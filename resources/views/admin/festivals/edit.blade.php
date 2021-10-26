@extends('layouts.admin')

@section('title')
    Festivals Edit
@endsection

@section('content')
    <section class="container-fluid">
        <div class="card">
            <div class="card-header">
                <a class="btn btn-secondary float-right" href="{{route('admin.festivals.index')}}">Back</a>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('success'))
                    {{ session('success') }}
                @endif

                @if (session('error'))
                    {{ session('error') }}
                @endif
                <form action="{{route('admin.festivals.update', ['festival' => $item->id])}}" method="POST" id="create_form">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{$item->name}}" />
                    </div>
                    <div class="form-group">
                        <label for="start_at">Start At</label>
                        <input type="date" id="start_at" name="start_at" class="form-control"  value="{{$item->start_at->format('Y-m-d')}}" />
                    </div>
                    <div class="form-group">
                        <label for="end_at">End At</label>
                        <input type="date" id="end_at" name="end_at" class="form-control"  value="{{$item->end_at->format('Y-m-d')}}" />
                    </div>
                    <button type="submit" class="btn btn-success">Update</button>
                </form>
            </div>
            {{-- <div class="card-footer"></div> --}}
        </div>
    </section>
@endsection