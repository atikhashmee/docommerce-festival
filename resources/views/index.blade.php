@extends('layouts.app')

@section('content')
<section class="w-100 products-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6 col-md-4">
                <img src="{{asset('web_assets/images/discount-offer.png')}}" alt="upto 70% discount" class="img-fluid d-block mx-auto pb-5">
            </div>

            <div class="col-6 col-md-4">
                <img src="{{asset('web_assets/images/cash-deilvery.png')}}" alt="Cash on delivery" class="img-fluid d-block mx-auto pb-5">
            </div>

            <div class="col-6 col-md-4">
                <img src="{{asset('web_assets/images/delivery.png')}}" alt="delivery" class="img-fluid d-block mx-auto pb-5">
            </div>
        </div>

        {{-- <div class="row">
            <div class="col-md-12">
                <h3 class="product-section-heading mb-5">
                    Featured Categories
                    <a href="#" class="float-right">
                        View all <i class="fas fa-angle-right"></i>
                    </a>
                </h3>
            </div>
        </div>

        <div class="row">
            <div class="col-6 col-md-2 mb-4">
                <div class="productsDiv p-2 shadow-sm rounded">
                    <a href="#">
                    <img src="https://zipgrip.delivery/storage/58/product/thumb/1636625682-roots-111.jpg" alt="Men Shoes" class="img-fluid d-block mx-auto rounded mb-2">
                        <h6 class="product-name mb-0">Men Shoes</h6>
                    </a>
                </div>
            </div>
            <div class="col-6 col-md-2 mb-4">
                <div class="productsDiv p-2 shadow-sm rounded">
                    <a href="#">
                    <img src="https://zipgrip.delivery/storage/4/product/thumb/1636520569-max-121.jpg" alt="Travel Bag" class="img-fluid d-block mx-auto rounded mb-2">
                        <h6 class="product-name mb-0">Travel Bag</h6>
                    </a>
                </div>
            </div>
            <div class="col-6 col-md-2 mb-4">
                <div class="productsDiv p-2 shadow-sm rounded">
                    <a href="#">
                    <img src="https://zipgrip.delivery/storage/73/product/thumb/1636631706-prince-34.jpg" alt="Winter Collection" class="img-fluid d-block mx-auto rounded mb-2">
                        <h6 class="product-name mb-0">Winter Collection</h6>
                    </a>
                </div>
            </div>
            <div class="col-6 col-md-2 mb-4">
                <div class="productsDiv p-2 shadow-sm rounded">
                    <a href="#">
                    <img src="https://zipgrip.delivery/storage/57/product/thumb/1636365039-on-hand-100-authentic-enchanteur-perfumed-body-lotion-500ml.jpg" alt="Skin Care" class="img-fluid d-block mx-auto rounded mb-2">
                        <h6 class="product-name mb-0">Skin Care</h6>
                    </a>
                </div>
            </div>
            <div class="col-6 col-md-2 mb-4">
                <div class="productsDiv p-2 shadow-sm rounded">
                    <a href="#">
                    <img src="https://zipgrip.delivery/storage/73/product/thumb/1636630300-prince-12.jpg" alt="Kids Clothes" class="img-fluid d-block mx-auto rounded mb-2">
                        <h6 class="product-name mb-0">Kids Clothes</h6>
                    </a>
                </div>
            </div>
            <div class="col-6 col-md-2 mb-4">
                <div class="productsDiv p-2 shadow-sm rounded">
                    <a href="https://festival.docommerce.com/category/3">
                    <img src="https://zipgrip.delivery/storage/74/product/thumb/1636707717-img-2169.jpg" alt="Saree" class="img-fluid d-block mx-auto rounded mb-2">
                        <h6 class="product-name mb-0">Saree</h6>
                    </a>
                </div>
            </div>
        </div> --}}
        
        <div class="row">
            <div class="col-md-12">
                <h3 class="product-section-heading mb-5">
                    Hot Deals
                    <a href="{{ route('products_page') }}?section=hot_deals" class="float-right">
                        See more <i class="fas fa-angle-right"></i>
                    </a>
                </h3>
            </div>
        </div>
        <div class="row">
            @if (count($hot_deals) > 0)
                @foreach ($hot_deals as $product)
                    <div class="col-6 col-md-3 mb-4">
                        @component('web-components._product', compact('product'))
                            
                        @endcomponent
                    </div>
                @endforeach
            @endif
        </div>

        <div class="row pt-3 pb-5">
            <div class="col-md-12">
                <a href="https://docommerce.com/pricing" target="_blank">
                    <img src="{{asset('web_assets/images/banner.jpg')}}" alt="banner" class="rounded img-fluid d-block mx-auto img-thumbnail">
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

                <h3 class="product-section-heading mb-5">
                    Exclusive products

                    <a href="{{ route('products_page') }}?section=exclusive" class="float-right">
                        See more <i class="fas fa-angle-right"></i>
                    </a>
                </h3>
            </div>
        </div>
        <div class="row">
            @if (count($exclusives) > 0)
                @foreach ($exclusives as $product)
                    <div class="col-6 col-md-3 mb-4">
                        @component('web-components._product', compact('product'))
                            
                        @endcomponent
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>

@include('web-components._faq')

@endsection