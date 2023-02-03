@extends('layouts.master')
@section('title', 'Data produk')

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
@section('content')
    <div class="container-fluid">
        {{ Breadcrumbs::render('produk_index') }}
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="container">
                            <!-- modal -->
                            <div class="modal fade" id="largeModal" id="modal-dialog tabindex=" -1" role="dialog"
                                aria-labelledby="basicModal" aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"><span id="modal_nama_produk"></span></h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div id='carouselExampleIndicators' class='carousel slide' data-ride='carousel'>
                                                <span id="result"></span>
                                                <a class='carousel-control-prev' href='#carouselExampleIndicators'
                                                    role='button' data-slide='prev'>
                                                    <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                                                    <span class='sr-only'>Previous</span>
                                                </a>
                                                <a class='carousel-control-next' href='#carouselExampleIndicators'
                                                    role='button' data-slide='next'>
                                                    <span class='carousel-control-next-icon' aria-hidden='true'></span>
                                                    <span class='sr-only'>Next</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @can('produk_create')
                                <a href="{{ route('produk.create') }}" class="btn btn-md btn-success mb-3">TAMBAH</a>
                            @endcan

                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Kode Produk</th>
                                            <th>Nama produk</th>
                                            <th>Kategori Produk</th>
                                            <th>Unit</th>
                                            <th>Berat</th>
                                            <th>Harga</th>
                                            <th>QTY</th>
                                            @canany(['produk_update', 'produk_delete'])
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
        <script type="text/javascript">
            $(document).on('click', '#view_gambar', function() {
                var id = $(this).data('id');
                var nama = $(this).data('nama');
                $('#largeModal #modal_nama_produk').text(nama);
                console.log(id)

                $.ajax({
                    url: '/panel/GetGambarProduk/' + id,
                    type: 'GET',

                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    data: {

                    },
                    success: function(html) {
                        $("#result").html(html);
                    }

                });


            })
        </script>

        <script>
            const action =
                '{{ auth()->user()->can('produk_update') ||auth()->user()->can('produk_delete')? 'yes yes yes': '' }}'
            let columns = [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'kode_produk',
                    name: 'kode_produk'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'kategori',
                    name: 'kategori'
                },
                {
                    data: 'unit',
                    name: 'unit'
                },
                {
                    data: 'berat',
                    name: 'berat'
                },
                {
                    data: 'harga',
                    name: 'harga',
                    render: function(data, type, full, meta) {
                    return data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
                },
                {
                    data: 'qty',
                    name: 'qty'
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
                ajax: "{{ route('produk.index') }}",
                columns: columns
            });
        </script>
    @endpush
