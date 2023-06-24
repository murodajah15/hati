<?php
$session = session();
$pakai = session()->get('pakai');
$tambah = session()->get('tambah');
$edit = session()->get('edit');
$hapus = session()->get('hapus');
$proses = session()->get('proses');
$unproses = session()->get('unproses');
$cetak = session()->get('cetak');
?>

<div class="modal fade" id="detailestimasi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 100%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <input type="hidden" id='title' value="<?= $title ?>">
      </div>
      <div class="modal-body">
        <?php if ($tambah == 1) {
          if ($title == "Detail Data Estimasi") {
          }
        ?>
          <?= form_open('wo/simpanestimasi', ['class' => 'formdetailestimasi']) ?>

          <?= csrf_field(); ?>
          <div class="row mb-2 mt-4">
            <div class="col-12 col-sm-6">
              <?php
              date_default_timezone_set('Asia/Jakarta');
              $tglestimasi = date('Y-m-d H:i:s');
              $tglwo = date('Y-m-d H:i:s');
              ?>
              <label for="nama" class="form-label mb-1">No. Estimasi / Tanggal (M-D-Y)</label>
              <div class="input-group mb-1">
                <input type='text' class='form-control form-control-sm mb-2' value="<?= $estimasi['noestimasi'] ?>" id="noestimasijadi" name="noestimasijadi" readonly style="width: 5%">
                <input type="datetime-local" class='form-control form-control-sm mb-2' name='tanggal' id='tanggal' value="<?= $estimasi['tanggal'] ?>" style="width: 40%" readonly>
              </div>
              <label for="nama" class="form-label mb-0">No. Polisi</label>
              <div class="input-group mb-1">
                <input type="text" class="form-control form-control-sm" placeholder="No. Polisi" name="nopolisi" id="nopolisi" value="<?= $tbmobil['nopolisi'] ?>" readonly>
                <input type="text" style="width: 40%" class="form-control form-control-sm" name="norangka" id="norangka" value="<?= $tbmobil['norangka'] ?>" readonly>
              </div>
              <label for="nama" class="form-label mb-1">Customer</label>
              <div class="input-group mb-1">
                <input type="text" class="form-control form-control-sm mb-2" name="kdpemilik" id="kdpemilik" readonly style="width: 5%" value="<?= $tbmobil['kdpemilik'] ?>">
                <input type="text" class="form-control form-control-sm mb-2" name="nmpemilik" id="nmpemilik" readonly style="width: 40%" value="<?= $tbmobil['nmpemilik'] ?>">
              </div>
              <div class="invalid-feedback errornmpemilik">
              </div>
              <label for="nama" class="form-label mb-1">Jenis Service / Kilo Meter</label>
              <div class="input-group mb-1">
                <input type="text" class="form-control form-control-sm mb-2" value="<?= $estimasi['kdservice'] ?>" readonly>
                <input type="text" class="form-control form-control-sm mb-2" value="<?= $estimasi['km'] ?>" readonly>
              </div>

              <label for="nama" class="form-label mb-1">Aktifitas / Fasilitas</label>
              <div class="input-group mb-1">
                <input type="text" class="form-control form-control-sm mb-2" value="<?= $estimasi['aktifitas'] ?>" readonly>
                <input type="text" class="form-control form-control-sm mb-2" value="<?= $estimasi['fasilitas'] ?>" readonly>
              </div>
              <label for="keluhan" class="form-label mb-1">Keluhan</label>
              <textarea class="form-control" name="keluhan" id="keluhan" rows="4" readonly><?= $estimasi['keluhan'] ?></textarea>
              <div class="invalid-feedback errorKeluhan">
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <label for="keluhan" class="form-label mb-1">Nama Polis</label>
              <input type="text" class="form-control form-control-sm" name="nama_polis" id="nama_polis" value="<?= $tbmobil['nama_polis'] ?>" readonly>
              <label for="keluhan" class="form-label mb-1">No. Polis</label>
              <input type="text" class="form-control form-control-sm" name="no_polis" id="no_polis" value="<?= $tbmobil['no_polis'] ?>" readonly>
              <label for="keluhan" class="form-label mb-1">Tgl. Berakhir</label>
              <input type="date" class="form-control form-control-sm" name="tgl_akhir_polis" id="tgl_akhir_polis" value="<?= $tbmobil['tgl_akhir_polis'] ?>" readonly>
              <label for="keluhan" class="form-label mb-1">Asuransi</label>
              <div class="input-group mb-1">
                <input type="text" class="form-control form-control-sm" name="nama_asuransi" id="kode_asuransi" value="<?= $tbmobil['kode_asuransi'] ?>" readonly>
                <input type="text" style="width: 40%" class="form-control form-control-sm" name="kode_asuransi" id="nama_asuransi" value="<?= $tbmobil['nama_asuransi'] ?>" readonly>
              </div>
              <label for="keluhan" class="form-label mb-1">Alamat Asuransi</label>
              <textarea class="form-control" name="alamat_asuransi" rows="2" readonly><?= $tbmobil['alamat_asuransi'] ?></textarea>
              <label for="nama" class="form-label mb-0">Status WO</label>
              <br>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="klaim" name="klaim" <?= $estimasi['klaim'] > 0 ? "checked" : "" ?> disabled>
                <label class="form-check-label" for="flexCheckDefault">Klaim</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="" id="internal" name="internal" <?= $estimasi['internal'] > 0 ? "checked" : "" ?> disabled>
                <label class="form-check-label" for="flexCheckChecked">Internal</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="" id="inventaris" name="inventaris" <?= $estimasi['inventaris'] > 0 ? "checked" : "" ?> disabled>
                <label class="form-check-label" for="flexCheckDefault">Inventaris</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="" id="campaign" name="campaign" <?= $estimasi['campaign'] > 0 ? "checked" : "" ?> disabled>
                <label class="form-check-label" for="flexCheckChecked">Campaign</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="" id="booking" name="booking" <?= $estimasi['booking'] > 0 ? "checked" : "" ?> disabled>
                <label class="form-check-label" for="flexCheckChecked">Booking</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input mb-2" type="checkbox" value="" id="lain_lain" name="lain_lain" <?= $estimasi['lain_lain'] > 0 ? "checked" : "" ?> disabled>
                <label class="form-check-label" for="flexCheckChecked">Lain-lain</label>
              </div>
              <br>
              <label for="nama" class="form-label mb-1">NPWP</label>
              <input type="text" class="form-control form-control-sm mb-2" name="npwp" id="npwp" <?= $tbcustomer['npwp'] ?> readonly>
              <label for="nama" class="form-label mb-1">Contact Person</label>
              <input type="text" class="form-control form-control-sm mb-2" name="contact_person" id="contact_person" <?= $tbcustomer['contact_person'] ?> readonly>
              <label for="nama" class="form-label mb-1">Nomor Contact Person</label>
              <input type="text" class="form-control form-control-sm mb-2" name="no_contact_person" id="no_contact_person" <?= $tbcustomer['no_contact_person'] ?> readonly>
            </div>
          </div>
          <ul class="nav nav-tabs">
            <li class="nav-item">
              <a href="#summary" class="nav-link active" data-bs-toggle="tab">Summary</a>
            </li>
            <li class="nav-item">
              <a href="#sparepart" class="nav-link" data-bs-toggle="tab">Spare Part</a>
            </li>
            <li class="nav-item">
              <a href="#jasa" class="nav-link" data-bs-toggle="tab">Jasa</a>
            </li>
            <li class="nav-item">
              <a href="#bahan" class="nav-link" data-bs-toggle="tab">Bahan</a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade show active" id="summary">
              <br>
              <div class="row mb-2">
                <div class="col-12 col-sm-6">
                  <label for="nama" class="form-label mb-1">Total Spare Part</label>
                  <input type="text" class="form-control form-control-sm mb-2 text-end" id="grandtotal_part" readonly>
                  <label for="nama" class="form-label mb-1">Total Jasa</label>
                  <input type="text" class="form-control form-control-sm mb-2 text-end" id="grandtotal_jasa" readonly>
                  <label for="nama" class="form-label mb-1">Total Bahan</label>
                  <input type="text" class="form-control form-control-sm mb-2 text-end" id="grandtotal_bahan" readonly>
                  <label for="nama" class="form-label mb-1">Total</label>
                  <input type="text" class="form-control form-control-sm mb-2 text-end" id="total_s_j_b" readonly>
                </div>
                <div class="col-12 col-sm-6">
                  <label for="nama" class="form-label mb-1">DPP</label>
                  <input type="text" class="form-control form-control-sm mb-2 text-end" id="dpp" readonly>
                  <label for="nama" class="form-label mb-1">PPN</label>
                  <input type="text" class="form-control form-control-sm mb-2 text-end" id="ppn" readonly>
                  <label for="nama" class="form-label mb-1">Materai</label>
                  <input type="text" class="form-control form-control-sm mb-2 text-end" id="materai" readonly>
                  <label for="nama" class="form-label mb-1">Grand Total</label>
                  <input type="text" class="form-control form-control-sm mb-2 text-end" id="grantotal" readonly>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="sparepart">
              <br>
              <div class="row mb-2">
                <table class="table table-striped" style="width:100%">
                  <thead>
                    <tr>
                      <!-- <th>ID</th> -->
                      <th width="200">Kode Part</th>
                      <th width="400">Nama Spare Part</th>
                      <th width="100">Qty</th>
                      <th>Harga Satuan</th>
                      <th width="90">Disc (%)</th>
                      <th>Subtotal</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody">
                    <input type="hidden" name="id" id="id">
                    <td>
                      <div class="input-group mb-0">
                        <input type="text" class="form-control form-control-sm" placeholder="Kode Part" name="kodepart" id="kodepart" onblur="hit_ssubtotal()">
                        <button class="btn btn-outline-secondary btn-sm caripart" type="button" id="button-addon2"><i class="fa fa-search"></i></button>
                      </div>
                    </td>
                    <td><input type="text" name="namapart" id="namapart" class="form-control form-control-sm" value="" readonly></td>
                    <td><input type="text" name="qty" id="qty" class="form-control form-control-sm text-end" onkeyup="validAngka(this)" value=0 onblur="hit_ssubtotal()"></td>
                    <td><input type="text" name="harga" id="harga" class="form-control form-control-sm text-end" onkeyup="validAngka_no_titik(this)" value=0 onblur="hit_ssubtotal()"></td>
                    <td><input type="text" name="pr_discount" id="pr_discount" class="form-control form-control-sm text-end" onkeyup="validAngka(this)" value=0 onblur="hit_ssubtotal()"></td>
                    <td><input type="text" name="subtotal" id="subtotal" class="form-control form-control-sm text-end" value=0 readonly></td>
                    </td>
                    <td><button type="submit" id="btnaddpart" class="btn btn-primary btn-sm btnaddpart"><i class="fa fa-plus"></i></button></td>
                    </tbody>
                </table>
              </div>
              <div class="row mb-2">
                <!-- <div class="col-md-12">
                          <button type="button" id="btnremoveall" class="btn btn-danger btn-sm btnremoveall"><i class="fa fa-trash"></i>Remove All</button>
                        </div> -->
                <!-- <td><a href="#"><button type="button" class="btn btn-danger btn-sm" onclick="wo_part()"><i class='fa fa-trash'></i></button></a></td> -->
                <div id="table_wo_part"></div>

                <!-- <table id="table_wo_part" class="table table-striped" style="width:100%">
                  <thead>
                    <tr>
                      <!-- <th>ID</th> -->
                <!-- <th width="200">No. WO</th>
                <th width="200">User</th>
                </tr>
                </thead> -->
                <?php
                // // $query = "create temporary table temp_wo_part select * rom wo_part limit 0";
                // $db = \Config\Database::connect();
                // $query   = $db->query("create temporary table temp_wo_part select * from wo_part limit 0");
                // $query =  $db->query("insert into temp_wo_part (nowo,user) values ('$nowo_sementara','test')");
                // $builder = $db->table('temp_wo_part');
                // $query    = $builder->get();
                // $results = $query->getResultArray();
                // foreach ($results as $row) {
                //   echo '<tr><td>' . $row['nowo'] . '<td>' . $row['user'] . '</td>';
                // }
                ?>
                </tr>
                <tbody>
                </tbody>
                </table>

                <table class="table table-striped" style="width:100%">
                  <thead>
                    <tr>
                      <th width="200">Kode Part</th>
                      <th width="400">Nama Spare Part</th>
                      <th width="100">Qty</th>
                      <th>Harga Satuan</th>
                      <th width="90">Disc (%)</th>
                      <th>Subtotal</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody class="formtambahpart">
                  </tbody>
                </table>

                <div class="col-12 col-sm-6">
                  <table class="table table-striped" style="width:100%">
                    <thead>
                      <tr>
                        <!-- <th>ID</th> -->
                        <th width="150">Total Item</th>
                        <th width="150">Total QTY</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <td><input type="text" class="form-control form-control-sm text-end" name="total_item_part" id="total_item_part" value=0 readonly></td>
                      <td><input type="text" class="form-control form-control-sm text-end" name="total_qty_part" id="total_qty_part" value=0 readonly></td>
                      <td><input type="text" class="form-control form-control-sm text-end" name="total_part" id="total_part" value=0 readonly></td>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="jasa">
              <br>
              <div class="row mb-2">
                __ Jasa __
              </div>
            </div>
            <div class="tab-pane fade " id="bahan">
              <div class="row mb-2">
                __ Bahan __
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <!-- <button type="button" class="btn btn-secondary btn-sm mb-3" data-bs-dismiss="modal"><i class="fa fa-arrow-left"></i> Close</button> -->
          </div>
          <?= form_close() ?>
          <!-- </form> -->
      </div>
    <?php
        } else {
    ?>
      <?php
          $session = session();
          if (session()->get('nama') == "") {
      ?>
        <script>
          window.setTimeout(function() {
            window.location.href = "dashboard";
          }, 0);
        </script>
      <?php
          } else {
            echo "<p>Anda tidak berhak membuat Estimasi / WO</p>";
          }
      ?>

      <button class="btn btn-flat btn-primary btn-sm mb-3 tomboltambah" type="button" disabled><i class="fa fa-plus"></i> Tambah</button>
    <?php
        }
    ?>
    <!-- </div> -->
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>
    </div>
  </div>
