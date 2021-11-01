@extends('layouts.admin')

@section('title')
    Festivals
@endsection

@section('content')
    <section class="container" id="festivalTableContainer">
        <form action="{{route('admin.orders.index')}}" method="GET" id="filter_form"></form>
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <a class="btn btn-primary" href="{{route('admin.users.create')}}">Create</a>
                    <div class="search-form d-flex">
                        <input placeholder="Names" name="search[name]" type="search" class="form-control">
                        <button class="btn btn-success" id="searchButton"><i aria-hidden="true" class="fa fa-search"></i></button>
                    </div>
            </div>
        
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th class="massActionWrapper">
                                <button type="button" class="btn btn-xs btn-default checkbox-toggle"
                                        @click="checkAll">
                                    <input type="checkbox" name="select_all" class="hidden">
                                    <i id="check-all-icon" class="fa fa-square-o" data-toggle="tooltip"
                                       data-placement="top" title="Select All"></i>
                                </button>
                                {{-- <div class="input-group-btn all-check">
                                    <div class="ahow-option">
                                        <button type="button" class="btn btn-xs btn-default checkbox-caret">
                                            <span id="count"></span>
                                            {{ __('announcement.announcements') }} {{ __('create.selected') }}
                                        </button>
                                        <button type="button"
                                                class="btn btn-xs btn-default dropdown-toggle checkbox-caret"
                                                data-toggle="dropdown" aria-expanded="false">
                                            {{ __('create.actions') }}
                                            <span class="caret"></span>
                                            <span class="sr-only">{{ __('trash.toggle_dropdown') }}</span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            @can('bulk trash announcement')
                                            <li>
                                                <a href="javascript:void(0)" @click="trashOrDestroyPermanently('trash')" class="massAction" data-doafter="reload"><i class="fa fa-trash"></i> {{ __('trash.trash') }}</a>
                                            </li>
                                            @endcan

                                            @can('bulk destroy permanently announcement')
                                            <li>
                                                <a href="javascript:void(0)" @click="trashOrDestroyPermanently('delete')" class="massAction" data-doafter="reload"><i class="fa fa-times"></i> {{ __('trash.delete_permanently') }}</a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </div>
                                </div> --}}
                            </th>
                            <th>#Order&nbsp;ID</th>
                            <th>User</th>
                            <th>Amount</th>
                            <th>Store</th>
                            <th></th>
                        </tr>
                        </thead>
                        @if (count($orders) > 0)
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>
                                            <input name="ids[]" type="checkbox" class="massCheck" @change="checkSpecific" value="{{$order->id}}">
                                        </td>
                                        <td>
                                            {{ $order->id }}
                                        </td>
                                        <td>  {{ $order->user->name }}</td>
                                        <td>  {{ $order->email ?? 'N/A' }}</td>
                                        <td>  {{ $order->phone_number ?? 'N/A' }}</td>
                                        <td>
                                            {{-- <div class="dropdown">
                                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="#">Detail</a>
                                                    <a class="dropdown-item" href="{{route('admin.users.edit', ['user' => $item->id])}}">Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="return confirm('Are you sure?')?document.querySelector('#delete_action{{$item->id}}').submit():null; ">Delete</a>
                                                    <form method="POST" id="delete_action{{$item->id}}" action="{{route('admin.users.destroy', ['user' => $item])}}">
                                                        @csrf
                                                        @method('delete')
                                                    </form>
                                                </div>
                                            </div> --}}
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
                        {{ $orders->withQueryString()->links() }}
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
        $("#festivalTableContainer").DataSorting({    
            formId : "filter_form",
            initSort : `<?=json_encode(request('sort'))?>`,
            initSearch : `<?=json_encode(request('search'))?>`
        });
    </script>
@endsection


