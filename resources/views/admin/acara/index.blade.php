@extends('admin.layouts.app')
@section('title', 'Kelola Acara')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Acara</h1>
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

    <!-- DataTables Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Semua Acara</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Tanggal Acara</th>
                            <th>Batas Pendaftaran</th>
                            <th>Penyelenggara</th>
                            <th>Status</th>
                            <th>Total Pendaftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Judul</th>
                            <th>Tanggal Acara</th>
                            <th>Batas Pendaftaran</th>
                            <th>Penyelenggara</th>
                            <th>Status</th>
                            <th>Total Pendaftar</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @forelse($acaras as $acara)
                            <tr>
                                <td>{{ $acara->judul }}</td>
                                <td>{{ \Carbon\Carbon::parse($acara->tanggal_acara)->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($acara->batas_pendaftaran)->format('d-m-Y') }}</td>
                                <td>{{ $acara->panitia->user->name }}</td>
                                <td>{!! $acara->status_badge !!}</td>
                                <td>
                                    <span class="badge badge-pill badge-primary">
                                        {{ $acara->pendaftarans->count() }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.acara.show', $acara->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $acara->id }})">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                    <form id="delete-form-{{ $acara->id }}" action="{{ route('admin.acara.destroy', $acara->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data acara</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "language": {
                "lengthMenu": "Tampilkan _MENU_ data",
                "search": "Cari:",
                "zeroRecords": "Tidak ada data yang cocok",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "infoEmpty": "Tidak ada data yang ditampilkan",
                "infoFiltered": "(difilter dari _MAX_ total data)",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            }
        });
    });

    function confirmDelete(acaraId) {
        if (confirm('Apakah Anda yakin ingin menghapus acara ini? Semua pendaftaran terkait juga akan dihapus.')) {
            document.getElementById('delete-form-' + acaraId).submit();
        }
    }
</script>
@endsection