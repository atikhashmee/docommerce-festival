@extends('layouts.admin')

@section('title')
    Stores
@endsection

@section('content')
    <section class="container-fluid" id="festivalTableContainer">
        @if (session('error'))
            <div class="alert alert-danger">
                {{session('error')}}
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                {{session('success')}}
            </div>
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">
                    <li>{{ $error }}</li>
                </div>
            @endforeach
        @endif
        <div class="d-flex flex-row flex-row-reverse mb-4">
            <a href="{{route('admin.product.import')}}" class="btn btn-secondary"><i class="fas fa-upload"></i> Import</a>
        </div>
        <div class="card">
            <form action="{{route('admin.products.index')}}" method="GET" id="filter_form" class="card-header d-flex justify-content-between">
                <div class="d-flex"></div>
                <div class="search-form d-flex">                                        
                    <select name="type" id="type" class="form-control mr-2">
                        <option value="">Select Type</option>
                        @foreach([
                            'hot_deal' => 'Hot Deal', 
                            'exclusive' => 'Exclusive', 
                            'hot_exclusive' => 'Hot Deal & Exclusive',
                            'no_hot_exclusive' => 'No Deal'
                            ] as $typK => $typV)
                            <option value="{{ $typK }}" {{ Request::get('type') == $typK ? 'selected' : '' }}>{{ $typV }}</option>
                        @endforeach
                    </select>

                    <select name="store_id" id="store_id" class="form-control mr-2">
                        <option value="">Select Store</option>
                        @if (count($stores) > 0)
                            @foreach ($stores as $store)
                                <option value="{{$store->id}}" @if(Request::get('store_id')!=null && Request::get('store_id') == $store->id) selected @endif> ({{$store->original_store_id}}) {{$store->name ?? 'No Name'}} ({{$store->store_domain}})  ({{ $store->total_products }}) </option>
                            @endforeach
                        @endif
                    </select>
                    {{-- <select name="section" id="section" class="form-control mr-2">
                        <option value="">Select Sections</option>
                        @if (count($sections) > 0)
                            @foreach ($sections as $section)
                                <option>{{$section}}</option>
                            @endforeach
                        @endif
                    </select> --}}
                    <select name="category_id" id="category_id" class="form-control mr-2" >
                        <option value="">Select Category</option>
                        @if (count($categories) > 0)
                            @foreach ($categories as $category)
                                <option value="{{$category->id}}" @if(Request::get('category_id')!=null && Request::get('category_id') == $category->id) selected @endif>{{$category->name ?? 'No Name'}} ({{ $category->total_products }}) </option>
                            @endforeach
                        @endif
                    </select>
                    <input placeholder="Product Names" name="search" type="search" class="form-control">
                    <button class="btn btn-success" id="searchButton"><i aria-hidden="true" class="fa fa-search"></i></button>
                    <a class="btn btn-warning ml-2" href="{{route('admin.products.index')}}"><i aria-hidden="true" class="fa fa-times"></i></a>
                </div>
            </form>
        
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th class="massActionWrapper">
                                <button type="button" class="btn btn-xs btn-default checkbox-toggle p-0"
                                        onchange="checkAll()">
                                    <input type="checkbox" name="select_all" class="hidden">
                                    <i id="check-all-icon" class="fa fa-square-o" data-toggle="tooltip"
                                       data-placement="top" title="Select All"></i>
                                </button>
                                <div class="dropdown all-check d-none">
                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span id="count"></span> Items Selected
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="changeAll('hot_deal')">Make Hot Deal All</a>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="changeAll('exclusive')">Make Exclusive All</a>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="changeAll('hot_exclusive')">Make Hot Deal & Exclusive All</a>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="changeAll('remove_hot_exclusive')">Remove Hot Deal & Exclusive All</a>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="deleteAll()">Delete All</a>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="updateSync()">Update Sync</a>
                                    </div>
                                </div>
                            </th>
                            <th>#SL</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Stock</th>
                            {{-- <th>Section</th> --}}
                            {{-- <th>Weight</th> --}}
                            <th>Order&nbsp;Quantity</th>
                            <th>Category</th>
                            <th>Store</th>
                            <th>Hot/Exclusive</th>
                            <th></th>
                        </tr>
                        </thead>
                        @if (count($products) > 0)
                            <tbody>
                                @foreach ($products as $item)
                                    <tr>
                                        <td><input name="ids[]" type="checkbox" class="massCheck" onchange="checkSpecific(this)" value="{{$item->id}}"></td>
                                        <td>{{ $item->id }}</td>
                                        <td>  
                                            {{-- <img src="{{ $item->original_product_img }}" class="rounded" height="50" width="50"> --}}
                                            <h5> <span style="border: 1px solid #d3d3d3; padding:3px">{{ $item->original_product_sequence_id }}</span> <a target="_blank" href="{{route("detail_page", ["slug" => $item->slug])}}">{{ $item->name }}</a> </h5>
                                        </td>
                                        <td>
                                            <div class="price">
                                                <span>৳{{ $item->price }}</span>  
                                                <span style="color:#100f0f61" class="discount">({{ $item->discount_type=='fixed'?"৳":"" }}{{ $item->discount_amount }}{{ $item->discount_type=='percentage' ?"%":"" }} off)</span> 
                                            </div>
                                            <div class="original_price" style="color:#100f0f61"> ৳{{ $item->old_price }} </div>
                                        </td>
                                        <td>{{ $item->quantity }}</td>
                                        {{-- <td>{{ $item->section_type }}</td> --}}
                                        {{-- <td>{{ $item->weight }}</td> --}}
                                        <td>0</td>
                                        <td>  {{ $item->category->name ?? 'N/A' }}</td>
                                        <td>  {{ $item->store->name ?? 'N/A' }}</td>
                                        <td>
                                            @if ($item->section_type == '{"hot_deal":"1", "exclusive":"0"}')
                                                <label class="badge badge-danger">Hot Deal</label>
                                            @elseif ($item->section_type == '{"hot_deal":"0", "exclusive":"1"}')
                                                <label class="badge badge-warning">Exclusive</label>
                                            @elseif ($item->section_type == '{"hot_deal":"1", "exclusive":"1"}')
                                                <label class="badge badge-success">Hot & Exclusive</label>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="{{route("admin.product.edit", ['id' => $item->id])}}">Edit & Detail</a>
                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="return confirm('Are you sure?')?document.querySelector('#delete_action{{$item->id}}').submit():null; ">Delete</a>
                                                    <form method="POST" id="delete_action{{$item->id}}" action="{{route('admin.products.destroy', ['product' => $item])}}">
                                                        @csrf
                                                        @method('delete')
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @else
                            <tbody>
                                <tr>
                                    <td colspan="9" class="text-center">
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
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-6">
                        {{ $products->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('modals')
<div class="modal fade" id="update_sync_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Chose Syncable Column</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.products.syncAll') }}" method="POST">
                            @csrf
                            <input type="hidden" name="selected_products" id="selected_products">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="checkbox" name="column[]" id="name" value="name">
                                        <label for="name">Name</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="checkbox" name="column[]" id="slug" value="slug">
                                        <label for="slug">Slug</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="checkbox" name="column[]" id="short_description" value="short_description">
                                        <label for="short_description">Short Description</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="checkbox" name="column[]" id="description" value="description">
                                        <label for="description">Description</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="checkbox" name="column[]" id="images" value="images">
                                        <label for="images">Images</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="checkbox" name="column[]" id="price" value="price">
                                        <label for="price">Price</label>
                                    </div>
                                </div>
                            </div> 
                            
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                    </div>
                </div>
            
        </div>
    
  </div>
@endsection
@section('styles')
    <style>
        th > .sort {
            float: right;
            cursor: pointer;
        }
        .sort i {
            font-size: 16px;
            color: #d3d3d3;
        }
        .sort i.active {
            color: #000;
        }
    </style>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            
        });
        let selectedIds = [];
        $("#festivalTableContainer").DataSorting({    
            formId : "filter_form",
            initSort : `<?=json_encode(request('sort'))?>`,
            initSearch : `<?=json_encode(request('search'))?>`
        });
        function checkAll() {
            if ($('input[name="select_all"]').prop('checked')) {
                $("input[name='ids[]']").each(function (indexInArray, valueOfElement) { 
                    selectedIds[$(valueOfElement).val()] = $(valueOfElement).val();
                });
            } else {
                selectedIds = [];
            }
            checkItem();
        }
        function checkSpecific(evt) {
            if ($(evt).prop('checked')) {
                selectedIds[$(evt).val()] = $(evt).val();
            } else {
                selectedIds = selectedIds.filter(iv => iv != $(evt).val())
            }
            checkItem();
        }
        function checkItem() {
            if (selectedIds.length  > 0) {
                let totalCount = 0;
                $('input[name="select_all"]').prop('checked', true);
                $("input[name='ids[]']").each(function (indexInArray, valueOfElement) { 
                    if (selectedIds[$(valueOfElement).val()] !== undefined) {
                        $(valueOfElement).prop('checked', true)
                        totalCount++;
                    }
                });

                $(".massActionWrapper").attr('colspan', '9')
                $("#count").text(totalCount)
                $('table tr th').each(function(i, v) {
                    $(v).hide();
                })
                $('table tr th:eq(0)').show()
                $(".all-check").removeClass('d-none');

            } else {
                $('input[name="select_all"]').prop('checked', false);
                $("input[name='ids[]']").each(function (indexInArray, valueOfElement) {
                    $(valueOfElement).prop('checked', false)
                });

                $(".massActionWrapper").attr('colspan', '0')
                $('table tr th').each(function(i, v) {
                    $(v).show();
                })
                $(".all-check").addClass('d-none');
            }
        }

        function changeAll(type) {
            if (confirm('Are you sure?')) {
                let formD = new FormData();
                formD.append('type', type);
                formD.append('product_ids', JSON.stringify(selectedIds));
                fetch(`{{route("admin.products.changeAll")}}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN' : `{{csrf_token()}}`,
                    },
                    body: formD
                }).then(res=>res.json())
                .then( res => {
                    if (res.status) {
                        window.location.reload()
                    }
                })
            }
        }

        function deleteAll() {
            if (confirm('Are you sure?')) {
                let formD = new FormData();
                formD.append('product_ids', JSON.stringify(selectedIds));
                fetch(`{{route("admin.products.deteletAll")}}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN' : `{{csrf_token()}}`,
                    },
                    body: formD
                }).then(res=>res.json())
                .then( res => {
                    if (res.status) {
                        window.location.reload()
                    }
                })
            }
        }

        function updateSync() {
            $("#selected_products").val(JSON.stringify(selectedIds))
            $("#update_sync_modal").modal('show')
        }
    </script>
@endsection


