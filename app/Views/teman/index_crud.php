<?= $this->extend('dashboard/index'); ?>

<?= $this->section('content'); ?>
<main>
  <div class="container-fluid px-4">
    <h3 class="mt-2"><?= $title; ?></h3>
    <div class="card mb-4">
      <div class="card-header" style="height: 3rem;">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <i class="fas fa-table me-1"></i>
            <li class="breadcrumb-item text-white"><a href="<?= base_url('dashboard') ?>" ?>Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tabel Teman</li>
          </ol>
        </nav>
      </div>
      <div class="card-body">
        <button class="btn btn-flat btn-info btn-sm btnreload" onclick="reload_table()" type="button"><i class="fa fa-spinner"></i> Reload Table</button>
        <button class="btn btn-flat btn-primary btn-sm" onclick="tambah()" type="button"><i class="fa fa-plus"></i> Tambah data</button>
        <div id="table_teman"></div>
      </div>
    </div>
  </div>
</main>

<?= $this->endSection(); ?>