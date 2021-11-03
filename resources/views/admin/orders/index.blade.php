@extends('layouts.admin')

@section('title')
    Festivals
@endsection

@section('content')
    <section class="container-fluid" id="festivalTableContainer">
        <form action="{{route('admin.orders.index')}}" method="GET" id="filter_form"></form>
      
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6 col-sm-6 second-child-menu">
                        <a href="javascript:void(0)"
                           class="btn btn-primary">All
                            <span class="sr-only">(current)</span>
                        </a>
        
                        <a href="javascript:void(0)"
                           class="btn btn-primary">Pending
                            <span class="sr-only" >(current)</span>
                        </a>
        
                        <a href="javascript:void(0)"
                           class="btn btn-primary">In Progress
                            <span class="sr-only">(current)</span>
                        </a>
        
                        <a href="javascript:void(0)"
                           class="btn btn-primary">Delivered
                            <span class="sr-only">(current)</span>
                        </a>
        
                        <a href="javascript:void(0)"
                           class="btn btn-primary">Failed
                            <span class="sr-only">(current)</span>
                        </a>
                    </div>
                    <div class="col-md-6 second-child-menu form-inline text-right">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-inline">
                                        <a href="javascript:void(0)" class="btn btn-primary"
                                           data-toggle="modal"
                                           data-target="#export"><i class="fa fa-cloud-download" aria-hidden="true"></i>
                                            &nbsp;&nbsp;Export</a>
        
                                    <div class="input-group">
                                        <div class="form-group">
                                            <input type="text" id="datepicker-from" name="from"
                                                   placeholder="From"
                                                   class="form-control w-150">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="datepicker-to" name="to"
                                                   placeholder="To"
                                                   class="form-control w-150">
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control w-150"
                                                   placeholder="{{ __('order.order_id') . ", " . __('order.customer') }}"
                                                   name="keyword" v-model="params.keyword" type="search"
                                                   @keyup.enter="updateCurrentPage">
                                        </div>
                                        <div class="btn btn-primary"><i
                                                class="fa fa-search" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th class="massActionWrapper">
                                <button type="button" class="btn btn-xs btn-default checkbox-toggle p-0"
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
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Payment Method</th>
                            <th>Product Source</th>
                            <th>Status</th>
                            <th>Amount</th>
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
                                        <td>  {{ $order->id }} </td>
                                        <td>  {{ $order->created_at }} </td>
                                        <td>  {{ $order->user->name }} </td>
                                        <td>  Cash-on                  </td>
                                        <td> {{ $order->orderDetails[0]->store->name ?? 'N/A'  }}</td>
                                        <td>  {{ $order->status  }}</td>
                                        <td>  {{ $order->total_final_amount  }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="{{route("admin.orders.show", ['order' => $order->id])}}">Detail</a>
                                                    <a class="dropdown-item" href="{{route("admin.order.change.status", ["order_id" => $order->id])}}">Change Status</a>
                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="changeStatus('Canceled', {{ $order->id }})">Cancel & Refund</a>
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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $("#festivalTableContainer").DataSorting({    
            formId : "filter_form",
            initSort : `<?=json_encode(request('sort'))?>`,
            initSearch : `<?=json_encode(request('search'))?>`
        });

        function changeStatus(status, order_id) {
        Swal.fire({
            title: 'Are you sure?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: `Yes, change it!`
        }).then((result) => {
            if (result.value) {
                updateStatus(status, order_id);
            }
        });
    }

    function updateStatus(status, order_id) {
        let formD = new FormData();
        formD.append("status", status);
        formD.append("order_id", order_id);
        fetch(`{{route("admin.order.update.change")}}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN' : `{{csrf_token()}}`,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formD
        }).then(res=>res.json())
        .then(res=>{
            if (!res.status) {
                let messages = '';
                if (typeof(res.data) === 'object') {
                    for (const [key, value] of Object.entries(res.data)) {
                        messages += '<li>' + value[0] + '</li>';
                    }
                } else {
                    messages = res.data;
                }

                Swal.fire({
                    type: 'error',
                    title: 'Whoops! Something went wrong!',
                    html: '    <div class="alert alert-danger">\n' +
                        '        <ul>\n' +
                        messages +
                        '        </ul>\n' +
                        '    </div>\n'
                });
            } else {
                window.location.reload()
            }
        })
    }
    </script>
@endsection


