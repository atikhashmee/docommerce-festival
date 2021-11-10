<style>
.medium {
		 -webkit-transform: translateY(30px);
		 -moz-transform: translateY(30px);
		 -ms-transform: translateY(30px);
		 -o-transform: translateY(30px);
		 transform: translateY(30px);
		 -webkit-animation: fadeIn 0.7s ease-in forwards;
		 animation: fadeIn 0.7s ease-in forwards;
		 font-size: 20px;
         margin-top: -30px;
         margin-left: 25px;
         margin-bottom: 70px;
	}
	 .medium span {
		 width: 100px;
		 position: relative;
		 display: block;
		 background: #ffcf02;
		 color: #111;
		 text-align: center;
		 -webkit-box-sizing: border-box;
		 min-width: 220px;
         font-size: 13px;
         font-weight: 700;
		 height: 40px;
		 line-height: 40px;
		 -webkit-transform-style: preserve-3d;
	}
	 .medium span:before, .medium span:after {
		 content: "";
		 position: absolute;
		 display: block;
		 bottom: -10px;
		 border: 20px solid #ddb500;
		 z-index: -1;
		 -webkit-transform: translateZ(-1px);
	}
	 .medium span:before {
		 left: -30px;
		 border-left-color: transparent;
	}
	 .medium span:after {
		 right: -30px;
		 border-right-color: transparent;
	}
	 .medium span span:before, .medium span span:after {
		 content: "";
		 position: absolute;
		 display: block;
		 border-style: solid;
		 bottom: -10px;
		 border-color: #705c00 transparent transparent transparent;
	}
	 .medium span span:before {
		 left: 0;
		 border-width: 10px 0 0 10px;
	}
	 .medium span span:after {
		 right: 0;
		 border-width: 10px 10px 0 0;
	}
 
</style>

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
            
            <a href="{{route("bulk_order_page", ['product_id' => $product->id])}}">
                <div class="ribbon-wrapper medium">
                    <span>
                        <span>Save UPTO 25% on Bulk Orders</span>
                    </span>
                </div>
            </a>
                
            
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