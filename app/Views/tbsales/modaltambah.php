<!-- Modal -->
<div class="modal fade" role="dialog" id="modaltambahtbsales" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 60%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('tbsales/simpandata', ['class' => 'formtbsales']) ?>
      <?= csrf_field(); ?>
      <div class="modal-body">
        <div class="row">
          <div class='col-12 col-sm-6'>
            <label for="kode" class="form-label mb-1">Kode</label>
            <input type="text" class="form-control mb-2" name="kode" id="kode">
            <div class="invalid-feedback errorKode">
            </div>
            <label for="nama" class="form-label mb-1">Nama</label>
            <input type="text" class="form-control mb-2" name="nama" id="nama">
            <div class="invalid-feedback errorNama">
            </div>
            <label for="nama" class="form-label mb-1">No. HP 1</label>
            <input type="text" class="form-control mb-2" name="nohp1" id="nohp1">
            <label for="nama" class="form-label mb-1">No. HP 2</label>
            <input type="text" class="form-control mb-2" name="nohp2" id="nohp2">
          </div>
          <div class='col-12 col-sm-6'>
            <label for="nama" class="form-label mb-1">Email</label>
            <input type="email" class="form-control mb-2" name="email" id="email">
            <label for="nama" class="form-label mb-1">Tanggal Masuk</label>
            <input type="text" class="form-control mb-2" name="tglmasuk" id="tglmasuk">
            <label for="nama" class="form-label mb-1">Supervisor</label>
            <select class="form-select mb-1" name="kdspv" id="kdspv">
              <option value="">[Pilih Supervisor]
                <?php
                foreach ($tbsales as $key) {
                  echo "<option value='$key[kode]'>$key[kode] - $key[nama]</option>";
                }
                ?>
            </select>
            <label for="nama" class="form-label mb-1">Status</label>
            <select class="form-select mb-1" name="status" id="status" required>
              <option value="">[Pilih Status]
                <!-- <option value='Sales Counter'>Sales Counter</option>
              <option value='Senior Sales Counter'>Senior Sales Counter</option>
              <option value='Trainee Executive'>Trainee Executive</option>
              <option value='Junior Sales Executive'>Junior Sales Executive</option>
              <option value='Sales Executive'>Sales Executive</option>
              <option value='Trainee Counter'>Trainee Counter</option>
              <option value='Supervisor'>Supervisor</option>
              <option value='Manager'>Manager</option> -->
                <?php
                foreach ($tbstatus_sales as $key) {
                  echo "<option value='$key[status]'>$key[status]</option>";
                }
                ?>
            </select>
          </div>
          <div class="col-md-12 mb-2">
            <label for="nama" class="form-label mb-1">Aktif</label><br>
            <!-- <input type=radio name='aktif' value='Y' checked> Y
          <input type=radio name='aktif' value='N'> N -->
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="aktif" name="aktif" checked>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" id="btnsimpan" class="btn btn-primary btnsimpan">Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          </div>
          <?= form_close() ?>
        </div>
      </div>
    </div>
  </div>

  <script>
    var myModal = document.getElementById('modaltambahtbsales')
    var myInput = document.getElementById('kode')
    myModal.addEventListener('shown.bs.modal', function() {
      myInput.focus()
    })

    $(document).ready(function() {
      $('.formtbsales').submit(function(e) {
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
              // alert(response.error);
              if (response.error.kode) {
                $('#kode').addClass('is-invalid');
                $('.errorKode').html(response.error.kode);
              } else {
                $('.errorKode').fadeOut();
                $('#kode').removeClass('is-invalid');
                $('#kode').addClass('is-valid');
              }
              if (response.error.nama) {
                $('#nama').addClass('is-invalid');
                $('.errorNama').html(response.error.nama);
              } else {
                $('.errorNama').fadeOut();
                $('#nama').removeClass('is-invalid');
                $('#nama').addClass('is-valid');
              }
            } else {
              $('#modaltambahtbsales').modal('hide');
              // swal({
              //   title: "Data berhasil disimpan",
              //   text: "",
              //   icon: "success",
              //   buttons: true,
              //   dangerMode: true,
              // })

              swal({
                title: response.sukses,
                text: "Silahkan dilanjutkan",
                icon: "success",
              })
              reload_table();
              // .then(function() {
              //   window.location.href = '/tbsales';
              // });

              // window.location = '/tbsales';
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