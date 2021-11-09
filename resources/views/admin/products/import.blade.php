@extends('layouts.admin')

@section('title')
    Stores
@endsection

@section('content')
    <section class="container-fluid" id="festivalTableContainer">
        <div class="d-flex flex-row flex-row-reverse mb-4">
            <a href="{{route('admin.products.index')}}" class="btn btn-primary btn-sec"><i class="fas fa-angle-double-left"></i> Back</a>
        </div>
        <div class="card">
            <form action="{{route('admin.product.import')}}" method="GET" id="filter_form" class="card-header d-flex justify-content-between">
                <div class="">
                    <div class="d-flex align-items-start" v-if="products.length > 0">
                        <div class="form-group custom-price-group d-inline-block">
                            <label for="">Fixed(1.00)</label>
                            <input type="number" value="0" id="fixed_all" @keyup="changePriceAll($event, 'fixed')">
                        </div>
                        <div class="form-group custom-price-group d-inline-block">
                            <label for="">Percentage(%)</label>
                            <input type="number" value="0" id="percent_all" @keyup="changePriceAll($event, 'percen')">
                        </div>
                        <div class="form-group d-inline-block mr-2">
                            <!-- <label for="">Category</label> -->
                            <select name="category_id" class="form-control" @change="changeCategoryAll($event)">
                                <option value="">Select Category</option>
                                @if (count($categories) > 0)
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name ?? 'No Name'}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        
                        <button class="btn btn-primary" @click="importStoredData()" type="button">Save Changes</button>
                    </div>
                </div>
                <div class="search-form d-flex">
                    <select name="store_id" id="store_id" class="form-control" @change="changeStore($event)">
                        <option value="">Select Store</option>
                        @foreach ($stores as $store)
                            <option  value="{{$store->original_store_id}}">{{$store->name}}</option>
                        @endforeach
                    </select>
                </div>
            </form>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th class="massActionWrapper" width="66px">
                                <button type="button" class="btn btn-xs btn-default checkbox-toggle p-0" @click="checkAll()">
                                    <input type="checkbox" name="select_all" class="hidden">
                                    <i id="check-all-icon" class="fa fa-square-o" data-toggle="tooltip"
                                       data-placement="top" title="Select All"></i>
                                </button>
                                <div class="dropdown all-check d-none">
                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span id="count">@{{selectedProduct.length}}</span> Items Selected
                                    </button>
                                    {{-- <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="attachToFestival()">Attach to festival</a>
                                    </div> --}}
                                </div>
                            </th>
                            <th>Store Product ID</th>
                            <th>Product</th>
                            <th>Stock</th>
                            <th>Price</th>
                            <th>Update Price</th>
                            <th>Category</th>
                        </tr>
                        </thead>
                            <tbody v-if="products.length > 0">
                                <tr v-for="product in products">
                                    <td><input name="ids[]" type="checkbox" class="massCheck" v-model="selectedProduct" @change="checkSpecific($event)" :value="product.original_product_id"></td>
                                    <td>
                                        <h5>@{{ product.original_product_id }}</h5>
                                    </td>
                                    <td>  
                                        {{-- <img :src="product.original_product_img" class="rounded" height="50" width="50"> --}}
                                        <h5>@{{ product.name }}</h5>
                                    </td>
                                    <td>
                                        <div v-if="product.variants.length > 0">
                                            <a href="javascript:void(0)" @click="openModal(product)">Change Product Quantity</a>
                                        </div> 
                                        <div v-else>
                                            <input type="number" class="form-control" v-model="product.quantity" placeholder="">
                                        </div>
                                    </td>
                                    <td> 
                                        <span v-if="product.variants.length > 0">
                                            <a href="javascript:void(0)" @click="openModal(product)">Change Product Price</a>
                                        </span>
                                        <span v-else>@{{ product.price }}</span>
                                    </td>
                                    <td>  
                                        <div v-if="product.variants.length > 0">
                                            <a href="javascript:void(0)" @click="openModal(product)">Change Product Price</a>
                                        </div> 
                                        <div v-else>
                                            <table>
                                                <tr>
                                                    <td>Percentage (%)</td>
                                                    <td>
                                                        <input type="number" class="form-control" v-model="product.percentage"  @keyup="changePrice(product, 'percen')" placeholder="">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Fixed</td>
                                                    <td>
                                                        <input type="number" class="form-control" v-model="product.fixed"  @keyup="changePrice(product, 'fixed')" placeholder="">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>New Price</td>
                                                    <td>
                                                        <input type="number" class="form-control" readonly v-model="product.new_price" placeholder="">
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
                                    <td colspan="7" class="text-center">
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
          <!-- Modal -->
  <div class="modal fade" id="variantmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Change Variants Product</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="d-flex">
                <div class="form-group custom-price-group">
                    <label for="">Fixed(1.00)</label>
                    <input type="number" value="0" id="fixed_all_var" @keyup="changePriceAll($event, 'fixed', true)">
                </div>
                <div class="form-group custom-price-group">
                    <label for="">Percentage(%)</label>
                    <input type="number" value="0" id="percent_all_var" @keyup="changePriceAll($event, 'percen', true)">
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Update Price</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="vr_p in variants_products">
                        <td>@{{vr_p.product_name}}</td>
                        <td>@{{vr_p.product_price}}</td>
                        <td><input type="number" v-model="vr_p.quantity" class="form-control"></td>
                        <td>
                            <table>
                                <tr>
                                    <td>Percentage (%)</td>
                                    <td>
                                        <input type="number" class="form-control" v-model="vr_p.percentage"  @keyup="changePrice(vr_p, 'percen', true)" placeholder="">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Fixed</td>
                                    <td>
                                        <input type="number" class="form-control" v-model="vr_p.fixed"  @keyup="changePrice(vr_p, 'fixed', true)" placeholder="">
                                    </td>
                                </tr>
                                <tr>
                                    <td>New Price</td>
                                    <td>
                                        <input type="number" class="form-control" readonly v-model="vr_p.new_price" placeholder="">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" @click="updateVariantPrice()">Save changes</button>
        </div>
      </div>
    </div>
  </div>
    </section>
