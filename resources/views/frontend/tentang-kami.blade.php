@extends('layouts.master-frontend')
@section('title', 'Tentang Kami')
@section('content')
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="/">Home</a></li>
                    <li class='active'>Tentang Kami</li>
                </ul>
            </div><!-- /.breadcrumb-inner -->
        </div><!-- /.container -->
    </div>

    <div class="body-content">
        <div class="container">
            <div class="contact-page">
                <div class="terms-conditions-page">
                    <div class="row">
                        <div class="col-md-6 terms-conditions">
                            <h2 class="heading-title">Tentang Kami</h2>
                            <div class="">
                                <h2>{{ $setting_toko->nama_toko }}</h2>
                                <p style="text-align: justify">{{ $setting_toko->deskripsi }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <center>
                                <img src="{{ asset('temp-front-end/assets/images/about.webp') }}" alt="" width="80%">
                            </center>
                        </div>
                    </div>
                </div>
            </div><!-- /.row -->
            <!-- ============================================== BRANDS CAROUSEL ============================================== -->
            <div id="brands-carousel" class="logo-slider wow fadeInUp">



            </div>
        </div>
    @endsection
