@extends('layouts.master')
@section('title', 'Edit Pesan')
@section('content')
    <div class="container-fluid">
        {{ Breadcrumbs::render('pesan-edit', $pesan) }}
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="form-group ">
                            <a href="{{ route('pesan.index') }}" class="btn btn-warning" style="float: right"><i
                                    class="fa fa-arrow-left"></i> Back</a>
                        </div>
                        <form method="POST" action="{{ route('pesan.update',$pesan->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <div class="mb-3">
                                        <label for="nama">Nama</label>
                                        <input class="form-control @error('nama') is-invalid @enderror" id="
                                        nama" type="text" value="{{ old('nama') ? old('nama') : $pesan->nama }}" placeholder="Nama pesan" name="nama" autocomplete="off">
                                        @error('nama')
                                            <span style="color: red;">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="judul">Judul</label>
                                        <input class="form-control @error('judul') is-invalid @enderror" id="
                                        judul" type="text" value="{{ old('judul') ? old('judul') : $pesan->judul }}" placeholder="Judul" name="judul" autocomplete="off">
                                        @error('judul')
                                            <span style="color: red;">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="telpon">No Telpon</label>
                                        <input class="form-control @error('telpon') is-invalid @enderror" id="
                                        telpon" type="text" value="{{ old('telpon') ? old('telpon') : $pesan->telpon }}" placeholder="No Telpon" name="telpon" autocomplete="off">
                                        @error('telpon')
                                            <span style="color: red;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="mb-1">
                                        <label for="exampleFormControlInput1">Deskripsi</label>
                                        <textarea rows="12" class="form-control @error('deskripsi') is-invalid @enderror" id="
                                                exampleFormControlInput1" type="text" placeholder="Deskripsi"
                                            name="deskripsi">{{ old('deskripsi') ? old('deskripsi') : $pesan->deskripsi }}</textarea>
                                        @error('deskripsi')
                                            <p style="color: red;">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="">
                                        <button type="submit" class="btn btn-sm btn-primary">SIMPAN</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
