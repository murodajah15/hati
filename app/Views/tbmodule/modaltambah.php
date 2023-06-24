<!-- Modal -->
<div class="modal fade" role="dialog" id="modaltambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 50%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('tbmodule/simpandata', ['class' => 'formtbmodule']) ?>
      <?= csrf_field(); ?>
      <input type="hidden" class="form-control" name="clokasi_menu" id="clokasi_menu">
      <div class="modal-body">
        <div class="col-md-6 mb-2">
          <label for="kode" class="form-label mb-1">No. Urut</label>
          <input type="number" class="form-control" name="nurut" id="nurut">
        </div>
        <div class="col-md-12 mb-2">
          <label for="nama" class="form-label mb-1">Module</label>
          <input type="text" class="form-control" name="cmodule" id="cmodule">
          <div class="invalid-feedback errorCmodule">
          </div>
        </div>
        <div class="col-md-12 mb-2">
          <label for="nama" class="form-label mb-1">Menu</label>
          <input type="text" class="form-control" name="cmenu" id="cmenu">
        </div>
        <div class="col-md-12 mb-2">
          <label for="nama" class="form-label mb-1">Parent</label>
          <input type="text" class="form-control" name="cparent" id="cparent">
        </div>
        <!-- <div class="col-md-12 mb-2">
          <label for="nama" class="form-label mb-1">Main Menu</label>
          <input type="text" class="form-control" name="cmainmenu" id="cmainmenu">
        </div> -->
        <div class="col">
          <label for="nama" class="form-label mb-1">Main Menu</label><br>
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="cmainmenu" name="cmainmenu" checked>
          </div>
        </div>
        <div class="col-md-12 mb-2">
          <label for="nama" class="form-label mb-1">Level</label>
          <input type="number" class="form-control" name="nlevel" id="nlevel">
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
  var myInput = document.getElementById('nurut')
  myModal.addEventListener('shown.bs.modal', function() {
    myInput.focus()
  })

  $(document).ready(function() {
    $('.formtbmodule').submit(function(e) {
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
            if (response.error.cmodule) {
              $('#cmodule').addClass('is-invalid');
              $('.errorCmodule').html(response.error.cmodule);
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
            //   window.location.href = '/tbmodule';
            // });

            // window.location = '/tbmodule';
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