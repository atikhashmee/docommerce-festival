<ul class="list-group">
    <li class="list-group-item @if(Route::currentRouteName() == 'home') active @endif" aria-current="true">
        <a href="{{route('home')}}" class="btn-link">Dashboard</a>
    </li>
    <li class="list-group-item @if(Route::currentRouteName() == 'orders_page') active @endif">
        <a href="{{route('orders_page')}}" class="btn-link">Orders</a>
    </li>
    <li class="list-group-item @if(Route::currentRouteName() == 'profile_page') active @endif">
        <a href="{{route('profile_page')}}" class="btn-link">Profile</a>
    </li> 
</ul>