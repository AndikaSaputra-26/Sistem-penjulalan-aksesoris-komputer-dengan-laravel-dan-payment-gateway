@extends('layouts.master-frontend')
@section('title', 'Login')
@section('content')
    <!-- ============================================== HEADER : END ============================================== -->
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="home.html">Home</a></li>
                    <li class='active'>Login</li>
                </ul>
            </div><!-- /.breadcrumb-inner -->
        </div><!-- /.container -->
    </div><!-- /.breadcrumb -->

    <div class="body-content">
        <div class="container">
            <div class="sign-in-page">
                <div class="row">
                    <!-- Sign-in -->
                    <div class="col-md-6">
                        <center>
                            <img src="{{ asset('temp-front-end/assets/images/login.webp') }}" alt="" width="80%">
                        </center>
                    </div>
                    <div class="col-md-6 col-sm-6 sign-in">
                        <h4 class="checkout-subtitle">
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle" aria-hidden="true"></i> Login User
                            </div>
                        </h4>
                        <form class="register-form outer-top-xs" method="post" action="{{ route('auth-user') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="info-title" for="email">Email<span>*</span></label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="form-control unicase-form-control text-input" id="email">
                                @error('password')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="info-title" for="password">Password <span>*</span></label>
                                <input type="password" class="form-control unicase-form-control text-input" name="password"
                                    id="password">
                                @error('password')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>
                            <p style="float: right"><a href="" data-toggle="modal" data-target="#tesModal">Forgot Password
                                    ?</a></p>
                            <button type="submit" class="btn-upper btn btn-primary checkout-page-button">Login</button>
                        </form>
                    </div>

                    <!-- Sign-in -->
                </div><!-- /.sigin-in-->
            </div><!-- /.container -->
        </div><!-- /.body-content -->
    @endsection

    {{-- modal add --}}
    <div class="modal fade" id="tesModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal"><span>&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Reset Password</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('sendReset') }}">
                        @csrf
                        <div class="form-group">
                            <label for="">Masukan Email Terdaftar</label>
                            <input required type="email" name="email" value="{{ old('email') }}" class="form-control" id="alamat_lengkap"
                                placeholder="Masukan Email Terdaftar">
                        </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">SEND PASSWORD RESET LINK</button>
                </div>
            </form>
            </div>
        </div>
    </div>
