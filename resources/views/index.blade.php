@extends('layouts.app')

@section('content')
<section class="w-100 products-section py-6">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <img src="{{asset('web_assets/images/discount-offer.png')}}" alt="upto 70% discount" class="img-fluid d-block mx-auto pb-5">
            </div>

            <div class="col-md-3">
                <img src="{{asset('web_assets/images/gifts.png')}}" alt="gifts" class="img-fluid d-block mx-auto pb-5">
            </div>

            <div class="col-md-3">
                <img src="{{asset('web_assets/images/caskback.png')}}" alt="cashback" class="img-fluid d-block mx-auto pb-5">
            </div>

            <div class="col-md-3">
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
        <div class="row justify-content-center">
            @if (count($hot_deals) > 0)
                @foreach ($hot_deals as $product)
                    <div class="col-md-3">
                        @component('web-components._product', compact('product'))
                            
                        @endcomponent
                    </div>
                @endforeach
            @endif
        </div>

        <div class="row py-5">
            <div class="col-md-12">
                <img src="{{asset('web_assets/images/banner.jpg')}}" alt="banner" class="rounded img-fluid d-block mx-auto">
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
        <div class="row justify-content-center">
            @if (count($exclusives) > 0)
                @foreach ($exclusives as $product)
                    <div class="col-md-3">
                        @component('web-components._product', compact('product'))
                            
                        @endcomponent
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>

<section class="faq-section w-100 py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center intro-h2">
                    FAQ about DoCommerce festival 2021
                </h3>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="accordion mt-5" id="festivalFAQ">
                    <div class="card">
                      <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                          <button class="btn btn-block text-left faq-btn" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Q1: When this festival will start?
                          </button>
                        </h2>
                      </div>
                  
                      <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#festivalFAQ">
                        <div class="card-body">
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptatum nesciunt exercitationem, a iure consequuntur accusamus ex eligendi autem quod blanditiis dolores aut laboriosam ut laborum sequi hic velit sint numquam.
                        </div>
                      </div>
                    </div>
                    <div class="card">
                      <div class="card-header" id="headingTwo">
                        <h2 class="mb-0">
                          <button class="btn btn-block text-left faq-btn collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Q2: When can I view the discounted prices?
                          </button>
                        </h2>
                      </div>
                      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#festivalFAQ">
                        <div class="card-body">
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptatum nesciunt exercitationem, a iure consequuntur accusamus ex eligendi autem quod blanditiis dolores aut laboriosam ut laborum sequi hic velit sint numquam.
                        </div>
                      </div>
                    </div>
                    <div class="card">
                      <div class="card-header" id="headingThree">
                        <h2 class="mb-0">
                          <button class="btn btn-block text-left faq-btn collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Q3: How can I be sure that I get the maximum discounts?
                          </button>
                        </h2>
                      </div>
                      <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#festivalFAQ">
                        <div class="card-body">
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptatum nesciunt exercitationem, a iure consequuntur accusamus ex eligendi autem quod blanditiis dolores aut laboriosam ut laborum sequi hic velit sint numquam.
                        </div>
                      </div>
                    </div>
                  </div>
            </div>
        </div>
    </div>
</section>

@endsection