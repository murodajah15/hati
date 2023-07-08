<?php
$session = session();
$ses_data = [
  'form'       => 'detail',
];
$session->set($ses_data);
?>


<script src="<?= base_url('/js/autoNumeric.js') ?>" crossorigin="anonymous"></script>

<div class="modal fade" id="modaldetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 90%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <input type="hidden" id='title' value="<?= $title ?>">
      </div>
      <div class="modal-body">
        <?= form_open('po_part/update_po_part', ['class' => 'form_update_po_part']) ?>
        <?= csrf_field(); ?>
        <div class="row mb-1 mt-1">
          <div class="col-12 col-sm-6">
            <?php
            date_default_timezone_set('Asia/Jakarta');
            $tanggal = date('Y-m-d H:i:s');
            ?>
            <input type="hidden" class="form-control" name="id" id="id" value="<?= $po_part['id'] ?>" readonly>
            <label for="nama" class="form-label mb-1">No. PO / Tanggal (M-D-Y)</label>
            <div class="input-group mb-1">
              <input type='text' class='form-control form-control-sm mb-1' value="<?= $po_part['nopo'] ?>" id="nopo" name="nopo" readonly style="width: 5%">
              <input type="datetime-local" class='form-control form-control-sm mb-1' name='tanggal' id='tanggal' value="<?= $po_part['tanggal'] ?>" style="width: 40%" readonly>
            </div>
            <label for="nama" class="form-label mb-1">Supplier</label>
            <div class="input-group mb-1">
              <input type="text" style="width:10%;" name="kdsupplier" id="kdsupplier" value="<?= $po_part['kdsupplier'] ?>" class="form-control form-control-sm mb-0" placeholder="" readonly>
              <input type="text" style="width:40%;" name="nmsupplier" id="nmsupplier" value="<?= $po_part['nmsupplier'] ?>" class="form-control form-control-sm mb-0" readonly>
              <button class="btn btn-outline-secondary btn-sm" type="button" id="carisupplier" disabled><i class="fa fa-search"></i></button>
              <div class="invalid-feedback errorKdsupplier">
              </div>
            </div>
            <label for="nama" class="form-label mb-0">Jenis Order</label>
            <select class="form-select form-select-sm mb-1" name="jnsorder" id="jnsorder" disabled>
              <option value="">[Pilih Jenis Order]</option>
              <?php
              $arr = array("NORMAL", "URGENT", "HOTLINE", "LAIN-LAIN");
              $jml_kata = count($arr);
              for ($c = 0; $c < $jml_kata; $c += 1) {
                if ($arr[$c] == $po_part['jnsorder']) {
                  echo "<option value='$arr[$c]' selected>$arr[$c] </option>";
                } else {
                  echo "<option value='$arr[$c]'> $arr[$c] </option>";
                }
              }
              ?>"
            </select>
            <div class="invalid-feedback errorJnsorder">
            </div>
            <label for="nama" class="form-label mb-1">Reference</label>
            <input type="text" class="form-control form-control-sm mb-1" name="reference" id="reference" value="<?= $po_part['reference'] ?>" readonly>
            <label for="nama" class="form-label mb-1">Biaya 1 / Jumlah</label>
            <div class="input-group mb-1">
              <input type="text" class="form-control form-control-sm mb-0" name="biaya1" id="biaya1" value="<?= $po_part['biaya1'] ?>" readonly>
              <input type="text" class="form-control form-control-sm mb-0" name="nbiaya1" id="nbiaya1" value="<?= $po_part['nbiaya1'] ?>" placeholder="nbiaya1" style="text-align:right;" readonly>
            </div>
            <label for="nama" class="form-label mb-1">Biaya 2 / Jumlah</label>
            <div class="input-group mb-2">
              <input type="text" class="form-control form-control-sm mb-0" name="biaya2" id="biaya2" value="<?= $po_part['biaya2'] ?>" readonly>
              <input type="text" class="form-control form-control-sm mb-0" name="nbiaya2" id="nbiaya2" value="<?= $po_part['nbiaya2'] ?>" placeholder="nbiaya2" style="text-align:right;" readonly>
            </div>
            <label for="nama" class="form-label mb-1">Catatan</label>
            <textarea class="form-control" name="catatan" id="catatan" rows="2" readonly></textarea>
          </div>
          <div class="col-12 col-sm-3">
            <label for="nama" class="form-label mb-1">Total Biaya 1+2</label>
            <input type="text" class="form-control form-control-sm mb-1" name="total_biaya" id="total_biaya" value="<?= $po_part['total_biaya'] ?>" placeholder="total_biaya" style="text-align:right;" readonly>
            <label for="keluhan" class="form-label mb-1">Subtotal</label>
            <input type="text" class="form-control form-control-sm mb-1" name="subtotal" id="subtotal" value="<?= $po_part['subtotal'] ?>" style="text-align:right;" readonly>
            <label for="keluhan" class="form-label mb-1">Total Sementara</label>
            <input type="text" class="form-control form-control-sm mb-1" name="totalsmt" id="totalsmt" value="<?= $po_part['totalsmt'] ?>" style="text-align:right;" readonly>
            <label for="keluhan" class="form-label mb-1">PPN % / PPN (Rp.)</label>
            <div class="input-group mb-1">
              <input type="text" class="form-control form-control-sm mb-0" name="ppn" id="ppn" value="<?= $po_part['ppn'] ?>" style="width: 5%; text-align:right;" readonly>
              <input type="text" class="form-control form-control-sm mb-0" name="rp_ppn" id="rp_ppn" value="<?= $po_part['rp_ppn'] ?>" placeholder="rp_ppn" style="width: 50%; text-align:right;" readonly>
            </div>
            <label for="keluhan" class="form-label mb-1">Materai</label>
            <input type="text" class="form-control form-control-sm mb-1" name="materai" id="materai" value="<?= $po_part['materai'] ?>" style="text-align:right;" readonly>
            <label for="keluhan" class="form-label mb-1">Total</label>
            <input type="text" class="form-control form-control-sm mb-1" name="total" id="total" value="<?= $po_part['total'] ?>" style="text-align:right;" readonly>
          </div>
          <div class="col-12 col-sm-3">
            <label for="nama" class="form-label mb-0">Cara Bayar</label>
            <select class="form-select form-select-sm mb-1" name="cara_bayar" id="cara_bayar" disabled>
              <option value="">[Pilih Cara Bayar]</option>
              <?php
              $arr = array("Tunai", "Transfer", "Kartu Debit", "Cek/BG", "Kartu Kredit", "Marketplace");
              $jml_kata = count($arr);
              for ($c = 0; $c < $jml_kata; $c += 1) {
                if ($arr[$c] == $po_part['cara_bayar']) {
                  echo "<option value='$arr[$c]' selected>$arr[$c] </option>";
                } else {
                  echo "<option value='$arr[$c]'> $arr[$c] </option>";
                }
              }
              ?>
            </select>
            <label for="keluhan" class="form-label mb-0">Jatuh Tempo (Hari)</label>
            <input type="number" class="form-control form-control-sm mb-1" name="tempo" id="tempo" value="<?= $po_part['tempo'] ?>" readonly>
            <label for="keluhan" class="form-label mb-0">Tanggal Jatuh Tempo</label>
            <input type="date" class="form-control form-control-sm mb-1" name="tgljttempo" id="tgljttempo" value="<?= $po_part['tgljttempo'] ?>" readonly>
            <!-- value=@Model.EndDate.ToString("MM-dd-yyyy") -->
          </div>
        </div>
        <div class="row mb-2">
          <label for="keluhan" class="form-label mb-1"><b>Detail Barang</b></label>
          <div id="tabel_po_partdd"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        <?= form_close() ?>
      </div>
      <?php

      ?>
      <!-- </div> -->
      <!-- <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div> -->
    </div>
  </div>
