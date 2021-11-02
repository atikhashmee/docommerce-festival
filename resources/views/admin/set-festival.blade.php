@extends('layouts.admin')

@section('content')
    <section class="container-fluid py-3">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <form action="{{route("admin.dashboard.postFestival")}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="">Select Festival 
                        <a href="{{route('admin.festivals.create')}}">Create</a></label>
                        <select class="form-control" name="festival_id" id="festival_id">
                            <option value="">Select Festival</option>
                            @foreach ($festivals as $festival)
                                <option value="{{ $festival->id }}">{{ $festival->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-primary">Save Changes</button>
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </section>
@endsection


