<?php

namespace App\Controllers;

use App\Models\TbjasaModel;
use App\Models\EstimasijasaModel;
use PHPExcel;
use PHPExcel_IOFactory;

class Tbjasa extends BaseController
{
  protected $tbjasaModel, $estimasijasaModel;
  public function __construct()
  {
    $this->tbjasaModel = new TbjasaModel();
    $this->estimasijasaModel = new EstimasijasaModel();
  }

  public function index()
  {
    $data = [
      'menu' => 'file',
      'submenu' => 'tbjasa',
      'title' => 'Tabel jasa',
      'tbjasa' => $this->tbjasaModel->orderBy('kode', 'desc')->findAll() //$tbjasa
    ];
    echo view('tbjasa/index', $data);
  }

  public function detail($id)
  {
    $data = [
      'title' => 'Detail Tabel jasa',
      'tbjasa' => $this->tbjasaModel->getid($id)
    ];
    if (empty($data['tbjasa'])) {
      throw new \CodeIgniter\Exceptions\PageNotFoundException('Id jasa' . $id . 'tidak ditemukan.');
    }
    return view('tbjasa/detail', $data);
  }

  public function create()
  {
    // session();
    $data = [
      'title' => 'Tambah Tabel jasa',
      'validation' => \Config\Services::validation()
    ];
    return view('tbjasa/create', $data);
  }

