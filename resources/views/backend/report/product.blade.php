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
        <div class="table-responsive">
            @if (count($report) > 0)
            <table class="table table-bordered" id="order-dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Produk</th>
                        <th>Slug</th>
                        <th>Total Kuantitas</th>
                        <th>Total Pembelian (Amount)</th>
                        <th>Total Pesanan</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Nama Produk</th>
                        <th>Slug</th>
                        <th>Total Kuantitas</th>
                        <th>Total Pembelian (Amount)</th>
                        <th>Total Pesanan</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($report as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->product_title }}</td>
                        <td>{{ $item->product_slug }}</td>
                        <td>{{ $item->total_quantity }}</td>
                        <td>{{ number_format($item->total_amount, 2) }}</td>
                        <td>{{ $item->total_orders }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <span style="float:right">{{ $report->links() }}</span>
            @else
            <h6 class="text-center">Tidak ada laporan yang ditemukan!!!</h6>
            @endif
        </div>
    </div>
</div>
@endsection