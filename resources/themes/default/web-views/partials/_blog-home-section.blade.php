<section class="container rtl pb-4 px-max-sm-0">
    <div class="__shadow-2">
        <div class="__p-20px rounded bg-white overflow-hidden">
            <div class="d-flex __gap-6px flex-between px-sm-3">
                <div class="category-product-view-title">
                <span class="for-feature-title font-bold __text-20px text-uppercase">
                        {{$blog->title]}}
                </span>
                </div>
                <div class="category-product-view-all">
                    <a class="text-capitalize view-all-text text-nowrap web-text-primary"
                       href="">
                        {{ translate('view_all')}}
                        <i class="czi-arrow-{{Session::get('direction') === "rtl" ? 'left mr-1 ml-n1 mt-1 float-left' : 'right ml-1 mr-n1'}}"></i>
                    </a>
                </div>
            </div>

            <div class="mt-2">
                <div class="carousel-wrap-2 d-none d-sm-block">
                    <div class="owl-carousel owl-theme category-wise-product-slider">
                        @foreach($blog as $blog)
                            @include('web-views.partials._single-blog')
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
