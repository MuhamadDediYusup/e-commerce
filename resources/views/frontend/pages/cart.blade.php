@extends('frontend.layouts.master')
@section('title','Keranjang Belanja')
@section('main-content')
<!-- Breadcrumbs -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="{{('home')}}">Beranda<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="">Keranjang Belanja</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbs -->

<!-- Shopping Cart -->
<div class="shopping-cart section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- Ringkasan Belanja -->
                <table class="table shopping-summery">
                    <thead>
                        <tr class="main-hading">
                            <th>PRODUK</th>
                            <th>NAMA</th>
                            <th class="text-center">HARGA SATUAN</th>
                            <th class="text-center">JUMLAH</th>
                            <th class="text-center">TOTAL</th>
                            <th class="text-center"><i class="ti-trash remove-icon"></i></th>
                        </tr>
                    </thead>
                    <tbody id="cart_item_list">
                        <form action="{{route('cart.update')}}" method="POST">
                            @csrf
                            @if(Helper::getAllProductFromCart())
                            @foreach(Helper::getAllProductFromCart() as $cart)
                            <tr>
                                @php
                                $photo = explode(',', $cart->product['photo']);
                                @endphp
                                <td class="image" data-title="No"><img src="{{$photo[0]}}" alt="{{$photo[0]}}"></td>
                                <td class="product-des" data-title="Deskripsi">
                                    <p class="product-name"><a
                                            href="{{route('product-detail', $cart->product['slug'])}}"
                                            target="_blank">{{$cart->product['title']}}</a></p>
                                    <p class="product-des">{!!($cart['summary']) !!}</p>
                                </td>
                                <td class="price" data-title="Harga">
                                    <span>Rp{{number_format($cart['price'], 2)}}</span>
                                </td>
                                <td class="qty" data-title="Jumlah">
                                    <div class="input-group">
                                        <div class="button minus">
                                            <button type="button" class="btn btn-primary btn-number" data-type="minus"
                                                data-field="quant[{{$cart->id}}]">
                                                <i class="ti-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" name="quant[{{$cart->id}}]" class="input-number" data-min="1"
                                            data-max="{{ $cart->product->stock }}" value="{{ $cart->quantity }}">
                                        <input type="hidden" name="qty_id[]" value="{{$cart->id}}">
                                        <div class="button plus">
                                            <button type="button" class="btn btn-primary btn-number" data-type="plus"
                                                data-field="quant[{{$cart->id}}]">
                                                <i class="ti-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="total-amount cart_single_price" data-title="Total">
                                    <span class="money">Rp{{number_format($cart['amount'], 2)}}</span>
                                </td>
                                <td class="action" data-title="Hapus">
                                    <a href="{{route('cart-delete', $cart->id)}}"><i
                                            class="ti-trash remove-icon"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                {{-- <td class="float-right">
                                    <button class="btn float-right" type="submit">Perbarui</button>
                                </td> --}}
                            </tr>
                            @else
                            <tr>
                                <td class="text-center">
                                    Tidak ada keranjang yang tersedia. <a href="{{route('product-grids')}}"
                                        style="color:blue;">Lanjutkan
                                        berbelanja</a>
                                </td>
                            </tr>
                            @endif
                        </form>
                    </tbody>
                </table>
                <!--/ End Ringkasan Belanja -->
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <!-- Total Pembayaran -->
                <div class="total-amount">
                    <div class="row">
                        <div class="col-lg-8 col-md-5 col-12">
                            <div class="left">
                                <div class="coupon">
                                    <form action="{{route('coupon-store')}}" method="POST">
                                        @csrf
                                        <input name="code" placeholder="Masukkan Kupon Anda">
                                        <button class="btn">Terapkan</button>
                                    </form>
                                </div>
                                {{-- <div class="checkbox">`
                                    @php
                                    $shipping=DB::table('shippings')->where('status','active')->limit(1)->get();
                                    @endphp
                                    <label class="checkbox-inline" for="2"><input name="news" id="2" type="checkbox"
                                            onchange="showMe('shipping');"> Pengiriman</label>
                                </div> --}}
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-7 col-12">
                            <div class="right">
                                <ul>
                                    <li class="order_subtotal" data-price="{{Helper::totalCartPrice()}}">Subtotal
                                        Keranjang<span>Rp{{number_format(Helper::totalCartPrice(),2)}}</span></li>

                                    @if(session()->has('coupon'))
                                    <li class="coupon_price" data-price="{{Session::get('coupon')['value']}}">
                                        Anda
                                        Hemat<span>Rp{{number_format(Session::get('coupon')['value'],2)}}</span>
                                    </li>
                                    @endif
                                    @php
                                    $total_amount=Helper::totalCartPrice();
                                    if(session()->has('coupon')){
                                    $total_amount=$total_amount-Session::get('coupon')['value'];
                                    }
                                    @endphp
                                    @if(session()->has('coupon'))
                                    <li class="last" id="order_total_price">Anda
                                        Bayar<span>Rp{{number_format($total_amount,2)}}</span></li>
                                    @else
                                    <li class="last" id="order_total_price">Anda
                                        Bayar<span>Rp{{number_format($total_amount,2)}}</span></li>
                                    @endif
                                </ul>
                                <div class="button5">
                                    <a href="{{route('checkout')}}" class="btn">Checkout</a>
                                    <a href="{{route('product-grids')}}" class="btn">Lanjutkan berbelanja</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ End Total Pembayaran -->
            </div>
        </div>
    </div>
</div>
<!--/ End Shopping Cart -->

<!-- Start Shop Services Area -->
<section class="shop-services section home">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Mulai Layanan Tunggal -->
                <div class="single-service">
                    <i class="ti-rocket"></i>
                    <h4>Pengiriman Gratis</h4>
                    <p>Pesanan di atas Rp100.000</p>
                </div>
                <!-- Akhir Layanan Tunggal -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Mulai Layanan Tunggal -->
                <div class="single-service">
                    <i class="ti-lock"></i>
                    <h4>Pembayaran Aman</h4>
                    <p>Pembayaran 100% aman</p>
                </div>
                <!-- Akhir Layanan Tunggal -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Mulai Layanan Tunggal -->
                <div class="single-service">
                    <i class="ti-tag"></i>
                    <h4>Harga Terbaik</h4>
                    <p>Harga terjamin</p>
                </div>
                <!-- Akhir Layanan Tunggal -->
            </div>
        </div>
    </div>
</section>
<!-- End Shop Services Area -->

<script>
    document.getElementById('quantityInput').addEventListener('change', function () {
            const maxStock = parseInt(this.dataset.max);
            const value = parseInt(this.value);

            if (value > maxStock) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Jumlah melebihi stok yang tersedia!',
                });
                this.value = maxStock;
            }
        });
</script>

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
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('frontend/js/nice-select/js/jquery.nice-select.min.js')}}"></script>
<script src="{{asset('frontend/js/select2/js/select2.min.js')}}"></script>
<script>
    $(document).ready(function () {
    $("select.select2").select2();
    $('select.nice-select').niceSelect();

    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    if (!csrfToken) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'CSRF Token tidak ditemukan di halaman!',
        });
        return;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    });

    let isUpdating = false;

    function updateCart(input, cartId, quantity) {
        if (isUpdating) {
            return;
        }

        isUpdating = true;

        let maxStock = parseInt(input.data('max')) || 9999;
        let minStock = parseInt(input.data('min')) || 1;

        if (isNaN(quantity) || quantity < minStock) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Jumlah minimal adalah 1!',
            });
            input.val(minStock);
            isUpdating = false;
            return;
        }

        if (quantity > maxStock) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Jumlah melebihi stok yang tersedia!',
            });
            input.val(maxStock);
            isUpdating = false;
            return;
        }

        $.ajax({
            url: '{{ route("cart.update") }}',
            method: 'POST',
            data: {
                qty_id: [cartId],
                quant: { [cartId]: quantity }
            },
            success: function (response) {
                if (response.errors && response.errors.length > 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.errors.join(' '),
                    });
                    isUpdating = false;
                    return;
                }

                let cartRow = input.closest('tr');
                let newAmount = response.cart_amount || 0;
                cartRow.find('.total-amount span').text('Rp' + newAmount.toLocaleString('id-ID', { minimumFractionDigits: 2 }));

                $('.order_subtotal span').text('Rp' + (response.subtotal || 0).toLocaleString('id-ID', { minimumFractionDigits: 2 }));
                $('#order_total_price span').text('Rp' + (response.total || 0).toLocaleString('id-ID', { minimumFractionDigits: 2 }));

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Keranjang berhasil diperbarui!',
                    timer: 1500,
                    showConfirmButton: false
                });

                isUpdating = false;
            },
            error: function (xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: xhr.responseJSON?.error || 'Gagal memperbarui keranjang!',
                });
                isUpdating = false;
            }
        });
    }

    $(document).off('click.cartUpdate', '.btn-number');
    $(document).on('click.cartUpdate', '.btn-number', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        if (isUpdating) {
            return false;
        }

        let button = $(this);
        let input = button.closest('.input-group').find('.input-number');
        let type = button.data('type');
        let cartId = input.siblings('input[name="qty_id[]"]').val();
        let currentVal = parseInt(input.val()) || 1;

        if (!cartId) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Cart ID tidak valid!',
            });
            return false;
        }

        let newVal = currentVal;
        if (type === 'plus') {
            newVal = currentVal + 1;
        } else if (type === 'minus' && currentVal > 1) {
            newVal = currentVal - 1;
        }

        if (newVal !== currentVal) {
            input.val(newVal);
            updateCart(input, cartId, newVal);
        }

        return false;
    });

    $(document).off('change.cartUpdate', '.input-number');
    $(document).on('change.cartUpdate', '.input-number', function () {
        if (isUpdating) {
            return;
        }

        let input = $(this);
        let cartId = input.siblings('input[name="qty_id[]"]').val();
        let quantity = parseInt(input.val()) || 1;

        if (!cartId) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Cart ID tidak valid!',
            });
            return;
        }

        updateCart(input, cartId, quantity);
    });

    $('form').on('submit', function() {
        $(this).find('button[type="submit"]').prop('disabled', true);
    });
});
</script>
@endpush
