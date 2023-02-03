@extends('layouts.master')
@section('title', 'Tambah Supplier')
@section('content')
    <div class="container-fluid">
        {{ Breadcrumbs::render('supplier-tambah') }}
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="form-group ">
                            <a href="{{ route('supplier.index') }}" class="btn btn-warning" style="float: right"><i
                                    class="fa fa-arrow-left"></i> Back</a>
                        </div>
                        <div class="col-md-6">
                            <form method="POST" action="{{ route('supplier.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="kode_supplier">Kode Supplier</label>
                                    <input class="form-control @error('kode_supplier') is-invalid @enderror" id="
                                    kode_supplier" type="text" value="{{ old('kode_supplier') }}" placeholder="Kode Supplier" name="kode_supplier" autocomplete="off">
                                    @error('kode_supplier')
                                        <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="nama">Nama Supplier</label>
                                    <input class="form-control @error('nama') is-invalid @enderror" id="
                                    nama" type="text" value="{{ old('nama') }}" placeholder="Nama Supplier" name="nama" autocomplete="off">
                                    @error('nama')
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
                                    <label for="alamat">Alamat</label>
                                    <input class="form-control @error('alamat') is-invalid @enderror" id="
                                    alamat" type="text" value="{{ old('alamat') }}" placeholder="Alamat" name="alamat" autocomplete="off">
                                    @error('alamat')
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
