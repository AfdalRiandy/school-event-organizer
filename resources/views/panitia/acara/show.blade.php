@extends('panitia.layouts.app')
@section('title', 'Detail Acara')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Acara</h1>
        <div>
            @if($acara->status == 'pending')
                <a href="{{ route('panitia.acara.edit', $acara->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
                    <i class="fas fa-edit fa-sm text-white-50"></i> Edit Acara
                </a>
            @endif
            <a href="{{ route('panitia.acara.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm ml-2">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
            </a>
        </div>
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
                    <button type="button" onclick="confirmDelete({{ $acara->id }})" class="btn btn-danger btn-block">
                        <i class="fas fa-trash fa-sm"></i> Hapus Acara
                    </button>
                    
                    <form id="delete-form-{{ $acara->id }}" action="{{ route('panitia.acara.destroy', $acara->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
            @endif

            @if($acara->status == 'disetujui')
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Pendaftar</h6>
                </div>
                <div class="card-body">
                    <a href="{{ route('panitia.pendaftar.index', $acara->id) }}" class="btn btn-primary btn-block">
                        <i class="fas fa-users fa-sm"></i> Lihat Daftar Pendaftar
                    </a>
                    
                    @php
                        $totalPendaftar = $acara->pendaftarans->count();
                        $pendingPendaftar = $acara->pendaftarans->where('status', 'pending')->count();
                    @endphp
                    
                    @if($pendingPendaftar > 0)
                        <div class="mt-3 text-center">
                            <span class="badge badge-pill badge-warning">{{ $pendingPendaftar }}</span> pendaftar menunggu persetujuan
                        </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function confirmDelete(acaraId) {
        if (confirm('Apakah Anda yakin ingin menghapus acara ini?')) {
            document.getElementById('delete-form-' + acaraId).submit();
        }
    }
</script>
@endsection