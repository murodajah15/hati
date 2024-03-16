<?php
$session = session();
// var_dump($vdata);
?>
<!-- Modal -->
<div class="modal-dialog" style="max-width: 90%;">
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
        <form action="{{ $action }}" method="post" class="formtbasuransi">
            @csrf
            @if ($tbasuransi->id)
                @method('put')
            @endif
            <div class="modal-body">
                <input type="hidden" class="form-control-sm" name="username" id="username"
                    value="{{ $session->get('username') }}">
                <input type="hidden" class="form-control-sm" name="kodelama" id="kodelama"
                    value="{{ $tbasuransi->kode }}">
                <div class='col-md-12'>
                    <div class="row">
                        <div class='col-md-6'>
                            <table style=font-size:12px; class='table table-borderless table-sm table-hover'>
                                <div class="col-md-6 mb-2">
                                    <tr>
                                        <td width="100">Kode</td>
                                        <td><input type="text" class="form-control form-control-sm" name="kode"
                                                id="kode" value="{{ $tbasuransi->kode }}"
                                                {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}
                                                {{ str_contains($vdata['title'], 'Detail') ? '' : 'autofocus' }}>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nama</td>
                                        <td><input type="text" class="form-control form-control-sm" name="nama"
                                                id="nama" value="{{ $tbasuransi->nama }}"
                                                {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td>
                                            <textarea rows='3' class='form-control form-control-sm' name='alamat' id='alamat'
                                                {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>{{ $tbasuransi->alamat }}</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Kota</td>
                                        <td> <input type='text' class='form-control form-control-sm' name='kota'
                                                id='kota' value="{{ $tbasuransi->kota }}"
                                                {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Kode Pos</td>
                                        <td> <input type='text' class='form-control form-control-sm' name='kodepos'
                                                id='kodepos' value="{{ $tbasuransi->kodepos }}"
                                                {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Telp</td>
                                        <td> <input type='text' class='form-control form-control-sm' name='telp'
                                                value="{{ $tbasuransi->telp }}"
                                                {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Contact Person</td>
                                        <td> <input type='text' class='form-control form-control-sm'
                                                name='contact_person' value="{{ $tbasuransi->contact_person }}"
                                                {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>No.Contact Person</td>
                                        <td> <input type='text' class='form-control form-control-sm'
                                                name='no_contact_person' value="{{ $tbasuransi->no_contact_person }}"
                                                {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td> <input type='text' class='form-control form-control-sm'
                                                name='email'value="{{ $tbasuransi->email }}"
                                                {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}></td>
                                    </tr>
                            </table>
                        </div>
                        <div class='col-md-6'>
                            <table style=font-size:12px; class='table table-borderless table-sm table-hover'>
                                <tr>
                                    <td>NPWP</td>
                                    <td> <input type='text' class='form-control form-control-sm'
                                            name='npwp'value="{{ $tbasuransi->npwp }}"
                                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}></td>
                                </tr>
                                <tr>
                                    <td>Nama NPWP</td>
                                    <td> <input type='text' class='form-control form-control-sm' name='nama_npwp'
                                            id='nama_npwp' value="{{ $tbasuransi->nama_npwp }}"
                                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <td>TOP</td>
                                    <td> <input type='number' class='form-control form-control-sm'
                                            name='top'value="{{ $tbasuransi->top }}"
                                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}
                                            style="text-align:right;">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Kredit Limit</td>
                                    <td> <input type='number' class='form-control form-control-sm'
                                            name='kredit_limit'value="{{ $tbasuransi->kredit_limit }}"
                                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}
                                            style="text-align:right;">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Disc. Part</td>
                                    <td> <input type='number' class='form-control form-control-sm'
                                            name='disc_part'value="{{ $tbasuransi->disc_part }}"
                                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}
                                            style="text-align:right;">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Disc. Jasa</td>
                                    <td> <input type='number' class='form-control form-control-sm'
                                            name='disc_jasa'value="{{ $tbasuransi->disc_jasa }}"
                                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}
                                            style="text-align:right;">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Disc.Bahan</td>
                                    <td> <input type='number' class='form-control form-control-sm'
                                            name='disc_bahan'value="{{ $tbasuransi->disc_bahan }}"
                                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}
                                            style="text-align:right;">
                                    </td>
                                </tr>
                                <tr>
                                    <td>PPh Jasa</td>
                                    <td> <input type='number' class='form-control form-control-sm'
                                            name='pph_jasa'value="{{ $tbasuransi->pph_jasa }}"
                                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}
                                            style="text-align:right;">
                                    </td>
                                </tr>
                                <tr>
                                    <td>PPh Material</td>
                                    <td> <input type='number' class='form-control form-control-sm'
                                            name='pph_material'value="{{ $tbasuransi->pph_material }}"
                                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}
                                            style="text-align:right;">
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="aktif"
                                                name="aktif"
                                                {{ (str_contains($vdata['title'], 'Tambah') ? 'checked' : $tbasuransi->aktif == 'Y') ? 'checked' : '' }}
                                                {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}>
                                            <label class="aktif" for="flexCheckDefault">
                                                Aktif
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <?php
                if (strpos($vdata['title'], 'Tambah') !== false) {
                } else {
                ?>
                        <div class="col-md-12">
                            <label for="nama" class="form-label mb-1 mt-3">User</label>
                            <input type="text" class="form-control" name="user" id="user"
                                value="{{ $tbasuransi->user }}" readonly>
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
        $('.formtbasuransi').submit(function(e) {
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
                        //     window.location.href = '/tbasuransi';
                        // });
                        // window.location = '/tbasuransi';
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
