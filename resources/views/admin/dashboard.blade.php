@extends('layouts.admin')

@section('content')
    <section class="container-fluid py-3">
        <div class="row">
            <div class="col-md-12">
                <img src="{{asset('web_assets/images/do-commerce-logo.png')}}" alt="DoCommerce" class="img-fluid mx-auto d-block festive-logo">
                <h3 class="text-center m-0 py-3 font-weight-bold">11-11 Festival 2021</h3>
            </div>
        </div>

        <div class="row justify-content-center mt-5">
            <div class="col-md-2">
                <div class="dashboard-glance dg1 rounded shadow p-4 mb-3">
                    <p class="mb-1">Total Orders</p>
                    <h3 class="font-weight-bold m-0">500</h3>
                </div>
            </div>

            <div class="col-md-2">
                <div class="dashboard-glance dg2 rounded shadow p-4 mb-3">
                    <p class="mb-1">Today's Orders</p>
                    <h3 class="font-weight-bold m-0">30</h3>
                </div>
            </div>

            <div class="col-md-2">
                <div class="dashboard-glance dg3 rounded shadow p-4 mb-3">
                    <p class="mb-1">Total Sales</p>
                    <h3 class="font-weight-bold m-0">৳150000</h3>
                </div>
            </div>

            <div class="col-md-2">
                <div class="dashboard-glance dg4 rounded shadow p-4 mb-3">
                    <p class="mb-1">Today's Sales</p>
                    <h3 class="font-weight-bold m-0">৳2000</h3>
                </div>
            </div>

            <div class="col-md-2">
                <div class="dashboard-glance dg5 rounded shadow p-4 mb-3">
                    <p class="mb-1">Pending Orders</p>
                    <h3 class="font-weight-bold m-0">14</h3>
                </div>
            </div>

        </div>

    </section>
<<<<<<< HEAD

    <div class="container">
        <div class="row py-5">
            <div class="col-md-6">
                <h3 class="mb-3 font-weight-bold">Top 5 Stores</h3>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Name</th>
                                <th>Total Orders</th>
                                <th>Total Sales</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Abc</td>
                                <td>40</td>
                                <td>৳7000</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Def</td>
                                <td>35</td>
                                <td>৳6000</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Ghi</td>
                                <td>32</td>
                                <td>৳5800</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Jkl</td>
                                <td>28</td>
                                <td>৳5500</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Mno</td>
                                <td>25</td>
                                <td>৳4000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-6">
                <h3 class="mb-3 font-weight-bold">Top 5 Products</h3>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Product Name</th>
                                <th>Store</th>
                                <th>Total Orders</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Figaro Pitted Green Olives</td>
                                <td>Abc</td>
                                <td>100</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Foodex Sriracha Chili Sauce</td>
                                <td>Xyz</td>
                                <td>20</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Hershey Caramel Syrup</td>
                                <td>Ghi</td>
                                <td>19</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Hosen sweet Corn</td>
                                <td>Abc</td>
                                <td>18</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Cadbury Cocoa Powder</td>
                                <td>Def</td>
                                <td>15</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <p class="text-right py-3">
                    <a href="#" class="text-danger">* Order complaints</a>
                </p>
                
            </div>
        </div>
    </div>
@endsection
=======
@endsection
>>>>>>> 9dc88e31a008380085a2cf1c7d4c7ddfef1a16f7
