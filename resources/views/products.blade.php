@extends('layouts.app')

@section('content')
    @php
        $Datacategory = null;
        $Datastore = null;
        if (isset($store)) {
            $Datastore = $store;
        }
        if (isset($category)) {
            $Datacategory = $category;
        }
    @endphp
    <section class="w-100 bg-light sticky-top sticky-offset">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('index_page')}}" class="font-weight-bold"><i class="fas fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                @if ($Datastore != null)
                                    {{$Datastore->name}}
                                @elseif($Datacategory != null)
                                    {{$Datacategory->name}}
                                @else 
                                    Products @if (Request::get('search') != null)
                                        / {{Request::get('search')}}
                                    @endif
                                @endif
                            </li>
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
                    <button type="button" class="btn d-block mb-4 btn-outline-success d-md-none left-side-bar-swt">Filter</button>
                    <form method="GET" id="filterForm">
                        <div class="left-linksDiv mb-5">
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
                                        <input class="form-check-input" type="radio" name="sort_letter" id="a-z" value="a-z" @if(Request::get('sort_letter') != null && Request::get('sort_letter') == "a-z") checked @endif>
                                        <label class="form-check-label" for="a-z"><span>A - Z</span></label>
                                    </div>
                                </li>
                                <li>
                                    <div class="custome-checkbox">
                                        <input class="form-check-input" type="radio" name="sort_letter" id="z-a" value="z-a" @if(Request::get('sort_letter') != null && Request::get('sort_letter') == "z-a") checked @endif>
                                        <label class="form-check-label" for="brand10"><span>Z - A</span></label>
                                    </div>
                                </li>
                            </ul>
                            <hr>
                            <h4 class="mb-4">Sort by price</h4>
                            <ul class="list_brand">
                                <li>
                                    <div class="custome-checkbox">
                                        <input class="form-check-input" type="radio" name="sort_price" id="low-high" value="low-high" @if(Request::get('sort_price') != null && Request::get('sort_price') == "low-high") checked @endif>
                                        <label class="form-check-label" for="low-high"><span>Low - High</span></label>
                                    </div>
                                </li>
                                <li>
                                    <div class="custome-checkbox">
                                        <input class="form-check-input" type="radio" name="sort_price" id="high-low" value="high-low" @if(Request::get('sort_price') != null && Request::get('sort_price') == "high-low") checked @endif>
                                        <label class="form-check-label" for="high-low"><span>High - Low</span></label>
                                    </div>
                                </li>
                            </ul>
                            <hr>
                            <h4 class="mb-4">Filter by Price</h4>
                            @php
                                $filter_price_min = 0;
                                $filter_price_max = (isset($max_price) && $max_price == 0) ? 20000 : $max_price ?? 20000 * 2;
                                $prodcut_max_price = $filter_price_max;
                                if (Request::get('price_range')) {
                                    list($filter_price_min, $filter_price_max) = explode(',', Request::get('price_range'));
                                }
                            @endphp
                            <div class="filter_price" style="width: 90%;">
                                <input type="hidden" name="price_range" id="price_range" value="{{Request::get('price_range')}}">
                                <div id="price_filter" data-min="0" data-max="{{$prodcut_max_price}}" data-min-value="{{$filter_price_min}}"  data-max-value="{{$filter_price_max}}" data-price-sign=" ৳" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
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
                    </form>
                    
                </div>

                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-12">
        
                            <h5 class="product-section-heading storeNameDiv mb-5">
                                @if ($Datastore != null)
                                    {{$Datastore->name}}
                                @elseif($Datacategory != null)
                                    {{$Datacategory->name}}
                                @else 
                                    Products 
                                    @if (Request::get('search') != null)
                                        / {{Request::get('search')}}
                                    @endif
                                @endif
        
                                @if ($Datastore != null)  
                                    <a href="//{{$Datastore->store_url}}" class="float-right">
                                        Visit Owner's Store <i class="fas fa-angle-right"></i>
                                    </a>
                                @endif
                              
                            </h5>
                        </div>
                    </div>
                    {{-- <div class="row">
                        @if (count($exclusives) > 0)
                            @foreach ($exclusives as $product)
                                <div class="col-md-4 mb-4">
                                    @component('web-components._product', compact('product'))
                                        
                                    @endcomponent
                                </div>
                            @endforeach
                        @endif
                    </div> --}}

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
                    {{$exclusives->links()}}
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

    $(document).ready(function () {
        $(".custome-checkbox").on("click", "input[type=radio]", function(evt) {
            $("#filterForm").submit();
            //console.log(evt.currentTarget);
        })

        $('.left-side-bar-swt').on('click', function (e) {
            e.preventDefault();
            $('.left-linksDiv').toggle();
        });
    });

    </script>
@endsection