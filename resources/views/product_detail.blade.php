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

    @if (isset($product) && $product->description!=null)
        <section class="other-store-product py-3 py-md-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="descriptionDiv p-3 shadow-sm rounded">
                            <h5 class="m-0 pb-3 mb-3 description-heading">
                                Description
                            </h5>
                            <p class="m-0">
                                {!! $product->description !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section class="other-store-product py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
    
                    <h3 class="product-section-heading storeNameDiv mb-5">
                        {{$product->store->name}} Others Products

                        <a href="{{route('store_page', ['store_id' => $product->original_store_id])}}" class="float-right" target="_blank">
                            View all products <i class="fas fa-angle-right"></i>
                        </a>
                    </h3>
                </div>
            </div>
            <div class="row">
                @if (count($store_other_products) > 0)
                    @foreach ($store_other_products as $product)
                        <div class="col-6 col-md-3 mb-4">
                            @component('web-components._product', compact('product'))
                                
                            @endcomponent
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
    <section class="other-store-product py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="fb-comments" data-href="{{$product_url}}" data-width="100%" data-numposts="5"></div>
                </div>
            </div>
        </div>
    </section>
@endsection