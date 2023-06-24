<?php

namespace App\Controllers;

use App\Models\SaplikasiModel;
use CodeIgniter\HTTP\Files\UploadedFile;

class Saplikasi extends BaseController
{
  protected $helpers = ['form'];
  protected $saplikasiModel;
  public function __construct()
  {
    $this->saplikasiModel = new SaplikasiModel();
  }

  public function index()
  {
    $data = [
      'menu' => 'utility',
      'submenu' => 'saplikasi',
      'title' => 'Setup Aplikasi',
      'saplikasi' => $this->saplikasiModel->orderBy('kd_perusahaan')->findAll() //$tbmodule
    ];
    echo view('saplikasi/index', $data);
  }

  public function detail($id)
  {
    $data = [
      'title' => 'Detail tabel module',
      'saplikasi' => $this->saplikasiModel->getmodule($id)
    ];
    if (empty($data['saplikasi'])) {
      throw new \CodeIgniter\Exceptions\PageNotFoundException('Id module' . $id . 'tidak ditemukan.');
    }
    return view('saplikasi/detail', $data);
  }

  public function create()
  {
    // session();
    $data = [
      'title' => 'Tambah tabel module',
      'validation' => \Config\Services::validation()
    ];
    return view('saplikasi/formtambah', $data);
  }

