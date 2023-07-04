<?php

namespace App\Controllers;

use App\Models\WoModel;
use App\Models\EstimasiModel;
use App\Models\TbcustomerModel;
use App\Models\TbmobilModel;
use App\Models\tbmerekModel;
use App\Models\tbmodelModel;
use App\Models\tbtipeModel;
use App\Models\tbwarnaModel;
use App\Models\tbjenisModel;
use App\Models\WoparttempModel;
use App\Models\TbagamaModel;


class Wo extends BaseController
{
  protected $tbcustomerModel, $estimasiModel, $woModel, $tbmobilModel, $tbmerekModel, $tbmodelModel, $tbtipeModel, $tbwarnaModel, $tbjenisModel, $tbagamaModel;
  public function __construct()
  {
    $this->estimasiModel = new EstimasiModel();
    $this->woModel = new WoModel();
    $this->tbcustomerModel = new TbcustomerModel();
    $this->tbmobilModel = new TbmobilModel();
    $this->tbmerekModel = new TbmerekModel();
    $this->tbmodelModel = new TbmodelModel();
    $this->tbtipeModel = new TbtipeModel();
    $this->tbwarnaModel = new TbwarnaModel();
    $this->tbjenisModel = new TbjenisModel();
    $this->tbcustomerModel = new TbcustomerModel();
    $this->tbagamaModel = new TbagamaModel();
  }

  public function index()
  {
    $data = [
      'menu' => 'transaksi',
      'submenu' => 'wo',
      'submenu1' => 'general_repair',
      'title' => 'Work Order',
      'wo' => $this->woModel->orderBy('noestimasi')->findAll() //$wo
    ];
    echo view('wo/index', $data);
  }

  public function table_mobil()
  {
    $model = new tbmobilmodel();
    $data['title'] = 'Work Order';
    $data['tbmobil'] = $model->getnopolisi();
    // dd($data);
    echo view('wo/tabel_mobil', $data);
  }

  public function detail($id)
  {
    $data = [
      'title' => 'Detail Tabel WO',
      'wo' => $this->woModel->getwo($id)
    ];
    if (empty($data['wo'])) {
      throw new \CodeIgniter\Exceptions\PageNotFoundException('Id WO' . $id . 'tidak ditemukan.');
    }
    return view('wo/detail', $data);
  }

  public function ajaxLoadData()
  {
    $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
    $katakunci = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
    $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
    $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
    // var_dump($nopolisi);
    $this->woModel = new woModel();
    $data = $this->woModel->tampilData($katakunci, $start, $length);
    $jumlahData = $this->woModel->tampilData($katakunci);
    $output = array(
      "draw" => intval($param['draw']),
      "recordsTotal" => count($jumlahData),
      "recordsFiltered" => count($jumlahData),
      "data" => $data,
    );
    // var_dump($data);
    echo json_encode($output);
  }

