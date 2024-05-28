<div class="col-lg-3 col-md-4 col-sm-4 col-6  p-2">
    <div class="product-single-hover style--card">
        <div class="inline_product clickable d-flex justify-content-center">
            <div class="p-10px pb-0">
                <a href="{{route('blog', $blog->id )}}" class="brand_div" data-toggle="tooltip" title="{{$blog->title}}">
                    <img alt="{{$blog->title}}" src="{{ getValidImage(path: 'storage/app/public/blog/'.$blog->image, type: 'brand') }}">
                </a>
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