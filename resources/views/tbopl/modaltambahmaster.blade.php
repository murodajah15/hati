<?php
$session = session();
// var_dump($vdata);
$tambahtbsupplier = $tambahtbsupplier->tambah;

?>
<!-- Modal -->
<div class="modal-dialog" style="max-width: 50%;">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">
                {{ $vdata['title'] }}
                {{-- @if (isset($vdata))
                    {{ $vdata['title'] }}
                @endif --}}
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <!-- Way 1: Display All Error Messages -->
        {{-- //submitnya gak pakai ajax --}}
        {{-- @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}
        <form action="{{ $action }}" method="post" class="formtbopl">
            @csrf
            @if ($tbopl->id)
                @method('put')
            @endif
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" class="form-control-sm" name="username" id="username"
                            value="{{ $session->get('username') }}">
                        <input type="hidden" class="form-control-sm" name="kodelama" id="kodelama"
                            value="{{ $tbopl->kode }}">
                        <div class="col-md-12">
                            <label for="kode" class="label mb-1">Kode</label>
                            <input type="text" class="form-control form-control-sm mt-1" name="kode"
                                id="kode" value="{{ $tbopl->kode }}"
                                {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}
                                {{ str_contains($vdata['title'], 'Detail') ? '' : 'autofocus' }}>
                        </div>
                        <div class="col-md-12">
                            <label for="nama" class="label mb-1">Nama</label>
                            <input type="text" class="form-control form-control-sm mb-2" name="nama"
                                id="nama" value="{{ $tbopl->nama }}"
                                {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                        </div>
                        <div class="col-md-12">
                            <div class="input-group mb-2">
                                <input type="text" name="kdsupplier" id="kdsupplier" style="width:3em;"
                                    class="form-control form-control-sm" placeholder="Supplier" aria-label="Supplier"
                                    value="{{ $tbopl->kdsupplier }}"
                                    {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                <input type="text" name="nmsupplier" id="nmsupplier" style="width:20em;"
                                    class="form-control form-control-sm"
                                    value="{{ isset($tbsupplier->nama) ? $tbsupplier->nama : '' }}" readonly>
                                <button class="btn btn-outline-secondary btn-sm" type="button" id="carisupplier"
                                    {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}><i
                                        class="fa fa-search"></i></button>
                                <button class="btn btn-outline-primary btn-sm tambahtbsupplier" type="button"
                                    <?= $tambahtbsupplier == 1 ? (str_contains($vdata['title'], 'Detail') ? 'disabled' : '') : 'disabled' ?>><i
                                        class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="harga_jual" class="label mb-1">Harga Jual</label>
                            <input type="number" class="form-control form-control-sm" name="harga_jual" id="harga_jual"
                                style="text-align:right" step="any" value="{{ $tbopl->harga_jual }}"
                                {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                        </div>
                        <div class="col-md-12">
                            <label for="harga_beli" class="label mb-1">Harga Beli</label>
                            <input type="number" class="form-control form-control-sm" name="harga_beli" id="harga_beli"
                                style="text-align:right" step="any" value="{{ $tbopl->harga_beli }}"
                                {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                        </div>
                        <div class="col-md-12 mb-0">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="aktif" name="aktif"
                                    {{ (str_contains($vdata['title'], 'Tambah') ? 'checked' : $tbopl->aktif == 'Y') ? 'checked' : '' }}
                                    {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}>
                                <label class="aktif" for="flexCheckDefault">
                                    Aktif
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="row"> --}}
                <?php
                    if (strpos($vdata['title'], 'Tambah') !== false) {
                    } else {
                    ?>
                <div class="col-md-12">
                    <label for="nama" class="label mb-1 mt-3">User</label>
                    <input type="text" class="form-control form-control-sm" name="user" id="user"
                        value="{{ $tbopl->user }}" readonly>
                </div> <?php } ?>
                <div class="modal-footer">
                    @if (str_contains($vdata['title'], 'Detail'))
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    @else
                        <button type="submit" id="btnsimpan" class="btn btn-primary btnsimpan">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    @endif
                </div>
            </div>
            {{-- </div> --}}
        </form>
    </div>
</div>


<script>
    var myModal = document.getElementById('modaltambahmaster')
    var myInput = document.getElementById('kode')
    // myModal.addEventListener('shown.bs.modal', function() {
    //     myInput.focus()
    // })
    $(myModal).on('shown.bs.modal', function() {
        $(this).find(myInput).focus();
    });

    $(document).ready(function() {
        $('.formtbopl').submit(function(e) {
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
                    // console.log(response);
                    if (response.error) {
                        if (response.error.kode) {
                            $('#kode').addClass('is-invalid');
                            $('.errorKode').html(response.error.kode);
                        } else {
                            $('.errorKode').fadeOut();
                            $('#kode').removeClass('is-invalid');
                            $('#kode').addClass('is-valid');
                        }
                        if (response.error.nama) {
                            $('#nama').addClass('is-invalid');
                            $('.errorNama').html(response.error.nama);
                        } else {
                            $('.errorNama').fadeOut();
                            $('#nama').removeClass('is-invalid');
                            $('#nama').addClass('is-valid');
                        }
                    } else {
                        $('#modaltambahmaster').modal('hide');
                        // swal({
                        //     title: "Data berhasil disimpann",
                        //     text: "",
                        //     icon: "success",
                        //     buttons: true,
                        //     dangerMode: true,
                        // })
                        // swal({
                        //     title: response.sukses,
                        //     // title: 'Sukses',
                        //     text: "Silahkan dilanjutkan",
                        //     icon: "success",
                        // })
                        reload_table();
                        toastr.info('Data berhasil di simpan, silahkan melanjutkan')
                        // .then(function() {
                        //     window.location.href = '/tbopl';
                        // });
                        // window.location = '/tbopl';
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
    });

    $('.tambahtbsupplier').click(function(e) {
        e.preventDefault();
        $.ajax({
            // url: "<?= url('tbopl/tambahtbsupplier') ?>",
            // url: "<?= url('tbsupplier/modaltambah') ?>",
            url: `{{ route('tbsupplier.create') }}`,
            dataType: "json",
            success: function(response) {
                $('#modaltambah').html(response.body)
                $('#modaltambah').modal('show');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })

    // var carikdsupplier = $("#kdsuppliere").val();
    // $.ajax({
    //     url: "<?= url('ambildatatbsupplier') ?>",
    //     dataType: "json",
    //     data: {
    //         'kdsupplier': carikdsupplier
    //     },
    //     success: function(response) {
    //         if (response.data) {
    //             $('#kdsupplier').html(response.data);
    //         }
    //     },
    //     error: function(xhr, ajaxOptions, thrownError) {
    //         alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
    //     }
    // })

    // // tampildatatbsupplier();
    // $('#kdsupplier').focusin(function(e) {
    //     $.ajax({
    //         url: "<?= url('ambildatatbsupplier') ?>",
    //         dataType: "json",
    //         success: function(response) {
    //             if (response.data) {
    //                 $('#kdsupplier').html(response.data);
    //             }
    //         },
    //         error: function(xhr, ajaxOptions, thrownError) {
    //             alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
    //         }
    //     })
    // });

    $('#carisupplier').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= url('carisupplier') ?>",
            dataType: "json",
            success: function(response) {
                $('#modalcarisupplier').html(response.body)
                $('#modalcarisupplier').modal('show');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })
    $('#kdsupplier').on('blur', function(e) {
        let cari = $(this).val()
        if (cari !== "") {
            $.ajax({
                url: "<?= url('replsupplier') ?>",
                type: 'get',
                data: {
                    'kode': cari
                },
                success: function(data) {
                    let data_response = JSON.parse(data);
                    if (data_response['kdsupplier'] == '') {
                        $('#kdsupplier').val('');
                        $('#nmsupplier').val('');
                        return;
                    } else {
                        $('#kdsupplier').val(data_response['kdsupplier']);
                        $('#nmsupplier').val(data_response['nmsupplier']);
                    }
                },
                error: function() {
                    $('#kdsupplier').val('');
                    $('#nmsupplier').val('');
                    return;
                    // console.log('file not fount');
                }
            })
            // console.log(cari);
        }
    })
</script>
