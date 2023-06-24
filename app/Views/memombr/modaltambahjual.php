<?php
$session = session();
$pakai = session()->get('pakai');
$tambah = session()->get('tambah');
$edit = session()->get('edit');
$hapus = session()->get('hapus');
$proses = session()->get('proses');
$unproses = session()->get('unproses');
$cetak = session()->get('cetak');
?>

<script src="<?= base_url('/js/autoNumeric.js') ?>" crossorigin="anonymous"></script>

<div class="modal fade" role="dialog" id="modaltambahjual" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 50%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title . ' ' . $memombr['nomemo']; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?= form_open('estimasi/simpanestimasidxxx', ['class' => 'forminputjual']) ?>
        <input type='hidden' class='form-control form-control-sm mb-2' value="<?= $memombr['nomemo'] ?>" name="nomemo" id="nomemo" readonly style="width: 5%">
        <?= csrf_field(); ?>
        <div class="row mb-2">
          <table class="table table-striped" style="width:100%">
            <thead>
              <tr>
                <!-- <th>ID</th> -->
                <th width="400">Nama Produk</th>
                <th>Modal</th>
                <th>Jual</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody">
              <input type="hidden" name="id" id="id">
              <td>
                <input type="text" class="form-control form-control-sm" placeholder="Nama Produk" name="nama_produk" id="nama_produk">
                <div class="invalid-feedback errorNama_produk">
                </div>
              </td>
              <td><input type="text" name="modal" id="modal" class="form-control form-control-sm text-end" value=0></td>
              <td><input type="text" name="jual" id="jual" class="form-control form-control-sm text-end" value=0></td>
              <td><button type="submit" id="btnaddjual" class="btn btn-primary btn-sm btnaddjual"><i class="fa fa-save"></i></button></td>
              </tbody>
          </table>
        </div>
        <div class="row mt-2 mb-2">
          <div id="tbl_memombrd"></div>
        </div>
        <?= form_close() ?>
        <div class="modal-footer">
          <button type="submit" id="tbnaddjual" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    var myModal = document.getElementById('modaltambahjual')
    var myInput = document.getElementById('nama_produk')
    myModal.addEventListener('shown.bs.modal', function() {
      myInput.focus()
    })

    $(document).ready(function() {
      // reload_table_memombrd();
      $('#modal').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '0'
      })
      $('#jual').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '0'
      })
    });

    $('.forminputjual').submit(function() {
      $.ajax({
        type: "post",
        url: "<?= site_url('memombr/simpanjual') ?>",
        data: $(this).serialize(),
        dataType: "json",
        beforeSend: function() {
          $('.tbnaddjual').attr('disable', 'disabled')
          $('.tbnaddjual').html('<i class="fa fa-spin fa-spinner"></i>')
        },
        complete: function() {
          $('.tbnaddjual').removeAttr('disable')
          $('.tbnaddjual').html('<i class="fa fa-plus"></i>')
        },
        success: function(response) {
          if (response.error) {
            if (response.error.nama_produk) {
              // alert(response.error.kodejasa);
              $('#nama_produk').addClass('is-invalid');
              $('.errorNama_produk').html(response.error.nama_produk);
            } else {
              $('.errorNama_produk').fadeOut();
              $('#nama_produk').removeClass('is-invalid');
              $('#nama_produk').addClass('is-valid');
            }
          } else {
            $('.errorNama_produk').fadeOut();
            $('#nama_produk').removeClass('is-invalid');
            $('#nama_produk').addClass('is-valid');
            $('#modaltambahjual').modal('hide');
            reload_table_memombrd();
            swal({
              icon: 'success',
              title: response.sukses, //"Data berhasil ditambah ",
              text: response.sukses,
            });
            document.getElementById("nama_produk").value = "";
            document.getElementById("modal").value = "0";
            document.getElementById("jual").value = "0";
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      });
      return false;
    })
  </script>