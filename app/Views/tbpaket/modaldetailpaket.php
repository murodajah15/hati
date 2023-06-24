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

<div class="modal fade" id="modaldetailpaket" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 70%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title . ' ' . $tbpaket['kode'] . ' - ' . $tbpaket['nama']; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <input type="hidden" id='title' value="<?= $title ?>">
      </div>
      <div class="modal-body">
        <?php if ($tambah == 1) {
          if ($title == "Detail Data paket") {
          }
        ?>
          <div class="container-fluid">
            <div class="row mb-2 mt-1">
              <div class="col-12 col-sm-4">
                <?php
                date_default_timezone_set('Asia/Jakarta');
                $tglpaket = date('Y-m-d H:i:s');
                $tglwo = date('Y-m-d H:i:s');
                ?>
              </div>
              <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a href="#jasa" class="nav-link active" data-bs-toggle="tab">Jasa</a>
                </li>
                <li class="nav-item">
                  <a href="#sparepart" class="nav-link" data-bs-toggle="tab">Spare Part</a>
                </li>
                <li class="nav-item">
                  <a href="#bahan" class="nav-link" data-bs-toggle="tab">Bahan</a>
                </li>
                <li class="nav-item">
                  <a href="#opl" class="nav-link" data-bs-toggle="tab">Pekerjaan Luar</a>
                </li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane fade show active" id="jasa">
                  <?= form_open('tbpaket/simpanpaketdxxx', ['class' => 'forminputjasa']) ?>
                  <?= csrf_field(); ?>
                  <div class="row mb-2">
                    <input type='hidden' class='form-control form-control-sm mb-2' value="<?= $tbpaket['kode'] ?>" name="kdpaket" id="kdpaket" readonly style="width: 5%">
                    <table class="table table-striped" style="width:100%">
                      <thead>
                        <tr>
                          <!-- <th>ID</th> -->
                          <th width="200">Kode Jasa</th>
                          <th width="400">Nama Jasa</th>
                          <th>Jam</th>
                          <th>FRT</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <input type="hidden" name="id" id="id">
                        <td>
                          <div class="input-group mb-0">
                            <input type="text" class="form-control form-control-sm" placeholder="Kode Jasa" name="kodejasa" id="kodejasa">
                            <button class="btn btn-outline-secondary btn-sm carijasa" type="button" id="carijasa"><i class="fa fa-search"></i></button>
                          </div>
                          <div class="invalid-feedback errorKodejasa">
                          </div>
                        </td>
                        <td><input type="text" name="namajasa" id="namajasa" class="form-control form-control-sm" value="" readonly></td>
                        <td><input type="text" name="jam" id="jam" class="form-control form-control-sm text-end" value=0 readonly></td>
                        <!-- onkeyup="validAngka_no_titik(this)" -->
                        <td><input type="text" name="frt" id="frt" class="form-control form-control-sm text-end" onkeyup="validAngka(this)" value=0 readonly></td>
                        <td><button type="submit" id="btnaddjasa" class="btn btn-primary btn-sm btnaddjasa"><i class="fa fa-plus"></i></button></td>
                      </tbody>
                    </table>
                  </div>
                  <div class="row mt-2 mb-2">
                    <div id="tbl_paket_jasa"></div>
                  </div>
                  <?= form_close() ?>
                </div>
                <div class="tab-pane fade" id="sparepart">
                  <?= form_open('tbpaket/simpanpaketdxxx', ['class' => 'forminputpart']) ?>
                  <?= csrf_field(); ?>
                  <div class="row mb-2">
                    <input type='hidden' class='form-control form-control-sm mb-2' value="<?= $tbpaket['kode'] ?>" name="kdpaket" id="kdpaket" readonly style="width: 5%">
                    <table class="table table-striped" style="width:100%">
                      <thead>
                        <tr>
                          <!-- <th>ID</th> -->tbpaket/
                          <th width="200">Kode Part</th>
                          <th width="500">Nama Spare Part</th>
                          <th width="100">Qty</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <input type="hidden" name="id" id="id">
                        <td>
                          <div class="input-group mb-0">
                            <input type="text" class="form-control form-control-sm" placeholder="Kode Part" name="kodepart" id="kodepart">
                            <button class="btn btn-outline-secondary btn-sm caripart" type="button" id="caripart"><i class="fa fa-search"></i></button>
                          </div>
                          <div class="invalid-feedback errorKodepart">
                          </div>
                        </td>
                        <td><input type="text" name="namapart" id="namapart" class="form-control form-control-sm" value="" readonly></td>
                        <!-- <td><input type="text" name="qtypart" id="qtypart" class="form-control form-control-sm text-end" onkeyup="validAngka(this)" value=0 required> -->
                        <!-- <td><input type="text" name="qtypart" id="qtypart" class="form-control form-control-sm text-end" onkeyup="autoNumber(this)" value=0 required> -->
                        <td><input type="text" name="qtypart" id="qtypart" class="form-control form-control-sm text-end" value=0 required>
                          <div class="invalid-feedback errorQtypart">
                          </div>
                        </td>
                        <td><button type="submit" id="btnaddpart" class="btn btn-primary btn-sm btnaddpart"><i class="fa fa-plus"></i></button></td>
                      </tbody>
                    </table>
                  </div>
                  <div class="row mb-2">
                    <div id="tbl_paket_part"></div>
                  </div>
                  <?= form_close() ?>
                </div>
                <div class="tab-pane fade" id="bahan">
                  <?= form_open('tbpaket/simpanpaketdxxx', ['class' => 'forminputbahan']) ?>
                  <?= csrf_field(); ?>
                  <div class="row mb-2">
                    <input type='hidden' class='form-control form-control-sm mb-2' value="<?= $tbpaket['kode'] ?>" name="kdpaket" id="kdpaket" readonly style="width: 5%">
                    <table class="table table-striped" style="width:100%">
                      <thead>
                        <tr>
                          <!-- <th>ID</th> -->
                          <th width="200">Kode Bahan</th>
                          <th width="500">Nama Bahan</th>
                          <th width="100">Qty</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <input type="hidden" name="id" id="id">
                        <td>
                          <div class="input-group mb-0">
                            <input type="text" class="form-control form-control-sm" placeholder="Kode Bahan" name="kodebahan" id="kodebahan">
                            <button class="btn btn-outline-secondary btn-sm caribahan" type="button" id="caribahan"><i class="fa fa-search"></i></button>
                          </div>
                          <div class="invalid-feedback errorKodebahan">
                          </div>
                        </td>
                        <td><input type="text" name="namabahan" id="namabahan" class="form-control form-control-sm" value="" readonly></td>
                        <td><input type="text" name="qtybahan" id="qtybahan" class="form-control form-control-sm text-end" onkeyup="validAngka(this)" value=0 required>
                          <div class="invalid-feedback errorQtybahan">
                          </div>
                        </td>
                        <td><button type="submit" id="btnaddbahan" class="btn btn-primary btn-sm btnaddbahan"><i class="fa fa-plus"></i></button></td>
                      </tbody>
                    </table>
                  </div>
                  <div class="row mt-2 mb-2">
                    <div id="tbl_paket_bahan"></div>
                  </div>
                  <?= form_close() ?>
                </div>
                <div class="tab-pane fade" id="opl">
                  <?= form_open('tbpaket/simpanpaketdxxx', ['class' => 'forminputopl']) ?>
                  <?= csrf_field(); ?>
                  <div class="row mb-2">
                    <input type='hidden' class='form-control form-control-sm mb-2' value="<?= $tbpaket['kode'] ?>" name="kdpaket" id="kdpaket" readonly style="width: 5%">
                    <table class="table table-striped" style="width:100%">
                      <thead>
                        <tr>
                          <!-- <th>ID</th> -->
                          <th width="200">Kode OPL</th>
                          <th width="500">Nama OPL</th>
                          <th width="100">Qty</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <input type="hidden" name="id" id="id">
                        <td>
                          <div class="input-group mb-0">
                            <input type="text" class="form-control form-control-sm" placeholder="Kode OPL" name="kodeopl" id="kodeopl">
                            <button class="btn btn-outline-secondary btn-sm cariopl" type="button" id="cariopl"><i class="fa fa-search"></i></button>
                          </div>
                          <div class="invalid-feedback errorKodeopl">
                          </div>
                        </td>
                        <td><input type="text" name="namaopl" id="namaopl" class="form-control form-control-sm" value="" readonly></td>
                        <td><input type="text" name="qtyopl" id="qtyopl" class="form-control form-control-sm text-end" onkeyup="validAngka(this)" value=0 required>
                          <div class="invalid-feedback errorQtyopl">
                          </div>
                        </td>
                        <td><button type="submit" id="btnaddopl" class="btn btn-primary btn-sm btnaddopl"><i class="fa fa-plus"></i></button></td>
                      </tbody>
                    </table>
                  </div>
                  <div class="row mt-2 mb-2">
                    <div id="tbl_paket_opl"></div>
                  </div>
                  <?= form_close() ?>
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
            echo "<p>Anda tidak berhak membuat paket / WO</p>";
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
  $(document).ready(function() {
    reload_table_paket_part();
    reload_table_paket_jasa();
    reload_table_paket_bahan();
    reload_table_paket_opl();

    $('#kodepart').on('blur', function(e) {
      let cari = $(this).val()
      if (cari !== "") {
        $.ajax({
          url: "<?= site_url('tbpaket/replpart') ?>",
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
          url: "<?= site_url('tbpaket/repljasa') ?>",
          type: 'post',
          data: {
            'kodejasa': cari
          },
          success: function(data) {
            let data_response = JSON.parse(data);
            if (data_response['kode'] == '') {
              $('#kodejasa').val('');
              $('#namajasa').val('');
              $('#jam').val('0.00');
              $('#ftr').val('0');
              return;
            } else {
              $('#kodejasa').val(data_response['kode']);
              $('#namajasa').val(data_response['nama']);
              $('#jam').val(data_response['jam']);
              if ($('#qtyjasa').val() == "") {
                $('#qtyjasa').val('0.00');
              }
              if ($('#qtyjasa').val() == "0.00") {
                $('#qtyjasa').val('0.00');
              }
              if ($('#qtyjasa').val() == "0") {
                $('#qtyjasa').val('0.00');
              }
              $('#frt').val(data_response['frt']);
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
          url: "<?= site_url('tbpaket/replbahan') ?>",
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
          url: "<?= site_url('tbpaket/replopl') ?>",
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

  function reload_table_paket_part() {
    $kdpaket = document.getElementById('kdpaket').value;
    // alert($kdpaket);
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
        kdpaket: $("#kdpaket").val()
      },
      // dataType: "json",
      url: "<?= site_url('tbpaket/table_paket_part'); ?>",
      beforeSend: function(f) {
        $('.btnreload').attr('disable', 'disabled')
        $('.btnreload').html('<i class="fa fa-spin fa-spinner"></i>')
        // alert('1');
        $('#tbl_paket_part').html('<center>Loading Table ...</center>');
      },
      success: function(data) {
        $('#tbl_paket_part').html(data);
        $('.btnreload').removeAttr('disable')
        $('.btnreload').html('<i class="fa fa-spinner">')
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }

  function reload_table_paket_opl() {
    $kdpaket = document.getElementById('kdpaket').value;
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
        kdpaket: $("#kdpaket").val()
      },
      // dataType: "json",
      url: "<?= site_url('tbpaket/table_paket_opl'); ?>",
      beforeSend: function(f) {
        $('.btnreload').attr('disable', 'disabled')
        $('.btnreload').html('<i class="fa fa-spin fa-spinner"></i>')
        // alert('1');
        $('#tbl_paket_opl').html('<center>Loading Table ...</center>');
      },
      success: function(data) {
        $('#tbl_paket_opl').html(data);
        $('.btnreload').removeAttr('disable')
        $('.btnreload').html('<i class="fa fa-spinner">')
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }

  function reload_table_paket_bahan() {
    $kdpaket = document.getElementById('kdpaket').value;
    // alert($kdpaket);
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
        kdpaket: $("#kdpaket").val()
      },
      // dataType: "json",
      url: "<?= site_url('tbpaket/table_paket_bahan'); ?>",
      beforeSend: function(f) {
        $('.btnreload').attr('disable', 'disabled')
        $('.btnreload').html('<i class="fa fa-spin fa-spinner"></i>')
        // alert('1');
        $('#tbl_paket_bahan').html('<center>Loading Table1 ...</center>');
      },
      success: function(data) {
        $('#tbl_paket_bahan').html(data);
        $('.btnreload').removeAttr('disable')
        $('.btnreload').html('<i class="fa fa-spinner">')
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }

  function reload_table_paket_jasa() {
    $kdpaket = document.getElementById('kdpaket').value;
    // alert($kdpaket);
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
        kdpaket: $("#kdpaket").val()
      },
      // dataType: "json",
      url: "<?= site_url('tbpaket/table_paket_jasa'); ?>",
      beforeSend: function(f) {
        $('.btnreload').attr('disable', 'disabled')
        $('.btnreload').html('<i class="fa fa-spin fa-spinner"></i>')
        // alert('1');
        $('#tbl_paket_jasa').html('<center>Loading Table1 ...</center>');
      },
      success: function(data) {
        $('#tbl_paket_jasa').html(data);
        $('.btnreload').removeAttr('disable')
        $('.btnreload').html('<i class="fa fa-spinner">')
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }

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
      mDec: '0'
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
      mDec: '0'
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
      mDec: '0'
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
      mDec: '0'
    })

    $('#caripart').click(function(e) {
      e.preventDefault();
      $.ajax({
        url: "<?= site_url('tbpaket/caridatapart') ?>",
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

    $('#carijasa').click(function(e) {
      e.preventDefault();
      $.ajax({
        url: "<?= site_url('tbpaket/caridatajasa') ?>",
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
        url: "<?= site_url('tbpaket/caridatabahan') ?>",
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
        url: "<?= site_url('tbpaket/caridataopl') ?>",
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

    $('.forminputjasa').submit(function() {
      $.ajax({
        type: "post",
        url: "<?= site_url('tbpaket/simpanjasa') ?>",
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
            // if (response.error.qtyjasa) {
            //   $('#qtyjasa').addClass('is-invalid');
            //   $('.errorQtyjasa').html(response.error.qtyjasa);
            // } else {
            //   $('.errorQtyjasa').fadeOut();
            //   $('#qtyjasa').removeClass('is-invalid');
            //   $('#qtyjasa').addClass('is-valid');
            // }
            // reload_table_paket_jasa();
          } else {
            $('.errorKodejasa').fadeOut();
            $('#kodejasa').removeClass('is-invalid');
            $('#kodejasa').addClass('is-valid');
            // $('.errorQtyjasa').fadeOut();
            // $('#qtyjasa').removeClass('is-invalid');
            // $('#qtyjasa').addClass('is-valid');
            reload_table_paket_jasa();
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
              document.getElementById("jam").value = "0.00";
              document.getElementById("frt").value = "0";
            }
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      });
      return false;
    })

    $('.forminputpart').submit(function() {
      $.ajax({
        type: "post",
        // url: $(this).attr('action'),
        url: "<?= site_url('tbpaket/simpanpart') ?>",
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
            if (response.error.qtypart) {
              $('#qtypart').addClass('is-invalid');
              $('.errorQtypart').html(response.error.qtypart);
            } else {
              $('.errorQtypart').fadeOut();
              $('#qtypart').removeClass('is-invalid');
              $('#qtypart').addClass('is-valid');
            }
            // reload_table_paket_part();
          } else {
            $('.errorKodepart').fadeOut();
            $('#kodepart').removeClass('is-invalid');
            $('#kodepart').addClass('is-valid');
            $('.errorQtypart').fadeOut();
            $('#qtypart').removeClass('is-invalid');
            $('#qtypart').addClass('is-valid');
            reload_table_paket_part();
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
            }
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      });
      return false;
    })

    $('.forminputbahan').submit(function() {
      $.ajax({
        type: "post",
        url: "<?= site_url('tbpaket/simpanbahan') ?>",
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
            // reload_table_paket_bahan();
          } else {
            $('.errorKodebahan').fadeOut();
            $('#kodebahan').removeClass('is-invalid');
            $('#kodebahan').addClass('is-valid');
            $('.errorQtybahan').fadeOut();
            $('#qtybahan').removeClass('is-invalid');
            $('#qtybahan').addClass('is-valid');
            reload_table_paket_bahan();
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
        url: "<?= site_url('tbpaket/simpanopl') ?>",
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
            // reload_table_paket_opl();
          } else {
            $('.errorKodeopl').fadeOut();
            $('#kodeopl').removeClass('is-invalid');
            $('#kodeopl').addClass('is-valid');
            $('.errorQtyopl').fadeOut();
            $('#qtyopl').removeClass('is-invalid');
            $('#qtyopl').addClass('is-valid');
            reload_table_paket_opl();
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
            }
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      });
      return false;
    })
  });

  function hapusdetailtbpaket($id) {
    swal({
        title: "Yakin akan hapusss ?",
        text: "Once deleted, you will not be able to recover this data!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: "<?php echo site_url('tbpaket/hapusdetailtbpaket') ?>/" + $id,
            type: "POST",
            dataType: "JSON",
            success: function(data1) {
              //if success reload ajax table
              // $('#modal_form').modal('hide');
              reload_table_paket_part();
              reload_table_paket_bahan();
              reload_table_paket_opl();
              reload_table_paket_jasa();
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
</script>