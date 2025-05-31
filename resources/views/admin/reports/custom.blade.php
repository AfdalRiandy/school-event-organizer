<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
        }
        .subtitle {
            font-size: 14px;
            margin-top: 5px;
        }
        .date {
            margin-top: 5px;
            font-style: italic;
        }
        .filter-info {
            margin-top: 10px;
            font-size: 12px;
            color: #666;
        }
        .section {
            margin-top: 30px;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 20px;
            text-align: right;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">{{ $title }}</div>
        <div class="subtitle">Sistem Manajemen Acara Sekolah</div>
        <div class="date">Tanggal: {{ $date }}</div>
        
        <div class="filter-info">
            <p>
                @if($filters['type'] != 'all')
                    Tipe: {{ ucfirst($filters['type']) }}
                @else
                    Tipe: Semua Data
                @endif
                
                @if($filters['dateStart'] && $filters['dateEnd'])
                    | Periode: {{ $filters['dateStart'] }} s/d {{ $filters['dateEnd'] }}
                @endif
                
                @if($filters['sort'])
                    | Urutan: {{ $filters['sort'] == 'latest' ? 'Terbaru' : ($filters['sort'] == 'oldest' ? 'Terlama' : 'Nama/Judul') }}
                @endif
            </p>
        </div>
    </div>
    
    @if($users && count($users) > 0 && ($filters['type'] == 'all' || $filters['type'] == 'users'))
    <div class="section">
        <div class="section-title">Data Pengguna</div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Tanggal Registrasi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>{{ $user->created_at->format('d-m-Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
    
    @if($acaras && count($acaras) > 0 && ($filters['type'] == 'all' || $filters['type'] == 'events'))
    <div class="section">
        <div class="section-title">Data Acara</div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Acara</th>
                    <th>Tanggal Acara</th>
                    <th>Batas Pendaftaran</th>
                    <th>Penyelenggara</th>
                    <th>Status</th>
                    <th>Jumlah Pendaftar</th>
                </tr>
            </thead>
            <tbody>
                @foreach($acaras as $index => $acara)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $acara->judul }}</td>
                        <td>{{ \Carbon\Carbon::parse($acara->tanggal_acara)->format('d-m-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($acara->batas_pendaftaran)->format('d-m-Y') }}</td>
                        <td>{{ $acara->panitia->user->name }}</td>
                        <td>{{ ucfirst($acara->status) }}</td>
                        <td>{{ $acara->pendaftarans->count() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
    
    @if($pendaftarans && count($pendaftarans) > 0 && ($filters['type'] == 'all' || $filters['type'] == 'registrations'))
    <div class="section">
        <div class="section-title">Data Pendaftaran</div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Acara</th>
                    <th>Nama Siswa</th>
                    <th>NIS</th>
                    <th>Kelas</th>
                    <th>Tanggal Pendaftaran</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pendaftarans as $index => $pendaftaran)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $pendaftaran->acara->judul }}</td>
                        <td>{{ $pendaftaran->siswa->user->name }}</td>
                        <td>{{ $pendaftaran->siswa->nis }}</td>
                        <td>{{ $pendaftaran->siswa->kelas }}</td>
                        <td>{{ $pendaftaran->created_at->format('d-m-Y H:i') }}</td>
                        <td>{{ ucfirst($pendaftaran->status) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
    
    <div class="footer">
        Dicetak oleh: {{ Auth::user()->name }} pada {{ now()->format('d-m-Y H:i:s') }}
    </div>
</body>
</html>