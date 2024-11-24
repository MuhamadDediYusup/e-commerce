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

<section id="contact-us" class="contact-us section">
    <div class="container">
        <div class="contact-head">
            <div class="row">
                <div class="col-12">
                    <div class="container">
                        <h2>Silakan Lakukan Pembayaran</h2>
                        <p>Total Pembayaran: Rp{{ number_format($order->total_amount, 2) }}</p>

                        <h3>Detail Produk</h3>
                        <table class="table table-bordered">
                            <thead>
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
                                    <td colspan="3"><strong>Total:</strong></td>
                                    <td><strong>Rp{{ number_format($order->total_amount, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>

                        <button id="pay-button" class="btn btn-primary">Bayar Sekarang</button>
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