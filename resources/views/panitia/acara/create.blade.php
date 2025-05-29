@extends('panitia.layouts.app')
@section('title', 'Buat Acara Baru')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Buat Acara Baru</h1>
        <a href="{{ route('panitia.acara.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Acara Baru</h6>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('panitia.acara.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="judul">Judul Acara <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul') }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="tanggal_acara">Tanggal Acara <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="tanggal_acara" name="tanggal_acara" value="{{ old('tanggal_acara') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="batas_pendaftaran">Batas Pendaftaran <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="batas_pendaftaran" name="batas_pendaftaran" value="{{ old('batas_pendaftaran') }}" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="image">Gambar (Opsional)</label>
                            <input type="file" class="form-control-file" id="image" name="image">
                            <small class="form-text text-muted">Format: JPG, PNG, JPEG, GIF. Maks: 2MB</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi Acara <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required>{{ old('deskripsi') }}</textarea>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-info">
                    <i class="fas fa-info-circle mr-1"></i> Acara yang dibuat akan berstatus "Menunggu Persetujuan" sampai disetujui oleh Wakil Kesiswaan.
                </div>
                
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Set minimal date untuk tanggal acara ke hari ini
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('tanggal_acara').setAttribute('min', today);
        document.getElementById('batas_pendaftaran').setAttribute('min', today);
        
        // Validasi batas pendaftaran harus sebelum tanggal acara
        $('#tanggal_acara').on('change', function() {
            document.getElementById('batas_pendaftaran').setAttribute('max', $(this).val());
            
            // Jika batas pendaftaran sudah diisi dan lebih dari tanggal acara, reset
            const batasPendaftaran = $('#batas_pendaftaran').val();
            if (batasPendaftaran && batasPendaftaran > $(this).val()) {
                $('#batas_pendaftaran').val($(this).val());
            }
        });
    });
</script>
@endsection