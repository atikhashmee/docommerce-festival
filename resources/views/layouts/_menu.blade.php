<section class="product-menu w-100 py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Browse Categories
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            @if (count($categories) > 0)
                                @foreach ($categories as $category)
                                    <a class="dropdown-item" href="#">{{$category->name}}</a>
                                @endforeach
                            @endif
                        </div>
                        </li>
                    </ul>
                    
                </nav>
            </div>

            <div class="col-md-9">
                <div class="float-none float-md-right p-0 py-md-2">
                    <ul class="nav mx-auto ml-md-auto cart-notification-ul">
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
                        <li class="nav-item mx-1">
                            @guest
                                <a href="{{route('login')}}" class="top-notification-icons p-2"><i class="fas fa-user"></i></a>
                            @else
                                <a href="javascript:void(0)" class="top-notification-icons p-2"><i class="fas fa-user"></i></a>
                            @endguest
                        </li>
                        <li class="nav-item mx-1 cart-li">
                            <a href="javascript:void(0)" class="top-notification-icons p-2">
                                <i class="fas fa-shopping-basket"></i>
                                <span class="notification-numbers shadow-sm">15</span>
                            </a>
                            <div class="cart-dropdown-wrap text-left">
                                <ul class="m-0 p-0">
                                    <li>
                                        <div class="shopping-cart-img">
                                            <a href="#"><img alt="product" src="assets/images/products/1.png"></a>
                                        </div>
                                        <div class="shopping-cart-title">
                                            <h4><a href="shop-product-right.html">American Garden Original BBQ Sauce</a></h4>
                                            <h4><span>1 × </span>৳800.00</h4>
                                        </div>
                                        <div class="shopping-cart-delete">
                                            <a href="#"><i class="fa fa-times"></i></a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="shopping-cart-img">
                                            <a href="shop-product-right.html"><img alt="Nest" src="assets/images/products/2.png"></a>
                                        </div>
                                        <div class="shopping-cart-title">
                                            <h4><a href="shop-product-right.html">American Garden Original BBQ Sauce</a></h4>
                                            <h4><span>1 × </span>৳3200.00</h4>
                                        </div>
                                        <div class="shopping-cart-delete">
                                            <a href="#"><i class="fa fa-times"></i></a>
                                        </div>
                                    </li>
                                </ul>

                                <div class="shopping-cart-footer">
                                    <div class="shopping-cart-total">
                                        <h4>Total <span>৳1000.00</span></h4>
                                    </div>
                                    <div class="shopping-cart-button">
                                        <a href="cart.html" class="btn btn-outline-success">View cart</a>
                                        <a href="#" class="btn btn-success">Checkout</a>
                                    </div>
                                </div>

                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>