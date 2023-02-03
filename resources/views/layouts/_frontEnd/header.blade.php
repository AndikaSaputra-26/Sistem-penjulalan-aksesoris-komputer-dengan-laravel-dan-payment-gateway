<header class="header-style-1">
    <div class="top-bar animate-dropdown">
        <div class="container">
            <div class="header-top-inner">

                <div class="cnt-account">
                    <ul class="list-unstyled">
                        @if (Session::get('login-customer'))
                            <li><a href="{{ route('signout-user') }}"><i class="fa fa-sign-out" aria-hidden="true"></i>
                                    Logout</a></li>
                        @else
                            <li><a href="{{ route('auth-web') }}"><i class="fa fa-sign-in" aria-hidden="true"></i>
                                    Login</a></li>
                            <li><a href="{{ route('signin-web') }}"><i class="fa fa-wpforms" aria-hidden="true"></i>
                                    Register</a></li>
                        @endif

                    </ul>
                </div>

                @if (Session::get('login-customer'))
                    <div class="cnt-block">
                        <ul class="list-unstyled list-inline">
                            <li class="dropdown dropdown-small">
                                <a href="#" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown"><span
                                        class="value">{{ Session::get('name-customer') }} </span><b
                                        class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ route('setting-akun') }}">Akun Profile</a></li>
                                    <li><a href="{{ route('pembelian') }}">Pembelian</a></li>
                                    <li><a href="{{ route('wishlist.index') }}">Wishlist</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                @endif

            </div>
        </div>
    </div>
    <div class="main-header">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 logo-holder">
                    <div class="logo">
                        <a href="{{ route('dashboard') }}">
                            <img src="{{ asset('temp-front-end/assets/images/logo.png') }}" alt=""
                                style="width: 90%;">
                        </a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-7 top-search-holder">
                    <div class="search-area">
                        <form action="{{ route('pencarian-produk') }}" method="GET">
                            <div class="control-group">
                                <input required class="search-field typeahead" name="search" id="search"
                                    autocomplete="off" placeholder="Cari Produk" <?php if (isset($_GET['search'])) { ?>
                                    value="<?= $_GET['search'] ?>" <?php } ?> />
                                <button type="submit" class="search-button">
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                @if (Session::get('login-customer'))
                    <div class="col-xs-12 col-sm-12 col-md-2 animate-dropdown top-cart-row">
                        <div class="dropdown dropdown-cart">
                            <a href="#" class="dropdown-toggle lnk-cart" data-toggle="dropdown">
                                <div class="items-cart-inner">
                                    <div class="basket">
                                        <i class="glyphicon glyphicon-shopping-cart"></i>
                                    </div>
                                    @php
                                        $cartItems = \Cart::getContent();
                                    @endphp
                                    <div class="basket-item-count"><span
                                            class="count">{{ Cart::getTotalQuantity() }}</span></div>
                                    <div class="total-price-basket">
                                        <span class="total-price">
                                            <span class="value"> @currency(Cart::getTotal())</span>
                                        </span>
                                    </div>


                                </div>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <div class="cart-item product-summary">

                                        {{-- mulai --}}
                                        @foreach ($cartItems as $item)
                                            <div class="row">
                                                <div class="col-xs-4">
                                                    <div class="image">
                                                        @php
                                                            $thumbnail = DB::table('produk_photo')
                                                                ->where('produk_id', $item->id)
                                                                ->first();
                                                            $slug = DB::table('produk')
                                                                ->where('id', $item->id)
                                                                ->first();
                                                        @endphp
                                                        <a
                                                            href="{{ route('detail-produk', ['id' => $item->id, 'slug' => $slug->slug]) }}"><img
                                                                src="{{ Storage::url('public/produk/' . $thumbnail->photo) }}"
                                                                alt=""></a>
                                                    </div>
                                                </div>
                                                <div class="col-xs-7">

                                                    <h3 class="name"><a
                                                            href="{{ route('detail-produk', ['id' => $item->id, 'slug' => $slug->slug]) }}">{{ $item->name }}
                                                            -
                                                            {{ $item->quantity }}</a></h3>
                                                    <div class="price">@currency($item->price)</div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="clearfix"></div>
                                    <hr>
                                    <div class="clearfix cart-total">
                                        <div class="pull-right">
                                            <span class="text">Sub Total :</span><span
                                                class='price'>@currency(Cart::getTotal())</span>
                                        </div>
                                        <div class="clearfix"></div>
                                        <a href="{{ route('cart.list') }}"
                                            class="btn btn-upper btn-primary btn-block m-t-20">Checkout</a>
                                        <form action="{{ route('cart.clear') }}" method="POST">
                                            @csrf
                                            <button class="btn btn-upper btn-danger btn-block m-t-10">Hapus Semua
                                                Cart</button>
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endif


            </div>

        </div>
        <div class="header-nav animate-dropdown">
            <div class="container">
                <div class="yamm navbar navbar-default" role="navigation">
                    <div class="navbar-header">
                        <button data-target="#mc-horizontal-menu-collapse" data-toggle="collapse"
                            class="navbar-toggle collapsed" type="button">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="nav-bg-class">
                        <div class="navbar-collapse collapse" id="mc-horizontal-menu-collapse">
                            <div class="nav-outer">
                                <ul class="nav navbar-nav">
                                    <li class="dropdown hidden-sm">
                                        <a href="{{ route('dashboard') }}"><span
                                                class="menu-label hot-menu hidden-xs">hot</span>SALE</a>
                                    </li>

                                    <li class="dropdown">
                                        <a href="{{ route('tentang-kami') }}">TENTANG KAMI</a>
                                    </li>

                                    <li class="dropdown">
                                        <a href="{{ route('cara-belanja') }}">CARA BELANJA</a>
                                    </li>
                                    <li class="dropdown">
                                        <a href="{{ route('kontak') }}">KONTAK</a>
                                    </li>



                                </ul><!-- /.navbar-nav -->
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</header>
