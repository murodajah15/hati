<?php

namespace App\Controllers;

use App\Models\TbsalesModel;
use App\Models\MemombrModel;
use App\Models\Tbstatus_salesModel;

class Tbsales extends BaseController
{
  protected $tbsalesModel, $memombrModel, $tbstatus_salesModel;
  public function __construct()
  {
    $this->tbsalesModel = new TbsalesModel();
    $this->memombrModel = new MemombrModel();
    $this->tbstatus_salesModel = new Tbstatus_salesModel();
  }

  public function index()
  {
    $data = [
      'menu' => 'file',
      'submenu' => 'tbsales',
      'submenu1' => 'ref_umum',
      'title' => 'Tabel Sales',
      'tbsales' => $this->tbsalesModel->orderBy('kode', 'desc')->findAll() //$tbsa
    ];
    echo view('tbsales/index', $data);
  }

  public function detail($id)
  {
    $data = [
      'title' => 'Detail Tabel Sales',
      'tbsales' => $this->tbsalesModel->getsales($id)
    ];
    if (empty($data['tbsales'])) {
      throw new \CodeIgniter\Exceptions\PageNotFoundException('Id sa' . $id . 'tidak ditemukan.');
    }
    return view('tbsales/detail', $data);
  }

  public function create()
  {
    // session();
    $data = [
      'title' => 'Tambah Tabel Sales',
      'tbsales' => $this->tbsalesModel->orderBy('kode', 'desc')->findAll(),
      'validation' => \Config\Services::validation()
    ];
    return view('tbsales/create', $data);
  }

  public function ajaxLoadData()
  {
    $request = $this->request;
    // dd($request->getPost('order[0][column]'));
    $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
    $katakunci = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
    $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
    $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
    $data = $this->tbsalesModel->tampilData($request, $katakunci, $start, $length);
    $jumlahData = $this->tbsalesModel->tampilData($request, $katakunci);
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
      $row = $this->tbsalesModel->find($id);
      $data = [
        'title' => 'Detail Data Sales',
        // 'id' => $row['id'],
        // 'kdsa' => $row['kdsa'],
        // 'nama' => $row['nama'],
        // 'user' => $row['user'],
        'tbsales' => $this->tbsalesModel->find($id),
        'tbsaleslist' => $this->tbsalesModel->findAll(),
        'tbstatus_sales' => $this->tbstatus_salesModel->findAll(),
      ];
      $msg = [
        'sukses' => view('tbsales/modaldetail', $data)
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
        'title' => 'Tambah Data Sales',
        'tbsales' => $this->tbsalesModel->orderBy('kode', 'desc')->findAll(),
        'tbstatus_sales' => $this->tbstatus_salesModel->orderBy('status', 'asc')->findAll()
      ];
      $msg = [
        'data' => view('tbsales/modaltambah', $data),
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
        'title' => 'Tambah Data Sales'
      ];
      $msg = [
        'data' => view('tbsales/formtambah', $data),
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
          'rules' => 'required|is_unique[tbsales.kode]',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'is_unique' => '{field} tidak boleh ada yang sama1'
          ]
        ],
        'nama' => [
          'label' => 'Nama',
          'rules' => 'required|is_unique[tbsales.nama]',
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
        if ($this->request->getVar('aktif') == 'on') {
          $aktif = 'Y';
        } else {
          $aktif = 'N';
        }
        $session = session();
        $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        $simpandata = [
          'kode' => $this->request->getVar('kode'),
          'nama' => $this->request->getVar('nama'),
          'nohp1' => $this->request->getVar('nohp1'),
          'nohp2' => $this->request->getVar('nohp2'),
          'email' => $this->request->getVar('email'),
          'status' => $this->request->getVar('status'),
          'kdspv' => $this->request->getVar('kdspv'),
          'tglmasuk' => $this->request->getVar('tglmasuk'),
          'aktif' => $aktif,
          'user' => $user,
        ];
        $this->tbsalesModel->insert($simpandata);
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
      $row = $this->tbsalesModel->find($id);
      $data = [
        'title' => 'Edit Data Sales',
        // 'id' => $row['id'],
        // 'kdsa' => $row['kdsa'],
        // 'nama' => $row['nama'],
        'tbsales' => $this->tbsalesModel->find($id),
        'tbsaleslist' => $this->tbsalesModel->findAll(),
        'tbstatus_sales' => $this->tbstatus_salesModel->findAll(),
      ];
      $msg = [
        'sukses' => view('tbsales/modaledit', $data)
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
        'kode' => $this->request->getVar('kode'),
        'nama' => $this->request->getVar('nama'),
        'nohp1' => $this->request->getVar('nphp1'),
        'nohp2' => $this->request->getVar('nohp2'),
        'email' => $this->request->getVar('email'),
        'status' => $this->request->getVar('status'),
        'kdspv' => $this->request->getVar('kdspv'),
        'tglmasuk' => $this->request->getVar('tglmasuk'),
        'aktif' => $aktif,
        'user' => $user,
      ];
      $id = $this->request->getVar('id');
      $this->tbsalesModel->update($id, $simpandata);
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
    $rowtbsales = $this->tbsalesModel->find($id);
    $rowmemo = $this->memombrModel->getsales($rowtbsales['kode']);
    if ($rowmemo) {
      session()->setFlashdata('pesan', 'Data gagal dihapus, sudah terpakai di transaksi');
      echo json_encode(array("status" => FALSE));
    } else {
      $this->tbsalesModel->delete_by_id($id);
      session()->setFlashdata('pesan', 'Data berhasil dihapus');
      echo json_encode(array("status" => TRUE));
    }
  }

  public function table_sales()
  {
    $model = new tbsalesModel();
    $data['title'] = 'Tabel Sales';
    $data['tbsales'] = $model->getsales();
    echo view('tbsales/tabel_sales', $data);
  }
}
