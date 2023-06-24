<!-- Modal -->
<?= form_open('rwtkeluarga/updatedata', ['class' => 'formedit']) ?>
<?= csrf_field() ?>
<div class="container container-fluid">
  <div class="col-md-12">
    <div class="card-header mb-2">
      <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
    </div>
    <input type="hidden" class="form-control" name="id" id="id" value="<?= $id ?>">
    <div class="col-md-6 mb-2">
      <label for="kode" class="form-label mb-1">Kode</label>
      <input type="text" class="form-control" name="kode" id="kode" value="<?= $kode ?>">
      <div class="invalid-feedback errorKode">
      </div>
    </div>
    <div class="col-md-6 mb-2">
      <label for="nama" class="form-label mb-1">Nama</label>
      <input type="text" class="form-control" name="nama" id="nama" value="<?= $nama ?>" autofocus>
    </div>
    <hr>
    <div class="col-md-12 mb-2">
      <button type="submit" id="btnsimpan" class="btn btn-primary btnsimpan">Simpan</button>
      <button type="button" class="btn btn-secondary" id="btnbatal">Batal</button>
    </div>
  </div>
  <?= form_close() ?>
</div>

<script>
  $(document).ready(function() {
    var myInput = document.getElementById('nama').focus()
    // myInput.focus()
    $('.formedit').submit(function() {
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
            }
          } else {
            reload_table();
            swal({
              title: "Data Berhasil diupdate ",
              text: "",
              icon: "success"
            })
            // reload_table();
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      });
      return false;
    })

    $('#btnbatal').click(function() {
      reload_table();
      // history.back();
    })

  });
</script>