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
  <title>Login</title>
  <link rel="shortcut icon" href="<?= base_url('favicon.ico') ?>" type="image/x-icon" />
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
                  <p style="text-align: center; margin:-20px 0px"><img src=<?= base_url("/img/user_blue.png") ?> width="100px" height="100px" class='img-circle'></p>
                  <h3 class="text-center font-weight-light my-4">Silahkan Login</h3>
                </div>
                <div class="card-body">
                  <?php if (session()->getFlashdata('msg')) : ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('msg') ?></div>
                  <?php endif; ?>
                  <form action="/login/auth" method="post">
                    <div class="mb-3">
                      <label for="InputForEmail" class="form-label">Email address</label>
                      <input type="email" name="email" class="form-control" id="email" value="<?= (old('email')) ? old('email') : '' ?>" autocomplete='off' placeholder="Masukan Email" autofocus>
                      <!-- value="<?= set_value('email') ?>" -->
                    </div>
                    <div class="mb-3">
                      <label for="InputForPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="password" value="<?= (old('password')) ? old('password') : '' ?>" placeholder="Masukan Password" autocomplete='off'>
                    </div>
                    <!-- <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                      <button type="submit" class="btn btn-primary">Login</button>
                    </div> -->
                    <div class="mt-3 mb-0">
                      <div class="d-grid"><button type='submit' class="btn btn-primary btn-block">Login</button></div>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center py-3">
                  <!-- <a class="small" href="forgotpassword.html">Forgot Password?</a> -->
                  <a class="small" href="resetpassword">
                    <font color="red">Reset Password!</font>
                  </a>
                  <div class="small"><a href="register">Need an account? Sign up!</a></div>
                  <br>
                  <p style="font-size:13px;" class="text-center"><i class="fa fa-car"></i> Copyright &copy; 2022 - <?= date("Y") ?> - Honda Autoland Group</p>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>

    <!-- Popper.js first, then Bootstrap JS -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script> -->

</body>

</html>