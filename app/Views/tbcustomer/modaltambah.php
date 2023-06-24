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

<div class="modal fade" role="dialog" id="modaltambahcustomer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 90%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- <?= form_open('tbcustomer/simpandata', ['class' => 'formtbcustomer']) ?> -->
      <form action='tbcustomer/simpandata' method='post' enctype='multipart/form-data' class='formtbcustomer'>
        <div class="modal-body">
          <ul class="nav nav-tabs">
            <li class="nav-item">
              <a href="#home" class="nav-link active" data-bs-toggle="tab">Data</a>
            </li>
            <li class="nav-item">
              <a href="#profile" class="nav-link" data-bs-toggle="tab">Alamat, Contact Person, NPWP</a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
            </li> -->
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade show active" id="home">
              <br>
              <div class="row mb-2">
                <div class="col-12 col-sm-6">
                  <?php
                  $kode = 'C' . date('Y') . date('m') . sprintf("%05s", intval(substr('00000', -5)) + 1);
                  foreach ($kodecustomer as $row) {
                    if ($row->kode <> null) {
                      $kode = 'C' . date('Y') . date('m') . sprintf("%05s", intval(substr($row->kode, -5)) + 1);
                    } else {
                      $kode = 'C' . date('Y') . date('m') . sprintf("%05s", intval(substr('0', -5)) + 1);
                    }
                  }
                  ?>
                  <label for="nama" class="form-label mb-1">Kode</label>
                  <input type='text' class='form-control mb-2' name='kode' id='kode' size='10' value="<?= $kode ?>" readonly>
                  <div class="invalid-feedback errorKode">
                  </div>
                  <label for="nama" class="form-label mb-1">Kelompok</label>
                  <select required id='kelompok' name='kelompok' class="form-select" style='width: 200x;' autofocus='autofocus'>
                    <option value='Mr.'>Mr.</option>
                    <option value='Ms.'>Ms.</option>
                    <option value='Mrs.'>Mrs.</option>
                    <option value='Mrs.'>Company</option>
                  </select>
                  <label for="nama" class="form-label mb-1">Nama</label>
                  <input type='text' class='form-control mb-2' name='nama' id='nama'>
                  <div class="invalid-feedback errorNama">
                  </div>
                  <label for="nama" class="form-label mb-1">Alamat</label>
                  <textarea rows='2' class='form-control' name='alamat' id='alamat'></textarea>
                  <label for="nama" class="form-label mb-1">Kelurahan</label>
                  <input type='text' class='form-control mb-2' name='kelurahan' id='kelurahan'>
                  <label for="nama" class="form-label mb-1">Kecamatan</label>
                  <input type='text' class='form-control mb-2' name='kecamatan' id='kecamatan'>
                  <label for="nama" class="form-label mb-1">Kota</label>
                  <input type='text' class='form-control mb-2' name='kota' id='kota'>
                  <label for="nama" class="form-label mb-1">Provinsi</label>
                  <input type='text' class='form-control mb-2' name='provinsi' id='provinsi'>
                  <label for="nama" class="form-label mb-1">Kode Pos</label>
                  <input type='text' class='form-control' name='kodepos' id='kodepos'>
                  <label for="nama" class="form-label mb-1">Email</label>
                  <input type='email' class='form-control' name='email' id='email'>
                  <label for="nama" class="form-label mb-1">Agama</label>
                  <select class="form-select" name="agama" id="agama">
                    <option value="">[Pilih Agama]
                      <?php
                      foreach ($tbagama as $key) {
                        echo "<option value=$key[nama]>$key[nama]</option>";
                      }
                      ?>
                    </option>
                  </select>
                </div>
                <div class="col-12 col-sm-6">
                  <label for="nama" class="form-label mb-1">Telp</label>
                  <input type='text' class='form-control' name='telp1'>
                  <input type='text' class='form-control mb-2' name='telp2'>
                  <label for="nama" class="form-label mb-1">Tanggal Lahir (M-D-Y)</label>
                  <input type='date' class='form-control mb-2' name='tgl_lahir'>
                  <label for="nama" class="form-label mb-1">NIK / NO. KTP</label>
                  <input type='text' class='form-control mb-2' name='nik'>
                  <label for="nama" class="form-label mb-1">Alamat KTP</label>
                  <input button type='Button' class='btn btn-success btn-sm' value='Salin' onClick='salin_alamat_ktp()' />
                  <textarea rows='3' class='form-control mb-2' name='alamat_ktp' id='alamat_ktp'></textarea>
                  <label for="nama" class="form-label mb-1">Kelurahan KTP</label>
                  <input type='text' class='form-control mb-2' name='kelurahan_ktp' id='kelurahan_ktp'>
                  <label for="nama" class="form-label mb-1">Kecamatan KTP</label>
                  <input type='text' class='form-control mb-2' name='kecamatan_ktp' id='kecamatan_ktp'>
                  <label for="nama" class="form-label mb-1">Kota KTP</label>
                  <input type='text' class='form-control mb-2' name='kota_ktp' id='kota_ktp'>
                  <label for="nama" class="form-label mb-1">Provinsi KTP</label>
                  <input type='text' class='form-control mb-2' name='provinsi_ktp' id='provinsi_ktp'>
                  <label for="nama" class="form-label mb-1">Kode Pos KTP</label>
                  <input type='text' class='form-control' name='kodepos_ktp' id='kodepos_ktp'>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="profile">
              <br>
              <div class="row g-3 mb-2">
                <div class="col">
                  <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
                    <tr>
                      <td>Alamat Kantor<br><input button type='Button' class='btn btn-success btn-sm' value='Salin' onClick='salin_alamat_ktr()' /></td>
                      <td> <textarea rows='3' class='form-control' name='alamat_ktr' id='alamat_ktr'></textarea></td>
                    </tr>
                    <tr>
                      <td>Kelurahan Kantor</td>
                      <td> <input type='text' class='form-control' name='kelurahan_ktr' id='kelurahan_ktr'></td>
                    </tr>
                    <tr>
                      <td>Kecamatan Kantor</td>
                      <td> <input type='text' class='form-control' name='kecamatan_ktr' id='kecamatan_ktr'></td>
                    </tr>
                    <tr>
                      <td>Kota Kantor</td>
                      <td> <input type='text' class='form-control' name='kota_ktr' id='kota_ktr'></td>
                    </tr>
                    <tr>
                      <td>Provinsi Kantor</td>
                      <td> <input type='text' class='form-control' name='provinsi_ktr' id='provinsi_ktr'></td>
                    </tr>
                    <tr>
                      <td>Kode Pos Kantor</td>
                      <td> <input type='text' class='form-control' name='kodepos_ktr' id='kodepos_ktr'></td>
                    </tr>
                    <tr>
                      <td>Telp Kantor</td>
                      <td> <input type='text' class='form-control' name='telp1_ktr'></td>
                    </tr>
                    <tr>
                      <td>
                      <td> <input type='text' class='form-control' name='telp2_ktr'></td>
                    </tr>
                  </table>
                </div>
                <div class="col">
                  <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
                    <tr>
                      <td>Contact Person</td>
                      <td> <input type='text' class='form-control' name='contact_person' id='contact_person'></td>
                    </tr>
                    <tr>
                      <td>No. Telp CP</td>
                      <td> <input type='text' class='form-control' name='no_contact_person'></td>
                    </tr>
                    <tr>
                      <td>NPWP</td>
                      <td> <input type='text' class='form-control' name='npwp'></td>
                    </tr>
                    <tr>
                      <td>Nama NPWP<br><input button type='Button' class='btn btn-success btn-sm' value='Salin' onClick='salin_alamat_npwp()' /></td>
                      <td> <input type='text' class='form-control' name='nama_npwp' id='nama_npwp'></td>
                    </tr>
                    <tr>
                      <td>Alamat NPWP</td>
                      <td> <textarea rows='3' class='form-control' name='alamat_npwp' id='alamat_npwp'></textarea></td>
                    </tr>
                    <tr>
                      <td>Maksimum Piutang</td>
                      <td> <input type='number' class='form-control' name='mak_piutang'></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <?php
            if ($tambah == 1 or $edit == 1) {
              echo '<button type="submit" id="btnsimpan" class="btn btn-primary btnsimpan">Simpan</button>';
            } else {
              echo '<button type="submit" id="btnsimpan" class="btn btn-primary btnsimpan disabled">Simpan</button>';
            }
            ?>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          </div>
          <!-- <?= form_close() ?> -->
      </form>
    </div>
  </div>
