@extends('layouts.master-frontend')
@section('title', 'Detail Produk')
@section('content')
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Produk</a></li>
                    <li class='active'>Detail Produk - {{ $data->nama }}</li>
                </ul>
            </div><!-- /.breadcrumb-inner -->
        </div>
    </div><!-- /.breadcrumb -->
    <div class="body-content outer-top-xs">
        <div class='container'>
            <div class='row single-product'>
                <div class='col-md-12'>
                    <div class="detail-block">
                        <div class="row  wow fadeInUp">

                            <div class="col-xs-12 col-sm-6 col-md-5 gallery-holder">
                                <div class="product-item-holder size-big single-product-gallery small-gallery">

                                    <div id="owl-single-product">

                                        @php
                                            $photo = DB::table('produk_photo')
                                                ->where('produk_id', '=', $data->id)
                                                ->get();
                                        @endphp

                                        @foreach ($photo as $rows)
                                            <div class="single-product-gallery-item" id="slide{{ $rows->id }}">
                                                <a data-lightbox="image-1" data-title="Gallery"
                                                    href="{{ Storage::url('public/produk/' . $rows->photo) }}">
                                                    <img class="" alt="" width="400" height="450"
                                                        src="{{ asset('temp-front-end/assets/images/blank.gif') }} "
                                                        data-echo="{{ Storage::url('public/produk/' . $rows->photo) }}" />
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>



                                    <div class="single-product-gallery-thumbs gallery-thumbs">
                                        <div id="owl-single-product-thumbnails">
                                            @foreach ($photo as $rows)
                                                <div class="item">
                                                    <a class="horizontal-thumb @if ($loop->iteration == 1) active @endif"
                                                        data-target="#owl-single-product"
                                                        data-slide="{{ $loop->iteration - 1 }}"
                                                        href="#slide{{ $rows->id }}">
                                                        <img style="display: block" width="85" height="100" alt=""
                                                            src="{{ asset('temp-front-end/assets/images/blank.gif') }} "
                                                            data-echo="{{ Storage::url('public/produk/' . $rows->photo) }}" />
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div><!-- /#owl-single-product-thumbnails -->



                                    </div><!-- /.gallery-thumbs -->

                                </div><!-- /.single-product-gallery -->
                            </div><!-- /.gallery-holder -->
                            <div class='col-sm-6 col-md-7 product-info-block'>
                                <div class="product-info">
                                    <h1 class="name">{{ $data->kode_produk }} - {{ $data->nama }}</h1>
                                    <div class="stock-container info-container m-t-10">
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="stock-box">
                                                    <span class="label">Availability :</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="stock-box">
                                                    @if ($data->qty > 0)
                                                        <span class="value">In Stock</span>
                                                    @else
                                                    <span class="value">Out of Stock</span>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="stock-container info-container m-t-10">
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="stock-box">
                                                    <span class="label">Kategori :</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="stock-box">
                                                    <span
                                                        class="value">{{ $data->kategori->nama_kategori }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="stock-container info-container m-t-10">
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="stock-box">
                                                    <span class="label">Stok :</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="stock-box">
                                                    <span class="value">{{ $data->qty }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="stock-container info-container m-t-10">
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="stock-box">
                                                    <span class="label">Unit :</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="stock-box">
                                                    <span class="value">{{ $data->unit->nama_unit }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="description-container m-t-20" style="text-align: justify">
                                        {{ $data->deskripsi }}
                                    </div>

                                    <div class="price-container info-container m-t-20">
                                        <div class="row">


                                            <div class="col-sm-6">
                                                <div class="price-box">
                                                    <span class="price">@currency($data->harga)</span>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="favorite-button m-t-10">
                                                    <a class="btn btn-primary" data-toggle="tooltip" data-placement="right"
                                                        title="Wishlist" href="{{ route('wishlist-store', $data->id) }}">
                                                        <i class="fa fa-heart"></i>
                                                    </a>

                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="quantity-container info-container">
                                        <div class="row">

                                            <div class="col-sm-2">
                                                <span class="label">Qty :</span>
                                            </div>
                                            <form action="{{ route('cart.store') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="col-sm-2">
                                                    <div class="cart-quantity">
                                                        <div class="quant-input">
                                                            <div class="arrows">
                                                                <div class="arrow plus gradient"><span
                                                                        class="ir"><i
                                                                            class="icon fa fa-sort-asc"></i></span></div>
                                                                <div class="arrow minus gradient"><span
                                                                        class="ir"><i
                                                                            class="icon fa fa-sort-desc"></i></span></div>
                                                            </div>
                                                            <input type="text" value="1" name="quantity">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-7">
                                                    <input type="hidden" value="{{ $data->id }}" name="id">
                                                    <input type="hidden" value="{{ $data->nama }}" name="nama">
                                                    <input type="hidden" value="{{ $data->harga }}" name="harga">
                                                    @php
                                                        $thumbnail = DB::table('produk_photo')
                                                            ->where('produk_id', $data->id)
                                                            ->first();
                                                    @endphp

                                                    <input type="hidden" value="{{ $thumbnail->photo }}" name="photo">
                                                    <button class="btn btn-primary"><i
                                                            class="fa fa-shopping-cart inner-right-vs"></i> ADD TO
                                                        CART </button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <section class="section featured-product wow fadeInUp">
                        <h3 class="section-title">Produk Terkait</h3>
                        <div class="owl-carousel home-owl-carousel upsell-product custom-carousel owl-theme outer-top-xs">
                            @foreach ($relate as $row)
                                <form action="{{ route('cart.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="item item-carousel">
                                        <div class="products">
                                            <div class="product">
                                                <div class="product-image">
                                                    <div class="image">
                                                        <a
                                                            href="{{ route('detail-produk', ['id' => $row->id, 'slug' => $row->slug]) }}">
                                                            @php
                                                                $thumbnail = DB::table('produk_photo')
                                                                    ->where('produk_id', $row->id)
                                                                    ->first();
                                                            @endphp
                                                            <img style="height: 250px"
                                                                src="{{ Storage::url('public/produk/' . $thumbnail->photo) }}"
                                                                alt=""></a>
                                                    </div>

                                                    <div class="tag new"><span>new</span></div>
                                                </div>
                                                <div class="product-info text-left">
                                                    <h3 class="name"><a
                                                            href="{{ route('detail-produk', ['id' => $row->id, 'slug' => $row->slug]) }}">{{ $row->kode_produk }}
                                                            - {{ $row->nama }}</a>
                                                    </h3>
                                                    <div class="description"></div>

                                                    <div class="product-price">
                                                        <span class="price">
                                                            @currency($row->harga)</span>
                                                    </div>

                                                </div>
                                                <div class="cart clearfix animate-effect">
                                                    <div class="action">
                                                        <ul class="list-unstyled">
                                                            <li class="add-cart-button btn-group">
                                                                <input type="hidden" value="1" name="quantity">

                                                                <input type="hidden" value="{{ $row->id }}" name="id">
                                                                <input type="hidden" value="{{ $row->nama }}"
                                                                    name="nama">
                                                                <input type="hidden" value="{{ $row->harga }}"
                                                                    name="harga">
                                                                <input type="hidden" value="{{ $thumbnail->photo }}"
                                                                    name="photo">
                                                                <button class="btn btn-primary icon"><i
                                                                        class="fa fa-shopping-cart"></i>
                                                                </button>

                                                            </li>
                                                            <li class="lnk wishlist">
                                                                <a class="add-to-cart"
                                                                    href="{{ route('wishlist-store', $row->id) }}"
                                                                    title="Wishlist">
                                                                    <i class="icon fa fa-heart"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            @endforeach
                        </div>
                    </section>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
@endsection
