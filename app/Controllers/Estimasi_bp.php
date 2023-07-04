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
use App\Models\TbpaketModel;
use App\Models\PaketpartModel;
use App\Models\PaketjasaModel;
use App\Models\PaketbahanModel;
use App\Models\PaketoplModel;
use App\Models\TbasuransiModel;
use App\Models\Tasklist_bpdModel;
use App\Models\TbmekanikModel;

use \Dompdf\Dompdf;

class Estimasi_bp extends BaseController
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
    $this->tbmekanikModel = new TbmekanikModel();
  }

  public function index()
  {
    $data = [
      'menu' => 'transaksi',
      'submenu' => 'estimasi_bp',
      'submenu1' => 'body_repair',
      'title' => 'Estimasi Work Order Body Repair',
      'estimasi_bp' => $this->estimasi_bpModel->orderBy('noestimasi')->findAll() //$wo
    ];
    echo view('estimasi_bp/index', $data);
  }

  public function ajaxLoadData()
  {
    $request = $this->request;
    $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
    $katakunci = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
    $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
    $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
    $data = $this->estimasi_bpModel->tampilData($request, $katakunci, $start, $length);
    $jumlahData = $this->estimasi_bpModel->tampilData($request, $katakunci);
    $output = array(
      "draw" => intval($param['draw']),
      "recordsTotal" => count($jumlahData),
      "recordsFiltered" => count($jumlahData),
      "data" => $data,
    );
    // var_dump($data);
    echo json_encode($output);
  }

  public function table_mobil()
  {
    $model = new tbmobilmodel();
    $data['title'] = 'Estimas Work Order Body Repair';
    $data['tbmobil'] = $model->getnopolisi();
    // dd($data);
    echo view('estimasi_bp/tabel_mobil', $data);
  }

  public function detail_mobil()
  {
    $model = new tbmobilmodel();
    $data['title'] = 'Detail Kendaraan';
    $data['tbmobil'] = $model->getnopolisi();
    // dd($data);
    echo view('tbmobil/modaldetail', $data);
  }

  public function formdetail()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->tbmobilModel->find($id);
      $data = [
        'title' => 'Detail Data Kendaraan',
        'id' => $row['id'],
        'tbmobil' => $row,
        'tbmerek' => $this->tbmerekModel->getNama(),
        'tbmodel' => $this->tbmodelModel->getMerek(),
        'tbtipe' => $this->tbtipeModel->getModel(),
        'tbwarna' => $this->tbwarnaModel->getNama(),
        'tbjenis' => $this->tbjenisModel->getNama(),
      ];
      $msg = [
        'sukses' => view('tbmobil/modaldetail', $data)
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function modalestimasi_bp()
  {
    $id = $this->request->getVar('id');
    $row = $this->tbmobilModel->find($id);
    $nopolisi = $row['nopolisi'];
    $kdpemilik = $row['kdpemilik'];
    $data = [
      'title' => 'Estimasi WO Body Repair',
      'wo' => $this->wo_bpModel->getnopolisi($nopolisi),
      'tbmobil' => $this->tbmobilModel->getnopolisi($nopolisi),
      'tbmerek' => $this->tbmerekModel->getNama(),
      'tbmodel' => $this->tbmodelModel->getMerek(),
      'tbtipe' => $this->tbtipeModel->getModel(),
      'tbwarna' => $this->tbwarnaModel->getNama(),
      'tbjenis' => $this->tbjenisModel->getNama(),
      'tbcustomer' => $this->tbcustomerModel->getkdcustomer($kdpemilik),
    ];
    // var_dump($data);
    $msg = [
      'sukses' => view('estimasi_bp/modalestimasi_bp', $data)
    ];
    echo json_encode($msg);
  }

  public function tambahestimasi_bp()
  {
    $nopolisi = $_POST['nopolisi'];
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Tambah Data Estimasi WO Body Repair',
        'tbmobil' => $this->tbmobilModel->getnopolisi($nopolisi),
        'tbpaket' => $this->tbpaketModel->where('aktif', 'Y')->orderBy('kode', 'asc')->findAll()
      ];
      // var_dump($data);
      $msg = [
        'data' => view('estimasi_bp/tambahestimasi_bp', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function detailestimasi_bp()
  {
    $id = $this->request->getVar('id');
    $row = $this->estimasi_bpModel->find($id);
    $nopolisi = $row['nopolisi'];
    $kdpemilik = $row['kdpemilik'];
    $kdsa = $row['kdsa'];
    $data = [
      'title' => 'Detail Estimasi',
      'estimasi_bp' => $this->estimasi_bpModel->find($id),
      'tbmobil' => $this->tbmobilModel->getnopolisi($nopolisi),
      'tbmerek' => $this->tbmerekModel->getNama(),
      'tbmodel' => $this->tbmodelModel->getMerek(),
      'tbtipe' => $this->tbtipeModel->getModel(),
      'tbwarna' => $this->tbwarnaModel->getNama(),
      'tbjenis' => $this->tbjenisModel->getNama(),
      'tbsa' => $this->tbsaModel->getkode($kdsa),
      'tbcustomer' => $this->tbcustomerModel->getkdcustomer($kdpemilik),
    ];
    // var_dump($data);
    $msg = [
      'sukses' => view('estimasi_bp/detailestimasi_bp', $data)
    ];
    echo json_encode($msg);
  }

  public function detail_wo_bp()
  {
    $id = $this->request->getVar('id');
    $row = $this->wo_bpModel->find($id);
    $nopolisi = $row['nopolisi'];
    $kdpemilik = $row['kdpemilik'];
    $kdsa = $row['kdsa'];
    $data = [
      'title' => 'Detail WO',
      'wo_bp' => $this->wo_bpModel->find($id),
      'tbmobil' => $this->tbmobilModel->getnopolisi($nopolisi),
      'tbmerek' => $this->tbmerekModel->getNama(),
      'tbmodel' => $this->tbmodelModel->getMerek(),
      'tbtipe' => $this->tbtipeModel->getModel(),
      'tbwarna' => $this->tbwarnaModel->getNama(),
      'tbjenis' => $this->tbjenisModel->getNama(),
      'tbsa' => $this->tbsaModel->getkode($kdsa),
      'tbcustomer' => $this->tbcustomerModel->getkdcustomer($kdpemilik),
    ];
    // var_dump($data);
    $msg = [
      'sukses' => view('estimasi_bp/detail_wo_bp', $data)
    ];
    echo json_encode($msg);
  }

  public function inputestimasi_bpd()
  {
    $id = $this->request->getVar('id');
    $row = $this->estimasi_bpModel->find($id);
    $nopolisi = $row['nopolisi'];
    $kdpemilik = $row['kdpemilik'];
    $data = [
      'title' => 'Update Detail Estimasi Body Repair',
      'estimasi_bp' => $this->estimasi_bpModel->find($id),
      'tbmobil' => $this->tbmobilModel->getnopolisi($nopolisi),
      'tbmerek' => $this->tbmerekModel->getNama(),
      'tbmodel' => $this->tbmodelModel->getMerek(),
      'tbtipe' => $this->tbtipeModel->getModel(),
      'tbwarna' => $this->tbwarnaModel->getNama(),
      'tbjenis' => $this->tbjenisModel->getNama(),
      'tbcustomer' => $this->tbcustomerModel->getkdcustomer($kdpemilik),
    ];
    // var_dump($data);
    $msg = [
      'sukses' => view('estimasi_bp/inputestimasi_bpd', $data)
    ];
    echo json_encode($msg);
  }

  public function editestimasi_bp()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->estimasi_bpModel->find($id);
      $nopolisi = $row['nopolisi'];
      $kdpemilik = $row['kdpemilik'];
      $kdpaket = $row['kdpaket'];
      $kdsa = $row['kdsa'];
      if (!isset($kdsa)) {
        $kdsa = "";
      }
      $data = [
        'title' => 'Edit Data Estimasi Body Repair',
        // 'id' => $row['id'],
        // 'nopolisi' => $row['nopolisi'],
        // 'nama' => $row['nama'],
        // 'aktif' => $row['aktif'],
        'estimasi_bp' => $this->estimasi_bpModel->find($id),
        'tbmobil' => $this->tbmobilModel->getnopolisi($nopolisi),
        'tbmerek' => $this->tbmerekModel->getNama(),
        'tbmodel' => $this->tbmodelModel->getMerek(),
        'tbtipe' => $this->tbtipeModel->getModel(),
        'tbwarna' => $this->tbwarnaModel->getNama(),
        'tbjenis' => $this->tbjenisModel->getNama(),
        'tbcustomer' => $this->tbcustomerModel->getkdcustomer($kdpemilik),
        'tbsa' => ($kdsa ? $this->tbsaModel->getkode($kdsa) : ''),
        'tbpaket' => $this->tbpaketModel->where('aktif', 'Y')->orderBy('kode', 'asc')->findAll()
      ];
      // var_dump($data);
      $msg = [
        'sukses' => view('estimasi_bp/editestimasi_bp', $data)
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function edit_wo_bp()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->wo_bpModel->find($id);
      $nopolisi = $row['nopolisi'];
      $kdpemilik = $row['kdpemilik'];
      $kdpaket = $row['kdpaket'];
      $kdsa = $row['kdsa'];
      if (!isset($kdsa)) {
        $kdsa = "";
      }
      $data = [
        'title' => 'Edit Data WO Body Repair',
        // 'id' => $row['id'],
        // 'nopolisi' => $row['nopolisi'],
        // 'nama' => $row['nama'],
        // 'aktif' => $row['aktif'],
        'wo_bp' => $this->wo_bpModel->find($id),
        'tbmobil' => $this->tbmobilModel->getnopolisi($nopolisi),
        'tbmerek' => $this->tbmerekModel->getNama(),
        'tbmodel' => $this->tbmodelModel->getMerek(),
        'tbtipe' => $this->tbtipeModel->getModel(),
        'tbwarna' => $this->tbwarnaModel->getNama(),
        'tbjenis' => $this->tbjenisModel->getNama(),
        'tbcustomer' => $this->tbcustomerModel->getkdcustomer($kdpemilik),
        'tbsa' => ($kdsa ? $this->tbsaModel->getkode($kdsa) : ''),
        'tbpaket' => $this->tbpaketModel->where('aktif', 'Y')->orderBy('kode', 'asc')->findAll()
      ];
      // var_dump($data);
      $msg = [
        'sukses' => view('estimasi_bp/edit_wo_bp', $data)
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function updateestimasi_bp()
  {
    if ($this->request->isAjax()) {
      $validation = \Config\Services::validation();
      $nowolama = $this->request->getVar('nowolama');
      $noestimasi = $this->request->getVar('noestimasi');
      $nowo = $this->request->getVar('nowo');
      if ($nowo != $nowolama) {
        $valid = $this->validate([
          'noestimasi' => [
            'label' => 'noestimasi',
            'rules' => 'required|is_unique[estimasi.noestimasi]',
            'errors' => [
              'required' => '{field} tidak boleh kosong',
              'is_unique' => '{field} tidak boleh ada yang sama'
            ]
          ],
          'nopolisi' => [
            'label' => 'nopolisi',
            'rules' => 'required',
            'errors' => [
              'required' => '{field} tidak boleh kosong',
              'is_unique' => '{field} tidak boleh ada yang sama'
            ]
          ]
        ]);
      } else {
        $valid = $this->validate([
          'noestimasi' => [
            'label' => 'noestimasi',
            'rules' => 'required',
            'errors' => [
              'required' => '{field} tidak boleh kosong'
            ]
          ]
        ]);
      }
      if (!$valid) {
        $msg = [
          'error' => [
            'noestimasi' => $validation->getError('noestimasi'),
            'nopolisi' => $validation->getError('nopolisi')
          ]
        ];
        echo json_encode($msg);
      } else {
        date_default_timezone_set('Asia/Jakarta');
        $session = session();
        $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        // if ($this->request->getVar('internal') === null) {
        //   $internal = 0;
        // } else {
        //   $internal = 1;
        // }
        $simpandata = [
          'noestimasi' => $this->request->getVar('noestimasi'),
          'tanggal' => $this->request->getVar('tanggal'),
          'nopolisi' => $this->request->getVar('nopolisi'),
          'norangka' => $this->request->getVar('norangka'),
          'kdpemilik' => $this->request->getVar('kdpemilik'),
          'nmpemilik' => $this->request->getVar('nmpemilik'),
          'kdsa' => $this->request->getVar('kdsa'),
          'keluhan' => $this->request->getVar('keluhan'),
          'kdservice' => $this->request->getVar('kdservice'),
          // 'nmservice' => $this->request->getVar('nmservice'),
          'km' => $this->request->getVar('km'),
          // 'kdpaket' => $this->request->getVar('kdpaket'),
          'aktifitas' => $this->request->getVar('aktifitas'),
          'fasilitas' => $this->request->getVar('fasilitas'),
          'status_tunggu' => $this->request->getVar('status_tunggu'),
          'int_reminder' => $this->request->getVar('int_reminder'),
          'via' => $this->request->getVar('via'),
          'pr_ppn' => $this->request->getVar('pr_ppn'),
          'no_polis' => $this->request->getVar('no_polis'),
          'nama_polis' => $this->request->getVar('nama_polis'),
          'tgl_akhir_polis' => $this->request->getVar('tgl_akhir_polis'),
          'kode_asuransi' => $this->request->getVar('kode_asuransi'),
          'nama_asuransi' => $this->request->getVar('nama_asuransi'),
          'alamat_asuransi' => $this->request->getVar('alamat_asuransi'),
          'klaim' => ($this->request->getVar('klaim') === null ? 0 : 1),
          'internal' => ($this->request->getVar('internal') === null ? 0 : 1),
          'inventaris' => ($this->request->getVar('inventaris') === null ? 0 : 1),
          'campaign' => ($this->request->getVar('campaign') === null ? 0 : 1),
          'booking' => ($this->request->getVar('booking') === null ? 0 : 1),
          'lain_lain' => ($this->request->getVar('lain_lain') === null ? 0 : 1),
          'surveyor' => $this->request->getVar('surveyor'),
          'npwp' => $this->request->getVar('npwp'),
          'contact_person' => $this->request->getVar('contact_person'),
          'no_contact_person' => $this->request->getVar('no_contact_person'),
          'user' => $user,
        ];
        // var_dump($simpandata);
        $id = $this->request->getVar('id');
        $this->estimasi_bpModel->update($id, $simpandata);
        $msg = [
          'sukses' => 'Data berhasil disimpan'
        ];
        session()->setFlashdata('pesan', 'Data berhasil diupdate');
        echo json_encode($msg);
      }
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function update_wo_bp()
  {
    if ($this->request->isAjax()) {
      $validation = \Config\Services::validation();
      $nowolama = $this->request->getVar('nowolama');
      $noestimasi = $this->request->getVar('noestimasi');
      $nowo = $this->request->getVar('nowo');
      if ($nowo != $nowolama) {
        $valid = $this->validate([
          'nowo' => [
            'label' => 'nowo',
            'rules' => 'required|is_unique[wo.nowo]',
            'errors' => [
              'required' => '{field} tidak boleh kosong',
              'is_unique' => '{field} tidak boleh ada yang sama'
            ]
          ],
          'nopolisi' => [
            'label' => 'nopolisi',
            'rules' => 'required',
            'errors' => [
              'required' => '{field} tidak boleh kosong',
              'is_unique' => '{field} tidak boleh ada yang sama'
            ]
          ]
        ]);
      } else {
        $valid = $this->validate([
          'nowo' => [
            'label' => 'nowo',
            'rules' => 'required',
            'errors' => [
              'required' => '{field} tidak boleh kosong'
            ]
          ]
        ]);
      }
      if (!$valid) {
        $msg = [
          'error' => [
            'nowo' => $validation->getError('nowo'),
            'nopolisi' => $validation->getError('nopolisi')
          ]
        ];
        echo json_encode($msg);
      } else {
        date_default_timezone_set('Asia/Jakarta');
        $session = session();
        $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        // if ($this->request->getVar('internal') === null) {
        //   $internal = 0;
        // } else {
        //   $internal = 1;
        // }
        $simpandata = [
          'nowo' => $this->request->getVar('nowo'),
          'tanggal' => $this->request->getVar('tanggal'),
          'nopolisi' => $this->request->getVar('nopolisi'),
          'norangka' => $this->request->getVar('norangka'),
          'kdpemilik' => $this->request->getVar('kdpemilik'),
          'nmpemilik' => $this->request->getVar('nmpemilik'),
          'kdsa' => $this->request->getVar('kdsa'),
          'keluhan' => $this->request->getVar('keluhan'),
          'kdservice' => $this->request->getVar('kdservice'),
          // 'nmservice' => $this->request->getVar('nmservice'),
          'km' => $this->request->getVar('km'),
          // 'kdpaket' => $this->request->getVar('kdpaket'),
          'aktifitas' => $this->request->getVar('aktifitas'),
          'fasilitas' => $this->request->getVar('fasilitas'),
          'status_tunggu' => $this->request->getVar('status_tunggu'),
          'int_reminder' => $this->request->getVar('int_reminder'),
          'via' => $this->request->getVar('via'),
          'pr_ppn' => $this->request->getVar('pr_ppn'),
          'kode_asuransi' => $this->request->getVar('kode_asuransi'),
          'nama_asuransi' => $this->request->getVar('nama_asuransi'),
          'alamat_asuransi' => $this->request->getVar('alamat_asuransi'),
          'no_polis' => $this->request->getVar('no_polis'),
          'nama_polis' => $this->request->getVar('nama_polis'),
          'tgl_akhir_polis' => $this->request->getVar('tgl_akhir_polis'),
          'kode_asuransi' => $this->request->getVar('kode_asuransi'),
          'nama_asuransi' => $this->request->getVar('nama_asuransi'),
          'alamat_asuransi' => $this->request->getVar('alamat_asuransi'),
          'klaim' => ($this->request->getVar('klaim') === null ? 0 : 1),
          'internal' => ($this->request->getVar('internal') === null ? 0 : 1),
          'inventaris' => ($this->request->getVar('inventaris') === null ? 0 : 1),
          'campaign' => ($this->request->getVar('campaign') === null ? 0 : 1),
          'booking' => ($this->request->getVar('booking') === null ? 0 : 1),
          'lain_lain' => ($this->request->getVar('lain_lain') === null ? 0 : 1),
          'surveyor' => $this->request->getVar('surveyor'),
          'npwp' => $this->request->getVar('npwp'),
          'contact_person' => $this->request->getVar('contact_person'),
          'no_contact_person' => $this->request->getVar('no_contact_person'),
          'user' => $user,
        ];
        // var_dump($simpandata);
        $id = $this->request->getVar('id');
        $this->wo_bpModel->update($id, $simpandata);
        $msg = [
          'sukses' => 'Data berhasil disimpan'
        ];
        session()->setFlashdata('pesan', 'Data berhasil diupdate');
        echo json_encode($msg);
      }
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function input_wo_bpd()
  {
    $id = $this->request->getVar('id');
    $row = $this->wo_bpModel->find($id);
    $nopolisi = $row['nopolisi'];
    $kdpemilik = $row['kdpemilik'];
    $data = [
      'title' => 'Update Detail WO Body Repair',
      'wo_bp' => $this->wo_bpModel->find($id),
      'tbmobil' => $this->tbmobilModel->getnopolisi($nopolisi),
      'tbmerek' => $this->tbmerekModel->getNama(),
      'tbmodel' => $this->tbmodelModel->getMerek(),
      'tbtipe' => $this->tbtipeModel->getModel(),
      'tbwarna' => $this->tbwarnaModel->getNama(),
      'tbjenis' => $this->tbjenisModel->getNama(),
      'tbcustomer' => $this->tbcustomerModel->getkdcustomer($kdpemilik),
    ];
    // var_dump($data);
    $msg = [
      'sukses' => view('estimasi_bp/input_wo_bpd', $data)
    ];
    echo json_encode($msg);
  }

  public function hapusestimasi_bp($id)
  {
    $rowestimasi = $this->estimasi_bpModel->find($id);
    $noestimasi = $rowestimasi['noestimasi'];
    $rowjasa = $this->estimasijasa_bpModel->getnoestimasi($noestimasi);
    $rowpart = $this->estimasipart_bpModel->getnoestimasi($noestimasi);
    $rowbahan = $this->estimasibahan_bpModel->getnoestimasi($noestimasi);
    $rowopl = $this->estimasiopl_bpModel->getnoestimasi($noestimasi);
    if ($rowjasa or $rowpart or $rowbahan or $rowopl) {
      session()->setFlashdata('pesan', 'Data gagal dihapus, sudah terdapat detail transaksi');
      echo json_encode(array("status" => FALSE));
    } else {
      $this->estimasi_bpModel->delete_by_id($id);
      session()->setFlashdata('pesan', 'Data berhasil dihapus');
      echo json_encode(array("status" => TRUE));
    }
  }

  public function hapus_wo_bp($id)
  {
    $row_wo = $this->wo_bpModel->find($id);
    $nowo = $row_wo['noestimasi'];
    $rowjasa = $this->wojasa_bpModel->getnowo($nowo);
    $rowpart = $this->wopart_bpModel->getnowo($nowo);
    $rowbahan = $this->wobahan_bpModel->getnowo($nowo);
    $rowopl = $this->woopl_bpModel->getnowo($nowo);
    if ($rowjasa or $rowpart or $rowbahan or $rowopl) {
      session()->setFlashdata('pesan', 'Data gagal dihapus, sudah terdapat detail transaksi');
      echo json_encode(array("status" => FALSE));
    } else {
      $this->wo_bpModel->delete_by_id($id);
      session()->setFlashdata('pesan', 'Data berhasil dihapus');
      echo json_encode(array("status" => TRUE));
    }
  }

  public function cancel_estimasi_bp($id)
  {
    $session = session();
    $user = $session->get('nama');
    $tgl_batal = date('Y-m-d H:i:s');
    $simpandata = [
      'batal' => "1",
      'tgl_batal' => $tgl_batal,
      'user_batal' => $user,
    ];
    $this->estimasi_bpModel->update($id, $simpandata);
    session()->setFlashdata('pesan', 'Data berhasil di Cancel');
    echo json_encode(array("status" => TRUE));
  }

  public function cancel_wo_bp($id)
  {
    $session = session();
    $user = $session->get('nama');
    $tgl_batal = date('Y-m-d H:i:s');
    $simpandata = [
      'batal' => "1",
      'tgl_batal' => $tgl_batal,
      'user_batal' => $user,
    ];
    $this->wo_bpModel->update($id, $simpandata);
    session()->setFlashdata('pesan', 'Data berhasil di Cancel');
    echo json_encode(array("status" => TRUE));
  }

  public function cetakestimasi_bp($id)
  {
    $dompdf = new Dompdf();
    // if ($this->request->isAjax()) {
    // $rowestimasi = $this->estimasi_bpModel->find($id);
    // $id = $this->request->getVar('id');
    $row = $this->estimasi_bpModel->find($id);
    $noestimasi = $row['noestimasi'];
    $nopolisi = $row['nopolisi'];
    $kdpemilik = $row['kdpemilik'];
    $kdsa = $row['kdsa'];
    if (!isset($kdsa)) {
      $kdsa = "";
    }
    $rowmobil = $this->tbmobilModel->getnopolisi($nopolisi);
    $kdmerek = $rowmobil['kdmerek'];
    $kdmodel = $rowmobil['kdmodel'];
    $kdtipe = $rowmobil['kdtipe'];
    $kdwarna = $rowmobil['kdwarna'];
    $kdjenis = $rowmobil['kdjenis'];


    $data = [
      'title' => 'Edit Data Estimasi',
      'estimasi_bp' => $this->estimasi_bpModel->find($id),
      'tbmobil' => $this->tbmobilModel->getnopolisi($nopolisi),
      'tbmerek' => $this->tbmerekModel->getkode($kdmerek),
      'tbmodel' => $this->tbmodelModel->getkode($kdmodel),
      'tbtipe' => $this->tbtipeModel->getkode($kdtipe),
      'tbwarna' => $this->tbwarnaModel->getkode($kdwarna),
      'tbjenis' => $this->tbjenisModel->getkode($kdjenis),
      'tbcustomer' => $this->tbcustomerModel->getkdcustomer($kdpemilik),
      'tbsa' => ($kdsa ? $this->tbsaModel->getkode($kdsa) : ''),
      'jasa' => $this->estimasijasa_bpModel->getnoestimasi($noestimasi),
      'part' => $this->estimasipart_bpModel->getnoestimasi($noestimasi),
      'bahan' => $this->estimasibahan_bpModel->getnoestimasi($noestimasi),
      'opl' => $this->estimasiopl_bpModel->getnoestimasi($noestimasi),
    ];
    // var_dump($data);
    // $msg = [
    //   'sukses' => view('estimasi_bp/cetakestimasi_bp', $data)
    // ];
    $html =  view('estimasi_bp/cetakestimasi_bp', $data);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'Potrait');
    $dompdf->render();
    // $dompdf->stream(); //langsung download
    $dompdf->stream('Estimasi ' . $noestimasi . '.pdf', array("Attachment" => false));
    // var_dump($msg);
    // echo json_encode($msg);
    // } else {
    //   exit('Maaf tidak dapat diproses');
    // }
  }

  public function hapusdetailestimasi_bp($id)
  {
    $this->estimasijasa_bpModel->hapusdetailestimasi($id);
    session()->setFlashdata('pesan', 'Data berhasil dihapus');
    echo json_encode(array("status" => TRUE));
  }

  public function editdetailestimasi_bp($id)
  {
    $id = $_POST['id'];
    $row = $this->estimasijasa_bpModel->getid($id);
    if (isset($row)) {
      foreach ($row as $hasil) {
        $data = [
          'kodejasa' => $hasil['kode'],
          'namajasa' => $hasil['nama'],
          'kerusakan' => $hasil['kerusakan'],
          'qtyjasa' => $hasil['qty'],
          'hargajasa' => $hasil['harga'],
          'pr_discountjasa' => $hasil['pr_discount'],
          'subtotaljasa' => $hasil['subtotal'],
        ];
      }
    } else {
      $data = [
        'kodejasa' => '',
        'namajasa' => '',
        'kerusakan' => '',
        'qtyjasa' => '',
        'hargajasa' => '',
        'pr_discountjasa' => '',
        'rp_discountjasa' => '',
        'subtotaljasa' => '',
      ];
    }
    echo json_encode($data);
  }

  public function tampildetailpartwo($id)
  {
    $id = $_POST['id'];
    $row = $this->wopart_bpModel->getid($id);
    if (isset($row)) {
      foreach ($row as $hasil) {
        $data = [
          'kodepart' => $hasil['kode'],
          'namapart' => $hasil['nama'],
          'kerusakan' => $hasil['kerusakan'],
          'qtypart' => $hasil['qty'],
          'hargapart' => $hasil['harga'],
          'pr_discountpart' => $hasil['pr_discount'],
          'kdmekanik' => $hasil['kdmekanik'],
          'nmmekanik' => $hasil['nmmekanik'],
          'subtotalpart' => $hasil['subtotal'],
        ];
      }
    } else {
      $data = [
        'kodepart' => '',
        'namapart' => '',
        'kerusakan' => '',
        'qtypart' => '',
        'hargapart' => '',
        'pr_discountpart' => '',
        'rp_discountpart' => '',
        'subtotalpart' => '',
        'kdmekanik' => '',
        'nmmekanik' => '',
        'subtotalpart' => 0,
      ];
    }
    echo json_encode($data);
  }

  public function tampildetailbahanwo($id)
  {
    $id = $_POST['id'];
    $row = $this->wobahan_bpModel->getid($id);
    if (isset($row)) {
      foreach ($row as $hasil) {
        $data = [
          'kodebahan' => $hasil['kode'],
          'namabahan' => $hasil['nama'],
          'kerusakan' => $hasil['kerusakan'],
          'qtybahan' => $hasil['qty'],
          'hargabahan' => $hasil['harga'],
          'pr_discountbahan' => $hasil['pr_discount'],
          'kdmekanik' => $hasil['kdmekanik'],
          'nmmekanik' => $hasil['nmmekanik'],
          'subtotalbahan' => $hasil['subtotal'],
        ];
      }
    } else {
      $data = [
        'kodebahan' => '',
        'namabahan' => '',
        'kerusakan' => '',
        'qtybahan' => '',
        'hargabahan' => '',
        'pr_discountbahan' => '',
        'rp_discountbahan' => '',
        'subtotalbahan' => '',
        'kdmekanik' => '',
        'nmmekanik' => '',
        'subtotalbahan' => 0,
      ];
    }
    echo json_encode($data);
  }

  public function tampildetailoplwo($id)
  {
    $id = $_POST['id'];
    $row = $this->woopl_bpModel->getid($id);
    if (isset($row)) {
      foreach ($row as $hasil) {
        $data = [
          'kodeopl' => $hasil['kode'],
          'namaopl' => $hasil['nama'],
          'kerusakan' => $hasil['kerusakan'],
          'qtyopl' => $hasil['qty'],
          'hargaopl' => $hasil['harga'],
          'pr_discountopl' => $hasil['pr_discount'],
          'kdmekanik' => $hasil['kdmekanik'],
          'nmmekanik' => $hasil['nmmekanik'],
          'subtotalopl' => $hasil['subtotal'],
        ];
      }
    } else {
      $data = [
        'kodeopl' => '',
        'namaopl' => '',
        'kerusakan' => '',
        'qtyopl' => '',
        'hargaopl' => '',
        'pr_discountopl' => '',
        'rp_discountopl' => '',
        'subtotalopl' => '',
        'kdmekanik' => '',
        'nmmekanik' => '',
        'subtotalopl' => 0,
      ];
    }
    echo json_encode($data);
  }

  public function hapusdetailwo_bp($id)
  {
    $this->wojasa_bpModel->hapusdetailwo($id);
    session()->setFlashdata('pesan', 'Data berhasil dihapus');
    echo json_encode(array("status" => TRUE));
  }

  public function editdetailwo_bp($id)
  {
    $id = $_POST['id'];
    $row = $this->wojasa_bpModel->getid($id);
    if (isset($row)) {
      foreach ($row as $hasil) {
        $data = [
          'kodejasa' => $hasil['kode'],
          'namajasa' => $hasil['nama'],
          'kerusakan' => $hasil['kerusakan'],
          'qtyjasa' => $hasil['qty'],
          'hargajasa' => $hasil['harga'],
          'pr_discountjasa' => $hasil['pr_discount'],
          'subtotaljasa' => $hasil['subtotal'],
          'kdmekanik' => $hasil['kdmekanik'],
          'nmmekanik' => $hasil['nmmekanik'],
        ];
      }
    } else {
      $data = [
        'kodejasa' => '',
        'namajasa' => '',
        'kerusakan' => '',
        'qtyjasa' => '',
        'hargajasa' => '',
        'pr_discountjasa' => '',
        'rp_discountjasa' => '',
        'subtotaljasa' => '',
        'kdmekanik' => '',
        'nmmekanik' => '',
      ];
    }
    echo json_encode($data);
  }

  public function batal_wo()
  {
    $id = $_POST['id'];
    $data = [
      'title' => 'Batal Data',
      'wo_bp' => $this->wo_bpModel->find($id),
    ];
    // var_dump($data);
    $msg = [
      'sukses' => view('estimasi_bp/modalbatal_wo', $data)
    ];
    echo json_encode($msg);
  }

  public function table_estimasi_bp()
  {
    $nopolisi = $_POST['nopolisi'];
    $model = new estimasi_bpModel();
    $data['title'] = 'estimasi_bp';
    $data['estimasi_bp'] = $model->getnopolisi($nopolisi);
    echo view('estimasi_bp/tabel_estimasi_bp', $data);
  }

  public function table_wo_bp()
  {
    $nopolisi = $_POST['nopolisi'];
    $model = new wo_bpModel();
    $data['title'] = 'Work Order Body Repair';
    $data['wo_bp'] = $model->getnopolisi($nopolisi);
    echo view('estimasi_bp/tabel_wo_bp', $data);
  }

  // public function formdetailmobil()
  // {
  //   if ($this->request->isAjax()) {
  //     $this->tbagamaModel->findAll();
  //     $id = $this->request->getVar('id');
  //     $row = $this->wo_bpModel->find($id);
  //     $data = [
  //       'title' => 'Detail Data Kendaraan',
  //       // 'id' => $row['id'],
  //       // 'nowo' => $row['nowo'],
  //       // 'nama' => $row['nama'],
  //       // 'npwp' => $row['npwp'],
  //       'wo' => $this->wo_bpModel->find($id),
  //       'tbagama' => $this->tbagamaModel->orderBy('nowo')->findAll(),
  //     ];
  //     // var_dump($data);
  //     $msg = [
  //       'sukses' => view('wo/formdetailmobil', $data)
  //     ];
  //     echo json_encode($msg);
  //   } else {
  //     exit('Maaf tidak dapat diproses');
  //   }
  // }

  public function cari_nopolisi()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data Mobil',
        'tbmobil' => $this->tbmobilModel->orderBy('nopolisi')->findAll() //$rwtkeluarga
      ];
      $msg = [
        'data' => view('wo/modalcari_nopolisi', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function repl_nopolisi()
  {
    if ($this->request->isAjax()) {
      $nowo = $_POST['nopolisi'];
      $row = $this->tbmobilModel->getnopolisi($nowo);
      if (isset($row)) {
        $data = [
          'title' => 'Detail data Kendaraan',
          'nopolisi' => $row['nopolisi'],
          'norangka' => $row['norangka'],
          'nomesin' => $row['nomesin'],
          'kdtipe' => $row['kdtipe'],
          'kdpemilik' => $row['kdpemilik'],
          'nmpemilik' => $row['nmpemilik'],
          'npwp' => $row['npwp'],
          'contact_person' => $row['contact_person'],
          'no_contact_person' => $row['no_contact_person'],
          'id' => $row['id'],

        ];
      } else {
        $data = [
          'title' => 'Detail data',
          'nopolisi' => '',
          'norangka' => '',
          'nomeisn' => '',
          'kdtipe' => '',
          'kdpemilik' => '',
          'nmpemilik' => '',
          'npwp' => '',
          'contact_person' => '',
          'no_contact_person' => '',
          'id' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function updatemobil()
  {
    if ($this->request->isAjax()) {
      $validation = \Config\Services::validation();
      $nopolisi = $this->request->getVar('nopolisi');
      $valid = $this->validate([
        'nopolisi' => [
          'label' => 'nopolisi',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong'
          ]
        ]
      ]);
      if (!$valid) {
        $msg = [
          'error' => [
            'nopolisi' => $validation->getError('nopolisi'),
            // 'nama' => $validation->getError('nama')
          ]
        ];
        echo json_encode($msg);
      } else {

        date_default_timezone_set('Asia/Jakarta');
        $session = session();
        $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        $simpandata = [
          'kdpemilik' => $this->request->getVar('kdpemilik'),
          'nmpemilik' => $this->request->getVar('nmpemilik'),
          'user' => $user,
        ];
        $id = $this->request->getVar('id');
        // var_dump($simpandata);
        $this->tbmobilModel->update($id, $simpandata);
        $msg = [
          'sukses' => 'Data berhasil diupdate'
        ];
        session()->setFlashdata('pesan', 'Data berhasil diupdate');
        echo json_encode($msg);
      }
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function table_mobil_customer()
  {
    // $id = '20221100001'; // $id; //$this->request->getPost('kdpemilik'); // '20221100001'; //9; //$this->request->getPost('kdpemilik');
    $id = $_POST['id'];
    // $id = $this->request->getVar('kdpemilik');
    $data = [
      'title' => 'Detail Kendaraan',
      'wo' => $this->wo_bpModel->getkdcustomer($id),
    ];
    // var_dump($data);
    echo view('wo/tabel_mobil_customer', $data);
  }

  public function formmobil()
  {
    $id = $this->request->getVar('id');
    $row = $this->tbmobilModel->find($id);
    $nopolisi = $row['nopolisi'];
    $kdpemilik = $row['kdpemilik'];
    $data = [
      'title' => 'Detail Estimasi',
      'wo' => $this->wo_bpModel->getnopolisi($nopolisi),
      'tbmobil' => $this->tbmobilModel->getnopolisi($nopolisi),
      'tbmerek' => $this->tbmerekModel->getNama(),
      'tbmodel' => $this->tbmodelModel->getMerek(),
      'tbtipe' => $this->tbtipeModel->getModel(),
      'tbwarna' => $this->tbwarnaModel->getNama(),
      'tbjenis' => $this->tbjenisModel->getNama(),
      'tbcustomer' => $this->tbcustomerModel->getkdcustomer($kdpemilik),
    ];
    // var_dump($data);
    $msg = [
      'sukses' => view('wo/modalmobil', $data)
    ];
    echo json_encode($msg);
  }

  public function simpanestimasi_bp()
  {
    if ($this->request->isAjax()) {
      $validation = \Config\Services::validation();
      $valid = $this->validate([
        'kdpemilik' => [
          'label' => 'kdpemilik',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'is_unique' => '{field} tidak boleh ada yang sama'
          ]
        ],
        'nopolisi' => [
          'label' => 'nopolisi',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong'
          ]
        ],
      ]);
      if (!$valid) {
        $msg = [
          'error' => [
            'kdpemilik' => $validation->getError('kdpemilik'),
            'nopolisi' => $validation->getError('nopolisi'),
          ]
        ];
        echo json_encode($msg);
      } else {
        date_default_timezone_set('Asia/Jakarta');
        $noestimasi = 'EB' . date('Y') . date('m') . sprintf("%05s", intval(substr('00000', -5)) + 1);
        $estimasi = $this->estimasi_bpModel->buatnoestimasi();
        if (isset($estimasi)) {
          foreach ($estimasi as $row) {
            if ($row->noestimasi != NULL) {
              $noestimasi = 'EB' . date('Y') . date('m') . sprintf("%05s", intval(substr($row->noestimasi, -5)) + 1);
            }
          }
        }
        $session = session();
        $user = "Tambah-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        $simpandata = [
          'noestimasi' => $noestimasi, //$this->request->getVar('noestimasi'),
          'tanggal' => $this->request->getVar('tanggal'),
          'nopolisi' => $this->request->getVar('nopolisi'),
          'norangka' => $this->request->getVar('norangka'),
          'kdpemilik' => $this->request->getVar('kdpemilik'),
          'nmpemilik' => $this->request->getVar('nmpemilik'),
          'kdsa' => $this->request->getVar('kdsa'),
          'keluhan' => $this->request->getVar('keluhan'),
          'kdservice' => $this->request->getVar('kdservice'),
          // 'nmservice' => $this->request->getVar('nmservice'),
          'km' => $this->request->getVar('km'),
          // 'kdpaket' => $this->request->getVar('kdpaket'),
          'aktifitas' => $this->request->getVar('aktifitas'),
          'fasilitas' => $this->request->getVar('fasilitas'),
          'status_tunggu' => $this->request->getVar('status_tunggu'),
          'int_reminder' => $this->request->getVar('int_reminder'),
          'via' => $this->request->getVar('via'),
          'pr_ppn' => $this->request->getVar('pr_ppn'),
          'no_polis' => $this->request->getVar('no_polis'),
          'nama_polis' => $this->request->getVar('nama_polis'),
          'tgl_akhir_polis' => $this->request->getVar('tgl_akhir_polis'),
          'kode_asuransi' => $this->request->getVar('kode_asuransi'),
          'nama_asuransi' => $this->request->getVar('nama_asuransi'),
          'alamat_asuransi' => $this->request->getVar('alamat_asuransi'),
          'klaim' => ($this->request->getVar('klaim') === null ? 0 : 1),
          'internal' => ($this->request->getVar('internal') === null ? 0 : 1),
          'inventaris' => ($this->request->getVar('inventaris') === null ? 0 : 1),
          'campaign' => ($this->request->getVar('campaign') === null ? 0 : 1),
          'booking' => ($this->request->getVar('booking') === null ? 0 : 1),
          'lain_lain' => ($this->request->getVar('lain_lain') === null ? 0 : 1),
          'surveyor' => $this->request->getVar('surveyor'),
          'npwp' => $this->request->getVar('npwp'),
          'contact_person' => $this->request->getVar('contact_person'),
          'no_contact_person' => $this->request->getVar('no_contact_person'),
          'user' => $user,
        ];
        // var_dump($simpandata);
        $this->estimasi_bpModel->insert($simpandata);
        $msg = [
          'sukses' => 'Data berhasil ditambah'
        ];
        session()->setFlashdata('pesan', 'Data berhasil ditambah');
        echo json_encode($msg);
      }
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function simpan_batal_wo()
  {
    if ($this->request->isAjax()) {
      $validation = \Config\Services::validation();
      $valid = $this->validate([
        'ket_batal' => [
          'label' => 'ket_batal',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'is_unique' => '{field} tidak boleh ada yang sama'
          ]
        ],
      ]);
      if (!$valid) {
        $msg = [
          'error' => [
            'ket_batal' => $validation->getError('ket_batal'),
          ]
        ];
        echo json_encode($msg);
      } else {
        date_default_timezone_set('Asia/Jakarta');
        $session = session();
        $user = $session->get('nama');
        $tgl_batal = date('Y-m-d H:i:s');
        $simpandata = [
          'ket_batal' => $this->request->getVar('ket_batal'),
          'batal' => '1',
          'tgl_batal' => $tgl_batal,
          'user_batal' => $user,
        ];
        // var_dump($simpandata);
        $id = $this->request->getVar('id');
        $this->wo_bpModel->update($id, $simpandata);
        $msg = [
          'sukses' => 'Data berhasil disimpan'
        ];
        session()->setFlashdata('pesan', 'Data berhasil disimpan');
        echo json_encode($msg);
      }
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function simpan_batal_estimasi()
  {
    if ($this->request->isAjax()) {
      $validation = \Config\Services::validation();
      $valid = $this->validate([
        'ket_batal' => [
          'label' => 'ket_batal',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'is_unique' => '{field} tidak boleh ada yang sama'
          ]
        ],
      ]);
      if (!$valid) {
        $msg = [
          'error' => [
            'ket_batal' => $validation->getError('ket_batal'),
          ]
        ];
        echo json_encode($msg);
      } else {
        date_default_timezone_set('Asia/Jakarta');
        $session = session();
        $user = $session->get('nama');
        $tgl_batal = date('Y-m-d H:i:s');
        $simpandata = [
          'ket_batal' => $this->request->getVar('ket_batal'),
          'batal' => '1',
          'tgl_batal' => $tgl_batal,
          'user_batal' => $user,
        ];
        // var_dump($simpandata);
        $id = $this->request->getVar('id');
        $this->estimasi_bpModel->update($id, $simpandata);
        $msg = [
          'sukses' => 'Data berhasil disimpan'
        ];
        session()->setFlashdata('pesan', 'Data berhasil disimpan');
        echo json_encode($msg);
      }
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function caridatapart()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data Part',
        'tbbarang' => $this->tbbarangModel->where('aktif', 'Y')->orderBy('kode', 'asc')->findAll() //$rwtkeluarga
      ];
      $msg = [
        'data' => view('estimasi_bp/modalcaripart', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function caridatabahan()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data Bahan',
        'tbbahan' => $this->tbbahanModel->where('aktif', 'Y')->orderBy('kode', 'asc')->findAll() //$rwtkeluarga
      ];
      $msg = [
        'data' => view('estimasi_bp/modalcaribahan', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function caridataopl()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data OPL',
        'tbopl' => $this->tboplModel->where('aktif', 'Y')->orderBy('kode', 'asc')->findAll() //$rwtkeluarga
      ];
      // var_dump($data);
      $msg = [
        'data' => view('estimasi_bp/modalcariopl', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function caridatajasa()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data jasa',
        'tbjasa' => $this->tbjasaModel->where('aktif', 'Y')->where('parent', 'N')->orderBy('kode', 'asc')->findAll() //$rwtkeluarga
      ];
      // var_dump($data);
      $msg = [
        'data' => view('estimasi_bp/modalcarijasa', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function caridatatasklist()
  {
    if ($this->request->isAjax()) {
      $kdasuransi = $_POST['kdasuransi'];
      $data = [
        'title' => 'Cari Data Task List',
        'tasklist_bpd' => $this->tasklist_bpdModel->where('kdasuransi', $kdasuransi)->orderBy('kode', 'asc')->findAll() //$rwtkeluarga
      ];
      // var_dump($data);
      $msg = [
        'data' => view('estimasi_bp/modalcaritasklist', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function simpanpart()
  {
    if ($this->request->isAjax()) {
      $validation = \Config\Services::validation();
      $valid = $this->validate([
        'kodepart' => [
          'label' => 'kodepart',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
          ]
        ],
        'qtypart' => [
          'label' => 'qtypart',
          // 'rules' => 'required|numeric|greater_than[0]',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'greater_than' => '{field} tidak boleh 0',
          ]
        ],
      ]);
      if (!$valid) {
        $msg = [
          'error' => [
            'kodepart' => $validation->getError('kodepart'),
            'qtypart' => $validation->getError('qtypart'),
          ]
        ];
        echo json_encode($msg);
      } else {
        $session = session();
        $noestimasi = $this->request->getVar('noestimasi');
        $kode = $this->request->getVar('kodepart');
        $data = $this->estimasipart_bpModel->getdoublebarang($noestimasi, $kode);
        if ($data) {
          foreach ($data as $row) {
            $id = $row['id'];
          }
          $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
          $simpandata = [
            'noestimasi' => $this->request->getVar('noestimasi'),
            'kode' => $this->request->getVar('kodepart'),
            'nama' => $this->request->getVar('namapart'),
            'jenis' => 'PART',
            'qty' => $this->request->getVar('qtypart'),
            'harga' => str_replace(",", "", $this->request->getVar('hargapart')),
            'pr_discount' => $this->request->getVar('pr_discountpart'),
            'subtotal' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('subtotalpart')),
            // 'harga' => $this->request->getVar('hargapart'),
            // 'pr_discount' => $this->request->getVar('pr_discountpart'),
            // 'subtotal' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('subtotalpart')),
            'user' => $user,
          ];
          if ($this->request->getVar('qtypart') > 0) {
            $this->estimasipart_bpModel->update($id, $simpandata);
            $msg = [
              'sukses' => 'Data berhasil diupdate'
            ];
            // session()->setFlashdata('pesan', 'Data berhasil ditambah');
            echo json_encode($msg);
          } else {
            $msg = [
              'sukses' => 'Data gagal ditambah'
            ];
            // session()->setFlashdata('pesan', 'Data gagal ditambah');
            echo json_encode($msg);
          }
        } else {
          $user = "Tambah-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
          $simpandata = [
            'noestimasi' => $this->request->getVar('noestimasi'),
            'kode' => $this->request->getVar('kodepart'),
            'nama' => $this->request->getVar('namapart'),
            'jenis' => 'PART',
            'qty' => $this->request->getVar('qtypart'),
            'harga' => str_replace(",", "", $this->request->getVar('hargapart')),
            'pr_discount' => $this->request->getVar('pr_discountpart'),
            'subtotal' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('subtotalpart')),
            // 'harga' => $this->request->getVar('hargapart'),
            // 'pr_discount' => $this->request->getVar('pr_discountpart'),
            // 'subtotal' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('subtotalpart')),
            'user' => $user,
          ];
          // var_dump($simpandata);
          if ($this->request->getVar('qtypart') > 0) {
            $this->estimasipart_bpModel->insert($simpandata);
            $msg = [
              'sukses' => 'Data berhasil ditambah'
            ];
            // session()->setFlashdata('pesan', 'Data berhasil ditambah');
            echo json_encode($msg);
          } else {
            $msg = [
              'sukses' => 'Data gagal ditambah'
            ];
            // session()->setFlashdata('pesan', 'Data gagal ditambah');
            echo json_encode($msg);
          }
        }
      }
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function simpan_part_wo()
  {
    if ($this->request->isAjax()) {
      $validation = \Config\Services::validation();
      $valid = $this->validate([
        'kodepart' => [
          'label' => 'kodepart',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
          ]
        ],
        'qtypart' => [
          'label' => 'qtypart',
          // 'rules' => 'required|numeric|greater_than[0]',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'greater_than' => '{field} tidak boleh 0',
          ]
        ],
      ]);
      if (!$valid) {
        $msg = [
          'error' => [
            'kodepart' => $validation->getError('kodepart'),
            'qtypart' => $validation->getError('qtypart'),
          ]
        ];
        echo json_encode($msg);
      } else {
        $session = session();
        $nowo = $this->request->getVar('nowo');
        $kode = $this->request->getVar('kodepart');
        $data = $this->wopart_bpModel->getdoublebarang($nowo, $kode);
        if ($data) {
          foreach ($data as $row) {
            $id = $row['id'];
          }
          $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
          $simpandata = [
            'nowo' => $this->request->getVar('nowo'),
            'kode' => $this->request->getVar('kodepart'),
            'nama' => $this->request->getVar('namapart'),
            'kdmekanik' => $this->request->getVar('kdmekanik'),
            'nmmekanik' => $this->request->getVar('nmmekanik'),
            'jenis' => 'PART',
            'qty' => str_replace(",", "", $this->request->getVar('qtypart')), //$this->request->getVar('qtypart'),
            'harga' => str_replace(",", "", $this->request->getVar('hargapart')),
            'pr_discount' => $this->request->getVar('pr_discountpart'),
            'subtotal' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('subtotalpart')),
            // 'harga' => $this->request->getVar('hargapart'),
            // 'pr_discount' => $this->request->getVar('pr_discountpart'),
            // 'subtotal' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('subtotalpart')),
            'user' => $user,
          ];
          if ($this->request->getVar('qtypart') > 0) {
            $this->wopart_bpModel->update($id, $simpandata);
            $msg = [
              'sukses' => 'Data berhasil diupdate'
            ];
            // session()->setFlashdata('pesan', 'Data berhasil ditambah');
            echo json_encode($msg);
          } else {
            $msg = [
              'sukses' => 'Data gagal ditambah'
            ];
            // session()->setFlashdata('pesan', 'Data gagal ditambah');
            echo json_encode($msg);
          }
        } else {
          $user = "Tambah-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
          $simpandata = [
            'nowo' => $this->request->getVar('nowo'),
            'kode' => $this->request->getVar('kodepart'),
            'nama' => $this->request->getVar('namapart'),
            'kdmekanik' => $this->request->getVar('kdmekanik'),
            'nmmekanik' => $this->request->getVar('nmmekanik'),
            'jenis' => 'PART',
            'qty' => $this->request->getVar('qtypart'),
            'harga' => str_replace(",", "", $this->request->getVar('hargapart')),
            'pr_discount' => $this->request->getVar('pr_discountpart'),
            'subtotal' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('subtotalpart')),
            // 'harga' => $this->request->getVar('hargapart'),
            // 'pr_discount' => $this->request->getVar('pr_discountpart'),
            // 'subtotal' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('subtotalpart')),
            'user' => $user,
          ];
          // var_dump($simpandata);
          if ($this->request->getVar('qtypart') > 0) {
            $this->wopart_bpModel->insert($simpandata);
            $msg = [
              'sukses' => 'Data berhasil ditambah'
            ];
            // session()->setFlashdata('pesan', 'Data berhasil ditambah');
            echo json_encode($msg);
          } else {
            $msg = [
              'sukses' => 'Data gagal ditambah'
            ];
            // session()->setFlashdata('pesan', 'Data gagal ditambah');
            echo json_encode($msg);
          }
        }
      }
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function table_estimasi_bp_part()
  {
    $noestimasi = $_POST['noestimasi'];
    $data = [
      'noestimasi' => $noestimasi,
      'title' => 'Estimasi Part',
      'estimasi_part' => $this->estimasipart_bpModel->getnoestimasi($noestimasi)
    ];
    // dd($data);
    echo view('estimasi_bp/tbl_estimasi_part', $data);
  }

  public function table_wo_bp_part()
  {
    $nowo = $_POST['nowo'];
    $data = [
      'nowo' => $nowo,
      'title' => 'WO Part',
      'wo_part' => $this->wopart_bpModel->getnowo($nowo)
    ];
    // dd($data);
    echo view('estimasi_bp/tbl_wo_part', $data);
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

  public function table_estimasi_bp_bahan()
  {
    $noestimasi = $_POST['noestimasi'];
    $data = [
      'noestimasi' => $noestimasi,
      'title' => 'Estimasi Bahan',
      'estimasi_bahan' => $this->estimasibahan_bpModel->getnoestimasi($noestimasi)
    ];
    // var_dump($data);
    echo view('estimasi_bp/tbl_estimasi_bahan', $data);
  }

  public function table_wo_bp_bahan()
  {
    $nowo = $_POST['nowo'];
    $data = [
      'nowo' => $nowo,
      'title' => 'WO Bahan',
      'wo_bahan' => $this->wobahan_bpModel->getnowo($nowo)
    ];
    // var_dump($data);
    echo view('estimasi_bp/tbl_wo_bahan', $data);
  }

  public function replbahan()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['kodebahan'];
      $row = $this->tbbahanModel->getkode($kode);
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

  public function simpanbahan()
  {
    if ($this->request->isAjax()) {
      $validation = \Config\Services::validation();
      $valid = $this->validate([
        'kodebahan' => [
          'label' => 'kodebahan',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
          ]
        ],
        'qtybahan' => [
          'label' => 'qtybahan',
          // 'rules' => 'required|numeric|greater_than[0]',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'greater_than' => '{field} tidak boleh 0',
          ]
        ],
      ]);
      if (!$valid) {
        $msg = [
          'error' => [
            'kodebahan' => $validation->getError('kodebahan'),
            'qtybahan' => $validation->getError('qtybahan'),
          ]
        ];
        echo json_encode($msg);
      } else {
        $session = session();
        $noestimasi = $this->request->getVar('noestimasi');
        $kode = $this->request->getVar('kodebahan');
        $data = $this->estimasibahan_bpModel->getdoublebarang($noestimasi, $kode);
        if ($data) {
          $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
          foreach ($data as $row) {
            $id = $row['id'];
          }
          $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
          $simpandata = [
            'noestimasi' => $this->request->getVar('noestimasi'),
            'kode' => $this->request->getVar('kodebahan'),
            'nama' => $this->request->getVar('namabahan'),
            'jenis' => 'BAHAN',
            'qty' => $this->request->getVar('qtybahan'),
            'harga' => str_replace(",", "", $this->request->getVar('hargabahan')),
            'pr_discount' => $this->request->getVar('pr_discountbahan'),
            'subtotal' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('subtotalbahan')),
            'user' => $user,
          ];
          if ($this->request->getVar('qtybahan') > 0) {
            $this->estimasibahan_bpModel->update($id, $simpandata);
            $msg = [
              'sukses' => 'Data berhasil diupdate'
            ];
            // session()->setFlashdata('pesan', 'Data berhasil ditambah');
            echo json_encode($msg);
          } else {
            $msg = [
              'sukses' => 'Data gagal ditambah'
            ];
            // session()->setFlashdata('pesan', 'Data gagal ditambah');
            echo json_encode($msg);
          }
        } else {
          $user = "Tambah-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
          $simpandata = [
            'noestimasi' => $this->request->getVar('noestimasi'),
            'kode' => $this->request->getVar('kodebahan'),
            'nama' => $this->request->getVar('namabahan'),
            'jenis' => 'BAHAN',
            'qty' => $this->request->getVar('qtybahan'),
            'harga' => str_replace(",", "", $this->request->getVar('hargabahan')),
            'pr_discount' => $this->request->getVar('pr_discountbahan'),
            'subtotal' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('subtotalbahan')),
            'user' => $user,
          ];
          if ($this->request->getVar('qtybahan') > 0) {
            $this->estimasibahan_bpModel->insert($simpandata);
            $msg = [
              'sukses' => 'Data berhasil ditambah'
            ];
            // session()->setFlashdata('pesan', 'Data berhasil ditambah');
            echo json_encode($msg);
          } else {
            $msg = [
              'sukses' => 'Data gagal ditambah'
            ];
            // session()->setFlashdata('pesan', 'Data gagal ditambah');
            echo json_encode($msg);
          }
        }
      }
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function simpan_bahan_wo()
  {
    if ($this->request->isAjax()) {
      $validation = \Config\Services::validation();
      $valid = $this->validate([
        'kodebahan' => [
          'label' => 'kodebahan',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
          ]
        ],
        'qtybahan' => [
          'label' => 'qtybahan',
          // 'rules' => 'required|numeric|greater_than[0]',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'greater_than' => '{field} tidak boleh 0',
          ]
        ],
      ]);
      if (!$valid) {
        $msg = [
          'error' => [
            'kodebahan' => $validation->getError('kodebahan'),
            'qtybahan' => $validation->getError('qtybahan'),
          ]
        ];
        echo json_encode($msg);
      } else {
        $session = session();
        $nowo = $this->request->getVar('nowo');
        $kode = $this->request->getVar('kodebahan');
        $data = $this->wobahan_bpModel->getdoublebarang($nowo, $kode);
        if ($data) {
          $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
          foreach ($data as $row) {
            $id = $row['id'];
          }
          $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
          $simpandata = [
            'nowo' => $this->request->getVar('nowo'),
            'kode' => $this->request->getVar('kodebahan'),
            'nama' => $this->request->getVar('namabahan'),
            'kdmekanik' => $this->request->getVar('kdmekanik'),
            'nmmekanik' => $this->request->getVar('nmmekanik'),
            'jenis' => 'BAHAN',
            'qty' => $this->request->getVar('qtybahan'),
            'harga' => str_replace(",", "", $this->request->getVar('hargabahan')),
            'pr_discount' => $this->request->getVar('pr_discountbahan'),
            'subtotal' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('subtotalbahan')),
            'user' => $user,
          ];
          if ($this->request->getVar('qtybahan') > 0) {
            $this->wobahan_bpModel->update($id, $simpandata);
            $msg = [
              'sukses' => 'Data berhasil diupdate'
            ];
            // session()->setFlashdata('pesan', 'Data berhasil ditambah');
            echo json_encode($msg);
          } else {
            $msg = [
              'sukses' => 'Data gagal ditambah'
            ];
            // session()->setFlashdata('pesan', 'Data gagal ditambah');
            echo json_encode($msg);
          }
        } else {
          $user = "Tambah-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
          $simpandata = [
            'nowo' => $this->request->getVar('nowo'),
            'kode' => $this->request->getVar('kodebahan'),
            'nama' => $this->request->getVar('namabahan'),
            'kdmekanik' => $this->request->getVar('kdmekanik'),
            'nmmekanik' => $this->request->getVar('nmmekanik'),
            'jenis' => 'BAHAN',
            'qty' => $this->request->getVar('qtybahan'),
            'harga' => str_replace(",", "", $this->request->getVar('hargabahan')),
            'pr_discount' => $this->request->getVar('pr_discountbahan'),
            'subtotal' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('subtotalbahan')),
            'user' => $user,
          ];
          if ($this->request->getVar('qtybahan') > 0) {
            $this->wobahan_bpModel->insert($simpandata);
            $msg = [
              'sukses' => 'Data berhasil ditambah'
            ];
            // session()->setFlashdata('pesan', 'Data berhasil ditambah');
            echo json_encode($msg);
          } else {
            $msg = [
              'sukses' => 'Data gagal ditambah'
            ];
            // session()->setFlashdata('pesan', 'Data gagal ditambah');
            echo json_encode($msg);
          }
        }
      }
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function table_estimasi_bp_opl()
  {
    $noestimasi = $_POST['noestimasi'];
    $data = [
      'noestimasi' => $noestimasi,
      'title' => 'Estimasi OPL',
      'estimasi_opl' => $this->estimasiopl_bpModel->getnoestimasi($noestimasi),
    ];
    // var_dump($data);
    echo view('estimasi_bp/tbl_estimasi_opl', $data);
  }

  public function table_estimasi_bp_jasa()
  {
    $noestimasi = $_POST['noestimasi'];
    $data = [
      'noestimasi' => $noestimasi,
      'title' => 'Estimasi Jasa',
      'estimasi_bp' => $this->estimasi_bpModel->getnoestimasi($noestimasi),
      'estimasi_jasa' => $this->estimasijasa_bpModel->getnoestimasi($noestimasi),
    ];
    // var_dump($data);
    echo view('estimasi_bp/tbl_estimasi_jasa', $data);
  }

  public function table_wo_bp_opl()
  {
    $nowo = $_POST['nowo'];
    $data = [
      'nowo' => $nowo,
      'title' => 'WO OPL',
      'wo_opl' => $this->woopl_bpModel->getnowo($nowo),
    ];
    // var_dump($data);
    echo view('estimasi_bp/tbl_wo_opl', $data);
  }

  public function table_wo_bp_jasa()
  {
    $nowo = $_POST['nowo'];
    $data = [
      'nowo' => $nowo,
      'title' => 'WO Jasa',
      'wo_bp' => $this->wo_bpModel->getnowo($nowo),
      'wo_jasa' => $this->wojasa_bpModel->getnowo($nowo),
    ];
    // var_dump($data);
    echo view('estimasi_bp/tbl_wo_jasa', $data);
  }

  public function replopl()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['kodeopl'];
      $row = $this->tboplModel->getkode($kode);
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

  public function repljasa()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['kodejasa'];
      $row = $this->tbjasaModel->getkode($kode);
      if (isset($row)) {
        $data = [
          'title' => 'Detail data',
          'kode' => $row['kode'],
          'nama' => $row['nama'],
          'harga' => $row['harga'],
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

  public function simpanopl()
  {
    if ($this->request->isAjax()) {
      $validation = \Config\Services::validation();
      $valid = $this->validate([
        'kodeopl' => [
          'label' => 'kodeopl',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
          ]
        ],
        'qtyopl' => [
          'label' => 'qtyopl',
          // 'rules' => 'required|numeric|greater_than[0]',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'greater_than' => '{field} tidak boleh 0',
          ]
        ],
      ]);
      if (!$valid) {
        $msg = [
          'error' => [
            'kodeopl' => $validation->getError('kodeopl'),
            'qtyopl' => $validation->getError('qtyopl'),
          ]
        ];
        echo json_encode($msg);
      } else {
        $session = session();
        $noestimasi = $this->request->getVar('noestimasi');
        $kode = $this->request->getVar('kodeopl');
        $data = $this->estimasiopl_bpModel->getdoublebarang($noestimasi, $kode);
        if ($data) {
          foreach ($data as $row) {
            $id = $row['id'];
          }
          $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
          $simpandata = [
            'noestimasi' => $this->request->getVar('noestimasi'),
            'kode' => $this->request->getVar('kodeopl'),
            'nama' => $this->request->getVar('namaopl'),
            'jenis' => 'OPL',
            'qty' => $this->request->getVar('qtyopl'),
            'harga' => str_replace(",", "", $this->request->getVar('hargaopl')),
            'pr_discount' => $this->request->getVar('pr_discountopl'),
            'subtotal' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('subtotalopl')),
            'user' => $user,
          ];
          if ($this->request->getVar('qtyopl') > 0) {
            $this->estimasiopl_bpModel->update($id, $simpandata);
            $msg = [
              'sukses' => 'Data berhasil diupdate'
            ];
            // session()->setFlashdata('pesan', 'Data berhasil ditambah');
            echo json_encode($msg);
          } else {
            $msg = [
              'sukses' => 'Data gagal ditambah'
            ];
            // session()->setFlashdata('pesan', 'Data gagal ditambah');
            echo json_encode($msg);
          }
        } else {
          $user = "Tambah-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
          $simpandata = [
            'noestimasi' => $this->request->getVar('noestimasi'),
            'kode' => $this->request->getVar('kodeopl'),
            'nama' => $this->request->getVar('namaopl'),
            'jenis' => 'OPL',
            'qty' => $this->request->getVar('qtyopl'),
            'harga' => str_replace(",", "", $this->request->getVar('hargaopl')),
            'pr_discount' => $this->request->getVar('pr_discountopl'),
            'subtotal' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('subtotalopl')),
            'user' => $user,
          ];
          if ($this->request->getVar('qtyopl') > 0) {
            $this->estimasibahan_bpModel->insert($simpandata);
            $msg = [
              'sukses' => 'Data berhasil ditambah!!'
            ];
            // session()->setFlashdata('pesan', 'Data berhasil ditambah');
            echo json_encode($msg);
          } else {
            $msg = [
              'sukses' => 'Data gagal ditambah'
            ];
            // session()->setFlashdata('pesan', 'Data gagal ditambah');
            echo json_encode($msg);
          }
        }
      }
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function simpan_opl_wo()
  {
    if ($this->request->isAjax()) {
      $validation = \Config\Services::validation();
      $valid = $this->validate([
        'kodeopl' => [
          'label' => 'kodeopl',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
          ]
        ],
        'qtyopl' => [
          'label' => 'qtyopl',
          // 'rules' => 'required|numeric|greater_than[0]',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'greater_than' => '{field} tidak boleh 0',
          ]
        ],
      ]);
      if (!$valid) {
        $msg = [
          'error' => [
            'kodeopl' => $validation->getError('kodeopl'),
            'qtyopl' => $validation->getError('qtyopl'),
          ]
        ];
        echo json_encode($msg);
      } else {
        $session = session();
        $nowo = $this->request->getVar('nowo');
        $kode = $this->request->getVar('kodeopl');
        $data = $this->woopl_bpModel->getdoublebarang($nowo, $kode);
        if ($data) {
          foreach ($data as $row) {
            $id = $row['id'];
          }
          $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
          $simpandata = [
            'nowo' => $this->request->getVar('nowo'),
            'kode' => $this->request->getVar('kodeopl'),
            'nama' => $this->request->getVar('namaopl'),
            'kdmekanik' => $this->request->getVar('kdmekanik'),
            'nmmekanik' => $this->request->getVar('nmmekanik'),
            'jenis' => 'OPL',
            'qty' => $this->request->getVar('qtyopl'),
            'harga' => str_replace(",", "", $this->request->getVar('hargaopl')),
            'pr_discount' => $this->request->getVar('pr_discountopl'),
            'subtotal' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('subtotalopl')),
            'user' => $user,
          ];
          if ($this->request->getVar('qtyopl') > 0) {
            $this->woopl_bpModel->update($id, $simpandata);
            $msg = [
              'sukses' => 'Data berhasil diupdate'
            ];
            // session()->setFlashdata('pesan', 'Data berhasil ditambah');
            echo json_encode($msg);
          } else {
            $msg = [
              'sukses' => 'Data gagal ditambah'
            ];
            // session()->setFlashdata('pesan', 'Data gagal ditambah');
            echo json_encode($msg);
          }
        } else {
          $user = "Tambah-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
          $simpandata = [
            'nowo' => $this->request->getVar('nowo'),
            'kode' => $this->request->getVar('kodeopl'),
            'nama' => $this->request->getVar('namaopl'),
            'kdmekanik' => $this->request->getVar('kdmekanik'),
            'nmmekanik' => $this->request->getVar('nmmekanik'),
            'jenis' => 'OPL',
            'qty' => $this->request->getVar('qtyopl'),
            'harga' => str_replace(",", "", $this->request->getVar('hargaopl')),
            'pr_discount' => $this->request->getVar('pr_discountopl'),
            'subtotal' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('subtotalopl')),
            'user' => $user,
          ];
          if ($this->request->getVar('qtyopl') > 0) {
            $this->woopl_bpModel->insert($simpandata);
            $msg = [
              'sukses' => 'Data berhasil ditambah!!'
            ];
            // session()->setFlashdata('pesan', 'Data berhasil ditambah');
            echo json_encode($msg);
          } else {
            $msg = [
              'sukses' => 'Data gagal ditambah'
            ];
            // session()->setFlashdata('pesan', 'Data gagal ditambah');
            echo json_encode($msg);
          }
        }
      }
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function simpanjasa()
  {
    if ($this->request->isAjax()) {
      $validation = \Config\Services::validation();
      $valid = $this->validate([
        'kodejasa' => [
          'label' => 'kodejasa',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
          ]
        ],
        'qtyjasa' => [
          'label' => 'qtyjasa',
          // 'rules' => 'required|numeric|greater_than[0]',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'greater_than' => '{field} tidak boleh 0',
          ]
        ],
      ]);
      if (!$valid) {
        $msg = [
          'error' => [
            'kodejasa' => $validation->getError('kodejasa'),
            'qtyjasa' => $validation->getError('qtyjasa'),
          ]
        ];
        echo json_encode($msg);
      } else {
        $session = session();
        $noestimasi = $this->request->getVar('noestimasi');
        $kode = $this->request->getVar('kodejasa');
        $data = $this->estimasijasa_bpModel->getdoublebarang($noestimasi, $kode);
        if ($data) {
          foreach ($data as $row) {
            $id = $row['id'];
          }
          $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
          $simpandata = [
            'noestimasi' => $this->request->getVar('noestimasi'),
            'kode' => $this->request->getVar('kodejasa'),
            'nama' => $this->request->getVar('namajasa'),
            'kerusakan' => $this->request->getVar('kerusakan'),
            'jenis' => 'JASA',
            'qty' => $this->request->getVar('qtyjasa'),
            'harga' => str_replace(",", "", $this->request->getVar('hargajasa')),
            'pr_discount' => $this->request->getVar('pr_discountjasa'),
            'subtotal' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('subtotaljasa')),
            'user' => $user,
          ];
          if ($this->request->getVar('qtyjasa') > 0) {
            $this->estimasijasa_bpModel->update($id, $simpandata);
            $msg = [
              'sukses' => 'Data berhasil diupdate'
            ];
            // session()->setFlashdata('pesan', 'Data berhasil ditambah');
            echo json_encode($msg);
          } else {
            $msg = [
              'sukses' => 'Data gagal ditambah'
            ];
            // session()->setFlashdata('pesan', 'Data gagal ditambah');
            echo json_encode($msg);
          }
        } else {
          $user = "Tambah-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
          $simpandata = [
            'noestimasi' => $this->request->getVar('noestimasi'),
            'kode' => $this->request->getVar('kodejasa'),
            'nama' => $this->request->getVar('namajasa'),
            'kerusakan' => $this->request->getVar('kerusakan'),
            'jenis' => 'JASA',
            'qty' => $this->request->getVar('qtyjasa'),
            'harga' => str_replace(",", "", $this->request->getVar('hargajasa')),
            'pr_discount' => $this->request->getVar('pr_discountjasa'),
            'subtotal' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('subtotaljasa')),
            'user' => $user,
          ];
          // var_dump($simpandata);
          if ($this->request->getVar('qtyjasa') > 0) {
            // $id = $this->wo_bpModel->getnoestimasi($this->request->getVar('noestimasi'));
            // $this->wo_bpModel->update($id, $simpanwo);
            $this->estimasijasa_bpModel->insert($simpandata);
            $msg = [
              'sukses' => 'Data berhasil ditambah'
            ];
            // session()->setFlashdata('pesan', 'Data berhasil ditambah');
            echo json_encode($msg);
          } else {
            $msg = [
              'sukses' => 'Data gagal ditambah'
            ];
            // session()->setFlashdata('pesan', 'Data gagal ditambah');
            echo json_encode($msg);
          }
        }
      }
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function simpan_jasa_wo()
  {
    if ($this->request->isAjax()) {
      $validation = \Config\Services::validation();
      $valid = $this->validate([
        'kodejasa' => [
          'label' => 'kodejasa',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
          ]
        ],
        'qtyjasa' => [
          'label' => 'qtyjasa',
          // 'rules' => 'required|numeric|greater_than[0]',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'greater_than' => '{field} tidak boleh 0',
          ]
        ],
      ]);
      if (!$valid) {
        $msg = [
          'error' => [
            'kodejasa' => $validation->getError('kodejasa'),
            'qtyjasa' => $validation->getError('qtyjasa'),
          ]
        ];
        echo json_encode($msg);
      } else {
        $session = session();
        $nowo = $this->request->getVar('nowo');
        $kode = $this->request->getVar('kodejasa');
        $data = $this->wojasa_bpModel->getdoublebarang($nowo, $kode);
        if ($data) {
          foreach ($data as $row) {
            $id = $row['id'];
          }
          $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
          $simpandata = [
            'nowo' => $this->request->getVar('nowo'),
            'kode' => $this->request->getVar('kodejasa'),
            'nama' => $this->request->getVar('namajasa'),
            'kerusakan' => $this->request->getVar('kerusakan'),
            'kdmekanik' => $this->request->getVar('kdmekanik'),
            'nmmekanik' => $this->request->getVar('nmmekanik'),
            'jenis' => 'JASA',
            'qty' => $this->request->getVar('qtyjasa'),
            'harga' => str_replace(",", "", $this->request->getVar('hargajasa')),
            'pr_discount' => $this->request->getVar('pr_discountjasa'),
            'subtotal' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('subtotaljasa')),
            'user' => $user,
          ];
          if ($this->request->getVar('qtyjasa') > 0) {
            $this->wojasa_bpModel->update($id, $simpandata);
            $msg = [
              'sukses' => 'Data berhasil diupdate'
            ];
            // session()->setFlashdata('pesan', 'Data berhasil ditambah');
            echo json_encode($msg);
          } else {
            $msg = [
              'sukses' => 'Data gagal ditambah'
            ];
            // session()->setFlashdata('pesan', 'Data gagal ditambah');
            echo json_encode($msg);
          }
        } else {
          $user = "Tambah-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
          $simpandata = [
            'nowo' => $this->request->getVar('nowo'),
            'kode' => $this->request->getVar('kodejasa'),
            'nama' => $this->request->getVar('namajasa'),
            'kerusakan' => $this->request->getVar('kerusakan'),
            'kdmekanik' => $this->request->getVar('kdmekanik'),
            'nmmekanik' => $this->request->getVar('nmmekanik'),
            'jenis' => 'JASA',
            'qty' => $this->request->getVar('qtyjasa'),
            'harga' => str_replace(",", "", $this->request->getVar('hargajasa')),
            'pr_discount' => $this->request->getVar('pr_discountjasa'),
            'subtotal' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('subtotaljasa')),
            'user' => $user,
          ];
          // var_dump($simpandata);
          if ($this->request->getVar('qtyjasa') > 0) {
            // $id = $this->wo_bpModel->getnowo($this->request->getVar('nowo'));
            // $this->wo_bpModel->update($id, $simpanwo);
            $this->wojasa_bpModel->insert($simpandata);
            $msg = [
              'sukses' => 'Data berhasil ditambah'
            ];
            // session()->setFlashdata('pesan', 'Data berhasil ditambah');
            echo json_encode($msg);
          } else {
            $msg = [
              'sukses' => 'Data gagal ditambah'
            ];
            // session()->setFlashdata('pesan', 'Data gagal ditambah');
            echo json_encode($msg);
          }
        }
      }
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function summary()
  {
    $noestimasi = $_POST['noestimasi'];
    $row = $this->estimasi_bpModel->getnoestimasi($noestimasi);
    foreach ($row as $k) {
      $noestimasi = $k['noestimasi'];
      $idestimasi = $k['id'];
      $pr_ppn = $k['pr_ppn'];
    }
    $jumpart = 0;
    $jumbahan = 0;
    $jumjasa = 0;
    $jumopl = 0;
    $jumjasa = $this->estimasijasa_bpModel->jumjasa($noestimasi);
    $jumpart = $this->estimasipart_bpModel->jumpart($noestimasi);
    $jumbahan = $this->estimasibahan_bpModel->jumbahan($noestimasi);
    $jumopl = $this->estimasiopl_bpModel->jumopl($noestimasi);
    foreach ($jumjasa as $j) {
      $jumjasa = $j['jumjasa'];
    }
    foreach ($jumpart as $j) {
      $jumpart = $j['jumpart'];
    }
    foreach ($jumbahan as $j) {
      $jumbahan = $j['jumbahan'];
    }
    foreach ($jumopl as $j) {
      $jumopl = $j['jumopl'];
    }
    $total = $jumpart + $jumjasa + $jumbahan + $jumopl;
    $ppn = $total * ($pr_ppn / 100);
    $total_estimasi = $total + $ppn;
    $dataupdate = [
      'id' => $idestimasi,
      'total_jasa' => $jumjasa,
      'total_part' => $jumpart,
      'total_bahan' => $jumbahan,
      'total_opl' => $jumopl,
      'total' => $total,
      'dpp' => $total,
      'pr_ppn' => $pr_ppn,
      'ppn' => $ppn,
      'total_estimasi' => $total_estimasi
    ];
    $id = $idestimasi;
    $this->estimasi_bpModel->update($id, $dataupdate);
    $data = [
      'title' => 'Estimasi WO Body Repair',
      'estimasi_bp' => $this->estimasi_bpModel->getnoestimasi($noestimasi),
      'summary_part' => $this->estimasipart_bpModel->getnoestimasi($noestimasi),
      'summary_jasa' => $this->estimasijasa_bpModel->getnoestimasi($noestimasi),
      'summary_bahan' => $this->estimasibahan_bpModel->getnoestimasi($noestimasi),
      'summary_opl' => $this->estimasiopl_bpModel->getnoestimasi($noestimasi),
    ];
    // var_dump($data);
    echo view('estimasi_bp/summary', $data);
  }

  public function summary_wo()
  {
    $nowo = $_POST['nowo'];
    $row = $this->wo_bpModel->getnowo($nowo);
    // var_dump($nowo);
    foreach ($row as $k) {
      $nowo = $k['nowo'];
      $idwo = $k['id'];
      $pr_ppn = $k['pr_ppn'];
    }
    $jumpart = 0;
    $jumbahan = 0;
    $jumjasa = 0;
    $jumopl = 0;
    $jumjasa = $this->wojasa_bpModel->jumjasa($nowo);
    $jumpart = $this->wopart_bpModel->jumpart($nowo);
    $jumbahan = $this->wobahan_bpModel->jumbahan($nowo);
    $jumopl = $this->woopl_bpModel->jumopl($nowo);
    foreach ($jumjasa as $j) {
      $jumjasa = $j['jumjasa'];
    }
    foreach ($jumpart as $j) {
      $jumpart = $j['jumpart'];
    }
    foreach ($jumbahan as $j) {
      $jumbahan = $j['jumbahan'];
    }
    foreach ($jumopl as $j) {
      $jumopl = $j['jumopl'];
    }
    $total = $jumpart + $jumjasa + $jumbahan + $jumopl;
    $ppn = $total * ($pr_ppn / 100);
    $total_wo = $total + $ppn;
    $dataupdate = [
      'id' => $idwo,
      'total_jasa' => $jumjasa,
      'total_part' => $jumpart,
      'total_bahan' => $jumbahan,
      'total_opl' => $jumopl,
      'total' => $total,
      'dpp' => $total,
      'pr_ppn' => $pr_ppn,
      'ppn' => $ppn,
      'total_wo' => $total_wo
    ];
    $id = $idwo;
    $this->wo_bpModel->update($id, $dataupdate);
    $data = [
      'title' => 'WO Body Repair',
      'wo_bp' => $this->wo_bpModel->getnowo($nowo),
      'summary_part' => $this->wopart_bpModel->getnowo($nowo),
      'summary_jasa' => $this->wojasa_bpModel->getnowo($nowo),
      'summary_bahan' => $this->wobahan_bpModel->getnowo($nowo),
      'summary_opl' => $this->woopl_bpModel->getnowo($nowo),
    ];
    // var_dump($data);
    echo view('estimasi_bp/summary_wo', $data);
  }

  public function hitung_summary_wo()
  {
    $nowo = $_POST['nowo'];
    $row = $this->wo_bpModel->getnowo($nowo);
    // var_dump($nowo);
    foreach ($row as $k) {
      $nowo = $k['nowo'];
      $idwo = $k['id'];
      $pr_ppn = $k['pr_ppn'];
    }
    $jumpart = 0;
    $jumbahan = 0;
    $jumjasa = 0;
    $jumopl = 0;
    $jumjasa = $this->wojasa_bpModel->jumjasa($nowo);
    $jumpart = $this->wopart_bpModel->jumpart($nowo);
    $jumbahan = $this->wobahan_bpModel->jumbahan($nowo);
    $jumopl = $this->woopl_bpModel->jumopl($nowo);
    foreach ($jumjasa as $j) {
      $jumjasa = $j['jumjasa'];
    }
    foreach ($jumpart as $j) {
      $jumpart = $j['jumpart'];
    }
    foreach ($jumbahan as $j) {
      $jumbahan = $j['jumbahan'];
    }
    foreach ($jumopl as $j) {
      $jumopl = $j['jumopl'];
    }
    $total = $jumpart + $jumjasa + $jumbahan + $jumopl;
    $ppn = $total * ($pr_ppn / 100);
    $total_wo = $total + $ppn;
    $dataupdate = [
      'id' => $idwo,
      'total_jasa' => $jumjasa,
      'total_part' => $jumpart,
      'total_bahan' => $jumbahan,
      'total_opl' => $jumopl,
      'total' => $total,
      'dpp' => $total,
      'pr_ppn' => $pr_ppn,
      'ppn' => $ppn,
      'total_wo' => $total_wo
    ];
    // var_dump($dataupdate);
    $this->wo_bpModel->update($idwo, $dataupdate);
  }

  public function caridatasa()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data sa',
        'tbsa' => $this->tbsaModel->where('aktif', 'Y')->orderBy('kdsa', 'asc')->findAll() //$rwtkeluarga
      ];
      $msg = [
        'data' => view('estimasi_bp/modalcarisa', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
  public function replsa()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['kdsa'];
      $row = $this->tbsaModel->getkode($kode);
      if (isset($row)) {
        $data = [
          'title' => 'Detail data',
          'kdsa' => $row['kdsa'],
          'nama' => $row['nama'],
        ];
      } else {
        $data = [
          'title' => 'Detail data',
          'kdsa' => '',
          'nama' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function caridatamekanik()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data Mekanik',
        'tbmekanik' => $this->tbmekanikModel->where('aktif', 'Y')->orderBy('kode', 'asc')->findAll() //$rwtkeluarga
      ];
      $msg = [
        'data' => view('estimasi_bp/modalcarimekanik', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
  public function replmekanik()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['kode'];
      $row = $this->tbmekanikModel->getkode($kode);
      if (isset($row)) {
        $data = [
          'title' => 'Detail data',
          'kdmekanik' => $row['kode'],
          'nmmekanik' => $row['nama'],
        ];
      } else {
        $data = [
          'title' => 'Detail data',
          'kdsa' => '',
          'nama' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function caridataasuransi()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data Asuransi',
        'tbasuransi' => $this->tbasuransiModel->where('aktif', 'Y')->orderBy('kode', 'asc')->findAll() //$rwtkeluarga
      ];
      $msg = [
        'data' => view('estimasi_bp/modalcariasuransi', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
  public function replasuransi()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['kode_asuransi'];
      $row = $this->tbasuransiModel->getkode($kode);
      if (isset($row)) {
        $data = [
          'title' => 'Detail data',
          'kode' => $row['kode'],
          'nama' => $row['nama'],
        ];
      } else {
        $data = [
          'title' => 'Detail data',
          'kode' => '',
          'nama' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function prosesestimasi_bp()
  {
    if ($this->request->isAjax()) {
      $session = session();
      $id = $_POST['id'];
      $row = $this->estimasi_bpModel->find($id);
      $close = $row['close'];
      if (!isset($close)) {
        $close = '';
      }
      if ($close == 'Y') {
      }
      $user = "Proses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      $simpandata = [
        'close' => 1,
        'user' => $user,
      ];
      // var_dump($simpandata);
      $this->estimasi_bpModel->update($id, $simpandata);
      $msg = [
        'sukses' => 'Data berhasil disimpan'
      ];
      session()->setFlashdata('pesan', 'Data berhasil diupdate');
      echo json_encode($msg);
    };
  }
  public function unprosesestimasi_bp()
  {
    if ($this->request->isAjax()) {
      $session = session();
      $id = $_POST['id'];

      $user = "Unproses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      $simpandata = [
        'close' => 0,
        'user' => $user,
      ];
      $this->estimasi_bpModel->update($id, $simpandata);
      $msg = [
        'sukses' => 'Data berhasil disimpan'
      ];
      session()->setFlashdata('pesan', 'Data berhasil diupdate');
      echo json_encode($msg);
    };
  }

  public function simpankewo()
  {
    if ($this->request->isAjax()) {
      $session = session();
      $noestimasi = $_POST['noestimasi'];
      $nowo = 'BW' . date('Y') . date('m') . sprintf("%05s", intval(substr('00000', -5)) + 1);
      $wo = $this->wo_bpModel->buatnowo();
      if (isset($wo)) {
        foreach ($wo as $row) {
          if ($row->nowo != NULL) {
            $nowo = 'BW' . date('Y') . date('m') . sprintf("%05s", intval(substr($row->nowo, -5)) + 1);
          }
        }
      }
      $user = "Tambah-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      $row = $this->estimasi_bpModel->getnoestimasi($noestimasi);
      foreach ($row as $k) {
        $idestimasi = $k['id'];
        $simpandata = [
          'noestimasi' => $noestimasi,
          'nowo' => $nowo,
          'close' => "N",
          'tanggal' => $k['tanggal'],
          'nopolisi' => $k['nopolisi'],
          'norangka' => $k['norangka'],
          'kdpemilik' => $k['kdpemilik'],
          'nmpemilik' => $k['nmpemilik'],
          'kdsa' => $k['kdsa'],
          'keluhan' => $k['keluhan'],
          'kdservice' => $k['kdservice'],
          // 'nmservice' => $k['nmservice'],
          'km' => $k['km'],
          // 'kdpaket' => $k['kdpaket'],
          'aktifitas' => $k['aktifitas'],
          'fasilitas' => $k['fasilitas'],
          'status_tunggu' => $k['status_tunggu'],
          'int_reminder' => $k['int_reminder'],
          'via' => $k['via'],
          'pr_ppn' => $k['pr_ppn'],
          'ppn' => $k['ppn'],
          'total_wo' => $k['total_estimasi'],
          'no_polis' => $k['no_polis'],
          'nama_polis' => $k['nama_polis'],
          'tgl_akhir_polis' => $k['tgl_akhir_polis'],
          'kode_asuransi' => $k['kode_asuransi'],
          'nama_asuransi' => $k['nama_asuransi'],
          'alamat_asuransi' => $k['alamat_asuransi'],
          'klaim' => ($k['klaim'] === null ? 0 : 1),
          'internal' => ($k['internal'] === null ? 0 : 1),
          'inventaris' => ($k['inventaris'] === null ? 0 : 1),
          'campaign' => ($k['campaign'] === null ? 0 : 1),
          'booking' => ($k['booking'] === null ? 0 : 1),
          'lain_lain' => ($k['lain_lain'] === null ? 0 : 1),
          'surveyor' => $k['surveyor'],
          'npwp' => $k['npwp'],
          'contact_person' => $k['contact_person'],
          'no_contact_person' => $k['no_contact_person'],
          'user' => $user,
        ];
      }
      $this->wo_bpModel->insert($simpandata);
      $simpandata = [
        'nowo' => $nowo,
      ];
      $this->estimasi_bpModel->update($idestimasi, $simpandata);
      $row = $this->estimasijasa_bpModel->getnoestimasi($noestimasi);
      foreach ($row as $k) {
        $simpandata = [
          'kode' => $k['kode'],
          'nama' => $k['nama'],
          'kerusakan' => $k['kerusakan'],
          'jenis' => $k['jenis'],
          'qty' => $k['qty'],
          'harga' => $k['harga'],
          'pr_discount' => $k['pr_discount'],
          'subtotal' => $k['subtotal'],
          'nowo' => $nowo,
          'user' => $user,
        ];
        $this->wojasa_bpModel->insert($simpandata);
      }
      $row = $this->estimasipart_bpModel->getnoestimasi($noestimasi);
      foreach ($row as $k) {
        $simpandata = [
          'kode' => $k['kode'],
          'nama' => $k['nama'],
          'kerusakan' => $k['kerusakan'],
          'jenis' => $k['jenis'],
          'qty' => $k['qty'],
          'harga' => $k['harga'],
          'pr_discount' => $k['pr_discount'],
          'subtotal' => $k['subtotal'],
          'nowo' => $nowo,
          'user' => $user,
        ];
        $this->wopart_bpModel->insert($simpandata);
      }
      $row = $this->estimasibahan_bpModel->getnoestimasi($noestimasi);
      foreach ($row as $k) {
        $simpandata = [
          'kode' => $k['kode'],
          'nama' => $k['nama'],
          'kerusakan' => $k['kerusakan'],
          'jenis' => $k['jenis'],
          'qty' => $k['qty'],
          'harga' => $k['harga'],
          'pr_discount' => $k['pr_discount'],
          'subtotal' => $k['subtotal'],
          'nowo' => $nowo,
          'user' => $user,
        ];
        $this->wobahan_bpModel->insert($simpandata);
      }
      $row = $this->estimasiopl_bpModel->getnoestimasi($noestimasi);
      foreach ($row as $k) {
        $simpandata = [
          'kode' => $k['kode'],
          'nama' => $k['nama'],
          'kerusakan' => $k['kerusakan'],
          'jenis' => $k['jenis'],
          'qty' => $k['qty'],
          'harga' => $k['harga'],
          'pr_discount' => $k['pr_discount'],
          'subtotal' => $k['subtotal'],
          'nowo' => $nowo,
          'user' => $user,
        ];
        $this->woopl_bpModel->insert($simpandata);
      }
      $msg = [
        'sukses' => 'Data berhasil disimpan'
      ];
      session()->setFlashdata('pesan', 'Data berhasil diupdate');
      echo json_encode($msg);
    };
  }

  public function proses_wo_bp()
  {
    if ($this->request->isAjax()) {
      $session = session();
      $id = $_POST['id'];
      $row = $this->wo_bpModel->find($id);
      $close = $row['close'];
      if (!isset($close)) {
        $close = 0;
      }
      $user = "Proses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      $simpandata = [
        'proses' => 1,
        'user_proses' => $user,
      ];
      var_dump($simpandata);
      $this->wo_bpModel->update($id, $simpandata);
      $msg = [
        'sukses' => 'Data berhasil disimpan'
      ];
      session()->setFlashdata('pesan', 'Data berhasil diupdate');
      echo json_encode($msg);
    };
  }
  public function unproses_wo_bp()
  {
    if ($this->request->isAjax()) {
      $session = session();
      $id = $_POST['id'];
      $user = "Unproses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      $simpandata = [
        'proses' => 0,
        'user_proses' => $user,
      ];
      $this->wo_bpModel->update($id, $simpandata);
      $msg = [
        'sukses' => 'Data berhasil disimpan'
      ];
      session()->setFlashdata('pesan', 'Data berhasil diupdate');
      echo json_encode($msg);
    };
  }

  public function cetakwo_bp($id)
  {
    $dompdf = new Dompdf();
    $row = $this->wo_bpModel->find($id);
    $nowo = $row['nowo'];
    $nopolisi = $row['nopolisi'];
    $kdpemilik = $row['kdpemilik'];
    $kdsa = $row['kdsa'];
    if (!isset($kdsa)) {
      $kdsa = "";
    }
    $rowmobil = $this->tbmobilModel->getnopolisi($nopolisi);
    $kdmerek = $rowmobil['kdmerek'];
    $kdmodel = $rowmobil['kdmodel'];
    $kdtipe = $rowmobil['kdtipe'];
    $kdwarna = $rowmobil['kdwarna'];
    $kdjenis = $rowmobil['kdjenis'];


    $data = [
      'title' => 'Cetak WO',
      'wo_bp' => $this->wo_bpModel->find($id),
      'tbmobil' => $this->tbmobilModel->getnopolisi($nopolisi),
      'tbmerek' => $this->tbmerekModel->getkode($kdmerek),
      'tbmodel' => $this->tbmodelModel->getkode($kdmodel),
      'tbtipe' => $this->tbtipeModel->getkode($kdtipe),
      'tbwarna' => $this->tbwarnaModel->getkode($kdwarna),
      'tbjenis' => $this->tbjenisModel->getkode($kdjenis),
      'tbcustomer' => $this->tbcustomerModel->getkdcustomer($kdpemilik),
      'tbsa' => ($kdsa ? $this->tbsaModel->getkode($kdsa) : ''),
      'jasa' => $this->wojasa_bpModel->getnowo($nowo),
      'part' => $this->wopart_bpModel->getnowo($nowo),
      'bahan' => $this->wobahan_bpModel->getnowo($nowo),
      'opl' => $this->woopl_bpModel->getnowo($nowo),
    ];
    // var_dump($data);
    // $msg = [
    //   'sukses' => view('wo_bp/cetakwo_bp', $data)
    // ];
    $html =  view('estimasi_bp/cetakwo_bp', $data);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'Potrait');
    $dompdf->render();
    // $dompdf->stream(); //langsung download
    $dompdf->stream('wo ' . $nowo . '.pdf', array("Attachment" => false));
    // var_dump($msg);
    // echo json_encode($msg);
    // } else {
    //   exit('Maaf tidak dapat diproses');
    // }
  }
}
