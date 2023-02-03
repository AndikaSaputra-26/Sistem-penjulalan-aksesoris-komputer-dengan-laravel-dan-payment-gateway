@extends('layouts.master')
@section('title', 'Tambah Unit')
@section('content')
    <div class="container-fluid">
        {{ Breadcrumbs::render('unit-tambah') }}
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="form-group ">
                            <a href="{{ route('unit.index') }}" class="btn btn-warning" style="float: right"><i
                                    class="fa fa-arrow-left"></i> Back</a>
                        </div>
                        <div class="col-md-6">
                            <form method="POST" action="{{ route('unit.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="nama_unit">Nama Unit</label>
                                    <input class="form-control @error('nama_unit') is-invalid @enderror" id="
                                    nama_unit" type="text" value="{{ old('nama_unit') }}" placeholder="Nama Unit" name="nama_unit" autocomplete="off">
                                    @error('nama_unit')
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
