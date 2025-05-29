@extends('wakil_kesiswaan.layouts.app')
@section('title', 'Dashboard Wakil Kesiswaan')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="{{ route('wakil_kesiswaan.acara.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-calendar-check fa-sm text-white-50"></i> Persetujuan Acara
        </a>
    </div>

    <!-- Content Row - Statistics -->
    <div class="row">

        <!-- Total Events Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
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

        <!-- Approved Events Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Acara Disetujui</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ App\Models\Acara::where('status', 'disetujui')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Events Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Menunggu Persetujuan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ App\Models\Acara::where('status', 'pending')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Students Registered Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Pendaftar</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ App\Models\Pendaftaran::count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Pending Event Approvals -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Acara Menunggu Persetujuan</h6>
                    <a href="{{ route('wakil_kesiswaan.acara.index') }}" class="btn btn-sm btn-primary">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    @php
                        $pendingAcara = App\Models\Acara::where('status', 'pending')
                            ->with('panitia.user')
                            ->latest()
                            ->take(5)
                            ->get();
                    @endphp

                    @if($pendingAcara->isEmpty())
                        <div class="text-center py-4">
                            <i class="fas fa-check-circle fa-3x text-gray-300 mb-3"></i>
                            <p class="text-gray-600 mb-0">Tidak ada acara yang menunggu persetujuan</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Judul</th>
                                        <th>Tanggal Acara</th>
                                        <th>Panitia</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingAcara as $acara)
                                        <tr>
                                            <td>{{ $acara->judul }}</td>
                                            <td>{{ \Carbon\Carbon::parse($acara->tanggal_acara)->format('d M Y') }}</td>
                                            <td>{{ $acara->panitia->user->name }}</td>
                                            <td>
                                                <a href="{{ route('wakil_kesiswaan.acara.show', $acara->id) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>
                                                <button type="button" onclick="approveAcara({{ $acara->id }})" class="btn btn-success btn-sm">
                                                    <i class="fas fa-check"></i> Setujui
                                                </button>
                                                <button type="button" onclick="rejectAcara({{ $acara->id }})" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-times"></i> Tolak
                                                </button>
                                                
                                                <form id="approve-form-{{ $acara->id }}" action="{{ route('wakil_kesiswaan.acara.approve', $acara->id) }}" method="POST" style="display: none;">
                                                    @csrf
                                                </form>
                                                <form id="reject-form-{{ $acara->id }}" action="{{ route('wakil_kesiswaan.acara.reject', $acara->id) }}" method="POST" style="display: none;">
                                                    @csrf
                                                </form>
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

        <!-- Admin Profile -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Profil Wakil Kesiswaan</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img class="img-profile rounded-circle mb-3" src="{{ asset('assets/img/undraw_profile.svg') }}" width="100">
                        <h5 class="mb-0">{{ Auth::user()->name }}</h5>
                        <p class="text-muted">{{ Auth::user()->email }}</p>
                    </div>
                    
                    <hr>
                    
                    <div class="row mb-2">
                        <div class="col-6 font-weight-bold">Role:</div>
                        <div class="col-6">Wakil Kesiswaan</div>
                    </div>
                    
                    <div class="row mb-2">
                        <div class="col-6 font-weight-bold">NIP:</div>
                        <div class="col-6">{{ Auth::user()->wakilKesiswaan ? Auth::user()->wakilKesiswaan->nip : '-' }}</div>
                    </div>
                    
                    <div class="row mb-2">
                        <div class="col-6 font-weight-bold">Bergabung:</div>
                        <div class="col-6">{{ Auth::user()->created_at->format('d M Y') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Registrations -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Pendaftaran Terbaru</h6>
                    <a href="{{ route('wakil_kesiswaan.histori') }}" class="btn btn-sm btn-primary">
                        Lihat Semua Histori
                    </a>
                </div>
                <div class="card-body">
                    @php
                        $recentRegistrations = App\Models\Pendaftaran::with(['acara.panitia.user', 'siswa.user'])
                            ->latest()
                            ->take(5)
                            ->get();
                    @endphp

                    @if($recentRegistrations->isEmpty())
                        <div class="text-center py-4">
                            <i class="fas fa-clipboard-list fa-3x text-gray-300 mb-3"></i>
                            <p class="text-gray-600 mb-0">Belum ada pendaftaran acara</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Acara</th>
                                        <th>Nama Siswa</th>
                                        <th>NIS</th>
                                        <th>Kelas</th>
                                        <th>Tanggal Pendaftaran</th>
                                        <th>Status</th>
                                        <th>Penyelenggara</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentRegistrations as $pendaftaran)
                                        <tr>
                                            <td>{{ $pendaftaran->acara->judul }}</td>
                                            <td>{{ $pendaftaran->siswa->user->name }}</td>
                                            <td>{{ $pendaftaran->siswa->nis }}</td>
                                            <td>{{ $pendaftaran->siswa->kelas }}</td>
                                            <td>{{ $pendaftaran->created_at->format('d-m-Y H:i') }}</td>
                                            <td>{!! $pendaftaran->status_badge !!}</td>
                                            <td>{{ $pendaftaran->acara->panitia->user->name }}</td>
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
<script>
    function approveAcara(acaraId) {
        if (confirm('Apakah Anda yakin ingin MENYETUJUI acara ini?')) {
            document.getElementById('approve-form-' + acaraId).submit();
        }
    }
    
    function rejectAcara(acaraId) {
        if (confirm('Apakah Anda yakin ingin MENOLAK acara ini?')) {
            document.getElementById('reject-form-' + acaraId).submit();
        }
    }
</script>
@endsection