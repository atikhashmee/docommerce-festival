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
                      <li class="breadcrumb-item"><a href="javascript:void(0)">Order</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Detail</li>
                    </ol>
                  </nav>
            </div>
        </div>
    </div>
</section>
 
 <div class="main_content">
     <div class="section py-6">
         <div class="container">
             <div class="row">
                <div class="col-md-3 mb-4">
                    @include('web-components._user_nav')
                </div>
 
                <div class="col-md-9">
                     <div class="card mb-5">
                         <div class="card-header"><h5 class="m-0">Order Detail</h5></div>
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
                                         <strong class="order-line-height">Total Amount : </strong>???{{ $order->sub_total}}<br>
                                         <strong class="order-line-height">Total Discount : </strong> (-) ???{{ $order->discount_amount }}<br>
                                         <strong class="order-line-height">Total Amount : </strong>???{{ $order->total_amount }}<br>
                                         <strong class="order-line-height">Payment Type : </strong> Cash On<br>
                                     </p>
                                 </div>
                                 <div class="col-md-6">
                                     <h5>Address</h5>
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
                                 <div class="card-header"><h5 class="m-0">Order Items</h5></div>
                                 <div class="card-body p-0">
                                     <div class="table-responsive">
                                        <table class="table table-bordered m-0">
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
                                            @php
                                                $subtotal_total = 0;
                                            @endphp
                                            @if(!empty($order->orderDetails))
                                                @foreach($order->orderDetails as $key => $detail)
                                                  @php
                                                      $subtotal = $detail->product_unit_price * $detail->product_quantity;
                                                      $subtotal_total += $detail->total;
                                                  @endphp
                                                   <tbody>
                                                       <tr>
                                                           <td>{{ $detail->id }}</td>
                                                           <td>
                                                               <div>
                                                                   <strong>{{ $detail->product_name }}</strong>
                                                                   <br>
                                                                   @if(!empty($detail->product_variant_details))
                                                                       @if($detail->product_variant_details['opt1_name'] != null)
                                                                           (<strong>{{ $detail->product_variant_details['opt1_name'] }}:</strong> {{ $detail->product_variant_details['opt1_value'] }})<br>
                                                                       @endif
                                                                       @if($detail->product_variant_details['opt2_name'] != null)
                                                                           (<strong>{{ $detail->product_variant_details['opt2_name'] }}:</strong> {{ $detail->product_variant_details['opt2_value'] }})<br>
                                                                       @endif
                                                                       @if($detail->product_variant_details['opt3_name'] != null)
                                                                           (<strong>{{ $detail->product_variant_details['opt3_name'] }}:</strong> {{ $detail->product_variant_details['opt3_value'] }})<br>
                                                                       @endif
                                                                   @endif
                                                               </div>
                                                           </td>
                                                           <td>  {{ $detail->status }}</td>
                                                           <td>???{{ $detail->product_unit_price }}
                                                               <br>
                                                               @if ($detail->additional_delivery_charge > 0)
                                                                   (???{{ $detail->additional_delivery_charge }})
                                                               @endif
                                                           </td>
                                                           <td>{{ $detail->product_quantity }}</td>
                                                           <td>???{{ $subtotal }}</td>
                                                           <td> {{ $detail->discount_amount!=0?'-'.$detail->discount_amount:'N/A' }} </td>
                                                           <th class="text-right">???{{ $detail->total }}</th>
                                                       </tr>
                                                   </tbody>
                                                @endforeach
                                            @endif
                                            <tr>
                                                <td colspan="8" class="text-right">
                                                    Total: ???{{$subtotal_total}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="8" class="text-right">
                                                    Shipping charge: (+) ???{{$order->total_shippings_charge}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="8" class="text-right">
                                                    Total Payable: ???{{$subtotal_total+$order->total_shippings_charge}}
                                                </td>
                                            </tr>
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
 </div>
@endsection