</div>


<script>
  function hit_ssubtotal() {
    let $total_sementara = parseInt(document.getElementById("qty").value) * parseInt(document.getElementById("harga").value)
    let $discount = $total_sementara * (parseInt(document.getElementById("pr_discount").value) / 100)
    let subtotal = $total_sementara - $discount
    document.getElementById("subtotal").value = subtotal

  }

  function hit_subtotal() {
    let $qty = parseInt(document.getElementById("qty").value);
    let $harga = parseInt(document.getElementById("harga").value);
    let $pr_discount = parseInt(document.getElementById("pr_discount").value);
    let $subtotal = parseInt(document.getElementById("subtotal").value);
    document.getElementById("total_item_part").value = parseInt(document.getElementById("total_item_part").value) + 1
    document.getElementById("total_qty_part").value = parseInt(document.getElementById("total_qty_part").value) + $qty
    let $total_qty_part = parseInt(document.getElementById("total_qty_part").value)
    document.getElementById("total_part").value = parseInt(document.getElementById("total_part").value) + $subtotal
    let $total_part = parseInt(document.getElementById("total_part").value)
    let $grandtotal_part = $total_part
    document.getElementById("grandtotal_part").value = $grandtotal_part
    document.getElementById("total_s_j_b").value = $grandtotal_part
    document.getElementById("dpp").value = parseInt(document.getElementById("total_s_j_b").value)
    // let $dpp = parseInt(document.getElementById("dpp").value)
    // document.getElementById("ppn").value = $dpp * (11 / 100)
    // let $ppn = parseInt(document.getElementById("ppn").value)
    // let $materai = 6000
    // document.getElementById("grandtotal").value = $dpp + $ppn + $materai
  }

  $(document).ready(function() {});
</script>