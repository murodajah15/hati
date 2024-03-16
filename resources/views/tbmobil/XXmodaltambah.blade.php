<?php
$session = session();
// var_dump($vdata);
?>
<!-- Modal -->
<div class="modal-dialog" style="max-width: 80%;">
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
        <form action="{{ $action }}" method="post" class="formtbmobil">
            @csrf
            @if ($tbmobil->id)
                @method('put')
            @endif
            <div class="modal-body">
                <input type="hidden" class="form-control-sm" name="username" id="username"
                    value="{{ $session->get('username') }}">
                <input type="hidden" class="form-control-sm" name="kodelama" id="kodelama"
                    value="{{ $tbmobil->nopolisi }}">
                <div class="row">
                    <div class='col-md-6'>
                        <table style=font-size:12px; class='table table-borderless table-sm table-hover'>
                            <tr>
                                <td>Nomor Polisi</td>
                                <td><input type="text" class='form-control form-control-sm' id='nopolisi'
                                        name='nopolisi' size='50' autocomplete='off'
                                        value="{{ $tbmobil->nopolisi }}"
                                        {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                </td>
                            </tr>
                            <tr>
                                <td>Nomor Rangka</td>
                                <td><input type="text" class='form-control form-control-sm' id='norangka'
                                        name='norangka' size='50' autocomplete='off'
                                        value="{{ $tbmobil->norangka }}"
                                        {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                </td>
                            </tr>
                            <tr>
                                <td>Nomor Mesin</td>
                                <td><input type="text" class='form-control form-control-sm' id='nomesin'
                                        name='nomesin' size='50' autocomplete='off' value="{{ $tbmobil->nomesin }}"
                                        {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                </td>
                            </tr>
                            <tr>
                                <td>Merek</td>
                                <td>
                                    <select id='kdmerek' name='kdmerek' class='form-control form-control-sm'
                                        style='width: 200x;'
                                        {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}>
                                        <option value="">[Pilih Merek]
                                            <?php
                                            foreach ($tbmerek as $key) {
                                                if ($key['kode'] == $tbmobil['kdmerek']) {
                                                    echo "<option value='$key[kode]' selected>$key[nama]</option>";
                                                } else {
                                                    echo "<option value='$key[kode]'>$key[nama]</option>";
                                                }
                                            }
                                            ?>
                                        </option>
                                </td>
                            </tr>
                            <tr>
                                <td>Jenis</td>
                                <td>
                                    <select id='kdjenis' name='kdjenis' class='form-control form-control-sm'
                                        style='width: 200x;'
                                        {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}>
                                        <option value="">[Pilih Jenis]
                                            <?php
                                            foreach ($tbjenis as $key) {
                                                if ($key['kode'] == $tbmobil['kdjenis']) {
                                                    echo "<option value='$key[kode]' selected>$key[nama]</option>";
                                                } else {
                                                    echo "<option value='$key[kode]'>$key[nama]</option>";
                                                }
                                            }
                                            ?>
                                        </option>
                                </td>
                            </tr>
                            <tr>
                                <td>Model</td>
                                <td>
                                    <select id='kdmodel' name='kdmodel' class='form-control form-control-sm'
                                        style='width: 200x;'
                                        {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}>
                                        <option value="">[Pilih Model]
                                            <?php
                                            foreach ($tbmodel as $key) {
                                                if ($key['kode'] == $tbmobil['kdmodel']) {
                                                    echo "<option value='$key[kode]' selected>$key[nama]</option>";
                                                } else {
                                                    echo "<option value='$key[kode]'>$key[nama]</option>";
                                                }
                                            }
                                            ?>
                                        </option>
                                </td>
                            </tr>
                            <tr>
                                <td>Tipe</td>
                                <td>
                                    <select id='kdtipe' name='kdtipe' class='form-control form-control-sm'
                                        style='width: 200x;'
                                        {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}>
                                        <option value="">[Pilih Tipe]
                                            <?php
                                            foreach ($tbtipe as $key) {
                                                if ($key['kode'] == $tbmobil['kdtipe']) {
                                                    echo "<option value='$key[kode]' selected>$key[nama]</option>";
                                                } else {
                                                    echo "<option value='$key[kode]'>$key[nama]</option>";
                                                }
                                            }
                                            ?>
                                        </option>
                                </td>
                            </tr>
                            <tr>
                                <td>Warna</td>
                                <td>
                                    <select id='kdwarna' name='kdwarna' class='form-control form-control-sm'
                                        style='width: 200x;'
                                        {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}>
                                        <option value="">[Pilih Warna]
                                            <?php
                                            foreach ($tbwarna as $key) {
                                                if ($key['kode'] == $tbmobil['kdwarna']) {
                                                    echo "<option value='$key[kode]' selected>$key[nama]</option>";
                                                } else {
                                                    echo "<option value='$key[kode]'>$key[nama]</option>";
                                                }
                                            }
                                            ?>
                                        </option>
                                </td>
                            </tr>
                            <tr>
                                <td>Tahun</td>
                                <td><input type="number" class='form-control form-control-sm' id='tahun'
                                        name='tahun' autocomplete='off' value="{{ $tbmobil->tahun }}"
                                        {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                </td>
                            </tr>
                            <tr>
                                <td>Nomor & Tanggal STNK</td>
                                <td>
                                    <div class="input-group">
                                        <input type="text" class='form-control form-control-sm' id='nostnk'
                                            name='nostnk' style="width:12em;" autocomplete='off'
                                            value="{{ $tbmobil->nostnk }}"
                                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                        <input type="date" class='form-control form-control-sm' id='tglstnk'
                                            name='tglstnk' style="width:7em;" autocomplete='off'
                                            value="{{ $tbmobil->tglstnk }}"
                                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Bahan Bakar</td>
                                <td><input type="text" class='form-control form-control-sm' id='bahanbakar'
                                        name='bahanbakar' size='50' autocomplete='off'
                                        value="{{ $tbmobil->bahanbakar }}"
                                        {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                </td>
                            </tr>
                            <tr>
                                <td>Dealer Penjualan</td>
                                <td><input type="text" class='form-control form-control-sm' id='dealerjual'
                                        name='dealerjual' size='50' autocomplete='off'
                                        value="{{ $tbmobil->dealerjual }}"
                                        {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class='col-md-6'>
                        <table style=font-size:12px; class='table table-borderless table-sm table-hover'>
                            <tr>
                                <td><button class="btn btn-flat btn-primary btn-sm mt-2 mb-2 tomboltambahcustomer"
                                        type="button"
                                        {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}><i
                                            class="fa fa-plus"></i>
                                        Customer</button></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Pemilik</td>
                                <td>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control form-control-sm"
                                            placeholder="Pemilik" name="kdpemilik" id="kdpemilik"
                                            value="{{ $tbmobil->kdpemilik }}"
                                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                        <button class="btn btn-outline-secondary btn-sm" type="button"
                                            id="caripemilik" onclick='caripemilik_()'
                                            {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}><i
                                                class="fa fa-search"></i></button>
                                        <input type="text" class="form-control form-control-sm" name="nmpemilik"
                                            id="nmpemilik" style="width: 40%" value="{{ $tbmobil->nmpemilik }}"
                                            readonly>
                                        {{-- <input type="hidden" class="form-control" name="npwp" id="npwp"
                                            value="{{ $tbmobil->npwp }}" readonly>
                                        <input type="hidden" class="form-control" name="contact_person"
                                            id="contact_person" readonly>
                                        <input type="hidden" class="form-control" name="no_contact_person"
                                            id="no_contact_person" value="{{ $tbmobil->no_contact_person }}"
                                            readonly> --}}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Pemakai</td>
                                <td>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control form-control-sm"
                                            placeholder="Pemakai" name="kdpemakai" id="kdpemakai"
                                            value="{{ $tbmobil->kdpemakai }}"
                                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                        <button class="btn btn-outline-secondary btn-sm" type="button"
                                            id="caripemakai" onclick='caripemakai_()'
                                            {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}><i
                                                class="fa fa-search"></i></button>
                                        <input type="text" style="width: 40%" class="form-control form-control-sm"
                                            name="nmpemakai" id="nmpemakai" value="{{ $tbmobil->nmpemakai }}"
                                            readonly>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>NPWP</td>
                                <td><input type="text" class='form-control form-control-sm' id='npwp'
                                        name='npwp' size='50' autocomplete='off'
                                        value="{{ $tbmobil->npwp }}"
                                        {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                </td>
                            </tr>
                            <tr>
                                <td>Contact Person</td>
                                <td><input type="text" class='form-control form-control-sm' id='contact_person'
                                        name='contact_person' size='50' autocomplete='off'
                                        value="{{ $tbmobil->contact_person }}"
                                        {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                </td>
                            </tr>
                            <tr>
                                <td>Nomor CP</td>
                                <td><input type="text" class='form-control form-control-sm' id='no_contact_person'
                                        name='no_contact_person' size='50' autocomplete='off'
                                        value="{{ $tbmobil->no_contact_person }}"
                                        {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                </td>
                            </tr>
                            <tr>
                                <td>Asuransi</td>
                                <td>
                                    <div class="input-group mb-1">
                                        <input type="text" class="form-control form-control-sm" name="kdasuransi"
                                            id="kdasuransi" value="{{ $tbmobil->kdasuransi }}"
                                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                        <button class="btn btn-outline-secondary btn-sm" type="button"
                                            id="cariasuransi" onclick='cariasuransi_()'
                                            {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}><i
                                                class="fa fa-search"></i></button>
                                        <input type="text" style="width: 40%" class="form-control form-control-sm"
                                            name="nmasuransi" id="nmasuransi" value="{{ $tbmobil->nmasuransi }}"
                                            readonly>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Nomor Polis</td>
                                <td><input type="text" class='form-control form-control-sm' id='no_polis'
                                        name='no_polis' size='50' autocomplete='off'
                                        value="{{ $tbmobil->no_polis }}"
                                        {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                </td>
                            </tr>
                            <tr>
                                <td>Nama Polis</td>
                                <td><input type="text" class='form-control form-control-sm' id='nama_polis'
                                        name='nama_polis' size='50' autocomplete='off'
                                        value="{{ $tbmobil->nama_polis }}"
                                        {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                </td>
                            </tr>
                            <tr>
                                <td>Tgl. Akhir Polis</td>
                                <td><input type="date" class='form-control form-control-sm' id='tgl_akhir_polis'
                                        name='tgl_akhir_polis' size='50' autocomplete='off'
                                        value="{{ $tbmobil->tgl_akhir_polis }}"
                                        {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                </td>
                            </tr>
                            {{-- <tr>
                                <td>Alamat Asuransi</td>
                                <td>
                                    <textarea class="form-control" name="alamat_asuransi" id="alamat_asuransi" rows="2" readonly></textarea>
                                </td>
                            </tr> --}}
                        </table>
                    </div>
                </div>
                <?php
                if (strpos($vdata['title'], 'Tambah') !== false) {
                } else {
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <label for="nama" class="form-label mb-1 mt-1">User</label>
                        <input type="text" class="form-control form-control-sm" name="user" id="user"
                            value="{{ $tbmobil->user }}" readonly>
                    </div> <?php } ?>
                </div>
                <div class="modal-footer">
                    @if (str_contains($vdata['title'], 'Detail'))
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    @else
                        <button type="submit" id="btnsimpan" class="btn btn-primary btnsimpan">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    var myModal = document.getElementById('modaltambah')
    var myInput = document.getElementById('kode')
    // myModal.addEventListener('shown.bs.modal', function() {
    //     myInput.focus()
    // })
    $(myModal).on('shown.bs.modal', function() {
        $(this).find(myInput).focus();
    });

    $(document).ready(function() {
        $('.formtbmobil').submit(function(e) {
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
                        $('#modaltambah').modal('hide');
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
                        //     window.location.href = '/tbmobil';
                        // });
                        // window.location = '/tbmobil';
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

    $('.tomboltambahcustomer').on('click', function(e) {
        $.ajax({
            method: "GET",
            url: "tambahcustomer",
            dataType: "json",
            success: function(response) {
                $('#modaltambah').html(response.body)
                $("#modaltambah").modal('show');
            }
        })
    })

    // Nampilin list data pilihan ===================
    function caripemilik_() {
        $.ajax({
            method: "GET",
            url: "caripemilik",
            dataType: "json",
            success: function(response) {
                $('#modalcaripemilik').html(response.body)
                $("#modalcaripemilik").modal('show');
            }
        })
    }
    $('#kdpemilik').on('blur', function(e) {
        let cari = $(this).val();
        $.ajax({
            url: 'replpemilik',
            type: 'get',
            data: {
                kode: cari
            },
            success: function(response) {
                let data_response = JSON.parse(response);
                // alert(data_response.kdpemilik)
                if (data_response.kdpemilik === "") {
                    $('#kdpemilik').val('');
                    $('#nmpemilik').val('');
                    // caripemilik();
                    return;
                }
                $('#kdpemilik').val(data_response['kdpemilik']);
                $('#nmpemilik').val(data_response['nmpemilik']);
            },
            error: function() {
                console.log('file not fount');
            }
        })
        // console.log(cari);
    })

    // Nampilin list data pilihan ===================
    function caripemakai_() {
        $.ajax({
            method: "GET",
            url: "caripemakai",
            dataType: "json",
            success: function(response) {
                $('#modalcaripemakai').html(response.body)
                $("#modalcaripemakai").modal('show');
            }
        })
    }
    $('#kdpemakai').on('blur', function(e) {
        let cari = $(this).val();
        $.ajax({
            url: 'replpemakai',
            type: 'get',
            data: {
                kode: cari
            },
            success: function(response) {
                let data_response = JSON.parse(response);
                // alert(data_response.kdpemakai)
                if (data_response.kdpemakai === "") {
                    $('#kdpemakai').val('');
                    $('#nmpemakai').val('');
                    // caripemakai();
                    return;
                }
                $('#kdpemakai').val(data_response['kdpemakai']);
                $('#nmpemakai').val(data_response['nmpemakai']);
            },
            error: function() {
                console.log('file not fount');
            }
        })
        // console.log(cari);
    })

    // Nampilin list data pilihan ===================
    function cariasuransi_() {
        $.ajax({
            method: "GET",
            url: "cariasuransi",
            dataType: "json",
            success: function(response) {
                $('#modalcariasuransi').html(response.body)
                $("#modalcariasuransi").modal('show');
            }
        })
    }
    $('#kdasuransi').on('blur', function(e) {
        let cari = $(this).val();
        $.ajax({
            url: 'replasuransi',
            type: 'get',
            data: {
                kode: cari
            },
            success: function(response) {
                let data_response = JSON.parse(response);
                if (data_response.kode_asuransi === "") {
                    $('#kdasuransi').val('');
                    $('#nmasuransi').val('');
                    // cariasuransi();
                    return;
                }
                $('#kdasuransi').val(data_response['kdasuransi']);
                $('#nmasuransi').val(data_response['nmasuransi']);
            },
            error: function() {
                console.log('file not fount');
            }
        })
        // console.log(cari);
    })
</script>
