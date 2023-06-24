<!-- Modal -->
<div class="modal fade" id="modaldetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 80%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('tbagama/updatedata', ['class' => 'formtbagama']) ?>
      <input type="hidden" class="form-control" name="id" id="id" value=<?= $id ?>>
      <div class="modal-body">
        <div class="row g-3 mb-2">
          <div class="col-md-6">
            <label for="kode" class="form-label mb-1">Kode Perusahaan</label>
            <input type="text" class="form-control" name="kd_perusahaan" id="kd_perusahaan" value="<?= $kd_perusahaan ?>" readonly>
            <div class="invalid-feedback errorKd_perusahaan">
            </div>
          </div>
          <div class="col-md-6">
            <label for="nama" class="form-label mb-1">Nama Perusahaan</label>
            <input type="text" class="form-control" name="nm_perusahaan" id="nm_perusahaan" value="<?= $nm_perusahaan ?>" readonly>
          </div>
          <div class="col-md-12">
            <label for="nama" class="form-label mb-1">Alamat</label>
            <textarea class="form-control" name="alamat" id="alamat" readonly><?= $alamat ?></textarea>
          </div>
        </div>
        <div class="row g-3 mb-2">
          <div class="col-md-6">
            <label for="nama" class="form-label mb-1">Telp</label>
            <input type="text" class="form-control" name="telp" id="telp" value="<?= $telp ?>" readonly>
          </div>
          <div class="col-md-6">
            <label for="nama" class="form-label mb-1">NPWP</label>
            <input type="text" class="form-control" name="npwp" id="npwp" value="<?= $npwp ?>" readonly>
          </div>
        </div>
        <div class="row g-3 mb-2">
          <div class="col-md-6">
            <label for="nama" class="form-label mb-1">Pejabat (1)</label>
            <input type="text" class="form-control" name="pejabat_1" id="pejabat_1" value="<?= $pejabat_1 ?>" readonly>
          </div>
          <div class="col-md-6">
            <label for="nama" class="form-label mb-1">Pejabat (2)</label>
            <input type="text" class="form-control" name="pejabat_2" id="pejabat_2" value="<?= $pejabat_2 ?>" readonly>
          </div>
        </div>
        <div class="row g-3 mb-2">
          <div class="col-md-6">
            <label for="logo" class="col-sm-2 col-form-label">Logo</label>
            <div class="col-sm-2">
              <img src="/img/<?= $logo ?>" class="img-thumbnail img-preview">
            </div>
          </div>
          <div class="col">
            <label for="nama" class="form-label mb-1">Aktif</label><br>
            <?php
            if ($aktif == 'Y') {
              // echo "<tr><td>Aktif</td>     <td> : <input type=radio name='aktif' value='Y' checked> Y  
              // 						  <input type=radio name='aktif' value='N'> N </td></tr></table>";
              echo '<div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="aktif" name="aktif" checked disabled>
                  </div>';
            } else {
              // echo "<tr><td>Aktif</td>     <td> : <input type=radio name='aktif' value='Y'> Y 
              // 						  <input type=radio name='aktif' value='N' checked> N </td></tr></table>";
              echo '<div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="aktif" name="aktif" disabled>
                  </div>';
            }
            ?>
          </div>
        </div>
        <div class="row g-3 mb-2">
          <div class="col-md-12">
            <label for="nama" class="form-label mb-1">User : <?= $user ?></label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        <?= form_close() ?>
      </div>
    </div>
  </div>