<!-- Modal -->
<div class="modal fade" id="modaldetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 80%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('tbagama/updatedata', ['class' => 'formtbagama']) ?>
      <div class="modal-body">
        <div class="row">
          <div class="col-12 col-sm-6">
            <label for="kode" class="form-label mb-1">Kode</label>
            <input type="text" class="form-control" name="kode" id="kode" value="<?= $tbbarang['kode'] ?>" readonly>
            <label for="nama" class="form-label mb-1">Nama</label>
            <input type="text" class="form-control mb-2" name="nama" id="nama" value="<?= $tbbarang['nama'] ?>" readonly>
            <label for="nama" class="form-label mb-1">Buatan</label>
            <input type="text" class="form-control mb-2" name="nama" id="nama" value="<?= $tbbarang['kdnegara'] ?>" readonly>
            <label for="nama" class="form-label mb-1">Lokasi</label>
            <input type="text" class="form-control mb-2" name="nama" id="nama" value="<?= $tbbarang['lokasi'] ?>" readonly>
            <label for="nama" class="form-label mb-1">Merek</label>
            <input type="text" class="form-control mb-2" name="nama" id="nama" value="<?= $tbbarang['merek'] ?>" readonly>
            <label for="nama" class="form-label mb-1">Jenis</label>
            <input type="text" class="form-control mb-2" name="nama" id="nama" value="<?= $tbbarang['kdjnbrg'] ?>" readonly>
            <label for="nama" class="form-label mb-1">Satuan</label>
            <input type="text" class="form-control mb-2" name="nama" id="nama" value="<?= $tbbarang['kdsatuan'] ?>" readonly>
            <label for="nama" class="form-label mb-1">Perputaran Barang</label>
            <input type="text" class="form-control mb-2" name="nama" id="nama" value="<?= $tbbarang['kdmove'] ?>" readonly>
            <label for="nama" class="form-label mb-1">Discount <?= $tbdisc['disc_normal'] ?> %</label>
            <input type="text" class="form-control mb-2" name="nama" id="kddisc" value="<?= $tbbarang['kddiscount'] ?>" readonly>
          </div>
          <div class="col-12 col-sm-6">
            <label for="" class="form-label mb-1">Harga Jual</label>
            <input type="number" class="form-control" name="harga_jual" id="harga_jual" value="<?= $tbbarang['harga_jual'] ?>" readonly>
            <label for="" class="form-label mb-1">Harga Beli</label>
            <input type="number" class="form-control" name="harga_beli" id="harga_beli" value="<?= $tbbarang['harga_beli'] ?>" readonly>
            <label for="" class="form-label mb-1">Harga Beli Lama</label>
            <input type="number" class="form-control" name="harga_beli_lama" id="harga_beli_lama" value="<?= $tbbarang['harga_beli_lama'] ?>" readonly>
            <label for="" class="form-label mb-1">HPP</label>
            <input type="number" class="form-control" name="hpp" id="hpp" value="<?= $tbbarang['hpp'] ?>" readonly>
            <label for="" class="form-label mb-1">HPP Lama</label>
            <input type="number" class="form-control" name="hpp_lama" id="hpp_lama" value="<?= $tbbarang['hpp_lama'] ?>" readonly>
            <label for="" class="form-label mb-1">Stock</label>
            <input type="number" class="form-control" name="stock" id="stock" value="<?= $tbbarang['stock'] ?>" readonly>
            <label for="" class="form-label mb-1">Stock Min</label>
            <input type="number" class="form-control" name="stock_min" id="stock_min" value="<?= $tbbarang['stock_min'] ?>" readonly>
            <label for="" class="form-label mb-1">Stock Mak</label>
            <input type="number" class="form-control" name="stock_mak" id="stock_mak" value="<?= $tbbarang['stock_mak'] ?>" readonly>
            <label for="nama" class="form-label mb-1">Aktif</label><br>
            <?php
            if ($tbbarang['aktif'] == 'Y') {
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

<script>
  $(document).ready(function() {
    let cari = document.getElementById('kddisc').value();
    alert(cari);
    if (cari !== "") {
      $.ajax({
        url: "<?= site_url('tbbarang/repldiscount') ?>",
        type: 'post',
        data: {
          'kddiscount': cari
        },
        success: function(data) {
          let data_response = JSON.parse(data);
          if (data_response['kode'] == '') {
            $('#discount').html('');
            return;
          } else {
            $('#discount').html(data_response['disc_normal']);
            // alert(data_response['kode']);
          }
        },
        error: function() {
          $('#discount').html('');
          return;
          // console.log('file not fount');
        }
      })
      // console.log(cari);
    }
  })
</script>