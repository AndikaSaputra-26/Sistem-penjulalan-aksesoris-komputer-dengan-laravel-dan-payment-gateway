@extends('layouts.master')
@section('title', 'Tambah Produk')
@section('content')
    <div class="container-fluid">
        {{ Breadcrumbs::render('produk-tambah') }}
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="form-group ">
                            <a href="{{ route('produk.index') }}" class="btn btn-warning" style="float: right"><i
                                    class="fa fa-arrow-left"></i> Back</a>
                            <br>
                        </div>
                        <form method="POST" action="{{ route('produk.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <div class="mb-3">
                                        <label for="kode_produk">Kode produk</label>
                                        <input class="form-control @error('kode_produk') is-invalid @enderror" id="
                                                                kode_produk" type="text" value="{{ old('kode_produk') }}"
                                            placeholder="Kode Produk" name="kode_produk" autocomplete="off">
                                        @error('kode_produk')
                                            <span style="color: red;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="nama">Nama produk</label>
                                        <input class="form-control @error('nama') is-invalid @enderror" id="
                                                                nama" type="text" value="{{ old('nama') }}"
                                            placeholder="Nama Produk" name="nama" autocomplete="off">
                                        @error('nama')
                                            <span style="color: red;">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1">Kategori</label>
                                        <select name="kategori_id"
                                            class="form-control  @error('kategori_id') is-invalid @enderror"
                                            id="exampleFormControlSelect1">
                                            <option value="">-- Pilih --</option>
                                            @foreach ($kategori_id as $row)
                                                <option value="{{ $row->id }}"
                                                    {{ old('kategori_id') && old('kategori_id') == $row->id ? 'selected' : '' }}>
                                                    {{ $row->nama_kategori }}</option>
                                            @endforeach
                                        </select>
                                        @error('kategori_id')
                                            <span style="color: red;">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1">Unit</label>
                                        <select name="unit_id"
                                            class="form-control  @error('unit_id') is-invalid @enderror"
                                            id="exampleFormControlSelect1">
                                            <option value="">-- Pilih --</option>
                                            @foreach ($unit_id as $row)
                                                <option value="{{ $row->id }}"
                                                    {{ old('unit_id') && old('unit_id') == $row->id ? 'selected' : '' }}>
                                                    {{ $row->nama_unit }}</option>
                                            @endforeach
                                        </select>
                                        @error('unit_id')
                                            <span style="color: red;">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="berat">Berat (Satuan Gram)</label>
                                        <input class="form-control @error('berat') is-invalid @enderror" id="
                                        berat" type="number" value="{{ old('berat') }}"
                                            placeholder="Berat" name="berat" autocomplete="off">
                                        @error('berat')
                                            <span style="color: red;">{{ $message }}</span>
                                        @enderror
                                    </div>


                                    <div class="mb-1">
                                        <label for="harga">Harga Produk</label>
                                        <input class="form-control @error('harga') is-invalid @enderror" id="
                                                                harga" type="number" value="{{ old('harga') }}"
                                            placeholder="Harga Produk" name="harga" autocomplete="off">
                                        @error('harga')
                                            <span style="color: red;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="mb-1">
                                        <label for="exampleFormControlInput1">Deskripsi</label>
                                        <textarea rows="12" class="form-control @error('deskripsi') is-invalid @enderror" id="
                                                exampleFormControlInput1" type="text" placeholder="Deskripsi"
                                            name="deskripsi">{{ old('deskripsi') }}</textarea>
                                        @error('deskripsi')
                                            <p style="color: red;">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <table class="table table-bordered table-sm" id="dynamic_field">
                                        <thead>
                                            <tr>
                                                <th>Photo Produk </th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tr>
                                            <td><input type="file" name="photo[]"
                                                    class="form-control  @error('photo') is-invalid @enderror" /></td>
                                            <td><button type="button" name="add_photo" id="add_photo"
                                                    class="btn btn-success"><i class="fa fa-plus"
                                                        aria-hidden="true"></i></button></td>
                                        </tr>
                                    </table>
                                    @error('photo')
                                        <p style="color: red;">{{ $message }}</p>
                                    @enderror

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

@push('js')
    <script>
        $(document).ready(function() {
            var i = 1;
            $('#add_photo').click(function() {
                i++;
                $('#dynamic_field').append('<tr id="row' + i +
                    '"><td><input type="file" name="photo[]" class="form-control" required="" /></td><td><button type="button" name="remove" id="' +
                    i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
            });

            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
            });

        });
    </script>
@endpush
