<?php

namespace App\Controllers;

use App\Models\TbbarangModel;
use App\Models\TbjnbrgModel;
use App\Models\TbsatuanModel;
use App\Models\TbmoveModel;
use App\Models\TbnegaraModel;
use App\Models\TbdiscModel;
use App\Models\EstimasipartModel;

class Tbbarang extends BaseController
{
  protected $tbbarangModel, $tbjnbrgModel, $tbsatuanModel, $tbmoveModel, $tbnegaraModel, $tbdiscModel, $estimasipartModel;
  public function __construct()
  {
    $this->tbbarangModel = new TbbarangModel();
    $this->tbjnbrgModel = new TbjnbrgModel();
    $this->tbsatuanModel = new TbsatuanModel();
    $this->tbmoveModel = new TbmoveModel();
    $this->tbnegaraModel = new TbnegaraModel();
    $this->tbdiscModel = new TbdiscModel();
    $this->estimasipartModel = new EstimasipartModel();
  }

  public function index()
  {
    $data = [
      'menu' => 'file',
      'submenu' => 'tbbarang',
      'title' => 'Tabel Barang',
      'tbbarang' => $this->tbbarangModel->orderBy('kode', 'desc')->findAll() //$tbbarang
    ];
    echo view('tbbarang/index', $data);
  }

  public function detail($id)
  {

    $data = [
      'title' => 'Detail tabel barang',
      'tbbarang' => $this->tbbarangModel->getbarang($id)
    ];
    if (empty($data['tbbarang'])) {
      throw new \CodeIgniter\Exceptions\PageNotFoundException('Id barang' . $id . 'tidak ditemukan.');
    }
    return view('tbbarang/detail', $data);
  }

  public function create()
  {
    // session();
    $data = [
      'title' => 'Tambah tabel barang',
      'validation' => \Config\Services::validation()
    ];
    return view('tbbarang/create', $data);
  }

