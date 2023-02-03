@extends('layouts.master')
@section('title', 'Alamat Customer')
@section('content')
    <div class="container-fluid">
        {{ Breadcrumbs::render('customer_index') }}
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="form-group ">

                        <a href="{{ route('customer.index') }}" class="btn btn-warning" style="float: right;margin:10px"><i
                                class="fa fa-arrow-left"></i> Back</a>
                    </div>
                    <div class="card-body">

                        <div class="row">

                            @foreach ($alamat as $row)
                                <div class="col-md-6">
                                    <div class="bg-white card addresses-item mb-4 shadow-sm">
                                        <div class="gold-members p-4">
                                            <div class="media">
                                                <div class="mr-3"><i class="icofont-briefcase icofont-3x"></i>
                                                </div>
                                                <div class="media-body" style="min-height: 150px; text-align:justify">
                                                    <h6 class="mb-1"> <b>{{ $row->nama_provinsi }} -
                                                            {{ $row->nama_kota }}</b> </h6>
                                                    <p style="text-align: justify">{{ $row->alamat_lengkap }}
                                                    </p>
                                                    @can('address_update')
                                                        <a class="btn btn-md btn-outline-primary mb-1 updateData"
                                                            data-id_data="{{ $row->id }}"
                                                            data-customer_id="{{ $row->customer_id }}"
                                                            data-alamat_lengkap="{{ $row->alamat_lengkap }}"
                                                            data-provinsi_id="{{ $row->provinsi_id }}"
                                                            data-kota_id="{{ $row->kota_id }}"><i class="fas fa-edit"></i>
                                                            EDIT</a>
                                                    @endcan
                                                    @can('address_delete')
                                                        <form action="{{ route('alamat.destroy', $row->id) }}" method="post"
                                                            class="d-inline"
                                                            onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                            @csrf
                                                            @method('delete')
                                                            <button class="btn btn-md btn-outline-danger mb-1">
                                                                <i class="fas fa-trash-alt"></i> DELETE
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @can('address_create')
                                <div class="col-md-6">
                                    <a href="javascript:void(0)" class="btn btn-md btn-outline-success mb-1"
                                        id="createNewCustomer" style="float: left;margin:10px"> <i class="fa fa-plus"></i>
                                        TAMBAH ALAMAT</a>
                                </div>
                            @endcan


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal add --}}
    <div class="modal fade" id="ajaxModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Alamat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <div class="form-group">
                            <label class="font-weight-bold">Provinsi</label>
                            <input type="hidden" id="customer_id" name="customer_id" value="{{ $customer_id }}">
                            <select class="form-control provinsi-asal" id="provinsi-asal" name="province_origin">
                                <option value="">-- Pilih --</option>
                                @foreach ($provinsi as $item => $value)
                                    <option value="{{ $item }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Kota / Kabupaten</label>
                            <select name="kota_id" id="kota_id" class="form-control  @error('kota_id') is-invalid @enderror"
                                id="exampleFormControlSelect1">
                                <option value="">-- Pilih --</option>
                            </select>
                            <span id="result"></span>
                            <div id="result_tunggu"></div>
                        </div>
                        <div class="form-group">
                            <label for="">Alamat</label>
                            <textarea class="form-control" id="alamat_lengkap" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="simpan_data" type="button" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    {{-- modal edit --}}
    <div class="modal fade" id="ajaxModelEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Alamat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <div class="form-group">
                            <label class="font-weight-bold">Provinsi</label>
                            <input type="hidden" id="id_data" name="id_data" value="">
                            <input type="hidden" id="customer_id_edit" name="customer_id" value="{{ $customer_id }}">
                            <select class="form-control provinsi-asal" id="provinsi-asal-edit" name="province_origin">
                                <option value="">-- Pilih --</option>
                                @foreach ($provinsi as $item => $value)
                                    <option value="{{ $item }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Kota / Kabupaten</label>

                            <span id="result_edit"></span>
                            <div id="result_tunggu_edit"></div>
                        </div>
                        <div class="form-group">
                            <label for="">Alamat</label>
                            <textarea class="form-control" id="alamat_lengkap_edit" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="update_data" type="button" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
        <script type="text/javascript">
            $(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'firstName',
                            name: 'firstName'
                        },
                        {
                            data: 'lastName',
                            name: 'lastName'
                        },
                        {
                            data: 'info',
                            name: 'info'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });

            });
        </script>
        <script type="text/javascript">
            $('#createNewCustomer').click(function() {
                $('#ajaxModel').modal('show');
            });
            $('.updateData').click(function() {
                $('#ajaxModelEdit').modal('show');
                var id_data = $(this).data('id_data');
                var alamat_lengkap = $(this).data('alamat_lengkap');
                var customer_id = $(this).data('customer_id');
                var provinsi_id = $(this).data('provinsi_id');
                var kota_id = $(this).data('kota_id');
                $('#id_data').val(id_data);
                $('#alamat_lengkap_edit').val(alamat_lengkap);
                $("#customer_id").val(customer_id);
                $("#provinsi-asal-edit").val(provinsi_id);
                $("#provinsi-asal").val('');
                $.ajax({
                    url: '/panel/cities/' + provinsi_id,
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    data: {},
                    beforeSend: function() {
                        $("#result_edit").html("");
                        $('#kota_id_edit').remove();
                        $("#result_tunggu_edit").html(
                            '<p style="color:green"><blink>Tunggu sebentar</blink></p>');
                    },

                    success: function(html) {
                        $('#kota_id').remove();
                        $("#result_edit").html(html);
                        $("#result_tunggu_edit").html('');
                        $("#kota_id").val(kota_id);
                    }
                });



            });

            $("#provinsi-asal").change(function() {
                var selectedValue = $(this).val();
                $.ajax({
                    url: '/panel/cities/' + selectedValue,
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    data: {},
                    beforeSend: function() {
                        $("#result").html("");
                        $('#kota_id').remove();
                        $("#result_tunggu").html(
                            '<p style="color:green"><blink>Tunggu sebentar</blink></p>');
                    },

                    success: function(html) {
                        $('#kota_id').remove();
                        $("#result").html(html);
                        $("#result_tunggu").html('');
                    }
                });
            })
            $("#provinsi-asal-edit").change(function() {
                var selectedValue = $(this).val();
                $.ajax({
                    url: '/panel/cities/' + selectedValue,
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    data: {},
                    beforeSend: function() {
                        $("#result_edit").html("");
                        $('#kota_id_edit').remove();
                        $("#result_tunggu_edit").html(
                            '<p style="color:green"><blink>Tunggu sebentar</blink></p>');
                    },

                    success: function(html) {
                        $('#kota_id_edit').remove();
                        $("#result_edit").html(html);
                        $("#result_tunggu_edit").html('');
                    }
                });
            })
        </script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.all.min.js"></script>

        <script>
            $("#simpan_data").click(function() {
                toastr.options = {
                    tapToDismiss: true,
                    toastClass: 'toast',
                    containerId: 'toast-container',
                    debug: false,
                    fadeIn: 300,
                    fadeOut: 1000,
                    extendedTimeOut: 1000,
                    iconClass: 'toast-info',
                    positionClass: 'toast-top-right',
                    timeOut: 5000,
                    titleClass: 'toast-title',
                    messageClass: 'toast-message'
                };

                var customer_id = $('#customer_id').val();
                var provinsi_id = $('#provinsi-asal').val();
                var kota_id_cek = $('#kota_id').val();
                var alamat_lengkap = $('#alamat_lengkap').val();


                if (!provinsi_id) {
                    toastr.error('Provinsi belum di pilih');
                    $('#provinsi-asal').focus();
                } else if (!kota_id_cek) {
                    toastr.error('Kota /  Kabupaten belum di pilih');
                    $('#kota_id').focus();
                } else if (!alamat_lengkap) {
                    toastr.error('Alamat lengkap belum di isi');
                    $('#alamat_lengkap').focus();
                } else {
                    swal.fire({
                        title: "",
                        icon: 'question',
                        text: "Yakin Simpan Data ?",
                        type: "warning",
                        showCancelButton: !0,
                        confirmButtonText: "Yes, save it!",
                        cancelButtonText: "No, cancel!",
                        reverseButtons: !0
                    }).then(function(e) {

                        if (e.value === true) {
                            $.ajax({
                                type: "POST",
                                url: "{{ route('alamat.store') }}",
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                },
                                data: {
                                    'customer_id': customer_id,
                                    'provinsi_id': provinsi_id,
                                    'kota_id': kota_id_cek,
                                    'alamat_lengkap': alamat_lengkap
                                },
                                dataType: "json",
                                success: function(result) {
                                    if (result.success == true) {
                                        swal.fire("Data berhasil di simpan", result.message,
                                            "success");
                                        setTimeout(function() {
                                            location.reload();
                                        }, 1000);


                                    } else {
                                        swal.fire("Error!", 'Sumething went wrong.', "error");
                                        setTimeout(function() {
                                            location.reload();
                                        }, 1000);
                                    }
                                }
                            });
                        }
                    })
                }

            });
        </script>

        <script>
            $("#update_data").click(function() {
                toastr.options = {
                    tapToDismiss: true,
                    toastClass: 'toast',
                    containerId: 'toast-container',
                    debug: false,
                    fadeIn: 300,
                    fadeOut: 1000,
                    extendedTimeOut: 1000,
                    iconClass: 'toast-info',
                    positionClass: 'toast-top-right',
                    timeOut: 5000,
                    titleClass: 'toast-title',
                    messageClass: 'toast-message'
                };
                var id = $('#id_data').val();
                var customer_id_edit = $('#customer_id_edit').val();
                var provinsi_id = $('#provinsi-asal-edit').val();
                var kota_id_cek = $('#kota_id').val();
                var alamat_lengkap = $('#alamat_lengkap_edit').val();
                if (!provinsi_id) {
                    toastr.error('Provinsi belum di pilih');
                    $('#provinsi-asal-edit').focus();
                } else if (!kota_id_cek) {
                    toastr.error('Kota /  Kabupaten belum di pilih');
                    $('#kota_id').focus();
                } else if (!alamat_lengkap) {
                    toastr.error('Alamat lengkap belum di isi');
                    $('#alamat_lengkap_edit').focus();
                } else {
                    swal.fire({
                        title: "",
                        icon: 'question',
                        text: "Yakin Simpan Data ?",
                        type: "warning",
                        showCancelButton: !0,
                        confirmButtonText: "Yes, save it!",
                        cancelButtonText: "No, cancel!",
                        reverseButtons: !0
                    }).then(function(e) {

                        if (e.value === true) {
                            $.ajax({
                                type: "PUT",
                                url: '/panel/alamat/' + id,
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                },
                                data: {
                                    'customer_id': customer_id_edit,
                                    'provinsi_id': provinsi_id,
                                    'kota_id': kota_id_cek,
                                    'alamat_lengkap': alamat_lengkap
                                },
                                dataType: "json",
                                success: function(result) {
                                    if (result.success == true) {
                                        swal.fire("Data berhasil di update", result.message,
                                            "success");
                                        setTimeout(function() {
                                            location.reload();
                                        }, 1000);


                                    } else {
                                        swal.fire("Error!", 'Sumething went wrong.', "error");
                                        setTimeout(function() {
                                            location.reload();
                                        }, 1000);
                                    }
                                }
                            });
                        }
                    })
                }

            });
        </script>
    @endpush
@endsection
