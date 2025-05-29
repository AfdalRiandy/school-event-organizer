@extends('admin.layouts.app')
@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Admin</h1>
        <a href="{{ route('admin.user.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-user-plus fa-sm text-white-50"></i> Tambah User Baru
        </a>
    </div>

    <!-- Content Row - System Statistics -->
    <div class="row">

        <!-- Total Users Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Pengguna</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ App\Models\User::count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Events Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Acara</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ App\Models\Acara::count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Registrations Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Pendaftaran</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ App\Models\Pendaftaran::count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent User Registrations Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                User Terdaftar (Bulan Ini)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ App\Models\User::whereMonth('created_at', now()->month)
                                        ->whereYear('created_at', now()->year)
                                        ->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-plus fa-2x text-gray-300"></i>
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
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Distribusi Pengguna</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
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
            <div class="card shadow mb-4">
                <div class="card-header py-3">
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
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
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
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-plus fa-3x text-gray-300 mb-3"></i>
                            <p class="text-gray-600 mb-0">Belum ada acara yang dibuat</p>
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
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
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
                        <div class="text-center py-4">
                            <i class="fas fa-users fa-3x text-gray-300 mb-3"></i>
                            <p class="text-gray-600 mb-0">Belum ada pengguna yang terdaftar</p>
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
            <div class="card shadow mb-4">
                <div class="card-header py-3">
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
                        <div class="text-center py-4">
                            <i class="fas fa-clipboard-list fa-3x text-gray-300 mb-3"></i>
                            <p class="text-gray-600 mb-0">Belum ada pendaftaran acara</p>
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