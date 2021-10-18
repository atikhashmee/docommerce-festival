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
                      <li class="breadcrumb-item active" aria-current="page">Checkout</li>
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
            <div class="card">
                <div class="card-header">Orders</div>

                <div class="card-body p-0">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#SL</th>
                                <th>Order Number</th>
                                <th>Product Count</th>
                                <th>Payment</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($orders) > 0)
                                @foreach ($orders as $key => $order)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{strtotime($order->order_number)}}</td>
                                    <td>2</td>
                                    <td>Cash On</td>
                                    <td>{{$order->total_final_amount}}</td>
                                    <td>
                                        <button type="button" class="btn btn-success">Detail</button>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
