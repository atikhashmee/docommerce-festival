<footer class="w-100">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <a href="https://docommerce.com/" target="_blank">
                    <img src="{{asset('web_assets/images/footer-logo.png')}}" alt="Docommerce 11-11 Festival" class="img-fluid d-block mx-auto mx-md-0">
                </a>
                
            </div>

            <div class="col-md-8 text-center text-md-right">
                <ul class="m-0 mt-2 mt-md-2 p-0 list-inline footer-quick-links">
                    <li class="list-inline-item"><a href="{{ route('privacy-policy') }}"><span class="px-2">&#9673;</span> Privacy Policies</a></li>
                    <li class="list-inline-item"><a href="{{ url('/#faq') }}"><span class="px-2">&#9673;</span> FAQ</a></li>
                    <li class="list-inline-item"><a href="{{route('login')}}"><span class="px-2">&#9673;</span> Track Order</a></li>
                    <li class="list-inline-item"><span class="px-2">|</span> Contact: <a href="tel:01745408181">01745408181</a></li>
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