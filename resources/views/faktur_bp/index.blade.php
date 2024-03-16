@extends('/home/index')

@section('content')
    @include('home.akses');
    <?php
    $pakai = session('pakai');
    $tambah = session('tambah');
    $edit = session('edit');
    $hapus = session('hapus');
    $proses = session('proses');
    $unproses = session('unproses');
    $cetak = session('cetak');
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-0">
                    <div class="col-sm-6">
                        <div class="btn-group">
                            <h4 class="m-0 text-dark">{{ $title }}&nbsp;&nbsp;</h4>
                            &nbsp;<span><button tipe="button" class="btn btn-primary btn-sm tomboltambah"
                                    {{ $tambah != 1 ? 'disabled' : '' }}> <i class="fa fa-circle-plus"></i>
                                    Tambah Faktur</button></span>
                        </div>
                        @if (session('message'))
                            <div class="text-success">{{ session('message') }}</div>
                        @endif
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item active">{{ $title }}</li>
                            &nbsp;&nbsp;<button style="display:inline" class="btn btn-outline-info btn-sm mb-2 btnreload"
                                onclick="reload_table()" type="button"><i class="fa fa-spinner"></i></button>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
                <div class="card mt-2">
                    <div class="card-body">
                        <table id="tbl-faktur_bp" class="table table-bordered table-hover table-sm tbl-faktur_bp">
                            {{-- <table id="tbl-mobil_bp" class="table table-bordered table-striped tbl-mobil_bp"> --}}
                            <thead>
                                <tr>
                                    <th width=30 style="text-align:center;">#</th>
                                    <th width="70">No.Faktur</th>
                                    <th width="120">Tgl.Faktur</th>
                                    <th width="70">No.WO</th>
                                    <th width="70">No.Polisi</th>
                                    <th width="250">Pemilik</th>
                                    <th width="90">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    {{-- </div> --}}
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
        </div>
    </div>


    <div class="viewmodal" style="display: none;"></div>

    <!-- jQuery -->
    <script src="assets/plugins/jquery/jquery.min.js"></script>

    <div class="modal fade" id="modaltambahmaster" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
    </div>
    <div class="modal fade" id="modalcariwo" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
    </div>
    <div class="modal fade" id="modaltambah" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
    </div>
    <div class="modal fade" id="modalcaripemilik" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
    </div>
    <div class="modal fade" id="modalcaripemakai" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
    </div>
    <div class="modal fade" id="modaldetail" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
    </div>
    <div class="modal fade" id="modaltblwo" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
    </div>
    <div class="modal fade" id="modaltambahwo" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
    </div>
    <div class="modal fade" id="modaldetailfaktur" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
    </div>
    <div class="modal fade" id="modalcaritltipebp" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
    </div>
    <div class="modal fade" id="modalcaritlbp" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
    </div>
    <div class="modal fade" id="modalcarisa" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
    </div>
    <div class="modal fade" id="modalcariasuransi" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
    </div>
    <div class="modal fade" id="modaltambahdetail" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
    </div>
    <div class="modal fade" id="modalcarijasa" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
    </div>
    <div class="modal fade" id="modalcaripart" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
    </div>
    <div class="modal fade" id="modalcaribahan" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
    </div>
    <div class="modal fade" id="modalcariopl" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
    </div>
    <div class="modal fade" id="modalcariasuransi" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
    </div>
    <div class="modal fade" id="modalbatalproses" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
    </div>

    <script>
        reload_table();

        function reload_table() {
            $(function() {
                var table = $('.tbl-faktur_bp').DataTable({
                    ajax: "{{ route('faktur_bpajax') }}",
                    // beforeSend: function(jqXHR) {
                    //     jqXHR.overrideMimeType("application/json");
                    //     $('#p1').append('<h3> The beforeSend() function called. </h3>');
                    // }
                    // scrollCollapse: true,
                    scrollY: '42vh',
                    // info: true,
                    // responsive: true,
                    autoWidth: false,
                    aLengthMenu: [
                        [5, 50, 100, -1],
                        [5, 50, 100, "All"]
                    ],
                    iDisplayLength: 5,
                    scrollX: true,
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    paging: true,
                    lengthChange: true,
                    searching: true,
                    ordering: true,
                    columnDefs: [{
                            className: 'dt-body-center',
                            targets: [0],
                        },
                        {
                            orderable: false,
                            className: 'dt-body-center',
                            targets: [6],
                        }
                    ],
                    order: [
                        [1, 'asc']
                    ],
                    columns: [{
                            orderable: false,
                            "data": null,
                            "searchable": false,
                            "render": function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            orderable: true,
                            // data: 'kode1',
                            // name: 'kode1'
                            data: 'nofaktur',
                            name: 'nofaktur',
                            // data: null,
                            render: function(data, type, row, meta) {
                                return `<a href="#" onclick="detail(${row.id})">${row.nofaktur}</a>`;
                            }
                        },
                        {
                            data: 'tanggal',
                            name: 'tanggal'
                        },
                        {
                            data: 'nowo',
                            name: 'nowo'
                        },
                        {
                            data: 'nopolisi',
                            name: 'nopolisi'
                        },
                        {
                            data: 'nmpemilik',
                            name: 'nmpemilik'
                        },
                        {
                            data: null,
                            render: function(data, type, row, meta) {
                                if (row.batal == 1) {
                                    return `<div class="btn-group" role="group">
                                        <button id="btnGroupDrop1" type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            Pilih Aksi
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                            <li><a class="dropdown-item <?= $pakai == 1 ? '' : 'disabled' ?>" onclick="detailfaktur(${row.id})" href="#" readonly><i class='fa fa-edit'"></i> Detail</a></li>
                                            <li><a class="dropdown-item <?= $hapus == 1 ? '' : 'disabled' ?>" onclick="ambilfaktur(${row.id})" href="#" readonly><i class='fa fa-trash'"></i> Ambil</a></li>
                                        </ul>
                                    </div>`;
                                } else {
                                    if (row.close == 1) {
                                        return `<div class="btn-group" role="group">
                                            <button id="btnGroupDrop1" type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                Pilih Aksi
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                <li><a class="dropdown-item <?= $pakai == 1 ? '' : 'disabled' ?>" onclick="detailfaktur(${row.id})" href="#" readonly><i class='fa fa-edit'"></i> Detail</a></li>
                                                <li><a class="dropdown-item <?= $unproses == 1 ? '' : 'disabled' ?>" onclick="unprosesfaktur(${row.id})" href="#" readonly><i class='fa fa-arrow-left'"></i> Unclose</a></li>
                                                <li><a class="dropdown-item <?= $cetak == 1 ? '' : 'disabled' ?>" onclick="cetakfaktur(${row.id})" href="#" readonly><i class='fa fa-print'"></i> Cetak</a></li>
                                            </ul>
                                            </div>`;
                                    } else {
                                        return `<div class="btn-group" role="group">
                                        <button id="btnGroupDrop1" type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            Pilih Aksi
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                            <li><a class="dropdown-item <?= $edit == 1 ? '' : 'disabled' ?>" onclick="editfaktur(${row.id})" href="#" readonly><i class='fa fa-edit'"></i> Edit</a></li>
                                            <li><a class="dropdown-item <?= $pakai == 1 ? '' : 'disabled' ?>" onclick="detailfaktur(${row.id})" href="#" readonly><i class='fa fa-edit'"></i> Edit Detail</a></li>
                                            <li><a class="dropdown-item <?= $proses == 1 ? '' : 'disabled' ?>" onclick="prosesfaktur(${row.id})" href="#" readonly><i class='fa fa-arrow-right'"></i> Close</a></li>
                                            <li><a class="dropdown-item <?= $hapus == 1 ? '' : 'disabled' ?>" onclick="cancelfaktur(${row.id})" href="#" readonly><i class='fa fa-trash'"></i> Cancel</a></li>
                                        </ul>
                                    </div>`;
                                    }
                                }
                            },
                        },
                    ]
                });

            });
        }

        $('.tomboltambah').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: `{{ route('faktur_bp.create') }}`,
                dataType: "json",
                success: function(response) {
                    // $('.viewmodal').html(response.data).show();
                    $('#modaltambahmaster').html(response.body)
                    $('#modaltambahmaster').modal('show');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    // alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    // const errors = xhr.responseJSON?.errors
                    // console.log(errors);
                    if (xhr.status == '401' || xhr.status == '419') {
                        toastr.error('Login Expired, silahkan login ulang')
                        toastr.options = {
                            "closeButton": false,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": true,
                            "positionClass": "toast-top-center",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                        window.location.href = "{{ route('actionlogout') }}";
                    }
                }
            })
        })

        function detail(id) {
            $.ajax({
                type: "get",
                url: `{{ url('faktur_bp') }}/${id}`,
                dataType: "json",
                data: {
                    id: id,
                    _method: "GET",
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.data) {
                        // console.log(response.data);
                        $('#modaltambahmaster').html(response.body);
                        $('#modaltambahmaster').modal('show');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            })
        }

        function editdetail(id) {
            $.ajax({
                type: "get",
                // url: `{{ url('mobil_bp_detail') }}/${id}`,
                url: `{{ url('faktur_bpd') }}`,
                dataType: "json",
                data: {
                    id: id,
                    _method: "GET",
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.data) {
                        // console.log(response.data);
                        $('#modaldetail').html(response.body);
                        $('#modaldetail').modal('show');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            })
        }

        function edit(id) {
            $.ajax({
                type: "get",
                url: `{{ url('faktur') }}/${id}/edit`,
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        // let data_response = JSON.parse(response.data);
                        // alert(data_response.kode);
                        // console.log(response.data);
                        // $('.viewmodal').html(response.data).show();
                        $('#modaltambahmaster').html(response.body);
                        $('#modaltambahmaster').modal('show');
                        // $('#kode').modal('aaaaa');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    // alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    // const errors = xhr.responseJSON?.errors
                    // console.log(errors);
                    if (xhr.status == '401' || xhr.status == '419') {
                        toastr.error('Login Expired, silahkan login ulang')
                        toastr.options = {
                            "closeButton": false,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": true,
                            "positionClass": "toast-top-center",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                        window.location.href = "{{ route('actionlogout') }}";
                    }
                }
            })
        }

        function wo_bp(id) {
            $.ajax({
                type: "get",
                url: `{{ url('vwo_bp') }}`,
                dataType: "json",
                data: {
                    id: id,
                    _method: "GET",
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.data) {
                        // let data_response = JSON.parse(response.data);
                        // alert(data_response.kode);
                        // console.log(response.data);
                        // $('.viewmodal').html(response.data).show();
                        $('#modaltblwo').html(response.body);
                        $('#modaltblwo').modal('show');
                        // $('#kode').modal('aaaaa');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    // alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    // const errors = xhr.responseJSON?.errors
                    // console.log(errors);
                    if (xhr.status == '401' || xhr.status == '419') {
                        toastr.error('Login Expired, silahkan login ulang')
                        toastr.options = {
                            "closeButton": false,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": true,
                            "positionClass": "toast-top-center",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                        window.location.href = "{{ route('actionlogout') }}";
                    }
                }
            })
        }

        function hapus(id) {
            swal({
                    title: "Yakin akan hapus ?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: `{{ url('faktur') }}/${id}`,
                            type: "POST",
                            data: {
                                id: id,
                                _method: "DELETE",
                                _token: '{{ csrf_token() }}',
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.sukses == false) {
                                    // swal({
                                    //     title: "Data gagal dihapus!",
                                    //     text: "",
                                    //     icon: "error"
                                    // })
                                    toastr.error('Data gagal dihapus')
                                } else {
                                    // swal({
                                    //     title: "Data berhasil dihapus! ",
                                    //     text: "",
                                    //     icon: "success"
                                    // })
                                    reload_table();
                                    toastr.info('Data berhasil dihapus, silahkan melanjutkan')
                                    // .then(function() {
                                    //     window.location.href = '/mobil_bp';
                                    // });
                                }
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                // alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                                // const errors = xhr.responseJSON?.errors
                                // console.log(errors);
                                if (xhr.status == '401' || xhr.status == '419') {
                                    toastr.error('Login Expired, silahkan login ulang')
                                    toastr.options = {
                                        "closeButton": false,
                                        "debug": false,
                                        "newestOnTop": false,
                                        "progressBar": true,
                                        "positionClass": "toast-top-center",
                                        "preventDuplicates": false,
                                        "onclick": null,
                                        "showDuration": "300",
                                        "hideDuration": "1000",
                                        "timeOut": "5000",
                                        "extendedTimeOut": "1000",
                                        "showEasing": "swing",
                                        "hideEasing": "linear",
                                        "showMethod": "fadeIn",
                                        "hideMethod": "fadeOut"
                                    }
                                    window.location.href = "{{ route('actionlogout') }}";
                                }
                            }

                        })
                    }
                })
        }

        function editfaktur(id) {
            $.ajax({
                type: "get",
                url: `{{ url('faktur_bp') }}/${id}/edit`,
                data: {
                    id: id,
                    // _method: "get",
                    _token: '{{ csrf_token() }}',
                },
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        // console.log(response.data);
                        $('#modaltambahmaster').html(response.body);
                        $('#modaltambahmaster').modal('show');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }

            })
        }

        // function detail_faktur(id) {
        //     $.ajax({
        //         type: "get",
        //         // url: `faktur_bpd`,
        //         url: `{{ url('faktur_bp') }}/${id}`,
        //         data: {
        //             id: id,
        //             _method: "get",
        //             _token: '{{ csrf_token() }}',
        //         },
        //         dataType: "json",
        //         success: function(response) {
        //             if (response.data) {
        //                 // console.log(response.data);
        //                 $('#modaldetailmaster').html(response.body);
        //                 $('#modaldetailmaster').modal('show');
        //             }
        //         },
        //         error: function(xhr, ajaxOptions, thrownError) {
        //             alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        //         }

        //     })
        // }

        function detailfaktur(id) {
            $.ajax({
                type: "get",
                url: `faktur_bpd`,
                // url: `{{ url('faktur_bpd') }}/${id}`,
                data: {
                    id: id,
                    _method: "get",
                    _token: '{{ csrf_token() }}',
                },
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        // console.log(response.data);
                        $('#modaldetailfaktur').html(response.body);
                        $('#modaldetailfaktur').modal('show');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }

            })
        }

        function prosesfaktur(id) {
            swal({
                    title: "Yakin akan close ?",
                    text: "",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: 'faktur_bpproses',
                            type: "POST",
                            data: {
                                id: id,
                                _method: "POST",
                                _token: '{{ csrf_token() }}',
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.sukses == false) {
                                    // swal({
                                    //     title: "Data gagal dihapus!",
                                    //     text: "",
                                    //     icon: "error"
                                    // })
                                    toastr.error('Data gagal di close')
                                } else {
                                    // swal({
                                    //     title: "Data berhasil dihapus! ",
                                    //     text: "",
                                    //     icon: "success"
                                    // })
                                    reload_table();
                                    toastr.info('Data berhasil di close, silahkan melanjutkan')
                                    // .then(function() {
                                    //     window.location.href = '/mobil_bp';
                                    // });
                                }
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                // alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                                // const errors = xhr.responseJSON?.errors
                                // console.log(errors);
                                if (xhr.status == '401' || xhr.status == '419') {
                                    toastr.error('Login Expired, silahkan login ulang')
                                    toastr.options = {
                                        "closeButton": false,
                                        "debug": false,
                                        "newestOnTop": false,
                                        "progressBar": true,
                                        "positionClass": "toast-top-center",
                                        "preventDuplicates": false,
                                        "onclick": null,
                                        "showDuration": "300",
                                        "hideDuration": "1000",
                                        "timeOut": "5000",
                                        "extendedTimeOut": "1000",
                                        "showEasing": "swing",
                                        "hideEasing": "linear",
                                        "showMethod": "fadeIn",
                                        "hideMethod": "fadeOut"
                                    }
                                    window.location.href = "{{ route('actionlogout') }}";
                                }
                            }

                        })
                    }
                })
        }

        function unprosesfaktur(id) {
            swal({
                    title: "Yakin akan unclose ?",
                    text: "",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: "get",
                            url: 'faktur_bpunproses',
                            data: {
                                id: id,
                                _method: "POST",
                                _token: '{{ csrf_token() }}',
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.data) {
                                    // console.log(response.data);
                                    $('#modalbatalproses').html(response.body);
                                    $('#modalbatalproses').modal('show');
                                }
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                            }

                        })
                    }
                })
        }

        function cancelfaktur(id) {
            swal({
                    title: "Yakin akan cancel ?",
                    text: "",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: 'faktur_bpcancel',
                            type: "POST",
                            data: {
                                id: id,
                                _method: "POST",
                                _token: '{{ csrf_token() }}',
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.sukses == false) {
                                    // swal({
                                    //     title: "Data gagal dihapus!",
                                    //     text: "",
                                    //     icon: "error"
                                    // })
                                    toastr.error('Data gagal di cancel')
                                } else {
                                    // swal({
                                    //     title: "Data berhasil dihapus! ",
                                    //     text: "",
                                    //     icon: "success"
                                    // })
                                    reload_table();
                                    toastr.info('Data berhasil di cancel, silahkan melanjutkan')
                                    // .then(function() {
                                    //     window.location.href = '/mobil_bp';
                                    // });
                                }
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                // alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                                // const errors = xhr.responseJSON?.errors
                                // console.log(errors);
                                if (xhr.status == '401' || xhr.status == '419') {
                                    toastr.error('Login Expired, silahkan login ulang')
                                    toastr.options = {
                                        "closeButton": false,
                                        "debug": false,
                                        "newestOnTop": false,
                                        "progressBar": true,
                                        "positionClass": "toast-top-center",
                                        "preventDuplicates": false,
                                        "onclick": null,
                                        "showDuration": "300",
                                        "hideDuration": "1000",
                                        "timeOut": "5000",
                                        "extendedTimeOut": "1000",
                                        "showEasing": "swing",
                                        "hideEasing": "linear",
                                        "showMethod": "fadeIn",
                                        "hideMethod": "fadeOut"
                                    }
                                    window.location.href = "{{ route('actionlogout') }}";
                                }
                            }

                        })
                    }
                })
        }

        function ambilfaktur(id) {
            swal({
                    title: "Yakin akan ambil ?",
                    text: "",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: 'faktur_bpambil',
                            type: "POST",
                            data: {
                                id: id,
                                _method: "POST",
                                _token: '{{ csrf_token() }}',
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.sukses == false) {
                                    // swal({
                                    //     title: "Data gagal dihapus!",
                                    //     text: "",
                                    //     icon: "error"
                                    // })
                                    toastr.error('Data gagal di ambil')
                                } else {
                                    // swal({
                                    //     title: "Data berhasil dihapus! ",
                                    //     text: "",
                                    //     icon: "success"
                                    // })
                                    reload_table();
                                    toastr.info('Data berhasil di ambil, silahkan melanjutkan')
                                    // .then(function() {
                                    //     window.location.href = '/mobil_bp';
                                    // });
                                }
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                // alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                                // const errors = xhr.responseJSON?.errors
                                // console.log(errors);
                                if (xhr.status == '401' || xhr.status == '419') {
                                    toastr.error('Login Expired, silahkan login ulang')
                                    toastr.options = {
                                        "closeButton": false,
                                        "debug": false,
                                        "newestOnTop": false,
                                        "progressBar": true,
                                        "positionClass": "toast-top-center",
                                        "preventDuplicates": false,
                                        "onclick": null,
                                        "showDuration": "300",
                                        "hideDuration": "1000",
                                        "timeOut": "5000",
                                        "extendedTimeOut": "1000",
                                        "showEasing": "swing",
                                        "hideEasing": "linear",
                                        "showMethod": "fadeIn",
                                        "hideMethod": "fadeOut"
                                    }
                                    window.location.href = "{{ route('actionlogout') }}";
                                }
                            }

                        })
                    }
                })
        }

        function cetakfaktur(id) {
            $url = "{{ url('cetak_faktur_bp') }}?id=" + id,
                // data: {
                //     id: id,
                //     _method: "POST",
                //     _token: '{{ csrf_token() }}',
                // },
                window.open($url, '_blank')
        }
    </script>
@endsection

{{-- @stop --}}
