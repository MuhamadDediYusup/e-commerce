@extends('frontend.layouts.master')
@section('title','Berkah Tani')
@section('main-content')
<!-- Slider Area -->
@if(count($banners)>0)
<section id="Gslider" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        @foreach($banners as $key=>$banner)
        <li data-target="#Gslider" data-slide-to="{{$key}}" class="{{(($key==0)? 'active' : '')}}"></li>
        @endforeach

    </ol>
    <div class="carousel-inner" role="listbox">
        @foreach($banners as $key=>$banner)
        <div class="carousel-item {{(($key==0)? 'active' : '')}}">
            <img class="first-slide" src="{{$banner->photo}}" alt="First slide">
            <div class="carousel-caption d-none d-md-block text-left">
                <h1 class="wow fadeInDown">{{$banner->title}}</h1>
                <p>{!! html_entity_decode($banner->description) !!}</p>
                <a class="btn btn-lg ws-btn wow fadeInUpBig" href="{{route('product-grids')}}" role="button">Belanja
                    Sekarang<i class="far fa-arrow-alt-circle-right"></i></i></a>
            </div>
        </div>
        @endforeach
    </div>
    <a class="carousel-control-prev" href="#Gslider" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Sebelumnya</span>
    </a>
    <a class="carousel-control-next" href="#Gslider" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Selanjutnya</span>
    </a>
</section>
@endif

<!--/ End Slider Area -->


<!-- Start Product Area -->
<div class="product-area section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Barang Sedang Tren</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="product-info">
                    <div class="nav-main">
                        <!-- Tab Nav -->
                        <ul class="nav nav-tabs filter-tope-group" id="myTab" role="tablist">
                            @php
                            $categories=DB::table('categories')->get();
                            // dd($categories);
                            @endphp
                            @if($categories)
                            <button class="btn" style="background:#354458" data-filter="*">
                                Semua produk
                            </button>
                            @foreach($categories as $key=>$cat)
                            <button class="btn" style="background:none;color:#354458;" data-filter=".{{$cat->id}}">
                                {{$cat->title}}
                            </button>
                            @endforeach
                            @endif
                        </ul>
                        <!--/ End Tab Nav -->
                    </div>

                    <div class="tab-content isotope-grid" id="myTabContent">
                        @if($product_lists)
                        @foreach($product_lists as $key=>$product)
                        <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item {{$product->category_id}}">
                            <div class="single-product">
                                <div class="product-img">
                                    <a href="{{route('product-detail',$product->slug)}}">
                                        @php
                                        $photo=explode(',',$product->photo);
                                        @endphp
                                        <img class="default-img" src="{{$photo[0]}}" alt="{{$photo[0]}}" width="100%"
                                            height="300px">
                                        <img class="hover-img" src="{{$photo[0]}}" alt="{{$photo[0]}}" width="100%"
                                            height="300px">
                                        @if($product->stock<=0) <span class="out-of-stock">Sale out</span>
                                            @else
                                            <span class="price-dec">Diskon {{$product->discount}}%</span>
                                            @endif
                                    </a>
                                    <div class="button-head">
                                        <div class="product-action-2">
                                            <a title="Add to cart" href="{{route('add-to-cart',$product->slug)}}">Tambah
                                                ke Keranjang</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h3><a href="{{route('product-detail',$product->slug)}}">{{$product->title}}</a>
                                    </h3>
                                    <div class="product-price">
                                        @php
                                        $after_discount=($product->price-($product->price*$product->discount)/100);
                                        @endphp
                                        <span>Rp{{number_format($after_discount,2)}}</span>
                                        <del style="padding-left:4%;">Rp{{number_format($product->price,2)}}</del>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Product Area -->

<!-- Start Shop Home List  -->
<section class="shop-home-list section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="shop-section-title">
                            <h1>Barang Terbaru</h1>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @php
                    $product_lists=DB::table('products')->where('status','active')->orderBy('id','DESC')->limit(6)->get();
                    @endphp
                    @foreach($product_lists as $product)
                    <div class="col-md-4">
                        <!-- Start Single List  -->
                        <div class="single-list">
                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <div class="list-image overlay">
                                        @php
                                        $photo=explode(',',$product->photo);
                                        @endphp
                                        <img src="{{asset($photo[0])}}" width="100%" height="300px"
                                            alt="{{asset($photo[0])}}">
                                        <a href="{{route('add-to-cart',$product->slug)}}" class="buy"><i
                                                class="fa fa-shopping-bag"></i></a>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12 ">
                                    <div class="content">
                                        <h4 class="title"><a
                                                href="{{route('product-detail',$product->slug)}}">{{$product->title}}</a>
                                        </h4>
                                        @php
                                        $after_discount=($product->price-($product->price*$product->discount)/100);
                                        @endphp
                                        <span>Rp{{number_format($after_discount,2)}}</span>
                                        <del style="padding-left:4%;">Rp{{number_format($product->price,2)}}</del>
                                        <p class="price with-discount">Diskon {{number_format($product->discount)}}%</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Single List  -->
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Shop Home List  -->

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

{{-- @include('frontend.layouts.newsletter') --}}

