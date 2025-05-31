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
        .stat-box {
            display: inline-block;
            width: 30%;
            margin: 1%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-align: center;
        }
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            margin: 5px 0;
        }
        .stat-label {
            font-size: 12px;
            color: #666;
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
        @if($period)
            <div>Periode: {{ ucfirst($period) }}</div>
        @endif
    </div>
    
    <div class="section">
        <div class="section-title">Ringkasan Statistik</div>
        
        <div class="stat-box">
            <div class="stat-number">{{ array_sum($users) }}</div>
            <div class="stat-label">Total Pengguna</div>
        </div>
        
        <div class="stat-box">
            <div class="stat-number">{{ array_sum($acaras) }}</div>
            <div class="stat-label">Total Acara</div>
        </div>
        
        <div class="stat-box">
            <div class="stat-number">{{ array_sum($pendaftarans) }}</div>
            <div class="stat-label">Total Pendaftaran</div>
        </div>
    </div>
    
    <div class="section">
        <div class="section-title">Statistik Pengguna</div>
        <table>
            <thead>
                <tr>
                    <th>Role</th>
                    <th>Jumlah</th>
                    <th>Persentase</th>
                </tr>
            </thead>
            <tbody>
                @php $totalUsers = array_sum($users); @endphp
                @foreach($users as $role => $count)
                    <tr>
                        <td>{{ ucfirst($role) }}</td>
                        <td>{{ $count }}</td>
                        <td>{{ $totalUsers > 0 ? number_format(($count / $totalUsers) * 100, 2) : 0 }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="section">
        <div class="section-title">Statistik Acara</div>
        <table>
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Jumlah</th>
                    <th>Persentase</th>
                </tr>
            </thead>
            <tbody>
                @php $totalAcaras = array_sum($acaras); @endphp
                @foreach($acaras as $status => $count)
                    <tr>
                        <td>{{ ucfirst($status) }}</td>
                        <td>{{ $count }}</td>
                        <td>{{ $totalAcaras > 0 ? number_format(($count / $totalAcaras) * 100, 2) : 0 }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="section">
        <div class="section-title">Statistik Pendaftaran</div>
        <table>
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Jumlah</th>
                    <th>Persentase</th>
                </tr>
            </thead>
            <tbody>
                @php $totalPendaftarans = array_sum($pendaftarans); @endphp
                @foreach($pendaftarans as $status => $count)
                    <tr>
                        <td>{{ ucfirst($status) }}</td>
                        <td>{{ $count }}</td>
                        <td>{{ $totalPendaftarans > 0 ? number_format(($count / $totalPendaftarans) * 100, 2) : 0 }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="footer">
        Dicetak oleh: {{ Auth::user()->name }} pada {{ now()->format('d-m-Y H:i:s') }}
    </div>
</body>
</html>