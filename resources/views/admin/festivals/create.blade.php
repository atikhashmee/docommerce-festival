@extends('layouts.admin')

@section('title')
    Festivals Create
@endsection

@section('content')
    <section class="container">
        <div class="card">
            <div class="card-header">
                <a class="btn btn-secondary float-right" href="{{route('admin.festivals.index')}}"><i class="fas fa-angle-double-left"></i> Back</a>
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
                <form action="{{route('admin.festivals.store')}}" method="post" id="create_form">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="start_at">Start At</label>
                        <input type="date" id="start_at" name="start_at" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="end_at">End At</label>
                        <input type="date" id="end_at" name="end_at" class="form-control" />
                    </div>
                    <button type="submit" class="btn btn-success">submit</button>
                </form>
            </div>
            {{-- <div class="card-footer"></div> --}}
        </div>
    </section>
@endsection

<script>
    function saveData() {
        let form = document.querySelector('#create_form')
        fetch(form.getAttribute('action'), {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN' : `{{csrf_token()}}`,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: new FormData(form)
        }).then(res=>res.json())
        .then(res=>{
            console.log(res, 'asdf');
        })
    }
</script>