  public function ajaxLoadData()
  {
    $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
    $katakunci = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
    $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
    $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';

    $this->saplikasiModel = new SaplikasiModel();
    $data = $this->saplikasiModel->tampilData($katakunci, $start, $length);
    $jumlahData = $this->saplikasiModel->tampilData($katakunci);

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
      $row = $this->saplikasiModel->find($id);
      $data = [
        'title' => 'Detail data',
        'id' => $row['id'],
        'kd_perusahaan' => $row['kd_perusahaan'],
        'nm_perusahaan' => $row['nm_perusahaan'],
        'alamat' => $row['alamat'],
        'telp' => $row['telp'],
        'npwp' => $row['npwp'],
        'logo' => $row['logo'],
        'pejabat_1' => $row['pejabat_1'],
        'pejabat_2' => $row['pejabat_2'],
        'user' => $row['user'],
        'aktif' => $row['aktif'],
      ];
      $msg = [
        'sukses' => view('saplikasi/modaldetail', $data)
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
        'data' => view('saplikasi/modaltambah', $data),
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
        'data' => view('saplikasi/formtambah', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function simpandata()
  {
    if ($this->request->isAjax()) {
      $rules = [
        'kd_perusahaan' => [
          'rules' => 'required|max_length[20]|is_unique[saplikasi.kd_perusahaan]',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'is_unique' => '{field} tidak boleh ada yang sama',
            'max_length' => '{field} Maksimum 20 karakter',
          ],
        ],
        'photo' => [
          'rules' => 'uploaded[photo]|max_size[photo,1024]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]',
          'errors' => [
            'uploaded' => 'Pilih gambar terlebih dahulu',
            'max_size' => 'Harap isi dahulu pada :max karakter dan pada :max karakter.',
            'is_image' => 'Yang anda pilih bukan gambar',
            'mime_in' => 'Yang anda pilih bukan gambar',
          ]
        ]
      ];
      $filePhoto = $this->request->getFile('photo');
      // dd($filePhoto);
      if ($filePhoto->getError() == 4) {
        $namaPhoto = 'default.png';
      } else {
        $namaPhoto = $filePhoto->getRandomName();
      }

      if (!$this->validate($rules)) {
        $validation = \Config\Services::validation();
        $msg = [
          'error' => [
            'kd_perusahaan' => $validation->getError('kd_perusahaan'),
            'photo' => $validation->getError('photo'),
          ]
        ];
        echo json_encode($msg);
      } else {
        if (isset($filePhoto)) {
          $filePhoto->move('img', $namaPhoto);
        }
        $session = session();
        $user = "Tambah-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        if ($this->request->getVar('aktif') == 'on') {
          $aktif = 'Y';
        } else {
          $aktif = 'N';
        }
        $simpandata = [
          'kd_perusahaan' => $this->request->getVar('kd_perusahaan'),
          'nm_perusahaan' => $this->request->getVar('nm_perusahaan'),
          'alamat' => $this->request->getVar('alamat'),
          'telp' => $this->request->getVar('telp'),
          'npwp' => $this->request->getVar('npwp'),
          'pejabat_1' => $this->request->getVar('pejabat_1'),
          'pejabat_2' => $this->request->getVar('pejabat_2'),
          'logo' => $namaPhoto,
          'user' => $user,
          'aktif' => $aktif,
        ];
        // dd($simpandata);
        $this->saplikasiModel->insert($simpandata);
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
      $row = $this->saplikasiModel->find($id);
      $data = [
        'title' => 'Edit data',
        'id' => $row['id'],
        'kd_perusahaan' => $row['kd_perusahaan'],
        'nm_perusahaan' => $row['nm_perusahaan'],
        'alamat' => $row['alamat'],
        'telp' => $row['telp'],
        'npwp' => $row['npwp'],
        'logo' => $row['logo'],
        'pejabat_1' => $row['pejabat_1'],
        'pejabat_2' => $row['pejabat_2'],
        'user' => $row['user'],
        'aktif' => $row['aktif'],
      ];
      $msg = [
        'sukses' => view('saplikasi/modaledit', $data)
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

      // Cek gambar apakah tetap gambar lama
      $filePhoto = $this->request->getFile('photo');
      if ($filePhoto->getError() == 4) {
        // if (!isset($filePhoto)) {
        $namaPhoto = $this->request->getVar('photoLama');
      } else {
        $namaPhoto = $filePhoto->getRandomName();
        if (is_file('img/' . $this->request->getVar('photoLama'))) {
          if ($this->request->getVar('photoLama') != 'default.png') {
            unlink('img/' . $this->request->getVar('photoLama'));
          }
        }
        // unlink('img/' . $this->request->getVar('photoLama'));
        $filePhoto->move('img', $namaPhoto);
      }
      if ($this->request->getVar('aktif') == 'on') {
        $aktif = 'Y';
      } else {
        $aktif = 'N';
      }
      $simpandata = [
        'kd_perusahaan' => $this->request->getVar('kd_perusahaan'),
        'nm_perusahaan' => $this->request->getVar('nm_perusahaan'),
        'alamat' => $this->request->getVar('alamat'),
        'telp' => $this->request->getVar('telp'),
        'npwp' => $this->request->getVar('npwp'),
        'logo' => $namaPhoto,
        'pejabat_1' => $this->request->getVar('pejabat_1'),
        'pejabat_2' => $this->request->getVar('pejabat_2'),
        'user' => $user,
        'aktif' => $aktif,
      ];
      $id = $this->request->getVar('id');
      $this->saplikasiModel->update($id, $simpandata);
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
    // hapus gambar di img
    $user = $this->saplikasiModel->find($id);
    // dd($user['photo']);
    if ($user['logo'] != 'default.png') {
      // if (file_exists('img/' . $user['photo'])) {
      if (is_file('img/' . $user['logo'])) {
        unlink('img/' . $user['logo']);
      }
    }
    $this->saplikasiModel->delete_by_id($id);
    session()->setFlashdata('pesan', 'Data berhasil dihapus');
    echo json_encode(array("status" => TRUE));
  }

  // public function urutkan()
  // {
  //   $results = $this->saplikasiModel->orderBy('nurut')->findAll();
  //   // var_dump($results);
  //   $i = 1;
  //   foreach ($results as $row) {
  //     $nurut = $i;
  //     $simpandata = [
  //       'nurut' => $nurut
  //     ];
  //     $id = $row['id'];
  //     $this->saplikasiModel->update($id, $simpandata);
  //     $i++;
  //   }
  //   session()->setFlashdata('pesan', 'Data berhasil diurutkan');
  //   echo json_encode(array("status" => TRUE));
  // }

  public function table_saplikasi()
  {
    $model = new SaplikasiModel();
    $data['title'] = 'Setup Aplikasi';
    $data['saplikasi'] = $model->getid();
    // dd($data);
    echo view('saplikasi/tabel_saplikasi', $data);
  }

  public function deletemultiple()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id_a');
      $jmldata = count($id);
      for ($i = 0; $i < $jmldata; $i++) {
        $logo = $id[$i];
        if ($logo != 'default.png') {
          // if (file_exists('img/' . $user['photo'])) {
          if (is_file('img/' . $logo)) {
            unlink('img/' . $logo);
          }
        }
      }
      $hapusdata = $this->saplikasiModel->hapusbanyak($id, $jmldata);
      if ($hapusdata == true) {
        $msg = [
          'sukses' => "$jmldata data berhasil dihapus",
          'id' => $id
        ];
      }
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
}
