@extends('layouts.app')

@section('content')
    <section class="w-100 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('index_page')}}">Home</a></li>
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
                            <tbody>
                                <tr>
                                    <td>
                                        <img src="assets/images/products/1.png" alt="products" class="cart-product-img">
                                    </td>
                                    <td>
                                        <p class="product_name">American Garden Original BBQ Sauce</p>
                                    </td>
                                    <td>
                                        <p class="product_price">৳135.00</p>
                                    </td>
                                    <td>
                                        <div class="input-group plus-minus-input w-150">
                                            <div class="input-group-button">
                                                <button type="button" class="button hollow circle" data-quantity="minus" data-field="quantity">
                                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                            <input class="input-group-field" type="number" name="quantity" value="1">
                                            <div class="input-group-button">
                                                <button type="button" class="button hollow circle" data-quantity="plus" data-field="quantity">
                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                </button>
                                            </div>
        
                                        </div> 
                                    </td>
                                    <td>
                                        <p class="product_price">৳135.00</p>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger">
                                            <i class="fa fa-times"></i> Remove
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <img src="assets/images/products/2.png" alt="products" class="cart-product-img">
                                    </td>
                                    <td>
                                        <p class="product_name">American Garden Original BBQ Sauce</p>
                                    </td>
                                    <td>
                                        <p class="product_price">৳135.00</p>
                                    </td>
                                    <td>
                                        <div class="input-group plus-minus-input">
                                            <div class="input-group-button">
                                                <button type="button" class="button hollow circle" data-quantity="minus" data-field="quantity">
                                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                            <input class="input-group-field" type="number" name="quantity" value="5">
                                            <div class="input-group-button">
                                                <button type="button" class="button hollow circle" data-quantity="plus" data-field="quantity">
                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                </button>
                                            </div>
        
                                        </div> 
                                    </td>
                                    <td>
                                        <p class="product_price">৳135.00</p>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger">
                                            <i class="fa fa-times"></i> Remove
                                        </button>
                                    </td>
                                </tr>
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
                                        <p>৳270.00</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="font-weight-bold">Total</p>
                                    </td>
                                    <td>
                                        <p class="font-weight-bold">৳270.00</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="right">
                                        <a href="#" class="btn btn-success">Proceed to checkout</a>
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