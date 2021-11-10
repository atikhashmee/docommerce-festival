@extends('layouts.app')

@section('content')
    <section class="w-100 bg-light sticky-top sticky-offset">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('index_page')}}" class="font-weight-bold"><i class="fas fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Bulk Orders</li>
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
                    <form action="{{route("bulk_order_post_page")}}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{$product->id}}" >
                        <div class="form-group">
                            <label for="">Product Name</label>
                            <input type="text" readonly name="product_name" class="form-control" value="{{$product->name}}">
                            @error('product_name')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Product Quantity <span class="text-danger">*</span> </label>
                            <input type="text" name="product_quantity" class="form-control" value="{{old('product_quantity')}}">
                            @error('product_quantity')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="full_name" class="form-control"  value="{{old('full_name')}}">
                            @error('full_name')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Mobile Number <span class="text-danger">*</span></label>
                            <input type="text" name="mobile_number" class="form-control" value="{{old('mobile_number')}}">
                            @error('mobile_number')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="text" name="email" class="form-control" value="{{old('email')}}">
                            @error('email')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Address</label>
                            <input type="text" name="address" class="form-control" value="{{old('address')}}">
                        </div>
                        <div class="form-group">
                            <label for="">Business Name</label>
                            <input type="text" name="business_name" class="form-control" value="{{old('business_name')}}">
                        </div>
                        <div class="form-group">
                            <label for="">Business Address</label>
                            <input type="text" name="business_address" class="form-control" value="{{old('business_address')}}">
                        </div>
                        <small>(* Mark Fields are Mandatory)</small> <br>
                        <button type="submit" class="btn btn-primary">Submit Your Order</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
@endsection