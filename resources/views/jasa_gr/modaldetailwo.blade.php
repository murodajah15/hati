<?php
$submenu = 'wo_gr';
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
$close_wo = $wo_gr->close;
$close_jasa = $wo_gr->close_jasa;
$batal = $wo_gr->batal;
?>


<!-- Modal -->
<div class="modal-dialog" style="max-width: 70%;">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">
                {{ $vdata['title'] }}{{ ' ' . $wo_gr->nowo }}{{ $wo_gr->batal == 1 ? ', WO Batal' : '' }}
                {{ $wo_gr->close == 1 ? ', WO Closed' : ', WO Open' }}
                {{-- @if (isset($vdata))
                    {{ $vdata['title'] }}
                @endif --}}
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <input type="hidden" class="form-control-sm" name="username" id="username"
                value="{{ $session->get('username') }}">
            <input type="hidden" class="form-control-sm" name="nowo" id="nowo" value="{{ $wo_gr->nowo }}">

            {{-- <div class="card-body"> --}}
            <div class="row">
                <div class="col-md-6">
                    @if ($wo_gr->close == 1 or $wo_gr->close_jasa == 1 or $wo_gr->batal == 1)
                        <button tipe="button" class="btn btn-primary btn-sm tomboltambahjasa" disabled> <i
                                class="fa fa-circle-plus"></i>
                            Tambah Jasa</button>
                    @else
                        <button tipe="button" class="btn btn-primary btn-sm tomboltambahjasa"
                            {{ $tambah != 1 ? 'disabled' : '' }}> <i class="fa fa-circle-plus"></i>
                            Tambah Jasa</button>
                    @endif
                </div>
                <div class="col-sm-6">
                    &nbsp;&nbsp;<button style="display:inline"
                        class="btn btn-outline-info btn-sm mb-2 float-sm-right btnreload"
                        onclick="reload_table_jasa_wo()" type="button"><i class="fa fa-spinner"></i></button>
                </div><!-- /.col -->
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <table id="tbl-jasawo_gr" class="table table-bordered table-hover table-sm tbl-jasawo_gr">
                        <thead>
                            <th>#</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Disc.(%)</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
{{-- </div> --}}

<script>
    var myModal = document.getElementById('modaltambahwo')
    var myInput = document.getElementById('kode')
    // myModal.addEventListener('shown.bs.modal', function() {
    //     myInput.focus()
    // })

    $(myModal).on('shown.bs.modal', function() {
        $(this).find(myInput).focus();
    });

    reload_table_jasa_wo();

    function reload_table_jasa_wo() {
        $(function() {
            let vnowo = document.getElementById('nowo').value;
            // var vnowo = $("#nowo").val();
            var table = $('#tbl-jasawo_gr').DataTable({
                ajax: "{{ url('jasawo_grajax') }}?nowo=" + vnowo,
                type: "GET",
                destroy: true,
                processing: true,
                serverSide: true,
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                columnDefs: [{
                        className: 'dt-body-center',
                        targets: [0, 6],
                    },

                    {
                        orderable: true,
                        className: 'dt-body-right',
                        targets: [3, 4, 5],
                    },
                ],
                order: [
                    [1, 'asc']
                ],
                info: true,
                autoWidth: true,
                responsive: true,
                aLengthMenu: [
                    [5, 50, 100, -1],
                    [5, 50, 100, "All"]
                ],
                autoWidth: false,
                iDisplayLength: 5,
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
                        data: 'kode',
                        name: 'kode',
                        // "render": function(data, type, row, meta) {
                        //     return meta.row + meta.settings._iDisplayStart + 1;
                        // }
                        // data: null,
                        render: function(data, type, row, meta) {
                            return `<a href="#" onclick="detail_jasa(${row.id})">${row.kode}</a>`;
                        }
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'qty',
                        render: function(data, type, row, meta) {
                            return meta.settings.fnFormatNumber(row.qty);
                        }
                    },
                    {
                        data: 'harga',
                        name: 'harga',
                        render: function(data, type, row, meta) {
                            return meta.settings.fnFormatNumber(row.harga);
                        }
                    },
                    {
                        data: 'pr_discount',
                        name: 'pr_discount',
                        render: function(data, type, row, meta) {
                            return meta.settings.fnFormatNumber(row.pr_discount);
                        }
                    },
                    {
                        data: 'subtotal',
                        render: function(data, type, row, meta) {
                            return meta.settings.fnFormatNumber(row.subtotal);
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            return `<a href="#${row.id}"><button onclick="editdetailjasa(${row.id})" class='btn btn-sm btn-warning' href='javascript:void(0)' <?= $edit == 1 ? '' : 'disabled' ?> <?= $close_wo == 1 ? 'disabled' : '' ?> <?= $close_jasa == 1 ? 'disabled' : '' ?> <?= $batal == 1 ? 'disabled' : '' ?>><i class='fa fa-edit'></i></button></a>
                            <a href="#${row.id},${row.kode}"><button onclick="hapusdetailjasa(${row.id})" class='btn btn-sm btn-danger' href='javascript:void(0)' <?= $hapus == 1 ? '' : 'disabled' ?> <?= $close_wo == 1 ? 'disabled' : '' ?> <?= $close_jasa == 1 ? 'disabled' : '' ?> <?= $batal == 1 ? 'disabled' : '' ?>><i class='fa fa-trash'></i></button></a>`;

                        }
                    },
                ]
            });
        });
    }

    $('.tomboltambahjasa').click(function(e) {
        var nowo = document.getElementById('nowo').value;
        e.preventDefault();
        $.ajax({
            url: `{{ route('wo_grd.create') }}`,
            dataType: "json",
            type: "GET",
            data: {
                jenis: "JASA",
                nowo: nowo,
                _method: "POST",
                _token: '{{ csrf_token() }}',
            },
            success: function(response) {
                // $('.viewmodal').html(response.data).show();
                $('#modaltambahdetail').html(response.body)
                $('#modaltambahdetail').modal('show');
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

    function editdetailjasa(id) {
        // e.preventDefault();
        $.ajax({
            url: `{{ url('wo_grd') }}/${id}/edit`,
            dataType: "json",
            data: {
                id: id,
                jenis: 'JASA',
                _method: "POST",
                _token: '{{ csrf_token() }}',
            },
            success: function(response) {
                // $('.viewmodal').html(response.data).show();
                $('#modaltambahdetail').html(response.body)
                $('#modaltambahdetail').modal('show');
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

    function hapusdetailjasa(id) {
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
                        url: `{{ url('wo_grd') }}/${id}`,
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
                                toastr.info('Data berhasil dihapus, silahkan melanjutkan')
                                reload_table_jasa_wo();
                                // .then(function() {
                                //     window.location.href = '/mobil_gr';
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
</script>
