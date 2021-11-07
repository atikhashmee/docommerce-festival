
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

<section class="w-100 stores-section py-5">
    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="owl-carousel owl-theme stores-slide">
                @if (count($stores) > 0)
                    @foreach ($stores as $store)
                        <div class="item">
                            <a href="{{route('store_page', ['store_id' => $store->id])}}">
                                <img src="{{$store->store_logo_url}}" alt="{{$store->name}}" width="285" height="157" class="img-fluid mx-auto d-block brands-img mb-5">
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</section>

<section class="product-heading w-100 py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2 class="text-center m-0 p-0">
                    Exclusive products with special price
                </h2>
            </div>
        </div>
    </div>
</section>