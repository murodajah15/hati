<?php
$session = session();
// var_dump($vdata);
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
        <form action="updatetasklisttipe_bpd" method="post" class="formtasklisttipe_bpd">
            @csrf
            @if ($tasklisttipe_bpd->id)
                @method('get')
            @endif
            <div class="modal-body">
                <input type="hidden" class="form-control-sm" name="username" id="username"
                    value="{{ $session->get('username') }}">
                <input type="hidden" class="form-control-sm" name="kodelama" id="kodelama"
                    value="{{ $tasklisttipe_bpd->kdpaket }}">
                <input type="hidden" class="form-control" name="id" id="id" style="width:10em;"
                    value="{{ $tasklisttipe_bpd->id }}" readonly>
                <div class="col-md-12 mb-2">
                    <label for="kode" class="form-label mb-1">Kode Jasa</label>
                    <input type="text" class="form-control" name="kode" id="kode" style="width:10em;"
                        value="{{ $tasklisttipe_bpd->kode }}" readonly>
                    <label for="nama" class="form-label mb-1">Nama </label>
                    <input type="text" class="form-control" name="nama" id="nama"
                        value="{{ $tasklisttipe_bpd->nama }}" readonly>
                    <label for="harga" class="form-label mb-1">Harga</label>
                    <input type="number" class="form-control" name="harga" id="hargajasa"
                        style="text-align:right;width:10em;" value="{{ $tasklisttipe_bpd->harga }}"
                        {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : 'autofocus' }}>
                </div>

                {{-- <div class="container-fluid">
                    <div class="row mb-2 mt-1"> --}}
                <div class="col-12 col-sm-4">
                    <?php
                    date_default_timezone_set('Asia/Jakarta');
                    $tglpaket = date('Y-m-d H:i:s');
                    $tglwo = date('Y-m-d H:i:s');
                    ?>
                </div>

                {{-- </div>
                </div> --}}

                <?php
                if (strpos($vdata['title'], 'Tambah') !== false) {
                } else {
                ?>
                <div class="col-md-12">
                    <label for="nama" class="form-label mb-1 mt-0">User</label>
                    <input type="text" class="form-control" name="user" id="user"
                        value="{{ $tasklisttipe_bpd->user }}" readonly>
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
    var myModal = document.getElementById('modaleditdetail')
    var myInput = document.getElementById('hargajasa')
    // myModal.addEventListener('shown.bs.modal', function() {
    //     myInput.focus()
    // })
    $(myModal).on('shown.bs.modal', function() {
        $(this).find(myInput).focus();
    });

    $(document).ready(function() {
        $('.formtasklisttipe_bpd').submit(function(e) {
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
                        if (response.sukses == true) {
                            $('#modaleditdetail').modal('hide');
                            toastr.info('Data berhasil di simpan, silahkan melanjutkan')
                        } else {
                            toastr.error('Data gagal di simpan, silahkan ulangi')
                        }
                        reload_table_tasklisttipe_bpd()
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
