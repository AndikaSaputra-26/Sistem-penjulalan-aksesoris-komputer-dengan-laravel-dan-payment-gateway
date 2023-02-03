@extends('layouts.master')
@section('title', 'Tambah Customer')
@section('content')
    <div class="container-fluid">
        {{ Breadcrumbs::render('customer-tambah') }}
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="form-group ">
                            <a href="{{ route('customer.index') }}" class="btn btn-warning" style="float: right"><i
                                    class="fa fa-arrow-left"></i> Back</a>
                        </div>
                        <div class="col-md-6">
                            <form method="POST" action="{{ route('customer.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="nama">Nama</label>
                                    <input class="form-control @error('nama') is-invalid @enderror" id="
                                    nama" type="text" value="{{ old('nama') }}" placeholder="Nama Customer" name="nama" autocomplete="off">
                                    @error('nama')
                                        <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tanggal_lahir">Tanggal Lahir</label>
                                    <input class="form-control @error('tanggal_lahir') is-invalid @enderror" id="
                                    tanggal_lahir" type="date" value="{{ old('tanggal_lahir') }}" placeholder="Tanggal Lahir" name="tanggal_lahir" autocomplete="off">
                                    @error('tanggal_lahir')
                                        <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <select class="form-control @error('jenis_kelamin') is-invalid @enderror" name="jenis_kelamin">
                                        <option value="">-- Pilih --</option>
                                      <option value="Laki-laki">Laki-laki</option>
                                      <option value="Perempuan">Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>



                                <div class="mb-3">
                                    <label for="exampleFormControlInput1">Email</label>
                                    <input class="form-control @error('email') is-invalid @enderror" id="
                                                            exampleFormControlInput1" type="email"
                                        value="{{ old('email') }}" placeholder="Email" name="email" autocomplete="off">
                                    @error('email')
                                        <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>



                                <div class="mb-3">
                                    <label for="telpon">No Telpon</label>
                                    <input class="form-control @error('telpon') is-invalid @enderror" id="
                                    telpon" type="text" value="{{ old('telpon') }}" placeholder="No Telpon" name="telpon" autocomplete="off">
                                    @error('telpon')
                                        <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1">Password</label>
                                    <input class="form-control @error('password') is-invalid @enderror" id="
                                                            exampleFormControlInput1" type="password"
                                        value="{{ old('password') }}" placeholder="Password" name="password">
                                    @error('password')
                                        <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-sm btn-primary">SIMPAN</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
