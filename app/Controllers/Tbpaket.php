<?php

namespace App\Controllers;

use App\Models\TbpaketModel;
use App\Models\EstimasiModel;
use App\Models\TbmobilModel;
use App\Models\TbtipeModel;
use App\Models\TbbarangModel;
use App\Models\PaketpartModel;
use App\Models\PaketjasaModel;
use App\Models\PaketbahanModel;
use App\Models\PaketoplModel;
use App\Models\TbbahanModel;
use App\Models\TboplModel;
use App\Models\TbjasaModel;

class Tbpaket extends BaseController
{
  protected $tbpaketModel, $estimasiModel, $tbmobilModel, $tbtipeModel, $tbbarangModel, $paketpartModel, $paketjasaModel, $paketbahanModel, $paketoplModel,
    $tbbahanModel, $tboplModel, $tbjasaModel;
  public function __construct()
  {
    $this->tbpaketModel = new TbpaketModel();
    $this->estimasiModel = new EstimasiModel();
    $this->tbmobilModel = new TbmobilModel();
    $this->tbtipeModel = new TbtipeModel();
    $this->tbbarangModel = new TbbarangModel();
    $this->paketpartModel = new PaketpartModel();
    $this->paketjasaModel = new PaketjasaModel();
    $this->paketbahanModel = new PaketbahanModel();
    $this->paketoplModel = new PaketoplModel();
    $this->tbbahanModel = new TbbahanModel();
    $this->tboplModel = new TboplModel();
    $this->tbjasaModel = new TbjasaModel();
  }

  public function index()
  {
    $data = [
      'menu' => 'file',
      'submenu' => 'tbpaket',
      'submenu1' => 'ref_bengkel',
      'title' => 'Tabel Paket',
      'tbpaket' => $this->tbpaketModel->orderBy('kode', 'desc')->findAll() //$tbpaket
    ];
    echo view('tbpaket/index', $data);
  }

  public function detail($id)
  {
    $data = [
      'title' => 'Detail Tabel Paket',
      'tbpaket' => $this->tbpaketModel->getid($id)
    ];
    if (empty($data['tbpaket'])) {
      throw new \CodeIgniter\Exceptions\PageNotFoundException('Id Paket' . $id . 'tidak ditemukan.');
    }
    return view('tbpaket/detail', $data);
  }

  public function create()
  {
    // session();
    $data = [
      'title' => 'Tambah Tabel Paket',
      'validation' => \Config\Services::validation(),
      'tbtipe' => $this->tbtipeModel->findAll()
    ];
    return view('tbpaket/create', $data);
  }

