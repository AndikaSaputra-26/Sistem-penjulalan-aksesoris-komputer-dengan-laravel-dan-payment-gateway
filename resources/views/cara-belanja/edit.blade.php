@extends('layouts.master')
@section('title', 'Edit Cara Belanja')
@section('content')
    <div class="container-fluid">
        {{ Breadcrumbs::render('belanja-edit', $caraBelanja) }}
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="form-group ">
                            <a href="{{ route('cara-belanja.index') }}" class="btn btn-warning" style="float: right"><i
                                    class="fa fa-arrow-left"></i> Back</a>
                        </div>
                        <div class="col-md-6">
                            <form method="POST" action="{{ route('cara-belanja.update',$caraBelanja->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="title">Title</label>
                                    <input class="form-control @error('title') is-invalid @enderror" id="
                                    title" type="text" value="{{ old('title') ? old('title') : $caraBelanja->title }}" placeholder="title" name="title" autocomplete="off">
                                    @error('title')
                                        <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea rows="12" class="form-control @error('deskripsi') is-invalid @enderror" id="
                                            deskripsi" type="text" placeholder="deskripsi"
                                        name="deskripsi">{{ old('deskripsi') ? old('deskripsi') : $caraBelanja->deskripsi }}</textarea>
                                    @error('deskripsi')
                                        <span style="color: red;">{{ $message }}</span>
                                    @enderror
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
