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
  <div class="container mt-0">
    <button class="btn btn-flat btn-primary btn-sm mb-2 tomboltambah" type="button"><i class="fa fa-plus"></i> Tambah</button>
    <!-- <button class="btn btn-flat btn-primary btn-sm mb-2 mt-0 tomboltambah" type="button"><i class="fa fa-plus"></i> Tambah data</button> -->
    <!-- <table class="table table-bordered table-striped" id="tbl-agama-data"> -->
    <table id="tbl-user-data" class="table table-striped" style="width:100%">
      <!-- <table class="table"> -->
      <thead>
        <tr>
          <th width="30">No.</th>
          <th>Nama</th>
          <th>Email</th>
          <th>Nama Lengkap</th>
          <th>Aktif</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $n = 1; ?>
        <?php foreach ($tbuser as $k) : ?>
          <tr>
            <td class="text-center" scope="row"><?= $n++; ?></td>
            <td><?= $k['nama']; ?></td>
            <td><?= $k['email']; ?></td>
            <td><?= $k['nama_lengkap']; ?></td>
            <?php
            if ($k['aktif'] == 'Y') {
              echo '<td><div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="aktif" name="aktif" checked disabled>
            </div></td>';
            } else {
              echo '<td><div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="aktif" name="aktif" disabled>
            </div></td>';
            }
            ?>
            <td width="190">
              <!-- <a href="/tbuser/detail/<?= $k['email']; ?>" class="btn btn-info btn-sm">Akses</a> -->
              <button type="button" class="btn btn-info btn-sm" onClick="akses(<?= $k['id'] ?>)"><i class="fa fa-book"></i> Akses</button>
              <button type="button" class="btn btn-success btn-sm" onClick="detail(<?= $k['id'] ?>)"><i class="fa fa-eye"></i></button>
              <button type='Button' class='btn btn-warning btn-sm' onClick="edit(<?= $k['id'] ?>)"><i class="fa fa-edit"></i></button>
              <button type='Button' class='btn btn-danger btn-sm' onClick="hapus(`<?= $k['id'] ?>`)"><i class="fa fa-trash"></i></button>
              <!-- </form> -->
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#tbl-user-data').DataTable({
      destroy: true,
      "aLengthMenu": [
        [5, 50, 100, -1],
        [5, 50, 100, "All"]
      ],
      "iDisplayLength": 5
    })
  });

  $('.tomboltambah').click(function(e) {
    e.preventDefault();
    $.ajax({
      url: "<?= site_url('tbuser/formtambah') ?>",
      dataType: "json",
      success: function(response) {
        $('.viewmodal').html(response.data).show();
        $('#modaltambah').modal('show');
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  })
</script>