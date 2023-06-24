<?php

namespace App\Controllers;

use App\Models\MemombrModel;
use App\Models\TbcustomerModel;
use App\Models\tbmerekModel;
use App\Models\tbmodelModel;
use App\Models\tbtipeModel;
use App\Models\tbwarnaModel;
use App\Models\tbjenisModel;
use App\Models\tbasuransiModel;
use App\Models\tbleasingModel;
use App\Models\tbsalesModel;
use App\Models\MemombrdModel;
use App\Models\PengajuandiscountModel;
use App\Models\PenerimaankasirModel;
use App\Models\HisuserModel;
use \Dompdf\Dompdf;

class Memombr extends BaseController
{
  protected $tbcustomerModel, $memombrModel, $woModel, $tbmobilModel, $tbmerekModel, $tbmodelModel, $tbtipeModel, $tbwarnaModel, $tbjenisModel, $tbagamaModel,
    $tbasuransiModel, $tbleasingModel, $tbsalesModel, $memombrdModel, $pengajuandiscountModel, $penerimaankasirModel, $hisuserModel;
  public function __construct()
  {
    $this->memombrModel = new MemombrModel();
    $this->tbcustomerModel = new TbcustomerModel();
    $this->tbmerekModel = new TbmerekModel();
    $this->tbmodelModel = new TbmodelModel();
    $this->tbtipeModel = new TbtipeModel();
    $this->tbwarnaModel = new TbwarnaModel();
    $this->tbjenisModel = new TbjenisModel();
    $this->tbasuransiModel = new TbasuransiModel();
    $this->tbleasingModel = new TbleasingModel();
    $this->tbsalesModel = new TbsalesModel();
    $this->memombrdModel = new MemombrdModel();
    $this->pengajuandiscountModel = new PengajuandiscountModel();
    $this->penerimaankasirModel = new PenerimaankasirModel();
    $this->hisuserModel = new HisuserModel();
  }

  public function index()
  {
    $data = [
      'menu' => 'transaksi',
      'submenu' => 'memombr',
      'title' => 'Memo Mobil Baru',
      'memombr' => $this->memombrModel->orderBy('nomemo', 'desc')->findAll() //$wo
    ];
    echo view('memombr/index', $data);
  }

  public function ajaxLoadData()
  {
    $request = $this->request;
    // dd($request->getPost('order[0][column]'));
    $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
    $katakunci = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
    $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
    $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
    $data = $this->memombrModel->tampilData($request, $katakunci, $start, $length);
    $jumlahData = $this->memombrModel->tampilData($request, $katakunci);
    $output = array(
      "draw" => intval($param['draw']),
      "recordsTotal" => count($jumlahData),
      "recordsFiltered" => count($jumlahData),
      "data" => $data,
    );
    echo json_encode($output);
  }

  public function table_memombr()
  {
    $model = new memombrModel();
    $data['title'] = 'memombr';
    echo view('memombr/tabel_memombr', $data);
  }

