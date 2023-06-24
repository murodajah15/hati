<?= $this->extend('dashboard/index'); ?>
<?= $this->section('content'); ?>
<?php
$menu = "update profile";
$submenu = "";
?>
<!-- <div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <font size="4">EXPORT DATA MASTER PEGAWAI</font>
      </div>
      <div class="panel-body">
      </div>
    </div>
  </div>
</div> -->

<!-- <div id="layoutSidenav_content"> -->
<div class="container-fluid px-4">
  <br>
  <div class="row">
    <div class="card mb-3">
      <div class="card-header">
        <h3>UPDATE PROFILE USER</h3>
      </div>
      <br>
      <form class="row g-3" action="/update_profile/update/<?= $user['id']; ?>" method="post">
        <input type="hidden" name="id" value="<?= $user['id'] ?>">
        <div class="col-md-6">
          <label for="inputnama" class="form-label">User Nama</label>
          <input type="text" class="form-control" id="name" name="nama" value="<?= $user['nama'] ?>" disabled>
        </div>
        <div class="col-md-6">
          <label for="inputEmail4" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email" value="<?= $user['email'] ?>" disabled>
        </div>
        <div class="col-md-6">
          <label for="namalengkap" class="form-label">Nama Lengkap</label>
          <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?= $user['nama_lengkap'] ?>">
        </div>
        <div class="col-md-6">
          <label for="inputnohp" class="form-label">No. HP</label>
          <input type="text" class="form-control" id="nohp" name="nohp" value="<?= $user['nohp'] ?>">
        </div>
        <div class="col-12">
          <button type="submit" class="btn btn-primary btn-xs">Simpan</button>
          <a href="<?= base_url('dashboard'); ?>"><button type="button" class="btn btn-danger btn-xs">Batal</button></a>
        </div>
        <br><br><br>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>