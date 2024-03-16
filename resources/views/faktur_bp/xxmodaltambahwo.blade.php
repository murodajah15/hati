<?php
$session = session();
// var_dump($vdata);
?>
<!-- Modal -->
<div class="modal-dialog" style="max-width: 95%;">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">
                {{ $vdata['title'] }}{{ ' ' . $tbmobil->nopolisi }}
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
            <form action={{ $action }} method="post" class="formtambahwo">
                @csrf
                @if ($wo_bp->id)
                    @method('put')
                @endif
                <input type="hidden" class="form-control form-control-sm" name="id" id="id"
                    value="<?= $wo_bp['id'] ?>">
                <div class="row mb-2 mt-0">
                    <div class="col-12 col-sm-6">
                        <?php
                        date_default_timezone_set('Asia/Jakarta');
                        $tglwo_bp = date('Y-m-d H:i:s');
                        ?>
                        <label for="nama" class="form-label mb-1">No. WO / Tanggal / Est Selesai
                            (M-D-Y)</label>
                        <input type='hidden' class='form-control form-control-sm mb-2' value="{{ $wo_bp->nowo }}"
                            readonly style="width: 5%" id='nowolama' name='nowolama'>
                        <div class="input-group mb-1">
                            <input type='text' class='form-control form-control-sm mb-2'
                                value="{{ str_contains($vdata['title'], 'Tambah') ? 'AUTO GENERATE' : $wo_bp->nowo }}"
                                style="width: 25%" id='nowo'
                                {{ str_contains($vdata['title'], 'Edit') ? 'name=nowo' : '' }} readonly>
                            <input type="datetime-local" class='form-control form-control-sm mb-2' name='tanggal'
                                id='tanggal' value="<?= $tglwo_bp ?>" style="width: 30%" readonly>
                            <input type="datetime-local" class='form-control form-control-sm mb-2' name='est_selesai'
                                id='est_selesai' value="<?= $wo_bp->est_selesai ?>" style="width: 30%"
                                {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                        </div>
                        <label for="nama" class="form-label mb-0">No. Polisi</label>
                        <div class="input-group mb-1">
                            <input type="text" class="form-control form-control-sm" placeholder="No. Polisi"
                                name="nopolisi" id="nopolisi" value={{ $tbmobil->nopolisi }} readonly>
                            <input type="text" class="form-control form-control-sm" name="norangka" id="norangka"
                                value="<?= $tbmobil['norangka'] ?>" style="width: 55%" readonly>
                            {{-- <input type="text" class="col-8" class="form-control form-control-sm" name="norangka"
                                id="norangka" value="<?= $tbmobil['norangka'] ?>" readonly> --}}
                        </div>
                        <label for="nama" class="form-label mb-1">Customer</label>
                        <div class="input-group mb-1">
                            <input type="text" class="form-control form-control-sm mb-2" name="kdpemilik"
                                id="kdpemilik" readonly style="width: 5%" value="<?= $tbmobil['kdpemilik'] ?>">
                            <input type="text" class="form-control form-control-sm mb-2" name="nmpemilik"
                                id="nmpemilik" readonly style="width: 40%" value="<?= $tbmobil['nmpemilik'] ?>">
                        </div>
                        <div class="invalid-feedback errornmpemilik">
                        </div>
                        <label for="nama" class="form-label mb-1">Jenis Service / Kilo Meter</label>
                        <div class="input-group mb-2">
                            <select id='kdservice' name='kdservice' class="form-select form-select-sm"
                                autofocus='autofocus' required
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
                                    if ($arrkdservice[$c] == $wo_bp->kdservice) {
                                        echo "<option value='$arrkdservice[$c]' selected>$arrkdservice[$c] </option>";
                                    } else {
                                        echo "<option value='$arrkdservice[$c]'> $arrkdservice[$c] </option>";
                                    }
                                }
                                echo '</select>';
                                ?>
                            </select>
                            <input type="number" class="form-control form-control-sm" name="km" placeholder="KM"
                                value="<?= $wo_bp['km'] ?>"
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
                            <select id='aktifitas' name='aktifitas' class="form-select form-select-sm"
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
                                    if ($arraktifitas[$c] == $wo_bp->aktifitas) {
                                        echo "<option value='$arraktifitas[$c]' selected>$arraktifitas[$c] </option>";
                                    } else {
                                        echo "<option value='$arraktifitas[$c]'> $arraktifitas[$c] </option>";
                                    }
                                }
                                echo '</select>';
                                ?>
                            </select>
                            <select id='fasilitas' name='fasilitas' class="form-select form-select-sm"
                                style='width: 200x;' autofocus='autofocus'
                                {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}>
                                <option value=''>- PILIH FASILITAS -</option>
                                {{-- <option value='Service Car'>Service Car</option>
                                <option value='Service Motorcycle'>Service Motorcycle</option> --}}
                                <?php
                                $arrfasilitas = ['Service Car', 'Service Motorcycle'];
                                $jml_kata = count($arrfasilitas);
                                for ($c = 0; $c < $jml_kata; $c += 1) {
                                    if ($arrfasilitas[$c] == $wo_bp->fasilitas) {
                                        echo "<option value='$arrfasilitas[$c]' selected>$arrfasilitas[$c] </option>";
                                    } else {
                                        echo "<option value='$arrfasilitas[$c]'> $arrfasilitas[$c] </option>";
                                    }
                                }
                                echo '</select>';
                                ?>
                            </select>
                            <select id='status_tunggu' name='status_tunggu' class="form-select form-select-sm"
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
                                    if ($arrstatus_tunggu[$c] == $wo_bp->status_tunggu) {
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
                            <select id='int_reminder' name='int_reminder' class="form-select form-select-sm"
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
                                    if ($arrint_reminder[$c] == $wo_bp->int_reminder) {
                                        echo "<option value='$arrint_reminder[$c]' selected>$arrint_reminder[$c] </option>";
                                    } else {
                                        echo "<option value='$arrint_reminder[$c]'> $arrint_reminder[$c] </option>";
                                    }
                                }
                                echo '</select>';
                                ?>
                            </select>
                            <select id='via' name='via' class="form-select form-select-sm"
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
                                    if ($arrvia[$c] == $wo_bp->via) {
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
                                value="<?= $wo_bp['kdsa'] ?>" class="form-control"
                                {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                            <input type="text" style="width:50%;" name="nmsa" id="nmsa"
                                value="<?= $wo_bp['nmsa'] ?>" class="form-control" readonly>
                            <button class="btn btn-outline-secondary" type="button" id="carisa"
                                {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}><i
                                    class="fa fa-search"></i></button>
                            <!-- <button class="btn btn-outline-primary tambahtbsa" type="button"><i class="fa fa-plus"></i></button> -->
                        </div>
                        <label for="keluhan" class="form-label mb-1">Keluhan</label>
                        <textarea class="form-control" name="keluhan" id="keluhan" rows="3"
                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>{{ $wo_bp->keluhan }}</textarea>
                        <label for="saran" class="form-label mb-1">Saran</label>
                        <textarea class="form-control" name="saran" id="saran" rows="3"
                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>{{ $wo_bp->saran }}</textarea>
                        <label for="oen_risk" class="form-label mb-1">Own Risk</label>
                        <input type="number" class="form-control form-control-sm" style="text-align:right;"
                            name="own_risk" id="own_risk" value="<?= $wo_bp['own_risk'] ?>"
                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                    </div>


                    <div class="col-12 col-sm-6">
                        <label for="keluhan" class="form-label mb-1">Nama Polis</label>
                        <input type="text" class="form-control form-control-sm" name="nama_polis" id="nama_polis"
                            value="<?= $wo_bp['nama_polis'] ?>"
                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                        <label for="keluhan" class="form-label mb-1">No. Polis</label>
                        <input type="text" class="form-control form-control-sm" name="no_polis" id="no_polis"
                            value="<?= $wo_bp['no_polis'] ?>"
                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                        <label for="keluhan" class="form-label mb-1">Tgl. Berakhir</label>
                        <input type="date" class="form-control form-control-sm" name="tgl_akhir_polis"
                            id="tgl_akhir_polis" value="<?= $wo_bp['tgl_akhir_polis'] ?>"
                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                        <label for="keluhan" class="form-label mb-1">Asuransi</label>
                        <div class="input-group mb-1">
                            <input type="text" style="width:10%;" name="kdasuransi" id="kdasuransi_es"
                                value="<?= $wo_bp['kdasuransi'] ?>" class="form-control"
                                {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                            <input type="text" style="width:40%;" name="nmasuransi" id="nmasuransi_es"
                                value="<?= $wo_bp['nmasuransi'] ?>" class="form-control" readonly>
                            <button class="btn btn-outline-secondary" type="button" id="cariasuransi_es"
                                {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}>
                                <i class="fa fa-search"></i></button>
                        </div>
                        <label for="alamatasuransi" class="form-label mb-1">Alamat Asuransi</label>
                        <textarea class="form-control" name="alamat_asuransi" id="alamat_asuransi_es" rows="2" readonly>{{ $wo_bp['alamat_asuransi'] }}</textarea>
                        <label for="nama" class="form-label mb-1">Surveyor</label>
                        <input type="text" class="form-control form-control-sm mb-2" name="surveyor"
                            id="surveyor" value="<?= $wo_bp['surveyor'] ?>"
                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                        <label for="nama" class="form-label mb-0">Status WO</label>
                        <br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="klaim" name="klaim"
                                {{ (str_contains($vdata['title'], 'Tambah') ? 'checked' : $wo_bp->klaim == '1') ? 'checked' : '' }}
                                {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}>
                            <label class="form-check-label" for="flexCheckDefault">Klaim</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="internal" name="internal"
                                {{ (str_contains($vdata['title'], 'Tambah') ? 'checked' : $wo_bp->internal == '1') ? 'checked' : '' }}
                                {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}>
                            <label class="form-check-label" for="flexCheckChecked">Internal</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inventaris" name="inventaris"
                                {{ (str_contains($vdata['title'], 'Tambah') ? 'checked' : $wo_bp->inventaris == '1') ? 'checked' : '' }}
                                {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}>
                            <label class="form-check-label" for="flexCheckDefault">Inventaris</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="campaign" name="campaign"
                                {{ (str_contains($vdata['title'], 'Tambah') ? 'checked' : $wo_bp->campaign == '1') ? 'checked' : '' }}
                                {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}>
                            <label class="form-check-label" for="flexCheckChecked">Campaign</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="booking" name="booking"
                                {{ (str_contains($vdata['title'], 'Tambah') ? 'checked' : $wo_bp->booking == '1') ? 'checked' : '' }}
                                {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}>
                            <label class="form-check-label" for="flexCheckChecked">Booking</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input mb-2" type="checkbox" id="lain_lain" name="lain_lain"
                                {{ (str_contains($vdata['title'], 'Tambah') ? 'checked' : $wo_bp->lain_lain == '1') ? 'checked' : '' }}
                                {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}>
                            <label class="form-check-label" for="flexCheckChecked">Lain-lain</label>
                        </div>
                        <br>
                        <label for="nama" class="form-label mb-1">PPN (%)</label>
                        <input type="number" class="form-control form-control-sm mb-2" name="pr_ppn"
                            id="pr_ppn" value="<?= $wo_bp['pr_ppn'] ?>"
                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                        <label for="nama" class="form-label mb-1">NPWP</label>
                        <input type="text" class="form-control form-control-sm mb-2" name="npwp"
                            id="npwp" value="<?= $tbmobil['npwp'] ?>" readonly>
                        <label for="nama" class="form-label mb-1">Contact Person</label>
                        <input type="text" class="form-control form-control-sm mb-2" name="contact_person"
                            id="contact_person" value="<?= $tbmobil['contact_person'] ?>" readonly>
                        <label for="nama" class="form-label mb-1">Nomor Contact Person</label>
                        <input type="text" class="form-control form-control-sm mb-2" name="no_contact_person"
                            id="no_contact_person" value="<?= $tbmobil['no_contact_person'] ?>" readonly>
                    </div>
                </div>
                @if (strpos($vdata['title'], 'Detail') !== false)
                    <div class="row">
                        <div class="col-md-12">
                            <label for="nama" class="form-label mb-1 mt-0">User</label>
                            <input type="text" class="form-control form-control-sm" name="user" id="user"
                                value="{{ $wo_bp->user }}" readonly>
                        </div>
                        {{-- <div class="vdetail_wo_bp"></div> --}}
                    </div>
                @endif
                <div class="modal-footer">
                    @if (str_contains($vdata['title'], 'Detail'))
                        <button type="button" class="btn btn-info btn-sm btnvdetail">View Detail</button>
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


    // $('.tambahwo').disabled = true;
    // $('.tambahwo').disabled = true;

    $(document).ready(function() {
        $('#pagemobil').removeClass('in show active'); // to remove the current active tab
        $('#pagewo').addClass('in show active'); // add active class to the clicked tab
        $("#tabmobil").removeClass('active');
        $("#tabwo").addClass('active');
        reload_table_wo_bp();
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
                        // $('#modaltambahmaster').modal('hide');
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
                        // reload_table();
                        document.getElementById("btntambahwo").disabled = false;
                        document.getElementById("btnsimpan").disabled = true;
                        $('#modaltambah').modal('show');
                        // document.getElementById("pagemobil").removeClass('active');
                        // document.getElementById("pagewo").addClass('active');
                        $('#pagemobil').removeClass(
                            'in show active'); // to remove the current active tab
                        $('#pagewo').addClass(
                            'in show active'
                        ); // add active class to the clicked tab                        
                        reload_table_wo_bp();
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

        $('.formtambahwo').submit(function(e) {
            // var id = $('#idwo').val();
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
                        $('#modaltambahwo').modal('hide');
                        $('#modaltblwo').modal('show');
                        reload_table_wo_bp();
                        toastr.info('Data berhasil di simpan, silahkan melanjutkan')
                        // reload_table_wo();
                        // document.getElementById("btntambahwo").disabled = false;
                        // document.getElementById("btnsimpan").disabled = true;
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
                        url: `{{ url('wo_bp') }}/${id}`,
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
                                reload_table_wo_bp();
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

    // Nampilin list data pilihan ===================
    $('.btnvdetail').click(function(e) {
        var idwo = $("#idwo").val();
        var nowo = $("#nowo").val();
        $.ajax({
            type: "get",
            url: 'detailwo_bp',
            dataType: "json",
            data: {
                id: idwo,
                nowo: nowo,
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
    })
</script>
