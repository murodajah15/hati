<?php
$session = session();
$pakai = session()->get('pakai');
$tambah = session()->get('tambah');
$edit = session()->get('edit');
$hapus = session()->get('hapus');
$proses = session()->get('proses');
$unproses = session()->get('unproses');
$cetak = session()->get('cetak');
$nmform = [
  'form' => "edit",
];
$session->set($nmform);
?>

<script src="<?= base_url('/js/autoNumeric.js') ?>" crossorigin="anonymous"></script>

<div class="modal fade" id="input_wo_bpd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 100%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <input type="hidden" id='title' value="<?= $title ?>">
      </div>
      <div class="modal-body">
        <?php if ($tambah == 1) {
          if ($title == "Detail Data WO Body Repair") {
          }
        ?>
          <!-- <?= form_open('close_wo_bp/simpanestimasi_bpd', ['class' => 'forminputestimasi_bpd']) ?>

          <?= csrf_field(); ?> -->
          <div class="row mb-2 mt-2">
            <div class="col-12 col-sm-4">
              <?php
              date_default_timezone_set('Asia/Jakarta');
              $tglwo = date('Y-m-d H:i:s');
              ?>
              <input type="hidden" name="kode_asuransi" id="kode_asuransi" value="<?= $wo_bp['kode_asuransi'] ?>">
              <label for="nama" class="form-label mb-1">No. WO / Tanggal (M-D-Y)</label>
              <div class="input-group mb-1">
                <input type='text' class='form-control form-control-sm mb-2' value="<?= $wo_bp['nowo'] ?>" name="nowo" id="nowo" readonly style="width: 5%">
                <input type="datetime-local" class='form-control form-control-sm mb-2' name='tanggal' id='tanggal' value="<?= $wo_bp['tanggal'] ?>" style="width: 40%" readonly>
              </div>
            </div>
            <div class="col-12 col-sm-4">
              <label for="nama" class="form-label mb-1">No. Polisi</label>
              <div class="input-group mb-1">
                <input type="text" class="form-control form-control-sm" placeholder="No. Polisi" name="nopolisi" id="nopolisi" value="<?= $tbmobil['nopolisi'] ?>" readonly>
                <input type="text" style="width: 40%" class="form-control form-control-sm" name="norangka" id="norangka" value="<?= $tbmobil['norangka'] ?>" readonly>
              </div>
            </div>
            <div class="col-12 col-sm-4">
              <label for="nama" class="form-label mb-1">Customer</label>
              <div class="input-group mb-1">
                <input type="text" class="form-control form-control-sm mb-2" name="kdpemilik" id="kdpemilik" readonly style="width: 5%" value="<?= $tbmobil['kdpemilik'] ?>">
                <input type="text" class="form-control form-control-sm mb-2" name="nmpemilik" id="nmpemilik" readonly style="width: 40%" value="<?= $tbmobil['nmpemilik'] ?>">
              </div>
            </div>
          </div>
          <ul class="nav nav-tabs">
            <li class="nav-item">
              <a href="#summary" class="nav-link active" data-bs-toggle="tab" id="tabsummary">Summary</a>
            </li>
            <li class="nav-item">
              <a href="#jasa" class="nav-link" data-bs-toggle="tab" id="tabjasa">Jasa</a>
            </li>
            <li class="nav-item">
              <a href="#sparepart" class="nav-link" data-bs-toggle="tab" id="tabsparepart">Spare Part</a>
            </li>
            <li class="nav-item">
              <a href="#bahan" class="nav-link" data-bs-toggle="tab" id="tabbahan">Bahan</a>
            </li>
            <li class="nav-item">
              <a href="#opl" class="nav-link" data-bs-toggle="tab" id="tabopl">Pekerjaan Luar</a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade show active" id="summary">
            </div>
            <div class="tab-pane fade" id="jasa">
              <?= form_open('close_wo_bp/simpanestimasidxxx', ['class' => 'forminputjasa']) ?>
              <input type='hidden' class='form-control form-control-sm mb-2' value="<?= $wo_bp['nowo'] ?>" name="nowo" id="nowo" readonly style="width: 5%">
              <?= csrf_field(); ?>
              <div class="row mb-2">
                <table class="table table-striped" style="width:100%">
                  <thead>
                    <tr>
                      <!-- <th>ID</th> -->
                      <th width="150">Kode jasa</th>
                      <th width="150">Nama jasa</th>
                      <th width="150">Kerusakan</th>
                      <th width="100">Qty</th>
                      <th width="100">Harga Satuan</th>
                      <th width="90">Disc (%)</th>
                      <th>Disc (Rp.)</th>
                      <th>Subtotal</th>
                      <th>Kd. Mekanik</th>
                      <th>Mekanik</th>

                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody">
                    <input type="hidden" name="id" id="id">
                    <td>
                      <div class="input-group mb-0">
                        <input type="text" class="form-control form-control-sm" placeholder="Kode Jasa" name="kodejasa" id="kodejasa" onblur="hit_ssubtotal_jasa()">
                        <button class="btn btn-outline-secondary btn-sm caritasklist" type="button" id="caritasklist"><i class="fa fa-search"></i></button>
                      </div>
                      <div class="invalid-feedback errorKodejasa">
                      </div>
                    </td>
                    <td><textarea class="form-control form-control-sm" value="" name="namajasa" id="namajasa" rows="2" readonly></textarea></td>
                    <!-- <td><input type="text" name="namajasa" id="namajasa" class="form-control form-control-sm" value="" readonly></td> -->
                    <td><textarea class="form-control form-control-sm" value="" name="kerusakan" id="kerusakan" rows="2"></textarea></td>
                    <!-- <td><input type="text" name="kerusakan" id="kerusakan" class="form-control form-control-sm" value=""></td> -->
                    <td><input type="text" name="qtyjasa" id="qtyjasa" class="form-control form-control-sm text-end" onkeyup="validAngka(this)" value=0 onblur="hit_ssubtotal_jasa()" required>
                      <div class="invalid-feedback errorQtyjasa">
                      </div>
                    </td>
                    <td><input type="text" name="hargajasa" id="hargajasa" class="form-control form-control-sm text-end" value=0 onblur="hit_ssubtotal_jasa()"></td>
                    <!-- onkeyup="validAngka_no_titik(this)" -->
                    <td><input type="text" name="pr_discountjasa" id="pr_discountjasa" class="form-control form-control-sm text-end" value=0 onblur="hit_ssubtotal_jasa()"></td>
                    <td><input type="text" name="rp_discountjasa" id="rp_discountjasa" class="form-control form-control-sm text-end" value=0 readonly></td>
                    <td><input type="text" name="subtotaljasa" id="subtotaljasa" class="form-control form-control-sm text-end" value=0 readonly></td>
                    <td>
                      <div class="input-group mb-0">
                        <input type="text" class="form-control form-control-sm" placeholder="Kode Mekanik" name="kdmekanik" id="kdmekanik" required>
                        <button class="btn btn-outline-secondary btn-sm carimekanik" type="button" id="carimekanik"><i class="fa fa-search"></i></button>
                      </div>
                      <div class="invalid-feedback errorKodejasa">
                      </div>
                    </td>
                    <td><input type="text" name="nmmekanik" id="nmmekanik" class="form-control form-control-sm" readonly></td>
                    <td><button type="submit" id="btnaddjasa" class="btn btn-primary btn-sm btnaddjasa"><i class="fa fa-plus"></i></button></td>
                    </tbody>
                </table>
              </div>
              <div class="row mt-2 mb-2">
                <div id="tbl_wo_jasa"></div>
              </div>
              <?= form_close() ?>
            </div>
            <div class="tab-pane fade" id="sparepart">
              <div class="row mb-2">
                <div id="tbl_wo_part"></div>
              </div>
            </div>
            <div class="tab-pane fade " id="bahan">
              <div class="row mt-2 mb-2">
                <div id="tbl_wo_bahan"></div>
              </div>
            </div>
            <div class="tab-pane fade " id="opl">
              <div class="row mt-2 mb-2">
                <div id="tbl_wo_opl"></div>
              </div>
            </div>
          </div>
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
            echo "<p>Anda tidak berhak membuat Estimasi / WO</p>";
          }
      ?>

      <button class="btn btn-flat btn-primary btn-sm mb-3 tomboltambah" type="button" disabled><i class="fa fa-plus"></i> Tambah</button>
    <?php
        }
    ?>
    <!-- </div> -->
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>
    </div>
  </div>
