<section class="product-menu w-100 py-3 sticky-top">
    <div class="container">
        <div class="row">
            
            <div class="col-md-9 order-md-12">
                <div class="float-right p-0 py-md-2">
                    <ul class="nav mx-auto ml-md-auto cart-notification-ul align-items-center">
                        <li class="nav-item mx-1">
                            <form class="form-inline my-2 my-lg-0 product-search">
                                <div class="input-group ml-auto top-search">
                                    <input type="text" class="form-control" aria-label="I am looking for..." placeholder="I am looking for...">
                                    <div class="input-group-append">
                                        <button class="btn btn-success" type="button"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </li>
                        <li class="nav-item mx-1 login-li">
                            @guest
                                <a href="{{route('login')}}" class="top-notification-icons p-2"><i class="fas fa-user"></i></a>
                            @else
                                <a href="{{route('orders_page')}}" class="top-notification-icons p-2"><i class="fas fa-user"></i></a>
                            @endguest
                        </li>
                        <li class="nav-item mx-1 cart-li">
                            <a href="javascript:void(0)" class="top-notification-icons p-2">
                                <i class="fas fa-shopping-basket"></i>
                                <span class="notification-numbers shadow-sm" id="cart_quantity">0</span>
                            </a>
                            <div class="cart-dropdown-wrap text-left">
                                <ul class="m-0 p-0" id="cart_items_short">
                                   
                                </ul>

                                <div class="shopping-cart-footer">
                                    <div class="shopping-cart-total">
                                        <h4>Total <span>৳<span id="total_price_top">00.00</span></span></h4>
                                    </div>
                                    <div class="shopping-cart-button">
                                        <a href="{{route('cart_view_page')}}" class="btn btn-outline-success">View cart</a>
                                        <a href="{{route('checkout_page')}}" class="btn btn-success">Checkout</a>
                                    </div>
                                </div>

                            </div>
                        </li>
                        <li>
                            <a href="javascript:void(0)"  onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();" class="btn btn-outline-success btn-sm ml-3">Logout</a>
                        </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        
                    </ul>
                </div>
            </div>

            <div class="col-md-3 order-md-1">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Browse Categories
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            @if (count($categories) > 0)
                                @foreach ($categories as $category)
                                    <a class="dropdown-item" href="{{route('category_page', ['category_id' => $category->id])}}">{{$category->name}}</a>
                                @endforeach
                            @endif
                        </div>
                        </li>
                    </ul>
                    
                </nav>
            </div>

        </div>
    </div>
</section>