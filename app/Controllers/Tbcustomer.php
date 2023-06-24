<?php

namespace App\Controllers;

use App\Models\TbcustomerModel;
use App\Models\TbagamaModel;
use App\Models\TbmobilModel;

class Tbcustomer extends BaseController
{
  protected $tbcustomerModel, $tbagamaModel, $tbmobilModel, $model;
  public function __construct()
  {
    $this->tbcustomerModel = new TbcustomerModel();
    $this->tbagamaModel = new TbagamaModel();
    $this->tbmobilModel = new TbmobilModel();
  }

  public function index()
  {
    $data = [
      'menu' => 'file',
      'submenu' => 'tbcustomer',
      'title' => 'Tabel Customer',
      'tbcustomer' => $this->tbcustomerModel->orderBy('kode')->findAll() //$tbcustomer
    ];
    echo view('tbcustomer/index', $data);
  }

  public function detail($id)
  {
    $data = [
      'title' => 'Detail Tabel Customer',
      'tbcustomer' => $this->tbcustomerModel->getcustomer($id)
    ];
    if (empty($data['tbcustomer'])) {
      throw new \CodeIgniter\Exceptions\PageNotFoundException('Id customer' . $id . 'tidak ditemukan.');
    }
    return view('tbcustomer/detail', $data);
  }

