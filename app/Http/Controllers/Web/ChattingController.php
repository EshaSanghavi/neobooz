<?php

namespace App\Http\Controllers\Web;

use App\Events\ChattingEvent;
use App\Http\Controllers\Controller;
use App\Models\Chatting;
use App\Models\DeliveryMan;
use App\Models\Order;
use App\Models\ProductCompare;
use App\Models\Seller;
use App\Models\User;
use App\Models\Wishlist;
use App\Utils\ImageManager;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChattingController extends Controller
{
    public function __construct(
        private Order $order,
        private Wishlist $wishlist,
        private ProductCompare $compare,

    )
    {

    }

    public function chat_list(Request $request)
    { 
        $adminId = 1;

        $lastChatting = Chatting::with('admin')->where('user_id', auth('customer')->id())
            ->whereNotNull(['admin_id', 'user_id'])
            ->orderBy('created_at', 'DESC')
            ->first();

        if (!isset($lastChatting)){
            $lastChatting = new Chatting();
            $lastChatting->user_id = auth('customer')->id();
            $lastChatting->admin_id = $adminId;
            $lastChatting->save();
        
            $lastChatting = Chatting::with('admin')->where('user_id', auth('customer')->id())
                ->whereNotNull(['admin_id', 'user_id'])
                ->orderBy('created_at', 'DESC')
                ->first();
        }

        if (isset($lastChatting)) {
            // theme_aster - specific shop start
                $lastChatting = Chatting::with('admin')->where('admin_id', $adminId)
                    ->orderBy('created_at', 'DESC')
                    ->first();
                Chatting::where(['user_id' => auth('customer')->id(), 'admin_id' => $adminId])->update(['seen_by_customer' => 1]);
            // theme_aster - specific shop end

            $chattings = Chatting::join('admins', 'admins.id', '=', 'chattings.admin_id')
                ->select('chattings.*', 'admins.name', 'admins.phone', 'admins.image')
                ->where('chattings.user_id', auth('customer')->id())
                ->where('admin_id', $lastChatting->admin_id)
                ->when(theme_root_path() == 'default', function ($query) {
                    return $query->orderBy('chattings.created_at', 'desc');
                })
                ->when(theme_root_path() != 'default', function ($query) {
                    return $query->orderBy('chattings.created_at', 'asc');
                })
                ->get();
            
            return view(VIEW_FILE_NAMES['user_inbox'], [
                'chattings' => $chattings,
                'last_chat' => $lastChatting
            ]);
        }

        return view(VIEW_FILE_NAMES['user_inbox']);

    }
    public function messages(Request $request)
    {
        $adminId = 1;

        Chatting::where(['user_id'=>auth('customer')->id(), 'admin_id'=> $adminId])->update([
            'seen_by_customer' => 1
        ]);

        $shops = Chatting::join('admins', 'admins.id', '=', $adminId)
            ->select('chattings.*', 'admins.name', 'admins.image')
            ->where('user_id', auth('customer')->id())
            ->where('chattings.admin_id', $adminId)
            ->orderBy('created_at', 'ASC')
            ->get();
            
        return response()->json($shops);

    }

    public function messages_store(Request $request)
    {
        $adminId = 1;

        $message_form = User::find(auth('customer')->id());
        if ($request->image == null && $request->message == '') {
            return response()->json(translate('type_something').'!', 403);
        }

        $initialMsg = Chatting::where(['user_id'=>auth('customer')->id(), 'message'=> null])->delete();

        $image = [] ;
        if ($request->file('image')) {
            $validator = Validator::make($request->all(), [
                'image.*' => 'image|mimes:jpeg,png,jpg,gif,webp,bmp,tif,tiff|max:6000'
            ]);
            if ($validator->fails()) {
                return response()->json(translate('The_file_must_be_an_image').'!', 403);
            }
            foreach ($request->image as $key=>$value) {
                $image_name = ImageManager::upload('chatting/', 'webp', $value);
                $image[] = $image_name;
            }
        }

        $message = $request['message'];
        $chatting = [
            'user_id'          => auth('customer')->id(),
            'admin_id'         => $adminId,
            'message'          => $request['message'],
            'attachment'       => json_encode($image),
            'sent_by_customer' => 1,
            'seen_by_customer' => 1,
            'seen_by_admin'    => 0,
            'created_at'       => now(),
        ];

        $chatting += ['admin_id' => $adminId];
        Chatting::create($chatting);

        $admin = Admin::find($adminId);
        ChattingEvent::dispatch('message_from_customer', 'admin', $admin, $message_form);

        $imageArray = [];
        foreach ($image as $singleImage) {
            $imageArray[] = getValidImage(path: 'storage/app/public/chatting/'.$singleImage, type: 'product');
        }

        return response()->json(['message'=>$message,'image'=>$imageArray]);
    }

}
