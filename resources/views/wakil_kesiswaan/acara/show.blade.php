@extends('wakil_kesiswaan.layouts.app')
@section('title', 'Detail Acara')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Acara</h1>
        <a href="{{ route('wakil_kesiswaan.acara.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Detail Acara Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Acara</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Status:</div>
                        <div class="col-md-9">{!! $acara->status_badge !!}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Judul:</div>
                        <div class="col-md-9">{{ $acara->judul }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Panitia:</div>
                        <div class="col-md-9">{{ $acara->panitia->user->name }}</div>
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
                        <div class="col-md-3 font-weight-bold">Dibuat pada:</div>
                        <div class="col-md-9">{{ $acara->created_at->format('d F Y H:i') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Terakhir diupdate:</div>
                        <div class="col-md-9">{{ $acara->updated_at->format('d F Y H:i') }}</div>
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
            
            @if($acara->status == 'pending')
            <!-- Action Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi</h6>
                </div>
                <div class="card-body">
                    <button type="button" onclick="approveAcara({{ $acara->id }})" class="btn btn-success btn-block mb-2">
                        <i class="fas fa-check fa-sm"></i> Setujui Acara
                    </button>
                    
                    <button type="button" onclick="rejectAcara({{ $acara->id }})" class="btn btn-danger btn-block">
                        <i class="fas fa-times fa-sm"></i> Tolak Acara
                    </button>
                    
                    <form id="approve-form-{{ $acara->id }}" action="{{ route('wakil_kesiswaan.acara.approve', $acara->id) }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    
                    <form id="reject-form-{{ $acara->id }}" action="{{ route('wakil_kesiswaan.acara.reject', $acara->id) }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
            @endif
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