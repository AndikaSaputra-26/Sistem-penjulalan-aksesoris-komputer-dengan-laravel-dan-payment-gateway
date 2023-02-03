@extends('layouts.master')
@section('title', 'Edit Produk')
@section('content')
    @push('css')
        <style>
            .img-size {
                height: 450px;
                width: 500px;
                background-size: cover;
                overflow: hidden;
            }

            .modal-content {
                width: 500px;
                border: none;
            }

            .modal-body {
                padding: 2;
            }

            .carousel-control-prev-icon {
                background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23009be1' viewBox='0 0 8 8'%3E%3Cpath d='M5.25 0l-4 4 4 4 1.5-1.5-2.5-2.5 2.5-2.5-1.5-1.5z'/%3E%3C/svg%3E");
                width: 30px;
                height: 48px;
            }

            .carousel-control-next-icon {
                background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23009be1' viewBox='0 0 8 8'%3E%3Cpath d='M2.75 0l-1.5 1.5 2.5 2.5-2.5 2.5 1.5 1.5 4-4-4-4z'/%3E%3C/svg%3E");
                width: 30px;
                height: 48px;
            }

        </style>
    @endpush
    <div class="modal fade" id="largeModal" id="modal-dialog tabindex=" -1" role="dialog" aria-labelledby="basicModal"
        aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><span id="modal_nama_produk"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <center><img src="" id="photo_pro" width="100%" /></center>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



    <div class="container-fluid">
        {{ Breadcrumbs::render('produk-edit', $produk) }}
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="form-group ">
                            <a href="{{ route('produk.index') }}" class="btn btn-warning" style="float: right"><i
                                    class="fa fa-arrow-left"></i> Back</a>
                            <br>
                        </div>
                        <form method="POST" action="{{ route('produk.update', $produk->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <div class="mb-3">
                                        <label for="kode_produk">Kode produk</label>
                                        <input class="form-control @error('kode_produk') is-invalid @enderror" id="
                                                                                            kode_produk" type="text"
                                            value="{{ old('kode_produk') ? old('kode_produk') : $produk->kode_produk }}"
                                            placeholder="Kode Produk" name="kode_produk" autocomplete="off">
                                        @error('kode_produk')
                                            <span style="color: red;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="nama">Nama produk</label>
                                        <input class="form-control @error('nama') is-invalid @enderror" id="
                                                                                            nama" type="text"
                                            value="{{ old('nama') ? old('nama') : $produk->nama }}"
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
                                                    {{ old('kategori_id') && old('kategori_id') == $row->id ? 'selected' : '' }}
                                                    {{ $produk->kategori->id == $row->id ? 'selected' : '' }}>
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
                                                    {{ old('unit_id') && old('unit_id') == $row->id ? 'selected' : '' }}
                                                    {{ $produk->unit->id == $row->id ? 'selected' : '' }}>
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
                                        berat" type="number" value="{{ old('berat') ? old('berat') : $produk->berat }}"
                                            placeholder="Berat" name="berat" autocomplete="off">
                                        @error('berat')
                                            <span style="color: red;">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-1">
                                        <label for="harga">Harga Produk</label>
                                        <input class="form-control @error('harga') is-invalid @enderror" id="
                                                                                            harga" type="number"
                                            value="{{ old('harga') ? old('harga') : $produk->harga }}"
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
                                            name="deskripsi">{{ old('deskripsi') ? old('deskripsi') : $produk->deskripsi }}</textarea>
                                        @error('deskripsi')
                                            <p style="color: red;">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group col-md-6">


                                    <table class="table table-bordered table-sm" id="dynamic_field">
                                        <thead>
                                            <tr>
                                                <th>Photo Produk</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        {{-- asal --}}
                                        @foreach ($photo as $row)
                                            <tr id="detail_file{{ $row->id }}">
                                                <td>
                                                        <center><a href="#" class="btn btn-primary btn-xs mb-1" data-toggle="modal"
                                                            data-id="{{ $row->id }}" id="view_gambar"
                                                            data-photo="{{ $row->photo }}" data-target="#largeModal"
                                                            title="View Gambar"><i class="fas fa-eye"></i> Lihat Photo Produk</a></center>


                                                    <input type="hidden" name="id_asal[]" value="{{ $row->id }}" class="form-control  @error('id_asal') is-invalid @enderror" /></td>
                                                </td>

                                                <td>


                                                    <button type="button" id="{{ $row->id }}"
                                                        class="btn btn-danger btn_remove_data">X</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td><input type="file" name="photo[]"
                                                    class="form-control  @error('photo') is-invalid @enderror" required /></td>
                                            <td><button type="button" name="add_photo" id="add_photo"
                                                    class="btn btn-success"><i class="fa fa-plus"
                                                        aria-hidden="true"></i></button>
                                            </td>
                                        </tr>



                                    </table>

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
    <script type="text/javascript">
        $(document).on('click', '#view_gambar', function() {
            var photo = $(this).data('photo');
            $('#largeModal #photo_pro').attr("src", "../../../storage/produk/" + photo);
            console.log(photo);
        })

        $(document).on('click', '.btn_remove_data', function() {
            var bid = this.id;
            console.log(bid)
            var trid = $(this).closest('tr').attr('id');
            $('#' + trid + '').remove();
        });

        // $("#btn_remove_data").click(function() {
        //     console.log(this.id)
        // });
    </script>


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
