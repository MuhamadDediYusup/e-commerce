@extends('frontend.layouts.master')

@section('title','Checkout')

@section('main-content')

<!-- Breadcrumbs -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="{{route('home')}}">Beranda<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="javascript:void(0)">Checkout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbs -->

<!-- Start Checkout -->
<section class="shop checkout section">
    <div class="container">
        <form class="form" method="POST" action="{{route('cart.order')}}">
            @csrf
            <div class="row">

                <div class="col-lg-8 col-12">
                    <div class="checkout-form">
                        <h2>Lakukan Checkout Anda di Sini</h2>
                        <p>Silakan mendaftar untuk melakukan checkout lebih cepat</p>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Nama Depan<span>*</span></label>
                                    <input type="text" name="first_name" placeholder=""
                                        value="{{old('first_name', $checkoutInfo->first_name)}}">
                                    @error('first_name')
                                    <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Nama Belakang<span>*</span></label>
                                    <input type="text" name="last_name" placeholder=""
                                        value="{{old('lat_name', $checkoutInfo->last_name)}}">
                                    @error('last_name')
                                    <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Alamat Email<span>*</span></label>
                                    <input type="email" name="email" placeholder=""
                                        value="{{old('email', $checkoutInfo->email)}}">
                                    @error('email')
                                    <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Nomor Telepon <span>*</span></label>
                                    <input type="number" name="phone" placeholder="" required
                                        value="{{old('phone', $checkoutInfo->phone_number)}}">
                                    @error('phone')
                                    <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Negara<span>*</span></label>
                                    <select name="country" id="country" readonly>
                                        <option value="ID" {{ old('country', $checkoutInfo->country) == 'ID' ?
                                            'selected' : '' }}>Indonesia</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Alamat Baris 1<span>*</span></label>
                                    <input type="text" name="address1" placeholder=""
                                        value="{{old('address1', $checkoutInfo->address_line1)}}">
                                    @error('address1')
                                    <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Alamat Baris 2</label>
                                    <input type="text" name="address2" placeholder=""
                                        value="{{old('address2', $checkoutInfo->address_line2)}}">
                                    @error('address2')
                                    <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Kode Pos</label>
                                    <input type="text" name="post_code" placeholder=""
                                        value="{{old('post_code', $checkoutInfo->postal_code)}}">
                                    @error('post_code')
                                    <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="order-details">
                        <div class="single-widget">
                            <h2>TOTAL KERANJANG</h2>
                            <div class="content">
                                <ul>
                                    <li class="order_subtotal" data-price="{{Helper::totalCartPrice()}}">Subtotal
                                        Keranjang<span>Rp{{number_format(Helper::totalCartPrice(),2)}}</span></li>
                                    <li class="shipping">
                                        Biaya Pengiriman
                                        @if(count(Helper::shipping())>0 && Helper::cartCount()>0)
                                        <select name="shipping" class="nice-select">
                                            <option value="">Pilih alamat Anda</option>
                                            @foreach(Helper::shipping() as $shipping)
                                            <option value="{{$shipping->id}}" class="shippingOption"
                                                data-price="{{$shipping->price}}">{{$shipping->type}}:
                                                Rp{{$shipping->price}}</option>
                                            @endforeach
                                        </select>
                                        @else
                                        <span>Gratis</span>
                                        @endif
                                    </li>

                                    @if(session('coupon'))
                                    <li class="coupon_price" data-price="{{session('coupon')['value']}}">Anda
                                        Hemat<span>Rp{{number_format(session('coupon')['value'],2)}}</span></li>
                                    @endif
                                    @php
                                    $total_amount=Helper::totalCartPrice();
                                    if(session('coupon')){
                                    $total_amount=$total_amount-session('coupon')['value'];
                                    }
                                    @endphp
                                    @if(session('coupon'))
                                    <li class="last" id="order_total_price">
                                        Total<span>Rp{{number_format($total_amount,2)}}</span></li>
                                    @else
                                    <li class="last" id="order_total_price">
                                        Total<span>Rp{{number_format($total_amount,2)}}</span></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="single-widget get-button">
                            <div class="content">
                                <div class="button">
                                    <button type="submit" class="btn">lanjut ke pembayaran</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<section class="shop-services section home">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-3 col-md-6 col-12">
                <div class="single-service">
                    <i class="ti-rocket"></i>
                    <h4>Pengiriman Gratis</h4>
                    <p>Pesanan di atas Rp100.000</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="single-service">
                    <i class="ti-lock"></i>
                    <h4>Pembayaran Aman</h4>
                    <p>Pembayaran 100% aman</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="single-service">
                    <i class="ti-tag"></i>
                    <h4>Harga Terbaik</h4>
                    <p>Harga terjamin</p>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script src="{{asset('frontend/js/nice-select/js/jquery.nice-select.min.js')}}"></script>
<script src="{{ asset('frontend/js/select2/js/select2.min.js') }}"></script>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script>
    const ORDER_ID = "{{ $order_id ?? '' }}"; // Sisipkan order_id dari backend
</script>

<script>
    $(document).ready(function() { $("select.select2").select2(); });
  		$('select.nice-select').niceSelect();
</script>
<script>
    function showMe(box){
			var checkbox=document.getElementById('shipping').style.display;
			var vis= 'none';
			if(checkbox=="none"){
				vis='block';
			}
			if(checkbox=="block"){
				vis="none";
			}
			document.getElementById(box).style.display=vis;
		}
</script>
<script>
    $(document).ready(function(){
			$('.shipping select[name=shipping]').change(function(){
				let cost = parseFloat( $(this).find('option:selected').data('price') ) || 0;
				let subtotal = parseFloat( $('.order_subtotal').data('price') );
				let coupon = parseFloat( $('.coupon_price').data('price') ) || 0;
				$('#order_total_price span').text('$'+(subtotal + cost-coupon).toFixed(2));
			});

		});
</script>
<script>
    document.getElementById('pay-button').addEventListener('click', function () {
    fetch('/payment/checkout', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ order_id: ORDER_ID })
    })
    .then(response => response.json())
    .then(data => {
        snap.pay(data.snap_token, {
            onSuccess: function(result) {
                console.log('Payment success:', result);
                alert('Payment successful!');
            },
            onPending: function(result) {
                console.log('Waiting for payment:', result);
                alert('Payment pending!');
            },
            onError: function(result) {
                console.log('Payment failed:', result);
                alert('Payment failed!');
            }
        });
    });
});

</script>
@endpush


<!-- End Shop Services Area -->
@endsection
@push('styles')
<style>
    li.shipping {
        display: inline-flex;
        width: 100%;
        font-size: 14px;
    }

    li.shipping .input-group-icon {
        width: 100%;
        margin-left: 10px;
    }

    .input-group-icon .icon {
        position: absolute;
        left: 20px;
        top: 0;
        line-height: 40px;
        z-index: 3;
    }

    .form-select {
        height: 30px;
        width: 100%;
    }

    .form-select .nice-select {
        border: none;
        border-radius: 0px;
        height: 40px;
        background: #f6f6f6 !important;
        padding-left: 45px;
        padding-right: 40px;
        width: 100%;
    }

    .list li {
        margin-bottom: 0 !important;
    }

    .list li:hover {
        background: #F7941D !important;
        color: white !important;
    }

    .form-select .nice-select::after {
        top: 14px;
    }
</style>
@endpush