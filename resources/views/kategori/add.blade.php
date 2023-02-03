@extends('layouts.master')
@section('title', 'Tambah kategori')
@section('content')
    <div class="container-fluid">
        {{ Breadcrumbs::render('kategori-tambah') }}
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="form-group ">
                            <a href="{{ route('kategori.index') }}" class="btn btn-warning" style="float: right"><i
                                    class="fa fa-arrow-left"></i> Back</a>
                        </div>
                        <div class="col-md-6">
                            <form method="POST" action="{{ route('kategori.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="nama_kategori">Nama Kategori Produk</label>
                                    <input class="form-control @error('nama_kategori') is-invalid @enderror" id="
                                    nama_kategori" type="text" value="{{ old('nama_kategori') }}" placeholder="Nama Kategori Produk" name="nama_kategori" autocomplete="off">
                                    @error('nama_kategori')
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
