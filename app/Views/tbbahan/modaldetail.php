<!-- Modal -->
<div class="modal fade" id="modaldetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 80%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('tbbahan/updatedata', ['class' => 'formtbagama']) ?>
      <div class="modal-body">
        <div class="row">
          <div class="col-12 col-sm-6">
            <label for="kode" class="form-label mb-1">Kode</label>
            <input type="text" class="form-control" name="kode" id="kode" value="<?= $tbbahan['kode'] ?>" readonly>
            <div class="invalid-feedback errorKode">
            </div>
            <label for="nama" class="form-label mb-1">Nama</label>
            <input type="text" class="form-control mb-2" name="nama" id="nama" value="<?= $tbbahan['nama'] ?>" readonly>
            <div class="invalid-feedback errorNama">
            </div>
            <label for="nama" class="form-label mb-1">Buatan</label>
            <input type="text" class="form-control mb-2" name="nama" id="nama" value="<?= $tbbahan['kdnegara'] ?>" readonly>
            <div class="invalid-feedback errorNama">
            </div>
            <label for="nama" class="form-label mb-1">Lokasi</label>
            <input type="text" class="form-control mb-2" name="nama" id="nama" value="<?= $tbbahan['lokasi'] ?>" readonly>
            <div class="invalid-feedback errorNama">
            </div>
            <label for="nama" class="form-label mb-1">Merek</label>
            <input type="text" class="form-control mb-2" name="nama" id="nama" value="<?= $tbbahan['merek'] ?>" readonly>
            <div class="invalid-feedback errorNama">
            </div>
            <label for="nama" class="form-label mb-1">Jenis</label>
            <input type="text" class="form-control mb-2" name="nama" id="nama" value="<?= $tbbahan['kdjnbrg'] ?>" readonly>
            <div class="invalid-feedback errorNama">
            </div>
            <label for="nama" class="form-label mb-1">Satuan</label>
            <input type="text" class="form-control mb-2" name="nama" id="nama" value="<?= $tbbahan['kdsatuan'] ?>" readonly>
            <div class="invalid-feedback errorNama">
            </div>
            <label for="nama" class="form-label mb-1">Perputaran bahan</label>
            <input type="text" class="form-control mb-2" name="nama" id="nama" value="<?= $tbbahan['kdmove'] ?>" readonly>
            <div class="invalid-feedback errorNama">
            </div>
            <label for="nama" class="form-label mb-1">Discount</label>
            <input type="text" class="form-control mb-2" name="nama" id="nama" value="<?= $tbbahan['kddiscount'] ?>" readonly>
            <div class="invalid-feedback errorNama">
            </div>
          </div>
          <div class="col-12 col-sm-6">
            <label for="" class="form-label mb-1">Harga Jual</label>
            <input type="number" class="form-control" name="harga_jual" id="harga_jual" value="<?= $tbbahan['harga_jual'] ?>" readonly>
            <label for="" class="form-label mb-1">Harga Beli</label>
            <input type="number" class="form-control" name="harga_beli" id="harga_beli" value="<?= $tbbahan['harga_beli'] ?>" readonly>
            <label for="" class="form-label mb-1">Harga Beli Lama</label>
            <input type="number" class="form-control" name="harga_beli_lama" id="harga_beli_lama" value="<?= $tbbahan['harga_beli_lama'] ?>" readonly>
            <label for="" class="form-label mb-1">HPP</label>
            <input type="number" class="form-control" name="hpp" id="hpp" value="<?= $tbbahan['hpp'] ?>" readonly>
            <label for="" class="form-label mb-1">HPP Lama</label>
            <input type="number" class="form-control" name="hpp_lama" id="hpp_lama" value="<?= $tbbahan['hpp_lama'] ?>" readonly>
            <label for="" class="form-label mb-1">Stock</label>
            <input type="number" class="form-control" name="stock" id="stock" value="<?= $tbbahan['stock'] ?>" readonly>
            <label for="" class="form-label mb-1">Stock Min</label>
            <input type="number" class="form-control" name="stock_min" id="stock_min" value="<?= $tbbahan['stock_min'] ?>" readonly>
            <label for="" class="form-label mb-1">Stock Mak</label>
            <input type="number" class="form-control" name="stock_mak" id="stock_mak" value="<?= $tbbahan['stock_mak'] ?>" readonly>
            <label for="nama" class="form-label mb-1">Aktif</label><br>
            <?php
            if ($tbbahan['aktif'] == 'Y') {
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