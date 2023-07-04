<?php

namespace App\Controllers;

use App\Models\TbagamaModel;
use App\Models\TbcustomerModel;

class Tbagama extends BaseController
{
  protected $tbagamaModel, $tbcustomerModel;
  public function __construct()
  {
    $this->tbagamaModel = new TbagamaModel();
    $this->tbcustomerModel = new TbcustomerModel();
  }

  public function index()
  {
    $data = [
      'menu' => 'file',
      'submenu' => 'tbagama',
      'submenu1' => 'ref_umum',
      'title' => 'Tabel Agama',
      'tbagama' => $this->tbagamaModel->orderBy('kode', 'desc')->findAll() //$tbagama
    ];
    echo view('tbagama/index', $data);
  }

  public function detail($id)
  {
    $data = [
      'title' => 'Detail tabel agama',
      'tbagama' => $this->tbagamaModel->getagama($id)
    ];
    if (empty($data['tbagama'])) {
      throw new \CodeIgniter\Exceptions\PageNotFoundException('Id agama' . $id . 'tidak ditemukan.');
    }
    return view('tbagama/detail', $data);
  }

  public function create()
  {
    // session();
    $data = [
      'title' => 'Tambah tabel agama',
      'validation' => \Config\Services::validation()
    ];
    return view('tbagama/create', $data);
  }

  public function ajaxLoadData()
  {
    $request = $this->request;
    // dd($request->getPost('order[0][column]'));
    $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
    $katakunci = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
    $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
    $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
    $data = $this->tbagamaModel->tampilData($request, $katakunci, $start, $length);
    $jumlahData = $this->tbagamaModel->tampilData($request, $katakunci);
    $output = array(
      "draw" => intval($param['draw']),
      "recordsTotal" => count($jumlahData),
      "recordsFiltered" => count($jumlahData),
      "data" => $data,
    );
    echo json_encode($output);
  }

  public function formdetail()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->tbagamaModel->find($id);
      $data = [
        'title' => 'Detail data',
        // 'id' => $row['id'],
        // 'kode' => $row['kode'],
        // 'nama' => $row['nama'],
        // 'user' => $row['user'],
        'tbagama' => $this->tbagamaModel->find($id),
      ];
      $msg = [
        'sukses' => view('tbagama/modaldetail', $data)
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function formtambah()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Tambah data'
      ];
      $msg = [
        'data' => view('tbagama/modaltambah', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function formtambahform()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Tambah data'
      ];
      $msg = [
        'data' => view('tbagama/formtambah', $data),
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
          'label' => 'Kode',
          'rules' => 'required|is_unique[tbagama.kode]',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'is_unique' => '{field} tidak boleh ada yang sama'
          ]
        ],
        'nama' => [
          'label' => 'Nama',
          'rules' => 'required|is_unique[tbagama.nama]',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'is_unique' => '{field} tidak boleh ada yang sama'
          ]
        ],
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
        $simpandata = [
          'kode' => $this->request->getVar('kode'),
          'nama' => $this->request->getVar('nama'),
          'user' => $user,
        ];
        $this->tbagamaModel->insert($simpandata);
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
      $row = $this->tbagamaModel->find($id);
      $data = [
        'title' => 'Edit data',
        // 'id' => $row['id'],
        // 'kode' => $row['kode'],
        // 'nama' => $row['nama'],
        'tbagama' => $this->tbagamaModel->find($id),
      ];
      $msg = [
        'sukses' => view('tbagama/modaledit', $data)
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function updatedata()
  {
    if ($this->request->isAjax()) {
      $session = session();
      $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      $simpandata = [
        'nama' => $this->request->getVar('nama'),
        'user' => $user,
      ];
      $id = $this->request->getVar('id');
      $this->tbagamaModel->update($id, $simpandata);
      $msg = [
        'sukses' => 'Data berhasil disimpan'
      ];
      session()->setFlashdata('pesan', 'Data berhasil diupdate');
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function hapus($id)
  {
    $rowtbagama = $this->tbagamaModel->find($id);
    $rowtbcustomer = $this->tbcustomerModel->getnamaagama($rowtbagama['nama']);
    if ($rowtbcustomer) {
      session()->setFlashdata('pesan', 'Data gagal dihapus, sudah terpakai di transaksi');
      echo json_encode(array("status" => FALSE));
    } else {
      $this->tbagamaModel->delete_by_id($id);
      session()->setFlashdata('pesan', 'Data berhasil dihapus');
      echo json_encode(array("status" => TRUE));
    }
  }

  public function table_agama()
  {
    $model = new tbagamamodel();
    $data['title'] = 'Tabel Agama';
    $data['tbagama'] = $model->getagama();
    echo view('tbagama/tabel_agama', $data);
  }
}
