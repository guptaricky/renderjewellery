<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ Auth::user()->hasRole(['Admin', 'SuperAdmin']) ? route('dashboard.admin') : route('dashboard.user') }}" class="brand-link">
    <img src="{{ Vite::asset('public/dist/img/logo-rj.png') }}" alt="RJ" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Render Jewellery</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        @php
            $profile_picture = Auth::user()->profile_picture ?? 'blank_profile.png';
        @endphp
          <img src="{{ Vite::asset('public/dist/img/'.$profile_picture) }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="{{ route('profile.view') }}" class="d-block">{{ Auth::user()->name }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="{{ Auth::user()->hasRole(['Admin', 'SuperAdmin']) ? route('dashboard.admin') : route('dashboard.user') }}" class="nav-link active">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        @if (Auth::user()->hasRole(['Admin', 'SuperAdmin']))
        <li class="nav-header">MASTERS</li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-list-ul"></i>
            <p>
              MASTERS
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('plan.create') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Plan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('productCategories.create') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Category</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('productSubCategories.create') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Sub Category</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="{{ route('user.list') }}" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Users
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('products.productList') }}" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Products
            </p>
          </a>
        </li>
        
        <li class="nav-item">
          <a href="{{ route('orders.orderList') }}" class="nav-link">
            <i class="nav-icon fas fa-cart-arrow-down"></i>
            <p>
              Orders
            </p>
          </a>
        </li>
        @else
        <li class="nav-item">
          <a href="{{ route('products.create') }}" class="nav-link">
            <i class="nav-icon fas fa-plus"></i>
            <p>
              Create Product
            </p>
          </a>
        </li>
        @endif
        

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>