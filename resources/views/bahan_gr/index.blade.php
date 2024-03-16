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
                            <h4 class="m-0 text-dark">{{ $title }}&nbsp;</h4>
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
                                onclick="reload_table_wo_gr()" type="button"><i class="fa fa-spinner"></i></button>
                        </ol>
                    </div><!-- /.col -->

                </div><!-- /.row -->
                <div class="card mt-2">
                    <div class="card-body">
                        <table id="tbl-wo_gr" class="table table-bordered table-hover table-sm tbl-wo_gr">
                            <thead>
                                <tr>
                                    <th width="30">#</th>
                                    <th width="100">NO.WO</th>
                                    <th width="160">TANGGAL</th>
                                    <th width="90">NO.POLISI</th>
                                    <th width="160">NO.RANGKA</th>
                                    <th>JENIS</th>
                                    <th>KM</th>
                                    <th width="30">CLOSE</th>
                                    {{-- <th width="100">NO.ESTIMASI</th> --}}
                                    <th>AKSI</th>
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
    <div class="modal fade" id="modaldetail" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
    </div>
    <div class="modal fade" id="modaldetailwo" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
    </div>
    <div class="modal fade" id="modaltambahdetail" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
    </div>
    <div class="modal fade" id="modalcaribahan" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
    </div>
    <div class="modal fade" id="modalbatalproses" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
    </div>

    <script>
        reload_table_wo_gr();

        function reload_table_wo_gr() {
            $(function() {
                var table = $('.tbl-wo_gr').DataTable({
                    ajax: "{{ route('vwobahan_grajax') }}",
                    type: "GET",
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
                            className: 'dt-body-right',
                            targets: [5, 6],
                        },
                        {
                            orderable: false,
                            className: 'dt-body-center',
                            targets: [7],
                        },
                    ],
                    order: [
                        [1, 'desc']
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
                            data: 'nowo',
                            name: 'nowo',
                            // data: null,
                            render: function(data, type, row, meta) {
                                return `<a href="#" onclick="detail(${row.id})">${row.nowo}</a>`;
                            }
                        },
                        {
                            data: 'tglwo',
                            name: 'tglwo'
                        },
                        {
                            data: 'nopolisi',
                            name: 'nopolisi'
                        },
                        {
                            data: 'norangka',
                            name: 'norangka'
                        },
                        {
                            data: 'kdservice',
                            name: 'kdservice'
                        },
                        {
                            data: 'km',
                            name: 'km'
                        },
                        // {
                        //     data: 'total',
                        //     render: function(data, type, row, meta) {
                        //         return meta.settings.fnFormatNumber(row.total);
                        //     }
                        // },
                        {
                            orderable: true,
                            data: 'close_bahan',
                            name: 'close_bahan',
                            'render': function(data, type, row) {
                                if (row.close_bahan == 1) {
                                    return `<input type="checkbox" checked disabled>`;
                                } else {
                                    return `<input type="checkbox" disabled>`;
                                }
                            }
                        },
                        // {
                        //     data: 'noestimasi',
                        //     name: 'noestimasi'
                        // },
                        // {
                        //     data: null,
                        //     render: function(data, type, row, meta) {
                        //         return `<a href="#${row.id}"><button onclick="detail(${row.id})" class='btn btn-sm btn-info' href='javascript:void(0)' <?= $pakai == 1 ? '' : 'disabled' ?>><i class='fa fa-eye'></i></button></a>
                    //         <a href="#${row.id}"><button onclick="edit(${row.id})" class='btn btn-sm btn-warning' href='javascript:void(0)' <?= $edit == 1 ? '' : 'disabled' ?>><i class='fa fa-edit'></i></button></a>
                    //         <a href="#${row.id},${row.kode}"><button onclick="hapus(${row.id})" class='btn btn-sm btn-danger' href='javascript:void(0)' <?= $hapus == 1 ? '' : 'disabled' ?>><i class='fa fa-trash'></i></button></a>`;

                        //     }
                        // },
                        {
                            data: null,
                            render: function(data, type, row, meta) {
                                // <li><a class="dropdown-item <?= $pakai == 1 ? '' : 'disabled' ?>" onclick="editdetail(${row.id})" href="#" readonly><i class='fa fa-eye'"></i> Detail</a></li>
                                // <li><a class="dropdown-item <?= $pakai == 1 ? '' : 'disabled' ?>" onclick="detail(${row.id})" href="#" readonly><i class='fa fa-eye'"></i> View</a></li>
                                if (row.batal == 1) {
                                    return `<div class="btn-group" role="group">
                                        <button style="width:100px;" id="btnGroupDrop1" type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            Pilih Aksi
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                            <li><a class="dropdown-item <?= $pakai == 1 ? '' : 'disabled' ?>" onclick="detailwo(${row.id})" href="#" readonly><i class='fa fa-edit'"></i> Detail</a></li>
                                            <li><a class="dropdown-item <?= $hapus == 1 ? '' : 'disabled' ?>" onclick="ambilwo(${row.id})" href="#" readonly><i class='fa fa-trash'"></i> Ambil</a></li>
                                        </ul>
                                    </div>`;
                                } else {
                                    if (row.close == 1) {
                                        return `<div class="btn-group" role="group">
                                        <button style="width:100px;" id="btnGroupDrop1" type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            WO Closed
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                            <li><a class="dropdown-item <?= $pakai == 1 ? '' : 'disabled' ?>" onclick="detailwo(${row.id})" href="#" readonly><i class='fa fa-edit'"></i> Detail</a></li>
                                        </ul>                                                                                
                                        </div>`;
                                    } else {
                                        if (row.close_bahan) {
                                            return `<div class="btn-group" role="group">
                                                <button style="width:100px;" id="btnGroupDrop1" type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    Pilih Aksi
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                    <li><a class="dropdown-item <?= $pakai == 1 ? '' : 'disabled' ?>" onclick="detailwo(${row.id})" href="#" readonly><i class='fa fa-edit'"></i> Detail</a></li>
                                                    <li><a class="dropdown-item <?= $unproses == 1 ? '' : 'disabled' ?>" onclick="unproses(${row.id})" href="#" readonly><i class='fa fa-arrow-left'"></i> Unclose</a></li>
                                                </ul>
                                            </div>`;
                                        } else {
                                            return `<div class="btn-group" role="group">
                                                <button style="width:100px;" id="btnGroupDrop1" type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    Pilih Aksi
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                    <li><a class="dropdown-item <?= $pakai == 1 ? '' : 'disabled' ?>" onclick="detailwo(${row.id})" href="#" readonly><i class='fa fa-edit'"></i> Edit Detail</a></li>
                                                    <li><a class="dropdown-item <?= $proses == 1 ? '' : 'disabled' ?>" onclick="proses(${row.id})" href="#" readonly><i class='fa fa-arrow-right'"></i> Close</a></li>
                                                </ul>
                                            </div>`;
                                        }

                                    }
                                }
                            },
                        },
                    ]
                });

            });
        }


        function detail(id) {
            $.ajax({
                type: "get",
                url: `{{ url('wo_gr') }}/${id}`,
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

        function detailwo(id) {
            $.ajax({
                type: "get",
                // url: `{{ url('mobil_gr_detail') }}/${id}`,
                url: `{{ url('bahan_grdetail') }}`,
                dataType: "json",
                data: {
                    id: id,
                    _method: "GET",
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.data) {
                        // console.log(response.data);
                        $('#modaldetailwo').html(response.body);
                        $('#modaldetailwo').modal('show');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            })
        }

        function proses(id) {
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
                            url: 'proses_bahanwo_gr',
                            type: "get",
                            data: {
                                id: id,
                                _method: "get",
                                _token: '{{ csrf_token() }}',
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.sukses == false) {
                                    toastr.error('Data gagal di proses (WO sudah clos)')
                                } else {
                                    toastr.info(response.sukses)
                                    // .then(function() {
                                    //     window.location.href = '/mobil_gr';
                                    // });
                                }
                                reload_table_wo_gr();
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

        function unproses(id) {
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
                            url: 'unproses_bahanwo_gr',
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
    </script>
@endsection

{{-- @stop --}}
