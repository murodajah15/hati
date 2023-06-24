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
            <li class="breadcrumb-item active" aria-current="page">Pegawai</li>
          </ol>
        </nav>
      </div>
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
      <div class="card-body">

        <div class="container mt-1">
          <!-- <table id="datatablesSimple"> -->
          <table id="tabel-teman" class="table table-striped" style="width:100%">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nama</th>
                <th scope="col">Alamat</th>
                <th scope="col">Jekel</th>
                <th scope="col" width="170">Aksi</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</main>

<script>
  $(document).ready(function() {
    $('#tabel-teman').DataTable({
      processing: true,
      serverSide: true,
      // scrollY: "400px",
      // scrollCollapse: true,
      ajax: {
        url: '<?= site_url('temanAjax') ?>',
        type: 'POST',
      },
      ordering: true,
      columns: [{
          data: null,
          render: function(data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          data: 'namateman',
          name: 'namateman'
        },
        {
          data: 'alamat',
          name: 'alamat'
        },
        {
          data: 'jeniskelamin',
          name: 'jeniskelamin'
        },
        {
          data: null,
          render: function(data, type, row, meta) {
            return `<a href="#${row.id}" onclick="alert('Edit data id=${row.id}')"><button class='btn btn-sm btn-secondary' href='javascript:void(0)'><i class='fa fa-eye'></i></button></a> 
          <a href="#${row.id}" onclick="alert('Edit data id=${row.id}')"><button class='btn btn-sm btn-primary' href='javascript:void(0)'><i class='fa fa-edit'></i></button></a> 
          <a href="#${row.id}" onclick="alert('Delete data id=${row.id}')"><button class='btn btn-sm btn-danger' href='javascript:void(0)'><i class='fa fa-trash'></i></button></a>`;
          }

        },
      ],
      columnDefs: [{
        orderable: false,
        targets: [0, 1, 2, 3, 4]
      }],
      bFilter: true,
      order: [
        [0, 'asc'],
        [1, 'asc'],
        [2, 'asc'],
        [3, 'asc'],
      ],
    });
  });
</script>

<?= $this->endSection(); ?>