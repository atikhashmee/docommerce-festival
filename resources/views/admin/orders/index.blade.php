@extends('layouts.admin')

@section('title')
    Festivals
@endsection

@section('content')
    <section class="container-fluid" id="festivalTableContainer">
        <form action="{{route('admin.orders.index')}}" method="GET" id="filter_form">
            <input type="hidden" name="from" id="filter_date_from">
            <input type="hidden" name="to" id="filter_date_to">
            <input type="hidden" name="status" id="statusFilter">
            <input type="hidden" name="search_key" id="searchTxt">
        </form>
      
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <a href="javascript:void(0)" onclick="changeFilter('all', 'filter')" class="btn btn-primary">All<span class="sr-only">(current)</span></a>
                        <a href="javascript:void(0)" onclick="changeFilter('Pending', 'filter')" class="btn btn-primary">Pending<span class="sr-only" >(current)</span></a>
                        <a href="javascript:void(0)" onclick="changeFilter('In Progress', 'filter')" class="btn btn-primary">In Progress<span class="sr-only">(current)</span></a>
                        <a href="javascript:void(0)" onclick="changeFilter('Delivered', 'filter')" class="btn btn-primary">Delivered<span class="sr-only">(current)</span></a>
                        {{-- <a href="javascript:void(0)" onclick="changeFilter('Failed', 'filter')" class="btn btn-primary">Failed<span class="sr-only">(current)</span></a> --}}
                    </div>
                    <div class="col-md-6">
                        <div class="form-inline justify-content-end">
                            <a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal" data-target="#export"><i class="fa fa-cloud-download" aria-hidden="true"></i>Export</a>
                            <div class="form-group">
                                <input type="text" class="form-control" id="daterangepicker" placeholder="Start - End Date" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <input class="form-control" onblur="searchData(this)" placeholder="Order Id, Customer" name="keyword" type="search">
                            </div>
                            <div class="btn btn-primary" onclick="submitForm()"><i class="fa fa-search" aria-hidden="true"></i></div>
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
                                SL
                                {{-- <button type="button" class="btn btn-xs btn-default checkbox-toggle p-0"
                                        @click="checkAll">
                                    <input type="checkbox" name="select_all" class="hidden">
                                    <i id="check-all-icon" class="fa fa-square-o" data-toggle="tooltip"
                                       data-placement="top" title="Select All"></i>
                                </button> --}}
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
                                @foreach ($orders as $key => $order)
                                    <tr>
                                        <td>
                                            {{++$key}}
                                            {{-- <input name="ids[]" type="checkbox" class="massCheck" @change="checkSpecific" value="{{$order->id}}"> --}}
                                        </td>
                                        <td>  {{ strtotime($order->order_number) }} </td>
                                        <td>  {{ $order->created_at }} </td>
                                        <td>  {{ $order->user->name }} </td>
                                        <td>  Cash-on                  </td>
                                        <td> {{ $order->orderDetails[0]->store->name ?? 'N/A'  }}</td>
                                        <td>  {{ $order->status  }}</td>
                                        <td>  ৳{{ $order->total_final_amount  }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="{{route("admin.orders.show", ['order' => $order->id])}}">Detail</a>
                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="changeStatus('Confirmed', {{ $order->id }})">Confirm</a>
                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="changeStatus('Canceled', {{ $order->id }})">Cancel</a>
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
    </section>
@endsection
@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>

        $('#daterangepicker').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $('#daterangepicker').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            $("#filter_date_from").val(picker.startDate.format('YYYY-MM-DD'))
            $("#filter_date_to").val(picker.endDate.format('YYYY-MM-DD'))
        });

        $('#daterangepicker').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            $("#filter_date_from").val('')
            $("#filter_date_to").val('')
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

        function changeFilter(status, type) {
            if (type==='filter') {
                $("#statusFilter").val(status)
                submitForm();
            }
        }

        function searchData(evt) {
            document.querySelector("#searchTxt").value = evt.value
        }
        function submitForm() {
            $("#filter_form").submit()
        }
    </script>
@endsection


