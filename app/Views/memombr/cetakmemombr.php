</html>

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
    margin-top: 20px;
  }

  td {
    font-size: 10px;
  }
</style>
<style>
  .solid {
    border-left: 1px red solid;
    height: 170px;
    width: 0px;
    display: inline-block;
    padding-left: 5px;
  }

  .dotted {
    border-left: 2px #264bec dotted;
    height: 170px;
    width: 0px;
    display: inline-block;
    padding-left: 5px;
  }

  .dashed {
    border-left: 3px #e00d82 dashed;
    height: 170px;
    width: 0px;
    display: inline-block;
    padding-left: 5px;
  }
</style>
<?php
if ($memombr['valid'] == 'N') {
  echo '<script>alert("Memo belum divalidasi !")</script>';
  echo  "<script type='text/javascript'>";
  echo "window.close();";
  echo "</script>";
  exit();
}

$n = 0;
$nama_produk1 = '';
$modal1 = 0;
$jual1 = 0;
$nama_produk2 = '';
$modal2 = 0;
$jual2 = 0;
$nama_produk3 = '';
$modal3 = 0;
$jual3 = 0;
$nama_produk4 = '';
$modal4 = 0;
$jual4 = 0;
$nama_produk5 = '';
$modal5 = 0;
$jual5 = 0;
$nama_produk6 = '';
$modal6 = 0;
$jual6 = 0;
$nama_produk7 = '';
$modal7 = 0;
$jual7 = 0;
$nama_produk8 = '';
$modal8 = 0;
$jual8 = 0;
$nama_produk9 = '';
$modal9 = 0;
$jual9 = 0;
$nama_produk10 = '';
$modal10 = 0;
$jual10 = 0;
$nama_produk11 = '';
$modal11 = 0;
$jual11 = 0;
$nama_produk12 = '';
$modal12 = 0;
$jual12 = 0;
$nama_produk13 = '';
$modal13 = 0;
$jual13 = 0;
$nama_produk14 = '';
$modal14 = 0;
$jual14 = 0;
foreach ($memombrd as $d) {
  $n++;
  if ($n == 1) {
    $nama_produk1 = $d['nama_produk'];
    $modal1 = $d['modal'];
    $jual1 = $d['jual'];
  }
  if ($n == 2) {
    $nama_produk2 = $d['nama_produk'];
    $modal2 = $d['modal'];
    $jual2 = $d['jual'];
  }
  if ($n == 3) {
    $nama_produk3 = $d['nama_produk'];
    $modal3 = $d['modal'];
    $jual3 = $d['jual'];
  }
  if ($n == 4) {
    $nama_produk4 = $d['nama_produk'];
    $modal4 = $d['modal'];
    $jual4 = $d['jual'];
  }
  if ($n == 5) {
    $nama_produk5 = $d['nama_produk'];
    $modal5 = $d['modal'];
    $jual5 = $d['jual'];
  }
  if ($n == 6) {
    $nama_produk6 = $d['nama_produk'];
    $modal6 = $d['modal'];
    $jual6 = $d['jual'];
  }
  if ($n == 7) {
    $nama_produk7 = $d['nama_produk'];
    $modal7 = $d['modal'];
    $jual7 = $d['jual'];
  }
  if ($n == 8) {
    $nama_produk8 = $d['nama_produk'];
    $modal8 = $d['modal'];
    $jual8 = $d['jual'];
  }
  if ($n == 9) {
    $nama_produk9 = $d['nama_produk'];
    $modal9 = $d['modal'];
    $jual9 = $d['jual'];
  }
  if ($n == 10) {
    $nama_produk10 = $d['nama_produk'];
    $modal10 = $d['modal'];
    $jual10 = $d['jual'];
  }
  if ($n == 11) {
    $nama_produk11 = $d['nama_produk'];
    $modal11 = $d['modal'];
    $jual11 = $d['jual'];
  }
  if ($n == 12) {
    $nama_produk12 = $d['nama_produk'];
    $modal12 = $d['modal'];
    $jual12 = $d['jual'];
  }
  if ($n == 13) {
    $nama_produk13 = $d['nama_produk'];
    $modal13 = $d['modal'];
    $jual13 = $d['jual'];
  }
  if ($n == 14) {
    $nama_produk14 = $d['nama_produk'];
    $modal14 = $d['modal'];
    $jual14 = $d['jual'];
  }
}
?>

