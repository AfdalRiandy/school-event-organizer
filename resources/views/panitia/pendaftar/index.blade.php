@extends('panitia.layouts.app')
@section('title', 'Daftar Pendaftar')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pendaftar Acara: {{ $acara->judul }}</h1>
        <a href="{{ route('panitia.acara.show', $acara->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
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
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pendaftar</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama Siswa</th>
                            <th>NIS</th>
                            <th>Kelas</th>
                            <th>Jurusan</th>
                            <th>Tanggal Pendaftaran</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Nama Siswa</th>
                            <th>NIS</th>
                            <th>Kelas</th>
                            <th>Jurusan</th>
                            <th>Tanggal Pendaftaran</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @forelse($pendaftarans as $pendaftaran)
                            <tr>
                                <td>{{ $pendaftaran->siswa->user->name }}</td>
                                <td>{{ $pendaftaran->siswa->nis }}</td>
                                <td>{{ $pendaftaran->siswa->kelas }}</td>
                                <td>{{ $pendaftaran->siswa->jurusan }}</td>
                                <td>{{ $pendaftaran->created_at->format('d-m-Y H:i') }}</td>
                                <td>{!! $pendaftaran->status_badge !!}</td>
                                <td>
                                    @if($pendaftaran->status == 'pending')
                                        <button type="button" class="btn btn-success btn-sm" onclick="showApproveModal({{ $pendaftaran->id }})">
                                            <i class="fas fa-check"></i> Setujui
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="showRejectModal({{ $pendaftaran->id }})">
                                            <i class="fas fa-times"></i> Tolak
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-primary btn-sm" onclick="showStatusModal({{ $pendaftaran->id }})">
                                            <i class="fas fa-info-circle"></i> Detail
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada pendaftar untuk acara ini</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approveModalLabel">Setujui Pendaftaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="approveForm" action="" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menyetujui pendaftaran ini?</p>
                    <input type="hidden" name="status" value="disetujui">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Setujui</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Tolak Pendaftaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="rejectForm" action="" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menolak pendaftaran ini?</p>
                    <input type="hidden" name="status" value="ditolak">
                    <div class="form-group">
                        <label for="alasan_penolakan">Alasan Penolakan</label>
                        <textarea class="form-control" id="alasan_penolakan" name="alasan_penolakan" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Status Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">Detail Status Pendaftaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="statusContent">
                    <!-- Will be filled dynamically -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
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

    function showApproveModal(pendaftaranId) {
        document.getElementById('approveForm').action = `{{ url('panitia/pendaftar') }}/${pendaftaranId}/update-status`;
        $('#approveModal').modal('show');
    }

    function showRejectModal(pendaftaranId) {
        document.getElementById('rejectForm').action = `{{ url('panitia/pendaftar') }}/${pendaftaranId}/update-status`;
        $('#rejectModal').modal('show');
    }

    function showStatusModal(pendaftaranId) {
        // Get the pendaftaran data
        const pendaftarans = @json($pendaftarans);
        const pendaftaran = pendaftarans.find(p => p.id === pendaftaranId);
        
        let html = `
            <div class="alert ${pendaftaran.status === 'disetujui' ? 'alert-success' : 'alert-danger'}">
                <strong>Status:</strong> ${pendaftaran.status === 'disetujui' ? 'Disetujui' : 'Ditolak'}
            </div>
        `;
        
        if (pendaftaran.status === 'ditolak' && pendaftaran.alasan_penolakan) {
            html += `
                <div class="mt-3">
                    <strong>Alasan Penolakan:</strong>
                    <p class="mt-2">${pendaftaran.alasan_penolakan}</p>
                </div>
            `;
        }
        
        document.getElementById('statusContent').innerHTML = html;
        $('#statusModal').modal('show');
    }
</script>
@endsection