@extends('layouts.admin')

@section('title')
    Festivals Edit
@endsection

@section('content')
    <section class="container">
        <div class="card">
            <div class="card-header">
                <a class="btn btn-secondary float-right" href="{{route('admin.users.index')}}"><i class="fas fa-angle-double-left"></i> Back</a>
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
                <form action="{{route('admin.users.update', ['user' => $item->id])}}" method="POST" id="create_form">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="name">Name<span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" class="form-control" value="{{$item->name}}" />
                    </div>
                    <div class="form-group">
                        <label for="email">Email<span class="text-danger">*</span></label>
                        <input type="text" id="email" name="email" class="form-control" value="{{$item->email}}" />
                    </div>
                    <div class="form-group">
                        <label for="phone_number">Phone Number<span class="text-danger">*</span></label>
                        <input type="text" id="phone_number" name="phone_number" class="form-control" value="{{$item->phone_number}}" />
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="text" id="password" name="password" class="form-control" />
                    </div>
                    <button type="submit" class="btn btn-success">Update</button>
                </form>
            </div>
            {{-- <div class="card-footer"></div> --}}
        </div>
    </section>
@endsection