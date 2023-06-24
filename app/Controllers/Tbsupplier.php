<?php

namespace App\Controllers;

use App\Models\TbsupplierModel;
use App\Models\TboplModel;

class Tbsupplier extends BaseController
{
  protected $tbsupplierModel, $tboplModel;
  public function __construct()
  {
    $this->tbsupplierModel = new TbsupplierModel();
    $this->tboplModel = new TboplModel();
  }

  public function index()
  {
    $data = [
      'menu' => 'file',
      'submenu' => 'tbsupplier',
      'title' => 'Tabel Supplier',
      'tbsupplier' => $this->tbsupplierModel->orderBy('kode')->findAll() //$tbsupplier
    ];
    echo view('tbsupplier/index', $data);
  }

  public function ajaxLoadData()
  {
    $request = $this->request;
    $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
    $katakunci = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
    $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
    $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
    $data = $this->tbsupplierModel->tampilData($request, $katakunci, $start, $length);
    $jumlahData = $this->tbsupplierModel->tampilData($request, $katakunci);
    $output = array(
      "draw" => intval($param['draw']),
      "recordsTotal" => count($jumlahData),
      "recordsFiltered" => count($jumlahData),
      "data" => $data,
    );
    // var_dump($data);
    echo json_encode($output);
  }

  public function formdetail()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->tbsupplierModel->find($id);
      $data = [
        'title' => 'Detail Data Supplier',
        'id' => $row['id'],
        // 'kode' => $row['kode'],
        // 'nama' => $row['nama'],
        // 'user' => $row['user'],
        // 'aktif' => $row['aktif'],
        'tbsupplier' => $row,
      ];
      $msg = [
        'sukses' => view('tbsupplier/modaldetail', $data)
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function detail($id)
  {
    $data = [
      'title' => 'Detail Tabel Supplier',
      'tbsupplier' => $this->tbsupplierModel->getid($id)
    ];
    if (empty($data['tbsupplier'])) {
      throw new \CodeIgniter\Exceptions\PageNotFoundException('Id supplier' . $id . 'tidak ditemukan.');
    }
    return view('tbsupplier/modaldetail', $data);
  }

  public function create()
  {
    // session();
    $data = [
      'title' => 'Tambah Data Tabel Supplier',
      'validation' => \Config\Services::validation()
    ];
    return view('tbsupplier/formtambah', $data);
  }

  public function formtambah()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Tambah Data Tabel Supplier',
        'kodesupplier' => $this->tbsupplierModel->buatkode(),
      ];
      $msg = [
        'data' => view('tbsupplier/modaltambah', $data),
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
          'rules' => 'required|is_unique[tbsupplier.kode]',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'is_unique' => '{field} tidak boleh ada yang sama'
          ]
        ],
        'nama' => [
          'label' => 'nama',
          'rules' => 'required|is_unique[tbsupplier.nama]',
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
            'nama' => $validation->getError('nama'),
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
          'kelompok' => $this->request->getVar('kelompok'),
          'nama' => $this->request->getVar('nama'),
          'alamat' => $this->request->getVar('alamat'),
          'kelurahan' => $this->request->getVar('kelurahan'),
          'kecamatan' => $this->request->getVar('kecamatan'),
          'kota' => $this->request->getVar('kota'),
          'kodepos' => $this->request->getVar('kodepos'),
          'telp' => $this->request->getVar('telp'),
          'contact_person' => $this->request->getVar('contact_person'),
          'no_contact_person' => $this->request->getVar('no_contact_person'),
          'npwp' => $this->request->getVar('npwp'),
          'nama_npwp' => $this->request->getVar('nama_npwp'),
          'alamat_npwp' => $this->request->getVar('alamat_npwp'),
          'mak_hutang' => $this->request->getVar('mak_hutang'),
          'aktif' => $aktif, //$this->request->getVar('aktif'),
          'user' => $user,
        ];
        $this->tbsupplierModel->insert($simpandata);
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
      $row = $this->tbsupplierModel->find($id);
      $data = [
        'title' => 'Edit Data Tabel Supplier',
        // 'id' => $row['id'],
        // 'kode' => $row['kode'],
        // 'nama' => $row['nama'],
        // 'aktif' => $row['aktif'],
        'tbsupplier' => $row,
      ];
      $msg = [
        'sukses' => view('tbsupplier/modaledit', $data)
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
            'rules' => 'required|is_unique[tbsupplier.kode]',
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
          'kelompok' => $this->request->getVar('kelompok'),
          'nama' => $this->request->getVar('nama'),
          'alamat' => $this->request->getVar('alamat'),
          'kelurahan' => $this->request->getVar('kelurahan'),
          'kecamatan' => $this->request->getVar('kecamatan'),
          'kota' => $this->request->getVar('kota'),
          'kodepos' => $this->request->getVar('kodepos'),
          'telp' => $this->request->getVar('telp'),
          'contact_person' => $this->request->getVar('contact_person'),
          'no_contact_person' => $this->request->getVar('no_contact_person'),
          'npwp' => $this->request->getVar('npwp'),
          'nama_npwp' => $this->request->getVar('nama_npwp'),
          'alamat_npwp' => $this->request->getVar('alamat_npwp'),
          'mak_hutang' => $this->request->getVar('mak_hutang'),
          'aktif' => $aktif, //$this->request->getVar('aktif'),
          'user' => $user,
        ];
        $id = $this->request->getVar('id');
        $this->tbsupplierModel->update($id, $simpandata);
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
    $rowtbsupplier = $this->tbsupplierModel->find($id);
    $rowtbopl = $this->tboplModel->getsupplier($rowtbsupplier['kode']); //cari kode model di tabel tipe
    if ($rowtbopl) {
      session()->setFlashdata('pesan', 'Data gagal dihapus, sudah terpakai di transaksi');
      echo json_encode(array("status" => FALSE));
    } else {
      $this->tbsupplierModel->delete_by_id($id);
      session()->setFlashdata('pesan', 'Data berhasil dihapus');
      echo json_encode(array("status" => TRUE));
    }
  }

  public function table_supplier()
  {
    $model = new tbsuppliermodel();
    $data['title'] = 'Tabel Supplier';
    $data['tbsupplier'] = $model->getkode();
    // dd($data);
    echo view('tbsupplier/tabel_supplier', $data);
  }
}
