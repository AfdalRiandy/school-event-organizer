@extends('panitia.layouts.app')
@section('title', 'Status Pendaftar')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Status Pendaftar</h1>
        <a href="{{ route('panitia.pendaftar.all') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-users fa-sm text-white-50"></i> Lihat Semua Pendaftar
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4">
            <!-- Acaras Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Acara & Pendaftar</h6>
                </div>
                <div class="card-body">
                    @php
                        $acaras = Auth::user()->panitia->acara;
                    @endphp
                    
                    @if($acaras->isEmpty())
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-times fa-4x text-gray-300 mb-3"></i>
                            <p class="text-gray-600 mb-0">Belum ada acara yang Anda buat</p>
                            <a href="{{ route('panitia.acara.create') }}" class="btn btn-primary mt-3">
                                <i class="fas fa-plus fa-sm mr-1"></i> Buat Acara Baru
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Judul Acara</th>
                                        <th>Tanggal Acara</th>
                                        <th>Status</th>
                                        <th>Jumlah Pendaftar</th>
                                        <th>Disetujui</th>
                                        <th>Ditolak</th>
                                        <th>Menunggu</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($acaras as $acara)
                                        @php
                                            $totalPendaftar = $acara->pendaftarans->count();
                                            $disetujui = $acara->pendaftarans->where('status', 'disetujui')->count();
                                            $ditolak = $acara->pendaftarans->where('status', 'ditolak')->count();
                                            $menunggu = $acara->pendaftarans->where('status', 'pending')->count();
                                        @endphp
                                        <tr>
                                            <td>{{ $acara->judul }}</td>
                                            <td>{{ \Carbon\Carbon::parse($acara->tanggal_acara)->format('d-m-Y') }}</td>
                                            <td>{!! $acara->status_badge !!}</td>
                                            <td>{{ $totalPendaftar }}</td>
                                            <td><span class="badge badge-success">{{ $disetujui }}</span></td>
                                            <td><span class="badge badge-danger">{{ $ditolak }}</span></td>
                                            <td><span class="badge badge-warning">{{ $menunggu }}</span></td>
                                            <td>
                                                <a href="{{ route('panitia.pendaftar.index', $acara->id) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-users"></i> Lihat Pendaftar
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
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