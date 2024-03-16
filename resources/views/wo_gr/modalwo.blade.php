<?php
$session = session();
// var_dump($vdata);
$tambah = $userdtl->tambah;
$edit = $userdtl->edit;
$hapus = $userdtl->hapus;
?>
<!-- Modal -->
<div class="modal-dialog" style="max-width: 70%;">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">
                {{ $vdata['title'] . ' : ' . $tasklisttipe_gr['kode'] . '-' . $tasklisttipe_gr['nama'] . '-' . $tasklisttipe_gr['kdasuransi'] . '-' . $tasklisttipe_gr['nmasuransi'] }}
                {{-- @if (isset($vdata))
                    {{ $vdata['title'] }}
                @endif --}}
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="input-group">
                    <div class="col-md-2">
                        <input type="checkbox" class="checkbox" class="form-control" name="check_salin"
                            id="check_salin"> Salin dari
                    </div>
                    <div class="row">
                        <div id="kode_salin">
                            <div class="col-md-12">
                                <div class="col-12 col-sm-12">
                                    <div class="input-group mb-1">
                                        <input type="text" style="width: 3%" class="form-control form-control-sm"
                                            name="kdtasklist_salin" id="kdtasklist_salin">
                                        <input type="text" style="width: 3%" class="form-control form-control-sm"
                                            name="nmtasklist_salin" id="nmtasklist_salin" readonly>
                                        <input type="text" style="width: 3%" class="form-control form-control-sm"
                                            name="kdasuransi_salin" id="kdasuransi_salin" readonly>
                                        <input type="text" style="width: 30%" class="form-control form-control-sm"
                                            name="nmasuransi_salin" id="nmasuransi_salin" readonly>
                                        <button class="btn btn-outline-secondary btn-sm" type="button"
                                            id="caritasklist_salin"><i class="fa fa-search"></i></button>
                                        &nbsp;&nbsp;<button class="btn btn-primary btn-sm" type="button"
                                            id="proses_salin_tasklist_grd">Proses</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <form action="simpantasklisttipe_grd" method="post" class="formtasklisttipe_grd">
                    @csrf
                    <input type="hidden" class="form-control-sm" name="username" id="username"
                        value="{{ $session->get('username') }}">
                    <input type="hidden" class="form-control-sm" name="kdtasklist" id="kdtasklist"
                        value="{{ $tasklisttipe_gr->kode }}">
                    <input type="hidden" class="form-control-sm" name="kdasuransi" id="kdasuransi"
                        value="{{ $tasklisttipe_gr->kdasuransi }}">
                    <input type="hidden" class="form-control-sm" name="nmasuransi" id="nmasuransi"
                        value="{{ $tasklisttipe_gr->nmasuransi }}">
                    <div class="row mb-0">
                        <table style='font-size:13px;' class="table table-bordered table-hover table-sm"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th width="170">Kode Jasa</th>
                                    <th>Nama Jasa</th>
                                    <th width="120">Harga</th>
                                    <th width="40">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <input type="hidden" name="id" id="id">
                                <td>
                                    <div class="input-group mb-0">
                                        <input type="text" class="form-control form-control-sm"
                                            placeholder="Kode Jasa" name="kode" id="kode"
                                            {{ $tambah == '1' ? '' : 'disabled' }} required>
                                        <button class="btn btn-outline-secondary btn-sm caritlbp" type="button"
                                            {{ $tambah == '1' ? '' : 'disabled' }} id="caritlbp"><i
                                                class="fa fa-search"></i></button>
                                    </div>
                                    <div class="invalid-feedback errorkode">
                                    </div>
                                </td>
                                <td><input type="text" name="nama" id="nama"
                                        class="form-control form-control-sm" value="" readonly>
                                </td>
                                <td><input type="number" name="harga" id="harga" style="text-align:right;"
                                        class="form-control form-control-sm text-end" value=0>
                                </td>
                                <td><button type="submit" id="btnaddjasa" class="btn btn-primary btn-sm btnaddjasa"
                                        {{ $tambah == '1' ? '' : 'disabled' }}><i class="fa fa-plus"></i></button>
                                </td>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <div class="card mt-0">
                <div class="card-body">
                    {{-- <button style="display:inline" class="btn btn-outline-info btn-sm mb-2 btnreloadjasa"
                                    onclick="reload_table_paket_jasa()" type="button"><i
                                        class="fa fa-spinner"></i></button> --}}
                    {{-- <div class='col-md-12'> --}}
                    <table id='tbl-tasklisttipe_grd' style='font-size:13px;'
                        class="table table-bordered table-hover table-sm">
                        <thead>
                            <tr>
                                <th width='30'>No.</th>
                                <th width='80'>Kode Jasa</th>
                                <th width='300'>Nama Jasa</th>
                                <th>Asuransi</th>
                                <th>Harga</th>
                                <th width="60">Aksi</th>
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

