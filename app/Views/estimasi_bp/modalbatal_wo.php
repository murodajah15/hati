<div class="modal fade" role="dialog" id="modalbatal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 50%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?= form_open('estimasi_bp/simpan_batal_wo', ['class' => 'formbatal_wo']) ?>
        <?= csrf_field(); ?>

        <div class="row">
          <div class="col-lg-12 margin-tb">
            <input type="hidden" name="id" id="id" value="<?= $wo_bp['id'] ?>">
            <label for="kode" class="form-label mb-0">No. WO</label>
            <input type="text" class="form-control mb-1" name="nopolisi" id="nopolisi" value="<?= $wo_bp['nowo'] ?>" readonly>
            <label for="kode" class="form-label mb-0">Alasan Batal/Cancel</label>
            <textarea class="form-control" name="ket_batal" id="ket_batal" rows="4"></textarea>
            <div class="invalid-feedback errorKet_batal">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary btn-simpan" id="btn-simpan">Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        <?= form_close() ?>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      $('.formbatal_wo').on('click', '.btn-simpan', function(e) {
        $('.formbatal_wo').submit(function(e) {
          e.preventDefault();
          $.ajax({
            url: $(this).attr('action'),
            type: "post",
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function() {
              $('.btn-simpan').attr('disable', 'disabled')
              $('.btn-simpan').prop('disable', false)
              $('.btn-simpan').html('<i class="fa fa-spin fa-spinner"></i>')
            },
            complete: function() {
              $('.btn-simpan').removeAttr('disable')
              $('.btn-simpan').html('<i class="fa fa-file"></i> Simpan')
              $('.btn-simpan').prop('disabled', false)
            },
            success: function(response) {
              if (response.error) {
                // alert('error');
                if (response.error.ket_batal) {
                  $('#ket_batal').addClass('is-invalid');
                  $('.errorKet_batal').html(response.error.ket_batal);
                }
              } else {
                // alert('sukses'.response.sukses);
                // let hasil;
                // hasil = document.getElementById("title").value;
                swal({
                  title: "Data berhasil di Cancel",
                  text: "",
                  icon: "success",
                })
                $('#modalbatal').modal('hide');
                reload_table_estimasi_bp();
                reload_table_wo_bp();
              }
            },
            error: function(xhr, ajaxOptions, thrownError) {
              alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
          });
        });
      });
    });
  </script>