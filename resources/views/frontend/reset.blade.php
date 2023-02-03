@extends('layouts.master-frontend')
@section('title', 'Reset Password')
@section('content')
    <!-- ============================================== HEADER : END ============================================== -->
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="home.html">Home</a></li>
                    <li class='active'>Reset Password</li>
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
                                <i class="fa fa-info-circle" aria-hidden="true"></i> Reset Password
                            </div>
                        </h4>
                        <form class="register-form outer-top-xs" method="post"
                            action="{{ route('update-password-customer') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <input type="hidden" name="email" id="" value="{{ $email }}">
                                <input type="hidden" name="token" id="" value="{{ $token }}">
                                <label class="info-title" for="password">Password <span>*</span></label>
                                <input id="password" class="form-control" name="password" type="password"
                                    pattern="^\S{6,}$"
                                    onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Minimal 6 Karakter' : ''); if(this.checkValidity()) form.passcon.pattern = this.value;"
                                    placeholder="Password Baru" required>

                            </div>
                            <div class="form-group">
                                <label class="info-title" for="password">Confirmasi Password <span>*</span></label>

                                <input class="form-control" id="passcon" name="passcon" type="password" pattern="^\S{6,}$"
                                    onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Masukkan Password Yang Sama' : '');"
                                    placeholder="Confirmasi Password" required>

                            </div>
                            <button type="submit" class="btn-upper btn btn-primary checkout-page-button">Update
                                Password</button>
                        </form>
                    </div>

                    <!-- Sign-in -->
                </div><!-- /.sigin-in-->
            </div><!-- /.container -->
        </div><!-- /.body-content -->
    @endsection