  public function hitung_wo_part()
  {
    if ($this->request->isAjax()) {
      $kode = $this->request->getVar('kode');
      $jmldata = count($kode);
      for ($i = 0; $i < $jmldata; $i++) {
      }
      $msg = [
        'sukses' => '$jmldata data berhasil disimpan',
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function table_wo_part()
  {
    // $db = \Config\Database::connect();
    // $query   = $db->query("create temporary table temp_wo_part select * from wo_part limit 0");
    // $builder = $db->table('temp_wo_part');
    // $query =  $db->query("insert into temp_wo_part (nowo,user) values ('2222','test')");
    // $query =  $db->query("insert into temp_wo_part (nowo,user) values ('33333','test3333')");
    // $query    = $builder->get();
    // $results = $query->getResultArray();
    // $data['temp_wo_part'] = $results;
    $nowo = $this->request->getVar('nowo');
    $model = new woparttempModel;
    $data = [
      'nowo' => $nowo,
      'title' => 'Estimasi WO',
      'temp_wo_part' => $model->getwoparttemp($nowo)
    ];
    // $data['temp_wo_part'] = $model->getwoparttemp($nowo);
    // dd('nowo' . $data);
    echo view('wo/tabel_wo_part', $data);
    // $msg = [
    //   'sukses' => view('wo/tabel_wo_part', $data)
    // ];
    // echo json_encode($msg);
  }

  public function tambah_wo_part()
  {
    $woparttempModel = new woparttempModel;
    $session = session();
    $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
    $simpandata = [
      'nowo' => $this->request->getVar('nowo'),
      'kodepart' => $this->request->getVar('kodepart'),
      'namapart' => $this->request->getVar('namapart'),
      'qty' => $this->request->getVar('qty'),
      'harga' => $this->request->getVar('harga'),
      'pr_discount' => $this->request->getVar('pr_discount'),
      'subtotal' => $this->request->getVar('subtotal'),
      'user' => $user,
    ];
    $this->$woparttempModel->insert($simpandata);
    $msg = [
      'sukses' => 'Data berhasil ditambah'
    ];
    session()->setFlashdata('pesan', 'Data berhasil ditambah');
    echo json_encode($msg);
    // $model = new woparttempModel;
    // $nowo = $this->request->getVar('nowo');
    // $data = [
    //   'title' => 'Estimasi WO',
    //   'temp_wo_part' => $model->getwoparttemp($nowo)
    // ];
    // $data['temp_wo_part'] = $model->getwoparttemp($nowo);
    // dd('nowo' . $data);
    // echo view('wo/tabel_wo_part', $data);
  }

  // public function hapus_wo_part($id)
  // {
  //   $this->woparttempModel->delete_by_id($id);
  //   session()->setFlashdata('pesan', 'Data berhasil dihapus');
  //   echo json_encode(array("status" => TRUE));
  // }
  public function hapus_wo_part()
  {
    $woparttempModel = new woparttempModel;
    $id = $this->request->getVar('id');
    $this->$woparttempModel->delete_by_id($id);
    session()->setFlashdata('pesan', 'Data berhasil dihapus');
    echo json_encode(array("status" => TRUE));
  }

  public function formdetail()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->tbmobilModel->find($id);
      $data = [
        'title' => 'Detail Data Kendaraan',
        'id' => $row['id'],
        'tbmobil' => $row,
        'tbmerek' => $this->tbmerekModel->getNama(),
        'tbmodel' => $this->tbmodelModel->getMerek(),
        'tbtipe' => $this->tbtipeModel->getModel(),
        'tbwarna' => $this->tbwarnaModel->getNama(),
        'tbjenis' => $this->tbjenisModel->getNama(),
      ];
      $msg = [
        'sukses' => view('tbmobil/modaldetail', $data)
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
        'title' => 'Tambah Data WO',
        'estimasi' => $this->woModel->buatnoestimasi(),
        'tbmobil' => $this->tbmobilModel->findAll(),
      ];
      // var_dump($data);
      $msg = [
        'data' => view('wo/modaltambah', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function tambahestimasi()
  {
    $nopolisi = $_POST['nopolisi'];
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Tambah Data Estimasi / WO',
        'tbmobil' => $this->tbmobilModel->getnopolisi($nopolisi),
      ];
      // var_dump($data);
      $msg = [
        'data' => view('wo/tambahestimasi', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function tambahwo()
  {
    $nopolisi = $_POST['nopolisi'];
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Tambah Data WO',
        'tbmobil' => $this->tbmobilModel->getnopolisi($nopolisi),
      ];
      // var_dump($data);
      $msg = [
        'data' => view('wo/tambahestimasi', $data),
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
        'data' => view('wo/formtambah', $data),
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
        'noestimasi' => [
          'label' => 'noestimasi',
          'rules' => 'required|is_unique[wo.noestimasi]',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'is_unique' => '{field} tidak boleh ada yang sama'
          ]
        ],
        'nopolisi' => [
          'label' => 'nopolisi',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong'
          ]
        ],
      ]);
      if (!$valid) {
        $msg = [
          'error' => [
            'noestimasi' => $validation->getError('noestimasi'),
            'nopolisi' => $validation->getError('nopolisi'),
          ]
        ];
        echo json_encode($msg);
      } else {
        date_default_timezone_set('Asia/Jakarta');
        $noestimasi = 'ES' . date('Y') . date('m') . sprintf("%05s", intval(substr('00000', -5)) + 1);
        $estimasi = $this->woModel->buatnoestimasi();
        foreach ($estimasi as $row) {
          if ($row->noestimasi > 0) {
            $noestimasi = 'ES' . date('Y') . date('m') . sprintf("%05s", intval(substr($row->noestimasi, -5)) + 1);
          }
        }
        $session = session();
        $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        $simpandata = [
          'noestimasi' => $noestimasi, //$this->request->getVar('noestimasi'),
          'tanggal' => $this->request->getVar('tanggal'),
          'nopolisi' => $this->request->getVar('nopolisi'),
          'norangka' => $this->request->getVar('norangka'),
          'kdpemilik' => $this->request->getVar('kdpemilik'),
          'nmpemilik' => $this->request->getVar('nmpemilik'),
          'user' => $user,
        ];
        $this->woModel->insert($simpandata);
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
      $id = $this->request->getVar('id');
      $row = $this->tbmobilModel->find($id);
      $data = [
        'title' => 'Edit Data Kendaraan',
        // 'id' => $row['id'],
        // 'nopolisi' => $row['nopolisi'],
        // 'nama' => $row['nama'],
        // 'aktif' => $row['aktif'],
        'tbmobil' => $row,
        'tbmerek' => $this->tbmerekModel->getNama(),
        'tbmodel' => $this->tbmodelModel->getMerek(),
        'tbtipe' => $this->tbtipeModel->getModel(),
        'tbwarna' => $this->tbwarnaModel->getNama(),
        'tbjenis' => $this->tbjenisModel->getNama(),
      ];
      // var_dump($data);
      $msg = [
        'sukses' => view('tbmobil/modaledit', $data)
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function formeditwo()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $data = [
        'title' => 'Edit Data',
        'wo' => $this->woModel->find($id),
        'tbmobil' => $this->tbmobilModel->findAll(),
      ];
      // var_dump($data);
      $msg = [
        'sukses' => view('wo/modaledit', $data)
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
      $nowolama = $this->request->getVar('nowolama');
      $nowo = $this->request->getVar('nowo');
      if ($nowo != $nowolama) {
        $valid = $this->validate([
          'noestimasi' => [
            'label' => 'noestimasi',
            'rules' => 'required|is_unique[wo.noestimasi]',
            'errors' => [
              'required' => '{field} tidak boleh kosong',
              'is_unique' => '{field} tidak boleh ada yang sama'
            ]
          ],
          'nopolisi' => [
            'label' => 'nopolisi',
            'rules' => 'required',
            'errors' => [
              'required' => '{field} tidak boleh kosong',
              'is_unique' => '{field} tidak boleh ada yang sama'
            ]
          ]
        ]);
      } else {
        $valid = $this->validate([
          'noestimasi' => [
            'label' => 'noestimasi',
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
            'noestimasi' => $validation->getError('noestimasi'),
            'nopolisi' => $validation->getError('nopolisi')
          ]
        ];
        echo json_encode($msg);
      } else {

        date_default_timezone_set('Asia/Jakarta');
        $session = session();
        $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        $simpandata = [
          'noestimasi' => $this->request->getVar('noestimasi'),
          'tanggal' => $this->request->getVar('tanggal'),
          'nopolisi' => $this->request->getVar('nopolisi'),
          'norangka' => $this->request->getVar('norangka'),
          'kdpemilik' => $this->request->getVar('kdpemilik'),
          'nmpemilik' => $this->request->getVar('nmpemilik'),
          'user' => $user,
        ];
        $id = $this->request->getVar('id');
        $this->woModel->update($id, $simpandata);
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
    $this->woModel->delete_by_id($id);
    session()->setFlashdata('pesan', 'Data berhasil dihapus');
    echo json_encode(array("status" => TRUE));
  }

  public function hapusestimasi($id)
  {
    $this->estimasiModel->delete_by_id($id);
    session()->setFlashdata('pesan', 'Data berhasil dihapus');
    echo json_encode(array("status" => TRUE));
  }

  public function hapuswo($id)
  {
    $this->woModel->delete_by_id($id);
    session()->setFlashdata('pesan', 'Data berhasil dihapus');
    echo json_encode(array("status" => TRUE));
  }

  public function hapusmobil($id)
  {
    $this->tbmobilModel->hapusmobil($id);
    session()->setFlashdata('pesan', 'Data berhasil dihapus');
    echo json_encode(array("status" => TRUE));
  }

  public function table_estimasi()
  {
    $id = $_POST['id']; //$this->request->getVar('id'); //$_POST['id'];
    $model = new estimasimodel();
    $data['title'] = 'Estimasi';
    $data['estimasi'] = $model->getid($id);
    // dd($data);
    echo view('wo/tabel_estimasi', $data);
  }

  public function table_wo()
  {
    $nopolisi = $_POST['nopolisi'];
    $model = new womodel();
    $data['title'] = 'Work Order';
    $data['wo'] = $model->getnopolisi($nopolisi);
    echo view('wo/tabel_wo', $data);
  }

  public function formdetailmobil()
  {
    if ($this->request->isAjax()) {
      $this->tbagamaModel->findAll();
      $id = $this->request->getVar('id');
      $row = $this->woModel->find($id);
      $data = [
        'title' => 'Edit Data Kendaraan',
        // 'id' => $row['id'],
        // 'nowo' => $row['nowo'],
        // 'nama' => $row['nama'],
        // 'npwp' => $row['npwp'],
        'wo' => $this->woModel->find($id),
        'tbagama' => $this->tbagamaModel->orderBy('nowo')->findAll(),
      ];
      // var_dump($data);
      $msg = [
        'sukses' => view('wo/formdetailmobil', $data)
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
        'data' => view('wo/modalcari_nopolisi', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function repl_nopolisi()
  {
    if ($this->request->isAjax()) {
      $nowo = $_POST['nopolisi'];
      $row = $this->tbmobilModel->getnopolisi($nowo);
      if (isset($row)) {
        $data = [
          'title' => 'Detail data Kendaraan',
          'nopolisi' => $row['nopolisi'],
          'norangka' => $row['norangka'],
          'nomesin' => $row['nomesin'],
          'kdtipe' => $row['kdtipe'],
          'kdpemilik' => $row['kdpemilik'],
          'nmpemilik' => $row['nmpemilik'],
          'npwp' => $row['npwp'],
          'contact_person' => $row['contact_person'],
          'no_contact_person' => $row['no_contact_person'],
          'id' => $row['id'],

        ];
      } else {
        $data = [
          'title' => 'Detail data',
          'nopolisi' => '',
          'norangka' => '',
          'nomeisn' => '',
          'kdtipe' => '',
          'kdpemilik' => '',
          'nmpemilik' => '',
          'npwp' => '',
          'contact_person' => '',
          'no_contact_person' => '',
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
      'wo' => $this->woModel->getkdcustomer($id),
    ];
    // var_dump($data);
    echo view('wo/tabel_mobil_customer', $data);
  }

  public function modalestimasi()
  {
    $id = $this->request->getVar('id');
    $row = $this->tbmobilModel->find($id);
    $nopolisi = $row['nopolisi'];
    $kdpemilik = $row['kdpemilik'];
    $data = [
      'title' => 'Detail Estimasi & WO',
      'wo' => $this->woModel->getnopolisi($nopolisi),
      'tbmobil' => $this->tbmobilModel->getnopolisi($nopolisi),
      'tbmerek' => $this->tbmerekModel->getNama(),
      'tbmodel' => $this->tbmodelModel->getMerek(),
      'tbtipe' => $this->tbtipeModel->getModel(),
      'tbwarna' => $this->tbwarnaModel->getNama(),
      'tbjenis' => $this->tbjenisModel->getNama(),
      'tbcustomer' => $this->tbcustomerModel->getkdcustomer($kdpemilik),
    ];
    // var_dump($data);
    $msg = [
      'sukses' => view('wo/modalestimasi', $data)
    ];
    echo json_encode($msg);
  }

  public function simpanestimasi()
  {
    if ($this->request->isAjax()) {
      $validation = \Config\Services::validation();
      $valid = $this->validate([
        'kdpemilik' => [
          'label' => 'kdpemilik',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'is_unique' => '{field} tidak boleh ada yang sama'
          ]
        ],
        'nopolisi' => [
          'label' => 'nopolisi',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong'
          ]
        ],
      ]);
      if (!$valid) {
        $msg = [
          'error' => [
            'kdpemilik' => $validation->getError('kdpemilik'),
            'nopolisi' => $validation->getError('nopolisi'),
          ]
        ];
        echo json_encode($msg);
      } else {
        date_default_timezone_set('Asia/Jakarta');
        $noestimasi = 'ES' . date('Y') . date('m') . sprintf("%05s", intval(substr('00000', -5)) + 1);
        $estimasi = $this->estimasiModel->buatnoestimasi();
        if (isset($estimasi)) {
          foreach ($estimasi as $row) {
            if ($row->noestimasi != NULL) {
              $noestimasi = 'ES' . date('Y') . date('m') . sprintf("%05s", intval(substr($row->noestimasi, -5)) + 1);
            }
          }
        }
        $session = session();
        $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        $simpandata = [
          'noestimasi' => $noestimasi, //$this->request->getVar('noestimasi'),
          'tanggal' => $this->request->getVar('tanggal'),
          'nopolisi' => $this->request->getVar('nopolisi'),
          'norangka' => $this->request->getVar('norangka'),
          'kdpemilik' => $this->request->getVar('kdpemilik'),
          'nmpemilik' => $this->request->getVar('nmpemilik'),
          'user' => $user,
        ];
        $this->estimasiModel->insert($simpandata);
        $msg = [
          'sukses' => 'Data berhasil ditambah',
          'noestimasi' => $noestimasi,
        ];
        session()->setFlashdata('pesan', 'Data berhasil ditambah');
        echo json_encode($msg);
      }
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function detailestimasi()
  {
    $id = $this->request->getVar('id');
    $row = $this->estimasiModel->find($id);
    $nopolisi = $row['nopolisi'];
    $kdpemilik = $row['kdpemilik'];
    $data = [
      'title' => 'Detail Estimasi',
      'estimasi' => $this->estimasiModel->find($id),
      'tbmobil' => $this->tbmobilModel->getnopolisi($nopolisi),
      'tbmerek' => $this->tbmerekModel->getNama(),
      'tbmodel' => $this->tbmodelModel->getMerek(),
      'tbtipe' => $this->tbtipeModel->getModel(),
      'tbwarna' => $this->tbwarnaModel->getNama(),
      'tbjenis' => $this->tbjenisModel->getNama(),
      'tbcustomer' => $this->tbcustomerModel->getkdcustomer($kdpemilik),
    ];
    // var_dump($data);
    $msg = [
      'sukses' => view('wo/detailestimasi', $data)
    ];
    echo json_encode($msg);
  }

  public function simpanwo()
  {
    if ($this->request->isAjax()) {
      $validation = \Config\Services::validation();
      $valid = $this->validate([
        'kdpemilik' => [
          'label' => 'kdpemilik',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'is_unique' => '{field} tidak boleh ada yang sama'
          ]
        ],
        'nopolisi' => [
          'label' => 'nopolisi',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong'
          ]
        ],
        // 'keluhan' => [
        //   'label' => 'keluhan',
        //   'rules' => 'required',
        //   'errors' => [
        //     'required' => '{field} tidak boleh kosong'
        //   ]
        // ],
      ]);
      if (!$valid) {
        $msg = [
          'error' => [
            'kdpemilik' => $validation->getError('kdpemilik'),
            'nopolisi' => $validation->getError('nopolisi'),
            'keluhan' => $validation->getError('keluhan'),
          ]
        ];
        echo json_encode($msg);
      } else {
        date_default_timezone_set('Asia/Jakarta');
        $nowo = 'WO' . date('Y') . date('m') . sprintf("%05s", intval(substr('00000', -5)) + 1);
        $wo = $this->woModel->buatnowo();
        foreach ($wo as $row) {
          if ($row->nowo > 0) {
            $nowo = 'WO' . date('Y') . date('m') . sprintf("%05s", intval(substr($row->nowo, -5)) + 1);
          }
        }
        $session = session();
        $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        $simpandata = [
          'nowo' => $nowo, //$this->request->getVar('noestimasi'),
          'tanggal' => $this->request->getVar('tanggal'),
          'nopolisi' => $this->request->getVar('nopolisi'),
          'norangka' => $this->request->getVar('norangka'),
          'kdpemilik' => $this->request->getVar('kdpemilik'),
          'nmpemilik' => $this->request->getVar('nmpemilik'),
          'user' => $user,
        ];
        $this->woModel->insert($simpandata);
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
}
