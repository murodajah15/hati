<script src="<?= base_url('/js/autoNumeric.js') ?>" crossorigin="anonymous"></script>

<!-- Modal -->
<div class="modal fade" role="dialog" id="modaltambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 90%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('mohfaktur/simpandata', ['class' => 'formmohfaktur']) ?>
      <?php
      $nomemo = "MF" . uniqid();
      ?>
      <div class="modal-body">
        <div class="row mb-2">
          <div class="col-12 col-sm-6">
            <?php
            date_default_timezone_set('Asia/Jakarta');
            // $tgl = date('Y-m-d H:i:s');
            $tgl = date('Y-m-d');
            ?>
            <div class="input-group">
              <div class="col-md-4">
                <label for="nama" class="form-label mb-1">No. Pengajuan</label>
                <input type='text' class='form-control form-control-sm mb-2' value="AUTO GENERATE" id="nomor" name="nomor" readonly style="width: 100%">
              </div>
              <div class="col-md-4">
                <label for="nama" class="form-label mb-1">Tanggal (M-D-Y)</label>
                <input type="date" class='form-control form-control-sm mb-2' name='tanggal' id='tanggal' value="<?= $tgl ?>" style="width: 100%">
                <div class="invalid-feedback errorTanggal">
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-12">
              <label for="nama" class="form-label mb-0"><b><u>MEMO</u></b></label>
              <div class="input-group mb-2">
                <input type="text" class="form-control" placeholder="No. Memo" name="nomemo" id="nomemo" readonly>
                <button class="btn btn-outline-secondary btn-sm" type="button" id="carimemo">Cari</button>
                <input type="datetime-local" class="col-8" class="form-control" placeholder="Tgl. Memo" name="tglmemo" id="tglmemo" readonly>
              </div>
              <label for="nama" class="form-label mb-0"><b><u>SPK</u></b></label>
              <div class="input-group mb-2">
                <input type="text" class="form-control" placeholder="No. SPK" name="nospk" id="nospk" readonly>
                <input type="datetime-local" class="col-8" class="form-control" placeholder="Tgl. spk" name="tglspk" id="tglspk" readonly>
                <div class="invalid-feedback errorNospk">
                </div>
              </div>
            </div>
            <div class="input-group">
              <div class="col-md-12">
                <label for="nama" class="form-label mb-0">Sales</label>
                <div class="input-group mb-2">
                  <input type="text" class="form-control" placeholder="Kode Sales" name="kdsales" id="kdsales">
                  <button class="btn btn-outline-secondary btn-sm" type="button" id="carisales">Cari</button>
                  <input type="text" class="col-8" class="form-control" placeholder="Nama Sales" name="nmsales" id="nmsales" readonly>
                </div>
              </div>
              <div class="col-md-12">
                <label for="nama" class="form-label mb-0">Supervisor</label>
                <div class="input-group mb-2">
                  <input type="text" class="form-control" placeholder="Kode Supervisor" name="kdspv" id="kdspv">
                  <button class="btn btn-outline-secondary btn-sm" type="button" id="carispv">Cari</button>
                  <input type="text" class="col-8" class="form-control" placeholder="Nama Supervisor" name="nmspv" id="nmspv" readonly>
                </div>
              </div>
              <div class="col-12 col-sm-12">
                <div class="input-group">
                  <div class="col-12 col-sm-4">
                    <label for="nama" class="form-label mb-0 labeltipe">Tipe Faktur&nbsp;&nbsp;</label>
                  </div>
                  <div class="col-12 col-sm-8">
                    <div class="input-group">
                      <div class="col-12 col-sm-4">
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="tipe_faktur" id="tipe_faktur" value='Personal' checked>
                          <label class="form-check-label" for="tipe_faktur1">
                            Personal
                          </label>
                        </div>
                      </div>
                      <div class="col-12 col-sm-8">
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="tipe_faktur" id="tipe_faktur" value='Company'>
                          <label class="form-check-label" for="tipe_faktur2">
                            Company
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="input-group">
                    <div class="col-12 col-sm-4">
                      <label for="nama" class="form-label mb-0 labeltipe">Tipe Pelanggan&nbsp;&nbsp;</label>
                    </div>
                    <div class="col-12 col-sm-8">
                      <div class="input-group">
                        <div class="col-12 col-sm-4">
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tipe_pelanggan" id="tipe_pelanggan" value='Personal' checked>
                            <label class="form-check-label" for="tipe_pelanggan1">
                              Personal
                            </label>
                          </div>
                        </div>
                        <div class="col-12 col-sm-8">
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tipe_pelanggan" id="tipe_pelanggan" value='Fleet'>
                            <label class="form-check-label" for="tipe_pelanggan2">
                              Fleet
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="input-group">
                      <div class="col-12 col-sm-4">
                        <label for="nama" class="form-label mb-0 labeltipe">Status Pelanggan&nbsp;&nbsp;</label>
                      </div>
                      <div class="col-12 col-sm-8">
                        <div class="input-group">
                          <div class="col-12 col-sm-4">
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="status_pelanggan" id="status_pelanggan" value='Baru' checked>
                              <label class="form-check-label" for="status_pelanggan1">
                                Baru
                              </label>
                            </div>
                          </div>
                          <div class="col-12 col-sm-8">
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="status_pelanggan" id="status_pelanggan" value='Lama'>
                              <label class="form-check-label" for="status_pelanggan2">
                                Lama
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <label for="nama" class="form-label mb-0"><b><u>DATA PEMESAN</u></b></label><br>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" role="switch" name="sama_spk" id="sama_spk">
                      <label class="form-check-label" for="flexSwitchCheck"><b>Data Pemesan sama dengan data di SPK</b></label>
                    </div>
                    <div class="input-group mb-2">
                      <input type="text" class="form-control" placeholder="Pemesan" name="kdpemesan" id="kdpemesan" readonly>
                      <input type="text" class="col-8" class="form-control" name="nmpemesan" id="nmpemesan" readonly>
                    </div>
                    <label for="nama" class="form-label mb-0">Nomor KTP</label>
                    <input type="text" class="form-control mb-1" name="nik_pemesan" id="nik_pemesan" readonly>
                    <label for="nama" class="form-label mb-0">Alamat</label>
                    <input type="text" class="form-control mb-1" name="alamat_pemesan" id="alamat_pemesan" readonly>
                    <label for="nama" class="form-label mb-0">Kelurahan</label>
                    <input type="text" class="form-control mb-1" name="kel_pemesan" id="kel_pemesan" readonly>
                    <label for="nama" class="form-label mb-0">Kecamatan</label>
                    <input type="text" class="form-control mb-1" name="kec_pemesan" id="kec_pemesan" readonly>
                    <label for="nama" class="form-label mb-0">Kota</label>
                    <input type="text" class="form-control mb-1" name="kota_pemesan" id="kota_pemesan" readonly>
                  </div>
                  <div class="input-group">
                    <div class="col-md-8">
                      <label for="nama" class="form-label mb-0">Provinsi</label>
                      <input type="text" class="form-control mb-1" name="provinsi_pemesan" id="provinsi_pemesan" readonly>
                    </div>
                    <div class="col-md-4">
                      <label for="nama" class="form-label mb-0">Kode Pos</label>
                      <input type="text" class="form-control mb-1" name="kodepos_pemesan" id="kodepos_pemesan" readonly>
                    </div>
                  </div>
                  <div class="input-group mb-2">
                    <div class="col-md-4">
                      <label for="nama" class="form-label mb-0">No. HP</label>
                      <input type="text" class="form-control mb-1" name="hp_pemesan" id="hp_pemesan" readonly>
                    </div>
                    <div class="col-md-8">
                      <label for="nama" class="form-label mb-0">Email</label>
                      <input type="text" class="form-control mb-1" name="email_pemesan" id="email_pemesan" readonly>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <label for="nama" class="form-label mb-0"><b><u>DATA FAKTUR</u></b></label>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" role="switch" name="sama_pemesan" id="sama_pemesan">
                      <label class="form-check-label" for="flexSwitchCheck"><b>Sama dengan data Pemesan</b></label>
                    </div>
                    <div class="input-group mb-2">
                      <div class="col-md-6">
                        <label for="nama" class="form-label mb-0">Nomor Kartu Keluarga</label>
                        <input type="text" class="form-control mb-2" name="nkk" id="nkk" readonly>
                      </div>
                      <div class="col-md-6">
                        <label for="nama" class="form-label mb-0">Nomor KTP</label>
                        <input type="text" class="form-control mb-2" name="nik_stnk" id="nik_stnk" readonly>
                      </div>
                    </div>
                    <div class="input-group mb-2">
                      <input type="text" class="form-control" placeholder="STNK a/n" name="kdstnk" id="kdstnk" readonly>
                      <input type="text" class="col-8" class="form-control" name="nmstnk" id="nmstnk" readonly>
                    </div>
                    <label for="nama" class="form-label mb-0">Alamat</label>
                    <input type="text" class="form-control mb-1" name="alamat_stnk" id="alamat_stnk" readonly>
                    <label for="nama" class="form-label mb-0">Kelurahan</label>
                    <input type="text" class="form-control mb-1" name="kel_stnk" id="kel_stnk" readonly>
                    <label for="nama" class="form-label mb-0">Kecamatan</label>
                    <input type="text" class="form-control mb-1" name="kec_stnk" id="kec_stnk" readonly>
                    <label for="nama" class="form-label mb-0">Kota</label>
                    <input type="text" class="form-control mb-1" name="kota_stnk" id="kota_stnk" readonly>
                  </div>
                  <div class="input-group">
                    <div class="col-md-8">
                      <label for="nama" class="form-label mb-0">Provinsi</label>
                      <input type="text" class="form-control mb-1" name="provinsi_stnk" id="provinsi_stnk" readonly>
                    </div>
                    <div class="col-md-4">
                      <label for="nama" class="form-label mb-0">Kode Pos</label>
                      <input type="text" class="form-control mb-1" name="kodepos_stnk" id="kodepos_stnk" readonly>
                    </div>
                  </div>
                  <div class="input-group">
                    <div class="col-md-4">
                      <label for="nama" class="form-label mb-0">No. HP</label>
                      <input type="text" class="form-control mb-1" name="hp_stnk" id="hp_stnk" readonly>
                    </div>
                    <div class="col-md-8">
                      <label for="nama" class="form-label mb-0">Email</label>
                      <input type="text" class="form-control mb-1" name="email_stnk" id="email_stnk" readonly>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6">
            <label for="nama" class="form-label mb-0"><b><u>DATA KENDARAAN</u></b></label>
            <div class="col-12 col-sm-12">
              <label for="nama" class="form-label mb-0">Model</label>
              <div class="input-group mb-2">
                <input type="text" class="form-control mb-1" name="kdmodel" id="kdmodel" readonly>
                <input type="text" class="form-control mb-1" name="nmmodel" id="nmmodel" readonly>
              </div>
              <label for="nama" class="form-label mb-0">Tipe</label>
              <div class="input-group mb-2">
                <input type="text" class="form-control mb-1" name="kdtipe" id="kdtipe" readonly>
                <input type="text" class="form-control mb-1" name="nmtipe" id="nmtipe" readonly>
              </div>
              <label for="nama" class="form-label mb-0">Warna</label>
              <div class="input-group">
                <input type="text" class="form-control mb-1" name="kdwarna" id="kdwarna" readonly>
                <input type="text" class="form-control mb-1" name="nmwarna" id="nmwarna" readonly>
              </div>
              <div class="input-group">
                <div class="col-md-7">
                  <label for="nama" class="form-label mb-0">No. Rangka</label>
                  <input type="text" class="form-control mb-1" name="norangka" id="norangka" readonly>
                </div>
                <div class="col-md-5">
                  <label for="nama" class="form-label mb-0">No. Mesin</label>
                  <input type="text" class="form-control mb-1" name="nomesin" id="nomesin" readonly>
                </div>
              </div>

              <label for="nama" class="form-label mb-1">Accessories</label>
              <textarea rows=2 class='form-control mb-2' name='accessories' id='accessories'></textarea>
              <label for="nama" class="form-label mb-1">Harga</label>
              <input type="text" style="text-align:right;" class='form-control mb-2' name='harga' id='harga' value='0'>
              <div class="input-group">
                <div class="col-md-6">
                  <label for="nama" class="form-label mb-1">Down Payment</label>
                  <input type="text" style="text-align:right;" class='form-control mb-2' name='dp' id='dp' value='0'>
                </div>
                <div class="col-md-6">
                  <label for="nama" class="form-label mb-1">Tanggal Pembayaran DP</label>
                  <input type="date" style="text-align:right;" class='form-control mb-2' name='tgl_dp' id='tgl_dp'>
                </div>
              </div>
              <div class="input-group">
                <div class="col-md-6">
                  <label for="nama" class="form-label mb-1">ETA</label>
                  <input type="datetime-local" style="text-align:right;" class='form-control mb-2' name='eta' id='eta'>
                </div>
                <div class="col-md-6">
                  <label for="nama" class="form-label mb-1">ETD</label>
                  <input type="datetime-local" style="text-align:right;" class='form-control mb-2' name='etd' id='etd'>
                </div>
              </div>
              <div class="input-group">
                <div class="col-12 col-sm-4">
                  <label for="nama" class="form-label mb-0 labeltipe">Paket&nbsp;&nbsp;</label>
                </div>
                <div class="col-12 col-sm-8">
                  <div class="input-group">
                    <div class="col-12 col-sm-3">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="paket" id="paket" value='Pahe 1' checked>
                        <label class="form-check-label" for="paket1">
                          Pahe 1
                        </label>
                      </div>
                    </div>
                    <div class="col-12 col-sm-3">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="paket" id="paket" value='Pahe 2'>
                        <label class="form-check-label" for="paket2">
                          Pahe 2
                        </label>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="paket" id="paket" value='Extented Warranty'>
                        <label class="form-check-label" for="paket3">
                          Extended Warranty
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <label for="nama" class="form-label mb-1"><b><u>INFORMASI TAMBAHAN</u></b></label>
              <div class="input-group">
                <div class="col-12 col-sm-4">
                  <label for="nama" class="form-label mb-0 labeltipe">Jenis Kelamin&nbsp;&nbsp;</label>
                </div>
                <div class="col-12 col-sm-8">
                  <div class="input-group">
                    <div class="col-12 col-sm-3">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jekel" id="jekel" value='Pria' checked>
                        <label class="form-check-label" for="jekel1">
                          Pria
                        </label>
                      </div>
                    </div>
                    <div class="col-12 col-sm-3">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jekel" id="jekel" value='Wanita'>
                        <label class="form-check-label" for="jekel2">
                          Wanita
                        </label>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6">
                    </div>
                  </div>
                </div>
              </div>
              <label for="nama" class="form-label mb-1">Tanggal Lahir</label>
              <input type="date" style="text-align:right;" class='form-control mb-2' name='tgllahir' id='tgllahir'>
              <div class="input-group">
                <div class="col-12 col-sm-4">
                  <label for="nama" class="form-label mb-0 labeltipe">Status Pernikahan&nbsp;&nbsp;</label>
                </div>
                <div class="col-12 col-sm-8">
                  <div class="input-group">
                    <div class="col-12 col-sm-3">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status_menikah" id="status_menikah" value='Menikah' checked>
                        <label class="form-check-label" for="status_menikah1">
                          Menikah
                        </label>
                      </div>
                    </div>
                    <div class="col-12 col-sm-5">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status_menikah" id="status_menikah" value='Belum Menikah'>
                        <label class="form-check-label" for="status_menikah2">
                          Belum Menikah
                        </label>
                      </div>
                    </div>
                    <div class="col-12 col-sm-4">
                    </div>
                  </div>
                </div>
              </div>
              <div class="input-group">
                <div class="col-12 col-sm-4">
                  <label for="nama" class="form-label mb-0 labeltipe">Jumlah Keluarga Inti&nbsp;&nbsp;</label>
                </div>
                <div class="col-12 col-sm-8">
                  <div class="input-group">
                    <div class="col-12 col-sm-2">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jumlah_keluarga" id="jumlah_keluarga" value='1' checked>
                        <label class="form-check-label" for="jumlah_keluarga1">
                          1
                        </label>
                      </div>
                    </div>
                    <div class="col-12 col-sm-2">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jumlah_keluarga" id="jumlah_keluarga" value='2'>
                        <label class="form-check-label" for="jumlah_keluarga2">
                          2
                        </label>
                      </div>
                    </div>
                    <div class="col-12 col-sm-2">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jumlah_keluarga" id="jumlah_keluarga" value='3'>
                        <label class="form-check-label" for="jumlah_keluarga2">
                          3
                        </label>
                      </div>
                    </div>
                    <div class="col-12 col-sm-2">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jumlah_keluarga" id="jumlah_keluarga" value='4'>
                        <label class="form-check-label" for="jumlah_keluarga2">
                          4
                        </label>
                      </div>
                    </div>
                    <div class="col-12 col-sm-2">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jumlah_keluarga" id="jumlah_keluarga" value='5'>
                        <label class="form-check-label" for="jumlah_keluarga2">
                          >=5
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <label for="nama" class="form-label mb-1">Agama</label>
            <select class="form-select form-select-mb2 " name="agama" id="agama">
              <option value="">[Pilih Agama]
                <?php
                foreach ($tbagama as $key) {
                  echo "<option value=$key[nama]>$key[nama]</option>";
                }
                ?>
              </option>
            </select>
            <label for="nama" class="form-label mb-1 mt-2">Pekerjaan</label>
            <select class="form-select" name="pekerjaan" id="pekerjaan">
              <option value="">[Pilih Pekerjaan]</option>
              <option value="Tentara">Tentara</option>
              <option value="Dokter">Dokter</option>
              <option value="Pegawai Pemerintah">Pegawai Pemerintah</option>
              <option value="Pegawai Swasta">Pegawai Swasta</option>
              <option value="Arsitek">Arsitek</option>
              <option value="Pelajar">Pelajar</option>
              <option value="Guru/Dosen">Guru/Dosen</option>
              <option value="Lain-Lain">Lain-Lain</option>
            </select>
            <div class="input-group">
              <div class="col-12 col-sm-4">
                <label for="nama" class="form-label mb-0 labeltipe">Metode Pembelian&nbsp;&nbsp;</label>
              </div>
              <div class="col-12 col-sm-8">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="metode_pembelian" id="metode_pembelian" value='Mobil Pertama' checked>
                  <label class="form-check-label" for="metode_pembelian1">
                    Mobil Pertama
                  </label>
                </div>
                <div class="input-group">
                  <div class="col-md-5">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="metode_pembelian" id="metode_pembelian" value='Mobil Tambahan'>
                      <label class="form-check-label" for="metode_pembelian2">
                        Mobil Tambahan
                      </label>
                    </div>
                  </div>
                  <div class="col-md-7">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="checkbox" name="tambah_honda" id="tambah_honda">
                      <label class="form-check-label" for="metode_pembelian2">
                        Honda
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="checkbox" name="tambah_nonhonda" id="tambah_nonhonda">
                      <label class="form-check-label" for="metode_pembelian2">
                        Bukan Honda
                      </label>
                    </div>
                  </div>
                </div>
                <div class="input-group">
                  <div class="col-md-5">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="metode_pembelian" id="metode_pembelian" value='Mobil Pengganti'>
                      <label class="form-check-label" for="metode_pembelian2">
                        Mobil Pengganti
                      </label>
                    </div>
                  </div>
                  <div class="col-md-7">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="checkbox" name="ganti_honda" id="ganti_honda">
                      <label class="form-check-label" for="metode_pembelian2">
                        Honda
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="checkbox" name="ganti_nonhonda" id="ganti_nonhonda">
                      <label class="form-check-label" for="metode_pembelian2">
                        Bukan Honda
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="input-group">
              <div class="col-12 col-sm-4">
                <label for="nama" class="form-label mb-0 labeltipe">Metode Pembayaran&nbsp;&nbsp;</label>
              </div>
              <div class="col-12 col-sm-8">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="metode_pembayaran" id="metode_pembayaran" value='Cash' checked>
                  <label class="form-check-label" for="metode_pembayaran1">
                    Cash
                  </label>
                </div>
                <div class="input-group">
                  <div class="col-md-5">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="metode_pembayaran" id="metode_pembayaran" value='Credit'>
                      <label class="form-check-label" for="metode_pembayaran2">
                        Credit
                      </label>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <label for="nama" class="form-label mb-0 labeltipe">Perusahaan Leasing :</label>
                  <input type="text" class="form-control mb-1" name="leasing" id="leasing">
                </div>
                <div class="input-group">
                  <div class="col-md-8">
                    <label for="nama" class="form-label mb-0 labeltipe">Tenor Pembayaran :</label>
                    <input type="text" class="form-control mb-1" name="tenor" id="tenor">
                  </div>
                  <div class="col-md-4">
                    <label for="nama" class="form-label mb-0 labeltipe">Bulan</label>
                    <input type="text" class="form-control mb-1" name="bulan" id="bulan">
                  </div>
                </div>
                <div class="input-group">
                  <div class="col-12 col-sm-4">
                    <label for="nama" class="form-label mb-0 labeltipe">Asuransi : </label>
                  </div>
                  <div class="col-12 col-sm-8">
                    <div class="input-group">
                      <div class="col-12 col-sm-3">
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="asuransi" id="asuransi" value='Ya' checked>
                          <label class="form-check-label" for="asuransi1">
                            Ya
                          </label>
                        </div>
                      </div>
                      <div class="col-12 col-sm-5">
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="asuransi" id="asuransi" value='Tidak'>
                          <label class="form-check-label" for="asuransi2">
                            Tidak
                          </label>
                        </div>
                      </div>
                      <div class="col-12 col-sm-4">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <label for="nama" class="form-label mb-0">Sales Manager</label>
              <div class="input-group mb-2">
                <input type="text" class="form-control" placeholder="Kode SM" name="kdsm" id="kdsm" readonly>
                <!-- <button class="btn btn-outline-secondary btn-sm" type="button" id="carism">Cari</button> -->
                <input type="text" class="col-8" placeholder="Nama SM" name="nmsm" id="nmsm" readonly>
              </div>
            </div>
            <div class="col-md-12">
              <label for="nama" class="form-label mb-0">Admin</label>
              <input type="text" class="form-control" placeholder="Admin" name="admin" id="admin">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" id="btnsimpan" class="btn btn-primary btnsimpan">Simpan</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      </div>
    </div>
    <?= form_close() ?>
  </div>
