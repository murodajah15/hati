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
        <form action="{{ $action }}" method="post" class="formtbleasing">
            @csrf
            @if ($tbleasing->id)
                @method('put')
            @endif
            <div class="modal-body">
                <input type="hidden" class="form-control-sm" name="username" id="username"
                    value="{{ $session->get('username') }}">
                <input type="hidden" class="form-control-sm" name="kodelama" id="kodelama"
                    value="{{ $tbleasing->kode }}">
                <div class='col-md-12'>
                    <div class="row">
                        <div class='col-md-6'>
                            <table style=font-size:12px; class='table table-borderless table-sm table-hover'>
                                <div class="col-md-6 mb-2">
                                    <td width="100">Kode</td>
                                    <td><input type="text" class="form-control form-control-sm" name="kode"
                                            id="kode" value="{{ $tbleasing->kode }}"
                                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}
                                            {{ str_contains($vdata['title'], 'Detail') ? '' : 'autofocus' }}>
                                    </td>
                                    <tr>
                                        <td>Nama</td>
                                        <td><input type="text" class="form-control form-control-sm" name="nama"
                                                id="nama" value="{{ $tbleasing->nama }}"
                                                {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td>
                                            <textarea rows='2' class='form-control form-control-sm' name='alamat' id='alamat'
                                                {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>{{ $tbleasing->alamat }}</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Kota</td>
                                        <td> <input type='text' class='form-control form-control-sm' name='kota'
                                                id='kota' value="{{ $tbleasing->kota }}"
                                                {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Kode Pos</td>
                                        <td> <input type='text' class='form-control form-control-sm' name='kodepos'
                                                id='kodepos' value="{{ $tbleasing->kodepos }}"
                                                {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Telp</td>
                                        <td>
                                            <div class='input-group'><input type='text'
                                                    class='form-control form-control-sm' width='50%' name='telp1'
                                                    value="{{ $tbleasing->telp1 }}"
                                                    {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                                <input type='text' class='form-control form-control-sm'
                                                    width='50%' name='telp2' value="{{ $tbleasing->telp2 }}"
                                                    {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td> <input type='email' class='form-control form-control-sm' name='email'
                                                id='email' value="{{ $tbleasing->email }}"
                                                {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>NPWP</td>
                                        <td> <input type='text' class='form-control form-control-sm' name='npwp'
                                                value="{{ $tbleasing->npwp }}"
                                                {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Nama NPWP</td>
                                        <td> <input type='text' class='form-control form-control-sm' name='nama_npwp'
                                                value="{{ $tbleasing->nama_npwp }}"
                                                {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat NPWP</td>
                                        <td>
                                            <textarea rows='2' class='form-control form-control-sm' name='alamat_npwp'
                                                {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>{{ $tbleasing->npwp }}</textarea>
                                        </td>
                                    </tr>
                                </div>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table style=font-size:12px; class='table table-borderless table-sm table-hover'>
                                <tr>
                                    <td width="100">NPPKP</td>
                                    <td> <input type='text' class='form-control form-control-sm' name='nppkp'
                                            value="<?= $tbleasing['nppkp'] ?>"></td>
                                </tr>
                                <tr>
                                    <td>Contact Person</td>
                                    <td> <input type='text' class='form-control form-control-sm'
                                            name='contact_person' id='contact_person'
                                            value="{{ $tbleasing->contact_person }}"
                                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <td>No. Contact Person</td>
                                    <td> <input type='text' class='form-control form-control-sm'
                                            name='no_contact_person' id='no_contact_person'
                                            value="{{ $tbleasing->no_contact_person }}"
                                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Temp Of Payment (TOP)/Hari</td>
                                    <td> <input type='number' class='form-control form-control-sm'
                                            style="text-align:right;" name='top' value="<?= $tbleasing['top'] ?>"
                                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Discount Part</td>
                                    <td> <input type='number' class='form-control form-control-sm'
                                            style="text-align:right;" name='disc_part'
                                            value="<?= $tbleasing['disc_part'] ?>"
                                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Discount Jasa</td>
                                    <td> <input type='number' class='form-control form-control-sm'
                                            style="text-align:right;" name='disc_jasa'
                                            value="<?= $tbleasing['disc_jasa'] ?>"
                                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Discount Bahan</td>
                                    <td> <input type='number' class='form-control form-control-sm'
                                            style="text-align:right;" name='disc_bahan'
                                            value="<?= $tbleasing['disc_bahan'] ?>"
                                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <td>PPH Jasa</td>
                                    <td> <input type='number' class='form-control form-control-sm'
                                            style="text-align:right;" name='pph_jasa'
                                            value="<?= $tbleasing['pph_jasa'] ?>"
                                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <td>PPH Material</td>
                                    <td> <input type='number' class='form-control form-control-sm'
                                            style="text-align:right;" name='pph_material'
                                            value="<?= $tbleasing['pph_material'] ?>"
                                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Kredit Limit</td>
                                    <td> <input type='number' class='form-control form-control-sm'
                                            style="text-align:right;" name='kredit_limit'
                                            value="<?= $tbleasing['kredit_limit'] ?>"
                                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="aktif"
                                                name="aktif"
                                                {{ (str_contains($vdata['title'], 'Tambah') ? 'checked' : $tbleasing->aktif == 'Y') ? 'checked' : '' }}
                                                {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}>
                                            <label class="aktif" for="flexCheckDefault">
                                                Aktif
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <?php
                    if (strpos($vdata['title'], 'Tambah') !== false) {
                    } else {
                    ?>
                    <tr>
                        <td>User</td>
                        <td> <input type='text' class='form-control form-control-sm' name='user'
                                id='user' value="{{ $tbleasing->user }}" readonly>
                        </td>
                    </tr>
                    <?php } ?>
                </div>
            </div>
            <div class="modal-footer">
                @if (str_contains($vdata['title'], 'Detail'))
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                @else
                    <button type="submit" id="btnsimpan" class="btn btn-primary btnsimpan btn-sm">Simpan</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                @endif
            </div>
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
        $('.formtbleasing').submit(function(e) {
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
                        //     window.location.href = '/tbleasing';
                        // });
                        // window.location = '/tbleasing';
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
