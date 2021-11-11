@extends('layouts.app')

@section('content')
    <section class="w-100 bg-light sticky-top sticky-offset">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('index_page')}}" class="font-weight-bold"><i class="fas fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Detail</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="w-100 products-section py-5">
        @include('web-components._detail')
    </section>

    <section class="other-store-product py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
    
                    <h3 class="product-section-heading mb-5">
                        Other store products
                    </h3>
                </div>
            </div>
            <div class="row">
                 <div class="col-6 col-md-3 mb-4">
                    <div class="productsDiv p-3 shadow-sm rounded">
                        <a href="#"  title="American Garden Original BBQ Sauce">
                            <div class="ribbon ribbon-top-left"><span>Save ৳20</span></div>
                            
                            <img src="{{asset('web_assets/images/products/1.png')}}" alt="product 1" class="img-fluid d-block mx-auto rounded">
    
                            <h6 class="product-name mb-2">American Garden Original BBQ Sauce</h6>
                        </a>
    
                        <h6>
                            <span class="text-danger font-weight-bold">৳170</span> <small style="text-decoration: line-through;">৳190</small>
                        </h6>
                        
    
                        <a href="javascript:void(0)" class="btn btn-warning addcart-btn btn-block mt-4 text-capitalize">Add to cart</a>

                        <div class="wish-zoom">
                            <a href="javascript:void(0)" class="p-d-switch">
                                <i class="fas fa-search-plus"></i>
                            </a>
                            
                        </div>

                    </div>
                 </div>

                 <div class="col-6 col-md-3 mb-4">
                    <div class="productsDiv p-3 shadow-sm rounded">
                        <a href="#"  title="American Garden Original BBQ Sauce">
                            <div class="ribbon ribbon-top-left"><span>Save ৳20</span></div>

                            <img src="{{asset('web_assets/images/products/2.png')}}" alt="product 1" class="img-fluid d-block mx-auto rounded">
    
                            <h6 class="product-name mb-2">American Garden Original BBQ Sauce</h6>
                        </a>
    
                        <h6>
                            <span class="text-danger font-weight-bold">৳170</span> <small style="text-decoration: line-through;">৳190</small>
                        </h6>
                        
    
                        <a href="javascript:void(0)" class="btn btn-warning addcart-btn btn-block mt-4 text-capitalize">Add to cart</a>

                        <div class="wish-zoom">
                            <a href="javascript:void(0)" class="p-d-switch">
                                <i class="fas fa-search-plus"></i>
                            </a>
                            
                        </div>

                    </div>
                 </div>
                   
            </div>
        </div>
    </section>
    
@endsection