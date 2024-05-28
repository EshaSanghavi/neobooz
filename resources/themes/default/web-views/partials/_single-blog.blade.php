
<div class="product-single-hover style--category shadow-none">
    <div class="overflow-hidden position-relative">
        <div class=" inline_product clickable d-flex justify-content-center">
            <div class="d-block pb-0">
                <a href="{{route('product',$product->slug)}}" class="d-block">
                    <img alt=""
                         src="{{ getValidImage(path: 'storage/app/public/blog/'.$blog->image, type: 'product') }}">
                </a>
            </div>
        </div>
    </div>
</div>


