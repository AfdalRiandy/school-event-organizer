<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">PANITIA</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('panitia.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <li class="nav-item active">
        <a class="nav-link" href="{{ route('panitia.acara.index') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>Acara</span></a>
    </li>

    <li class="nav-item active">
        <a class="nav-link" href="{{ route('panitia.pendaftar.all') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Pendaftar</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

</ul>