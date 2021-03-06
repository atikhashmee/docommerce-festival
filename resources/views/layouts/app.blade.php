<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('web_assets/images/favicon.png') }}" />

    <title>{{ env('APP_TITLE') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->    
    <link rel="stylesheet" href="{{asset('web_assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.7.0/css/all.min.css">
    <link rel="stylesheet" href="{{asset('web_assets/css/owl.carousel.min.css')}}" />
    <link rel="stylesheet" href="{{asset('web_assets/css/owl.theme.default.min.css')}}" />
    <link rel="stylesheet" href="{{asset('web_assets/css/jquery-ui.css')}}" />
    <link rel="stylesheet" href="{{asset('web_assets/css/style.css?v='.time())}}" />
    <link rel="stylesheet" href="{{asset('web_assets/css/responsive.css?v='.time())}}" />
    <link rel="stylesheet" href="{{asset('web_assets/css/flip-count.css?v='.time())}}" />
    <script>
        var baseUrl = `{{url('/')}}`;
    </script>
</head>
<body>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v12.0" nonce="9Zbdft3c"></script>
    <!-- loader div start -->
    <div class="loader-div">
		<div class="loader"></div>
    </div>
    <!-- loader div end -->

    
    <div class="added-message">
        <p>
            <span class="p_name">Product Name</span><br>
            <span class="p_desc">Successfully added in the <span class="textChange">cart</span>.</span>
            
        </p>
    </div>
    @if (in_array(Route::currentRouteName(), ['index_page', 'home']))
        @include('layouts._top_banner')
    @endif
    @if(Route::currentRouteName() == 'index_page')
        @include('layouts._index')
    @elseif(in_array(Route::currentRouteName(), ['products_page', 'store_page', 'cart_view_page', 'checkout_page', 'login', 'register', 'order_completed', 'orders_page', 'detail_page', 'category_page', 'privacy-policy'])) 
        <section class="w-100 header text-center">
            <a href="{{route('index_page')}}"><img src="{{asset('web_assets/images/top-banner-inner.jpg')}}" alt="DoCommerce 11-11 Festival" class="img-fluid mx-auto festive-logo d-none d-md-block">
            <img src="{{asset('web_assets/images/top-banner-2.jpg')}}" alt="DoCommerce 11-11 Festival" class="img-fluid mx-auto festive-logo d-block d-md-none"></a>
        </section>
    @endif
    @include('layouts._menu')
    @yield('content')
    @include('layouts._footer')

    <!-- Modal -->
    <div class="modal fade" id="festivalModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="festivalModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                
                <div class="modal-body">
                    
                    <img src="{{ asset('web_assets/images/festival-11-11.jpg') }}" alt="DoCommerce 11-11 Festival" class="img-fluid d-block mx-auto shadow" height="470" width="470" loading="lazy">
                    
                    
                    <div class="flipper d-flex justify-content-center" data-reverse="true" data-datetime="2021-11-11 00:00:00" data-template="dd|HH|ii|ss" data-labels="Days|Hours|Minutes|Seconds" id="myFlipper"></div>
                    
                </div>
                
            </div>
        </div>
    </div>
    
    <a id="back-to-top" href="#" class="btn btn-primary btn-sm back-to-top" role="button"><i class="fas fa-chevron-up"></i></a>
    <script src="{{asset('web_assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('web_assets/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('web_assets/js/owl.carousel.min.js')}}"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/igorlino/elevatezoom-plus/1.1.6/src/jquery.ez-plus.js"></script>
    <script src="{{asset('web_assets/js/custom.js?v='.time())}}"></script>
    <script src="{{asset('web_assets/js/scripts.js?v='.time())}}"></script>
    <script src="{{asset('web_assets/js/jquery.flipper-responsive.js')}}"></script>
    @if (env('ISLIVE'))  
        <script>
            $(window).on('load',function(){
                $('#festivalModal').modal('show');
                $('#myFlipper').flipper('init');
            });

        </script>
    @endif
    @yield('scripts')
</body>
</html>
