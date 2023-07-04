<?php

namespace App\Controllers;

use App\Models\Faktur_bpModel;
use App\Models\Wo_bpModel;
use App\Models\Wopart_bpModel;
use App\Models\Wobahan_bpModel;
use App\Models\Woopl_bpModel;
use App\Models\Wojasa_bpModel;
use App\Models\Fakturpart_bpModel;
use App\Models\Fakturbahan_bpModel;
use App\Models\Fakturopl_bpModel;
use App\Models\Fakturjasa_bpModel;
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

use \Dompdf\Dompdf;

class Close_faktur_bp extends BaseController
{
  protected $tbcustomerModel, $estimasi_bpModel, $faktur_bpModel, $tbmobilModel, $tbmerekModel, $tbmodelModel, $tbtipeModel, $tbwarnaModel, $tbjenisModel, $tbagamaModel,
    $tbbarangModel, $estimasipart_bpModel, $estimasibahan_bpModel, $tbbahanModel, $tboplModel, $tbjasaModel, $tbsaModel, $estimasiopl_bpModel, $estimasijasa_bpModel, $tbpaketModel,
    $paketpartModel, $paketjasaModel, $paketbahanModel, $paketoplModel, $tbasuransiModel, $tasklist_bpdModel, $wopart_bpModel, $wobahan_bpModel, $woopl_bpModel, $wojasa_bpModel,
    $wo_bpModel, $fakturpart_bpModel, $fakturbahan_bpModel, $fakturopl_bpModel, $fakturjasa_bpModel;

