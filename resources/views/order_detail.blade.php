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
                      <li class="breadcrumb-item"><a href="javascript:void(0)">Order</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Detail</li>
                    </ol>
                  </nav>
            </div>
        </div>
    </div>
</section>
 
 <div class="main_content">
     <div class="section py-2">
         <div class="container">
             <div class="row">
                <div class="col-md-4">
                    @include('web-components._user_nav')
                </div>
 
                <div class="col-md-8">
                     <div class="card">
                         <div class="card-header">Order Detail</div>
                         <div class="card-body" style="min-height: 260px;">
                             <div class="row">
                                 <div class="col-md-6">
                                     <p>
                                         @php
                                             $discount_amount = $order->discount_amount;
                                             $total_amount = $order->total_amount
                                         @endphp
                                         <strong class="order-line-height">Order Number : </strong> {{ strtotime($order->order_number) }} <br>
                                         <strong class="order-line-height">Order Date : </strong> {{ date('d M Y', strtotime($order->created_at)) }} <br>
                                         <strong class="order-line-height">Order Status : </strong> {{ $order->status }}<br>
                                         <strong class="order-line-height">Total Amount : </strong>{{ $order->cur_symb}}{{ $order->sub_total}}<br>
                                         <strong class="order-line-height">Total Discount : </strong> (-) $ {{ $order->discount_amount }}<br>
                                         <strong class="order-line-height">Total Amount : </strong>{{ $order->cur_symb}}{{ $order->total_amount }}<br>
                                         <strong class="order-line-height">Payment Type : </strong> Cash On<br>
                                     </p>
                                 </div>
                                 <div class="col-md-6">
                                     <h2>Address</h2>
                                     <address>
                                         @php
                                             $shipping = $order->address;
                                         @endphp
                                         @if(!empty($shipping))
                                             <strong class="order-line-height">Name : </strong> {{ $shipping->name }} <br>
                                             <strong class="order-line-height">Address 1 : </strong>{{ $shipping->address_line_1 }} <br>
                                             <strong class="order-line-height">Address 2 : </strong> {{ $shipping->address_line_2 }} <br>
                                           
                                                {{ $shipping->district_name }}
                                             {{ $shipping->state_name.', '. $shipping->zip_code?$shipping->zip_code.',':'' }}
                                             {{ $shipping->country_name }} <br>
                                             <strong class="order-line-height">Phone : </strong>{{ $shipping->phone }} <br>
                                             <strong class="order-line-height">Email : </strong>{{ $shipping->email }} <br>
                                        
                                         @endif
                                     </address>
                                 </div>
                             </div>
                         </div>
                     </div>
 
                     <div class="row">
                         <div class="col">
                             <div class="card">
                                 <div class="card-header">Order Items</div>
                                 <div class="card-body p-0">
                                     <table class="table table-bordered">
                                         <thead>
                                         <tr>
                                             <th>#SL</th>
                                             <th>Name</th>
                                             <th>Status</th>
                                             <th>Price</th>
                                             <th>Quantity</th>
                                             <th>Subtotal</th>
                                             <th>Discount</th>
                                             <th class="text-right">Total</th>
                                         </tr>
                                         </thead>
                                         @if(!empty($order->orderDetails))
                                             @foreach($order->orderDetails as $key => $detail)
                                               @php
                                                   
                                                   $subtotal = $detail->product_unit_price * $detail->quantity;
                                                   $supplier_total = 0;
                                               @endphp
                                                <tbody>
                                                    <tr>
                                                        <td>{{ $detail->id }}</td>
                                                        <td>
                                                            <div>
                                                                {{ $detail->product_name }}
                                                                <br>
                                                                @if(!empty($detail->productVariant))
                                                                    @if($detail->productVariant->opt1_name)
                                                                        (<strong>{{ $detail->productVariant->opt1_name }}:</strong> {{ $detail->productVariant->opt1_value }})<br>
                                                                    @endif
                                                                    @if($detail->productVariant->opt2_name)
                                                                        (<strong>{{ $detail->productVariant->opt2_name }}:</strong> {{ $detail->productVariant->opt2_value }})<br>
                                                                    @endif
                                                                    @if($detail->productVariant->opt3_name)
                                                                        (<strong>{{ $detail->productVariant->opt3_name }}:</strong> {{ $detail->productVariant->opt3_value }})<br>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td>  {{ $detail->status }}</td>
                                                        <td>{{ $order->cur_symb}} {{ $detail->product_unit_price }}
                                                            <br>
                                                            @if ($detail->additional_delivery_charge > 0)
                                                                ({{ $order->cur_symb}}  {{ $detail->additional_delivery_charge }})
                                                            @endif
                                                        </td>
                                                        <td>{{ $detail->product_quantity }}</td>
                                                        <td>{{ $subtotal }}</td>
                                                        <td> {{ $detail->discount_amount!=0?'-'.$detail->discount_amount:'N/A' }} </td>
                                                        <th class="text-right">{{ $order->cur_symb}}{{ $detail->total }}</th>
                                                    </tr>
                                                </tbody>
                                             @endforeach
                                         @endif
                                     </table>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
@endsection