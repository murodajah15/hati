<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <!-- <?= base_url('/css/bootstrap-520.min.css') ?> -->
  <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous"> -->
  <link rel="stylesheet" href="<?= base_url('/css/bootstrap-520.min.css') ?>">
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" /> -->
  <link rel="stylesheet" href="<?= base_url('/vendor/fontawesome/css/fontawesome.min.css') ?>">
  <link href="<?= base_url('/css/sweet-alert.css') ?>" rel="stylesheet" type="text/css" />


  <title>Login</title>
</head>

<body class="bg-default">
  <div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
      <main>
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-5">
              <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header">
                  <p style="text-align: center; margin:-20px 0px"><img src="/img/reset_password.png" width="70px" height="70px" class='img-circle'></p>
                  <h3 class="text-center font-weight-light my-4">Reset Password</h3>
                </div>
                <div class="card-body">
                  <?php if (session()->getFlashdata('msg')) : ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('msg') ?></div>
                  <?php endif; ?>
                  <!-- <form action="/resetpassword/reset" method="post"> -->
                  <?= form_open('/resetpassword', ['class' => 'formresetpassword']) ?>
                  <div class="mb-3">
                    <label for="InputForEmail" class="form-label">Email address</label>
                    <!-- <input type="email" name="email" class="form-control" id="email" value="<?= (old('email')) ? old('email') : '' ?>" placeholder="Masukan email" autocomplete='off'> -->
                    <input type="email" class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" id="email" name="email" autofocus value="<?= old('email'); ?>">
                    <div class="invalid-feedback errorEmail">
                      <?= $validation->getError('email'); ?>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="InputForPassword" class="form-label">Password</label>
                    <!-- <input type="password" name="password" class="form-control" id="password" value="<?= (old('password')) ? old('password') : '' ?>" placeholder="Masukan Password" autocomplete='off'> -->
                    <input type="password" class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>" id="password" name="password" autofocus value="<?= old('password'); ?>" placeholder="Masukan Password" autocomplete='off'>
                    <div class="invalid-feedback errorPassword">
                      <?= $validation->getError('password'); ?>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="InputForPassword" class="form-label">Confirm Password</label>
                    <!-- <input type="password" name="confpassword" class="form-control" id="confpassword" value="<?= (old('confpassword')) ? old('confpassword') : '' ?>" placeholder="Konfirmasi Password" autocomplete='off'> -->
                    <input type="password" class="form-control <?= ($validation->hasError('confpassword')) ? 'is-invalid' : ''; ?>" id="confpassword" name="confpassword" autofocus value="<?= old('confpassword'); ?>" placeholder="Masukan ulang password" autocomplete='off'>
                    <div class="invalid-feedback errorConfpassword">
                      <?= $validation->getError('confpassword'); ?>
                    </div>
                  </div>
                  <!-- <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                      <button type="submit" class="btn btn-primary">Login</button>
                    </div> -->
                  <div class="mt-3 mb-0">
                    <div class="d-grid"><button type='submit' class="btn btn-danger btnreset" id="btnreset">Reset</button></div>
                  </div>
                  <?= form_close() ?>
                </div>
                <div class="card-footer text-center py-3">
                  <div class="small"><a href="login">Have an account? Login!</a></div>
                  <br>
                  <p style="font-size:13px;" class="text-center"><i class="fa fa-car"></i> Copyright &copy; 2022 - <?= date("Y") ?> - Honda Autoland Group</p>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>

    <script src="<?= base_url('/js/scripts.js') ?>"></script>
    <script src="<?= base_url('js/jquery-3.5.1.js') ?>" rel="stylesheet"></script>
    <script src="<?= base_url('/js/sweet-alert.min.js') ?>"></script>

    <script>
      $(document).ready(function() {
        $('.formresetpassword').submit(function(e) {
          e.preventDefault();
          $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function() {
              $('.btnreset').attr('disable', 'disabled')
              $('.btnreset').html('<i class="fa fa-spin fa-spinner"></i>')
            },
            complete: function() {
              $('.btnreset').removeAttr('disable')
              $('.btnreset').html('Reset')
            },
            success: function(response) {
              if (response.error) {
                // alert(response.error.email);
                if (response.error.email) {
                  $('#email').addClass('is-invalid');
                  $('.errorEmail').html(response.error.email);
                } else {
                  $('.errorEmail').fadeOut();
                  $('#email').removeClass('is-invalid');
                  $('#email').addClass('is-valid');
                }
                if (response.error.password) {
                  $('#password').addClass('is-invalid');
                  $('.errorPassword').html(response.error.password);
                } else {
                  $('.errorPassword').fadeOut();
                  $('#password').removeClass('is-invalid');
                  $('#password').addClass('is-valid');
                }
                if (response.error.confpassword) {
                  $('#confpassword').addClass('is-invalid');
                  $('.errorConfpassword').html(response.error.confpassword);
                } else {
                  $('.errorConfpassword').fadeOut();
                  $('#confpassword').removeClass('is-invalid');
                  $('#confpassword').addClass('is-valid');
                }
              } else {
                // alert(response.sukses)
                if (response.sukses !== 'Email tidak ditemukan!') {
                  swal({
                      title: response.sukses, //"Reset Password Berhasil",
                      text: "Reset password berhasil!",
                      icon: "success",
                    })
                    .then(function() {
                      window.location.href = '/login';
                    });
                } else {
                  swal({
                    title: response.sukses,
                    text: "Reset password gagal!",
                    icon: "error",
                  })
                }
              }
            },
            error: function(xhr, ajaxOptions, thrownError) {
              alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
          });
          return false;
        })
      })
    </script>

</body>

</html>