<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
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
    <script>
        var baseUrl = `{{url('/')}}`
    </script>
</head>
<body>
    <div class="added-message">
        <p>
            <span class="p_name">Product Name</span><br>
            <span class="p_desc">Successfully added in the <span class="textChange">cart</span>.</span>
            
        </p>
    </div>
    @if (in_array(Route::currentRouteName(), ['index_page', 'cart_view_page', 'checkout_page', 'login', 'register', 'order_completed', 'orders_page', 'detail_page', 'home']))
        @include('layouts._top_banner')
    @endif
    @if(Route::currentRouteName() == 'index_page')
        @include('layouts._index')
    @elseif(in_array(Route::currentRouteName(), ['store_page', 'category_page'])) 
        <section class="w-100 header text-center">
            <a href="{{route('index_page')}}"><img src="{{asset('web_assets/images/top-banner.png')}}" alt="DoCommerce 11-11 Festival" class="img-fluid mx-auto festive-logo d-none d-md-block">
            <img src="{{asset('web_assets/images/top-banner-2.png')}}" alt="DoCommerce 11-11 Festival" class="img-fluid mx-auto festive-logo d-block d-md-none"></a>
        </section>
    @endif
    @include('layouts._menu')
    @yield('content')
    @include('layouts._footer')
    
    <a id="back-to-top" href="#" class="btn btn-primary btn-sm back-to-top" role="button"><i class="fas fa-chevron-up"></i></a>
    <script src="{{asset('web_assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('web_assets/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('web_assets/js/owl.carousel.min.js')}}"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/igorlino/elevatezoom-plus/1.1.6/src/jquery.ez-plus.js"></script>
    <script src="{{asset('web_assets/js/custom.js?v='.time())}}"></script>
    <script src="{{asset('web_assets/js/scripts.js?v='.time())}}"></script>
    @yield('scripts')
</body>
</html>
