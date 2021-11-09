@extends('layouts.app')

@section('content')
<section class="w-100 products-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6 col-md-4">
                <img src="{{asset('web_assets/images/discount-offer.png')}}" alt="upto 70% discount" class="img-fluid d-block mx-auto pb-5">
            </div>

            <div class="col-6 col-md-4">
                <img src="{{asset('web_assets/images/gifts.png')}}" alt="gifts" class="img-fluid d-block mx-auto pb-5">
            </div>

            <div class="col-6 col-md-4">
                <img src="{{asset('web_assets/images/delivery.png')}}" alt="delivery" class="img-fluid d-block mx-auto pb-5">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3 class="product-section-heading mb-5">
                    Hot Deals
                    <a href="#" class="float-right">
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

                    <a href="#" class="float-right">
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