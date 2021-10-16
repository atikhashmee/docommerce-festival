
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{route('stores.store')}}" method="post">
    @csrf
    <input type="text" name="name">
    <input type="date" name="start_at">
    <input type="date" name="end_at">
    <button type="submit">submit</button>
</form>