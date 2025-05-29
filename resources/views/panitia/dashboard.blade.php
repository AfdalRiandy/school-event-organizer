@extends('panitia.layouts.app')
@section('title', 'Dashboard Panitia')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="{{ route('panitia.acara.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Buat Acara Baru
        </a>
    </div>

    <!-- Content Row -->
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
                                {{ Auth::user()->panitia && Auth::user()->panitia->acara ? Auth::user()->panitia->acara->count() : 0 }}
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
                                {{ Auth::user()->panitia && Auth::user()->panitia->acara ? Auth::user()->panitia->acara->where('status', 'disetujui')->count() : 0 }}
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
                                {{ Auth::user()->panitia && Auth::user()->panitia->acara ? Auth::user()->panitia->acara->where('status', 'pending')->count() : 0 }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Registrants Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Pendaftar</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @php
                                    $totalPendaftar = 0;
                                    if (Auth::user()->panitia && Auth::user()->panitia->acara) {
                                        foreach(Auth::user()->panitia->acara as $acara) {
                                            $totalPendaftar += $acara->pendaftarans ? $acara->pendaftarans->count() : 0;
                                        }
                                    }
                                    echo $totalPendaftar;
                                @endphp
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

        <!-- Recent Events -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Acara Terbaru</h6>
                    <a href="{{ route('panitia.acara.index') }}" class="btn btn-sm btn-primary">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    @php
                        $recentAcara = Auth::user()->panitia->acara()->latest()->take(5)->get();
                    @endphp

                    @if($recentAcara->isEmpty())
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-plus fa-3x text-gray-300 mb-3"></i>
                            <p class="text-gray-600 mb-0">Belum ada acara yang dibuat</p>
                            <a href="{{ route('panitia.acara.create') }}" class="btn btn-primary mt-3">
                                Buat Acara Baru
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Judul</th>
                                        <th>Tanggal Acara</th>
                                        <th>Status</th>
                                        <th>Pendaftar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentAcara as $acara)
                                        <tr>
                                            <td>{{ $acara->judul }}</td>
                                            <td>{{ \Carbon\Carbon::parse($acara->tanggal_acara)->format('d M Y') }}</td>
                                            <td>{!! $acara->status_badge !!}</td>
                                            <td>
                                                <span class="badge badge-pill badge-primary">
                                                    {{ $acara->pendaftarans->count() }}
                                                </span>
                                                @if($acara->pendaftarans->where('status', 'pending')->count() > 0)
                                                    <span class="badge badge-pill badge-warning ml-1" title="Menunggu persetujuan">
                                                        {{ $acara->pendaftarans->where('status', 'pending')->count() }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('panitia.acara.show', $acara->id) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if($acara->status == 'disetujui')
                                                    <a href="{{ route('panitia.pendaftar.index', $acara->id) }}" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-users"></i>
                                                    </a>
                                                @endif
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

        <!-- Panitia Profile -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Profil Panitia</h6>
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
                        <div class="col-6">Panitia</div>
                    </div>
                    
                    <div class="row mb-2">
                        <div class="col-6 font-weight-bold">Bergabung:</div>
                        <div class="col-6">{{ Auth::user()->created_at->format('d M Y') }}</div>
                    </div>
                    
                    <div class="row mb-2">
                        <div class="col-6 font-weight-bold">Acara Aktif:</div>
                        <div class="col-6">
                            {{ Auth::user()->panitia && Auth::user()->panitia->acara ? 
                               Auth::user()->panitia->acara->where('status', 'disetujui')
                                   ->where('tanggal_acara', '>=', now()->format('Y-m-d'))->count() : 0 
                            }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Registrations & Pending Approvals -->
    <div class="row">
        <!-- Pending Registrations -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Pendaftaran Menunggu Persetujuan</h6>
                    <a href="{{ route('panitia.pendaftar.all') }}" class="btn btn-sm btn-primary">
                        Lihat Semua Pendaftar
                    </a>
                </div>
                <div class="card-body">
                    @php
                        $pendingRegistrations = [];
                        foreach(Auth::user()->panitia->acara as $acara) {
                            foreach($acara->pendaftarans->where('status', 'pending') as $pendaftaran) {
                                $pendingRegistrations[] = $pendaftaran;
                            }
                        }
                        // Sort by latest and take only 5
                        $pendingRegistrations = collect($pendingRegistrations)->sortByDesc('created_at')->take(5);
                    @endphp

                    @if(count($pendingRegistrations) == 0)
                        <div class="text-center py-4">
                            <i class="fas fa-check-circle fa-3x text-gray-300 mb-3"></i>
                            <p class="text-gray-600 mb-0">Tidak ada pendaftaran yang menunggu persetujuan</p>
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
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingRegistrations as $pendaftaran)
                                        <tr>
                                            <td>{{ $pendaftaran->acara->judul }}</td>
                                            <td>{{ $pendaftaran->siswa->user->name }}</td>
                                            <td>{{ $pendaftaran->siswa->nis }}</td>
                                            <td>{{ $pendaftaran->siswa->kelas }}</td>
                                            <td>{{ $pendaftaran->created_at->format('d M Y H:i') }}</td>
                                            <td>
                                                <form action="{{ route('panitia.pendaftar.update-status', $pendaftaran->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="status" value="disetujui">
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        <i class="fas fa-check"></i> Setujui
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-danger btn-sm" onclick="showRejectModal({{ $pendaftaran->id }})">
                                                    <i class="fas fa-times"></i> Tolak
                                                </button>
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
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Tolak Pendaftaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="rejectForm" action="" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menolak pendaftaran ini?</p>
                    <input type="hidden" name="status" value="ditolak">
                    <div class="form-group">
                        <label for="alasan_penolakan">Alasan Penolakan</label>
                        <textarea class="form-control" id="alasan_penolakan" name="alasan_penolakan" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function showRejectModal(pendaftaranId) {
        document.getElementById('rejectForm').action = `{{ url('panitia/pendaftar') }}/${pendaftaranId}/update-status`;
        $('#rejectModal').modal('show');
    }
</script>
@endsection