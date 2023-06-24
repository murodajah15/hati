<?php

namespace App\Controllers;

use App\Models\Estimasi_bpModel;
use App\Models\Estimasipart_bpModel;
use App\Models\Estimasibahan_bpModel;
use App\Models\Estimasiopl_bpModel;
use App\Models\Estimasijasa_bpModel;
use App\Models\Wo_bpModel;
use App\Models\Wopart_bpModel;
use App\Models\Wobahan_bpModel;
use App\Models\Woopl_bpModel;
use App\Models\Wojasa_bpModel;
use App\Models\TbcustomerModel;
use App\Models\TbmobilModel;
use App\Models\TbmerekModel;
use App\Models\TbmodelModel;
use App\Models\TbtipeModel;
use App\Models\TbwarnaModel;
use App\Models\TbjenisModel;
use App\Models\TbagamaModel;
use App\Models\TbbarangModel;
use App\Models\TbbahanModel;
use App\Models\TboplModel;
use App\Models\TbjasaModel;
use App\Models\TbsaModel;
use App\Models\TbmekanikModel;
use App\Models\TbpaketModel;
use App\Models\PaketpartModel;
use App\Models\PaketjasaModel;
use App\Models\PaketbahanModel;
use App\Models\PaketoplModel;
use App\Models\TbasuransiModel;
use App\Models\Tasklist_bpdModel;

use \Dompdf\Dompdf;

class Part_bp extends BaseController
{
  protected $tbcustomerModel, $estimasi_bpModel, $wo_bpModel, $tbmobilModel, $tbmerekModel, $tbmodelModel, $tbtipeModel, $tbwarnaModel, $tbjenisModel, $tbagamaModel,
    $tbbarangModel, $estimasipart_bpModel, $estimasibahan_bpModel, $tbbahanModel, $tboplModel, $tbjasaModel, $tbsaModel, $estimasiopl_bpModel, $estimasijasa_bpModel, $tbpaketModel,
    $paketpartModel, $paketjasaModel, $paketbahanModel, $paketoplModel, $tbasuransiModel, $tasklist_bpdModel, $wopart_bpModel, $wobahan_bpModel, $woopl_bpModel, $wojasa_bpModel,
    $tbmekanikModel;
  public function __construct()
  {
    $this->estimasi_bpModel = new Estimasi_bpModel();
    $this->estimasipart_bpModel = new Estimasipart_bpModel();
    $this->estimasibahan_bpModel = new Estimasibahan_bpModel();
    $this->estimasiopl_bpModel = new Estimasiopl_bpModel();
    $this->estimasijasa_bpModel = new Estimasijasa_bpModel();
    $this->wo_bpModel = new Wo_bpModel();
    $this->wopart_bpModel = new Wopart_bpModel();
    $this->wobahan_bpModel = new Wobahan_bpModel();
    $this->woopl_bpModel = new Woopl_bpModel();
    $this->wojasa_bpModel = new Wojasa_bpModel();
    $this->tbcustomerModel = new TbcustomerModel();
    $this->tbmobilModel = new TbmobilModel();
    $this->tbmerekModel = new TbmerekModel();
    $this->tbmodelModel = new TbmodelModel();
    $this->tbtipeModel = new TbtipeModel();
    $this->tbwarnaModel = new TbwarnaModel();
    $this->tbjenisModel = new TbjenisModel();
    $this->tbcustomerModel = new TbcustomerModel();
    $this->tbagamaModel = new TbagamaModel();
    $this->tbbarangModel = new TbbarangModel();
    $this->tbbahanModel = new TbbahanModel();
    $this->tboplModel = new TboplModel();
    $this->tbjasaModel = new TbjasaModel();
    $this->tbsaModel = new TbsaModel();
    $this->tbpaketModel = new TbpaketModel();
    $this->paketpartModel = new PaketpartModel();
    $this->paketjasaModel = new PaketjasaModel();
    $this->paketbahanModel = new PaketbahanModel();
    $this->paketoplModel = new PaketoplModel();
    $this->tbasuransiModel = new TbasuransiModel();
    $this->tasklist_bpdModel = new Tasklist_bpdModel();
  }

  public function index()
  {
    $data = [
      'menu' => 'transaksi',
      'submenu' => 'part_bp',
      'title' => 'Pembebanan Spare Part Body Repair',
      'wo_bp' => $this->wo_bpModel->orderBy('nowo')->findAll() //$wo
    ];
    echo view('part_bp/index', $data);
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

  public function input_part_bp()
  {
    $id = $this->request->getVar('id');
    $row = $this->wo_bpModel->find($id);
    $data = [
      'title' => 'Update Spare Part Body Repair',
      'wo_bp' => $this->wo_bpModel->find($id),
    ];
    // var_dump($data);
    $msg = [
      'sukses' => view('part_bp/input_part_bp', $data)
    ];
    echo json_encode($msg);
  }

  public function table_wo_bp()
  {
    $model = new wo_bpModel();
    $data['title'] = 'Work Order Body Repair';
    $data['wo_bp'] = $model->findAll();
    echo view('part_bp/tabel_wo_bp', $data);
  }

  public function table_part_bp()
  {
    $nowo = $_POST['nowo'];
    $data = [
      'nowo' => $nowo,
      'title' => 'Part WO Body Repair',
      'wo_part' => $this->wopart_bpModel->getnowo($nowo)
    ];
    // dd($data);
    echo view('part_bp/tabel_part_bp', $data);
  }

  public function caridatapart()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data Part',
        'tbbarang' => $this->tbbarangModel->where('aktif', 'Y')->orderBy('kode', 'asc')->findAll() //$rwtkeluarga
      ];
      $msg = [
        'data' => view('part_bp/modalcaripart', $data),
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

  public function close_part_bp()
  {
    if ($this->request->isAjax()) {
      $session = session();
      $id = $_POST['id'];
      $user = "Proses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      $simpandata = [
        'close_part' => 1,
        'user_close_part' => $user,
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
  public function unclose_part_bp()
  {
    if ($this->request->isAjax()) {
      $session = session();
      $id = $_POST['id'];
      $user = "Unproses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      $simpandata = [
        'close_part' => 0,
        'user_close_part' => $user,
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
