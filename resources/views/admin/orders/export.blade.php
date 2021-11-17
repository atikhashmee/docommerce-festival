@extends('layouts.admin')

@section('title')
    Festivals
@endsection

@section('content')
    <section class="container-fluid" id="festivalTableContainer">
        <div class="card">
            <div class="card-header">
                <form action="{{route("admin.order.export.save")}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 d-flex">
                            <input type="hidden" name="columns" id="columns" value="all">
                            <input type="hidden" name="from" id="filter_date_from">
                            <input type="hidden" name="to" id="filter_date_to">
                            <div class="form-group">
                                <input type="text" class="form-control" id="daterangepicker" placeholder="Start - End Date" autocomplete="off">
                                @error('from')
                                    <span class="text-danger">{{$message}}</span> <br>
                                @enderror
                                @error('to')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                                <a href="javascript:void(0)" class="d-block" data-toggle="modal" data-target="#columnChoseModal">Customize Column</a>
                            </div>
                            <div class="form-group">
                                <select name="format" id="format" class="form-control">
                                    <option value="">Select Format</option>
                                    <option value="xml">XML</option>
                                    <option value="json">JSON</option>
                                    <option value="csv">CSV</option>
                                </select>
                                @error('format')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for=""></label>
                                <div class="btn btn-primary" onclick="submitForm(this)">Export</div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="columnChoseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">   
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title" id="exampleModalLabel">Customize columns</h5>
                        <p>Select the columns that you want to include in your file</p>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="column_form" class="d-flex flex-column">
                        <div><input type="checkbox" name="order_id" value="order_id" checked> Order&nbsp;ID</div>
                        <div><input type="checkbox" name="date" value="date" checked> Date</div>
                        <div><input type="checkbox" name="customer" value="customer" checked> Customer</div>
                        <div><input type="checkbox" name="payment_method" value="payment_method" checked> Payment Method</div>
                        <div><input type="checkbox" name="product_source" value="product_source" checked> Product Source</div>
                        <div><input type="checkbox" name="status" value="status" checked> Status</div>
                        <div><input type="checkbox" name="amount" value="amount" checked> Amount</div>
                    </form>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" onclick="savedCustomizedColumn()" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
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

        function savedCustomizedColumn() {
            let columnsArr = [];
            let elements = document.querySelector('#column_form').elements;
            if (elements.length > 0) {
                for (let index = 0; index < elements.length; index++) {
                    const element = elements[index];
                    if (element.checked) {
                        columnsArr.push(element.name)
                    }
                }
            }
            if (columnsArr.length > 0) {
                document.querySelector('#columns').value = JSON.stringify(columnsArr)
            }
            $("#columnChoseModal").modal('hide')
        }

        function submitForm(obj) 
        {  
            obj.closest('form').submit()
        }

    </script>
@endsection