@endsection
@section('modals')
   
@endsection
@section('styles')
    <style>
        /* For Firefox */
        input[type='number'] {
            -moz-appearance:textfield;
        }
        /* Webkit browsers like Safari and Chrome */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        .custom-price-group {
            border: 1px solid #d4a9df;
            border-radius: 4px;
            background: #fff;
            padding: 0px 10px;
            margin-right: 10px;
            width: 120px;
        }
        .custom-price-group label{
            margin: 0 auto;
            width: 100%;
            color: rgba(0,0,0,0.5);
            font-size: 80%;
        }
        .custom-price-group input{
            outline: none;
            border: none;
            width: 100%;
        }
    </style>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <script>
        let app = new Vue({
            el: "#festivalTableContainer", 
            data: {
                products: [],
                variants_products: [],
                selectedProduct: [],
            }, 
            methods: {
                changeStore(dom) {
                    if (dom.currentTarget.value) {
                        $('.loader-div').show();
                        let url = `{{url("admin/products/get-store-products/")}}/${$("#store_id").val()}`;
                        fetch(url)
                        .then(res=>res.json())
                        .then(res => {
                            $('.loader-div').hide();
                            if (res.length > 0) {
                                this.products = [...res]
                            }
                        })
                    }
                },
                checkSpecific(obj) {
                    if ($(obj).prop('checked')) {
                        
                    }
                    this.checkItem()
                    console.log(this.selectedProduct, 'asdf');
                },
                changePrice(prod, type, isVariant=false) {
                    if (isVariant) {
                        if (this.variants_products.length > 0) {
                            this.variants_products.forEach( item => {
                                if (Number(item.id) === Number(prod.id)) {
                                    if (type === 'percen') {
                                        item.fixed = 0;
                                        let dataPrice = Number(item.product_price) - Number((item.percentage / 100 )  * Number(item.product_price))
                                        if (dataPrice > 0) {
                                            item.new_price = Number(dataPrice).toFixed(2)
                                        }
                                    } else if (type === 'fixed') {
                                        item.percentage = 0
                                        let dataPrice =  Number(item.product_price) - Number(item.fixed)
                                        if (dataPrice > 0) {
                                            item.new_price =  Number(dataPrice).toFixed(2)
                                        }
                                    }
                                }
                            }) 
                        }
                    } else {
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
                    }
                },
                changePriceAll(evt, type, isVariant=false) {
                    let rateValue = Number(evt.currentTarget.value)
                    if (isVariant) {
                        if (this.variants_products.length > 0) {
                            this.variants_products.forEach( item => {
                                if (type === 'percen') {
                                    document.querySelector('#fixed_all_var').value = 0;
                                    item.fixed = 0; item.percentage = rateValue
                                    let dataPrice = Number(item.product_price) - Number((rateValue / 100 )  * Number(item.product_price))
                                    if (dataPrice > 0) {
                                        item.new_price = Number(dataPrice).toFixed(2)
                                    }
                                } else if (type === 'fixed') {
                                    document.querySelector('#percent_all_var').value = 0;
                                    item.percentage = 0 
                                    item.fixed = rateValue
                                    let dataPrice =  Number(item.product_price) - Number(rateValue)
                                    if (dataPrice > 0) {
                                        item.new_price =  Number(dataPrice).toFixed(2)
                                    }
                                }
                            }) 
                        }
                    } else {
                        if (this.products.length > 0) {
                            this.products.forEach(element => {
                                if (type === 'percen') {
                                    document.querySelector('#fixed_all').value = 0;
                                    element.fixed = 0; element.percentage = rateValue
                                    let dataPrice = Number(element.price) - Number((rateValue / 100 )  * Number(element.price))
                                    if (dataPrice > 0) {
                                        element.new_price = Number(dataPrice).toFixed(2)
                                    }
                                } else if (type === 'fixed') {
                                    document.querySelector('#percent_all').value = 0;
                                    element.percentage = 0 
                                    element.fixed = rateValue
                                    let dataPrice =  Number(element.price) - Number(rateValue)
                                    if (dataPrice > 0) {
                                        element.new_price =  Number(dataPrice).toFixed(2)
                                    }
                                }
                                if (element.variants.length > 0) {
                                    element.variants = element.variants.map(varnt => {
                                        if (type === 'percen') {
                                            varnt.fixed = 0; varnt.percentage = rateValue
                                            let dataPrice = Number(varnt.price) - Number((rateValue / 100 )  * Number(varnt.price))
                                            if (dataPrice > 0) {
                                                varnt.new_price = Number(dataPrice).toFixed(2)
                                            }
                                        } else if (type === 'fixed') {
                                            varnt.percentage = 0 
                                            varnt.fixed = rateValue
                                            let dataPrice =  Number(varnt.price) - Number(rateValue)
                                            if (dataPrice > 0) {
                                                varnt.new_price =  Number(dataPrice).toFixed(2)
                                            }
                                        }
                                        return varnt;
                                    })
                                }
                            });
                        }
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
                    if (this.selectedProduct.length > 0) {
                        this.products = this.products.filter(item=>{
                            return this.selectedProduct.find(vv => vv == item.original_product_id)
                        })
                        let formD = new FormData();
                        formD.append('products', JSON.stringify(this.products))
                        formD.append('store_id', $("#store_id").val())
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
                            if (res.status) {
                                window.location.reload()
                            }
                        })
                    } else {
                        alert('Select Products')
                    }
                },
                openModal(product) {
                    this.variants_products  =[]
                    var allVarinats = [];
                    let variantData = [...product.variants]
                    variantData.forEach(item=>{
                        let names = item.name.split('/');
                        let obj = {}
                        obj.opt1_value = typeof names[0] !== 'undefined' ? item.opt1_value: null 
                        obj.opt2_value = typeof names[1] !== 'undefined' ? item.opt2_value: null 
                        obj.opt3_value = typeof names[2] !== 'undefined' ? item.opt3_value: null 
                        obj.old_price = item.old_price
                        obj.price = item.price
                        obj.percentage = item.percentage
                        obj.fixed = item.fixed
                        obj.new_price = item.new_price
                        obj.id = item.id
                        allVarinats.push(obj)
                    })
                    if (allVarinats.length > 0) {
                        allVarinats.forEach(item=>{
                            let var_product = {
                                id: item.id,
                                original_product_id: product.original_product_id,
                                product_name: product.name,
                                product_price: item.price,
                                percentage: item.percentage,
                                new_price : item.new_price,
                                fixed : item.fixed,
                            }
                            if (item.opt1_value !== null) {
                                var_product.product_name += '('+item.opt1_value+')'
                            }
                            if (item.opt2_value !== null) {
                                var_product.product_name += '('+item.opt2_value+')'
                            }
                            if (item.opt3_value !== null) {
                                var_product.product_name += '('+item.opt3_value+')'
                            }
                            this.variants_products.push(var_product)
                        })
                    }
                   $("#variantmodal").modal('show') 
                },
                updateVariantPrice() {
                    if (this.variants_products.length > 0) {
                        this.variants_products.forEach(element => {
                            if (this.products.length > 0) {
                                this.products.forEach(product => {
                                    if (Number(product.original_product_id) === Number(element.original_product_id)) {
                                        if (product.variants.length > 0) {
                                            product.variants.forEach( variant => {
                                                if (Number(variant.id) === Number(element.id)) {
                                                    variant.quantity = element.quantity;
                                                    variant.fixed = element.fixed;
                                                    variant.percentage = element.percentage;
                                                    variant.new_price = element.new_price;
                                                }
                                            })
                                        }
                                    }
                                }) 
                            }
                        })
                    }
                    
                   $("#variantmodal").modal('hide') 
                },
                checkItem() {
                    if (this.selectedProduct.length  > 0) {
                        $('input[name="select_all"]').attr('checked', true);
                        $(".massActionWrapper").attr('colspan', '6')
                        $('table tr th').each(function(i, v) {
                            $(v).hide();
                        })
                        $('table tr th:eq(0)').show()
                        $(".all-check").removeClass('d-none');

                    } else {
                        $('input[name="select_all"]').attr('checked', false);
                        $(".massActionWrapper").attr('colspan', '0')
                        $('table tr th').each(function(i, v) {
                            $(v).show();
                        })
                        $(".all-check").addClass('d-none');
                    }
                },
                checkAll() {
                    if ($('input[name="select_all"]').prop('checked')) {
                        $("input[name='ids[]']").each((indexInArray, valueOfElement) => { 
                            this.selectedProduct.push($(valueOfElement).val());
                        });
                    } else {
                        this.selectedProduct = [];
                    }
                    this.checkItem()
                }
            },
            watch: {

            }
        })
    </script>
@endsection


