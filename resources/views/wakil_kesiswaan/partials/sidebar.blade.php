<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Wakil Kesiswaan</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('wakil_kesiswaan.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <li class="nav-item active">
        <a class="nav-link" href="{{ route('wakil_kesiswaan.acara.index') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>Acara</span></a>
    </li>

    <li class="nav-item active">
        <a class="nav-link" href="{{ route('wakil_kesiswaan.histori') }}">
            <i class="fas fa-fw fa-graduation-cap"></i>
            <span>Histori Pendaftaran</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

</ul>