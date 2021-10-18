@extends('layouts.app')

@section('content')
<section class="w-100 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route('index_page')}}">Home</a></li>
                      <li class="breadcrumb-item"><a href="javascript:void(0)">User</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                  </nav>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            @include('web-components._user_nav')
        </div>
        <div class="col-md-8">
            <div class="d-flex flex-wrap justify-content-between">
                <div class="card text-white bg-primary mb-3" style="flex-basis: 48%">
                    <div class="card-body">
                      <h5 class="card-title">Total Order</h5>
                      <p class="card-text">{{$total_order}}</p>
                    </div>
                  </div>
                  <div class="card text-white bg-success mb-3" style="flex-basis: 48%">
                    <div class="card-body">
                      <h5 class="card-title">Total Order Amount</h5>
                      <p class="card-text">${{$total_order_amount}}</p>
                    </div>
                  </div>
                  <div class="card text-white bg-danger mb-3" style="flex-basis: 48%">
                    <div class="card-body">
                      <h5 class="card-title">Last Ordered Products</h5>
                      <ul>
                        @foreach ($last_five_orders_product as $product)
                            <li>{{$product->name}}</li>
                        @endforeach
                      </ul>
                    </div>
                  </div>
            </div>
        </div>
    </div>
</div>
@endsection
