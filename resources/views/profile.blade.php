@extends('layouts.app')

@section('content')
<section class="w-100 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route('index_page')}}">Home</a></li>
                      <li class="breadcrumb-item"><a href="javascript:void(0)">User</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Profile</li>
                    </ol>
                  </nav>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            @include('web-components._user_nav')
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Your Info</div>
                <div class="card-body">
                    <form action="{{route('profile_update_page')}}" method="post">
                        @method('put')
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="text" class="form-control" name="email" value="{{ auth()->user()->email }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Phone</label>
                                    <input type="text" class="form-control" name="phone_number" value="{{ auth()->user()->phone_number }}">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-warning">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
