@extends('layouts.master')
@section('title', 'Data supplier')
@section('content')
    <div class="container-fluid">
        {{ Breadcrumbs::render('supplier_index') }}
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        @can('supplier_create')
                            <a href="{{ route('supplier.create') }}" class="btn btn-md btn-success mb-3">TAMBAH</a>
                        @endcan

                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Telpon</th>
                                        <th>Alamat</th>
                                        @canany(['supplier_update', 'supplier_delete'])
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
            '{{ auth()->user()->can('supplier_update') ||auth()->user()->can('supplier_delete')? 'yes yes yes': '' }}'
        let columns = [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'kode_supplier',
                name: 'kode_supplier'
            },
            {
                data: 'nama',
                name: 'nama'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'telpon',
                name: 'telpon'
            },
            {
                data: 'alamat',
                name: 'alamat'
            },
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
            ajax: "{{ route('supplier.index') }}",
            columns: columns
        });
    </script>
@endpush
