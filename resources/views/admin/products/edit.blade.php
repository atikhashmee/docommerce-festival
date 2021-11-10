@extends('layouts.admin')

@section('title')
   Product Edit
@endsection

@section('content')
    <section class="container-fluid" id="festivalTableContainer">
        <div class="d-flex flex-row flex-row-reverse mb-4">
            <a href="{{route('admin.products.index')}}" class="btn btn-primary btn-sec"><i class="fas fa-angle-double-left"></i> Back</a>
        </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" readonly class="form-control" :value="product.name">
                                </div>
                                <div class="form-group">
                                    <label for="">Slug</label>
                                    <input type="text" readonly class="form-control" :value="product.slug">
                                </div>
                                <div class="form-group">
                                    <label for="">Description</label>
                                    <textarea class="form-control" cols="30" rows="10" v-html="product.short_description"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Section</label>
                                    <select name="section_type" id="section_type" v-model="product.section_type" class="form-control mr-2">
                                        <option value="">Select Sections</option>
                                        @if (count($sections) > 0)
                                            @foreach ($sections as $section)
                                                <option @if($product->section_type == $section) selected @endif>{{$section}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Category</label>
                                    <select name="category_id" id="category_id" v-model="product.category_id" class="form-control mr-2">
                                        <option value="">Select Category</option>
                                        @if (count($categories) > 0)
                                            @foreach ($categories as $category)
                                                <option value="{{$category->id}}" @if($product->category_id == $category->id) selected @endif>{{$category->name ?? 'No Name'}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <img :src="product.original_product_img" alt="">
                                </div>
                                <div class="col-md-6" v-if="product.other_images.length > 0">
                                    <div class="row">
                                        <div class="col-md-3" v-for="img in product.other_images">
                                            <img :src="img.original_product_img" width="100" height="100" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div v-if="product.variants.length > 0">
                                <div v-for="variant in product.variants" class="row mb-2 p-2" style="border: 1px solid #81368f">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Variant Name</label>
                                            <input type="text" readonly class="form-control" :value="variant.name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Original Price</label>
                                            <input type="text" readonly class="form-control" :value="variant.old_price">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group custom-price-group d-inline-block">
                                            <label for="">Fixed(1.00)</label>
                                            <input type="number" value="0" v-model="variant.fixed" @keyup="variantPriceChange($event, 'fixed', variant)">
                                        </div>
                                        <div class="form-group custom-price-group d-inline-block">
                                            <label for="">Percentage(%)</label>
                                            <input type="number" value="0" v-model="variant.percentage" @keyup="variantPriceChange($event, 'percen', variant)">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">New Price</label>
                                            <input type="text" readonly class="form-control" v-model.number="variant.new_price">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Weight</label>
                                            <input type="number" v-model.number="variant.weight" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Stock</label>
                                            <input type="number" v-model.number="variant.quantity" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-else>
                                <div class="row mb-2 p-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Original Price</label>
                                            <input type="text" readonly class="form-control"  v-model="product.old_price">
                                        </div>
                                        <div class="form-group">
                                            <div class="form-group custom-price-group d-inline-block">
                                                <label for="">Fixed(1.00)</label>
                                                <input type="number" value="0"  v-model.number="product.fixed" @keyup="productPriceChange($event, 'fixed')">
                                            </div>
                                            <div class="form-group custom-price-group d-inline-block">
                                                <label for="">Percentage(%)</label>
                                                <input type="number" value="0"  v-model.number="product.percentage"  @keyup="productPriceChange($event, 'percen')">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="">New Price</label>
                                            <input type="text" readonly class="form-control" v-model="product.new_price">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Weight</label>
                                            <input type="number" v-model.number="product.weight" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Stock</label>
                                            <input type="number" v-model.number="product.quantity" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" @click="updateData()" class="btn btn-primary float-right">Update Changes</button>
                        </div>
                    </div>
                </div>
            </div>
    </section>
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
                product: <?=$product?>,
                variants_products: [],
                selectedProduct: [],
            }, 
            mounted() {
                console.log(this.product);
            },
            updated() {
                //console.log(this.product);
            },
            methods: {
               updateData() {
                let formD = new FormData();
                formD.append('product', JSON.stringify(this.product))
                   fetch(`{{url("admin/products")}}/${this.product.id}`, {
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
                            window.location.reload();
                        }
                       console.log(res, 'asdf');
                    })
               },
               productPriceChange(evt, type) { 
                    let rateValue = Number(evt.currentTarget.value)
                    if (type === 'percen') {
                        this.product.fixed = 0; 
                        this.product.percentage = rateValue;
                        let dataPrice = Number(this.product.old_price) - Number((rateValue / 100 )  * Number(this.product.old_price))
                        if (dataPrice > 0) {
                            this.product.new_price = Number(dataPrice).toFixed(2)
                        }
                    } else if (type === 'fixed') {
                        this.product.percentage = 0 
                        this.product.fixed = rateValue
                        let dataPrice =  Number(this.product.old_price) - Number(rateValue)
                        if (dataPrice > 0) {
                            this.product.new_price =  Number(dataPrice).toFixed(2)
                        }
                    }
               },
               variantPriceChange(evt, type, varObj) {
                    let rateValue = Number(evt.currentTarget.value)
                    if (type === 'percen') {
                        varObj.fixed = 0; 
                        varObj.percentage = rateValue;
                        let dataPrice = Number(varObj.old_price) - Number((rateValue / 100 )  * Number(varObj.old_price))
                        if (dataPrice > 0) {
                            varObj.new_price = Number(dataPrice).toFixed(2)
                        }
                    } else if (type === 'fixed') {
                        varObj.percentage = 0 
                        varObj.fixed = rateValue
                        let dataPrice =  Number(varObj.old_price) - Number(rateValue)
                        if (dataPrice > 0) {
                            varObj.new_price =  Number(dataPrice).toFixed(2)
                        }
                    }

                    this.product.variants = this.product.variants.map(vari => {
                        if (Number(vari.id) === Number(varObj.id)) {
                            vari = {...varObj}
                        }
                        return vari;
                    })
               }
            },
            watch: {

            }
        })
    </script>
@endsection