  public function ajaxLoadData()
  {
    $request = $this->request;
    // dd($request->getPost('order[0][column]'));
    $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
    $katakunci = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
    $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
    $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
    $data = $this->tbjasaModel->tampilData($request, $katakunci, $start, $length);
    $jumlahData = $this->tbjasaModel->tampilData($request, $katakunci);
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
      $row = $this->tbjasaModel->find($id);
      $parent_id = $row['parent_id'];
      $data = [
        'title' => 'Detail Tabel Jasa',
        'tbjasa' => $this->tbjasaModel->find($id),
        'tbjasap' => $this->tbjasaModel->getparent_id($parent_id),
      ];
      $msg = [
        'sukses' => view('tbjasa/modaldetail', $data)
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
        'submenu' => 'tbjasa',
        'title' => 'Tambah Data jasa',
        // 'tbjnbrg' => $this->tbjnbrgModel->getid()
      ];
      // dd($data);
      $msg = [
        'data' => view('tbjasa/modaltambah', $data),
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
          'rules' => 'required|is_unique[tbjasa.kode]',
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
        $user = "Tambah-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        if ($this->request->getVar('aktif') == 'on') {
          $aktif = 'Y';
        } else {
          $aktif = 'N';
        }
        $parent = $this->request->getVar('exampleRadios');
        if ($parent == "option1") {
          $parent = 'Y';
        } else {
          $parent = 'N';
        }
        $simpandata = [
          'kode' => $this->request->getVar('kode'),
          'nama' => $this->request->getVar('nama'),
          'parent' => $parent,
          'parent_id' => $this->request->getVar('parent_id'),
          'parent_name' => $this->request->getVar('parent_name'),
          'jam' => $this->request->getVar('jam'),
          'frt' => $this->request->getVar('frt'),
          'harga' => $this->request->getVar('harga'),
          'user' => $user,
          'aktif' => $aktif,
        ];
        $this->tbjasaModel->insert($simpandata);
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
      $row = $this->tbjasaModel->find($id);
      $parent_id = $row['parent_id'];
      $data = [
        'title' => 'Edit Data jasa',
        'tbjasa' => $this->tbjasaModel->find($id),
        'tbjasap' => $this->tbjasaModel->getparent_id($parent_id),
      ];

      $msg = [
        'sukses' => view('tbjasa/modaledit', $data)
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
            'rules' => 'required|is_unique[tbjasa.kode]',
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
        $parent = $this->request->getVar('exampleRadios');
        if ($parent == "option1") {
          $parent = 'Y';
        } else {
          $parent = 'N';
        }
        $simpandata = [
          'kode' => $this->request->getVar('kode'),
          'nama' => $this->request->getVar('nama'),
          'parent' => $parent,
          'parent_id' => $this->request->getVar('parent_id'),
          'parent_name' => $this->request->getVar('parent_name'),
          'jam' => $this->request->getVar('jam'),
          'frt' => $this->request->getVar('frt'),
          'harga' => $this->request->getVar('harga'),
          'user' => $user,
          'aktif' => $aktif,
        ];
        $id = $this->request->getVar('id');
        $this->tbjasaModel->update($id, $simpandata);
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
    $rowtbjasa = $this->tbjasaModel->find($id);
    $rowestimasidetail = $this->estimasijasaModel->getkode($rowtbjasa['kode']);
    if ($rowestimasidetail) {
      session()->setFlashdata('pesan', 'Data gagal dihapus, sudah terpakai di transaksi');
      echo json_encode(array("status" => FALSE));
    } else {
      $this->tbjasaModel->delete_by_id($id);
      session()->setFlashdata('pesan', 'Data berhasil dihapus');
      echo json_encode(array("status" => TRUE));
    }
  }

  public function table_jasa()
  {
    $model = new tbjasamodel();
    $data['title'] = 'Tabel jasa';
    $data['tbjasa'] = $model->getid();
    echo view('tbjasa/tabel_jasa', $data);
  }

  public function tambahtbsupplier()
  {
    if ($this->request->isAjax()) {
      $data = [
        'menu' => 'file',
        'submenu' => 'tbsupplier',
        'title' => 'Tambah Data Tabel Supplier',
        // 'tbjnbrg' => $this->tbjnbrgModel->getid()
      ];
      // dd($data);
      $msg = [
        'data' => view('tbjasa/tambahtbsupplier', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function cariparent()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data Parent Jasa',
        'tbjasap' => $this->tbjasaModel->where('parent', 'Y')->where('aktif', 'Y')->orderBy('kode', 'asc')->findAll() //$rwtkeluarga
      ];
      $msg = [
        'data' => view('tbjasa/modalcarijasaP', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
  public function replparent()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['parent_id'];
      $row = $this->tbjasaModel->getkode($kode);
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

  public function importdata()
  {
    $validation = \Config\Services::validation();
    $valid = $this->validate([
      'fileimport' => [
        'label' => 'Inputan File',
        'rules' => 'uploaded[fileimport]|ext_in[fileimport,xls,xlsx],required',
        'errors' => [
          'required' => '{field} tidak boleh kosong',
          'uploaded' => '{field} tidak boleh kosong',
          'ext_in' => '{field} harus extensi xls atau xlsx',
        ]
      ]
    ]);
    if (!$valid) {
      $msg = [
        'error' => [
          'pesan' => $validation->getError('fileimport'),
        ]
      ];
      return redirect()->to('/tbjasa/index');
      echo json_encode($msg);
    } else {
      $file_excel = $this->request->getfile('fileimport');
      $ext = $file_excel->getClientExtension();
      if ($ext == "xls") {
        $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
      } else {
        $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
      }
      $spreedsheet = $render->load($file_excel);
      $data = $spreedsheet->getActiveSheet()->toArray();
      $jmlupdate = 0;
      $jmlinsert = 0;
      foreach ($data as $x => $row) {
        if ($x == 0) {
          continue;
        }
        $kode = $row[1];
        $nama = $row[2];
        $parent = $row[3];
        $parent_id = $row[4];
        $parent_name = $row[5];
        $jam = $row[6];
        $frt = $row[7];
        $harga = $row[8];
        // echo $kode . ' - ' . $nama . '<br>';
        //cek terlebih dahulu apa sudah ada datanya
        $row = $this->tbjasaModel->getkode($kode);
        if ($row) {
          $jmlupdate++;
          continue;
        } else {
          $jmlinsert++;
          $session = session();
          $user = "Tambah-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
          $simpandata = [
            'kode' => $kode,
            'nama' => $nama,
            'parent' => $parent,
            'parent_id' => $parent_id,
            'parent_name' => $parent_name,
            'jam' => $jam,
            'frt' => $frt,
            'harga' => $harga,
            'user' => $user,
            'aktif' => 'Y',
          ];
          $this->tbjasaModel->insert($simpandata);
        }
      }
      // $msg = [
      //   'pesan' => $jmlupdate . 'data berhasil dipudate' . $jmlinsert . ' data berhasil ditambah'
      // ];
      // echo json_encode($msg);
      session()->setFlashdata('pesan', $jmlupdate . 'data berhasil dipudate' . $jmlinsert . ' data berhasil ditambah');
      // echo json_encode(array("status" => TRUE));
      // return redirect()->to('/tbjasa');
      echo "<script>
        alert($jmlupdate+' data berhasil dipudate, '+$jmlinsert+ ' data berhasil ditambah');
        window.location.href='/tbjasa';
      </script>";
    }
  }
}
