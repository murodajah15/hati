<?php
$total_part = 0;
$ftotal_part = '';
$total_bahan = 0;
$ftotal_bahan = '';
$total_jasa = 0;
$ftotal_jasa = '';
$total_opl = 0;
$ftotal_opl = '';
foreach ($faktur_bp as $r) {
  $pr_ppn = $r['pr_ppn'];
}
foreach ($summary_part as $r) {
  $total_part = $total_part + $r['subtotal'];
  $ftotal_part = number_format($total_part, 0, ".", ".");
}
foreach ($summary_jasa as $r) {
  $total_jasa = $total_jasa + $r['subtotal'];
  $ftotal_jasa = number_format($total_jasa, 0, ".", ".");
}
foreach ($summary_bahan as $r) {
  $total_bahan = $total_bahan + $r['subtotal'];
  $ftotal_bahan = number_format($total_bahan, 0, ".", ".");
}
foreach ($summary_opl as $r) {
  $total_opl = $total_opl + $r['subtotal'];
  $ftotal_opl = number_format($total_opl, 0, ".", ".");
}
$grandtotal = $total_part + $total_jasa + $total_bahan + $total_opl;
$fgrandtotal = number_format($grandtotal, 0, ".", ".");

$ppn = $grandtotal * ($pr_ppn / 100);
$fppn = number_format($ppn, 0, ".", ".");

$grandtotal_ppn = $grandtotal + $ppn;
$fgrandtotal_ppn = number_format($grandtotal_ppn, 0, ".", ".");

?>
<div class="row mt-2 mb-2">
  <div class="col-12 col-sm-6">
    <label for="nama" class="form-label mb-1">Total Spare Part</label>
    <input type="text" class="form-control form-control-sm mb-2 text-end" id="grandtotal_part" value="<?= $ftotal_part ?>" readonly>
    <label for="nama" class="form-label mb-1">Total Jasa</label>
    <input type="text" class="form-control form-control-sm mb-2 text-end" id="grandtotal_jasa" value="<?= $ftotal_jasa ?>" readonly>
    <label for="nama" class="form-label mb-1">Total Bahan</label>
    <input type="text" class="form-control form-control-sm mb-2 text-end" id="grandtotal_bahan" value="<?= $ftotal_bahan ?>" readonly>
    <label for="nama" class="form-label mb-1">Total OPL</label>
    <input type="text" class="form-control form-control-sm mb-2 text-end" id="grandtotal_opl" value="<?= $ftotal_opl ?>" readonly>
    <label for="nama" class="form-label mb-1">Total</label>
    <input type="text" class="form-control form-control-sm mb-2 text-end" id="total_s_j_b" value="<?= $fgrandtotal ?>" readonly>
  </div>
  <div class="col-12 col-sm-6">
    <label for="nama" class="form-label mb-1">DPP</label>
    <input type="text" class="form-control form-control-sm mb-2 text-end" id="dpp" value="<?= $fgrandtotal ?>" readonly>
    <label for="nama" class="form-label mb-1">PPN</label>
    <input type="text" class="form-control form-control-sm mb-2 text-end" id="ppn" value="<?= $fppn ?>" readonly>
    <label for="nama" class="form-label mb-1">Materai</label>
    <input type="text" class="form-control form-control-sm mb-2 text-end" id="materai" readonly>
    <label for="nama" class="form-label mb-1">Grand Total</label>
    <input type="text" class="form-control form-control-sm mb-2 text-end" id="grantotal" value="<?= $fgrandtotal_ppn ?>" readonly>
  </div>
</div>