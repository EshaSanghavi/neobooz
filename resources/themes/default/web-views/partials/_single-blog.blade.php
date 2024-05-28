
<div class="product-single-hover style--category shadow-none">
    <div class="overflow-hidden position-relative">
        <div class=" inline_product clickable d-flex justify-content-center">
            
            <div class="d-block pb-0">
                <a href="{{route('blog', $blog->id )}}" class="d-block">
                    <img alt=""
                         src="{{ getValidImage(path: 'storage/app/public/blog/'.$blog->image, type: 'product') }}">
                </a>
            </div>

        </div>
        <div class="single-product-details">
            <div class="">
                <a href="{{route('blog', $blog->id )}}" class="text-capitalize fw-semibold">
                    {{ $blog->title }}
                </a>
            </div>
            <div class="justify-content-between ">
                <div class="product-price d-flex flex-wrap gap-8 align-items-center row-gap-0">
                    <span class="text-accent text-dark">
                        {{ $blog->blog_category }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>