</div>


<script>
  $(document).ready(function() {
    $('#nbiaya1').autoNumeric('init', {
      aSep: ',',
      aDec: '.',
      mDec: '0'
    })
    $('#nbiaya2').autoNumeric('init', {
      aSep: ',',
      aDec: '.',
      mDec: '0'
    })
    $('#total_biaya').autoNumeric('init', {
      aSep: ',',
      aDec: '.',
      mDec: '0'
    })
    $('#subtotal').autoNumeric('init', {
      aSep: ',',
      aDec: '.',
      mDec: '0'
    })
    $('#totalsmt').autoNumeric('init', {
      aSep: ',',
      aDec: '.',
      mDec: '0'
    })
    $('#ppn').autoNumeric('init', {
      aSep: ',',
      aDec: '.',
      mDec: '0'
    })
    $('#rp_ppn').autoNumeric('init', {
      aSep: ',',
      aDec: '.',
      mDec: '0'
    })
    $('#materai').autoNumeric('init', {
      aSep: ',',
      aDec: '.',
      mDec: '0'
    })
    $('#total').autoNumeric('init', {
      aSep: ',',
      aDec: '.',
      mDec: '0'
    })
    $('#nbiaya1').on('keyup', function(e) {
      hit_total();
    })
    $('#nbiaya2').on('keyup', function(e) {
      hit_total();
    })
    $('#ppn').on('keyup', function(e) {
      hit_total();
    })
    $('#materai').on('keyup', function(e) {
      hit_total();
    })
    $('#nbiaya1').on('blur', function(e) {
      hit_total();
    })
    $('#nbiaya2').on('blur', function(e) {
      hit_total();
    })
    $('#ppn').on('blur', function(e) {
      hit_total();
    })
    $('#materai').on('blur', function(e) {
      hit_total();
    })
  });

  reload_table_po_partd();

  function reload_table_po_partd() {
    $nopo = document.getElementById('nopo').value;
    // alert($nopo);
    <?php
    $session = session();
    // if ($session->get('nama') == "") {
    if (!$session->has('nama')) {
    ?>
      vexpired();

      function vexpired() {
        $(document).ready(function() {
          $('#expired').modal('show');
        });
      }
    <?php
    }
    ?>
    $.ajax({
      type: "post",
      data: {
        nopo: $("#nopo").val()
      },
      // dataType: "json",
      url: "<?= site_url('po_part/table_po_partd'); ?>",
      beforeSend: function(f) {
        $('.btnreload').attr('disable', 'disabled')
        $('.btnreload').html('<i class="fa fa-spin fa-spinner"></i>')
        // alert('1');
        $('#tabel_po_partd').html('<center>Loading Table ...</center>');
      },
      success: function(data) {
        $('#tabel_po_partdd').html(data);
        $('.btnreload').removeAttr('disable')
        $('.btnreload').html('<i class="fa fa-spinner">')
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }

  $("#modaledit").on('hide.bs.modal', function() {
    // alert('The modal is about to be hidden.');
    // reload_table_faktur_bp();
    reload_table();
  });
</script>