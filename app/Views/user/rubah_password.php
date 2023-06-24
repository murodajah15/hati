<!doctype html>
<html lang="en">
<?= $this->extend('dashboard/index'); ?>
<?= $this->section('content'); ?>

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
                  <h1 class="text-center font-weight-light my-2">Rubah Password</h1>
                </div>
                <div class="card-body">
                  <?php if (isset($validation)) : ?>
                    <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
                  <?php endif; ?>
                  <?php if (session()->getFlashdata('msg')) : ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('msg') ?></div>
                  <?php endif; ?>
                  <form action="/rubah_password/update/<?= $user['id']; ?>" method="post">
                    <?= csrf_field(); ?>
                    <?php
                    $session = session(); ?>
                    <input type="hidden" name="nama" value=<?= $session->get('nama'); ?>>
                    <input type="hidden" name="id" value=<?= $user['id']; ?>>
                    <div class="mb-2">
                      <label for="InputForName" class="form-label">Nama</label>
                      <input type="text" name="name" class="form-control" id="InputForName" value="<?= $session->get('nama'); ?>" placeholder="Name" disabled>
                    </div>
                    <div class="mb-2">
                      <label for="InputForEmail" class="form-label">Email address</label>
                      <input type="email" name="email" class="form-control" id="InputForEmail" value="<?= $user['email'] ?>" placeholder="Email" disabled>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <!-- <div class="form-floating mb-2 mb-md-2"> -->
                        <label for="inputPasswordLama">Password Lama</label>
                        <input class="form-control" id="inputForPasswordLama" name="password_lama" type="password" placeholder="Password lama" value="<?= (old('password_lama')) ? old('password_lama') : '' ?>" />
                        <!-- </div> -->
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <!-- <div class="form-floating mb-2 mb-md-0"> -->
                          <label for="inputPassword">Password Baru</label>
                          <input class="form-control" id="inputForPassword" name="password" type="password" placeholder="Password baru" value="<?= (old('password')) ? old('password') : '' ?>" />
                          <!-- </div> -->
                        </div>
                        <div class="col-md-6">
                          <!-- <div class="form-floating mb-3 mb-md-0"> -->
                          <label for="inputPasswordConfirm">Confirm Password Baru</label>
                          <input class="form-control" type="password" name="confpassword" placeholder="Confirm password baru" value="<?= (old('confpassword')) ? old('confpassword') : '' ?>" />
                          <!-- </div> -->
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="mt-3 mb-2">
                          <button type='submit' class='btn btn-primary'>Simpan</button>
                          <a href="<?= base_url('/dashboard') ?>"><input button type='Button' class='btn btn-danger' value='Batal' /></a>
                          <!-- <button type='submit' class="btn btn-primary btn-block">Simpan</button>
                          <button type='submit' class="btn btn-danger btn-block">Batal</button> -->
                        </div>
                      </div>
                  </form>
                </div>
                <!-- <div class="card-footer text-center py-3">
                  <div class="small"><a href="login">Have an account? Go to login</a></div>
                </div> -->
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

<?= $this->endSection(); ?>