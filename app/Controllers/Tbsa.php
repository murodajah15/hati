<?php

namespace App\Controllers;

use App\Models\TbsaModel;
use App\Models\TbcustomerModel;
use App\Models\EstimasiModel;

class Tbsa extends BaseController
{
  protected $tbsaModel, $tbcustomerModel, $estimasiModel;
  public function __construct()
  {
    $this->tbsaModel = new TbsaModel();
    $this->tbcustomerModel = new TbcustomerModel();
    $this->estimasiModel = new EstimasiModel();
  }

  public function index()
  {
    $data = [
      'menu' => 'file',
      'submenu' => 'tbsa',
      'submenu1' => 'ref_bengkel',
      'title' => 'Tabel SA',
      'tbsa' => $this->tbsaModel->orderBy('kdsa', 'desc')->findAll() //$tbsa
    ];
    echo view('tbsa/index', $data);
  }

  public function detail($id)
  {
    $data = [
      'title' => 'Detail Tabel SA',
      'tbsa' => $this->tbsaModel->getsa($id)
    ];
    if (empty($data['tbsa'])) {
      throw new \CodeIgniter\Exceptions\PageNotFoundException('Id sa' . $id . 'tidak ditemukan.');
    }
    return view('tbsa/detail', $data);
  }

  public function create()
  {
    // session();
    $data = [
      'title' => 'Tambah Tabel SA',
      'validation' => \Config\Services::validation()
    ];
    return view('tbsa/create', $data);
  }

  public function ajaxLoadData()
  {
    $request = $this->request;
    // dd($request->getPost('order[0][column]'));
    $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
    $katakunci = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
    $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
    $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
    $data = $this->tbsaModel->tampilData($request, $katakunci, $start, $length);
    $jumlahData = $this->tbsaModel->tampilData($request, $katakunci);
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
      $row = $this->tbsaModel->find($id);
      $data = [
        'title' => 'Detail data',
        // 'id' => $row['id'],
        // 'kdsa' => $row['kdsa'],
        // 'nama' => $row['nama'],
        // 'user' => $row['user'],
        'tbsa' => $this->tbsaModel->find($id),
      ];
      $msg = [
        'sukses' => view('tbsa/modaldetail', $data)
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
        'data' => view('tbsa/modaltambah', $data),
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
        'data' => view('tbsa/formtambah', $data),
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
        'kdsa' => [
          'label' => 'kdsa',
          'rules' => 'required|is_unique[tbsa.kdsa]',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'is_unique' => '{field} tidak boleh ada yang sama1'
          ]
        ],
        'nama' => [
          'label' => 'Nama',
          'rules' => 'required|is_unique[tbsa.nama]',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'is_unique' => '{field} tidak boleh ada yang sama'
          ]
        ],
      ]);
      if (!$valid) {
        $msg = [
          'error' => [
            'kdsa' => $validation->getError('kdsa'),
            'nama' => $validation->getError('nama')
          ]
        ];
        echo json_encode($msg);
      } else {
        if ($this->request->getVar('aktif') == 'on') {
          $aktif = 'Y';
        } else {
          $aktif = 'N';
        }
        $session = session();
        $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        $simpandata = [
          'kdsa' => $this->request->getVar('kdsa'),
          'nama' => $this->request->getVar('nama'),
          'alamat' => $this->request->getVar('alamat'),
          'kelurahan' => $this->request->getVar('kelurahan'),
          'kecamatan' => $this->request->getVar('kecamatan'),
          'kota' => $this->request->getVar('kota'),
          'kodepos' => $this->request->getVar('kodepos'),
          'nohp' => $this->request->getVar('nohp'),
          'aktif' => $aktif,
          'user' => $user,
        ];
        $this->tbsaModel->insert($simpandata);
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
      $row = $this->tbsaModel->find($id);
      $data = [
        'title' => 'Edit data',
        // 'id' => $row['id'],
        // 'kdsa' => $row['kdsa'],
        // 'nama' => $row['nama'],
        'tbsa' => $this->tbsaModel->find($id),
      ];
      $msg = [
        'sukses' => view('tbsa/modaledit', $data)
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
      if ($this->request->getVar('aktif') == 'on') {
        $aktif = 'Y';
      } else {
        $aktif = 'N';
      }
      $simpandata = [
        'kdsa' => $this->request->getVar('kdsa'),
        'nama' => $this->request->getVar('nama'),
        'alamat' => $this->request->getVar('alamat'),
        'kelurahan' => $this->request->getVar('kelurahan'),
        'kecamatan' => $this->request->getVar('kecamatan'),
        'kota' => $this->request->getVar('kota'),
        'kodepos' => $this->request->getVar('kodepos'),
        'nohp' => $this->request->getVar('nohp'),
        'aktif' => $aktif,
        'user' => $user,
      ];
      $id = $this->request->getVar('id');
      $this->tbsaModel->update($id, $simpandata);
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
    $rowtbsa = $this->tbsaModel->find($id);
    $rowestimasi = $this->estimasiModel->getsa($rowtbsa['kdsa']);
    if ($rowestimasi) {
      session()->setFlashdata('pesan', 'Data gagal dihapus, sudah terpakai di transaksi');
      echo json_encode(array("status" => FALSE));
    } else {
      $this->tbsaModel->delete_by_id($id);
      session()->setFlashdata('pesan', 'Data berhasil dihapus');
      echo json_encode(array("status" => TRUE));
    }
  }

  public function table_sa()
  {
    $model = new tbsamodel();
    $data['title'] = 'Tabel SA';
    $data['tbsa'] = $model->getsa();
    echo view('tbsa/tabel_sa', $data);
  }
}
