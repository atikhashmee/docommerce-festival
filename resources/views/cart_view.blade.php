@extends('layouts.app')

@section('content')
    <section class="w-100 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('index_page')}}" class="font-weight-bold"><i class="fas fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Cart</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="w-100 products-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive shop_cart_table">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody id="cart_list_page">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row justify-content-end mt-4">
                <div class="col-md-6">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th colspan="2">
                                        Cart Totals
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <p>Cart Subtotal</p>
                                    </td>
                                    <td>
                                        <p>৳<span id="cart_sub_total_page">0.00</span> </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="font-weight-bold">Total</p>
                                    </td>
                                    <td>
                                        <p class="font-weight-bold">৳<span id="cart_total_page">0.00</span></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="right">
                                        <a href="{{route('checkout_page')}}" class="btn btn-success">Proceed to checkout</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('web-components._faq')
@endsection