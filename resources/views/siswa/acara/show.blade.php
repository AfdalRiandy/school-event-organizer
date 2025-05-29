@extends('siswa.layouts.app')
@section('title', 'Detail Acara')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Acara</h1>
        <a href="{{ route('siswa.acara.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <!-- Detail Acara Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Acara</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Judul:</div>
                        <div class="col-md-9">{{ $acara->judul }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Tanggal Acara:</div>
                        <div class="col-md-9">{{ \Carbon\Carbon::parse($acara->tanggal_acara)->format('d F Y') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Batas Pendaftaran:</div>
                        <div class="col-md-9">{{ \Carbon\Carbon::parse($acara->batas_pendaftaran)->format('d F Y') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Penyelenggara:</div>
                        <div class="col-md-9">{{ $acara->panitia->user->name }}</div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-md-12 font-weight-bold mb-2">Deskripsi:</div>
                        <div class="col-md-12">
                            {!! nl2br(e($acara->deskripsi)) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Gambar Acara Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Gambar Acara</h6>
                </div>
                <div class="card-body">
                    @if($acara->image)
                        <img src="{{ asset('storage/acara/' . $acara->image) }}" class="img-fluid rounded" alt="Gambar Acara">
                    @else
                        <div class="text-center py-5 bg-light rounded">
                            <i class="fas fa-image fa-3x text-gray-400 mb-3"></i>
                            <p class="mb-0 text-gray-500">Tidak ada gambar</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Registration Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Pendaftaran</h6>
                </div>
                <div class="card-body">
                    @php
                        $today = \Carbon\Carbon::now()->startOfDay();
                        $batasPendaftaran = \Carbon\Carbon::parse($acara->batas_pendaftaran)->endOfDay();
                        $pendaftaran = Auth::user()->siswa->pendaftarans()
                            ->where('acara_id', $acara->id)
                            ->first();
                    @endphp
                    
                    @if($pendaftaran)
                        <div class="text-center">
                            <h5 class="mb-3">Status Pendaftaran</h5>
                            <div class="mb-3">{!! $pendaftaran->status_badge !!}</div>
                            
                            @if($pendaftaran->status == 'ditolak' && $pendaftaran->alasan_penolakan)
                                <div class="alert alert-danger mt-3">
                                    <strong>Alasan Penolakan:</strong><br>
                                    {{ $pendaftaran->alasan_penolakan }}
                                </div>
                            @endif
                            
                            @if($pendaftaran->status == 'pending' && $today->lte($batasPendaftaran))
                                <form action="{{ route('siswa.pendaftaran.delete', $pendaftaran->id) }}" method="POST" class="mt-3">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Yakin ingin membatalkan pendaftaran?')">
                                        <i class="fas fa-times mr-1"></i> Batalkan Pendaftaran
                                    </button>
                                </form>
                            @endif
                        </div>
                    @else
                        @if($today->lte($batasPendaftaran))
                            <div class="text-center">
                                <p class="mb-3">Tertarik dengan acara ini? Daftar sekarang!</p>
                                <form action="{{ route('siswa.pendaftaran.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="acara_id" value="{{ $acara->id }}">
                                    <button type="submit" class="btn btn-success btn-block">
                                        <i class="fas fa-user-plus mr-1"></i> Daftar Acara Ini
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="text-center">
                                <div class="alert alert-warning mb-0">
                                    <i class="fas fa-exclamation-triangle mr-1"></i> Pendaftaran sudah ditutup
                                </div>
                            </div>
                        @endif
                    @endif
                    
                    <div class="text-center mt-3">
                        <small class="text-muted">
                            Batas waktu pendaftaran: {{ \Carbon\Carbon::parse($acara->batas_pendaftaran)->format('d F Y') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection