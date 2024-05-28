@extends('layouts.front-end.app')

@section('title', translate('all_Blogs'))

@push('css_or_js')
    <meta property="og:image" content="{{dynamicStorage(path: 'storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="og:title" content="Brands of {{$web_config['name']->value}} "/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description"
          content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160) }}">

    <meta property="twitter:card" content="{{dynamicStorage(path: 'storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="twitter:title" content="Brands of {{$web_config['name']->value}}"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description"
          content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160) }}">
@endpush

@section('content')

    <div class="container pb-5 mb-2 mb-md-4 rtl text-align-direction">
        <div class="bg-primary-light rounded-10 my-4 p-3 p-sm-4"
             data-bg-img="{{ theme_asset(path: 'public/assets/front-end/img/media/bg.png') }}">
            <div class="d-flex flex-column gap-1 text-primary">
                <h4 class="mb-0 text-start fw-bold text-primary text-uppercase">
                    {{ translate('Blogs') }}
                </h4>
            </div>
        </div>

        
        <div class="brand_div-wrap mb-4">
            @foreach($blogs as $blog)
                <div class="row mx-n2">
                    <div class="col-md-12">
                        <div class="text-center">
                            {{ $blog->title }}
                        </div>
                    </div>
                </div>
                <a href="" class="brand_div"
                   data-toggle="tooltip" title="{{$blog->title}}">
                    <img alt="{{$blog->title}}"
                         src="{{ getValidImage(path: 'storage/app/public/blog/'.$blog->image, type: 'brand') }}">
                </a>
            @endforeach
        </div>
    </div>
@endsection

@push('script')
    <script src="{{theme_asset(path: 'public/assets/front-end/vendor/nouislider/distribute/nouislider.min.js')}}"></script>
@endpush