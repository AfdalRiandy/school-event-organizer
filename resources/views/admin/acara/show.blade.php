@extends('admin.layouts.app')
@section('title', 'Detail Acara')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Acara</h1>
        <div>
            <a href="{{ route('admin.acara.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Detail Acara Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Acara</h6>
                </div>
                <div class="card-body">
                    @if($acara->image)
                        <div class="mb-4 text-center">
                            <img src="{{ asset('storage/acara/' . $acara->image) }}" alt="{{ $acara->judul }}" class="img-fluid rounded" style="max-height: 300px;">
                        </div>
                    @endif
                    
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Judul Acara:</div>
                        <div class="col-md-9">{{ $acara->judul }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Status:</div>
                        <div class="col-md-9">{!! $acara->status_badge !!}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Penyelenggara:</div>
                        <div class="col-md-9">{{ $acara->panitia->user->name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Tanggal Acara:</div>
                        <div class="col-md-9">{{ \Carbon\Carbon::parse($acara->tanggal_acara)->format('d F Y') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Batas Pendaftaran:</div>
                        <div class="col-md-9">{{ \Carbon\Carbon::parse($acara->batas_pendaftaran)->format('d F Y') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Dibuat pada:</div>
                        <div class="col-md-9">{{ $acara->created_at->format('d F Y H:i') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Terakhir diupdate:</div>
                        <div class="col-md-9">{{ $acara->updated_at->format('d F Y H:i') }}</div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-md-12 font-weight-bold mb-2">Deskripsi:</div>
                        <div class="col-md-12">
                            <p>{{ $acara->deskripsi }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- Action Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi</h6>
                </div>
                <div class="card-body">
                    <button type="button" onclick="confirmDelete({{ $acara->id }})" class="btn btn-danger btn-block">
                        <i class="fas fa-trash fa-sm"></i> Hapus Acara
                    </button>
                    
                    <form id="delete-form-{{ $acara->id }}" action="{{ route('admin.acara.destroy', $acara->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>

            <!-- Stats Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik Pendaftaran</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 text-center border-right">
                            <h4 class="font-weight-bold">{{ $acara->pendaftarans->count() }}</h4>
                            <small class="text-muted">Total Pendaftar</small>
                        </div>
                        <div class="col-6 text-center">
                            <h4 class="font-weight-bold">{{ $acara->pendaftarans->where('status', 'disetujui')->count() }}</h4>
                            <small class="text-muted">Disetujui</small>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6 text-center border-right">
                            <h4 class="font-weight-bold">{{ $acara->pendaftarans->where('status', 'pending')->count() }}</h4>
                            <small class="text-muted">Menunggu</small>
                        </div>
                        <div class="col-6 text-center">
                            <h4 class="font-weight-bold">{{ $acara->pendaftarans->where('status', 'ditolak')->count() }}</h4>
                            <small class="text-muted">Ditolak</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- List of Participants -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Peserta</h6>
        </div>
        <div class="card-body">
            @if($acara->pendaftarans->isEmpty())
                <div class="text-center py-4">
                    <i class="fas fa-users fa-3x text-gray-300 mb-3"></i>
                    <p class="text-gray-600 mb-0">Belum ada peserta yang mendaftar untuk acara ini</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered" id="pendaftaranTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nama Siswa</th>
                                <th>NIS</th>
                                <th>Kelas</th>
                                <th>Jurusan</th>
                                <th>Tanggal Pendaftaran</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($acara->pendaftarans as $pendaftaran)
                                <tr>
                                    <td>{{ $pendaftaran->siswa->user->name }}</td>
                                    <td>{{ $pendaftaran->siswa->nis }}</td>
                                    <td>{{ $pendaftaran->siswa->kelas }}</td>
                                    <td>{{ $pendaftaran->siswa->jurusan }}</td>
                                    <td>{{ $pendaftaran->created_at->format('d-m-Y H:i') }}</td>
                                    <td>{!! $pendaftaran->status_badge !!}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#pendaftaranTable').DataTable({
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