  public function ajaxLoadData()
  {
    $request = $this->request;
    // dd($request->getPost('order[0][column]'));
    $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
    $katakunci = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
    $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
    $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
    $data = $this->tbpaketModel->tampilData($request, $katakunci, $start, $length);
    $jumlahData = $this->tbpaketModel->tampilData($request, $katakunci);
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
      $row = $this->tbpaketModel->find($id);
      $data = [
        'title' => 'Detail Tabel Paket',
        'tbpaket' => $this->tbpaketModel->find($id),
        'tbtipe' => $this->tbtipeModel->findAll()
      ];
      $msg = [
        'sukses' => view('tbpaket/modaldetail', $data)
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function formdetailpaket()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->tbpaketModel->find($id);
      $data = [
        'title' => 'Detail Tabel Paket',
        'tbpaket' => $this->tbpaketModel->find($id),
        'tbtipe' => $this->tbtipeModel->findAll()
      ];
      $msg = [
        'sukses' => view('tbpaket/modaldetailpaket', $data)
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
        'menu' => 'file',
        'submenu' => 'tbpaket',
        'title' => 'Tambah Data Paket',
        'tbtipe' => $this->tbtipeModel->findAll()
        // 'tbjnbrg' => $this->tbjnbrgModel->getid()
      ];
      // dd($data);
      $msg = [
        'data' => view('tbpaket/modaltambah', $data),
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
          'label' => 'Kode',
          'rules' => 'required|is_unique[tbpaket.kode]',
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
        if ($this->request->getVar('aktif') == 'on') {
          $aktif = 'Y';
        } else {
          $aktif = 'N';
        }
        $simpandata = [
          'kode' => $this->request->getVar('kode'),
          'nama' => $this->request->getVar('nama'),
          'jenis' => $this->request->getVar('jenis'),
          'kdtipe' => $this->request->getVar('kdtipe'),
          'user' => $user,
          'aktif' => $aktif,
        ];
        $this->tbpaketModel->insert($simpandata);
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
      $row = $this->tbpaketModel->find($id);
      $data = [
        'title' => 'Edit Data Paket',
        'tbpaket' => $this->tbpaketModel->find($id),
        'tbtipe' => $this->tbtipeModel->findAll()
      ];

      $msg = [
        'sukses' => view('tbpaket/modaledit', $data)
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
      if ($kode !== $kodelama) {
        $valid = $this->validate([
          'kode' => [
            'label' => 'kode',
            'rules' => 'required|is_unique[tbpaket.kode]',
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
          'jenis' => $this->request->getVar('jenis'),
          'kdtipe' => $this->request->getVar('kdtipe'),
          'user' => $user,
          'aktif' => $aktif,
        ];
        $id = $this->request->getVar('id');
        $this->tbpaketModel->update($id, $simpandata);
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
    $rowtbpaket = $this->tbpaketModel->find($id);
    $rowestimasidetail = $this->estimasiModel->getkodeservice($rowtbpaket['kode']);
    if ($rowestimasidetail) {
      session()->setFlashdata('pesan', 'Data gagal dihapus, sudah terpakai di transaksi');
      echo json_encode(array("status" => FALSE));
    } else {
      $rowestimasidetail = $this->tbmobilModel->gettipe($rowtbpaket['kdtipe']);
      if ($rowestimasidetail) {
        session()->setFlashdata('pesan', 'Data gagal dihapus, sudah terpakai di transaksi');
        echo json_encode(array("status" => FALSE));
      } else {
        $this->tbpaketModel->delete_by_id($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        echo json_encode(array("status" => TRUE));
      }
    }
  }

  public function hapusdetailtbpaket($id)
  {
    $this->paketpartModel->hapusdetailpaket($id);
    session()->setFlashdata('pesan', 'Data berhasil dihapus');
    echo json_encode(array("status" => TRUE));
  }

  public function table_paket()
  {
    $model = new tbpaketmodel();
    $data['title'] = 'Tabel paket';
    $data['tbpaket'] = $model->getid();
    echo view('tbpaket/tabel_paket', $data);
  }

  public function table_paket_part()
  {
    $kdpaket = $_POST['kdpaket'];
    $data = [
      'kdpaket' => $kdpaket,
      'title' => 'Paket Part ',
      'paket_part' => $this->paketpartModel->getkdpaket($kdpaket)
    ];
    // dd($data);
    echo view('tbpaket/tbl_paket_part', $data);
  }
  public function table_paket_jasa()
  {
    $kdpaket = $_POST['kdpaket'];
    $data = [
      'kdpaket' => $kdpaket,
      'title' => 'Paket Jasa ',
      'paket_jasa' => $this->paketjasaModel->getkdpaket($kdpaket)
    ];
    // dd($data);
    echo view('tbpaket/tbl_paket_jasa', $data);
  }
  public function table_paket_bahan()
  {
    $kdpaket = $_POST['kdpaket'];
    $data = [
      'kdpaket' => $kdpaket,
      'title' => 'Paket Bahan ',
      'paket_bahan' => $this->paketbahanModel->getkdpaket($kdpaket)
    ];
    // dd($data);
    echo view('tbpaket/tbl_paket_bahan', $data);
  }
  public function table_paket_opl()
  {
    $kdpaket = $_POST['kdpaket'];
    $data = [
      'kdpaket' => $kdpaket,
      'title' => 'Paket OPL ',
      'paket_opl' => $this->paketoplModel->getkdpaket($kdpaket)
    ];
    // dd($data);
    echo view('tbpaket/tbl_paket_opl', $data);
  }

  public function caridatapart()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data Part',
        'tbbarang' => $this->tbbarangModel->where('aktif', 'Y')->orderBy('kode', 'asc')->findAll() //$rwtkeluarga
      ];
      $msg = [
        'data' => view('tbpaket/modalcaripart', $data),
      ];
      echo json_encode($msg);
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
        'data' => view('tbpaket/modalcarijasa', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function caridatabahan()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data Bahan',
        'tbbahan' => $this->tbbahanModel->where('aktif', 'Y')->orderBy('kode', 'asc')->findAll() //$rwtkeluarga
      ];
      $msg = [
        'data' => view('tbpaket/modalcaribahan', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function caridataopl()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data OPL',
        'tbopl' => $this->tboplModel->where('aktif', 'Y')->orderBy('kode', 'asc')->findAll() //$rwtkeluarga
      ];
      // var_dump($data);
      $msg = [
        'data' => view('tbpaket/modalcariopl', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function replpart()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['kodepart'];
      $row = $this->tbbarangModel->getkdbarang($kode);
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
          'jam' => $row['jam'],
          'frt' => $row['frt'],
        ];
      } else {
        $data = [
          'title' => 'Detail data',
          'kode' => '',
          'nama' => '',
          'harga' => '',
          'jam' => '0',
          'frt' => '0',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function replbahan()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['kodebahan'];
      $row = $this->tbbarangModel->getkdbarang($kode);
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

  public function replopl()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['kodeopl'];
      $row = $this->tboplModel->getkode($kode);
      if (isset($row)) {
        $data = [
          'title' => 'Detail data',
          'kode' => $row['kode'],
          'nama' => $row['nama'],
          'harga' => $row['harga_jual'],
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

  public function simpanpart()
  {
    if ($this->request->isAjax()) {
      $validation = \Config\Services::validation();
      $valid = $this->validate([
        'kodepart' => [
          'label' => 'kodepart',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
          ]
        ],
        'qtypart' => [
          'label' => 'qtypart',
          'rules' => 'required|numeric|greater_than[0]',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'greater_than' => '{field} tidak boleh 0',
          ]
        ],
      ]);
      if (!$valid) {
        $msg = [
          'error' => [
            'kodepart' => $validation->getError('kodepart'),
            'qtypart' => $validation->getError('qtypart'),
          ]
        ];
        echo json_encode($msg);
      } else {
        $kdpaket = $this->request->getVar('kdpaket');
        $kode = $this->request->getVar('kodepart');
        $data = $this->paketpartModel->getdoublebarang($kdpaket, $kode);
        if ($data) {
          $msg = [
            'sukses' => 'Data gagal ditambah'
          ];
          echo json_encode($msg);
        } else {
          $session = session();
          $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
          $simpandata = [
            'kdpaket' => $this->request->getVar('kdpaket'),
            'kode' => $this->request->getVar('kodepart'),
            'nama' => $this->request->getVar('namapart'),
            'jenis' => 'PART',
            'qty' => $this->request->getVar('qtypart'),
            'user' => $user,
          ];
          // var_dump($simpandata);
          if ($this->request->getVar('qtypart') > 0) {
            $this->paketpartModel->insert($simpandata);
            $msg = [
              'sukses' => 'Data berhasil ditambah'
            ];
            // session()->setFlashdata('pesan', 'Data berhasil ditambah');
            echo json_encode($msg);
          } else {
            $msg = [
              'sukses' => 'Data gagal ditambah'
            ];
            // session()->setFlashdata('pesan', 'Data gagal ditambah');
            echo json_encode($msg);
          }
        }
      }
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
        $kdpaket = $this->request->getVar('kdpaket');
        $kode = $this->request->getVar('kodejasa');
        $data = $this->paketjasaModel->getdoublebarang($kdpaket, $kode);
        // var_dump($data);
        if ($data) {
          $msg = [
            'sukses' => 'Data gagal ditambah'
          ];
          echo json_encode($msg);
        } else {
          $session = session();
          $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
          $simpandata = [
            'kdpaket' => $this->request->getVar('kdpaket'),
            'kode' => $this->request->getVar('kodejasa'),
            'nama' => $this->request->getVar('namajasa'),
            'jenis' => 'JASA',
            'jam' => $this->request->getVar('jam'),
            'frt' => str_replace(",", "", $this->request->getVar('frt')),
            'user' => $user,
          ];
          $this->paketjasaModel->insert($simpandata);
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

  public function simpanbahan()
  {
    if ($this->request->isAjax()) {
      $validation = \Config\Services::validation();
      $valid = $this->validate([
        'kodebahan' => [
          'label' => 'kodebahan',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
          ]
        ],
        'qtybahan' => [
          'label' => 'qtybahan',
          'rules' => 'required|numeric|greater_than[0]',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'greater_than' => '{field} tidak boleh 0',
          ]
        ],
      ]);
      if (!$valid) {
        $msg = [
          'error' => [
            'kodebahan' => $validation->getError('kodebahan'),
            'qtybahan' => $validation->getError('qtybahan'),
          ]
        ];
        echo json_encode($msg);
      } else {
        $kdpaket = $this->request->getVar('kdpaket');
        $kode = $this->request->getVar('kodebahan');
        $data = $this->paketbahanModel->getdoublebarang($kdpaket, $kode);
        if ($data) {
          $msg = [
            'sukses' => 'Data gagal ditambah'
          ];
          echo json_encode($msg);
        } else {
          $session = session();
          $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
          $simpandata = [
            'kdpaket' => $this->request->getVar('kdpaket'),
            'kode' => $this->request->getVar('kodebahan'),
            'nama' => $this->request->getVar('namabahan'),
            'jenis' => 'BAHAN',
            'qty' => $this->request->getVar('qtybahan'),
            'user' => $user,
          ];
          if ($this->request->getVar('qtybahan') > 0) {
            $this->paketbahanModel->insert($simpandata);
            $msg = [
              'sukses' => 'Data berhasil ditambah'
            ];
            // session()->setFlashdata('pesan', 'Data berhasil ditambah');
            echo json_encode($msg);
          } else {
            $msg = [
              'sukses' => 'Data gagal ditambah'
            ];
            // session()->setFlashdata('pesan', 'Data gagal ditambah');
            echo json_encode($msg);
          }
        }
      }
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function simpanopl()
  {
    if ($this->request->isAjax()) {
      $validation = \Config\Services::validation();
      $valid = $this->validate([
        'kodeopl' => [
          'label' => 'kodeopl',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
          ]
        ],
        'qtyopl' => [
          'label' => 'qtyopl',
          'rules' => 'required|numeric|greater_than[0]',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'greater_than' => '{field} tidak boleh 0',
          ]
        ],
      ]);
      if (!$valid) {
        $msg = [
          'error' => [
            'kodeopl' => $validation->getError('kodeopl'),
            'qtyopl' => $validation->getError('qtyopl'),
          ]
        ];
        echo json_encode($msg);
      } else {
        $kdpaket = $this->request->getVar('kdpaket');
        $kode = $this->request->getVar('kodeopl');
        $data = $this->paketoplModel->getdoublebarang($kdpaket, $kode);
        if ($data) {
          $msg = [
            'sukses' => 'Data gagal ditambah!'
          ];
          echo json_encode($msg);
        } else {
          $session = session();
          $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
          $simpandata = [
            'kdpaket' => $this->request->getVar('kdpaket'),
            'kode' => $this->request->getVar('kodeopl'),
            'nama' => $this->request->getVar('namaopl'),
            'jenis' => 'OPL',
            'qty' => $this->request->getVar('qtyopl'),
            'user' => $user,
          ];
          if ($this->request->getVar('qtyopl') > 0) {
            $this->paketoplModel->insert($simpandata);
            $msg = [
              'sukses' => 'Data berhasil ditambah!!'
            ];
            // session()->setFlashdata('pesan', 'Data berhasil ditambah');
            echo json_encode($msg);
          } else {
            $msg = [
              'sukses' => 'Data gagal ditambah'
            ];
            // session()->setFlashdata('pesan', 'Data gagal ditambah');
            echo json_encode($msg);
          }
        }
      }
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
}
