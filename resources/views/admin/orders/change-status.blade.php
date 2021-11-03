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
                    <div class="col-md-6">
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
                    <div class="col-md-6">
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
                                        <th>Action</th>
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
                                                   <th>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Action
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a class="dropdown-item" onclick="changeStatus('In Progress', {{ $detail->id }})" href="javascript:void(0)">In Progress</a>
                                                            <a class="dropdown-item" onclick="changeStatus('Ready to Ship', {{ $detail->id }})" href="javascript:void(0)">Ready To Ship</a>
                                                            <a class="dropdown-item" onclick="changeStatus('Shipped', {{ $detail->id }})" href="javascript:void(0)">Shipped</a>
                                                            <a class="dropdown-item" onclick="changeStatus('Delivered', {{ $detail->id }})" href="javascript:void(0)">Delivered</a>
                                                        </div>
                                                    </div>
                                                   </th>
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



