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
            <li class="breadcrumb-item active" aria-current="page">Tabel Divisi</li>
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
        <a href="/tbdivisi/create" class="btn btn-primary btn-sm mb-3"><i class="fa fa-plus"></i> Tambah Data Divisi</a>
        <!-- <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="fa fa-plus"></i> Tambah Data</button> -->
        <table id="datatablesSimple">
          <!-- <table class="table"> -->
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Kode</th>
              <th scope="col">Nama</th>
              <th scope="col">User</th>
              <th scope="col">Created</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $n = 1; ?>
            <?php foreach ($tbdivisi as $k) : ?>
              <tr>
                <th class="text-center" scope="row"><?= $n++; ?></th>
                <td><?= $k['kode']; ?></td>
                <td><?= $k['nama']; ?></td>
                <td><?= $k['user']; ?></td>
                <td><?= $k['created_at']; ?></td>
                <td>
                  <!-- <a href="/tbdivisi/detail/<?= $k['id']; ?>" class="btn btn-info btn-sm">Detail</a> -->
                  <!-- <button type="button" data-toggle="modal" data-target="#modalDetail" id="btn-detail" class="btn btn-warning btn-sm" data-id="<?= $k['id']; ?>"> <i class="fa fa-eye"></i></button> -->
                  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modaldetail<?= $k['id']; ?>"><i class="fa fa-eye"></i></button>
                  <a href="/tbdivisi/edit/<?= $k['id']; ?>" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                  <!-- <form action="/tbdivisi/<?= $k['id']; ?>" methode="post" class="d-inline">
                    <?= csrf_field(); ?> -->
                  <!-- <input type="hidden" name="_methode" value="DELETE"> -->
                  <!-- <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin?')"><i class="fa fa-trash"></i></button> -->
                  <!-- <input button type='Button' class='btn btn-danger btn-sm' value='Hapus' onClick="alert_hapus(<?= $k['id'] ?>)" /> -->
                  <input button type='Button' class='btn btn-danger btn-sm' value='Hapus' onClick="alert_hapus(`<?= $k['id'] ?>`, `<?= $k['kode'] ?>`)" />
                  <!-- </form> -->
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>

<?php $no = 0;
foreach ($tbdivisi as $k) : $no++; ?>
  <!-- Modal -->
  <div class="modal fade" id="modaldetail<?= $k['id']; ?>" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <!-- <div class="modal-dialog modal-xl"> -->
    <div class="modal-dialog">
      <div class="modal-content">
        <div class=" modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Detail Divisi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-2">
            <label for="kode" class="col-form-label">Kode Divisi</label>
            <input type="text" class="form-control" name="kode" value="<?= $k['kode']; ?>" readonly>
          </div>
          <div class="mb-2">
            <label for="nama" class="col-form-label">Nama Divisi</label>
            <input type="text" class="form-control" name="nama" value="<?= $k['nama']; ?>" readonly>
          </div>
          <div class="mb-2">
            <label for="user" class="col-form-label">User</label>
            <input type="text" class="form-control" name="nama" value="<?= $k['user']; ?>" readonly>
            Create <input type="text" class="form-control" name="nama" value="<?= $k['created_at']; ?>" readonly class="inline">
            Update <input type="text" class="form-control" name="nama" value="<?= $k['updated_at']; ?>" readonly>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<?php endforeach ?>

<script>
  function alert_hapus($id, $kode) {
    swal({
        title: "Yakin akan hapus kode " + $kode + " ?",
        text: "Once deleted, you will not be able to recover this data!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          //alert($kode);
          $href = "/tbdivisi/";
          window.location.href = $href + $id;
          // swal("Poof! Your imaginary file has been deleted!", {
          //   icon: "success",
          // });
        } else {
          //swal("Batal Hapus!");
        }
      });
  };
</script>

<?= $this->endSection(); ?>