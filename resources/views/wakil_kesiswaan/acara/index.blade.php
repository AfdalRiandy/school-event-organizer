@extends('wakil_kesiswaan.layouts.app')
@section('title', 'Persetujuan Acara')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Persetujuan Acara</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- DataTables Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pengajuan Acara</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Tanggal Acara</th>
                            <th>Batas Pendaftaran</th>
                            <th>Panitia</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Judul</th>
                            <th>Tanggal Acara</th>
                            <th>Batas Pendaftaran</th>
                            <th>Panitia</th>
                            <th>Status</th>
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
                                    <a href="{{ route('wakil_kesiswaan.acara.show', $acara->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    @if($acara->status == 'pending')
                                        <button type="button" onclick="approveAcara({{ $acara->id }})" class="btn btn-success btn-sm">
                                            <i class="fas fa-check"></i> Setujui
                                        </button>
                                        <button type="button" onclick="rejectAcara({{ $acara->id }})" class="btn btn-danger btn-sm">
                                            <i class="fas fa-times"></i> Tolak
                                        </button>
                                        <form id="approve-form-{{ $acara->id }}" action="{{ route('wakil_kesiswaan.acara.approve', $acara->id) }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                        <form id="reject-form-{{ $acara->id }}" action="{{ route('wakil_kesiswaan.acara.reject', $acara->id) }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data acara</td>
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