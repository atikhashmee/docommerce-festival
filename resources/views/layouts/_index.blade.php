
<section class="w-100 festive-name">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="name-inner p-3 shadow-sm">
                    <h1 class="text-center m-0 p-0">
                        DoCommerce ১১-১১ ফেস্টিভ্যাল ২০২১
                    </h1>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="w-100 stores-section py-6">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <p class="intro-p text-center">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Officiis corrupti ipsa enim blanditiis distinctio cupiditate exercitationem expedita ut libero. Aliquam aspernatur facilis adipisci illum! Facere earum sapiente corporis non odio!
                </p>

                <h2 class="intro-h2 text-center text-uppercase py-4">
                    Enjoy upto 70% discount from bestsellers
                </h2>
            </div>
        </div>

        <div class="row justify-content-center py-4">
            @if (count($stores) > 0)
                @foreach ($stores as $store)
                    <div class="col-md-2">
                        <a href="{{route('store_page', ['store_id' => $store->id])}}">
                            <img src="{{$store->store_logo_url}}" alt="{{$store->name}}" width="285" height="157" class="img-fluid mx-auto d-block brands-img mb-5">
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>

<section class="product-heading w-100 py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2>
                    Exclusive products with special price
                </h2>
            </div>
        </div>
    </div>
</section>