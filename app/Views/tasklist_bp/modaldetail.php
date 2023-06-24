<!-- Modal -->
<div class="modal fade" id="modaldetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 50%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('tbjasa/updatedata', ['class' => 'formtbjasa']) ?>
      <div class="modal-body">
        <div class="row">
          <div class="col-12 col-sm-12">
            <label for="kode" class="form-label mb-1">Kode</label>
            <input type="text" class="form-control mb-2" name="kode" id="kode" value="<?= $tasklist_bp['kode'] ?>" readonly>
            <div class="invalid-feedback errorKode">
            </div>
            <label for="nama" class="form-label mb-1">Nama</label>
            <input type="text" class="form-control mb-2" name="nama" id="nama" value="<?= $tasklist_bp['nama'] ?>" readonly>
            <div class="invalid-feedback errorNama">
            </div>
            <!-- <label for="nama" class="form-label mb-0 labeltipe">Asuransi</label>
            <select class="form-select mb-1" name="kdasuransi" id="kdasuransi" required>
              <option value="">[Pilih Asuransi]
                <?php
                foreach ($tbasuransi as $key) {
                  if ($key['kode'] == $tasklist_bp['kdasuransi']) {
                    echo "<option value='$key[kode]' selected>$key[kode] - $key[nama]</option>";
                  } else {
                    echo "<option value='$key[kode]'>$key[kode] - $key[nama]</option>";
                  }
                }
                ?>
              </option>
            </select> -->
            <label for="keluhan" class="form-label mb-1">Asuransi</label>
            <div class="input-group mb-1">
              <input type="text" class="form-control form-control-sm" name="kdasuransi" id="kdasuransi" value="<?= $tasklist_bp['kdasuransi'] ?>" readonly>
              <input type="text" style="width: 40%" class="form-control form-control-sm" name="nmasuransi" id="nmasuransi" value="<?= $tasklist_bp['nmasuransi'] ?>" readonly>
              <button class="btn btn-outline-secondary" type="button" id="cariasuransi" disabled><i class="fa fa-search"></i></button>
            </div>
            <label for="nama" class="form-label mb-1">Aktif</label><br>
            <?php
            if ($tasklist_bp['aktif'] == 'Y') {
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
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
      <?= form_close() ?>
    </div>
  </div>
</div>