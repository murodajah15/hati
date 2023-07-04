<?php

namespace App\Controllers;

use App\Models\TbdiscModel;
use App\Models\TbbarangModel;

class Tbdisc extends BaseController
{
  protected $tbdiscModel, $tbbarangModel;
  public function __construct()
  {
    $this->tbdiscModel = new TbdiscModel();
    $this->tbbarangModel = new TbbarangModel();
  }

  public function index()
  {
    $data = [
      'menu' => 'file',
      'submenu' => 'tbdisc',
      'submenu1' => 'ref_part',
      'title' => 'Tabel Discount',
      'tbdisc' => $this->tbdiscModel->orderBy('kode')->findAll() //$tbdisc
    ];
    echo view('tbdisc/index', $data);
  }

  public function formdetail()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->tbdiscModel->find($id);
      $data = [
        'title' => 'Detail Data',
        'id' => $row['id'],
        // 'kode' => $row['kode'],
        // 'nama' => $row['nama'],
        // 'user' => $row['user'],
        // 'aktif' => $row['aktif'],
        'tbdisc' => $row,
      ];
      $msg = [
        'sukses' => view('tbdisc/modaldetail', $data)
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function detail($id)
  {
    $data = [
      'title' => 'Detail Tabel Discount',
      'tbdisc' => $this->tbdiscModel->getid($id)
    ];
    if (empty($data['tbdisc'])) {
      throw new \CodeIgniter\Exceptions\PageNotFoundException('Id disc' . $id . 'tidak ditemukan.');
    }
    return view('tbdisc/modaldetail', $data);
  }

  public function create()
  {
    // session();
    $data = [
      'title' => 'Tambah Data Tabel Discount',
      'validation' => \Config\Services::validation()
    ];
    return view('tbdisc/formtambah', $data);
  }

  public function ajaxLoadData()
  {
    $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
    $katakunci = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
    $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
    $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';

    $tbdiscModel = new TbdiscModel();
    $data = $tbdiscModel->tampilData($katakunci, $start, $length);
    $jumlahData = $tbdiscModel->tampilData($katakunci);

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
        'title' => 'Tambah Data Tabel disc'
      ];
      $msg = [
        'data' => view('tbdisc/modaltambah', $data),
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
          'rules' => 'required|is_unique[tbdisc.kode]',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'is_unique' => '{field} tidak boleh ada yang sama'
          ]
        ]
      ]);
      if (!$valid) {
        $msg = [
          'error' => [
            'kode' => $validation->getError('kode'),
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
          'disc_normal' => $this->request->getVar('disc_normal'),
          'disc_urgent' => $this->request->getVar('disc_urgent'),
          'disc_hotline' => $this->request->getVar('disc_hotline'),
          'aktif' => $aktif, //$this->request->getVar('aktif'),
          'user' => $user,
        ];
        $this->tbdiscModel->insert($simpandata);
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
      $row = $this->tbdiscModel->find($id);
      $data = [
        'title' => 'Edit Data Tabel Discount',
        // 'id' => $row['id'],
        // 'kode' => $row['kode'],
        // 'nama' => $row['nama'],
        // 'aktif' => $row['aktif'],
        'tbdisc' => $row,
      ];
      $msg = [
        'sukses' => view('tbdisc/modaledit', $data)
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
            'rules' => 'required|is_unique[tbdisc.kode]',
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
          'disc_normal' => $this->request->getVar('disc_normal'),
          'disc_urgent' => $this->request->getVar('disc_urgent'),
          'disc_hotline' => $this->request->getVar('disc_hotline'),
          'aktif' => $aktif, //$this->request->getVar('aktif'),
          'user' => $user,
        ];
        $id = $this->request->getVar('id');
        $this->tbdiscModel->update($id, $simpandata);
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
    $rowtbdisc = $this->tbdiscModel->find($id);
    $rowtbbarang = $this->tbbarangModel->getkodedisc($rowtbdisc['kode']);
    if ($rowtbbarang) {
      session()->setFlashdata('pesan', 'Data gagal dihapus, sudah terpakai di transaksi');
      echo json_encode(array("status" => FALSE));
    } else {
      $this->tbdiscModel->delete_by_id($id);
      session()->setFlashdata('pesan', 'Data berhasil dihapus');
      echo json_encode(array("status" => TRUE));
    }
  }

  public function table_disc()
  {
    $model = new tbdiscmodel();
    $data['title'] = 'Tabel disc';
    $data['tbdisc'] = $model->getkode();
    // dd($data);
    echo view('tbdisc/tabel_disc', $data);
  }
}
