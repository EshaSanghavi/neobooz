@php($announcement=getWebConfig(name: 'announcement'))

@if (isset($announcement) && $announcement['status']==1)
    <div class="text-center position-relative px-4 py-1" id="announcement"
         style="background-color: {{ $announcement['color'] }};color:{{$announcement['text_color']}}">
        <span>{{ $announcement['announcement'] }} </span>
        <span class="__close-announcement web-announcement-slideUp">X</span>
    </div>
@endif


@push('styles')
<style>
header{
    position: sticky;
    bottom: 0; 
  }
@media only screen and (max-width: 768px) {
  /* Hide desktop header styles */
  header{
    display: none;
    position: sticky;
    bottom: 0; 
  }
}
</style>
@endpush

<header>
    <div class="navbar-sticky bg-light mobile-head">
        <div class="navbar navbar-expand-md navbar-light">
            <div class="container ">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand d-none d-sm-block mr-3 flex-shrink-0 __min-w-7rem"
                    href="{{route('home')}}">
                    <img class="__inline-11"
                            src="{{ getValidImage(path: 'storage/app/public/company/'.$web_config['web_logo']->value, type: 'logo') }}"
                            alt="{{$web_config['name']->value}}">
                </a>
                <a class="navbar-brand d-sm-none"
                    href="{{route('home')}}">
                    <img class="mobile-logo-img __inline-12"
                            src="{{ getValidImage(path: 'storage/app/public/company/'.$web_config['mob_logo']->value, type: 'logo') }}"
                            alt="{{$web_config['name']->value}}"/>
                </a>

                <div class="input-group-overlay mx-lg-4 search-form-mobile text-align-direction">
                    <form action="{{route('products')}}" type="submit" class="search_form">
                        <div class="d-flex align-items-center gap-2">
                            <input class="form-control appended-form-control search-bar-input" type="search"
                                    autocomplete="off"
                                    placeholder="{{ translate("search_for_items")}}..."
                                    name="name" value="{{ request('name') }}">

                            <button class="input-group-append-overlay search_button d-none d-md-block" type="submit">
                                    <span class="input-group-text __text-20px">
                                        <i class="czi-search text-white"></i>
                                    </span>
                            </button>

                            <span class="close-search-form-mobile fs-14 font-semibold text-muted d-md-none" type="submit">
                                {{ translate('cancel') }}
                            </span>
                        </div>

                        <input name="data_from" value="search" hidden>
                        <input name="page" value="1" hidden>
                        <diV class="card search-card mobile-search-card">
                            <div class="card-body">
                                <div class="search-result-box __h-400px overflow-x-hidden overflow-y-auto"></div>
                            </div>
                        </diV>
                    </form>
                </div>

                <div class="navbar-toolbar d-flex flex-shrink-0 align-items-center">
                    <a class="navbar-tool navbar-stuck-toggler" href="#">
                        <span class="navbar-tool-tooltip">{{ translate('expand_Menu') }}</span>
                        <div class="navbar-tool-icon-box">
                            <i class="navbar-tool-icon czi-menu open-icon"></i>
                            <i class="navbar-tool-icon czi-close close-icon"></i>
                        </div>
                    </a>
                    <div class="navbar-tool open-search-form-mobile d-lg-none {{Session::get('direction') === "rtl" ? 'mr-md-3' : 'ml-md-3'}}">
                        <a class="navbar-tool-icon-box bg-secondary" href="javascript:">
                            <i class="tio-search"></i>
                        </a>
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
                                        <img class="img-profile rounded-circle __inline-14" alt=""
                                                src="{{ getValidImage(path: 'storage/app/public/profile/'.auth('customer')->user()->image, type: 'avatar') }}">
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
                    <div id="cart_items">
                        @include('layouts.front-end.partials._cart')
                    </div>
                </div>
            </div>

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