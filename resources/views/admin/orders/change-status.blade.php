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
                            <strong class="order-line-height">Order&nbsp;ID : </strong> {{ strtotime($order->order_number) }} <br>
                            <strong class="order-line-height">Order&nbsp;Date : </strong> {{ dateFormat($order->created_at, 1) }} <br>
                            <strong class="order-line-height">Order&nbsp;Status : </strong> {{ $order->status }}<br>
                            <strong class="order-line-height">SubTotal : </strong> ৳{{ $order->sub_total}}<br>
                            <strong class="order-line-height">Discount&nbsp;Amount : </strong> (-)  ৳{{ $order->discount_amount }}<br>
                            <strong class="order-line-height">Total&nbsp;Amount : </strong> ৳{{ $order->total_amount + $order->total_shippings_charge }}<br>
                        </p>
                    </div>
                    <div class="col-md-4">
                        <h2>Order Address</h2>
                        <address>
                            @php
                                $shipping = $order->address;
                            @endphp
                            @if(!empty($shipping))
                                <strong class="order-line-height">Name  : </strong> {{ $shipping->name }} <br>
                                <strong class="order-line-height">Address : </strong>{{ $shipping->address_line_1 }}
                                @if($shipping->address_line_2)
                                    {{ $shipping->address_line_2 }} <br>
                                @endif
                                    {{ $shipping->district_name }}
                                {{ $shipping->state_name.', '. $shipping->zip_code?$shipping->zip_code.',':'' }}
                                {{ $shipping->country_name }} <br>
                                <strong class="order-line-height">Phone Number : </strong>{{ $shipping->phone }} <br>
                                <strong class="order-line-height">Email : </strong>{{ $shipping->email }} <br>
                            @else
                                {{ __('web.billing_address_message') }}<br>
                                <a href="{{ route('user.address') }}">{{ __('web.edit_address') }}</a>
                            @endif
                            <strong class="order-line-height">User : </strong> {{ $order->user->phone_number }}<br>
                        </address>
                    </div>
                    <div class="col-md-4">
                        <h2>Stores</h2>
                        <div style="overflow-y: scroll; max-height: 400px;">
                            @if (count($stores) > 0)
                                @foreach($stores as $storeData)
                                    <div class="storeAddress mt-4 p-3 bg-light shadow-sm">
                                        <p class="font-weight-bold;">{{$storeData[0]}}</p>
                                        <hr>
                                        <address class="mb-0">
                                            @php
                                                $store = $storeData[1] ?? null;
                                            @endphp
                                            @if(!empty($store))
                                                <strong class="order-line-height">Address : </strong>
                                                @if (isset($store['address_line_1']))
                                                    {{$store['address_line_1']}}
                                                    <br>
                                                @endif
                                                @if (isset($store['address_line_2']))
                                                    {{$store['address_line_2']}}
                                                    <br>
                                                @endif
                                                @if (isset($store['hotline_number']))
                                                    {{$store['hotline_number']}}
                                                    <br>
                                                @endif
                                                @if (isset($store['email']))
                                                    {{$store['email']}}
                                                    <br>
                                                @endif
                                            @endif
                                        </address>
                                    </div>
                                    
                                @endforeach
                            @endif
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
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    @php
                                        $subtotal_total = 0;
                                    @endphp
                                    @if(!empty($order->orderDetails))
                                        @foreach($order->orderDetails as $key => $detail)
                                          @php
                                              
                                              $subtotal = $detail->product_unit_price * $detail->product_quantity;
                                              $subtotal_total += $subtotal;
                                          @endphp
                                           <tbody>
                                               <tr>
                                                   <td>{{ $detail->id }}</td>
                                                   <td>
                                                       <div>
                                                           <a target="_blank" href="{{route('detail_page', ['slug' => $detail->product->slug])}}">{{ $detail->product_name }}</a>
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
                                                   <td>৳{{ $detail->product_unit_price }}
                                                       <br>
                                                       @if ($detail->additional_delivery_charge > 0)
                                                           (৳{{ $detail->additional_delivery_charge }})
                                                       @endif
                                                   </td>
                                                   <td>{{ $detail->product_quantity }}</td>
                                                   <td>৳{{ $subtotal }}</td>
                                                   <td> {{ $detail->discount_amount!=0?'-'.$detail->discount_amount:'N/A' }} </td>
                                                   <th class="text-right">৳{{ $detail->total }}</th>
                                                   <th>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Action
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a class="dropdown-item disabled"  @if (in_array($detail->status, ['Ready to Ship', 'Shipped', 'Delivered' ])) disabled @else onclick="changeStatus('In Progress', {{ $detail->id }})" @endif href="javascript:void(0)">In Progress</a>
                                                            <a class="dropdown-item"  @if (in_array($detail->status, ['Shipped', 'Delivered' ])) disabled @else onclick="changeStatus('Ready to Ship', {{ $detail->id }})" @endif href="javascript:void(0)">Ready To Ship</a>
                                                            <a class="dropdown-item"  @if (in_array($detail->status, ['Delivered' ])) disabled @else onclick="changeStatus('Shipped', {{ $detail->id }})" @endif href="javascript:void(0)">Shipped</a>
                                                            <a class="dropdown-item" onclick="changeStatus('Delivered', {{ $detail->id }})" href="javascript:void(0)">Delivered</a>
                                                        </div>
                                                    </div>
                                                   </th>
                                               </tr>
                                           </tbody>
                                        @endforeach
                                    @endif
                                    <tr>
                                        <td colspan="9" class="text-right">
                                            Total: ৳{{$subtotal_total}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="9" class="text-right">
                                            Shipping charge: (+) ৳{{$order->total_shippings_charge}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="9" class="text-right">
                                            Total Payable: ৳{{($subtotal_total+$order->total_shippings_charge)}}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function changeStatus(status, detail_id) {
        Swal.fire({
            title: 'Are you sure?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: `Yes, change it!`
        }).then((result) => {
            if (result.value) {
                updateStatus(status, detail_id);
            }
        });
    }

    function updateStatus(status, detail_id) {
        let formD = new FormData();
        formD.append("status", status);
        formD.append("detail_id", detail_id);
        fetch(`{{route("admin.order.update.status")}}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN' : `{{csrf_token()}}`,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formD
        }).then(res=>res.json())
        .then(res=>{
            if (!res.status) {
                let messages = '';
                if (typeof(res.data) === 'object') {
                    for (const [key, value] of Object.entries(res.data)) {
                        messages += '<li>' + value[0] + '</li>';
                    }
                } else {
                    messages = res.data;
                }

                Swal.fire({
                    type: 'error',
                    title: 'Whoops! Something went wrong!',
                    html: '    <div class="alert alert-danger">\n' +
                        '        <ul>\n' +
                        messages +
                        '        </ul>\n' +
                        '    </div>\n'
                });
            } else {
                window.location.reload()
            }
        })
    }
    
</script>
@endsection



