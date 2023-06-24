<!-- Modal -->
<div class="modal fade" role="dialog" id="modaltambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 50%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('tbklpuser/simpandata', ['class' => 'formtbklpuser']) ?>
      <?= csrf_field(); ?>
      <div class="modal-body">
        <div class="col-md-6 mb-2">
          <label for="kode" class="form-label mb-1">Kelompok</label>
          <input type="text" class="form-control" name="kelompok" id="kelompok">
          <div class="invalid-feedback errorKelompok">
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
    var myModal = document.getElementById('modaltambah')
    var myInput = document.getElementById('kelompok')
    myModal.addEventListener('shown.bs.modal', function() {
      myInput.focus()
    })

    $(document).ready(function() {
      $('.formtbklpuser').submit(function(e) {
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
              if (response.error.kelompok) {
                $('#kelompok').addClass('is-invalid');
                $('.errorKelompok').html(response.error.kelompok);
              }
            } else {
              // alert(response.sukses);
              $('#modaltambah').modal('hide');
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
              //   window.location.href = '/tbklpuser';
              // });

              // window.location = '/tbklpuser';
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