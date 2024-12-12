<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      
      <!-- Messages Dropdown Menu -->
      
      <!-- Notifications Dropdown Menu -->
      
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <x-dropdown-link :href="route('cart')">
            <i class="fas fa-shopping-cart"><span id="cart-count" style="font-family:'Source Sans Pro';font-size: 12px; color: white; background: red; border-radius: 50%; padding: 2px 5px; position: absolute; top: 2px; right: 6px;">
              0
          </span></i>
        </x-dropdown-link>
    </li>
      <li class="nav-item d-none d-sm-inline-block">
          <x-dropdown-link :href="route('profile.view')">
              {{ __('Profile') }}
          </x-dropdown-link>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
          <form method="POST" action="{{ route('logout') }}">
              @csrf

              <x-dropdown-link :href="route('logout')"
                      onclick="event.preventDefault();
                                  this.closest('form').submit();">
                  {{ __('Log Out') }}
              </x-dropdown-link>
          </form>
      </li>
    </ul>
  </nav>