<?php

namespace App\Controllers;

use App\Models\Beli_partModel;
use App\Models\Beli_partdModel;
use App\Models\Po_partModel;
use App\Models\Po_partdModel;
use App\Models\TbsupplierModel;
use App\Models\TbbarangModel;

use \Dompdf\Dompdf;

class Beli_part extends BaseController
{
  protected $beli_partModel, $beli_partdModel, $po_partModel, $po_partdModel, $tbsupplierModel, $tbbarangModel;

  public function __construct()
  {
    $this->beli_partModel = new Beli_partModel();
    $this->beli_partdModel = new Beli_partdModel();
    $this->po_partModel = new Po_partModel();
    $this->po_partdModel = new Po_partdModel();
    $this->tbsupplierModel = new TbsupplierModel();
    $this->tbbarangModel = new TbbarangModel();
  }

  public function index()
  {
    $data = [
      'menu' => 'transaksi',
      'submenu' => 'beli_part',
      'submenu1' => 'spare_part',
      'title' => 'Pembelian Spare Part',
      'beli_part' => $this->beli_partModel->orderBy('nobeli')->findAll() //$wo
    ];
    echo view('beli_part/index', $data);
  }

  public function ajaxLoadData()
  {
    $request = $this->request;
    $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
    $katakunci = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
    $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
    $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
    $data = $this->beli_partModel->tampilData($request, $katakunci, $start, $length);
    $jumlahData = $this->beli_partModel->tampilData($request, $katakunci);
    $output = array(
      "draw" => intval($param['draw']),
      "recordsTotal" => count($jumlahData),
      "recordsFiltered" => count($jumlahData),
      "data" => $data,
    );
    echo json_encode($output);
  }

  public function table_beli_part()
  {
    $model = new beli_partModel();
    $data['title'] = 'Pembelian Spare Part';
    $data['beli_part'] = $model->findAll();
    // var_dump($data['beli_part']);
    echo view('beli_part/tabel_beli_part', $data);
  }

