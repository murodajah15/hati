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
  if ($mohfaktur['valid'] == 'N') {
    echo '<script>alert("Permohonan Faktur belum divalidasi!")</script>';
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
  ?>

  <div class="container-fluid" style="width:100%;height:100%;background:white;border: solid 1px black;">
    <div class=" row">
      <p style="width:100%;height:30px;background:white;border-block-end:solid 1px black;margin-top:1px; font-size:18px; margin-bottom:1px;text-align:center;">
        <!-- <p style="width:100%;height:30px;background:white;border:solid 1px black;margin-top:1px; font-size:18px; margin-bottom:1px;text-align:center;"> -->
        <b>FORM FAKTUR</b>
      </p>
      <table cellspacing="1" cellpadding="0" height="0">
        <tr>
          <td width="3" style="font-size:12px;"></td>
          <td width="85" style="font-size:12px;"></td>
          <td width="5" style="font-size:12px;"></td>
          <td width="10" style="font-size:12px;"></td>
          <td width="80" style="font-size:12px;"></td>
          <td width="5" style="font-size:12px;"></td>
          <td width="50" style="font-size:12px;"></td>
          <td width="5" style="font-size:12px;"></td>
          <td width="110" style="font-size:12px;"></td>
          <td width="5" style="font-size:12px;"></td>
          <td width="85" style="font-size:12px;"></td>
          <td width="5" style="font-size:12px;"></td>
          <td width="60" style="font-size:12px;"></td>
          <td width="5" style="font-size:12px;"></td>
          <td width="80" style="font-size:12px;"></td>
        <tr>
        <tr>
          <td colspan="2" rowspan="4"><img src="<?= base_url("./img/logo_honda.jpg") ?>" width="80" height="50"></td>
          <!-- <td colspan="2" rowspan="4"><img src="./img/logo_honda.jpg"></td> -->
          <td colspan="8"></td>
          <td style="font-size:12px;">No. SPK</td>
          <td width="5" style="font-size:12px;">:</td>
          <td colspan="3" style="font-size:12px;"> <?= $mohfaktur['nospk'] ?></td>
        <tr>
          <td colspan="8"></td>
          <td style="font-size:12px;">Tanggal</td>
          <td width="5" style="font-size:12px;">:</td>
          <td colspan="3" style="font-size:12px;"> <?= $mohfaktur['tglspk'] ?></td>
        <tr>
          <td colspan="8"></td>
          <td style="font-size:12px;">Sales</td>
          <td width="5" style="font-size:12px;">:</td>
          <td colspan="3" style="font-size:12px;"> <?= $mohfaktur['nmsales'] ?></td>
        <tr>
          <td colspan="8"></td>
          <td style="font-size:12px;">Supervisor</td>
          <td width="5" style="font-size:12px;">:</td>
          <td colspan="3" style="font-size:12px;"> <?= $mohfaktur['nmspv'] ?></td>
        <tr>
          <td colspan="8" style="font-size:12px;"><?= $nama_perusahaan ?></td>
        <tr>
          <td colspan="8" style="font-size:12px;"><?= $alamat_perusahaan ?></td>
        <tr>
          <td><br></td>
        <tr>
          <td colspan="2" style="font-size:12px;">Tipe Faktur</td>
          <td style="font-size:12px;">:</td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['tipe_faktur'] == "Personal" ? "checked" : "" ?> enabled></td>
          <td style="font-size:12px;">Personal</td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['tipe_faktur'] == "Company" ? "checked" : "" ?>></td>
          <td style="font-size:12px;">Company</td>
        <tr>
          <td colspan="2" style="font-size:12px;">Tipe Pelanggan</td>
          <td style="font-size:12px;">:</td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['tipe_pelanggan'] == "Personal" ? "checked" : "" ?>></td>
          <td style="font-size:12px;">Personal</td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['tipe_pelanggan'] == "Fleet" ? "checked" : "" ?>></td>
          <td style="font-size:12px;">Fleet</td>
        <tr>
          <td colspan="2" style="font-size:12px;">Status Pelanggan</td>
          <td style="font-size:12px;">:</td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['status_pelanggan'] == "Baru" ? "checked" : "" ?>></td>
          <td style="font-size:12px;">Baru</td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['status_pelanggan'] == "Lama" ? "checked" : "" ?>></td>
          <td style="font-size:12px;">Lama</td>
        <tr>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['sama_spk'] == "Y" ? "checked" : "" ?>></td>
          <td colspan="4" style="font-size:12px;">Data Pemesan sama dengan data di SPK</td>
        <tr>
          <td colspan="15">
            <!-- <br> -->
            <!-- <hr> -->
          </td>
        <tr>
          <td style="width:25px;height:20px;background:white;border-block-end:solid 1px black;border-block-start:solid 1px black;text-align:center" colspan="15" style="font-size:12px;text-align:center"><b>DATA PEMESAN</b></td>

        <tr>
          <td colspan="15">
            <!-- <br> -->
            <!-- <hr> -->
          </td>
        <tr>
          <td colspan="2" style="font-size:12px;">Nama Pemesan</td>
          <td width="5" style="font-size:12px;">:</td>
          <td colspan="5" style="font-size:12px;"> <?= $mohfaktur['nmpemesan'] ?></td>
        <tr>
          <td colspan="2" style="font-size:12px;">Nomor KTP</td>
          <td width="5" style="font-size:12px;">:</td>
          <td colspan="5" style="font-size:12px;"> <?= $mohfaktur['nik_pemesan'] ?></td>

        <tr>
          <td colspan="2" style="font-size:12px;">Alamat</td>
          <td width="5" style="font-size:12px;">:</td>
          <td colspan="13" style="font-size:12px;"> <?= $mohfaktur['alamat_pemesan'] ?></td>
        <tr>
          <td colspan="2" style="font-size:12px;">Kelurahan/Kecamatan/Kota</td>
          <td width="5" style="font-size:12px;">:</td>
          <td colspan="13" style="font-size:12px;"> <?= $mohfaktur['kel_pemesan'] . '/' . $mohfaktur['kec_pemesan'] . '/' . $mohfaktur['kota_pemesan'] ?></td>
        <tr>
          <td colspan="2" style="font-size:12px;">Handphone</td>
          <td width="5" style="font-size:12px;">:</td>
          <td colspan="5" style="font-size:12px;"> <?= $mohfaktur['hp_pemesan'] ?></td>
          <td colspan="1" style="font-size:12px;">Email </td>
          <td width="5" style="font-size:12px;">:</td>
          <td colspan="5" style="font-size:12px;"> <?= $mohfaktur['email_pemesan'] ?></td>
        <tr>
          <td colspan="15">
            <!-- <hr> -->
            <!-- <br> -->
          </td>
        <tr>
          <td style="width:25px;height:20px;background:white;border-block-end:solid 1px black;border-block-start:solid 1px black;text-align:center" colspan="15" style="font-size:12px;text-align:center"><b>DATA FAKTUR</b></td>
        <tr>
          <td colspan="15">
            <!-- <br> -->
            <!-- <hr> -->
          </td>
        <tr>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['sama_pemesan'] == "Y" ? "checked" : "" ?>></td>
          <td colspan="4" style="font-size:12px;">Sama dengan data Pemesan</td>
        <tr>
          <td colspan="2" style="font-size:12px;">Nomor Kartu Keluarga</td>
          <td width="5" style="font-size:12px;">:</td>
          <td colspan="5" style="font-size:12px;"> <?= $mohfaktur['nkk'] ?></td>
        <tr>
          <td colspan="2" style="font-size:12px;">Nomor KTP</td>
          <td width="5" style="font-size:12px;">:</td>
          <td colspan="5" style="font-size:12px;"> <?= $mohfaktur['nik_stnk'] ?></td>
        <tr>
          <td colspan="2" style="font-size:12px;">Nama Faktur/STNK</td>
          <td width="5" style="font-size:12px;">:</td>
          <td colspan="5" style="font-size:12px;"> <?= $mohfaktur['nmstnk'] ?></td>
        <tr>
          <td colspan="2" style="font-size:12px;">Alamat</td>
          <td width="5" style="font-size:12px;">:</td>
          <td colspan="13" style="font-size:12px;"> <?= $mohfaktur['alamat_stnk'] ?></td>
        <tr>
          <td colspan="2" style="font-size:12px;">Kelurahan/Kecamatan/Kota</td>
          <td width="5" style="font-size:12px;">:</td>
          <td colspan="18" style="font-size:12px;"> <?= $mohfaktur['kel_stnk'] . '/' . $mohfaktur['kec_stnk'] . '/' . $mohfaktur['kota_stnk'] ?></td>
        <tr>
          <td colspan="2" style="font-size:12px;">Handphone</td>
          <td width="5" style="font-size:12px;">:</td>
          <td colspan="5" style="font-size:12px;"> <?= $mohfaktur['hp_stnk'] ?></td>
          <td colspan="1" style="font-size:12px;">Email </td>
          <td width="5" style="font-size:12px;">:</td>
          <td colspan="5" style="font-size:12px;"> <?= $mohfaktur['email_stnk'] ?></td>
        <tr>
          <td colspan="15">
            <!-- <br> -->
            <!-- <hr> -->
            <!-- </td> -->
        <tr>
          <td style="width:25px;height:20px;background:white;border-block-end:solid 1px black;border-block-start:solid 1px black;text-align:center" colspan="15" style="font-size:12px;text-align:center"><b>DATA KENDARAAN</b></td>

        <tr>
          <td colspan="15">
            <!-- <br> -->
            <!-- <hr> -->
          </td>
        <tr>
          <td colspan="2" style="font-size:12px;">Model/Tipe</td>
          <td width="5" style="font-size:12px;">:</td>
          <td colspan="5" style="font-size:12px;"> <?= $mohfaktur['nmmodel'] . '/' . $mohfaktur['nmtipe'] ?></td>
          <td colspan="1" style="font-size:12px;">Warna </td>
          <td width="5" style="font-size:12px;">:</td>
          <td colspan="5" style="font-size:12px;"> <?= $mohfaktur['nmwarna'] ?></td>
        <tr>
          <td colspan="2" style="font-size:12px;">Nomor Rangka</td>
          <td width="5" style="font-size:12px;">:</td>
          <td colspan="5" style="font-size:12px;"> <?= $mohfaktur['norangka'] ?></td>
          <td colspan="1" style="font-size:12px;">Nomor Mesin </td>
          <td width="5" style="font-size:12px;">:</td>
          <td colspan="5" style="font-size:12px;"> <?= $mohfaktur['nomesin'] ?></td>
        <tr>
          <td colspan="2" style="font-size:12px;">Aksesoris</td>
          <td width="5" style="font-size:12px;">:</td>
          <td colspan="7" style="font-size:12px;"> <?= $mohfaktur['accessories'] ?></td>
        <tr>
          <td colspan="2" style="font-size:12px;">Harga</td>
          <td width="5" style="font-size:12px;">:</td>
          <td colspan="5" style="font-size:12px;"> <?= 'Rp. ' . number_format($mohfaktur['harga'], 0, ',', ',') ?></td>
        <tr>
          <td colspan="2" style="font-size:12px;">Down Parment</td>
          <td width="5" style="font-size:12px;">:</td>
          <td colspan="5" style="font-size:12px;"> <?= 'Rp. ' . number_format($mohfaktur['dp'], 0, ',', ',') ?></td>
        <tr>
          <td colspan="2" style="font-size:12px;">Tanggal Pembayaran DP</td>
          <td width="5" style="font-size:12px;">:</td>
          <?php
          $date = date_create($mohfaktur['tgl_dp']);
          ?>
          <td colspan="3" style="font-size:12px;"> <?= date_format($date, "d-m-Y"); ?></td>
        <tr>
          <td colspan="2" style="font-size:12px;">ETA</td>
          <td width="5" style="font-size:12px;">:</td>
          <?php
          $date = date_create($mohfaktur['eta']);
          ?>
          <td colspan="4" style="font-size:12px;"> <?= date_format($date, "d-m-Y H:i:s"); ?></td>
          <!-- <td colspan="5" style="font-size:12px;"> <?= $mohfaktur['eta'] ?></td> -->
          <td></td>
          <?php
          $date = date_create($mohfaktur['eta']);
          ?>
          <td colspan="4" style="font-size:12px;"> ETD : <?= date_format($date, "d-m-Y H:i:s"); ?></td>
        <tr>
          <td colspan="2" style="font-size:12px;">Paket</td>
          <td style="font-size:12px;">:</td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['paket'] == "Pahe 1" ? "checked" : "" ?>></td>
          <td style="font-size:12px;">Pahe 1</td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['paket'] == "Pahe 2" ? "checked" : "" ?>></td>
          <td style="font-size:12px;">Pahe 2</td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['paket'] == "Extended Warranty" ? "checked" : "" ?>></td>
          <td colspan="3" style="font-size:12px;">Extended Warranty</td>
        <tr>
          <td colspan="15">
            <!-- <br> -->
            <!-- <hr> -->
          </td>
        <tr>
          <td style="width:25px;height:20px;background:white;border-block-end:solid 1px black;border-block-start:solid 1px black;text-align:center" colspan="15" style="font-size:12px;text-align:center"><b>INFORMASI TAMBAHAN</b></td>
        <tr>
          <td colspan="15">
            <!-- <br> -->
            <!-- <hr> -->
          </td>
        <tr>
          <td colspan="2" style="font-size:12px;">Jenis Kelamin</td>
          <td style="font-size:12px;">:</td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['jekel'] == "Pria" ? "checked" : "" ?>></td>
          <td style="font-size:12px;">Pria</td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['jekel'] == "Wanita" ? "checked" : "" ?>></td>
          <td style="font-size:12px;">Wanita</td>
        <tr>
          <td colspan="2" style="font-size:12px;">Tanggal Lahir</td>
          <td width="5" style="font-size:12px;">:</td>
          <?php
          $date = date_create($mohfaktur['tgllahir']);
          ?>
          <td colspan="3" style="font-size:12px;"> <?= date_format($date, "d-m-Y"); ?></td>
        <tr>
          <td colspan="2" style="font-size:12px;">Status Pernikahan</td>
          <td width="5" style="font-size:12px;">:</td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['status_menikah'] == "Menikah" ? "checked" : "" ?>></td>
          <td style="font-size:12px;">Menikah</td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['status_menikah'] == "Belum Menikah" ? "checked" : "" ?>></td>
          <td colspan="3" style="font-size:12px;">Belum Menikah</td>
        <tr>
          <td colspan="2" style="font-size:12px;">Jumlah Keluarga Inti</td>
          <td width="5" style="font-size:12px;">:</td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['jumlah_keluarga'] == "1" ? "checked" : "" ?>></td>
          <td style="font-size:12px;">1</td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['jumlah_keluarga'] == "2" ? "checked" : "" ?>></td>
          <td style="font-size:12px;">2</td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['jumlah_keluarga'] == "3" ? "checked" : "" ?>></td>
          <td style="font-size:12px;">3</td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['jumlah_keluarga'] == "4" ? "checked" : "" ?>></td>
          <td style="font-size:12px;">4</td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['jumlah_keluarga'] == "5" ? "checked" : "" ?>></td>
          <td style="font-size:12px;">>=5</td>
        <tr>
          <td colspan="2" style="font-size:12px;">Agama</td>
          <td width="5" style="font-size:12px;">:</td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['agama'] == "ISLAM" ? "checked" : "" ?>></td>
          <td style="font-size:12px;">Islam</td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['agama'] == "KRISTEN PROTESTAN" ? "checked" : "" ?>></td>
          <td style="font-size:12px;">Katolik</td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['agama'] == "KRISTEN KATHOLIK" ? "checked" : "" ?>></td>
          <td style="font-size:12px;">Kristen</td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['agama'] == "BUDHA" ? "checked" : "" ?>></td>
          <td style="font-size:12px;">Budha</td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['agama'] == "HINDU" ? "checked" : "" ?>></td>
          <td style="font-size:12px;">Hindu</td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['agama'] == "LAIN-LAIN (KEPERCAYAAN)" ? "checked" : "" ?>></td>
          <td style="font-size:12px;">Kong Hu Cu</td>
        <tr>
          <td colspan="2" style="font-size:12px;">Pekerjaan</td>
          <td width="5" style="font-size:12px;">:</td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['pekerjaan'] == "Tentara" ? "checked" : "" ?>></td>
          <td style="font-size:12px;">Tentara</td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['pekerjaan'] == "Dokter" ? "checked" : "" ?>></td>
          <td style="font-size:12px;">Dokter</td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['pekerjaan'] == "Pegawai Pemerintah" ? "checked" : "" ?>></td>
          <td style="font-size:12px;">Pegawai Pemerintah</td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['pekerjaan'] == "Pegawai Swasta" ? "checked" : "" ?>></td>
          <td style="font-size:12px;">Pegawai Swasta</td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['pekerjaan'] == "Pengacara" ? "checked" : "" ?>></td>
          <td style="font-size:12px;">Pengacara</td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['pekerjaan'] == "Arsitek" ? "checked" : "" ?>></td>
          <td style="font-size:12px;">Arsitek</td>
        <tr>
          <td colspan="3" style="font-size:12px;"></td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['tipe_faktur'] == "Pelajar" ? "checked" : "" ?>></td>
          <td style="font-size:12px;">Pelajar</td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['tipe_faktur'] == "Guru/Dosen" ? "checked" : "" ?>></td>
          <td style="font-size:12px;">Guru/Dosen</td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['tipe_faktur'] == "Lain-Lain" ? "checked" : "" ?>></td>
          <td style="font-size:12px;">Lain-Lain</td>
        <tr>
          <td><br></td>
        <tr>
          <td colspan="2" style="font-size:12px;">Metode Pembelian</td>
          <td width="5" style="font-size:12px;">:</td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['metode_pembelian'] == "Mobil Pertama" ? "checked" : "" ?>></td>
          <td colspan="2" style="font-size:12px;">Mobil Pertama</td>
        <tr>
          <td colspan="3" style="font-size:12px;"></td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['metode_pembelian'] == "Mobil Tambahan" ? "checked" : "" ?>></td>
          <td colspan="2" style="font-size:12px;">Mobil Tambahan</td>
          <td></td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['tambah_honda'] == "Y" ? "checked" : "" ?>></td>
          <td style="font-size:12px;">Honda</td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['tambah_nonhonda'] == "Y" ? "checked" : "" ?>></td>
          <td style="font-size:12px;">Bukan Honda</td>
        <tr>
          <td colspan="3" style="font-size:12px;"></td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['metode_pembelian'] == "Mobil Pengganti" ? "checked" : "" ?>></td>
          <td colspan="2" style="font-size:12px;">Mobil Pengganti</td>
          <td></td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['ganti_honda'] == "Y" ? "checked" : "" ?>></td>
          <td style="font-size:12px;">Honda</td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['ganti_nonhonda'] == "Y" ? "checked" : "" ?>></td>
          <td style="font-size:12px;">Bukan Honda</td>
        <tr>
          <td><br></td>
        <tr>
          <td colspan="2" style="font-size:12px;">Metode Pembayaran</td>
          <td width="5" style="font-size:12px;">:</td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['metode_pembayaran'] == "Cash" ? "checked" : "" ?>></td>
          <td style="font-size:12px;">Cash</td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['metode_pembayaran'] == "Credit" ? "checked" : "" ?>></td>
          <td style="font-size:12px;">Credit</td>
          <td colspan="5" style="font-size:12px;">Perusahaan Leasing : <?= $mohfaktur['leasing'] ?></td>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td colspan="5" style="font-size:12px;">Tenor Pembayaran : <?= $mohfaktur['tenor'] ?>, Bulan : <?= $mohfaktur['bulan'] ?></td>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td colspan="2" style="font-size:12px;">Asuransi : </td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['asuransi'] == "Y" ? "checked" : "" ?>></td>
          <td style="font-size:12px;">Ya</td>
          <td style="font-size:12px;"> <input type="checkbox" <?= $mohfaktur['asuransi'] == "N" ? "checked" : "" ?>></td>
          <td style="font-size:12px;">Tidak</td>
      </table>
    </div>
    <br>
    <table cellspacing="1" cellpadding="0" height="1">
      <tr>
        <td width="110" style="font-size:12px;text-align:center"><?= 'CUSTOMER' ?></td>
        <td width="110" style="font-size:12px;text-align:center"><?= 'SALES' ?></td>
        <td width="110" style="font-size:12px;text-align:center"><?= 'SUPERVISOR' ?></td>
        <td width="110" style="font-size:12px;text-align:center"><?= 'ASM/SM' ?></td>
        <td width="110" style="font-size:12px;text-align:center"><?= 'Spesial ADMIN' ?></td>
      <tr>
        <td><br><br><br><br></td>
      <tr>
        <td width="110" style="font-size:12px;text-align:center"><u><?= '( ' . strtoupper($mohfaktur['nmpemesan']) . ' )' ?></u></td>
        <td width="110" style="font-size:12px;text-align:center"><u><?= '( ' . strtoupper($mohfaktur['nmsales']) . ' )' ?></u></td>
        <td width="110" style="font-size:12px;text-align:center"><u><?= '( ' . strtoupper($mohfaktur['nmspv']) . ' )' ?></u></td>
        <td width="110" style="font-size:12px;text-align:center"><u><?= '( ' . strtoupper($mohfaktur['nmsm']) . ' )' ?></u></td>
        <td width="110" style="font-size:12px;text-align:center"><u><?= '( ' . strtoupper($mohfaktur['admin']) . ' )' ?></u></td>
      </tr>
      <!-- <tr>
    <td width="100" style="font-size:12px;text-align:center"><?= '(________________________)' ?></td>
    <td width="100" style="font-size:12px;text-align:center"><?= '(________________________)' ?></td>
    <td width="100" style="font-size:12px;text-align:center"><?= '(________________________)' ?></td>
  </tr> -->
    </table>
  </div>


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