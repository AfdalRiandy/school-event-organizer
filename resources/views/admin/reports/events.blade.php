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
                <th>Judul Acara</th>
                <th>Tanggal Acara</th>
                <th>Batas Pendaftaran</th>
                <th>Penyelenggara</th>
                <th>Status</th>
                <th>Jumlah Pendaftar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($acaras as $index => $acara)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $acara->judul }}</td>
                    <td>{{ \Carbon\Carbon::parse($acara->tanggal_acara)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($acara->batas_pendaftaran)->format('d-m-Y') }}</td>
                    <td>{{ $acara->panitia->user->name }}</td>
                    <td>{{ ucfirst($acara->status) }}</td>
                    <td>{{ $acara->pendaftarans->count() }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">Tidak ada data acara</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        Dicetak oleh: {{ Auth::user()->name }} pada {{ now()->format('d-m-Y H:i:s') }}
    </div>
</body>
</html>