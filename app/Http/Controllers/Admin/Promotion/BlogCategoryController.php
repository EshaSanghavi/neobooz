<?php

namespace App\Http\Controllers\Admin\Promotion;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Enums\WebConfigKey;
use Brian2694\Toastr\Facades\Toastr;


use Image;
use File;
use Auth;
class BlogCategoryController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $categories=BlogCategory::all();
        $languages = getWebConfig(name: 'pnc_language') ?? null;
        return view('admin-views.blog.blog_category',compact('categories', 'languages'));

    }

    public function create()
    {
        $languages = getWebConfig(name: 'pnc_language') ?? null;
        $defaultLanguage = $languages[0];
        return view('admin-views.blog.create_blog_category', compact('languages', 'defaultLanguage'));
    }


    public function store(Request $request)
    {
        $rules = [
            'name'=>'required|unique:blog_categories',
            'slug'=>'required|unique:blog_categories',
            'status'=>'required',
        ];
        $customMessages = [
            'name.required' => trans('admin_validation.Name is required'),
            'name.unique' => trans('admin_validation.Name already exist'),
            'slug.required' => trans('admin_validation.Slug is required'),
            'slug.unique' => trans('admin_validation.Slug already exist'),
        ];
        $this->validate($request, $rules,$customMessages);

        $category = new BlogCategory();
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->status = $request->status;
        $category->save();


        $categories=BlogCategory::all();
        $languages = getWebConfig(name: 'pnc_language') ?? null;
        Toastr::success(translate('blog_category_added_successfully'));
        return view('admin-views.blog.blog_category',compact('categories', 'languages'))->with($notification);
    }


    public function edit($id)
    {
        $category = BlogCategory::find($id);
        return view('admin.promotion.edit_blog_category',compact('category'));
    }

    public function update(Request $request,$id)
    {
        $category = BlogCategory::find($id);
        $rules = [
            'name'=>'required|unique:blog_categories,name,'.$category->id,
            'slug'=>'required|unique:blog_categories,slug,'.$category->id,
            'status'=>'required',
        ];
        $customMessages = [
            'name.required' => trans('admin_validation.Name is required'),
            'name.unique' => trans('admin_validation.Name already exist'),
            'slug.required' => trans('admin_validation.Slug is required'),
            'slug.unique' => trans('admin_validation.Slug already exist'),
        ];
        $this->validate($request, $rules,$customMessages);

        $category = BlogCategory::find($id);
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->status = $request->status;
        $category->save();

        $notification= trans('admin_validation.Update Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.promotion.blog-category.index')->with($notification);
    }

    public function destroy($id)
    {
        $category = BlogCategory::find($id);
        $category->delete();

        $notification= trans('admin_validation.Delete Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function changeStatus($id){
        $category = BlogCategory::find($id);
        if($category->status==1){
            $category->status=0;
            $category->save();
            $message= trans('admin_validation.Inactive Successfully');
        }else{
            $category->status=1;
            $category->save();
            $message= trans('admin_validation.Active Successfully');
        }
        return response()->json($message);
    }
}
