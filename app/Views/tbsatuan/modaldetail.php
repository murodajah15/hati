<!-- Modal -->
<div class="modal fade" id="modaldetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 50%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('tbsatuan/updatedata', ['class' => 'formtbsatuan']) ?>
      <input type="hidden" class="form-control" name="id" id="id" value="<?= $tbsatuan['id'] ?>">
      <div class="modal-body">
        <div class="col-md-6 mb-2">
          <label for="kode" class="form-label mb-1">Kode</label>
          <input type="text" class="form-control" name="kode" id="kode" value="<?= $tbsatuan['kode'] ?>" readonly>
          <div class="invalid-feedback errorKode">
          </div>
        </div>
        <div class="col-md-12 mb-2">
          <label for="nama" class="form-label mb-1">Nama</label>
          <input type="text" class="form-control" name="nama" id="nama" value="<?= $tbsatuan['nama'] ?>" readonly>
        </div>
        <div class="col-md-12 mb-2">
          <label for="nama" class="form-label mb-1">Aktif</label>
          <?php
          if ($tbsatuan['aktif'] == 'Y') {
            // echo "<tr><td>Aktif</td>     <td> : <input type=radio name='aktif' value='Y' disabled> Y 
            // 						  <input type=radio name='aktif' value='N' checked disabled> N </td></tr></table>";
            echo '<div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="aktif" name="aktif" checked disabled>
                  </div>';
          } else {
            // echo "<tr><td>Aktif</td>     <td> : <input type=radio name='aktif' value='Y' checked disabled> Y  
            // 						  <input type=radio name='aktif' value='N' disabled> N </td></tr></table>";
            echo '<div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="aktif" name="aktif" disabled>
                  </div>';
          }
          ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        <?= form_close() ?>
      </div>
    </div>
  </div>