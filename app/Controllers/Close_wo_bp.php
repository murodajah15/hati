<?php

namespace App\Controllers;

// use App\Models\Estimasi_bpModel;
// use App\Models\Estimasipart_bpModel;
// use App\Models\Estimasibahan_bpModel;
// use App\Models\Estimasiopl_bpModel;
// use App\Models\Estimasijasa_bpModel;
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
// use App\Models\TbasuransiModel;
// use App\Models\Tasklist_bpdModel;

use \Dompdf\Dompdf;

class Close_wo_bp extends BaseController
{
  protected $tbcustomerModel, $estimasi_bpModel, $wo_bpModel, $tbmobilModel, $tbmerekModel, $tbmodelModel, $tbtipeModel, $tbwarnaModel, $tbjenisModel, $tbagamaModel,
    $tbbarangModel, $estimasipart_bpModel, $estimasibahan_bpModel, $tbbahanModel, $tboplModel, $tbjasaModel, $tbsaModel, $estimasiopl_bpModel, $estimasijasa_bpModel, $tbpaketModel,
    $paketpartModel, $paketjasaModel, $paketbahanModel, $paketoplModel, $tbasuransiModel, $tasklist_bpdModel, $wopart_bpModel, $wobahan_bpModel, $woopl_bpModel, $wojasa_bpModel;
  public function __construct()
  {
    // $this->estimasi_bpModel = new Estimasi_bpModel();
    // $this->estimasipart_bpModel = new Estimasipart_bpModel();
    // $this->estimasibahan_bpModel = new Estimasibahan_bpModel();
    // $this->estimasiopl_bpModel = new Estimasiopl_bpModel();
    // $this->estimasijasa_bpModel = new Estimasijasa_bpModel();
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
    // $this->tbasuransiModel = new TbasuransiModel();
    // $this->tasklist_bpdModel = new Tasklist_bpdModel();
  }

  public function index()
  {
    $data = [
      'menu' => 'transaksi',
      'submenu' => 'close_wo_bp',
      'title' => 'Close Work Order Body Repair',
      'wo_bp' => $this->wo_bpModel->orderBy('nowo')->findAll() //$wo
    ];
    echo view('close_wo_bp/index', $data);
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

  public function detail_wo_bp1()
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
      'sukses' => view('close_wo_bp/detail_wo_bp', $data)
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
      'sukses' => view('close_wo_bp/inputestimasi_bpd', $data)
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
        'sukses' => view('close_wo_bp/editestimasi_bp', $data)
      ];
      echo json_encode($msg);
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
      'sukses' => view('close_wo_bp/input_wo_bpd', $data)
    ];
    echo json_encode($msg);
  }

  public function hapusdetailestimasi_bp($id)
  {
    $this->estimasijasa_bpModel->hapusdetailestimasi($id);
    session()->setFlashdata('pesan', 'Data berhasil dihapus');
    echo json_encode(array("status" => TRUE));
  }

  public function hapusdetailwo_bp($id)
  {
    $this->wojasa_bpModel->hapusdetailwo($id);
    session()->setFlashdata('pesan', 'Data berhasil dihapus');
    echo json_encode(array("status" => TRUE));
  }

  public function table_wo_bp()
  {
    $model = new wo_bpModel();
    $data['title'] = 'Work Order Body Repair';
    $data['wo_bp'] = $model->findAll();
    echo view('close_wo_bp/tabel_wo_bp', $data);
  }

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

  public function caridatajasa()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data jasa',
        'tbjasa' => $this->tbjasaModel->where('aktif', 'Y')->where('parent', 'N')->orderBy('kode', 'asc')->findAll() //$rwtkeluarga
      ];
      // var_dump($data);
      $msg = [
        'data' => view('close_wo_bp/modalcarijasa', $data),
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
        'data' => view('close_wo_bp/modalcaritasklist', $data),
      ];
      echo json_encode($msg);
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
    echo view('close_wo_bp/tbl_estimasi_part', $data);
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
    echo view('close_wo_bp/tbl_wo_part', $data);
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
    echo view('close_wo_bp/tbl_wo_bahan', $data);
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
    echo view('close_wo_bp/tbl_estimasi_opl', $data);
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
    echo view('close_wo_bp/tbl_estimasi_jasa', $data);
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
    echo view('close_wo_bp/tbl_wo_opl', $data);
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
    echo view('close_wo_bp/tbl_wo_jasa', $data);
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

  public function summary_wo_bp()
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
    echo view('close_wo_bp/summary_wo', $data);
  }

  public function close_wo_bp()
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
        'close' => 1,
        'user_close' => $user,
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
  public function unclose_wo_bp()
  {
    if ($this->request->isAjax()) {
      $session = session();
      $id = $_POST['id'];
      $row = $this->wo_bpModel->find($id);
      $close_faktur = $row['close_faktur'];
      if ($close_faktur < 1) {
        $user = "Unproses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        $simpandata = [
          'close' => 0,
          'user_close' => $user,
        ];
        $this->wo_bpModel->update($id, $simpandata);
        $msg = [
          'sukses' => 'Data berhasil disimpan'
        ];
        session()->setFlashdata('pesan', 'Data berhasil diupdate');
      } else {
        $msg = [
          'sukses' => 'Data gagal diunclose (sudah faktur) !'
        ];
        session()->setFlashdata('pesan', 'Data gagal diunclose (sudah faktur) !');
      }
      echo json_encode($msg);
    };
  }
}
