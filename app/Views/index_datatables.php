<?= $this->extend('dashboard/index'); ?>

<?= $this->section('content'); ?>
<main>
  <div class="container-fluid px-4">
    <div class="row">
      <div class="container container-fluid">
        <table class="table table-bordered table-stripted">
          <!-- <table class="table"> -->
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Nama</th>
              <th scope="col">Alamat</th>
              <th scope="col">Jekel</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>

<script>
  table => ('#table_teman').DataTable({
    "order": [],
    "processing": true,
    "serverside": true,
    "ajax": {
      "url": "<?php echo site_url('Datatables/table_data'); ?>",
      "type": "POST"
    },
    "columnDefs": [{
      "targets": [0],
      "orderable": false
    }]
  });
</script>

<?= $this->endSection(); ?>