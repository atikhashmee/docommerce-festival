@extends('layouts.app')

@section('content')
    <section class="w-100 bg-light sticky-top sticky-offset">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('index_page')}}" class="font-weight-bold"><i class="fas fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Store name</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="w-100 products-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="left-linksDiv">
                        {{-- <h4>Categories</h4>

                        <ul class="categories-list">
                            @if (count($categories) > 0)
                                @foreach ($categories as $category)
                                    <li>
                                        <a href="{{route('category_page', ['category_id' => $category->id])}}">
                                            {{$category->name}} <i class="fas fa-angle-double-right"></i>
                                            <span>{{$category->total_products ?? 0}}</span>
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>

                        <hr> --}}

                        <h4 class="mb-4">Sort by name</h4>

                        <ul class="list_brand">
                            <li>
                                <div class="custome-checkbox">
                                    <input class="form-check-input" type="checkbox" name="a-z" id="a-z">
                                    <label class="form-check-label" for="a-z"><span>A - Z</span></label>
                                </div>
                            </li>
                            <li>
                                <div class="custome-checkbox">
                                    <input class="form-check-input" type="checkbox" name="z-a" id="z-a">
                                    <label class="form-check-label" for="brand10"><span>Z - A</span></label>
                                </div>
                            </li>
                        </ul>

                        <hr>

                        <h4 class="mb-4">Sort by price</h4>

                        <ul class="list_brand">
                            <li>
                                <div class="custome-checkbox">
                                    <input class="form-check-input" type="checkbox" name="low-high" id="low-high">
                                    <label class="form-check-label" for="low-high"><span>Low - High</span></label>
                                </div>
                            </li>
                            <li>
                                <div class="custome-checkbox">
                                    <input class="form-check-input" type="checkbox" name="high-low" id="high-low">
                                    <label class="form-check-label" for="high-low"><span>High - Low</span></label>
                                </div>
                            </li>
                        </ul>

                        <hr>

                        <h4 class="mb-4">Filter by Price</h4>

                        <div class="filter_price">
                            <input type="hidden" name="price_range" id="price_range">
                            <div id="price_filter" data-min="0" data-max="3800.00" data-min-value="0" data-max-value="3800" data-price-sign=" ৳" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                                <div class="ui-slider-range ui-widget-header ui-corner-all" style="left: 0%; width: 100%;"></div>
                                <span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0" style="left: 0%;"></span>
                                <span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0" style="left: 100%;"></span>
                            </div>
                            <div class="price_range mt-4">
                                <span>Price: <span id="flt_price"></span></span>
                                <input type="hidden" id="price_first">
                                <input type="hidden" id="price_second">
                            </div>
                        </div>

                    </div>
                    
                </div>

                <div class="col-md-9">
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
                        @if (count($exclusives) > 0)
                            @foreach ($exclusives as $product)
                                <div class="col-md-4 mb-4">
                                    @component('web-components._product', compact('product'))
                                        
                                    @endcomponent
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="row pt-3 pb-5">
                        <div class="col-md-12">
                            <a href="https://docommerce.com/pricing" target="_blank">
                                <img src="{{asset('web_assets/images/banner.jpg')}}" alt="banner" class="rounded img-fluid d-block mx-auto img-thumbnail">
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        @if (count($exclusives) > 0)
                            @foreach ($exclusives as $product)
                                <div class="col-md-4 mb-4">
                                    @component('web-components._product', compact('product'))
                                        
                                    @endcomponent
                                </div>
                            @endforeach
                        @endif
                    </div>
                    
                </div>
            </div>

        </div>
    </section>

@endsection

@section('scripts')
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script>
        $('#price_filter').each( function() {
		var $filter_selector = $(this);
		var a = $filter_selector.data("min-value");
		var b = $filter_selector.data("max-value");
		var c = $filter_selector.data("price-sign");
		$filter_selector.slider({
			range: true,
			min: $filter_selector.data("min"),
			max: $filter_selector.data("max"),
			values: [ a, b ],
			slide: function( event, ui ) {
				$( "#flt_price" ).html( c + ui.values[ 0 ] + " - " + c + ui.values[ 1 ] );
				$( "#price_first" ).val(ui.values[ 0 ]);
				$( "#price_second" ).val(ui.values[ 1 ]);
			},
			stop: function(evet, ui) {
				document.querySelector('#price_range').value = ui.values[ 0 ]+','+ui.values[ 1 ];
				$("#filterForm").submit();
			}
		});
		$( "#flt_price" ).html( c + $filter_selector.slider( "values", 0 ) + " - " + c + $filter_selector.slider( "values", 1 ) );
	});

    </script>
@endsection