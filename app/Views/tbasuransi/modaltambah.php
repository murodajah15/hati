<div class="modal fade" role="dialog" id="modaltambahasuransi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 90%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- <?= form_open('tbasuransi/simpandata', ['class' => 'formtbasuransi']) ?> -->
      <form action='tbasuransi/simpandata' method='post' enctype='multipart/form-data' class='formtbasuransi'>
        <div class="modal-body">
          <div class="row mb-2">
            <div class="col-12 col-sm-6">
              <?php
              $kode = 'A' . date('Y') . date('m') . sprintf("%05s", intval(substr('00000', -5)) + 1);
              foreach ($kodeasuransi as $row) {
                if ($row->kode <> null) {
                  $kode = 'A' . date('Y') . date('m') . sprintf("%05s", intval(substr($row->kode, -5)) + 1);
                } else {
                  $kode = 'A' . date('Y') . date('m') . sprintf("%05s", intval(substr('0', -5)) + 1);
                }
              }
              ?>
              <label for="nama" class="form-label mb-1">Kode</label>
              <input type='text' class='form-control mb-2' name='kode' id='kode' size='10' value="<?= $kode ?>" readonly>
              <div class="invalid-feedback errorKode">
              </div>
              <label for="nama" class="form-label mb-1">Nama</label>
              <input type='text' class='form-control mb-2' name='nama' id='nama'>
              <div class="invalid-feedback errorNama">
              </div>
              <label for="nama" class="form-label mb-1">Alamat</label>
              <textarea rows='2' class='form-control' name='alamat' id='alamat'></textarea>
              <label for="nama" class="form-label mb-1">Kota</label>
              <input type='text' class='form-control mb-2' name='kota' id='kota'>
              <label for="nama" class="form-label mb-1">Telp</label>
              <input type='text' class='form-control mb-2' name='telp'>
              <label for="nama" class="form-label mb-1">Fax</label>
              <input type='text' class='form-control mb-2' name='fax'>
              <label for="nama" class="form-label mb-1">Email</label>
              <input type='email' class='form-control mb-2' name='email'>
              Contact Person
              <input type='text' class='form-control mb-2' name='contact_person' id='contact_person'>
              No. Telp CP
              <input type='text' class='form-control' name='no_contact_person'>
            </div>
            <div class="col-12 col-sm-6">
              <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
                <tr>
                  <td>NPWP</td>
                  <td> <input type='text' class='form-control' name='npwp'></td>
                </tr>
                <tr>
                  <td>Nama NPWP<br><input button type='Button' class='btn btn-success btn-sm' value='Salin' onClick='salin_alamat_npwp()' /></td>
                  <td> <input type='text' class='form-control' name='nama_npwp' id='nama_npwp'></td>
                </tr>
                <tr>
                  <td>NPPKP</td>
                  <td> <input type='text' class='form-control' name='nppkp'></td>
                </tr>
                <tr>
                  <td>Temp Of Payment (TOP)</td>
                  <td> <input type='text' class='form-control' name='top'></td>
                </tr>
                <tr>
                  <td>Discount Part</td>
                  <td> <input type='number' class='form-control' name='disc_part'></td>
                </tr>
                <tr>
                  <td>Discount Jasa</td>
                  <td> <input type='number' class='form-control' name='disc_jasa'></td>
                </tr>
                <tr>
                  <td>Discount Bahan</td>
                  <td> <input type='number' class='form-control' name='disc_bahan'></td>
                </tr>
                <tr>
                  <td>PPH Jasa</td>
                  <td> <input type='number' class='form-control' name='pph_jasa'></td>
                </tr>
                <tr>
                  <td>PPH Material</td>
                  <td> <input type='number' class='form-control' name='pph_material'></td>
                </tr>
                <tr>
                  <td>Kredit Limit</td>
                  <td> <input type='number' class='form-control' name='kredit_limit'></td>
                </tr>
              </table>
              <div class="col-md-12 mb-2">
                <label for="nama" class="form-label mb-1">Aktif</label><br>
                <!-- <input type=radio name='aktif' value='Y' checked> Y
          <input type=radio name='aktif' value='N'> N -->
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="aktif" name="aktif" checked>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" id="btnsimpan" class="btn btn-primary btnsimpan">Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
        <!-- <?= form_close() ?> -->
      </form>
    </div>
  </div>
</div>


<script>
  var myModal = document.getElementById('modaltambahasuransi')
  var myInput = document.getElementById('kode')
  myModal.addEventListener('shown.bs.modal', function() {
    myInput.focus()
  })

  $(document).ready(function() {
    $('.formtbasuransi').submit(function(e) {
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
            // alert(response.error.kode);
            if (response.error.kode) {
              $('#kode').addClass('is-invalid');
              $('.errorKode').html(response.error.kode);
              document.getElementById("kode").focus();
            }
            if (response.error.nama) {
              $('#nama').addClass('is-invalid');
              $('.errorNama').html(response.error.nama);
              document.getElementById("nama").focus();
            }
          } else {
            // alert(response.sukses);
            $('#modaltambahasuransi').modal('hide');
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
            //   window.location.href = '/tbasuransi';
            // });

            // window.location = '/tbasuransi';
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