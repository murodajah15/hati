<?php

namespace App\Controllers;

use App\Models\TbsatuanModel;
use App\Models\TbbarangModel;

class Tbsatuan extends BaseController
{
  protected $tbsatuanModel, $tbbarangModel;
  public function __construct()
  {
    $this->tbsatuanModel = new TbsatuanModel();
    $this->tbbarangModel = new TbbarangModel();
  }

  public function index()
  {
    $data = [
      'menu' => 'file',
      'submenu' => 'tbsatuan',
      'title' => 'Tabel Satuan',
      'tbsatuan' => $this->tbsatuanModel->orderBy('kode')->findAll() //$tbsatuan
    ];
    echo view('tbsatuan/index', $data);
  }

  public function formdetail()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->tbsatuanModel->find($id);
      $data = [
        'title' => 'Detail Data',
        'id' => $row['id'],
        // 'kode' => $row['kode'],
        // 'nama' => $row['nama'],
        // 'user' => $row['user'],
        // 'aktif' => $row['aktif'],
        'tbsatuan' => $row,
      ];
      $msg = [
        'sukses' => view('tbsatuan/modaldetail', $data)
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function detail($id)
  {
    $data = [
      'title' => 'Detail Tabel Satuan',
      'tbsatuan' => $this->tbsatuanModel->getid($id)
    ];
    if (empty($data['tbsatuan'])) {
      throw new \CodeIgniter\Exceptions\PageNotFoundException('Id satuan' . $id . 'tidak ditemukan.');
    }
    return view('tbsatuan/modaldetail', $data);
  }

  public function create()
  {
    // session();
    $data = [
      'title' => 'Tambah Data Tabel Satuan',
      'validation' => \Config\Services::validation()
    ];
    return view('tbsatuan/formtambah', $data);
  }

  public function ajaxLoadData()
  {
    $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
    $katakunci = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
    $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
    $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';

    $tbsatuanModel = new TbsatuanModel();
    $data = $tbsatuanModel->tampilData($katakunci, $start, $length);
    $jumlahData = $tbsatuanModel->tampilData($katakunci);

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
        'title' => 'Tambah Data'
      ];
      $msg = [
        'data' => view('tbsatuan/modaltambah', $data),
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
          'rules' => 'required|is_unique[tbsatuan.kode]',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'is_unique' => '{field} tidak boleh ada yang sama'
          ]
        ],
        'nama' => [
          'label' => 'nama',
          'rules' => 'required|is_unique[tbsatuan.nama]',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'is_unique' => '{field} tidak boleh ada yang sama'
          ],
        ]
      ]);
      if (!$valid) {
        $msg = [
          'error' => [
            'kode' => $validation->getError('kode'),
            'nama' => $validation->getError('nama')
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
        $this->tbsatuanModel->insert($simpandata);
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
      $row = $this->tbsatuanModel->find($id);
      $data = [
        'title' => 'Edit Data Tabel Satuan',
        // 'id' => $row['id'],
        // 'kode' => $row['kode'],
        // 'nama' => $row['nama'],
        // 'aktif' => $row['aktif'],
        'tbsatuan' => $row,
      ];
      $msg = [
        'sukses' => view('tbsatuan/modaledit', $data)
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
            'rules' => 'required|is_unique[tbsatuan.kode]',
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
        $this->tbsatuanModel->update($id, $simpandata);
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
    $rowtbsatuan = $this->tbsatuanModel->find($id);
    $rowtbbarang = $this->tbbarangModel->getkodesatuan($rowtbsatuan['kode']);
    if ($rowtbbarang) {
      session()->setFlashdata('pesan', 'Data gagal dihapus, sudah terpakai di transaksi');
      echo json_encode(array("status" => FALSE));
    } else {
      $this->tbsatuanModel->delete_by_id($id);
      session()->setFlashdata('pesan', 'Data berhasil dihapus');
      echo json_encode(array("status" => TRUE));
    }
  }

  public function table_satuan()
  {
    $model = new tbsatuanmodel();
    $data['title'] = 'Tabel Satuan';
    $data['tbsatuan'] = $model->getkode();
    // dd($data);
    echo view('tbsatuan/tabel_satuan', $data);
  }
}
