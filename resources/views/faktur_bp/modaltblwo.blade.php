<?php
$submenu = 'wo_bp';
$session = session();
// var_dump($vdata);
?>
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

<!-- Modal -->
<div class="modal-dialog" style="max-width: 80%;">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">
                {{ $vdata['title'] . ' : ' . $tbmobil['nopolisi'] . '-' . $tbmobil['norangka'] }}
                <button style="display:inline" class="btn btn-outline-info btn-sm mb-2 btnreload"
                    onclick="reload_table_wo_bp()" type="button"><i class="fa fa-spinner"></i></button>
                {{-- @if (isset($vdata))
                    {{ $vdata['title'] }}
                @endif --}}
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table id="tbl-wo_bp" class="table table-bordered table-hover table-sm tbl-wo_bp">
                <thead>
                    <tr>
                        <th width="30">#</th>
                        <th width="100">NO.WO</th>
                        <th width="140">TANGGAL</th>
                        {{-- <th width="160">NO.RANGKA</th> --}}
                        <th>JENIS</th>
                        <th width="60">KM</th>
                        <th width="90">TOTAL</th>
                        <th width="30">CLOSE</th>
                        <th width="100">NO.ESTIMASI</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        reload_table_wo_bp()
    })

    function reload_table_wo_bp() {
        var vnopolisi = $("#nopolisi").val();
        $(function() {
            var table = $('.tbl-wo_bp').DataTable({
                ajax: "{{ url('vwo_bpajax') }}?nopolisi=" + vnopolisi,
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
                        targets: [4, 5],
                    },
                    {
                        orderable: false,
                        className: 'dt-body-center',
                        targets: [6, 8],
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
                            return `<a href="#" onclick="detail_wo(${row.id})">${row.nowo}</a>`;
                        }
                    },
                    {
                        data: 'tglwo',
                        name: 'tglwo'
                    },
                    // {
                    //     data: 'nopolisi',
                    //     name: 'nopolisi'
                    // },
                    // {
                    //     data: 'norangka',
                    //     name: 'norangka'
                    // },
                    {
                        data: 'kdservice',
                        name: 'kdservice'
                    },
                    {
                        data: 'km',
                        name: 'km'
                    },
                    {
                        data: 'total',
                        render: function(data, type, row, meta) {
                            return meta.settings.fnFormatNumber(row.total);
                        }
                    },
                    {
                        orderable: true,
                        data: 'close',
                        name: 'close',
                        'render': function(data, type, row) {
                            if (row.close == 1) {
                                return `<input type="checkbox" checked disabled>`;
                            } else {
                                return `<input type="checkbox" disabled>`;
                            }
                        }
                    },
                    {
                        data: 'noestimasi',
                        name: 'noestimasi'
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
                                            <li><a class="dropdown-item <?= $pakai == 1 ? '' : 'disabled' ?>" onclick="view_detailwo(${row.id})" href="#" readonly><i class='fa fa-edit'"></i> Detail</a></li>
                                            <li><a class="dropdown-item <?= $hapus == 1 ? '' : 'disabled' ?>" onclick="ambilwo(${row.id})" href="#" readonly><i class='fa fa-trash'"></i> Ambil</a></li>
                                        </ul>
                                    </div>`;
                            } else {
                                if (row.close == 1) {
                                    if (row.nowo == "") {
                                        return `<div class="btn-group" role="group">
                                            <button id="btnGroupDrop1" type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                Pilih Aksi
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                <li><a class="dropdown-item <?= $unproses == 1 ? '' : 'disabled' ?>" onclick="unproseswo(${row.id})" href="#" readonly><i class='fa fa-arrow-left'"></i> Unclose</a></li>
                                                <li><a class="dropdown-item <?= $cetak == 1 ? '' : 'disabled' ?>" onclick="cetakwo(${row.id})" href="#" readonly><i class='fa fa-print'"></i> Cetak</a></li>
                                                <li><a class="dropdown-item <?= $proses == 1 ? '' : 'disabled' ?>" onclick="buatwo(${row.id})" href="#" readonly><i class='fa fa-book'"></i> Buat WO</a></li>
                                            </ul>
                                            </div>`;
                                    } else {
                                        return `<div class="btn-group" role="group">
                                            <button id="btnGroupDrop1" type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                Pilih Aksi
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                <li><a class="dropdown-item <?= $pakai == 1 ? '' : 'disabled' ?>" onclick="view_detailwo(${row.id})" href="#" readonly><i class='fa fa-edit'"></i> Detail</a></li>
                                                <li><a class="dropdown-item <?= $unproses == 1 ? '' : 'disabled' ?>" onclick="unproseswo(${row.id})" href="#" readonly><i class='fa fa-arrow-left'"></i> Unclose</a></li>
                                                <li><a class="dropdown-item <?= $cetak == 1 ? '' : 'disabled' ?>" onclick="cetakwo(${row.id})" href="#" readonly><i class='fa fa-print'"></i> Cetak</a></li>
                                            </div>`;
                                    }
                                } else {
                                    return `<div class="btn-group" role="group">
                                        <button id="btnGroupDrop1" type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            Pilih Aksi
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                            <li><a class="dropdown-item <?= $edit == 1 ? '' : 'disabled' ?>" onclick="editwo(${row.id})" href="#" readonly><i class='fa fa-edit'"></i> Edit</a></li>
                                            <li><a class="dropdown-item <?= $pakai == 1 ? '' : 'disabled' ?>" onclick="view_detailwo(${row.id})" href="#" readonly><i class='fa fa-edit'"></i> Edit Detail</a></li>
                                            <li><a class="dropdown-item <?= $cetak == 1 ? '' : 'disabled' ?>" onclick="cetakwo(${row.id})" href="#" readonly><i class='fa fa-print'"></i> Cetak</a></li>
                                            <li><a class="dropdown-item <?= $proses == 1 ? '' : 'disabled' ?>" onclick="proseswo(${row.id})" href="#" readonly><i class='fa fa-arrow-right'"></i> Close</a></li>
                                            <li><a class="dropdown-item <?= $hapus == 1 ? '' : 'disabled' ?>" onclick="cancelwo(${row.id})" href="#" readonly><i class='fa fa-trash'"></i> Cancel</a></li>
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


    function editwo(id) {
        $.ajax({
            type: "get",
            url: `{{ url('wo_bp') }}/${id}/edit`,
            data: {
                id: id,
                _method: "get",
                _token: '{{ csrf_token() }}',
            },
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    // console.log(response.data);
                    $('#modaltambahwo').html(response.body);
                    $('#modaltambahwo').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }

        })
    }

    function detail_wo(id) {
        $.ajax({
            type: "get",
            // url: `wo_bpd`,
            url: `{{ url('wo_bp') }}/${id}`,
            data: {
                id: id,
                _method: "get",
                _token: '{{ csrf_token() }}',
            },
            dataType: "json",
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

    function view_detailwo(id) {
        $.ajax({
            type: "get",
            // url: `wo_bpd`,
            url: `{{ url('wo_bpd') }}/${id}`,
            data: {
                id: id,
                _method: "get",
                _token: '{{ csrf_token() }}',
            },
            dataType: "json",
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

    function proseswo(id) {
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
                        url: 'wo_bpproses',
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
                                reload_table_wo_bp();
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

    function unproseswo(id) {
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
                        url: 'wo_bpunproses',
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

    function cancelwo(id) {
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
                        url: 'wo_bpcancel',
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
                                reload_table_wo_bp();
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

    function ambilwo(id) {
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
                        url: 'wo_bpambil',
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
                                reload_table_wo_bp();
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

    function cetakwo(id) {
        $url = "{{ url('cetak_wo_bp') }}?id=" + id,
            // data: {
            //     id: id,
            //     _method: "POST",
            //     _token: '{{ csrf_token() }}',
            // },
            window.open($url, '_blank')
    }
</script>
