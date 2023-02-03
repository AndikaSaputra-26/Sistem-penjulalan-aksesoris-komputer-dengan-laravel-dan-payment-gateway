@extends('layouts.master')
@section('title', 'Roles')
@section('content')
    <div class="container-fluid">
        {{ Breadcrumbs::render('roles') }}
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-body">

                        @can('role_create')
                            <a href="{{ route('roles.create') }}" class="btn btn-md btn-success mb-3">TAMBAH</a>
                        @endcan
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Roles</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
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

        const action = '{{ auth()->user()->can('role_update') || auth()->user()->can('role_delete') ? 'yes yes yes' : '' }}'
        let columns = [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'name',
                name: 'name'
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
            ajax: "{{ route('roles.index') }}",
            columns: columns
        });
    </script>
@endpush

