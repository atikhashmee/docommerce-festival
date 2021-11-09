<div class="productsDiv p-3 shadow-sm rounded">
    <a href="{{route('detail_page', ['slug' => $product->slug])}}" title="{{$product->name}}">
        <img src="{{$product->original_product_img}}" alt="{{$product->name}}" class="img-fluid d-block mx-auto rounded">
        <h6 class="product-name mb-2">{{$product->name}}</h6>
    </a>
    <h6>
        <span class="text-danger font-weight-bold">৳{{intval($product->price)}}</span>
        <small style="text-decoration: line-through;">৳{{intval($product->old_price)}}</small>
        <small class="text-success save-sm"><span>-10%</span> <span>Save ৳100</span></small>
    </h6>
    @if ($product->variants_count > 0)
        <a href="javascript:void(0)" class="btn btn-warning p-d-switch btn-block mt-4 text-capitalize" data-product_id="{{$product->id}}">Add to cart</a>
    @else
        <a href="javascript:void(0)"  onclick="addToCart({{$product}})" class="btn btn-warning addcart-btn btn-block mt-4 text-capitalize">Add to cart</a>
    @endif
    <div class="wish-zoom">
        <a href="javascript:void(0)" class="p-d-switch" data-product_id="{{$product->id}}">
            <i class="fas fa-expand-arrows-alt"></i>
        </a>
        {{-- <a href="javascript:void(0)" class="add-wishlist-switch">
            <i class="fas fa-heart"></i>
        </a> --}}
    </div>
</div>