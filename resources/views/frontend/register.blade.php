@extends('layouts.master-frontend')
@section('title', 'Sign In')
@section('content')
    <!-- ============================================== HEADER : END ============================================== -->
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="home.html">Home</a></li>
                    <li class='active'>Register</li>
                </ul>
            </div><!-- /.breadcrumb-inner -->
        </div><!-- /.container -->
    </div><!-- /.breadcrumb -->

    <div class="body-content">
        <div class="container">
            <div class="sign-in-page">
                <div class="row">
                    <div class="col-md-6">
                        <center>
                            <img src="{{ asset('temp-front-end/assets/images/register.webp') }}" alt="" width="100%">
                        </center>

                    </div>
                    <div class="col-md-6 col-sm-6 create-new-account">
                        <h4 class="checkout-subtitle">
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle" aria-hidden="true"></i> Create a new account
                            </div>
                        </h4>

                        <form class="register-form outer-top-xs" role="form" method="POST"
                            action="{{ route('register-user') }}">
                            @csrf
                            <div class="form-group">
                                <label class="info-title" for="email">Email<span>*</span></label>
                                <input style="box-shadow: 0 0 5pt 2pt #D3D3D3;
                                    outline-width: 0px;" type="email" name="email" autocomplete="off"
                                    value="{{ old('email') }}" class="form-control unicase-form-control text-input "
                                    id="email">
                                @error('email')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="info-title" for="nama">Nama Lengkap <span>*</span></label>
                                <input style="box-shadow: 0 0 5pt 2pt #D3D3D3;
                                    outline-width: 0px;" type="text" name="nama" autocomplete="off"
                                    value="{{ old('nama') }}" class="form-control unicase-form-control text-input"
                                    id="nama">
                                @error('nama')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="info-title" for="telpon">Telpon <span>*</span></label>
                                <input style="box-shadow: 0 0 5pt 2pt #D3D3D3;
                                    outline-width: 0px;" type="text" name="telpon" autocomplete="off"
                                    value="{{ old('telpon') }}" class="form-control unicase-form-control text-input"
                                    id="telpon">
                                @error('telpon')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="info-title" for="password">Password <span>*</span></label>
                                <input style="box-shadow: 0 0 5pt 2pt #D3D3D3;
                                    outline-width: 0px;" type="password" name="password" autocomplete="off"
                                    class="form-control unicase-form-control text-input" id="password">
                                @error('password')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group row">
                                <label for="captcha" class="col-md-4 col-form-label text-md-right">Captcha</label>
                                <div class="col-md-6 captcha">
                                    <span>{!! captcha_img() !!}</span>
                                    <button type="button" class="btn btn-danger" class="reload" id="reload">
                                    &#x21bb;
                                    </button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="captcha" class="col-md-4 col-form-label text-md-right">Enter Captcha</label>
                                <div class="col-md-6">
                                    <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha" name="captcha">
                                </div>
                                @error('captcha')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn-upper btn btn-primary checkout-page-button">Sign Up</button>
                        </form>


                    </div>
                    <!-- create a new account -->
                </div><!-- /.row -->
            </div><!-- /.sigin-in-->
        </div><!-- /.container -->
    </div><!-- /.body-content -->
@endsection

@push('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
    $('#reload').click(function () {
        $.ajax({
            type: 'GET',
            url: '{{ route('reloadCaptcha') }}',
            success: function (data) {
                // console.log(data)
                $(".captcha span").html(data.captcha);
            }
        });
    });
</script>
@endpush
