<?php
$session = session();
$nmform = [
  'form' => "edit",
];
$session->set($nmform);
?>

<?= 'test'; ?>

<script src="<?= base_url('/js/autoNumeric.js') ?>" crossorigin="anonymous"></script>

<!-- Modal -->
<div class="modal fade" id="modaledit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 90%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('memombr/updatedata', ['class' => 'formmemombr']) ?>
      <input type="hidden" class="form-control" name="id" id="id" value="<?= $memombr['id'] ?>">
      <div class="modal-body">
        <div class="row mb-2">
          <div class="col-12 col-sm-6">
            <div class="input-group">
              <div class="col-md-4">
                <label for="nama" class="form-label mb-1">No. Memo</label>
                <input type='text' class='form-control form-control-sm mb-2' id="nomemo" name="nomemo" value="<?= $memombr['nomemo'] ?>" readonly style="width: 100%">
              </div>
              <div class="col-md-4">
                <label for="nama" class="form-label mb-1">Nomor SPK</label>
                <input type="text" class="form-control form-control-sm mb-2" name="nospk" id="nospk" value="<?= $memombr['nospk'] ?>" autofocus>
              </div>
              <div class="col-md-4">
                <label for="nama" class="form-label mb-1">Tanggal (M-D-Y)</label>
                <input type="datetime-local" class='form-control form-control-sm mb-2' name='tanggal' id='tanggal' value="<?= $memombr['tanggal'] ?>" style="width: 100%">
              </div>
            </div>
            <div class="col-12 col-sm-12">
              <label for="nama" class="form-label mb-0"><b><u>Pemesan</u></b></label>
              <div class="col-md-12">
                <div class="input-group mb-2">
                  <input type="text" class="form-control" placeholder="Pemesan" name="kdcustomer" id="kdcustomer" value="<?= $memombr['kdcustomer'] ?>">
                  <button class="btn btn-outline-secondary btn-sm" type="button" id="caricustomer">Cari</button>
                  <input type="text" class="col-8" class="form-control" name="nmcustomer" id="nmcustomer" value="<?= $memombr['nmcustomer'] ?>" readonly>
                </div>
                <label for="nama" class="form-label mb-0">Alamat</label>
                <input type="text" class="form-control mb-1" name="alamat" id="alamat" value="<?= $memombr['alamat'] ?>" readonly>
                <label for="nama" class="form-label mb-0">Kelurahan</label>
                <input type="text" class="form-control mb-1" name="kelurahan" id="kelurahan" value="<?= $memombr['kelurahan'] ?>" readonly>
                <label for="nama" class="form-label mb-0">Kecamatan</label>
                <input type="text" class="form-control mb-1" name="kecamatan" id="kecamatan" value="<?= $memombr['kecamatan'] ?>" readonly>
                <label for="nama" class="form-label mb-0">Kota</label>
                <input type="text" class="form-control mb-1" name="kota" id="kota" value="<?= $memombr['kota'] ?>" readonly>
                <div class="input-group">
                  <div class="col-md-6">
                    <label for="nama" class="form-label mb-0">Provinsi</label>
                    <input type="text" class="form-control mb-1" name="provinsi" id="provinsi" value="<?= $memombr['provinsi'] ?>" readonly>
                  </div>
                  <div class="col-md-6">
                    <label for="nama" class="form-label mb-0">Kode Pos</label>
                    <input type="text" class="form-control mb-1" name="kodepos" id="kodepos" value="<?= $memombr['kodepos'] ?>" readonly>
                  </div>
                </div>
                <label for="nama" class="form-label mb-0">No. HP</label>
                <input type="text" class="form-control mb-1" name="nohp_customer" id="nohp_customer" value="<?= $memombr['nohp_customer'] ?>" readonly>
                <label for="nama" class="form-label mb-0">NIK</label>
                <input type="text" class="form-control mb-1" name="nik_customer" id="nik_customer" value="<?= $memombr['nik_customer'] ?>" readonly>
                <label for="nama" class="form-label mb-0"><b><u>STNK A/n</u></b></label>
                <div class="input-group mb-2">
                  <input type="text" class="form-control" placeholder="STNK a/n" name="kdcustomer_stnk" id="kdcustomer_stnk" value="<?= $memombr['kdcustomer_stnk'] ?>">
                  <button class="btn btn-outline-secondary btn-sm" type="button" id="caricustomer_stnk">Cari</button>
                  <input type="text" class="col-8" class="form-control" name="nmcustomer_stnk" id="nmcustomer_stnk" value="<?= $memombr['nmcustomer_stnk'] ?>" readonly>
                </div>
                <label for="nama" class="form-label mb-0">Alamat</label>
                <input type="text" class="form-control mb-1" name="alamat_stnk" id="alamat_stnk" value="<?= $memombr['alamat_stnk'] ?>" readonly>
                <label for="nama" class="form-label mb-0">Kelurahan</label>
                <input type="text" class="form-control mb-1" name="kelurahan_stnk" id="kelurahan_stnk" value="<?= $memombr['kelurahan_stnk'] ?>" readonly>
                <label for="nama" class="form-label mb-0">Kecamatan</label>
                <input type="text" class="form-control mb-1" name="kecamatan_stnk" id="kecamatan_stnk" value="<?= $memombr['kecamatan_stnk'] ?>" readonly>
                <label for="nama" class="form-label mb-0">Kota</label>
                <input type="text" class="form-control mb-1" name="kota_stnk" id="kota_stnk" value="<?= $memombr['kota_stnk'] ?>" readonly>
                <div class="input-group">
                  <div class="col-md-6">
                    <label for="nama" class="form-label mb-0">Provinsi</label>
                    <input type="text" class="form-control mb-1" name="provinsi_stnk" id="provinsi_stnk" value="<?= $memombr['provinsi_stnk'] ?>" readonly>
                  </div>
                  <div class="col-md-6">
                    <label for="nama" class="form-label mb-0">Kode Pos</label>
                    <input type="text" class="form-control mb-1" name="kodepos_stnk" id="kodepos_stnk" value="<?= $memombr['kodepos_stnk'] ?>" readonly>
                  </div>
                </div>
                <div class="input-group">
                  <div class="col-md-6">
                    <label for="nama" class="form-label mb-0">No. HP</label>
                    <input type="text" class="form-control mb-1" name="nohp_customer_stnk" id="nohp_customer_stnk" value="<?= $memombr['nohp_customer_stnk'] ?>" readonly>
                  </div>
                  <div class="col-md-6">
                    <label for="nama" class="form-label mb-0">Email</label>
                    <input type="text" class="form-control mb-1" name="email_stnk" id="email_stnk" value="<?= $memombr['email_stnk'] ?>" readonly>
                  </div>
                </div>
                <div class="input-group">
                  <div class="col-md-6">
                    <label for="nama" class="form-label mb-0">NIK</label>
                    <input type="text" class="form-control mb-1" name="nik_stnk" id="nik_stnk" value="<?= $memombr['nik_stnk'] ?>" readonly>
                  </div>
                  <div class="col-md-6">
                    <label for="nama" class="form-label mb-0">NIK KK</label>
                    <input type="text" class="form-control mb-1" name="nik_kk" id="nik_kk" value="<?= $memombr['nik_kk'] ?>">
                  </div>
                </div>
                <label for="nama" class="form-label mb-0">NPWP</label>
                <input type="text" class="form-control mb-1" name="npwp_stnk" id="npwp_stnk" value="<?= $memombr['npwp_stnk'] ?>">
              </div>
              <div class="input-group">
                <div class="col-12 col-sm-8">
                  <label for="nama" class="form-label mb-0 labeltipe">Pembayaran</label>
                  <select class="form-select mb-1" name="pembayaran" id="pembayaran" role>
                    <option value="">[Pilih Pembayaran]
                      <?php
                      $arr = array("TUNAI", "KREDIT", "PO");
                      $jml_kata = count($arr);
                      for ($c = 0; $c < $jml_kata; $c += 1) {
                        if ($arr[$c] == $memombr['pembayaran']) {
                          echo "<option value='$arr[$c]' selected>$arr[$c] </option>";
                        } else {
                          echo "<option value='$arr[$c]'> $arr[$c] </option>";
                        }
                      }
                      echo "</select>";
                      ?>
                  </select>
                </div>
                <div class="col-12 col-sm-4">
                  <label for="nama" class="form-label mb-0">Lama Kredit</label>
                  <input type="number" style="text-align:right;" class="form-control mb-2" name="lama_kredit" id="lama_kredit" value="<?= $memombr['lama_kredit'] ?>">
                </div>
              </div>
              <div class="col-12 col-sm-12">
                <label for="nama" class="form-label mb-0">Lembaga Kredit / Leasing</label>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" placeholder="Lembaga Kredit" name="kdleasing" id="kdleasing" value="<?= $memombr['kdleasing'] ?>">
                  <button class="btn btn-outline-secondary btn-sm" type="button" id="carikreditur">Cari</button>
                  <input type="text" class="col-8" class="form-control" name="nmkreditur" id="nmkreditur" value="<?= $memombr['nmkreditur'] ?>" readonly>
                </div>
              </div>
              <div class="col-12 col-sm-12">
                <label for="nama" class="form-label mb-0">Lembaga Asuransi</label>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" placeholder="Lembaga Asuransi" name="kdasuransi" id="kdasuransi" value="<?= $memombr['kdasuransi'] ?>">
                  <button class="btn btn-outline-secondary btn-sm" type="button" id="cariasuransi">Cari</button>
                  <input type="text" class="col-8" class="form-control" name="nmasuransi" id="nmasuransi" value="<?= $memombr['nmasuransi'] ?>" readonly>
                </div>
              </div>
              <!-- <label for="nama" class="form-label mb-0 labeltipe">Asuransi&nbsp;&nbsp;</label>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="asuransi" id="asuransi" value='COVER' checked>
                  <label class="form-check-label" for="asuransi1">
                    Cover
                  </label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="asuransi" id="asuransi" value='NO COVER'>
                  <label class="form-check-label" for="asuransi2">
                    No Cover
                  </label>
                </div>
                <div class="col-12 col-sm-6">
                  <label for="nama" class="form-label mb-0 labeltipe">Pembeli&nbsp;&nbsp;&nbsp;</label>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="pembeli" id="pembeli" value='Non GSO' checked>
                    <label class="form-check-label" for="pembeli1">
                      Non GSO
                    </label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="pembeli" id="pembeli" value='GSO'>
                    <label class="form-check-label" for="pembeli2">
                      GSO
                    </label>
                  </div>
                </div>
                <div class="col-12 col-sm-12">
                  <label for="nama" class="form-label mb-0 labeltipe">Penjualan</label>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="penjualan" id="penjualan" value='On The Road' checked>
                    <label class="form-check-label" for="penjualan1">
                      On The Road
                    </label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="penjualan" id="penjualan" value='Off The Road'>
                    <label class="form-check-label" for="penjualan2">
                      Off The Road
                    </label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="penjualan" id="penjualan" value='Dealer'>
                    <label class="form-check-label" for="penjualan3">
                      Dealer
                    </label>
                  </div>
                </div> -->
              <div class="row">
                <div class="col-md-12">
                  <div class="input-group">
                    <div class="col-12 col-sm-3">
                      <label for="nama" class="form-label mb-0 labeltipe">Asuransi&nbsp;&nbsp;</label>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="asuransi" id="asuransi" value='COVER' <?= $memombr['asuransi'] == 'COVER' ? 'checked' : '' ?>>
                        <label class="form-check-label" for="asuransi1">
                          Cover
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="asuransi" id="asuransi" value='NO COVER' <?= $memombr['asuransi'] == 'NO COVER' ? 'checked' : '' ?>>
                        <label class="form-check-label" for="asuransi2">
                          No Cover
                        </label>
                      </div>
                    </div>
                    <div class="col-12 col-sm-3">
                      <label for="nama" class="form-label mb-0 labeltipe">Pembeli&nbsp;&nbsp;&nbsp;</label>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="pembeli" id="pembeli" value='Non GSO' <?= $memombr['pembeli'] == 'Non GSO' ? 'checked' : '' ?>>
                        <label class="form-check-label" for="pembeli1">
                          Non GSO
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="pembeli" id="pembeli" value='GSO' <?= $memombr['pembeli'] == 'GSO' ? 'checked' : '' ?>>
                        <label class="form-check-label" for="pembeli2">
                          GSO
                        </label>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6">
                      <label for="nama" class="form-label mb-0 labeltipe">Penjualan</label>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="penjualan" id="penjualan" value='On The Road' <?= $memombr['penjualan'] == 'On The Road' ? 'checked' : '' ?>>
                        <label class="form-check-label" for="penjualan1">
                          On The Road
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="penjualan" id="penjualan" value='Off The Road' <?= $memombr['penjualan'] == 'Off The Road' ? 'checked' : '' ?>>
                        <label class="form-check-label" for="penjualan2">
                          Off The Road
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="penjualan" id="penjualan" value='Dealer' <?= $memombr['penjualan'] == 'Dealer' ? 'checked' : '' ?>>
                        <label class="form-check-label" for="penjualan3">
                          Dealer
                        </label>
                      </div>
                    </div>
                    <div class="col-12 col-sm-5">
                      <label for="nama" class="form-label mb-1"><b><u>Harga Kendaraan</u></b></label>
                      <br>
                      <label for="nama" class="form-label mb-1">Harga Per Unit</label>
                      <input type="text" style="text-align:right;" class='form-control mb-2' name='harga_jual_mobil' id='harga_jual_mobil' value="<?= $memombr['harga_jual_mobil'] ?>">
                      <label for="nama" class="form-label mb-1">Accessories Per Unit</label>
                      <input type="text" style="text-align:right;" class='form-control mb-2' name='harga_jual_accessories' id='harga_jual_accessories' value="<?= $memombr['harga_jual_accessories'] ?>">
                      <label for="nama" class="form-label mb-1">Biaya Pelanggaran Wilayah</label>
                      <input type="text" style="text-align:right;" class='form-control mb-2' name='biaya_wilayah' id='biaya_wilayah' value="<?= $memombr['biaya_wilayah'] ?>">
                      <label for="nama" class="form-label mb-1">Upping Price</label>
                      <input type="text" style="text-align:right;" class='form-control mb-2' name='upping_price' id='upping_price' value="<?= $memombr['upping_price'] ?>">
                    </div>
                    <div class="col-12 col-sm-1">
                    </div>
                    <div class="col-12 col-sm-6">
                      <label for="nama" class="form-label mb-1"><b><u></u></b></label>
                      <br>
                      <label for="nama" class="form-label mb-1">Discount Unit</label>
                      <input type="text" style="text-align:right;" class='form-control mb-2' name='disc_team_harga' id='disc_team_harga' value="<?= $memombr['disc_team_harga'] ?>">
                      <label for="nama" class="form-label mb-1">Discount Accessories</label>
                      <input type="text" style="text-align:right;" class='form-control mb-2' name='disc_accessories' id='disc_accessories' value="<?= $memombr['disc_accessories'] ?>">
                      <label for="nama" class="form-label mb-1">Total</label>
                      <input type="text" style="text-align:right;" class='form-control mb-2' name='total' id='total' value="<?= $memombr['total'] ?>" readonly>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6">
            <div class="input-group">
              <div class="col-md-6">
                <label for="nama" class="form-label mb-1">Nomor Rangka</label>
                <input type="text" class="form-control mb-1" name="norangka" id="norangka" value="<?= $memombr['norangka'] ?>">
              </div>
              <div class="col-md-4">
                <label for="nama" class="form-label mb-1">Nomor Mesin</label>
                <input type="text" class="form-control mb-1" name="nomesin" id="nomesin" value="<?= $memombr['nomesin'] ?>">
              </div>
              <div class="col-md-2">
                <label for="nama" class="form-label mb-1">Tahun</label>
                <input type="number" class="form-control mb-2" name="tahun" id="tahun" value="<?= $memombr['tahun'] ?>">
              </div>
            </div>
            <div class="input-group">
              <div class="col-12 col-sm-3">
                <label for="nama" class="form-label mb-0">Merek</label>
                <select class="form-select" name="kdmerek" id="kdmerek">
                  <option value="">[Pilih Merek]
                    <?php
                    foreach ($tbmerek as $key) {
                      if ($key['kode'] == $memombr['kdmerek']) {
                        echo "<option value='$key[kode]' selected>$key[kode] - $key[nama]</option>";
                      } else {
                        echo "<option value='$key[kode]'>$key[kode] - $key[nama]</option>";
                      }
                    }
                    ?>
                  </option>
                </select>
              </div>
              <div class="col-12 col-sm-3">
                <label for="nama" class="form-label mb-0 labelmodel">Model</label>
                <select class="form-select mb-1" name="kdmodel" id="kdmodel" role>
                  <option value="">[Pilih Model]
                    <?php
                    foreach ($tbmodel as $key) {
                      if ($key['kode'] == $memombr['kdmodel']) {
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
                <label for="nama" class="form-label mb-0 labeltipe">Tipe</label>
                <select class="form-select mb-1" name="kdtipe" id="kdtipe" role>
                  <option value="">[Pilih Tipe]
                    <?php
                    foreach ($tbtipe as $key) {
                      if ($key['kode'] == $memombr['kdtipe']) {
                        echo "<option value='$key[kode]' selected>$key[kode] - $key[nama]</option>";
                      } else {
                        echo "<option value='$key[kode]'>$key[kode] - $key[nama]</option>";
                      }
                    }
                    ?>
                  </option>
                </select>
                <input type="hidden" name="nmtipe" id="nmtipe">
              </div>
            </div>
            <div class="input-group">
              <div class="col-12 col-sm-5">
                <label for="nama" class="form-label mb-0 labeltipe">Jenis</label>
                <select class="form-select mb-1" name="kdjenis" id="kdjenis" role>
                  <option value="">[Pilih Jenis]
                    <?php
                    ?>
                    <?php
                    foreach ($tbjenis as $key) {
                      if ($key['kode'] == $memombr['kdjenis']) {
                        echo "<option value='$key[kode]' selected>$key[kode] - $key[nama]</option>";
                      } else {
                        echo "<option value='$key[kode]'>$key[kode] - $key[nama]</option>";
                      }
                    }
                    ?>
                  </option>
                </select>
              </div>
              <div class="col-12 col-sm-7">
                <label for="nama" class="form-label mb-0 labeltipe">Warna</label>
                <select class="form-select mb-1" name="kdwarna" id="kdwarna" role>
                  <option value="">[Pilih Warna]
                    <?php
                    foreach ($tbwarna as $key) {
                      if ($key['kode'] == $memombr['kdwarna']) {
                        echo "<option value='$key[kode]' selected>$key[kode] - $key[nama]</option>";
                      } else {
                        echo "<option value='$key[kode]'>$key[kode] - $key[nama]</option>";
                      }
                    }
                    ?>
                  </option>
                </select>
              </div>
            </div>
            <label for="nama" class="form-label mb-0">Merek Kaca Film</label>
            <input type="text" class="form-control mb-2" name="kaca_film" id="kaca_film" value="<?= $memombr['kaca_film'] ?>">
            <label for="nama" class="form-label mb-0">Salesman</label>
            <div class="input-group mb-2">
              <input type="text" class="form-control" placeholder="Salesman" name="kdsales" id="kdsales" value="<?= $memombr['kdsales'] ?>">
              <button class="btn btn-outline-secondary btn-sm" type="button" id="carisales">Cari</button>
              <input type="text" class="col-8" class="form-control" name="nmsales" id="nmsales" value="<?= isset($tbsales['nama']) ? $tbsales['nama'] : '' ?>" readonly>
            </div>
            <label for="nama" class="form-label mb-1">Status Sales</label>
            <input type="text" class='form-control form-control-sm mb-2' name='status_sales' id='status_sales' value="<?= $memombr['status_sales'] ?>" readonly>
            <label for="nama" class="form-label mb-0">Supervisor</label>
            <div class="input-group mb-2">
              <input type="text" class="form-control" placeholder="Supervisor" name="kdspv" id="kdspv" value="<?= $memombr['kdspv'] ?>">
              <button class="btn btn-outline-secondary btn-sm" type="button" id="carispv">Cari</button>
              <input type="text" class="col-8" class="form-control" name="nmspv" id="nmspv" value="<?= isset($tbspv['nama']) ? $tbspv['nama'] : '' ?>" readonly>
            </div>
            <label for="nama" class="form-label mb-0">Sales Manager</label>
            <div class="input-group mb-2">
              <input type="text" class="form-control" placeholder="Sales Mgr" name="kdmgr" id="kdmgr" value="<?= $memombr['kdmgr'] ?>">
              <button class="btn btn-outline-secondary btn-sm" type="button" id="carimgr">Cari</button>
              <input type="text" class="col-8" class="form-control" name="nmmgr" id="nmmgr" value="<?= isset($tbmgr['nama']) ? $tbmgr['nama'] : '' ?>" readonly>
            </div>
            <label for="nama" class="form-label mb-0">
              <font color="blue"><b><u>Variasi/Asuransi/Lain-lain yang dijual</u></b></font>
            </label><br>
            <button class="btn btn-flat btn-primary btn-sm mb-2 tambahjual" type="button"><i class="fa fa-plus"></i> Tambah</button>
            <div id="tbl_memombrd"></div>
            <label for="nama" class="form-label mb-0">
              <font color="red"><b><u>VOUCHER DISCOUNT</u></b></font>
            </label><br>
            <label for="nama" class="form-label mb-1">Disc Dealer / Cash Back</label>
            <input type="text" style="text-align:right;" style="text-align:right;" class='form-control mb-2' name='disc_dealer' id='disc_dealer' value="<?= $memombr['disc_dealer'] ?>">
            <label for="nama" class="form-label mb-1">Event HPM</label>
            <input type="text" style="text-align:right;" style="text-align:right;" class='form-control mb-2' name='event_hpm' id='event_hpm' value="<?= $memombr['event_hpm'] ?>">
            <label for="nama" class="form-label mb-1">Event Lain-Lain</label>
            <input type="text" style="text-align:right;" style="text-align:right;" class='form-control mb-2' name='event_lain' id='event_lain' value="<?= $memombr['event_lain'] ?>">
            <div class="input-group mb-2">
              <div class="col-md-6">
                <label for="nama" class="form-label mb-1">Mediator Bank</label>
                <input type="text" class='form-control mb-2' name='mediator_bank' id='mediator_bank' value="<?= $memombr['mediator_bank'] ?>">
                <label for="nama" class="form-label mb-1">Mediator An</label>
                <input type="text" class='form-control mb-2' name='mediator_an' id='mediator_an' value="<?= $memombr['mediator_an'] ?>">
              </div>
              <div class="col-md-6">
                <label for="nama" class="form-label mb-1">Mediator Cabang</label>
                <input type="text" class='form-control mb-2' name='mediator_cabang' id='mediator_cabang' value="<?= $memombr['mediator_cabang'] ?>">
                <label for="nama" class="form-label mb-1">Mediator Account</label>
                <input type="text" class='form-control mb-2' name='mediator_account' id='mediator_account' value="<?= $memombr['mediator_account'] ?>">
              </div>
            </div>
            <label for="nama" class="form-label mb-1">Mediator Nilai</label>
            <input type="text" style="text-align:right;" class='form-control mb-2' name='mediator_nilai' id='mediator_nilai' value="<?= $memombr['mediator_nilai'] ?>">
            <!-- <div class="col-12 col-sm-6"> -->
            <div class="input-group mb-2">
              <label for="nama" class="form-label form-label-inline mb-1">Nama STNK&nbsp;&nbsp;</label><br>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="nama_stnk" name="nama_stnk" <?= $memombr['nama_stnk'] == 'Y' ? 'checked' : '' ?>>
              </div>
              <label for="nama" class="form-label form-label-inline mb-1">Tipe/Unit/Warna Mobil&nbsp;&nbsp;</label><br>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="tipe_unit_warna" name="tipe_unit_warna" <?= $memombr['tipe_unit_warna'] == 'Y' ? 'checked' : '' ?>>
              </div>
            </div>
            <!-- </div>
            <div class="col-12 col-sm-6"> -->
            <div class="input-group mb-2">
              <label for="nama" class="form-label form-label-inline mb-1">Pembelian Asuransi&nbsp;&nbsp;</label><br>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="beli_asuransi" name="beli_asuransi" <?= $memombr['beli_asuransi'] == 'Y' ? 'checked' : '' ?>>
              </div>
              <label for="nama" class="form-label form-label-inline mb-1">Pembelian Accessories&nbsp;&nbsp;</label><br>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="beli_accessories" name="beli_accessories" <?= $memombr['beli_accessories'] == 'Y' ? 'checked' : '' ?>>
              </div>
            </div>
            <!-- </div> -->
            <label for="nama" class="form-label mb-1"><b><u>Uang Masuk</u></b></label>
            <br>
            <label for="nama" class="form-label mb-1">Booking Fee</label>
            <input type="text" style="text-align:right;" class='form-control mb-2' name='booking_fee' id='booking_fee' value="<?= $memombr['booking_fee'] ?>">
            <label for="nama" class="form-label mb-1">Lain-Lain</label>
            <textarea rows=3 class='form-control mb-2' name='ket_uang_lain' id='ket_uang_lain'><?= $memombr['ket_uang_lain'] ?></textarea>
            <input type="text" style="text-align:right;" class='form-control mb-2' name='uang_lain' id='uang_lain' value="<?= $memombr['uang_lain'] ?>">
            <!-- </div>
          <div class="col-md-12"> -->
            <div class="modal-footer">
              <button type="submit" id="btnsimpan" class="btn btn-primary btnsimpan">Simpan</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
          </div>
        </div>
        <?= form_close() ?>
      </div>
    </div>
  </div>

  <script>
    var myModal = document.getElementById('modaledit')
    var myInput = document.getElementById('nospk')
    myModal.addEventListener('shown.bs.modal', function() {
      myInput.focus()
    })

    $(document).ready(function() {
      reload_table_memombrd();
      $('#harga_jual_mobil').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '0'
      })
      $('#harga_jual_accessories').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '0'
      })
      $('#biaya_wilayah').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '0'
      })
      $('#upping_price').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '0'
      })
      $('#disc_team_harga').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '0'
      })
      $('#disc_accessories').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '0'
      })
      $('#total').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '0'
      })
      $('#mediator_nilai').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '0'
      })
      $('#booking_fee').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '0'
      })
      $('#uang_lain').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '0'
      })
      $('#disc_dealer').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '0'
      })
      $('#event_hpm').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '0'
      })
      $('#event_lain').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '0'
      })

      $('#harga_jual_mobil').on('keyup', function(e) {
        hit_total();
      })
      $('#harga_jual_accessories').on('keyup', function(e) {
        hit_total();
      })
      $('#biaya_wilayah').on('keyup', function(e) {
        hit_total();
      })
      $('#upping_price').on('keyup', function(e) {
        hit_total();
      })
      $('#disc_team_harga').on('keyup', function(e) {
        hit_total();
      })
      $('#disc_accessories').on('keyup', function(e) {
        hit_total();
      })
      $('#mediator_nilai').on('keyup', function(e) {
        hit_total();
      })
      $('#booking_fee').on('keyup', function(e) {
        hit_total();
      })
      $('#uang_lain').on('keyup', function(e) {
        hit_total();
      })

      $('.formmemombr').submit(function(e) {
        e.preventDefault();
        $.ajax({
          type: "post",
          url: $(this).attr('action'),
          data: $(this).serialize(),
          dataType: "json",
          beforeSend: function() {
            $('.btnsimpan').attr('disable', 'disabled')
            $('.btnsimpan').html('<i class="fa fa-spin fa-spinner"></i>')
          },
          complete: function() {
            $('.btnsimpan').removeAttr('disable')
            $('.btnsimpan').html('Simpan')
          },
          success: function(response) {
            if (response.error) {
              // alert(response.error);
            } else {
              // alert(response.sukses);
              $('#modaledit').modal('hide');
              // swal({
              //   title: "Data berhasil disimpan",
              //   text: "",
              //   icon: "success",
              //   buttons: true,
              //   dangerMode: true,
              // })

              swal({
                title: "Data Berhasil diupdate ",
                text: "",
                icon: "success"
              })
              reload_table();
              // .then(function() {
              //   window.location.href = '/memombr';
              // });

              // window.location = '/memombr';
            }
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
          }
        });
        return false;
      })
    });

    function hit_total() {
      let textharga_jual_mobil = document.getElementById("harga_jual_mobil").value
      let harga_jual_mobil = textharga_jual_mobil.replace(/,/g, "");
      if (harga_jual_mobil === "") {
        harga_jual_mobil = 0;
      }
      let textharga_jual_accessories = document.getElementById("harga_jual_accessories").value
      let harga_jual_accessories = textharga_jual_accessories.replace(/,/g, "");
      if (harga_jual_accessories === "") {
        harga_jual_accessories = 0;
      }
      let textbiaya_wilayah = document.getElementById("biaya_wilayah").value
      let biaya_wilayah = textbiaya_wilayah.replace(/,/g, "");
      if (biaya_wilayah === "") {
        biaya_wilayah = 0;
      }
      let textupping_price = document.getElementById("upping_price").value
      let upping_price = textupping_price.replace(/,/g, "");
      if (upping_price === "") {
        upping_price = 0;
      }
      let textdisc_team_harga = document.getElementById("disc_team_harga").value
      let disc_team_harga = textdisc_team_harga.replace(/,/g, "");
      if (disc_team_harga === "") {
        disc_team_harga = 0;
      }
      let textdisc_accessories = document.getElementById("disc_accessories").value
      let disc_accessories = textdisc_accessories.replace(/,/g, "");
      if (disc_accessories === "") {
        disc_accessories = 0;
      }
      let total = parseFloat(harga_jual_mobil) + parseFloat(harga_jual_accessories) + parseFloat(biaya_wilayah) +
        parseFloat(upping_price) - parseFloat(disc_team_harga) - parseFloat(disc_accessories);
      document.getElementById("total").value = total.toLocaleString('en-US');
    }

    $('#carikreditur').click(function(e) {
      e.preventDefault();
      cari_data_kreditur();
    })

    $('#kdkreditur').on('blur', function(e) {
      let cari = $(this).val()
      let cari1 = $('#kdkreditur').val()
      if (cari === "") {
        cari = "XXXXXXXXXXXXXXXXXXXXXXXXX";
      }
      $.ajax({
        url: "<?= site_url('memombr/repl_kreditur') ?>",
        type: 'post',
        data: {
          'kode_kreditur': cari
        },
        success: function(data) {
          let data_response = JSON.parse(data);
          if (data_response['kode'] == '') {
            $('#kdkreditur').val('');
            $('#nmkreditur').val('');

            cari_data_kreditur();
            return;
          } else {
            $('#kdkreditur').val(data_response['kode']);
            $('#nmkreditur').val(data_response['nama']);
          }
        },
        error: function() {
          $('#kdkreditur').val('');
          $('#nmkreditur').val('');
          cari_data_kreditur();
          return;
          // console.log('file not fount');
        }
      })
      // console.log(cari);
    })

    function cari_data_kreditur() {
      $.ajax({
        url: "<?= site_url('memombr/cari_data_kreditur') ?>",
        dataType: "json",
        success: function(response) {
          $('.viewmodal1').html(response.data).show();
          $('#modalcarikreditur').modal('show');
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      })
    }

    $('#cariasuransi').click(function(e) {
      e.preventDefault();
      cari_data_asuransi();
    })

    $('#kdasuransi').on('blur', function(e) {
      let cari = $(this).val()
      let cari1 = $('#kdasuransi').val()
      if (cari === "") {
        cari = "XXXXXXXXXXXXXXXXXXXXXXXXX";
      }
      $.ajax({
        url: "<?= site_url('memombr/repl_asuransi') ?>",
        type: 'post',
        data: {
          'kode_asuransi': cari
        },
        success: function(data) {
          let data_response = JSON.parse(data);
          if (data_response['kode'] == '') {
            $('#kdasuransi').val('');
            $('#nmasuransi').val('');

            cari_data_asuransi();
            return;
          } else {
            $('#kdasuransi').val(data_response['kode']);
            $('#nmasuransi').val(data_response['nama']);
          }
        },
        error: function() {
          $('#kdasuransi').val('');
          $('#nmasuransi').val('');
          cari_data_asuransi();
          return;
          // console.log('file not fount');
        }
      })
      // console.log(cari);
    })

    function cari_data_asuransi() {
      $.ajax({
        url: "<?= site_url('memombr/cari_data_asuransi') ?>",
        dataType: "json",
        success: function(response) {
          $('.viewmodal1').html(response.data).show();
          $('#modalcariasuransi').modal('show');
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      })
    }

    $('#carisales').click(function(e) {
      e.preventDefault();
      cari_data_sales();
    })

    $('#kdsales').on('blur', function(e) {
      let cari = $(this).val()
      let cari1 = $('#kdsales').val()
      if (cari === "") {
        cari = "XXXXXXXXXXXXXXXXXXXXXXXXX";
      }
      $.ajax({
        url: "<?= site_url('memombr/repl_sales') ?>",
        type: 'post',
        data: {
          'kode_sales': cari
        },
        success: function(data) {
          let data_response = JSON.parse(data);
          if (data_response['kode'] == '') {
            $('#kdsales').val('');
            $('#nmsales').val('');
            $('#kdspv').val('');
            cari_data_sales();
            return;
          } else {
            $('#kdsales').val(data_response['kode']);
            $('#nmsales').val(data_response['nama']);
            $('#kdspv').val(data_response['kdspv']);
          }
        },
        error: function() {
          $('#kdsales').val('');
          $('#nmsales').val('');
          $('#kdspv').val('');
          cari_data_sales();
          return;
          // console.log('file not fount');
        }
      })
      // console.log(cari);
    })

    function cari_data_sales() {
      $.ajax({
        url: "<?= site_url('memombr/cari_data_sales') ?>",
        dataType: "json",
        success: function(response) {
          $('.viewmodal1').html(response.data).show();
          $('#modalcarisales').modal('show');
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      })
    }

    $('#carispv').click(function(e) {
      e.preventDefault();
      cari_data_spv();
    })

    $('#kdspv').on('blur', function(e) {
      let cari = $(this).val()
      let cari1 = $('#kdspv').val()
      if (cari === "") {
        cari = "XXXXXXXXXXXXXXXXXXXXXXXXX";
      }
      $.ajax({
        url: "<?= site_url('memombr/repl_spv') ?>",
        type: 'post',
        data: {
          'kode_spv': cari
        },
        success: function(data) {
          let data_response = JSON.parse(data);
          if (data_response['kode'] == '') {
            $('#kdspv').val('');
            $('#nmspv').val('');
            cari_data_spv();
            return;
          } else {
            $('#kdspv').val(data_response['kode']);
            $('#nmspv').val(data_response['nama']);
          }
        },
        error: function() {
          $('#kdspv').val('');
          $('#nmspv').val('');
          cari_data_spv();
          return;
          // console.log('file not fount');
        }
      })
      // console.log(cari);
    })

    function cari_data_spv() {
      $.ajax({
        url: "<?= site_url('memombr/cari_data_spv') ?>",
        dataType: "json",
        success: function(response) {
          $('.viewmodal1').html(response.data).show();
          $('#modalcarispv').modal('show');
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      })
    }

    $('#carimgr').click(function(e) {
      e.preventDefault();
      cari_data_mgr();
    })

    $('#kdmgr').on('blur', function(e) {
      let cari = $(this).val()
      let cari1 = $('#kdmgr').val()
      if (cari === "") {
        cari = "XXXXXXXXXXXXXXXXXXXXXXXXX";
      }
      $.ajax({
        url: "<?= site_url('memombr/repl_mgr') ?>",
        type: 'post',
        data: {
          'kode_mgr': cari
        },
        success: function(data) {
          let data_response = JSON.parse(data);
          if (data_response['kode'] == '') {
            $('#kdmgr').val('');
            $('#nmmgr').val('');
            cari_data_mgr();
            return;
          } else {
            $('#kdmgr').val(data_response['kode']);
            $('#nmmgr').val(data_response['nama']);
          }
        },
        error: function() {
          $('#kdmgr').val('');
          $('#nmmgr').val('');
          cari_data_mgr();
          return;
          // console.log('file not fount');
        }
      })
      // console.log(cari);
    })

    function cari_data_mgr() {
      $.ajax({
        url: "<?= site_url('memombr/cari_data_mgr') ?>",
        dataType: "json",
        success: function(response) {
          $('.viewmodal1').html(response.data).show();
          $('#modalcarimgr').modal('show');
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      })
    }

    $('#caricustomer').click(function(e) {
      e.preventDefault();
      cari_data_customer();
    })

    $('#kdcustomer').on('blur', function(e) {
      let cari = $(this).val()
      let cari1 = $('#kdcustomer').val()
      if (cari === "") {
        cari = "XXXXXXXXXXXXXXXXXXXXXXXXX";
      }
      $.ajax({
        url: "<?= site_url('memombr/repl_customer') ?>",
        type: 'post',
        data: {
          'kode_customer': cari
        },
        success: function(data) {
          let data_response = JSON.parse(data);
          if (data_response['kode'] == '') {
            $('#kdcustomer').val('');
            $('#nmcustomer').val('');
            cari_data_customer();
            return;
          } else {
            $('#kdcustomer').val(data_response['kode']);
            $('#nmcustomer').val(data_response['nama']);
          }
        },
        error: function() {
          $('#kdcustomer').val('');
          $('#nmcustomer').val('');
          cari_data_customer();
          return;
          // console.log('file not fount');
        }
      })
      // console.log(cari);
    })

    function cari_data_customer() {
      $.ajax({
        url: "<?= site_url('memombr/cari_data_customer') ?>",
        dataType: "json",
        success: function(response) {
          $('.viewmodal1').html(response.data).show();
          $('#modalcaricustomer').modal('show');
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      })
    }

    $('#caricustomer_stnk').click(function(e) {
      e.preventDefault();
      cari_data_customer_stnk();
    })

    $('#kdcustomer_stnk').on('blur', function(e) {
      let cari = $(this).val()
      let cari1 = $('#kdcustomer_stnk').val()
      if (cari === "") {
        cari = "XXXXXXXXXXXXXXXXXXXXXXXXX";
      }
      $.ajax({
        url: "<?= site_url('memombr/repl_customer_stnk') ?>",
        type: 'post',
        data: {
          'kode_customer_stnk': cari
        },
        success: function(data) {
          let data_response = JSON.parse(data);
          if (data_response['kode'] == '') {
            $('#kdcustomer_stnk').val('');
            $('#nmcustomer_stnk').val('');
            cari_data_customer_stnk();
            return;
          } else {
            $('#kdcustomer_stnk').val(data_response['kode']);
            $('#nmcustomer_stnk').val(data_response['nama']);
          }
        },
        error: function() {
          $('#kdcustomer_stnk').val('');
          $('#nmcustomer_stnk').val('');
          cari_data_customer_stnk();
          return;
          // console.log('file not fount');
        }
      })
      // console.log(cari);
    })

    function cari_data_customer_stnk() {
      $.ajax({
        url: "<?= site_url('memombr/cari_data_customer_stnk') ?>",
        dataType: "json",
        success: function(response) {
          $('.viewmodal1').html(response.data).show();
          $('#modalcaricustomerstnk').modal('show');
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      })
    }

    $('.tambahjual').click(function(e) {
      e.preventDefault();
      id = $('#id').val()
      $.ajax({
        url: "<?= site_url('memombr/tambahjual') ?>",
        dataType: "json",
        type: "POST",
        data: {
          'id': id
        },
        success: function(response) {
          $('.viewmodal1').html(response.data).show();
          $('#modaltambahjual').modal('show');
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      })
    })

    function reload_table_memombrd() {
      $nomemo = document.getElementById('nomemo').value;
      <?php
      $session = session();
      // if ($session->get('nama') == "") {
      if (!$session->has('nama')) {
      ?>
        vexpired();

        function vexpired() {
          $(document).ready(function() {
            $('#expired').modal('show');
          });
        }
      <?php
      }
      ?>
      $.ajax({
        type: "post",
        data: {
          nomemo: $("#nomemo").val()
        },
        // dataType: "json",
        url: "<?= site_url('memombr/table_memombrd'); ?>",
        beforeSend: function(f) {
          $('.btnreload').attr('disable', 'disabled')
          $('.btnreload').html('<i class="fa fa-spin fa-spinner"></i>')
          // alert('1');
          $('#tbl_memombrd').html('<center>Loading Table ...</center>');
        },
        success: function(data) {
          $('#tbl_memombrd').html(data);
          $('.btnreload').removeAttr('disable')
          $('.btnreload').html('<i class="fa fa-spinner">')
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      })
    }

    function hapusmemombrd($id) {
      swal({
          title: "Yakin akan hapus ?",
          text: "Once deleted, you will not be able to recover this data!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              url: "<?php echo site_url('memombr/hapusmemombrd') ?>/" + $id,
              type: "POST",
              dataType: "JSON",
              success: function(data) {
                //if success reload ajax table
                // $('#modal_form').modal('hide');
                if (data.status == true) {
                  swal({
                    title: "Data Berhasil dihapus! ",
                    text: "",
                    icon: "info"
                  })
                } else {
                  swal({
                    title: "Data Gagal dihapus, sudah ada detail transaksi! ",
                    text: "",
                    icon: "info"
                  })
                }
                reload_table_memombrd();
                // .then(function() {
                //   window.location.href = '/wo';
                // });
              },
              error: function(jqXHR, textStatus, errorThrown) {
                alert('Error deleting data id ' + $kode);
              }
            });
          } else {
            // swal("Batal Hapus!");
          }
        });
    }
  </script>