  public function formdetail()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->beli_partModel->find($id);
      $kdsupplier = $row['kdsupplier'];
      $data = [
        'title' => 'Detail Pembelian Spare Part',
        'beli_part' => $this->beli_partModel->find($id),
        'tbsupplier' => $this->tbsupplierModel->getkode($kdsupplier),
      ];
      // var_dump($data);
      $msg = [
        'sukses' => view('beli_part/modaldetail', $data)
      ];
      echo json_encode($msg);
    }
  }

  public function formtambah()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Tambah Data Pembelian Spare Part',
        'beli_part' => $this->beli_partModel->findAll(),
      ];
      $msg = [
        'data' => view('beli_part/modaltambah', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function simpanbeli_part()
  {
    if ($this->request->isAjax()) {
      $validation = \Config\Services::validation();
      $valid = $this->validate([
        'kdsupplier' => [
          'label' => 'kdsupplier',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong'
          ]
        ],
        'jnsorder' => [
          'label' => 'jnsorder',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'is_unique' => '{field} tidak boleh ada yang sama'
          ]
        ],
      ]);
      if (!$valid) {
        $msg = [
          'error' => [
            'jnsorder' => $validation->getError('jnsorder'),
            'kdsupplier' => $validation->getError('kdsupplier'),
          ]
        ];
        echo json_encode($msg);
      } else {
        date_default_timezone_set('Asia/Jakarta');
        $nobeli = 'BL' . date('Y') . date('m') . sprintf("%05s", intval(substr('00000', -5)) + 1);
        $beli = $this->beli_partModel->buatnobeli();
        if (isset($beli)) {
          foreach ($beli as $row) {
            if ($row->nobeli != NULL) {
              $nobeli = 'BL' . date('Y') . date('m') . sprintf("%05s", intval(substr($row->nobeli, -5)) + 1);
            }
          }
        }
        $session = session();
        $user = "Tambah-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        $simpandata = [
          'nobeli' => $nobeli, //$this->request->getVar('nopo'),
          'tanggal' => $this->request->getVar('tanggal'),
          'nopo' => $this->request->getVar('nopo'),
          'tglpo' => $this->request->getVar('tglpo'),
          'kdsupplier' => $this->request->getVar('kdsupplier'),
          'nmsupplier' => $this->request->getVar('nmsupplier'),
          'jnsorder' => $this->request->getVar('jnsorder'),
          'biaya1' => $this->request->getVar('biaya1'),
          'biaya2' => $this->request->getVar('biaya2'),
          'nbiaya1' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('nbiaya1')),
          'nbiaya2' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('nbiaya2')),
          'total_biaya' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('total_biaya')),
          'catatan' => $this->request->getVar('catatan'),
          'subtotal' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('subtotalh')),
          'totalsmt' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('totalsmt')),
          'ppn' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('ppn')),
          'rp_ppn' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('rp_ppn')),
          'materai' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('materai')),
          'total' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('total')),
          'cara_bayar' => $this->request->getVar('cara_bayar'),
          'tempo' => $this->request->getVar('tempo'),
          'tgljttempo' => $this->request->getVar('tgljttempo'),
          'user' => $user,
        ];
        // var_dump($simpandata);
        $this->beli_partModel->insert($simpandata);
        $nopo = $this->request->getVar('nopo');
        $rowpod = $this->po_partdModel->getnopo($nopo);
        var_dump($rowpod);
        if ($rowpod) {
          foreach ($rowpod as $pod) {
            $simpandata = [
              'nobeli' => $nobeli,
              'kodepart' => $pod['kodepart'],
              'namapart' => $pod['namapart'],
              'qty' => $pod['qty'],
              'hrgbeli' => $pod['hrgbeli'],
              'discount' => $pod['discount'],
              'rp_discount' => $pod['rp_discount'],
              'subtotal' => $pod['subtotal'],
            ];
            $this->beli_partdModel->insert($simpandata);
          }
        }
        $msg = [
          'sukses' => 'Data berhasil disimpan'
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
      $data = [
        'title' => 'Edit Data Pembelian Spare Part',
        'beli_part' => $this->beli_partModel->find($id),
      ];
      $msg = [
        'sukses' => view('beli_part/modaledit', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function update_beli_part()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $validation = \Config\Services::validation();
      $valid = $this->validate([
        'kdsupplier' => [
          'label' => 'kdsupplier',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong'
          ]
        ],
        'jnsorder' => [
          'label' => 'jnsorder',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'is_unique' => '{field} tidak boleh ada yang sama'
          ]
        ],
      ]);
      if (!$valid) {
        $msg = [
          'error' => [
            'jnsorder' => $validation->getError('jnsorder'),
            'kdsupplier' => $validation->getError('kdsupplier'),
          ]
        ];
        echo json_encode($msg);
      } else {
        date_default_timezone_set('Asia/Jakarta');
        $session = session();
        $user = "Tambah-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        $simpandata = [
          'tanggal' => $this->request->getVar('tanggal'),
          'kdsupplier' => $this->request->getVar('kdsupplier'),
          'nmsupplier' => $this->request->getVar('nmsupplier'),
          'jnsorder' => $this->request->getVar('jnsorder'),
          'biaya1' => $this->request->getVar('biaya1'),
          'biaya2' => $this->request->getVar('biaya2'),
          'nbiaya1' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('nbiaya1')),
          'nbiaya2' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('nbiaya2')),
          'total_biaya' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('total_biaya')),
          'catatan' => $this->request->getVar('catatan'),
          'subtotal' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('subtotalh')),
          'totalsmt' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('totalsmt')),
          'ppn' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('ppn')),
          'rp_ppn' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('rp_ppn')),
          'materai' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('materai')),
          'total' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('total')),
          'cara_bayar' => $this->request->getVar('cara_bayar'),
          'tempo' => $this->request->getVar('tempo'),
          'tgljttempo' => $this->request->getVar('tgljttempo'),
          'user' => $user,
        ];
        // var_dump($simpandata);
        $this->beli_partModel->update($id, $simpandata);
        $msg = [
          'sukses' => 'Data berhasil disimpan'
        ];
        session()->setFlashdata('pesan', 'Data berhasil ditambah');
        echo json_encode($msg);
      }
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function input_beli_partd()
  {
    $id = $this->request->getVar('id');
    $row = $this->beli_partModel->find($id);
    $data = [
      'title' => 'Update Detail PO Spare Part',
      'beli_part' => $this->beli_partModel->find($id),
    ];
    // var_dump($data);
    $msg = [
      'sukses' => view('beli_part/input_beli_partd', $data)
    ];
    echo json_encode($msg);
  }

  public function simpan_beli_partd()
  {
    if ($this->request->isAjax()) {
      $validation = \Config\Services::validation();
      $valid = $this->validate([
        'kodepart' => [
          'label' => 'kodepart',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong'
          ]
        ],
        'qty' => [
          'label' => 'qty',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'is_unique' => '{field} tidak boleh ada yang sama'
          ]
        ],
      ]);
      if (!$valid) {
        $msg = [
          'error' => [
            'qty' => $validation->getError('qty'),
            'kodepart' => $validation->getError('kodepart'),
          ]
        ];
        echo json_encode($msg);
      } else {
        date_default_timezone_set('Asia/Jakarta');
        $session = session();
        $nobeli = $this->request->getVar('nobeli');
        $rowclose = $this->beli_partModel->getnobeli($nobeli);
        foreach ($rowclose as $row) {
          $close = $row['close'];
          $batal = $row['batal'];
        }
        if ($close == 1 or $batal == 1) {
          $msg = [
            'sukses' => 'Data gagal disimpan'
          ];
          session()->setFlashdata('pesan', 'Data gagal ditambah');
          echo json_encode($msg);
          exit();
        }
        $kode = $this->request->getVar('kodepart');
        $data = $this->beli_partdModel->getdoublebarang($nobeli, $kode);
        if ($data) {
          foreach ($data as $row) {
            $id = $row['id'];
          }
          $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
          $simpandata = [
            'nobeli' => $this->request->getVar('nobeli'),
            'kodepart' => $this->request->getVar('kodepart'),
            'namapart' => $this->request->getVar('namapart'),
            'qty' => str_replace(",", "", $this->request->getVar('qty')),
            'satuan' => $this->request->getVar('satuan'),
            'hrgbeli' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('hrgbeli')),
            'discount' => str_replace(",", "", $this->request->getVar('discount')),
            'rp_discount' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('rp_discount')),
            'subtotal' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('subtotal')),
            'user' => $user,
          ];
          $this->beli_partdModel->update($id, $simpandata);
          $msg = [
            'sukses' => 'Data berhasil disimpan'
          ];
        } else {
          $user = "Tambah-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
          $simpandata = [
            'nobeli' => $this->request->getVar('nobeli'),
            'kodepart' => $this->request->getVar('kodepart'),
            'namapart' => $this->request->getVar('namapart'),
            'qty' => str_replace(",", "", $this->request->getVar('qty')),
            'satuan' => $this->request->getVar('satuan'),
            'hrgbeli' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('hrgbeli')),
            'discount' => str_replace(",", "", $this->request->getVar('discount')),
            'rp_discount' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('rp_discount')),
            'subtotal' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('subtotal')),
            'user' => $user,
          ];
          // var_dump($simpandata);
          $this->beli_partdModel->insert($simpandata);
          $msg = [
            'sukses' => 'Data berhasil disimpan'
          ];
        }
        session()->setFlashdata('pesan', 'Data berhasil ditambah');
        echo json_encode($msg);
      }
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function tampil_detail_beli_partd($id)
  {
    $id = $_POST['id'];
    $row = $this->beli_partdModel->find($id);
    if (isset($row)) {
      $data = [
        'kodepart' => $row['kodepart'],
        'namapart' => $row['namapart'],
        'qty' => $row['qty'],
        'hrgbeli' => $row['hrgbeli'],
        'discount' => $row['discount'],
        'rp_discount' => $row['rp_discount'],
        'subtotal' => $row['subtotal'],
      ];
    } else {
      $data = [
        'kodepart' => '',
        'namapart' => '',
        'qty' => 0,
        'hrgbeli' => 0,
        'discount' => 0,
        'rp_discount' => 0,
        'subtotal' => 0,
      ];
    }
    echo json_encode($data);
  }

  public function update_beli_partd()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->beli_partdModel->find($id);
      $data = [
        'title' => 'Edit Data Pembelian Spare Part',
        'beli_partd' => $this->beli_partdModel->find($id),
        'tbbarang' => $this->tbbarangModel->where('aktif', 'Y')->orderBy('kode', 'asc')->findAll()
      ];
      // var_dump($data);
      $msg = [
        'sukses' => view('beli_part/editbeli_partd', $data)
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function hitung_summary_beli()
  {
    $nobeli = $_POST['nobeli'];
    $row = $this->beli_partModel->getnobeli($nobeli);
    // var_dump($nobeli);
    foreach ($row as $k) {
      $nobeli = $k['nobeli'];
      $idpo = $k['id'];
      $ppn = $k['ppn'];
      $total_biaya = $k['total_biaya'];
      $materai = $k['materai'];
    }
    $jumpart = 0;
    $jumpartrec = $this->beli_partdModel->jumpart($nobeli);
    foreach ($jumpartrec as $j) {
      $jumpart = $j['jumpart'];
    }
    $subtotal = $jumpart;
    $totalsmt = $total_biaya + $subtotal;
    $rp_ppn = $totalsmt * ($ppn / 100);
    $total = $totalsmt + $rp_ppn + $materai;
    $dataupdate = [
      'id' => $idpo,
      'subtotal' => $subtotal,
      'totalsmt' => $totalsmt,
      'rp_ppn' => $rp_ppn,
      'total' => $total,
    ];
    // var_dump($dataupdate);
    $this->beli_partModel->update($idpo, $dataupdate);
  }

  public function simpan_batal_faktur()
  {
    if ($this->request->isAjax()) {
      $validation = \Config\Services::validation();
      $valid = $this->validate([
        'ket_batal' => [
          'label' => 'ket_batal',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'is_unique' => '{field} tidak boleh ada yang sama'
          ]
        ],
      ]);
      if (!$valid) {
        $msg = [
          'error' => [
            'ket_batal' => $validation->getError('ket_batal'),
          ]
        ];
        echo json_encode($msg);
      } else {
        date_default_timezone_set('Asia/Jakarta');
        $session = session();
        $user = $session->get('nama');
        $tgl_batal = date('Y-m-d H:i:s');
        $simpandata = [
          'ket_batal' => $this->request->getVar('ket_batal'),
          'batal' => '1',
          'tgl_batal' => $tgl_batal,
          'user_batal' => $user,
        ];
        // var_dump($simpandata);
        $id = $this->request->getVar('id');
        $this->beli_partModel->update($id, $simpandata);
        $msg = [
          'sukses' => 'Data berhasil disimpan'
        ];
        session()->setFlashdata('pesan', 'Data berhasil disimpan');
        echo json_encode($msg);
      }
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function caridatapo()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data po',
        'po_part' => $this->po_partModel->where('close', '1')->orderBy('nopo', 'desc')->findAll() //$rwtkeluarga
      ];
      // var_dump($data);
      $msg = [
        'data' => view('beli_part/modalcaripo', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function replpo()
  {
    if ($this->request->isAjax()) {
      $nopo = $_POST['nopo'];
      $row = $this->po_partModel->getnopo($nopo);
      if (isset($row)) {
        $data = [
          'title' => 'Detail data po',
          'nopo' => $row['nopo'],
          'tglpo' => $row['tanggal'],
          'kdsupplier' => $row['kdsupplier'],
          'nmsupplier' => $row['nmsupplier'],
          'jnsorder' => $row['jnsorder'],
          'reference' => $row['reference'],
          'biaya1' => $row['biaya1'],
          'nbiaya1' => $row['nbiaya1'],
          'biaya2' => $row['biaya2'],
          'nbiaya2' => $row['nbiaya2'],
          'total_biaya' => $row['total_biaya'],
          'catatan' => $row['catatan'],
          'subtotal' => $row['subtotal'],
          'ppn' => $row['ppn'],
          'rp_ppn' => $row['rp_ppn'],
          'materai' => $row['materai'],
          'cara_bayar' => $row['cara_bayar'],
          'tempo' => $row['tempo'],
          'tgljttempo' => $row['tgljttempo'],
          'total' => $row['total'],
          'partshop' => $row['partshop'],
        ];
      } else {
        $data = [
          'title' => 'Detail data po',
          'nopo' => '',
          'tglpo' => '',
          'kdsupplier' => '',
          'nmsupplier' => '',
          'jnsorder' => '',
          'reference' => '',
          'biaya1' => '',
          'nbiaya1' => 0,
          'biaya2' => '',
          'nbiaya2' => 0,
          'total_biaya' => 0,
          'catatan' => '',
          'subtotal' => 0,
          'ppn' => 0,
          'rp_ppn' => 0,
          'materai' => 0,
          'cara_bayar' => '',
          'tempo' => 0,
          'tgljttempo' => '',
          'total' => 0,
          'partshop' => 0,
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function caridatasupplier()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data Supplier',
        'tbsupplier' => $this->tbsupplierModel->where('aktif', 'Y')->orderBy('kode', 'asc')->findAll() //$rwtkeluarga
      ];
      // var_dump($data);
      $msg = [
        'data' => view('beli_part/modalcarisupplier', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function replsupplier()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['kode'];
      $row = $this->tbsupplierModel->getkode($kode);
      if (isset($row)) {
        $data = [
          'title' => 'Detail data Supplier',
          'kdsupplier' => $row['kode'],
          'nmsupplier' => $row['nama'],
        ];
      } else {
        $data = [
          'title' => 'Detail data Supplier',
          'kdsupplier' => '',
          'nmsupplier' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function caridatapart()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data Part',
        'tbbarang' => $this->tbbarangModel->where('aktif', 'Y')->orderBy('kode', 'asc')->findAll() //$rwtkeluarga
      ];
      // var_dump($data);
      $msg = [
        'data' => view('beli_part/modalcaripart', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function replpart()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['kode'];
      $row = $this->tbbarangModel->getkode($kode);
      if (isset($row)) {
        $data = [
          'title' => 'Detail data part',
          'kodepart' => $row['kode'],
          'namapart' => $row['nama'],
          'hrgbeli' => number_format($row['harga_beli'], 0, ".", ","),
          'satuan' => $row['kdsatuan'],
        ];
      } else {
        $data = [
          'title' => 'Detail data part',
          'kodepart' => '',
          'namapart' => '',
          'hrgbeli' => '',
          'satuan' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function hapus_beli_part()
  {
    if ($this->request->isAjax()) {
      $id = $_POST['id'];
      $row = $this->po_partModel->find($id);
      $close = $row['close'];
      $batal = $row['batal'];
      if ($close == 1 or $batal == 1) {
        $msg = [
          'sukses' => 'Data gagal disimpan'
        ];
        session()->setFlashdata('pesan', 'Data gagal ditambah');
        echo json_encode($msg);
        exit();
      } else {
        $this->beli_partModel->delete_by_id($id);
        $msg = [
          'sukses' => 'Data berhasil dihapus'
        ];
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
      }
      echo json_encode($msg);
    };
  }

  public function hapus_beli_partd()
  {
    if ($this->request->isAjax()) {
      $id = $_POST['id'];
      $row = $this->beli_partdModel->find($id);
      $proses = $row['proses'];
      $nobeli = $row['nobeli'];
      $nobeli = $this->request->getVar('nobeli');
      $rowclose = $this->beli_partModel->getnobeli($nobeli);
      foreach ($rowclose as $row) {
        $close = $row['close'];
        $batal = $row['batal'];
      }
      if ($close == 1 or $batal == 1) {
        $msg = [
          'sukses' => 'Data gagal disimpan'
        ];
        session()->setFlashdata('pesan', 'Data gagal ditambah');
        echo json_encode($msg);
        exit();
      }
      if ($proses == 0) {
        $this->beli_partdModel->delete_by_id($id);
        $msg = [
          'sukses' => 'Data berhasil dihapus'
        ];
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
      } else {
        $msg = [
          'sukses' => 'Data gagal dihapus'
        ];
        session()->setFlashdata('pesan', 'Data gagal dihapus');
      }
      echo json_encode($msg);
    };
  }

  public function table_beli_partd()
  {
    $nobeli = $_POST['nobeli'];
    $data = [
      'nobeli' => $nobeli,
      'title' => 'Pembelian Spare Part',
      'beli_partd' => $this->beli_partdModel->getnobeli($nobeli)
    ];
    echo view('beli_part/tabel_beli_partd', $data);
  }

  public function close_beli_part()
  {
    if ($this->request->isAjax()) {
      $session = session();
      $id = $_POST['id'];
      $row = $this->beli_partModel->find($id);
      $close = $row['close'];
      if ($close == 0) {
        $user = "Close-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        $simpandata = [
          'close' => 1,
          'user' => $user,
        ];
        $this->beli_partModel->update($id, $simpandata);
        $msg = [
          'sukses' => 'Data berhasil disimpan'
        ];
      } else {
        $msg = [
          'sukses' => 'Data gagal disimpan'
        ];
        session()->setFlashdata('pesan', 'Data berhasil diupdate');
      }
      echo json_encode($msg);
    };
  }

  public function unclose_beli_part()
  {
    if ($this->request->isAjax()) {
      $session = session();
      $id = $_POST['id'];
      $row = $this->beli_partModel->find($id);
      $close = $row['close'];
      if ($close == 1) {
        $user = "Unclose-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        $simpandata = [
          'close' => 0,
          'user' => $user,
        ];
        $this->beli_partModel->update($id, $simpandata);
        $msg = [
          'sukses' => 'Data berhasil disimpan'
        ];
      } else {
        $msg = [
          'sukses' => 'Data gagal disimpan'
        ];
        session()->setFlashdata('pesan', 'Data berhasil diupdate');
      }
      echo json_encode($msg);
    };
  }

  public function cetakbeli_part($id)
  {
    $dompdf = new Dompdf();
    $row = $this->beli_partModel->find($id);
    $nobeli = $row['nobeli'];
    $data = [
      'title' => 'Cetak Pembelian Spare Part',
      'beli_part' => $this->beli_partModel->find($id),
    ];
    // var_dump($data);
    // $msg = [
    //   'sukses' => view('beli_part/cetakbeli_part', $data)
    // ];
    $html =  view('beli_part/cetakbeli_part', $data);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'Potrait');
    $dompdf->render();
    // $dompdf->stream(); //langsung download
    $dompdf->stream('pembelian ' . $nobeli . '.pdf', array("Attachment" => false));
    // var_dump($msg);
    // echo json_encode($msg);
    // } else {
    //   exit('Maaf tidak dapat diproses');
    // }
  }

  public function cancel_beli_part()
  {
    if ($this->request->isAjax()) {
      $session = session();
      $id = $_POST['id'];
      $row = $this->beli_partModel->find($id);
      $close = $row['close'];
      // $nopo = $row['nopo'];
      // if (!isset($close)) {
      //   $close = 0;
      // }
      // $row = $this->beli_partModel->getnopo($nopo);
      // foreach ($row as $data) {
      //   $close_wo = $data['close'];
      // }
      if ($close == 0) {
        $user = "Proses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        $simpandata = [
          'batal' => 1,
          'user_batal' => $user,
        ];
        $this->beli_partModel->update($id, $simpandata);
        $msg = [
          'sukses' => 'Data berhasil disimpan'
        ];
        session()->setFlashdata('pesan', 'Data berhasil diupdate');
      } else {
        $msg = [
          'sukses' => 'Data gagal disimpan'
        ];
        session()->setFlashdata('pesan', 'Data berhasil diupdate');
      }
      echo json_encode($msg);
    };
  }
}