</div>

<script>
  var myModal = document.getElementById('modaltambahcustomer')
  var myInput = document.getElementById('kode')
  myModal.addEventListener('shown.bs.modal', function() {
    myInput.focus()
  })

  $(document).ready(function() {
    $('.formtbcustomer').submit(function(e) {
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
          $('.btnsimpan').html('Simpan')
        },
        success: function(response) {
          if (response.error) {
            // alert(response.error.kode);
            if (response.error.kode) {
              $('#kode').addClass('is-invalid');
              $('.errorKode').html(response.error.kode);
              document.getElementById("kode").focus();
            }
            if (response.error.nama) {
              $('#nama').addClass('is-invalid');
              $('.errorNama').html(response.error.nama);
              document.getElementById("nama").focus();
            }
          } else {
            // alert(response.sukses);
            $('#modaltambahcustomer').modal('hide');
            // swal({
            //   title: "Data berhasil disimpan",
            //   text: "",
            //   icon: "success",
            //   buttons: true,
            //   dangerMode: true,
            // })

            swal({
              title: "Data Berhasil ditambah ",
              text: "",
              icon: "success"
            })
            reload_table();
            // .then(function() {
            //   window.location.href = '/tbcustomer';
            // });

            // window.location = '/tbcustomer';
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      });
      return false;
    })
  });
</script>