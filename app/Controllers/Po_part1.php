<?php

namespace App\Controllers;

use App\Models\Po_partModel;
use App\Models\Po_partdModel;
use App\Models\TbsupplierModel;
use App\Models\TbbarangModel;

use \Dompdf\Dompdf;

class Po_part extends BaseController
{
  protected $po_partModel, $po_partdModel, $tbsupplierModel, $tbbarangModel;

  public function __construct()
  {
    $this->po_partModel = new Po_partModel();
    $this->po_partdModel = new Po_partdModel();
    $this->tbsupplierModel = new TbsupplierModel();
    $this->tbbarangModel = new TbbarangModel();
  }

  public function index()
  {
    $data = [
      'menu' => 'transaksi',
      'submenu' => 'po_part',
      'submenu1' => 'spare_part',
      'title' => 'Purchase Order Part',
      'po_part' => $this->po_partModel->orderBy('nopo')->findAll() //$wo
    ];
    echo view('po_part/index', $data);
  }

  public function ajaxLoadData()
  {
    $request = $this->request;
    $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
    $katakunci = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
    $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
    $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
    $data = $this->po_partModel->tampilData($request, $katakunci, $start, $length);
    $jumlahData = $this->po_partModel->tampilData($request, $katakunci);
    $output = array(
      "draw" => intval($param['draw']),
      "recordsTotal" => count($jumlahData),
      "recordsFiltered" => count($jumlahData),
      "data" => $data,
    );
    echo json_encode($output);
  }

  public function table_po_part()
  {
    $model = new po_partModel();
    $data['title'] = 'Purchase Order Part';
    $data['po_part'] = $model->findAll();
    // var_dump($data['po_part']);
    echo view('po_part/tabel_po_part', $data);
  }

  // public function detail_po_part()
  // {
  //   $id = $this->request->getVar('id');
  //   $row = $this->po_partModel->find($id);
  //   $nopolisi = $row['nopolisi'];
  //   $kdpemilik = $row['kdpemilik'];
  //   $kdsa = $row['kdsa'];
  //   $data = [
  //     'title' => 'Detail WO',
  //     'po_part' => $this->po_partModel->find($id),
  //     'tbmobil' => $this->tbmobilModel->getnopolisi($nopolisi),
  //     'tbmerek' => $this->tbmerekModel->getNama(),
  //     'tbmodel' => $this->tbmodelModel->getMerek(),
  //     'tbtipe' => $this->tbtipeModel->getModel(),
  //     'tbwarna' => $this->tbwarnaModel->getNama(),
  //     'tbjenis' => $this->tbjenisModel->getNama(),
  //     'tbsa' => $this->tbsaModel->getkode($kdsa),
  //     'tbcustomer' => $this->tbcustomerModel->getkdcustomer($kdpemilik),
  //   ];
  //   var_dump($data);
  //   $msg = [
  //     'sukses' => view('po_part/detail_po_part', $data)
  //   ];
  //   echo json_encode($msg);
  // }