<style>
  .box1 {
    width: 1075px;
    height: 750px;
    background: white;
    border: solid 1px black;
    ;
  }

  .box2 {
    width: 230px;
    height: 230px;
    background: blue;
  }
</style>

<!-- <body> -->
<div class="box1">
  <div class="container-fluid">
    <div class="row">
      <p style="margin-top:5px; font-size:18px; margin-bottom:5px" align="center">
        MEMO MOBIL BARU
      </p>
      <div class="col-12 col-sm-6">
        <table cellspacing="1" cellpadding="1" height="1">
          <!-- <table border=1 width=100% align=”center”> -->
          <tr>
            <td width="5"></td>
            <td width="100" style="font-size:12px;"></td>
            <td width="5" style="font-size:12px;"></td>
            <td width="10" style="font-size:12px;"></td>
            <td width="50" style="font-size:12px;"></td>
            <td width="150" style="font-size:12px;"></td>
            <td width="120" style="font-size:12px;"></td>
            <td width="80" style="font-size:12px;"></td>
            <td width="5" style="font-size:12px;"></td>
            <td width="80" style="font-size:12px;"></td>
            <td width="85" style="font-size:12px;"></td>
            <td width="85" style="font-size:12px;"></td>
          <tr>
          <tr>
            <td colspan="13">
              <hr>
            </td>
          <tr>
            <td></td>
            <td style="font-size:12px;">Tanggal</td>
            <td style="font-size:12px;">:</td>
            <td colspan="3" style="font-size:12px;"> <?= $memombr['tanggal'] ?></td>
            <td style="font-size:18px;">NIK : <b><?= $memombr['tahun'] ?></b></td>
            <!-- <td style="font-size:12px;"></td> -->
            <td style="font-size:12px;">OTR</td>
            <td style="font-size:12px;">:</td>
            <td colspan="3" style="font-size:12px;"> <?= number_format($memombr['harga_jual_mobil'], 0, ',', ',') ?></td>
          <tr>
            <td></td>
            <td style="font-size:12px;">Tipe</td>
            <td style="font-size:12px;">:</td>
            <td colspan="3" style="font-size:12px;"><?= $memombr['nmtipe'] ?></td>
            <td style="font-size:12px;"></td>
            <td style="font-size:12px;">Discount Team Harga</td>
            <td style="font-size:12px;">:</td>
            <td colspan="3" style="font-size:12px;"> <?= number_format($memombr['disc_team_harga'], 0, ',', ',') ?></td>
          <tr>
            <td></td>
            <td style="font-size:12px;">No. Rangka</td>
            <td style="font-size:12px;">:</td>
            <td colspan="3" style="font-size:12px;"><?= $memombr['norangka'] ?></td>
            <td style="font-size:12px;"></td>
            <td style="font-size:12px;">Sales</td>
            <td style="font-size:12px;">:</td>
            <td colspan="3" style="font-size:12px;"><?= $memombr['kdsales'] ?></td>
          <tr>
            <td></td>
            <td style="font-size:12px;">No. Mesin</td>
            <td style="font-size:12px;">:</td>
            <td colspan="3" style="font-size:12px;"><?= $memombr['nomesin'] ?></td>
            <td style="font-size:12px;"></td>
            <td style="font-size:12px;">Status Sales</td>
            <td style="font-size:12px;">:</td>
            <td style="font-size:12px;"><?= $memombr['status_sales'] ?></td>
          <tr>
            <td></td>
            <td style="font-size:12px;">Warna</td>
            <td style="font-size:12px;">:</td>
            <td colspan="3" style="font-size:12px;"><?= $memombr['nmwarna'] ?></td>
            <td style="font-size:12px;"></td>
            <td style="font-size:12px;">Supervisor</td>
            <td style="font-size:12px;">:</td>
            <td colspan="3" style="font-size:12px;"><?= $memombr['kdspv'] ?></td>
          <tr>
            <td></td>
            <td style="font-size:12px;">No. SPK</td>
            <td style="font-size:12px;">:</td>
            <td colspan="3" style="font-size:12px;"><?= $memombr['nospk'] ?></td>
          <tr>
            <td colspan="13">
              <hr>
            </td>
          <tr>
            <td></td>
            <td style="font-size:12px;">Pemesan</td>
            <td style="font-size:12px;">:</td>
            <td colspan="3" style="font-size:12px;"><?= $memombr['nmcustomer'] ?></td>
            <td style="font-size:12px;">Merek Kaca Film</td>
            <td colspan="4" style="font-size:12px;"><b>Variasi/Asuransi/lain-lain yang dijual :</b></td>
          <tr>
            <td></td>
            <td style="font-size:12px;">Alamat</td>
            <td style="font-size:12px;">:</td>
            <td colspan="3" style="font-size:12px;"><?= $memombr['alamat'] ?></td>
            <td style="font-size:12px;"><?= $memombr['kaca_film'] ?></td>
            <td style="font-size:12px;">Nama Produk</td>
            <td style="font-size:12px;"></td>
            <td colspan="1" style="font-size:12px;"></td>
            <td style="font-size:12px;text-align:right;">Modal</td>
            <td style="font-size:12px;text-align:right;">Jual</td>
            <td style="font-size:12px;"></td>
          <tr>
            <td></td>
            <td style="font-size:12px;"></td>
            <td style="font-size:12px;"></td>
            <td colspan="3" style="font-size:12px;"><?= $memombr['kelurahan'] ?></td>
            <td style="font-size:12px;"></td>
            <td colspan="3" style="font-size:12px;"><?= $nama_produk1 ?></td>
            <td style="font-size:12px;text-align:right;"><?= $modal1 > 0 ? number_format($modal1, 0, ',', ',') : '' ?></td>
            <td style="font-size:12px;text-align:right;"><?= $jual1 > 0 ? number_format($jual1, 0, ',', ',') : '' ?></td>
          <tr>
            <td></td>
            <td style="font-size:12px;"></td>
            <td style="font-size:12px;"></td>
            <td colspan="3" style="font-size:12px;"><?= $memombr['kecamatan'] ?></td>
            <td style="font-size:12px;"></td>
            <td colspan="3" style="font-size:12px;"><?= $nama_produk2 ?></td>
            <td style="font-size:12px;text-align:right;"><?= $modal2 > 0 ? number_format($modal2, 0, ',', ',') : '' ?></td>
            <td style="font-size:12px;text-align:right;"><?= $jual2 > 0 ? number_format($jual2, 0, ',', ',') : '' ?></td>
          <tr>
            <td></td>
            <td style="font-size:12px;"></td>
            <td style="font-size:12px;"></td>
            <td colspan="3" style="font-size:12px;"><?= $memombr['kota'] . ' ' . $memombr['provinsi'] . ' ' . $memombr['kodepos'] ?></td>
            <td style="font-size:12px;">Pembayaran</td>
            <td colspan="3" style="font-size:12px;"><?= $nama_produk3 ?></td>
            <td style="font-size:12px;text-align:right;"><?= $modal3 > 0 ? number_format($modal3, 0, ',', ',') : '' ?></td>
            <td style="font-size:12px;text-align:right;"><?= $jual3 > 0 ? number_format($jual3, 0, ',', ',') : '' ?></td>
          <tr>
            <td></td>
            <td style="font-size:12px;">NIK</td>
            <td style="font-size:12px;">:</td>
            <td colspan="3" style="font-size:12px;"><?= $memombr['nik_customer'] ?></td>
            <td style="font-size:12px;"><?= $memombr['pembayaran'] ?></td>
            <td colspan="3" style="font-size:12px;"><?= $nama_produk4 ?></td>
            <td style="font-size:12px;text-align:right;"><?= $modal4 > 0 ? number_format($modal4, 0, ',', ',') : '' ?></td>
            <td style="font-size:12px;text-align:right;"><?= $jual4 > 0 ? number_format($jual4, 0, ',', ',') : '' ?></td>
          <tr>
            <td></td>
            <td style="font-size:12px;">HP</td>
            <td style="font-size:12px;">:</td>
            <td colspan="3" style="font-size:12px;"><?= $memombr['nohp_customer'] ?></td>
            <td style="font-size:12px;"></td>
            <td colspan="3" style="font-size:12px;"><?= $nama_produk5 ?></td>
            <td style="font-size:12px;text-align:right;"><?= $modal5 > 0 ? number_format($modal5, 0, ',', ',') : '' ?></td>
            <td style="font-size:12px;text-align:right;"><?= $jual5 > 0 ? number_format($jual5, 0, ',', ',') : '' ?></td>
          <tr>
            <td></td>
            <td style="font-size:12px;">STNK a/n</td>
            <td style="font-size:12px;"></td>
            <td colspan="3" style="font-size:12px;"><?= $memombr['nmcustomer_stnk'] ?></td>
            <td style="font-size:12px;"></td>
            <td colspan="3" style="font-size:12px;"><?= $nama_produk6 ?></td>
            <td style="font-size:12px;text-align:right;"><?= $modal6 > 0 ? number_format($modal6, 0, ',', ',') : '' ?></td>
            <td style="font-size:12px;text-align:right;"><?= $jual6 > 0 ? number_format($jual6, 0, ',', ',') : '' ?></td>
          <tr>
            <td></td>
            <td style="font-size:12px;">Alamat</td>
            <td style="font-size:12px;">:</td>
            <td colspan="3" style="font-size:12px;"><?= $memombr['alamat_stnk'] ?></td>
            <td style="font-size:12px;">Booking Fee Masuk</td>
            <td colspan="3" style="font-size:12px;"><?= $nama_produk7 ?></td>
            <td style="font-size:12px;text-align:right;"><?= $modal7 > 0 ? number_format($modal7, 0, ',', ',') : '' ?></td>
            <td style="font-size:12px;text-align:right;"><?= $jual7 > 0 ? number_format($jual7, 0, ',', ',') : '' ?></td>
          <tr>
            <td></td>
            <td style="font-size:12px;"></td>
            <td style="font-size:12px;"></td>
            <td colspan="3" style="font-size:12px;"><?= $memombr['kelurahan_stnk'] ?></td>
            <td style="font-size:12px;"><?= number_format($memombr['booking_fee'], 0, ',', ',') ?></td>
            <td colspan="3" style="font-size:12px;"><?= $nama_produk8 ?></td>
            <td style="font-size:12px;text-align:right;"><?= $modal8 > 0 ? number_format($modal8, 0, ',', ',') : '' ?></td>
            <td style="font-size:12px;text-align:right;"><?= $jual8 > 0 ? number_format($jual8, 0, ',', ',') : '' ?></td>
          <tr>
            <td></td>
            <td style="font-size:12px;"></td>
            <td style="font-size:12px;"></td>
            <td colspan="3" style="font-size:12px;"><?= $memombr['kecamatan_stnk'] ?></td>
            <td style="font-size:12px;"></td>
            <td colspan="3" style="font-size:12px;"><?= $nama_produk9 ?></td>
            <td style="font-size:12px;text-align:right;"><?= $modal9 > 0 ? number_format($modal9, 0, ',', ',') : '' ?></td>
            <td style="font-size:12px;text-align:right;"><?= $jual9 > 0 ? number_format($jual9, 0, ',', ',') : '' ?></td>
          <tr>
            <td></td>
            <td style="font-size:12px;"></td>
            <td style="font-size:12px;"></td>
            <td colspan="3" style="font-size:12px;"><?= $memombr['kota_stnk'] . ' ' . $memombr['provinsi_stnk'] . ' ' . $memombr['kodepos_stnk'] ?></td>
            <td style="font-size:12px;"></td>
            <td colspan="3" style="font-size:12px;"><?= $nama_produk10 ?></td>
            <td style="font-size:12px;text-align:right;"><?= $modal10 > 0 ? number_format($modal10, 0, ',', ',') : '' ?></td>
            <td style="font-size:12px;text-align:right;"><?= $jual10 > 0 ? number_format($jual10, 0, ',', ',') : '' ?></td>
          <tr>
            <td></td>
            <td style="font-size:12px;">NIK</td>
            <td style="font-size:12px;">:</td>
            <td colspan="3" style="font-size:12px;"><?= $memombr['nik_stnk'] ?></td>
            <td style="font-size:12px;"></td>
            <td colspan="3" style="font-size:12px;"><?= $nama_produk11 ?></td>
            <td style="font-size:12px;text-align:right;"><?= $modal11 > 0 ? number_format($modal11, 0, ',', ',') : '' ?></td>
            <td style="font-size:12px;text-align:right;"><?= $jual11 > 0 ? number_format($jual11, 0, ',', ',') : '' ?></td>
          <tr>
            <td></td>
            <td style="font-size:12px;">HP</td>
            <td style="font-size:12px;">:</td>
            <td colspan="3" style="font-size:12px;"><?= $memombr['nohp_customer_stnk'] ?></td>
            <td style="font-size:12px;">Permintaan Faktur Pajak</td>
            <td colspan="3" style="font-size:12px;"><?= $nama_produk12 ?></td>
            <td style="font-size:12px;text-align:right;"><?= $modal12 > 0 ? number_format($modal12, 0, ',', ',') : '' ?></td>
            <td style="font-size:12px;text-align:right;"><?= $jual12 > 0 ? number_format($jual12, 0, ',', ',') : '' ?></td>
          <tr>
            <td></td>
            <td style="font-size:12px;">Email</td>
            <td style="font-size:12px;">:</td>
            <td colspan="3" style="font-size:12px;"><?= $memombr['email_stnk'] ?></td>
            <td style="font-size:12px;"><?= $memombr['npwp_stnk'] ?></td>
            <td colspan="3" style="font-size:12px;"><?= $nama_produk13 ?></td>
            <td style="font-size:12px;text-align:right;"><?= $modal13 > 0 ? number_format($modal13, 0, ',', ',') : '' ?></td>
            <td style="font-size:12px;text-align:right;"><?= $jual13 > 0 ? number_format($jual13, 0, ',', ',') : '' ?></td>
          <tr>
            <td></td>
            <td style="font-size:12px;">NIK KK</td>
            <td style="font-size:12px;">:</td>
            <td colspan="3" style="font-size:12px;"><?= $memombr['nik_kk'] ?></td>
            <td style="font-size:12px;"></td>
            <td colspan="3" style="font-size:12px;"><?= $nama_produk14 ?></td>
            <td style="font-size:12px;text-align:right;"><?= $modal14 > 0 ? number_format($modal14, 0, ',', ',') : '' ?></td>
            <td style="font-size:12px;text-align:right;"><?= $jual14 > 0 ? number_format($jual14, 0, ',', ',') : '' ?></td>
          <tr>
            <td colspan="13">
              <hr>
            </td>
          <tr>
            <td></td>
            <td colspan="4" style="font-size:12px;text-align:center"><b>Validasi SPK</b></td>
            <td style="font-size:12px;">:</td>
            <td colspan="5" style="font-size:12px;text-align:center"><b>VOUCHER DISCOUNT</b></td>
          <tr>
            <td colspan="13">
              <hr />
            </td>
          <tr>
            <td></td>
            <td style="font-size:12px;">Pemesan</td>
            <td style="font-size:12px;">:</td>
            <td colspan="3" style="font-size:12px;"><?= $memombr['nmcustomer'] ?></td>
            <td style="font-size:12px;">Tipe Kendaraan</td>
            <td style="font-size:12px;"></td>
            <td style="font-size:12px;">:</td>
            <td colspan="3" style="font-size:12px;"><?= $memombr['nmtipe'] ?></td>
          <tr>
            <td></td>
            <td style="font-size:12px;">Tipe</td>
            <td style="font-size:12px;">:</td>
            <td colspan="3" style="font-size:12px;"><?= $memombr['nmtipe'] ?></td>
            <td style="font-size:12px;">Atas Nama</td>
            <td style="font-size:12px;"></td>
            <td style="font-size:12px;">:</td>
            <td colspan="3" style="font-size:12px;"><?= $memombr['nmcustomer'] ?></td>
          <tr>
            <td></td>
            <td style="font-size:12px;">Warna</td>
            <td style="font-size:12px;">:</td>
            <td colspan="3" style="font-size:12px;"><?= $memombr['nmwarna'] ?></td>
            <td style="font-size:12px;">Kondisi</td>
            <td style="font-size:12px;"></td>
            <td style="font-size:12px;">:</td>
          <tr>
            <td></td>
            <td style="font-size:12px;">CASH/KREDIT</td>
            <td style="font-size:12px;">:</td>
            <td colspan="3" style="font-size:12px;"><?= $memombr['pembayaran'] ?></td>
            <td style="font-size:12px;"></td>
            <td style="font-size:12px;">* Discount Dealer</td>
            <td style="font-size:12px;">:</td>
            <td style="font-size:12px;"><?= number_format($memombr['disc_dealer'], 0, ',', ',') ?></td>
          <tr>
            <td></td>
            <td style="font-size:12px;">Pembelian Asuransi</td>
            <td style="font-size:12px;">:</td>
            <td colspan="3" style="font-size:12px;"><?= $memombr['beli_asuransi'] ?></td>
            <td style="font-size:12px;"></td>
            <td style="font-size:12px;">* Event HPM</td>
            <td style="font-size:12px;">:</td>
            <td style="font-size:12px;"><?= number_format($memombr['event_hpm'], 0, ',', ',') ?></td>
          <tr>
            <td></td>
            <td style="font-size:12px;">Pembelian Accessories</td>
            <td style="font-size:12px;">:</td>
            <td colspan="3" style="font-size:12px;"><?= $memombr['beli_accessories'] ?></td>
            <td style="font-size:12px;"></td>
            <td style="font-size:12px;">* Lain-lain</td>
            <td style="font-size:12px;">:</td>
            <td style="font-size:12px;"><?= number_format($memombr['event_lain'], 0, ',', ',') ?></td>
          <tr>
          <tr>
            <td></td>
            <td style="font-size:12px;">Uang Masuk</td>
            <td style="font-size:12px;"></td>
            <td colspan="2" style="font-size:12px;">Booking Fee</td>
            <td colspan="2" style="font-size:12px;">Rp. <?= number_format($memombr['booking_fee'], 0, ',', ',') ?></td>
          <tr>
            <td></td>
            <td style="font-size:12px;"></td>
            <td style="font-size:12px;"></td>
            <td colspan="3" style="font-size:12px;">Discount yang diberikan</td>
          <tr>
            <td></td>
            <td style="font-size:12px;"></td>
            <td style="font-size:12px;"></td>
            <td colspan="3" style="font-size:12px;">Bonus Accessories (STANDART)</td>
          <tr>
            <td></td>
            <td style="font-size:12px;"><b>Tanggal Validasi SM</b></td>
            <td style="font-size:12px;"></td>
            <td colspan="3" style="font-size:12px;"></td>
            <td style="font-size:12px;"><b>Tanggal Validasi Direktur</b></td>
            <td style="font-size:12px;">Mediator</td>
            <td colspan=3 style="font-size:12px;">: Bank : <?= $memombr['mediator_bank'] ?></td>
            <td style="font-size:12px;">An : <?= $memombr['mediator_an'] ?></td>
            <td style="font-size:12px;"></td>
          <tr>
            <td></td>
            <td style="font-size:12px;"><?= $memombr['tgl_validasi'] ?></td>
            <td style="font-size:12px;"></td>
            <td colspan="3" style="font-size:12px;"></td>
            <td style="font-size:12px;"><?= $memombr['tgl_acc_discount'] ?></td>
            <td style="font-size:12px;"></td>
            <td colspan=3 style="font-size:12px;">: Cabang : <?= $memombr['mediator_cabang'] ?></td>
            <td style="font-size:12px;">Acc : <?= $memombr['mediator_account'] ?></td>
            <!-- <td style="font-size:12px;"></td> -->
          <tr>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- </body> -->

<script src=" <?= base_url('vendor/Bootstrap-5-5.1.3/js/bootstrap.bundle.min.js') ?>" crossorigin="anonymous">
</script>
<script src="<?= base_url('/js/scripts.js') ?>"></script>
<script src="<?= base_url('/vendor/chart.js/Chart.min.js') ?>" crossorigin="anonymous"></script>
<script src="<?= base_url('/assets/demo/chart-area-demo.js') ?>"></script>
<script src="<?= base_url('/assets/demo/chart-bar-demo.js') ?>"></script>
<script src="<?= base_url('js/jquery-3.5.1.js') ?>" rel="stylesheet"></script>
<script src="<?= base_url('js/jquery.dataTables.min.js') ?>" rel="stylesheet"></script>
<script src="<?= base_url('js/dataTables.bootstrap5.min.js') ?>" rel="stylesheet"></script>
<script src="<?= base_url('/js/sweet-alert.min.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>