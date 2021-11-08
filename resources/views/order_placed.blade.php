@extends('layouts.app')

@section('title')
   Order Completed
@endsection

@section('content')
    
<section class="w-100 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route('index_page')}}" class="font-weight-bold"><i class="fas fa-home"></i> Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                    </ol>
                  </nav>
            </div>
        </div>
    </div>
</section>

<div class="main_content">
    <div class="section pt-0 pb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="text-center order_complete bg-white p-30">
                        <i style="font-size: 70px;color: #4caf50;"  class="fas fa-check-circle"></i>
                        <div class="heading_s1">
                          <h3>Your order is completed!</h3>
                        </div>
                        <a href="{{ route('index_page') }}" class="btn primary-button">Continue Shopping</a>
                        <a href="{{ route('order_detail_page', ['order_id' => Request::segment(2)]) }}" class="btn primary-button">View Detail</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
