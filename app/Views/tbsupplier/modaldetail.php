<!-- Modal -->
<div class="modal fade" id="modaldetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 90%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action='tbsupplier/updatedata' method='post' enctype='multipart/form-data' class='formtbsupplier'>
        <div class="modal-body">
          <div class="row mb-2">
            <div class="col-12 col-sm-6">
              <label for="nama" class="form-label mb-1">Kode</label>
              <input type='text' class='form-control mb-2' name='kode' id='kode' size='10' value="<?= $tbsupplier['kode'] ?>" autofocus='autofocus' readonly>
              <div class="invalid-feedback errorKode">
              </div>
              <label for="nama" class="form-label mb-1">Kelompok</label>
              <input type='text' class='form-control mb-2' name='nama' id='nama' value="<?= $tbsupplier['kelompok'] ?>" readonly>
              <label for="nama" class="form-label mb-1">Nama</label>
              <input type='text' class='form-control mb-2' name='nama' id='nama' value="<?= $tbsupplier['nama'] ?>" readonly>
              <div class="invalid-feedback errorNama">
              </div>
              <label for="nama" class="form-label mb-1">Alamat</label>
              <textarea rows='2' class='form-control' name='alamat' id='alamat' readonly><?= $tbsupplier['alamat'] ?></textarea>
              <label for="nama" class="form-label mb-1">Kelurahan</label>
              <input type='text' class='form-control mb-2' name='kelurahan' id='kelurahan' value="<?= $tbsupplier['kelurahan'] ?>" readonly>
              <label for="nama" class="form-label mb-1">Kecamatan</label>
              <input type='text' class='form-control mb-2' name='kecamatan' id='kecamatan' value="<?= $tbsupplier['kecamatan'] ?>" readonly>
              <label for="nama" class="form-label mb-1">Kota</label>
              <input type='text' class='form-control mb-2' name='kota' id='kota' value="<?= $tbsupplier['kota'] ?>" readonly>
              <label for="nama" class="form-label mb-1">Kode Pos</label>
              <input type='text' class='form-control' name='kodepos' id='kodepos' value="<?= $tbsupplier['kodepos'] ?>" readonly>
              <label for="nama" class="form-label mb-1">Telp</label>
              <input type='text' class='form-control mb-2' name='telp' value="<?= $tbsupplier['telp'] ?>" readonly>
            </div>
            <div class="col-12 col-sm-6">
              <div class="col">
                <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
                  <tr>
                    <td>Contact Person</td>
                    <td> <input type='text' class='form-control' name='contact_person' id='contact_person' value="<?= $tbsupplier['contact_person'] ?>" readonly></td>
                  </tr>
                  <tr>
                    <td>No. Telp CP</td>
                    <td> <input type='text' class='form-control' name='no_contact_person' id='no_contact_person' value="<?= $tbsupplier['no_contact_person'] ?>" readonly></td>
                  </tr>
                  <tr>
                    <td>NPWP</td>
                    <td> <input type='text' class='form-control' name='npwp' value="<?= $tbsupplier['npwp'] ?>" readonly></td>
                  </tr>
                  <tr>
                    <td>Nama NPWP<br><input button type='Button' class='btn btn-success btn-sm' value='Salin' onClick='salin_alamat_npwp()' disabled></td>
                    <td> <input type='text' class='form-control' name='nama_npwp' id='nama_npwp' value="<?= $tbsupplier['nama_npwp'] ?>" readonly></td>
                  </tr>
                  <tr>
                    <td>Alamat NPWP</td>
                    <td> <textarea rows='3' class='form-control' name='alamat_npwp' id='alamat_npwp' readonly><?= $tbsupplier['alamat_npwp'] ?></textarea></td>
                  </tr>
                  <tr>
                    <td>Maksimum Hutang</td>
                    <td> <input type='number' class='form-control' name='mak_hutang' value="<?= $tbsupplier['mak_hutang'] ?>" readonly></td>
                  </tr>
                </table>
                <div class="col-md-12 mb-2">
                  <label for="nama" class="form-label mb-1">Aktif</label><br>
                  <?php
                  if ($tbsupplier['aktif'] == 'Y') {
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