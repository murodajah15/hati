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
  <div class="modal-dialog" style="max-width: 80%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php if ($tambah == 1) {
        ?>
          <!-- <form method='post' href="wo/simpanestimasi" enctype='multipart/form-data' class='formtambahestimasi'> -->
          <?= form_open('wo/simpanestimasi', ['class' => 'formtambahestimasi']) ?>
          <?= csrf_field(); ?>
          <div class="row mb-2 mt-4">
            <div class="col-12 col-sm-6">
              <?php
              date_default_timezone_set('Asia/Jakarta');
              $tglestimasi = date('Y-m-d H:i:s');
              $tglwo = date('Y-m-d H:i:s');
              // $noestimasi = 'ES' . date('Y') . date('m') . sprintf("%05s", intval(substr('00000', -5)) + 1);
              // foreach ($estimasi as $row) {
              //   $noestimasi = 'ES' . date('Y') . date('m') . sprintf("%05s", intval(substr($row->noestimasi, -5)) + 1);
              // }
              ?>
              <label for="nama" class="form-label mb-1">No. Estimasi / Tanggal (M-D-Y)</label>
              <div class="input-group mb-1">
                <input type='text' class='form-control form-control-sm mb-2' name='noestimasi' id='noestimasi' value="AUTO GENERATE" readonly style="width: 5%">
                <input type="datetime-local" class='form-control form-control-sm mb-2' name='tanggal' id='tanggal' value="<?= $tglestimasi ?>" style="width: 40%" readonly>
              </div>
              <label for="nama" class="form-label mb-1">No. WO / Tanggal (M-D-Y)</label>
              <div class="input-group mb-1">
                <input type='text' class='form-control form-control-sm mb-2' name='nowo' id='nowo' value="AUTO GENERATE" readonly style="width: 5%">
                <input type="datetime-local" class='form-control form-control-sm mb-2' name='tglwo' id='tglwo' value="<?= $tglwo ?>" style="width: 40%" readonly>
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
                <select required id='kelompok' name='kelompok' class="form-select form-select-sm" style='width: 200x;' autofocus='autofocus'>
                  <option value='GR.'>GR</option>
                  <option value='LAIN-LAIN'>LAIN-LAIN</option>
                </select>
                <input type="text" class="form-control form-control-sm" name="km">
              </div>
              <label for="nama" class="form-label mb-1">Aktifitas / Fasilitas</label>
              <div class="input-group mb-2">
                <select id='kelompok' name='kelompok' class="form-select form-select-sm" style='width: 200x;' autofocus='autofocus'>
                  <option value=''>- PILIH AKTIFITAS -</option>
                  <option value='Workshop'>Workshop</option>
                  <option value='Moving Service'>Moving Service</option>
                  <option value=''>Emergency Service (SRA)</option>
                  <option value='Home Service'>Home Service</option>
                  <option value='Flat Service'>Flat Service</option>
                  <option value='Service Point'>Service Point</option>
                </select>
                <select id='kelompok' name='kelompok' class="form-select form-select-sm" style='width: 200x;' autofocus='autofocus'>
                  <option value=''>- PILIH FASILITAS -</option>
                  <option value='Service Car'>Service Car</option>
                  <option value='Service Motorcycle'>Service Motorcycle</option>
                </select>
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
                <input type="text" class="form-control form-control-sm" name="nama_asuransi" id="kode_asuransi" value="<?= $tbmobil['kode_asuransi'] ?>" readonly>
                <input type="text" class="col-8" class="form-control form-control-sm" name="kode_asuransi" id="nama_asuransi" value="<?= $tbmobil['nama_asuransi'] ?>" readonly>
              </div>
              <label for="keluhan" class="form-label mb-1">Alamat Asuransi</label>
              <textarea class="form-control" name="alamat_asuransi" rows="2"></textarea>
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
              <label for="nama" class="form-label mb-1">NPWP</label>
              <input type="text" class="form-control form-control-sm mb-2" name="npwp" id="npwp" readonly>
              <label for="nama" class="form-label mb-1">Contact Person</label>
              <input type="text" class="form-control form-control-sm mb-2" name="contact_person" id="contact_person" readonly>
              <label for="nama" class="form-label mb-1">Nomor Contact Person</label>
              <input type="text" class="form-control form-control-sm mb-2" name="no_contact_person" id="no_contact_person" readonly>
            </div>
          </div>
          <ul class="nav nav-tabs">
            <li class="nav-item">
              <a href="#summary" class="nav-link active" data-bs-toggle="tab">Summary</a>
            </li>
            <li class="nav-item">
              <a href="#sparepart" class="nav-link" data-bs-toggle="tab">Spare Part</a>
            </li>
            <li class="nav-item">
              <a href="#jasa" class="nav-link" data-bs-toggle="tab">Jasa</a>
            </li>
            <li class="nav-item">
              <a href="#bahan" class="nav-link" data-bs-toggle="tab">Bahan</a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade show active" id="summary">
              <br>
              <div class="row mb-2">
                <div class="col-12 col-sm-6">
                  <label for="nama" class="form-label mb-1">Total Jasa</label>
                  <input type="text" class="form-control form-control-sm mb-2" name="npwp" id="npwp" readonly>
                  <label for="nama" class="form-label mb-1">Total Bahan</label>
                  <input type="text" class="form-control form-control-sm mb-2" name="npwp" id="npwp" readonly>
                  <label for="nama" class="form-label mb-1">Total Jasa & Bahan</label>
                  <input type="text" class="form-control form-control-sm mb-2" name="npwp" id="npwp" readonly>
                </div>
                <div class="col-12 col-sm-6">
                  <label for="nama" class="form-label mb-1">Total Jasa & Bahan</label>
                  <input type="text" class="form-control form-control-sm mb-2" name="npwp" id="npwp" readonly>
                  <label for="nama" class="form-label mb-1">Total Spare Part</label>
                  <input type="text" class="form-control form-control-sm mb-2" name="npwp" id="npwp" readonly>
                  <label for="nama" class="form-label mb-1">DPP</label>
                  <input type="text" class="form-control form-control-sm mb-2" name="npwp" id="npwp" readonly>
                  <label for="nama" class="form-label mb-1">PPN</label>
                  <input type="text" class="form-control form-control-sm mb-2" name="npwp" id="npwp" readonly>
                  <label for="nama" class="form-label mb-1">Materai</label>
                  <input type="text" class="form-control form-control-sm mb-2" name="npwp" id="npwp" readonly>
                  <label for="nama" class="form-label mb-1">Grand Total</label>
                  <input type="text" class="form-control form-control-sm mb-2" name="npwp" id="npwp" readonly>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="sparepart">
              <br>
              <div class="row mb-2">
                <table class="table table-striped" style="width:100%">
                  <thead>
                    <tr>
                      <!-- <th>ID</th> -->
                      <th width="200">Kode Part</th>
                      <th width="400">Nama Spare Part</th>
                      <th width="100">Qty</th>
                      <th>Harga Satuan</th>
                      <th width="90">Disc (%)</th>
                      <th>Subtotal</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody">
                    <input type="hidden" name="id" id="id">
                    <td>
                      <div class="input-group mb-0">
                        <input type="text" class="form-control form-control-sm" placeholder="Kode" name="kodepart" id="kodepart" onblur="hit_subtotal()">
                        <button class="btn btn-outline-secondary btn-sm caripart" type="button" id="button-addon2"><i class="fa fa-search"></i></button>
                      </div>
                    </td>
                    <td><input type="text" name="namapart" id="namapart" class="form-control form-control-sm" value="" readonly></td>
                    <td><input type="text" name="qty" id="qty" class="form-control form-control-sm text-end" onkeyup="validAngka(this)" value=0 onblur="hit_subtotal()"></td>
                    <td><input type="text" name="harga" id="harga" class="form-control form-control-sm text-end" onkeyup="validAngka_no_titik(this)" value=0 onblur="hit_subtotal()"></td>
                    <td><input type="text" name="disc" id="disc" class="form-control form-control-sm text-end" onkeyup="validAngka(this)" value=0 onblur="hit_subtotal()"></td>
                    <td><input type="text" name="subtotal" id="subtotal" class="form-control form-control-sm text-end" value=0 readonly></td>
                    </td>
                    <td><button type="submit" id="btnaddpart" class="btn btn-primary btn-sm btnaddpart"><i class="fa fa-plus"></i></button></td>
                    </tbody>
                </table>
              </div>
              <div class="row mb-2">
                <!-- <div class="col-md-12">
                          <button type="button" id="btnremoveall" class="btn btn-danger btn-sm btnremoveall"><i class="fa fa-trash"></i>Remove All</button>
                        </div> -->
                <table class="table table-striped" style="width:100%">
                  <thead>
                    <tr>
                      <!-- <th>ID</th> -->
                      <th width="200">Kode Part</th>
                      <th width="400">Nama Spare Part</th>
                      <th width="100">Qty</th>
                      <th>Harga Satuan</th>
                      <th width="90">Disc (%)</th>
                      <th>Subtotal</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody class="formtambahpart">
                  </tbody>
                </table>
                <div class="col-12 col-sm-6">
                  <table class="table table-striped" style="width:100%">
                    <thead>
                      <tr>
                        <!-- <th>ID</th> -->
                        <th width="150">Total Item</th>
                        <th width="150">Total QTY</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <td><input type="text" class="form-control form-control-sm" placeholder="Kode" name="kdpart" id="kdpart" readonly></td>
                      <td><input type="text" name="nmpart" id="nmpart" class="form-control form-control-sm" readonly></td>
                      <td><input type="text" name="qty" id="qty" class="form-control form-control-sm text-end" readonly></td>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="jasa">
              <br>
              <div class="row mb-2">
                __ Jasa __
              </div>
            </div>
            <div class="tab-pane fade " id="bahan">
              <div class="row mb-2">
                __ Bahan __
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <!-- <button type="submit" value="estimasi" class="btn btn-flat btn-primary btn-sm mb-3 btnsimpanestimasi"><i class="fa fa-file"></i> Simpan Estimasi</button>
            <button type="submit" value="wo" class="btn btn-flat btn-warning btn-sm mb-3 btnsimpanwo"><i class="fa fa-file"></i> Simpan WO</button> -->
            <button type="submit" value="estimasi" class="btn btn-flat btn-primary btn-sm mb-3 btnsimpanestimasi"><i class="fa fa-file"></i> Simpan</button>
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
          vexpired();
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