  public function ajaxLoadData()
  {
    $request = $this->request;
    // dd($request->getPost('order[0][column]'));
    $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
    $katakunci = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
    $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
    $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
    $data = $this->tbbarangModel->tampilData($request, $katakunci, $start, $length);
    $jumlahData = $this->tbbarangModel->tampilData($request, $katakunci);
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
      $row = $this->tbbarangModel->find($id);
      $tbdisc = $this->tbdiscModel->getkode($row['kddiscount']);
      $data = [
        'title' => 'Detail Data Barang',
        // 'id' => $row['id'],
        // 'kode' => $row['kode'],
        // 'nama' => $row['nama'],
        // 'user' => $row['user'],
        'tbbarang' => $this->tbbarangModel->find($id),
        'tbdisc' => $tbdisc,
      ];
      $msg = [
        'sukses' => view('tbbarang/modaldetail', $data)
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
        'submenu' => 'tbbarang',
        'title' => 'Tambah Data Barang',
        // 'tbjnbrg' => $this->tbjnbrgModel->getid()
      ];
      // dd($data);
      $msg = [
        'data' => view('tbbarang/modaltambah', $data),
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
        'title' => 'Tambah Data Barang'
      ];
      $msg = [
        'data' => view('tbbarang/formtambah', $data),
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
          'rules' => 'required|is_unique[tbbarang.kode]',
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
          'lokasi' => $this->request->getVar('lokasi'),
          'merek' => $this->request->getVar('merek'),
          'kdjnbrg' => $this->request->getVar('kdjnbrg'),
          'kdsatuan' => $this->request->getVar('kdsatuan'),
          'kdnegara' => $this->request->getVar('kdnegara'),
          'kdmove' => $this->request->getVar('kdmove'),
          'kddiscount' => $this->request->getVar('kddiscount'),
          'harga_jual' => $this->request->getVar('harga_jual'),
          'harga_beli' => $this->request->getVar('harga_beli'),
          'harga_beli_lama' => $this->request->getVar('harga_beli_lama'),
          'hpp' => $this->request->getVar('hpp'),
          'hpp_lama' => $this->request->getVar('hpp_lama'),
          'stock' => $this->request->getVar('stock'),
          'stock_min' => $this->request->getVar('stock_min'),
          'stock_mak' => $this->request->getVar('stock_mak'),
          'user' => $user,
          'aktif' => $aktif,

        ];
        $this->tbbarangModel->insert($simpandata);
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
      $row = $this->tbbarangModel->find($id);
      $data = [
        'title' => 'Edit Data Barang',
        // 'id' => $row['id'],
        // 'kode' => $row['kode'],
        // 'nama' => $row['nama'],
        'tbbarang' => $this->tbbarangModel->find($id),
      ];
      $msg = [
        'sukses' => view('tbbarang/modaledit', $data)
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
            'rules' => 'required|is_unique[tbbarang.kode]',
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
          'lokasi' => $this->request->getVar('lokasi'),
          'merek' => $this->request->getVar('merek'),
          'kdjnbrg' => $this->request->getVar('kdjnbrg'),
          'kdsatuan' => $this->request->getVar('kdsatuan'),
          'kdnegara' => $this->request->getVar('kdnegara'),
          'kdmove' => $this->request->getVar('kdmove'),
          'kddiscount' => $this->request->getVar('kddiscount'),
          'harga_jual' => $this->request->getVar('harga_jual'),
          'harga_beli' => $this->request->getVar('harga_beli'),
          'harga_beli_lama' => $this->request->getVar('harga_beli_lama'),
          'hpp' => $this->request->getVar('hpp'),
          'hpp_lama' => $this->request->getVar('hpp_lama'),
          'stock' => $this->request->getVar('stock'),
          'stock_min' => $this->request->getVar('stock_min'),
          'stock_mak' => $this->request->getVar('stock_mak'),
          'user' => $user,
          'aktif' => $aktif,
        ];
        $id = $this->request->getVar('id');
        $this->tbbarangModel->update($id, $simpandata);
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
    $rowtbbarang = $this->tbbarangModel->find($id);
    $rowestimasidetail = $this->estimasipartModel->getkode($rowtbbarang['kode']);
    if ($rowestimasidetail) {
      session()->setFlashdata('pesan', 'Data gagal dihapus, sudah terpakai di transaksi');
      echo json_encode(array("status" => FALSE));
    } else {
      $this->tbbarangModel->delete_by_id($id);
      session()->setFlashdata('pesan', 'Data berhasil dihapus');
      echo json_encode(array("status" => TRUE));
    }
  }

  public function table_barang()
  {
    $model = new tbbarangmodel();
    $data['title'] = 'Tabel Barang';
    $data['tbbarang'] = $model->getbarang();
    echo view('tbbarang/tabel_barang', $data);
  }

