<?php

namespace App\Controllers;

use App\Models\TbasuransiModel;
use App\Models\EstimasiModel;

class tbasuransi extends BaseController
{
  protected $tbasuransiModel, $estimasiModel;
  public function __construct()
  {
    $this->tbasuransiModel = new TbasuransiModel();
    $this->estimasiModel = new EstimasiModel();
  }

  public function index()
  {
    $data = [
      'menu' => 'file',
      'submenu' => 'tbasuransi',
      'title' => 'Tabel asuransi',
      'tbasuransi' => $this->tbasuransiModel->orderBy('kode')->findAll() //$tbasuransi
    ];
    echo view('tbasuransi/index', $data);
  }

  public function ajaxLoadData()
  {
    $request = $this->request;
    $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
    $katakunci = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
    $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
    $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
    $data = $this->tbasuransiModel->tampilData($request, $katakunci, $start, $length);
    $jumlahData = $this->tbasuransiModel->tampilData($request, $katakunci);
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
      $row = $this->tbasuransiModel->find($id);
      $data = [
        'title' => 'Detail Data asuransi',
        'id' => $row['id'],
        // 'kode' => $row['kode'],
        // 'nama' => $row['nama'],
        // 'user' => $row['user'],
        // 'aktif' => $row['aktif'],
        'tbasuransi' => $row,
      ];
      $msg = [
        'sukses' => view('tbasuransi/modaldetail', $data)
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function detail($id)
  {
    $data = [
      'title' => 'Detail Tabel asuransi',
      'tbasuransi' => $this->tbasuransiModel->getid($id)
    ];
    if (empty($data['tbasuransi'])) {
      throw new \CodeIgniter\Exceptions\PageNotFoundException('Id asuransi' . $id . 'tidak ditemukan.');
    }
    return view('tbasuransi/modaldetail', $data);
  }

  public function create()
  {
    // session();
    $data = [
      'title' => 'Tambah Data Tabel asuransi',
      'validation' => \Config\Services::validation()
    ];
    return view('tbasuransi/formtambah', $data);
  }

  public function formtambah()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Tambah Data Tabel asuransi',
        'kodeasuransi' => $this->tbasuransiModel->buatkode(),
      ];
      // var_dump($data);
      $msg = [
        'data' => view('tbasuransi/modaltambah', $data),
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
          'rules' => 'required|is_unique[tbasuransi.kode]',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'is_unique' => '{field} tidak boleh ada yang sama'
          ]
        ],
        'nama' => [
          'label' => 'nama',
          'rules' => 'required|is_unique[tbasuransi.nama]',
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
          'nama' => $this->request->getVar('nama'),
          'alamat' => $this->request->getVar('alamat'),
          'kota' => $this->request->getVar('kota'),
          'telp' => $this->request->getVar('telp'),
          'fax' => $this->request->getVar('fax'),
          'contact_person' => $this->request->getVar('contact_person'),
          'no_contact_person' => $this->request->getVar('no_contact_person'),
          'npwp' => $this->request->getVar('npwp'),
          'nama_npwp' => $this->request->getVar('nama_npwp'),
          'nppkp' => $this->request->getVar('nppkp'),
          'email' => $this->request->getVar('email'),
          'top' => $this->request->getVar('top'),
          'kredit_limit' => $this->request->getVar('kredit_limit'),
          'disc_part' => $this->request->getVar('disc_part'),
          'disc_jasa' => $this->request->getVar('disc_jasa'),
          'disc_bahan' => $this->request->getVar('disc_bahan'),
          'pph_jasa' => $this->request->getVar('pph_jasa'),
          'pph_material' => $this->request->getVar('pph_material'),
          'aktif' => $aktif, //$this->request->getVar('aktif'),
          'user' => $user,
        ];
        $this->tbasuransiModel->insert($simpandata);
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
      $row = $this->tbasuransiModel->find($id);
      $data = [
        'title' => 'Edit Data Tabel asuransi',
        // 'id' => $row['id'],
        // 'kode' => $row['kode'],
        // 'nama' => $row['nama'],
        // 'aktif' => $row['aktif'],
        'tbasuransi' => $row,
      ];
      $msg = [
        'sukses' => view('tbasuransi/modaledit', $data)
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
            'rules' => 'required|is_unique[tbasuransi.kode]',
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
          'nama' => $this->request->getVar('nama'),
          'alamat' => $this->request->getVar('alamat'),
          'kota' => $this->request->getVar('kota'),
          'telp' => $this->request->getVar('telp'),
          'fax' => $this->request->getVar('fax'),
          'contact_person' => $this->request->getVar('contact_person'),
          'no_contact_person' => $this->request->getVar('no_contact_person'),
          'npwp' => $this->request->getVar('npwp'),
          'nama_npwp' => $this->request->getVar('nama_npwp'),
          'nppkp' => $this->request->getVar('nppkp'),
          'email' => $this->request->getVar('email'),
          'top' => $this->request->getVar('top'),
          'kredit_limit' => $this->request->getVar('kredit_limit'),
          'disc_part' => $this->request->getVar('disc_part'),
          'disc_jasa' => $this->request->getVar('disc_jasa'),
          'disc_bahan' => $this->request->getVar('disc_bahan'),
          'pph_jasa' => $this->request->getVar('pph_jasa'),
          'pph_material' => $this->request->getVar('pph_material'),
          'aktif' => $aktif, //$this->request->getVar('aktif'),
          'user' => $user,
        ];
        $id = $this->request->getVar('id');
        $this->tbasuransiModel->update($id, $simpandata);
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
    $rowtbasuransi = $this->tbasuransiModel->find($id);
    $rowestimasi = $this->estimasiModel->getasuransi($rowtbasuransi['kode']); //cari kode model di tabel tipe
    if ($rowestimasi) {
      session()->setFlashdata('pesan', 'Data gagal dihapus, sudah terpakai di transaksi');
      echo json_encode(array("status" => FALSE));
    } else {
      $this->tbasuransiModel->delete_by_id($id);
      session()->setFlashdata('pesan', 'Data berhasil dihapus');
      echo json_encode(array("status" => TRUE));
    }
  }

  public function table_asuransi()
  {
    $model = new tbasuransimodel();
    $data['title'] = 'Tabel asuransi';
    $data['tbasuransi'] = $model->getkode();
    // dd($data);
    echo view('tbasuransi/tabel_asuransi', $data);
  }
}
