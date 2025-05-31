<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('panitia.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="mx-3 sidebar-brand-text">PANITIA</div>
    </a>

    <!-- Divider -->
    <hr class="my-0 sidebar-divider">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('panitia.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('panitia.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Nav Item - Events -->
    <li class="nav-item {{ request()->routeIs('panitia.acara.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('panitia.acara.index') }}">
            <i class="fas fa-fw fa-calendar"></i>
            <span>Acara</span>
        </a>
    </li>

    <!-- Nav Item - Registrants -->
    <li class="nav-item {{ request()->routeIs('panitia.pendaftar.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('panitia.pendaftar.all') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Pendaftar</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

</ul>