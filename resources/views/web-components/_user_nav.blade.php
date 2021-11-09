<ul class="list-group">
    {{-- <li class="list-group-item @if(Route::currentRouteName() == 'home') active @endif" aria-current="true">
        <a href="{{route('home')}}" class="btn-link">Dashboard</a>
    </li> --}}
    <li class="list-group-item">
        <a href="{{route('orders_page')}}">Orders</a>
    </li>
    <li>
        <a href="javascript:void(0)"  onclick="event.preventDefault();
            document.getElementById('logout-form').submit();" class="btn btn-outline-success btn-sm ml-3">Logout</a>
    </li>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
</ul>