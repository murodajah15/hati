<?php
$session = session();
// var_dump($vdata);
?>
<!-- Modal -->
<div class="modal-dialog" style="max-width: 70%;">
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
        <form action="{{ $action }}" method="post" class="formtbmekanik">
            @csrf
            @if ($tbmekanik->id)
                @method('put')
            @endif
            <div class="modal-body">
                <input type="hidden" class="form-control form-control-sm-sm" name="username" id="username"
                    value="{{ $session->get('username') }}">
                <input type="hidden" class="form-control form-control-sm-sm" name="kodelama" id="kodelama"
                    value="{{ $tbmekanik->kode }}">
                <div class='col-md-12'>
                    <div class="row">
                        <div class='col-md-12'>
                            <table style=font-size:12px; class='table table-borderless table-sm table-hover'>
                                <div class="col-md-6 mb-2">
                                    <tr>
                                        <td width="30">Kode</td>
                                        <td><input type="text" class="form-control form-control-sm" name="kode"
                                                style="width:15em" id="kode" value="{{ $tbmekanik->kode }}"
                                                {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}
                                                {{ str_contains($vdata['title'], 'Detail') ? '' : 'autofocus' }}></td>
                                    </tr>
                                    <tr>
                                        <td width="30">Nama</td>
                                        <td colspan="2"><input type="text" class="form-control form-control-sm"
                                                name="nama" id="nama" value="{{ $tbmekanik->nama }}"
                                                {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="30">Alamat</td>
                                        <td colspan="5"><input type="text" class="form-control form-control-sm"
                                                name="alamat" id="alamat" value="{{ $tbmekanik->alamat }}"
                                                {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td width="30">Kelurahan</td>
                                        <td><input type="text" class="form-control form-control-sm" name="kelurahan"
                                                id="kelurahan" value="{{ $tbmekanik->kelurahan }}"
                                                {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td width="30">Kecamatan</td>
                                        <td><input type="text" class="form-control form-control-sm" name="kecamatan"
                                                id="kecamatan" value="{{ $tbmekanik->kecamatan }}"
                                                {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td width="30">Kota</td>
                                        <td><input type="text" class="form-control form-control-sm" name="kota"
                                                id="kota" value="{{ $tbmekanik->kota }}"
                                                {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td width="30">Provinsi</td>
                                        <td><input type="text" class="form-control form-control-sm" name="provinsi"
                                                id="provinsi" value="{{ $tbmekanik->provinsi }}"
                                                {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Kode Pos</td>
                                        <td style="width:20em;"><input type="text"
                                                class="form-control form-control-sm" name="kodepos" id="kodepos"
                                                value="{{ $tbmekanik->kodepos }}"
                                                {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td width="30">No. HP</td>
                                        <td><input type="text" class="form-control form-control-sm" name="telp1"
                                                id="telp1" value="{{ $tbmekanik->telp1 }}"
                                                {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td width="30">Kategori</td>
                                        <td><select class="form-control form-control-sm js-example-basic-single"
                                                name="kategori" id="kategori"
                                                {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}>
                                                <?php
                                                $arrkategori = ['CUCI', 'QUICK SERVICE', 'PERIODICAL MAINTENANCE', 'GENERAL REPAIR', 'SPOORING & BALANCE', 'BODY & PAINT', 'BONGKAR PASANG'];
                                                $jml_kata = count($arrkategori);
                                                for ($c = 0; $c < $jml_kata; $c += 1) {
                                                    if ($arrkategori[$c] == $tbmekanik->kategori) {
                                                        echo "<option value='$arrkategori[$c]' selected>$arrkategori[$c] </option>";
                                                    } else {
                                                        echo "<option value='$arrkategori[$c]'> $arrkategori[$c] </option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="30"></td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="aktif"
                                                    name="aktif"
                                                    {{ (str_contains($vdata['title'], 'Tambah') ? 'checked' : $tbmekanik->aktif == 'Y') ? 'checked' : '' }}
                                                    {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}>
                                                <label class="aktif" for="flexCheckDefault">
                                                    Aktif
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                </div>
                                <?php
                                    if (strpos($vdata['title'], 'Tambah') !== false) {
                                    } else {
                                    ?>
                                <tr>
                                    <td>User</td>
                                    <td colspan=5> <input type='text' class='form-control form-control-sm'
                                            name='user' id='user' value="{{ $tbmekanik->user }}" readonly>
                                    </td>
                                </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                @if (str_contains($vdata['title'], 'Detail'))
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                @else
                    <button type="submit" id="btnsimpan" class="btn btn-primary btnsimpan">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                @endif
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
        $('.formtbmekanik').submit(function(e) {
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
                        //     window.location.href = '/tbmekanik';
                        // });
                        // window.location = '/tbmekanik';
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
</script>
