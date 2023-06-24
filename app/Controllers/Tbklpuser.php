<?php

namespace App\Controllers;

use App\Models\TbklpuserModel;

class Tbklpuser extends BaseController
{
  protected $tbklpuserModel;
  public function __construct()
  {
    $this->tbklpuserModel = new TbklpuserModel();
  }

  public function index()
  {
    $data = [
      'menu' => 'utility',
      'submenu' => 'tbklpuser',
      'title' => 'Tabel Kelompok User',
      'tbklpuser' => $this->tbklpuserModel->orderBy('kelompok')->findAll() //$tbklpuser
    ];
    echo view('tbklpuser/index', $data);
  }

  public function formdetail()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->tbklpuserModel->find($id);
      $data = [
        'title' => 'Detail Data',
        'id' => $row['id'],
        'kelompok' => $row['kelompok'],
        'tbklpuser' => $row,
      ];
      $msg = [
        'sukses' => view('tbklpuser/modaldetail', $data)
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function detail($id)
  {
    $data = [
      'title' => 'Detail Tabel Kelompok User',
      'tbklpuser' => $this->tbklpuserModel->getid($id)
    ];
    if (empty($data['tbklpuser'])) {
      throw new \CodeIgniter\Exceptions\PageNotFoundException('Id klpuser' . $id . 'tidak ditemukan.');
    }
    return view('tbklpuser/modaldetail', $data);
  }

  public function create()
  {
    // session();
    $data = [
      'title' => 'Tambah Tabel Kelompok User',
      'validation' => \Config\Services::validation()
    ];
    return view('tbklpuser/formtambah', $data);
  }

  public function ajaxLoadData()
  {
    $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
    $katakunci = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
    $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
    $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';

    $tbklpuserModel = new TbklpuserModel();
    $data = $tbklpuserModel->tampilData($katakunci, $start, $length);
    $jumlahData = $tbklpuserModel->tampilData($katakunci);

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
        'data' => view('tbklpuser/modaltambah', $data),
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
      $session = session();
      $user = "Tambah-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      $valid = $this->validate([
        'kelompok' => [
          'label' => 'kelompok',
          'rules' => 'required|is_unique[tbklpuser.kelompok]',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'is_unique' => '{field} tidak boleh ada yang sama'
          ]
        ],
        // 'nama' => [
        //   'label' => 'nama',
        //   'rules' => 'required|is_unique[tbklpuser.nama]',
        //   'errors' => [
        //     'required' => '{field} tidak boleh kosong',
        //     'is_unique' => '{field} tidak boleh ada yang sama'
        //   ],
        // ]
      ]);
      if (!$valid) {
        $msg = [
          'error' => [
            'kelompok' => $validation->getError('kelompok'),
            // 'nama' => $validation->getError('nama')
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
          'kelompok' => $this->request->getVar('kelompok'),
          'user' => $user,
        ];
        $this->tbklpuserModel->insert($simpandata);
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
      $row = $this->tbklpuserModel->find($id);
      $data = [
        'title' => 'Edit Data',
        'id' => $row['id'],
        'kelompok' => $row['kelompok'],
        'tbklpuser' => $row,
      ];
      $msg = [
        'sukses' => view('tbklpuser/modaledit', $data)
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
      $kelompoklama = $this->request->getVar('kelompoklama');
      $kelompok = $this->request->getVar('kelompok');
      $session = session();
      $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      if ($kelompok != $kelompoklama) {
        $valid = $this->validate([
          'kelompok' => [
            'label' => 'kelompok',
            'rules' => 'required|is_unique[tbklpuser.kelompok]',
            'errors' => [
              'required' => '{field} tidak boleh kosong',
              'is_unique' => '{field} tidak boleh ada yang sama'
            ]
          ]
        ]);
      } else {
        $valid = $this->validate([
          'kelompok' => [
            'label' => 'kelompok',
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
            'kelompok' => $validation->getError('kelompok'),
            'user' => $user,
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
          'kelompok' => $this->request->getVar('kelompok'),
          'user' => $user,
        ];
        $id = $this->request->getVar('id');
        $this->tbklpuserModel->update($id, $simpandata);
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
    $this->tbklpuserModel->delete_by_id($id);
    session()->setFlashdata('pesan', 'Data berhasil dihapus');
    echo json_encode(array("status" => TRUE));
  }

  public function table_klpuser()
  {
    $model = new tbklpusermodel();
    $data['title'] = 'Tabel klpuser';
    $data['tbklpuser'] = $model->getkelompok();
    // dd($data);
    echo view('tbklpuser/tabel_klpuser', $data);
  }
}
