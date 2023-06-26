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
    margin-top: 150px;
  }

  td {
    font-size: 10px;
  }
</style>
<?php
if ($wo_bp['close'] == 'N') {
  echo '<script>alert("WO belum di close !")</script>';
  echo  "<script type='text/javascript'>";
  echo "window.close();";
  echo "</script>";
  exit();
}
?>

<div class="container-fluid">
  <div class="row">
    <p style="margin-top:5px;font-size:18px; margin-bottom:5px" align="center">
      <u>WORK ORDER BODY REPAIR</u>
    </p>
    <p style="margin-top:5px;font-size:14px; margin-bottom:5px" align="center"><?= $wo_bp['nowo'] ?></p>
    <!-- <hr style="width:99%;text-align:left;margin-left:0"> -->
    <table cellspacing="0" cellpadding="0" height="-2">
      <tr>
        <td width="60" style="font-size:11px;">NO. RANGKA</td>
        <td width="100" style="font-size:10px" ;>: <?= $tbmobil['norangka'] ?></td>
        <td width="60" style="font-size:11px;">NO. POLISI</td>
        <td width="150" style="font-size:10px" ;>: <?= $tbmobil['nopolisi'] ?></td>
        <td width="60" style="font-size:11px;">CONTACT</td>
        <td width="130" style="font-size:10px" ;>: <?= isset($tbcustomer['contact_person']) ? $tbcustomer['contact_person'] : "" ?> </td>
      <tr>
        <td width="60" style="font-size:11px;">NO. MESIN</td>
        <td width="100" style="font-size:10px" ;>: <?= $tbmobil['nomesin'] ?></td>
        <td width="60" style="font-size:11px;">TIPE/THN</td>
        <td width="150" style="font-size:10px" ;>: <?= $tbtipe['nama'] . ' / ' . $tbmobil['tahun'] ?></td>
        <td width="60" style="font-size:11px;">NO.PIC</td>
        <td width="130" style="font-size:10px" ;>: <?= isset($tbcustomer['no_contact_person']) ? $tbcustomer['no_contact_person'] : "" ?></td>
      <tr>
        <td width="60" style="font-size:11px;">WARNA</td>
        <td width="100" style="font-size:10px" ;>: <?= $tbwarna['nama'] ?></td>
        <td width="60" style="font-size:11px;">PEMILIK</td>
        <td width="150" style="font-size:10px" ;>: <?= $wo_bp['nmpemilik'] ?></td>
        <td width="60" style="font-size:11px;">MASUK</td>
        <td width="130" style="font-size:10px" ;>: <?= $wo_bp['tanggal'] ?></td>
    </table>
    <hr size="2.1">
    <table class="table table-bordered table-striped" cellpadding="1" cellspacing="0">
      <!-- <table table border="0.50" table-layout="fixed" ; cellpadding="1" ; cellspacing="0" ; style=font-size:11px; class="table table-striped table table-bordered;"> -->
      <thead>
        <tr>
          <td style="font-size:11px;" width="9">NO.</td>
          <td style="font-size:11px;" width="70"></td>
          <td style="font-size:11px;" width="200">PEKERJAAN UTAMA</td>
          <td style="font-size:11px;text-align:right;" width="80">HARGA</td>
          <td style="font-size:11px;text-align:right;" width="80">DISCOUNT</td>
          <td style="font-size:11px;text-align:right;" width="80">TOTAL</td>
        </tr>
      </thead>
      <?php
      $n = 0;
      $totaljasa = 0;
      $ftotaljasa = "";
      foreach ($jasa as $row) {
        $totaljasa = $row['subtotal'] + $totaljasa;
        $fqty = number_format($row['qty'], 2, ',', '.');
        $fharga = number_format($row['harga'], 0, ',', '.');
        $fdiscount = number_format(($row['qty'] * $row['harga']) * ($row['pr_discount'] / 100), 0, ',', '.');
        $fsubtotal = number_format($row['subtotal'], 0, ',', '.');

        $n++;
        echo '<tr>';
        echo '<td style="text-align:right;">' . $n . '<td>&nbsp;' . $row['kode'] . '</td><td>' . $row['nama'] . '</td><td style="text-align:right;">' . $fharga . '</td>
        <td style="text-align:right;">' . $fdiscount . '</td><td style="text-align:right;">' . $fsubtotal  . '</td>';
        echo '<tr>';
      }
      $ftotaljasa = number_format($totaljasa, 0, ',', '.');
      echo '<td></td><td></td><td colspan="3" style="text-align:right;">' . '<b>TOTAL BIAYA JASA UTAMA  Rp.</b>' .
        '</td>' . '</td><td style="text-align:right;"><b>' . $ftotaljasa  . '</b></td>';
      ?>
    </table>
    <hr size="2.1">
    <table class="table table-bordered table-striped" cellpadding="1" cellspacing="0">
      <!-- <table table border="0.50" table-layout="fixed" ; cellpadding="1" ; cellspacing="0" ; style=font-size:11px; class="table table-striped table table-bordered;"> -->
      <thead>
        <tr>
          <td style="font-size:11px;" width="9">NO.</td>
          <td style="font-size:11px;text-align:left;" width="70">NO. PART</td>
          <td style="font-size:11px;text-align:left;" width="179">NAMA PART</td>
          <td style="font-size:11px;text-align:left;" width="20">QTY</td>
          <td style="font-size:11px;text-align:right;" width="80">HARGA</td>
          <td style="font-size:11px;text-align:right;" width="80">DISCOUNT</td>
          <td style="font-size:11px;text-align:right;" width="80">TOTAL</td>
        </tr>
      </thead>
      <?php
      $n = 0;
      $totalpart = 0;
      $ftotalpart = "";
      foreach ($part as $row) {
        $totalpart = $row['subtotal'] + $totalpart;
        $fqty = number_format($row['qty'], 2, ',', '.');
        $fharga = number_format($row['harga'], 0, ',', '.');
        $fdiscount = number_format(($row['qty'] * $row['harga']) * ($row['pr_discount'] / 100), 0, ',', '.');
        $fsubtotal = number_format($row['subtotal'], 0, ',', '.');

        $n++;
        echo '<tr>';
        echo '<td style="text-align:right;">' . $n . '<td>&nbsp;' . $row['kode'] . '</td><td>' . $row['nama'] . '</td><td style="text-align:right;">' . $row['qty'] . '</td><td style="text-align:right;">' . $fharga . '</td>
        <td style="text-align:right;">' . $fdiscount . '</td><td style="text-align:right;">' . $fsubtotal  . '</td>';
        echo '<tr>';
      }
      $ftotalpart = number_format($totalpart, 0, ',', '.');
      echo '<td></td><td></td><td colspan="4" style="text-align:right;">' . '<b>TOTAL BIAYA JASA + PART UTAMA  Rp.</b>' .
        '</td>' . '</td><td style="text-align:right;"><b>' . $ftotalpart  . '</b></td>';
      ?>
    </table>
    <hr size="2.1">
    <table class="table table-bordered table-striped" cellpadding="1" cellspacing="0">
      <!-- <table table border="0.50" table-layout="fixed" ; cellpadding="1" ; cellspacing="0" ; style=font-size:11px; class="table table-striped table table-bordered;"> -->
      <thead>
        <tr>
          <td style="font-size:11px;" width="9">NO.</td>
          <td style="font-size:11px;text-align:left;" width="70">NO. BAHAN</td>
          <td style="font-size:11px;text-align:left;" width="179">NAMA BAHAN</td>
          <td style="font-size:11px;text-align:left;" width="20">QTY</td>
          <td style="font-size:11px;text-align:right;" width="80">HARGA</td>
          <td style="font-size:11px;text-align:right;" width="80">DISCOUNT</td>
          <td style="font-size:11px;text-align:right;" width="80">TOTAL</td>
        </tr>
      </thead>
      <?php
      $n = 0;
      $totalbahan = 0;
      $ftotalbahan = "";
      foreach ($bahan as $row) {
        $totalbahan = $row['subtotal'] + $totalbahan;
        $fqty = number_format($row['qty'], 2, ',', '.');
        $fharga = number_format($row['harga'], 0, ',', '.');
        $fdiscount = number_format(($row['qty'] * $row['harga']) * ($row['pr_discount'] / 100), 0, ',', '.');
        $fsubtotal = number_format($row['subtotal'], 0, ',', '.');

        $n++;
        echo '<tr>';
        echo '<td style="text-align:right;">' . $n . '<td>&nbsp;' . $row['kode'] . '</td><td>' . $row['nama'] . '</td><td style="text-align:right;">' . $row['qty'] . '</td><td style="text-align:right;">' . $fharga . '</td>
        <td style="text-align:right;">' . $fdiscount . '</td><td style="text-align:right;">' . $fsubtotal  . '</td>';
        echo '<tr>';
      }
      $ftotalbahan = number_format($totalbahan, 0, ',', '.');
      echo '<td></td><td></td><td colspan="4" style="text-align:right;">' . '<b>TOTAL BIAYA BAHAN  Rp.</b>' .
        '</td>' . '</td><td style="text-align:right;"><b>' . $ftotalbahan  . '</b></td>';
      ?>
    </table>
    <hr size="2.1">
    <table class="table table-bordered table-striped" cellpadding="1" cellspacing="0">
      <!-- <table table border="0.50" table-layout="fixed" ; cellpadding="1" ; cellspacing="0" ; style=font-size:11px; class="table table-striped table table-bordered;"> -->
      <thead>
        <tr>
          <td style="font-size:11px;" width="9">NO.</td>
          <td style="font-size:11px;text-align:left;" width="70">NO. OPL</td>
          <td style="font-size:11px;text-align:left;" width="200">NAMA OPL</td>
          <td style="font-size:11px;text-align:right;" width="80">HARGA</td>
          <td style="font-size:11px;text-align:right;" width="80">DISCOUNT</td>
          <td style="font-size:11px;text-align:right;" width="80">TOTAL</td>
        </tr>
      </thead>
      <?php
      $n = 0;
      $totalopl = 0;
      $ftotalopl = "";
      foreach ($opl as $row) {
        $totalopl = $row['subtotal'] + $totalopl;
        $fqty = number_format($row['qty'], 2, ',', '.');
        $fharga = number_format($row['harga'], 0, ',', '.');
        $fdiscount = number_format(($row['qty'] * $row['harga']) * ($row['pr_discount'] / 100), 0, ',', '.');
        $fsubtotal = number_format($row['subtotal'], 0, ',', '.');

        $n++;
        echo '<tr>';
        echo '<td style="text-align:right;">' . $n . '<td>&nbsp;' . $row['kode'] . '</td><td>' . $row['nama'] . '</td><td style="text-align:right;">' . $fharga . '</td>
        <td style="text-align:right;">' . $fdiscount . '</td><td style="text-align:right;">' . $fsubtotal  . '</td>';
        echo '<tr>';
      }
      $ftotalopl = number_format($totalopl, 0, ',', '.');
      echo '<td></td><td></td><td colspan="3" style="text-align:right;">' . '<b>TOTAL BIAYA OPL  Rp.</b>' .
        '</td>' . '</td><td style="text-align:right;"><b>' . $ftotalopl  . '</b></td>';
      ?>
    </table>
    <hr size="2.1">
    <table class="table table-bordered table-striped">
      <!-- <table table border="0.50" table-layout="fixed" ; cellpadding="1" ; cellspacing="0" ; style=font-size:11px; class="table table-striped table table-bordered;"> -->
      <thead>
        <th style="font-size:1px;" width="9"></th>
        <th style="font-size:1px;text-align:left;" width="66"></th>
        <th style="font-size:1px;text-align:left;" width="200"></th>
        <th style="font-size:1px;text-align:right;" width="80"></th>
        <th style="font-size:1px;text-align:right;" width="80"></th>
        <th style="font-size:1px;text-align:right;" width="80"></th>
      </thead>
      <?php
      $total = $totaljasa + $totalpart + $totalbahan + $totalopl;
      $ftotal = number_format($total, 0, ',', '.');
      // $ppn = $total * ($wo_bp['ppn'] / 100);
      $ppn = $wo_bp['ppn'];
      $fppn = number_format($ppn, 0, ',', '.');
      $grandtotal = $total + $ppn;
      $fgrandtotal = number_format($grandtotal, 0, ',', '.');
      echo '<td></td><td></td><td colspan="3" style="text-align:right;">' . '<b>TOTAL BIAYA (DPP)  Rp.</b>' .
        '</td>' . '</td><td style="text-align:right;"><b>' . $ftotal  . '</b></td><tr>';
      echo '<td></td><td></td><td colspan="3" style="text-align:right;">' . '<b>PPN  Rp.</b>' .
        '</td>' . '</td><td style="text-align:right;"><b>' . $fppn  . '</b></td>' . '<tr>';
      echo '<td></td><td></td><td colspan="3" style="text-align:right;">' . '<b>GRAND TOTAL (DPP)  Rp.</b>' .
        '</td>' . '</td><td style="text-align:right;"><b>' . $fgrandtotal  . '</b></td>' . '</table>';
      ?>
      <hr size="2.1">
      <font size=2><u><b>PERHATIAN :</b></u></font>
      <br>
      <font size=2>1. Perkiraan tersebut diatas berdasarkan apa yang dapat diketahui sementara, dan dapat berubah sesuai keadaan yang sebenarnya pada saat <br>
        &nbsp;&nbsp;&nbsp;&nbsp;pelaksanaan kerja perbaikan.<br>
        2. Perbaikan baru dapat dilaksanakan jika sudah ada persetujuan harga Work Order (WO).<br><br>
        Tangerang Selatan,<?= date('d-m-Y H:i:s'); ?><br>
        Disetujui Oleh,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hormat Kami<br><br><br><br><br>


        (_____________)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(______________)<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Customer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Service Advisor
      </font>
  </div>
</div>

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