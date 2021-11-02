@extends('layouts.admin')

@section('title')
    Festivals Edit
@endsection

@section('content')
    <section class="container">
        <div class="card">
            <div class="card-header">
                <a class="btn btn-secondary float-right" href="{{route('admin.categories.index')}}"><i class="fas fa-angle-double-left"></i> Back</a>
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
                <form action="{{route('admin.categories.update', ['category' => $item->id])}}" method="POST" id="create_form">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{$item->name}}" />
                    </div>
                    <button type="submit" class="btn btn-success">Update</button>
                </form>
            </div>
            {{-- <div class="card-footer"></div> --}}
        </div>
    </section>
@endsection