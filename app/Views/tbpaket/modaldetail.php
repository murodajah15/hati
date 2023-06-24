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
            <input type="text" class="form-control mb-2" name="kode" id="kode" value="<?= $tbpaket['kode'] ?>" readonly>
            <div class="invalid-feedback errorKode">
            </div>
            <label for="nama" class="form-label mb-1">Nama</label>
            <input type="text" class="form-control mb-2" name="nama" id="nama" value="<?= $tbpaket['nama'] ?>" readonly>
            <div class="invalid-feedback errorNama">
            </div>
            <label for="nama" class="form-label mb-1">Jenis Service</label>
            <select class="form-select form-select-sm mb-2" style="height: 31px;" name="jenis" id="jenis" readonly>
              <option value="">- PILIH JENIS SERVICE -</option>
              <?php
              $arr = array("PM", "GR", "PM+GR", "LAIN-LAIN");
              $jml_kata = count($arr);
              for ($c = 0; $c < $jml_kata; $c += 1) {
                if ($arr[$c] == $tbpaket['jenis']) {
                  echo "<option value='$arr[$c]' selected>$arr[$c] </option>";
                } else {
                  echo "<option value='$arr[$c]'> $arr[$c] </option>";
                }
              }
              echo "</select>";
              ?>
            </select>
            <label for="nama" class="form-label mb-0 labeltipe">Tipe</label>
            <select class="form-select mb-1" name="kdtipe" id="kdtipe" required>
              <option value="">[Pilih Tipe]
                <?php
                foreach ($tbtipe as $key) {
                  if ($key['kode'] == $tbpaket['kdtipe']) {
                    echo "<option value='$key[kode]' selected>$key[kode] - $key[nama]</option>";
                  } else {
                    echo "<option value='$key[kode]'>$key[kode] - $key[nama]</option>";
                  }
                }
                ?>
              </option>
            </select>
            <label for="nama" class="form-label mb-1">Aktif</label><br>
            <?php
            if ($tbpaket['aktif'] == 'Y') {
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