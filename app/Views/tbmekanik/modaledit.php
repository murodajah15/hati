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

<!-- Modal -->
<div class="modal fade" id="modaledit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 90%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- <?= form_open('tbmekanik/updatedata', ['class' => 'formtbmekanik']) ?> -->
      <form action='tbmekanik/updatedata' method='post' enctype='multipart/form-data' class='formtbmekanik'>
        <input type="hidden" name="id" id="id" value="<?= $tbmekanik['id'] ?>">
        <input type="hidden" name="kodelama" id="kodelama" value="<?= $tbmekanik['kode'] ?>">
        <div class="modal-body">
          <div class="row mb-2">
            <div class="col-12 col-sm-6">
              <label for="nama" class="form-label mb-1">Kode</label>
              <input type='text' class='form-control form-control-sm mb-2' name='kode' id='kode' size='10' value="<?= $tbmekanik['kode'] ?>" autofocus='autofocus'>
              <div class="invalid-feedback errorKode">
              </div>
              <label for="nama" class="form-label mb-1">Kode H3S</label>
              <input type='text' class='form-control form-control-sm mb-2' name='kode_h3s' id='kode_h3s' value="<?= $tbmekanik['kode_h3s'] ?>">
              <label for="nama" class="form-label mb-1">Nama</label>
              <input type='text' class='form-control form-control-sm mb-2' name='nama' id='nama' value="<?= $tbmekanik['nama'] ?>">
              <div class="invalid-feedback errorNama">
              </div>
              <label for="nama" class="form-label mb-1">Alamat</label>
              <textarea rows='2' class='form-control form-control-sm mb-2' name='alamat' id='alamat'><?= $tbmekanik['alamat'] ?></textarea>
              <label for="nama" class="form-label mb-1">Kelurahan</label>
              <input type='text' class='form-control form-control-sm mb-2' name='kelurahan' id='kelurahan' value="<?= $tbmekanik['kelurahan'] ?>">
              <label for="nama" class="form-label mb-1">Kecamatan</label>
              <input type='text' class='form-control form-control-sm mb-2' name='kecamatan' id='kecamatan' value="<?= $tbmekanik['kecamatan'] ?>">
            </div>
            <div class="col-12 col-sm-6">
              <label for="nama" class="form-label mb-1">Kota</label>
              <input type='text' class='form-control form-control-sm mb-2' name='kota' id='kota' value="<?= $tbmekanik['kota'] ?>">
              <label for="nama" class="form-label mb-1">Provinsi</label>
              <input type='text' class='form-control form-control-sm mb-2' name='provinsi' id='provinsi' value="<?= $tbmekanik['provinsi'] ?>">
              <label for="nama" class="form-label mb-1">Kode Pos</label>
              <input type='text' class='form-control form-control-sm mb-2' name='kodepos' id='kodepos' value="<?= $tbmekanik['kodepos'] ?>">
              <label for="nama" class="form-label mb-1">Telp</label>
              <input type='text' class='form-control form-control-sm mb-2' name='telp1' value="<?= $tbmekanik['telp1'] ?>">
              <label for="nama" class="form-label mb-1">Kategori</label>
              <select required id='kategori' name='kategori' class="form-select mb-2" style='width: 200x;'>
                <?php
                $kategori = array('QUICK SERVICE', 'PERIODICAL MAINTENANCE', 'GENERAL REPAIR', 'SPOORING & BALANCE', 'BODY & PAINT', 'BONGKAR PASANG');
                $jml_kata = count($kategori);
                for ($c = 0; $c < $jml_kata; $c += 1) {
                  if ($kategori[$c] == $tbmekanik['kategori']) {
                    echo "<option value='$kategori[$c]' selected>$kategori[$c] </option>";
                  } else {
                    echo "<option value='$kategori[$c]'> $kategori[$c] </option>";
                  }
                }
                ?>
              </select>
              <label for="nama" class="form-label mb-1">Aktif</label><br>
              <?php
              if ($tbmekanik['aktif'] == 'Y') {
                // echo "<tr><td>Aktif</td>     <td> : <input type=radio name='aktif' value='Y' disabled> Y 
                // 						  <input type=radio name='aktif' value='N' checked disabled> N </td></tr></table>";
                echo '<div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="aktif" name="aktif" checked>
                  </div>';
              } else {
                // echo "<tr><td>Aktif</td>     <td> : <input type=radio name='aktif' value='Y' checked disabled> Y  
                // 						  <input type=radio name='aktif' value='N' disabled> N </td></tr></table>";
                echo '<div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="aktif" name="aktif">
                  </div>';
              }
              ?>
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
  var myModal = document.getElementById('modaledit')
  var myInput = document.getElementById('nama')
  myModal.addEventListener('shown.bs.modal', function() {
    myInput.focus()
  })

  $(document).ready(function() {
    $('.formtbmekanik').submit(function(e) {
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
            alert(response.error.kode);
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
            $('#modaledit').modal('hide');
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
              icon: "success"
            })
            reload_table();
            // .then(function() {
            //   window.location.href = '/tbagama';
            // });

            // window.location = '/tbagama';
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