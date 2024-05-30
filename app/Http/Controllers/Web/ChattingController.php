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
        $lastChatting = Chatting::with('deliveryMan')->where('user_id', auth('customer')->id())
            ->whereNotNull(['delivery_man_id', 'user_id'])
            ->orderBy('created_at', 'DESC')
            ->first();
        if (isset($lastChatting)) {
            // theme_aster - specific shop start
            if ($request->has('id')) {
                $lastChatting = Chatting::with('admin')->where('admin_id', $request->id)
                    ->orderBy('created_at', 'DESC')
                    ->first();
                Chatting::where(['user_id' => auth('customer')->id(), 'admin_id' => $request['id']])->update(['seen_by_customer' => 1]);
            }// theme_aster - specific shop end

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

            $Admins = Chatting::join('admins', 'admins.id', '=', 'chattings.admin_id')
                ->select('chattings.*', 'admins.name', 'admins.phone', 'admins.image', 'admins.email')
                ->where('chattings.user_id', auth('customer')->id())
                ->orderBy('chattings.created_at', 'desc')
                ->get()
                ->unique('admin_id');
            /*Unseen Message Count*/
            $Admins?->map(function ($admin) {
                $admin['unseen_message_count'] = Chatting::where([
                    'user_id' => $admin->user_id,
                    'admin_id' => $admin->admin_id,
                    'sent_by_customer' => 0,
                    'seen_by_customer' => 0,
                ])->count();
            });
            /*End Unseen Message*/
            return view(VIEW_FILE_NAMES['user_inbox'], [
                'chattings' => $chattings,
                'Admins' => $Admins,
                'last_chat' => $lastChatting
            ]);
        }

        return view(VIEW_FILE_NAMES['user_inbox']);

    }
    public function messages(Request $request)
    {
        


    }

    public function messages_store(Request $request)
    {
        
    }

}
