@extends('layouts.admin')

@section('title')
    Festival Stores
@endsection

@section('content')
    <section class="container-fluid" id="festivalTableContainer">
        <form action="{{route('admin.festival-stores.index')}}" method="GET" id="filter_form"></form>
        <div class="card">        
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th data-sort="id">
                                #SL
                            </th>
                            <th>Festival</th>
                            <th>Logo</th>
                            <th data-sort="name">
                                Name
                                {{-- <span class="sort">
                                    <i class="fa fa-arrow-up" aria-hidden="true"></i>
                                    <i class="fa fa-arrow-down" aria-hidden="true"></i>
                                </span> --}}
                            </th>
                            <th data-sort="store_domain">
                                Domain
                                {{-- <span class="sort">
                                    <i class="fa fa-arrow-up" aria-hidden="true"></i>
                                    <i class="fa fa-arrow-down" aria-hidden="true"></i>
                                </span> --}}
                            </th>
                        </tr>
                        </thead>
                            @if (count($records) > 0)
                            <tbody id="sorting">
                                @foreach ($records as $item)
                                    <tr class="sortRow" data-id="{{ $item->id }}">
                                        <td>{{ $item->sort }}</td>
                                        <td>{{ $item->festival != null ? $item->festival->name : '-' }}</td>
                                        @if ($item->store != null)
                                            <td>  
                                                @if ($item->img !=null && file_exists(public_path('storage/stores/'.$item->img)))
                                                    <img src="{{ asset('storage/stores/'.$item->img) }}" alt="{{ $item->name }}" height="97" width="176">
                                                @else
                                                    <img src="{{ $item->store->store_logo_url }}" alt="{{ $item->store->name }}" height="97" width="176">
                                                @endif
                                            </td>
                                            <td>  
                                                <h5>{{ $item->store->name }}</h5>
                                                <small> {{ $item->store_slogan }}</small>
                                            </td>
                                            <td>{{ $item->store->store_domain }}</td>
                                        @else
                                            <td> &nbsp;</td>
                                            <td>-</td>
                                            <td>-</td>
                                        @endif
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
            {{-- <div class="card-footer">
                <div class="row">
                    <div class="col-md-6">
                        {{ $records->withQueryString()->links() }}
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
            </div> --}}
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('admin_assets/plugins/jquery-ui.min.js') }}"></script>
    <script>
        $(function () {
            $("#sorting").sortable({
                items: "tr",
                cursor: 'move',
                opacity: 0.6,
                update: function () {
                    sendOrder();
                }
            });

            function sendOrder() {
                var order = [];

                $('tr.sortRow').each(function (index, element) {
                    order.push({
                        id: $(this).attr('data-id'),
                        position: index + 1,
                    });
                });
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('admin.festival-stores.store') }}",
                    data: {
                        order: order,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (res) {
                        if (res.status === 'success') {
                            console.log(res.message);
                        } else {
                            console.log(res.message);
                        }

                    }
                });
            }
        });

        $("#festivalTableContainer").DataSorting({    
            formId : "filter_form",
            initSort : `<?=json_encode(request('sort'))?>`,
            initSearch : `<?=json_encode(request('search'))?>`
        });
    </script>
@endsection


