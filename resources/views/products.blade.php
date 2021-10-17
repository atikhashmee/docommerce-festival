@extends('layouts.app')

@section('content')
    <section class="w-100 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('index_page')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Store name</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="w-100 products-section py-6">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="left-linksDiv">
                        <h4>Categories</h4>

                        <ul class="categories-list">
                            @if (count($categories) > 0)
                                @foreach ($categories as $category)
                                    <li>
                                        <a href="{{route('category_page', ['category_id' => $category->id])}}">
                                            {{$category->name}} <i class="fas fa-angle-double-right"></i>
                                            <span>{{$category->total_products ?? 0}}</span>
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>

                        <hr>

                        <h4 class="mb-4">Sort by name</h4>

                        <ul class="list_brand">
                            <li>
                                <div class="custome-checkbox">
                                    <input class="form-check-input" type="checkbox" name="a-z" id="a-z">
                                    <label class="form-check-label" for="a-z"><span>A - Z</span></label>
                                </div>
                            </li>
                            <li>
                                <div class="custome-checkbox">
                                    <input class="form-check-input" type="checkbox" name="z-a" id="z-a">
                                    <label class="form-check-label" for="brand10"><span>Z - A</span></label>
                                </div>
                            </li>
                        </ul>

                        <hr>

                        <h4 class="mb-4">Sort by price</h4>

                        <ul class="list_brand">
                            <li>
                                <div class="custome-checkbox">
                                    <input class="form-check-input" type="checkbox" name="low-high" id="low-high">
                                    <label class="form-check-label" for="low-high"><span>Low - High</span></label>
                                </div>
                            </li>
                            <li>
                                <div class="custome-checkbox">
                                    <input class="form-check-input" type="checkbox" name="high-low" id="high-low">
                                    <label class="form-check-label" for="high-low"><span>High - Low</span></label>
                                </div>
                            </li>
                        </ul>

                    </div>
                    
                </div>

                <div class="col-md-9">
                    <div class="row justify-content-center">
                        @if (count($exclusives) > 0)
                            @foreach ($exclusives as $product)
                                <div class="col-md-4">
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

                    <div class="row justify-content-center">
                        @if (count($exclusives) > 0)
                            @foreach ($exclusives as $product)
                                <div class="col-md-4">
                                    @component('web-components._product', compact('product'))
                                        
                                    @endcomponent
                                </div>
                            @endforeach
                        @endif
                    </div>
                    
                </div>
            </div>

        </div>
    </section>

    @include('web-components._faq')
@endsection