@extends('admin.layouts.app')
@section('title', 'Edit User')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit User</h1>
        <a href="{{ route('admin.user.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit User</h6>
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

            <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password (biarkan kosong jika tidak ingin mengubah)</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="">Pilih Role</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="siswa" {{ old('role', $user->role) == 'siswa' ? 'selected' : '' }}>Siswa</option>
                                <option value="panitia" {{ old('role', $user->role) == 'panitia' ? 'selected' : '' }}>Panitia</option>
                                <option value="wakil_kesiswaan" {{ old('role', $user->role) == 'wakil_kesiswaan' ? 'selected' : '' }}>Wakil Kesiswaan</option>
                            </select>
                        </div>
                        
                        <!-- Fields for Siswa -->
                        <div id="siswaFields" style="display: none;">
                            <div class="form-group">
                                <label for="nis">NIS (Nomor Induk Siswa)</label>
                                <input type="text" class="form-control" id="nis" name="nis" 
                                       value="{{ old('nis', $user->siswa->nis ?? '') }}">
                            </div>
                            
                            <div class="form-group">
                                <label for="jurusan">Jurusan</label>
                                <input type="text" class="form-control" id="jurusan" name="jurusan" 
                                       value="{{ old('jurusan', $user->siswa->jurusan ?? '') }}">
                            </div>
                            
                            <div class="form-group">
                                <label for="kelas">Kelas</label>
                                <input type="text" class="form-control" id="kelas" name="kelas" 
                                       value="{{ old('kelas', $user->siswa->kelas ?? '') }}">
                            </div>
                        </div>
                        
                        <!-- Fields for Wakil Kesiswaan -->
                        <div id="wakilKesiswaanFields" style="display: none;">
                            <div class="form-group">
                                <label for="nip">NIP (Nomor Induk Pegawai)</label>
                                <input type="text" class="form-control" id="nip" name="nip" 
                                       value="{{ old('nip', $user->wakilKesiswaan->nip ?? '') }}">
                            </div>
                        </div>
                    </div>
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
        
        // Trigger change event untuk menampilkan field yang sesuai
        $('#role').trigger('change');
    });
</script>
@endsection