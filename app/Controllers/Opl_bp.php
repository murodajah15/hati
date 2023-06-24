<?php

namespace App\Controllers;

use App\Models\Estimasi_bpModel;
use App\Models\Estimasiopl_bpModel;
use App\Models\Wo_bpModel;
use App\Models\Woopl_bpModel;
use App\Models\TboplModel;
use App\Models\TbmekanikModel;
use App\Models\PaketoplModel;

use \Dompdf\Dompdf;

class opl_bp extends BaseController
{
  protected $tbcustomerModel, $estimasi_bpModel, $wo_bpModel, $tbmobilModel, $tbmerekModel, $tbmodelModel, $tbtipeModel, $tbwarnaModel, $tbjenisModel, $tbagamaModel,
    $tbbarangModel, $estimasipart_bpModel, $tboplModel, $tbjasaModel, $tbsaModel, $estimasiopl_bpModel, $estimasijasa_bpModel, $tbpaketModel,
    $paketpartModel, $paketjasaModel, $paketoplModel, $tbasuransiModel, $tasklist_bpdModel, $woopl_bpModel,
    $tbmekanikModel;
  public function __construct()
  {
    $this->estimasi_bpModel = new Estimasi_bpModel();
    $this->estimasiopl_bpModel = new Estimasiopl_bpModel();
    $this->wo_bpModel = new Wo_bpModel();
    $this->woopl_bpModel = new Woopl_bpModel();
    $this->tboplModel = new TboplModel();
    $this->paketoplModel = new PaketoplModel();
    $this->tbmekanikModel = new TbmekanikModel();
  }

  public function index()
  {
    $data = [
      'menu' => 'transaksi',
      'submenu' => 'opl_bp',
      'title' => 'Pembebanan OPL Body Repair',
      'wo_bp' => $this->wo_bpModel->orderBy('nowo')->findAll() //$wo
    ];
    echo view('opl_bp/index', $data);
  }

  public function ajaxLoadData()
  {
    $request = $this->request;
    $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
    $katakunci = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
    $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
    $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
    $data = $this->wo_bpModel->tampilData($request, $katakunci, $start, $length);
    $jumlahData = $this->wo_bpModel->tampilData($request, $katakunci);
    $output = array(
      "draw" => intval($param['draw']),
      "recordsTotal" => count($jumlahData),
      "recordsFiltered" => count($jumlahData),
      "data" => $data,
    );
    // var_dump($data);
    echo json_encode($output);
  }

  public function input_opl_bp()
  {
    $id = $this->request->getVar('id');
    $row = $this->wo_bpModel->find($id);
    $data = [
      'title' => 'Update OPL Body Repair',
      'wo_bp' => $this->wo_bpModel->find($id),
    ];
    // var_dump($data);
    $msg = [
      'sukses' => view('opl_bp/input_opl_bp', $data)
    ];
    echo json_encode($msg);
  }

  public function table_wo_bp()
  {
    $model = new wo_bpModel();
    $data['title'] = 'Work Order Body Repair';
    $data['wo_bp'] = $model->findAll();
    echo view('opl_bp/tabel_wo_bp', $data);
  }

  public function table_opl_bp()
  {
    $nowo = $_POST['nowo'];
    $data = [
      'nowo' => $nowo,
      'title' => 'Part WO Body Repair',
      'wo_opl' => $this->woopl_bpModel->getnowo($nowo)
    ];
    // dd($data);
    echo view('opl_bp/tabel_opl_bp', $data);
  }

  public function caridatapart()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data Part',
        'tbbarang' => $this->tbbarangModel->where('aktif', 'Y')->orderBy('kode', 'asc')->findAll() //$rwtkeluarga
      ];
      $msg = [
        'data' => view('opl_bp/modalcaripart', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function replpart()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['kodepart'];
      $row = $this->tbbarangModel->getkdbarang($kode);
      if (isset($row)) {
        $data = [
          'title' => 'Detail data',
          'kode' => $row['kode'],
          'nama' => $row['nama'],
          'harga' => $row['harga_jual'],
        ];
      } else {
        $data = [
          'title' => 'Detail data',
          'kode' => '',
          'nama' => '',
          'harga' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function close_opl_bp()
  {
    if ($this->request->isAjax()) {
      $session = session();
      $id = $_POST['id'];
      $user = "Proses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      $simpandata = [
        'close_opl' => 1,
        'user_close_opl' => $user,
      ];
      // var_dump($simpandata);
      $this->wo_bpModel->update($id, $simpandata);
      $msg = [
        'sukses' => 'Data berhasil disimpan'
      ];
      session()->setFlashdata('pesan', 'Data berhasil diupdate');
      echo json_encode($msg);
    };
  }
  public function unclose_opl_bp()
  {
    if ($this->request->isAjax()) {
      $session = session();
      $id = $_POST['id'];
      $user = "Unproses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      $simpandata = [
        'close_opl' => 0,
        'user_close_opl' => $user,
      ];
      $this->wo_bpModel->update($id, $simpandata);
      $msg = [
        'sukses' => 'Data berhasil disimpan'
      ];
      session()->setFlashdata('pesan', 'Data berhasil diupdate');
      echo json_encode($msg);
    };
  }
}
