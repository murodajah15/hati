<?= $this->extend('dashboard/index'); ?>

<?= $this->section('content'); ?>
<!-- <div id="layoutSidenav_content"> -->
<main>
  <div class="container-fluid px-4">
    <!-- <h2 class="mt-4">Tabel Cabang</h2> -->
    <!-- <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Tabel Cabang</li>
      </ol> -->
    <h2></h2>
    <?php if (session()->getFlashdata('pesan')) : ?>
      <!-- <div class="alert alert-success alert-dismissible fade in" role="alert"> -->
      <div class="alert alert-success" role="alert">
        <?= session()->getFlashdata('pesan'); ?>
      </div>
    <?php endif; ?>
    <div class="card mb-4">
      <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Detail Data Tabel Cabang
      </div>
      <div class="card-body">
        <form class="row g-3" action="/tbcabang/save" method="post">
          <div class="col-md-6">
            <label for="kode" class="form-label">Kode</label>
            <input type="text" class="form-control" id="kode" name="kode" autofocus value="<?= $tbcabang['kode']; ?>" readonly>
          </div>
          <div class="col-md-12">
            <label for="kode" class="form-label">Nama</label>
            <input type="text" class="form-control " id="nama" name="nama" autofocus value="<?= $tbcabang['nama']; ?>" readonly>
          </div>
          <div class="col-12">
            <a href="<?= base_url('tbcabang'); ?>"><button type="button" class="btn btn-danger btn-xs">Close</button></a>
          </div>
          <br><br><br>
        </form>
      </div>
    </div>
</main>

<?= $this->endSection(); ?>