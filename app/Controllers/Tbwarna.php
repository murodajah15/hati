<?php

namespace App\Controllers;

use App\Models\TbwarnaModel;
use App\Models\UserdtlModel;
use App\Models\TbmobilModel;

class Tbwarna extends BaseController
{
  protected $tbwarnaModel, $tbmodelModel, $userdtlModel, $tbmobilModel;
  public function __construct()
  {
    $this->tbwarnaModel = new TbwarnaModel();
    $this->userdtlModel = new UserdtlModel();
    $this->tbmobilModel = new TbmobilModel();
  }

  public function index()
  {
    $session = session();
    $username = $session->get('email');
    $data = [
      'menu' => 'file',
      'submenu' => 'tbwarna',
      'title' => 'Tabel Warna Kendaraan',
      'tbwarna' => $this->tbwarnaModel->getid(),
      'userdtl' => $this->userdtlModel->getuserakses('tbwarna', $username),
      // 'Tbwarna' => $this->tbwarnaModel->orderBy('kode')->findAll() //$Tbwarna
    ];
    // dd($data);
    echo view('tbwarna/index', $data);
  }

  public function formdetail()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->tbwarnaModel->find($id);
      $data = [
        'title' => 'Detail Data',
        'id' => $row['id'],
        'tbwarna' => $row,
      ];
      $msg = [
        'sukses' => view('Tbwarna/modaldetail', $data)
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function detail($id)
  {
    $data = [
      'title' => 'Detail Tabel Warna',
      'Tbwarna' => $this->tbwarnaModel->getid($id),
    ];
    if (empty($data['Tbwarna'])) {
      throw new \CodeIgniter\Exceptions\PageNotFoundException('Id warna' . $id . 'tidak ditemukan.');
    }
    return view('Tbwarna/modaldetail', $data);
  }

  public function create()
  {
    // session();
    $data = [
      'title' => 'Tambah Tabel Warna',
      'validation' => \Config\Services::validation()
    ];
    return view('Tbwarna/formtambah', $data);
  }

  public function ajaxLoadData()
  {
    $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
    $katakunci = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
    $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
    $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';

    $Tbwarna = new tbwarnaModel();
    $data = $Tbwarna->tampilData($katakunci, $start, $length);
    $jumlahData = $Tbwarna->tampilData($katakunci);

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
        'userdtl' => $this->userdtlModel->getuserakses('tbwarna', $username),
      ];
      // var_dump($data);
      $msg = [
        'data' => view('tbwarna/modaltambah', $data),
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
          'rules' => 'required|is_unique[Tbwarna.kode]',
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
          'aktif' => $aktif, //$this->request->getVar('aktif'),
          'user' => $user,
        ];
        $this->tbwarnaModel->insert($simpandata);
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
      $row = $this->tbwarnaModel->find($id);
      $data = [
        'title' => 'Edit Data',
        // 'id' => $row['id'],
        // 'kode' => $row['kode'],
        // 'nama' => $row['nama'],
        // 'aktif' => $row['aktif'],
        'tbwarna' => $row,
        'userdtl' => $this->userdtlModel->getuserakses('tbwarna', $username),
      ];
      $msg = [
        'sukses' => view('Tbwarna/modaledit', $data)
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
            'rules' => 'required|is_unique[Tbwarna.kode]',
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
          'aktif' => $aktif, //$this->request->getVar('aktif'),
          'user' => $user,
        ];
        $id = $this->request->getVar('id');
        $this->tbwarnaModel->update($id, $simpandata);
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
    $rowtbwarna = $this->tbwarnaModel->find($id);
    $rowtbmobil = $this->tbmobilModel->getwarna($rowtbwarna['kode']); //cari kode model di tabel tipe
    if ($rowtbmobil) {
      session()->setFlashdata('pesan', 'Data gagal dihapus, sudah terpakai di transaksi');
      echo json_encode(array("status" => FALSE));
    } else {
      $this->tbwarnaModel->delete_by_id($id);
      session()->setFlashdata('pesan', 'Data berhasil dihapus');
      echo json_encode(array("status" => TRUE));
    }
  }

  public function table_warna()
  {
    $model = new tbwarnaModel();
    $data['title'] = 'Tabel warna';
    $data['tbwarna'] = $model->getkode();
    // dd($data);
    echo view('tbwarna/tabel_warna', $data);
  }
}
