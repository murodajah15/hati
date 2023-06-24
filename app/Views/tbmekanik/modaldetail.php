<!-- Modal -->
<div class="modal fade" id="modaldetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 90%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('tbmekanik/detaildata', ['class' => 'formtbmekanik']) ?>
      <input type="hidden" name="id" id="id" value="<?= $tbmekanik['id'] ?>">
      <input type="hidden" name="kodelama" id="kodelama" value="<?= $tbmekanik['kode'] ?>">
      <div class="modal-body">
        <div class="row mb-2">
          <div class="col-12 col-sm-6">
            <label for="nama" class="form-label mb-1">Kode</label>
            <input type='text' class='form-control form-control-sm mb-2' name='kode' id='kode' size='10' value="<?= $tbmekanik['kode'] ?>" readonly>
            <div class="invalid-feedback errorKode">
            </div>
            <label for="nama" class="form-label mb-1">Kode H3S</label>
            <input type='text' class='form-control form-control-sm mb-2' name='kode_h3s' id='kode_h3s' value="<?= $tbmekanik['kode_h3s'] ?>" readonly>
            <label for="nama" class="form-label mb-1">Nama</label>
            <input type='text' class='form-control form-control-sm mb-2' name='nama' id='nama' value="<?= $tbmekanik['nama'] ?>" readonly>
            <div class="invalid-feedback errorNama">
            </div>
            <label for="nama" class="form-label mb-1">Alamat</label>
            <textarea rows='2' class='form-control form-control-sm' name='alamat' id='alamat' readonly><?= $tbmekanik['alamat'] ?></textarea>
            <label for="nama" class="form-label mb-1">Kelurahan</label>
            <input type='text' class='form-control form-control-sm mb-2' name='kelurahan' id='kelurahan' value="<?= $tbmekanik['kelurahan'] ?>" readonly>
            <label for="nama" class="form-label mb-1">Kecamatan</label>
            <input type='text' class='form-control form-control-sm mb-2' name='kecamatan' id='kecamatan' value="<?= $tbmekanik['kecamatan'] ?>" readonly>
          </div>
          <div class="col-12 col-sm-6">
            <label for="nama" class="form-label mb-1">Kota</label>
            <input type='text' class='form-control form-control-sm mb-2' name='kota' id='kota' value="<?= $tbmekanik['kota'] ?>" readonly>
            <label for="nama" class="form-label mb-1">Provinsi</label>
            <input type='text' class='form-control form-control-sm mb-2' name='provinsi' id='provinsi' value="<?= $tbmekanik['provinsi'] ?>" readonly>
            <label for="nama" class="form-label mb-1">Kode Pos</label>
            <input type='text' class='form-control form-control-sm mb-2' name='kodepos' id='kodepos' value="<?= $tbmekanik['kodepos'] ?>" readonly>
            <label for="nama" class="form-label mb-1">Telp</label>
            <input type='text' class='form-control form-control-sm mb-2' name='telp1' value="<?= $tbmekanik['telp1'] ?>" readonly>
            <label for="nama" class="form-label mb-1">Kategori</label>
            <input type='text' class='form-control form-control-sm mb-2' name='kategori' id='kategori' value="<?= $tbmekanik['kategori'] ?>" readonly>
            <label for="nama" class="form-label mb-1">Aktif</label><br>
            <?php
            if ($tbmekanik['aktif'] == 'Y') {
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
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        <?= form_close() ?>
      </div>
    </div>
  </div>