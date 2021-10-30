@extends('layouts.admin')

@section('title')
    Stores
@endsection

@section('content')
    <section class="container-fluid" id="festivalTableContainer">
        <div class="d-flex flex-row flex-row-reverse">
            <a href="{{route('admin.products.index')}}" class="btn btn-success">Back</a>
        </div>
        <div class="card">
            <form action="{{route('admin.product.import')}}" method="GET" id="filter_form" class="card-header d-flex justify-content-between">
                <div class="d-flex"></div>
                <div class="search-form d-flex">
                    <select name="festival_id" id="festival_id" class="form-control" onchange="changeFestival(this)">
                        <option value="">Select Festival</option>
                        @if (count($festivals) > 0)
                            @foreach ($festivals as $festival)
                                <option value="{{$festival->id}}">{{$festival->name ?? 'No Name'}} </option>
                            @endforeach
                        @endif
                    </select>
                    <select name="store_id" id="store_id" class="form-control">
                        <option value="">Select Store</option>
                    </select>
                    <button class="btn btn-success" id="searchButton">Find</button>
                </div>
            </form>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th class="massActionWrapper">
                                <button type="button" class="btn btn-xs btn-default checkbox-toggle"
                                        onclick="checkAll()">
                                    <input type="checkbox" name="select_all" class="hidden">
                                    <i id="check-all-icon" class="fa fa-square-o" data-toggle="tooltip"
                                       data-placement="top" title="Select All"></i>
                                </button>
                                <div class="dropdown all-check d-none">
                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span id="count"></span> Items Selected
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="attachToFestival()">Attach to festival</a>
                                    </div>
                                </div>
                            </th>
                            <th>#SL</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Update Price</th>
                            <th>Category</th>
                        </tr>
                        </thead>
                        @if (count($products) > 0)
                            <tbody>
                                @foreach ($products as $key => $item)
                                    <tr>
                                        <td><input name="ids[]" type="checkbox" class="massCheck" @change="checkSpecific" value="{{$item->id}}"></td>
                                        <td>{{ ++$key }}</td>
                                        <td>  
                                            <img src="{{ $item->original_product_img }}" class="rounded" height="50" width="50">
                                            <h5>{{ $item->name }}</h5>
                                        </td>
                                        <td>  {{ $item->price }}</td>
                                        <td>  
                                            <table>
                                                <tr>
                                                    <td>Percentage (%)</td>
                                                    <td>
                                                        <input type="number" placeholder="">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Fixed</td>
                                                    <td>
                                                        <input type="number" placeholder="">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>New Price</td>
                                                    <td>
                                                        <input type="number" placeholder="">
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>
                                            <select name="category_id" id="category_id" class="form-control">
                                                <option value="">Select Category</option>
                                                @if (count($categories) > 0)
                                                    @foreach ($categories as $category)
                                                        <option value="{{$category->id}}">{{$category->name ?? 'No Name'}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @else
                            <tbody>
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <h3>
                                            No Record Found
                                        </h3>
                                    </td>
                                </tr>
                            </tbody>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('styles')
    <style>
      
    </style>
@endsection
@section('scripts')
    <script>
        function changeFestival(dom) { 
            let url = `{{url("admin/stores/festival/")}}/${dom.value}`;
            fetch(url)
            .then(res=>res.json())
            .then(res => {
                let txt = `<option value="">Select Store</option>`;
                if (res.length > 0) {
                    res.forEach(element => {
                        txt += `<option value="${element.id}">${element.name}</option>`;
                    });
                }
                document.querySelector("#store_id").innerHTML = txt;
            })
        }
    </script>
@endsection


