<?php

namespace App\Controllers;

use App\Models\TbmobilModel;
use App\Models\TbmerekModel;
use App\Models\TbmodelModel;
use App\Models\TbtipeModel;
use App\Models\TbwarnaModel;
use App\Models\TbjenisModel;
use App\Models\TbcustomerModel;
use App\Models\EstimasiModel;
use App\Models\WoModel;
use App\Models\TbasuransiModel;

class tbmobil extends BaseController
{
  protected $tbmobilModel, $tbmerekModel, $tbmodelModel, $tbtipeModel, $tbwarnaModel, $tbjenisModel, $tbcustomerModel, $model, $estimasiModel,
    $woModel, $tbasuransiModel;
  public function __construct()
  {
    $this->tbmobilModel = new TbmobilModel();
    $this->tbmerekModel = new TbmerekModel();
    $this->tbmodelModel = new TbmodelModel();
    $this->tbtipeModel = new TbtipeModel();
    $this->tbwarnaModel = new TbwarnaModel();
    $this->tbjenisModel = new TbjenisModel();
    $this->tbcustomerModel = new TbcustomerModel();
    $this->estimasiModel = new EstimasiModel();
    $this->woModel = new WoModel();
    $this->tbasuransiModel = new TbasuransiModel();
  }

  public function index()
  {
    $data = [
      'menu' => 'file',
      'submenu' => 'tbmobil',
      'submenu1' => 'ref_kendaraan',
      'title' => 'Tabel Kendaraan',
      'tbmobil' => $this->tbmobilModel->orderBy('nopolisi')->findAll() //$tbmobil
    ];
    echo view('tbmobil/index', $data);
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

  public function detail($id)
  {
    $data = [
      'title' => 'Detail Tabel Mobil',
      'tbmobil' => $this->tbmobilModel->getid($id)
    ];
    if (empty($data['tbmobil'])) {
      throw new \CodeIgniter\Exceptions\PageNotFoundException('Id mobil' . $id . 'tidak ditemukan.');
    }
    return view('tbmobil/modaldetail', $data);
  }

  public function create()
  {
    $data = [
      'title' => 'Tambah Tabel Mobil',
      'validation' => \Config\Services::validation()
    ];
    return view('tbmobil/formtambah', $data);
  }

  public function ajaxLoadData()
  {
    $request = $this->request;
    $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
    $katakunci = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
    $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
    $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
    $this->model = new tbmobilModel();
    $data = $this->model->tampilData($request, $katakunci, $start, $length);
    $jumlahData = $this->model->tampilData($request, $katakunci);

    $output = array(
      "draw" => intval($param['draw']),
      "recordsTotal" => count($jumlahData),
      "recordsFiltered" => count($jumlahData),
      "data" => $data,
    );

    echo json_encode($output);
  }

  public function formtambah()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Tambah Data Kendaraan',
        'tbmerek' => $this->tbmerekModel->getNama(),
        'tbmodel' => $this->tbmodelModel->getMerek(),
        'tbtipe' => $this->tbtipeModel->getModel(),
        'tbwarna' => $this->tbwarnaModel->getNama(),
        'tbjenis' => $this->tbjenisModel->getNama(),
      ];
      $msg = [
        'data' => view('tbmobil/modaltambah', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function simpandata()
  {
    if ($this->request->isAjax()) {
      $validation = \Config\Services::validation();
      $valid = $this->validate([
        'nopolisi' => [
          'label' => 'nopolisi',
          'rules' => 'required|is_unique[tbmobil.nopolisi]',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'is_unique' => '{field} tidak boleh ada yang sama'
          ]
        ]
      ]);
      if (!$valid) {
        $msg = [
          'error' => [
            'nopolisi' => $validation->getError('nopolisi')
          ]
        ];
        echo json_encode($msg);
      } else {
        $session = session();
        $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        if ($this->request->getVar('aktif') == 'on') {
          $aktif = 'Y';
        } else {
          $aktif = 'N';
        }
        $simpandata = [
          'nopolisi' => $this->request->getVar('nopolisi'),
          'norangka' => $this->request->getVar('norangka'),
          'nomesin' => $this->request->getVar('nomesin'),
          'kdmerek' => $this->request->getVar('kdmerek'),
          'kdmodel' => $this->request->getVar('kdmodel'),
          'kdtipe' => $this->request->getVar('kdtipe'),
          'kdwarna' => $this->request->getVar('kdwarna'),
          'kdjenis' => $this->request->getVar('kdjenis'),
          'nostnk' => $this->request->getVar('nostnk'),
          'tglstnk' => $this->request->getVar('tglstnk'),
          'bahanbakar' => $this->request->getVar('bahanbakar'),
          'dealerjual' => $this->request->getVar('dealerjual'),
          'kdpemilik' => $this->request->getVar('kdpemilik'),
          'nmpemilik' => $this->request->getVar('nmpemilik'),
          'npwp' => $this->request->getVar('npwp'),
          'contact_person' => $this->request->getVar('contact_person'),
          'no_contact_person' => $this->request->getVar('no_contact_person'),
          'kdpemakai' => $this->request->getVar('kdpemakai'),
          'nmpemakai' => $this->request->getVar('nmpemakai'),
          'kode_asuransi' => $this->request->getVar('kode_asuransi'),
          'nama_asuransi' => $this->request->getVar('nama_asuransi'),
          'alamat_asuransi' => $this->request->getVar('alamat_asuransi'),
          'user' => $user,
        ];
        $this->tbmobilModel->insert($simpandata);
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

  public function formedit()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->tbmobilModel->find($id);
      $data = [
        'title' => 'Edit Data Kendaraan',
        // 'id' => $row['id'],
        // 'nopolisi' => $row['nopolisi'],
        // 'nama' => $row['nama'],
        // 'aktif' => $row['aktif'],
        'tbmobil' => $row,
        'tbmerek' => $this->tbmerekModel->getNama(),
        'tbmodel' => $this->tbmodelModel->getMerek(),
        'tbtipe' => $this->tbtipeModel->getModel(),
        'tbwarna' => $this->tbwarnaModel->getNama(),
        'tbjenis' => $this->tbjenisModel->getNama(),
      ];
      $msg = [
        'sukses' => view('tbmobil/modaledit', $data)
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function updatedata()
  {
    if ($this->request->isAjax()) {
      $validation = \Config\Services::validation();
      $nopolisilama = $this->request->getVar('nopolisilama');
      $nopolisi = $this->request->getVar('nopolisi');
      if ($nopolisi != $nopolisilama) {
        $valid = $this->validate([
          'nopolisi' => [
            'label' => 'nopolisi',
            'rules' => 'required|is_unique[tbmobil.nopolisi]',
            'errors' => [
              'required' => '{field} tidak boleh kosong',
              'is_unique' => '{field} tidak boleh ada yang sama'
            ]
          ]
        ]);
      } else {
        $valid = $this->validate([
          'nopolisi' => [
            'label' => 'nopolisi',
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
            'nopolisi' => $validation->getError('nopolisi')
          ]
        ];
        echo json_encode($msg);
      } else {
        $session = session();
        $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        if ($this->request->getVar('aktif') == 'on') {
          $aktif = 'Y';
        } else {
          $aktif = 'N';
        }
        $simpandata = [
          'nopolisi' => $this->request->getVar('nopolisi'),
          'norangka' => $this->request->getVar('norangka'),
          'nomesin' => $this->request->getVar('nomesin'),
          'kdmerek' => $this->request->getVar('kdmerek'),
          'kdmodel' => $this->request->getVar('kdmodel'),
          'kdtipe' => $this->request->getVar('kdtipe'),
          'kdwarna' => $this->request->getVar('kdwarna'),
          'kdjenis' => $this->request->getVar('kdjenis'),
          'nostnk' => $this->request->getVar('nostnk'),
          'tglstnk' => $this->request->getVar('tglstnk'),
          'bahanbakar' => $this->request->getVar('bahanbakar'),
          'dealerjual' => $this->request->getVar('dealerjual'),
          'kdpemilik' => $this->request->getVar('kdpemilik'),
          'nmpemilik' => $this->request->getVar('nmpemilik'),
          'npwp' => $this->request->getVar('npwp'),
          'contact_person' => $this->request->getVar('contact_person'),
          'no_contact_person' => $this->request->getVar('no_contact_person'),
          'kdpemakai' => $this->request->getVar('kdpemakai'),
          'nmpemakai' => $this->request->getVar('nmpemakai'),
          'kode_asuransi' => $this->request->getVar('kode_asuransi'),
          'nama_asuransi' => $this->request->getVar('nama_asuransi'),
          'alamat_asuransi' => $this->request->getVar('alamat_asuransi'),
          'user' => $user,
        ];
        $id = $this->request->getVar('id');
        $this->tbmobilModel->update($id, $simpandata);
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

  public function hapus($id)
  {
    $data = $this->tbmobilModel->find($id);
    $nopolisi = $data['nopolisi'];
    $estimasi = $this->estimasiModel->getnopolisi($nopolisi);
    $wo = $this->woModel->getnopolisi($nopolisi);
    // var_dump($estimasi);
    if ($estimasi or $wo) {
      session()->setFlashdata('pesan', 'Data gagal dihapus, kendaraan tersebut sudah ada ditransaksi!');
      echo json_encode(array("status" => FALSE));
    } else {
      $this->tbmobilModel->delete_by_id($id);
      session()->setFlashdata('pesan', 'Data berhasil dihapus');
      echo json_encode(array("status" => TRUE));
    }
  }

  public function table_mobil()
  {
    $model = new tbmobilmodel();
    $data['title'] = 'Tabel mobil';
    $data['tbmobil'] = $model->getnopolisi();
    // dd($data);
    echo view('tbmobil/tabel_mobil', $data);
  }

  public function filter_merek()
  {
    $kdmerek = $_GET['id'];
    if ($kdmerek == "") {
      $data = $this->tbmodelModel->getmerek();
    } else {
      $data = $this->tbmodelModel->getmerek($kdmerek);
    }
    // var_dump($data);
    // echo json_encode($data);
    $data1 = '
    <select id="kdmodel">
      <option value="">[Pilih Model]</option>';
    foreach ($data as $model) {
      $data1 = $data1 . "<option value=$model->kode> $model->kode - $model->nama</option>";
    }
    $data1 = $data1 . "</select>";
    echo $data1;
  }

  public function filter_model()
  {
    $kdmodel = $_GET['id'];
    $data = $this->tbtipeModel->getmodel($kdmodel);
    // var_dump($data);
    // echo json_encode($data);
    $data1 = '
    <select id="kdmodel">
      <option value="">[Pilih Tipe]</option>';
    foreach ($data as $tipe) {
      $data1 = $data1 . "<option value=$tipe->kode> $tipe->kode - $tipe->nama</option>";
    }
    $data1 = $data1 . "</select>";
    echo $data1;
  }

  public function cari_data_pemakai()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data Pemakai',
        'tbcustomer' => $this->tbcustomerModel->orderBy('kode', 'desc')->findAll() //$rwtkeluarga
      ];
      $msg = [
        'data' => view('tbmobil/modalcari_pemakai', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function repl_pemakai()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['kode_pemakai'];
      $row = $this->tbcustomerModel->getkdcustomer($kode);
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

  public function cari_data_pemilik()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data pemilik',
        'tbcustomer' => $this->tbcustomerModel->orderBy('kode', 'desc')->findAll() //$rwtkeluarga
      ];
      $msg = [
        'data' => view('tbmobil/modalcari_pemilik', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function repl_pemilik()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['kode_pemilik'];
      $row = $this->tbcustomerModel->getkdcustomer($kode);
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

  public function cari_data_asuransi()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data Asuransi',
        'tbasuransi' => $this->tbasuransiModel->orderBy('kode', 'asc')->findAll(),
      ];
      $msg = [
        'data' => view('tbmobil/modalcariasuransi', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function repl_asuransi()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['kode'];
      $row = $this->tbasuransiModel->getkode($kode);
      if (isset($row)) {
        $data = [
          'title' => 'Detail data',
          'kode' => $row['kode'],
          'nama' => $row['nama'],
          'alamat' => $row['alamat'] . ' ' . $row['kota'],
        ];
      } else {
        $data = [
          'title' => 'Detail data',
          'kode' => '',
          'nama' => '',
          'alamat' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
}
