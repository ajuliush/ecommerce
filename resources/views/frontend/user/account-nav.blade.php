<ul class="account-nav">
    <li><a href="{{ route('dashboard') }}" class="menu-link menu-link_us-s  {{ request()->routeIs('dashboard') ? 'menu-link_active' : ''}}">Dashboard</a></li>
    <li><a href="{{ route('order.index') }}" class="menu-link menu-link_us-s {{ request()->routeIs('order.index') ? 'menu-link_active' : ''}}">Orders</a></li>
    <li><a href="account-address.html" class="menu-link menu-link_us-s">Addresses</a></li>
    <li><a href="account-details.html" class="menu-link menu-link_us-s">Account Details</a></li>
    <li><a href="account-wishlist.html" class="menu-link menu-link_us-s">Wishlist</a></li>
    <li>
        <form method="POST" action="{{ route('logout') }}" style="display: none;" id="logout-form">
            @csrf
        </form>
        <a href="{{ route('logout') }}" class="menu-link menu-link_us-s" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
        </a>
    </li>

</ul>
