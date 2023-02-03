@extends('layouts.master')
@section('title', 'Edit pembelian')
@section('content')
    <div class="container-fluid">
        {{-- {{ Breadcrumbs::render('pembelian-tambah') }} --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-body">

                        <form action="{{ route('pembelian.store') }}" method="POST" id="form-purchase">
                            @csrf
                            @method('POST')
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="{{ route('pembelian.index') }}" class="btn btn-warning"
                                        style="float: right"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="kode">Kode Pembelian</label>
                                        <input class="form-control" id="kode" type="text"
                                            value="{{ $purchase ? $purchase->kode_pembelian : '' }}"
                                            placeholder="Kode Pembelian" name="kode" autocomplete="off" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label for="tanggal">Tanggal Pembelian</label>
                                        <input class="form-control" id="tanggal" type="date"
                                            value="{{ $purchase ? $purchase->tanggal : date('Y-m-d') }}"
                                            placeholder="Tanggal" name="tanggal" autocomplete="off">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="supplier_id">Supplier</label>
                                        <select name="supplier_id" class="form-control  @error('role') is-invalid @enderror"
                                            id="supplier">
                                            <option value="">-- Pilih --</option>
                                            @foreach ($supplier as $row)
                                                <option value="{{ $row->id }}"
                                                    {{ $purchase && $purchase->supplier_id == $row->id ? 'selected' : '' }}>
                                                    {{ $row->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <input type="hidden" name="stok" id="stok">
                                    <input type="hidden" name="kode_produk" id="kode-produk">
                                    <input type="hidden" name="unit_produk" id="unit-produk">
                                    <input type="hidden" name="index_tr" id="index-tr">

                                    <div class="mb-3">
                                        <label for="produk">Produk</label>
                                        <select name="produk" id="produk" class="form-control" id="produk">
                                            <option value="" disabled selected>-- Pilih --</option>
                                            @foreach ($produk as $row)
                                                <option value="{{ $row->id }}">
                                                    {{ $row->nama }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-3 offset-md-6">
                                    <div class="mb-3">
                                        <label for="harga">Harga</label>
                                        <input class="form-control" id="harga" type="number" value="" placeholder="Harga"
                                            name="kode_pembelian" autocomplete="off">
                                    </div>

                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="kode_pembelian">QTY</label>
                                        <div class="input-group mb-3">

                                            <input class="form-control" id="qty" type="number" value="" placeholder="QTY"
                                                name="qty" autocomplete="off">
                                            <div class="input-group-prepend">
                                                <button type="button" class="btn btn-info" id="btn-update"
                                                    style="display: none;">
                                                    <i class="fas fa-save me-1"></i>
                                                    Update
                                                </button>
                                                <button type="button" id="btn-add" class="btn btn-primary" id="btn-add">
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
                                                <th>Nama Produk</th>
                                                <th>Unit</th>
                                                <th>Harga</th>
                                                <th>Qty</th>
                                                <th>Subtotal</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($detail_purchase as $detail)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        {{ $detail->nama_produk }}
                                                        <input type="hidden" class="produk-hidden" name="produk[]"
                                                            value="{{ $detail->produk_id }}">
                                                    </td>
                                                    <td>{{ $detail->nama_unit }}</td>
                                                    <td>
                                                        {{ number_format($detail->harga) }}
                                                        <input type="hidden" class="harga-hidden" name="harga[]"
                                                            value="{{ $detail->harga }}">
                                                        <input type="hidden" class="unit-hidden" name="unit[]"
                                                            value="{{ $detail->nama_unit }}">
                                                    </td>
                                                    <td>
                                                        {{ $detail->qty }}
                                                        <input type="hidden" class="qty-hidden" name="qty[]"
                                                            value="{{ $detail->qty }}">
                                                        <input type="hidden" class="stok-hidden" name="stok[]"
                                                            value="{{ $detail->stok }}">
                                                    </td>
                                                    <td>
                                                        {{ number_format($detail->sub_total) }}
                                                        <input type="hidden" class="subtotal-hidden" name="subtotal[]"
                                                            value="{{ $detail->sub_total }}">
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-warning btn-xs me-1 btn-edit" type="button">
                                                            <i class="fas fa-edit"></i>
                                                        </button>

                                                        <button class="btn btn-danger btn-xs btn-delete" type="button">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                    <div class="row mt-4">
                                        <div class="col-md-4">
                                            <div class="form-group mb-2">
                                                <label class="form-label" for="total">Total</label>
                                                <input class="form-control disabled" type="text" id="total" name="total"
                                                    placeholder="Total"
                                                    value="{{ $purchase ? number_format($purchase->total) : '' }}"
                                                    required="" disabled="">
                                            </div>

                                            <div class="form-group mb-2">
                                                <label class="form-label" for="diskon">Diskon</label>
                                                <input class="form-control" type="number" id="diskon" name="diskon"
                                                    placeholder="Diskon"
                                                    value="{{ $purchase ? number_format($purchase->diskon) : '' }}">
                                            </div>

                                            <div class="form-group mb-2">
                                                <label class="form-label" for="grand-total">Grand Total</label>
                                                <input class="form-control disabled" type="text" id="grand-total"
                                                    name="grand_total" placeholder="Grand Total"
                                                    value="{{ $purchase ? number_format($purchase->grand_total) : '' }}"
                                                    required="" disabled="">

                                                <input type="hidden" id="grand-total-hidden" name="grand_total_hidden"
                                                    value="{{ $purchase ? $purchase->grand_total : '' }}">
                                                <input type="hidden" id="total-hidden" name="total_hidden"
                                                    value="{{ $purchase ? $purchase->total : '' }}">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <label class="form-label" for="catatan">Catatan</label>
                                                <textarea class="form-control" id="catatan" name="catatan" placeholder="Catatan"
                                                    rows="8">{{ $purchase ? $purchase->catatan : '' }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group mb-2">
                                                <label class="form-label" for="button">Button</label>
                                                <br>

                                                <button type="submit" class="btn btn-success d-block w-100 mb-2"
                                                    id="btn-save" >
                                                    Update
                                                </button>

                                                <a href="{{ route('pembelian.index') }}"
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


@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script>
        const btnAdd = $('#btn-add')
        const harga = $('#harga')
        const produk = $('#produk')
        const qty = $('#qty')
        const tblCart = $('#tbl-cart')
        const unitProduk = $('#unit-produk')
        const stok = $('#stok')
        const kodeProduk = $('#kode-produk')
        const grandTotal = $('#grand-total')
        const btnUpdate = $('#btn-update')
        const diskon = $('#diskon')
        const btnSave = $('#btn-save')
        const btnCancel = $('#btn-cancel')

        const tanggal = $('#tanggal')
        const supplier = $('#supplier')
        const kode = $('#kode')
        const catatan = $('#catatan')

        produk.change(function() {
            harga.prop('type', 'text')
            harga.prop('disabled', true)
            harga.val('Loading...')

            qty.prop('type', 'text')
            qty.prop('disabled', true)
            qty.val('Loading...')

            $.ajax({
                url: '/panel/produk/get-item-by-id/' + $(this).val(),
                method: 'GET',
                success: function(res) {
                    console.log(res)
                    stok.val(res.data[0].qty)
                    kodeProduk.val(res.data[0].kode_produk)
                    unitProduk.val(res.data[0].nama_unit)
                    setTimeout(() => {
                        harga.prop('type', 'number')
                        harga.prop('disabled', false)
                        harga.val(res.data[0].harga)
                        qty.prop('type', 'number')
                        qty.prop('disabled', false)
                        qty.val('')
                        qty.focus()
                    }, 500)

                }
            })
        })

        btnAdd.click(function() {
            if (!produk.val()) {
                produk.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Produk tidak boleh kosong'
                })

            } else if (!harga.val() || harga.val() < 1) {
                harga.focus()
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Harga tidak boleh kosong dan minimal 1'
                })

            } else if (!qty.val() || qty.val() < 1) {
                qty.focus()
                qty.val('')

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Qty tidak boleh kosong dan minimal 1'
                })

            } else {
                // cek duplikasi produk
                $('input[name="produk[]"]').each(function() {
                    let index = $(this).parent().parent().index()
                    if ($(this).val() == produk.val()) {
                        tblCart.find('tbody tr:eq(' + index + ')').remove()
                        generateNo()
                    }
                })
                let subtotal = harga.val() * qty.val()
                tblCart.find('tbody').append(`
            <tr>
                <td>${tblCart.find('tbody tr').length + 1}</td>
                <td>
                    ${produk.find('option:selected').text()}
                    <input type="hidden" class="produk-hidden" name="produk[]" value="${produk.val()}">
                </td>
                <td>${unitProduk.val()}</td>
                <td>
                    ${formatRibuan(harga.val())}
                    <input type="hidden" class="harga-hidden" name="harga[]" value="${harga.val()}">
                    <input type="hidden" class="unit-hidden" name="unit[]" value="${unitProduk.val()}">
                </td>
                <td>
                    ${qty.val()}
                    <input type="hidden" class="qty-hidden" name="qty[]" value="${qty.val()}">
                    <input type="hidden" class="stok-hidden" name="stok[]" value="${stok.val()}">
                </td>
                <td>
                    ${formatRibuan(subtotal)}
                    <input type="hidden" class="subtotal-hidden" name="subtotal[]" value="${subtotal}">
                </td>
                <td>
                    <button class="btn btn-warning btn-xs me-1 btn-edit" type="button">
                        <i class="fas fa-edit"></i>
                    </button>

                    <button class="btn btn-danger btn-xs btn-delete" type="button">
                        <i class="fas fa-times"></i>
                    </button>
                </td>
            </tr>
        `)
                generateNo()
                hitungTotal()
                hitungDiskon()
                clearForm()
                cekTableLength()
                produk.focus()
            }
        })
        btnUpdate.click(function() {
            let index = $('#index-tr').val()

            if (!produk.val()) {
                produk.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Produk tidak boleh kosong'
                })

            } else if (!harga.val() || harga.val() < 1) {
                harga.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Harga tidak boleh kosong dan minimal 1'
                })

            } else if (!qty.val() || qty.val() < 1) {
                qty.focus()
                qty.val('')

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Qty tidak boleh kosong dan minimal 1'
                })

            } else {
                // cek duplikasi pas update
                $('input[name="produk[]"]').each(function(i) {
                    // i = index each
                    if ($(this).val() == produk.val() && i != index) {
                        tblCart.find('tbody tr:eq(' + i + ')').remove()
                    }
                })

                let subtotal = harga.val() * qty.val()

                $('#tbl-cart tbody tr:eq(' + index + ')').html(`
                    <td></td>
                    <td>
                        ${produk.find('option:selected').text()}
                        <input type="hidden" class="produk-hidden" name="produk[]" value="${produk.val()}">
                    </td>
                    <td>${unitProduk.val()}</td>
                    <td>
                        ${formatRibuan(harga.val())}
                        <input type="hidden" class="harga-hidden" name="harga[]" value="${harga.val()}">
                        <input type="hidden" class="unit-hidden" name="unit[]" value="${unitProduk.val()}">
                    </td>
                    <td>
                        ${qty.val()}
                        <input type="hidden" class="qty-hidden" name="qty[]" value="${qty.val()}">
                        <input type="hidden" class="stok-hidden" name="stok[]" value="${stok.val()}">
                    </td>
                    <td>
                        ${formatRibuan(subtotal)}
                        <input type="hidden" class="subtotal-hidden" name="subtotal[]" value="${subtotal}">
                    </td>
                    <td>
                        <button class="btn btn-warning btn-xs me-1 btn-edit" type="button">
                            <i class="fas fa-edit"></i>
                        </button>

                        <button class="btn btn-danger btn-xs btn-delete" type="button">
                            <i class="fas fa-times"></i>
                        </button>
                    </td>
                `)

                clearForm()
                hitungTotal()
                hitungDiskon()
                generateNo()
                btnUpdate.hide()
                btnAdd.show()
            }
        })

        $(document).on('click', '.btn-edit', function(e) {
            e.preventDefault()
            let index = $(this).parent().parent().index()

            btnAdd.hide()

            btnUpdate.show()

            produk.val($('.produk-hidden:eq(' + index + ')').val())
            harga.val($('.harga-hidden:eq(' + index + ')').val())
            qty.val($('.qty-hidden:eq(' + index + ')').val())
            stok.val($('.stok-hidden:eq(' + index + ')').val())
            unitProduk.val($('.unit-hidden:eq(' + index + ')').val())

            $('#index-tr').val(index)
        })
        $(document).on('click', '.btn-delete', function(e) {
            $(this).parent().parent().remove()

            generateNo()
            hitungTotal()
            hitungDiskon()
            cekTableLength()
        })

        $('#form-purchase').submit(function(e) {
            e.preventDefault()
            let pembelian = {
                tanggal: tanggal.val(),
                supplier: supplier.val(),
                kode: kode.val(),
                diskon: diskon.val(),
                catatan: catatan.val(),
                total: $('#total-hidden').val(),
                grand_total: $('#grand-total-hidden').val(),
                produk: $('input[name="produk[]"]').map(function() {
                    return $(this).val()
                }).get(),
                harga: $('input[name="harga[]"]').map(function() {
                    return $(this).val()
                }).get(),
                qty: $('input[name="qty[]"]').map(function() {
                    return $(this).val()
                }).get(),
                subtotal: $('input[name="subtotal[]"]').map(function() {
                    return $(this).val()
                }).get(),
            }

            if (!kode.val()) {
                kode.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Kode pembelian tidak boleh kosong'
                })

            } else if (!tanggal.val()) {
                tanggal.focus()
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Tanggal tidak boleh kosong'
                })
            } else if (!supplier.val()) {
                supplier.focus()
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Supplier tidak boleh kosong'
                })
            } else {
                $.ajax({
                    type: 'PUT',
                    url: '{{ route('pembelian.update', $purchase->pembelian_id) }}',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    data: pembelian,
                    success: function(res) {
                        console.log(res)
                        Swal.fire({
                            icon: 'success',
                            title: 'Update data',
                            text: 'Berhasil'
                        }).then(function() {
                            window.location = '{{ route('pembelian.index') }}'
                        })
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!'
                        })
                    }
                })

            }


        })


        diskon.on('change keyup', function() {
            hitungDiskon()
        })

        function generateNo() {
            let no = 1
            tblCart.find('tbody tr').each(function() {
                $(this).find('td:nth-child(1)').html(no)
                no++
            })
        }

        function hitungTotal() {
            let xTotal = 0

            $('input[name="subtotal[]"]').map(function() {
                xTotal += parseInt($(this).val())
            }).get()

            $('#total').val(formatRibuan(xTotal))
            $('#grand-total').val(formatRibuan(xTotal))

            $('#grand-total-hidden').val(xTotal)
            $('#total-hidden').val(xTotal)
        }

        function formatRibuan(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        }

        function hitungDiskon() {
            xTotal = parseInt($('#total-hidden').val())
            xDiskon = (xTotal - parseInt($('#diskon').val()))

            if (Number.isNaN(xDiskon)) {
                grandTotal.val(formatRibuan(xTotal))

                $('#grand-total-hidden').val(xTotal)
            } else {
                grandTotal.val(formatRibuan(xDiskon))

                $('#grand-total-hidden').val(xDiskon)
            }
        }

        function clearForm() {
            kodeProduk.val('')
            produk.val('')
            unitProduk.val('')
            harga.val('')
            qty.val('')
        }

        function cekTableLength() {
            let cek = tblCart.find('tbody tr').length

            if (cek > 0) {
                btnSave.prop('disabled', false)
                btnCancel.prop('disabled', false)
            } else {
                btnSave.prop('disabled', true)
                btnCancel.prop('disabled', true)
            }
        }
    </script>
@endpush
