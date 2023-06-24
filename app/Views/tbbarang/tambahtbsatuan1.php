<!-- Modal -->
<div class="modal fade" role="dialog" id="modaltambahtbsatuan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 50%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('tbsatuan/simpandata', ['class' => 'formtbsatuan']) ?>
      <div class="modal-body">
        <div class="row">
          <div class="col-12 col-sm-12">
            <label for="kode" class="form-label mb-1">Kode</label>
            <input type="text" class="form-control mb-2" name="kode" id="kodesatuan">
            <div class="invalid-feedback errorKodesatuan">
            </div>
            <label for="nama" class="form-label mb-1">Nama</label>
            <input type="text" class="form-control mb-2" name="nama" id="namasatuan" autofocus>
            <div class="invalid-feedback errorNamasatuan">
            </div>
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
  var myModal = document.getElementById('modaltambahtbsatuan')
  var myInput = document.getElementById('kodesatuan')
  myModal.addEventListener('shown.bs.modal', function() {
    myInput.focus()
  })

  $(document).ready(function() {
    $('.formtbsatuan').submit(function(e) {
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
              $('#kodesatuan').addClass('is-invalid');
              $('.errorKodesatuan').html(response.error.kode);
            } else {
              $('.errorKodesatuan').fadeOut();
              $('#kodesatuan').removeClass('is-invalid');
              $('#kodesatuan').addClass('is-valid');
            }
            if (response.error.nama) {
              $('#namasatuan').addClass('is-invalid');
              $('.errorNamasatuan').html(response.error.nama);
            } else {
              $('.errorNamasatuan').fadeOut();
              $('#namasatuan').removeClass('is-invalid');
              $('#namasatuan').addClass('is-valid');
            }
          } else {
            // alert(response.sukses);
            $('#modaltambahtbsatuan').modal('hide');
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