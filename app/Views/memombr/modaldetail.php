<?php
$session = session();
$nmform = [
  'form' => "detail",
];
$session->set($nmform);
?>

<script src="<?= base_url('/js/autoNumeric.js') ?>" crossorigin="anonymous"></script>

<!-- Modal -->
<div class="modal fade" id="modaldetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                <input type="text" class="form-control form-control-sm mb-2" name="nospk" id="nospk" value="<?= $memombr['nospk'] ?>" readonly autofocus>
              </div>
              <div class="col-md-4">
                <label for="nama" class="form-label mb-1">Tanggal (M-D-Y)</label>
                <input type="datetime-local" class='form-control form-control-sm mb-2' name='tanggal' id='tanggal' value="<?= $memombr['tanggal'] ?>" readonly style="width: 100%">
              </div>
            </div>
            <div class="col-12 col-sm-12">
              <label for="nama" class="form-label mb-0"><b><u>Pemesan</u></b></label>
              <div class="col-md-12">
                <div class="input-group mb-2">
                  <input type="text" class="form-control" placeholder="Pemesan" name="kdcustomer" id="kdcustomer" value="<?= $memombr['kdcustomer'] ?>" readonly>
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
                <input type="text" class="form-control mb-1" name="nik" id="nik" value="<?= $memombr['nik_customer'] ?>" readonly>
                <label for="nama" class="form-label mb-0"><b><u>STNK A/n</u></b></label>
                <div class="input-group mb-2">
                  <input type="text" class="form-control" placeholder="STNK a/n" name="kdcustomer_stnk" id="kdcustomer_stnk" value="<?= $memombr['kdcustomer_stnk'] ?>" readonly>
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
                    <input type="text" class="form-control mb-1" name="nik_kk" id="nik_kk" value="<?= $memombr['nik_kk'] ?>" readonly>
                  </div>
                </div>
                <label for="nama" class="form-label mb-0">NPWP</label>
                <input type="text" class="form-control mb-1" name="npwp_stnk" id="npwp_stnk" value="<?= $memombr['npwp_stnk'] ?>" readonly>
              </div>
              <div class="input-group">
                <div class="col-12 col-sm-8">
                  <label for="nama" class="form-label mb-0 labeltipe">Pembayaran</label>
                  <select class="form-select mb-1" name="pembayaran" id="pembayaran" disabled role>
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
                  <input type="number" class="form-control mb-2" name="lama_kredit" id="lama_kredit" value="<?= $memombr['lama_kredit'] ?>" readonly>
                </div>
              </div>
              <div class="col-12 col-sm-12">
                <label for="nama" class="form-label mb-0">Lembaga Kredit / Leasing</label>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" placeholder="Lembaga Kredit" name="kdleasing" id="kdleasing" value="<?= $memombr['kdleasing'] ?>" readonly>
                  <button class="btn btn-outline-secondary btn-sm" type="button" id="carikreditur">Cari</button>
                  <input type="text" class="col-8" class="form-control" name="nmkreditur" id="nmkreditur" value="<?= $memombr['nmkreditur'] ?>" readonly>
                </div>
              </div>
              <div class="col-12 col-sm-12">
                <label for="nama" class="form-label mb-0">Lembaga Asuransi</label>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" placeholder="Lembaga Asuransi" name="kdasuransi" id="kdasuransi" value="<?= $memombr['kdasuransi'] ?>" readonly>
                  <button class="btn btn-outline-secondary btn-sm" type="button" id="cariasuransi">Cari</button>
                  <input type="text" class="col-8" class="form-control" name="nmasuransi" id="nmasuransi" value="<?= $memombr['nmasuransi'] ?>" readonly>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="input-group">
                    <div class="col-12 col-sm-3">
                      <label for="nama" class="form-label mb-0 labeltipe">Asuransi&nbsp;&nbsp;</label>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="asuransi" id="asuransi" <?= $memombr['asuransi'] == 'COVER' ? 'checked' : '' ?> disabled>
                        <label class="form-check-label" for="asuransi1">
                          Cover
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="asuransi" id="asuransi" <?= $memombr['asuransi'] == 'NO COVER' ? 'checked' : '' ?> disabled>
                        <label class="form-check-label" for="asuransi2">
                          No Cover
                        </label>
                      </div>
                    </div>
                    <div class="col-12 col-sm-3">
                      <label for="nama" class="form-label mb-0 labeltipe">Pembeli&nbsp;&nbsp;&nbsp;</label>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="pembeli" id="pembeli" <?= $memombr['pembeli'] == 'Non GSO' ? 'checked' : '' ?> disabled>
                        <label class="form-check-label" for="pembeli1">
                          Non GSO
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="pembeli" id="pembeli" <?= $memombr['pembeli'] == 'GSO' ? 'checked' : '' ?> disabled>
                        <label class="form-check-label" for="pembeli2">
                          GSO
                        </label>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6">
                      <label for="nama" class="form-label mb-0 labeltipe">Penjualan</label>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="penjualan" id="penjualan" <?= $memombr['penjualan'] == 'On The Road' ? 'checked' : '' ?> disabled>
                        <label class="form-check-label" for="penjualan1">
                          On The Road
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="penjualan" id="penjualan" <?= $memombr['penjualan'] == 'Off The Road' ? 'checked' : '' ?> disabled>
                        <label class="form-check-label" for="penjualan2">
                          Off The Road
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="penjualan" id="penjualan" <?= $memombr['penjualan'] == 'Dealer' ? 'checked' : '' ?> disabled>
                        <label class="form-check-label" for="penjualan3">
                          Dealer
                        </label>
                      </div>
                    </div>
                    <div class="col-12 col-sm-5">
                      <label for="nama" class="form-label mb-1"><b><u>Harga Kendaraan</u></b></label>
                      <br>
                      <label for="nama" class="form-label mb-1">Harga Per Unit</label>
                      <input type="text" style="text-align:right;" class='form-control mb-2' name='harga_jual_mobil' id='harga_jual_mobil' value="<?= $memombr['harga_jual_mobil'] ?>" readonly>
                      <label for="nama" class="form-label mb-1">Accessories Per Unit</label>
                      <input type="text" style="text-align:right;" class='form-control mb-2' name='harga_jual_accessories' id='harga_jual_accessories' value="<?= $memombr['harga_jual_accessories'] ?>" readonly>
                      <label for="nama" class="form-label mb-1">Biaya Pelanggaran Wilayah</label>
                      <input type="text" style="text-align:right;" class='form-control mb-2' name='biaya_wilayah' id='biaya_wilayah' value="<?= $memombr['biaya_wilayah'] ?>" readonly>
                      <label for="nama" class="form-label mb-1">Upping Price</label>
                      <input type="text" style="text-align:right;" class='form-control mb-2' name='upping_price' id='upping_price' value="<?= $memombr['upping_price'] ?>" readonly>
                    </div>
                    <div class="col-12 col-sm-1">
                    </div>
                    <div class="col-12 col-sm-6">
                      <label for="nama" class="form-label mb-1"><b><u></u></b></label>
                      <br>
                      <label for="nama" class="form-label mb-1">Discount Unit</label>
                      <input type="text" style="text-align:right;" class='form-control mb-2' name='disc_team_harga' id='disc_team_harga' value="<?= $memombr['disc_team_harga'] ?>" readonly>
                      <label for="nama" class="form-label mb-1">Discount Accessories</label>
                      <input type="text" style="text-align:right;" class='form-control mb-2' name='disc_accessories' id='disc_accessories' value="<?= $memombr['disc_accessories'] ?>" readonly>
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
                <input type="text" class="form-control mb-1" name="norangka" id="norangka" value="<?= $memombr['norangka'] ?>" readonly>
              </div>
              <div class="col-md-4">
                <label for="nama" class="form-label mb-1">Nomor Mesin</label>
                <input type="text" class="form-control mb-1" name="nomesin" id="nomesin" value="<?= $memombr['nomesin'] ?>" readonly>
              </div>
              <div class="col-md-2">
                <label for="nama" class="form-label mb-1">Tahun</label>
                <input type="number" class="form-control mb-2" name="tahun" id="tahun" value="<?= $memombr['tahun'] ?>" readonly>
              </div>
            </div>
            <div class="input-group">
              <div class="col-12 col-sm-3">
                <label for="nama" class="form-label mb-0">Merek</label>
                <select class="form-select" name="kdmerek" id="kdmerek" disabled required>
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
                <select class="form-select mb-1" name="kdmodel" id="kdmodel" disabled role>
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
                <select class="form-select mb-1" name="kdtipe" id="kdtipe" disabled role>
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
                <select class="form-select mb-1" name="kdjenis" id="kdjenis" disabled role>
                  <option value="">[Pilih Jenis]
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
              <div class="col-12 col-sm-7">
                <label for="nama" class="form-label mb-0 labeltipe">Warna</label>
                <select class="form-select mb-1" name="kdwarna" id="kdwarna" disabled role>
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
            <input type="text" class="form-control mb-2" name="kaca_film" id="kaca_film" value="<?= $memombr['kaca_film'] ?>" readonly>
            <label for="nama" class="form-label mb-0">Salesman</label>
            <div class="input-group mb-2">
              <input type="text" class="form-control" placeholder="Salesman" name="kdsales" id="kdsales" value="<?= $memombr['kdsales'] ?>" readonly>
              <button class="btn btn-outline-secondary btn-sm" type="button" id="carisales">Cari</button>
              <input type="text" class="col-8" class="form-control" name="nmsales" id="nmsales" value="<?= isset($tbsales['nama']) ? $tbsales['nama'] : '' ?>" readonly>
            </div>
            <label for="nama" class="form-label mb-1">Status Sales</label>
            <input type="text" class='form-control form-control-sm mb-2' name='status_sales' id='status_sales' value="<?= $memombr['status_sales'] ?>" readonly>
            <label for="nama" class="form-label mb-0">Supervisor</label>
            <div class="input-group mb-2">
              <input type="text" class="form-control" placeholder="Supervisor" name="kdspv" id="kdspv" value="<?= $memombr['kdspv'] ?>" readonly>
              <button class="btn btn-outline-secondary btn-sm" type="button" id="carispv">Cari</button>
              <input type="text" class="col-8" class="form-control" name="nmspv" id="nmspv" value="<?= isset($tbspv['nama']) ? $tbspv['nama'] : '' ?>" readonly>
            </div>
            <label for="nama" class="form-label mb-0">Sales Manager</label>
            <div class="input-group mb-2">
              <input type="text" class="form-control" placeholder="Sales Mgr" name="kdmgr" id="kdmgr" value="<?= $memombr['kdmgr'] ?>" readonly>
              <button class="btn btn-outline-secondary btn-sm" type="button" id="carimgr">Cari</button>
              <input type="text" class="col-8" class="form-control" name="nmmgr" id="nmmgr" value="<?= isset($tbmgr['nama']) ? $tbmgr['nama'] : '' ?>" readonly>
            </div>
            <label for="nama" class="form-label mb-0">
              <font color="blue"><b><u>Variasi/Asuransi/Lain-lain yang dijual</u></b></font>
            </label><br>
            <label for="nama" class="form-label mb-1">
              Untuk input Variasi/Asuransi/Lain-lain yang dijual, silahkan simpan terlebih dahulu
            </label>
            <div id="tbl_memombrd"></div>
            <label for="nama" class="form-label mb-0">
              <font color="red"><b><u>VOUCHER DISCOUNT</u></b></font>
            </label><br>
            <label for="nama" class="form-label mb-1">Disc Dealer / Cash Back</label>
            <input type="text" style="text-align:right;" class='form-control mb-2' name='disc_dealer' id='disc_dealer' value="<?= $memombr['disc_dealer'] ?>" readonly>
            <label for="nama" class="form-label mb-1">Event HPM</label>
            <input type="text" style="text-align:right;" class='form-control mb-2' name='event_hpm' id='event_hpm' value="<?= $memombr['event_hpm'] ?>" readonly>
            <label for="nama" class="form-label mb-1">Event Lain-Lain</label>
            <input type="text" style="text-align:right;" class='form-control mb-2' name='event_lain' id='event_lain' value="<?= $memombr['event_lain'] ?>" readonly>
            <div class="input-group mb-2">
              <div class="col-md-6">
                <label for="nama" class="form-label mb-1">Mediator Bank</label>
                <input type="text" class='form-control mb-2' name='mediator_bank' id='mediator_bank' value="<?= $memombr['mediator_bank'] ?>" readonly>
                <label for="nama" class="form-label mb-1">Mediator An</label>
                <input type="text" class='form-control mb-2' name='mediator_an' id='mediator_an' value="<?= $memombr['mediator_an'] ?>" readonly>
              </div>
              <div class="col-md-6">
                <label for="nama" class="form-label mb-1">Mediator Cabang</label>
                <input type="text" class='form-control mb-2' name='mediator_cabang' id='mediator_cabang' value="<?= $memombr['mediator_cabang'] ?>" readonly>
                <label for="nama" class="form-label mb-1">Mediator Account</label>
                <input type="text" class='form-control mb-2' name='mediator_account' id='mediator_account' value="<?= $memombr['mediator_account'] ?>" readonly>
              </div>
            </div>
            <label for="nama" class="form-label mb-1">Mediator Nilai</label>
            <input type="text" style="text-align:right;" class='form-control mb-2' name='mediator_nilai' id='mediator_nilai' value="<?= $memombr['mediator_nilai'] ?>" readonly>
            <!-- <div class="col-12 col-sm-6"> -->
            <div class="input-group mb-2">
              <label for="nama" class="form-label form-label-inline mb-1">Nama STNK&nbsp;&nbsp;</label><br>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="nama_stnk" name="nama_stnk" <?= $memombr['nama_stnk'] == 'Y' ? 'checked' : '' ?> disabled>
              </div>
              <label for="nama" class="form-label form-label-inline mb-1">Tipe/Unit/Warna Mobil&nbsp;&nbsp;</label><br>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="tipe_unit_warna" name="tipe_unit_warna" <?= $memombr['tipe_unit_warna'] == 'Y' ? 'checked' : '' ?> disabled>
              </div>
            </div>
            <!-- </div>
            <div class="col-12 col-sm-6"> -->
            <div class="input-group mb-2">
              <label for="nama" class="form-label form-label-inline mb-1">Pembelian Asuransi&nbsp;&nbsp;</label><br>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="beli_asuransi" name="beli_asuransi" <?= $memombr['beli_asuransi'] == 'Y' ? 'checked' : '' ?> disabled>
              </div>
              <label for="nama" class="form-label form-label-inline mb-1">Pembelian Accessories&nbsp;&nbsp;</label><br>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="beli_accessories" name="beli_accessories" <?= $memombr['beli_accessories'] == 'Y' ? 'checked' : '' ?> disabled>
              </div>
            </div>
            <label for="nama" class="form-label mb-1"><b><u>Uang Masuk</u></b></label>
            <br>
            <label for="nama" class="form-label mb-1">Booking Fee</label>
            <input type="text" style="text-align:right;" class='form-control mb-2' name='booking_fee' id='booking_fee' value="<?= $memombr['booking_fee'] ?>" readonly>
            <label for="nama" class="form-label mb-1">Lain-Lain</label>
            <textarea rows=3 class='form-control mb-2' name='ket_uang_lain' id='ket_uang_lain' readonly><?= $memombr['ket_uang_lain'] ?></textarea>
            <input type="text" style="text-align:right;" class='form-control mb-2' name='uang_lain' id='uang_lain' value="<?= $memombr['uang_lain'] ?>" readonly readonly>
            <div class="input-group">
              <div class="col-md-7">
                <label for="nama" class="form-label mb-1">Validasi Oleh</label>
                <input type="text" class='form-control mb-2' name='nama_validasi' id='nama_validasi' value="<?= $memombr['nama_validasi'] ?>" readonly>
              </div>
              <div class="col-md-5">
                <label for="nama" class="form-label mb-1">Tanggal Validasi</label>
                <input type="datetime-local" class='form-control mb-2' name='tgl_validasi' id='tgl_validasi' value="<?= $memombr['tgl_validasi'] ?>" readonly>
              </div>
            </div>
            <div class="input-group">
              <div class="col-md-7">
                <label for="nama" class="form-label mb-1">Disetujui Discount Oleh</label>
                <input type="text" class='form-control mb-2' name='nama_acc_discount' id='nama_acc_discount' value="<?= $memombr['nama_acc_discount'] ?>" readonly>
              </div>
              <div class="col-md-5">
                <label for="nama" class="form-label mb-1">Tanggal disetujui Discount</label>
                <input type="datetime-local" class='form-control mb-2' name='tgl_acc_discount' id='tgl_acc_discount' value="<?= $memombr['tgl_acc_discount'] ?>" readonly>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
        <?= form_close() ?>
      </div>
    </div>
  </div>

  <script>
    var myModal = document.getElementById('modaldetail')
    // var myInput = document.getElementById('nama')
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
    })
  </script>