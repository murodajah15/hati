<?php

namespace App\Controllers;

use App\Models\Estimasi_bpModel;
use App\Models\Estimasibahan_bpModel;
use App\Models\Wo_bpModel;
use App\Models\Wobahan_bpModel;
use App\Models\TbbahanModel;
use App\Models\TbmekanikModel;
use App\Models\PaketbahanModel;

use \Dompdf\Dompdf;

class Bahan_bp extends BaseController
{
  protected $tbcustomerModel, $estimasi_bpModel, $wo_bpModel, $tbmobilModel, $tbmerekModel, $tbmodelModel, $tbtipeModel, $tbwarnaModel, $tbjenisModel, $tbagamaModel,
    $tbbarangModel, $estimasibahan_bpModel, $tbbahanModel, $tboplModel, $tbjasaModel, $tbsaModel, $estimasiopl_bpModel, $estimasijasa_bpModel, $tbpaketModel,
    $paketbahanModel, $tbasuransiModel, $tasklist_bpdModel, $wobahan_bpModel, $tbmekanikModel;
  public function __construct()
  {
    $this->estimasi_bpModel = new Estimasi_bpModel();
    $this->estimasibahan_bpModel = new Estimasibahan_bpModel();
    $this->wo_bpModel = new Wo_bpModel();
    $this->wobahan_bpModel = new Wobahan_bpModel();
    $this->tbbahanModel = new TbbahanModel();
    $this->paketbahanModel = new PaketbahanModel();
    $this->tbmekanikModel = new TbmekanikModel();
  }

  public function index()
  {
    $data = [
      'menu' => 'transaksi',
      'submenu' => 'bahan_bp',
      'submenu1' => 'body_repair',
      'title' => 'Pembebanan Bahan Body Repair',
      'wo_bp' => $this->wo_bpModel->orderBy('nowo')->findAll() //$wo
    ];
    echo view('bahan_bp/index', $data);
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

  public function input_bahan_bp()
  {
    $id = $this->request->getVar('id');
    $row = $this->wo_bpModel->find($id);
    $data = [
      'title' => 'Update Bahan Body Repair',
      'wo_bp' => $this->wo_bpModel->find($id),
    ];
    // var_dump($data);
    $msg = [
      'sukses' => view('bahan_bp/input_bahan_bp', $data)
    ];
    echo json_encode($msg);
  }

  public function table_wo_bp()
  {
    $model = new wo_bpModel();
    $data['title'] = 'Work Order Body Repair';
    $data['wo_bp'] = $model->findAll();
    echo view('bahan_bp/tabel_wo_bp', $data);
  }

  public function table_bahan_bp()
  {
    $nowo = $_POST['nowo'];
    $data = [
      'nowo' => $nowo,
      'title' => 'Part WO Body Repair',
      'wo_bahan' => $this->wobahan_bpModel->getnowo($nowo)
    ];
    // dd($data);
    echo view('bahan_bp/tabel_bahan_bp', $data);
  }

  public function caridatapart()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data Part',
        'tbbarang' => $this->tbbarangModel->where('aktif', 'Y')->orderBy('kode', 'asc')->findAll() //$rwtkeluarga
      ];
      $msg = [
        'data' => view('bahan_bp/modalcaripart', $data),
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

  public function close_bahan_bp()
  {
    if ($this->request->isAjax()) {
      $session = session();
      $id = $_POST['id'];
      $user = "Proses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      $simpandata = [
        'close_bahan' => 1,
        'user_close_bahan' => $user,
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
  public function unclose_bahan_bp()
  {
    if ($this->request->isAjax()) {
      $session = session();
      $id = $_POST['id'];
      $row = $this->wo_bpModel->find($id);
      if ($row['close'] < 1) {
        $user = "Unproses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        $simpandata = [
          'close_bahan' => 0,
          'user_close_bahan' => $user,
        ];
        $this->wo_bpModel->update($id, $simpandata);
        $msg = [
          'sukses' => 'Data berhasil disimpan'
        ];
        session()->setFlashdata('pesan', 'Data berhasil diupdate');
      } else {
        $msg = [
          'sukses' => 'Data gagal disimpan'
        ];
        session()->setFlashdata('pesan', 'Data gagal diupdate');
      }
      echo json_encode($msg);
    };
  }
}
