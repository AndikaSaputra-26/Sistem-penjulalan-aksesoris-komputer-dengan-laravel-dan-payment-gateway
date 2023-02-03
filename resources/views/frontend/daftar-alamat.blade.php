@extends('layouts.master-frontend')
@section('title', 'Daftar Alamat Customer')
@section('content')
    <!-- ============================================== HEADER : END ============================================== -->
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="home.html">Home</a></li>
                    <li class='active'>Daftar Alamat</li>
                </ul>
            </div><!-- /.breadcrumb-inner -->
        </div><!-- /.container -->
    </div><!-- /.breadcrumb -->

    <div class="body-content">
        <div class="container">
            <div class="row">
                <div class="col-md-3 sidebar">
                    <div class="side-menu animate-dropdown outer-bottom-xs">
                        <div class="head" style="background-color: #5A98BF; border:white"><i
                                class="icon fa fa-align-justify fa-fw"></i> <span style="color: white">Data Akun</span>
                        </div>
                        <nav class="yamm megamenu-horizontal" role="navigation">
                            <ul class="nav">
                                <li class=" menu-item">
                                    <a href="{{ route('setting-akun') }}">PROFILE</a>
                                </li>
                                <li class=" menu-item">
                                    <a href="{{ route('daftar-alamat') }}">DAFTAR ALAMAT</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="search-result-container ">
                        <div id="myTabContent" class="tab-content category-list">
                            <div class="tab-pane active " id="grid-container">
                                <div class="category-product">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button class="btn btn-md btn-primary mb-1" data-toggle="modal"
                                                data-target="#tesModal" style="float: left;margin-bottom:15px">
                                                <i class="fa fa-plus"></i> TAMBAH ALAMAT
                                            </button>
                                        </div>
                                        @foreach ($alamat as $row)
                                            <div class="col-md-6">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading"> <b>{{ $row->nama_provinsi }} -
                                                            {{ $row->nama_kota }}</b> </div>
                                                    <div class="panel-body"
                                                        style="min-height: 100px; text-align:justify">
                                                        {{ $row->alamat_lengkap }}</div>
                                                    <div class="panel-footer">
                                                        <a class="btn btn-md btn-primary mb-1 updateData"
                                                            style="float: left; margin-right:5px"
                                                            data-id_data="{{ $row->id }}"
                                                            data-customer_id="{{ $row->customer_id }}"
                                                            data-alamat_lengkap="{{ $row->alamat_lengkap }}"
                                                            data-provinsi_id="{{ $row->provinsi_id }}"
                                                            data-kota_id="{{ $row->kota_id }}"><i
                                                                class="fa fa-edit"></i>
                                                            EDIT</a>

                                                        <form action="{{ route('destroy-alamat', $row->id) }}"
                                                            method="post" class="d-inline"
                                                            onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                            @csrf
                                                            @method('delete')
                                                            <button class="btn btn-danger">
                                                                <i class="fa fa-trash"></i> DELETE
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal add --}}
    <div class="modal fade" id="tesModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal"><span>&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Tambah Alamat</h4>
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
    <div class="modal fade" id="ajaxModelEdit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal"><span>&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Tambah Alamat</h4>
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
@endsection
@push('js')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script>
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
                url: '/data-kota/' + provinsi_id,
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
                url: '/data-kota/' + selectedValue,
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
                url: '/data-kota/' + selectedValue,
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
                            url: "{{ route('create-alamat') }}",
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
                            url: 'update-alamat/' + id,
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
