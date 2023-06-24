<?php

namespace App\Controllers;

use App\Models\RwtkeluargaModel;
use App\Models\RwtkeluargadModel;
use App\Models\TbdivisiModel;

class Rwtkeluarga extends BaseController
{
  protected $rwtkeluargaModel, $rwtkeluargadModel;
  public function __construct()
  {
    $this->rwtkeluargaModel = new RwtkeluargaModel();
    $this->rwtkeluargadModel = new RwtkeluargadModel();
    $this->tbdivisiModel = new TbdivisiModel();
  }

  public function index()
  {
    $data = [
      'menu' => 'transaksi',
      'submenu' => 'rwtkeluarga',
      'title' => 'Riwayat Keluarga',
      'rwtkeluarga' => $this->rwtkeluargaModel->orderBy('kode')->findAll() //$rwtkeluarga
    ];
    echo view('rwtkeluarga/index', $data);
  }

  public function detail($id)
  {
    $data = [
      'title' => 'Detail tabel rwtkeluarga',
      'rwtkeluarga' => $this->rwtkeluargaModel->getrwtkeluarga($id)
    ];
    if (empty($data['rwtkeluarga'])) {
      throw new \CodeIgniter\Exceptions\PageNotFoundException('Id rwtkeluarga' . $id . 'tidak ditemukan.');
    }
    return view('rwtkeluarga/detail', $data);
  }

  public function create()
  {
    // session();
    $data = [
      'title' => 'Tambah tabel rwtkeluarga',
      'validation' => \Config\Services::validation()
    ];
    return view('rwtkeluarga/create', $data);
  }

  public function ajaxLoadData()
  {
    $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
    $katakunci = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
    $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
    $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';

    $this->model = new rwtkeluargaModel();
    $data = $this->model->tampilData($katakunci, $start, $length);
    $jumlahData = $this->model->tampilData($katakunci);

    $output = array(
      "draw" => intval($param['draw']),
      "recordsTotal" => count($jumlahData),
      "recordsFiltered" => count($jumlahData),
      "data" => $data,
    );
    echo json_encode($output);
  }

