@extends('layouts.back-end.app')

@section('title', translate('blog_List'))

@section('content')
    <div class="content container-fluid">

        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex gap-2">
                <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/inhouse-product-list.png') }}" alt="">
                {{ translate('blog_List') }}
                <span class="badge badge-soft-dark radius-50 fz-14 ml-1">{{ $blogs->total() }}</span>
            </h2>
        </div>

       
        <div class="row mt-20">
            <div class="col-md-12">
                <div class="card">
                    <div class="px-3 py-4">
                        <div class="row align-items-center">
                            <div class="col-lg-4">

                                <form action="{{ url()->current() }}" method="GET">
                                    <div class="input-group input-group-custom input-group-merge">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tio-search"></i>
                                            </div>
                                        </div>
                                        <input id="datatableSearch_" type="search" name="searchValue"
                                               class="form-control"
                                               placeholder="{{ translate('search_Product_Name') }}"
                                               aria-label="Search orders"
                                               value="{{ request('searchValue') }}">
                                        <input type="hidden" value="{{ request('status') }}" name="status">
                                        <button type="submit" class="btn btn--primary">{{ translate('search') }}</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-8 mt-3 mt-lg-0 d-flex flex-wrap gap-3 justify-content-lg-end">

                                
                                <a href="{{ route('admin.products.add') }}" class="btn btn--primary">
                                        <i class="tio-add"></i>
                                        <span class="text">{{ translate('add_new_product') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="datatable"
                               class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100 text-start">
                            <thead class="thead-light thead-50 text-capitalize">
                            <tr>
                                <th>{{ translate('SL') }}</th>
                                <th>{{ translate('Title') }}</th>
                                <th class="text-center">{{ translate('Category') }}</th>
                                <th class="text-center">{{ translate('Image') }}</th>
                                <th class="text-center">{{ translate('Show homepage') }}</th>
                                <th class="text-center">{{ translate('status') }}</th>
                                <th class="text-center">{{ translate('action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($blogs as $index => $blog)
                                <tr>
                                    <td>{{ ++$index }}</td>
                                    <td>{{ $blog->title }}</a></td>
                                    <td>{{ $blog->category->name }}</td>
                                    <td><img src="{{ asset($blog->image) }}" width="80px" height="80px" class="rounded-circle" alt=""></td>
                                        <td>
                                            @if ($blog->show_homepage)
                                                <span class="badge badge-success">{{__('admin.Yes')}}</span>
                                            @else
                                            <span class="badge badge-danger">{{__('admin.No')}}</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if($blog->status == 1)
                                            <a href="javascript:;" onclick="changeBlogStatus({{ $blog->id }})">
                                                <input id="status_toggle" type="checkbox" checked data-toggle="toggle" data-on="{{__('admin.Active')}}" data-off="{{__('admin.Inactive')}}" data-onstyle="success" data-offstyle="danger">
                                            </a>

                                            @else
                                            <a href="javascript:;" onclick="changeBlogStatus({{ $blog->id }})">
                                                <input id="status_toggle" type="checkbox" data-toggle="toggle" data-on="{{__('admin.Active')}}" data-off="{{__('admin.Inactive')}}" data-onstyle="success" data-offstyle="danger">
                                            </a>

                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.blog.edit',$blog->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                            <a href="javascript:;" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger btn-sm" onclick="deleteData({{ $blog->id }})"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        </td>
                                    </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive mt-4">
                        <div class="px-4 d-flex justify-content-lg-end">
                            {{ $products->links() }}
                        </div>
                    </div>

                    @if(count($products)==0)
                        <div class="text-center p-4">
                            <img class="mb-3 w-160"
                                 src="{{ dynamicAsset(path: 'public/assets/back-end/svg/illustrations/sorry.svg') }}"
                                 alt="{{translate('image_description')}}">
                            <p class="mb-0">{{ translate('no_data_to_show') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <span id="message-select-word" data-text="{{ translate('select') }}"></span>
@endsection