  public function formdetail()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->memombrModel->find($id);
      $kdspv = $row['kdspv'];
      $kdsales = $row['kdsales'];
      $kdmgr = $row['kdmgr'];
      $data = [
        'title' => 'Detail data Memo Mobil Baru',
        // 'id' => $row['id'],
        // 'kode' => $row['kode'],
        // 'nama' => $row['nama'],
        'memombr' => $this->memombrModel->find($id),
        'tbmerek' => $this->tbmerekModel->getNama(),
        'tbmodel' => $this->tbmodelModel->getMerek(),
        'tbtipe' => $this->tbtipeModel->getModel(),
        'tbwarna' => $this->tbwarnaModel->getNama(),
        'tbjenis' => $this->tbjenisModel->getNama(),
        'tbsales' => $this->tbsalesModel->getkode($kdsales),
        'tbspv' => $this->tbsalesModel->getkode($kdspv),
        'tbmgr' => $this->tbsalesModel->getkode($kdmgr),
      ];
      $msg = [
        'sukses' => view('memombr/modaldetail', $data)
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
        'title' => 'Tambah Data Memo',
        'tbmerek' => $this->tbmerekModel->getnama(),
        'tbmodel' => $this->tbmodelModel->getMerek(),
        'tbtipe' => $this->tbtipeModel->getModel(),
        'tbwarna' => $this->tbwarnaModel->getNama(),
        'tbjenis' => $this->tbjenisModel->getNama(),
      ];
      $msg = [
        'data' => view('memombr/modaltambah', $data),
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
        // 'nomemo' => [
        //   'label' => 'nomemo',
        //   'rules' => 'required|is_unique[memombr.nomemo]',
        //   'errors' => [
        //     'required' => '{field} tidak boleh kosong',
        //     'is_unique' => '{field} tidak boleh ada yang sama'
        //   ]
        // ],
        'tanggal' => [
          'label' => 'tanggal',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong'
          ]
        ],
      ]);
      if (!$valid) {
        $msg = [
          'error' => [
            // 'nomemo' => $validation->getError('nomemo'),
            'tanggal' => $validation->getError('tanggal')
          ]
        ];
        echo json_encode($msg);
      } else {
        date_default_timezone_set('Asia/Jakarta');
        $session = session();
        $user = "Tambah-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        $nomemo = 'M' . date('Y') . date('m') . sprintf("%05s", intval(substr('00000', -5)) + 1);
        $memombr = $this->memombrModel->buatnomemo();
        if (isset($memombr)) {
          foreach ($memombr as $row) {
            if ($row->nomemo != NULL) {
              $nomemo = 'M' . date('Y') . date('m') . sprintf("%05s", intval(substr($row->nomemo, -5)) + 1);
            }
          }
        }
        if ($this->request->getVar('nama_stnk') == 'on') {
          $nama_stnk = 'Y';
        } else {
          $nama_stnk = 'N';
        }
        if ($this->request->getVar('tipe_unit_warna') == 'on') {
          $tipe_unit_warna = 'Y';
        } else {
          $tipe_unit_warna = 'N';
        }
        if ($this->request->getVar('beli_asuransi') == 'on') {
          $beli_asuransi = 'Y';
        } else {
          $beli_asuransi = 'N';
        }
        if ($this->request->getVar('beli_accessories') == 'on') {
          $beli_accessories = 'Y';
        } else {
          $beli_accessories = 'N';
        }

        $rowtipe = $this->tbtipeModel->getkode($this->request->getVar('kdtipe'));
        $rowwarna = $this->tbwarnaModel->getkode($this->request->getVar('kdwarna'));
        // var_dump($rowtipe);
        if ($this->request->getVar('kdtipe') != "") {
          $nmtipe = $rowtipe['nama'];
        } else {
          $nmtipe = '';
        }
        if ($this->request->getVar('kdwarna') != "") {
          $nmwarna = $rowwarna['nama'];
        } else {
          $nmwarna = '';
        }
        // var_dump($this->request->getVar('asuransi'));
        $simpandata = [
          'nomemo' => $nomemo,
          'tanggal' => $this->request->getVar('tanggal'),
          'nospk' => $this->request->getVar('nospk'),
          'norangka' => $this->request->getVar('norangka'),
          'nomesin' => $this->request->getVar('nomesin'),
          'kdmerek' => $this->request->getVar('kdmerek'),
          'kdmodel' => $this->request->getVar('kdmodel'),
          'kdtipe' => $this->request->getVar('kdtipe'),
          'kdjenis' => $this->request->getVar('kdjenis'),
          'kdwarna' => $this->request->getVar('kdwarna'),
          'nmtipe' => $nmtipe,
          'nmwarna' => $nmwarna,
          'tahun' => $this->request->getVar('tahun'),
          'pembayaran' => $this->request->getVar('pembayaran'),
          'kdleasing' => $this->request->getVar('kdleasing'),
          'nmkreditur' => $this->request->getVar('nmkreditur'),
          'lama_kredit' => $this->request->getVar('lama_kredit'),
          'kdleasing' => $this->request->getVar('kdleasing'),
          'asuransi' => $this->request->getVar('asuransi'),
          'kdasuransi' => $this->request->getVar('kdasuransi'),
          'nmasuransi' => $this->request->getVar('nmasuransi'),
          'pembeli' => $this->request->getVar('pembeli'),
          'penjualan' => $this->request->getVar('penjualan'),
          'disc_team_harga' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('disc_team_harga')),
          'booking_fee' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('booking_fee')),
          'kaca_film' => $this->request->getVar('kaca_film'),
          'kdsales' => $this->request->getVar('kdsales'),
          'status_sales' => $this->request->getVar('status_sales'),
          'kdspv' => $this->request->getVar('kdspv'),
          'kdmgr' => $this->request->getVar('kdmgr'),
          'kdcustomer' => $this->request->getVar('kdcustomer'),
          'nmcustomer' => $this->request->getVar('nmcustomer'),
          'alamat' => $this->request->getVar('alamat'),
          'kelurahan' => $this->request->getVar('kelurahan'),
          'kecamatan' => $this->request->getVar('kecamatan'),
          'kota' => $this->request->getVar('kota'),
          'provinsi' => $this->request->getVar('provinsi'),
          'kodepos' => $this->request->getVar('kodepos'),
          'nik_customer' => $this->request->getVar('nik_customer'),
          'nohp_customer' => $this->request->getVar('nohp_customer'),
          'kdcustomer_stnk' => $this->request->getVar('kdcustomer_stnk'),
          'nmcustomer_stnk' => $this->request->getVar('nmcustomer_stnk'),
          'alamat_stnk' => $this->request->getVar('alamat_stnk'),
          'kelurahan_stnk' => $this->request->getVar('kelurahan_stnk'),
          'kecamatan_stnk' => $this->request->getVar('kecamatan_stnk'),
          'kota_stnk' => $this->request->getVar('kota_stnk'),
          'provinsi_stnk' => $this->request->getVar('provinsi_stnk'),
          'kodepos_stnk' => $this->request->getVar('kodepos_stnk'),
          'nik_stnk' => $this->request->getVar('nik_stnk'),
          'nik_kk' => $this->request->getVar('nik_kk'),
          'nohp_customer_stnk' => $this->request->getVar('nohp_customer_stnk'),
          'email_stnk' => $this->request->getVar('email_stnk'),
          'npwp_stnk' => $this->request->getVar('npwp_stnk'),
          'harga_jual_mobil' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('harga_jual_mobil')),
          'harga_jual_accessories' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('harga_jual_accessories')),
          'biaya_wilayah' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('biaya_wilayah')),
          'upping_price' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('upping_price')),
          'disc_accessories' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('disc_accessories')),
          'total' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('total')),
          'disc_dealer' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('disc_dealer')),
          'mediator_an' => $this->request->getVar('mediator_an'),
          'mediator_bank' => $this->request->getVar('mediator_bank'),
          'mediator_cabang' => $this->request->getVar('mediator_cabang'),
          'mediator_account' => $this->request->getVar('mediator_account'),
          'mediator_nilai' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('mediator_nilai')),
          'tglvalidasi' => $this->request->getVar('tglvalidasi'),
          'ket_uang_lain' => $this->request->getVar('ket_uang_lain'),
          'uang_lain' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('uang_lain')),
          'event_hpm' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('event_hpm')),
          'event_lain' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('event_lain')),
          'nama_stnk' => $nama_stnk, //$this->request->getVar('event_lain'),
          'tipe_unit_warna' => $tipe_unit_warna, //$this->request->getVar('event_lain'),
          'beli_asuransi' => $beli_asuransi, //$this->request->getVar('event_lain'),
          'beli_accessories' => $beli_accessories, //$this->request->getVar('event_lain'),
          'user' => $user,
        ];
        // var_dump($simpandata);
        $this->memombrModel->insert($simpandata);
        $simpanhisuser = [
          'tanggal' => date('Y-m-d'),
          'dokumen' => $nomemo,
          'form' => 'Memo Mobil Baru',
          'status' => 'Tambah',
          'catatan' => '',
          'user' => $session->get('nama'),
        ];
        $this->hisuserModel->insert($simpanhisuser);
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
      $row = $this->memombrModel->find($id);
      $kdspv = $row['kdspv'];
      $kdsales = $row['kdsales'];
      $kdmgr = $row['kdmgr'];
      $data = [
        'title' => 'Edit data Memo Mobil Baru',
        // 'id' => $row['id'],
        // 'kode' => $row['kode'],
        // 'nama' => $row['nama'],
        'memombr' => $this->memombrModel->find($id),
        'tbmerek' => $this->tbmerekModel->getNama(),
        'tbmodel' => $this->tbmodelModel->getMerek(),
        'tbtipe' => $this->tbtipeModel->getModel(),
        'tbwarna' => $this->tbwarnaModel->getNama(),
        'tbjenis' => $this->tbjenisModel->getNama(),
        'tbsales' => $this->tbsalesModel->getkode($kdsales),
        'tbspv' => $this->tbsalesModel->getkode($kdspv),
        'tbmgr' => $this->tbsalesModel->getkode($kdmgr),
      ];
      $msg = [
        'sukses' => view('memombr/modaledit', $data)
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
      $valid = $this->validate([
        'nomemo' => [
          'label' => 'nomemo',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong'
          ]
        ]
      ]);
      if (!$valid) {
        $msg = [
          'error' => [
            'nomemombr' => $validation->getError('nomemombr'),
            'nopolisi' => $validation->getError('nopolisi')
          ]
        ];
        echo json_encode($msg);
      } else {
        date_default_timezone_set('Asia/Jakarta');
        $session = session();
        $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        if ($this->request->getVar('nama_stnk') == 'on') {
          $nama_stnk = 'Y';
        } else {
          $nama_stnk = 'N';
        }
        if ($this->request->getVar('tipe_unit_warna') == 'on') {
          $tipe_unit_warna = 'Y';
        } else {
          $tipe_unit_warna = 'N';
        }
        if ($this->request->getVar('beli_asuransi') == 'on') {
          $beli_asuransi = 'Y';
        } else {
          $beli_asuransi = 'N';
        }
        if ($this->request->getVar('beli_accessories') == 'on') {
          $beli_accessories = 'Y';
        } else {
          $beli_accessories = 'N';
        }
        $rowtipe = $this->tbtipeModel->getkode($this->request->getVar('kdtipe'));
        $rowwarna = $this->tbwarnaModel->getkode($this->request->getVar('kdwarna'));
        // var_dump($rowwarna);
        $nmtipe = isset($rowtipe['nama']) ? $rowtipe['nama'] : '';
        $nmwarna = isset($rowwarna['nama']) ? $rowwarna['nama'] : '';
        $simpandata = [
          'nomemo' => $this->request->getVar('nomemo'),
          'tanggal' => $this->request->getVar('tanggal'),
          'nospk' => $this->request->getVar('nospk'),
          'norangka' => $this->request->getVar('norangka'),
          'nomesin' => $this->request->getVar('nomesin'),
          'kdmerek' => $this->request->getVar('kdmerek'),
          'kdmodel' => $this->request->getVar('kdmodel'),
          'kdtipe' => $this->request->getVar('kdtipe'),
          'kdjenis' => $this->request->getVar('kdjenis'),
          'kdwarna' => $this->request->getVar('kdwarna'),
          'nmtipe' => $nmtipe,
          'nmwarna' => $nmwarna,
          'tahun' => $this->request->getVar('tahun'),
          'pembayaran' => $this->request->getVar('pembayaran'),
          'kdleasing' => $this->request->getVar('kdleasing'),
          'nmkreditur' => $this->request->getVar('nmkreditur'),
          'lama_kredit' => $this->request->getVar('lama_kredit'),
          'kdleasing' => $this->request->getVar('kdleasing'),
          'asuransi' => $this->request->getVar('asuransi'),
          'kdasuransi' => $this->request->getVar('kdasuransi'),
          'nmasuransi' => $this->request->getVar('nmasuransi'),
          'pembeli' => $this->request->getVar('pembeli'),
          'penjualan' => $this->request->getVar('penjualan'),
          'disc_team_harga' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('disc_team_harga')),
          'booking_fee' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('booking_fee')),
          'kaca_film' => $this->request->getVar('kaca_film'),
          'kdsales' => $this->request->getVar('kdsales'),
          'status_sales' => $this->request->getVar('status_sales'),
          'kdspv' => $this->request->getVar('kdspv'),
          'kdmgr' => $this->request->getVar('kdmgr'),
          'kdcustomer' => $this->request->getVar('kdcustomer'),
          'nmcustomer' => $this->request->getVar('nmcustomer'),
          'alamat' => $this->request->getVar('alamat'),
          'kelurahan' => $this->request->getVar('kelurahan'),
          'kecamatan' => $this->request->getVar('kecamatan'),
          'kota' => $this->request->getVar('kota'),
          'provinsi' => $this->request->getVar('provinsi'),
          'kodepos' => $this->request->getVar('kodepos'),
          'nik_customer' => $this->request->getVar('nik_customer'),
          'nohp_customer' => $this->request->getVar('nohp_customer'),
          'kdcustomer_stnk' => $this->request->getVar('kdcustomer_stnk'),
          'nmcustomer_stnk' => $this->request->getVar('nmcustomer_stnk'),
          'alamat_stnk' => $this->request->getVar('alamat_stnk'),
          'kelurahan_stnk' => $this->request->getVar('kelurahan_stnk'),
          'kecamatan_stnk' => $this->request->getVar('kecamatan_stnk'),
          'kota_stnk' => $this->request->getVar('kota_stnk'),
          'provinsi_stnk' => $this->request->getVar('provinsi_stnk'),
          'kodepos_stnk' => $this->request->getVar('kodepos_stnk'),
          'nik_stnk' => $this->request->getVar('nik_stnk'),
          'nik_kk' => $this->request->getVar('nik_kk'),
          'nohp_customer_stnk' => $this->request->getVar('nohp_customer_stnk'),
          'email_stnk' => $this->request->getVar('email_stnk'),
          'npwp_stnk' => $this->request->getVar('npwp_stnk'),
          'harga_jual_mobil' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('harga_jual_mobil')),
          'harga_jual_accessories' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('harga_jual_accessories')),
          'biaya_wilayah' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('biaya_wilayah')),
          'upping_price' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('upping_price')),
          'disc_accessories' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('disc_accessories')),
          'total' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('total')),
          'disc_dealer' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('disc_dealer')),
          'mediator_an' => $this->request->getVar('mediator_an'),
          'mediator_bank' => $this->request->getVar('mediator_bank'),
          'mediator_cabang' => $this->request->getVar('mediator_cabang'),
          'mediator_account' => $this->request->getVar('mediator_account'),
          'mediator_nilai' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('mediator_nilai')),
          'tglvalidasi' => $this->request->getVar('tglvalidasi'),
          'ket_uang_lain' => $this->request->getVar('ket_uang_lain'),
          'uang_lain' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('uang_lain')),
          'event_hpm' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('event_hpm')),
          'event_lain' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('event_lain')),
          'nama_stnk' => $nama_stnk, //$this->request->getVar('event_lain'),
          'tipe_unit_warna' => $tipe_unit_warna, //$this->request->getVar('event_lain'),
          'beli_asuransi' => $beli_asuransi, //$this->request->getVar('event_lain'),
          'beli_accessories' => $beli_accessories, //$this->request->getVar('event_lain'),
          'user' => $user,
        ];
        // var_dump($simpandata);
        $id = $this->request->getVar('id');
        $this->memombrModel->update($id, $simpandata);
        $simpanhisuser = [
          'tanggal' => date('Y-m-d'),
          'dokumen' => $this->request->getVar('nomemo'),
          'form' => 'Memo Mobil Baru',
          'status' => 'Edit',
          'catatan' => '',
          'user' => $session->get('nama'),
        ];
        $this->hisuserModel->insert($simpanhisuser);
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
    $session = session();
    $row = $this->memombrModel->find($id);
    $simpanhisuser = [
      'tanggal' => date('Y-m-d'),
      'dokumen' => $row['nomemo'],
      'form' => 'Memo Mobil Baru',
      'status' => 'Hapus',
      'catatan' => '',
      'user' => $session->get('nama'),
    ];
    $this->hisuserModel->insert($simpanhisuser);
    $id = $row['id'];
    $this->memombrModel->delete_by_id($id);
    session()->setFlashdata('pesan', 'Data berhasil dihapus');
    echo json_encode(array("status" => TRUE));
  }

  public function modalmemombr()
  {
    $id = $this->request->getVar('id');
    $row = $this->tbmobilModel->find($id);
    $nopolisi = $row['nopolisi'];
    $kdpemilik = $row['kdpemilik'];
    $data = [
      'title' => 'memombr & WO',
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
      'sukses' => view('memombr/modalmemombr', $data)
    ];
    echo json_encode($msg);
  }

  public function tambahmemombr()
  {
    $nopolisi = $_POST['nopolisi'];
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Tambah Data memombr / WO',
        'tbmobil' => $this->tbmobilModel->getnopolisi($nopolisi),
      ];
      // var_dump($data);
      $msg = [
        'data' => view('memombr/tambahmemombr', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function detailmemombr()
  {
    $id = $this->request->getVar('id');
    $row = $this->memombrModel->find($id);
    $nopolisi = $row['nopolisi'];
    $kdpemilik = $row['kdpemilik'];
    $kdsa = $row['kdsa'];
    $data = [
      'title' => 'Detail memombr',
      'memombr' => $this->memombrModel->find($id),
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
      'sukses' => view('memombr/detailmemombr', $data)
    ];
    echo json_encode($msg);
  }

  public function tambahjual()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->memombrModel->find($id);
      $nomemo = $row['nomemo'];
      $data = [
        'title' => 'Tambah Data Penjualan',
        'memombr' => $this->memombrModel->getnomemo($nomemo),
        'memombrd' => $this->memombrdModel->getdata($nomemo),
      ];
      // var_dump($data);
      $msg = [
        'data' => view('memombr/modaltambahjual', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function inputmemombrd()
  {
    $id = $this->request->getVar('id');
    $row = $this->memombrModel->find($id);
    $nopolisi = $row['nopolisi'];
    $kdpemilik = $row['kdpemilik'];
    $data = [
      'title' => 'Update Detail memombr',
      'memombr' => $this->memombrModel->find($id),
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
      'sukses' => view('memombr/inputmemombrd', $data)
    ];
    echo json_encode($msg);
  }

  public function editmemombr()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->memombrModel->find($id);
      $nopolisi = $row['nopolisi'];
      $kdpemilik = $row['kdpemilik'];
      $kdsa = $row['kdsales'];
      if (!isset($kdsales)) {
        $kdsales = "";
      }
      $data = [
        'title' => 'Edit Data memombr',
        'memombr' => $this->memombrModel->find($id),
        'tbmobil' => $this->tbmobilModel->getnopolisi($nopolisi),
        'tbmerek' => $this->tbmerekModel->getNama(),
        'tbmodel' => $this->tbmodelModel->getMerek(),
        'tbtipe' => $this->tbtipeModel->getModel(),
        'tbwarna' => $this->tbwarnaModel->getNama(),
        'tbjenis' => $this->tbjenisModel->getNama(),
        'tbcustomer' => $this->tbcustomerModel->getkdcustomer($kdpemilik),
        'tbsales' => ($kdsales ? $this->tbsalesModel->getkode($kdsales) : ''),
      ];
      // var_dump($data);
      $msg = [
        'sukses' => view('memombr/editmemombr', $data)
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function cetakmemombr($id)
  {
    $session = session();
    $row = $this->memombrModel->find($id);
    $dompdf = new Dompdf();
    // if ($this->request->isAjax()) {
    // $rowmemombr = $this->memombrModel->find($id);
    // $id = $this->request->getVar('id');
    $nomemo = $row['nomemo'];
    $kdmerek = $row['kdmerek'];
    $kdmodel = $row['kdmodel'];
    $kdtipe = $row['kdtipe'];
    $kdwarna = $row['kdwarna'];
    $kdcustomer = $row['kdcustomer'];
    $kdcustomer_stnk = $row['kdcustomer_stnk'];
    $data = [
      'title' => 'Edit Data memombr',
      'memombr' => $this->memombrModel->find($id),
      'tbmerek' => $this->tbmerekModel->getkode($kdmerek),
      'tbmodel' => $this->tbmodelModel->getkode($kdmodel),
      'tbtipe' => $this->tbtipeModel->getkode($kdtipe),
      'tbwarna' => $this->tbwarnaModel->getkode($kdwarna),
      // 'tbjenis' => $this->tbjenisModel->getkode($kdjenis),
      'tbcustomer' => $this->tbcustomerModel->getkdcustomer($kdcustomer),
      'tbcustomer_stnk' => $this->tbcustomerModel->getkdcustomer($kdcustomer_stnk),
      'memombrd' => $this->memombrdModel->getdata($nomemo),
    ];
    // $msg = [
    //   'sukses' => view('memombr/cetakmemombr', $data)
    // ];
    // var_dump($data);
    $simpanhisuser = [
      'tanggal' => date('Y-m-d'),
      'dokumen' => $row['nomemo'],
      'form' => 'Memo Mobil Baru',
      'status' => 'Cetak',
      'catatan' => '',
      'user' => $session->get('nama'),
    ];
    $this->hisuserModel->insert($simpanhisuser);
    $html =  view('memombr/cetakmemombr', $data);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'Landscape');
    $dompdf->render();
    // $dompdf->stream(); //langsung download
    $dompdf->stream('memombr ' . $nomemo . '.pdf', array("Attachment" => false));
    // var_dump($msg);
    // echo json_encode($msg);
    // } else {
    //   exit('Maaf tidak dapat diproses');
    // }
  }

  public function hapusmemombrd($id)
  {
    $this->memombrdModel->delete_by_id($id);
    session()->setFlashdata('pesan', 'Data berhasil dihapus');
    echo json_encode(array("status" => TRUE));
  }

  // public function formdetailmobil()
  // {
  //   if ($this->request->isAjax()) {
  //     $this->memombrModel->findAll();
  //     $id = $this->request->getVar('id');
  //     $row = $this->woModel->find($id);
  //     $data = [
  //       'title' => 'Detail Data Kendaraan',
  //       // 'id' => $row['id'],
  //       // 'nowo' => $row['nowo'],
  //       // 'nama' => $row['nama'],
  //       // 'npwp' => $row['npwp'],
  //       'wo' => $this->woModel->find($id),
  //       'tbagama' => $this->tbagamaModel->orderBy('nowo')->findAll(),
  //     ];
  //     // var_dump($data);
  //     $msg = [
  //       'sukses' => view('wo/formdetailmobil', $data)
  //     ];
  //     echo json_encode($msg);
  //   } else {
  //     exit('Maaf tidak dapat diproses');
  //   }
  // }

  public function cari_data_kreditur()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data Kreditur',
        'tbleasing' => $this->tbleasingModel->orderBy('kode')->findAll() //$rwtkeluarga
      ];
      $msg = [
        'data' => view('memombr/modalcarikreditur', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function repl_kreditur()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['kode_kreditur'];
      $row = $this->tbleasingModel->getkode($kode);
      if (isset($row)) {
        $data = [
          'kode' => $row['kode'],
          'nama' => $row['nama'],
        ];
      } else {
        $data = [
          'kode' => '',
          'nama' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function cari_data_asuransi()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data asuransi',
        'tbasuransi' => $this->tbasuransiModel->orderBy('kode')->findAll() //$rwtkeluarga
      ];
      $msg = [
        'data' => view('memombr/modalcariasuransi', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function repl_asuransi()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['kode_asuransi'];
      $row = $this->tbasuransiModel->getkode($kode);
      if (isset($row)) {
        $data = [
          'kode' => $row['kode'],
          'nama' => $row['nama'],
        ];
      } else {
        $data = [
          'kode' => '',
          'nama' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function cari_data_sales()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data sales',
        'tbsales' => $this->tbsalesModel->orderBy('kode')->findAll() //$rwtkeluarga
      ];
      $msg = [
        'data' => view('memombr/modalcarisales', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function repl_sales()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['kode_sales'];
      $row = $this->tbsalesModel->getkode($kode);
      if (isset($row)) {
        $data = [
          'kode' => $row['kode'],
          'nama' => $row['nama'],
        ];
      } else {
        $data = [
          'kode' => '',
          'nama' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function cari_data_spv()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data Supervisor',
        'tbsales' => $this->tbsalesModel->where('status', 'SUPERVISOR')->orderBy('kode')->findAll()
      ];
      $msg = [
        'data' => view('memombr/modalcarispv', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function repl_spv()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['kode_spv'];
      $row = $this->tbsalesModel->getspv($kode);
      if (isset($row)) {
        $data = [
          'kode' => $row['kode'],
          'nama' => $row['nama'],
        ];
      } else {
        $data = [
          'kode' => '',
          'nama' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function cari_data_mgr()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data Manager',
        'tbsales' => $this->tbsalesModel->where('status', 'MANAGER')->orderBy('kode')->findAll()
      ];
      $msg = [
        'data' => view('memombr/modalcarimgr', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function repl_mgr()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['kode_mgr'];
      $row = $this->tbsalesModel->getmgr($kode);
      if (isset($row)) {
        $data = [
          'kode' => $row['kode'],
          'nama' => $row['nama'],
        ];
      } else {
        $data = [
          'kode' => '',
          'nama' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function cari_data_customer()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data Pemesan',
        'tbcustomer' => $this->tbcustomerModel->orderBy('kode')->findAll()
      ];
      $msg = [
        'data' => view('memombr/modalcaricustomer', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function repl_customer()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['kode_customer'];
      $row = $this->tbcustomerModel->getkdcustomer($kode);
      if (isset($row)) {
        $data = [
          'kode' => $row['kode'],
          'nama' => $row['nama'],
        ];
      } else {
        $data = [
          'kode' => '',
          'nama' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function cari_data_customer_stnk()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data Pemesan',
        'tbcustomer' => $this->tbcustomerModel->orderBy('kode')->findAll()
      ];
      $msg = [
        'data' => view('memombr/modalcaricustomerstnk', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function repl_customer_stnk()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['kode_customer'];
      $row = $this->tbcustomerModel->getkdcustomer($kode);
      if (isset($row)) {
        $data = [
          'kode' => $row['kode'],
          'nama' => $row['nama'],
        ];
      } else {
        $data = [
          'kode' => '',
          'nama' => '',
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

  public function formmobil()
  {
    $id = $this->request->getVar('id');
    $row = $this->tbmobilModel->find($id);
    $nopolisi = $row['nopolisi'];
    $kdpemilik = $row['kdpemilik'];
    $data = [
      'title' => 'Detail Work Order',
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
      'sukses' => view('wo/modalmobil', $data)
    ];
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
        'data' => view('memombr/modalcariasuransi', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
  public function replasuransi()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['kdsa'];
      $row = $this->tbasuransiModel->getkode($kode);
      if (isset($row)) {
        $data = [
          'title' => 'Detail Data Memo',
          'kode' => $row['kode'],
          'nama' => $row['nama'],
        ];
      } else {
        $data = [
          'title' => 'Detail Data Memo',
          'kode' => '',
          'nama' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function proses()
  {
    if ($this->request->isAjax()) {
      $session = session();
      $id = $_POST['id'];
      $row = $this->memombrModel->find($id);
      $valid = $row['valid'];
      if (!isset($valid)) {
        $valid = '';
      }
      if ($valid == 'Y') {
      }
      $user = "Proses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      $simpandata = [
        'valid' => "Y",
        'user' => $user,
      ];
      // var_dump($simpandata);
      $this->memombrModel->update($id, $simpandata);
      $session = session();
      $row = $this->memombrModel->find($id);
      $simpanhisuser = [
        'tanggal' => date('Y-m-d'),
        'dokumen' => $row['nomemo'],
        'form' => 'Memo Mobil Baru',
        'status' => 'Proses',
        'catatan' => '',
        'user' => $session->get('nama'),
      ];
      $this->hisuserModel->insert($simpanhisuser);
      $msg = [
        'sukses' => 'Data berhasil disimpan'
      ];
      session()->setFlashdata('pesan', 'Data berhasil diupdate');
      echo json_encode($msg);
    };
  }
  public function unproses()
  {
    if ($this->request->isAjax()) {
      $id = $_POST['id'];
      $row = $this->memombrModel->find($id);
      $nomemo = $row['nomemo'];
      if ($row['mohfaktur'] == 'N') {
        $rowp = $this->pengajuandiscountModel->where('valid', 'Y')->getnomemo($nomemo);
        if ($rowp) {
          $msg = [
            'sukses' => false
          ];
          session()->setFlashdata('pesan', 'Data gagal divalidasi!');
          echo json_encode($msg);
        } else {
          $rowk = $this->penerimaankasirModel->where('valid', 'Y')->getnomemo($nomemo);
          if ($rowk) {
            $msg = [
              'sukses' => false
            ];
            session()->setFlashdata('pesan', 'Data gagal divalidasi!');
            echo json_encode($msg);
          } else {
            $session = session();
            $user = "Unproses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
            $simpandata = [
              'valid' => "N",
              'user' => $user,
            ];
            $this->memombrModel->update($id, $simpandata);
            $session = session();
            $row = $this->memombrModel->find($id);
            $simpanhisuser = [
              'tanggal' => date('Y-m-d'),
              'dokumen' => $row['nomemo'],
              'form' => 'Memo Mobil Baru',
              'status' => 'Unproses',
              'catatan' => '',
              'user' => $session->get('nama'),
            ];
            $this->hisuserModel->insert($simpanhisuser);
            $msg = [
              'sukses' => true
            ];
            session()->setFlashdata('pesan', 'Data berhasil diupdate');
            echo json_encode($msg);
          }
        }
      } else {
        $msg = [
          'sukses' => false
        ];
        session()->setFlashdata('pesan', 'Data gagal divalidasi!');
        echo json_encode($msg);
      }
    };
  }

  public function buatnomemo()
  {
    $db = \Config\Database::connect();
    $builder = $db->table("memombr");
    $builder->selectMax('nomemo');
    return $builder->get()->getResult();
  }

  public function simpanjual()
  {
    if ($this->request->isAjax()) {
      $validation = \Config\Services::validation();
      $valid = $this->validate([
        'nama_produk' => [
          'label' => 'nama_produk',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
          ]
        ],
      ]);
      if (!$valid) {
        $msg = [
          'error' => [
            'nama_produk' => $validation->getError('nama_produk'),
          ]
        ];
        echo json_encode($msg);
      } else {
        $session = session();
        $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        $simpandata = [
          'nomemo' => $this->request->getVar('nomemo'),
          'nama_produk' => $this->request->getVar('nama_produk'),
          'modal' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('modal')),
          'jual' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('jual')),
          'user' => $user,
        ];
        // var_dump($simpandata);
        $this->memombrdModel->insert($simpandata);
        $msg = [
          'sukses' => 'Data berhasil ditambah'
        ];
        // session()->setFlashdata('pesan', 'Data berhasil ditambah');
        echo json_encode($msg);
      }
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function table_memombrd()
  {
    $nomemo = $_POST['nomemo'];
    $data = [
      'nomemo' => $nomemo,
      'title' => 'Penjualan Lain-lain',
      'memombrd' => $this->memombrdModel->getdata($nomemo)
    ];
    // var_dump($data);
    echo view('memombr/tabel_memombrd', $data);
  }

  public function rmemombr()
  {
    $data = [
      'menu' => 'report',
      'submenu' => 'rmemombr',
      'title' => 'Laporam Memo Mobil Baru',
    ];
    echo view('memombr/rmemombr', $data);
  }

  public function table_rmemombr()
  {
    $tanggal1 = $_POST['tanggal1'];
    $tanggal2 = $_POST['tanggal2'];
    if ($_POST['periode'] == 'off') {
      $data = [
        'title' => 'Laporam Memo Mobil Baru Semua Periode',
        'periode' => $_POST['periode'],
        'memombr' => $this->memombrModel->findAll(),
      ];
    } else {
      $data = [
        'title' => 'Laporam Memo Mobil Baru',
        'tanggal1' => $_POST['tanggal1'],
        'tanggal2' => $_POST['tanggal2'],
        'periode' => $_POST['periode'],
        'memombr' => $this->memombrModel->getperiode($tanggal1, $tanggal2),
      ];
    }
    // var_dump($data);
    echo view('memombr/tabel_rmemombr', $data);
  }

  public function cetakrmemombr($tgl1)
  {
    $tanggal1 = $tgl1;
    // $tanggal2 = $_POST['tanggal2'];
    // if ($_POST['periode'] == 'on') {
    //   $data = [
    //     'title' => 'Laporam Memo Mobil Baru',
    //     'tanggal1' => $_POST['tanggal1'],
    //     'tanggal2' => $_POST['tanggal2'],
    //     'periode' => $_POST['periode'],
    //     'memombr' => $this->memombrModel->findAll(),
    //   ];
    // } else {
    //   $data = [
    //     'title' => 'Laporam Memo Mobil Baru',
    //     'tanggal1' => $_POST['tanggal1'],
    //     'tanggal2' => $_POST['tanggal2'],
    //     'periode' => $_POST['periode'],
    //     'memombr' => $this->memombrModel->getperiode($tanggal1, $tanggal2),
    //   ];
    // }
    // var_dump($data);
    $data = [
      'title' => 'Laporam Memo Mobil Baru',
      'memombr' => $this->memombrModel->findAll(),
    ];
    return view('memombr/cetakrmemombr', $data);
  }
}