  public function ajaxLoadDataDetail()
  {
    $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
    $katakunci = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
    $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
    $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';

    $db = \Config\Database::connect();
    $query   = $db->query('SELECT * from rwtkeluarga');
    $results = $query->getResultArray();

    // $this->model = new rwtkeluargaModel();
    // $data = $this->model->tampilData($katakunci, $start, $length);
    // $jumlahData = $this->model->tampilData($katakunci);

    $this->model = new rwtkeluargadModel();
    $data = $this->model->tampilDataDetail($katakunci, $start, $length);
    $jumlahData = $this->model->tampilDataDetail($katakunci);

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
      $row = $this->rwtkeluargaModel->find($id);
      $data = [
        'title' => 'Detail data',
        'id' => $row['id'],
        'kode' => $row['kode'],
        'nama' => $row['nama'],
        'user' => $row['user'],
      ];
      $msg = [
        'sukses' => view('rwtkeluarga/modaldetail', $data)
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
        'data' => view('rwtkeluarga/formtambah', $data),
      ];
      // echo json_encode($msg);
      echo view('rwtkeluarga/formtambah', $data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function formtambahbanyak()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Tambah data banyak'
      ];
      $msg = [
        'data' => view('rwtkeluarga/formtambahbanyak', $data),
      ];
      echo json_encode($msg);
      // echo view('rwtkeluarga/formtambahbanyak', $data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function formtambahmodal()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Tambah data'
      ];
      $msg = [
        'data' => view('rwtkeluarga/modaltambah', $data),
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
        'data' => view('rwtkeluarga/formtambah', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function simpandata()
  {
    // $this->rwtkeluargaModel = new rwtkeluargaModel();
    // if ($this->request->isAjax()) {
    $validation = \Config\Services::validation();
    $valid = $this->validate([
      'kode' => [
        'label' => 'Kode',
        'rules' => 'required|is_unique[rwtkeluarga.kode]',
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
      $simpandata = [
        'kode' => $this->request->getVar('kode'),
        'nama' => $this->request->getVar('nama'),
        'user' => $user,
      ];
      $this->rwtkeluargaModel->insert($simpandata);
      $msg = [
        'sukses' => 'Data berhasil ditambah'
      ];
      session()->setFlashdata('pesan', 'Data berhasil ditambah');
      echo json_encode($msg);
    }
    // } else {
    //   exit('Maaf tidak dapat diproses');
    // }
  }

  public function formedit()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->rwtkeluargaModel->find($id);
      $data = [
        'title' => 'Edit data',
        'id' => $row['id'],
        'kode' => $row['kode'],
        'nama' => $row['nama'],
      ];
      // $msg = [
      //   'sukses' => view('rwtkeluarga/modaledit', $data)
      // ];
      // echo json_encode($msg);
      echo view('rwtkeluarga/formedit', $data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function formedit_detail()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->rwtkeluargaModel->find($id);
      $data = [
        'title' => 'Detail data keluarga',
        'id' => $row['id'],
        'kode' => $row['kode'],
        'nama' => $row['nama'],
      ];
      // $msg = [
      //   'sukses' => view('rwtkeluarga/modaledit_detail', $data)
      // ];
      // echo json_encode($msg);
      echo view('rwtkeluarga/formedit_detail', $data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function formeditmodal()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->rwtkeluargaModel->find($id);
      $data = [
        'title' => 'Edit data',
        'id' => $row['id'],
        'kode' => $row['kode'],
        'nama' => $row['nama'],
      ];
      $msg = [
        'sukses' => view('rwtkeluarga/modaledit', $data)
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
      // $kodeLama = $this->rwtkeluargaModel->getkdrwtkeluarga($this->request->getVar('id'));
      $row = $this->rwtkeluargaModel->find($this->request->getVar('id'));
      $kodeLama = $row['kode'];
      // dd($kodeLama);
      if ($kodeLama == $this->request->getVar('kode')) { //('03' == $this->request->getVar('kode')) {
        $rule_kode = "required";
      } else {
        $rule_kode = "required|is_unique[rwtkeluarga.kode]";
      }
      $valid = $this->validate([
        'kode' => [
          'label' => 'Kode',
          // 'rules' => 'required|is_unique[rwtkeluarga.kode]',
          // 'rules' => 'required',
          'rules' => $rule_kode,
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'is_unique' => '{field} tidak boleh ada yang sama1'
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
        $simpandata = [
          'kode' => $this->request->getVar('kode'),
          'nama' => $this->request->getVar('nama'),
          'user' => $user,
        ];
        $id = $this->request->getVar('id');
        $this->rwtkeluargaModel->update($id, $simpandata);
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
    $this->rwtkeluargaModel->delete_by_id($id);
    session()->setFlashdata('pesan', 'Data berhasil dihapus');
    echo json_encode(array("status" => TRUE));
  }

  public function deletemultiple()
  {
    if ($this->request->isAjax()) {
      $kode = $this->request->getVar('kode_a');
      $jmldata = count($kode);
      $hapusdata = $this->rwtkeluargaModel->hapusbanyak($kode, $jmldata);
      if ($hapusdata == true) {
        $msg = [
          'sukses' => "$jmldata data berhasil dihapus",
          'kode' => $kode
        ];
      }
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function table_rwtkeluarga()
  {
    $model = new rwtkeluargaModel();
    $data['title'] = 'Tabel rwtkeluarga';
    $data['rwtkeluarga'] = $model->getrwtkeluarga();
    echo view('rwtkeluarga/tabel_rwtkeluarga', $data);
  }

  public function table_detail()
  {
    $id = $_POST['id'];
    // $row = $this->rwtkeluargaModel->find($this->request->getGet('id'));
    $row = $this->rwtkeluargaModel->find($id);
    $data = [
      'title' => 'Detail data',
      'id' => $row['id'],
      'kode' => $row['kode'],
      'nama' => $row['nama'],
    ];
    // $data['title'] = 'Tabel rwtkeluarga';
    // $data['rwtkeluarga'] = $model->getrwtkeluarga();
    echo view('rwtkeluarga/tabel_detail', $data);
  }

  public function simpandatabanyak()
  {
    if ($this->request->isAjax()) {
      $kode = $this->request->getVar('kode');
      $nama = $this->request->getVar('nama');
      $jmldata = count($kode);
      for ($i = 0; $i < $jmldata; $i++) {
        $this->rwtkeluargaModel->insert([
          'kode' => $kode[$i],
          'nama' => $nama[$i],
        ]);
      }
      $msg = [
        'sukses' => '$jmldata data berhasil disimpan',
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function simpan_data_detail()
  {
    if ($this->request->isAjax()) {
      $session = session();
      $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      $kode = $this->request->getVar('kode');
      $nama = $this->request->getVar('nama');
      $jekel = $this->request->getVar('jekel');
      // dd($jekel);
      $jmldata = count($kode);
      $kode_parent = $_POST['kode_parent'];
      $this->rwtkeluargadModel->delete_by_kode($kode_parent);
      for ($i = 0; $i < $jmldata; $i++) {
        if ($nama[$i] != "") {
          $this->rwtkeluargadModel->insert([
            'kode' => $kode[$i],
            'nama' => $nama[$i],
            'jekel' => $jekel[$i],
            'user' => $user,
          ]);
        }
      }
      $msg = [
        'sukses' => $jmldata . ' data berhasil disimpan',
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function cari_data_divisi()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari data',
        'tbdivisi' => $this->tbdivisiModel->orderBy('nama')->findAll() //$rwtkeluarga
      ];
      $msg = [
        'data' => view('rwtkeluarga/modalcari', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function repl_divisi()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['kode_divisi'];
      $row = $this->tbdivisiModel->getkddivisi($kode);
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
