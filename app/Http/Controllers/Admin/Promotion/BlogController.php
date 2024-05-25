<?php

namespace App\Http\Controllers\Admin\Promotion;

use App\Enums\ViewPaths\Admin\Blog as Blogs;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\PopularPost;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Image;
use File;
use Auth;

use App\Contracts\Repositories\AttributeRepositoryInterface;
use App\Contracts\Repositories\BannerRepositoryInterface;
use App\Contracts\Repositories\BrandRepositoryInterface;
use App\Contracts\Repositories\CartRepositoryInterface;
use App\Contracts\Repositories\CategoryRepositoryInterface;
use App\Contracts\Repositories\ColorRepositoryInterface;
use App\Contracts\Repositories\DealOfTheDayRepositoryInterface;
use App\Contracts\Repositories\FlashDealProductRepositoryInterface;
use App\Contracts\Repositories\ProductRepositoryInterface;
use App\Contracts\Repositories\ReviewRepositoryInterface;
use App\Contracts\Repositories\TranslationRepositoryInterface;
use App\Contracts\Repositories\VendorRepositoryInterface;
use App\Contracts\Repositories\WishlistRepositoryInterface;
use App\Enums\ViewPaths\Admin\Product;
use App\Enums\WebConfigKey;
use App\Events\ProductRequestStatusUpdateEvent;
use App\Exports\ProductListExport;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\ProductDenyRequest;
use App\Http\Requests\ProductAddRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Services\ProductService;
use App\Traits\FileManagerTrait;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Maatwebsite\Excel\Facades\Excel;
use mysql_xdevapi\Exception;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

    
class BlogController extends Controller
{
    use FileManagerTrait {
        delete as deleteFile;
        update as updateFile;
    }

    public function __construct(
        private readonly CategoryRepositoryInterface         $categoryRepo,
        private readonly BrandRepositoryInterface            $brandRepo,
        private readonly ProductRepositoryInterface          $productRepo,
        private readonly VendorRepositoryInterface           $sellerRepo,
        private readonly ColorRepositoryInterface            $colorRepo,
        private readonly AttributeRepositoryInterface        $attributeRepo,
        private readonly TranslationRepositoryInterface      $translationRepo,
        private readonly CartRepositoryInterface             $cartRepo,
        private readonly WishlistRepositoryInterface         $wishlistRepo,
        private readonly FlashDealProductRepositoryInterface $flashDealProductRepo,
        private readonly DealOfTheDayRepositoryInterface     $dealOfTheDayRepo,
        private readonly ReviewRepositoryInterface           $reviewRepo,
        private readonly BannerRepositoryInterface           $bannerRepo,
    )
    {
    }

    public function index(Request|null $request, string $type = null): View
    {
        return $this->getListView(request: $request, type: $type);
    }

    public function getAddView(): View
    {
        $categories = $this->categoryRepo->getListWhere(filters: ['position' => 0], dataLimit: 'all');
        $brands = $this->brandRepo->getListWhere(dataLimit: 'all');
        $brandSetting = getWebConfig(name: 'product_brand');
        $digitalProductSetting = getWebConfig(name: 'digital_product');
        $colors = $this->colorRepo->getList(orderBy: ['name' => 'desc'], dataLimit: 'all');
        $attributes = $this->attributeRepo->getList(orderBy: ['name' => 'desc'], dataLimit: 'all');
        $languages = getWebConfig(name: 'pnc_language') ?? null;
        $defaultLanguage = $languages[0];

        return view(Product::ADD[VIEW], compact('categories', 'brands', 'brandSetting', 'digitalProductSetting', 'colors', 'attributes', 'languages', 'defaultLanguage'));
    }


    public function create()
    {
        $categories = BlogCategory::where('status',1)->get();
        return view('admin.promotion.create_blog',compact('categories'));
    }


