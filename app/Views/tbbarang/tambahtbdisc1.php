<!-- Modal -->
<div class="modal fade" role="dialog" id="modaltambahtbdisc" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 50%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('tbdisc/simpandata', ['class' => 'formtbdisc']) ?>
      <div class="modal-body">
        <div class="row">
          <div class="col-12 col-sm-12">
            <label for="kode" class="form-label mb-1">Kode</label>
            <input type="text" class="form-control mb-2" name="kode" id="kodedisc">
            <div class="invalid-feedback errorKodedisc">
            </div>
            <label for="nama" class="form-label mb-1">Disc Normal</label>
            <input type="number" step="0.01" class="form-control mb-2" name="disc_normal" id="disc_normal" autofocus>
            <label for="nama" class="form-label mb-1">Disc Urgent</label>
            <input type="number" step="0.01" class="form-control mb-2" name="disc_urgent" id="disc_urgent" autofocus>
            <label for="nama" class="form-label mb-1">Disc Hotline</label>
            <input type="number" step="0.01" class="form-control mb-2" name="disc_hotline" id="disc_hotline" autofocus>
            <label for="nama" class="form-label mb-1">Aktif</label>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="aktif" name="aktif" checked>
            </div>
          </div>
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
  var myModal = document.getElementById('modaltambahtbdisc')
  var myInput = document.getElementById('kodedisc')
  myModal.addEventListener('shown.bs.modal', function() {
    myInput.focus()
  })

  $(document).ready(function() {
    $('.formtbdisc').submit(function(e) {
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
              $('#kodedisc').addClass('is-invalid');
              $('.errorKodedisc').html(response.error.kode);
            } else {
              $('.errorKodedisc').fadeOut();
              $('#kodedisc').rediscClass('is-invalid');
              $('#kodedisc').addClass('is-valid');
            }
          } else {
            // alert(response.sukses);
            $('#modaltambahtbdisc').modal('hide');
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
            //   window.location.href = '/tbbarang';
            // });

            // window.location = '/tbbarang';
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