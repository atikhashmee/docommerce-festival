<footer class="w-100">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <a href="{{ url('/') }}">
                    <img src="{{asset('web_assets/images/footer-logo.png')}}" alt="Docommerce 11-11 Festival" loading="lazy" class="img-fluid d-block mx-auto mx-md-0">
                </a>
                
            </div>

            <div class="col-md-6 text-center text-md-right">
                <h5 class="footer-header mt-5 mt-md-0">Quick Links</h5>
                <ul class="m-0 mt-2 mt-md-4 p-0 footer-quick-links">
                    
                    <li><a href="#">Terms and Conditions</a></li>
                    <li><a href="{{ route('privacy-policy') }}">Privacy Policies</a></li>
                    <li><a href="{{ url('/#faq') }}">FAQ</a></li>
                    <li><a href="#">Return Policy</a></li>
                    {{-- <li><a href="javascript:void(0)"  onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">Logout</a></li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form> --}}
                    <li>Contact: <a href="tel:01745408181">01745408181</a></li>
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