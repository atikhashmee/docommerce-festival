<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>DoCommerce 11-11 Festival</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Georama:ital,wght@0,400;1,700&family=Noto+Sans:wght@400;700&display=swap" rel="stylesheet">

    <!-- Styles -->    
    <link rel="stylesheet" href="{{asset('web_assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.7.0/css/all.min.css">
    <link rel="stylesheet" href="{{asset('web_assets/css/adminStyle.css')}}">
    @yield('styles')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('admin') }}">
                    <!-- {{ config('app.name', 'DoCommerce 11-11 Festival') }} -->
                    DoCommerce 11-11 Festival
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('admin.login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('admin.register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a href="{{route('admin.users.index')}}" class="nav-link">Users</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.orders.index')}}" class="nav-link">Orders</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.products.index')}}" class="nav-link">Products</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.stores.index')}}" class="nav-link">Stores</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.categories.index')}}" class="nav-link">Categories</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.festivals.index')}}" class="nav-link">Festivals</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('admin.logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
        @yield('modals')
    </div>
    <script src="{{asset('web_assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('web_assets/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('admin_assets/js/script.js')}}"></script>
    @yield('scripts')
</body>
</html>
