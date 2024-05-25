@extends('layouts.back-end.app')

@section('title', translate('blog_Add'))

@push('css_or_js')
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="content container-fluid">
        <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
            <h2 class="h1 mb-0 d-flex gap-2">
                <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/inhouse-product-list.png') }}" alt="">
                {{ translate('add_New_Blog') }}
            </h2>
        </div>

        <form class="blog-form text-start" action="{{ route('admin.blog-store') }}" method="POST" enctype="multipart/form-data" id="blog_form">
            @csrf
            <div class="card">
                <div class="px-4 pt-3">
                    <ul class="nav nav-tabs w-fit-content mb-4">
                        @foreach ($languages as $lang)
                            <li class="nav-item">
                                <span class="nav-link text-capitalize form-system-language-tab {{ $lang == $defaultLanguage ? 'active' : '' }} cursor-pointer"
                                      id="{{ $lang }}-link">{{ getLanguageName($lang) . '(' . strtoupper($lang) . ')' }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="card-body">
                    @foreach ($languages as $lang)
                        <div class="{{ $lang != $defaultLanguage ? 'd-none' : '' }} form-system-language-form"
                             id="{{ $lang }}-form">
                            <div class="form-group">
                                <label class="title-color"
                                       for="{{ $lang }}_name">{{ translate('Title') }}
                                    ({{ strtoupper($lang) }})
                                </label>
                                <input type="text" {{ $lang == $defaultLanguage ? 'required' : '' }} name="title"
                                       id="{{ $lang }}_name" class="form-control">
                            </div>
                            <input type="hidden" name="lang[]" value="{{ $lang }}">
                            
                            <div class="form-group pt-2">
                                <label class="title-color"
                                       for="{{ $lang }}_slug">{{ translate('slug') }}
                                    ({{ strtoupper($lang) }})</label>
                                    <input type="text" {{ $lang == $defaultLanguage ? 'required' : '' }} name="slug"
                                       id="{{ $lang }}_slug" class="form-control" >
                            </div>

                            <div class="form-group pt-2">
                                <label class="title-color"
                                       for="{{ $lang }}_category">{{ translate('Category') }}
                                    ({{ strtoupper($lang) }})</label>
                                <select id="{{ $lang }}_category" class="js-select2-custom form-control action-get-request-onchange" 
                                        name="category"
                                        data-element-id="select"
                                        data-element-type="select"
                                        required>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                </select>
                            </div>

                            <div class="form-group pt-2">
                                <label class="title-color"
                                       for="{{ $lang }}_description">{{ translate('description') }}
                                    ({{ strtoupper($lang) }})</label>
                                <textarea class="summernote" name="description[]">{{ old('details') }}</textarea>
                            </div>
                            
                            <div class="form-group pt-2">
                                <label class="title-color"
                                       for="{{ $lang }}_showhomepage">{{ translate('show_homepage_?') }}
                                    ({{ strtoupper($lang) }})</label>
                                <select id="{{ $lang }}_showhomepage" class="js-select2-custom form-control action-get-request-onchange" 
                                        name="showhomepage"
                                        data-element-id="select"
                                        data-element-type="select"
                                        required>
                                        <option value="1">{{translate('Yes')}}</option>
                                        <option value="0">{{translate('No')}}</option>
                                </select>
                            </div>

                            <div class="form-group pt-2">
                                <label class="title-color"
                                       for="{{ $lang }}_status">{{ translate('status') }}
                                    ({{ strtoupper($lang) }})</label>
                                <select id="{{ $lang }}_status" class="js-select2-custom form-control action-get-request-onchange" 
                                        name="status"
                                        data-element-id="select"
                                        data-element-type="select"
                                        required>
                                        <option value="1">{{translate('Active')}}</option>
                                        <option value="0">{{translate('Inactive')}}</option>
                                </select>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>



            <div class="row justify-content-end gap-3 mt-3 mx-1">
                <button type="reset" class="btn btn-secondary px-5">{{ translate('reset') }}</button>
                <button type="submit" class="btn btn--primary px-5 blog-add-requirements-check">{{ translate('submit') }}</button>
            </div>
        </form>
    </div>

    
@endsection

@push('script')
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/tags-input.min.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/spartan-multi-image-picker.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/admin/product-add-update.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/admin/product-add-colors-img.js') }}"></script>
@endpush