</div>
</div>
</div>

<script>
  var myModal = document.getElementById('modaltambah')
  var myInput = document.getElementById('kode')
  myModal.addEventListener('shown.bs.modal', function() {
    myInput.focus()
  })

  $(document).ready(function() {
    $('#harga').autoNumeric('init', {
      aSep: ',',
      aDec: '.',
      mDec: '0'
    })
    $('#dp').autoNumeric('init', {
      aSep: ',',
      aDec: '.',
      mDec: '0'
    })

    $('.formmohfaktur').submit(function(e) {
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
            if (response.error.tanggal) {
              $('#tanggal').addClass('is-invalid');
              $('.errorTanggal').html(response.error.tanggal);
            } else {
              $('.errorTanggal').fadeOut();
              $('#tanggal').removeClass('is-invalid');
              $('#tanggal').addClass('is-valid');
            }
            if (response.error.nospk) {
              $('#nospk').addClass('is-invalid');
              $('.errorNospk').html(response.error.nospk);
            } else {
              $('.errorNospk').fadeOut();
              $('#nospk').removeClass('is-invalid');
              $('#nospk').addClass('is-valid');
            }
          } else {
            // alert(response.sukses);
            $('#modaltambah').modal('hide');
            // swal({
            //   title: "Data berhasil disimpan",
            //   text: "",
            //   icon: "success",
            //   buttons: true,
            //   dangerMode: true,
            // })

            swal({
              title: "Data Berhasil ditambah ",
              text: "",
              icon: "success"
            })
            reload_table();
            // .then(function() {
            //   window.location.href = '/mohfaktur';
            // });

            // window.location = '/mohfaktur';
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      });
      return false;
    })
  });

  $('#carimemo').click(function(e) {
    e.preventDefault();
    cari_data_memo();
  })

  $('#nomemo').on('blur', function(e) {
    let cari = $(this).val()
    let cari1 = $('#nomemo').val()
    if (cari === "") {
      cari = "XXXXXXXXXXXXXXXXXXXXXXXXX";
    }
    $.ajax({
      url: "<?= site_url('mohfaktur/repl_memo') ?>",
      type: 'post',
      data: {
        'nomemo': cari
      },
      success: function(data) {
        let data_response = JSON.parse(data);
        if (data_response['nomemo'] == '') {
          $('#nomemo').val('');
          $('#tglmemo').val('');

          cari_data_memo();
          return;
        } else {
          $('#nomemo').val(data_response['nomemo']);
          $('#tglmemo').val(data_response['tglmemo']);
        }
      },
      error: function() {
        $('#nomemo').val('');
        $('#tglmemo').val('');
        cari_data_memo();
        return;
        // console.log('file not fount');
      }
    })
    // console.log(cari);
  })

  function cari_data_memo() {
    $.ajax({
      url: "<?= site_url('mohfaktur/cari_data_memo') ?>",
      dataType: "json",
      success: function(response) {
        $('.viewmodal1').html(response.data).show();
        $('#modalcarimemo').modal('show');
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }
</script>