<!-- Modal -->
@if($product_lists)
@foreach($product_lists as $key=>$product)
<div class="modal fade" id="{{$product->id}}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close"
                        aria-hidden="true"></span></button>
            </div>
            <div class="modal-body">
                <div class="row no-gutters">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <!-- Product Slider -->
                        <div class="product-gallery">
                            <div class="quickview-slider-active">
                                @php
                                $photo=explode(',',$product->photo);
                                // dd($photo);
                                @endphp

                                @foreach($photo as $data)
                                <img src="{{ asset($data) }}" alt="{{$data}}">
                                <div class="slider">
                                    <img src="{{ asset($data) }}" alt="{{$data}}">
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- End Product slider -->
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <div class="quickview-content">
                            <h2>{{$product->title}}</h2>
                            <div class="quickview-ratting-review">
                                <div class="quickview-ratting-wrap">
                                    <div class="quickview-ratting">
                                        @php
                                        $rate=DB::table('product_reviews')->where('product_id',$product->id)->avg('rate');
                                        $rate_count=DB::table('product_reviews')->where('product_id',$product->id)->count();
                                        @endphp
                                        @for($i=1; $i<=5; $i++) @if($rate>=$i)
                                            <i class="yellow fa fa-star"></i>
                                            @else
                                            <i class="fa fa-star"></i>
                                            @endif
                                            @endfor
                                    </div>
                                    <a href="#"> ({{$rate_count}} ulasan pelanggan)</a>
                                </div>
                                <div class="quickview-stock">
                                    @if($product->stock >0)
                                    <span><i class="fa fa-check-circle-o"></i> {{$product->stock}} persediaan</span>
                                    @else
                                    <span><i class="fa fa-times-circle-o text-danger"></i> {{$product->stock}} kehabisan
                                        stok</span>
                                    @endif
                                </div>
                            </div>
                            @php
                            $after_discount=($product->price-($product->price*$product->discount)/100);
                            @endphp
                            <h3><small><del class="text-muted">${{number_format($product->price,2)}}</del></small>
                                ${{number_format($after_discount,2)}} </h3>
                            <div class="quickview-peragraph">
                                <p>{!! html_entity_decode($product->summary) !!}</p>
                            </div>
                            <form action="{{route('single-add-to-cart')}}" method="POST" class="mt-4">
                                @csrf
                                <div class="quantity">
                                    <!-- Input Order -->
                                    <div class="input-group">
                                        <div class="button minus">
                                            <button type="button" class="btn btn-primary btn-number" disabled="disabled"
                                                data-type="minus" data-field="quant[1]">
                                                <i class="ti-minus"></i>
                                            </button>
                                        </div>
                                        <input type="hidden" name="slug" value="{{$product->slug}}">
                                        <input type="text" name="quant[1]" class="input-number" data-min="1"
                                            data-max="1000" value="1">
                                        <div class="button plus">
                                            <button type="button" class="btn btn-primary btn-number" data-type="plus"
                                                data-field="quant[1]">
                                                <i class="ti-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!--/ End Input Order -->
                                </div>
                                <div class="add-to-cart">
                                    <button type="submit" class="btn">Masukkan ke keranjang</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@endif
<!-- Modal end -->
@endsection

@push('styles')
<style>
    /* Banner Sliding */
    #Gslider .carousel-inner {
        background: #000000;
        color: #354458;
    }

    #Gslider .carousel-inner {
        height: 550px;
    }

    #Gslider .carousel-inner img {
        width: 100% !important;
        opacity: .8;
    }

    #Gslider .carousel-inner .carousel-caption {
        bottom: 60%;
    }

    #Gslider .carousel-inner .carousel-caption h1 {
        font-size: 50px;
        font-weight: bold;
        line-height: 100%;
        color: #F7941D;
    }

    #Gslider .carousel-inner .carousel-caption p {
        font-size: 18px;
        color: #354458;
        margin: 28px 0 28px 0;
    }

    #Gslider .carousel-indicators {
        bottom: 70px;
    }

    .how-active1 {
        background-color: #354458;
        color: white;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
    /*==================================================================
        [ Isotope ]*/
        $(document).ready(function() {
    var $topeContainer = $('.isotope-grid');
    var $filter = $('.filter-tope-group');

    // Inisialisasi Isotope
    var $grid = $topeContainer.isotope({
        itemSelector: '.isotope-item',
        layoutMode: 'fitRows',
        percentPosition: true,
        animationEngine : 'best-available',
        masonry: {
            columnWidth: '.isotope-item'
        }
    });

    // Filter item saat tombol diklik
    $filter.on('click', 'button', function() {
        var filterValue = $(this).attr('data-filter');
        console.log("Filtering with value: ", filterValue);  // Debugging log
        $grid.isotope({ filter: filterValue });
    });

    var isotopeButton = $('.filter-tope-group button');

    $(isotopeButton).each(function() {
        $(this).on('click', function() {
            isotopeButton.removeClass('how-active1');
            $(this).addClass('how-active1');
            console.log("Button clicked: ", $(this).text());  // Debugging log
        });
    });
});
</script>
<script>
    function cancelFullScreen(el) {
            var requestMethod = el.cancelFullScreen||el.webkitCancelFullScreen||el.mozCancelFullScreen||el.exitFullscreen;
            if (requestMethod) { // cancel full screen.
                requestMethod.call(el);
            } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
                var wscript = new ActiveXObject("WScript.Shell");
                if (wscript !== null) {
                    wscript.SendKeys("{F11}");
                }
            }
        }

        function requestFullScreen(el) {
            // Supports most browsers and their versions.
            var requestMethod = el.requestFullScreen || el.webkitRequestFullScreen || el.mozRequestFullScreen || el.msRequestFullscreen;

            if (requestMethod) { // Native full screen.
                requestMethod.call(el);
            } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
                var wscript = new ActiveXObject("WScript.Shell");
                if (wscript !== null) {
                    wscript.SendKeys("{F11}");
                }
            }
            return false
        }
</script>

@endpush
