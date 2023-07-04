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
  'form' => "detail",
];
$session->set($nmform);
?>

<div class="modal fade" id="detail_wo_bp" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 90%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <input type="hidden" id='title' value="<?= $title ?>">
      </div>
      <div class="modal-body">
        <?php if ($pakai == 1) {
          if ($title == "Detail Data wo") {
          }
        ?>
          <?= form_open('estimasi_bp/simpanwo', ['class' => 'formdetail_wo_bp']) ?>
          <?= csrf_field(); ?>
          <div class="row mb-2 mt-4">
            <div class="col-12 col-sm-6">
              <?php
              date_default_timezone_set('Asia/Jakarta');
              $tglwo = date('Y-m-d H:i:s');
              $tglwo = date('Y-m-d H:i:s');
              ?>
              <label for="nama" class="form-label mb-1">No. WO / Tanggal (M-D-Y)</label>
              <div class="input-group mb-1">
                <input type='text' class='form-control form-control-sm mb-2' value="<?= $wo_bp['nowo'] ?>" id="wojadi" name="wojadi" readonly style="width: 5%">
                <input type="datetime-local" class='form-control form-control-sm mb-2' name='tanggal' id='tanggal' value="<?= $wo_bp['tanggal'] ?>" style="width: 40%" readonly>
              </div>
              <label for="nama" class="form-label mb-0">No. Polisi</label>
              <div class="input-group mb-1">
                <input type="text" class="form-control form-control-sm" placeholder="No. Polisi" name="nopolisi" id="nopolisi" value="<?= $tbmobil['nopolisi'] ?>" readonly>
                <input type="text" style="width: 40%" class="form-control form-control-sm" name="norangka" id="norangka" value="<?= $tbmobil['norangka'] ?>" readonly>
              </div>
              <label for="nama" class="form-label mb-1">Customer</label>
              <div class="input-group mb-1">
                <input type="text" class="form-control form-control-sm mb-2" name="kdpemilik" id="kdpemilik" readonly style="width: 5%" value="<?= $tbmobil['kdpemilik'] ?>" readonly>
                <input type="text" class="form-control form-control-sm mb-2" name="nmpemilik" id="nmpemilik" readonly style="width: 40%" value="<?= $tbmobil['nmpemilik'] ?>" readonly>
              </div>
              <div class="invalid-feedback errornmpemilik">
              </div>
              <label for="nama" class="form-label mb-1">Jenis Service / Kilo Meter</label>
              <div class="input-group mb-1">
                <select class="form-select form-select-sm" style="height: 31px;" name="kdservice" id="kdservice" disabled>
                  <option value="">- PILIH JENIS SERVICE -</option>
                  <?php
                  $arr = array("PM", "GR", "PM+GR", "LAIN-LAIN");
                  $jml_kata = count($arr);
                  for ($c = 0; $c < $jml_kata; $c += 1) {
                    if ($arr[$c] == $wo_bp['kdservice']) {
                      echo "<option value='$arr[$c]' selected>$arr[$c] </option>";
                    } else {
                      echo "<option value='$arr[$c]'> $arr[$c] </option>";
                    }
                  }
                  echo "</select>";
                  ?>
                </select>
                <input type="text" class="form-control form-control-sm mb-1" value="<?= $wo_bp['km'] ?>" placeholder="KM" readonly>
              </div>
              <label for="nama" class="form-label mb-1">Paket</label>
              <input type="text" class="form-control form-control-sm mb-1" value="<?= $wo_bp['kdpaket'] ?>" placeholder="Paket" readonly>
              <label for="nama" class="form-label mb-1">Aktifitas / Fasilitas / Status Tunggu</label>
              <div class="input-group mb-2">
                <select id='aktifitas' name='aktifitas' class="form-select form-select-sm" disabled>
                  <option value=''>- PILIH AKTIFITAS -</option>
                  <?php
                  $arr = array("Workshop", "Moving Service", "Emergency Service (SRA)", "Home Service", "Flat Service", "Service Point");
                  $jml_kata = count($arr);
                  for ($c = 0; $c < $jml_kata; $c += 1) {
                    if ($arr[$c] == $wo_bp['aktifitas']) {
                      echo "<option value='$arr[$c]' selected>$arr[$c] </option>";
                    } else {
                      echo "<option value='$arr[$c]'> $arr[$c] </option>";
                    }
                  }
                  echo "</select>";
                  ?>
                </select>
                <select id='fasilitas' name='fasilitas' class="form-select form-select-sm" style='width: 200x;' disabled>
                  <option value=''>- PILIH FASILITAS -</option>
                  <?php
                  $arr = array("Service Car", "Service Motorcycle");
                  $jml_kata = count($arr);
                  for ($c = 0; $c < $jml_kata; $c += 1) {
                    if ($arr[$c] == $wo_bp['fasilitas']) {
                      echo "<option value='$arr[$c]' selected>$arr[$c] </option>";
                    } else {
                      echo "<option value='$arr[$c]'> $arr[$c] </option>";
                    }
                  }
                  ?>
                </select>
                <select id='status_tunggu' name='status_tunggu' class="form-select form-select-sm" style='width: 200x;' disabled>
                  <option value=''>- PILIH STATUS TUNGGU -</option>
                  <?php
                  $arr = array("Tunggu", "Tinggal", "Menginap");
                  $jml_kata = count($arr);
                  for ($c = 0; $c < $jml_kata; $c += 1) {
                    if ($arr[$c] == $wo_bp['status_tunggu']) {
                      echo "<option value='$arr[$c]' selected>$arr[$c] </option>";
                    } else {
                      echo "<option value='$arr[$c]'> $arr[$c] </option>";
                    }
                  }
                  ?>
                </select>
              </div>
              <label for="nama" class="form-label mb-1">Interval Reminder / Via</label>
              <div class="input-group mb-2">
                <select id='int_reminder' name='int_reminder' class="form-select form-select-sm" disabled>
                  <option value=''>- PILIH INTERVAL REMINDER -</option>
                  <?php
                  $arr = array("01 Bulan", "02 Bulan", "03 Bulan", "04 Bulan", "05 Bulan", "06 Bulan", "07 Bulan", "08 Bulan", "09 Bulan");
                  $jml_kata = count($arr);
                  for ($c = 0; $c < $jml_kata; $c += 1) {
                    if ($arr[$c] == $wo_bp['int_reminder']) {
                      echo "<option value='$arr[$c]' selected>$arr[$c] </option>";
                    } else {
                      echo "<option value='$arr[$c]'> $arr[$c] </option>";
                    }
                  }
                  ?>
                </select>
                <select id='via' name='via' class="form-select form-select-sm" disabled>
                  <option value=''>- PILIH REMINDER VIA -</option>
                  <option value='Telp'>Telp</option>
                  <option value='SMS'>SMS</option>
                  <option value='WA'>WA</option>
                  <option value='Email'>Email</option>
                  <?php
                  $arr = array("Telp", "SMS", "WA", "Email");
                  $jml_kata = count($arr);
                  for ($c = 0; $c < $jml_kata; $c += 1) {
                    if ($arr[$c] == $wo_bp['via']) {
                      echo "<option value='$arr[$c]' selected>$arr[$c] </option>";
                    } else {
                      echo "<option value='$arr[$c]'> $arr[$c] </option>";
                    }
                  }
                  ?>
                </select>
              </div>
              Service Advisor
              <div class="input-group mb-2">
                <?php
                $nmsa = isset($tbsa['nama']) ? $tbsa['nama'] : '';
                ?>
                <input type="text" style="width:5%;" name="kdsa" id="kdsa" class="form-control" placeholder="" value="<?= $wo_bp['kdsa'] ?>" readonly>
                <input type="text" style="width:50%;" name="nmsa" id="nmsa" class="form-control" value="<?= $nmsa ?>" readonly>
                <button class="btn btn-outline-secondary" type="button" id="carisa" disabled><i class="fa fa-search"></i></button>
                <!-- <button class="btn btn-outline-primary tambahtbsa" type="button"><i class="fa fa-plus"></i></button> -->
              </div>
              <label for="keluhan" class="form-label mb-1">Keluhan</label>
              <textarea class="form-control" name="keluhan" id="keluhan" rows="4" readonly><?= $wo_bp['keluhan'] ?></textarea>
              <div class="invalid-feedback errorKeluhan">
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <label for="keluhan" class="form-label mb-1">Nama Polis</label>
              <input type="text" class="form-control form-control-sm" name="nama_polis" id="nama_polis" value="<?= $tbmobil['nama_polis'] ?>" readonly>
              <label for="keluhan" class="form-label mb-1">No. Polis</label>
              <input type="text" class="form-control form-control-sm" name="no_polis" id="no_polis" value="<?= $tbmobil['no_polis'] ?>" readonly>
              <label for="keluhan" class="form-label mb-1">Tgl. Berakhir</label>
              <input type="date" class="form-control form-control-sm" name="tgl_akhir_polis" id="tgl_akhir_polis" value="<?= $tbmobil['tgl_akhir_polis'] ?>" readonly>
              <label for="keluhan" class="form-label mb-1">Asuransi</label>
              <div class="input-group mb-1">
                <input type="text" class="form-control form-control-sm" name="nama_asuransi" id="kode_asuransi" value="<?= $tbmobil['kode_asuransi'] ?>" readonly>
                <input type="text" style="width: 40%" class="form-control form-control-sm" name="kode_asuransi" id="nama_asuransi" value="<?= $tbmobil['nama_asuransi'] ?>" readonly>
              </div>
              <label for="keluhan" class="form-label mb-1">Alamat Asuransi</label>
              <textarea class="form-control" name="alamat_asuransi" rows="2" readonly><?= $tbmobil['alamat_asuransi'] ?></textarea>
              <label for="nama" class="form-label mb-0">Status WO</label>
              <br>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="klaim" name="klaim" <?= $wo_bp['klaim'] > 0 ? "checked" : "" ?> disabled>
                <label class="form-check-label" for="flexCheckDefault">Klaim</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="" id="internal" name="internal" <?= $wo_bp['internal'] > 0 ? "checked" : "" ?> disabled>
                <label class="form-check-label" for="flexCheckChecked">Internal</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="" id="inventaris" name="inventaris" <?= $wo_bp['inventaris'] > 0 ? "checked" : "" ?> disabled>
                <label class="form-check-label" for="flexCheckDefault">Inventaris</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="" id="campaign" name="campaign" <?= $wo_bp['campaign'] > 0 ? "checked" : "" ?> disabled>
                <label class="form-check-label" for="flexCheckChecked">Campaign</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="" id="booking" name="booking" <?= $wo_bp['booking'] > 0 ? "checked" : "" ?> disabled>
                <label class="form-check-label" for="flexCheckChecked">Booking</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input mb-2" type="checkbox" value="" id="lain_lain" name="lain_lain" <?= $wo_bp['lain_lain'] > 0 ? "checked" : "" ?> disabled>
                <label class="form-check-label" for="flexCheckChecked">Lain-lain</label>
              </div>
              <br>
              <label for="nama" class="form-label mb-1">PPN (%)</label>
              <input type="number" class="form-control form-control-sm mb-2" name="pr_ppn" id="pr_ppn" value="<?= $wo_bp['pr_ppn'] ?>" readonly>
              <label for="nama" class="form-label mb-1">NPWP</label>
              <input type="text" class="form-control form-control-sm mb-2" name="npwp" id="npwp" <?= isset($tbcustomer['npwp']) ? $tbcustomer['npwp'] : '' ?> readonly>
              <label for="nama" class="form-label mb-1">Contact Person</label>
              <input type="text" class="form-control form-control-sm mb-2" name="contact_person" id="contact_person" <?= isset($tbcustomer['contact_person']) ? $tbcustomer['contact_person'] : '' ?> readonly>
              <label for="nama" class="form-label mb-1">Nomor Contact Person</label>
              <input type="text" class="form-control form-control-sm mb-2" name="no_contact_person" id="no_contact_person" <?= isset($tbcustomer['no_contact_person']) ? $tbcustomer['no_contact_person'] : '' ?> readonly>
            </div>
          </div>
          <ul class="nav nav-tabs" aria-readonly="true">
            <li class="nav-item">
              <a href="#summary_wo" class="nav-link active" data-bs-toggle="tab" id="tabsummary">Summary</a>
            </li>
            <li class="nav-item">
              <a href="#jasa_wo" class="nav-link" data-bs-toggle="tab" id="tabjasa">Jasa</a>
            </li>
            <li class="nav-item">
              <a href="#sparepart_wo" class="nav-link" data-bs-toggle="tab" id="tabsparepart">Spare Part</a>
            </li>
            <li class="nav-item">
              <a href="#bahan_wo" class="nav-link" data-bs-toggle="tab" id="tabbahan">Bahan</a>
            </li>
            <li class="nav-item">
              <a href="#opl_wo" class="nav-link" data-bs-toggle="tab" id="tabopl">Pekerjaan Luar</a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade show active" id="summary_wo">
              <br>
            </div>
            <div class="tab-pane fade" id="jasa_wo">
              <br>
              <div class="row mb-2">
                <div id="tbl_wo_jasa"></div>
              </div>
            </div>
            <div class="tab-pane fade" id="sparepart_wo">
              <br>
              <label for="nama" class="form-label mb-1">
                <font color=red><?= $wo_bp['close_part'] == 1 ? 'Spare Part Closed' : 'Spare Part Unclosed' ?></font>
              </label>
              <input type='hidden' class='form-control form-control-sm mb-2' value="<?= $wo_bp['nowo'] ?>" name="nowo" id="nowo" readonly style="width: 5%">
              <div class="row mb-2">
                <div id="tbl_wo_part"></div>
              </div>
            </div>
            <div class="tab-pane fade " id="bahan_wo">
              <br>
              <label for="nama" class="form-label mb-1">
                <font color=red><?= $wo_bp['close_bahan'] == 1 ? 'Bahan Closed' : 'Bahan Unclosed' ?></font>
              </label>
              <div class="row mb-2">
                <div id="tbl_wo_bahan"></div>
              </div>
            </div>
            <div class="tab-pane fade " id="opl_wo">
              <br>
              <label for="nama" class="form-label mb-1">
                <font color=red><?= $wo_bp['close_opl'] == 1 ? 'OPL Closed' : 'OPL Unclosed' ?></font>
              </label>
              <div class="row mb-2">
                <div id="tbl_wo_opl"></div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <!-- <button type="button" class="btn btn-secondary btn-sm mb-3" data-bs-dismiss="modal"><i class="fa fa-arrow-left"></i> Close</button> -->
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
            echo "<p>Anda tidak berhak membuat WO</p>";
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


<script>
  function simpankewo() {
    $nowo = document.getElementById('nowo').value;
    $.ajax({
      type: "post",
      url: "<?= site_url('estimasi_bp/simpankewo') ?>",
      data: {
        nowo: $nowo
      },
      dataType: "json",
      beforeSend: function() {
        $('.btnreload').attr('disable', 'disabled')
        $('.btnreload').html('<i class="fa fa-spin fa-spinner"></i>')
      },
      complete: function() {
        $('.btnreload').removeAttr('disable')
        $('.btnreload').html('<i class="fa fa-spiner"></i>')
      },
      success: function(response) {
        swal({
          icon: 'success',
          title: response.sukses, //"Data berhasil ditambah ",
          text: response.sukses,
        });
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    });
    return false;
  }

  $(document).ready(function() {
    reload_summary();
    reload_table_wo_jasa();
    reload_table_wo_part();
    reload_table_wo_bahan();
    reload_table_wo_opl();
  });

  $('#tabsummary').on('click', function() {
    reload_summary();
  });
  $('#tabjasa').on('click', function() {
    reload_table_wo_jasa();
  });
  $('#tabsparepart').on('click', function() {
    reload_table_wo_part();
  });
  $('#tabbahan').on('click', function() {
    reload_table_wo_bahan();
  });
  $('#tabopl').on('click', function() {
    reload_table_wo_opl();
  });

  function reload_table_wo_jasa() {
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
      url: "<?= site_url('estimasi_bp/table_wo_bp_jasa'); ?>",
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

  function reload_table_wo_part() {
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
      url: "<?= site_url('estimasi_bp/table_wo_bp_part'); ?>",
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

  function reload_table_wo_bahan() {
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
      url: "<?= site_url('estimasi_bp/table_wo_bp_bahan'); ?>",
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


  function reload_table_wo_opl() {
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
      url: "<?= site_url('estimasi_bp/table_wo_bp_opl'); ?>",
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

  function reload_summary() {
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
      url: "<?= site_url('estimasi_bp/summary_wo'); ?>",
      beforeSend: function(f) {
        $('.btnreload').attr('disable', 'disabled')
        $('.btnreload').html('<i class="fa fa-spin fa-spinner"></i>')
        // alert('1');
        $('#summary_wo').html('<center>Loading Data ...</center>');
      },
      success: function(data) {
        $('#summary_wo').html(data);
        $('.btnreload').removeAttr('disable')
        $('.btnreload').html('<i class="fa fa-spinner">')
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }
</script>