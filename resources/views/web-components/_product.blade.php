<div class="productsDiv p-3 shadow-sm rounded">
    {{-- @if(intval($product->stock_quantity) == 0) outOfStock @endif --}}
    <a href="{{route('detail_page', ['slug' => $product->slug])}}" title="{{$product->name}}">
        @if (intval($product->discount_amount) > 0)
            @if ($product->discount_type == 'fixed')
                <div class="ribbon ribbon-top-left"><span>Save ৳{{intval($product->discount_amount)}}</span></div>
            @else
                <div class="ribbon ribbon-top-left"><span>Save {{intval($product->discount_amount)}}%</span></div>
            @endif
        @endif


    
        <img src="{{ "https://zipgrip.delivery".strstr($product->original_product_img, '/storage') }}" alt="{{$product->name}}" class="img-fluid d-block mx-auto rounded mb-2">
        <h6 class="product-name mb-2">{{$product->name}}</h6>
    </a>
    <h6>
        <span class="text-danger font-weight-bold">৳{{intval($product->price)}}</span>
        <small style="text-decoration: line-through;">৳{{intval($product->old_price)}}</small>
    </h6>
    @if ($product->variants_count > 0)
        <a href="javascript:void(0)" class="btn btn-warning p-d-switch btn-block mt-4 text-capitalize" data-product_id="{{$product->id}}">Add to cart</a>
    @else
    <a href="javascript:void(0)"  onclick="addToCart({{$product}})" class="btn btn-warning addcart-btn btn-block mt-4 text-capitalize">Add to cart</a>
        {{-- @if (intval($product->stock_quantity) > 0)
            <a href="javascript:void(0)"  onclick="addToCart({{$product}})" class="btn btn-warning addcart-btn btn-block mt-4 text-capitalize">Add to cart</a>
        @else
            <a href="{{route('detail_page', ['slug' => $product->slug])}}" class="btn btn-warning addcart-btn btn-block mt-4 text-capitalize">Add to cart</a>
        @endif --}}
    @endif
    <div class="wish-zoom">
        <a href="javascript:void(0)" class="p-d-switch" data-product_id="{{$product->id}}">
            <i class="fas fa-search-plus"></i>
        </a>
        {{-- <a href="javascript:void(0)" class="add-wishlist-switch">
            <i class="fas fa-heart"></i>
        </a> --}}
    </div>
</div>