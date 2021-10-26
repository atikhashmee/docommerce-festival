@extends('layouts.admin')

@section('title')
    Festivals
@endsection

@section('content')
    <section class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <a class="btn btn-primary" href="{{route('admin.festivals.create')}}">Create</a>
                <form action="{{route('admin.festivals.index')}}" method="GET" class="d-flex">
                    <input  placeholder="Festival Names" name="keyword" type="search" class="form-control">
                    <button class="btn btn-success"><i aria-hidden="true" class="fa fa-search"></i></button>
                </form>
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
                            <th @click="filterParam('sort', 'id')" :class="{ 'sorting' : params.sort_by !== 'id', 'sorting_asc' : params.sort_by === 'id' && params.order_by === 'asc', 'sorting_desc' : params.sort_by === 'id' && params.order_by === 'desc' }">
                                #SL
                                <span class="sort"><i class="fa fa-caret-up" aria-hidden="true"></i><i class="fa fa-caret-down" aria-hidden="true"></i></span>
                            </th>
                            <th @click="filterParam('sort', 'action_text')" :class="{ 'sorting' : params.sort_by !== 'action_text', 'sorting_asc' : params.sort_by === 'action_text' && params.order_by === 'asc', 'sorting_desc' : params.sort_by === 'action_text' && params.order_by === 'desc' }">
                                Name
                                <span class="sort"><i class="fa fa-caret-up" aria-hidden="true"></i><i class="fa fa-caret-down" aria-hidden="true"></i></span>
                            </th>
                            <th width="10%" @click="filterParam('sort', 'created_at')" :class="{ 'sorting' : params.sort_by !== 'created_at', 'sorting_asc' : params.sort_by === 'created_at' && params.order_by === 'asc', 'sorting_desc' : params.sort_by === 'created_at' && params.order_by === 'desc' }">
                                Start At
                                <span class="sort"><i class="fa fa-caret-up" aria-hidden="true"></i><i class="fa fa-caret-down" aria-hidden="true"></i></span>
                            </th>
                            <th width="10%" @click="filterParam('sort', 'created_at')" :class="{ 'sorting' : params.sort_by !== 'created_at', 'sorting_asc' : params.sort_by === 'created_at' && params.order_by === 'asc', 'sorting_desc' : params.sort_by === 'created_at' && params.order_by === 'desc' }">
                                End At
                                <span class="sort"><i class="fa fa-caret-up" aria-hidden="true"></i><i class="fa fa-caret-down" aria-hidden="true"></i></span>
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
                                        <td>  {{ $item->name }}</td>
                                        <td> {{ $item->start_at->format('D-M-Y') }}</td>
                                        <td> {{ $item->end_at->format('D-M-Y') }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="#">Detail</a>
                                                    <a class="dropdown-item" href="{{route('admin.festivals.edit', ['festival' => $item->id])}}">Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="return confirm('Are you sure?')?document.querySelector('#delete_action{{$item->id}}').submit():null; ">Delete</a>
                                                    <form method="POST" id="delete_action{{$item->id}}" action="{{route('admin.festivals.destroy', ['festival' => $item])}}">
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
                        {{$items->links()}}
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


