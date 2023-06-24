<!-- Modal -->
<div class="modal fade" id="modaldetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 80%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('tbmodel/updatedata', ['class' => 'formtbmodel']) ?>
      <div class="modal-body">
        <div class="row mb-2">
          <div class="col-12 col-sm-6">
            <label for="kode" class="form-label mb-0">No. Polisi</label>
            <input type="text" class="form-control mb-1" name="nopolisi" id="nopolisi" value="<?= $tbmobil['nopolisi'] ?>" readonly>
            <div class="invalid-feedback errorNopolisi">
            </div>
            <label for="nama" class="form-label mb-0">No. Rangka</label>
            <input type="text" class="form-control mb-1" name="norangka" id="norangka" value="<?= $tbmobil['norangka'] ?>" readonly>
            <label for="nama" class="form-label mb-0">No. Mesin</label>
            <input type="text" class="form-control mb-1" name="nomesin" id="nomesin" value="<?= $tbmobil['nomesin'] ?>" readonly>
            <label for="nama" class="form-label mb-0">Merek</label>

            <label for="nama" class="form-label mb-1">Merek</label>
            <select class="form-select" name="kdmerek" id="kdmerek" disabled>
              <option value="">[Pilih Merek]
                <?php
                foreach ($tbmerek as $key) {
                  if ($key['kode'] == $tbmobil['kdmerek']) {
                    echo "<option value='$key[kode]' selected>$key[kode] - $key[nama]</option>";
                  } else {
                    echo "<option value='$key[kode]'>$key[kode] - $key[nama]</option>";
                  }
                }
                ?>
              </option>
            </select>
            <label for="nama" class="form-label mb-0 labelmodel">Model</label>
            <select class="form-select mb-1" name="kdmodel" id="kdmodel" disabled>
              <option value="">[Pilih Model]
                <?php
                foreach ($tbmodel as $key) {
                  if ($key['kode'] == $tbmobil['kdmodel']) {
                    echo "<option value='$key[kode]' selected>$key[kode] - $key[nama]</option>";
                  } else {
                    echo "<option value='$key[kode]'>$key[kode] - $key[nama]</option>";
                  }
                }
                ?>
              </option>
            </select>
            <label for="nama" class="form-label mb-0 labeltipe">Tipe</label>
            <select class="form-select mb-1" name="kdtipe" id="kdtipe" disabled>
              <?php
              foreach ($tbtipe as $key) {
                if ($key['kode'] == $tbmobil['kdtipe']) {
                  echo "<option value='$key[kode]' selected>$key[kode] - $key[nama]</option>";
                } else {
                  echo "<option value='$key[kode]'>$key[kode] - $key[nama]</option>";
                }
              }
              ?>
              </option>
            </select>
            <label for="nama" class="form-label mb-0 labeltipe">Warna</label>
            <select class="form-select mb-1" name="kdwarna" id="kdwarna" disabled>
              <option value="">[Pilih Warna]
                <?php
                foreach ($tbwarna as $key) {
                  if ($key['kode'] == $tbmobil['kdwarna']) {
                    echo "<option value='$key[kode]' selected>$key[kode] - $key[nama]</option>";
                  } else {
                    echo "<option value='$key[kode]'>$key[kode] - $key[nama]</option>";
                  }
                }
                ?>
              </option>
            </select>
            <label for="nama" class="form-label mb-0 labeltipe">Jenis</label>
            <select class="form-select mb-1" name="kdjenis" id="kdjenis" disabled>
              <?php
              foreach ($tbjenis as $key) {
                if ($key['kode'] == $tbmobil['kdjenis']) {
                  echo "<option value='$key[kode]' selected>$key[kode] - $key[nama]</option>";
                } else {
                  echo "<option value='$key[kode]'>$key[kode] - $key[nama]</option>";
                }
              }
              ?>
              </option>
            </select>
          </div>
          <div class="col-12 col-sm-6">
            <div class="input-group">
              <div class="col-md-8">
                <label for="nama" class="form-label mb-0">No. STNK</label>
                <input type="text" class="form-control mb-1" name="nostnk" id="nostnk" value="<?= $tbmobil['nostnk'] ?>" readonly>
              </div>
              <div class="col-md-4">
                <label for="nama" class="form-label mb-0">Tgl. STNK</label>
                <input type="date" class="form-control mb-1" name="tglstnk" id="tglstnk" value="<?= $tbmobil['tglstnk'] ?>" readonly>
              </div>
            </div>
            <label for="nama" class="form-label mb-0">Bahan Bakar</label>
            <input type="text" class="form-control mb-1" name="bahanbakar" id="bahanbakar" value="<?= $tbmobil['bahanbakar'] ?>" readonly>
            <label for="nama" class="form-label mb-0">Dealer Penjualan</label>
            <input type="text" class="form-control mb-1" name="dealerjual" id="dealerjual" value="<?= $tbmobil['dealerjual'] ?>" readonly>
            <label for="nama" class="form-label mb-0">Pemilik</label>
            <div class="input-group">
              <div class="col-md-4">
                <input type="text" class="form-control mb-1" name="kdpemilik" id="kdpemilik" value="<?= $tbmobil['kdpemilik'] ?>" readonly>
              </div>
              <div class="col-md-8">
                <input type="text" class="form-control mb-1" name="nmpemilik" id="nmpemilik" value="<?= $tbmobil['nmpemilik'] ?>" readonly>
              </div>
            </div>
            <label for="nama" class="form-label mb-0">NPWP</label>
            <input type="text" class="form-control" name="npwp" id="npwp" value="<?= $tbmobil['npwp'] ?>" readonly>
            <label for="nama" class="form-label mb-0">Contact Person</label>
            <input type="text" class="form-control" name="contact_person" id="contact_person" value="<?= $tbmobil['contact_person'] ?>" readonly>
            <label for="nama" class="form-label mb-0">No. Contact Person</label>
            <input type="text" class="form-control" name="no_contact_person" id="no_contact_person" value="<?= $tbmobil['no_contact_person'] ?>" readonly>
            <label for="nama" class="form-label mb-0">Pemakai</label>
            <div class="input-group">
              <div class="col-md-4">
                <input type="text" class="form-control mb-1" name="kdpemakai" id="kdpemakai" value="<?= $tbmobil['kdpemakai'] ?>" readonly>
              </div>
              <div class="col-md-8">
                <input type="text" class="form-control mb-1" name="nmpemilik" id="nmpemilik" value="<?= $tbmobil['nmpemakai'] ?>" readonly>
              </div>
            </div>
            NPWP <input type="text" class="form-control" name="npwp" id="npwp" value="<?= $tbmobil['npwp'] ?>" readonly>
            Contact Person <input type="text" class="form-control" name="contact_person" id="contact_person" value="<?= $tbmobil['contact_person'] ?>" readonly>
            No. Contact Person <input type="text" class="form-control" name="no_contact_person" id="no_contact_person" value="<?= $tbmobil['no_contact_person'] ?>" readonly>
            <label for="keluhan" class="form-label mb-1">Asuransi</label>
            <div class="input-group mb-1">
              <input type="text" class="form-control form-control-sm" name="kode_asuransi" id="kode_asuransi" value="<?= $tbmobil['kode_asuransi'] ?>" readonly>
              <input type="text" style="width: 40%" class="form-control form-control-sm" name="nama_asuransi" id="nama_asuransi" value="<?= $tbmobil['nama_asuransi'] ?>" readonly>
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