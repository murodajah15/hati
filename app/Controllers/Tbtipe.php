<?php

namespace App\Controllers;

use App\Models\TbtipeModel;
use App\Models\TbmodelModel;
use App\Models\TbmobilModel;
use App\Models\UserdtlModel;

class Tbtipe extends BaseController
{
  protected $tbtipeModel, $tbmodelModel, $userdtlModel, $model, $tbmobilModel;
  public function __construct()
  {
    $this->tbtipeModel = new TbtipeModel();
    $this->tbmodelModel = new TbmodelModel();
    $this->tbmobilModel = new TbmobilModel();
    $this->userdtlModel = new UserdtlModel();
  }

  public function index()
  {
    $session = session();
    $username = $session->get('email');
    $data = [
      'menu' => 'file',
      'submenu' => 'tbtipe',
      'title' => 'Tabel Tipe',
      'tbtipe' => $this->tbtipeModel->getid(),
      'userdtl' => $this->userdtlModel->getuserakses('tbtipe', $username),
      // 'Tbtipe' => $this->TbtipeModel->orderBy('kode')->findAll() //$Tbtipe
    ];
    // dd($data);
    echo view('tbtipe/index', $data);
  }

  public function formdetail()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->tbtipeModel->find($id);
      $data = [
        'title' => 'Detail data',
        'id' => $row['id'],
        // 'kode' => $row['kode'],
        // 'nama' => $row['nama'],
        // 'user' => $row['user'],
        // 'aktif' => $row['aktif'],
        'tbtipe' => $row,
        'tbmodel' => $this->tbmodelModel->findAll(),
      ];
      $msg = [
        'sukses' => view('Tbtipe/modaldetail', $data)
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function detail($id)
  {
    $data = [
      'title' => 'Detail Tabel Tipe',
      'Tbtipe' => $this->tbtipeModel->getid($id),
      'tbmodel' => $this->tbmodelModel->findAll(),
    ];
    if (empty($data['Tbtipe'])) {
      throw new \CodeIgniter\Exceptions\PageNotFoundException('Id Tipe' . $id . 'tidak ditemukan.');
    }
    return view('Tbtipe/modaldetail', $data);
  }

  public function create()
  {
    // session();
    $data = [
      'title' => 'Tambah Tabel Tipe',
      'validation' => \Config\Services::validation()
    ];
    return view('Tbtipe/formtambah', $data);
  }

  public function ajaxLoadData()
  {
    $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
    $katakunci = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
    $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
    $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';

    $this->model = new TbtipeModel();
    $data = $this->model->tampilData($katakunci, $start, $length);
    $jumlahData = $this->model->tampilData($katakunci);

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
      $session = session();
      $username = $session->get('email');
      $data = [
        'title' => 'Tambah Data',
        'tbmodel' => $this->tbmodelModel->where('aktif', 'Y')->findAll(),
        'userdtl' => $this->userdtlModel->getuserakses('tbtipe', $username),
      ];
      // var_dump($data);
      $msg = [
        'data' => view('tbtipe/modaltambah', $data),
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
        'kode' => [
          'label' => 'kode',
          'rules' => 'required|is_unique[Tbtipe.kode]',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'is_unique' => '{field} tidak boleh ada yang sama'
          ]
        ]
      ]);
      if (!$valid) {
        $msg = [
          'error' => [
            'kode' => $validation->getError('kode')
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
          'kode' => $this->request->getVar('kode'),
          'nama' => $this->request->getVar('nama'),
          'kdmodel' => $this->request->getVar('kdmodel'),
          'aktif' => $aktif, //$this->request->getVar('aktif'),
          'user' => $user,
        ];
        $this->tbtipeModel->insert($simpandata);
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
      $session = session();
      $username = $session->get('email');
      $id = $this->request->getVar('id');
      $row = $this->tbtipeModel->find($id);
      $data = [
        'title' => 'Edit Data',
        // 'id' => $row['id'],
        // 'kode' => $row['kode'],
        // 'nama' => $row['nama'],
        // 'aktif' => $row['aktif'],
        'tbtipe' => $row,
        'tbmodel' => $this->tbmodelModel->findAll(),
        'userdtl' => $this->userdtlModel->getuserakses('tbtipe', $username),
      ];
      $msg = [
        'sukses' => view('Tbtipe/modaledit', $data)
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
      $kodelama = $this->request->getVar('kodelama');
      $kode = $this->request->getVar('kode');
      if ($kode != $kodelama) {
        $valid = $this->validate([
          'kode' => [
            'label' => 'kode',
            'rules' => 'required|is_unique[Tbtipe.kode]',
            'errors' => [
              'required' => '{field} tidak boleh kosong',
              'is_unique' => '{field} tidak boleh ada yang sama'
            ]
          ]
        ]);
      } else {
        $valid = $this->validate([
          'kode' => [
            'label' => 'kode',
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
            'kode' => $validation->getError('kode')
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
          'kode' => $this->request->getVar('kode'),
          'nama' => $this->request->getVar('nama'),
          'kdmodel' => $this->request->getVar('kdmodel'),
          'aktif' => $aktif, //$this->request->getVar('aktif'),
          'user' => $user,
        ];
        $id = $this->request->getVar('id');
        $this->tbtipeModel->update($id, $simpandata);
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
    $rowtbtipe = $this->tbtipeModel->find($id);
    $rowtbmobil = $this->tbmobilModel->gettipe($rowtbtipe['kode']); //cari kode model di tabel tipe
    if ($rowtbmobil) {
      session()->setFlashdata('pesan', 'Data gagal dihapus, sudah terpakai di transaksi');
      echo json_encode(array("status" => FALSE));
    } else {
      $this->tbtipeModel->delete_by_id($id);
      session()->setFlashdata('pesan', 'Data berhasil dihapus');
      echo json_encode(array("status" => TRUE));
    }
  }

  public function table_tipe()
  {
    $model = new Tbtipemodel();
    $data['title'] = 'Tabel Tipe';
    $data['tbtipe'] = $model->getkode();
    // dd($data);
    echo view('tbtipe/tabel_tipe', $data);
  }
}
