<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>BP</title>
  <link href=" <?= base_url('/css/dataTables.bootstrap5.min.css') ?>" rel="stylesheet" />
  <link href=" <?= base_url('/css/styles.css') ?>" rel="stylesheet" />
  <link href=" <?= base_url('/css/animate.min.css') ?>" rel="stylesheet" />
  <script src="<?= base_url('/js/all.min.js') ?>" crossorigin="anonymous"></script>
  <link href="<?= base_url('/css/sweet-alert.css') ?>" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
</head>
<style>
  @page {
    margin: 20px;
    margin-top: 30px;
  }

  td {
    font-size: 10px;
  }
</style>
<?php
if ($pengajuandiscount['valid'] == 'N') {
  echo '<script>alert("Pengajuan discount belum divalidasi!")</script>';
  echo  "<script type='text/javascript'>";
  echo "window.close();";
  echo "</script>";
  exit();
}
?>

<div class="container-fluid">
  <div class="row">
    <p style="margin-top:5px; font-size:18px; margin-bottom:5px" align="center">
      <u>PENGAJUAN DISCOUNT</u>
    </p>
    <table cellspacing="1" cellpadding="1" height="1">
      <tr>
        <td width="100" style="font-size:12px;"></td>
        <td width="5" style="font-size:12px;"></td>
        <td width="10" style="font-size:12px;"></td>
        <td width="50" style="font-size:12px;"></td>
        <td width="300" style="font-size:12px;"></td>
      <tr>
      <tr>
        <td width="100" style="font-size:12px;">Nama Pemesan</td>
        <td width="5" style="font-size:12px;">:</td>
        <td colspan="3" style="font-size:12px;"> <?= $pengajuandiscount['nama_pemesan'] ?></td>
      <tr>
        <td width="100" style="font-size:12px;">Nama STNK</td>
        <td width="5" style="font-size:12px;">:</td>
        <td colspan="3" style="font-size:12px;"><?= $pengajuandiscount['nama_stnk'] ?></td>
      <tr>
        <td width="100" style="font-size:12px;">Pembayaran CASH/CREDIT</td>
        <td width="5" style="font-size:12px;">:</td>
        <td colspan="3" style="font-size:12px;"><?= $pengajuandiscount['pembayaran'] ?></td>
      <tr>
        <td width="100" style="font-size:12px;">Tipe/Warna</td>
        <td width="5" style="font-size:12px;">:</td>
        <td colspan="3" style="font-size:12px;"><?= $pengajuandiscount['tipe'] . ' / ' . $pengajuandiscount['warna'] ?></td>
      <tr>
        <td width="100" style="font-size:12px;">Pembelian Accessories</td>
        <td width="5" style="font-size:12px;">:</td>
        <td colspan="3" style="font-size:12px;"><?= $pengajuandiscount['pembelian_accessories'] ?></td>
      <tr>
        <td width="100" style="font-size:12px;">Booking Fee</td>
        <td width="5" style="font-size:12px;">:</td>
        <td>Rp.</td>
        <td style="font-size:12px;text-align:right"><?= number_format($pengajuandiscount['booking_fee'], 0, '.', ',') ?></td>
        <td></td>
      <tr>
        <td width="100" style="font-size:12px;">Discount Team Harga</td>
        <td width="5" style="font-size:12px;">:</td>
        <td>Rp.</td>
        <td style="font-size:12px;text-align:right"><?= number_format($pengajuandiscount['discount_team_harga'], 0, '.', ',') ?></td>
        <td></td>
      <tr>
        <td width="100" style="font-size:12px;">Discount Cash Back</td>
        <td width="5" style="font-size:12px;">:</td>
        <td>Rp.</td>
        <td style="font-size:12px;text-align:right"><?= number_format($pengajuandiscount['discount_cashback'], 0, '.', ',') ?></td>
        <td></td>
      <tr>
        <td width="100" style="font-size:12px;">Paket</td>
        <td width="5" style="font-size:12px;">:</td>
        <td>Rp.</td>
        <td style="font-size:12px;text-align:right"><?= number_format($pengajuandiscount['paket'], 0, '.', ',') ?></td>
        <td></td>
      <tr>
        <td width="100" style="font-size:12px;">Mediator</td>
        <td width="5" style="font-size:12px;">:</td>
        <td>Rp.</td>
        <td style="font-size:12px;text-align:right"><?= number_format($pengajuandiscount['mediator'], 0, '.', ',') ?></td>
        <td></td>
      <tr>
        <td width="100" style="font-size:12px;">Lain-lain</td>
        <td width="5" style="font-size:12px;">:</td>
        <td>Rp.</td>
        <td style="font-size:12px;text-align:right"><?= number_format($pengajuandiscount['lain_lain'], 0, '.', ',') ?></td>
        <td></td>
      <tr>
    </table>
  </div>
</div>
<p style="font-size:14px">Disetujui oleh :</p>
<br><br><br>
<table cellspacing="1" cellpadding="0" height="1">
  <tr>
    <td width="150" style="font-size:12px;text-align:center"><u><?= '( ' . strtoupper($pengajuandiscount['approv_spv']) . ' )' ?></u></td>
    <td width="150" style="font-size:12px;text-align:center"><u><?= '( ' . strtoupper($pengajuandiscount['approv_sm']) . ' )' ?></u></td>
    <td width="150" style="font-size:12px;text-align:center"><u><?= '( ' . strtoupper($pengajuandiscount['approv_dir']) . ' )' ?></u></td>
  </tr>
  <!-- <tr>
    <td width="150" style="font-size:12px;text-align:center"><?= '(________________________)' ?></td>
    <td width="150" style="font-size:12px;text-align:center"><?= '(________________________)' ?></td>
    <td width="150" style="font-size:12px;text-align:center"><?= '(________________________)' ?></td>
  </tr> -->
  <tr>
    <td width="150" style="font-size:12px;text-align:center"><?= 'SPV' ?></td>
    <td width="150" style="font-size:12px;text-align:center"><?= 'SM' ?></td>
    <td width="150" style="font-size:12px;text-align:center"><?= 'Direktur' ?></td>
  </tr>
</table>

<script src="<?= base_url('vendor/Bootstrap-5-5.1.3/js/bootstrap.bundle.min.js') ?>" crossorigin="anonymous"></script>
<script src="<?= base_url('/js/scripts.js') ?>"></script>
<script src="<?= base_url('/vendor/chart.js/Chart.min.js') ?>" crossorigin="anonymous"></script>
<script src="<?= base_url('/assets/demo/chart-area-demo.js') ?>"></script>
<script src="<?= base_url('/assets/demo/chart-bar-demo.js') ?>"></script>
<script src="<?= base_url('js/jquery-3.5.1.js') ?>" rel="stylesheet"></script>
<script src="<?= base_url('js/jquery.dataTables.min.js') ?>" rel="stylesheet"></script>
<script src="<?= base_url('js/dataTables.bootstrap5.min.js') ?>" rel="stylesheet"></script>
<script src="<?= base_url('/js/sweet-alert.min.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>