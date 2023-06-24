<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\UserdtlModel;
use App\Models\MemombrModel;
use App\Models\PengajuandiscountModel;
use App\Models\MohfakturModel;

class Dashboard extends Controller
{
  protected $userdtl, $userdtlmodel, $memombrModel, $pengajuandiscountModel, $mohfakturModel;
  public function __construct()
  {
    $this->userdtlmodel = new userdtlModel();
    $this->memombrModel = new MemombrModel();
    $this->pengajuandiscountModel = new PengajuandiscountModel();
    $this->mohfakturModel = new mohfakturModel();
  }

  public function index()
  {
    $userdtlModel = new userdtlmodel();
    $session = session();
    $username = $session->get('email');
    echo "<p>Selamat datang, " . $session->get('nama_lengkap') . "</p>";
    // return redirect()->to('template');
    $data = [
      'menu' => 'dashboard',
      'submenu' => '',
      'username' => $username,
      'memombr' => $this->memombrModel->jumlah_record(),
      'pengajuandiscount' => $this->pengajuandiscountModel->jumlah_record(),
      'pengajuandiscount_approved' => $this->pengajuandiscountModel->jumlah_record_approved(),
      'mohfaktur' => $this->mohfakturModel->jumlah_record(),
    ];
    // var_dump($data);
    return view('dashboard/index', $data);
  }

  function tampilGrafikMemombr()
  {
    $bulan = $this->request->getPost('bulan');
    $db = \Config\Database::connect();
    $query = $db->query("SELECT tanggal,total from memombr where date_format(tanggal,'%Y-%m') = '$bulan' order by tanggal asc")->getResult();
    $data = [
      'grafik' => $query
    ];
    $json = [
      'data' => view('dashboard/grafikmemombr', $data),
    ];
    // var_dump($bulan);
    echo json_encode($json);
  }

  function tampilGrafik()
  {
    $bulan = $this->request->getPost('bulan');
    $db = \Config\Database::connect();
    //   select * FROM
    // (SELECT COUNT(*) AS numrows 
    //  FROM memombr where date_format(tanggal,'%Y-%m') = '2023-03'
    //  UNION ALL 
    //  SELECT COUNT(*) as numrows1
    //  FROM pengajuandiscount where date_format(tanggal,'%Y-%m') = '2023-03'
    // ) AS a
    $query = $db->query("select * FROM (SELECT COUNT(*) AS numrows,tanggal as tanggal FROM memombr where date_format(tanggal,'%Y-%m') = '$bulan' and valid='Y' UNION ALL 
    SELECT COUNT(*) as numrows,tanggal as tanggal FROM pengajuandiscount where date_format(tanggal,'%Y-%m') = '$bulan' and valid='Y' UNION ALL
    SELECT COUNT(*) as numrows,tanggal as tanggal FROM mohfaktur where date_format(tanggal,'%Y-%m') = '$bulan' and valid='Y') AS a")->getResult();
    $data = [
      'grafik' => $query
    ];
    $json = [
      'data' => view('dashboard/grafikgabungan', $data),
    ];
    // var_dump($bulan);
    echo json_encode($json);
  }
}
