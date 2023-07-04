<?php

namespace App\Controllers;

use App\Models\TbmodelModel;
use App\Models\TbmerekModel;
use App\Models\TbtipeModel;

class Tbmodel extends BaseController
{
  protected $tbmodelModel, $tbmerekModel, $tbtipeModel;
  public function __construct()
  {
    $this->tbmodelModel = new TbmodelModel();
    $this->tbmerekModel = new TbmerekModel();
    $this->tbtipeModel = new TbtipeModel();
  }

  public function index()
  {
    $data = [
      'menu' => 'file',
      'submenu' => 'tbmodel',
      'submenu1' => 'ref_kendaraan',
      'title' => 'Tabel Model Kendaraan',
      // 'tbmodel' => $this->tbmodelModel->findAll(),
      'tbmodel' => $this->tbmodelModel->getid(),
    ];
    // dd($data);
    echo view('tbmodel/index', $data);
  }

  public function formdetail()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->tbmodelModel->find($id);
      $data = [
        'title' => 'Detail Data',
        'id' => $row['id'],
        // 'kode' => $row['kode'],
        // 'nama' => $row['nama'],
        // 'user' => $row['user'],
        // 'aktif' => $row['aktif'],
        'tbmodel' => $row,
        'tbmerek' => $this->tbmerekModel->findAll(),

      ];
      $msg = [
        'sukses' => view('tbmodel/modaldetail', $data)
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function detail($id)
  {
    $data = [
      'title' => 'Detail Tabel Model',
      'tbmodel' => $this->tbmodelModel->getid($id),
      'tbmerek' => $this->tbmerekModel->findAll(),
    ];
    if (empty($data['tbmodel'])) {
      throw new \CodeIgniter\Exceptions\PageNotFoundException('Id model' . $id . 'tidak ditemukan.');
    }
    return view('tbmodel/modaldetail', $data);
  }

  public function create()
  {
    // session();
    $data = [
      'title' => 'Tambah Tabel Model',
      'validation' => \Config\Services::validation(),
      'tbmerek' => $this->tbmerekModel->findAll(),
    ];
    return view('tbmodel/formtambah', $data);
  }

  public function ajaxLoadData()
  {
    $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
    $katakunci = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
    $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
    $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';

    $tbmodel = new TbmodelModel();
    $data = $tbmodel->tampilData($katakunci, $start, $length);
    $jumlahData = $tbmodel->tampilData($katakunci);

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
        'title' => 'Tambah Data',
        'tbmerek' => $this->tbmerekModel->where('aktif', 'Y')->findAll(),
      ];
      $msg = [
        'data' => view('tbmodel/modaltambah', $data),
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
          'rules' => 'required|is_unique[tbmodel.kode]',
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
          'kdmerek' => $this->request->getVar('kdmerek'),
          'aktif' => $aktif, //$this->request->getVar('aktif'),
          'user' => $user,
        ];
        $this->tbmodelModel->insert($simpandata);
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
      $row = $this->tbmodelModel->find($id);
      $data = [
        'title' => 'Edit Data',
        // 'id' => $row['id'],
        // 'kode' => $row['kode'],
        // 'nama' => $row['nama'],
        // 'aktif' => $row['aktif'],
        'tbmodel' => $row,
        'tbmerek' => $this->tbmerekModel->findAll(),
      ];
      $msg = [
        'sukses' => view('tbmodel/modaledit', $data)
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
            'rules' => 'required|is_unique[tbmodel.kode]',
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
          'kdmerek' => $this->request->getVar('kdmerek'),
          'aktif' => $aktif, //$this->request->getVar('aktif'),
          'user' => $user,
        ];
        $id = $this->request->getVar('id');
        $this->tbmodelModel->update($id, $simpandata);
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
    $rowtbmodel = $this->tbmodelModel->find($id);
    $rowtbtipe = $this->tbtipeModel->getmodel($rowtbmodel['kode']); //cari kode model di tabel tipe
    if ($rowtbtipe) {
      session()->setFlashdata('pesan', 'Data gagal dihapus, sudah terpakai di transaksi');
      echo json_encode(array("status" => FALSE));
    } else {
      $this->tbmodelModel->delete_by_id($id);
      session()->setFlashdata('pesan', 'Data berhasil dihapus');
      echo json_encode(array("status" => TRUE));
    }
  }

  public function table_model()
  {
    $model = new tbmodelmodel();
    $data['title'] = 'Tabel model';
    $data['tbmodel'] = $model->getkode();
    // dd($data);
    echo view('tbmodel/tabel_model', $data);
  }
}
