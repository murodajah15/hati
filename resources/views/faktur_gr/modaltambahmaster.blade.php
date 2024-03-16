<?php
$session = session();
// var_dump($vdata);
?>
<!-- Modal -->
<div class="modal-dialog" style="max-width: 95%;">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">
                {{ $vdata['title'] }}{{ str_contains($vdata['title'], 'Edit') ? $faktur_gr->nopolisi : '' }}
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
            <form action={{ $action }} method="post" class="formtambahfaktur">
                @csrf
                @if ($faktur_gr->id)
                    @method('put')
                @endif
                <input type="hidden" class="form-control form-control-sm" name="id" id="id"
                    value={{ $faktur_gr->id }}>
                <div class="row mb-2 mt-0">
                    <div class="col-12 col-sm-6">
                        <?php
                        date_default_timezone_set('Asia/Jakarta');
                        $tglfaktur = date('Y-m-d H:i:s');
                        ?>
                        <label for="nama" class="form-label mb-1">No. Faktur / Tanggal (M-D-Y)</label>
                        <div class="input-group mb-1">
                            <input type='text' style="width:4%;" class='form-control form-control-sm mb-2'
                                value="{{ str_contains($vdata['title'], 'Tambah') ? 'AUTO GENERATE' : $faktur_gr->nofaktur }}"
                                style="width: 5%" id='nofaktur'
                                {{ str_contains($vdata['title'], 'Edit') ? 'name=nofaktur' : '' }} readonly>
                            <input type="datetime-local" class='form-control form-control-sm mb-2' name='tanggal'
                                id='tanggal'
                                value="{{ str_contains($vdata['title'], 'Tambah') ? $tglfaktur : $faktur_gr->tanggal }}"
                                style="width: 55%" readonly>
                        </div>
                        <label for="nama" class="form-label mb-1">No. WO / Tanggal (M-D-Y)</label>
                        <div class="input-group mb-2">
                            <input type="text" style="width:4%;" name="nowo" id="nowo"
                                value="<?= $faktur_gr['nowo'] ?>" class="form-control form-control-sm"
                                {{ str_contains($vdata['title'], 'Tambah') ? '' : 'readonly' }}>
                            <input type="text" style="width:50%;" name="tglwo" id="tglwo"
                                value="<?= $faktur_gr['tglwo'] ?>" class="form-control form-control-sm" readonly>
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="cariwo_gr"
                                {{ str_contains($vdata['title'], 'Tambah') ? '' : 'disabled' }}><i
                                    class="fa fa-search"></i></button>
                            <!-- <button class="btn btn-outline-primary tambahtbsa" type="button"><i class="fa fa-plus"></i></button> -->
                        </div>
                        <label for="nama" class="form-label mb-0">No. Polisi</label>
                        <div class="input-group mb-1">
                            <input type="text" class="form-control form-control-sm" placeholder="No. Polisi"
                                name="nopolisi" id="nopolisi" value="<?= $faktur_gr['nopolisi'] ?>" readonly>
                            <input type="text" style="width:55%;" class="form-control form-control-sm"
                                name="norangka" id="norangka" value="<?= $faktur_gr['norangka'] ?>" readonly>
                        </div>
                        <label for="nama" class="form-label mb-1">Customer</label>
                        <div class="input-group mb-1">
                            <input type="text" style="width:4%;" class="form-control form-control-sm mb-2"
                                name="kdpemilik" id="kdpemilik" readonly style="width: 5%"
                                value="<?= $faktur_gr['kdpemilik'] ?>">
                            <input type="text" style="width:55%;" class="form-control form-control-sm mb-2"
                                name="nmpemilik" id="nmpemilik" readonly style="width: 40%"
                                value="<?= $faktur_gr['nmpemilik'] ?>">
                        </div>
                        <div class="invalid-feedback errornmpemilik">
                        </div>
                        <label for="nama" class="form-label mb-1">Jenis Service / Kilo Meter</label>
                        <div class="input-group mb-2">
                            <select id='kdservice' name='kdservice' style="width:10%;"
                                class="form-control form-control-sm" autofocus='autofocus' required
                                {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}>
                                <option value=''>- PILIH JENIS SERVICE -</option>
                                {{-- <option value='PM'>PM</option>
                                <option value='GR'>GR</option>
                                <option value='PM+GR'>PM+GR</option>
                                <option value='LAIN-LAIN'>LAIN-LAIN</option> --}}
                                <?php
                                $arrkdservice = ['PM', 'GR', 'PM+GR', 'LAIN-LAIN'];
                                $jml_kata = count($arrkdservice);
                                for ($c = 0; $c < $jml_kata; $c += 1) {
                                    if ($arrkdservice[$c] == $faktur_gr->kdservice) {
                                        echo "<option value='$arrkdservice[$c]' selected>$arrkdservice[$c] </option>";
                                    } else {
                                        echo "<option value='$arrkdservice[$c]'> $arrkdservice[$c] </option>";
                                    }
                                }
                                echo '</select>';
                                ?>
                            </select>
                            <input type="number" style="width:50%;" class="form-control form-control-sm"
                                name="km" placeholder="KM" value="<?= $faktur_gr['km'] ?>"
                                {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                            <div class="invalid-feedback errorKdservice">
                            </div>
                        </div>
                        <?php
                        // foreach ($tbpaket as $key) {
                        //   echo "<option value=$key[kode]>$key[kode] - $key[nama]</option>";
                        // }
                        ?>
                        <!-- </select> -->
                        <label for="nama" class="form-label mb-1">Aktifitas / Fasilitas / Status Tunggu</label>
                        <div class="input-group mb-2">
                            <select id='aktifitas' name='aktifitas' class="form-control form-control-sm"
                                autofocus='autofocus' {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}>
                                <option value=''>- PILIH AKTIFITAS -</option>
                                {{-- <option value='Workshop'>Workshop</option>
                                <option value='Moving Service'>Moving Service</option>
                                <option value='Emergency Service (SRA)'>Emergency Service (SRA)</option>
                                <option value='Home Service'>Home Service</option>
                                <option value='Flat Service'>Flat Service</option>
                                <option value='Service Point'>Service Point</option> --}}
                                <?php
                                $arraktifitas = ['Moving Service', 'Emergency Service (SRA)', 'Home Service', 'Flat Service', 'Service Point'];
                                $jml_kata = count($arraktifitas);
                                for ($c = 0; $c < $jml_kata; $c += 1) {
                                    if ($arraktifitas[$c] == $faktur_gr->aktifitas) {
                                        echo "<option value='$arraktifitas[$c]' selected>$arraktifitas[$c] </option>";
                                    } else {
                                        echo "<option value='$arraktifitas[$c]'> $arraktifitas[$c] </option>";
                                    }
                                }
                                echo '</select>';
                                ?>
                            </select>
                            <select id='fasilitas' name='fasilitas' class="form-control form-control-sm"
                                style='width: 200x;' autofocus='autofocus'
                                {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}>
                                <option value=''>- PILIH FASILITAS -</option>
                                {{-- <option value='Service Car'>Service Car</option>
                                <option value='Service Motorcycle'>Service Motorcycle</option> --}}
                                <?php
                                $arrfasilitas = ['Service Car', 'Service Motorcycle'];
                                $jml_kata = count($arrfasilitas);
                                for ($c = 0; $c < $jml_kata; $c += 1) {
                                    if ($arrfasilitas[$c] == $faktur_gr->fasilitas) {
                                        echo "<option value='$arrfasilitas[$c]' selected>$arrfasilitas[$c] </option>";
                                    } else {
                                        echo "<option value='$arrfasilitas[$c]'> $arrfasilitas[$c] </option>";
                                    }
                                }
                                echo '</select>';
                                ?>
                            </select>
                            <select id='status_tunggu' name='status_tunggu' class="form-control form-control-sm"
                                style='width: 200x;' autofocus='autofocus'
                                {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}>
                                <option value=''>- PILIH STATUS TUNGGU -</option>
                                {{-- <option value='Tunggu'>Tunggu</option>
                                <option value='Tinggal'>Tinggal</option>
                                <option value='Menginap'>Menginap</option> --}}
                                <?php
                                $arrstatus_tunggu = ['Tunggu', 'Tinggal', 'Menginap'];
                                $jml_kata = count($arrstatus_tunggu);
                                for ($c = 0; $c < $jml_kata; $c += 1) {
                                    if ($arrstatus_tunggu[$c] == $faktur_gr->status_tunggu) {
                                        echo "<option value='$arrstatus_tunggu[$c]' selected>$arrstatus_tunggu[$c] </option>";
                                    } else {
                                        echo "<option value='$arrstatus_tunggu[$c]'> $arrstatus_tunggu[$c] </option>";
                                    }
                                }
                                echo '</select>';
                                ?>
                            </select>
                        </div>
                        <label for="nama" class="form-label mb-1">Interval Reminder / Via</label>
                        <div class="input-group mb-2">
                            <select id='int_reminder' name='int_reminder' class="form-control form-control-sm"
                                autofocus='autofocus' {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}>
                                <option value=''>- PILIH INTERVAL REMINDER -</option>
                                {{-- <option value='01 Bulan'>01 Bulan</option>
                                <option value='02 Bulan'>02 Bulan</option>
                                <option value='03 Bulan'>03 Bulan</option>
                                <option value='04 Bulan'>04 Bulan</option>
                                <option value='05 Bulan'>05 Bulan</option>
                                <option value='06 Bulan'>06 Bulan</option>
                                <option value='07 Bulan'>07 Bulan</option>
                                <option value='08 Bulan'>08 Bulan</option>
                                <option value='09 Bulan'>09 Bulan</option> --}}
                                <?php
                                $arrint_reminder = ['01 Bulan', '02 Bulan', '03 Bulan', '04 Bulan', '05 Bulan', '06 Bulan', '07 Bulan', '08 Bulan', '09 Bulan'];
                                $jml_kata = count($arrint_reminder);
                                for ($c = 0; $c < $jml_kata; $c += 1) {
                                    if ($arrint_reminder[$c] == $faktur_gr->int_reminder) {
                                        echo "<option value='$arrint_reminder[$c]' selected>$arrint_reminder[$c] </option>";
                                    } else {
                                        echo "<option value='$arrint_reminder[$c]'> $arrint_reminder[$c] </option>";
                                    }
                                }
                                echo '</select>';
                                ?>
                            </select>
                            <select id='via' name='via' class="form-control form-control-sm"
                                autofocus='autofocus' {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}>
                                <option value=''>- PILIH REMINDER VIA -</option>
                                {{-- <option value='Telp'>Telp</option>
                                <option value='SMS'>SMS</option>
                                <option value='WA'>WA</option>
                                <option value='Email'>Email</option> --}}
                                <?php
                                $arrvia = ['Telp', 'SMS', 'WA', 'Email'];
                                $jml_kata = count($arrvia);
                                for ($c = 0; $c < $jml_kata; $c += 1) {
                                    if ($arrvia[$c] == $faktur_gr->via) {
                                        echo "<option value='$arrvia[$c]' selected>$arrvia[$c] </option>";
                                    } else {
                                        echo "<option value='$arrvia[$c]'> $arrvia[$c] </option>";
                                    }
                                }
                                echo '</select>';
                                ?>
                            </select>
                        </div>
                        <label for="sa" class="form-label mb-1">Service Advisor</label>
                        <div class="input-group mb-2">
                            <input type="text" style="width:5%;" name="kdsa" id="kdsa"
                                value="<?= $faktur_gr['kdsa'] ?>" class="form-control form-control-sm"
                                {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                            <input type="text" style="width:50%;" name="nmsa" id="nmsa"
                                value="<?= $faktur_gr['nmsa'] ?>" class="form-control form-control-sm" readonly>
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="carisa"
                                {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}><i
                                    class="fa fa-search"></i></button>
                            <!-- <button class="btn btn-outline-primary tambahtbsa" type="button"><i class="fa fa-plus"></i></button> -->
                        </div>
                        <label for="keluhan" class="form-label mb-1">Keluhan</label>
                        <textarea class="form-control" name="keluhan" id="keluhan" rows="4"
                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>{{ $faktur_gr->keluhan }}</textarea>
                        <label for="keluhan" class="form-label mb-1">Own Risk</label>
                        <input type="number" class="form-control form-control-sm" style="text-align:right;"
                            name="own_risk" id="own_risk" value="<?= $faktur_gr['own_risk'] ?>"
                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label for="keluhan" class="form-label mb-1">Nama Polis</label>
                        <input type="text" class="form-control form-control-sm" name="nama_polis" id="nama_polis"
                            value="<?= $faktur_gr['nama_polis'] ?>"
                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                        <label for="keluhan" class="form-label mb-1">No. Polis</label>
                        <input type="text" class="form-control form-control-sm" name="no_polis" id="no_polis"
                            value="<?= $faktur_gr['no_polis'] ?>"
                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                        <label for="keluhan" class="form-label mb-1">Tgl. Berakhir</label>
                        <input type="date" class="form-control form-control-sm" name="tgl_akhir_polis"
                            id="tgl_akhir_polis" value="<?= $faktur_gr['tgl_akhir_polis'] ?>"
                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                        <label for="keluhan" class="form-label mb-1">Asuransi</label>
                        <div class="input-group mb-1">
                            <input type="text" style="width:4%;" name="kdasuransi" id="kdasuransi_es"
                                value="<?= $faktur_gr['kdasuransi'] ?>" class="form-control form-control-sm"
                                {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                            <input type="text" style="width:55%;" name="nmasuransi" id="nmasuransi_es"
                                value="<?= $faktur_gr['nmasuransi'] ?>" class="form-control form-control-sm" readonly>
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="cariasuransi_es"
                                {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}>
                                <i class="fa fa-search"></i></button>
                        </div>
                        <label for="alamatasuransi" class="form-label mb-1">Alamat Asuransi</label>
                        <textarea class="form-control" name="alamat_asuransi" id="alamat_asuransi_es" rows="2" readonly>{{ $faktur_gr['alamat_asuransi'] }}</textarea>
                        <label for="nama" class="form-label mb-1">Surveyor</label>
                        <input type="text" class="form-control form-control-sm mb-2" name="surveyor"
                            id="surveyor" value="<?= $faktur_gr['surveyor'] ?>"
                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                        <label for="nama" class="form-label mb-0">Status WO</label>
                        <br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="klaim" name="klaim"
                                {{ $faktur_gr->klaim == '1' ? 'checked' : '' }}
                                {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}>
                            <label class="form-check-label" for="flexCheckDefault">Klaim</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="internal" name="internal"
                                {{ $faktur_gr->internal == '1' ? 'checked' : '' }}
                                {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}>
                            <label class="form-check-label" for="flexCheckChecked">Internal</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inventaris" name="inventaris"
                                {{ $faktur_gr->inventaris == '1' ? 'checked' : '' }}
                                {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}>
                            <label class="form-check-label" for="flexCheckDefault">Inventaris</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="campaign" name="campaign"
                                {{ $faktur_gr->campaign == '1' ? 'checked' : '' }}
                                {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}>
                            <label class="form-check-label" for="flexCheckChecked">Campaign</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="booking" name="booking"
                                {{ $faktur_gr->booking == '1' ? 'checked' : '' }}
                                {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}>
                            <label class="form-check-label" for="flexCheckChecked">Booking</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="lain_lain" name="lain_lain"
                                {{ $faktur_gr->lain_lain == '1' ? 'checked' : '' }}
                                {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}>
                            <label class="form-check-label" for="flexCheckChecked">Lain-lain</label>
                        </div>
                        <br>
                        <label for="nama" class="form-label mt-2 mb-1">PPN (%)</label>
                        <input type="number" class="form-control form-control-sm mb-2" name="pr_ppn"
                            id="pr_ppn" value="<?= $faktur_gr['pr_ppn'] ?>"
                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                        <label for="nama" class="form-label mb-1">NPWP</label>
                        <input type="text" class="form-control form-control-sm mb-2" name="npwp"
                            id="npwp" value="<?= $faktur_gr['npwp'] ?>" readonly>
                        <label for="nama" class="form-label mb-1">Contact Person</label>
                        <input type="text" class="form-control form-control-sm mb-2" name="contact_person"
                            id="contact_person" value="<?= $faktur_gr['contact_person'] ?>" readonly>
                        <label for="nama" class="form-label mb-1">Nomor Contact Person</label>
                        <input type="text" class="form-control form-control-sm mb-2" name="no_contact_person"
                            id="no_contact_person" value="<?= $faktur_gr['no_contact_person'] ?>" readonly>
                    </div>
                </div>
                @if (strpos($vdata['title'], 'Detail') !== false)
                    <div class="row">
                        <div class="col-md-12">
                            <label for="nama" class="form-label mb-1 mt-0">User</label>
                            <input type="text" class="form-control form-control-sm" name="user" id="user"
                                value="{{ $faktur_gr->user }}" readonly>
                        </div>
                        {{-- <div class="vdetail_estimasi_gr"></div> --}}
                    </div>
                @endif
                <div class="modal-footer">
                    @if (str_contains($vdata['title'], 'Detail'))
                        {{-- <button type="button" class="btn btn-info btn-sm btnvdetail">View Detail</button> --}}
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    @else
                        <button type="submit" id="btnsimpan"
                            class="btn btn-primary btn-sm btnsimpan">Simpan</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var myModal = document.getElementById('modaltambah')
    var myInput = document.getElementById('norangka')
    // myModal.addEventListener('shown.bs.modal', function() {
    //     myInput.focus()
    // })
    $(myModal).on('shown.bs.modal', function() {
        $(this).find(myInput).focus();
    });


    // $('.tambahestimasi').disabled = true;
    // $('.tambahestimasi').disabled = true;

    $(document).ready(function() {
        $('.formtambahfaktur').submit(function(e) {
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
                        reload_table();
                        toastr.info('Data berhasil di simpan, silahkan melanjutkan')
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

        $('.formtambahestimasi').submit(function(e) {
            var id = $('#idestimasi').val();
            const form = $(this)
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: form.serialize(),
                dataType: "json",
                // method: "POST",
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
                        $('#modaltambahestimasi').modal('hide');
                        $('#modaltambah').modal('show');
                        reload_table_estimasi_gr();
                        toastr.info('Data berhasil di simpan, silahkan melanjutkan')
                        // reload_table_estimasi();
                        document.getElementById("btntambahestimasi").disabled = false;
                        document.getElementById("btnsimpan").disabled = true;
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

    // Nampilin list data pilihan ===================
    $('#cariwo_gr').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= url('cariwo_gr') ?>",
            dataType: "json",
            success: function(response) {
                $('#modalcariwo').html(response.body)
                $('#modalcariwo').modal('show');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })
    $('#nowo').on('blur', function(e) {
        let cari = $(this).val()
        if (cari !== "") {
            $.ajax({
                url: "<?= url('replwo_gr') ?>",
                type: 'get',
                data: {
                    'kode': cari
                },
                success: function(data) {
                    let data_response = JSON.parse(data);
                    if (data_response['nowo'] == '') {
                        $('#noestimasi').val('');
                        $('#nowo').val('');
                        $('#tglwo').val('');
                        $('#nopolisi').val('');
                        $('#norangka').val('');
                        $('#kdpemilik').val('');
                        $('#nmpemilik').val('');
                        $('#kdsa').val('');
                        $('#nmsa').val('');
                        $('#kdservice').val('');
                        $('#nmservice').val('');
                        $('#km').val('');
                        $('#kdpaket').val('');
                        $('#aktifitas').val('');
                        $('#fasilitas').val('');
                        $('#status_tunggu').val('');
                        $('#int_reminder').val('');
                        $('#via').val('');
                        $('#status_tunggu').val('');
                        $('#keluhan').val('');
                        $('#saran').val('');
                        $('#pr_ppn').val('');
                        $('#no_polis').val('');
                        $('#nama_polis').val('');
                        $('#tgl_akhir_polis').val('');
                        $('#kdasuransi').val('');
                        $('#nmasuransi').val('');
                        $('#alamat_asuransi').val('');
                        $('#klaim').prop('checked', false)
                        $('#internal').prop('checked', false)
                        $('#inventaris').prop('checked', false)
                        $('#campaign').prop('checked', false)
                        $('#booking').prop('checked', false)
                        $('#lain_lain').prop('checked', false)
                        $('#surveyor').val('');
                        $('#npwp').val('');
                        $('#contact_person').val('');
                        $('#own_risk').val('');
                        return;
                    } else {
                        $('#noestimasi').val(data_response['noestimasi']);
                        $('#nowo').val(data_response['nowo']);
                        $('#tglwo').val(data_response['tglwo']);
                        $('#nopolisi').val(data_response['nopolisi']);
                        $('#norangka').val(data_response['norangka']);
                        $('#kdpemilik').val(data_response['kdpemilik']);
                        $('#nmpemilik').val(data_response['nmpemilik']);
                        $('#kdsa').val(data_response['kdsa']);
                        $('#nmsa').val(data_response['nmsa']);
                        $('#kdservice').val(data_response['kdservice']);
                        $('#nmservice').val(data_response['nmservice']);
                        $('#km').val(data_response['km']);
                        $('#kdpaket').val(data_response['kdpaket']);
                        $('#aktifitas').val(data_response['aktifitas']);
                        $('#fasilitas').val(data_response['fasilitas']);
                        $('#status_tunggu').val(data_response['status_tunggu']);
                        $('#int_reminder').val(data_response['int_reminder']);
                        $('#via').val(data_response['via']);
                        $('#status_tunggu').val(data_response['status_tunggu']);
                        $('#keluhan').val(data_response['keluhan']);
                        $('#saran').val(data_response['saran']);
                        $('#pr_ppn').val(data_response['pr_ppn']);
                        $('#no_polis').val(data_response['no_polis']);
                        $('#nama_polis').val(data_response['nama_polis']);
                        $('#tgl_akhir_polis').val(data_response['tgl_akhir_polis']);
                        $('#kdasuransi').val(data_response['kdasuransi']);
                        $('#nmasuransi').val(data_response['nmasuransi']);
                        $('#alamat_asuransi').val(data_response['alamat_asuransi']);
                        $('#klaim').prop('checked', data_response['klaim'] == 1 ? true : false)
                        $('#internal').prop('checked', data_response['internal'] == 1 ? true :
                            false)
                        $('#inventaris').prop('checked', data_response['inventaris'] == 1 ? true :
                            false)
                        $('#campaign').prop('checked', data_response['campaign'] == 1 ? true :
                            false)
                        $('#booking').prop('checked', data_response['booking'] == 1 ? true :
                            false)
                        $('#lain_lain').prop('checked', data_response['lain_lain'] == 1 ? true :
                            false)
                        $('#surveyor').val(data_response['campaign']);
                        $('#npwp').val(data_response['npwp']);
                        $('#contact_person').val(data_response['contact_person']);
                        $('#own_risk').val(data_response['own_risk']);
                    }
                },
                error: function() {
                    $('#estimasi').val('');
                    $('#nowo').val('');
                    $('#tglwo').val('');
                    $('#nopolisi').val('');
                    $('#norangka').val('');
                    $('#kdpemilik').val('');
                    $('#nmpemilik').val('');
                    $('#kdsa').val('');
                    $('#nmsa').val('');
                    $('#kdservice').val('');
                    $('#nmservice').val('');
                    $('#km').val('');
                    $('#kdpaket').val('');
                    $('#aktifitas').val('');
                    $('#fasilitas').val('');
                    $('#status_tunggu').val('');
                    $('#int_reminder').val('');
                    $('#via').val('');
                    $('#status_tunggu').val('');
                    $('#keluhan').val('');
                    $('#saran').val('');
                    $('#pr_ppn').val('');
                    $('#no_polis').val('');
                    $('#nama_polis').val('');
                    $('#tgl_akhir_polis').val('');
                    $('#kdasuransi').val('');
                    $('#nmasuransi').val('');
                    $('#alamat_asuransi').val('');
                    $('#klaim').prop('checked', false)
                    $('#internal').prop('checked', false)
                    $('#inventaris').prop('checked', false)
                    $('#campaign').prop('checked', false)
                    $('#booking').prop('checked', false)
                    $('#lain_lain').prop('checked', false)
                    $('#surveyor').val('');
                    $('#npwp').val('');
                    $('#contact_person').val('');
                    $('#own_risk').val('');
                    return;
                    // console.log('file not fount');
                }
            })
            // console.log(cari);
        }
    })

    $('#nowo').on('focus', function(e) {
        let cari = $(this).val()
        if (cari !== "") {
            $.ajax({
                url: "<?= url('replwo_gr') ?>",
                type: 'get',
                data: {
                    'kode': cari
                },
                success: function(data) {
                    let data_response = JSON.parse(data);
                    if (data_response['nowo'] == '') {
                        $('#noestimasi').val('');
                        $('#nowo').val('');
                        $('#tglwo').val('');
                        $('#nopolisi').val('');
                        $('#norangka').val('');
                        $('#kdpemilik').val('');
                        $('#nmpemilik').val('');
                        $('#kdsa').val('');
                        $('#nmsa').val('');
                        $('#kdservice').val('');
                        $('#nmservice').val('');
                        $('#km').val('');
                        $('#kdpaket').val('');
                        $('#aktifitas').val('');
                        $('#fasilitas').val('');
                        $('#status_tunggu').val('');
                        $('#int_reminder').val('');
                        $('#via').val('');
                        $('#status_tunggu').val('');
                        $('#keluhan').val('');
                        $('#saran').val('');
                        $('#pr_ppn').val('');
                        $('#no_polis').val('');
                        $('#nama_polis').val('');
                        $('#tgl_akhir_polis').val('');
                        $('#kdasuransi').val('');
                        $('#nmasuransi').val('');
                        $('#alamat_asuransi').val('');
                        $('#klaim').prop('checked', false)
                        $('#internal').prop('checked', false)
                        $('#inventaris').prop('checked', false)
                        $('#campaign').prop('checked', false)
                        $('#booking').prop('checked', false)
                        $('#lain_lain').prop('checked', false)
                        $('#surveyor').val('');
                        $('#npwp').val('');
                        $('#contact_person').val('');
                        $('#own_risk').val('');
                        return;
                    } else {
                        $('#noestimasi').val(data_response['noestimasi']);
                        $('#nowo').val(data_response['nowo']);
                        $('#tglwo').val(data_response['tglwo']);
                        $('#nopolisi').val(data_response['nopolisi']);
                        $('#norangka').val(data_response['norangka']);
                        $('#kdpemilik').val(data_response['kdpemilik']);
                        $('#nmpemilik').val(data_response['nmpemilik']);
                        $('#kdsa').val(data_response['kdsa']);
                        $('#nmsa').val(data_response['nmsa']);
                        $('#kdservice').val(data_response['kdservice']);
                        $('#nmservice').val(data_response['nmservice']);
                        $('#km').val(data_response['km']);
                        $('#kdpaket').val(data_response['kdpaket']);
                        $('#aktifitas').val(data_response['aktifitas']);
                        $('#fasilitas').val(data_response['fasilitas']);
                        $('#status_tunggu').val(data_response['status_tunggu']);
                        $('#int_reminder').val(data_response['int_reminder']);
                        $('#via').val(data_response['via']);
                        $('#status_tunggu').val(data_response['status_tunggu']);
                        $('#keluhan').val(data_response['keluhan']);
                        $('#saran').val(data_response['saran']);
                        $('#pr_ppn').val(data_response['pr_ppn']);
                        $('#no_polis').val(data_response['no_polis']);
                        $('#nama_polis').val(data_response['nama_polis']);
                        $('#tgl_akhir_polis').val(data_response['tgl_akhir_polis']);
                        $('#kdasuransi').val(data_response['kdasuransi']);
                        $('#nmasuransi').val(data_response['nmasuransi']);
                        $('#alamat_asuransi').val(data_response['alamat_asuransi']);
                        $('#klaim').prop('checked', data_response['klaim'] == 1 ? true : false)
                        $('#internal').prop('checked', data_response['internal'] == 1 ? true :
                            false)
                        $('#inventaris').prop('checked', data_response['inventaris'] == 1 ? true :
                            false)
                        $('#campaign').prop('checked', data_response['campaign'] == 1 ? true :
                            false)
                        $('#booking').prop('checked', data_response['booking'] == 1 ? true :
                            false)
                        $('#lain_lain').prop('checked', data_response['lain_lain'] == 1 ? true :
                            false)
                        $('#surveyor').val(data_response['campaign']);
                        $('#npwp').val(data_response['npwp']);
                        $('#contact_person').val(data_response['contact_person']);
                        $('#own_risk').val(data_response['own_risk']);
                    }
                },
                error: function() {
                    $('#nowo').val('');
                    $('#tglwo').val('');
                    $('#nopolisi').val('');
                    $('#norangka').val('');
                    $('#kdpemilik').val('');
                    $('#nmpemilik').val('');
                    $('#kdsa').val('');
                    $('#nmsa').val('');
                    $('#kdservice').val('');
                    $('#nmservice').val('');
                    $('#km').val('');
                    $('#kdpaket').val('');
                    $('#aktifitas').val('');
                    $('#fasilitas').val('');
                    $('#status_tunggu').val('');
                    $('#int_reminder').val('');
                    $('#via').val('');
                    $('#status_tunggu').val('');
                    $('#keluhan').val('');
                    $('#saran').val('');
                    $('#pr_ppn').val('');
                    $('#no_polis').val('');
                    $('#nama_polis').val('');
                    $('#tgl_akhir_polis').val('');
                    $('#kdasuransi').val('');
                    $('#nmasuransi').val('');
                    $('#alamat_asuransi').val('');
                    $('#klaim').prop('checked', false)
                    $('#internal').prop('checked', false)
                    $('#inventaris').prop('checked', false)
                    $('#campaign').prop('checked', false)
                    $('#booking').prop('checked', false)
                    $('#lain_lain').prop('checked', false)
                    $('#surveyor').val('');
                    $('#npwp').val('');
                    $('#contact_person').val('');
                    $('#own_risk').val('');
                    return;
                    // console.log('file not fount');
                }
            })
            // console.log(cari);
        }
    })

    // Nampilin list data pilihan ===================
    $('#carisa').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= url('carisa') ?>",
            dataType: "json",
            success: function(response) {
                $('#modalcarisa').html(response.body)
                $('#modalcarisa').modal('show');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })
    $('#kdsa').on('blur', function(e) {
        let cari = $(this).val()
        if (cari !== "") {
            $.ajax({
                url: "<?= url('replsa') ?>",
                type: 'get',
                data: {
                    'kode': cari
                },
                success: function(data) {
                    let data_response = JSON.parse(data);
                    if (data_response['kdsa'] == '') {
                        $('#kdsa').val('');
                        $('#nmsa').val('');
                        return;
                    } else {
                        $('#kdsa').val(data_response['kdsa']);
                        $('#nmsa').val(data_response['nmsa']);
                    }
                },
                error: function() {
                    $('#kdsa').val('');
                    $('#nmsa').val('');
                    return;
                    // console.log('file not fount');
                }
            })
            // console.log(cari);
        }
    })

    // Nampilin list data pilihan ===================
    $('#cariasuransi_es').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= url('cariasuransi_es') ?>",
            dataType: "json",
            success: function(response) {
                $('#modalcariasuransi').html(response.body)
                $('#modalcariasuransi').modal('show');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })
    $('#kdasuransi_es').on('blur', function(e) {
        let cari = $(this).val()
        if (cari !== "") {
            $.ajax({
                url: "<?= url('replasuransi_es') ?>",
                type: 'get',
                data: {
                    'kode': cari
                },
                success: function(data) {
                    let data_response = JSON.parse(data);
                    if (data_response['kdasuransi'] == '') {
                        $('#kdasuransi_es').val('');
                        $('#nmasuransi_es').val('');
                        $('#alamat_asuransi_es').val('');
                        return;
                    } else {
                        $('#kdasuransi_es').val(data_response['kdasuransi']);
                        $('#nmasuransi_es').val(data_response['nmasuransi']);
                        $('#alamat_asuransi_es').val(data_response['alamat']);
                    }
                },
                error: function() {
                    $('#kdasuransi_es').val('');
                    $('#nmasuransi_es').val('');
                    $('#alamat_asuransi_es').val('');
                    return;
                    // console.log('file not fount');
                }
            })
            // console.log(cari);
        }
    })

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
                        url: `{{ url('estimasi_gr') }}/${id}`,
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
                                reload_table_estimasi_gr();
                                toastr.info('Data berhasil dihapus, silahkan melanjutkan')
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