<script>
    $(document).ready(function() {
        reload_table_tasklisttipe_grd()
        $('#kode_salin').hide();
        $('#check_salin').on('change', function() {
            if (this.value == 'on') {
                $('#kode_salin').show();
                this.value = 'off';
            } else {
                $('#kode_salin').hide();
                this.value = 'on';
            }
        });

        // $('#sparepart').on('click', function(e) {
        //     console.log('test')
        // })
    })

    function reload_table_tasklisttipe_grd() {
        $(function() {
            var vkdtasklist = $("#kdtasklist").val();
            var vkdasuransi = $("#kdasuransi").val();
            var table = $('#tbl-tasklisttipe_grd').DataTable({
                ajax: "{{ url('tasklisttipe_grdajax') }}?kdtasklist=" + vkdtasklist + "&kdasuransi=" +
                    vkdasuransi,
                type: "GET",
                scrollY: '42vh',
                // info: true,
                // responsive: true,
                autoWidth: true,
                aLengthMenu: [
                    [5, 50, 100, -1],
                    [5, 50, 100, "All"]
                ],
                iDisplayLength: 50,
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
                        targets: [0, 5],
                    },

                    {
                        orderable: true,
                        className: 'dt-body-right',
                        targets: [3, 4],
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
                        // data: 'kode1',
                        // name: 'kode1'
                        data: 'kode',
                        name: 'kode'
                        // "render": function(data, type, row, meta) {
                        //     return meta.row + meta.settings._iDisplayStart + 1;
                        // }
                        // data: null,
                        // render: function(data, type, row, meta) {
                        //     return `<a href="#" onclick="detail(${row.id})">${row.kode}</a>`;
                        // }
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'kdasuransi',
                        name: 'kdasuransi',
                    },
                    {
                        data: 'harga',
                        name: 'harga',
                        render: function(data, type, row, meta) {
                            return meta.settings.fnFormatNumber(row.harga);
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            return `<a href="#${row.id}"><button onclick="edittasklisttipe_grd(${row.id})" class='btn btn-sm btn-warning' href='javascript:void(0)' <?= $edit == 1 ? '' : 'disabled' ?>><i class='fa fa-edit'></i></button></a>
                            <a href="#${row.id},${row.kode}"><button onclick="hapusdetail(${row.id})" class='btn btn-sm btn-danger' href='javascript:void(0)' <?= $hapus == 1 ? '' : 'disabled' ?>><i class='fa fa-trash'></i></button></a>`;
                        }
                    },
                ]
            });
        });
    }


    $('.formtasklisttipe_grd').submit(function(e) {
        const form = $(this)
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: form.serialize(),
            dataType: "json",
            method: "POST",
            beforeSend: function() {
                $('.btnsimpan').attr('disable', 'disabled')
                $('.btnsimpan').html('<i class="fa fa-spin fa-spinner"></i>')
                form.find('.invalid-feedback').remove()
                form.find('.is-invalid').removeClass('is-invalid')
            },
            complete: function() {
                $('.btnsimpan').removeAttr('disable')
                $('.btnsimpan').html('Simpan')
            },
            success: function(response) {
                console.log(response);
                if (response.error) {
                    if (response.error.kodejasa) {
                        $('#kodejasa').addClass('is-invalid');
                        $('.errorkodejasa').html(response.error.kodejasa);
                    } else {
                        $('.errorkodejasa').fadeOut();
                        $('#kodejasa').removeClass('is-invalid');
                        $('#kodejasa').addClass('is-valid');
                    }
                    if (response.error.nama) {
                        $('#namajasa').addClass('is-invalid');
                        $('.errornamajasa').html(response.error.namajasa);
                    } else {
                        $('.errornamajasa').fadeOut();
                        $('#namajasa').removeClass('is-invalid');
                        $('#namajasa').addClass('is-valid');
                    }
                } else {
                    if (response.sukses == false) {
                        toastr.error(
                            'Data gagal di simpan, barang sudah pernah di input')
                    } else {
                        document.getElementById('kode').value = ""
                        document.getElementById('nama').value = ""
                        document.getElementById('harga').value = "0"
                        toastr.info('Data berhasil di simpan, silahkan melanjutkan')
                    }
                    reload_table_tasklisttipe_grd()
                }
            },
            // error: function(xhr, ajaxOptions, thrownError) {
            //     alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            // }
            error: function(xhr, ajaxOptions, thrownError) {
                // console.log(xhr)
                const errors = xhr.responseJSON?.errors
                // console.log(errors);
                if (errors) {
                    let i = 0;
                    for ([key, message] of Object.entries(errors)) {
                        i++;
                        if (i == 1) {
                            form.find(`[name="${key}"]`).focus()
                        }
                        console.log(key, message);
                        form.find(`[name="${key}"]`)
                            .addClass('is-invalid')
                            .parent()
                            .append(`<div class="invalid-feedback">${message}</div>`)
                    }
                }

                // console.log(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }

        });
        return false;
    })

    // function proses_salin_tasklist(id) {
    $('#proses_salin_tasklist_grd').click(function(e) {
        var kdtasklist_salin = document.getElementById('kdtasklist_salin').value
        var kdasuransi_salin = document.getElementById('kdasuransi_salin').value
        var kdasuransi = document.getElementById('kdasuransi').value
        var kdtasklist = document.getElementById('kdtasklist').value
        swal({
                title: "Yakin akan proses salin " + kdtasklist_salin + " ?",
                text: "",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: `{{ url('salintasklisttipe_grd') }}`,
                        type: "POST",
                        data: {
                            kdtasklist_salin: kdtasklist_salin,
                            kdasuransi_salin: kdasuransi_salin,
                            kdasuransi: kdasuransi,
                            kdtasklist: kdtasklist,
                            // _method: "DELETE",
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
                                toastr.error('Proses gagal')
                            } else {
                                // swal({
                                //     title: "Data berhasil dihapus! ",
                                //     text: "",
                                //     icon: "success"
                                // })
                                reload_table_tasklisttipe_grd()
                                toastr.info('Proses berhasil, silahkan melanjutkan')
                                // .then(function() {
                                //     window.location.href = '/tasklisttipe_gr';
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
    })

    function hapusdetail(id) {
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
                        url: `{{ url('tasklisttipe_grd') }}/${id}`,
                        type: "POST",
                        data: {
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
                                toastr.error('Data gagal dihapus silahkan melanjutkan')
                            } else {
                                // swal({
                                //     title: "Data berhasil dihapus! ",
                                //     text: "",
                                //     icon: "success"
                                // })
                                reload_table_tasklisttipe_grd()
                                toastr.info('Data berhasil dihapus, silahkan melanjutkan')
                                // .then(function() {
                                //     window.location.href = '/tasklisttipe_gr';
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

    $('#caritasklist_salin').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= url('caritltipebp') ?>",
            dataType: "json",
            success: function(response) {
                $('#modalcaritltipebp').html(response.body)
                $('#modalcaritltipebp').modal('show');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })
    $('#kdtasklist_salin').on('blur', function(e) {
        let cari = $(this).val()
        // if (cari !== "") {
        $.ajax({
            url: "<?= url('repltltipebp') ?>",
            type: 'get',
            data: {
                'kode': cari
            },
            success: function(data) {
                let data_response = JSON.parse(data);
                if (data_response['kdtasklist_salin'] == '') {
                    $('#kdtasklist_salin').val('');
                    $('#nmtasklist_salin').val('');
                    $('#kdasuransi_salin').val('');
                    $('#nmasuransi_salin').val('');
                    return;
                } else {
                    $('#kdtasklist_salin').val(data_response['kdtasklist_salin']);
                    $('#nmtasklist_salin').val(data_response['nmtasklist_salin']);
                    $('#kdasuransi_salin').val(data_response['kdasuransi_salin']);
                    $('#nmasuransi_salin').val(data_response['nmasuransi_salin']);
                }
            },
            error: function() {
                $('#kdtasklist_salin').val('');
                $('#nmtasklist_salin').val('');
                $('#kdasuransi_salin').val('');
                $('#nmasuransi_salin').val('');
                return;
                // console.log('file not fount');
            }
        })
        // console.log(cari);
        // }
    })

    $('#caritlbp').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= url('caritlbp') ?>",
            dataType: "json",
            success: function(response) {
                $('#modalcaritlbp').html(response.body)
                $('#modalcaritlbp').modal('show');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })
    $('#kode').on('blur', function(e) {
        let cari = $(this).val()
        // if (cari !== "") {
        $.ajax({
            url: "<?= url('repltlbp') ?>",
            type: 'get',
            data: {
                'kode': cari
            },
            success: function(data) {
                let data_response = JSON.parse(data);
                if (data_response['kodejasa'] == '') {
                    $('#kode').val('');
                    $('#nama').val('');
                    $('#harga').val('0');
                    return;
                } else {
                    $('#kode').val(data_response['kode']);
                    $('#nama').val(data_response['nama']);
                    $('#harga').val(data_response['harga']);
                }
            },
            error: function() {
                $('#kode').val('');
                $('#nama').val('');
                $('#harga').val('0');
                return;
                // console.log('file not fount');
            }
        })
        // console.log(cari);
        // }
    })

    function edittasklisttipe_grd(id) {
        $.ajax({
            type: "get",
            // url: `{{ url('tasklisttipe_gr_detail') }}/${id}`,
            url: `{{ url('edittasklisttipe_grd') }}`,
            dataType: "json",
            data: {
                id: id,
                _method: "GET",
                _token: '{{ csrf_token() }}',
            },
            success: function(response) {
                if (response.data) {
                    // console.log(response.data);
                    $('#modaleditdetail').html(response.body);
                    $('#modaleditdetail').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    }
</script>
