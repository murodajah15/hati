<!-- Modal -->
<div class="modal fade" id="modaldetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 50%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('tbagama/updatedata', ['class' => 'formtbagama']) ?>
      <input type="hidden" class="form-control" name="id" id="id" value=<?= $id ?>>
      <div class="modal-body">
        <div class="col-md-6 mb-2">
          <label for="kode" class="form-label mb-1">No. Urut</label>
          <input type="text" class="form-control" name="nurut" id="nurut" value="<?= $nurut ?>" readonly>
        </div>
        <div class="col-md-12 mb-2">
          <label for="nama" class="form-label mb-1">Module</label>
          <input type="text" class="form-control" name="cmodule" id="cmodule" value="<?= $cmodule ?>" readonly>
        </div>
        <div class="col-md-12 mb-2">
          <label for="nama" class="form-label mb-1">Menu</label>
          <input type="text" class="form-control" name="cmenu" id="cmenu" value="<?= $cmenu ?>" readonly>
        </div>
        <div class="col-md-12 mb-2">
          <label for="nama" class="form-label mb-1">Parent</label>
          <input type="text" class="form-control" name="cparent" id="cparent" value="<?= $cparent ?>" readonly>
        </div>
        <!-- <div class="col-md-12 mb-2">
          <label for="nama" class="form-label mb-1">Main Menu</label>
          <input type="text" class="form-control" name="cmainmenu" id="cmainmenu" value="<?= $cmainmenu ?>" readonly>
        </div> -->
        <div class="col">
          <label for="nama" class="form-label mb-1">Main Menu</label><br>
          <?php
          if ($cmainmenu == 'Y') {
            echo '<div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="cmainmenu" name="cmainmenu" checked disabled>
                  </div>';
          } else {
            echo '<div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="cmainmenu" name="cmainmenu" disabled>
                  </div>';
          }
          ?>
        </div>
        <div class="col-md-12 mb-2">
          <label for="nama" class="form-label mb-1">Level</label>
          <input type="text" class="form-control" name="nlevel" id="nlevel" value="<?= $nlevel ?>" readonly>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
      <?= form_close() ?>
    </div>
  </div>
</div>