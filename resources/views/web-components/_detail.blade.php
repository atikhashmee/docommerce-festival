<div class="container">
    <div class="row">
        <div class="col-md-12">

            <h6 class="product-section-heading storeNameDiv mb-5">
                {{$product->store->name}}
                <a href="//{{$product->store->store_url}}" class="float-right" target="_blank">
                    View owner's store <i class="fas fa-angle-right"></i>
                </a>
            </h6>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <img id="zoom_01" class="img-fluid d-block mx-auto" src="{{asset('web_assets/images/products/1.png')}}"
            data-zoom-image="{{asset('web_assets/images/products/1.png')}}"/>
            <div id="gallery_01" class="mb-4">
                <a href="javascript:void(0)" data-image="{{asset('web_assets/images/products/1.png')}}" data-zoom-image="{{asset('web_assets/images/products/1.png')}}" class="active">
                    <img id="img_01" src="{{asset('web_assets/images/products/1.png')}}"/>
                </a>
                <a href="javascript:void(0)" data-image="{{asset('web_assets/images/products/2.png')}}" data-zoom-image="{{asset('web_assets/images/products/2.png')}}">
                    <img id="img_02" src="{{asset('web_assets/images/products/2.png')}}"/>
                </a>
                <a href="javascript:void(0)" data-image="{{asset('web_assets/images/products/3.png')}}" data-zoom-image="{{asset('web_assets/images/products/3.png')}}">
                    <img id="img_03" src="{{asset('web_assets/images/products/3.png')}}"/>
                </a>
            </div>
        </div>

        <div class="col-md-6">
            <h6 class="product-details mb-3">{{$product->name}}</h6>
            <h6 class="product-details-price mb-3">
                <span class="text-danger font-weight-bold">৳<span id="product_price">{{intval($product->price)}}</span></span><br>
                <small style="text-decoration: line-through;">৳<span id="product_old_price">{{intval($product->old_price)}}</span></small>
                @if (intval($product->discount_amount) > 0)
                    @if ($product->discount_type == 'fixed')
                        <small class="save-pill badge badge-success"><span>Save ৳{{intval($product->discount_amount)}}</span></small>
                    @else
                        <small class="save-pill badge badge-success"><span>Save {{intval($product->discount_amount)}}%</span></small>
                    @endif
                @endif
            </h6>
            @if (count($product->show_variants) > 0)
                <div class="options pt-3 variant_data">
                    @foreach ($product->show_variants as $name => $item)
                        <div class="each-variant-row">
                            <span class="mr-1">{{$name}}</span>
                            @foreach ($item as $prop => $val)
                                <button type="button" onclick="changeVariant(this)" data-item="{{ $prop }}" class="btn btn-info btn-sm mr-1">{{$prop}}</button>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="addPriceCart py-4">
                <div class="input-group plus-minus-input">
                    <div class="input-group-button">
                    <button type="button" class="button hollow circle" data-quantity="minus" data-field="quantity">
                        <i class="fa fa-minus" aria-hidden="true"></i>
                    </button>
                    </div>
                    <input class="input-group-field" type="number" name="quantity" id="product_quantity" min="1" max="999" value="1">
                    <div class="input-group-button">
                    <button type="button" class="button hollow circle" data-quantity="plus" data-field="quantity">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </button>
                    </div>
                    <a href="javascript:void(0)"  onclick="variantProductAdd({{ json_encode($product) }})" class="btn btn-success addcart-btn ml-3 text-capitalize"><i class="fas fa-cart-plus"></i> Add to cart</a>
                </div>
            </div>
            <div>
                <p>Save UPTO 25% on Bulk Orders</p>
                <a href="javascript:void(0)" class="btn btn-success addcart-btn ml-3 text-capitalize"><i class="fas fa-cart-plus"></i> Place Order</a>
            </div>
            <hr>
            <p>
                Category: <a href="{{route("category_page", ['category_id' => $product->category_id])}}">{{$product->category->name}}</a> 
            </p>

        </div>
    </div>
</div>

<div id="extra_field">
    <input type="hidden" name="variants_data" id="variants_data" value="{{ json_encode($product->variants) }}">
    <input type="hidden" name="product_quantity" id="product_quantity"/>         
    <input type="hidden" name="selected_variant" id="selected_variant" value="{{ json_encode($product->smallest_variant) }}">
</div>