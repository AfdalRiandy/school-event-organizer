@extends('wakil_kesiswaan.layouts.app')
@section('title', 'Histori Pendaftaran')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Histori Pendaftaran Siswa</h1>
    </div>

    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter</h6>
        </div>
        <div class="card-body">
            <div class="form-inline">
                <div class="form-group mx-sm-3 mb-2">
                    <label for="acara-filter" class="mr-2">Acara:</label>
                    <select class="form-control" id="acara-filter">
                        <option value="">-- Semua Acara --</option>
                        @foreach($acaras as $acara)
                            <option value="{{ $acara->judul }}">
                                {{ $acara->judul }} ({{ \Carbon\Carbon::parse($acara->tanggal_acara)->format('d-m-Y') }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="status-filter" class="mr-2">Status:</label>
                    <select class="form-control" id="status-filter">
                        <option value="">-- Semua Status --</option>
                        <option value="Pending">Pending</option>
                        <option value="Disetujui">Disetujui</option>
                        <option value="Ditolak">Ditolak</option>
                    </select>
                </div>
                <button type="button" id="reset-filter" class="btn btn-secondary mb-2" style="display:none;">Reset Filter</button>
            </div>
        </div>
    </div>

    <!-- DataTables Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pendaftaran Siswa</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Acara</th>
                            <th>Nama Siswa</th>
                            <th>NIS</th>
                            <th>Kelas</th>
                            <th>Jurusan</th>
                            <th>Tanggal Pendaftaran</th>
                            <th>Status</th>
                            <th>Penyelenggara</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Acara</th>
                            <th>Nama Siswa</th>
                            <th>NIS</th>
                            <th>Kelas</th>
                            <th>Jurusan</th>
                            <th>Tanggal Pendaftaran</th>
                            <th>Status</th>
                            <th>Penyelenggara</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @forelse($pendaftarans as $pendaftaran)
                            <tr>
                                <td>{{ $pendaftaran->acara->judul }}</td>
                                <td>{{ $pendaftaran->siswa->user->name }}</td>
                                <td>{{ $pendaftaran->siswa->nis }}</td>
                                <td>{{ $pendaftaran->siswa->kelas }}</td>
                                <td>{{ $pendaftaran->siswa->jurusan }}</td>
                                <td>{{ $pendaftaran->created_at->format('d-m-Y H:i') }}</td>
                                <td>{!! $pendaftaran->status_badge !!}</td>
                                <td>{{ $pendaftaran->acara->panitia->user->name }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data pendaftaran</td>
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
        // Initialize DataTable
        var table = $('#dataTable').DataTable({
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
        
        // Client-side filtering by Acara
        $('#acara-filter').on('change', function() {
            var selectedAcara = $(this).val();
            table.column(0).search(selectedAcara).draw();
            toggleResetButton();
        });
        
        // Client-side filtering by Status
        $('#status-filter').on('change', function() {
            var selectedStatus = $(this).val();
            table.column(6).search(selectedStatus).draw();
            toggleResetButton();
        });
        
        // Reset filter
        $('#reset-filter').on('click', function() {
            $('#acara-filter').val('');
            $('#status-filter').val('');
            table.search('').columns().search('').draw();
            $(this).hide();
        });
        
        // Helper function to toggle reset button
        function toggleResetButton() {
            if ($('#acara-filter').val() || $('#status-filter').val()) {
                $('#reset-filter').show();
            } else {
                $('#reset-filter').hide();
            }
        }
    });
</script>
@endsection