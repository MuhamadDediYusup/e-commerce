{{-- @extends('frontend.layouts.master')

@section('title', 'Berkah Tani || Login')

@section('main-content')
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

<section class="shop login section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 col-12">
                <div class="login-form">
                    <h2>Masuk</h2>
                    <p>Silakan daftar untuk proses checkout yang lebih cepat</p>
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
                                </div>
                                <div class="form-group login-btn mt-2">
                                    <a href="{{route('login')}}" class="btn">Masuk Sebagai Admin</a>
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
                </div>
            </div>
        </div>
    </div>
</section>
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
@endpush --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Berkah Tani || Login</title>
    @include('backend.layouts.head')

</head>

<body class="bg-gradient-success">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9 mt-5">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <img src="{{ asset('backend/img/logo3.png') }}" alt="login"
                                        class="img-fluid mx-auto d-block" style="width: 200px;">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Selamat Datang Kembali!</h1>
                                    </div>
                                    <form class="user" method="POST" action="{{ route('login.submit') }}">
                                        @csrf
                                        <div class="form-group">
                                            <input type="email"
                                                class="form-control form-control-user @error('email') is-invalid @enderror"
                                                name="email" value="{{ old('email') }}" id="exampleInputEmail"
                                                aria-describedby="emailHelp" placeholder="Masukkan Email..." required
                                                autocomplete="email" autofocus>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input type="password"
                                                class="form-control form-control-user @error('password') is-invalid @enderror"
                                                id="exampleInputPassword" placeholder="Masukkan Kata Sandi..."
                                                name="password" required autocomplete="current-password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                        </div>
                                        <button type="submit" class="btn btn-user btn-block btn-success">
                                            Login
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</body>

</html>
