@extends('siswa.layouts.app')
@section('title', 'Histori Pendaftaran')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Histori Pendaftaran</h1>
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
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pendaftaran Acara</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Acara</th>
                            <th>Tanggal Acara</th>
                            <th>Tanggal Pendaftaran</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Acara</th>
                            <th>Tanggal Acara</th>
                            <th>Tanggal Pendaftaran</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @forelse($pendaftarans as $pendaftaran)
                            <tr>
                                <td>{{ $pendaftaran->acara->judul }}</td>
                                <td>{{ \Carbon\Carbon::parse($pendaftaran->acara->tanggal_acara)->format('d-m-Y') }}</td>
                                <td>{{ $pendaftaran->created_at->format('d-m-Y H:i') }}</td>
                                <td>{!! $pendaftaran->status_badge !!}</td>
                                <td>
                                    <a href="{{ route('siswa.acara.show', $pendaftaran->acara_id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    @if($pendaftaran->status == 'pending' && \Carbon\Carbon::now()->lte(\Carbon\Carbon::parse($pendaftaran->acara->batas_pendaftaran)))
                                        <form action="{{ route('siswa.pendaftaran.delete', $pendaftaran->id) }}" method="POST" style="display:inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin membatalkan pendaftaran?')">
                                                <i class="fas fa-times"></i> Batalkan
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada pendaftaran acara</td>
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
</script>
@endsection