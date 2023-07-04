<div class="row">
  <div class="container fluid mt-2">
    <?php if (session()->getFlashdata('pesan')) : ?>
      <div class="alert alert-primary d-flex align-items-center" role="alert">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
          <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </svg>
        <div>
          <!-- <div class="alert alert-success alert-dismissible fade in" role="alert"> -->
          <!-- <div class="alert alert-success" role="alert"> -->
          <?= session()->getFlashdata('pesan'); ?>
          <!-- </div> -->
        </div>
      </div>

    <?php endif; ?>
  </div>

  <div class="container mt-1">
    <!-- <table class="table table-bordered table-striped" id="tbl-agama-data"> -->
    <table id="tbl-module-data" class="table table-striped" style="width:100%">
      <!-- <table class="table"> -->
      <thead>
        <tr>
          <th width="30">No.</th>
          <th>Module</th>
          <th>Menu</th>
          <th>Parent</th>
          <th>Main</th>
          <th>Level</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $n = 1; ?>
        <?php foreach ($tbmodule as $k) : ?>
          <tr>
            <!-- <th class="text-center" scope="row"><?= $n++; ?></th> -->
            <td><?= $k['nurut']; ?></td>
            <td><?= $k['cmainmenu'] == 'Y' ? '<b>' . $k['cmodule'] . '</b>' : $k['cmodule'] ?></td>
            <td><?= $k['cmenu']; ?></td>
            <td><?= $k['cparent']; ?></td>
            <td><?= $k['cmainmenu']; ?></td>
            <td><?= $k['nlevel']; ?></td>
            <td width="120">
              <button type="button" class="btn btn-success btn-sm" onClick="detail(<?= $k['id'] ?>)"><i class="fa fa-eye"></i></button>
              <button type='Button' class='btn btn-warning btn-sm' onClick="edit(<?= $k['id'] ?>)"><i class="fa fa-edit"></i></button>
              <button type='Button' class='btn btn-danger btn-sm' onClick="hapus(`<?= $k['id'] ?>`, `<?= $k['cmodule'] ?>`)"><i class="fa fa-trash"></i></button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#tbl-module-data').DataTable({
      destroy: true,
      "aLengthMenu": [
        [5, 50, 100, -1],
        [5, 50, 100, "All"]
      ],
      "iDisplayLength": 5
    })
  });
</script>