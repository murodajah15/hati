<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">

  <!-- <title>Register</title> -->
</head>

<body class="bg-primary">
  <div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
      <main>
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-6">
              <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header">
                  <h1 class="text-center font-weight-light my-2">Sign Up</h1>
                </div>
                <div class="card-body">
                  <form action="/register/save" method="post">
                    <?= csrf_field(); ?>
                    <div class="mb-2">
                      <label for="InputForName" class="form-label">Name</label>
                      <input type="text" name="nama" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" id="InputForName" value="<?= (old('nama')) ? old('nama') : '' ?>" placeholder="Nama" autofocus>
                      <div class="invalid-feedback">
                        <?= $validation->getError('nama'); ?>
                      </div>
                    </div>
                    <div class="mb-2">
                      <label for="InputForEmail" class="form-label">Email address</label>
                      <input type="email" name="email" class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" id=" InputForEmail" value="<?= (old('email')) ? old('email') : '' ?>" placeholder="Email">
                      <div class="invalid-feedback">
                        <?= $validation->getError('email'); ?>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-floating mb-2 mb-md-0">
                          <label for="inputPassword">Password</label>
                          <input class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" id="inputForPassword" name="password" type="password" placeholder="Create a password" value="<?= (old('password')) ? old('password') : '' ?>" />
                          <div class="invalid-feedback">
                            <?= $validation->getError('password'); ?>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                          <label for="inputPasswordConfirm">Confirm Password</label>
                          <input class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" type="password" name="confpassword" placeholder="Confirm password" value="<?= (old('password')) ? old('password') : '' ?>" />
                          <div class="invalid-feedback">
                            <?= $validation->getError('confpassword'); ?>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- <div class="mb-2">
                      <div class="col-md-4">
                        <label for="InputForPassword" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="InputForPassword">
                        <label for="InputForConfPassword" class="form-label">Confirm Password</label>
                        <input type="password" name="confpassword" class="form-control" id="InputForConfPassword">
                      </div>
                    </div> -->

                    <div class="mt-3 mb-0">
                      <div class="d-grid"><button type='submit' class="btn btn-primary btn-block">Create Account</button></div>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center py-3">
                  <div class="small"><a href="<?= base_url('login') ?>">Have an account? Go to login</a></div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
  </div>

  <!-- Popper.js first, then Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
</body>

</html>