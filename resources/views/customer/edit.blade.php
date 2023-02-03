@extends('layouts.master')
@section('title', 'Edit Customer')
@section('content')
    <div class="container-fluid">
        {{ Breadcrumbs::render('customer-edit', $customer) }}
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="form-group ">
                            <a href="{{ route('customer.index') }}" class="btn btn-warning" style="float: right"><i
                                    class="fa fa-arrow-left"></i> Back</a>
                        </div>
                        <div class="col-md-6">
                            <form method="POST" action="{{ route('customer.update', $customer->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="nama">Nama</label>
                                    <input class="form-control @error('nama') is-invalid @enderror" id="
                                        nama" type="text" value="{{ old('nama') ? old('nama') : $customer->nama }}"
                                        placeholder="Nama Customer" name="nama" autocomplete="off">
                                    @error('nama')
                                        <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tanggal_lahir">Tanggal Lahir</label>
                                    <input class="form-control @error('tanggal_lahir') is-invalid @enderror" id="
                                        tanggal_lahir" type="date"
                                        value="{{ old('tanggal_lahir') ? old('tanggal_lahir') : $customer->tanggal_lahir }}"
                                        placeholder="Tanggal Lahir" name="tanggal_lahir" autocomplete="off">
                                    @error('tanggal_lahir')
                                        <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <select class="form-control @error('jenis_kelamin') is-invalid @enderror"
                                        name="jenis_kelamin">
                                        <option value="">-- Pilih --</option>
                                        <option value="Laki Laki"
                                            {{ $customer->jenis_kelamin == 'Laki Laki' ? 'selected' : '' }}
                                            {{ old('jenis_kelamin') == 'Laki Laki' ? 'selected' : '' }}>Laki
                                            Laki</option>
                                        <option value="Perempuan"
                                            {{ $customer->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}
                                            {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                            Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="exampleFormControlInput1">Email</label>
                                    <input class="form-control @error('email') is-invalid @enderror" id="
                                                                exampleFormControlInput1" type="email"
                                        value="{{ old('email') ? old('email') : $customer->email }}" placeholder="Email"
                                        name="email" autocomplete="off">
                                    @error('email')
                                        <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="telpon">No Telpon</label>
                                    <input class="form-control @error('telpon') is-invalid @enderror" id="
                                        telpon" type="text"
                                        value="{{ old('telpon') ? old('telpon') : $customer->telpon }}"
                                        placeholder="No Telpon" name="telpon" autocomplete="off">
                                    @error('telpon')
                                        <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password">Password</label>
                                    <input class="form-control @error('password') is-invalid @enderror" id="
                                    password" type="password"
                                        value=""
                                        placeholder="Password" name="password" autocomplete="off">
                                        <p style="color: red">Kosongkan jika tidak ingin meru ah password</p>
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
