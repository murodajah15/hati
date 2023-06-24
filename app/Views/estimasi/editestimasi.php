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

<div class="modal fade" id="editestimasi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 90%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <input type="hidden" id='title' value="<?= $title ?>">
      </div>
      <div class="modal-body">
        <?php if ($edit == 1) {
          if ($title == "Edit Data Estimasi") {
          }
        ?>
          <?= form_open('estimasi/updateestimasi', ['class' => 'formeditestimasi']) ?>
          <?= csrf_field(); ?>
          <input type="hidden" id="id" name="id" value="<?= $estimasi['id'] ?>">
          <div class="row mb-2 mt-4">
            <div class="col-12 col-sm-6">
              <?php
              date_default_timezone_set('Asia/Jakarta');
              $tglestimasi = date('Y-m-d H:i:s');
              $tglwo = date('Y-m-d H:i:s');
              ?>
              <label for="nama" class="form-label mb-1">No. Estimasi / Tanggal (M-D-Y)</label>
              <div class="input-group mb-1">
                <input type='text' class='form-control form-control-sm mb-2' value="<?= $estimasi['noestimasi'] ?>" id="noestimasi" name="noestimasi" readonly style="width: 5%">
                <div class="invalid-feedback errorNoestimasi">
                </div>
                <input type="datetime-local" class='form-control form-control-sm mb-2' name='tanggal' id='tanggal' value="<?= $estimasi['tanggal'] ?>" style="width: 40%" readonly>
              </div>
              <label for="nama" class="form-label mb-0">No. Polisi</label>
              <div class="input-group mb-1">
                <input type="text" class="form-control form-control-sm" placeholder="No. Polisi" name="nopolisi" id="nopolisi" value="<?= $tbmobil['nopolisi'] ?>" readonly>
                <div class="invalid-feedback errorNopolisi">
                </div>
                <input type="text" style="width: 40%" class="form-control form-control-sm" name="norangka" id="norangka" value="<?= $tbmobil['norangka'] ?>" readonly>
              </div>
              <label for="nama" class="form-label mb-1">Customer</label>
              <div class="input-group mb-1">
                <input type="text" class="form-control form-control-sm mb-1" name="kdpemilik" id="kdpemilik" style="width: 5%" value="<?= $tbmobil['kdpemilik'] ?>" readonly>
                <input type="text" class="form-control form-control-sm mb-1" name="nmpemilik" id="nmpemilik" style="width: 40%" value="<?= $tbmobil['nmpemilik'] ?>" readonly>
              </div>
              <div class="invalid-feedback errornmpemilik">
              </div>
              <label for="nama" class="form-label mb-1">Jenis Service / Kilo Meter</label>
              <div class="input-group mb-1">
                <select class="form-select form-select-sm" style="height: 31px;" name="kdservice" id="kdservice">
                  <option value="">- PILIH JENIS SERVICE -</option>
                  <?php
                  $arr = array("PM", "GR", "PM+GR", "LAIN-LAIN");
                  $jml_kata = count($arr);
                  for ($c = 0; $c < $jml_kata; $c += 1) {
                    if ($arr[$c] == $estimasi['kdservice']) {
                      echo "<option value='$arr[$c]' selected>$arr[$c] </option>";
                    } else {
                      echo "<option value='$arr[$c]'> $arr[$c] </option>";
                    }
                  }
                  echo "</select>";
                  ?>
                </select>
                <input type="text" class="form-control form-control-sm mb-1" value="<?= $estimasi['km'] ?>" placeholder="KM">
              </div>
              <label for="nama" class="form-label mb-1">Paket</label>
              <select class="form-select form-select-mb2 " name="kdpaket" id="kdpaket">
                <option value="">- PILIH PAKET -
                  <?php
                  foreach ($tbpaket as $key) {
                    if ($estimasi['kdpaket'] == $key['kode']) {
                      echo "<option value='$key[kode]' selected>$key[kode] - $key[nama]</option>";
                    } else {
                      echo "<option value=$key[kode]>$key[kode] - $key[nama]</option>";
                    }
                  }
                  ?>
                </option>
              </select>
              <label for="nama" class="form-label mb-1">Aktifitas / Fasilitas / Status Tunggu</label>
              <div class="input-group mb-2">
                <select id='aktifitas' name='aktifitas' class="form-select form-select-sm" autofocus='autofocus'>
                  <option value=''>- PILIH AKTIFITAS -</option>
                  <?php
                  $arr = array("Workshop", "Moving Service", "Emergency Service (SRA)", "Home Service", "Flat Service", "Service Point");
                  $jml_kata = count($arr);
                  for ($c = 0; $c < $jml_kata; $c += 1) {
                    if ($arr[$c] == $estimasi['aktifitas']) {
                      echo "<option value='$arr[$c]' selected>$arr[$c] </option>";
                    } else {
                      echo "<option value='$arr[$c]'> $arr[$c] </option>";
                    }
                  }
                  echo "</select>";
                  ?>
                </select>
                <select id='fasilitas' name='fasilitas' class="form-select form-select-sm" style='width: 200x;' autofocus='autofocus'>
                  <option value=''>- PILIH FASILITAS -</option>
                  <?php
                  $arr = array("Service Car", "Service Motorcycle");
                  $jml_kata = count($arr);
                  for ($c = 0; $c < $jml_kata; $c += 1) {
                    if ($arr[$c] == $estimasi['fasilitas']) {
                      echo "<option value='$arr[$c]' selected>$arr[$c] </option>";
                    } else {
                      echo "<option value='$arr[$c]'> $arr[$c] </option>";
                    }
                  }
                  ?>
                </select>
                <select id='status_tunggu' name='status_tunggu' class="form-select form-select-sm" style='width: 200x;' autofocus='autofocus'>
                  <option value=''>- PILIH STATUS TUNGGU -</option>
                  <?php
                  $arr = array("Tunggu", "Tinggal", "Menginap");
                  $jml_kata = count($arr);
                  for ($c = 0; $c < $jml_kata; $c += 1) {
                    if ($arr[$c] == $estimasi['status_tunggu']) {
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
                <select id='int_reminder' name='int_reminder' class="form-select form-select-sm" autofocus='autofocus'>
                  <option value=''>- PILIH INTERVAL REMINDER -</option>
                  <?php
                  $arr = array("01 Bulan", "02 Bulan", "03 Bulan", "04 Bulan", "05 Bulan", "06 Bulan", "07 Bulan", "08 Bulan", "09 Bulan");
                  $jml_kata = count($arr);
                  for ($c = 0; $c < $jml_kata; $c += 1) {
                    if ($arr[$c] == $estimasi['int_reminder']) {
                      echo "<option value='$arr[$c]' selected>$arr[$c] </option>";
                    } else {
                      echo "<option value='$arr[$c]'> $arr[$c] </option>";
                    }
                  }
                  ?>
                </select>
                <select id='via' name='via' class="form-select form-select-sm" autofocus='autofocus'>
                  <option value=''>- PILIH REMINDER VIA -</option>
                  <option value='Telp'>Telp</option>
                  <option value='SMS'>SMS</option>
                  <option value='WA'>WA</option>
                  <option value='Email'>Email</option>
                  <?php
                  $arr = array("Telp", "SMS", "WA", "Email");
                  $jml_kata = count($arr);
                  for ($c = 0; $c < $jml_kata; $c += 1) {
                    if ($arr[$c] == $estimasi['via']) {
                      echo "<option value='$arr[$c]' selected>$arr[$c] </option>";
                    } else {
                      echo "<option value='$arr[$c]'> $arr[$c] </option>";
                    }
                  }
                  ?>
                </select>
              </div>
              <!-- <div class="input-group mb-1">
              <input type="text" class="form-control form-control-sm mb-1" name="aktifitas" id="aktifitas" value="<?= $estimasi['aktifitas'] ?>">
              <input type="text" class="form-control form-control-sm mb-1" name="fasilitas" id="fasilitas" value="<?= $estimasi['fasilitas'] ?>">
            </div> -->
              Service Advisor
              <div class="input-group mb-2">
                <?php
                if ($tbsa) {
                  $nmsa = $tbsa['nama'];
                } else {
                  $nmsa = '';
                }
                ?>
                <input type="text" style="width:5%;" name="kdsa" id="kdsa" class="form-control" placeholder="" value="<?= $estimasi['kdsa'] ?>">
                <input type="text" style="width:50%;" name="nmsa" id="nmsa" class="form-control" value="<?= $nmsa ?>" readonly>
                <button class="btn btn-outline-secondary" type="button" id="carisa"><i class="fa fa-search"></i></button>
                <!-- <button class="btn btn-outline-primary tambahtbsa" type="button"><i class="fa fa-plus"></i></button> -->
              </div>
              <label for="keluhan" class="form-label mb-1">Keluhan</label>
              <textarea class="form-control" name="keluhan" id="keluhan" rows="4"><?= $estimasi['keluhan'] ?></textarea>
              <div class="invalid-feedback errorKeluhan">
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <label for="keluhan" class="form-label mb-1">Nama Polis</label>
              <input type="text" class="form-control form-control-sm" name="nama_polis" id="nama_polis" value="<?= $estimasi['nama_polis'] ?>">
              <label for="keluhan" class="form-label mb-1">No. Polis</label>
              <input type="text" class="form-control form-control-sm" name="no_polis" id="no_polis" value="<?= $estimasi['no_polis'] ?>">
              <label for="keluhan" class="form-label mb-1">Tgl. Berakhir</label>
              <input type="date" class="form-control form-control-sm" name="tgl_akhir_polis" id="tgl_akhir_polis" value="<?= $estimasi['tgl_akhir_polis'] ?>">
              <label for="keluhan" class="form-label mb-1">Asuransi</label>
              <div class="input-group mb-1">
                <input type="text" class="form-control form-control-sm" name="kode_asuransi" id="kode_asuransi" value="<?= $estimasi['kode_asuransi'] ?>">
                <input type="text" style="width: 40%" class="form-control form-control-sm" name="nama_asuransi" id="nama_asuransi" value="<?= $estimasi['nama_asuransi'] ?>" readonly>
                <button class="btn btn-outline-secondary" type="button" id="cariasuransi"><i class="fa fa-search"></i></button>
              </div>
              <label for="keluhan" class="form-label mb-1">Alamat Asuransi</label>
              <textarea class="form-control" name="alamat_asuransi" rows="2"><?= $tbmobil['alamat_asuransi'] ?></textarea>
              <label for="nama" class="form-label mb-1">Surveyor</label>
              <input type="text" class="form-control form-control-sm mb-2" name="surveyor" id="surveyor" value="<?= $tbmobil['alamat_asuransi'] ?>">
              <label for="nama" class="form-label mb-0">Status WO</label>
              <br>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="klaim" name="klaim" <?= $estimasi['klaim'] > 0 ? "checked" : "" ?>>
                <label class="form-check-label" for="flexCheckDefault">Klaim</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="" id="internal" name="internal" <?= $estimasi['internal'] > 0 ? "checked" : "" ?>>
                <label class="form-check-label" for="flexCheckChecked">Internal</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="" id="inventaris" name="inventaris" <?= $estimasi['inventaris'] > 0 ? "checked" : "" ?>>
                <label class="form-check-label" for="flexCheckDefault">Inventaris</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="" id="campaign" name="campaign" <?= $estimasi['campaign'] > 0 ? "checked" : "" ?>>
                <label class="form-check-label" for="flexCheckChecked">Campaign</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="" id="booking" name="booking" <?= $estimasi['booking'] > 0 ? "checked" : "" ?>>
                <label class="form-check-label" for="flexCheckChecked">Booking</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input mb-2" type="checkbox" value="" id="lain_lain" name="lain_lain" <?= $estimasi['lain_lain'] > 0 ? "checked" : "" ?>>
                <label class="form-check-label" for="flexCheckChecked">Lain-lain</label>
              </div>
              <br>
              <label for="nama" class="form-label mb-1">PPN (%)</label>
              <input type="number" class="form-control form-control-sm mb-2" name="pr_ppn" id="pr_ppn" value="<?= $estimasi['pr_ppn'] ?>">
              <label for="nama" class="form-label mb-1">NPWP</label>
              <input type="text" class="form-control form-control-sm mb-2" name="npwp" id="npwp" value="<?= $estimasi['npwp'] ?>">
              <label for=" nama" class="form-label mb-1">Contact Person</label>
              <input type="text" class="form-control form-control-sm mb-2" name="contact_person" id="contact_person" value="<?= $estimasi['contact_person'] ?>">
              <label for=" nama" class="form-label mb-1">Nomor Contact Person</label>
              <input type="text" class="form-control form-control-sm mb-2" name="no_contact_person" id="no_contact_person" value="<?= $estimasi['no_contact_person'] ?>">
            </div>
          </div>
          <div class=" col-md-12">
            <button type="submit" value="estimasi" class="btn btn-flat btn-primary btn-sm btnupdateestimasi" id="btnupdateestimasi"><i class="fa fa-file"></i> Simpan</button>
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
          </div>
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
            echo "<p>Anda tidak berhak membuat Estimasi / WO</p>";
          }
    ?>

    <button class="btn btn-flat btn-primary btn-sm mb-3 tomboledit" type="button" disabled><i class="fa fa-plus"></i> edit</button>
  <?php
        }
  ?>
  <!-- </div> -->
  <!-- <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
  </div> -->
  </div>
</div>


<script>
  $(document).ready(function() {
    $('.formeditestimasi').on('click', '.btnupdateestimasi', function(e) {
      $('.formeditestimasi').submit(function(e) {
        e.preventDefault();
        $.ajax({
          url: $(this).attr('action'),
          // url: "<?= site_url('estimasi/updateestimasi') ?>",
          type: "post",
          data: $(this).serialize(),
          dataType: "json",
          beforeSend: function() {
            $('.btnupdateestimasi').attr('disable', 'disabled')
            $('.btnupdateestimasi').prop('disable', false)
            $('.btnupdateestimasi').html('<i class="fa fa-spin fa-spinner"></i>')
          },
          complete: function() {
            $('.btnupdateestimasi').removeAttr('disable')
            $('.btnupdateestimasi').html('<i class="fa fa-file"></i> update Estimasi')
            $('.btnupdateestimasi').prop('disabled', true)
          },
          success: function(response) {
            if (response.error) {
              // alert('error');
              if (response.error.nopolisi) {
                $('#noestimasi').addClass('is-invalid');
                $('.errorNoestimasi').html(response.error.noestimasi);
              }
              if (response.error.nopolisi) {
                $('#nopolisi').addClass('is-invalid');
                $('.errorNopolisi').html(response.error.nopolisi);
              }
              if (response.error.keluhan) {
                $('#keluhan').addClass('is-invalid');
                $('.errorKeluhan').html(response.error.keluhan);
              }
            } else {
              // alert('sukses'.response.sukses);
              $('#editestimasi').modal('hide');
              let hasil;
              hasil = document.getElementById("title").value;
              swal({
                title: "Estimasi Berhasil diupdate ",
                text: hasil,
                icon: "success",
              })
              reload_table_estimasi();
            }
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
          }
        });
      });
    });

    // $(document).ready(function() {
    // $('#table_wo_part').DataTable();
    // alert('t');
    wo_part();

    function edit_wo_part() {
      let $nowo = document.getElementById("nowo").value;
      let $kodepart = document.getElementById("kodepart").value;
      let $namapart = document.getElementById("namapart").value;
      let $qty = document.getElementById("qty").value;
      let $harga = document.getElementById("harga").value;
      let $pr_discount = document.getElementById("pr_discount").value;
      let $subtotal = document.getElementById("subtotal").value;
      $.ajax({
        method: "GET",
        data: {
          nowo: $nowo,
          kodepart: $kodepart,
          namapart: $namapart,
          qty: $qty,
          harga: $harga,
          pr_discount: $pr_discount,
          subtotal: $subtotal,
        },
        url: "<?= site_url('wo/edit_wo_part'); ?>",
        dataType: "JSON",
        success: function(data) {
          //if success reload ajax table
          // $('#modal_form').modal('hide');
          // swal({
          //   title: "Data Berhasil dihapus ",
          //   text: "",
          //   icon: "info"
          // })
          wo_part();
          // .then(function() {
          //   window.location.href = '/wo';
          // });
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error deleting data id ' + $id);
        }
      })
      wo_part();
    }

    // });

    var kode = new Array();
    $('.btnaddpart').click(function(e) {
      e.preventDefault();
      hit_subtotal();
      let $nowo = document.getElementById("nowo").value;
      let $kodepart = document.getElementById("kodepart").value;
      let $namapart = document.getElementById("namapart").value;
      let $qty = document.getElementById("qty").value;
      let $harga = document.getElementById("harga").value;
      let $pr_discount = document.getElementById("pr_discount").value;
      let $subtotal = document.getElementById("subtotal").value;
      let doc1 = '<tr><td><input type="text" name="kode[]" id="kode[]" class="form-control form-control-sm kode" value="' + $kodepart + '" readonly></td> <td><input type="text" name="namapart[]" class="form-control form-control-sm" value="' + $namapart + '" readonly></td></td> <td><input type="text" name="qty[]" class="form-control form-control-sm text-end qty" value="' + $qty + '" readonly></td></td> <td><input type="text" name="harga[]" class="form-control form-control-sm text-end" value="' + $harga + '" readonly></td><td><input type="text" name="pr_discount[]" class="form-control form-control-sm text-end" value="' + $pr_discount + '" readonly></td><td><input type="text" name="subtotal[]" class="form-control form-control-sm text-end" value="' + $subtotal + '" readonly></td><td><button type="button" class="btn btn-danger btn-sm btnhapusform"><i class="fa fa-trash"></i></button></td></tr>';
      $('.formeditpart').append(doc1);
      edit_wo_part();
    });

    $(document).on('click', '.btnhapusform', function(e) {
      e.preventDefault();
      let kode = document.getElementById('kode').value;
      let countkode = document.querySelectorAll('.kode').length;
      let countqty = document.querySelectorAll('.qty').length;
      $jmlkode = countkode;
      // alert($jmlkode);


      $.ajax({
        type: "post",
        url: "<?= site_url('wo/hitung_wo_part'); ?>",
        data: $(this).serialize(),
        dataType: "json",
        success: function(response) {
          if (response.success) {
            swal({
              title: "Data Berhasil diedit ",
              text: "",
              icon: "success"
            })
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      });

      $(this).parents('tr').remove();
    });

    function hapuspartwo($id) {
      // swal({
      //     title: "Yakin akan hapus ?",
      //     text: "Once deleted, you will not be able to recover this data!",
      //     icon: "warning",
      //     buttons: true,
      //     dangerMode: true,
      //   })
      //   .then((willDelete) => {
      //     if (willDelete) {
      $.ajax({
        // url: "<?php echo site_url('wo/hapus_wo_part') ?>/" + $id,
        url: "<?php echo site_url('wo/hapus_wo_part') ?>",
        type: "POST",
        data: {
          id: $id,
        },
        dataType: "JSON",
        success: function(data) {
          // if success reload ajax table
          // $('#modal_form').modal('hide');
          // swal({
          //   title: "Data Berhasil dihapus ",
          //   text: "",
          //   icon: "info"
          // })
          wo_part();
          // .then(function() {
          //   window.location.href = '/wo';
          // });
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error deleting data id ' + $id);
        }
      });
      // } else {
      //   swal("Batal Hapus!");
      // }
      // });
    }

    function wo_part() {
      let $nowo = document.getElementById("nowo").value;
      $.ajax({
        method: "GET",
        data: {
          nowo: $nowo,
        },
        url: "<?= site_url('wo/table_wo_part'); ?>",
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

  });

  $('#kdsa').on('keypress', function(e) {
    if (e.which == 13) {
      var keyPressed = event.keyCode || event.which;
      if (keyPressed === 13) {
        alert("Press tab to continue!");
        event.preventDefault();
        return false;
      }
    }
  });

  $('#carisa').click(function(e) {
    e.preventDefault();
    $.ajax({
      url: "<?= site_url('estimasi/caridatasa') ?>",
      dataType: "json",
      success: function(response) {
        $('.viewmodalcarisa').html(response.data).show();
        $('#modalcarisa').modal('show');
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  })

  $('#kdsa').on('blur', function(e) {
    let cari = $(this).val()
    if (cari !== "") {
      $.ajax({
        url: "<?= site_url('estimasi/replsa') ?>",
        type: 'post',
        data: {
          'kdsa': cari
        },
        success: function(data) {
          let data_response = JSON.parse(data);
          if (data_response['kode'] == '') {
            $('#kdsa').val('');
            $('#nmsa').val('');
            return;
          } else {
            $('#kdsa').val(data_response['kdsa']);
            $('#nmsa').val(data_response['nama']);
          }
        },
        error: function() {
          $('#kdsa').val('');
          return;
          // console.log('file not fount');
        }
      })
      // console.log(cari);
    }
  })

  $('#kode_asuransi').on('keypress', function(e) {
    if (e.which == 13) {
      var keyPressed = event.keyCode || event.which;
      if (keyPressed === 13) {
        alert("Press tab to continue!");
        event.preventDefault();
        return false;
      }
    }
  });
  $('#cariasuransi').click(function(e) {
    e.preventDefault();
    $.ajax({
      url: "<?= site_url('estimasi/caridataasuransi') ?>",
      dataType: "json",
      success: function(response) {
        $('.viewmodalcariasuransi').html(response.data).show();
        $('#modalcariasuransi').modal('show');
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  })
  $('#kode_asuransi').on('blur', function(e) {
    let cari = $(this).val()
    if (cari !== "") {
      $.ajax({
        url: "<?= site_url('estimasi/replasuransi') ?>",
        type: 'post',
        data: {
          'kode_asuransi': cari
        },
        success: function(data) {
          let data_response = JSON.parse(data);
          if (data_response['kode'] == '') {
            $('#kode_asuransi').val('');
            $('#nama_asuransi').val('');
            return;
          } else {
            $('#kode_asuransi').val(data_response['kode']);
            $('#nama_asuransi').val(data_response['nama']);
          }
        },
        error: function() {
          $('#kode_asuransi').val('');
          return;
          // console.log('file not fount');
        }
      })
      // console.log(cari);
    }
  });
</script>