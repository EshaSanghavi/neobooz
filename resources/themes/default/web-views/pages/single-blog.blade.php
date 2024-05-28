@extends('layouts.front-end.app')

@section('title', translate('all_Blogs'))

@push('css_or_js')
    <meta property="og:image" content="{{dynamicStorage(path: 'storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="og:title" content="Blogs of {{$web_config['name']->value}} "/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description" content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160) }}">
    <meta property="twitter:card" content="{{dynamicStorage(path: 'storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="twitter:title" content="Blogs of {{$web_config['name']->value}}"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description" content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160) }}">
@endpush

@section('content')
    <div class="container pb-5 md-4 rtl text-align-direction">
        <div class="bg-primary-light rounded-10 mt-4 p-3 p-sm-4" data-bg-img="{{ theme_asset(path: 'public/assets/front-end/img/media/bg.png') }}">
                    <h4 class="mb-0 text-start fw-bold text-primary text-uppercase">
                        {{ $blog->title }}
                    </h4>
            </div>
        </div>

        <div class="row ml-4">
            <div class="col-lg-3 col-md-4 col-sm-4 col-6  p-2">
                    <div class="product-single-hover style--card">
                        <div class="inline_product clickable d-flex justify-content-center">
                            <div class="p-10px pb-0">
                                <img alt="{{$blog->title}}" src="{{ getValidImage(path: 'storage/app/public/blog/'.$blog->image, type: 'brand') }}">
                            </div>
                        </div>
                        <div class="single-product-details">
                            <div class="text-center">
                                <span class="text-accent text-dark"> {{ $blog->title }} </span>
                                <div class="justify-content-between text-center">
                                    <div class="product-price text-center d-flex flex-wrap justify-content-center align-items-center gap-8">
                                        {{ $blog->blog_category }}
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>   
@endsection
