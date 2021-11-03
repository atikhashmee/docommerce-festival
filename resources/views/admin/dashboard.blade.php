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
                    <h3 class="font-weight-bold m-0">{{$total_orders}}</h3>
                </div>
            </div>

            <div class="col-md-2">
                <div class="dashboard-glance dg2 rounded shadow p-4 mb-3">
                    <p class="mb-1">Today's Orders</p>
                    <h3 class="font-weight-bold m-0">{{$today_total_orders}}</h3>
                </div>
            </div>

            <div class="col-md-2">
                <div class="dashboard-glance dg3 rounded shadow p-4 mb-3">
                    <p class="mb-1">Total Sales</p>
                    <h3 class="font-weight-bold m-0">৳{{$total_sales}}</h3>
                </div>
            </div>

            <div class="col-md-2">
                <div class="dashboard-glance dg4 rounded shadow p-4 mb-3">
                    <p class="mb-1">Today's Sales</p>
                    <h3 class="font-weight-bold m-0">৳{{$today_total_sales}}</h3>
                </div>
            </div>

            <div class="col-md-2">
                <div class="dashboard-glance dg5 rounded shadow p-4 mb-3">
                    <p class="mb-1">Pending Orders</p>
                    <h3 class="font-weight-bold m-0">{{$pending_orders}}</h3>
                </div>
            </div>

        </div>

    </section>

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
                            @if (count($top_five_stores) > 0)
                                @foreach ($top_five_stores as $key1 => $stor)
                                    <tr>
                                        <td>{{++$key1}}</td>
                                        <td>{{$stor->name}}</td>
                                        <td>{{$stor->total_orders}}</td>
                                        <td>৳7000</td>
                                    </tr>
                                @endforeach
                            @endif
                           
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
                            @if (count($top_five_products) > 0)
                                @foreach ($top_five_products as $key => $pro)
                                    <tr>
                                        <td>{{++$key}}</td>
                                        <td>{{$pro->name}}</td>
                                        <td>{{$pro->store->name ?? 'N/A'}}</td>
                                        <td>{{$pro->total_freq}}</td>
                                    </tr>
                                @endforeach
                            @endif
                            
                        </tbody>
                    </table>
                </div>

                <p class="text-right py-3">
                    <a href="#" class="text-danger">* Order complaints</a>
                </p>
                
            </div>
        </div>

        <div class="row py-5">
            <div class="col-md-6">
                <h3 class="mb-3 font-weight-bold">Orders Volume</h3>
                <div class="graphsDiv">
                    <canvas id="tOrders" width="400" height="400"></canvas>
                </div>
            </div>

            <div class="col-md-6">
                <h3 class="mb-3 font-weight-bold">Sales Volume (in thousands)</h3>
                <div class="graphsDiv">
                    <canvas id="tSales" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const ctx = document.getElementById('tOrders');
        const ctx2 = document.getElementById('tSales');

        const tOrders = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Nov 11","Nov 12","Nov 13","Nov 14","Nov 15","Nov 16","Nov 17","Nov 18"],
                datasets: [{
                    label: 'Orders Volume',
                    data: ["11","25","30","20","35","55","80","215"],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });


        const tSales = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ["Nov 11","Nov 12","Nov 13","Nov 14","Nov 15","Nov 16","Nov 17","Nov 18"],
                datasets: [{
                    label: 'Sales Volume (in thousands)',
                    data: ["5","15","35","45","25","40","75","125"],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
@endsection
