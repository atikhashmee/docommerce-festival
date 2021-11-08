@extends('layouts.admin')

@section('title')
    order Detail
@endsection

@section('content')
    <section class="container-fluid" id="festivalTableContainer">
        <div class="card">
            <div class="card-header">
                <a href="{{ route("admin.orders.index") }}" class="btn btn-primary"> <i class="fas fa-angle-double-left"></i> Back </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <p>
                            @php
                                $discount_amount = $order->discount_amount;
                                $total_amount = $order->total_amount
                            @endphp
                            <strong class="order-line-height">Order&nbsp;ID : </strong> {{ $order->order_number }} <br>
                            <strong class="order-line-height">Order&nbsp;Date : </strong> {{ date('d M Y', strtotime($order->created_at)) }} <br>
                            <strong class="order-line-height">Order&nbsp;Status : </strong> {{ $order->status }}<br>
                            <strong class="order-line-height">SubTotal : </strong> {{ $order->sub_total}}<br>
                            <strong class="order-line-height">Discount&nbsp;Amount : </strong> (-)  {{ $order->discount_amount }}<br>
                            <strong class="order-line-height">Total&nbsp;Amount : </strong> {{ $order->total_amount }}<br>
                        </p>
                    </div>
                    <div class="col-md-4">
                        <h2>Order Address</h2>
                        <address>
                            @php
                                $shipping = $order->address;
                            @endphp
                            @if(!empty($shipping))
                                <strong class="order-line-height">{{ __('web.name') }} : </strong> {{ $shipping->name }} <br>
                                <strong class="order-line-height">{{ __('web.address') }} : </strong>{{ $shipping->address_line_1 }}
                                @if($shipping->address_line_2)
                                    {{ $shipping->address_line_2 }} <br>
                                @endif
                                    {{ $shipping->district_name }}
                                {{ $shipping->state_name.', '. $shipping->zip_code?$shipping->zip_code.',':'' }}
                                {{ $shipping->country_name }} <br>
                                <strong class="order-line-height">{{ __('web.phone_number') }} : </strong>{{ $shipping->phone }} <br>
                                <strong class="order-line-height">{{ __('web.email') }} : </strong>{{ $shipping->email }} <br>
                            @else
                                {{ __('web.billing_address_message') }}<br>
                                <a href="{{ route('user.address') }}">{{ __('web.edit_address') }}</a>
                            @endif
                        </address>
                    </div>
                    <div class="col-md-4">
                        <h2>Store Address</h2>
                        <address>
                            @php
                                $shipping = $order->address;
                            @endphp
                            @if(!empty($shipping))
                                <strong class="order-line-height">{{ __('web.name') }} : </strong> {{ $shipping->name }} <br>
                                <strong class="order-line-height">{{ __('web.address') }} : </strong>{{ $shipping->address_line_1 }}
                                @if($shipping->address_line_2)
                                    {{ $shipping->address_line_2 }} <br>
                                @endif
                                    {{ $shipping->district_name }}
                                {{ $shipping->state_name.', '. $shipping->zip_code?$shipping->zip_code.',':'' }}
                                {{ $shipping->country_name }} <br>
                                <strong class="order-line-height">{{ __('web.phone_number') }} : </strong>{{ $shipping->phone }} <br>
                                <strong class="order-line-height">{{ __('web.email') }} : </strong>{{ $shipping->email }} <br>
                            @else
                                {{ __('web.billing_address_message') }}<br>
                                <a href="{{ route('user.address') }}">{{ __('web.edit_address') }}</a>
                            @endif
                        </address>
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
    </section>
@endsection


