@php
    $totalAmount = 0;
    foreach ($report as $r) {
        $totalAmount += $r->total_amount;
    }
@endphp
@extends('backend.layouts.master')

@section('main-content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row">
            <div class="col-md-12">
                @include('backend.layouts.notification')
            </div>
        </div>
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-success float-left">Laporan Jumlah Pembelian Berdasarkan Produk</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('products.report') }}" method="GET" class="form-inline mb-3">
                <label for="month" class="mr-2">Pilih Bulan:</label>
                <select name="month" id="month" class="form-control mr-2">
                    <option value="" {{ request('month') == '' ? 'selected' : '' }}>Semua Bulan</option>
                    @foreach(range(1, 12) as $b)
                        <option value="{{ $b }}" {{ request('month') == $b ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($b)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>
                <select name="year" class="form-control mr-2">
                    <option value="" {{ request('year') == '' ? 'selected' : '' }}>Semua Tahun</option>
                    @for($year = date('Y'); $year >= 2020; $year--)
                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endfor
                </select>
                <button type="submit" class="btn btn-success">Filter</button>
                <a href="{{ route('products.print', ['month' => request('month'), 'year' => request('year')]) }}"
                   target="_blank" class="btn btn-primary ml-2">Cetak laporan</a>
            </form>

            <div class="table-responsive">
                @if (count($report) > 0)
                    <table class="table table-bordered" id="order-dataTable" width="100%" cellspacing="0">
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
                        <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Total Kuantitas</th>
                            <th>Total Pembelian (Amount)</th>
                            <th>Total Pesanan</th>
                            <th>Tanggal</th>
                        </tr>
                        </tfoot>
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
                    <div class="mt-3">
                        <h5 class="text-right font-weight-bold">
                            Total Keseluruhan Pembelian: <span class="text-success">{{ 'Rp' . number_format($totalAmount, 2, ',', '.') }}</span>
                        </h5>
                    </div>
                    <span style="float:right">{{ $report->links() }}</span>
                @else
                    <h6 class="text-center">Tidak ada laporan yang ditemukan!!!</h6>
                @endif
            </div>
        </div>
    </div>
@endsection
