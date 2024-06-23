@extends('frontend.layouts.master')

@section('title','E-SHOP || About Us')

@section('main-content')

<!-- Breadcrumbs -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="index1.html">Home<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="blog-single.html">About Us</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbs -->

<!-- About Us -->
<section class="about-us section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="about-content">
                    @php
                    $settings=DB::table('settings')->get();
                    @endphp
                    <h3>Welcome To <span>Berkah Tani</span></h3>
                    <p>@foreach($settings as $data) {{$data->description}} @endforeach</p>
                    <div class="button">
                        <a href="{{route('contact')}}" class="btn primary">Contact Us</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="about-img overlay">
                    <img src="@foreach($settings as $data) {{$data->photo}} @endforeach"
                        alt="@foreach($settings as $data) {{$data->photo}} @endforeach">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End About Us -->


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
@endsection