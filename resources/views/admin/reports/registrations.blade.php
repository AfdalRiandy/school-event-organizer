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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Acara</th>
                <th>Nama Siswa</th>
                <th>NIS</th>
                <th>Kelas</th>
                <th>Jurusan</th>
                <th>Tanggal Pendaftaran</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pendaftarans as $index => $pendaftaran)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $pendaftaran->acara->judul }}</td>
                    <td>{{ $pendaftaran->siswa->user->name }}</td>
                    <td>{{ $pendaftaran->siswa->nis }}</td>
                    <td>{{ $pendaftaran->siswa->kelas }}</td>
                    <td>{{ $pendaftaran->siswa->jurusan }}</td>
                    <td>{{ $pendaftaran->created_at->format('d-m-Y H:i') }}</td>
                    <td>{{ ucfirst($pendaftaran->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">Tidak ada data pendaftaran</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        Dicetak oleh: {{ Auth::user()->name }} pada {{ now()->format('d-m-Y H:i:s') }}
    </div>
</body>
</html>