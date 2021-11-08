<div class="container">
    <div class="row">
        <div class="col-md-12">

            <h5 class="product-section-heading storeNameDiv mb-5">
                Store name

                <a href="#" class="float-right">
                    View owner's store <i class="fas fa-angle-right"></i>
                </a>
            </h5>
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
                <span class="text-danger font-weight-bold">৳<span id="product_price">{{$product->price}}</span></span> 
                <small style="text-decoration: line-through;">৳<span id="product_old_price">{{$product->old_price}}</span></small>
            </h6>
            @if (count($product->show_variants) > 0)
                <div class="options pt-3">
                    @foreach ($product->show_variants as $name => $item)
                        <div class="each-variant-row">
                            <span class="mr-1">{{$name}}</span>
                            @foreach ($item as $prop => $val)
                                <button type="button" onclick="changeVariant({{json_encode($val)}}, this)" class="btn btn-info btn-sm mr-1 @if(isset($product->smallest_variant) && $val->id == $product->smallest_variant->id) active @endif">{{$prop}}</button>
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
                    <input class="input-group-field" type="number" name="quantity" min="1" max="999" value="1">
                    <div class="input-group-button">
                    <button type="button" class="button hollow circle" data-quantity="plus" data-field="quantity">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </button>
                    </div>
                    <a href="javascript:void(0)" class="btn btn-success addcart-btn ml-3 text-capitalize"><i class="fas fa-cart-plus"></i> Add to cart</a>
                </div>
            </div>
            <hr>
            <p>
                Category: <a href="{{route("category_page", ['category_id' => $product->category_id])}}">{{$product->category->name}}</a> 
            </p>

        </div>
    </div>
</div>