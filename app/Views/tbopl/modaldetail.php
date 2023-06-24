<!-- Modal -->
<div class="modal fade" id="modaldetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 50%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('tbopl/updatedata', ['class' => 'formtbopl']) ?>
      <input type="hidden" class="form-control" name="id" id="id" value="<?= $tbopl['id'] ?>">
      <input type="hidden" class="form-control" name="kodelama" id="kodelama" value="<?= $tbopl['kode'] ?>">
      <div class="modal-body">
        <div class="row">
          <div class="col-12 col-sm-12">
            <label for="kode" class="form-label mb-1">Kode</label>
            <input type="text" class="form-control mb-2" name="kode" id="kode" value="<?= $tbopl['kode'] ?>" readonly>
            <div class="invalid-feedback errorKode">
            </div>
            <label for="nama" class="form-label mb-1">Nama</label>
            <input type="text" class="form-control mb-2" name="nama" id="nama" value="<?= $tbopl['nama'] ?>" readonly>
            <div class="invalid-feedback errorNama">
            </div>
            Supplier
            <div class="input-group mb-2">
              <?php
              if ($tbsupplier) {
                $nmsupplier = $tbsupplier['nama'];
              } else {
                $nmsupplier = '';
              }
              ?>
              <input type="text" style="width:5%;" name="kdsupplier" id="kdsupplier" class="form-control" placeholder="Kd. Supplier" value="<?= $tbopl['kdsupplier'] ?>" readonly>
              <input type="text" style="width:50%;" name="nmsupplier" id="nmsupplier" class="form-control" placeholder="Supplier" value="<?= $nmsupplier ?>" readonly>
              <!-- <button class="btn btn-outline-secondary" type="button" id="carisupplier"><i class="fa fa-search"></i></button>
              <button class="btn btn-outline-primary tambahtbsupplier" type="button"><i class="fa fa-plus"></i></button> -->
            </div>
            <label for="" class="form-label mb-1">Harga Beli</label>
            <input type="number" class="form-control mb-2" name="harga_beli" id="harga_beli" value="<?= $tbopl['harga_beli'] ?>" readonly>
            <label for="" class="form-label mb-1">Harga Jual</label>
            <input type="number" class="form-control mb-2" name="harga_jual" id="harga_jual" value="<?= $tbopl['harga_jual'] ?>" readonly>
          </div>
        </div>
        <label for="nama" class="form-label mb-1">Aktif</label><br>
        <?php
        if ($tbopl['aktif'] == 'Y') {
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