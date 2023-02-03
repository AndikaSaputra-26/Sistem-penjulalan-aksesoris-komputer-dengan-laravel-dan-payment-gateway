<td>
    @can('transaksi_detail')
        <a href="#" class="btn btn-success btn-xs mb-1" title="Detail" data-toggle="modal" data-target="#ajaxModel"
            data-id="{{ $model->id }}" data-invoice="{{ $model->invoice }}"
            data-modal-customer="{{ $model->customer->nama }}" data-modal-telpon="{{ $model->customer->telpon }}"
            data-modal-alamat="{{ $model->customer_alamat->alamat_lengkap }}"
            data-modal-tanggal-pembelian="{{ $model->tanggal_pembelian }}"
            data-modal-sub-total="{{ $model->sub_total }}" data-modal-ongkir="{{ $model->ongkir }}"
            data-modal-grand-total="{{ $model->grand_total }}" data-modal-jasa-kirim="{{ $model->jasa_kirim }}"
            data-modal-berat-total="{{ $model->berat_total }}" data-modal-status-bayar="{{ $model->status_bayar }}"
            data-modal-catatan="{{ $model->catatan }}" id="detailtransaksi">
            <i class="fas fa-eye"></i>
        </a>
    @endcan

    @can('update_invoice')
        <a class="btn btn-md btn-primary mb-1 updateData" title="Update Invoice"
            data-id_data="{{ $model->id }}"
            data-no_resi="{{ $model->no_resi }}">
            <i class="fas fa-edit"></i>
        </a>
    @endcan

    @can('transaksi_delete')
        <form action="{{ route('transaksi.destroy', $model->id) }}" method="post" class="d-inline"
            onsubmit="return confirm('Yakin ingin menghapus data ini?')">
            @csrf
            @method('delete')
            <button class="btn btn-danger btn-xs mb-1" title="Hapus">
                <i class="fas fa-trash-alt"></i>
            </button>
        </form>
    @endcan
</td>


<div class="modal fade" id="ajaxModelEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Nomor Resi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('transaksi.update', $model->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">No Resi</label>
                        <input class="form-control" type="hidden" name="update_id_transaksi" id="update_id_transaksi" value="">
                        <input class="form-control" type="text" placeholder="Masukan No. Resi" name="update_resi" id=update_resi required
                            value="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="" type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<script type="text/javascript">
    $(document).on('click', '#detailtransaksi', function() {
        var id = $(this).data('id');
        var invoice = $(this).data('invoice');
        var modal_customer = $(this).data('modal-customer');
        var modal_telpon = $(this).data('modal-telpon');
        var modal_alamat = $(this).data('modal-alamat');
        var modal_tanggal_pembelian = $(this).data('modal-tanggal-pembelian');
        var modal_sub_total = $(this).data('modal-sub-total');
        var modal_ongkir = $(this).data('modal-ongkir');
        var grand_total = $(this).data('modal-grand-total');
        var jasa_kirim = $(this).data('modal-jasa-kirim');
        var berat_total = $(this).data('modal-berat-total');
        var status_bayar = $(this).data('modal-status-bayar');
        var catatan = $(this).data('modal-catatan');
        $('#ajaxModel #invoice').text(invoice);
        $('#ajaxModel #modal-customer').text(modal_customer);
        $('#ajaxModel #modal-telpon').text(modal_telpon);
        $('#ajaxModel #modal-tanggal-pembelian').text(modal_tanggal_pembelian);
        $('#ajaxModel #modal-alamat').text(modal_alamat);
        $('#ajaxModel #modal-sub-total').text(modal_sub_total);
        $('#ajaxModel #modal-ongkir').text(modal_ongkir);
        $('#ajaxModel #modal-grand_total').text(grand_total);
        $('#ajaxModel #modal-jasa-kirim').text(jasa_kirim);
        $('#ajaxModel #modal-berat-total').text(berat_total);
        $('#ajaxModel #modal-status-bayar').text(status_bayar);
        $('#ajaxModel #modal-catatan').text(catatan);
        $('#ajaxModel #download').attr("href", "../invoice/"+id);

        $.ajax({
            url: '/getDetailItem/' + id,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            data: {},
            success: function(html) {
                // console.log(html)
                $("#result").html(html);
                $("#result_tunggu").html('');
            }
        });


    })


    $('.updateData').click(function() {
        var id = $(this).data('id_data');
        var no_resi = $(this).data('no_resi');
        $('#ajaxModelEdit').modal('show');
        $('#ajaxModelEdit #update_id_transaksi').val(id);
        $('#ajaxModelEdit #update_resi').val(no_resi);
    });
</script>

<div class="modal fade" id="ajaxModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog  modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail transaksi</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <a href="" id="download" class="btn btn-md btn-danger mb-3"><i class="fa fa-print" aria-hidden="true"></i> Print Invoice</a>
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Invoice</th>
                                        <td><span id="invoice"></span></td>
                                    </tr>
                                    <tr>
                                        <th>Customer</th>
                                        <td><span id="modal-customer"></span></td>
                                    </tr>`
                                    <tr>
                                        <th>No Telpon</th>
                                        <td><span id="modal-telpon"></span></td>
                                    </tr>
                                    <tr>
                                        <th>Alamat Pengiriman</th>
                                        <td><span id="modal-alamat"></span></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Pemesanan</th>
                                        <td><span id="modal-tanggal-pembelian"></span></td>
                                    </tr>
                                    <tr>
                                        <th>Subtotal</th>
                                        <td> <span id="modal-sub-total"></span></td>
                                    </tr>
                                    <tr>
                                        <th>Ongkir</th>
                                        <td><span id="modal-ongkir"></span></td>
                                    </tr>
                                    <tr>
                                        <th>Grand Total</th>
                                        <td><span id="modal-grand_total"></span></td>
                                    </tr>

                                    <tr>
                                        <th>Pengiriman</th>
                                        <td><span id="modal-jasa-kirim"></span></td>
                                    </tr>
                                    <tr>
                                        <th>Berat Total</th>
                                        <td><span id="modal-berat-total"></span> Gram</td>
                                    </tr>
                                    <tr>
                                        <th>Status Bayar</th>
                                        <td><span id="modal-status-bayar"></span></td>
                                    </tr>
                                    <tr>
                                        <th>Catatan</th>
                                        <td><span id="modal-catatan"></span></td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <span id="result"></span>
                            <div id="result_tunggu"></div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ajaxModel2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog  modal-xs" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cetak Laporan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <form method="POST" action="{{ route('laporan_transaksi') }}">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Customer</label>
                                <select name="customer" class="form-control">
                                    <option value="semua">-- Semua Customer --</option>
                                    @php
                                        $cus = DB::table('customer')
                                            ->select('*')
                                            ->get();
                                    @endphp
                                    @foreach ($cus as $rows)
                                        <option value="{{ $rows->id }}">{{ $rows->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Dari Tanggal</label>
                                <input type="date" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" name="dari" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Sampai Tanggal</label>
                                <input type="date" class="form-control" name="ke" required>
                            </div>
                            <button type="submit" class="btn btn-danger">Cetak</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                    </div>
                </div>

            </div>
            </form>
        </div>
    </div>
</div>
