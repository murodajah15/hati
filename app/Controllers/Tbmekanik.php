<?php

namespace App\Controllers;

use App\Models\TbmekanikModel;

class Tbmekanik extends BaseController
{
  protected $tbmekanikModel;
  public function __construct()
  {
    $this->tbmekanikModel = new TbmekanikModel();
  }

  public function index()
  {
    $data = [
      'menu' => 'file',
      'submenu' => 'tbmekanik',
      'submenu1' => 'ref_bengkel',
      'title' => 'Tabel mekanik',
      'tbmekanik' => $this->tbmekanikModel->orderBy('kode')->findAll() //$tbmekanik
    ];
    echo view('tbmekanik/index', $data);
  }

  public function detail($id)
  {
    $data = [
      'title' => 'Detail Tabel mekanik',
      'tbmekanik' => $this->tbmekanikModel->getmekanik($id)
    ];
    if (empty($data['tbmekanik'])) {
      throw new \CodeIgniter\Exceptions\PageNotFoundException('Id mekanik' . $id . 'tidak ditemukan.');
    }
    return view('tbmekanik/detail', $data);
  }

  public function ajaxLoadData()
  {
    $request = $this->request;
    $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
    $katakunci = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
    $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
    $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
    $data = $this->tbmekanikModel->tampilData($request, $katakunci, $start, $length);
    $jumlahData = $this->tbmekanikModel->tampilData($request, $katakunci);
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
        'tbmekanik' => $this->tbmekanikModel->find($id),
      ];
      $msg = [
        'sukses' => view('tbmekanik/modaldetail', $data)
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
        'title' => 'Tambah Data mekanik',
        'kodemekanik' => $this->tbmekanikModel->buatkode(),
      ];
      // var_dump($data);
      $msg = [
        'data' => view('tbmekanik/modaltambah', $data),
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
        'data' => view('tbmekanik/formtambah', $data),
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
          'rules' => 'required|is_unique[tbmekanik.kode]',
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
        if ($this->request->getVar('aktif') == 'on') {
          $aktif = 'Y';
        } else {
          $aktif = 'N';
        }
        $simpandata = [
          'kode' => $this->request->getVar('kode'),
          'kode_h3s' => $this->request->getVar('kode_h3s'),
          'nama' => $this->request->getVar('nama'),
          'alamat' => $this->request->getVar('alamat'),
          'kelurahan' => $this->request->getVar('kelurahan'),
          'kecamatan' => $this->request->getVar('kecamatan'),
          'kota' => $this->request->getVar('kota'),
          'provinsi' => $this->request->getVar('provinsi'),
          'kodepos' => $this->request->getVar('kodepos'),
          'telp1' => $this->request->getVar('telp1'),
          'kategori' => $this->request->getVar('kategori'),
          'aktif' => $aktif,
          'tgl_register' => date('Y-m-d'),
          'email' => $this->request->getVar('email'),
          'user' => $user,
        ];
        $this->tbmekanikModel->insert($simpandata);
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
      $row = $this->tbmekanikModel->find($id);
      $data = [
        'title' => 'Edit Data mekanik',
        // 'id' => $row['id'],
        // 'kode' => $row['kode'],
        // 'nama' => $row['nama'],
        // 'npwp' => $row['npwp'],
        'tbmekanik' => $this->tbmekanikModel->find($id),
      ];
      // var_dump($data);
      $msg = [
        'sukses' => view('tbmekanik/modaledit', $data)
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
            'rules' => 'required|is_unique[tbmekanik.kode]',
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
        if ($this->request->getVar('aktif') == 'on') {
          $aktif = 'Y';
        } else {
          $aktif = 'N';
        }
        $simpandata = [
          'kode' => $this->request->getVar('kode'),
          'kode_h3s' => $this->request->getVar('kode_h3s'),
          'nama' => $this->request->getVar('nama'),
          'alamat' => $this->request->getVar('alamat'),
          'kelurahan' => $this->request->getVar('kelurahan'),
          'kecamatan' => $this->request->getVar('kecamatan'),
          'kota' => $this->request->getVar('kota'),
          'provinsi' => $this->request->getVar('provinsi'),
          'kodepos' => $this->request->getVar('kodepos'),
          'telp1' => $this->request->getVar('telp1'),
          'kategori' => $this->request->getVar('kategori'),
          'aktif' => $aktif,
          'tgl_register' => date('Y-m-d'),
          'email' => $this->request->getVar('email'),
          'user' => $user,
        ];
        $id = $this->request->getVar('id');
        $this->tbmekanikModel->update($id, $simpandata);
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
    $this->tbmekanikModel->delete_by_id($id);
    session()->setFlashdata('pesan', 'Data berhasil dihapus');
    echo json_encode(array("status" => TRUE));
  }

  public function table_mekanik()
  {
    $model = new tbmekanikmodel();
    $data['title'] = 'Tabel Mekanik';
    $data['tbmekanik'] = $model->getkode();
    // var_dump($data);
    echo view('tbmekanik/tabel_mekanik', $data);
  }

  public function formdetailmobil()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->tbmekanikModel->find($id);
      $data = [
        'title' => 'Edit Data Kendaraan',
        // 'id' => $row['id'],
        // 'kode' => $row['kode'],
        // 'nama' => $row['nama'],
        // 'npwp' => $row['npwp'],
        'tbmekanik' => $this->tbmekanikModel->find($id),
      ];
      // var_dump($data);
      $msg = [
        'sukses' => view('tbmekanik/formdetailmobil', $data)
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function table_mobil_mekanik()
  {
    // $id = '20221100001'; // $id; //$this->request->getPost('kdpemilik'); // '20221100001'; //9; //$this->request->getPost('kdpemilik');
    $id = $_POST['id'];
    // $id = $this->request->getVar('kdpemilik');
    $data = [
      'title' => 'Detail Kendaraan',
      'tbmekanik' => $this->tbmekanikModel->getkdmekanik($id),
    ];
    // var_dump($data);
    echo view('tbmekanik/tabel_mobil_mekanik', $data);
  }
}
