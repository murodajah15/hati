<!-- Modal -->
<div class="modal fade" role="dialog" id="modaltambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 80%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('tbsa/simpandata', ['class' => 'formtbsa']) ?>
      <div class="modal-body">
        <div class="row">
          <div class="col-12 col-sm-6">
            <label for="kdsa" class="form-label mb-1">Kode</label>
            <input type="text" class="form-control" name="kdsa" id="kdsa">
            <div class="invalid-feedback errorKdsa">
            </div>
            <label for="nama" class="form-label mb-1">Nama</label>
            <input type="text" class="form-control" name="nama" id="nama" autofocus>
            <div class="invalid-feedback errorNama">
            </div>
            <label for="nama" class="form-label mb-1">Alamat</label>
            <input type="text" class="form-control" name="alamat" id="alamat" autofocus>
            <label for="nama" class="form-label mb-1">Kelurahan</label>
            <input type="text" class="form-control" name="kelurahan" id="kelurahan" autofocus>
            <label for="nama" class="form-label mb-1">Kecamatan</label>
            <input type="text" class="form-control" name="kecamatan" id="kecamatan" autofocus>
          </div>
          <div class="col-12 col-sm-6">
            <label for="nama" class="form-label mb-1">Kota</label>
            <input type="text" class="form-control" name="kota" id="kota" autofocus>
            <label for="nama" class="form-label mb-1">Kode Pos</label>
            <input type="text" class="form-control" name="kodepos" id="kodepos" autofocus>
            <label for="nama" class="form-label mb-1">No. HP</label>
            <input type="text" class="form-control" name="nohp" id="nohp" autofocus>
            <label for="nama" class="form-label mb-1">Aktif</label><br>
            <!-- <input type=radio name='aktif' value='Y' checked> Y
          <input type=radio name='aktif' value='N'> N -->
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
  var myModal = document.getElementById('modaltambah')
  var myInput = document.getElementById('kdsa')
  myModal.addEventListener('shown.bs.modal', function() {
    myInput.focus()
  })

  $(document).ready(function() {
    $('.formtbsa').submit(function(e) {
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
            if (response.error.kdsa) {
              $('#kdsa').addClass('is-invalid');
              $('.errorKdsa').html(response.error.kdsa);
            } else {
              $('.errorKdsa').fadeOut();
              $('#kdsa').removeClass('is-invalid');
              $('#kdsa').addClass('is-valid');
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
            //   window.location.href = '/tbsa';
            // });

            // window.location = '/tbsa';
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