<script>
  $(document).ready(function() {
    $('.btnaddpart').click(function(e) {
      e.preventDefault();
      let $kodepart = document.getElementById("kodepart").value;
      let $namapart = document.getElementById("namapart").value;
      let $qty = document.getElementById("qty").value;
      let $harga = document.getElementById("harga").value;
      let $disc = document.getElementById("disc").value;
      let $subtotal = document.getElementById("subtotal").value;
      let doc1 = '<tr><td><input type="text" name="kodepart[]" class="form-control form-control-sm" value="' + $kodepart + '" readonly></td> <td><input type="text" name="namapart[]" class="form-control form-control-sm" value="' + $namapart + '" readonly></td></td> <td><input type="text" name="qty[]" class="form-control form-control-sm text-end" value="' + $qty + '" readonly></td></td> <td><input type="text" name="harga[]" class="form-control form-control-sm text-end" value="' + $harga + '" readonly></td><td><input type="text" name="disc[]" class="form-control form-control-sm text-end" value="' + $disc + '" readonly></td><td><input type="text" name="subtotal[]" class="form-control form-control-sm text-end" value="' + $subtotal + '" readonly></td><td><button type="button" class="btn btn-danger btn-sm btnhapusform"><i class="fa fa-trash"></i></button></td></tr>';
      $('.formtambahpart').append(doc1);
      // $('.formtambahpart').append(`
      //   <tr>
      //     <td>
      //     <input type="text" name="kodepart[]" class="form-control form-control-sm" value='` + $kodepart + ` readonly >
      //     </td>
      //     <td>
      //       <input type="text" name="namapart[]" class="form-control form-control-sm" value='` + $namapart + ` readonly>
      //     </td>
      //     <td>
      //       <input type="text" name="qty[]" class="form-control form-control-sm text-end" value=` + $qty + ` readonly>
      //     </td>
      //     <td>
      //       <input type="text" name="harga[]" class="form-control form-control-sm text-end" value=` + $harga + ` readonly>
      //     </td>
      //     <td>
      //       <input type="text" name="disc[]" class="form-control form-control-sm text-end" value=` + $disc + ` readonly>
      //     </td>
      //     <td style="text-align:right">
      //       <input type="text" name="subtotal[]" class="form-control form-control-sm text-end" value=` + $subtotal + ` readonly>
      //     </td>
      //     <td>
      //       <button type="button" class="btn btn-danger btn-sm btnhapusform"><i class="fa fa-trash"></i></button>
      //     </td>
      //   </tr>
      // `)
      // $('input[name^="kodepart"]').each(function() {
      //   $(this).val(kodepart);
      // });
      // $('input[name^="namapart"]').each(function() {
      //   $(this).val(namapart);
      // });
      // $('input[name^="qty"]').each(function() {
      //   $(this).val(qty);
      // });
      // $('input[name^="harga"]').each(function() {
      //   $(this).val(harga);
      // });
      // $('input[name^="disc"]').each(function() {
      //   $(this).val(disc);
      // });
      // $('input[name^="subtotal"]').each(function() {
      //   $(this).val(subtotal);
      // });
    });

    $(document).on('click', '.btnhapusform', function(e) {
      e.preventDefault();
      $(this).parents('tr').remove();
    });

    function hit_subtotal() {
      // let total_sementara = parseInt(document.getElementById("qty").value) * parseInt(document.getElementById("harga").value)
      let total_sementara = document.getElementById("qty").value * document.getElementById("harga").value
      // alert(total_sementara)
      // alert(total_sementara1)
      let discount = total_sementara * (parseInt(document.getElementById("disc").value) / 100)
      document.getElementById("subtotal").value = total_sementara - discount
    }

    $('.formtambahestimasi').submit(function(e) {
      e.preventDefault();
      $.ajax({
        // url: "<?= site_url('wo/simpanestimasi') ?>",
        type: "post",
        url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType: "json",
        beforeSend: function() {
          $('.btnsimpanestimasi').attr('disable', 'disabled')
          $('.btnsimpanestimasi').html('<i class="fa fa-spin fa-spinner"></i>')
        },
        complete: function() {
          $('.btnsimpanestimasi').removeAttr('disable')
          $('.btnsimpanestimasi').html('Simpan')
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
            $('#tambahestimasi').modal('hide');
            // swal({
            //   title: "Data berhasil disimpan",
            //   text: "",
            //   icon: "success",
            //   buttons: true,
            //   dangerMode: true,
            // })
            swal({
              title: "Estimasi Berhasil disimpan ",
              text: "",
              icon: "success",
            })
            // reload_table();
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      });
    });

    $(document).on('click', '.btnsimpanwo', function(e) {
      alert('wo');
      $('.formtambahestimasi').submit(function(e) {
        e.preventDefault();
        $.ajax({
          type: "post",
          // url: $(this).attr('action'),
          url: "<?= site_url('wo/simpanwo') ?>",
          data: $(this).serialize(),
          dataType: "json",
          beforeSend: function() {
            $('.btnsimpanwo').attr('disable', 'disabled')
            $('.btnsimpanwo').html('<i class="fa fa-spin fa-spinner"></i>')
          },
          complete: function() {
            $('.btnsimpanwo').removeAttr('disable')
            $('.btnsimpanwo').html('Simpan WO')
          },
          success: function(response) {
            if (response.error) {
              // alert(response.error.keluhan);
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
              $(".modal-body").html("");
              $(".modal-body").removeData();
              // swal({
              //   title: "Data berhasil disimpan",
              //   text: "",
              //   icon: "success",
              //   buttons: true,
              //   dangerMode: true,
              // })
              swal({
                title: "WO Berhasil disimpan ",
                text: "",
                icon: "success",
              })
              // reload_table();
            }
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
          }
        });
      });
    });
  });

  $('#tambahestimasi').on('hidden.bs.modal', function() {
    $('.viewmodalcustomer').removeData();
    $(this).find('form').trigger('reset');
    $(this).removeData();
    $(this).removeData('bs.modal');
    $(this).removeData('bs.modal').find(".modal-dialog").empty();
  })
</script>