  public function formdetail()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->po_partModel->find($id);
      $kdsupplier = $row['kdsupplier'];
      $data = [
        'title' => 'Detail Faktur Body Repair',
        'po_part' => $this->po_partModel->find($id),
        'tbsupplier' => $this->tbsupplierModel->getkode($kdsupplier),
      ];
      // var_dump($data);
      $msg = [
        'sukses' => view('po_part/modaldetail', $data)
      ];
      echo json_encode($msg);
    }
  }

  public function formtambah()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Tambah Data Purchase Order (PO)',
        'po_part' => $this->po_partModel->findAll(),
      ];
      $msg = [
        'data' => view('po_part/modaltambah', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function simpanpo_part()
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
        $nopo = 'PO' . date('Y') . date('m') . sprintf("%05s", intval(substr('00000', -5)) + 1);
        $po = $this->po_partModel->buatnopo();
        if (isset($po)) {
          foreach ($po as $row) {
            if ($row->nopo != NULL) {
              $nopo = 'PO' . date('Y') . date('m') . sprintf("%05s", intval(substr($row->nopo, -5)) + 1);
            }
          }
        }
        $session = session();
        $user = "Tambah-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        $simpandata = [
          'nopo' => $nopo, //$this->request->getVar('nopo'),
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
          'subtotal' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('subtotal')),
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
        $this->po_partModel->insert($simpandata);
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
        'title' => 'Edit Data Purchase Order (PO)',
        'po_part' => $this->po_partModel->find($id),
      ];
      $msg = [
        'sukses' => view('po_part/modaledit', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function update_po_part()
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
          'subtotal' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('subtotal')),
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
        $this->po_partModel->update($id, $simpandata);
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

  public function input_po_partd()
  {
    $id = $this->request->getVar('id');
    $row = $this->po_partModel->find($id);
    $data = [
      'title' => 'Update Detail PO Spare Part',
      'po_part' => $this->po_partModel->find($id),
    ];
    // var_dump($data);
    $msg = [
      'sukses' => view('po_part/input_po_partd', $data)
    ];
    echo json_encode($msg);
  }

  public function simpan_po_partd()
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
        $nopo = $this->request->getVar('nopo');
        $rowclose = $this->po_partModel->getnopo($nopo);
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
        $data = $this->po_partdModel->getdoublebarang($nopo, $kode);
        if ($data) {
          foreach ($data as $row) {
            $id = $row['id'];
          }
          $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
          $simpandata = [
            'nopo' => $this->request->getVar('nopo'),
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
          $this->po_partdModel->update($id, $simpandata);
          $msg = [
            'sukses' => 'Data berhasil disimpan'
          ];
        } else {
          $user = "Tambah-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
          $simpandata = [
            'nopo' => $this->request->getVar('nopo'),
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
          $this->po_partdModel->insert($simpandata);
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

  public function tampil_detail_po_partd($id)
  {
    $id = $_POST['id'];
    $row = $this->po_partdModel->find($id);
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

  public function update_po_partd()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->po_partdModel->find($id);
      $data = [
        'title' => 'Edit Data Purchase Order (PO)',
        'po_partd' => $this->po_partdModel->find($id),
        'tbbarang' => $this->tbbarangModel->where('aktif', 'Y')->orderBy('kode', 'asc')->findAll()
      ];
      // var_dump($data);
      $msg = [
        'sukses' => view('po_part/editpo_partd', $data)
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function hitung_summary_po()
  {
    $nopo = $_POST['nopo'];
    $row = $this->po_partModel->getnopo($nopo);
    // var_dump($nopo);
    foreach ($row as $k) {
      $nopo = $k['nopo'];
      $idpo = $k['id'];
      $ppn = $k['ppn'];
      $total_biaya = $k['total_biaya'];
      $materai = $k['materai'];
    }
    $jumpart = 0;
    $jumpartrec = $this->po_partdModel->jumpart($nopo);
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
    $this->po_partModel->update($idpo, $dataupdate);
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
        $this->po_partModel->update($id, $simpandata);
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

  public function caridatasupplier()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data Supplier',
        'tbsupplier' => $this->tbsupplierModel->where('aktif', 'Y')->orderBy('kode', 'asc')->findAll() //$rwtkeluarga
      ];
      // var_dump($data);
      $msg = [
        'data' => view('po_part/modalcarisupplier', $data),
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
        'data' => view('po_part/modalcaripart', $data),
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

  public function hapus_po_partd()
  {
    if ($this->request->isAjax()) {
      $id = $_POST['id'];
      $row = $this->po_partdModel->find($id);
      $proses = $row['proses'];
      $nopo = $row['nopo'];
      $nopo = $this->request->getVar('nopo');
      $rowclose = $this->po_partModel->getnopo($nopo);
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
        $this->po_partdModel->delete_by_id($id);
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

  public function table_po_partd()
  {
    $nopo = $_POST['nopo'];
    $data = [
      'nopo' => $nopo,
      'title' => 'Purchase Order Part',
      'po_partd' => $this->po_partdModel->getnopo($nopo)
    ];
    echo view('po_part/tabel_po_partd', $data);
  }

  public function close_po_part()
  {
    if ($this->request->isAjax()) {
      $session = session();
      $id = $_POST['id'];
      $row = $this->po_partModel->find($id);
      $close = $row['close'];
      if ($close == 0) {
        $user = "Close-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        $simpandata = [
          'close' => 1,
          'user' => $user,
        ];
        $this->po_partModel->update($id, $simpandata);
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

  public function unclose_po_part()
  {
    if ($this->request->isAjax()) {
      $session = session();
      $id = $_POST['id'];
      $row = $this->po_partModel->find($id);
      $close = $row['close'];
      if ($close == 1) {
        $user = "Unclose-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        $simpandata = [
          'close' => 0,
          'user' => $user,
        ];
        $this->po_partModel->update($id, $simpandata);
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

  public function cetakpo_part($id)
  {
    $dompdf = new Dompdf();
    $row = $this->po_partModel->find($id);
    $nopo = $row['nopo'];
    $data = [
      'title' => 'Cetak faktur',
      'po_part' => $this->po_partModel->find($id),
    ];
    // var_dump($data);
    // $msg = [
    //   'sukses' => view('po_part/cetakpo_part', $data)
    // ];
    $html =  view('po_part/cetakpo_part', $data);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'Potrait');
    $dompdf->render();
    // $dompdf->stream(); //langsung download
    $dompdf->stream('faktur ' . $nopo . '.pdf', array("Attachment" => false));
    // var_dump($msg);
    // echo json_encode($msg);
    // } else {
    //   exit('Maaf tidak dapat diproses');
    // }
  }

  public function cancel_po_part()
  {
    if ($this->request->isAjax()) {
      $session = session();
      $id = $_POST['id'];
      $row = $this->po_partModel->find($id);
      $close = $row['close'];
      // $nopo = $row['nopo'];
      // if (!isset($close)) {
      //   $close = 0;
      // }
      // $row = $this->po_partModel->getnopo($nopo);
      // foreach ($row as $data) {
      //   $close_wo = $data['close'];
      // }
      if ($close == 0) {
        $user = "Proses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        $simpandata = [
          'batal' => 1,
          'user_batal' => $user,
        ];
        $this->po_partModel->update($id, $simpandata);
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
