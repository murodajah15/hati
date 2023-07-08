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

<div class="modal fade" id="modaltambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 90%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <input type="hidden" id='title' value="<?= $title ?>">
      </div>
      <div class="modal-body">
        <?php if ($tambah == 1) {
        ?>
          <?= form_open('beli_part/simpanbeli_part', ['class' => 'formtambahbeli_part']) ?>
          <?= csrf_field(); ?>
          <div class="row mb-1 mt-1">
            <div class="col-12 col-sm-6">
              <?php
              // date_default_timezone_set('Asia/Jakarta');
              $tanggal = date('Y-m-d H:i:s');
              ?>
              <label for="nama" class="form-label mb-1">No. Pembelian / Tanggal (M-D-Y)</label>
              <div class="input-group mb-1">
                <input type='text' class='form-control form-control-sm mb-0' value="AUTO GENERATE" id="nopojadi" name="nopojadi" readonly style="width: 5%">
                <input type="datetime-local" class='form-control form-control-sm mb-0' name='tanggal' id='tanggal' value="<?= $tanggal ?>" style="width: 40%" readonly>
              </div>
              <label for="nama" class="form-label mb-0">No. PO</label>
              <div class="input-group mb-1">
                <input type="text" style="width:10%;" name="nopo" id="nopo" class="form-control form-control-sm mb-0" placeholder="">
                <input type="text" style="width:40%;" name="tglpo" id="tglpo" class="form-control form-control-sm mb-0" readonly>
                <button class="btn btn-outline-secondary btn-sm" type="button" id="caripo"><i class="fa fa-search"></i></button>
              </div>
              <label for="nama" class="form-label mb-0">Supplier</label>
              <div class="input-group mb-1">
                <input type="text" style="width:10%;" name="kdsupplier" id="kdsupplier" class="form-control form-control-sm mb-0" placeholder="" readonly>
                <input type="text" style="width:40%;" name="nmsupplier" id="nmsupplier" class="form-control form-control-sm mb-0" readonly>
                <button class="btn btn-outline-secondary btn-sm" type="button" id="carisupplier" disabled><i class="fa fa-search"></i></button>
                <div class="invalid-feedback errorKdsupplier">
                </div>
              </div>
              <label for="nama" class="form-label mb-0">Jenis Order</label>
              <input type="text" class="form-control form-control-sm mb-1" name="jnsorder" id="jnsorder" readonly>
              <!-- <select class="form-select form-select-sm mb-1 " name="jnsorder" id="jnsorder">
                <option value="">[Pilih Jenis Order]</option>
                <?php
                // $arr = array("NORMAL", "URGENT", "HOTLINE", "LAIN-LAIN");
                // $jml_kata = count($arr);
                // for ($c = 0; $c < $jml_kata; $c += 1) {
                //   echo "<option value='$arr[$c]'> $arr[$c] </option>";
                // }
                ?>
              </select> -->
              <div class="invalid-feedback errorJnsorder">
              </div>
              <label for="nama" class="form-label mb-0">Reference</label>
              <input type="text" class="form-control form-control-sm mb-1" name="reference" id="reference" readonly>
              <label for="nama" class="form-label mb-0">Biaya 1 / Jumlah</label>
              <div class="input-group mb-1">
                <input type="text" class="form-control form-control-sm mb-0" name="biaya1" id="biaya1" readonly>
                <input type="text" class="form-control form-control-sm mb-0" value=0 name="nbiaya1" id="nbiaya1" placeholder="biaya1" style="text-align:right;" readonly>
              </div>
              <label for="nama" class="form-label mb-0">Biaya 2 / Jumlah</label>
              <div class="input-group mb-1">
                <input type="text" class="form-control form-control-sm mb-0" name="biaya2" id="biaya2" readonly>
                <input type="text" class="form-control form-control-sm mb-0" value=0 name="nbiaya2" id="nbiaya2" placeholder="nbiaya2" style="text-align:right;" readonly>
              </div>
              <label for="nama" class="form-label mb-0">Catatan</label>
              <textarea class="form-control" name="catatan" id="catatan" rows="2"></textarea>
            </div>
            <div class="col-12 col-sm-3">
              <label for="nama" class="form-label mb-1">Total Biaya 1+2</label>
              <input type="text" class="form-control form-control-sm mb-1" value=0 name="total_biaya" id="total_biaya" placeholder="total_biaya" style="text-align:right;" readonly>
              <label for="keluhan" class="form-label mb-0">Subtotal</label>
              <input type="text" class="form-control form-control-sm mb-1" name="subtotalh" id="subtotalh" value=0 style="text-align:right;" readonly>
              <label for="keluhan" class="form-label mb-0">Total Sementara</label>
              <input type="text" class="form-control form-control-sm mb-1" name="totalsmt" id="totalsmt" value=0 style="text-align:right;" readonly>
              <label for="keluhan" class="form-label mb-0">PPN % / PPN (Rp.)</label>
              <div class="input-group mb-1">
                <input type="text" class="form-control form-control-sm mb-0" name="ppn" id="ppn" value="<?= $ppn ?>" style="width: 5%; text-align:right;" readonly>
                <input type="text" class="form-control form-control-sm mb-0" name="rp_ppn" id="rp_ppn" value=0 placeholder="rp_ppn" style="width: 50%; text-align:right;" readonly>
              </div>
              <label for="keluhan" class="form-label mb-0">Materai</label>
              <input type="text" class="form-control form-control-sm mb-1" name="materai" id="materai" value=0 style="text-align:right;" readonly>
              <label for="keluhan" class="form-label mb-0">Total</label>
              <input type="text" class="form-control form-control-sm mb-1" name="total" id="total" value=0 style="text-align:right;" readonly>
            </div>
            <div class="col-12 col-sm-3">
              <label for="nama" class="form-label mb-0">Cara Bayar</label>
              <input type="text" class="form-control form-control-sm mb-1" name="cara_bayar" id="cara_bayar" readonly>
              <!-- <select class="form-select form-select-sm mb-1" name="cara_bayar" id="cara_bayar">
                <option value="">[Pilih Cara Bayar]</option>
                <?php
                // $arr = array("Tunai", "Transfer", "Kartu Debit", "Cek/BG", "Kartu Kredit", "Marketplace");
                // $jml_kata = count($arr);
                // for ($c = 0; $c < $jml_kata; $c += 1) {
                //   echo "<option value='$arr[$c]'> $arr[$c] </option>";
                // }
                ?>
              </select> -->
              <label for="keluhan" class="form-label mb-0">Jatuh Tempo (Hari)</label>
              <input type="number" class="form-control form-control-sm mb-1" name="tempo" id="tempo" value=0 readonly>
              <label for="keluhan" class="form-label mb-0">Tanggal Jatuh Tempo</label>
              <input type="date" class="form-control form-control-sm mb-1" name="tgljttempo" id="tgljttempo" readonly>
              <!-- value=@Model.EndDate.ToString("MM-dd-yyyy") -->
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-flat btn-primary btnsimpanbeli_part" id="btnsimpanbeli_part"><i class="fa fa-file"></i> Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          </div>
          <?= form_close() ?>
          <!-- </form> -->
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
    $('#tempo').on('keyup', function(e) {
      tgljttempo();
    })
    $('#tempo').on('blur', function(e) {
      tgljttempo();
    })
  });

  // function dateToYMD(end_date) {
  //   var ed = new Date(end_date);
  //   var d = ed.getDate();
  //   var m = ed.getMonth() + 1;
  //   var y = ed.getFullYear();
  //   console.log(y + '-' + (m <= 9 ? '0' + m : m) + '-' + (d <= 9 ? '0' + d : d));
  //   document.getElementById('tgljttempo').value = (y + '-' + (m <= 9 ? '0' + m : m) + '-' + (d <= 9 ? '0' + d : d));
  //   return '' + y + '-' + (m <= 9 ? '0' + m : m) + '-' + (d <= 9 ? '0' + d : d);
  // }

  function tgljttempo() {
    let tempo = document.getElementById('tempo').value
    let start = $("#tanggal").val();
    let result = new Date(start);
    let end = result.setDate(result.getDate() + parseFloat(tempo));
    let ed = new Date(end);
    let d = ed.getDate();
    let m = ed.getMonth() + 1;
    let y = ed.getFullYear();
    // console.log(y + '-' + (m <= 9 ? '0' + m : m) + '-' + (d <= 9 ? '0' + d : d));
    document.getElementById('tgljttempo').value = (y + '-' + (m <= 9 ? '0' + m : m) + '-' + (d <= 9 ? '0' + d : d));
    // select date(beli_part.tanggal) as tanggal from beli_part where date(beli_part.tanggal) = '2023-07-05'
  }

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
    let textsubtotal = document.getElementById("subtotalh").value
    let subtotal = textsubtotal.replace(/,/g, "");
    let total_biaya = parseFloat(nbiaya1) + parseFloat(nbiaya2)
    document.getElementById("total_biaya").value = total_biaya.toLocaleString('en-US');
    let totalsmt = parseFloat(total_biaya) + parseFloat(subtotal)
    document.getElementById("totalsmt").value = totalsmt.toLocaleString('en-US');
    let rp_ppn = parseFloat(totalsmt) * (parseFloat(ppn) / 100);
    document.getElementById("rp_ppn").value = rp_ppn.toLocaleString('en-US');
    let total = parseFloat(totalsmt) + parseFloat(rp_ppn) + parseFloat(materai)
    document.getElementById("total").value = total.toLocaleString('en-US');
  }

  $('.formtambahbeli_part').submit(function(e) {
    e.preventDefault();
    $.ajax({
      url: $(this).attr('action'),
      // url: "<?= site_url('beli_part/simpanbeli_part') ?>",
      type: "post",
      data: $(this).serialize(),
      dataType: "json",
      beforeSend: function() {
        $('.btnsimpanbeli_part').attr('disable', 'disabled')
        $('.btnsimpanbeli_part').prop('disable', true)
        $('.btnsimpanbeli_part').html('<i class="fa fa-spin fa-spinner"></i>')
      },
      complete: function() {
        $('.btnsimpanbeli_part').removeAttr('disable')
        $('.btnsimpanbeli_part').html('<i class="fa fa-file"></i> Simpan')
        $('.btnsimpanbeli_part').prop('disabled', false)
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
          $('#modaltambah').modal('hide');
          let hasil;
          hasil = document.getElementById("title").value;
          swal({
            title: "Berhasil disimpan ",
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

  $('#nopo').on('keypress', function(e) {
    if (e.which == 13) {
      var keyPressed = event.keyCode || event.which;
      if (keyPressed === 13) {
        alert("Press tab to continue!");
        event.preventDefault();
        return false;
      }
    }
  });
  $('#caripo').click(function(e) {
    e.preventDefault();
    $.ajax({
      url: "<?= site_url('beli_part/caridatapo') ?>",
      dataType: "json",
      success: function(response) {
        $('.viewmodalcari').html(response.data).show();
        $('#modalcari').modal('show');
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  })
  $('#nopo').on('blur', function(e) {
    let cari = $(this).val()
    alert(cari);
    if (cari !== "") {
      $.ajax({
        url: "<?= site_url('beli_part/replpo') ?>",
        type: 'post',
        data: {
          'nopo': cari
        },
        success: function(data) {
          let data_response = JSON.parse(data);
          if (data_response['nopo'] == '') {
            $('#nopo').val('');
            $('#tglpo').val('');
            $('#kdsupplier').val('');
            $('#nmsupplier').val('');
            $('#jnsorder').val('');
            $('#reference').val('');
            $('#biaya1').val('');
            $('#vnbiaya1').val('');
            $('#biaya2').val('');
            $('#nbiaya2').val('');
            $('#total_biaya').val('');
            $('#catatan').val('');
            $('#subtotal').val('');
            $('#ppn').val('');
            $('#rp_ppn').val('');
            $('#materai').val('');
            $('#cara_bayar').val('');
            $('#tempo').val('');
            $('#tgljttempo').val('');
            $('#total').val('');
            $('#partshop').val('');
            return;
          } else {
            $('#nopo').val(data_response['nopo']);
            $('#tglpo').val(data_response['tglpo']);
            $('#kdsupplier').val(data_response['kdsupplier']);
            $('#nmsupplier').val(data_response['nmsupplier']);
            $('#jnsorder').val(data_response['jnsorder']);
            $('#reference').val(data_response['reference']);
            $('#biaya1').val(data_response['biaya1']);
            $('#vnbiaya1').val(data_response['nbiaya1']);
            $('#biaya2').val(data_response['biaya2']);
            $('#nbiaya2').val(data_response['nbiaya2']);
            $('#total_biaya').val(data_response['total_biaya']);
            $('#catatan').val(data_response['catatan']);
            $('#subtotal').val(data_response['subtotal']);
            $('#ppn').val(data_response['ppn']);
            $('#rp_ppn').val(data_response['rp_ppn']);
            $('#materai').val(data_response['materai']);
            $('#cara_bayar').val(data_response['cara_bayar']);
            $('#tempo').val(data_response['tempo']);
            $('#tgljttempo').val(data_response['tgljttempo']);
            $('#total').val(data_response['total']);
            $('#partshop').val(data_response['partshop']);
          }
        },
        error: function() {
          $('#nopo').val('');
          $('#tglpo').val('');
          $('#kdsupplier').val('');
          $('#nmsupplier').val('');
          $('#jnsorder').val('');
          $('#reference').val('');
          $('#biaya1').val('');
          $('#vnbiaya1').val('');
          $('#biaya2').val('');
          $('#nbiaya2').val('');
          $('#total_biaya').val('');
          $('#catatan').val('');
          $('#subtotal').val('');
          $('#ppn').val('');
          $('#rp_ppn').val('');
          $('#materai').val('');
          $('#cara_bayar').val('');
          $('#tempo').val('');
          $('#tgljttempo').val('');
          $('#total').val('');
          $('#partshop').val('');
          return;
          // console.log('file not fount');
        }
      })
      // console.log(cari);
    } else {
      $('#nopo').val('');
      $('#tglpo').val('');
      $('#kdsupplier').val('');
      $('#nmsupplier').val('');
      $('#jnsorder').val('');
      $('#reference').val('');
      $('#biaya1').val('');
      $('#vnbiaya1').val('');
      $('#biaya2').val('');
      $('#nbiaya2').val('');
      $('#total_biaya').val('');
      $('#catatan').val('');
      $('#subtotal').val('');
      $('#ppn').val('');
      $('#rp_ppn').val('');
      $('#materai').val('');
      $('#cara_bayar').val('');
      $('#tempo').val('');
      $('#tgljttempo').val('');
      $('#total').val('');
      $('#partshop').val('');
    }
  })

  $('#kdsupplier').on('keypress', function(e) {
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

  $("#modaltambah").on('hide.bs.modal', function() {
    // alert('The modal is about to be hidden.');
    // reload_table_faktur_bp();
    reload_table();
  });
</script>