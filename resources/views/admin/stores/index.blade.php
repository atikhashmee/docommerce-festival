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
                                        <span id="count"></span> Items Selected
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="attachToFestival()">Attach to festival</a>
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
                                            <input name="ids[]" type="checkbox" class="massCheck" @change="checkSpecific" value="{{$item->id}}">
                                        </td>
                                        <td>
                                            {{ $item->id }}
                                        </td>
                                        <td>  
                                            <img src="{{ $item->store_logo_url }}" alt="{{ $item->name }}" height="100" width="100">
                                            
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
        <form method="POST" id="bulk-trash-or-destroy" action="#" accept-charset="UTF-8" class="data-form non-validate">
            @csrf
            @method('delete')
            <input type="hidden" name="type">
        </form>
    </section>
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
    </script>
@endsection


