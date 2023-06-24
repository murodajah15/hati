</html>

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>HATI</title>
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

<!-- <body onload="window.print()"> -->
<div class="box1">
  <div class="container-fluid">
    <div class="row">
      <p style="margin-top:5px; font-size:18px; margin-bottom:5px" align="center">
        Laporan Memo Mobil Baru
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