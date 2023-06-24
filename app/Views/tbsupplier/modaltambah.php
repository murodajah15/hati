<div class="modal fade" role="dialog" id="modaltambahsupplier" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 90%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- <?= form_open('tbsupplier/simpandata', ['class' => 'formtbsupplier']) ?> -->
      <form action='tbsupplier/simpandata' method='post' enctype='multipart/form-data' class='formtbsupplier'>
        <div class="modal-body">
          <div class="row mb-2">
            <div class="col-12 col-sm-6">
              <?php
              $kode = 'S' . date('Y') . date('m') . sprintf("%05s", intval(substr('00000', -5)) + 1);
              foreach ($kodesupplier as $row) {
                $kode = 'S' . date('Y') . date('m') . sprintf("%05s", intval(substr($row->kode, -5)) + 1);
              }
              ?>
              <label for="nama" class="form-label mb-1">Kode</label>
              <input type='text' class='form-control mb-2' name='kode' id='kode' size='10' value="<?= $kode ?>" readonly>
              <div class="invalid-feedback errorKode">
              </div>
              <label for="nama" class="form-label mb-1">Kelompok</label>
              <select required id='kelompok' name='kelompok' class="form-select" style='width: 200x;' autofocus='autofocus'>
                <option value='Mr.'>Mr.</option>
                <option value='Ms.'>Ms.</option>
                <option value='Mrs.'>Mrs.</option>
                <option value='Mrs.'>Company</option>
              </select>
              <label for="nama" class="form-label mb-1">Nama</label>
              <input type='text' class='form-control mb-2' name='nama' id='nama'>
              <div class="invalid-feedback errorNama">
              </div>
              <label for="nama" class="form-label mb-1">Alamat</label>
              <textarea rows='2' class='form-control' name='alamat' id='alamat'></textarea>
              <label for="nama" class="form-label mb-1">Kelurahan</label>
              <input type='text' class='form-control mb-2' name='kelurahan' id='kelurahan'>
              <label for="nama" class="form-label mb-1">Kecamatan</label>
              <input type='text' class='form-control mb-2' name='kecamatan' id='kecamatan'>
              <label for="nama" class="form-label mb-1">Kota</label>
              <input type='text' class='form-control mb-2' name='kota' id='kota'>
              <label for="nama" class="form-label mb-1">Kode Pos</label>
              <input type='text' class='form-control' name='kodepos' id='kodepos'>
              <label for="nama" class="form-label mb-1">Telp</label>
              <input type='text' class='form-control mb-2' name='telp'>
            </div>
            <div class="col-12 col-sm-6">
              <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
                <tr>
                  <td>Contact Person</td>
                  <td> <input type='text' class='form-control' name='contact_person' id='contact_person'></td>
                </tr>
                <tr>
                  <td>No. Telp CP</td>
                  <td> <input type='text' class='form-control' name='no_contact_person'></td>
                </tr>
                <tr>
                  <td>NPWP</td>
                  <td> <input type='text' class='form-control' name='npwp'></td>
                </tr>
                <tr>
                  <td>Nama NPWP<br><input button type='Button' class='btn btn-success btn-sm' value='Salin' onClick='salin_alamat_npwp()' /></td>
                  <td> <input type='text' class='form-control' name='nama_npwp' id='nama_npwp'></td>
                </tr>
                <tr>
                  <td>Alamat NPWP</td>
                  <td> <textarea rows='3' class='form-control' name='alamat_npwp' id='alamat_npwp'></textarea></td>
                </tr>
                <tr>
                  <td>Maksimum Hutang</td>
                  <td> <input type='number' class='form-control' name='mak_hutang'></td>
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
  var myModal = document.getElementById('modaltambahsupplier')
  var myInput = document.getElementById('kode')
  myModal.addEventListener('shown.bs.modal', function() {
    myInput.focus()
  })

  $(document).ready(function() {
    $('.formtbsupplier').submit(function(e) {
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
            $('#modaltambahsupplier').modal('hide');
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
            //   window.location.href = '/tbsupplier';
            // });

            // window.location = '/tbsupplier';
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