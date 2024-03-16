<?php
$submenu = 'estimasi_bp';
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
?>


<!-- Modal -->
<div class="modal-dialog" style="max-width: 50%;">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">
                {{ $vdata['title'] }}{{ ' ' . $estimasi_bp->nopolisi . ' - ' . $estimasi_bp->noestimasi }}
                {{-- @if (isset($vdata))
                    {{ $vdata['title'] }}
                @endif --}}
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{ $action }}" method="post" class="formtambahjasa_bp">
            @csrf
            @if ($estimasi_bpd->id)
                @method('put')
            @endif
            <div class="modal-body">
                <input type="hidden" class="form-control-sm" name="username" id="username"
                    value="{{ $session->get('username') }}">
                <input type="hidden" class="form-control-sm" name="noestimasi" id="noestimasi"
                    value="{{ $estimasi_bp->noestimasi }}">
                <input type="hidden" class='form-control form-control-sm' id='id' name='id' size='50'
                    autocomplete='off' readonly value="{{ $estimasi_bpd->id }}">
                <div class="row">
                    <div class='col-md-12'>
                        <table style=font-size:12px; class='table table-borderless table-sm table-hover'>
                            <tr>
                                <td>Asuransi</td>
                                <td>
                                    <div class="input-group mb-1">
                                        <input type="text" class="form-control form-control-sm" name="kdasuransi"
                                            id="kdasuransi" value="{{ $estimasi_bp->kdasuransi }}"
                                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }} readonly>
                                        <input type="text" style="width: 40%" class="form-control form-control-sm"
                                            name="nmasuransi" id="nmasuransi" value="{{ $estimasi_bp->nmasuransi }}"
                                            readonly>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Jasa</td>
                                <td>
                                    <div class="input-group mb-1">
                                        <input type="hidden" class="form-control form-control-sm" name="jenis"
                                            id="jenis" value="JASA">
                                        <input type="text" class="form-control form-control-sm" name="kode"
                                            id="kode" value="{{ $estimasi_bpd->kode }}"
                                            {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                        <input type="text" style="width: 40%" class="form-control form-control-sm"
                                            name="nama" id="nama" value="{{ $estimasi_bpd->nama }}" readonly>
                                        <button class="btn btn-outline-secondary btn-sm" type="button" id="carijasa"
                                            {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}><i
                                                class="fa fa-search"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Qty</td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" name="qty"
                                        id="qty" value="{{ $estimasi_bpd->qty }}" style="text-align:right;"
                                        {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                </td>
                            </tr>
                            <tr>
                                <td>Harga</td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" name="harga"
                                        id="harga" value="{{ $estimasi_bpd->harga }}" style="text-align:right;"
                                        {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                </td>
                            </tr>
                            <tr>
                                <td>Discount (%)</td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" name="pr_discount"
                                        id="pr_discount" value="{{ $estimasi_bpd->pr_discount }}"
                                        style="text-align:right;"
                                        {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                </td>
                            </tr>
                            <tr>
                                <td>Subtotal</td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" name="subtotal"
                                        id="subtotal" style="text-align:right;" value="{{ $estimasi_bpd->subtotal }}"
                                        readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td>
                                    <textarea type='text' rows='3' class="form-control form-control-sm" name="kerusakan" id="kerusakan"
                                        {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>{{ $estimasi_bpd->kerusakan }}</textarea>
                                </td>
                            </tr>
                        </table>
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
        $('#qty').on('keyup', function(e) {
            hit_subtotal();
        })
        $('#pr_discount').on('keyup', function(e) {
            hit_subtotal();
        })
        $('#qty').on('blur', function(e) {
            hit_subtotal();
        })
        $('#pr_discount').on('blur', function(e) {
            hit_subtotal();
        })
        $('#kode').on('focus', function(e) {
            hit_subtotal();
        })

        $('.formtambahjasa_bp').submit(function(e) {
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
                        toastr.info('Data berhasil di simpan, silahkan melanjutkan')
                        $('#modaltambahdetail').modal('hide');
                        $('#modaldetailestimasi').modal('show');
                        reload_table_estimasi_jasa();
                        reload_table_estimasi_bp();
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

    $('#carijasa').click(function(e) {
        var kdasuransi = $("#kdasuransi").val();
        e.preventDefault();
        $.ajax({
            url: "<?= url('carijasa_bp') ?>",
            dataType: "json",
            data: {
                'kdasuransi': kdasuransi,
            },
            success: function(response) {
                $('#modalcarijasa').html(response.body)
                $('#modalcarijasa').modal('show');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })
    $('#kode').on('blur', function(e) {
        let kdasuransi = $("#kdasuransi").val();
        let cari = $(this).val()
        if (cari !== "") {
            $.ajax({
                url: "<?= url('repljasa_bp') ?>",
                type: 'get',
                data: {
                    'kdasuransi': kdasuransi,
                    'kode': cari
                },
                success: function(data) {
                    let data_response = JSON.parse(data);
                    if (data_response['kode'] == '') {
                        $('#kode').val('');
                        $('#nama').val('');
                        return;
                    } else {
                        $('#kode').val(data_response['kode']);
                        $('#nama').val(data_response['nama']);
                    }
                },
                error: function() {
                    $('#kode').val('');
                    $('#nama').val('');
                    return;
                }
            })
        }
    })

    function hit_subtotal() {
        document.getElementById('qty').value == "" ? document.getElementById('qty').value = 0 : document.getElementById(
            'qty').value
        document.getElementById('harga').value == "" ? document.getElementById('harga').value = 0 : document
            .getElementById('harga').value
        document.getElementById('pr_discount').value == "" ? document.getElementById('pr_discount').value = 0 : document
            .getElementById('pr_discount').value
        var lharga = (parseFloat(document.getElementById('qty').value) * parseFloat(document.getElementById('harga')
            .value));
        var ldisc = lharga - (lharga * (document.getElementById('pr_discount').value)) / 100;
        var lsubtotal = ldisc;
        document.getElementById('subtotal').value = lsubtotal;
    }
</script>
