<footer class="w-100">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <a href="index.html">
                    <img src="{{asset('web_assets/images/do-commerce-w-logo.png')}}" alt="logo" loading="lazy" class="img-fluid d-block">
                </a>
                <p class="my-4 p-0 footer-about">
                    Enjoy upto 70% Discount from the bestsellers.
                </p>

                <ul class="social_icons m-0 p-0">        
                    <li><a target="_blank" href="https://www.facebook.com/DoCommerceLtd"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a target="_blank" href="https://www.instagram.com/docommerceltd/"><i class="fab fa-instagram"></i></a></li>
                </ul>
            </div>

            <div class="col-md-3">
                <h4 class="footer-header mt-4 mt-md-0">Quick Links</h4>
                <ul class="m-0 mt-4 p-0 footer-quick-links">
                    <li><a href="#">How to Order</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Supplier Registration</a></li>
                </ul>
            </div>

            <div class="col-md-3">
                <h4 class="footer-header d-none d-md-block">&nbsp;</h4>
                <ul class="m-0 mt-4 p-0 footer-quick-links">
                    <li><a href="#">Terms and Conditions</a></li>
                    <li><a href="#">Privacy Policies</a></li>
                    <li><a href="javascript:void(0)"  onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">Logout</a></li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </ul>
            </div>

            <div class="col-md-3">
                <h4 class="footer-header">Contact Info</h4>
                <ul class="m-0 mt-4 p-0 footer-quick-links">
                    <li><i class="fa fa-map-marker"></i> Mirpur 12</li>
                    <li><i class="fa fa-envelope"></i> <a href="mailto:festive@docommerce.com">festive@docommerce.com</a></li>
                    <li><i class="fa fa-mobile"></i> <a href="#">01780430305</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="w-100 bottom-footer">
        <div class="container-fluid py-3">
            <div class="row">
                <div class="col-md-12">
                    <p class="text-center m-0 p-0">Copyright &copy; 2021 <a href="https://docommerce.com/">DoCommerce Ltd</a></p>
                </div>
            </div>
        </div>
    </div>
</footer>


<!--product details popup -->
<div class="modal fade" id="productDetailsModal" tabindex="-1" aria-labelledby="productDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <img id="zoom_01" class="img-fluid d-block mx-auto" src="{{asset('web_assets/images/products/1.png')}}"
                        data-zoom-image="{{asset('web_assets/images/products/1.png')}}"/>

                        <div id="gallery_01" class="mb-4">
                            <a href="#" data-image="{{asset('web_assets/images/products/1.png')}}" data-zoom-image="{{asset('web_assets/images/products/1.png')}}" class="active">
                                <img id="img_01" src="{{asset('web_assets/images/products/1.png')}}"/>
                            </a>
                            <a href="#" data-image="{{asset('web_assets/images/products/2.png')}}" data-zoom-image="{{asset('web_assets/images/products/2.png')}}">
                                <img id="img_01" src="{{asset('web_assets/images/products/2.png')}}"/>
                            </a>
                            <a href="#" data-image="{{asset('web_assets/images/products/3.png')}}" data-zoom-image="{{asset('web_assets/images/products/3.png')}}">
                                <img id="img_01" src="{{asset('web_assets/images/products/3.png')}}"/>
                            </a>
                            
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h6 class="product-details mb-3">Product Name</h6>

                        <div class="rating mb-3">
                            <i class="fas fa-star full"></i>
                            <i class="fas fa-star full"></i>
                            <i class="fas fa-star full"></i>
                            <i class="fas fa-star blank"></i>
                            <i class="fas fa-star blank"></i>

                            <span class="ml-2">3 ratings</span>
                        </div>

                        <h6 class="product-details-price mb-3">
                            <span class="text-danger font-weight-bold">৳170.00</span> <small style="text-decoration: line-through;">৳190.00</small>
                        </h6>

                        <div class="options pt-3">
                            <span class="mr-1">Options</span>
                            <button class="btn btn-info active btn-sm mr-1">100ml</button>
                            <button class="btn btn-info btn-sm mr-1">200ml</button>
                            <button class="btn btn-info btn-sm mr-1">300ml</button>
                        </div>

                        <div class="addPriceCart py-4">
                            <div class="input-group plus-minus-input">
                                <div class="input-group-button">
                                <button type="button" class="button hollow circle" data-quantity="minus" data-field="quantity">
                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                </button>
                                </div>
                                <input class="input-group-field" type="number" name="quantity" value="0">
                                <div class="input-group-button">
                                <button type="button" class="button hollow circle" data-quantity="plus" data-field="quantity">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                </button>
                                </div>

                                <a href="javascript:void(0)" class="btn btn-success addcart-btn ml-3 text-capitalize"><i class="fas fa-cart-plus"></i> Add to cart</a>

                                <a href="javascript:void(0)" class="addPriceCart-wishlist add-wishlist-switch ml-3">
                                    <i class="fas fa-heart"></i>
                                </a>
                            </div> 
                            
                        </div>

                        <hr>

                        <p>
                            SKU: 4767654678788 <br>
                            Category: Canned & Jar , Daily
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>