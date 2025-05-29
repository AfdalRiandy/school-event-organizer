@extends('siswa.layouts.app')
@section('title', 'Dashboard Siswa')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="{{ route('siswa.acara.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-calendar-plus fa-sm text-white-50"></i> Lihat Semua Acara
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Total Registered Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Pendaftaran</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ Auth::user()->siswa->pendaftarans->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Approved Registrations Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Pendaftaran Disetujui</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ Auth::user()->siswa->pendaftarans->where('status', 'disetujui')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Registrations Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Menunggu Persetujuan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ Auth::user()->siswa->pendaftarans->where('status', 'pending')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Available Events Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Acara Tersedia</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ App\Models\Acara::where('status', 'disetujui')
                                    ->where('batas_pendaftaran', '>=', now()->format('Y-m-d'))
                                    ->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Recent Registrations -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Pendaftaran Terakhir</h6>
                    <a href="{{ route('siswa.pendaftaran.index') }}" class="btn btn-sm btn-primary">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @php
                            $recentRegistrations = Auth::user()->siswa->pendaftarans()
                                ->with('acara')
                                ->latest()
                                ->take(5)
                                ->get();
                        @endphp

                        @if($recentRegistrations->isEmpty())
                            <div class="text-center py-4">
                                <i class="fas fa-clipboard-list fa-3x text-gray-300 mb-3"></i>
                                <p class="text-gray-600 mb-0">Belum ada pendaftaran acara</p>
                                <a href="{{ route('siswa.acara.index') }}" class="btn btn-primary mt-3">
                                    Lihat Acara Tersedia
                                </a>
                            </div>
                        @else
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Acara</th>
                                        <th>Tanggal Acara</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentRegistrations as $pendaftaran)
                                        <tr>
                                            <td>{{ $pendaftaran->acara->judul }}</td>
                                            <td>{{ \Carbon\Carbon::parse($pendaftaran->acara->tanggal_acara)->format('d M Y') }}</td>
                                            <td>{!! $pendaftaran->status_badge !!}</td>
                                            <td>
                                                <a href="{{ route('siswa.acara.show', $pendaftaran->acara_id) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- User Profile -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Profil Siswa</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img class="img-profile rounded-circle mb-3" src="{{ asset('assets/img/undraw_profile.svg') }}" width="100">
                        <h5 class="mb-0">{{ Auth::user()->name }}</h5>
                        <p class="text-muted">{{ Auth::user()->email }}</p>
                    </div>
                    
                    <hr>
                    
                    <div class="row mb-2">
                        <div class="col-6 font-weight-bold">NIS:</div>
                        <div class="col-6">{{ Auth::user()->siswa->nis }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6 font-weight-bold">Jurusan:</div>
                        <div class="col-6">{{ Auth::user()->siswa->jurusan }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6 font-weight-bold">Kelas:</div>
                        <div class="col-6">{{ Auth::user()->siswa->kelas }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Events -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Acara Mendatang</h6>
                </div>
                <div class="card-body">
                    @php
                        $upcomingEvents = App\Models\Acara::where('status', 'disetujui')
                            ->where('batas_pendaftaran', '>=', now()->format('Y-m-d'))
                            ->latest()
                            ->take(3)
                            ->get();
                    @endphp
                    
                    @if($upcomingEvents->isEmpty())
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-times fa-3x text-gray-300 mb-3"></i>
                            <p class="text-gray-600 mb-0">Tidak ada acara mendatang yang tersedia</p>
                        </div>
                    @else
                        <div class="row">
                            @foreach($upcomingEvents as $acara)
                                <div class="col-lg-4 mb-4">
                                    <div class="card">
                                        @if($acara->image)
                                            <img class="card-img-top" src="{{ asset('storage/acara/' . $acara->image) }}" alt="Gambar Acara">
                                        @else
                                            <div class="card-img-top text-center py-5 bg-light">
                                                <i class="fas fa-image fa-3x text-gray-400"></i>
                                            </div>
                                        @endif
                                        <div class="card-body">
                                            <h5 class="card-title font-weight-bold">{{ $acara->judul }}</h5>
                                            <p class="card-text text-muted">
                                                <i class="fas fa-calendar-alt mr-1"></i> {{ \Carbon\Carbon::parse($acara->tanggal_acara)->format('d M Y') }}
                                            </p>
                                            <p class="card-text mb-2">{{ \Illuminate\Support\Str::limit($acara->deskripsi, 100) }}</p>
                                            
                                            @php
                                                $registered = Auth::user()->siswa->pendaftarans()
                                                    ->where('acara_id', $acara->id)
                                                    ->first();
                                            @endphp
                                            
                                            @if($registered)
                                                <span class="badge badge-success mb-2">Sudah Terdaftar</span>
                                            @endif
                                            
                                            <div class="text-center mt-3">
                                                <a href="{{ route('siswa.acara.show', $acara->id) }}" class="btn btn-primary btn-sm">
                                                    Lihat Detail
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card-footer text-muted small">
                                            <i class="fas fa-clock mr-1"></i> Batas pendaftaran: {{ \Carbon\Carbon::parse($acara->batas_pendaftaran)->format('d M Y') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection