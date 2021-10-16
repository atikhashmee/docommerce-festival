
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

<form action="{{route('festivals.store')}}" method="post" id="create_form">
    @csrf
    <input type="text" name="name">
    <input type="date" name="start_at">
    <input type="date" name="end_at">
    <button type="button" onclick="saveData()">submit</button>
</form>

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