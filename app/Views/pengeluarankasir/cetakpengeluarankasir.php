<script>
  // var is_chrome = function() {
  //   return Boolean(window.chrome);
  // }
  // if (is_chrome) {
  //   window.print();
  setTimeout(function() {
    window.close();
  }, 1000);
  //   //give them 10 seconds to print, then close
  // } else {
  // window.print();
  // window.close();
  // }
  // history.replaceState(history.state, '', '/');
  window.print();
  // history.replaceState(history.state, '', curURL);
</script>

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

<!-- <body onLoad="loadHandler();"> -->

<body>
  <style type="text/css" media="print">
    /* @media print { */
    /* @page {
        margin-top: 0;
        margin-bottom: 0;
      } */

    /* body {
        padding-top: 72px;
        padding-bottom: 72px;
      } */
    /* } */
  </style>

  <style>
    @page {
      margin-left: 40px;
      margin-top: 30px;
      margin-bottom: 0px;
    }

    body {
      padding-bottom: 25px;
    }

    td {
      font-size: 10px;
    }
  </style>
  <style type="text/css">
    @media print {
      #printbtn {
        display: none;
      }
    }
  </style>

  <?php
  if ($pengeluarankasir['valid'] == 'N') {
    echo '<script>alert("Pengeluaran kasir belum divalidasi!")</script>';
    echo  "<script type='text/javascript'>";
    echo "window.close();";
    echo "</script>";
    exit();
  }
  ?>

  <!-- <?= base_url('/img/logo_honda.jpg') ?> -->

  <?php
  // //Use this code to convert your image to base64
  // // Apply this in a view 

  // $path = base_url('img/logo_honda.jpg'); // Modify this part (your_img.png
  // $type = pathinfo($path, PATHINFO_EXTENSION);
  // echo 'aaa' . $type;
  // $data = file_get_contents($path);
  // $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
  ?>

  <!-- <button onclick="myPrintFunction()" id="printbtn">print</button> -->
  <script>
    function myPrintFunction() {
      // do something maybe
      window.print();
    }
  </script>

  <?php
  $session = session();
  $alamat_perusahaan = $session->get('alamat_perusahaan');
  $nama_perusahaan = $session->get('nama_perusahaan');
  $nama = $session->get('nama');
  ?>

  <div class="container-fluid" style="width:100%;height:100%;background:white;">
    <div class=" row">
      <p style="width:100%;height:30px;background:white;border-block-end:solid 1px black;margin-top:1px; font-size:18px; margin-bottom:1px;text-align:center;">
        <!-- <p style="width:100%;height:30px;background:white;border:solid 1px black;margin-top:1px; font-size:18px; margin-bottom:1px;text-align:center;"> -->
        <b>KWITANSI PENGELUARAN</b>
      </p>
      <table cellspacing="1" cellpadding="0" height="0">
        <tr>
          <td width="75" style="font-size:12px;"></td>
          <td width="5" style="font-size:12px;"></td>
          <td width="10" style="font-size:12px;"></td>
          <td width="80" style="font-size:12px;"></td>
          <td width="100" style="font-size:12px;"></td>
          <td width="200" style="font-size:12px;"></td>
          <td></td>
        <tr>
        <tr>
          <td style="font-size:12px;">No. Kwitansi</td>
          <td width="5" style="font-size:12px;">:</td>
          <td colspan="5" style="font-size:12px;"> <?= $pengeluarankasir['nomor'] ?></td>
        <tr>
          <td style="font-size:12px;">Tanggal</td>
          <td width="5" style="font-size:12px;">:</td>
          <!-- <td colspan="5" style="font-size:12px;"> <?= $pengeluarankasir['tanggal'] ?></td> -->
          <?php
          $date = date_create($pengeluarankasir['tanggal']);
          ?>
          <td colspan="5" style="font-size:12px;"> <?= date_format($date, "d-m-Y"); ?></td>
        <tr>
          <td style="font-size:12px;">No. SPK</td>
          <td width="5" style="font-size:12px;">:</td>
          <td colspan="5" style="font-size:12px;"> <?= $pengeluarankasir['nospk'] ?></td>
        <tr>
          <td style="font-size:12px;">Customer</td>
          <td width="5" style="font-size:12px;">:</td>
          <td colspan="5" style="font-size:12px;"> <?= $pengeluarankasir['nmcustomer'] ?></td>
        <tr>
          <td style="font-size:12px;">Jumlah</td>
          <td style="font-size:12px;">:</td>
          <td style="font-size:12px;"> <?= 'Rp. ' ?></td>
          <td style="font-size:12px;text-align:right;"> <?= number_format($pengeluarankasir['pengeluaran'], 0, ',', ',') ?></td>
        <tr>
          <td style="font-size:12px;">Bank Charger</td>
          <td width="5" style="font-size:12px;">:</td>
          <td style="font-size:12px;"> <?= 'Rp. ' ?></td>
          <td style="font-size:12px;text-align:right;"> <?= number_format($pengeluarankasir['bank_charge'], 0, ',', ',') ?></td>
        <tr>
          <td style="font-size:12px;">Total</td>
          <td width="5" style="font-size:12px;">:</td>
          <td style="font-size:12px;"> <?= 'Rp. ' ?></td>
          <td style="font-size:12px;text-align:right;"> <?= number_format($pengeluarankasir['total_pengeluaran'], 0, ',', ',') ?></td>
        <tr>
          <?php
          $terbilang = ucwords(terbilang($pengeluarankasir['total_pengeluaran']));
          ?>
          <td style="font-size:12px;">Terbilang</td>
          <td width="5" style="font-size:12px;">:</td>
          <td colspan="5" style="font-size:12px;"> <?= "# " . $terbilang . ' Rupiah #' ?></td>
      </table>
    </div>
    <br>
    <div class=" row">
      <!-- <table cellspacing="1" cellpadding="0" height="1" style="border: solid 1px black"> -->
      <table cellspacing="1" cellpadding="0" height="1">
        <tr>
          <td width="400"> Untuk Pembayaran : </td>
          <td width="120" style="font-size:12px;text-align:center"><?= 'CUSTOMER' ?></td>
          <td width="120" style="font-size:12px;text-align:center"><?= 'ADMIN KASIR' ?></td>
        <tr>
          <td rowspan="2" style="text-align:left"><i><?= $pengeluarankasir['keterangan'] ?></i></td>
          <!-- <td rowspan="2" style="text-align:left"><i><?= 'SELALU ADA JALAN MENUJU ROMA, JIKA KITA YAKIN BISASELALU ADA JALAN MENUJU ROMA, JIKA KITA YAKIN BISASELALU ADA JALAN MENUJU ROMA, JIKA KITA YAKIN BISA' ?></i></td> -->
        <tr>
          <td style="text-align:left"><i><?= '' ?></i></td>
          <td><br><br><br><br></td>
        <tr>
          <td></td>
          <td width="100" style="font-size:12px;text-align:center"><?= '(________________________)' ?></td>
          <td width="100" style="font-size:12px;text-align:center"><?= '(________________________)' ?></td>
        <tr>
          <?php
          $date = date_create(date("d-m-Y H:i:s"));
          ?>
          <td style="font-size:10px;"> <?= 'Dicetak oleh : ' . $nama . ', ' . date_format($date, "d-m-Y H:i:s"); ?></td>
      </table>
    </div>
  </div>

  <?php
  function terbilang($nilai)
  {
    if ($nilai < 0) {
      $hasil = "minus " . trim(penyebut($nilai));
    } else {
      $hasil = trim(penyebut($nilai));
    }
    return $hasil;
  }

  function penyebut($nilai)
  {
    $nilai = floor($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) {
      $temp = " " . $huruf[$nilai];
    } else if ($nilai < 20) {
      $temp = penyebut($nilai - 10) .
        " belas";
    } else if ($nilai < 100) {
      $temp = penyebut($nilai / 10) .
        " puluh" . penyebut($nilai % 10);
    } else if ($nilai < 200) {
      $temp = " seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
      $temp = penyebut($nilai / 100) .
        " ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
      $temp = " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
      $temp = penyebut($nilai / 1000) .
        " ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
      $temp = penyebut($nilai / 1000000) .
        " juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
      $temp = penyebut($nilai / 1000000000) .
        " milyar" . penyebut(fmod($nilai, 1000000000));
    } else if ($nilai < 1000000000000000) {
      $temp = penyebut($nilai / 1000000000000) .
        " trilyun" . penyebut(fmod($nilai, 1000000000000));
    }
    return $temp;
  }
  ?>

  <!-- <script src="<?= base_url('vendor/Bootstrap-5-5.1.3/js/bootstrap.bundle.min.js') ?>" crossorigin="anonymous"></script>
<script src="<?= base_url('/js/scripts.js') ?>"></script>
<script src="<?= base_url('/vendor/chart.js/Chart.min.js') ?>" crossorigin="anonymous"></script>
<script src="<?= base_url('/assets/demo/chart-area-demo.js') ?>"></script>
<script src="<?= base_url('/assets/demo/chart-bar-demo.js') ?>"></script>
<script src="<?= base_url('js/jquery-3.5.1.js') ?>" rel="stylesheet"></script>
<script src="<?= base_url('js/jquery.dataTables.min.js') ?>" rel="stylesheet"></script>
<script src="<?= base_url('js/dataTables.bootstrap5.min.js') ?>" rel="stylesheet"></script>
<script src="<?= base_url('/js/sweet-alert.min.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script> -->

</body>

</html>