@extends('layouts.master')
@section('title', 'Tambah transaksi')
@section('content')
    <div class="container-fluid">
        {{-- {{ Breadcrumbs::render('transaksi-tambah') }} --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-body">

                        <form method="POST" action="{{ route('transaksi.store') }}">


                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="{{ route('transaksi.index') }}" class="btn btn-warning"
                                        style="float: right"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="kode_transaksi">Kode transaksi</label>
                                        <input class="form-control @error('kode_transaksi') is-invalid @enderror" id="
                                                                                        kode_transaksi" type="text"
                                            value="{{ old('kode_transaksi') }}" placeholder="Kode transaksi"
                                            name="kode_transaksi" autocomplete="off">
                                        @error('kode_transaksi')
                                            <span style="color: red;">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="tanggal">Tanggal transaksi</label>
                                        <input class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" type="date"
                                            value="{{ old('tanggal') }}" placeholder="Tanggal"
                                            name="tanggal" autocomplete="off">
                                        @error('tanggal')
                                            <span style="color: red;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="customer_id">Customer</label>
                                        <select name="customer_id" class="form-control  @error('role') is-invalid @enderror"
                                            id="customer">
                                            <option value="">-- Pilih --</option>
                                            @foreach ($customer as $row)
                                                <option value="{{ $row->id }}"
                                                    {{ old('customer_id') && old('customer_id') == $row->id ? 'selected' : '' }}>
                                                    {{ $row->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="produk">Produk</label>
                                        <select name="produk" class="form-control"
                                            id="produk">
                                            <option value="">-- Pilih --</option>
                                            @foreach ($produk as $row)
                                                <option value="{{ $row->id }}">
                                                    {{ $row->nama }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-3 offset-md-6">
                                    <div class="mb-3">
                                        <label for="kode_transaksi">Harga</label>
                                        <input class="form-control @error('kode_transaksi') is-invalid @enderror" id="
                                                                                        kode_transaksi" type="text"
                                            value="{{ old('kode_transaksi') }}" placeholder="Harga"
                                            name="kode_transaksi" autocomplete="off">
                                        @error('kode_transaksi')
                                            <span style="color: red;">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="kode_transaksi">QTY</label>
                                        <div class="input-group mb-3">

                                            <input class="form-control @error('kode_transaksi') is-invalid @enderror"
                                                id="kode_transaksi" type="number" value="{{ old('kode_transaksi') }}"
                                                placeholder="QTY" name="kode_transaksi" autocomplete="off">
                                            @error('kode_transaksi')
                                                <span style="color: red;">{{ $message }}</span>
                                            @enderror
                                            <div class="input-group-prepend">
                                                <button type="button" class="btn btn-primary" id="btn-add">
                                                    <i class="fas fa-cart-plus me-1"></i>
                                                    Add
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <table class="table table-striped table-hover table-bordered table-sm mt-3"
                                        id="tbl-cart">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Kode - Nama</th>
                                                <th>Unit</th>
                                                <th>Harga</th>
                                                <th>Qty</th>
                                                <th>Subtotal</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                    <div class="row mt-4">
                                        <div class="col-md-4">
                                            <div class="form-group mb-2">
                                                <label class="form-label" for="total">Total</label>
                                                <input class="form-control disabled" type="text" id="total" name="total"
                                                    placeholder="Total" value="" required="" disabled="">
                                            </div>

                                            <div class="form-group mb-2">
                                                <label class="form-label" for="diskon">Diskon</label>
                                                <input class="form-control" type="number" id="diskon" name="diskon"
                                                    placeholder="Diskon" min="1" value="">
                                            </div>

                                            <div class="form-group mb-2">
                                                <label class="form-label" for="grand-total">Grand Total</label>
                                                <input class="form-control disabled" type="text" id="grand-total"
                                                    name="grand_total" placeholder="Grand Total" value="" required=""
                                                    disabled="">

                                                <input type="hidden" id="grand-total-hidden" name="grand_total_hidden"
                                                    value="">
                                                <input type="hidden" id="total-hidden" name="total_hidden" value="">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <label class="form-label" for="catatan">Catatan</label>
                                                <textarea class="form-control" id="catatan" name="catatan" placeholder="Catatan" rows="8"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group mb-2">
                                                <label class="form-label" for="button">Button</label>
                                                <br>

                                                <button type="submit" class="btn btn-primary d-block w-100 mb-2"
                                                    id="btn-save" disabled="">
                                                    Simpan
                                                </button>

                                                <a href="https://mjs.intelship.web.id/purchase"
                                                    class="btn btn-secondary d-block w-100" id="btn-cancel"
                                                    disabled="">Cancel</a>
                                            </div>
                                        </div>
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
