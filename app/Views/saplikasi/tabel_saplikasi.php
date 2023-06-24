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
    <?= form_open("saplikasi/deletemultiple", ['class' => "formhapus"]) ?>
    <!-- <table class="table table-bordered table-striped" id="tbl-agama-data"> -->
    <table id="tbl-saplikasi-data" class="table table-striped" style="width:100%">
      <!-- <table class="table"> -->
      <thead>
        <tr>
          <th width="50" class="text-center"><button type="submit" class="btn btn-flat btn-light btn-sm mb-2 tombolhapusbanyak"><i class="fa fa-trash"></i></button><input type="checkbox" class="form-checkbox" name="centangsemua" id="centangsemua"></th>
          <th width="30">No.</th>
          <th>Kode</th>
          <th>Nama</th>
          <th>Alamat</th>
          <th>Aktif</th>
          <th width="100">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $n = 1; ?>
        <?php foreach ($saplikasi as $k) : ?>
          <tr>
            <td class="text-center"><input type="checkbox" class="centang" name="id_a[]" value="<?= $k['logo'] ?>"></td>
            <td class="text-center" scope="row"><?= $n++; ?></td>
            <td><?= $k['kd_perusahaan']; ?></td>
            <td><?= $k['nm_perusahaan']; ?></td>
            <td><?= $k['alamat']; ?></td>
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
            <td width="120">
              <button type="button" class="btn btn-success btn-sm" onClick="detail(<?= $k['id'] ?>)"><i class="fa fa-eye"></i></button>
              <button type='Button' class='btn btn-warning btn-sm' onClick="edit(<?= $k['id'] ?>)"><i class="fa fa-edit"></i></button>
              <button type='Button' class='btn btn-danger btn-sm' onClick="hapus(`<?= $k['id'] ?>`, `<?= $k['kd_perusahaan'] ?>`)"><i class="fa fa-trash"></i></button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?= form_close(); ?>
</div>

<script>
  $(document).ready(function() {
    $('#tbl-saplikasi-data').DataTable({
      destroy: true,
      "aLengthMenu": [
        [5, 50, 100, -1],
        [5, 50, 100, "All"]
      ],
      "iDisplayLength": 5,
      columnDefs: [{
        orderable: false,
        targets: [0]
      }],
      bFilter: true,
      order: [
        [0, 'asc'],
        [1, 'asc'],
        [2, 'asc'],
        [3, 'asc'],
        [4, 'asc'],
      ],
    })
  });

  $('#centangsemua').click(function(e) {
    if ($(this).is(":checked")) {
      $('.centang').prop('checked', true)
    } else {
      $('.centang').prop('checked', false)
    }
  })

  $('.formhapus').on('submit', (function(e) {
    e.preventDefault();
    let jmldata = $('.centang:checked');
    // alert(jmldata.length);
    if (jmldata.length === 0) {
      // alert('tidak ada data yang dihapus, silahkan di centang');
      swal({
        title: "Tidak ada data yang dipilih",
        text: `Ada ${jmldata.length} data yang akan dihapus!`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: 'ya ',
        cancelButtonText: 'cancel',
        // buttons: true,
        dangerMode: true,
      })
    } else {
      swal({
          title: "Yakin akan hapus ?",
          text: `Ada ${jmldata.length} data yang akan dihapus!`,
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              url: $(this).attr('action'),
              data: $(this).serialize(),
              type: "POST",
              dataType: "JSON",
              success: function(response) {
                //if success reload ajax table
                reload_table();
                swal({
                  title: "Data Berhasil dihapus ",
                  text: response.sukses,
                  icon: "success"
                })
              },
              // error: function(jqXHR, textStatus, errorThrown) {
              // alert('error');
              error: function(xhr, ajaxOptions, ThrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
              }
            });
          } else {
            // swal("Batal Hapus!");
          }
        });
    }
    return false;
  }));
</script>