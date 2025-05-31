<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('siswa.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="mx-3 sidebar-brand-text">SISWA</div>
    </a>

    <!-- Divider -->
    <hr class="my-0 sidebar-divider">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('siswa.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Nav Item - Events -->
    <li class="nav-item {{ request()->routeIs('siswa.acara.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('siswa.acara.index') }}">
            <i class="fas fa-fw fa-calendar"></i>
            <span>Acara</span>
        </a>
    </li>

    <!-- Nav Item - Registration History -->
    <li class="nav-item {{ request()->routeIs('siswa.pendaftaran.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('siswa.pendaftaran.index') }}">
            <i class="fas fa-fw fa-history"></i>
            <span>Histori Pendaftaran</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

</ul>