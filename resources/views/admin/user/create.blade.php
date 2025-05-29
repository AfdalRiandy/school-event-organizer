@extends('admin.layouts.app')
@section('title', 'Tambah User')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah User</h1>
        <a href="{{ route('admin.user.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah User</h6>
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

            <form action="{{ route('admin.user.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="">Pilih Role</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                                <option value="panitia" {{ old('role') == 'panitia' ? 'selected' : '' }}>Panitia</option>
                                <option value="wakil_kesiswaan" {{ old('role') == 'wakil_kesiswaan' ? 'selected' : '' }}>Wakil Kesiswaan</option>
                            </select>
                        </div>
                        
                        <!-- Fields for Siswa -->
                        <div id="siswaFields" style="display: none;">
                            <div class="form-group">
                                <label for="nis">NIS (Nomor Induk Siswa)</label>
                                <input type="text" class="form-control" id="nis" name="nis" value="{{ old('nis') }}">
                            </div>
                            
                            <div class="form-group">
                                <label for="jurusan">Jurusan</label>
                                <input type="text" class="form-control" id="jurusan" name="jurusan" value="{{ old('jurusan') }}">
                            </div>
                            
                            <div class="form-group">
                                <label for="kelas">Kelas</label>
                                <input type="text" class="form-control" id="kelas" name="kelas" value="{{ old('kelas') }}">
                            </div>
                        </div>
                        
                        <!-- Fields for Wakil Kesiswaan -->
                        <div id="wakilKesiswaanFields" style="display: none;">
                            <div class="form-group">
                                <label for="nip">NIP (Nomor Induk Pegawai)</label>
                                <input type="text" class="form-control" id="nip" name="nip" value="{{ old('nip') }}">
                            </div>
                        </div>
                    </div>
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
        // Tampilkan/sembunyikan field berdasarkan role
        $('#role').on('change', function() {
            var role = $(this).val();
            
            // Sembunyikan semua field khusus
            $('#siswaFields, #wakilKesiswaanFields').hide();
            
            // Tampilkan field sesuai role
            if (role === 'siswa') {
                $('#siswaFields').show();
            } else if (role === 'wakil_kesiswaan') {
                $('#wakilKesiswaanFields').show();
            }
        });
        
        // Trigger change event jika role sudah dipilih (misalnya saat validation error)
        $('#role').trigger('change');
    });
</script>
@endsection