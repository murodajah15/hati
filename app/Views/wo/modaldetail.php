<!-- Modal -->
<div class="modal fade" id="modaldetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 90%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('tbcustomer/detaildata', ['class' => 'formtbcustomer']) ?>
      <input type="hidden" name="id" id="id" value="<?= $tbcustomer['id'] ?>">
      <input type="hidden" name="kodelama" id="kodelama" value="<?= $tbcustomer['kode'] ?>">
      <div class="modal-body">
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a href="#home" class="nav-link active" data-bs-toggle="tab">Data</a>
          </li>
          <li class="nav-item">
            <a href="#profile" class="nav-link" data-bs-toggle="tab">Alamat</a>
          </li>
          <!-- <li class="nav-item">
              <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
            </li> -->
        </ul>
        <div class="tab-content">
          <div class="tab-pane fade show active" id="home">
            <br>
            <div class="row mb-2">
              <div class="col-12 col-sm-6">
                <label for="nama" class="form-label mb-1">Kode</label>
                <input type='text' class='form-control mb-2' name='kode' id='kode' size='10' value="<?= $tbcustomer['kode'] ?>" readonly>
                <div class="invalid-feedback errorKode">
                </div>
                <label for="nama" class="form-label mb-1">Kelompok</label>
                <input type='text' class='form-control' name='kodepos' id='kodepos' value="<?= $tbcustomer['kelompok'] ?>" readonly>
                <label for="nama" class="form-label mb-1">Nama</label>
                <input type='text' class='form-control mb-2' name='nama' id='nama' value="<?= $tbcustomer['nama'] ?>" readonly>
                <div class="invalid-feedback errorNama">
                </div>
                <label for="nama" class="form-label mb-1">Alamat</label>
                <textarea rows='2' class='form-control' name='alamat' id='alamat' readonly><?= $tbcustomer['alamat'] ?></textarea>
                <label for="nama" class="form-label mb-1">Kota</label>
                <input type='text' class='form-control mb-2' name='kota' id='kota' value="<?= $tbcustomer['kota'] ?>" readonly>
                <label for="nama" class="form-label mb-1">Kode Pos</label>
                <input type='text' class='form-control' name='kodepos' id='kodepos' value="<?= $tbcustomer['kodepos'] ?>" readonly>
              </div>
              <div class="col-12 col-sm-6">
                <label for="nama" class="form-label mb-1">Agama</label>
                <input type='text' class='form-control' name='kodepos' id='kodepos' value="<?= $tbcustomer['agama'] ?>" readonly>
                <label for="nama" class="form-label mb-1">Telp</label>
                <input type='text' class='form-control' name='telp1' value="<?= $tbcustomer['telp1'] ?>">
                <input type='text' class='form-control mb-2' name='telp2' value="<?= $tbcustomer['telp2'] ?>" readonly>
                <label for="nama" class="form-label mb-1">Tanggal Lahir (M-D-Y)</label>
                <input type='date' class='form-control mb-2' name='tgl_lahir' value="<?= $tbcustomer['tgl_lahir'] ?>" readonly>
                <label for="nama" class="form-label mb-1">Alamat KTP</label>
                <textarea rows='3' class='form-control mb-2' name='alamat_ktp' id='alamat_ktp' readonly><?= $tbcustomer['alamat_ktp'] ?></textarea>
                <label for="nama" class="form-label mb-1">Kota KTP</label>
                <input type='text' class='form-control mb-2' name='kota_ktp' id='kota_ktp' value="<?= $tbcustomer['kota_ktp'] ?>" readonly>
                <label for="nama" class="form-label mb-1">Kode Pos KPT</label>
                <input type='text' class='form-control' name='kodepos_ktp' id='kodepos_ktp' value="<?= $tbcustomer['kodepos_ktp'] ?>" readonly>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="profile">
            <br>
            <div class="row g-3 mb-2">
              <div class="col">
                <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
                  <tr>
                    <td>Alamat Kantor</td>
                    <td> <textarea rows='3' class='form-control' name='alamat_ktr' id='alamat_ktr' readonly><?= $tbcustomer['alamat_ktr'] ?></textarea></td>
                  </tr>
                  <tr>
                    <td>Kota Kantor</td>
                    <td> <input type='text' class='form-control' name='kota_ktr' id='kota_ktr' value="<?= $tbcustomer['kota_ktr'] ?>" readonly></td>
                  </tr>
                  <tr>
                    <td>Kode Pos Kantor</td>
                    <td> <input type='text' class='form-control' name='kodepos_ktr' id='kodepos_ktr' value="<?= $tbcustomer['kodepos_ktr'] ?>" readonly></td>
                  </tr>
                  <tr>
                    <td>Telp Kantor</td>
                    <td> <input type='text' class='form-control' name='telp1_ktr' value="<?= $tbcustomer['telp1_ktr'] ?>" readonly></td>
                  </tr>
                  <tr>
                    <td>
                    <td> <input type='text' class='form-control' name='telp2_ktr' value="<?= $tbcustomer['telp2_ktr'] ?>" readonly></td>
                  </tr>
                </table>
              </div>
              <div class="col">
                <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
                  <tr>
                    <td>NPWP</td>
                    <td> <input type='text' class='form-control' name='npwp' value="<?= $tbcustomer['npwp'] ?>" readonly></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td> <input type='text' class='form-control' name='nama_npwp' id='nama_npwp' value="<?= $tbcustomer['nama_npwp'] ?>" readonly></td>
                  </tr>
                  <tr>
                    <td>Alamat NPWP</td>
                    <td> <textarea rows='3' class='form-control' name='alamat_npwp' id='alamat_npwp' readonly><?= $tbcustomer['alamat_npwp'] ?></textarea></td>
                  </tr>
                  <tr>
                    <td>Maksimum Piutang</td>
                    <td> <input type='number' class='form-control' name='mak_piutang' value="<?= $tbcustomer['mak_piutang'] ?>" readonly></td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="disabled">
            <p>Messages tab content ...</p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        <?= form_close() ?>
      </div>
    </div>
  </div>