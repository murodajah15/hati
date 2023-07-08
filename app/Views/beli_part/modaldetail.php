<?php
$session = session();
$pakai = session()->get('pakai');
$tambah = session()->get('tambah');
$edit = session()->get('edit');
$hapus = session()->get('hapus');
$proses = session()->get('proses');
$unproses = session()->get('unproses');
$cetak = session()->get('cetak');
$ppn = session()->get('ppn');
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
        <?php if ($edit == 1) {
        ?>
          <?= form_open('beli_part/update_beli_part', ['class' => 'form_update_beli_part']) ?>
          <?= csrf_field(); ?>
          <div class="row mb-1 mt-1">
            <div class="col-12 col-sm-6">
              <?php
              date_default_timezone_set('Asia/Jakarta');
              $tanggal = date('Y-m-d H:i:s');
              ?>
              <input type="hidden" class="form-control" name="id" id="id" value="<?= $beli_part['id'] ?>" readonly>
              <label for="nama" class="form-label mb-1">No. PO / Tanggal (M-D-Y)</label>
              <div class="input-group mb-1">
                <input type='text' class='form-control form-control-sm mb-1' value="<?= $beli_part['nopo'] ?>" id="nopojadi" name="nopojadi" readonly style="width: 5%">
                <input type="datetime-local" class='form-control form-control-sm mb-1' name='tanggal' id='tanggal' value="<?= $beli_part['tanggal'] ?>" style="width: 40%" readonly>
              </div>
              <label for="nama" class="form-label mb-1">Supplier</label>
              <div class="input-group mb-1">
                <input type="text" style="width:10%;" name="kdsupplier" id="kdsupplier" value="<?= $beli_part['kdsupplier'] ?>" class="form-control form-control-sm mb-0" placeholder="" readonly>
                <input type="text" style="width:40%;" name="nmsupplier" id="nmsupplier" value="<?= $beli_part['nmsupplier'] ?>" class="form-control form-control-sm mb-0" readonly>
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
                  if ($arr[$c] == $beli_part['jnsorder']) {
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
              <input type="text" class="form-control form-control-sm mb-1" name="reference" id="reference" value="<?= $beli_part['reference'] ?>" readonly>
              <label for="nama" class="form-label mb-1">Biaya 1 / Jumlah</label>
              <div class="input-group mb-1">
                <input type="text" class="form-control form-control-sm mb-0" name="biaya1" id="biaya1" value="<?= $beli_part['biaya1'] ?>" readonly>
                <input type="text" class="form-control form-control-sm mb-0" name="nbiaya1" id="nbiaya1" value="<?= $beli_part['nbiaya1'] ?>" placeholder="nbiaya1" style="text-align:right;" readonly>
              </div>
              <label for="nama" class="form-label mb-1">Biaya 2 / Jumlah</label>
              <div class="input-group mb-2">
                <input type="text" class="form-control form-control-sm mb-0" name="biaya2" id="biaya2" value="<?= $beli_part['biaya2'] ?>" readonly>
                <input type="text" class="form-control form-control-sm mb-0" name="nbiaya2" id="nbiaya2" value="<?= $beli_part['nbiaya2'] ?>" placeholder="nbiaya2" style="text-align:right;" readonly>
              </div>
              <label for="nama" class="form-label mb-1">Catatan</label>
              <textarea class="form-control" name="catatan" id="catatan" rows="2" readonly></textarea>
            </div>
            <div class="col-12 col-sm-3">
              <label for="nama" class="form-label mb-1">Total Biaya 1+2</label>
              <input type="text" class="form-control form-control-sm mb-1" name="total_biaya" id="total_biaya" value="<?= $beli_part['total_biaya'] ?>" placeholder="total_biaya" style="text-align:right;" readonly>
              <label for="keluhan" class="form-label mb-1">Subtotal</label>
              <input type="text" class="form-control form-control-sm mb-1" name="subtotal" id="subtotal" value="<?= $beli_part['subtotal'] ?>" style="text-align:right;" readonly>
              <label for="keluhan" class="form-label mb-1">Total Sementara</label>
              <input type="text" class="form-control form-control-sm mb-1" name="totalsmt" id="totalsmt" value="<?= $beli_part['totalsmt'] ?>" style="text-align:right;" readonly>
              <label for="keluhan" class="form-label mb-1">PPN % / PPN (Rp.)</label>
              <div class="input-group mb-1">
                <input type="text" class="form-control form-control-sm mb-0" name="ppn" id="ppn" value="<?= $beli_part['ppn'] ?>" style="width: 5%; text-align:right;" readonly>
                <input type="text" class="form-control form-control-sm mb-0" name="rp_ppn" id="rp_ppn" value="<?= $beli_part['rp_ppn'] ?>" placeholder="rp_ppn" style="width: 50%; text-align:right;" readonly>
              </div>
              <label for="keluhan" class="form-label mb-1">Materai</label>
              <input type="text" class="form-control form-control-sm mb-1" name="materai" id="materai" value="<?= $beli_part['materai'] ?>" style="text-align:right;" readonly>
              <label for="keluhan" class="form-label mb-1">Total</label>
              <input type="text" class="form-control form-control-sm mb-1" name="total" id="total" value="<?= $beli_part['total'] ?>" style="text-align:right;" readonly>
            </div>
            <div class="col-12 col-sm-3">
              <label for="nama" class="form-label mb-0">Cara Bayar</label>
              <select class="form-select form-select-sm mb-1" name="cara_bayar" id="cara_bayar" disabled>
                <option value="">[Pilih Cara Bayar]</option>
                <?php
                $arr = array("Tunai", "Transfer", "Kartu Debit", "Cek/BG", "Kartu Kredit", "Marketplace");
                $jml_kata = count($arr);
                for ($c = 0; $c < $jml_kata; $c += 1) {
                  if ($arr[$c] == $beli_part['cara_bayar']) {
                    echo "<option value='$arr[$c]' selected>$arr[$c] </option>";
                  } else {
                    echo "<option value='$arr[$c]'> $arr[$c] </option>";
                  }
                }
                ?>
              </select>
              <label for="keluhan" class="form-label mb-0">Jatuh Tempo (Hari)</label>
              <input type="number" class="form-control form-control-sm mb-1" name="tempo" id="tempo" value="<?= $beli_part['tempo'] ?>" readonly>
              <label for="keluhan" class="form-label mb-0">Tanggal Jatuh Tempo</label>
              <input type="date" class="form-control form-control-sm mb-1" name="tgljttempo" id="tgljttempo" value="<?= $beli_part['tgljttempo'] ?>" readonly>
              <!-- value=@Model.EndDate.ToString("MM-dd-yyyy") -->
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
          <?= form_close() ?>
      </div>
    <?php
        } else {
    ?>
      <?php
          $session = session();
          if (session()->get('nama') == "") {
      ?>
        <script>
          window.setTimeout(function() {
            window.location.href = "dashboard";
          }, 0);
        </script>
      <?php
          } else {
            echo "<p>Anda tidak berhak membuat Close Faktur</p>";
          }
      ?>

      <!-- <button class="btn btn-flat btn-primary btn-sm mb-3 tomboltambah" type="button" disabled><i class="fa fa-plus"></i> Tambah</button> -->
    <?php
        }
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

  function hit_total() {
    let textnbiaya1 = document.getElementById("nbiaya1").value
    let nbiaya1 = textnbiaya1.replace(/,/g, "");
    if (nbiaya1 === "") {
      nbiaya1 = 0;
    }
    let textnbiaya2 = document.getElementById("nbiaya2").value
    let nbiaya2 = textnbiaya2.replace(/,/g, "");
    if (nbiaya2 === "") {
      nbiaya2 = 0;
    }
    // let textrp_ppn = document.getElementById("rp_ppn").value
    // let rp_ppn = textrp_ppn.replace(/,/g, "");
    // if (rp_ppn === "") {
    //   rp_ppn = 0;
    // }
    let textppn = document.getElementById("ppn").value
    let ppn = textppn.replace(/,/g, "");
    if (ppn === "") {
      ppn = 0;
    }
    let textmaterai = document.getElementById("materai").value
    let materai = textmaterai.replace(/,/g, "");
    if (materai === "") {
      materai = 0;
    }
    let total_biaya = parseFloat(nbiaya1) + parseFloat(nbiaya2)
    document.getElementById("total_biaya").value = total_biaya.toLocaleString('en-US');
    let totalsmt = parseFloat(total_biaya)
    document.getElementById("totalsmt").value = totalsmt.toLocaleString('en-US');
    let rp_ppn = parseFloat(totalsmt) * (parseFloat(ppn) / 100);
    document.getElementById("rp_ppn").value = rp_ppn.toLocaleString('en-US');
    let total = parseFloat(totalsmt) + parseFloat(rp_ppn) + parseFloat(materai)
    document.getElementById("total").value = total.toLocaleString('en-US');
  }

  $('.form_update_beli_part').on('click', '.btnupdatebeli_part', function(e) {
    $('.form_update_beli_part').submit(function(e) {
      e.preventDefault();
      $.ajax({
        url: $(this).attr('action'),
        // url: "<?= site_url('beli_part/update_beli_part') ?>",
        type: "post",
        data: $(this).serialize(),
        dataType: "json",
        beforeSend: function() {
          $('.btnupdatebeli_part').attr('disable', 'disabled')
          $('.btnupdatebeli_part').prop('disable', true)
          $('.btnupdatebeli_part').html('<i class="fa fa-spin fa-spinner"></i>')
        },
        complete: function() {
          $('.btnupdatebeli_part').removeAttr('disable')
          $('.btnupdatebeli_part').html('<i class="fa fa-file"></i> Simpan')
          $('.btnupdatebeli_part').prop('disabled', false)
        },
        success: function(response) {
          if (response.error) {
            // alert('error');
            if (response.error.kdsupplier) {
              $('#kdsupplier').addClass('is-invalid');
              $('.errorKdsupplier').html(response.error.kdsupplier);
            } else {
              $('.errorKdsupplier').fadeOut();
              $('#kdsupplier').removeClass('is-invalid');
              $('#kdsupplier').addClass('is-valid');
            }
            if (response.error.jnsorder) {
              $('#jnsorder').addClass('is-invalid');
              $('.errorJnsorder').html(response.error.jnsorder);
            } else {
              $('.errorJnsorder').fadeOut();
              $('#jnsorder').removeClass('is-invalid');
              $('#jnsorder').addClass('is-valid');
            }
          } else {
            // alert('sukses'.response.sukses);
            $('#modaledit').modal('hide');
            let hasil;
            hasil = document.getElementById("title").value;
            swal({
              title: "Berhasil diupdate ",
              text: hasil,
              icon: "success",
            })
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      });
    });
  });

  $('#kdsuppliar').on('keypress', function(e) {
    if (e.which == 13) {
      var keyPressed = event.keyCode || event.which;
      if (keyPressed === 13) {
        alert("Press tab to continue!");
        event.preventDefault();
        return false;
      }
    }
  });
  $('#carisupplier').click(function(e) {
    e.preventDefault();
    $.ajax({
      url: "<?= site_url('beli_part/caridatasupplier') ?>",
      dataType: "json",
      success: function(response) {
        $('.viewmodalcari').html(response.data).show();
        $('#modalcarisupplier').modal('show');
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  })
  $('#kdsupplier').on('blur', function(e) {
    let cari = $(this).val()
    if (cari !== "") {
      $.ajax({
        url: "<?= site_url('beli_part/replsupplier') ?>",
        type: 'post',
        data: {
          'kode': cari
        },
        success: function(data) {
          let data_response = JSON.parse(data);
          if (data_response['kdsupplier'] == '') {
            $('#kdsupplier').val('');
            $('#nmsupplier').val('');
            return;
          } else {
            $('#kdsupplier').val(data_response['kdsupplier']);
            $('#nmsupplier').val(data_response['nmsupplier']);
          }
        },
        error: function() {
          $('#kdsupplier').val('');
          $('#nmsupplier').val('');
          return;
          // console.log('file not fount');
        }
      })
      // console.log(cari);
    } else {
      $('#kdsupplier').val('');
      $('#nmsupplier').val('');
    }
  })

  function beli_part() {
    let $nopo = document.getElementById("nopo").value;
    $.ajax({
      method: "GET",
      data: {
        nopo: $nopo,
      },
      url: "<?= site_url('beli_part/table_beli_part'); ?>",
      beforeSend: function(f) {
        $('.btnreload').attr('disable', 'disabled')
        $('.btnreload').html('<i class="fa fa-spin fa-spinner"></i>')
        // alert('1');
        $('#table_wo_part').html('<center>Loading Table ...</center>');
      },
      success: function(data) {
        // alert(data);
        $('#table_wo_part').html(data);
        $('.btnreload').removeAttr('disable')
        $('.btnreload').html('<i class="fa fa-spinner">')
      }
    })
  }

  $("#modaledit").on('hide.bs.modal', function() {
    // alert('The modal is about to be hidden.');
    // reload_table_faktur_bp();
    reload_table();
  });
</script>