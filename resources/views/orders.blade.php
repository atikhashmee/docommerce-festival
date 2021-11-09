@extends('layouts.app')

@section('content')
<section class="w-100 bg-light sticky-top sticky-offset">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route('index_page')}}" class="font-weight-bold"><i class="fas fa-home"></i> Home</a></li>
                      <li class="breadcrumb-item"><a href="javascript:void(0)">User</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Orders</li>
                    </ol>
                  </nav>
            </div>
        </div>
    </div>
</section>

<div class="main_content">
    <div class="section py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3 mb-4">
                    @include('web-components._user_nav')
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header"><h5 class="m-0">Orders</h5></div>

                        <div class="card-body p-0">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#SL</th>
                                        <th>Order Number</th>
                                        <th>Order Items</th>
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
                                            <td>{{$order->order_details_count}}</td>
                                            <td>Cash On</td>
                                            <td>৳{{$order->total_final_amount}}</td>
                                            <td>
                                                <a href="{{route('order_detail_page', ['order_id' => $order->id])}}" class="btn btn-outline-success">Detail</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            {{$orders->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
