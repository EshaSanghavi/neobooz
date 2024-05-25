@extends('layouts.back-end.app')

@section('title', translate('blog_List'))

@section('content')
    <div class="content container-fluid">

        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex gap-2">
                <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/inhouse-product-list.png') }}" alt="">
                {{ translate('blog_List') }}
                <span class="badge badge-soft-dark radius-50 fz-14 ml-1">{{}}</span>
            </h2>
        </div>

    </div>

@endsection
