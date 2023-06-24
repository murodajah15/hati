<?php

namespace App\Controllers;

use App\Models\Tasklist_bpModel;
use App\Models\TbasuransiModel;
use App\Models\TbjasaModel;
use App\Models\Tasklist_bpdModel;
use App\Models\TbklpjasaModel;

class Tasklist_bp extends BaseController
{
  protected $tasklist_bpModel, $tbasuransiModel, $tbjasaModel, $tasklist_bpdModel, $tbklpjasaModel;
  public function __construct()
  {
    $this->tasklist_bpModel = new Tasklist_bpModel();
    $this->tbasuransiModel = new TbasuransiModel();
    $this->tbjasaModel = new TbjasaModel();
    $this->tasklist_bpdModel = new Tasklist_bpdModel();
    $this->tbklpjasaModel = new TbklpjasaModel();
  }

  public function index()
  {
    $data = [
      'menu' => 'file',
      'submenu' => 'tasklist_bp',
      'title' => 'Task List Body Repair',
      'tasklist_bp' => $this->tasklist_bpModel->orderBy('kode')->findAll() //$tasklist_bp
    ];
    echo view('tasklist_bp/index', $data);
  }

  public function formdetail()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->tasklist_bpModel->find($id);
      $data = [
        'title' => 'Detail Data',
        'id' => $row['id'],
        // 'kode' => $row['kode'],
        // 'nama' => $row['nama'],
        // 'user' => $row['user'],
        // 'aktif' => $row['aktif'],
        'tasklist_bp' => $row,
        'tbasuransi' => $this->tbasuransiModel->findAll(),
      ];
      $msg = [
        'sukses' => view('tasklist_bp/modaldetail', $data)
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function formdetailtasklist_bp()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      // $row = $this->tasklist_bpModel->find($id);
      $data = [
        'title' => 'Detail Tasklist',
        'tasklist_bp' => $this->tasklist_bpModel->find($id),
        'tbjasa' => $this->tbjasaModel->findAll()
      ];
      $msg = [
        'sukses' => view('tasklist_bp/modaldetailtasklist', $data)
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function detail($id)
  {
    $data = [
      'title' => 'Detail Tabel Kelompok Jasa',
      'tasklist_bp' => $this->tasklist_bpModel->getid($id),
      'tbasuransi' => $this->tbasuransiModel->findAll(),
    ];
    if (empty($data['tasklist_bp'])) {
      throw new \CodeIgniter\Exceptions\PageNotFoundException('Id Kelompok Jasa' . $id . 'tidak ditemukan.');
    }
    return view('tasklist_bp/modaldetail', $data);
  }

  public function create()
  {
    // session();
    $data = [
      'title' => 'Tambah Data Tabel Kelompok Jasa',
      'validation' => \Config\Services::validation()
    ];
    return view('tasklist_bp/formtambah', $data);
  }

  public function ajaxLoadData()
  {
    $request = $this->request;
    $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
    $katakunci = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
    $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
    $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
    $data = $this->tasklist_bpModel->tampilData($request, $katakunci, $start, $length);
    $jumlahData = $this->tasklist_bpModel->tampilData($request, $katakunci);
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
        'title' => 'Tambah Data',
        'tbasuransi' => $this->tbasuransiModel->findAll(),
      ];
      $msg = [
        'data' => view('tasklist_bp/modaltambah', $data),
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
          'rules' => 'required|is_unique[tasklist_bp.kode]',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'is_unique' => '{field} tidak boleh ada yang sama'
          ]
        ],
        'nama' => [
          'label' => 'nama',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
          ],
        ],
        'kdasuransi' => [
          'label' => 'kdasuransi',
          'rules' => 'required|is_unique[tasklist_bp.kdasuransi]',
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
            'kdasuransi' => $validation->getError('kdasuransi'),
            'nmasuransi' => $validation->getError('nmasuransi'),
          ]
        ];
        echo json_encode($msg);
      } else {
        $session = session();
        $user = "Tambah-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        $kode = 'TLBP' . sprintf("%05s", intval(substr('00000', -5)) + 1);
        $tl = $this->tasklist_bpModel->buatnomor();
        if (isset($tl)) {
          foreach ($tl as $row) {
            if ($row->kode != NULL) {
              $kode = 'TLBP' . sprintf("%05s", intval(substr($row->kode, -5)) + 1);
            }
          }
        }
        if ($this->request->getVar('aktif') == 'on') {
          $aktif = 'Y';
        } else {
          $aktif = 'N';
        }
        $rowasuransi = $this->tbasuransiModel->getkode($this->request->getVar('kdasuransi'));
        $nmasuransi = $rowasuransi['nama'];
        $simpandata = [
          'kode' => $kode, //$this->request->getVar('kode'),
          'nama' => $this->request->getVar('nama'),
          'kdasuransi' => $this->request->getVar('kdasuransi'),
          'nmasuransi' => $nmasuransi,
          'aktif' => $aktif, //$this->request->getVar('aktif'),
          'user' => $user,
        ];
        $this->tasklist_bpModel->insert($simpandata);
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
      $row = $this->tasklist_bpModel->find($id);
      $data = [
        'title' => 'Edit Data Tabel Kelompok Jasa',
        // 'id' => $row['id'],
        // 'kode' => $row['kode'],
        // 'nama' => $row['nama'],
        // 'aktif' => $row['aktif'],
        'tasklist_bp' => $row,
        'tbasuransi' => $this->tbasuransiModel->findAll(),
      ];
      $msg = [
        'sukses' => view('tasklist_bp/modaledit', $data)
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
            'rules' => 'required|is_unique[tasklist_bp.kode]',
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
        $rowasuransi = $this->tbasuransiModel->getkode($this->request->getVar('kdasuransi'));
        $nmasuransi = $rowasuransi['nama'];
        $simpandata = [
          'kode' => $this->request->getVar('kode'),
          'nama' => $this->request->getVar('nama'),
          'kdasuransi' => $this->request->getVar('kdasuransi'),
          'nmasuransi' => $nmasuransi,
          'aktif' => $aktif, //$this->request->getVar('aktif'),
          'user' => $user,
        ];
        $id = $this->request->getVar('id');
        $this->tasklist_bpModel->update($id, $simpandata);
        // if ($this->request->getVar('kdasuransilama') != $this->request->getVar('kdasuransi')) {
        $rowtasklistd = $this->tasklist_bpdModel->getkdtl($this->request->getVar('kode'));
        // var_dump($rowtasklistd);
        if ($rowtasklistd) {
          foreach ($rowtasklistd as $row) {
            $id = $row['id'];
            $kode = $row['kode'];
            $nama = $row['nama'];
            $harga = $row['harga'];
            $kdasuransi = $this->request->getVar('kdasuransi');
            $simpandata = [
              'kode' => $kode,
              'nama' => $nama,
              'harga' => $harga,
              'kdasuransi' => $kdasuransi,
              'user' => $user,
            ];
            // var_dump($simpandata);
            $this->tasklist_bpdModel->update($id, $simpandata);
          }
        }
        // }
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
    $rowtasklist_bp = $this->tasklist_bpModel->find($id);
    // $rowtbbarang = $this->tbbarangModel->getkodesatuan($rowtasklist_bp['kode']);
    // if ($rowtbbarang) {
    //   session()->setFlashdata('pesan', 'Data gagal dihapus, sudah terpakai di transaksi');
    //   echo json_encode(array("status" => FALSE));
    // } else {
    $this->tasklist_bpModel->delete_by_id($id);
    session()->setFlashdata('pesan', 'Data berhasil dihapus');
    echo json_encode(array("status" => TRUE));
    // }
  }

  public function hapusdetailtasklist_bpd($id)
  {
    $this->tasklist_bpdModel->delete_by_id($id);
    session()->setFlashdata('pesan', 'Data berhasil dihapus');
    echo json_encode(array("status" => TRUE));
  }

  public function table_tasklist_bp()
  {
    $model = new tasklist_bpmodel();
    $data['title'] = 'Tasklist Body Repair';
    $data['tasklist_bp'] = $model->getkode();
    // dd($data);
    echo view('tasklist_bp/tabel_tasklist_bp', $data);
  }

  public function table_tasklist_bpd()
  {
    $kdtasklist = $_POST['kdtasklist'];
    $data = [
      'kdtasklist' => $kdtasklist,
      'title' => 'Task List Body Repair ',
      'tasklist_bpd' => $this->tasklist_bpdModel->getkdtl($kdtasklist)
    ];
    echo view('tasklist_bp/tabel_tasklist_bpd', $data);
  }

  public function caridatatbklpjasa()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data tbklpjasa',
        'tbtbklpjasa' => $this->tbklpjasaModel->where('aktif', 'Y')->orderBy('kode', 'asc')->findAll() //$rwtkeluarga
      ];
      $msg = [
        'data' => view('tasklist_bp/caridatatbklpjasa', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
  public function repltbklpjasa()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['kode'];
      $row = $this->tbklpjasaModel->getkode($kode);
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

  public function caridatatasklist_salin()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data tasklist_salin',
        'tasklist_bp' => $this->tasklist_bpModel->where('aktif', 'Y')->orderBy('kode', 'asc')->findAll() //$rwtkeluarga
      ];
      $msg = [
        'data' => view('tasklist_bp/caridatatasklist_salin', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
  public function repltasklist_salin()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['kode'];
      $row = $this->tasklist_bpModel->getkode($kode);
      if (isset($row)) {
        $data = [
          'title' => 'Detail data',
          'kode' => $row['kode'],
          'nama' => $row['nama'],
          'nmasuransi' => $row['nmasuransi'],
        ];
      } else {
        $data = [
          'title' => 'Detail data',
          'kode' => '',
          'nama' => '',
          'nmasuransi' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function salindetailtasklist_bpd()
  {
    // $simpandata = [
    //   'kdtasklist' => $this->request->getVar('kdtasklist'),
    //   'kdtasklist_salin' => $this->request->getVar('kdtasklist_salin'),
    //   'nmtasklist_salin' => $this->request->getVar('nmtasklist_salin'),
    //   'kdasuransi_salin' => $this->request->getVar('kdasuransi_salin'),
    //   'nmasuransi_salin' => $this->request->getVar('nmasuransi_salin'),
    // ];
    // var_dump($simpandata);
    $session = session();
    $kdtasklist_salin = $this->request->getVar('kdtasklist_salin');
    $kdasuransi = $this->request->getVar('kdasuransi');
    if ($kdtasklist_salin == "") {
      $msg = [
        'sukses' => 'Data gagal ditambah'
      ];
    } else {
      $kdtasklist = $this->request->getVar('kdtasklist');
      $row = $this->tasklist_bpdModel->getkdtl($kdtasklist_salin);
      foreach ($row as $data) {
        $kode = $data['kode'];
        $nama = $data['nama'];
        $harga = $data['harga'];
        $cek = $this->tasklist_bpdModel->getdata($kdtasklist, $kode);
        if ($cek) {
          foreach ($cek as $datacek) {
            $id = $datacek['id'];
          }
          $user = "Update-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
          $simpandata = [
            'kdasuransi' => $this->request->getVar('kdasuransi'),
            'kdtasklist' => $kdtasklist,
            'kode' => $kode,
            'nama' =>  $nama,
            'harga' => $harga,
            'user' => $user,
          ];
          $this->tasklist_bpdModel->update($id, $simpandata);
        } else {
          $user = "Tambah-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
          $simpandata = [
            'kdasuransi' => $this->request->getVar('kdasuransi'),
            'kdtasklist' => $kdtasklist,
            'kode' => $kode,
            'nama' =>  $nama,
            'harga' => $harga,
            'user' => $user,
          ];
          $this->tasklist_bpdModel->insert($simpandata);
        }
      }
      $msg = [
        'sukses' => 'Data berhasil ditambah'
      ];
      // session()->setFlashdata('pesan', 'Data berhasil ditambah');
    }
    echo json_encode($msg);
  }

  public function caridataasuransi()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data Asuransi',
        'tbasuransi' => $this->tbasuransiModel->where('aktif', 'Y')->orderBy('kode', 'asc')->findAll() //$rwtkeluarga
      ];
      $msg = [
        'data' => view('tasklist_bp/caridataasuransi', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
  public function replasuransi()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['kdasuransi'];
      $row = $this->tbasuransiModel->getkode($kode);
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

  public function caridatajasa()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data jasa',
        'tbjasa' => $this->tbjasaModel->where('aktif', 'Y')->where('parent', 'N')->orderBy('kode', 'asc')->findAll() //$rwtkeluarga
      ];
      // var_dump($data);
      $msg = [
        'data' => view('tasklist_bp/modalcarijasa', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
  public function repljasa()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['kodejasa'];
      $row = $this->tbjasaModel->getkode($kode);
      if (isset($row)) {
        $data = [
          'title' => 'Detail data',
          'kode' => $row['kode'],
          'nama' => $row['nama'],
          'harga' => $row['harga'],
        ];
      } else {
        $data = [
          'title' => 'Detail data',
          'kode' => '',
          'nama' => '',
          'harga' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function simpanjasa()
  {
    if ($this->request->isAjax()) {
      $validation = \Config\Services::validation();
      $valid = $this->validate([
        'kodejasa' => [
          'label' => 'kodejasa',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
          ]
        ],
        // 'qtyjasa' => [
        //   'label' => 'qtyjasa',
        //   'rules' => 'required|numeric|greater_than[0]',
        //   'errors' => [
        //     'required' => '{field} tidak boleh kosong',
        //     'greater_than' => '{field} tidak boleh 0',
        //   ]
        // ],
      ]);
      if (!$valid) {
        $msg = [
          'error' => [
            'kodejasa' => $validation->getError('kodejasa'),
            // 'qtyjasa' => $validation->getError('qtyjasa'),
          ]
        ];
        echo json_encode($msg);
      } else {
        $session = session();
        $kdtasklist = $this->request->getVar('kdtasklist');
        $kode = $this->request->getVar('kodejasa');
        $data = $this->tasklist_bpdModel->getdoublebarang($kdtasklist, $kode);
        // var_dump($data);
        if ($data) {
          foreach ($data as $row) {
            $id = $row['id'];
          }
          $user = "Update-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
          $simpandata = [
            'kdasuransi' => $this->request->getVar('kdasuransi'),
            'kdtasklist' => $this->request->getVar('kdtasklist'),
            'kode' => $this->request->getVar('kodejasa'),
            'nama' => $this->request->getVar('namajasa'),
            'harga' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('harga')),
            'user' => $user,
          ];
          $this->tasklist_bpdModel->update($id, $simpandata);
          $msg = [
            'sukses' => 'Data berhasil diupdate'
          ];
          // $msg = [
          //   'sukses' => 'Data gagal ditambah'
          // ];
          echo json_encode($msg);
        } else {
          $user = "Tambah-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
          $simpandata = [
            'kdasuransi' => $this->request->getVar('kdasuransi'),
            'kdtasklist' => $this->request->getVar('kdtasklist'),
            'kode' => $this->request->getVar('kodejasa'),
            'nama' => $this->request->getVar('namajasa'),
            'harga' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('harga')),
            'user' => $user,
          ];
          $this->tasklist_bpdModel->insert($simpandata);
          $msg = [
            'sukses' => 'Data berhasil ditambah'
          ];
          // session()->setFlashdata('pesan', 'Data berhasil ditambah');
          echo json_encode($msg);
        }
      }
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
}
