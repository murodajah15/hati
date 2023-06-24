<!-- Modal -->
<div class="modal fade" role="dialog" id="modaltambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 100%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('rwtkeluarga/simpandata', ['class' => 'formrwtkeluarga']) ?>
      <?= csrf_field() ?>
      <div class="modal-body">
        <div class="col-md-6 mb-2">
          <label for="kode" class="form-label mb-1">Kode</label>
          <input type="text" class="form-control" name="kode" id="kode">
          <div class="invalid-feedback errorKode">
          </div>
        </div>
        <div class="col-md-12 mb-2">
          <label for="nama" class="form-label mb-1">Nama</label>
          <input type="text" class="form-control" name="nama" id="nama" autofocus>
        </div>
        <div class="col-md-6 mb-2">
          <label for="divisi" class="form-label mb-1">Divisi</label>
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Divisi" name="kddivisi" id="kddivisi" class="col-4">
            <button class="btn btn-outline-secondary btn-sm" type="button" id="caridivisi">Cari</button>
            <input type="text" class="col-8" class="form-control" name="nmdivisi" id="nmdivisi" readonly>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" id="btnsimpan" class="btn btn-primary btnsimpan">Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        <?= form_close() ?>
      </div>
    </div>
  </div>

  <script>
    var myModal = document.getElementById('modaltambah')
    var myInput = document.getElementById('kode')
    myModal.addEventListener('shown.bs.modal', function() {
      myInput.focus()
    })

    $(document).ready(function() {
      $('.formrwtkeluarga').submit(function(e) {
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
              //   window.location.href = '/rwtkeluarga';
              // });

              // window.location = '/rwtkeluarga';
            }
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
          }
        });
        return false;
      })

      $('#caridivisi').click(function(e) {
        e.preventDefault();
        $.ajax({
          url: "<?= site_url('rwtkeluarga/cari_data_divisi') ?>",
          dataType: "json",
          success: function(response) {
            $('.viewmodal1').html(response.data).show();
            $('#modalcari').modal('show');
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
          }
        })
      })

    });
  </script>