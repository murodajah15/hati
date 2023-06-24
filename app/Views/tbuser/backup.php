<?= $this->extend('dashboard/index'); ?>
<?= $this->section('content'); ?>

<main>
  <div class="container-fluid px-4">
    <!-- <h3 class="mt-2"><?= $title; ?></h3> -->
    <br>
    <div class="card mb-4">
      <div class="card-header" style="height: 3rem;">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <i class="fas fa-table me-1"></i>
            <li class="breadcrumb-item text-white"><a href="<?= base_url('dashboard') ?>" ?>Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
          </ol>
        </nav>
      </div>
    </div>
    <p align='center'><a target="_blank" class='btn btn-primary' href='proses_backup' onClick="return confirm('Anda yakin akan proses backup database ?')">
        <span class='glyphicon glyphicon-record'></span></button> Proses Backup</a></p><br><br>
</main>

<?= $this->endSection(); ?>