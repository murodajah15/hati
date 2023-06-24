<!-- Modal -->
<div class="modal fade" id="modaldetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 70%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('tbuser/updatedata', ['class' => 'formtbuser']) ?>
      <?= csrf_field(); ?>
      <div class="modal-body">
        <div class="row g-3 mb-2">
          <div class="col">
            <label for="nama" class="form-label mb-1">Email</label>
            <input type="email" class="form-control" name="email" id="email" value="<?= $email ?>" readonly>
            <div class="invalid-feedback errorEmail">
            </div>
          </div>
          <div class="col">
            <label for="nama" class="form-label mb-1">Nama</label>
            <input type="text" class="form-control" name="nama" id="nama" value="<?= $nama ?>" readonly>
            <div class="invalid-feedback errorNama">
            </div>
          </div>
        </div>
        <div class="row g-3 mb-2">
          <div class="col">
            <label for="nama" class="form-label mb-1">Nama Lengkap</label>
            <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" value="<?= $nama_lengkap ?>" readonly>
          </div>
          <div class="col">
            <label for="nama" class="form-label mb-1">No. HP</label>
            <input type="text" class="form-control" name="nohp" id="nohp" value="<?= $nohp ?>" readonly>
          </div>
        </div>
        <div class="row g-3 mb-2">
          <!-- <div class="col-md-6 mb-2"> -->
          <div class="col">
            <label for="nama" class="form-label mb-1">Level</label>
            <input type="text" class="form-control" name="nohp" id="nohp" value="<?= $level ?>" readonly>
          </div>
          <div class="col">
            <label for="nama" class="form-label mb-1">Kelompok</label>
            <input type="text" class="form-control" name="kelompok" id="kelompok" value="<?= $kelompok ?>" readonly>
          </div>
        </div>
        <div class="row g-3 mb-2">
          <div class="col">
            <label for="nama" class="form-label mb-1">Aktif</label><br>
            <?php
            if ($aktif == 'Y') {
              // echo "<tr><td>Aktif</td>     <td> : <input type=radio name='aktif' value='Y' checked> Y  
              // 						  <input type=radio name='aktif' value='N'> N </td></tr></table>";
              echo '<div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="aktif" name="aktif" checked disabled>
                  </div>';
            } else {
              // echo "<tr><td>Aktif</td>     <td> : <input type=radio name='aktif' value='Y'> Y 
              // 						  <input type=radio name='aktif' value='N' checked> N </td></tr></table>";
              echo '<div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="aktif" name="aktif" disabled>
                  </div>';
            }
            ?>
          </div>
        </div>
        <div class="col">
          <label for="photo" class="col-sm-2 col-form-label">Photo</label>
          <div class="col-sm-2">
            <img src="<?= base_url('/img/' . $photo) ?>" class="img-thumbnail img-preview">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
      <?= form_close() ?>
    </div>
  </div>
</div>

<script>
  var myModal = document.getElementById('modaledit')
  var myInput = document.getElementById('email')
  myModal.addEventListener('shown.bs.modal', function() {
    myInput.focus()
  })

  $(document).ready(function() {
    $('.formtbuser').submit(function(e) {
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
          } else {
            // alert(response.sukses);
            $('#modaledit').modal('hide');
            // swal({
            //   title: "Data berhasil disimpan",
            //   text: "",
            //   icon: "success",
            //   buttons: true,
            //   dangerMode: true,
            // })
            swal({
              title: "Data Berhasil diupdate ",
              text: "",
              icon: "success",
            })
            reload_table();
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      });
      return false;
    })
  });

  $('#btntampilpass').click(function(e) {
    e.preventDefault();
    // membuat variabel berisi tipe input dari id='pass', id='pass' adalah form input password 
    var x = document.getElementById('password').type;
    //membuat if kondisi, jika tipe x adalah password maka jalankan perintah di bawahnya
    if (x == 'password') {
      //ubah form input password menjadi text
      document.getElementById('password').type = 'text';
      //ubah icon mata terbuka menjadi tertutup
      document.getElementById('btntampilpass').innerHTML = `<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye-slash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M10.79 12.912l-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/>
                                                        <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708l-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829z"/>
                                                        <path fill-rule="evenodd" d="M13.646 14.354l-12-12 .708-.708 12 12-.708.708z"/>
                                                        </svg>`;
    } else {
      //ubah form input password menjadi text
      document.getElementById('password').type = 'password';
      //ubah icon mata terbuka menjadi tertutup
      document.getElementById('btntampilpass').innerHTML = `<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                                        <path fill-rule="evenodd" d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                                        </svg>`;
    }
  })

  $('#btntampilconfpass').click(function(e) {
    e.preventDefault();
    // membuat variabel berisi tipe input dari id='pass', id='pass' adalah form input password 
    var x = document.getElementById('confpassword').type;
    //membuat if kondisi, jika tipe x adalah confpassword maka jalankan perintah di bawahnya
    if (x == 'password') {
      //ubah form input confpassword menjadi text
      document.getElementById('confpassword').type = 'text';
      //ubah icon mata terbuka menjadi tertutup
      document.getElementById('btntampilconfpass').innerHTML = `<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye-slash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M10.79 12.912l-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/>
                                                        <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708l-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829z"/>
                                                        <path fill-rule="evenodd" d="M13.646 14.354l-12-12 .708-.708 12 12-.708.708z"/>
                                                        </svg>`;
    } else {
      //ubah form input password menjadi text
      document.getElementById('confpassword').type = 'password';
      //ubah icon mata terbuka menjadi tertutup
      document.getElementById('btntampilconfpass').innerHTML = `<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                                        <path fill-rule="evenodd" d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                                        </svg>`;
    }
  })
</script>