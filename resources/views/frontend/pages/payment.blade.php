@extends('frontend.layouts.master')
@section('title','Berkah Tani | Hubungi Kami')
@section('main-content')
<!-- Breadcrumbs -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="{{route('home')}}">Beranda<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="javascript:void(0);">Pembayaran</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<section id="contact-us" class="contact-us section py-5">
    <div class="container">
        <div class="contact-head">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-lg border-0">
                        <div class="card-body p-4">
                            <h2 class="text-center mb-4">Silakan Lakukan Pembayaran</h2>
                            <p class="text-center mb-4">
                                <strong>Total Pembayaran:</strong>
                                <span class="text-success">Rp{{ number_format($order->total_amount, 2) }}</span>
                            </p>

                            <h3 class="mb-3">Detail Produk</h3>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Nama Produk</th>
                                            <th>Harga Satuan</th>
                                            <th>Kuantitas</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cartItems as $item)
                                        <tr>
                                            <td>{{ $item->product->title }}</td>
                                            <td>Rp{{ number_format($item->price, 2) }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>Rp{{ number_format($item->price * $item->quantity, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-end">
                                                <strong>Total:</strong>
                                            </td>
                                            <td>
                                                <strong class="text-success">Rp{{ number_format($order->total_amount, 2)
                                                    }}</strong>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="d-grid mt-4">
                                <button id="pay-button" class="btn btn-primary btn-lg">
                                    <i class="fas fa-credit-card"></i> Bayar Sekarang
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script>
    document.getElementById('pay-button').addEventListener('click', function () {
        snap.pay("{{ $snapToken }}", {
            onSuccess: function (result) {
                alert('Pembayaran berhasil!');
                window.location.href = "{{ route('home') }}";
            },
            onPending: function (result) {
                alert('Menunggu pembayaran Anda!');
            },
            onError: function (result) {
                alert('Pembayaran gagal!');
            }
        });
    });
</script>
@endsection