  public function ambildatatbjnbrg()
  {
    if ($this->request->isAjax()) {
      $kdjnbrg = $this->request->getVar('kdjnbrg');
      $datatbjnbrg = $this->tbjnbrgModel->where('aktif', 'Y')->getkode();
      $isidata = "<option value='' selected>[Pilih Jenis]</option>";
      foreach ($datatbjnbrg as $row) {
        if ($row['kode'] == $kdjnbrg) {
          $isidata .= '<option value="' . $row['kode'] . '" selected>' . $row['nama'] .  ' </option>';
        } else {
          $isidata .= '<option value="' . $row['kode'] . '">' . $row['nama'] . '</option>';
        }
      }
      $msg = [
        'data' => $isidata
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function tambahtbjnbrg()
  {
    if ($this->request->isAjax()) {
      $data = [
        'menu' => 'file',
        'submenu' => 'tbbarang',
        'title' => 'Tambah Data Tabel Jenis Barang',
        // 'tbjnbrg' => $this->tbjnbrgModel->getid()
      ];
      // dd($data);
      $msg = [
        'data' => view('tbbarang/tambahtbjnbrg', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function ambildatatbsatuan()
  {
    if ($this->request->isAjax()) {
      $kdsatuan = $this->request->getVar('kdsatuan');
      $datatbsatuan = $this->tbsatuanModel->where('aktif', 'Y')->getkode();
      $isidata = "<option value='' selected>[Pilih Satuan]</option>";
      foreach ($datatbsatuan as $row) {
        if ($row['kode'] == $kdsatuan) {
          $isidata .= '<option value="' . $row['kode'] . '" selected>' . $row['nama'] .  ' </option>';
        } else {
          $isidata .= '<option value="' . $row['kode'] . '">' . $row['nama'] . '</option>';
        }
      }
      $msg = [
        'data' => $isidata
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function tambahtbsatuan()
  {
    if ($this->request->isAjax()) {
      $data = [
        'menu' => 'file',
        'submenu' => 'tbbarang',
        'title' => 'Tambah Data Tabel Satuan',
        // 'tbsatuan' => $this->tbsatuanModel->getid()
      ];
      // dd($data);
      $msg = [
        'data' => view('tbbarang/tambahtbsatuan', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function ambildatatbmove()
  {
    if ($this->request->isAjax()) {
      $kdmove = $this->request->getVar('kdmove');
      $datatbmove = $this->tbmoveModel->where('aktif', 'Y')->getkode();
      $isidata = "<option value='' selected>[Pilih Moving]</option>";
      foreach ($datatbmove as $row) {
        if ($row['kode'] == $kdmove) {
          $isidata .= '<option value="' . $row['kode'] . '" selected>' . $row['nama'] .  ' </option>';
        } else {
          $isidata .= '<option value="' . $row['kode'] . '">' . $row['nama'] . '</option>';
        }
      }
      $msg = [
        'data' => $isidata
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function tambahtbmove()
  {
    if ($this->request->isAjax()) {
      $data = [
        'menu' => 'file',
        'submenu' => 'tbbarang',
        'title' => 'Tambah Data Tabel Move',
        // 'tbmove' => $this->tbmoveModel->getid()
      ];
      // dd($data);
      $msg = [
        'data' => view('tbbarang/tambahtbmove', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function tambahtbdisc()
  {
    if ($this->request->isAjax()) {
      $data = [
        'menu' => 'file',
        'submenu' => 'tbbarang',
        'title' => 'Tambah Data Tabel Discount',
        // 'tbmove' => $this->tbmoveModel->getid()
      ];
      // dd($data);
      $msg = [
        'data' => view('tbbarang/tambahtbdisc', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
  public function ambildatatbdisc()
  {
    if ($this->request->isAjax()) {
      $kddiscount = $this->request->getVar('kddiscount');
      $datatbdisc = $this->tbdiscModel->where('aktif', 'Y')->getkode();
      $isidata = "<option value='' selected>[Pilih Kode Discount]</option>";
      foreach ($datatbdisc as $row) {
        if ($row['kode'] == $kddiscount) {
          $isidata .= '<option value="' . $row['kode'] . '" selected>' . $row['kode'] . ' | ' . $row['disc_normal'] .  ' </option>';
        } else {
          $isidata .= '<option value="' . $row['kode'] . '">' . $row['kode'] . ' | ' . $row['disc_normal'] . '</option>';
        }
      }
      $msg = [
        'data' => $isidata,
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function tambahtbnegara()
  {
    if ($this->request->isAjax()) {
      $data = [
        'menu' => 'file',
        'submenu' => 'tbbarang',
        'title' => 'Tambah Data Tabel Negara',
        // 'tbmove' => $this->tbmoveModel->getid()
      ];
      // dd($data);
      $msg = [
        'data' => view('tbbarang/tambahtbnegara', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function caridatanegara()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data Negara',
        'tbnegara' => $this->tbnegaraModel->where('aktif', 'Y')->orderBy('kode', 'asc')->findAll() //$rwtkeluarga
      ];
      $msg = [
        'data' => view('tbbarang/modalcarinegara', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function replnegara()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['kdnegara'];
      $row = $this->tbnegaraModel->getkode($kode);
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

  public function repldiscount()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['kddiscount'];
      $row = $this->tbdiscModel->getkode($kode);
      if (isset($row)) {
        $data = [
          'title' => 'Detail data',
          'kode' => $row['kode'],
          'disc_normal' => $row['disc_normal'],
        ];
      } else {
        $data = [
          'title' => 'Detail data',
          'kode' => '',
          'disc_normal' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
}
