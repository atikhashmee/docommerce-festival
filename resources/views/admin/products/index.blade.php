@extends('layouts.admin')

@section('title')
    Stores
@endsection

@section('content')
    <section class="container-fluid" id="festivalTableContainer">
        <div class="d-flex flex-row flex-row-reverse mb-4">
            <a href="{{route('admin.product.import')}}" class="btn btn-secondary"><i class="fas fa-upload"></i> Import</a>
        </div>
        <div class="card">
            <form action="{{route('admin.products.index')}}" method="GET" id="filter_form" class="card-header d-flex justify-content-between">
                <div class="d-flex"></div>
                <div class="search-form d-flex">
                    <select name="store_id" id="store_id" class="form-control mr-2">
                        <option value="">Select Store</option>
                        @if (count($stores) > 0)
                            @foreach ($stores as $store)
                                <option value="{{$store->id}}">{{$store->name ?? 'No Name'}} ({{$store->store_domain}}) </option>
                            @endforeach
                        @endif
                    </select>
                    <select name="category_id" id="category_id" class="form-control mr-2">
                        <option value="">Select Category</option>
                        @if (count($categories) > 0)
                            @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{$category->name ?? 'No Name'}}</option>
                            @endforeach
                        @endif
                    </select>
                    <input placeholder="Product Names" name="search" type="search" class="form-control">
                    <button class="btn btn-success" id="searchButton"><i aria-hidden="true" class="fa fa-search"></i></button>
                </div>
            </form>
        
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th class="massActionWrapper">
                                <button type="button" class="btn btn-xs btn-default checkbox-toggle p-0"
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
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="deleteAll()">Delete All</a>
                                    </div>
                                </div>
                            </th>
                            <th>#SL</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Store</th>
                            <th></th>
                        </tr>
                        </thead>
                        @if (count($products) > 0)
                            <tbody>
                                @foreach ($products as $item)
                                    <tr>
                                        <td><input name="ids[]" type="checkbox" class="massCheck" @change="checkSpecific" value="{{$item->id}}"></td>
                                        <td>{{ $item->id }}</td>
                                        <td>  
                                            {{-- <img src="{{ $item->original_product_img }}" class="rounded" height="50" width="50"> --}}
                                            <h5>{{ $item->name }}</h5>
                                        </td>
                                        <td>  {{ $item->category->name ?? 'N/A' }}</td>
                                        <td>  {{ $item->store->name ?? 'N/A' }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="#">Detail</a>
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
        <form method="POST" id="bulk-trash-or-destroy" action="#" accept-charset="UTF-8" class="data-form non-validate">
            @csrf
            @method('delete')
            <input type="hidden" name="type">
        </form>
    </section>
@endsection
@section('modals')
  <!-- Modal -->
  <div class="modal fade" id="attachFestivalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Attach to Festival</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="">Festival Lists</label>
                <select name="festival_id" id="festival_id" class="form-control">
                    <option value="">Select option</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="submitAttachToFestival()">Save changes</button>
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
        function checkItem() {
            if (selectedIds.length  > 0) {
                $('input[name="select_all"]').attr('checked', true);
                $("input[name='ids[]']").each(function (indexInArray, valueOfElement) { 
                    if (selectedIds[$(valueOfElement).val()] !== undefined) {
                        $(valueOfElement).attr('checked', true)
                    }
                });

                $(".massActionWrapper").attr('colspan', '6')
                $('table tr th').each(function(i, v) {
                    $(v).hide();
                })
                $('table tr th:eq(0)').show()
                $(".all-check").removeClass('d-none');

            } else {
                $('input[name="select_all"]').attr('checked', false);
                $("input[name='ids[]']").each(function (indexInArray, valueOfElement) { 
                        $(valueOfElement).attr('checked', false)
                });

                $(".massActionWrapper").attr('colspan', '0')
                $('table tr th').each(function(i, v) {
                    $(v).show();
                })
                $(".all-check").addClass('d-none');
            }
        }

        function attachToFestival() {
            fetch(`{{route("admin.festivals.index")}}`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN' : `{{csrf_token()}}`,
                    'X-Requested-With': 'XMLHttpRequest',
                    'no-pagination' : 'no-pagination'
                },
                body: null
            }).then(res=>res.json())
            .then( res => {
                if (res.status) {
                    let txt = `<option value="">Select Option</option>`;
                    if (res.data.items.length > 0) {
                        res.data.items.forEach(element => {
                            txt += `<option value="${element.id}">${element.name}</option>`;
                        });
                        document.querySelector('#festival_id').innerHTML = txt;
                    } else {
                        let txt = `<option value="">Nothing Found</option>`;
                        document.querySelector('#festival_id').innerHTML = txt;
                    }
                    $("#attachFestivalModal").modal('show')
                }
            })
        }

        function submitAttachToFestival() {
            let formD = new FormData();
            formD.append('festival_id', document.querySelector('#festival_id').value);
            formD.append('store_ids', JSON.stringify(selectedIds));
            fetch(`{{route("admin.attach.festival.store.data")}}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN' : `{{csrf_token()}}`,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formD
            }).then(res=>res.json())
            .then( res => {
                if (res.status) {
                    $("#attachFestivalModal").modal('hide')
                }
            })
        }

        function deleteAll() {
            let formD = new FormData();
            formD.append('product_ids', JSON.stringify(selectedIds));
            fetch(`{{route("admin.products.deteletAll")}}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN' : `{{csrf_token()}}`,
                    'X-Requested-With': 'XMLHttpRequest',
                    'no-pagination' : 'no-pagination'
                },
                body: formD
            }).then(res=>res.json())
            .then( res => {
                if (res.status) {
                    window.location.reload()
                }
            })
        }
    </script>
@endsection


