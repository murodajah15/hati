<!-- Modal -->
<div class="modal fade" id="modaldetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 50%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('tbjasa/updatedata', ['class' => 'formtbjasa']) ?>
      <input type="hidden" class="form-control" name="id" id="id" value="<?= $tbjasa['id'] ?>">
      <input type="hidden" class="form-control" name="kodelama" id="kodelama" value="<?= $tbjasa['kode'] ?>">
      <div class="modal-body">
        <div class="row">
          <div class="col-12 col-sm-12">
            <?php
            if ($tbjasa['parent'] == 'Y') {
              $parent = 'Y';
            } else {
              $parent = 'N';
            }
            ?>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" <?= $parent == 'Y' ? 'checked' : '' ?> disabled>
              <label class="form-check-label" for="Parent">
                Parent
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2" <?= $parent == 'N' ? 'checked' : '' ?> disabled>
              <label class="form-check-label" for="Child">
                Child
              </label>
            </div>
            <label for="kode" class="form-label mb-1">Kode</label>
            <input type="text" class="form-control mb-2" name="kode" id="kode" value="<?= $tbjasa['kode'] ?>" readonly>
            <div class="invalid-feedback errorKode">
            </div>
            <label for="nama" class="form-label mb-1">Nama</label>
            <input type="text" class="form-control mb-2" name="nama" id="nama" value="<?= $tbjasa['nama'] ?>" readonly>
            <div class="invalid-feedback errorNama">
            </div>
            <div id="form-child">
              Parent
              <div class="input-group mb-2">
                <input style="width: 5%" type="text" name="parent_id" id="parent_id" class="form-control" value="<?= $tbjasa['parent_id'] ?>" placeholder="ID" readonly>
                <input style="width: 50%" type="text" name="parent_name" id="parent_name" class="form-control" placeholder="Parent" value="<?= $parent == 'Y' ? '' : $tbjasa['nama'] ?>" readonly>
                <button class="btn btn-outline-secondary" type="button" id="cariparent" disabled><i class="fa fa-search"></i></button>
              </div>
              <label for="" class="form-label mb-1">Jam</label>
              <input type="number" class="form-control mb-2" name="jam" id="jam" step="any" value="<?= $tbjasa['jam'] ?>" readonly>
              <label for="" class="form-label mb-1">FRT</label>
              <input type="number" class="form-control mb-2" name="frt" id="frt" step="any" value="<?= $tbjasa['frt'] ?>" readonly>
              <label for="" class="form-label mb-1">Harga</label>
              <input type="number" class="form-control mb-2" name="harga" id="harga" step="any" value="<?= $tbjasa['harga'] ?>" readonly>
            </div>
            <label for="nama" class="form-label mb-1">Aktif</label><br>
            <?php
            if ($tbjasa['aktif'] == 'Y') {
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