  public function __construct()
  {
    $this->faktur_bpModel = new Faktur_bpModel();
    $this->fakturpart_bpModel = new Fakturpart_bpModel();
    $this->fakturbahan_bpModel = new Fakturbahan_bpModel();
    $this->fakturopl_bpModel = new Fakturopl_bpModel();
    $this->fakturjasa_bpModel = new Fakturjasa_bpModel();
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
      'submenu' => 'close_faktur_bp',
      'submenu1' => 'body_repair',
      'title' => 'Close Faktur Body Repair',
      'faktur_bp' => $this->faktur_bpModel->orderBy('nowo')->findAll() //$wo
    ];
    echo view('close_faktur_bp/index', $data);
  }

  public function ajaxLoadData()
  {
    $request = $this->request;
    $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
    $katakunci = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
    $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
    $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
    $data = $this->faktur_bpModel->tampilData($request, $katakunci, $start, $length);
    $jumlahData = $this->faktur_bpModel->tampilData($request, $katakunci);
    $output = array(
      "draw" => intval($param['draw']),
      "recordsTotal" => count($jumlahData),
      "recordsFiltered" => count($jumlahData),
      "data" => $data,
    );
    // var_dump($data);
    echo json_encode($output);
  }

  public function table_faktur_bp()
  {
    $model = new faktur_bpModel();
    $data['title'] = 'Faktur Body Repair';
    $data['faktur_bp'] = $model->findAll();
    echo view('close_faktur_bp/tabel_faktur_bp', $data);
  }

  // public function detail_faktur_bp()
  // {
  //   $id = $this->request->getVar('id');
  //   $row = $this->faktur_bpModel->find($id);
  //   $nopolisi = $row['nopolisi'];
  //   $kdpemilik = $row['kdpemilik'];
  //   $kdsa = $row['kdsa'];
  //   $data = [
  //     'title' => 'Detail WO',
  //     'faktur_bp' => $this->faktur_bpModel->find($id),
  //     'tbmobil' => $this->tbmobilModel->getnopolisi($nopolisi),
  //     'tbmerek' => $this->tbmerekModel->getNama(),
  //     'tbmodel' => $this->tbmodelModel->getMerek(),
  //     'tbtipe' => $this->tbtipeModel->getModel(),
  //     'tbwarna' => $this->tbwarnaModel->getNama(),
  //     'tbjenis' => $this->tbjenisModel->getNama(),
  //     'tbsa' => $this->tbsaModel->getkode($kdsa),
  //     'tbcustomer' => $this->tbcustomerModel->getkdcustomer($kdpemilik),
  //   ];
  //   var_dump($data);
  //   $msg = [
  //     'sukses' => view('close_faktur_bp/detail_faktur_bp', $data)
  //   ];
  //   echo json_encode($msg);
  // }

  public function formdetail()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->faktur_bpModel->find($id);
      $nopolisi = $row['nopolisi'];
      $kdpemilik = $row['kdpemilik'];
      $kdsa = $row['kdsa'];
      $data = [
        'title' => 'Detail Faktur Body Repair',
        'faktur_bp' => $this->faktur_bpModel->find($id),
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
        'sukses' => view('close_faktur_bp/modaldetail', $data)
      ];
      echo json_encode($msg);
    }
  }

  public function formtambah()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Tambah Data Close Faktur Body Repair',
        'wo_bp' => $this->wo_bpModel->findAll(),
      ];
      $msg = [
        'data' => view('close_faktur_bp/modaltambah', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function simpanclose_faktur_bp()
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
        $nofaktur = 'FB' . date('Y') . date('m') . sprintf("%05s", intval(substr('00000', -5)) + 1);
        $faktur = $this->faktur_bpModel->buatnofaktur();
        if (isset($faktur)) {
          foreach ($faktur as $row) {
            if ($row->nofaktur != NULL) {
              $nofaktur = 'FB' . date('Y') . date('m') . sprintf("%05s", intval(substr($row->nofaktur, -5)) + 1);
            }
          }
        }
        $session = session();
        $user = "Tambah-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        $simpandata = [
          'nofaktur' => $nofaktur, //$this->request->getVar('nofaktur'),
          'tanggal' => $this->request->getVar('tanggal'),
          'nowo' => $this->request->getVar('nowo'),
          'tglwo' => $this->request->getVar('tglwo'),
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
          'total_faktur' => $this->request->getVar('total_wo'),
          'user' => $user,
        ];
        // var_dump($simpandata);
        $this->faktur_bpModel->insert($simpandata);
        $nowo = $this->request->getVar('nowo');
        $row = $this->wojasa_bpModel->getnowo($nowo);
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
            'kdmekanik' => $k['kdmekanik'],
            'nmmekanik' => $k['nmmekanik'],
            'nofaktur' => $nofaktur,
            'user' => $user,
          ];
          $this->fakturjasa_bpModel->insert($simpandata);
        }
        $row = $this->wopart_bpModel->getnowo($nowo);
        foreach ($row as $kpart) {
          $simpandata = [
            'kode' => $kpart['kode'],
            'nama' => $kpart['nama'],
            'kerusakan' => $kpart['kerusakan'],
            'jenis' => $kpart['jenis'],
            'qty' => $kpart['qty'],
            'harga' => $kpart['harga'],
            'pr_discount' => $kpart['pr_discount'],
            'subtotal' => $kpart['subtotal'],
            'kdmekanik' => $kpart['kdmekanik'],
            'nmmekanik' => $kpart['nmmekanik'],
            'nofaktur' => $nofaktur,
            'user' => $user,
          ];
          $this->fakturpart_bpModel->insert($simpandata);
        }
        $row = $this->wobahan_bpModel->getnowo($nowo);
        foreach ($row as $kbahan) {
          $simpandata = [
            'kode' => $kbahan['kode'],
            'nama' => $kbahan['nama'],
            'kerusakan' => $kbahan['kerusakan'],
            'jenis' => $kbahan['jenis'],
            'qty' => $kbahan['qty'],
            'harga' => $kbahan['harga'],
            'pr_discount' => $kbahan['pr_discount'],
            'subtotal' => $kbahan['subtotal'],
            'kdmekanik' => $kbahan['kdmekanik'],
            'nmmekanik' => $kbahan['nmmekanik'],
            'nofaktur' => $nofaktur,
            'user' => $user,
          ];
          $this->fakturbahan_bpModel->insert($simpandata);
        }
        $row = $this->woopl_bpModel->getnowo($nowo);
        // var_dump($row);
        foreach ($row as $kopl) {
          $simpandata = [
            'kode' => $kopl['kode'],
            'nama' => $kopl['nama'],
            'kerusakan' => $kopl['kerusakan'],
            'jenis' => $kopl['jenis'],
            'qty' => $kopl['qty'],
            'harga' => $kopl['harga'],
            'pr_discount' => $kopl['pr_discount'],
            'subtotal' => $kopl['subtotal'],
            'kdmekanik' => $kopl['kdmekanik'],
            'nmmekanik' => $kopl['nmmekanik'],
            'nofaktur' => $nofaktur,
            'user' => $user,
          ];
          $this->fakturopl_bpModel->insert($simpandata);
        }
        $msg = [
          'sukses' => 'Data berhasil disimpan'
        ];
        session()->setFlashdata('pesan', 'Data berhasil ditambah');
        echo json_encode($msg);
      }
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function edit_close_faktur_bp()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->faktur_bpModel->find($id);
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
        'faktur_bp' => $this->faktur_bpModel->find($id),
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
        'sukses' => view('close_faktur_bp/editfaktur_bp', $data)
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function simpan_batal_faktur()
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
        $this->faktur_bpModel->update($id, $simpandata);
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

  public function caridatawo()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data WO',
        'wo_bp' => $this->wo_bpModel->where('close', '1')->where('close_faktur', '0')->orderBy('nowo', 'asc')->findAll() //$rwtkeluarga
      ];
      // var_dump($data);
      $msg = [
        'data' => view('close_faktur_bp/modalcariwo', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function replwo()
  {
    if ($this->request->isAjax()) {
      $nowo = $_POST['nowo'];
      $row = $this->wo_bpModel->getnowo($nowo);
      if (isset($row)) {
        foreach ($row as $k) {
          $data = [
            'title' => 'Detail data Kendaraan',
            'nowo' => $k['nowo'],
            'tglwo' => $k['tanggal'],
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
            'no_polis' => $k['no_polis'],
            'nama_polis' => $k['nama_polis'],
            'tgl_akhir_polis' => $k['tgl_akhir_polis'],
            'kode_asuransi' => $k['kode_asuransi'],
            'nama_asuransi' => $k['nama_asuransi'],
            'alamat_asuransi' => $k['alamat_asuransi'],
            'klaim' => $k['klaim'],
            'internal' => $k['internal'],
            'inventaris' => $k['inventaris'],
            'campaign' => $k['campaign'],
            'booking' => $k['booking'],
            'lain_lain' => $k['lain_lain'],
            'surveyor' => $k['surveyor'],
            'npwp' => $k['npwp'],
            'contact_person' => $k['contact_person'],
            'no_contact_person' => $k['no_contact_person'],
            'total_faktur' => $k['total_wo'],
          ];
        }
      } else {
        $data = [
          'title' => 'Detail data',
          'nowo' => '',
          'nopolisi' => '',
          'norangka' => '',
          'kdpemilik' => '',
          'nmpemilik' => '',
          'kdsa' => '',
          'keluhan' => '',
          'kdservice' => '',
          // 'nmservice' => $k['nmservice'],
          'km' => '',
          // 'kdpaket' => $k['kdpaket'],
          'aktifitas' => '',
          'fasilitas' => '',
          'status_tunggu' => '',
          'int_reminder' => '',
          'via' => '',
          'pr_ppn' => '',
          'no_polis' => '',
          'nama_polis' => '',
          'tgl_akhir_polis' => '',
          'kode_asuransi' => '',
          'nama_asuransi' => '',
          'alamat_asuransi' => '',
          'klaim' => '',
          'internal' => '',
          'inventaris' => '',
          'campaign' => '',
          'booking' => '',
          'lain_lain' => '',
          'surveyor' => '',
          'npwp' => '',
          'contact_person' => '',
          'no_contact_person' => '',
          'total_faktur' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function table_faktur_bp_part()
  {
    $nofaktur = $_POST['nofaktur'];
    $data = [
      'nofaktur' => $nofaktur,
      'title' => 'Faktur Part',
      'faktur_part' => $this->fakturpart_bpModel->getnofaktur($nofaktur)
    ];
    // dd($data);
    echo view('close_faktur_bp/tbl_faktur_part', $data);
  }

  public function table_faktur_bp_bahan()
  {
    $nofaktur = $_POST['nofaktur'];
    $data = [
      'nofaktur' => $nofaktur,
      'title' => 'WO Bahan',
      'wo_bahan' => $this->fakturbahan_bpModel->getnofaktur($nofaktur)
    ];
    // var_dump($data);
    echo view('close_faktur_bp/tbl_faktur_bahan', $data);
  }

  public function table_faktur_bp_opl()
  {
    $nofaktur = $_POST['nofaktur'];
    $data = [
      'nofaktur' => $nofaktur,
      'title' => 'WO OPL',
      'faktur_opl' => $this->fakturopl_bpModel->getnofaktur($nofaktur),
    ];
    // var_dump($data);
    echo view('close_faktur_bp/tbl_faktur_opl', $data);
  }

  public function table_faktur_bp_jasa()
  {
    $nofaktur = $_POST['nofaktur'];
    $data = [
      'nofaktur' => $nofaktur,
      'title' => 'WO Jasa',
      'faktur_bp' => $this->faktur_bpModel->getnofaktur($nofaktur),
      'faktur_jasa' => $this->fakturjasa_bpModel->getnofaktur($nofaktur),
    ];
    // var_dump($data);
    echo view('close_faktur_bp/tbl_faktur_jasa', $data);
  }

  public function summary_faktur_bp()
  {
    $nofaktur = $_POST['nofaktur'];
    $row = $this->faktur_bpModel->getnofaktur($nofaktur);
    // var_dump($nofaktur);
    foreach ($row as $k) {
      $nofaktur = $k['nofaktur'];
      $idfaktur = $k['id'];
      $pr_ppn = $k['pr_ppn'];
    }
    $jumpart = 0;
    $jumbahan = 0;
    $jumjasa = 0;
    $jumopl = 0;
    $jumjasa = $this->fakturjasa_bpModel->jumjasa($nofaktur);
    $jumpart = $this->fakturpart_bpModel->jumpart($nofaktur);
    $jumbahan = $this->fakturbahan_bpModel->jumbahan($nofaktur);
    $jumopl = $this->fakturopl_bpModel->jumopl($nofaktur);
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
    $total_faktur = $total + $ppn;
    $dataupdate = [
      'id' => $idfaktur,
      'total_jasa' => $jumjasa,
      'total_part' => $jumpart,
      'total_bahan' => $jumbahan,
      'total_opl' => $jumopl,
      'total' => $total,
      'dpp' => $total,
      'pr_ppn' => $pr_ppn,
      'ppn' => $ppn,
      'total_faktur' => $total_faktur
    ];
    $id = $idfaktur;
    $this->faktur_bpModel->update($id, $dataupdate);
    $data = [
      'title' => 'faktur Body Repair',
      'faktur_bp' => $this->faktur_bpModel->getnofaktur($nofaktur),
      'summary_part' => $this->fakturpart_bpModel->getnofaktur($nofaktur),
      'summary_jasa' => $this->fakturjasa_bpModel->getnofaktur($nofaktur),
      'summary_bahan' => $this->fakturbahan_bpModel->getnofaktur($nofaktur),
      'summary_opl' => $this->fakturopl_bpModel->getnofaktur($nofaktur),
    ];
    // var_dump($data);
    echo view('close_faktur_bp/summary_faktur', $data);
  }

  public function close_faktur_bp()
  {
    if ($this->request->isAjax()) {
      $session = session();
      $id = $_POST['id'];
      $row = $this->faktur_bpModel->find($id);
      $close = $row['close'];
      $nowo = $row['nowo'];
      if (!isset($close)) {
        $close = 0;
      }
      $row = $this->wo_bpModel->getnowo($nowo);
      foreach ($row as $data) {
        $close_wo = $data['close'];
      }
      if ($close_wo == 1) {
        $user = "Proses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        $simpandata = [
          'close' => 1,
          'user_close' => $user,
        ];
        // var_dump($simpandata);
        $this->faktur_bpModel->update($id, $simpandata);
        $rowwo = $this->wo_bpModel->getnowo($nowo);
        foreach ($rowwo as $data) {
          $idwo = $data['id'];
        };
        $simpandata = [
          'close_faktur' => 1,
        ];
        // var_dump($idwo);
        $this->wo_bpModel->update($idwo, $simpandata);
        $msg = [
          'sukses' => 'Data berhasil disimpan'
        ];
        session()->setFlashdata('pesan', 'Data berhasil diupdate');
      } else {
        $msg = [
          'sukses' => 'Data gagal disimpan'
        ];
        session()->setFlashdata('pesan', 'Data berhasil diupdate');
      }
      echo json_encode($msg);
    };
  }

  public function unclose_faktur_bp()
  {
    if ($this->request->isAjax()) {
      $session = session();
      $id = $_POST['id'];
      $row = $this->faktur_bpModel->find($id);
      $nowo = $row['nowo'];
      $user = "Unproses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      $simpandata = [
        'close' => 0,
        'user_close' => $user,
      ];
      $this->faktur_bpModel->update($id, $simpandata);
      $rowwo = $this->wo_bpModel->getnowo($nowo);
      foreach ($rowwo as $data) {
        $idwo = $data['id'];
      };
      $simpandata = [
        'close_faktur' => 0,
      ];
      // var_dump($idwo);
      $this->wo_bpModel->update($idwo, $simpandata);
      $msg = [
        'sukses' => 'Data berhasil disimpan'
      ];
      session()->setFlashdata('pesan', 'Data berhasil diupdate');
      echo json_encode($msg);
    };
  }

  public function cetakfaktur_bp($id)
  {
    $dompdf = new Dompdf();
    $row = $this->faktur_bpModel->find($id);
    $nofaktur = $row['nofaktur'];
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
      'title' => 'Cetak faktur',
      'faktur_bp' => $this->faktur_bpModel->find($id),
      'tbmobil' => $this->tbmobilModel->getnopolisi($nopolisi),
      'tbmerek' => $this->tbmerekModel->getkode($kdmerek),
      'tbmodel' => $this->tbmodelModel->getkode($kdmodel),
      'tbtipe' => $this->tbtipeModel->getkode($kdtipe),
      'tbwarna' => $this->tbwarnaModel->getkode($kdwarna),
      'tbjenis' => $this->tbjenisModel->getkode($kdjenis),
      'tbcustomer' => $this->tbcustomerModel->getkdcustomer($kdpemilik),
      'tbsa' => ($kdsa ? $this->tbsaModel->getkode($kdsa) : ''),
      'jasa' => $this->fakturjasa_bpModel->getnofaktur($nofaktur),
      'part' => $this->fakturpart_bpModel->getnofaktur($nofaktur),
      'bahan' => $this->fakturbahan_bpModel->getnofaktur($nofaktur),
      'opl' => $this->fakturopl_bpModel->getnofaktur($nofaktur),
    ];
    // var_dump($data);
    // $msg = [
    //   'sukses' => view('faktur_bp/cetakfaktur_bp', $data)
    // ];
    $html =  view('close_faktur_bp/cetakfaktur_bp', $data);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'Potrait');
    $dompdf->render();
    // $dompdf->stream(); //langsung download
    $dompdf->stream('faktur ' . $nofaktur . '.pdf', array("Attachment" => false));
    // var_dump($msg);
    // echo json_encode($msg);
    // } else {
    //   exit('Maaf tidak dapat diproses');
    // }
  }

  public function cancel_faktur_bp()
  {
    if ($this->request->isAjax()) {
      $session = session();
      $id = $_POST['id'];
      $row = $this->faktur_bpModel->find($id);
      $close = $row['close'];
      $nowo = $row['nowo'];
      if (!isset($close)) {
        $close = 0;
      }
      $row = $this->wo_bpModel->getnowo($nowo);
      foreach ($row as $data) {
        $close_wo = $data['close'];
      }
      if ($close_wo == 1) {
        $user = "Proses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        $simpandata = [
          'close' => 1,
          'user_close' => $user,
        ];
        // var_dump($simpandata);
        $this->faktur_bpModel->update($id, $simpandata);
        $rowwo = $this->wo_bpModel->getnowo($nowo);
        foreach ($rowwo as $data) {
          $idwo = $data['id'];
        };
        $simpandata = [
          'close_faktur' => 1,
        ];
        // var_dump($idwo);
        $this->wo_bpModel->update($idwo, $simpandata);
        $msg = [
          'sukses' => 'Data berhasil disimpan'
        ];
        session()->setFlashdata('pesan', 'Data berhasil diupdate');
      } else {
        $msg = [
          'sukses' => 'Data gagal disimpan'
        ];
        session()->setFlashdata('pesan', 'Data berhasil diupdate');
      }
      echo json_encode($msg);
    };
  }
}
