@extends('layouts.admin')

@section('title')
    Stores
@endsection

@section('content')
    <section class="container-fluid" id="festivalTableContainer">
        <form action="{{route('admin.stores.index')}}" method="GET" id="filter_form"></form>
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <a href="{{route('admin.sync.store.data')}}" class="btn btn-primary">Update Sync <i class="fas fa-sync"></i></a>
                <div class="search-form d-flex">
                    <input placeholder="Store Names" name="search[name]" type="search" class="form-control">
                    <button class="btn btn-success" id="searchButton"><i aria-hidden="true" class="fa fa-search"></i></button>
                </div>
            </div>
        
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
                                        <span id="selected_count"></span> Items Selected
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="attachDetachToFestival()">Attach & Detach to <strong>{{request()->festival->name}}</strong></a>
                                    </div>
                                </div>
                            </th>
                            <th data-sort="id">
                                #SL
                                <span class="sort">
                                    <i class="fa fa-arrow-up" aria-hidden="true"></i>
                                    <i class="fa fa-arrow-down" aria-hidden="true"></i>
                                </span>
                            </th>
                            <th>Attached To Festival</th>
                            <th>Logo</th>
                            <th data-sort="name">
                                Name
                                <span class="sort">
                                    <i class="fa fa-arrow-up" aria-hidden="true"></i>
                                    <i class="fa fa-arrow-down" aria-hidden="true"></i>
                                </span>
                            </th>
                            <th data-sort="store_domain">
                                Domain
                                <span class="sort">
                                    <i class="fa fa-arrow-up" aria-hidden="true"></i>
                                    <i class="fa fa-arrow-down" aria-hidden="true"></i>
                                </span>
                            </th>
                            <th></th>
                        </tr>
                        </thead>
                        @if (count($items) > 0)
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>
                                            <input name="ids[]" type="checkbox" class="massCheck" onchange="checkSpecific(this, {{$item}})" value="{{$item->id}}">
                                        </td>
                                        <td>
                                            {{ $item->id }}
                                        </td>
                                        <td>
                                            {{ $item->attached_store_id == null ? "No" : "Yes" }}
                                        </td>
                                        <td>  
                                            @if ($item->img !=null && file_exists(public_path('storage/stores/'.$item->img)))
                                                <img src="{{ asset('storage/stores/'.$item->img) }}" alt="{{ $item->name }}" height="97" width="176">
                                            @else
                                                <img src="{{ $item->store_logo_url }}" alt="{{ $item->name }}" height="97" width="176">
                                            @endif
                                        </td>
                                        <td>  
                                            <h5>{{ $item->name }}</h5>
                                            <small> {{ $item->store_slogan }}</small>
                                        </td>
                                        <td>  {{ $item->store_domain }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="#">Detail</a>
                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="attachDetachToFestivalSingle({{$item}})">  {{ $item->attached_store_id == null ? "Attach To" : "Remove From" }} <strong>{{request()->festival->name}}</strong> </a>
                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="attachImageModal({{$item->id}})">Attach Image</a>
                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="return confirm('Are you sure?')?document.querySelector('#delete_action{{$item->id}}').submit():null; ">Delete</a>
                                                    <form method="POST" id="delete_action{{$item->id}}" action="{{route('admin.stores.destroy', ['store' => $item])}}">
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
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-6">
                        {{ $items->withQueryString()->links() }}
                    </div>
                    <div class="col-md-6">
                        <form action="{{route('admin.stores.index')}}" id="showing_form" class="ml-auto w-25">
                            <div class="form-group">
                                <label for="">Showing</label>
                                <select name="showing" class="form-control" id="showing" onchange="document.querySelector('#showing_form').submit()">
                                    <option @if(request('showing') == 25) selected @endif >25</option>
                                    <option @if(request('showing') == 50) selected @endif>50</option>
                                    <option @if(request('showing') == 100) selected @endif>100</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('modals')
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <form action="{{route("admin.attach.store.image")}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="store_id" name="store_id">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Store Image</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <img src="{{asset('web_assets/images/stores/0.png')}}" id="img_container" width="176" height="97" alt="Store logo">
                <div class="form-group mt-4">
                    <input type="file" name="imageFile" id="imageFile" class="form-control p-0">
                    @error('imageFile')
                        <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                    @error('store_id')
                        <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
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

        @if($errors->any())
            $("#imageModal").modal('show')
            console.log(document.querySelector("#store_id").value);
        @endif

        imageFile.onchange = evt => {
            const [file] = imageFile.files
            if (file) {
                img_container.src = URL.createObjectURL(file)
            }
        }
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
        function checkSpecific(evt, obj) {
            if ($(evt).prop('checked')) {
                selectedIds[$(evt).val()] = $(evt).val();
            } else {
                selectedIds = selectedIds.filter(iv => iv != $(evt).val())
            }
            checkItem();
        }
        function updateCount() {
            selectedIds = selectedIds.filter(iv => !IsNaN(iv))
            $("#selected_count").text(selectedIds.length)
        }
        function checkItem() {
            //updateCount();
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

        function attachDetachToFestival() {
            let formD = new FormData();
            formD.append('store_ids', JSON.stringify(selectedIds));
            formD.append('type', 'bulk');
            fetch(`{{route("admin.attach.store.data")}}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN' : `{{csrf_token()}}`,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: formD
            }).then(res=>res.json())
            .then( res => {
                if (res.status) {
                    window.location.reload()
                }
            })
        }

        function attachDetachToFestivalSingle(obj) {
            let formD = new FormData();
            formD.append('store_id', obj.id);
            formD.append('type', 'single');
            fetch(`{{route("admin.attach.store.data")}}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN' : `{{csrf_token()}}`,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: formD
            }).then(res=>res.json())
            .then( res => {
                if (res.status) {
                    window.location.reload()
                }
            })
        }
        
        function attachImageModal(store_id) {
            document.querySelector("#store_id").value=store_id;
            $("#imageModal").modal('show')
        }
    </script>
@endsection


