@extends('layouts.app')

@section('content')
    
<section class="w-100 bg-light sticky-top sticky-offset">
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


<section class="w-100 products-section py-5">
    <form  id="checkout_form">
        <div class="px-4">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <h5>Your Orders</h5>
                    <div class="table-responsive p-3 bg-white rounded mt-4 shadow-sm">
                        <table class="table table-bordered checkout-tbl">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Discount</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody id="checkout_page_lists">
                                
                            </tbody>
                        </table>
                    </div>

                    {{-- <h5 class="mt-4">Select Shipping</h5>
                    <form action="">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="shipping_type" id="shipping_type1" value="৳100.00 Inside Dhaka">
                            <label class="form-check-label" for="shipping_type1">
                                ৳100.00 Inside Dhaka
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="shipping_type" id="shipping_type2" value="৳120.00 Outside Dhaka">
                            <label class="form-check-label" for="shipping_type2">
                                ৳120.00 Outside Dhaka
                            </label>
                        </div>
                    </form> --}}
                </div>

                <div class="col-md-6">
                    <h5>Shipping Address</h5>
                    <div class="address-div p-3 bg-white rounded mt-4 shadow-sm">
                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group name_group">
                                <input type="text" name="name"  placeholder="Name *" class="form-control"></div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group state_id_group">
                                <div class="custom_select ">
                                    <select name="state_id" id="state_id" class="form-control">
                                        <option value="">Select Region</option>
                                        @if (count($states) > 0)
                                            @foreach ($states as $state)
                                                <option value="{{ $state->id }}" @if($state->id == 6) selected @else disabled @endif>{{ $state->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group city_group">
                                <div class="custom_select ">
                                    <select name="district_id" id="district_id" class="form-control">
                                        <option value="">Select District</option>
                                    </select>
                                </div>
                                <small class="text-danger">(* Current festival is only delivered to Dhaka)</small>
                            </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="address_line_1"  placeholder="Address *" class="form-control"></div>
                                </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="address_line_2" placeholder="Address line2" class="form-control"></div>
                                </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="zip_code"  placeholder="Postcode / ZIP *" class="form-control"></div>
                                </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="phone"  placeholder="Phone *" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="email"  placeholder="Email address" class="form-control">
                                </div>
                            </div>
                            {{-- <div class="col-md-6 col-sm-12 col-xm-12"><a href="javascript:void(0)" class="btn btn-outline-secondary change-address-btn">Change address</a></div> --}}
                        </div>
                    </div>
                    {{-- <div class="w-100 p-3 bg-white rounded mt-4 shadow-sm">
                        <p class="voucher_swt m-0">
                        <i class="fas fa-tag"></i> Have a coupon? <a href="#coupon" data-toggle="collapse" aria-expanded="false" class="collapsed">Click here to enter your code</a></span>
                        </p>
                        <div id="coupon" class="panel-collapse coupon_form collapse mt-3">
                            <div class="panel-body">
                            <div>
                                <div class="coupon field_form input-group">
                                    <input type="text" placeholder="Enter Coupon Code.." class="form-control form-control-sm"> 
                                    <div class="input-group-append"><button type="button" class="btn btn-outline-success btn-sm">Apply Coupon</button></div>
                                </div>
                                <span class="text-danger" style="display: none;">Invalid Code</span> <span class="text-sucess" style="display: none;"></span>
                            </div>
                            </div>
                        </div>
                    </div> --}}

                    <div class="w-100 p-3 bg-white rounded mt-4 shadow-sm">
                        <h5>Payment</h5>
                        <div class="payment_option d-flex flex-wrap">
                            <div class="custome-radio flex-fill">
                            <input type="radio" name="payment_option" id="exampleRadios1" class="form-check-input" value="cash_on">
                            <label for="exampleRadios1" class="form-check-label"><span>Cash On</span></label>
                            </div>
                        </div>
                    </div>

                    <div class="w-100 p-3 bg-white rounded mt-4 shadow-sm">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td>
                                            <p>Cart Subtotal</p>
                                        </td>
                                        <td>
                                            <p>৳ <span id="cart_sub_total_page">0</span></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="font-weight-bold">Total</p>
                                        </td>
                                        <td>
                                            <p class="font-weight-bold">৳ <span id="cart_total_page">0</span></p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @guest
                        <a href="{{route('login')}}" class="btn btn-success mt-4 float-right">Place Order</a>
                    @else
                        <button type="button" onclick="placeOrder()" class="btn btn-success mt-4 float-right">Place Order</button>
                    @endguest
                    <div id="error_msg" class="text-danger d-none"></div>
                    <div id="success_msg" class="text-success d-none"></div>
                </div>
            </div>
        </div>
    </form>
</section>

@endsection
@section('scripts')
<script>
    getDistrict(<?=json_encode($districts)?>)
</script>

@endsection