    public function store(Request $request)
    {
        $rules = [
            'title'=>'required|unique:blogs',
            'slug'=>'required|unique:blogs',
            'image'=>'required',
            'description'=>'required',
            'category'=>'required',
            'status'=>'required',
            'show_homepage'=>'required',
        ];
        $customMessages = [
            'title.required' => trans('admin_validation.Title is required'),
            'title.unique' => trans('admin_validation.Title already exist'),
            'slug.required' => trans('admin_validation.Slug is required'),
            'slug.unique' => trans('admin_validation.Slug already exist'),
            'image.required' => trans('admin_validation.Image is required'),
            'description.required' => trans('admin_validation.Description is required'),
            'category.required' => trans('admin_validation.Category is required'),
            'show_homepage.required' => trans('admin_validation.Show homepage is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $blog = new Blog();
        if($request->image){
            $extention=$request->image->getClientOriginalExtension();
            $image_name = 'blog-'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_name ='uploads/custom-images/'.$image_name;
            Image::make($request->image)
                ->save($image_name);
            $blog->image = $image_name;
        }

        $blog->admin_id = $admin->id;
        $blog->title = $request->title;
        $blog->slug = $request->slug;
        $blog->description = $request->description;
        $blog->blog_category_id = $request->category;
        $blog->status = $request->status;
        $blog->show_homepage = $request->show_homepage;
        $blog->seo_title = $request->seo_title ? $request->seo_title : $request->title;
        $blog->seo_description = $request->seo_description ? $request->seo_description : $request->title;
        $blog->save();

        $notification= trans('admin_validation.Created Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function edit($id)
    {
        $categories = BlogCategory::where('status',1)->get();
        $blog = Blog::find($id);
        return view('admin.promotion.edit_blog',compact('categories','blog'));
    }


    public function show($id)
    {
        $blog = Blog::with('category','comments')->find($id);
        return response()->json(['blog' => $blog], 200);
    }


    public function update(Request $request,$id)
    {
        $blog = Blog::find($id);
        $rules = [
            'title'=>'required|unique:blogs,title,'.$blog->id,
            'slug'=>'required|unique:blogs,slug,'.$blog->id,
            'description'=>'required',
            'category'=>'required',
            'status'=>'required',
            'show_homepage'=>'required',
        ];
        $customMessages = [
            'title.required' => trans('admin_validation.Title is required'),
            'title.unique' => trans('admin_validation.Title already exist'),
            'slug.required' => trans('admin_validation.Slug is required'),
            'slug.unique' => trans('admin_validation.Slug already exist'),
            'description.required' => trans('admin_validation.Description is required'),
            'category.required' => trans('admin_validation.Category is required'),
            'show_homepage.required' => trans('admin_validation.Show homepage is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        if($request->image){
            $old_image = $blog->image;
            $extention=$request->image->getClientOriginalExtension();
            $image_name = 'blog-'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_name ='uploads/custom-images/'.$image_name;
            Image::make($request->image)
                ->save(public_path().'/'.$image_name);
            $blog->image = $image_name;
            $blog->save();
            if($old_image){
                if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
            }
        }

        $blog->title = $request->title;
        $blog->slug = $request->slug;
        $blog->description = $request->description;
        $blog->blog_category_id = $request->category;
        $blog->status = $request->status;
        $blog->show_homepage = $request->show_homepage;
        $blog->seo_title = $request->seo_title ? $request->seo_title : $request->title;
        $blog->seo_description = $request->seo_description ? $request->seo_description : $request->title;
        $blog->save();

        $notification= trans('admin_validation.Updated Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.promotion.blog.index')->with($notification);
    }

    public function destroy($id)
    {
        $blog = Blog::find($id);
        $old_image = $blog->image;
        $blog->delete();
        if($old_image){
            if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
        }

        BlogComment::where('blog_id',$id)->delete();

        $notification=  trans('admin_validation.Delete Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function changeStatus($id){
        $blog = Blog::find($id);
        if($blog->status==1){
            $blog->status=0;
            $blog->save();
            $message= trans('admin_validation.Inactive Successfully');
        }else{
            $blog->status=1;
            $blog->save();
            $message= trans('admin_validation.Active Successfully');
        }
        return response()->json($message);
    }
}
