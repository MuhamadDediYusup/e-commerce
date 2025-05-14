<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pembelian Produk</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid #000; }
        th, td { padding: 5px; text-align: left; }

        .kop {
            text-align: center;
            margin-bottom: 10px;
        }

        .kop img {
            width: 80px;
            height: auto;
            float: left;
        }

        .kop .title {
            font-size: 16px;
            font-weight: bold;
        }

        .clear {
            clear: both;
        }
    </style>
</head>
<body>

<div class="kop">
    <img src="{{ public_path('backend/img/logo.png') }}" alt="Logo">
    <div class="title">Laporan Jumlah Pembelian Berdasarkan Produk</div>
    <div style="font-size: 12px;">{{ $setting->address }} | Telepon: {{ $setting->phone }}</div>
</div>
<div class="clear"></div>

<p>Bulan: {{ $month ? \Carbon\Carbon::create()->month($month)->translatedFormat('F') : 'Semua Bulan' }}</p>
<p>Tahun: {{ $year ?? 'Semua Tahun' }}</p>

<table>
    <thead>
    <tr>
        <th>No</th>
        <th>Nama Produk</th>
        <th>Total Kuantitas</th>
        <th>Total Pembelian (Amount)</th>
        <th>Total Pesanan</th>
        <th>Tanggal</th>
    </tr>
    </thead>
    <tbody>
    @foreach($report as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->product_title }}</td>
            <td>{{ $item->total_quantity }}</td>
            <td>{{ 'Rp'.number_format($item->total_amount, 2, ',', '.') }}</td>
            <td>{{ $item->total_orders }}</td>
            <td>{{ \Carbon\Carbon::parse($item->last_created_at)->locale('id')->translatedFormat('d F Y') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
