<?php

namespace App\Controllers;

use App\Models\TboplModel;
use App\Models\TbsupplierModel;
use App\Models\EstimasipartModel;


class Tbopl extends BaseController
{
  protected $tboplModel, $tbsupplierModel, $estimasipartModel;
  public function __construct()
  {
    $this->tboplModel = new TboplModel();
    $this->tbsupplierModel = new TbsupplierModel();
    $this->estimasipartModel = new EstimasipartModel();
  }

  public function index()
  {
    $data = [
      'menu' => 'file',
      'submenu' => 'tbopl',
      'title' => 'Tabel opl',
      'tbopl' => $this->tboplModel->orderBy('kode', 'desc')->findAll() //$tbopl
    ];
    echo view('tbopl/index', $data);
  }

  public function detail($id)
  {
    $data = [
      'title' => 'Detail Tabel OPL',
      'tbopl' => $this->tboplModel->getid($id)
    ];
    if (empty($data['tbopl'])) {
      throw new \CodeIgniter\Exceptions\PageNotFoundException('Id opl' . $id . 'tidak ditemukan.');
    }
    return view('tbopl/detail', $data);
  }

  public function create()
  {
    // session();
    $data = [
      'title' => 'Tambah Tabel opl',
      'validation' => \Config\Services::validation()
    ];
    return view('tbopl/create', $data);
  }

  public function ajaxLoadData()
  {
    $request = $this->request;
    // dd($request->getPost('order[0][column]'));
    $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
    $katakunci = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
    $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
    $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
    $data = $this->tboplModel->tampilData($request, $katakunci, $start, $length);
    $jumlahData = $this->tboplModel->tampilData($request, $katakunci);
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
      $row = $this->tboplModel->find($id);
      $kdsupplier = $row['kdsupplier'];
      if (!isset($kdsupplier)) {
        $kdsupplier = "";
      }
      $data = [
        'title' => 'Detail Data OPL',
        // 'id' => $row['id'],
        // 'kode' => $row['kode'],
        // 'nama' => $row['nama'],
        'tbsupplier' => ($kdsupplier ? $this->tbsupplierModel->getkode($kdsupplier) : ''),
        'tbopl' => $this->tboplModel->find($id),
      ];
      $msg = [
        'sukses' => view('tbopl/modaldetail', $data)
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
        'menu' => 'file',
        'submenu' => 'tbopl',
        'title' => 'Tambah Data OPL',
        // 'tbjnbrg' => $this->tbjnbrgModel->getid()
      ];
      // dd($data);
      $msg = [
        'data' => view('tbopl/modaltambah', $data),
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
          'rules' => 'required|is_unique[tbopl.kode]',
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
          'harga_beli' => $this->request->getVar('harga_beli'),
          'harga_jual' => $this->request->getVar('harga_jual'),
          'kdsupplier' => $this->request->getVar('kdsupplier'),
          'user' => $user,
          'aktif' => $aktif,

        ];
        $this->tboplModel->insert($simpandata);
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
      $row = $this->tboplModel->find($id);
      $kdsupplier = $row['kdsupplier'];
      if (!isset($kdsupplier)) {
        $kdsupplier = "";
      }
      $data = [
        'title' => 'Edit Data OPL',
        // 'id' => $row['id'],
        // 'kode' => $row['kode'],
        // 'nama' => $row['nama'],
        'tbsupplier' => ($kdsupplier ? $this->tbsupplierModel->getkode($kdsupplier) : ''),
        'tbopl' => $this->tboplModel->find($id),
      ];
      $msg = [
        'sukses' => view('tbopl/modaledit', $data)
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
      if ($kode !== $kodelama) {
        $valid = $this->validate([
          'kode' => [
            'label' => 'kode',
            'rules' => 'required|is_unique[tbopl.kode]',
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
          'kdsupplier' => $this->request->getVar('kdsupplier'),
          'harga_beli' => $this->request->getVar('harga_beli'),
          'harga_jual' => $this->request->getVar('harga_jual'),
          'user' => $user,
          'aktif' => $aktif,
        ];
        $id = $this->request->getVar('id');
        $this->tboplModel->update($id, $simpandata);
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
    $rowtbopl = $this->tboplModel->find($id);
    $rowestimasidetail = $this->estimasipartModel->getkode($rowtbopl['kode']);
    if ($rowestimasidetail) {
      session()->setFlashdata('pesan', 'Data gagal dihapus, sudah terpakai di transaksi');
      echo json_encode(array("status" => FALSE));
    } else {
      $this->tboplModel->delete_by_id($id);
      session()->setFlashdata('pesan', 'Data berhasil dihapus');
      echo json_encode(array("status" => TRUE));
    }
  }

  public function table_opl()
  {
    $model = new tboplmodel();
    $data['title'] = 'Tabel opl';
    $data['tbopl'] = $model->getid();
    echo view('tbopl/tabel_opl', $data);
  }

  public function tambahtbsupplier()
  {
    if ($this->request->isAjax()) {
      $data = [
        'menu' => 'file',
        'submenu' => 'tbsupplier',
        'title' => 'Tambah Data Tabel Supplier',
        // 'tbjnbrg' => $this->tbjnbrgModel->getid()
      ];
      // dd($data);
      $msg = [
        'data' => view('tbopl/tambahtbsupplier', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function caridatasupplier()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data Supplier',
        'tbsupplier' => $this->tbsupplierModel->where('aktif', 'Y')->orderBy('kode', 'asc')->findAll() //$rwtkeluarga
      ];
      $msg = [
        'data' => view('tbopl/modalcarisupplier', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
  public function replsupplier()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['kdsupplier'];
      $row = $this->tbsupplierModel->getkode($kode);
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
}
