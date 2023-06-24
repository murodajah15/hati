<!-- Modal -->
<div class="modal fade" id="modaldetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <input type="hidden" class="form-control" name="id" id="id" value=<?= $id ?>>
      <div class="modal-body">
        <div class="col-md-6 mb-2">
          <label for="kode" class="form-label mb-1">Kode</label>
          <input type="text" class="form-control" name="kode" id="kode" value="<?= $kode ?>" readonly>
        </div>
        <div class="col-md-12 mb-2">
          <label for="nama" class="form-label mb-1">Nama</label>
          <input type="text" class="form-control" name="nama" id="nama" value="<?= $nama ?>" readonly>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>