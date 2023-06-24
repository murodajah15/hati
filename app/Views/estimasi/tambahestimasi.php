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

<div class="modal fade" id="tambahestimasi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 90%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <input type="hidden" id='title' value="<?= $title ?>">
        <?php
        $nowo_sementara = "WO" . uniqid();
        ?>
      </div>
      <div class="modal-body">
        <?php if ($tambah == 1) {
        ?>
          <?= form_open('estimasi/simpanestimasi', ['class' => 'formtambahestimasi']) ?>

          <?= csrf_field(); ?>
          <div class="row mb-2 mt-4">
            <div class="col-12 col-sm-6">
              <?php
              date_default_timezone_set('Asia/Jakarta');
              $tglestimasi = date('Y-m-d H:i:s');
              $tglwo = date('Y-m-d H:i:s');
              ?>
              <label for="nama" class="form-label mb-1">No. Estimasi / Tanggal (M-D-Y)</label>
              <div class="input-group mb-1">
                <input type='text' class='form-control form-control-sm mb-2' value="AUTO GENERATE" id="noestimasijadi" name="noestimasijadi" readonly style="width: 5%">
                <input type="datetime-local" class='form-control form-control-sm mb-2' name='tanggal' id='tanggal' value="<?= $tglestimasi ?>" style="width: 40%" readonly>
              </div>
              <label for="nama" class="form-label mb-0">No. Polisi</label>
              <div class="input-group mb-1">
                <input type="text" class="form-control form-control-sm" placeholder="No. Polisi" name="nopolisi" id="nopolisi" value="<?= $tbmobil['nopolisi'] ?>" readonly>
                <input type="text" class="col-8" class="form-control form-control-sm" name="norangka" id="norangka" value="<?= $tbmobil['norangka'] ?>" readonly>
              </div>
              <label for="nama" class="form-label mb-1">Customer</label>
              <div class="input-group mb-1">
                <input type="text" class="form-control form-control-sm mb-2" name="kdpemilik" id="kdpemilik" readonly style="width: 5%" value="<?= $tbmobil['kdpemilik'] ?>">
                <input type="text" class="form-control form-control-sm mb-2" name="nmpemilik" id="nmpemilik" readonly style="width: 40%" value="<?= $tbmobil['nmpemilik'] ?>">
              </div>
              <div class="invalid-feedback errornmpemilik">
              </div>
              <label for="nama" class="form-label mb-1">Jenis Service / Kilo Meter</label>
              <div class="input-group mb-2">
                <select required id='kdservice' name='kdservice' class="form-select form-select-sm" autofocus='autofocus'>
                  <option value=''>- PILIH JENIS SERVICE -</option>
                  <option value='PM'>PM</option>
                  <option value='GR'>GR</option>
                  <option value='PM+GR'>PM+GR</option>
                  <option value='LAIN-LAIN'>LAIN-LAIN</option>
                </select>
                <input type="text" class="form-control form-control-sm" name="km" placeholder="KM">
              </div>
              <label for="nama" class="form-label mb-1">Paket</label>
              <select id='kdpaket' name='kdpaket' class="form-select form-select-sm">
                <option value=''>- PILIH PAKET -</option>
                <?php
                foreach ($tbpaket as $key) {
                  echo "<option value=$key[kode]>$key[kode] - $key[nama]</option>";
                }
                ?>
              </select>
              <label for="nama" class="form-label mb-1">Aktifitas / Fasilitas / Status Tunggu</label>
              <div class="input-group mb-2">
                <select id='aktifitas' name='aktifitas' class="form-select form-select-sm" autofocus='autofocus'>
                  <option value=''>- PILIH AKTIFITAS -</option>
                  <option value='Workshop'>Workshop</option>
                  <option value='Moving Service'>Moving Service</option>
                  <option value='Emergency Service (SRA)'>Emergency Service (SRA)</option>
                  <option value='Home Service'>Home Service</option>
                  <option value='Flat Service'>Flat Service</option>
                  <option value='Service Point'>Service Point</option>
                </select>
                <select id='fasilitas' name='fasilitas' class="form-select form-select-sm" style='width: 200x;' autofocus='autofocus'>
                  <option value=''>- PILIH FASILITAS -</option>
                  <option value='Service Car'>Service Car</option>
                  <option value='Service Motorcycle'>Service Motorcycle</option>
                </select>
                <select id='status_tunggu' name='status_tunggu' class="form-select form-select-sm" style='width: 200x;' autofocus='autofocus'>
                  <option value=''>- PILIH STATUS TUNGGU -</option>
                  <option value='Tunggu'>Tunggu</option>
                  <option value='Tinggal'>Tinggal</option>
                  <option value='Menginap'>Menginap</option>
                </select>
              </div>
              <label for="nama" class="form-label mb-1">Interval Reminder / Via</label>
              <div class="input-group mb-2">
                <select id='int_reminder' name='int_reminder' class="form-select form-select-sm" autofocus='autofocus'>
                  <option value=''>- PILIH INTERVAL REMINDER -</option>
                  <option value='01 Bulan'>01 Bulan</option>
                  <option value='02 Bulan'>02 Bulan</option>
                  <option value='03 Bulan'>03 Bulan</option>
                  <option value='04 Bulan'>04 Bulan</option>
                  <option value='05 Bulan'>05 Bulan</option>
                  <option value='06 Bulan'>06 Bulan</option>
                  <option value='07 Bulan'>07 Bulan</option>
                  <option value='08 Bulan'>08 Bulan</option>
                  <option value='09 Bulan'>09 Bulan</option>
                </select>
                <select id='via' name='via' class="form-select form-select-sm" autofocus='autofocus'>
                  <option value=''>- PILIH REMINDER VIA -</option>
                  <option value='Telp'>Telp</option>
                  <option value='SMS'>SMS</option>
                  <option value='WA'>WA</option>
                  <option value='Email'>Email</option>
                </select>
              </div>
              Service Advisor
              <div class="input-group mb-2">
                <input type="text" style="width:5%;" name="kdsa" id="kdsa" class="form-control" placeholder="">
                <input type="text" style="width:50%;" name="nmsa" id="nmsa" class="form-control" readonly>
                <button class="btn btn-outline-secondary" type="button" id="carisa"><i class="fa fa-search"></i></button>
                <!-- <button class="btn btn-outline-primary tambahtbsa" type="button"><i class="fa fa-plus"></i></button> -->
              </div>
              <label for="keluhan" class="form-label mb-1">Keluhan</label>
              <textarea class="form-control" name="keluhan" id="keluhan" rows="4"></textarea>
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
                <input type="text" style="width:10%;" name="kode_asuransi" id="kode_asuransi" class="form-control" placeholder="">
                <input type="text" style="width:40%;" name="nama_asuransi" id="nama_asuransi" class="form-control" readonly>
                <button class="btn btn-outline-secondary" type="button" id="cariasuransi"><i class="fa fa-search"></i></button>
                <!-- <input type="text" style="width:10%;" class="form-control form-control-sm" name="kode_asuransi" id="kode_asuransi" value="<?= $tbmobil['kode_asuransi'] ?>">
                <input type="text" style="width:40%;" class="form-control form-control-sm" name="nama_asuransi" id="nama_asuransi" value="<?= $tbmobil['nama_asuransi'] ?>" readonly>
                <button class="btn btn-outline-secondary" type="button" id="cariasuransi"><i class="fa fa-search"></i></button> -->
              </div>
              <label for="keluhan" class="form-label mb-1">Alamat Asuransi</label>
              <textarea class="form-control" name="alamat_asuransi" rows="2"></textarea>
              <label for="nama" class="form-label mb-1">Surveyor</label>
              <input type="text" class="form-control form-control-sm mb-2" name="surveyor" id="surveyor">
              <label for="nama" class="form-label mb-0">Status WO</label>
              <br>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="" id="klaim" name="klaim">
                <label class="form-check-label" for="flexCheckDefault">Klaim</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="" id="internal" name="internal">
                <label class="form-check-label" for="flexCheckChecked">Internal</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="" id="inventaris" name="inventaris">
                <label class="form-check-label" for="flexCheckDefault">Inventaris</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="" id="campaign" name="campaign">
                <label class="form-check-label" for="flexCheckChecked">Campaign</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="" id="booking" name="booking">
                <label class="form-check-label" for="flexCheckChecked">Booking</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input mb-2" type="checkbox" value="" id="lain_lain" name="lain_lain">
                <label class="form-check-label" for="flexCheckChecked">Lain-lain</label>
              </div>
              <br>
              <label for="nama" class="form-label mb-1">PPN (%)</label>
              <input type="number" class="form-control form-control-sm mb-2" name="pr_ppn" id="pr_ppn">
              <label for="nama" class="form-label mb-1">NPWP</label>
              <input type="text" class="form-control form-control-sm mb-2" name="npwp" id="npwp" readonly>
              <label for="nama" class="form-label mb-1">Contact Person</label>
              <input type="text" class="form-control form-control-sm mb-2" name="contact_person" id="contact_person" readonly>
              <label for="nama" class="form-label mb-1">Nomor Contact Person</label>
              <input type="text" class="form-control form-control-sm mb-2" name="no_contact_person" id="no_contact_person" readonly>
            </div>
          </div>
          <div class="col-md-12">
            <button type="submit" value="estimasi" class="btn btn-flat btn-primary btnsimpanestimasi" id="btnsimpanestimasi"><i class="fa fa-file"></i> Simpan</button>
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
            echo "<p>Anda tidak berhak membuat Estimasi / WO</p>";
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
    $('.formtambahestimasi').on('click', '.btnsimpanestimasi', function(e) {
      $('.formtambahestimasi').submit(function(e) {
        e.preventDefault();
        $.ajax({
          url: $(this).attr('action'),
          // url: "<?= site_url('estimasi/simpanestimasi') ?>",
          type: "post",
          data: $(this).serialize(),
          dataType: "json",
          beforeSend: function() {
            $('.btnsimpanestimasi').attr('disable', 'disabled')
            $('.btnsimpanestimasi').prop('disable', false)
            $('.btnsimpanestimasi').html('<i class="fa fa-spin fa-spinner"></i>')
          },
          complete: function() {
            $('.btnsimpanestimasi').removeAttr('disable')
            $('.btnsimpanestimasi').html('<i class="fa fa-file"></i> Simpan Estimasi')
            $('.btnsimpanestimasi').prop('disabled', true)
          },
          success: function(response) {
            if (response.error) {
              // alert('error');
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
              $('#tambahestimasi').modal('hide');
              let hasil;
              hasil = document.getElementById("title").value;
              swal({
                title: "Estimasi Berhasil disimpan ",
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

    // $(document).ready(function() {
    // $('#table_wo_part').DataTable();
    // alert('t');
    wo_part();

    function tambah_wo_part() {
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
        url: "<?= site_url('wo/tambah_wo_part'); ?>",
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
      $('.formtambahpart').append(doc1);
      tambah_wo_part();
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
              title: "Data Berhasil ditambah ",
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
  })
</script>