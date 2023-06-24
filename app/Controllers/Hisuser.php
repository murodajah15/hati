<?php

namespace App\Controllers;

use App\Models\HisuserModel;
use \Dompdf\Dompdf;

class Hisuser extends BaseController
{
  protected $hisuserModel;
  public function __construct()
  {
    $this->hisuserModel = new HisuserModel();
  }

  public function index()
  {
    $data = [
      'menu' => 'file',
      'submenu' => 'hisuser',
      'title' => 'History User',
      'hisuser' => $this->hisuserModel->findAll() //$wo
    ];
    echo view('hisuser/index', $data);
  }

  public function ajaxLoadData()
  {
    $request = $this->request;
    // dd($request->getPost('order[0][column]'));
    $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
    $katakunci = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
    $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
    $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
    $data = $this->hisuserModel->tampilData($request, $katakunci, $start, $length);
    $jumlahData = $this->hisuserModel->tampilData($request, $katakunci);
    $output = array(
      "draw" => intval($param['draw']),
      "recordsTotal" => count($jumlahData),
      "recordsFiltered" => count($jumlahData),
      "data" => $data,
    );
    echo json_encode($output);
  }

  public function table_hisuser()
  {
    $model = new hisuserModel();
    $data['title'] = 'hisuser';
    echo view('hisuser/tabel_hisuser', $data);
  }

  public function formdetail()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->hisuserModel->find($id);
      $data = [
        'title' => 'Detail Data History User',
        'hisuser' => $this->hisuserModel->find($id),
      ];
      $msg = [
        'sukses' => view('hisuser/modaldetail', $data)
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function rhisuser()
  {
    $data = [
      'menu' => 'report',
      'submenu' => 'rhisuser',
      'title' => 'Laporam History User',
    ];
    echo view('hisuser/rhisuser', $data);
  }

  public function table_rhisuser()
  {
    $tanggal1 = $_POST['tanggal1'];
    $tanggal2 = $_POST['tanggal2'];
    if ($_POST['periode'] == 'off') {
      $data = [
        'title' => 'Laporam History User Semua Periode',
        'periode' => $_POST['periode'],
        'hisuser' => $this->hisuserModel->findAll(),
      ];
    } else {
      $data = [
        'title' => 'Laporam History User',
        'tanggal1' => $_POST['tanggal1'],
        'tanggal2' => $_POST['tanggal2'],
        'periode' => $_POST['periode'],
        'hisuser' => $this->hisuserModel->getperiode($tanggal1, $tanggal2),
      ];
    }
    // var_dump($data);
    echo view('hisuser/tabel_rhisuser', $data);
  }

  public function cetakrhisuser($tgl1)
  {
    $tanggal1 = $tgl1;
    // $tanggal2 = $_POST['tanggal2'];
    // if ($_POST['periode'] == 'on') {
    //   $data = [
    //     'title' => 'Laporam History User',
    //     'tanggal1' => $_POST['tanggal1'],
    //     'tanggal2' => $_POST['tanggal2'],
    //     'periode' => $_POST['periode'],
    //     'hisuser' => $this->hisuserModel->findAll(),
    //   ];
    // } else {
    //   $data = [
    //     'title' => 'Laporam History User',
    //     'tanggal1' => $_POST['tanggal1'],
    //     'tanggal2' => $_POST['tanggal2'],
    //     'periode' => $_POST['periode'],
    //     'hisuser' => $this->hisuserModel->getperiode($tanggal1, $tanggal2),
    //   ];
    // }
    // var_dump($data);
    $data = [
      'title' => 'Laporam History User',
      'hisuser' => $this->hisuserModel->findAll(),
    ];
    return view('hisuser/cetakrhisuser', $data);
  }
}
