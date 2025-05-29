@extends('panitia.layouts.app')
@section('title', 'Edit Acara')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Acara</h1>
        <a href="{{ route('panitia.acara.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Acara</h6>
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

            <form action="{{ route('panitia.acara.update', $acara->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="judul">Judul Acara <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul', $acara->judul) }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="tanggal_acara">Tanggal Acara <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="tanggal_acara" name="tanggal_acara" value="{{ old('tanggal_acara', $acara->tanggal_acara) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="batas_pendaftaran">Batas Pendaftaran <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="batas_pendaftaran" name="batas_pendaftaran" value="{{ old('batas_pendaftaran', $acara->batas_pendaftaran) }}" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="image">Gambar (Opsional)</label>
                            <input type="file" class="form-control-file" id="image" name="image">
                            <small class="form-text text-muted">Format: JPG, PNG, JPEG, GIF. Maks: 2MB</small>
                            
                            @if($acara->image)
                                <div class="mt-2">
                                    <p class="mb-1">Gambar saat ini:</p>
                                    <img src="{{ asset('storage/acara/' . $acara->image) }}" alt="Current Image" class="img-thumbnail" style="max-height: 150px;">
                                </div>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi Acara <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required>{{ old('deskripsi', $acara->deskripsi) }}</textarea>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle mr-1"></i> Setelah diupdate, status acara akan tetap "Menunggu Persetujuan" sampai disetujui oleh Wakil Kesiswaan.
                </div>
                
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Validasi batas pendaftaran harus sebelum tanggal acara
        $('#tanggal_acara').on('change', function() {
            document.getElementById('batas_pendaftaran').setAttribute('max', $(this).val());
            
            // Jika batas pendaftaran sudah diisi dan lebih dari tanggal acara, reset
            const batasPendaftaran = $('#batas_pendaftaran').val();
            if (batasPendaftaran && batasPendaftaran > $(this).val()) {
                $('#batas_pendaftaran').val($(this).val());
            }
        });
        
        // Trigger onchange saat pertama kali halaman dimuat
        $('#tanggal_acara').trigger('change');
    });
</script>
@endsection