<!-- Modal -->
<div class="modal fade" role="dialog" id="modaltambahtbklpjasa" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 50%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('tbklpjasa/simpandata', ['class' => 'formtbklpjasa']) ?>
      <?= csrf_field(); ?>
      <div class="modal-body">
        <div class="col-md-6 mb-2">
          <label for="kode" class="form-label mb-1">Kode</label>
          <input type="text" class="form-control" name="kode" id="kode">
          <div class="invalid-feedback errorKode">
          </div>
        </div>
        <div class="col-md-12 mb-2">
          <label for="nama" class="form-label mb-1">Nama</label>
          <input type="text" class="form-control" name="nama" id="nama">
          <div class="invalid-feedback errorNama">
          </div>
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

  <script>
    var myModal = document.getElementById('modaltambahtbklpjasa')
    var myInput = document.getElementById('kode')
    myModal.addEventListener('shown.bs.modal', function() {
      myInput.focus()
    })

    $(document).ready(function() {
      $('.formtbklpjasa').submit(function(e) {
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
              $('#modaltambahtbklpjasa').modal('hide');
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
              //   window.location.href = '/tbklpjasa';
              // });

              // window.location = '/tbklpjasa';
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