@extends('layouts.master')
@section('title', 'Data Pesan')
@section('content')
    <div class="container-fluid">
        {{ Breadcrumbs::render('pesan_index') }}
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        {{-- @can('pesan_create')
                            <a href="{{ route('pesan.create') }}" class="btn btn-md btn-success mb-3">TAMBAH</a>
                        @endcan --}}

                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Judul/Sub</th>
                                        <th>Email</th>
                                        <th>Deskripsi</th>
                                        <th>Status</th>
                                        @canany(['pesan_update', 'pesan_delete'])
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
            '{{ auth()->user()->can('pesan_update') ||auth()->user()->can('pesan_delete')? 'yes yes yes': '' }}'
        let columns = [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'nama',
                name: 'nama'
            },
            {
                data: 'judul',
                name: 'judul'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'deskripsi',
                name: 'deskripsi'
            },
            {
                data: 'is_read',
                name: 'is_read',
                orderable: false
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
            ajax: "{{ route('pesan.index') }}",
            columns: columns
        });
    </script>
@endpush
