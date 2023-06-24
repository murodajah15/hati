<!-- Modal -->
<div class="modal fade" id="modaldetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 80%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('tbsa/updatedata', ['class' => 'formtbsa']) ?>
      <input type="hidden" class="form-control" name="id" id="id" value="<?= $tbsa['id'] ?>">
      <div class="modal-body">
        <div class="row">
          <div class="col-12 col-sm-6">
            <label for="kdsa" class="form-label mb-1">Kode</label>
            <input type="text" class="form-control" name="kdsa" id="kdsa" value="<?= $tbsa['kdsa'] ?>">
            <div class="invalid-feedback errorKdsa">
            </div>
            <label for="nama" class="form-label mb-1">Nama</label>
            <input type="text" class="form-control" name="nama" id="nama" value="<?= $tbsa['nama'] ?>" autofocus>
            <div class="invalid-feedback errorNama">
            </div>
            <label for="nama" class="form-label mb-1">Alamat</label>
            <input type="text" class="form-control" name="alamat" id="alamat" value="<?= $tbsa['alamat'] ?>">
            <label for="nama" class="form-label mb-1">Kelurahan</label>
            <input type="text" class="form-control" name="kelurahan" id="kelurahan" value="<?= $tbsa['kelurahan'] ?>">
            <label for="nama" class="form-label mb-1">Kecamatan</label>
            <input type="text" class="form-control" name="kecamatan" id="kecamatan" value="<?= $tbsa['kecamatan'] ?>">
          </div>
          <div class="col-12 col-sm-6">
            <label for="nama" class="form-label mb-1">Kota</label>
            <input type="text" class="form-control" name="kota" id="kota" value="<?= $tbsa['kota'] ?>">
            <label for="nama" class="form-label mb-1">Kode Pos</label>
            <input type="text" class="form-control" name="kodepos" id="kodepos" value="<?= $tbsa['kodepos'] ?>">
            <label for="nama" class="form-label mb-1">No. HP</label>
            <input type="text" class="form-control mb-2" name="nohp" id="nohp" value="<?= $tbsa['nohp'] ?>">
            <label for="nama" class="form-label mb-1">Aktif</label><br>
            <!-- <input type=radio name='aktif' value='Y' checked> Y
          <input type=radio name='aktif' value='N'> N -->
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="aktif" name="aktif" checked>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
      <?= form_close() ?>
    </div>
  </div>
</div>