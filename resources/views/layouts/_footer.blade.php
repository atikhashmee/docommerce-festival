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
            
        </div>
    </div>
    </div>
</div>