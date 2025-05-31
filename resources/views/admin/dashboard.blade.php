@extends('admin.layouts.app')
@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="mb-4 d-sm-flex align-items-center justify-content-between">
        <h1 class="mb-0 text-gray-800 h3">Dashboard Admin</h1>
        <a href="{{ route('admin.user.create') }}" class="shadow-sm d-none d-sm-inline-block btn btn-sm btn-primary">
            <i class="fas fa-user-plus fa-sm text-white-50"></i> Tambah User Baru
        </a>
    </div>

    <!-- Content Row - System Statistics -->
    <div class="row">

        <!-- Total Users Card -->
        <div class="mb-4 col-xl-3 col-md-6">
            <div class="py-2 shadow card border-left-primary h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="mr-2 col">
                            <div class="mb-1 text-xs font-weight-bold text-primary text-uppercase">
                                Total Pengguna</div>
                            <div class="mb-0 text-gray-800 h5 font-weight-bold">
                                {{ App\Models\User::count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="text-gray-300 fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Events Card -->
        <div class="mb-4 col-xl-3 col-md-6">
            <div class="py-2 shadow card border-left-success h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="mr-2 col">
                            <div class="mb-1 text-xs font-weight-bold text-success text-uppercase">
                                Total Acara</div>
                            <div class="mb-0 text-gray-800 h5 font-weight-bold">
                                {{ App\Models\Acara::count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="text-gray-300 fas fa-calendar-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Registrations Card -->
        <div class="mb-4 col-xl-3 col-md-6">
            <div class="py-2 shadow card border-left-info h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="mr-2 col">
                            <div class="mb-1 text-xs font-weight-bold text-info text-uppercase">
                                Total Pendaftaran</div>
                            <div class="mb-0 text-gray-800 h5 font-weight-bold">
                                {{ App\Models\Pendaftaran::count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="text-gray-300 fas fa-clipboard-list fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent User Registrations Card -->
        <div class="mb-4 col-xl-3 col-md-6">
            <div class="py-2 shadow card border-left-warning h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="mr-2 col">
                            <div class="mb-1 text-xs font-weight-bold text-warning text-uppercase">
                                User Terdaftar (Bulan Ini)</div>
                            <div class="mb-0 text-gray-800 h5 font-weight-bold">
                                {{ App\Models\User::whereMonth('created_at', now()->month)
                                        ->whereYear('created_at', now()->year)
                                        ->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="text-gray-300 fas fa-user-plus fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<!-- Reports & Statistics Section -->
<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="mb-4 shadow card">
            <div class="flex-row py-3 card-header d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Cetak Laporan & Statistik</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- User Reports -->
                    <div class="mb-4 col-lg-4 col-md-6">
                        <div class="card border-left-primary h-100">
                            <div class="card-body">
                                <h5 class="mb-3 card-title font-weight-bold text-primary">Laporan Pengguna</h5>
                                <p class="mb-3 card-text">Laporan lengkap tentang pengguna sistem berdasarkan role, waktu pendaftaran, dan aktivitas.</p>
                                <div class="mt-3">
                                    <a href="{{ route('admin.reports.users') }}" class="btn btn-primary btn-sm" target="_blank">
                                        <i class="mr-1 fas fa-file-pdf"></i> Semua Pengguna
                                    </a>
                                    <div class="ml-2 dropdown d-inline-block">
                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="userReportDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="mr-1 fas fa-filter"></i> Filter
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="userReportDropdown">
                                            <a class="dropdown-item" href="{{ route('admin.reports.users', ['role' => 'siswa']) }}" target="_blank">Siswa</a>
                                            <a class="dropdown-item" href="{{ route('admin.reports.users', ['role' => 'panitia']) }}" target="_blank">Panitia</a>
                                            <a class="dropdown-item" href="{{ route('admin.reports.users', ['role' => 'wakil_kesiswaan']) }}" target="_blank">Wakil Kesiswaan</a>
                                            <a class="dropdown-item" href="{{ route('admin.reports.users', ['role' => 'admin']) }}" target="_blank">Admin</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="{{ route('admin.reports.users', ['period' => 'month']) }}" target="_blank">Bulan Ini</a>
                                            <a class="dropdown-item" href="{{ route('admin.reports.users', ['period' => 'year']) }}" target="_blank">Tahun Ini</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Event Reports -->
                    <div class="mb-4 col-lg-4 col-md-6">
                        <div class="card border-left-success h-100">
                            <div class="card-body">
                                <h5 class="mb-3 card-title font-weight-bold text-success">Laporan Acara</h5>
                                <p class="mb-3 card-text">Laporan detail tentang acara yang diselenggarakan, jumlah pendaftar, dan status persetujuan.</p>
                                <div class="mt-3">
                                    <a href="{{ route('admin.reports.events') }}" class="btn btn-success btn-sm" target="_blank">
                                        <i class="mr-1 fas fa-file-pdf"></i> Semua Acara
                                    </a>
                                    <div class="ml-2 dropdown d-inline-block">
                                        <button class="btn btn-success btn-sm dropdown-toggle" type="button" id="eventReportDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="mr-1 fas fa-filter"></i> Filter
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="eventReportDropdown">
                                            <a class="dropdown-item" href="{{ route('admin.reports.events', ['status' => 'disetujui']) }}" target="_blank">Acara Disetujui</a>
                                            <a class="dropdown-item" href="{{ route('admin.reports.events', ['status' => 'pending']) }}" target="_blank">Acara Pending</a>
                                            <a class="dropdown-item" href="{{ route('admin.reports.events', ['status' => 'ditolak']) }}" target="_blank">Acara Ditolak</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="{{ route('admin.reports.events', ['period' => 'month']) }}" target="_blank">Bulan Ini</a>
                                            <a class="dropdown-item" href="{{ route('admin.reports.events', ['period' => 'upcoming']) }}" target="_blank">Acara Mendatang</a>
                                            <a class="dropdown-item" href="{{ route('admin.reports.events', ['period' => 'past']) }}" target="_blank">Acara Selesai</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Registration Reports -->
                    <div class="mb-4 col-lg-4 col-md-6">
                        <div class="card border-left-info h-100">
                            <div class="card-body">
                                <h5 class="mb-3 card-title font-weight-bold text-info">Laporan Pendaftaran</h5>
                                <p class="mb-3 card-text">Laporan lengkap tentang pendaftaran acara, status pendaftaran, dan kehadiran siswa.</p>
                                <div class="mt-3">
                                    <a href="{{ route('admin.reports.registrations') }}" class="btn btn-info btn-sm" target="_blank">
                                        <i class="mr-1 fas fa-file-pdf"></i> Semua Pendaftaran
                                    </a>
                                    <div class="ml-2 dropdown d-inline-block">
                                        <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="registrationReportDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="mr-1 fas fa-filter"></i> Filter
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="registrationReportDropdown">
                                            <a class="dropdown-item" href="{{ route('admin.reports.registrations', ['status' => 'disetujui']) }}" target="_blank">Pendaftaran Disetujui</a>
                                            <a class="dropdown-item" href="{{ route('admin.reports.registrations', ['status' => 'pending']) }}" target="_blank">Pendaftaran Pending</a>
                                            <a class="dropdown-item" href="{{ route('admin.reports.registrations', ['status' => 'ditolak']) }}" target="_blank">Pendaftaran Ditolak</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="{{ route('admin.reports.registrations', ['period' => 'today']) }}" target="_blank">Hari Ini</a>
                                            <a class="dropdown-item" href="{{ route('admin.reports.registrations', ['period' => 'week']) }}" target="_blank">Minggu Ini</a>
                                            <a class="dropdown-item" href="{{ route('admin.reports.registrations', ['period' => 'month']) }}" target="_blank">Bulan Ini</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Summary Report -->
                    <div class="mb-4 col-lg-4 col-md-6">
                        <div class="card border-left-warning h-100">
                            <div class="card-body">
                                <h5 class="mb-3 card-title font-weight-bold text-warning">Laporan Ringkasan</h5>
                                <p class="mb-3 card-text">Laporan ringkasan seluruh aktivitas sistem, statistik, dan grafik performa.</p>
                                <div class="mt-3">
                                    <a href="{{ route('admin.reports.summary') }}" class="btn btn-warning btn-sm" target="_blank">
                                        <i class="mr-1 fas fa-file-pdf"></i> Laporan Lengkap
                                    </a>
                                    <div class="ml-2 dropdown d-inline-block">
                                        <button class="btn btn-warning btn-sm dropdown-toggle" type="button" id="summaryReportDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="mr-1 fas fa-calendar"></i> Periode
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="summaryReportDropdown">
                                            <a class="dropdown-item" href="{{ route('admin.reports.summary', ['period' => 'month']) }}" target="_blank">Bulanan</a>
                                            <a class="dropdown-item" href="{{ route('admin.reports.summary', ['period' => 'quarter']) }}" target="_blank">Per 3 Bulan</a>
                                            <a class="dropdown-item" href="{{ route('admin.reports.summary', ['period' => 'semester']) }}" target="_blank">Per Semester</a>
                                            <a class="dropdown-item" href="{{ route('admin.reports.summary', ['period' => 'year']) }}" target="_blank">Tahunan</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Custom Reports -->
                    <div class="mb-4 col-lg-8 col-md-12">
                        <div class="card border-left-dark h-100">
                            <div class="card-body">
                                <h5 class="mb-3 card-title font-weight-bold text-dark">Laporan Kustom</h5>
                                <p class="mb-3 card-text">Buat laporan kustom dengan memilih periode tanggal, jenis data, dan filter khusus sesuai kebutuhan.</p>
                                
                                <form action="{{ route('admin.reports.custom') }}" method="GET" target="_blank" class="mt-3">
                                    <div class="form-row">
                                        <div class="mb-2 col-md-3">
                                            <label for="report_type">Jenis Laporan</label>
                                            <select class="form-control form-control-sm" id="report_type" name="type">
                                                <option value="all">Semua Data</option>
                                                <option value="users">Pengguna</option>
                                                <option value="events">Acara</option>
                                                <option value="registrations">Pendaftaran</option>
                                            </select>
                                        </div>
                                        <div class="mb-2 col-md-3">
                                            <label for="date_start">Tanggal Mulai</label>
                                            <input type="date" class="form-control form-control-sm" id="date_start" name="date_start">
                                        </div>
                                        <div class="mb-2 col-md-3">
                                            <label for="date_end">Tanggal Akhir</label>
                                            <input type="date" class="form-control form-control-sm" id="date_end" name="date_end">
                                        </div>
                                        <div class="mb-2 col-md-3">
                                            <label for="sort_by">Urutkan Berdasarkan</label>
                                            <select class="form-control form-control-sm" id="sort_by" name="sort">
                                                <option value="latest">Terbaru</option>
                                                <option value="oldest">Terlama</option>
                                                <option value="name">Nama/Judul</option>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="mt-2 btn btn-dark btn-sm">
                                        <i class="mr-1 fas fa-file-pdf"></i> Generate Laporan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- User Distribution Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="mb-4 shadow card">
                <div class="flex-row py-3 card-header d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Distribusi Pengguna</h6>
                </div>
                <div class="card-body">
                    <div class="pt-4 pb-2 chart-pie">
                        <canvas id="userRoleChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> Admin
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Siswa
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-info"></i> Panitia
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-warning"></i> Wakil Kesiswaan
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="col-xl-4 col-lg-5">
            <div class="mb-4 shadow card">
                <div class="py-3 card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik Lanjutan</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h4 class="small font-weight-bold">Pengguna Berdasarkan Role</h4>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Admin
                                <span class="badge badge-primary badge-pill">{{ App\Models\User::where('role', 'admin')->count() }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Siswa
                                <span class="badge badge-success badge-pill">{{ App\Models\User::where('role', 'siswa')->count() }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Panitia
                                <span class="badge badge-info badge-pill">{{ App\Models\User::where('role', 'panitia')->count() }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Wakil Kesiswaan
                                <span class="badge badge-warning badge-pill">{{ App\Models\User::where('role', 'wakil_kesiswaan')->count() }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Latest Events -->
        <div class="col-xl-6 col-lg-6">
            <div class="mb-4 shadow card">
                <div class="flex-row py-3 card-header d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Acara Terbaru</h6>
                    <a href="{{ route('admin.acara.index') }}" class="btn btn-sm btn-primary">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    @php
                        $latestEvents = App\Models\Acara::with('panitia.user')
                            ->latest()
                            ->take(5)
                            ->get();
                    @endphp

                    @if($latestEvents->isEmpty())
                        <div class="py-4 text-center">
                            <i class="mb-3 text-gray-300 fas fa-calendar-plus fa-3x"></i>
                            <p class="mb-0 text-gray-600">Belum ada acara yang dibuat</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Judul</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Penyelenggara</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($latestEvents as $acara)
                                        <tr>
                                            <td>{{ $acara->judul }}</td>
                                            <td>{{ \Carbon\Carbon::parse($acara->tanggal_acara)->format('d M Y') }}</td>
                                            <td>{!! $acara->status_badge !!}</td>
                                            <td>{{ $acara->panitia->user->name }}</td>
                                            <td>
                                                <a href="{{ route('admin.acara.show', $acara->id) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Latest User Registrations -->
        <div class="col-xl-6 col-lg-6">
            <div class="mb-4 shadow card">
                <div class="flex-row py-3 card-header d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Pengguna Terbaru</h6>
                    <a href="{{ route('admin.user.index') }}" class="btn btn-sm btn-primary">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    @php
                        $recentUsers = App\Models\User::latest()->take(5)->get();
                    @endphp

                    @if($recentUsers->isEmpty())
                        <div class="py-4 text-center">
                            <i class="mb-3 text-gray-300 fas fa-users fa-3x"></i>
                            <p class="mb-0 text-gray-600">Belum ada pengguna yang terdaftar</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Tanggal Daftar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentUsers as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if($user->role == 'admin')
                                                    <span class="badge badge-primary">Admin</span>
                                                @elseif($user->role == 'siswa')
                                                    <span class="badge badge-success">Siswa</span>
                                                @elseif($user->role == 'panitia')
                                                    <span class="badge badge-info">Panitia</span>
                                                @elseif($user->role == 'wakil_kesiswaan')
                                                    <span class="badge badge-warning">Wakil Kesiswaan</span>
                                                @endif
                                            </td>
                                            <td>{{ $user->created_at->format('d M Y') }}</td>
                                            <td>
                                                <a href="{{ route('admin.user.show', $user->id) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Event Registrations -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="mb-4 shadow card">
                <div class="py-3 card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Pendaftaran Acara Terbaru</h6>
                </div>
                <div class="card-body">
                    @php
                        $recentRegistrations = App\Models\Pendaftaran::with(['acara', 'siswa.user'])
                            ->latest()
                            ->take(10)
                            ->get();
                    @endphp

                    @if($recentRegistrations->isEmpty())
                        <div class="py-4 text-center">
                            <i class="mb-3 text-gray-300 fas fa-clipboard-list fa-3x"></i>
                            <p class="mb-0 text-gray-600">Belum ada pendaftaran acara</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Acara</th>
                                        <th>Nama Siswa</th>
                                        <th>NIS</th>
                                        <th>Kelas</th>
                                        <th>Jurusan</th>
                                        <th>Tanggal Pendaftaran</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentRegistrations as $pendaftaran)
                                        <tr>
                                            <td>{{ $pendaftaran->acara->judul }}</td>
                                            <td>{{ $pendaftaran->siswa->user->name }}</td>
                                            <td>{{ $pendaftaran->siswa->nis }}</td>
                                            <td>{{ $pendaftaran->siswa->kelas }}</td>
                                            <td>{{ $pendaftaran->siswa->jurusan }}</td>
                                            <td>{{ $pendaftaran->created_at->format('d-m-Y H:i') }}</td>
                                            <td>{!! $pendaftaran->status_badge !!}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/vendor/chart.js/Chart.min.js') }}"></script>
<script>
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';

    // Pie Chart for User Roles
    var ctx = document.getElementById("userRoleChart");
    var adminCount = {{ App\Models\User::where('role', 'admin')->count() }};
    var siswaCount = {{ App\Models\User::where('role', 'siswa')->count() }};
    var panitiaCount = {{ App\Models\User::where('role', 'panitia')->count() }};
    var wakilKesiswaanCount = {{ App\Models\User::where('role', 'wakil_kesiswaan')->count() }};
    
    var userRoleChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["Admin", "Siswa", "Panitia", "Wakil Kesiswaan"],
            datasets: [{
                data: [adminCount, siswaCount, panitiaCount, wakilKesiswaanCount],
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e'],
                hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#dda20a'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
            legend: {
                display: false
            },
            cutoutPercentage: 80,
        },
    });

    $(document).ready(function() {
        $('#dataTable').DataTable({
            "language": {
                "lengthMenu": "Tampilkan _MENU_ data",
                "search": "Cari:",
                "zeroRecords": "Tidak ada data yang cocok",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "infoEmpty": "Tidak ada data yang ditampilkan",
                "infoFiltered": "(difilter dari _MAX_ total data)",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            }
        });
    });
</script>
@endsection