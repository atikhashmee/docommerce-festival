
<section class="w-100 festive-name">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="name-inner p-3 shadow-sm">
                    <h1 class="text-center m-0 p-0 text-uppercase">
                        Enjoy upto 50% discount from best sellers
                    </h1>
                </div>
            </div>
        </div>
    </div>
</section>

@php
    $storeImages = [
        "0" => 'web_assets/images/stores/0.png',
        "2" => 'web_assets/images/stores/2.png',
        "3" => 'web_assets/images/stores/3.png',
        "4" => 'web_assets/images/stores/4.png',
        "8" => 'web_assets/images/stores/8.png',
        "10" => 'web_assets/images/stores/10.png',
        "12" => 'web_assets/images/stores/12.png',
        "13" => 'web_assets/images/stores/13.png',
        "17" => 'web_assets/images/stores/17.png',
        "25" => 'web_assets/images/stores/25.png',
        "28" => 'web_assets/images/stores/28.png',
        "38" => 'web_assets/images/stores/38.png',
        "39" => 'web_assets/images/stores/39.png'
    ];
@endphp

<section class="w-100 stores-section pt-5 pb-3">
    <div class="container">

        <div class="row justify-content-center">
            {{-- <div class="owl-carousel owl-theme stores-slide">
                @if (count($stores) > 0)
                    @foreach ($stores as $store)
                        <div class="item">
                            <a href="{{route('store_page', ['store_id' => $store->original_store_id])}}">
                                @if ($store->img !=null && file_exists(public_path('storage/stores/'.$store->img)))
                                    <img src="{{ asset('storage/stores/'.$store->img) }}" alt="{{ $store->name }}" height="97" width="176" class="img-fluid mx-auto d-block brands-img mb-5">
                                @else
                                    <img src="{{ $store->store_logo_url }}" alt="{{ $store->name }}" height="97" width="176" class="img-fluid mx-auto d-block brands-img mb-5">
                                @endif
                                
                            </a>
                        </div>
                    @endforeach
                @endif
            </div> --}}

            @if (count($stores) > 0)
                @foreach ($stores as $store)
                <div class="col-4 col-md-2">
                    <a href="{{route('store_page', ['store_id' => $store->original_store_id])}}">
                        @if ($store->img !=null && file_exists(public_path('storage/stores/'.$store->img)))
                            <img src="{{ asset('storage/stores/'.$store->img) }}" alt="{{ $store->name }}" height="97" width="176" class="img-fluid mx-auto d-block brands-img mb-5">
                        @else
                            <img src="{{ $store->store_logo_url }}" alt="{{ $store->name }}" height="97" width="176" class="img-fluid mx-auto d-block brands-img mb-5">
                        @endif
                        
                    </a>
                </div>
                @endforeach
            @endif

        </div>
    </div>
</section>

{{-- <section class="product-heading w-100 py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2 class="text-center m-0 p-0">
                    Exclusive products with special price
                </h2>
            </div>
        </div>
    </div>
</section> --}}