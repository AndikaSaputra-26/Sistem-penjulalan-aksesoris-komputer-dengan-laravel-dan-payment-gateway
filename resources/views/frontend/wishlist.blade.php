@extends('layouts.master-frontend')
@section('title', 'Wishlist')
@section('content')
    <!-- ============================================== HEADER : END ============================================== -->
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="home.html">Home</a></li>
                    <li class='active'>Wishlist</li>
                </ul>
            </div><!-- /.breadcrumb-inner -->
        </div><!-- /.container -->
    </div><!-- /.breadcrumb -->

    <div class="body-content">
        <div class="container">
            <div class="my-wishlist-page">
                <div class="row">
                    <div class="col-md-12 my-wishlist">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="4" class="heading-title">My Wishlist</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($data as $row)
                                        <tr>
                                            @php
                                                $thumbnail = DB::table('produk_photo')
                                                    ->where('produk_id', $row->produk_id)
                                                    ->first();
                                            @endphp
                                            <td class="col-md-2"><a
                                                    href="{{ route('detail-produk', ['id' => $row->id, 'slug' => $row->slug]) }}"><img
                                                        src="{{ Storage::url('public/produk/' . $thumbnail->photo) }}"
                                                        alt="imga"></a></td>
                                            <td class="col-md-7">
                                                <div class="product-name"><a
                                                        href="{{ route('detail-produk', ['id' => $row->id, 'slug' => $row->slug]) }}">{{ $row->kode_produk }}
                                                        - {{ $row->nama }}</a></div>
                                                <div class="price">
                                                    @currency($row->harga)
                                                </div>
                                            </td>
                                            <td class="col-md-2">
                                                <form action="{{ route('cart.store') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf

                                                    <input type="hidden" value="1" name="quantity">

                                                    <input type="hidden" value="{{ $row->produk_id }}" name="id">
                                                    <input type="hidden" value="{{ $row->nama }}" name="nama">
                                                    <input type="hidden" value="{{ $row->harga }}" name="harga">
                                                    <input type="hidden" value="{{ $thumbnail->photo }}" name="photo">
                                                    <button class="btn btn-primary icon"><i class="fa fa-shopping-cart"></i> Add to cart
                                                    </button>

                                                </form>
                                            </td>
                                            <td class="col-md-1 close-btn">
                                                {{-- <a href="#" class=""><i class="fa fa-times"></i></a> --}}

                                                <form action="{{ route('wishlist.destroy', $row->id) }}" method="post" class="d-inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </form>


                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- /.row -->
            </div>
        </div><!-- /.container -->
    </div><!-- /.body-content -->

@endsection
