
  <div class="col-lg-2">
    <ul class="account-nav">
      <li><a href="{{route('user.index')}}" class="menu-link menu-link_us-s ">Dashboard</a></li>
      <li><a href="{{route('user.orders')}}" class="menu-link menu-link_us-s">My Orders</a></li>
      <li><a href="{{route('address.index')}}" class="menu-link menu-link_us-s">Addresses</a></li>
      <li><a href="{{route('account.details')}}" class="menu-link menu-link_us-s">Account Details</a></li>
      <li><a href="account-wishlist.html" class="menu-link menu-link_us-s">Wishlist</a></li>
      <li>
        <form action="{{route('logout')}}" method="post" id="logout-form">
            @csrf
            <a href="{{route('logout')}}" class="menu-link menu-link_us-s" onclick="event.preventDefault(); getElementById('logout-form').submit();">Logout</a>
        </form>
    </li>
    </ul>
  </div>