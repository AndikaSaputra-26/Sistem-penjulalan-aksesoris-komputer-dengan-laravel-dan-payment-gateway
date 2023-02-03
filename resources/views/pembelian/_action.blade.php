<td>
    @if ($model->status_bayar == 'Sudah Bayar')
        <a href="" class="btn btn-success btn-xs mb-1 disabled" title="Edit">
            <i class="fa fa-check" aria-hidden="true"></i>
        </a>
    @else
        @can('update_pembayaran')
            <form action="{{ route('update_status_bayar', $model->id) }}" method="post" class="d-inline"
                onsubmit="return confirm('Yakin sudah melakukan pembayaran?')">
                @csrf
                @method('PUT')
                <button class="btn btn-success btn-xs mb-1" title="Update Pembayaran">
                    <i class="fa fa-check" aria-hidden="true"></i>
                </button>
            </form>
        @endcan
    @endif

    @if ($model->status_bayar == 'Sudah Bayar')
        @can('pembelian_update')
            <a href="{{ route('pembelian.edit', $model->id) }}" class="btn btn-primary btn-xs mb-1 disabled" title="Edit">
                <i class="fas fa-edit"></i>
            </a>
        @endcan
    @else
        @can('pembelian_update')
            <a href="{{ route('pembelian.edit', $model->id) }}" class="btn btn-primary btn-xs mb-1" title="Edit">
                <i class="fas fa-edit"></i>
            </a>
        @endcan
    @endif

    @if ($model->status_bayar == 'Sudah Bayar')
        <a href="" class="btn btn-danger btn-xs mb-1 disabled" title="Edit">
            <i class="fas fa-trash-alt"></i>
        </a>
    @else
        @can('pembelian_delete')
            <form action="{{ route('pembelian.destroy', $model->id) }}" method="post" class="d-inline"
                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                @csrf
                @method('delete')
                <button class="btn btn-danger btn-xs mb-1" title="Hapus">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </form>
        @endcan
    @endif
</td>

<div class="modal fade" id="ajaxModel2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog  modal-xs" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cetak Laporan Pembelian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <form method="POST" action="{{ route('laporan_pembelian') }}">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Supplier</label>
                                <select name="supplier" class="form-control">
                                    <option value="semua">-- Semua Supplier --</option>
                                    @php
                                        $cus = DB::table('supplier')
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
