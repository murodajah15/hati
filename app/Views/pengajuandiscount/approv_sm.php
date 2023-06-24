<script src="<?= base_url('/js/autoNumeric.js') ?>" crossorigin="anonymous"></script>

<?php $session = session(); ?>

<!-- Modal -->
<div class="modal fade" id="modalapprov" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 50%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('pengajuandiscount/simpanapprov_sm', ['class' => 'formapprov_sm']) ?>
      <input type="hidden" class="form-control" name="id" id="id" value="<?= $pengajuandiscount['id'] ?>">
      <input type="hidden" class='form-control mb-2' name='pembelian_accessories' id='pembelian_accessories' value="<?= $pengajuandiscount['pembelian_accessories'] ?>" readonly>
      <input type="hidden" class='form-control mb-2' name='bonus_accessories' id='bonus_accessories' value="<?= $pengajuandiscount['bonus_accessories'] ?>" readonly>
      <input type="hidden" class='form-control mb-2' name='booking_fee' id='booking_fee' value="<?= $pengajuandiscount['booking_fee'] ?>" readonly>
      <input type="hidden" class='form-control mb-2' name='discount_team_harga' id='discount_team_harga' value="<?= $pengajuandiscount['discount_team_harga'] ?>" readonly>
      <input type="hidden" class='form-control mb-2' name='discount_cashback' id='discount_cashback' value="<?= $pengajuandiscount['discount_cashback'] ?>" readonly>
      <input type="hidden" class='form-control mb-2' name='paket' id='paket' value="<?= $pengajuandiscount['paket'] ?>" readonly>
      <input type="hidden" class='form-control mb-2' name='mediator' id='mediator' value="<?= $pengajuandiscount['mediator'] ?>" readonly>
      <input type="hidden" class='form-control mb-2' name='lain_lain' id='lain_lain' value="<?= $pengajuandiscount['lain_lain'] ?>" readonly>
      <div class="modal-body">
        <div class="row mb-2">
          <div class="input-group">
            <div class="col-md-4">
              <label for="nama" class="form-label mb-1">No. Pengajuan</label>
              <input type='text' class='form-control mb-2' id="nomor" name="nomor" readonly style="width: 100%" value="<?= $pengajuandiscount['nomor'] ?>" readonly>
            </div>
            <div class="col-md-4">
              <label for="nama" class="form-label mb-1">Tanggal (M-D-Y)</label>
              <input type="date" class='form-control mb-2' name='tanggal' id='tanggal' style="width: 100%" value="<?= $pengajuandiscount['tanggal'] ?>" readonly>
            </div>
          </div>
          <label for="nama" class="form-label mb-0"><b><u>MEMO</u></b></label>
          <div class="input-group mb-2">
            <div class="col-md-4">
              <input type="text" class="form-control" placeholder="No. Memo" name="nomemo" id="nomemo" value="<?= $pengajuandiscount['nomemo'] ?>" style="width: 100%" readonly>
            </div>
            <div class="col-md-6">
              <input type="datetime-local" class="form-control" placeholder="Tgl. Memo" name="tglmemo" id="tglmemo" value="<?= $memombr['tanggal'] ?>" style="width: 100%" readonly>
            </div>
          </div>
          <div class="col-md-12">
            <label for="nama" class="form-label mb-0"><b><u>Approval</u></b></label>
            <select class="form-select mb-2" name="status_approv_sm" id="status_approv_sm">
              <option value="">[Pilih Persetujuan]
                <?php
                $arr = array("SETUJUI", "TIDAK DISETUJUI");
                $jml_kata = count($arr);
                for ($c = 0; $c < $jml_kata; $c += 1) {
                  if ($arr[$c] == $pengajuandiscount['status_approv_sm']) {
                    echo "<option value='$arr[$c]' selected>$arr[$c] </option>";
                  } else {
                    echo "<option value='$arr[$c]'> $arr[$c] </option>";
                  }
                }
                echo "</select>";
                ?>
            </select>
          </div>
          <div class="col-md-12">
            <label for="nama" class="form-label mb-0"><b><u>Keterangan Approv</u></b></label>
            <textarea rows="3" class='form-control form-control-sm mb-2' name='ket_approv_sm' id='ket_approv_sm'><?= $pengajuandiscount['ket_approv_sm'] ?></textarea>
          </div>
          <div class="modal-footer">
            <button type="submit" id="btnsimpan" class="btn btn-primary btnsimpan">Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          </div>
        </div>
      </div>
      <?= form_close() ?>
    </div>
  </div>
</div>


<script>
  var myModal = document.getElementById('modaldetail')
  // var myInput = document.getElementById('nama')
  // myModal.addEventListener('shown.bs.modal', function() {
  //   myInput.focus()
  // })

  $(document).ready(function() {
    $('#booking_fee').autoNumeric('init', {
      aSep: ',',
      aDec: '.',
      mDec: '0'
    })

    $('.formapprov_sm').submit(function(e) {
      e.preventDefault();
      $.ajax({
        type: "post",
        url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType: "json",
        beforeSend: function() {
          $('.btnsimpan').attr('disable', 'disabled')
          $('.btnsimpan').html('<i class="fa fa-spin fa-spinner"></i>')
        },
        complete: function() {
          $('.btnsimpan').removeAttr('disable')
          $('.btnsimpan').html('Simpan')
        },
        success: function(response) {
          if (response.error) {
            // alert(response.error);
          } else {
            // alert(response.sukses);
            $('#modalapprov').modal('hide');
            $('#modaldetail').modal('hide');
            // swal({
            //   title: "Data berhasil disimpan",
            //   text: "",
            //   icon: "success",
            //   buttons: true,
            //   dangerMode: true,
            // })

            swal({
              title: "Data Berhasil diupdate ",
              text: "",
              icon: "success"
            })
            reload_table();
            // .then(function() {
            //   window.location.href = '/pengajuandiscount';
            // });

            // window.location = '/pengajuandiscount';
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      });
      return false;
    })
  });
</script>