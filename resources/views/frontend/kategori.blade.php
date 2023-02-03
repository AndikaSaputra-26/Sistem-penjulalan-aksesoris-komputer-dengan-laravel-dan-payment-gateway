@extends('layouts.master-frontend')
@section('title', 'Kategori Produk')
@section('content')
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="#">Home</a></li>
                    <li class='active'>Sale</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="body-content outer-top-xs">
        <div class='container'>
            <div class='row'>
                {{-- sidebar --}}
                @include('frontend._include-sidebar')
                <div class='col-md-9'>
                    <div class="clearfix filters-container m-t-10">
                        <div class="row">
                            <div class="col col-sm-12 col-md-12">
                                <p>Menampilkan {{ $jumlah }} produk kategori <b>{{ $nama_kategori }}</b></p>
                                <hr>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="search-result-container ">
                        <div id="myTabContent" class="tab-content category-list">
                            <div class="tab-pane active " id="grid-container">
                                <div class="category-product">
                                    <div class="row">
                                        @foreach ($produk as $row)
                                            <div class="col-sm-6 col-md-4 wow fadeInUp">
                                                <div class="products">

                                                    <div class="product">
                                                        <div class="product-image">
                                                            <div class="image">
                                                                <a href="{{ route('detail-produk',['id' => $row->id,'slug' =>$row->slug ]) }}">
                                                                    @php
                                                                        $thumbnail = DB::table('produk_photo')->where('produk_id', $row->id)->first();
                                                                    @endphp
                                                                <img src="{{ Storage::url('public/produk/' . $thumbnail->photo) }}" alt=""></a>
                                                            </div>
                                                            <div class="tag new"><span>new</span></div>
                                                        </div>
                                                        <div class="product-info text-left">
                                                            <h3 class="name"><a
                                                                    href="{{ route('detail-produk',['id' => $row->id,'slug' =>$row->slug ]) }}">{{ $row->kode_produk }} - {{ $row->nama }}</a>
                                                            </h3>
                                                            <div class="description"></div>
                                                            <div class="product-price">
                                                                <span class="price"> @currency($row->harga)</span>
                                                            </div>
                                                        </div>
                                                        <div class="cart clearfix animate-effect">
                                                            <div class="action">
                                                                <ul class="list-unstyled">
                                                                    <li class="add-cart-button btn-group">
                                                                        <button class="btn btn-primary icon"
                                                                            data-toggle="dropdown" type="button">
                                                                            <i class="fa fa-shopping-cart"></i>
                                                                        </button>
                                                                        <button class="btn btn-primary cart-btn"
                                                                            type="button">Add to cart</button>
                                                                    </li>
                                                                    <li class="lnk wishlist">
                                                                        <a class="add-to-cart"
                                                                            href="{{ route('detail-produk',['id' => $row->id,'slug' =>$row->slug ]) }}"
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
                                        @endforeach


                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix filters-container">

                            <div class="text-right">
                                <div class="pagination-container">
                                    @if ($produk->hasPages())
                                        @if ($produk->lastPage() > 1)
                                            <ul class="list-inline list-unstyled">
                                                <li class="prev">
                                                    <a href="{{ $produk->url(1) }}"><i class="fa fa-angle-left"></i></a>
                                                </li>
                                                @for ($i = 1; $i <= $produk->lastPage(); $i++)
                                                    <li class="{{ ($produk->currentPage() == $i) ? ' active' : '' }}">
                                                        <a href="{{ $produk->url($i) }}">{{ $i }}</a>
                                                    </li>
                                                @endfor
                                                <li class="next">
                                                    <a href="{{ $produk->url($produk->currentPage()+1) }}">
                                                        <i class="fa fa-angle-right"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
