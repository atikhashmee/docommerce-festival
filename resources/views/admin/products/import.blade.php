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
                <div class="d-flex">
                    <div class="d-flex" v-if="products.length > 0">
                        <div class="form-group">
                            <label for="">Fixed(1.00)</label>
                            <input type="number" @keyup="changePriceAll($event, 'fixed')">
                        </div>
                        <div class="form-group">
                            <label for="">Percentage(%)</label>
                            <input type="number" @keyup="changePriceAll($event, 'percen')">
                        </div>
                        <div class="form-group">
                            <label for="">Category</label>
                            <select name="category_id" @change="changeCategoryAll($event)">
                                <option value="">Select Category</option>
                                @if (count($categories) > 0)
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name ?? 'No Name'}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        
                        <button class="btn btn-success" @click="importStoredData()" type="button">Update</button>
                    </div>
                </div>
                <div class="search-form d-flex">
                    <select name="festival_id" id="festival_id" class="form-control" @change="changeFestival($event)">
                        <option value="">Select Festival</option>
                        @if (count($festivals) > 0)
                            @foreach ($festivals as $festival)
                                <option value="{{$festival->id}}">{{$festival->name ?? 'No Name'}} </option>
                            @endforeach
                        @endif
                    </select>
                    <select name="store_id" id="store_id" class="form-control" @change="changeStore($event)">
                        <option value="">Select Store</option>
                        <option v-for="str in selectedStore" :value="str.id">@{{str.name}}</option>
                    </select>
                </div>
            </form>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th class="massActionWrapper">
                                <button type="button" class="btn btn-xs btn-default checkbox-toggle" onclick="checkAll()">
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
                            <th>Product</th>
                            <th>Price</th>
                            <th>Update Price</th>
                            <th>Category</th>
                        </tr>
                        </thead>
                            <tbody v-if="products.length > 0">
                                <tr v-for="product in products">
                                    <td><input name="ids[]" type="checkbox" class="massCheck" @change="checkSpecific" :value="product.id"></td>
                                    <td>  
                                        {{-- <img :src="product.original_product_img" class="rounded" height="50" width="50"> --}}
                                        <h5>@{{ product.name }}</h5>
                                    </td>
                                    <td> 
                                        <span v-if="product.variants.length > 0">
                                            <a href="#">Change Product Price</a>
                                        </span>
                                        <span v-else>@{{ product.price }}</span>
                                    </td>
                                    <td>  
                                        <div v-if="product.variants.length > 0">
                                            <a href="#">Change Product Price</a>
                                        </div> 
                                        <div v-else>
                                            <table>
                                                <tr>
                                                    <td>Percentage (%)</td>
                                                    <td>
                                                        <input type="number" v-model="product.percentage"  @keyup="changePrice(product, 'percen')" placeholder="">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Fixed</td>
                                                    <td>
                                                        <input type="number" v-model="product.fixed"  @keyup="changePrice(product, 'fixed')" placeholder="">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>New Price</td>
                                                    <td>
                                                        <input type="number" v-model="product.new_price" placeholder="">
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                    <td>
                                        <select  v-model="product.category_id" class="form-control">
                                            <option value="">Select Category</option>
                                            @if (count($categories) > 0)
                                                @foreach ($categories as $category)
                                                    <option value="{{$category->id}}">{{$category->name ?? 'No Name'}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <h3>
                                            No Record Found
                                        </h3>
                                    </td>
                                </tr>
                            </tbody>
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
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <script>
        let app = new Vue({
            el: "#festivalTableContainer", 
            data: {
                selectedStore: [],
                products: []
            }, 
            methods: {
                changeFestival(dom) {
                    let url = `{{url("admin/stores/festival/")}}/${$("#festival_id").val()}`;
                    fetch(url)
                    .then(res=>res.json())
                    .then(res => {
                        if (res.length > 0) {
                            this.selectedStore = [...res]
                        }
                    })
                },
                changeStore(dom) {
                    let url = `{{url("admin/products/get-store-products/")}}/${$("#store_id").val()}`;
                    fetch(url)
                    .then(res=>res.json())
                    .then(res => {
                        if (res.length > 0) {
                            this.products = [...res]
                        }
                    })
                },
                checkSpecific() {

                },
                changePrice(prod, type) {
                    if (this.products.length > 0) {
                        this.products.forEach(element => {
                            if (Number(prod.original_product_id) === Number(element.original_product_id)) {
                                if (type === 'percen') {
                                    element.fixed = 0;
                                    let dataPrice = Number(element.price) - Number((element.percentage / 100 )  * Number(element.price))
                                    if (dataPrice > 0) {
                                        element.new_price = Number(dataPrice).toFixed(2)
                                    }
                                } else if (type === 'fixed') {
                                    element.percentage = 0
                                    let dataPrice =  Number(element.price) - Number(element.fixed)
                                    if (dataPrice > 0) {
                                        element.new_price =  Number(dataPrice).toFixed(2)
                                    }
                                }
                            }
                        });
                    }
                },
                changePriceAll(evt, type) {
                    let rateValue = Number(evt.currentTarget.value)
                    if (this.products.length > 0) {
                        this.products.forEach(element => {
                            if (type === 'percen') {
                                element.fixed = 0; element.percentage = rateValue
                                let dataPrice = Number(element.price) - Number((rateValue / 100 )  * Number(element.price))
                                if (dataPrice > 0) {
                                    element.new_price = Number(dataPrice).toFixed(2)
                                }
                            } else if (type === 'fixed') {
                                element.percentage = 0 
                                element.fixed = rateValue
                                let dataPrice =  Number(element.price) - Number(rateValue)
                                if (dataPrice > 0) {
                                    element.new_price =  Number(dataPrice).toFixed(2)
                                }
                            }
                        });
                    }
                },
                changeCategoryAll(evt) {
                    let category_id = Number(evt.currentTarget.value)
                    if (this.products.length > 0) {
                        this.products.forEach(element => {
                            element.category_id = category_id
                        });
                    }
                },
                importStoredData() {
                    let formD = new FormData();
                    formD.append('products', JSON.stringify(this.products))
                    formD.append('store_id', $("#store_id").val())
                    formD.append('festival_id', $("#festival_id").val())
                    fetch(`{{route("admin.product.import.store")}}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN' : `{{csrf_token()}}`,
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: formD
                    })
                    .then(res=>res.json())
                    .then(res=>{
                        console.log(res, 'asdf');
                    })
                }
            },
            watch: {

            }
        })
    </script>
@endsection


