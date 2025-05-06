<header class="header shop">
    <!-- Topbar -->

    <div class="topbar">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Flex container -->
                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <div class="top-left">
                            <ul class="list-main">
                                @php
                                $settings=DB::table('settings')->get();

                                @endphp
                                @foreach($settings as $data)
                                    <li><i class="ti-headphone-alt"></i> {{ $data->phone }}</li>
                                    <li><i class="ti-email"></i> {{ $data->email }}</li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="right-content">
                            <ul class="list-main">
                                <li><i class="ti-archive"></i> <a href="{{ route('user.order.index') }}">Daftar Pesanan</a></li>
                                <li><i class="ti-location-pin"></i> <a href="{{ route('order.track') }}">Lacak Pesanan</a></li>
                                @auth
                                    @if(Auth::user()->role == 'admin')
                                        <li><i class="ti-user"></i> <a href="{{ route('admin') }}" target="_blank">Dashboard</a></li>
                                    @endif
                                    <li class="profile-dropdown">
                                        <button class="profile-btn">
                                            <i class="ti-user"></i> {{ Auth::user()->name }}
                                        </button>
                                        <div class="profile-dropdown-content">
                                            <a href="{{ route('user.logout') }}">
                                                <i class="ti-power-off"></i> Logout
                                            </a>
                                        </div>
                                    </li>
                                @else
                                    <li>
                                        <i class="ti-power-off"></i>
                                        <a href="{{ route('login.form') }}">Login</a> /
                                        <a href="{{ route('register.form') }}">Register</a>
                                    </li>
                                @endauth
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Topbar -->
    <div class="middle-inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-12">
                    <!-- Logo -->
                    <div class="logo">
                        @php
                        $settings=DB::table('settings')->get();
                        @endphp
                        <a href="{{route('home')}}"><img src="@foreach($settings as $data) {{$data->logo}} @endforeach"
                                alt="logo"></a>
                    </div>
                    <!--/ End Logo -->
                    <!-- Search Form -->
                    <div class="search-top">
                        <div class="top-search"><a href="#0"><i class="ti-search"></i></a></div>
                        <!-- Search Form -->
                        <div class="search-top">
                            <form class="search-form">
                                <input type="text" placeholder="Search here..." name="search">
                                <button value="search" type="submit"><i class="ti-search"></i></button>
                            </form>
                        </div>
                        <!--/ End Search Form -->
                    </div>
                    <!--/ End Search Form -->
                    <div class="mobile-nav"></div>
                </div>
                <div class="col-lg-8 col-md-7 col-12">
                    <div class="search-bar-top">
                        <div class="search-bar d-flex flex-wrap justify-content-center">
                            <select>
                                <option>Semua Kategori</option>
                                @foreach(Helper::getAllCategory() as $cat)
                                <option>{{$cat->title}}</option>
                                @endforeach
                            </select>
                            <form method="POST" action="{{route('product.search')}}">
                                @csrf
                                <input name="search" placeholder="Cari Produk Disini....." type="search">
                                <button class="btnn" type="submit"><i class="ti-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-12">
                    <div class="right-bar">
                        <!-- Search Form -->
                        <div class="sinlge-bar shopping">
                            @php
                            $total_prod=0;
                            $total_amount=0;
                            @endphp
                            <!-- Shopping Item -->
                            @auth
                            <div class="shopping-item">
                                <div class="bottom">
                                    <a href="{{route('cart')}}" class="btn animate">Keranjang</a>
                                </div>
                            </div>
                            @endauth
                            <!--/ End Shopping Item -->
                        </div>

                        <div class="single-bar shopping">
                            <a href="{{route('cart')}}" class="single-icon"><i class="ti-bag"></i> <span
                                    class="total-count">{{Helper::cartCount()}}</span></a>
                            <!-- Shopping Item -->
                            @auth
                            <div class="shopping-item">
                                <div class="dropdown-cart-header">
                                    <span>{{count(Helper::getAllProductFromCart())}} Barang</span>
                                    <a href="{{route('cart')}}">Lihat Keranjang</a>
                                </div>
                                <ul class="shopping-list">
                                    {{-- {{Helper::getAllProductFromCart()}} --}}
                                    @foreach(Helper::getAllProductFromCart() as $data)
                                    @php
                                    $photo=explode(',',$data->product['photo']);
                                    @endphp
                                    <li>
                                        <a href="{{route('cart-delete',$data->id)}}" class="remove"
                                            title="Remove this item"><i class="fa fa-remove"></i></a>
                                        <a class="cart-img" href="#"><img src="{{$photo[0]}}" alt="{{$photo[0]}}"></a>
                                        <h4><a href="{{route('product-detail',$data->product['slug'])}}"
                                                target="_blank">{{$data->product['title']}}</a></h4>
                                        <p class="quantity">{{$data->quantity}} x - <span class="amount">Rp.
                                                {{number_format($data->price,2)}}</span></p>
                                    </li>
                                    @endforeach
                                </ul>
                                <div class="bottom">
                                    <div class="total">
                                        <span>Total</span>
                                        <span class="total-amount">Rp.
                                            {{number_format(Helper::totalCartPrice(),2)}}</span>
                                    </div>
                                    <a href="{{route('checkout')}}" class="btn animate desktop-checkout">Checkout</a>
                                </div>
                            </div>
                            @endauth
                            <!--/ End Shopping Item -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header Inner -->
    <div class="header-inner">
        <div class="container">
            <div class="cat-nav-head">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <div class="menu-area">
                            <!-- Main Menu -->
                            <nav class="navbar navbar-expand-lg">
                                <div class="navbar-collapse">
                                    <div class="nav-inner">
                                        <ul class="nav main-menu menu navbar-nav">
                                            <li class="{{Request::path()=='home' ? 'active' : ''}}"><a
                                                    href="{{route('home')}}">Beranda</a></li>
                                            @auth
                                                <li class="mobile-only">
                                                    <a href="{{ route('checkout') }}"><i class="ti-credit-card"></i> Checkout</a>
                                                </li>
                                            @endauth
                                            <li class="{{Request::path()=='about-us' ? 'active' : ''}}"><a
                                                    href="{{route('about-us')}}">Tentang</a></li>
                                            <li
                                                class="@if(Request::path()=='product-grids'||Request::path()=='product-lists')  active  @endif">
                                                <a href="{{route('product-grids')}}">Produk</a><span
                                                    class="new">Baru</span>
                                            </li>
                                            {{Helper::getHeaderCategory()}}
                                            <li class="{{Request::path()=='contact' ? 'active' : ''}}"><a
                                                    href="{{route('contact')}}">Hubungi Kami</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                            <!--/ End Main Menu -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ End Header Inner -->
</header>
