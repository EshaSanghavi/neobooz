@php($announcement=getWebConfig(name: 'announcement'))

@section('styles')
<style>

  .mobile{
    display: none;
  }
  
@media only screen and (max-width: 768px) {
  /* Hide desktop header styles */
  .mobile{
    display: block;
    position: sticky;
    bottom: 0px;
    z-index: 100;
  }
}
</style>
@endsection

@if (isset($announcement) && $announcement['status']==1)
    <div class="text-center position-relative px-4 py-1" id="announcement"
         style="background-color: {{ $announcement['color'] }};color:{{$announcement['text_color']}}">
        <span>{{ $announcement['announcement'] }} </span>
        <span class="__close-announcement web-announcement-slideUp">X</span>
    </div>
@endif

<header class="mobile-nav rtl __inline-10">
    <div class="navbar-sticky bg-light mobile-head">
        <div class="navbar navbar-expand-md navbar-light">

            <div class="container px-10px">
                <div class="navbar-toolbar d-flex flex-shrink-0 align-items-center">
                    
                    <div class="navbar-tool d-lg-none {{Session::get('direction') === "rtl" ? 'mr-md-3' : 'ml-md-3'}}">
                        <a class="navbar-tool-icon-box bg-secondary" href="https://neobooz.com">
                            <i class="tio-home"></i>
                        </a>
                    </div>

                    <div class="dropdown">
                        <a class="navbar-tool ml-3" type="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                            <div class="navbar-tool-icon-box bg-secondary">
                                <div class="navbar-tool-icon-box bg-secondary">
                                    <i class="tio-grid"></i>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @foreach($categories as $category)
                                    <li class="dropdown px-3 pb-2">

                                        <a <?php if ($category->childes->count() > 0) echo "" ?>
                                            href="{{route('products',['id'=> $category['id'],'data_from'=>'category','page'=>1])}}">
                                            <span>{{$category['name']}}</span>

                                        </a>
                                        @if ($category->childes->count() > 0)
                                            <a data-toggle='dropdown' class='__ml-50px' style="float: right;">
                                                <i class="czi-arrow-right"></i>
                                            </a>
                                        @endif

                                        @if($category->childes->count()>0)
                                            <ul class="dropdown-menu text-align-direction">
                                                @foreach($category['childes'] as $subCategory)
                                                    <li class="dropdown px-3 pb-2">
                                                        <a href="{{route('products',['id'=> $subCategory['id'],'data_from'=>'category','page'=>1])}}">
                                                            <span>{{$subCategory['name']}}</span>
                                                        </a>

                                                        @if($subCategory->childes->count()>0)
                                                            <a class="header-subcategories-links" data-toggle='dropdown' style="float: right;">
                                                                <i class="czi-arrow-right"></i>
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                @foreach($subCategory['childes'] as $subSubCategory)
                                                                    <li>
                                                                        <a class="dropdown-item"
                                                                            href="{{route('products',['id'=> $subSubCategory['id'],'data_from'=>'category','page'=>1])}}">{{$subSubCategory['name']}}</a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                        </div>
                    </div>


                    <div id="cart_items">
                        @include('layouts.front-end.partials._cart')
                        
                    </div>

                    <div class="navbar-tool dropdown d-none d-md-block {{Session::get('direction') === "rtl" ? 'mr-md-3' : 'ml-md-3'}}">
                        <a class="navbar-tool-icon-box bg-secondary dropdown-toggle" href="{{route('wishlists')}}">
                            <span class="navbar-tool-label">
                                <span class="countWishlist">
                                    {{session()->has('wish_list')?count(session('wish_list')):0}}
                                </span>
                            </span>
                            <i class="navbar-tool-icon czi-heart"></i>
                            
                        </a>
                    </div>
                    @if(auth('customer')->check())
                        <div class="dropdown">
                            <a class="navbar-tool ml-3" type="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <div class="navbar-tool-icon-box bg-secondary">
                                    <div class="navbar-tool-icon-box bg-secondary">
                                        <i class="tio-user"></i>
                                    </div>
                                </div>
                                <div class="navbar-tool-text">
                                    <small>{{ translate('hello')}}, {{auth('customer')->user()->f_name}}</small>
                                    {{ translate('dashboard')}}
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}"
                                    aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item"
                                    href="{{route('account-oder')}}"> {{ translate('my_Order')}} </a>
                                <a class="dropdown-item"
                                    href="{{route('user-account')}}"> {{ translate('my_Profile')}}</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item"
                                    href="{{route('customer.auth.logout')}}">{{ translate('logout')}}</a>
                            </div>
                        </div>
                    @else
                        <div class="dropdown">
                            <a class="navbar-tool {{Session::get('direction') === "rtl" ? 'mr-md-3' : 'ml-md-3'}}"
                                type="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <div class="navbar-tool-icon-box bg-secondary">
                                    <div class="navbar-tool-icon-box bg-secondary">
                                        <svg width="16" height="17" viewBox="0 0 16 17" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                            <path d="M4.25 4.41675C4.25 6.48425 5.9325 8.16675 8 8.16675C10.0675 8.16675 11.75 6.48425 11.75 4.41675C11.75 2.34925 10.0675 0.666748 8 0.666748C5.9325 0.666748 4.25 2.34925 4.25 4.41675ZM14.6667 16.5001H15.5V15.6667C15.5 12.4509 12.8825 9.83341 9.66667 9.83341H6.33333C3.11667 9.83341 0.5 12.4509 0.5 15.6667V16.5001H14.6667Z"
                                                    fill="#1B7FED"/>
                                        </svg>

                                    </div>
                                </div>
                            </a>
                            <div class="text-align-direction dropdown-menu __auth-dropdown dropdown-menu-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}"
                                    aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{route('customer.auth.login')}}">
                                    <i class="fa fa-sign-in mr-2"></i> {{ translate('sign_in')}}
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{route('customer.auth.sign-up')}}">
                                    <i class="fa fa-user-circle mr-2"></i>{{ translate('sign_up')}}
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</header>



@push('script')
    <script>
        "use strict";

        $(".category-menu").find(".mega_menu").parents("li")
            .addClass("has-sub-item").find("> a")
            .append("<i class='czi-arrow-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}'></i>");
    </script>
@endpush