</div>
</div>

<script>
  $('#tabsummary').on('click', function() {
    reload_bp_summary();
  });
  $('#tabjasa').on('click', function() {
    reload_table_wo_bp_jasa();
  });
  $('#tabsparepart').on('click', function() {
    reload_table_wo_bp_part();
  });
  $('#tabbahan').on('click', function() {
    reload_table_wo_bp_bahan();
  });
  $('#tabopl').on('click', function() {
    reload_table_wo_bp_opl();
  });

  $(document).ready(function() {
    $('#hargapart').autoNumeric('init', {
      aSep: ',',
      aDec: '.',
      mDec: '0'
    })
    $('#qtypart').autoNumeric('init', {
      aSep: ',',
      aDec: '.',
      mDec: '2'
    })
    $('#pr_discountpart').autoNumeric('init', {
      aSep: ',',
      aDec: '.',
      mDec: '2'
    })
    $('#hargabahan').autoNumeric('init', {
      aSep: ',',
      aDec: '.',
      mDec: '0'
    })
    $('#qtybahan').autoNumeric('init', {
      aSep: ',',
      aDec: '.',
      mDec: '2'
    })
    $('#pr_discountbahan').autoNumeric('init', {
      aSep: ',',
      aDec: '.',
      mDec: '2'
    })
    $('#hargaopl').autoNumeric('init', {
      aSep: ',',
      aDec: '.',
      mDec: '0'
    })
    $('#qtyopl').autoNumeric('init', {
      aSep: ',',
      aDec: '.',
      mDec: '2'
    })
    $('#pr_discountopl').autoNumeric('init', {
      aSep: ',',
      aDec: '.',
      mDec: '2'
    })
    $('#hargajasa').autoNumeric('init', {
      aSep: ',',
      aDec: '.',
      mDec: '0'
    })
    $('#qtyjasa').autoNumeric('init', {
      aSep: ',',
      aDec: '.',
      mDec: '2'
    })
    $('#pr_discountjasa').autoNumeric('init', {
      aSep: ',',
      aDec: '.',
      mDec: '2'
    })
    reload_table_wo_bp_jasa();
    reload_table_wo_bp_part();
    reload_table_wo_bp_bahan();
    reload_table_wo_bp_opl();
    reload_bp_summary();

    $('.forminputbahan').submit(function() {
      $.ajax({
        type: "post",
        url: "<?= site_url('close_wo_bp/simpanbahan') ?>",
        data: $(this).serialize(),
        dataType: "json",
        beforeSend: function() {
          $('.btnaddbahan').attr('disable', 'disabled')
          $('.btnaddbahan').html('<i class="fa fa-spin fa-spinner"></i>')
        },
        complete: function() {
          $('.btnaddbahan').removeAttr('disable')
          $('.btnaddbahan').html('<i class="fa fa-plus"></i>')
        },
        success: function(response) {
          if (response.error) {
            if (response.error.kodebahan) {
              // alert(response.error.kodebahan);
              $('#kodebahan').addClass('is-invalid');
              $('.errorKodebahan').html(response.error.kodebahan);
            } else {
              $('.errorKodebahan').fadeOut();
              $('#kodebahan').removeClass('is-invalid');
              $('#kodebahan').addClass('is-valid');
            }
            if (response.error.qtybahan) {
              $('#qtybahan').addClass('is-invalid');
              $('.errorQtybahan').html(response.error.qtybahan);
            } else {
              $('.errorQtybahan').fadeOut();
              $('#qtybahan').removeClass('is-invalid');
              $('#qtybahan').addClass('is-valid');
            }
            // reload_table_wo_bahan();
          } else {
            $('.errorKodebahan').fadeOut();
            $('#kodebahan').removeClass('is-invalid');
            $('#kodebahan').addClass('is-valid');
            $('.errorQtybahan').fadeOut();
            $('#qtybahan').removeClass('is-invalid');
            $('#qtybahan').addClass('is-valid');
            reload_table_wo_bp_bahan();
            reload_bp_summary();
            if (response.sukses == "Data gagal ditambah") {
              swal({
                icon: 'error',
                title: "Data gagal ditambah!",
                text: "Barang Double / QTY masih kosong!",
              });

            } else {
              swal({
                icon: 'success',
                title: response.sukses, //"Data berhasil ditambah ",
                text: response.sukses,
              });
              document.getElementById("kodebahan").value = "";
              document.getElementById("namabahan").value = "";
              document.getElementById("qtybahan").value = "0.00";
              document.getElementById("hargabahan").value = "0";
              document.getElementById("pr_discountbahan").value = "0";
              document.getElementById("rp_discountbahan").value = "0";
              document.getElementById("subtotalbahan").value = "0";
            }
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      });
      return false;
    })

    $('.forminputopl').submit(function() {
      $.ajax({
        type: "post",
        url: "<?= site_url('close_wo_bp/simpanopl') ?>",
        data: $(this).serialize(),
        dataType: "json",
        beforeSend: function() {
          $('.btnaddopl').attr('disable', 'disabled')
          $('.btnaddopl').html('<i class="fa fa-spin fa-spinner"></i>')
        },
        complete: function() {
          $('.btnaddopl').removeAttr('disable')
          $('.btnaddopl').html('<i class="fa fa-plus"></i>')
        },
        success: function(response) {
          if (response.error) {
            if (response.error.kodeopl) {
              // alert(response.error.kodeopl);
              $('#kodeopl').addClass('is-invalid');
              $('.errorKodeopl').html(response.error.kodeopl);
            } else {
              $('.errorKodeopl').fadeOut();
              $('#kodeopl').removeClass('is-invalid');
              $('#kodeopl').addClass('is-valid');
            }
            if (response.error.qtyopl) {
              $('#qtyopl').addClass('is-invalid');
              $('.errorQtyopl').html(response.error.qtyopl);
            } else {
              $('.errorQtyopl').fadeOut();
              $('#qtyopl').removeClass('is-invalid');
              $('#qtyopl').addClass('is-valid');
            }
            // reload_table_wo_opl();
          } else {
            $('.errorKodeopl').fadeOut();
            $('#kodeopl').removeClass('is-invalid');
            $('#kodeopl').addClass('is-valid');
            $('.errorQtyopl').fadeOut();
            $('#qtyopl').removeClass('is-invalid');
            $('#qtyopl').addClass('is-valid');
            reload_table_wo_bp_opl();
            reload_bp_summary();
            if (response.sukses == "Data gagal ditambah") {
              swal({
                icon: 'error',
                title: "Data gagal ditambah!",
                text: "Barang Double / QTY masih kosong!",
              });

            } else {
              swal({
                icon: 'success',
                title: response.sukses, //"Data berhasil ditambah ",
                text: response.sukses,
              });
              document.getElementById("kodeopl").value = "";
              document.getElementById("namaopl").value = "";
              document.getElementById("qtyopl").value = "0.00";
              document.getElementById("hargaopl").value = "0";
              document.getElementById("pr_discountopl").value = "0";
              document.getElementById("rp_discountopl").value = "0";
              document.getElementById("subtotalopl").value = "0";
            }
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      });
      return false;
    })

    $('.forminputjasa').submit(function() {
      $.ajax({
        type: "post",
        url: "<?= site_url('estimasi_bp/simpan_jasa_wo') ?>",
        data: $(this).serialize(),
        dataType: "json",
        beforeSend: function() {
          $('.btnaddjasa').attr('disable', 'disabled')
          $('.btnaddjasa').html('<i class="fa fa-spin fa-spinner"></i>')
        },
        complete: function() {
          $('.btnaddjasa').removeAttr('disable')
          $('.btnaddjasa').html('<i class="fa fa-plus"></i>')
        },
        success: function(response) {
          if (response.error) {
            if (response.error.kodejasa) {
              // alert(response.error.kodejasa);
              $('#kodejasa').addClass('is-invalid');
              $('.errorKodejasa').html(response.error.kodejasa);
            } else {
              $('.errorKodejasa').fadeOut();
              $('#kodejasa').removeClass('is-invalid');
              $('#kodejasa').addClass('is-valid');
            }
            if (response.error.qtyjasa) {
              $('#qtyjasa').addClass('is-invalid');
              $('.errorQtyjasa').html(response.error.qtyjasa);
            } else {
              $('.errorQtyjasa').fadeOut();
              $('#qtyjasa').removeClass('is-invalid');
              $('#qtyjasa').addClass('is-valid');
            }
            // reload_table_wo_jasa();
          } else {
            $('.errorKodejasa').fadeOut();
            $('#kodejasa').removeClass('is-invalid');
            $('#kodejasa').addClass('is-valid');
            $('.errorQtyjasa').fadeOut();
            $('#qtyjasa').removeClass('is-invalid');
            $('#qtyjasa').addClass('is-valid');
            reload_table_wo_bp_jasa();
            reload_bp_summary();
            if (response.sukses == "Data gagal ditambah") {
              swal({
                icon: 'error',
                title: "Data gagal ditambah!",
                text: "Barang Double / QTY masih kosong!",
              });

            } else {
              swal({
                icon: 'success',
                title: response.sukses, //"Data berhasil ditambah ",
                text: response.sukses,
              });
              document.getElementById("kodejasa").value = "";
              document.getElementById("namajasa").value = "";
              document.getElementById("qtyjasa").value = "0.00";
              document.getElementById("hargajasa").value = "0";
              document.getElementById("pr_discountjasa").value = "0";
              document.getElementById("rp_discountjasa").value = "0";
              document.getElementById("subtotaljasa").value = "0";
            }
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      });
      return false;
    })

    $('#carimekanik').click(function(e) {
      e.preventDefault();
      $.ajax({
        url: "<?= site_url('estimasi_bp/caridatamekanik') ?>",
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

    $('#caripart').click(function(e) {
      e.preventDefault();
      $.ajax({
        url: "<?= site_url('close_wo_bp/caridatapart') ?>",
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

    $('#caribahan').click(function(e) {
      e.preventDefault();
      $.ajax({
        url: "<?= site_url('close_wo_bp/caridatabahan') ?>",
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

    $('#cariopl').click(function(e) {
      e.preventDefault();
      $.ajax({
        url: "<?= site_url('close_wo_bp/caridataopl') ?>",
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

    $('#caritasklist').click(function(e) {
      $kdasuransi = $('#kode_asuransi').val();
      e.preventDefault();
      $.ajax({
        type: "post",
        data: {
          kdasuransi: $kdasuransi,
        },
        url: "<?= site_url('estimasi_bp/caridatatasklist') ?>",
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

    $('.forminputpart').submit(function() {
      // alert('1')
      $.ajax({
        type: "post",
        // url: $(this).attr('action'),
        url: "<?= site_url('close_wo_bp/simpanpart') ?>",
        data: $(this).serialize(),
        dataType: "json",
        beforeSend: function() {
          $('.btnaddpart').attr('disable', 'disabled')
          $('.btnaddpart').html('<i class="fa fa-spin fa-spinner"></i>')
        },
        complete: function() {
          $('.btnaddpart').removeAttr('disable')
          $('.btnaddpart').html('<i class="fa fa-plus"></i>')
        },
        success: function(response) {
          if (response.error) {
            if (response.error.kodepart) {
              // alert(response.error.kodepart);
              $('#kodepart').addClass('is-invalid');
              $('.errorKodepart').html(response.error.kodepart);
            } else {
              $('.errorKodepart').fadeOut();
              $('#kodepart').removeClass('is-invalid');
              $('#kodepart').addClass('is-valid');
            }
            if (response.error.qty) {
              $('#qtypart').addClass('is-invalid');
              $('.errorQtypart').html(response.error.qty);
            } else {
              $('.errorQtypart').fadeOut();
              $('#qtypart').removeClass('is-invalid');
              $('#qtypart').addClass('is-valid');
            }
            // reload_table_wo_part();
          } else {
            $('.errorKodepart').fadeOut();
            $('#kodepart').removeClass('is-invalid');
            $('#kodepart').addClass('is-valid');
            $('.errorQtypart').fadeOut();
            $('#qtypart').removeClass('is-invalid');
            $('#qtypart').addClass('is-valid');
            reload_table_wo_bp_part();
            reload_bp_summary();
            if (response.sukses == "Data gagal ditambah") {
              swal({
                icon: 'error',
                title: "Data gagal ditambah!",
                text: "Barang Double / QTY masih kosong",
              });

            } else {
              swal({
                icon: 'success',
                title: response.sukses, //"Data berhasil ditambah ",
                text: response.sukses,
              });
              document.getElementById("kodepart").value = "";
              document.getElementById("namapart").value = "";
              document.getElementById("qtypart").value = "0.00";
              document.getElementById("hargapart").value = "0";
              document.getElementById("pr_discountpart").value = "0";
              document.getElementById("rp_discountpart").value = "0";
              document.getElementById("subtotalpart").value = "0";
            }
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      });
      return false;
    })

    $('#kodepart').on('focusin', function(e) {
      hit_ssubtotal_part();
    })
    $('#kodejasa').on('focusin', function(e) {
      hit_ssubtotal_jasa();
    })
    $('#kodebahan').on('focusin', function(e) {
      hit_ssubtotal_bahan();
    })
    $('#kodeopl').on('focusin', function(e) {
      hit_ssubtotal_opl();
    })
    $('#qtypart').on('keyup', function(e) {
      hit_ssubtotal_part();
    })
    $('#hargapart').on('keyup', function(e) {
      hit_ssubtotal_part();
    })
    $('#pr_discountpart').on('keyup', function(e) {
      hit_ssubtotal_part();
    })
    $('#qtyjasa').on('keyup', function(e) {
      hit_ssubtotal_jasa();
    })
    $('#hargajasa').on('keyup', function(e) {
      hit_ssubtotal_jasa();
    })
    $('#pr_discountjasa').on('keyup', function(e) {
      hit_ssubtotal_jasa();
    })
    $('#qtybahan').on('keyup', function(e) {
      hit_ssubtotal_bahan();
    })
    $('#hargabahan').on('keyup', function(e) {
      hit_ssubtotal_bahan();
    })
    $('#pr_discountbahan').on('keyup', function(e) {
      hit_ssubtotal_bahan();
    })
    $('#qtyopl').on('keyup', function(e) {
      hit_ssubtotal_opl();
    })
    $('#hargaopl').on('keyup', function(e) {
      hit_ssubtotal_opl();
    })
    $('#pr_discountopl').on('keyup', function(e) {
      hit_ssubtotal_opl();
    })

    $('#kodepart').on('blur', function(e) {
      let cari = $(this).val()
      if (cari !== "") {
        $.ajax({
          url: "<?= site_url('close_wo_bp/replpart') ?>",
          type: 'post',
          data: {
            'kodepart': cari
          },
          success: function(data) {
            let data_response = JSON.parse(data);
            if (data_response['kode'] == '') {
              $('#kodepart').val('');
              $('#namapart').val('');
              $('#qtypart').val('0.00');
              $('#hargapart').val('');

              return;
            } else {
              $('#kodepart').val(data_response['kode']);
              $('#namapart').val(data_response['nama']);
              if ($('#qtypart').val() == "") {
                $('#qtypart').val(1);
              }
              if ($('#qtypart').val() == "0.00") {
                $('#qtypart').val(1);
              }
              if ($('#qtypart').val() == "0") {
                $('#qtypart').val(1);
              }

              $('#hargapart').val(data_response['harga']);
              hit_ssubtotal_part();
            }
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            return;
            // console.log('file not fount');
          }
        })
        // console.log(cari);
      }
    })
    $('#kodejasa').on('blur', function(e) {
      let cari = $(this).val()
      if (cari !== "") {
        $.ajax({
          url: "<?= site_url('estimasi_bp/repljasa') ?>",
          type: 'post',
          data: {
            'kodejasa': cari
          },
          success: function(data) {
            let data_response = JSON.parse(data);
            if (data_response['kode'] == '') {
              $('#kodejasa').val('');
              $('#namajasa').val('');
              $('#qtyjasa').val('0.00');
              $('#hargajasa').val('');
              return;
            } else {
              $('#kodejasa').val(data_response['kode']);
              $('#namajasa').val(data_response['nama']);
              $('#hargajasa').val(data_response['harga']);
              if ($('#qtyjasa').val() == "") {
                $('#qtyjasa').val(1);
              }
              if ($('#qtyjasa').val() == "0.00") {
                $('#qtyjasa').val(1);
              }
              if ($('#qtyjasa').val() == "0") {
                $('#qtyjasa').val(1);
              }
              hit_ssubtotal_jasa();
            }
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            return;
            // console.log('file not fount');
          }
        })
        // console.log(cari);
      }
    })
    $('#kodebahan').on('blur', function(e) {
      let cari = $(this).val()
      if (cari !== "") {
        $.ajax({
          url: "<?= site_url('close_wo_bp/replbahan') ?>",
          type: 'post',
          data: {
            'kodebahan': cari
          },
          success: function(data) {
            let data_response = JSON.parse(data);
            if (data_response['kode'] == '') {
              $('#kodebahan').val('');
              $('#namabahan').val('');
              $('#hargabahan').val('');
              $('#qtybahan').val('0.00');
              return;
            } else {
              $('#kodebahan').val(data_response['kode']);
              $('#namabahan').val(data_response['nama']);
              $('#hargabahan').val(data_response['harga']);
              if ($('#qtybahan').val() == "") {
                $('#qtybahan').val(1);
              }
              if ($('#qtybahan').val() == "0.00") {
                $('#qtybahan').val(1);
              }
              if ($('#qtybahan').val() == "0") {
                $('#qtybahan').val(1);
              }
              hit_ssubtotal_bahan();
            }
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            return;
            // console.log('file not fount');
          }
        })
        // console.log(cari);
      }
    })

    $('#kodeopl').on('blur', function(e) {
      let cari = $(this).val()
      if (cari !== "") {
        $.ajax({
          url: "<?= site_url('close_wo_bp/replopl') ?>",
          type: 'post',
          data: {
            'kodeopl': cari
          },
          success: function(data) {
            let data_response = JSON.parse(data);
            if (data_response['kode'] == '') {
              $('#kodeopl').val('');
              $('#namaopl').val('');
              $('#hargaopl').val('');
              $('#qtyopl').val('0.00');
              return;
            } else {
              $('#kodeopl').val(data_response['kode']);
              $('#namaopl').val(data_response['nama']);
              $('#hargaopl').val(data_response['harga']);
              if ($('#qtyopl').val() === "") {
                $('#qtyopl').val(1);
              }
              if ($('#qtyopl').val() === "0.00") {
                $('#qtyopl').val(1);
              }
              if ($('#qtyopl').val() === "0") {
                $('#qtyopl').val(1);
              }
              hit_ssubtotal_opl();
            }
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            return;
            // console.log('file not fount');
          }
        })
        // console.log(cari);
      }
    })
  });

  function reload_table_wo_bp_part() {
    $nowo = document.getElementById('nowo').value;
    // alert($nowo);
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
        nowo: $("#nowo").val()
      },
      // dataType: "json",
      url: "<?= site_url('close_wo_bp/table_wo_bp_part'); ?>",
      beforeSend: function(f) {
        $('.btnreload').attr('disable', 'disabled')
        $('.btnreload').html('<i class="fa fa-spin fa-spinner"></i>')
        // alert('1');
        $('#tbl_wo_part').html('<center>Loading Table ...</center>');
      },
      success: function(data) {
        $('#tbl_wo_part').html(data);
        $('.btnreload').removeAttr('disable')
        $('.btnreload').html('<i class="fa fa-spinner">')
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }

  function hit_ssubtotal_part() {
    let textharga = document.getElementById("hargapart").value
    let harga = textharga.replace(/,/g, "");
    let textqty = document.getElementById("qtypart").value
    let qty = textqty.replace(/,/g, "");
    let total_sementara = harga * qty;
    let $rp_discount = (document.getElementById("pr_discountpart").value / 100) * total_sementara;
    let subtotal = total_sementara - $rp_discount;
    document.getElementById("rp_discountpart").value = $rp_discount.toLocaleString('en-US');
    document.getElementById("subtotalpart").value = subtotal.toLocaleString('en-US');
  }

  function hit_ssubtotal_opl() {
    let textharga = document.getElementById("hargaopl").value
    let harga = textharga.replace(/,/g, "");
    let textqty = document.getElementById("qtyopl").value
    let qty = textqty.replace(/,/g, "");
    let total_sementara = harga * qty;
    let $rp_discount = (document.getElementById("pr_discountopl").value / 100) * total_sementara;
    let subtotal = total_sementara - $rp_discount;
    document.getElementById("rp_discountopl").value = $rp_discount.toLocaleString('en-US');
    document.getElementById("subtotalopl").value = subtotal.toLocaleString('en-US');
  }

  function hit_ssubtotal_bahan() {
    let textharga = document.getElementById("hargabahan").value
    let harga = textharga.replace(/,/g, "");
    let textqty = document.getElementById("qtybahan").value
    let qty = textqty.replace(/,/g, "");
    let total_sementara = harga * qty;
    let $rp_discount = (document.getElementById("pr_discountbahan").value / 100) * total_sementara;
    let subtotal = total_sementara - $rp_discount;
    document.getElementById("rp_discountbahan").value = $rp_discount.toLocaleString('en-US');
    document.getElementById("subtotalbahan").value = subtotal.toLocaleString('en-US');
  }

  function hit_ssubtotal_jasa() {
    let textharga = document.getElementById("hargajasa").value
    let harga = textharga.replace(/,/g, "");
    let textqty = document.getElementById("qtyjasa").value
    let qty = textqty.replace(/,/g, "");
    let total_sementara = harga * qty;
    let $rp_discount = (document.getElementById("pr_discountjasa").value / 100) * total_sementara;
    let subtotal = total_sementara - $rp_discount;
    document.getElementById("rp_discountjasa").value = $rp_discount.toLocaleString('en-US');
    document.getElementById("subtotaljasa").value = subtotal.toLocaleString('en-US');
  }

  function hit_ssubtotal_jasa1() {
    let text = document.getElementById("hargajasa").value
    let harga = text.replace(",", "");
    let $total_sementara = parseInt(document.getElementById("qtyjasa").value) * harga;
    // let $total_sementara = parseInt(document.getElementById("qty").value) * parseInt(document.getElementById("harga").value)
    let $discount = $total_sementara * (parseInt(document.getElementById("pr_discountjasa").value) / 100);
    let subtotal = $total_sementara - $discount;
    document.getElementById("rp_discountjasa").value = $discount.toLocaleString('en-US');
    // document.getElementById("subtotal").value = subtotal;
    document.getElementById("subtotaljasa").value = subtotal.toLocaleString('en-US');
  }

  function reload_table_wo_bp_opl() {
    $nowo = document.getElementById('nowo').value;
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
        nowo: $("#nowo").val()
      },
      // dataType: "json",
      url: "<?= site_url('close_wo_bp/table_wo_bp_opl'); ?>",
      beforeSend: function(f) {
        $('.btnreload').attr('disable', 'disabled')
        $('.btnreload').html('<i class="fa fa-spin fa-spinner"></i>')
        // alert('1');
        $('#tbl_wo_opl').html('<center>Loading Table ...</center>');
      },
      success: function(data) {
        $('#tbl_wo_opl').html(data);
        $('.btnreload').removeAttr('disable')
        $('.btnreload').html('<i class="fa fa-spinner">')
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }

  function reload_table_wo_bp_bahan() {
    $nowo = document.getElementById('nowo').value;
    // alert($nowo);
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
        nowo: $("#nowo").val()
      },
      // dataType: "json",
      url: "<?= site_url('close_wo_bp/table_wo_bp_bahan'); ?>",
      beforeSend: function(f) {
        $('.btnreload').attr('disable', 'disabled')
        $('.btnreload').html('<i class="fa fa-spin fa-spinner"></i>')
        // alert('1');
        $('#tbl_wo_bahan').html('<center>Loading Table1 ...</center>');
      },
      success: function(data) {
        $('#tbl_wo_bahan').html(data);
        $('.btnreload').removeAttr('disable')
        $('.btnreload').html('<i class="fa fa-spinner">')
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }

  function reload_table_wo_bp_jasa() {
    $nowo = document.getElementById('nowo').value;
    // alert($nowo);
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
        nowo: $("#nowo").val()
      },
      // dataType: "json",
      url: "<?= site_url('close_wo_bp/table_wo_bp_jasa'); ?>",
      beforeSend: function(f) {
        $('.btnreload').attr('disable', 'disabled')
        $('.btnreload').html('<i class="fa fa-spin fa-spinner"></i>')
        // alert('1');
        $('#tbl_wo_jasa').html('<center>Loading Table1 ...</center>');
      },
      success: function(data) {
        $('#tbl_wo_jasa').html(data);
        $('.btnreload').removeAttr('disable')
        $('.btnreload').html('<i class="fa fa-spinner">')
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }

  function reload_bp_summary() {
    $nowo = document.getElementById('nowo').value;
    // alert($nowo);
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
        nowo: $("#nowo").val()
      },
      // dataType: "json",
      url: "<?= site_url('close_wo_bp/summary_wo_bp'); ?>",
      beforeSend: function(f) {
        $('.btnreload').attr('disable', 'disabled')
        $('.btnreload').html('<i class="fa fa-spin fa-spinner"></i>')
        // alert('1');
        $('#summary').html('<center>Loading Data ...</center>');
      },
      success: function(data) {
        $('#summary').html(data);
        $('.btnreload').removeAttr('disable')
        $('.btnreload').html('<i class="fa fa-spinner">')
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }

  function editdetailwo_bp($id) {
    $.ajax({
      url: "<?php echo site_url('estimasi_bp/editdetailwo_bp') ?>/" + $id,
      type: "POST",
      data: {
        id: $id
      },
      // dataType: "JSON",
      success: function(data) {
        // alert(data);
        let data_response = JSON.parse(data);
        // $('#kodejasa').val(data_response['kodejasa']);
        // document.getElementById("kodejasa").value = data_response['kodejasa'];
        document.getElementById("kodejasa").value = data_response['kodejasa'];
        document.getElementById("namajasa").value = data_response['namajasa'];
        document.getElementById("kerusakan").value = data_response['kerusakan'];
        document.getElementById("qtyjasa").value = data_response['qtyjasa'];
        document.getElementById("hargajasa").value = data_response['hargajasa'];
        document.getElementById("pr_discountjasa").value = data_response['pr_discountjasa'];
        document.getElementById("subtotaljasa").value = data_response['subtotaljasa'];
        document.getElementById("kdmekanik").value = data_response['kdmekanik'];
        document.getElementById("nmmekanik").value = data_response['nmmekanik'];
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error deleting data id ' + $kode);
      }
    });
  }

  function hapusdetailwo_bp($id) {
    swal({
        title: "Yakin akan hapus ?",
        text: "Once deleted, you will not be able to recover this data!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: "<?php echo site_url('estimasi_bp/hapusdetailwo_bp') ?>/" + $id,
            type: "POST",
            dataType: "JSON",
            success: function(data1) {
              //if success reload ajax table
              // $('#modal_form').modal('hide');
              reload_table_wo_bp_jasa();
              reload_table_wo_bp_part();
              reload_table_wo_bp_bahan();
              reload_table_wo_bp_opl();
              reload_bp_summary();
              // reload_table_estimasi_bp();
              // reload_table_wo_bp();
              swal({
                title: "Data Berhasil dihapus ",
                text: "",
                icon: "info"
              })
              // .then(function() {
              //   window.location.href = '/wo';
              // });
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert('Error deleting data id ' + $kode);
            }
          });
        } else {
          // swal("Batal Hapus!");
        }
      });
  }

  function reload_table_wo_bp() {
    $nopolisi = document.getElementById('nopolisi').value;
    // alert($nopolisi);
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
    $(document).ready(function() {
      $('#tbl-wo_bp').DataTable();
    });

    $.ajax({
      type: "post",
      data: {
        nopolisi: $nopolisi
      },
      // dataType: "json",
      url: "<?= site_url('close_wo_bp/table_wo_bp/'); ?>",
      beforeSend: function(f) {
        $('.btnreload').attr('disable', 'disabled')
        $('.btnreload').html('<i class="fa fa-spin fa-spinner"></i>')
        // alert('1');
        $('#tabel_estimasi_bp').html('<center>Loading Table1 ...</center>');
      },
      success: function(data) {
        // alert(data);
        $('#tabel_wo_bp').html(data);
        $('.btnreload').removeAttr('disable')
        $('.btnreload').html('<i class="fa fa-spinner">')
      }
    })
  }

  $("#input_wo_bpd").on('hide.bs.modal', function() {
    // alert('The modal is about to be hidden.');
    reload_table_estimasi_bp()
    reload_table_wo_bp()
  });

  $("#input_wo_bpd").on('show.bs.modal', function() {
    // alert('The modal is about to be show.');
    // reload_table_wo_bp()
  });

  // $(document).ready(function() {
  $("#nowo").dblclick(function() {
    alert("The paragraph was double-clicked.");
  });
  // });
</script>