  public function ajaxLoadData()
  {
    $request = $this->request;
    $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
    $katakunci = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
    $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
    $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
    $this->model = new TbcustomerModel();
    $data = $this->model->tampilData($request, $katakunci, $start, $length);
    $jumlahData = $this->model->tampilData($request, $katakunci);
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
      $data = [
        'title' => 'Detail Data',
        'tbcustomer' => $this->tbcustomerModel->find($id),
      ];
      $msg = [
        'sukses' => view('tbcustomer/modaldetail', $data)
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function formtambah()
  {
    if ($this->request->isAjax()) {
      $this->tbagamaModel->findAll();
      $data = [
        'title' => 'Tambah Data Customer',
        'kodecustomer' => $this->tbcustomerModel->buatkode(),
        'tbagama' => $this->tbagamaModel->orderBy('kode')->findAll()
      ];
      // var_dump($data);
      $msg = [
        'data' => view('tbcustomer/modaltambah', $data),
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
        'title' => 'Tambah Data'
      ];
      $msg = [
        'data' => view('tbcustomer/formtambah', $data),
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
          'rules' => 'required|is_unique[tbcustomer.kode]',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'is_unique' => '{field} tidak boleh ada yang sama'
          ]
        ],
        'nama' => [
          'label' => 'nama',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong'
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
        date_default_timezone_set('Asia/Jakarta');
        $session = session();
        $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        $simpandata = [
          'kode' => $this->request->getVar('kode'),
          'kelompok' => $this->request->getVar('kelompok'),
          'nama' => $this->request->getVar('nama'),
          'alamat' => $this->request->getVar('alamat'),
          'kelurahan' => $this->request->getVar('kelurahan'),
          'kecamatan' => $this->request->getVar('kecamatan'),
          'kota' => $this->request->getVar('kota'),
          'provinsi' => $this->request->getVar('provinsi'),
          'kodepos' => $this->request->getVar('kodepos'),
          'telp1' => $this->request->getVar('telp1'),
          'telp2' => $this->request->getVar('telp2'),
          'agama' => $this->request->getVar('agama'),
          'tgl_lahir' => $this->request->getVar('tgl_lahir'),
          'alamat_ktr' => $this->request->getVar('alamat_ktr'),
          'kelurahan_ktr' => $this->request->getVar('kelurahan_ktr'),
          'kecamatan_ktr' => $this->request->getVar('kecamatan_ktr'),
          'kota_ktr' => $this->request->getVar('kota_ktr'),
          'provinsi_ktr' => $this->request->getVar('provinsi_ktr'),
          'kodepos_ktr' => $this->request->getVar('kodepos_ktr'),
          'telp1_ktr' => $this->request->getVar('telp1_ktr'),
          'telp2_ktr' => $this->request->getVar('telp2_ktr'),
          'contact_person' => $this->request->getVar('contact_person'),
          'no_contact_person' => $this->request->getVar('no_contact_person'),
          'npwp' => $this->request->getVar('npwp'),
          'nama_npwp' => $this->request->getVar('nama_npwp'),
          'alamat_npwp' => $this->request->getVar('alamat_npwp'),
          'nik' => $this->request->getVar('nik'),
          'alamat_ktp' => $this->request->getVar('alamat_ktp'),
          'kelurahan_ktp' => $this->request->getVar('kelurahan_ktp'),
          'kecamatan_ktp' => $this->request->getVar('kecamatan_ktp'),
          'kota_ktp' => $this->request->getVar('kota_ktp'),
          'provinsi_ktp' => $this->request->getVar('provinsi_ktp'),
          'kodepos_ktp' => $this->request->getVar('kodepos_ktp'),
          'mak_piutang' => $this->request->getVar('mak_piutang'),
          'tgl_register' => date('Y-m-d'),
          'email' => $this->request->getVar('email'),
          'user' => $user,
        ];
        $this->tbcustomerModel->insert($simpandata);
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
      $this->tbagamaModel->findAll();
      $id = $this->request->getVar('id');
      $row = $this->tbcustomerModel->find($id);
      $data = [
        'title' => 'Edit Data Customer',
        // 'id' => $row['id'],
        // 'kode' => $row['kode'],
        // 'nama' => $row['nama'],
        // 'npwp' => $row['npwp'],
        'tbcustomer' => $this->tbcustomerModel->find($id),
        'tbagama' => $this->tbagamaModel->orderBy('kode')->findAll(),
      ];
      // var_dump($data);
      $msg = [
        'sukses' => view('tbcustomer/modaledit', $data)
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
            'rules' => 'required|is_unique[tbcustomer.kode]',
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
            'kode' => $validation->getError('kode'),
            // 'nama' => $validation->getError('nama')
          ]
        ];
        echo json_encode($msg);
      } else {

        date_default_timezone_set('Asia/Jakarta');
        $session = session();
        $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        $simpandata = [
          'kode' => $this->request->getVar('kode'),
          'kelompok' => $this->request->getVar('kelompok'),
          'nama' => $this->request->getVar('nama'),
          'alamat' => $this->request->getVar('alamat'),
          'kelurahan' => $this->request->getVar('kelurahan'),
          'kecamatan' => $this->request->getVar('kecamatan'),
          'kota' => $this->request->getVar('kota'),
          'provinsi' => $this->request->getVar('provinsi'),
          'kodepos' => $this->request->getVar('kodepos'),
          'telp1' => $this->request->getVar('telp1'),
          'telp2' => $this->request->getVar('telp2'),
          'agama' => $this->request->getVar('agama'),
          'tgl_lahir' => $this->request->getVar('tgl_lahir'),
          'alamat_ktr' => $this->request->getVar('alamat_ktr'),
          'kelurahan_ktr' => $this->request->getVar('kelurahan_ktr'),
          'kecamatan_ktr' => $this->request->getVar('kecamatan_ktr'),
          'kota_ktr' => $this->request->getVar('kota_ktr'),
          'provinsi_ktr' => $this->request->getVar('provinsi_ktr'),
          'kodepos_ktr' => $this->request->getVar('kodepos_ktr'),
          'telp1_ktr' => $this->request->getVar('telp1_ktr'),
          'telp2_ktr' => $this->request->getVar('telp2_ktr'),
          'contact_person' => $this->request->getVar('contact_person'),
          'no_contact_person' => $this->request->getVar('no_contact_person'),
          'npwp' => $this->request->getVar('npwp'),
          'nama_npwp' => $this->request->getVar('nama_npwp'),
          'alamat_npwp' => $this->request->getVar('alamat_npwp'),
          'nik' => $this->request->getVar('nik'),
          'alamat_ktp' => $this->request->getVar('alamat_ktp'),
          'kelurahan_ktp' => $this->request->getVar('kelurahan_ktp'),
          'kecamatan_ktp' => $this->request->getVar('kecamatan_ktp'),
          'kota_ktp' => $this->request->getVar('kota_ktp'),
          'provinsi_ktp' => $this->request->getVar('provinsi_ktp'),
          'kodepos_ktp' => $this->request->getVar('kodepos_ktp'),
          'mak_piutang' => $this->request->getVar('mak_piutang'),
          'tgl_register' => date('Y-m-d'),
          'email' => $this->request->getVar('email'),
          'user' => $user,
        ];
        $id = $this->request->getVar('id');
        $this->tbcustomerModel->update($id, $simpandata);
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
    $this->tbcustomerModel->delete_by_id($id);
    session()->setFlashdata('pesan', 'Data berhasil dihapus');
    echo json_encode(array("status" => TRUE));
  }

  public function hapusmobil($id)
  {
    $this->tbmobilModel->hapusmobil($id);
    session()->setFlashdata('pesan', 'Data berhasil dihapus');
    echo json_encode(array("status" => TRUE));
  }

  public function table_customer()
  {
    $model = new tbcustomermodel();
    $data['title'] = 'Tabel Customer';
    $data['tbcustomer'] = $model->getcustomer();
    echo view('tbcustomer/tabel_customer', $data);
  }

  public function formdetailmobil()
  {
    if ($this->request->isAjax()) {
      $this->tbagamaModel->findAll();
      $id = $this->request->getVar('id');
      $row = $this->tbcustomerModel->find($id);
      $data = [
        'title' => 'Edit Data Kendaraan',
        // 'id' => $row['id'],
        // 'kode' => $row['kode'],
        // 'nama' => $row['nama'],
        // 'npwp' => $row['npwp'],
        'tbcustomer' => $this->tbcustomerModel->find($id),
        'tbagama' => $this->tbagamaModel->orderBy('kode')->findAll(),
      ];
      // var_dump($data);
      $msg = [
        'sukses' => view('tbcustomer/formdetailmobil', $data)
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function cari_nopolisi()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data Mobil',
        'tbmobil' => $this->tbmobilModel->orderBy('nopolisi')->findAll() //$rwtkeluarga
      ];
      $msg = [
        'data' => view('tbcustomer/modalcari_nopolisi', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function repl_nopolisi()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['nopolisi'];
      $row = $this->tbmobilModel->getnopolisi($kode);
      if (isset($row)) {
        $data = [
          'title' => 'Detail data',
          'nopolisi' => $row['nopolisi'],
          'norangka' => $row['norangka'],
          'nomesin' => $row['nomesin'],
          'kdtipe' => $row['kdtipe'],
          'id' => $row['id'],

        ];
      } else {
        $data = [
          'title' => 'Detail data',
          'nopolisi' => '',
          'norangka' => '',
          'nomeisn' => '',
          'kdtipe' => '',
          'id' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function updatemobil()
  {
    if ($this->request->isAjax()) {
      $validation = \Config\Services::validation();
      $nopolisi = $this->request->getVar('nopolisi');
      $valid = $this->validate([
        'nopolisi' => [
          'label' => 'nopolisi',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong'
          ]
        ]
      ]);
      if (!$valid) {
        $msg = [
          'error' => [
            'nopolisi' => $validation->getError('nopolisi'),
            // 'nama' => $validation->getError('nama')
          ]
        ];
        echo json_encode($msg);
      } else {

        date_default_timezone_set('Asia/Jakarta');
        $session = session();
        $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        $simpandata = [
          'kdpemilik' => $this->request->getVar('kdpemilik'),
          'nmpemilik' => $this->request->getVar('nmpemilik'),
          'user' => $user,
        ];
        $id = $this->request->getVar('id');
        // var_dump($simpandata);
        $this->tbmobilModel->update($id, $simpandata);
        $msg = [
          'sukses' => 'Data berhasil diupdate'
        ];
        session()->setFlashdata('pesan', 'Data berhasil diupdate');
        echo json_encode($msg);
      }
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function table_mobil_customer()
  {
    // $id = '20221100001'; // $id; //$this->request->getPost('kdpemilik'); // '20221100001'; //9; //$this->request->getPost('kdpemilik');
    $id = $_POST['id'];
    // $id = $this->request->getVar('kdpemilik');
    $data = [
      'title' => 'Detail Kendaraan',
      'tbcustomer' => $this->tbcustomerModel->getkdcustomer($id),
    ];
    // var_dump($data);
    echo view('tbcustomer/tabel_mobil_customer', $data);
  }
}
