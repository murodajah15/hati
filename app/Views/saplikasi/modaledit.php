<!-- Modal -->
<div class="modal fade" id="modaledit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 80%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('saplikasi/updatedata', ['class' => 'formsaplikasi']) ?>
      <?= csrf_field(); ?>
      <input type="hidden" class="form-control" name="id" id="id" value="<?= $id ?>">
      <input type="hidden" class="form-control" name="photoLama" id="photoLama" value="<?= $logo ?>">
      <div class="modal-body">
        <div class="row g-3 mb-2">
          <div class="col-md-6">
            <label for="kode" class="form-label mb-1">Kode Perusahaan</label>
            <input type="text" class="form-control" name="kd_perusahaan" id="kd_perusahaan" value="<?= $kd_perusahaan ?>">
            <div class="invalid-feedback errorKd_perusahaan">
            </div>
          </div>
          <div class="col-md-6">
            <label for="nama" class="form-label mb-1">Nama Perusahaan</label>
            <input type="text" class="form-control" name="nm_perusahaan" id="nm_perusahaan" value="<?= $nm_perusahaan ?>">
          </div>
          <div class="col-md-12">
            <label for="nama" class="form-label mb-1">Alamat</label>
            <textarea class="form-control" name="alamat" id="alamat"><?= $alamat ?></textarea>
          </div>
        </div>
        <div class="row g-3 mb-2">
          <div class="col-md-6">
            <label for="nama" class="form-label mb-1">Telp</label>
            <input type="text" class="form-control" name="telp" id="telp" value="<?= $telp ?>">
          </div>
          <div class="col-md-6">
            <label for="nama" class="form-label mb-1">NPWP</label>
            <input type="text" class="form-control" name="npwp" id="npwp" value="<?= $npwp ?>">
          </div>
        </div>
        <div class="row g-3 mb-2">
          <div class="col-md-6">
            <label for="nama" class="form-label mb-1">Pejabat (1)</label>
            <input type="text" class="form-control" name="pejabat_1" id="pejabat_1" value="<?= $pejabat_1 ?>">
          </div>
          <div class="col-md-6">
            <label for="nama" class="form-label mb-1">Pejabat (2)</label>
            <input type="text" class="form-control" name="pejabat_2" id="pejabat_2" value="<?= $pejabat_2 ?>">
          </div>
        </div>
        <div class="row g-3 mb-2">
          <div class="col-md-6">
            <label for="logo" class="col-sm-2 col-form-label">Logo</label>
            <div class="col-sm-2">
              <img src="/img/<?= $logo ?>" class="img-thumbnail img-preview">
            </div>
            <div class="col-sm-8">
              <div class="mb-3">
                <input type="file" accept="image/png, image/jpeg" class="form-control" id="photo" name="photo" value="<?= $logo ?>" onchange="previewImg()">
                <!-- <input type="file" id="photo" name="photo" onchange="previewImg()"> -->
                <div class="invalid-feedback errorPhoto">
                </div>
                <label for="photo" class="custom-file-label"></label>
              </div>
            </div>
          </div>
          <div class="col">
            <label for="nama" class="form-label mb-1">Aktif</label><br>
            <?php
            if ($aktif == 'Y') {
              // echo "<tr><td>Aktif</td>     <td> : <input type=radio name='aktif' value='Y' checked> Y  
              // 						  <input type=radio name='aktif' value='N'> N </td></tr></table>";
              echo '<div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="aktif" name="aktif" checked>
                  </div>';
            } else {
              // echo "<tr><td>Aktif</td>     <td> : <input type=radio name='aktif' value='Y'> Y 
              // 						  <input type=radio name='aktif' value='N' checked> N </td></tr></table>";
              echo '<div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="aktif" name="aktif">
                  </div>';
            }
            ?>
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

  <script>
    var myModal = document.getElementById('modaledit')
    var myInput = document.getElementById('kd_perusahaan')
    myModal.addEventListener('shown.bs.modal', function() {
      myInput.focus()
    })

    $(document).ready(function() {
      $('.formsaplikasi').submit(function(e) {
        e.preventDefault();
        $.ajax({
          type: "post",
          url: $(this).attr('action'),
          // data: $(this).serialize(),
          data: new FormData(this), //penggunaan FormData
          processData: false,
          contentType: false,
          cache: false,
          async: false,
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
              if (response.error.kd_perusahaan) {
                // alert(response.error);
                $('#kd_perusahaan').addClass('is-invalid');
                $('.errorKd_perusahaan').html(response.error.kd_perusahaan);
              }
              if (response.error.photo) {
                // alert(response.error);
                $('#photo').addClass('is-invalid');
                $('.errorPhoto').html(response.error.photo);
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
                icon: "success",
              })
              reload_table();
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