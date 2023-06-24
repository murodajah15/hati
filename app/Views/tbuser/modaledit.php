<?php
$db = \Config\Database::connect();
?>
<div class="modal fade" id="modaledit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 70%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- form_open('tbuser/updatedata', ['class' => 'formtbuser'], ['enctype' => 'multipart/form-data']) -->
      <form method='post' enctype='multipart/form-data' action='tbuser/updatedata' class='formtbuser'>
        <?= csrf_field(); ?>
        <input type="hidden" class="form-control" name="id" id="id" value="<?= $id ?>">
        <input type="hidden" class="form-control" name="photoLama" id="photoLama" value="<?= $photo ?>">
        <input type="hidden" class="form-control" name="password_lama" id="password_lama" value="<?= $password ?>">
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
              <input type="text" class="form-control" name="nama" id="nama" value="<?= $nama ?>">
              <div class="invalid-feedback errorNama">
              </div>
            </div>
          </div>
          <div class="row g-3 mb-2">
            <div class="col">
              <label for="nama" class="form-label mb-1">Nama Lengkap</label>
              <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" value="<?= $nama_lengkap ?>">
            </div>
            <div class="col">
              <label for="nama" class="form-label mb-1">No. HP</label>
              <input type="text" class="form-control" name="nohp" id="nohp" value="<?= $nohp ?>">
            </div>
          </div>
          <div class="row g-3 mb-2">
            <div class="col">
              <label for="nama" class="form-label mb-1">Password</label>
              <div class="input-group">
                <input type="password" class="form-control" name="password" id="password">
                <!-- <button class="btn btn-outline-secondary btn-sm" type="button" onlick="tampil_password()" id="tampil_password">Tampil</button> -->
                <button class="btn btn-outline-secondary btn-sm" type="button" id="btntampilpass"><i class="fa fa-eye"></i></button>
                <div class="invalid-feedback errorPassword">
                </div>
              </div>
            </div>
            <div class="col">
              <label for="nama" class="form-label mb-1">Confirm Password</label>
              <div class="input-group">
                <input type="password" class="form-control" name="confpassword" id="confpassword">
                <button class="btn btn-outline-secondary btn-sm" type="button" id="btntampilconfpass"><i class="fa fa-eye"></i></button>
                <div class="invalid-feedback errorConfpassword">
                </div>
              </div>
            </div>
          </div>
          <div class="row g-3 mb-2">
            <!-- <div class="col-md-6 mb-2"> -->
            <div class="col">
              <label for="nama" class="form-label mb-1">Level</label>
              <select class="form-select" name="level" id="level">
                <option value="">[Pilih Level]</option>
                <!-- <option value="ADMINISTRATOR">ADMINISTRATOR</option>
              <option value="ADMIN">ADMIN</option>
              <option value="GUEST">GUEST</option> -->
                <?php
                $arrlevel = array("ADMINISTRATOR", "ADMIN", "GUEST");
                $jml_kata = count($arrlevel);
                for ($c = 0; $c < $jml_kata; $c += 1) {
                  if ($arrlevel[$c] == $level) {
                    echo "<option value='$arrlevel[$c]' selected>$arrlevel[$c] </option>";
                  } else {
                    echo "<option value='$arrlevel[$c]'> $arrlevel[$c] </option>";
                  }
                }
                echo "</select>";
                ?>
              </select>
            </div>
            <div class="col">
              <label for="nama" class="form-label mb-0">Kelompok</label>
              <select class="form-select" name="kelompok" id="kelompok" required>
                <option value="">[Pilih Kelompok]
                  <?php
                  foreach ($tbklpuser as $key) {
                    if ($key['kelompok'] == $kelompok) {
                      echo "<option value='$key[kelompok]' selected>$key[kelompok]</option>";
                    } else {
                      echo "<option value='$key[kelompok]'>$key[kelompok]</option>";
                    }
                  }
                  ?>
                </option>
              </select>
            </div>
            <div class="row g-3 mb-2">
              <div class="col">
                <label for="nama" class="form-label mb-1">Salin Akses dari User</label>
                <select onchange="fsalinuser()" class="form-select salinuser" name="salinuser" id="salinuser">
                  <option value="">[Pilih User]
                    <?php
                    $builder = $db->table('user');
                    $builder->where('aktif', 'Y');
                    $builder->orderBy('email');
                    $query   = $builder->get();
                    $results = $query->getResultArray();
                    foreach ($results as $row) {
                      echo "<option value='$row[email]'>$row[email] - $row[nama]</option>";
                    }
                    ?>
                  </option>
                </select>
              </div>
              <div class="col">
                <label for="photo" class="col-sm-2 col-form-label">Photo</label>
                <div class="col-sm-2">
                  <img src="<?= base_url('/img/' . $photo) ?>" class="img-thumbnail img-preview">
                </div>
                <div class="col-sm-8">
                  <div class="mb-3">
                    <input type="file" accept="image/png, image/jpeg" class="custom-file-input" id="photo" name="photo" value="<?= $photo ?>" onchange="previewImg()">
                    <div class="invalid-feedback errorPhoto">
                    </div>
                    <label for="photo" class="custom-file-label">Pilih gambar..</label>
                  </div>
                </div>
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
                    <input class="form-check-input" type="checkbox" id="aktif" name="aktif" checked>
                  </div>';
                } else {
                  // echo "<tr><td>Aktif</td>     <td> : <input type=radio name='aktif' value='Y'> Y 
                  // 						  <input type=radio name='aktif' value='N' checked> N </td></tr></table>";
                  echo '<div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="aktif" name="aktif">
                  </div>';
                }
                ?>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" id="btnsimpan" class="btn btn-primary btnsimpan">Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          </div>
          <!-- form_close() -->
      </form>
    </div>
  </div>
</div>

<script>
  var myModal = document.getElementById('modaledit')
  var myInput = document.getElementById('nama')
  myModal.addEventListener('shown.bs.modal', function() {
    myInput.focus()
  })

  $(document).ready(function() {
    $('.formtbuser').submit(function(e) {
      e.preventDefault();
      $.ajax({
        type: "post",
        url: $(this).attr('action'),
        // data: $(this).serialize(),
        data: new FormData(this), //penggunaan FormData
        processData: false,
        contentType: false,
        cache: false,
        async: false,
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
            if (response.error.email) {
              // alert(response.error);
              $('#email').addClass('is-invalid');
              $('.errorEmail').html(response.error.email);
            }
            if (response.error.nama) {
              // alert(response.error);
              $('#nama').addClass('is-invalid');
              $('.errorNama').html(response.error.nama);
            }
            if (response.error.password) {
              // alert(response.error);
              $('#password').addClass('is-invalid');
              $('.errorPassword').html(response.error.password);
            }
            if (response.error.confpassword) {
              // alert(response.error);
              $('#confpassword').addClass('is-invalid');
              $('.errorConfpassword').html(response.error.confpassword);
            }
            if (response.error.photo) {
              // alert(response.error);
              $('#photo').addClass('is-invalid');
              $('.errorPhoto').html(response.error.photo);
            }
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