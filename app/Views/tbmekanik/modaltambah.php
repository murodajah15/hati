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

<div class="modal fade" role="dialog" id="modaltambahmekanik" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 90%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- <?= form_open('tbmekanik/simpandata', ['class' => 'formtbmekanik']) ?> -->
      <form action='tbmekanik/simpandata' method='post' enctype='multipart/form-data' class='formtbmekanik'>
        <div class="modal-body">
          <div class="tab-content">
            <div class="tab-pane fade show active" id="home">
              <div class="row mb-2">
                <div class="col-12 col-sm-6">
                  <?php
                  $kode = 'MK' . date('Y') . date('m') . sprintf("%03s", intval(substr('00000', -3)) + 1);
                  foreach ($kodemekanik as $row) {
                    if ($row->kode <> null) {
                      $kode = 'MK' . date('Y') . date('m') . sprintf("%03s", intval(substr($row->kode, -3)) + 1);
                    } else {
                      $kode = 'MK' . date('Y') . date('m') . sprintf("%03s", intval(substr('0', -3)) + 1);
                    }
                  }
                  ?>
                  <label for="nama" class="form-label mb-1">Kode</label>
                  <input type='text' class='form-control form-control-sm mb-2' name='kode' id='kode' size='10' value="<?= $kode ?>" readonly>
                  <div class="invalid-feedback errorKode">
                  </div>
                  <label for="nama" class="form-label mb-1">Kode H3S</label>
                  <input type='text' class='form-control form-control-sm mb-2' name='kode_h3s' id='kode_h3s'>
                  <label for="nama" class="form-label mb-1">Nama</label>
                  <input type='text' class='form-control form-control-sm mb-2' name='nama' id='nama'>
                  <div class="invalid-feedback errorNama">
                  </div>
                  <label for="nama" class="form-label mb-1">Alamat</label>
                  <textarea rows='2' class='form-control form-control-sm mb-2' name='alamat' id='alamat'></textarea>
                  <label for="nama" class="form-label mb-1">Kelurahan</label>
                  <input type='text' class='form-control form-control-sm mb-2' name='kelurahan' id='kelurahan'>
                  <label for="nama" class="form-label mb-1">Kecamatan</label>
                  <input type='text' class='form-control form-control-sm mb-2' name='kecamatan' id='kecamatan'>
                </div>
                <div class="col-12 col-sm-6">
                  <label for="nama" class="form-label mb-1">Kota</label>
                  <input type='text' class='form-control form-control-sm mb-2' name='kota' id='kota'>
                  <label for="nama" class="form-label mb-1">Provinsi</label>
                  <input type='text' class='form-control form-control-sm mb-2' name='provinsi' id='provinsi'>
                  <label for="nama" class="form-label mb-1">Kode Pos</label>
                  <input type='text' class='form-control form-control-sm mb-2' name='kodepos' id='kodepos'>
                  <label for="nama" class="form-label mb-1">Telp</label>
                  <input type='text' class='form-control form-control-sm mb-2' name='telp1'>
                  <label for="nama" class="form-label mb-1">Kategori</label>
                  <select required id='kategori' name='kategori' class="form-select mb-2" style='width: 200x;' autofocus='autofocus'>
                    <option value='CUCI'>CUCI</option>
                    <option value='QUICK SERVICE'>QUICK SERVICE</option>
                    <option value='PERIODICAL MAINTENANCE'>PERIODICAL MAINTENANCE</option>
                    <option value='GENERAL REPAIR'>GENERAL REPAIR</option>
                    <option value='SPOORING & BALANCE'>SPOORING & BALANCE</option>
                    <option value='BODY & PAINT'>BODY & PAINT</option>
                    <option value='BONGKAR PASANG'>BONGKAR PASANG</option>
                  </select>
                  <label for="nama" class="form-label mb-1">Aktif</label><br>
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="aktif" name="aktif" checked>
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
  var myModal = document.getElementById('modaltambahmekanik')
  var myInput = document.getElementById('kode_h3s')
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
            $('#modaltambahmekanik').modal('hide');
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
            //   window.location.href = '/tbmekanik';
            // });

            // window.location = '/tbmekanik';
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