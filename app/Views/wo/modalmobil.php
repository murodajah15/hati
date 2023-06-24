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

<div class="modal fade" id="modalmobil" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 90%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a href="#data" class="nav-link active" data-bs-toggle="tab" id="kendaraan">Data Kendaraan</a>
          </li>
          <li class="nav-item">
            <a href="#datawo" class="nav-link" data-bs-toggle="tab" id="tabestimasi">Estimasi dan WO <button class="btn btn-flat btn-info btn-sm mb-2 btn-float-right btnreload" onclick="reload_table_wo()" type="button"><i class="fa fa-spinner"></i></button></a>
          </li>
          <!-- <li class="nav-item">
              <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
            </li> -->
        </ul>
        <div class="tab-content">
          <div class="tab-pane fade show active" id="data">
            <?= form_open('tbmobil/updatedata', ['class' => 'formtbmobilwo']) ?>
            <?= csrf_field(); ?>
            <input type="hidden" class="form-control" name="id" id="id" value="<?= $tbmobil['id'] ?>">
            <input type="hidden" class="form-control" name="nopolisilama" id="nopolisilama" value="<?= $tbmobil['nopolisi'] ?>">
            <div class="row mb-2">
              <div class="col-12 col-sm-6">
                <label for="kode" class="form-label mb-0">No. Polisi</label>
                <input type="text" class="form-control mb-1" name="nopolisi" id="nopolisi" value="<?= $tbmobil['nopolisi'] ?>">
                <div class="invalid-feedback errorNopolisi">
                </div>
                <label for="nama" class="form-label mb-0">No. Rangka</label>
                <input type="text" class="form-control mb-1" name="norangka" id="norangka" value="<?= $tbmobil['norangka'] ?>">
                <label for="nama" class="form-label mb-0">No. Mesin</label>
                <input type="text" class="form-control mb-1" name="nomesin" id="nomesin" value="<?= $tbmobil['nomesin'] ?>">
                <label for="nama" class="form-label mb-0">Merek</label>

                <label for="nama" class="form-label mb-1">Merek</label>
                <select class="form-select" name="kdmerek" id="kdmerek" required>
                  <option value="">[Pilih Merek]
                    <?php
                    foreach ($tbmerek as $key) {
                      if ($key['kode'] == $tbmobil['kdmerek']) {
                        echo "<option value='$key[kode]' selected>$key[kode] - $key[nama]</option>";
                      } else {
                        echo "<option value='$key[kode]'>$key[kode] - $key[nama]</option>";
                      }
                    }
                    ?>
                  </option>
                </select>
                <label for="nama" class="form-label mb-0 labelmodel">Model</label>
                <select class="form-select mb-1" name="kdmodel" id="kdmodel" required>
                  <option value="">[Pilih Model]
                    <?php
                    foreach ($tbmodel as $key) {
                      if ($key['kode'] == $tbmobil['kdmodel']) {
                        echo "<option value='$key[kode]' selected>$key[kode] - $key[nama]</option>";
                      } else {
                        echo "<option value='$key[kode]'>$key[kode] - $key[nama]</option>";
                      }
                    }
                    ?>
                  </option>
                </select>
                <label for="nama" class="form-label mb-0 labeltipe">Tipe</label>
                <select class="form-select mb-1" name="kdtipe" id="kdtipe" required>
                  <option value="">[Pilih Tipe]
                    <?php
                    foreach ($tbtipe as $key) {
                      if ($key['kode'] == $tbmobil['kdtipe']) {
                        echo "<option value='$key[kode]' selected>$key[kode] - $key[nama]</option>";
                      } else {
                        echo "<option value='$key[kode]'>$key[kode] - $key[nama]</option>";
                      }
                    }
                    ?>
                  </option>
                </select>
                <label for="nama" class="form-label mb-0 labeltipe">Warna</label>
                <select class="form-select mb-1" name="kdwarna" id="kdwarna">
                  <option value="">[Pilih Warna]
                    <?php
                    foreach ($tbwarna as $key) {
                      if ($key['kode'] == $tbmobil['kdwarna']) {
                        echo "<option value='$key[kode]' selected>$key[kode] - $key[nama]</option>";
                      } else {
                        echo "<option value='$key[kode]'>$key[kode] - $key[nama]</option>";
                      }
                    }
                    ?>
                  </option>
                </select>
                <label for="nama" class="form-label mb-0 labeltipe">Jenis</label>
                <select class="form-select mb-1" name="kdjenis" id="kdjenis">
                  <option value="">[Pilih Jenis]
                    <?php
                    foreach ($tbjenis as $key) {
                      if ($key['kode'] == $tbmobil['kdjenis']) {
                        echo "<option value='$key[kode]' selected>$key[kode] - $key[nama]</option>";
                      } else {
                        echo "<option value='$key[kode]'>$key[kode] - $key[nama]</option>";
                      }
                    }
                    ?>
                  </option>
                </select>
              </div>
              <div class="col-12 col-sm-6">
                <div class="input-group">
                  <div class="col-md-8">
                    <label for="nama" class="form-label mb-0">No. STNK</label>
                    <input type="text" class="form-control mb-1" name="nostnk" id="nostnk" value="<?= $tbmobil['nostnk'] ?>">
                  </div>
                  <div class="col-md-4">
                    <label for="nama" class="form-label mb-0">Tgl. STNK</label>
                    <input type="date" class="form-control mb-1" name="tglstnk" id="tglstnk" value="<?= $tbmobil['tglstnk'] ?>">
                  </div>
                </div>
                <label for="nama" class="form-label mb-0">Bahan Bakar</label>
                <input type="text" class="form-control mb-1" name="bahanbakar" id="bahanbakar" value="<?= $tbmobil['bahanbakar'] ?>">
                <label for="nama" class="form-label mb-0">Dealer Penjualan</label>
                <input type="text" class="form-control mb-1" name="dealerjual" id="dealerjual" value="<?= $tbmobil['dealerjual'] ?>">
                <button class="btn btn-flat btn-primary btn-sm mt-2 mb-2 tomboltambahpemilik" type="button"><i class="fa fa-plus"></i> Customer</button>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" placeholder="Pemilik" name="kdpemilik" id="kdpemilik" class="col-4" value="<?= $tbmobil['kdpemilik'] ?>">
                  <button class="btn btn-outline-secondary btn-sm" type="button" id="caripemilik">Cari</button>
                  <input type="text" class="col-8" class="form-control" name="nmpemilik" id="nmpemilik" readonly value="<?= $tbmobil['nmpemilik'] ?>">
                </div>
                <label for="nama" class="form-label mb-0">Pemakai</label>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" placeholder="Pemakai" name="kdpemakai" id="kdpemakai" class="col-4" value="<?= $tbmobil['kdpemakai'] ?>">
                  <button class="btn btn-outline-secondary btn-sm" type="button" id="caripemakai">Cari</button>
                  <input type="text" class="col-8" class="form-control" name="nmpemakai" id="nmpemakai" readonly value="<?= $tbmobil['nmpemakai'] ?>">
                </div>
                NPWP <input type="text" class="form-control" name="npwp" id="npwp" value="<?= $tbmobil['npwp'] ?>" readonly>
                Contact Person <input type="text" class="form-control" name="contact_person" id="contact_person" value="<?= $tbmobil['contact_person'] ?>" readonly>
                No. Contact Person <input type="text" class="form-control" name="no_contact_person" id="no_contact_person" value="<?= $tbmobil['no_contact_person'] ?>" readonly>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" id="btnupdate" class="btn btn-success btnsimpan">Update</button>
              <button type="button" id="btnestimasi" class="btn btn-primary btnestimasi" disabled>Tambah Estimasi & WO</button>
            </div>
            <?= form_close() ?>
          </div>
          <div class="tab-pane fade datawo" id="datawo">
            Estimasi
            <div id="tabel_estimasi"></div>
            WO
            <div id="tabel_wo"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  $("#tabestimasi").on("click", function() {
    reload_table_wo();
    reload_table_estimasi();
  });

  // reload_table_wo();
  // reload_table_estimasi();

  function reload_table_wo() {
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
      $('#tbl-wo').DataTable();
    });

    $.ajax({
      url: "<?= site_url('wo/table_wo'); ?>",
      beforeSend: function(f) {
        $('.btnreload').attr('disable', 'disabled')
        $('.btnreload').html('<i class="fa fa-spin fa-spinner"></i>')
        // alert('1');
        $('#tabel_wo').html('<center>Loading Table ...</center>');
      },
      success: function(data) {
        // alert(data);
        $('#tabel_wo').html(data);
        $('.btnreload').removeAttr('disable')
        $('.btnreload').html('<i class="fa fa-spinner">')
      }
    })
  }

  function reload_table_estimasi() {
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
      $('#tbl-estimasi').DataTable();
    });

    $.ajax({
      url: "<?= site_url('estimasi/table_estimasi'); ?>",
      beforeSend: function(f) {
        $('.btnreload').attr('disable', 'disabled')
        $('.btnreload').html('<i class="fa fa-spin fa-spinner"></i>')
        // alert('1');
        $('#tabel_estimasi').html('<center>Loading Table ...</center>');
      },
      success: function(data) {
        // alert(data);
        $('#tabel_estimasi').html(data);
        $('.btnreload').removeAttr('disable')
        $('.btnreload').html('<i class="fa fa-spinner">')
      }
    })
  }

  $(document).ready(function() {
    $('.formtbmobilwo').submit(function(e) {
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
          $('.btnsimpan').html('Update')
        },
        success: function(response) {
          if (response.error) {
            // alert('error');
            if (response.error.nopolisi) {
              $('#nopolisi').addClass('is-invalid');
              $('.errorNopolisi').html(response.error.nopolisi);
            }
          } else {
            // alert('sukses'.response.sukses);
            // $('#modalwo').modal('hide');
            document.getElementById("btnestimasi").disabled = false;
            document.getElementById("tabestimasi").disabled = false;
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
              icon: "success",
            })
            reload_table_wo();
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      });
      return false;
    })
  });

  $('#btnestimasi').click(function() {
    $nopolisi = document.getElementById('nopolisi').value;
    $.ajax({
      url: "<?= site_url('wo/formestimasi') ?>",
      dataType: "json",
      type: "post",
      data: {
        nopolisi: $nopolisi
      },
      success: function(response) {
        $('.viewmodaltambahwo').html(response.data).show();
        $('#modalestimasi').modal('show');
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  });
</script>