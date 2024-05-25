@extends('layouts.back-end.app')

@section('title', translate('blog_category'))

@section('content')
    <div class="content container-fluid">

        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex gap-2">
                <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/inhouse-product-list.png') }}" alt="">
                {{ translate('blog_category') }}
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
                                               placeholder="{{ translate('search_Blog_Name') }}"
                                               aria-label="Search orders"
                                               value="{{ request('searchValue') }}">
                                        <input type="hidden" value="{{ request('status') }}" name="status">
                                        <button type="submit" class="btn btn--primary">{{ translate('search') }}</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-8 mt-3 mt-lg-0 d-flex flex-wrap gap-3 justify-content-lg-end">

                                
                                <a href="{{ route('admin.blog-category.create') }}" class="btn btn--primary">
                                    <i class="tio-add"></i>
                                    <span class="text">{{ translate('add_new_blog_category') }}</span>
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
                                <th>{{ translate('Name') }}</th>
                                <th>{{ translate('Slug') }}</th>
                                <th>{{ translate('status') }}</th>
                                <th>{{ translate('action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $index => $category)
                                <tr>
                                    <td>{{ ++$index }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->slug }}</td>
                                        <td>
                                        <td class="text-center">
                                        <form action="" method="post" data-from="category-status"
                                              id="category-status{{ $category['id']}}-form" class="admin-category-status-form">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $product['id']}}">
                                            <label class="switcher mx-auto">
                                                <input type="checkbox" class="switcher_input toggle-switch-message"
                                                       name="status"
                                                       id="category-status{{ $category['id'] }}" value="1"
                                                       {{ $category['status'] == 1 ? 'checked' : '' }}
                                                       data-modal-id="toggle-status-modal"
                                                       data-toggle-id="category-status{{ $category['id'] }}"
                                                       data-on-image="product-status-on.png"
                                                       data-off-image="product-status-off.png"
                                                       data-on-title="{{ translate('Want_to_Turn_ON').' '.$category->name.' '.translate('status') }}"
                                                       data-off-title="{{ translate('Want_to_Turn_OFF').' '.$category->name.' '.translate('status') }}"
                                                       data-on-message="<p>{{ translate('if_enabled_this_category_will_be_available_on_the_website_and_customer_app') }}</p>"
                                                       data-off-message="<p>{{ translate('if_disabled_this_category_will_be_hidden_from_the_website_and_customer_app') }}</p>">
                                                <span class="switcher_control"></span>
                                            </label>
                                        </form>
                                    </td>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <a class="btn btn-outline-info btn-sm square-btn"
                                                    title="{{ translate('edit') }}"
                                                    href="{{ route('admin.blog-category.edit',$category->id) }}">
                                                    <i class="tio-edit"></i>
                                                </a>

                                                <a class="btn btn-outline-info btn-sm square-btn"
                                                    title="{{ translate('delete') }}"
                                                    href="{{ route('admin.blog-category.destroy',$category->id) }}">
                                                    <i class="tio-delete"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                   
                </div>
            </div>
        </div>
    </div>

    <span id="message-select-word" data-text="{{ translate('select') }}"></span>
@endsection
