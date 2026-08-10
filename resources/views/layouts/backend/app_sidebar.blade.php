<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center bg-white" href="">
        <div class="sidebar-brand-text mx-3">
            <img  alt="{{ env('APP_NAME') }}" width="150" >
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Manage
    </div>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('user.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Users</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('product.index') }}">
            <i class="fas fa-clipboard-list"></i>
            <span>Products</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('qrcode.index') }}">
            <i class="fa fa-qrcode"></i>
            <span>QR Codes</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('coupon.index') }}">
            <i class="fa fa-gift"></i>
            <span>Coupons</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('order.index') }}">
            <i class="fa fa-shopping-cart"></i>
            <span>Orders</span>
        </a>
    </li>
    <div class="sidebar-heading">
        CMS
    </div>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('page.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Pages</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('faq.index') }}">
            <i class="fas fa-question"></i>
            <span>FAQ</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->