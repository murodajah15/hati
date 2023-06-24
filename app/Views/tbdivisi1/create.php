<?= $this->extend('dashboard/index'); ?>

<?= $this->section('content'); ?>
<!-- <div id="layoutSidenav_content"> -->
<main>
  <div class="container-fluid px-4">
    <h3 class="mt-2"><?= $title; ?></h3>
    <?php if (session()->getFlashdata('pesan')) : ?>
      <!-- <div class="alert alert-success alert-dismissible fade in" role="alert"> -->
      <div class="alert alert-success" role="alert">
        <?= session()->getFlashdata('pesan'); ?>
      </div>
    <?php endif; ?>
    <div class="card mb-4">
      <div class="card-header" style="height: 3rem;">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>" ?>Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('/tbdivisi') ?>" ?>Tabel Divisi</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Tambah Divisi</li>
          </ol>
        </nav>
      </div>
      <div class="card-body">
        <form class="row g-3" action="/tbdivisi/save" method="post">
          <div class="col-md-6">
            <label for="kode" class="form-label">Kode</label>
            <input type="text" class="form-control <?= ($validation->hasError('kode')) ? 'is-invalid' : ''; ?>" id="kode" name="kode" autofocus value="<?= old('kode'); ?>">
            <div class="invalid-feedback">
              <?= $validation->getError('kode'); ?>
            </div>
          </div>
          <div class="col-md-12">
            <label for="kode" class="form-label">Nama</label>
            <input type="text" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" id="nama" name="nama" autofocus value="<?= old('nama'); ?>">
            <div class="invalid-feedback">
              <?= $validation->getError('nama'); ?>
            </div>
          </div>
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-xs">Simpan</button>
            <a href="<?= base_url('tbdivisi'); ?>"><button type="button" class="btn btn-danger btn-xs">Batal</button></a>
          </div>
          <br><br><br>
        </form>
      </div>
    </div>
</main>

<?= $this->endSection(); ?>