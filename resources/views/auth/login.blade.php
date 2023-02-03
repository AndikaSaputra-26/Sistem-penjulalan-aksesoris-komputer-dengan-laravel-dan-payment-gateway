@extends('layouts.auth')
@section('title', 'Login')
@section('content')
    <form class="user" method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <input type="email" name="email"
                class="form-control form-control-user @error('email') is-invalid @enderror" id=" email"
                aria-describedby="emailHelp" placeholder="Email" value="">
            @error('email')
                <center><span style="color: red;">{{ $message }}</span></center>
            @enderror
        </div>
        <div class="form-group">
            <input type="password" name="password"
                class="form-control form-control-user @error('password') is-invalid @enderror"" id=" password"
                placeholder="Password" autocomplete="current-password">

            @error('password')
                <center><span style="color: red;">{{ $message }}</span></center>
            @enderror

        </div>
        <button type="submit" class="btn btn-primary btn-user btn-block">
            Login
        </button>
    </form>
@endsection
