@extends('layouts.master')
@section('title', 'Data pembelian')
@section('content')
    <div class="container-fluid">
        {{ Breadcrumbs::render('pembelian_index') }}
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        @can('pembelian_create')
                            <a href="{{ route('pembelian.create') }}" class="btn btn-md btn-success mb-3">TAMBAH</a>
                        @endcan
                        <a href="" class="btn btn-md btn-danger mb-3" data-toggle="modal" data-target="#ajaxModel2">Cetak Laporan</a>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kode Pembelian</th>
                                        <th>Supplier</th>
                                        <th>Tanggal</th>
                                        <th>Grand Total</th>
                                        <th>Diskon</th>
                                        <th>Total</th>
                                        <th>Status Bayar</th>
                                        @canany(['pembelian_update', 'pembelian_delete'])
                                            <th>Action</th>
                                        @endcanany
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        const action =
            '{{ auth()->user()->can('pembelian_update') ||auth()->user()->can('pembelian_delete')? 'yes yes yes': '' }}'
        let columns = [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'kode_pembelian',
                name: 'kode_pembelian'
            },
            {
                data: 'supplier',
                name: 'supplier'
            },
            {
                data: 'tanggal',
                name: 'tanggal'
            },
            {
                data: 'grand_total',
                name: 'grand_total',
                render: function(data, type, full, meta) {
                    return data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
            {
                data: 'diskon',
                name: 'diskon',
                render: function(data, type, full, meta) {
                    return data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
            {
                data: 'total',
                name: 'total',
                render: function(data, type, full, meta) {
                    return data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
            {
                data: 'status_bayar',
                name: 'status_bayar'
            }
        ]

        if (action) {
            columns.push({
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            })
        }

        $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('pembelian.index') }}",
            columns: columns
        });
    </script>
@endpush
