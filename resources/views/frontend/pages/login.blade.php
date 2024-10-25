@extends('frontend.layouts.master')

@section('title','Berkah Tani || Login')

@section('main-content')
<!-- Breadcrumbs -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="{{route('home')}}">Beranda<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="javascript:void(0);">Login</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbs -->

<!-- Shop Login -->
<section class="shop login section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 col-12">
                <div class="login-form">
                    <h2>Masuk</h2>
                    <p>Silakan daftar untuk proses checkout yang lebih cepat</p>
                    <!-- Formulir -->
                    <form class="form" method="post" action="{{route('login.submit')}}">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Email Anda<span>*</span></label>
                                    <input type="email" name="email" placeholder="" required="required"
                                        value="{{old('email')}}">
                                    @error('email')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Password Anda<span>*</span></label>
                                    <input type="password" name="password" placeholder="" required="required"
                                        value="{{old('password')}}">
                                    @error('password')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <div class="form-group login-btn">
                                    <button class="btn" type="submit">Masuk</button>
                                    <a href="{{route('register.form')}}" class="btn">Daftar</a>
                                    {{-- ATAU
                                    <a href="{{route('login.redirect','facebook')}}" class="btn btn-facebook"><i
                                            class="ti-facebook"></i></a>
                                    <a href="{{route('login.redirect','github')}}" class="btn btn-github"><i
                                            class="ti-github"></i></a>
                                    <a href="{{route('login.redirect','google')}}" class="btn btn-google"><i
                                            class="ti-google"></i></a> --}}

                                </div>
                                <div class="checkbox">
                                    <label class="checkbox-inline" for="2"><input name="news" id="2"
                                            type="checkbox">Ingat saya</label>
                                </div>
                                @if (Route::has('password.request'))
                                <a class="lost-pass" href="{{ route('password.reset') }}">
                                    Lupa password?
                                </a>
                                @endif
                            </div>
                        </div>
                    </form>
                    <!--/ End Formulir -->
                </div>
            </div>
        </div>
    </div>
</section>
<!--/ End Login -->
@endsection
@push('styles')
<style>
    .shop.login .form .btn {
        margin-right: 0;
    }

    .btn-facebook {
        background: #39579A;
    }

    .btn-facebook:hover {
        background: #073088 !important;
    }

    .btn-github {
        background: #444444;
        color: white;
    }

    .btn-github:hover {
        background: black !important;
    }

    .btn-google {
        background: #ea4335;
        color: white;
    }

    .btn-google:hover {
        background: rgb(243, 26, 26) !important;
    }
</style>
@endpush
