<!-- Modal -->
<div class="modal fade" id="modaldetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 90%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action='tbleasing/updatedata' method='post' enctype='multipart/form-data' class='formtbleasing'>
        <div class="modal-body">
          <div class="row mb-2">
            <div class="col-12 col-sm-6">
              <label for="nama" class="form-label mb-1">Kode</label>
              <input type='text' class='form-control mb-2' name='kode' id='kode' size='10' value="<?= $tbleasing['kode'] ?>" autofocus='autofocus' readonly>
              <div class="invalid-feedback errorKode">
              </div>
              <label for="nama" class="form-label mb-1">Nama</label>
              <input type='text' class='form-control mb-2' name='nama' id='nama' value="<?= $tbleasing['nama'] ?>" readonly>
              <div class="invalid-feedback errorNama">
              </div>
              <label for="nama" class="form-label mb-1">Alamat</label>
              <textarea rows='2' class='form-control' name='alamat' id='alamat' readonly><?= $tbleasing['alamat'] ?></textarea>
              <label for="nama" class="form-label mb-1">Kota</label>
              <input type='text' class='form-control mb-2' name='kota' id='kota' value="<?= $tbleasing['kota'] ?>" readonly>
              <label for="nama" class="form-label mb-1">Telp</label>
              <input type='text' class='form-control mb-2' name='telp' value="<?= $tbleasing['telp'] ?>" readonly>
              <label for="nama" class="form-label mb-1">Fax</label>
              <input type='text' class='form-control mb-2' name='fax' value="<?= $tbleasing['fax'] ?>" readonly>
              <label for="nama" class="form-label mb-1">Email</label>
              <input type='email' class='form-control mb-2' name='email' value="<?= $tbleasing['email'] ?>" readonly>
              Contact Person
              <input type='text' class='form-control mb-2' name='contact_person' id='contact_person' value="<?= $tbleasing['contact_person'] ?>" readonly>
              No. Telp CP
              <input type='text' class='form-control' name='no_contact_person' value="<?= $tbleasing['no_contact_person'] ?>" readonly>
            </div>
            <div class="col-12 col-sm-6">
              <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
                <tr>
                  <td>NPWP</td>
                  <td> <input type='text' class='form-control' name='npwp' value="<?= $tbleasing['npwp'] ?>" readonly></td>
                </tr>
                <tr>
                  <td>Nama NPWP<br>
                  <td> <input type='text' class='form-control' name='nama_npwp' id='nama_npwp' value="<?= $tbleasing['nama_npwp'] ?>" readonly></td>
                </tr>
                <tr>
                  <td>NPPKP</td>
                  <td> <input type='text' class='form-control' name='nppkp' value="<?= $tbleasing['nppkp'] ?>" readonly></td>
                </tr>
                <tr>
                  <td>Temp Of Payment (TOP)</td>
                  <td> <input type='text' class='form-control' name='top' value="<?= $tbleasing['top'] ?>" readonly></td>
                </tr>
                <tr>
                  <td>Discount Part</td>
                  <td> <input type='number' class='form-control' name='disc_part' value="<?= $tbleasing['disc_part'] ?>" readonly></td>
                </tr>
                <tr>
                  <td>Discount Jasa</td>
                  <td> <input type='number' class='form-control' name='disc_jasa' value="<?= $tbleasing['disc_jasa'] ?>" readonly></td>
                </tr>
                <tr>
                  <td>Discount Bahan</td>
                  <td> <input type='number' class='form-control' name='disc_bahan' value="<?= $tbleasing['disc_bahan'] ?>" readonly></td>
                </tr>
                <tr>
                  <td>PPH Jasa</td>
                  <td> <input type='number' class='form-control' name='pph_jasa' value="<?= $tbleasing['pph_jasa'] ?>" readonly></td>
                </tr>
                <tr>
                  <td>PPH Material</td>
                  <td> <input type='number' class='form-control' name='pph_material' value="<?= $tbleasing['pph_material'] ?>" readonly></td>
                </tr>
                <tr>
                  <td>Kredit Limit</td>
                  <td> <input type='number' class='form-control' name='kredit_limit' value="<?= $tbleasing['kredit_limit'] ?>" readonly></td>
                </tr>
              </table>
              <div class="col-md-12 mb-2">
                <label for="nama" class="form-label mb-1">Aktif</label><br>
                <?php
                if ($tbleasing['aktif'] == 'Y') {
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
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
          <?= form_close() ?>
        </div>
    </div>
  </div>