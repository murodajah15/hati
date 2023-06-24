<?php

namespace App\Controllers;

use App\Models\MemombrModel;
use App\Models\TbcustomerModel;
use App\Models\tbmerekModel;
use App\Models\tbmodelModel;
use App\Models\tbtipeModel;
use App\Models\tbwarnaModel;
use App\Models\tbjenisModel;
use App\Models\tbasuransiModel;
use App\Models\tbleasingModel;
use App\Models\tbsalesModel;
use App\Models\MemombrdModel;
use App\Models\PengajuandiscountModel;
use App\Models\PenerimaankasirModel;
use App\Models\HisuserModel;
use \Dompdf\Dompdf;

class Approvmemospv extends BaseController
{
  protected $tbcustomerModel, $memombrModel, $woModel, $tbmobilModel, $tbmerekModel, $tbmodelModel, $tbtipeModel, $tbwarnaModel, $tbjenisModel, $tbagamaModel,
    $tbasuransiModel, $tbleasingModel, $tbsalesModel, $memombrdModel, $pengajuandiscountModel, $penerimaankasirModel, $hisuserModel;
  public function __construct()
  {
    $this->memombrModel = new MemombrModel();
    $this->tbcustomerModel = new TbcustomerModel();
    $this->tbmerekModel = new TbmerekModel();
    $this->tbmodelModel = new TbmodelModel();
    $this->tbtipeModel = new TbtipeModel();
    $this->tbwarnaModel = new TbwarnaModel();
    $this->tbjenisModel = new TbjenisModel();
    $this->tbasuransiModel = new TbasuransiModel();
    $this->tbleasingModel = new TbleasingModel();
    $this->tbsalesModel = new TbsalesModel();
    $this->memombrdModel = new MemombrdModel();
    $this->pengajuandiscountModel = new PengajuandiscountModel();
    $this->penerimaankasirModel = new PenerimaankasirModel();
    $this->hisuserModel = new HisuserModel();
  }

  public function index()
  {
    $data = [
      'menu' => 'proses',
      'submenu' => 'approvmemospv',
      'title' => 'Approv Memo Mobil Baru',
      'pengajuandiscount' => $this->pengajuandiscountModel->orderBy('nomemo', 'desc')->findAll() //$wo
    ];
    echo view('approvmemospv/index', $data);
  }

  public function ajaxLoadData()
  {
    $request = $this->request;
    // dd($request->getPost('order[0][column]'));
    $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
    $katakunci = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
    $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
    $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
    $data = $this->pengajuandiscountModel->where('valid', 'Y')->tampilData($request, $katakunci, $start, $length);
    $jumlahData = $this->pengajuandiscountModel->tampilData($request, $katakunci);
    $output = array(
      "draw" => intval($param['draw']),
      "recordsTotal" => count($jumlahData),
      "recordsFiltered" => count($jumlahData),
      "data" => $data,
    );
    echo json_encode($output);
  }

  public function table_approvmemospv()
  {
    $model = new pengajuandiscountModel();
    $data['title'] = 'memombr';
    echo view('approvmemospv/tabel_approvmemospv', $data);
  }

  public function formdetail()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->pengajuandiscountModel->find($id);
      $nomemo = $row['nomemo'];
      $data = [
        'title' => 'Detail Data Pengajuan Discount Mobil Baru',
        'pengajuandiscount' => $this->pengajuandiscountModel->find($id),
        'memombr' => $this->memombrModel->getnomemo($nomemo),
      ];
      $msg = [
        'sukses' => view('Approvmemospv/modaldetail', $data)
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
}
