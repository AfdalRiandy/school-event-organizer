@extends('admin.layouts.app')
@section('title', 'Detail User')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail User</h1>
        <div>
            <a href="{{ route('admin.user.edit', $user->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Edit User
            </a>
            <a href="{{ route('admin.user.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm ml-2">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <!-- Basic Info Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Dasar</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 30%">Nama</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <td>
                                @if($user->role == 'admin')
                                    <span class="badge badge-primary">Admin</span>
                                @elseif($user->role == 'siswa')
                                    <span class="badge badge-success">Siswa</span>
                                @elseif($user->role == 'panitia')
                                    <span class="badge badge-info">Panitia</span>
                                @elseif($user->role == 'wakil_kesiswaan')
                                    <span class="badge badge-warning">Wakil Kesiswaan</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Registrasi</th>
                            <td>{{ $user->created_at->format('d M Y H:i:s') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <!-- Role Specific Info Card -->
            @if($user->role == 'siswa' && $user->siswa)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Detail Siswa</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th style="width: 30%">NIS</th>
                                <td>{{ $user->siswa->nis }}</td>
                            </tr>
                            <tr>
                                <th>Jurusan</th>
                                <td>{{ $user->siswa->jurusan }}</td>
                            </tr>
                            <tr>
                                <th>Kelas</th>
                                <td>{{ $user->siswa->kelas }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            @elseif($user->role == 'wakil_kesiswaan' && $user->wakilKesiswaan)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Detail Wakil Kesiswaan</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th style="width: 30%">NIP</th>
                                <td>{{ $user->wakilKesiswaan->nip }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection