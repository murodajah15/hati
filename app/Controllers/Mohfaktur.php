<?php

namespace App\Controllers;

use App\Models\MohfakturModel;
use App\Models\MemombrModel;
use App\Models\TbagamaModel;
use App\Models\TbsalesModel;
use App\Models\TbmodelModel;
use App\Models\TbcustomerModel;
use App\Models\HisuserModel;
use \Dompdf\Dompdf;
use \Dompdf\Options;
use \Mpdf\Mpdf;

class mohfaktur extends BaseController
{
  protected $mohfakturModel, $memombrModel, $tbagamaModel, $tbsalesModel, $tbmodelModel, $tbcustomerModel, $hisuserModel;
  public function __construct()
  {
    $this->mohfakturModel = new MohfakturModel();
    $this->memombrModel = new MemombrModel();
    $this->tbagamaModel = new TbagamaModel();
    $this->tbsalesModel = new TbsalesModel();
    $this->tbmodelModel = new TbmodelModel();
    $this->tbcustomerModel = new TbcustomerModel();
    $this->hisuserModel = new HisuserModel();
  }

  public function index()
  {
    $data = [
      'menu' => 'transaksi',
      'submenu' => 'mohfaktur',
      'title' => 'Permohonan Faktur Mobil Baru',
      'mohfaktur' => $this->mohfakturModel->orderBy('nomor', 'desc')->findAll() //$wo
    ];
    echo view('mohfaktur/index', $data);
  }

  public function ajaxLoadData()
  {
    $request = $this->request;
    // dd($request->getPost('order[0][column]'));
    $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
    $katakunci = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
    $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
    $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
    $data = $this->mohfakturModel->tampilData($request, $katakunci, $start, $length);
    $jumlahData = $this->mohfakturModel->tampilData($request, $katakunci);
    $output = array(
      "draw" => intval($param['draw']),
      "recordsTotal" => count($jumlahData),
      "recordsFiltered" => count($jumlahData),
      "data" => $data,
    );
    echo json_encode($output);
  }

  public function table_mohfaktur()
  {
    $model = new mohfakturModel();
    $data['title'] = 'Permohonan Faktur Mobil Baru';
    echo view('mohfaktur/tabel_mohfaktur', $data);
  }

  public function formdetail()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->mohfakturModel->find($id);
      $nomemo = $row['nomemo'];
      $data = [
        'title' => 'Detail Data Permohonan Faktur Mobil Baru',
        'mohfaktur' => $this->mohfakturModel->find($id),
        'tbagama' => $this->tbagamaModel->orderBy('kode', 'asc')->findAll(),
      ];
      $msg = [
        'sukses' => view('mohfaktur/modaldetail', $data)
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
        'title' => 'Tambah Data Permohonan Faktur',
        'tbagama' => $this->tbagamaModel->orderBy('kode', 'asc')->findAll(),
      ];
      $msg = [
        'data' => view('mohfaktur/modaltambah', $data),
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
        'nospk' => [
          'label' => 'nospk',
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
            'tanggal' => $validation->getError('tanggal'),
            'nospk' => $validation->getError('nospk'),
          ]
        ];
        echo json_encode($msg);
      } else {
        date_default_timezone_set('Asia/Jakarta');
        $session = session();
        $user = "Tambah-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        $nomor = 'F' . date('Y') . date('m') . sprintf("%05s", intval(substr('00000', -5)) + 1);
        $mohfaktur = $this->mohfakturModel->buatnomor();
        if (isset($mohfaktur)) {
          foreach ($mohfaktur as $row) {
            if ($row->nomor != NULL) {
              $nomor = 'F' . date('Y') . date('m') . sprintf("%05s", intval(substr($row->nomor, -5)) + 1);
            }
          }
        }
        if ($this->request->getVar('sama_spk') == 'on') {
          $sama_spk = 'Y';
        } else {
          $sama_spk = 'N';
        }
        if ($this->request->getVar('sama_pemesan') == 'on') {
          $sama_pemesan = 'Y';
        } else {
          $sama_pemesan = 'N';
        }
        if ($this->request->getVar('tambah_honda') == 'on') {
          $tambah_honda = 'Y';
        } else {
          $tambah_honda = 'N';
        }
        if ($this->request->getVar('tambah_nonhonda') == 'on') {
          $tambah_nonhonda = 'Y';
        } else {
          $tambah_nonhonda = 'N';
        }
        if ($this->request->getVar('ganti_honda') == 'on') {
          $ganti_honda = 'Y';
        } else {
          $ganti_honda = 'N';
        }
        if ($this->request->getVar('ganti_nonhonda') == 'on') {
          $ganti_nonhonda = 'Y';
        } else {
          $ganti_nonhonda = 'N';
        }
        $simpandata = [
          'nomor' => $nomor,
          'tanggal' => $this->request->getVar('tanggal'),
          'nomemo' => $this->request->getVar('nomemo'),
          'tglmemo' => $this->request->getVar('tanggal'),
          'nospk' => $this->request->getVar('nospk'),
          'tglspk' => $this->request->getVar('tglspk'),
          'sama_spk' => $sama_spk,
          'tipe_faktur' => $this->request->getVar('tipe_faktur'),
          'tipe_pelanggan' => $this->request->getVar('tipe_pelanggan'),
          'status_pelanggan' => $this->request->getVar('status_pelanggan'),
          'kdpemesan' => $this->request->getVar('kdpemesan'),
          'nmpemesan' => $this->request->getVar('nmpemesan'),
          'kdsales' => $this->request->getVar('kdsales'),
          'nmsales' => $this->request->getVar('nmsales'),
          'kdspv' => $this->request->getVar('kdspv'),
          'nmspv' => $this->request->getVar('nmspv'),
          'kdpemesan' => $this->request->getVar('kdpemesan'),
          'nmpemesan' => $this->request->getVar('nmpemesan'),
          'alamat_pemesan' => $this->request->getVar('alamat_pemesan'),
          'kel_pemesan' => $this->request->getVar('kel_pemesan'),
          'kec_pemesan' => $this->request->getVar('kec_pemesan'),
          'kota_pemesan' => $this->request->getVar('kota_pemesan'),
          'provinsi_pemesan' => $this->request->getVar('provinsi_pemesan'),
          'kodepos_pemesan' => $this->request->getVar('kodepos_pemesan'),
          'hp_pemesan' => $this->request->getVar('hp_pemesan'),
          'email_pemesan' => $this->request->getVar('email_pemesan'),
          'sama_pemesan' => $sama_pemesan,
          'kdstnk' => $this->request->getVar('kdstnk'),
          'nmstnk' => $this->request->getVar('nmstnk'),
          'alamat_stnk' => $this->request->getVar('alamat_stnk'),
          'kel_stnk' => $this->request->getVar('kel_stnk'),
          'kec_stnk' => $this->request->getVar('kec_stnk'),
          'kota_stnk' => $this->request->getVar('kota_stnk'),
          'provinsi_stnk' => $this->request->getVar('provinsi_stnk'),
          'kodepos_stnk' => $this->request->getVar('kodepos_stnk'),
          'hp_stnk' => $this->request->getVar('hp_stnk'),
          'email_stnk' => $this->request->getVar('email_stnk'),
          'kdmodel' => $this->request->getVar('kdmodel'),
          'nmmodel' => $this->request->getVar('nmmodel'),
          'kdtipe' => $this->request->getVar('kdtipe'),
          'nmtipe' => $this->request->getVar('nmtipe'),
          'norangka' => $this->request->getVar('norangka'),
          'nomesin' => $this->request->getVar('nomesin'),
          'kdwarna' => $this->request->getVar('kdwarna'),
          'nmwarna' => $this->request->getVar('nmwarna'),
          'accessories' => $this->request->getVar('accessories'),
          'harga' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('harga')),
          'dp' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('dp')),
          'tgl_dp' => $this->request->getVar('tgl_dp'),
          'eta' => $this->request->getVar('eta'),
          'etd' => $this->request->getVar('etd'),
          'paket' => $this->request->getVar('paket'),
          'jekel' => $this->request->getVar('jekel'),
          'tgllahir' => $this->request->getVar('tgllahir'),
          'status_menikah' => $this->request->getVar('status_menikah'),
          'jumlah_keluarga' => $this->request->getVar('jumlah_keluarga'),
          'agama' => $this->request->getVar('agama'),
          'pekerjaan' => $this->request->getVar('pekerjaan'),
          'metode_pembelian' => $this->request->getVar('metode_pembelian'),
          'tambah_honda' => $this->request->getVar('tambah_honda'),
          'tambah_nonhonda' => $this->request->getVar('tambah_nonhonda'),
          'ganti_honda' => $this->request->getVar('ganti_honda'),
          'ganti_nonhonda' => $this->request->getVar('ganti_nonhonda'),
          'metode_pembayaran' => $this->request->getVar('metode_pembayaran'),
          'leasing' => $this->request->getVar('leasing'),
          'tenor' => $this->request->getVar('tenor'),
          'bulan' => $this->request->getVar('bulan'),
          'kdsm' => $this->request->getVar('kdsm'),
          'nmsm' => $this->request->getVar('nmsm'),
          'admin' => $this->request->getVar('admin'),
          'tambah_honda' => $tambah_honda,
          'tambah_nonhonda' => $tambah_nonhonda,
          'ganti_honda' => $ganti_honda,
          'ganti_nonhonda' => $ganti_nonhonda,
          'nik_pemesan' => $this->request->getVar('nik_pemesan'),
          'nik_stnk' => $this->request->getVar('nik_stnk'),
          'nkk' => $this->request->getVar('nkk'),
          'user' => $user,
        ];
        // var_dump($simpandata);
        $this->mohfakturModel->insert($simpandata);
        $simpanhisuser = [
          'tanggal' => date('Y-m-d'),
          'dokumen' => $nomor,
          'form' => 'Permohonan Faktur',
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
      $row = $this->mohfakturModel->find($id);
      // $nomemo = $row['nomemo'];
      $data = [
        'title' => 'Edit Data Permohonan Faktur Mobil Baru',
        'mohfaktur' => $this->mohfakturModel->find($id),
        'tbagama' => $this->tbagamaModel->orderBy('kode', 'asc')->findAll(),
      ];
      $msg = [
        'sukses' => view('mohfaktur/modaledit', $data)
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
        'nomor' => [
          'label' => 'nomor',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong'
          ]
        ],
        'nospk' => [
          'label' => 'nospk',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong'
          ]
        ]
      ]);
      if (!$valid) {
        $msg = [
          'error' => [
            'nomor' => $validation->getError('nomor'),
            'nospk' => $validation->getError('nospk'),
          ]
        ];
        echo json_encode($msg);
      } else {
        date_default_timezone_set('Asia/Jakarta');
        $session = session();
        $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        if ($this->request->getVar('sama_spk') == 'on') {
          $sama_spk = 'Y';
        } else {
          $sama_spk = 'N';
        }
        if ($this->request->getVar('sama_pemesan') == 'on') {
          $sama_pemesan = 'Y';
        } else {
          $sama_pemesan = 'N';
        }
        if ($this->request->getVar('tambah_honda') == 'on') {
          $tambah_honda = 'Y';
        } else {
          $tambah_honda = 'N';
        }
        if ($this->request->getVar('tambah_nonhonda') == 'on') {
          $tambah_nonhonda = 'Y';
        } else {
          $tambah_nonhonda = 'N';
        }
        if ($this->request->getVar('ganti_honda') == 'on') {
          $ganti_honda = 'Y';
        } else {
          $ganti_honda = 'N';
        }
        if ($this->request->getVar('ganti_nonhonda') == 'on') {
          $ganti_nonhonda = 'Y';
        } else {
          $ganti_nonhonda = 'N';
        }
        $simpandata = [
          'tanggal' => $this->request->getVar('tanggal'),
          'nomemo' => $this->request->getVar('nomemo'),
          'tglmemo' => $this->request->getVar('tanggal'),
          'nospk' => $this->request->getVar('nospk'),
          'tglspk' => $this->request->getVar('tglspk'),
          'sama_spk' => $sama_spk,
          'tipe_faktur' => $this->request->getVar('tipe_faktur'),
          'tipe_pelanggan' => $this->request->getVar('tipe_pelanggan'),
          'status_pelanggan' => $this->request->getVar('status_pelanggan'),
          'kdpemesan' => $this->request->getVar('kdpemesan'),
          'nmpemesan' => $this->request->getVar('nmpemesan'),
          'kdsales' => $this->request->getVar('kdsales'),
          'nmsales' => $this->request->getVar('nmsales'),
          'kdspv' => $this->request->getVar('kdspv'),
          'nmspv' => $this->request->getVar('nmspv'),
          'kdpemesan' => $this->request->getVar('kdpemesan'),
          'nmpemesan' => $this->request->getVar('nmpemesan'),
          'alamat_pemesan' => $this->request->getVar('alamat_pemesan'),
          'kel_pemesan' => $this->request->getVar('kel_pemesan'),
          'kec_pemesan' => $this->request->getVar('kec_pemesan'),
          'kota_pemesan' => $this->request->getVar('kota_pemesan'),
          'provinsi_pemesan' => $this->request->getVar('provinsi_pemesan'),
          'kodepos_pemesan' => $this->request->getVar('kodepos_pemesan'),
          'hp_pemesan' => $this->request->getVar('hp_pemesan'),
          'email_pemesan' => $this->request->getVar('email_pemesan'),
          'sama_pemesan' => $sama_pemesan,
          'kdstnk' => $this->request->getVar('kdstnk'),
          'nmstnk' => $this->request->getVar('nmstnk'),
          'alamat_stnk' => $this->request->getVar('alamat_stnk'),
          'kel_stnk' => $this->request->getVar('kel_stnk'),
          'kec_stnk' => $this->request->getVar('kec_stnk'),
          'kota_stnk' => $this->request->getVar('kota_stnk'),
          'provinsi_stnk' => $this->request->getVar('provinsi_stnk'),
          'kodepos_stnk' => $this->request->getVar('kodepos_stnk'),
          'hp_stnk' => $this->request->getVar('hp_stnk'),
          'email_stnk' => $this->request->getVar('email_stnk'),
          'kdmodel' => $this->request->getVar('kdmodel'),
          'nmmodel' => $this->request->getVar('nmmodel'),
          'kdtipe' => $this->request->getVar('kdtipe'),
          'nmtipe' => $this->request->getVar('nmtipe'),
          'norangka' => $this->request->getVar('norangka'),
          'nomesin' => $this->request->getVar('nomesin'),
          'kdwarna' => $this->request->getVar('kdwarna'),
          'nmwarna' => $this->request->getVar('nmwarna'),
          'accessories' => $this->request->getVar('accessories'),
          'harga' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('harga')),
          'dp' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('dp')),
          'tgl_dp' => $this->request->getVar('tgl_dp'),
          'eta' => $this->request->getVar('eta'),
          'etd' => $this->request->getVar('etd'),
          'paket' => $this->request->getVar('paket'),
          'jekel' => $this->request->getVar('jekel'),
          'tgllahir' => $this->request->getVar('tgllahir'),
          'status_menikah' => $this->request->getVar('status_menikah'),
          'jumlah_keluarga' => $this->request->getVar('jumlah_keluarga'),
          'agama' => $this->request->getVar('agama'),
          'pekerjaan' => $this->request->getVar('pekerjaan'),
          'metode_pembelian' => $this->request->getVar('metode_pembelian'),
          'tambah_honda' => $this->request->getVar('tambah_honda'),
          'tambah_nonhonda' => $this->request->getVar('tambah_nonhonda'),
          'ganti_honda' => $this->request->getVar('ganti_honda'),
          'ganti_nonhonda' => $this->request->getVar('ganti_nonhonda'),
          'metode_pembayaran' => $this->request->getVar('metode_pembayaran'),
          'leasing' => $this->request->getVar('leasing'),
          'tenor' => $this->request->getVar('tenor'),
          'bulan' => $this->request->getVar('bulan'),
          'kdsm' => $this->request->getVar('kdsm'),
          'nmsm' => $this->request->getVar('nmsm'),
          'admin' => $this->request->getVar('admin'),
          'tambah_honda' => $tambah_honda,
          'tambah_nonhonda' => $tambah_nonhonda,
          'ganti_honda' => $ganti_honda,
          'ganti_nonhonda' => $ganti_nonhonda,
          'nik_pemesan' => $this->request->getVar('nik_pemesan'),
          'nik_stnk' => $this->request->getVar('nik_stnk'),
          'nkk' => $this->request->getVar('nkk'),
          'user' => $user,
        ];
        // var_dump($simpandata);
        $id = $this->request->getVar('id');
        $this->mohfakturModel->update($id, $simpandata);
        $simpanhisuser = [
          'tanggal' => date(''),
          'dokumen' => $this->request->getVar('nomor'),
          'form' => 'Permohonan Faktur',
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

  // public function formapprov_spv()
  // {
  //   if ($this->request->isAjax()) {
  //     $id = $this->request->getVar('id');
  //     $row = $this->mohfakturModel->find($id);
  //     $nomemo = $row['nomemo'];
  //     $data = [
  //       'title' => 'Approval Permohonan Faktur Mobil Baru',
  //       'mohfaktur' => $this->mohfakturModel->find($id),
  //       // 'memombr' => $this->memombrModel->getnomemo($nomemo),
  //     ];
  //     $msg = [
  //       'sukses' => view('mohfaktur/approv_spv', $data)
  //     ];
  //     echo json_encode($msg);
  //   } else {
  //     exit('Maaf tidak dapat diproses');
  //   }
  // }
  // public function simpanapprov_spv()
  // {
  //   if ($this->request->isAjax()) {
  //     $validation = \Config\Services::validation();
  //     $valid = $this->validate([
  //       'nomor' => [
  //         'label' => 'nomor',
  //         'rules' => 'required',
  //         'errors' => [
  //           'required' => '{field} tidak boleh kosong'
  //         ]
  //       ]
  //     ]);
  //     if (!$valid) {
  //       $msg = [
  //         'error' => [
  //           'nomor' => $validation->getError('nomor'),
  //         ]
  //       ];
  //       echo json_encode($msg);
  //     } else {
  //       date_default_timezone_set('Asia/Jakarta');
  //       $tgl = date('Y-m-d H:i:s');
  //       $session = session();
  //       $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
  //       if ($this->request->getVar('status_approv_spv') != '') {
  //         $simpandata = [
  //           'status_approv_spv' => $this->request->getVar('status_approv_spv'),
  //           'approv_spv' => $session->get('nama'),
  //           'tglapprov_spv' => $tgl,
  //           'ket_approv_spv' => $this->request->getVar('ket_approv_spv'),
  //           'user' => $user,
  //         ];
  //       } else {
  //         $simpandata = [
  //           'status_approv_spv' => '',
  //           'approv_spv' => '',
  //           'tglapprov_spv' => '',
  //           'ket_approv_spv' => '',
  //         ];
  //       }
  //       // var_dump($simpandata);
  //       $id = $this->request->getVar('id');
  //       $this->mohfakturModel->update($id, $simpandata);
  //       $msg = [
  //         'sukses' => 'Data berhasil disimpan'
  //       ];
  //       session()->setFlashdata('pesan', 'Data berhasil diupdate');
  //       echo json_encode($msg);
  //     }
  //   } else {
  //     exit('Maaf tidak dapat diproses');
  //   }
  // }

  // public function formapprov_sm()
  // {
  //   if ($this->request->isAjax()) {
  //     $id = $this->request->getVar('id');
  //     $row = $this->mohfakturModel->find($id);
  //     $nomemo = $row['nomemo'];
  //     $data = [
  //       'title' => 'Approval Permohonan Faktur Mobil Baru',
  //       'mohfaktur' => $this->mohfakturModel->find($id),
  //       // 'memombr' => $this->memombrModel->getnomemo($nomemo),
  //     ];
  //     $msg = [
  //       'sukses' => view('mohfaktur/approv_sm', $data)
  //     ];
  //     echo json_encode($msg);
  //   } else {
  //     exit('Maaf tidak dapat diproses');
  //   }
  // }
  // public function simpanapprov_sm()
  // {
  //   if ($this->request->isAjax()) {
  //     $validation = \Config\Services::validation();
  //     $valid = $this->validate([
  //       'nomor' => [
  //         'label' => 'nomor',
  //         'rules' => 'required',
  //         'errors' => [
  //           'required' => '{field} tidak boleh kosong'
  //         ]
  //       ]
  //     ]);
  //     if (!$valid) {
  //       $msg = [
  //         'error' => [
  //           'nomor' => $validation->getError('nomor'),
  //         ]
  //       ];
  //       echo json_encode($msg);
  //     } else {
  //       date_default_timezone_set('Asia/Jakarta');
  //       $tgl = date('Y-m-d H:i:s');
  //       $session = session();
  //       $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
  //       if ($this->request->getVar('status_approv_sm') != '') {
  //         $simpandata = [
  //           'status_approv_sm' => $this->request->getVar('status_approv_sm'),
  //           'approv_sm' => $session->get('nama'),
  //           'tglapprov_sm' => $tgl,
  //           'ket_approv_sm' => $this->request->getVar('ket_approv_sm'),
  //           'user' => $user,
  //         ];
  //       } else {
  //         $simpandata = [
  //           'status_approv_sm' => '',
  //           'approv_sm' => '',
  //           'tglapprov_sm' => '',
  //           'ket_approv_sm' => '',
  //         ];
  //       }
  //       // var_dump($simpandata);
  //       $id = $this->request->getVar('id');
  //       $this->mohfakturModel->update($id, $simpandata);
  //       //update ke memo
  //       if ($this->request->getVar('status_approv_sm') == 'SETUJUI') {
  //         $simpandata = [
  //           'nama_validasi' => $session->get('nama'),
  //           'tgl_validasi' => $tgl,
  //         ];
  //       } else {
  //         $simpandata = [
  //           'nama_validasi' => '',
  //           'tgl_validasi' => '',
  //         ];
  //       }
  //       // // var_dump($simpandata);
  //       // $nomemo = $this->request->getVar('nomemo');
  //       // // $row = $this->memombrModel->getnomemo($nomemo);
  //       // $id = $row['id'];
  //       // $this->memombrModel->update($id, $simpandata);
  //       // $msg = [
  //       //   'sukses' => 'Data berhasil disimpan'
  //       // ];
  //       // session()->setFlashdata('pesan', 'Data berhasil diupdate');
  //       // echo json_encode($msg);
  //     }
  //   } else {
  //     exit('Maaf tidak dapat diproses');
  //   }
  // }

  // public function formapprov_dir()
  // {
  //   if ($this->request->isAjax()) {
  //     $id = $this->request->getVar('id');
  //     $row = $this->mohfakturModel->find($id);
  //     $nomemo = $row['nomemo'];
  //     $data = [
  //       'title' => 'Approval Permohonan Faktur Mobil Baru',
  //       'mohfaktur' => $this->mohfakturModel->find($id),
  //       // 'memombr' => $this->memombrModel->getnomemo($nomemo),
  //     ];
  //     $msg = [
  //       'sukses' => view('mohfaktur/approv_dir', $data)
  //     ];
  //     echo json_encode($msg);
  //   } else {
  //     exit('Maaf tidak dapat diproses');
  //   }
  // }
  // public function simpanapprov_dir()
  // {
  //   if ($this->request->isAjax()) {
  //     $validation = \Config\Services::validation();
  //     $valid = $this->validate([
  //       'nomor' => [
  //         'label' => 'nomor',
  //         'rules' => 'required',
  //         'errors' => [
  //           'required' => '{field} tidak boleh kosong'
  //         ]
  //       ]
  //     ]);
  //     if (!$valid) {
  //       $msg = [
  //         'error' => [
  //           'nomor' => $validation->getError('nomor'),
  //         ]
  //       ];
  //       echo json_encode($msg);
  //     } else {
  //       date_default_timezone_set('Asia/Jakarta');
  //       $tgl = date('Y-m-d H:i:s');
  //       $session = session();
  //       $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
  //       if ($this->request->getVar('status_approv_dir') != '') {
  //         if ($this->request->getVar('status_approv_dir') == 'SETUJUI') {
  //           $close = 'Y';
  //         } else {
  //           $close = 'N';
  //         }
  //         $simpandata = [
  //           'status_approv_dir' => $this->request->getVar('status_approv_dir'),
  //           'approv_dir' => $session->get('nama'),
  //           'tglapprov_dir' => $tgl,
  //           'ket_approv_dir' => $this->request->getVar('ket_approv_dir'),
  //           'close' => $close,
  //           'user' => $user,
  //         ];
  //       } else {
  //         $simpandata = [
  //           'status_approv_dir' => '',
  //           'approv_dir' => '',
  //           'tglapprov_dir' => '',
  //           'ket_approv_dir' => '',
  //         ];
  //       }
  //       // var_dump($simpandata);
  //       $id = $this->request->getVar('id');
  //       $this->mohfakturModel->update($id, $simpandata);
  //       //update ke memo
  //       if ($this->request->getVar('status_approv_dir') == 'SETUJUI') {
  //         $simpandata = [
  //           'nama_acc_discount' => $session->get('nama'),
  //           'tgl_acc_discount' => $tgl,
  //           'pembelian_accessories' => $this->request->getVar('pembelian_accessories'),
  //           'bonus_accessories' => $this->request->getVar('bonus_accessories'),
  //           'booking_fee' => $this->request->getVar('booking_fee'),
  //           'disccount_team_harga' => $this->request->getVar('disccount_team_harga'),
  //           'disc_dealer' => $this->request->getVar('discount_cashback'),
  //           'mediator_nilai' => $this->request->getVar('mediator'),
  //           'paket' => $this->request->getVar('paket'),
  //           'uang_lain' => $this->request->getVar('lain_lain'),
  //         ];
  //       } else {
  //         $simpandata = [
  //           'nama_acc_discount' => '',
  //           'tgl_acc_discount' => '',
  //           'pembelian_accessories' => '',
  //           'bonus_accessories' => '',
  //           'booking_fee' => 0,
  //           'disccount_team_harga' => 0,
  //           'disc_dealer' => 0,
  //           'mediator_nilai' => 0,
  //           'paket' => 0,
  //           'uang_lain' => 0,
  //         ];
  //       }
  //       // // var_dump($simpandata);
  //       // $nomemo = $this->request->getVar('nomemo');
  //       // $row = $this->memombrModel->getnomemo($nomemo);
  //       // $id = $row['id'];
  //       // $this->memombrModel->update($id, $simpandata);
  //       // $msg = [
  //       //   'sukses' => 'Data berhasil disimpan'
  //       // ];
  //       // session()->setFlashdata('pesan', 'Data berhasil diupdate');
  //       // echo json_encode($msg);
  //     }
  //   } else {
  //     exit('Maaf tidak dapat diproses');
  //   }
  // }

  public function hapus($id)
  {
    $session = session();
    $row = $this->mohfakturModel->find($id);
    $simpanhisuser = [
      'tanggal' => date('Y-m-d'),
      'dokumen' => $row['nomor'],
      'form' => 'Permohonan Faktur',
      'status' => 'Hapus',
      'catatan' => '',
      'user' => $session->get('nama'),
    ];
    $this->hisuserModel->insert($simpanhisuser);
    $this->mohfakturModel->delete_by_id($id);
    session()->setFlashdata('pesan', 'Data berhasil dihapus');
    echo json_encode(array("status" => TRUE));
  }

  public function cetakmohfaktur($id)
  {
    $session = session();
    $row = $this->mohfakturModel->find($id);
    $simpanhisuser = [
      'tanggal' => date('Y-m-d'),
      'dokumen' => $row['nomor'],
      'form' => 'Permohonan Faktur',
      'status' => 'Cetak',
      'catatan' => '',
      'user' => $session->get('nama'),
    ];
    $this->hisuserModel->insert($simpanhisuser);
    $data = [
      'title' => 'Cetak Data Permohonan Faktur',
      'mohfaktur' => $this->mohfakturModel->find($id),
    ];
    return view('mohfaktur/cetakmohfaktur', $data);

    // $dompdf = new Dompdf();
    // define("DOMPDF_UNICODE_ENABLED", TRUE);
    // // $dompdf->loadHtml($aData('html'));
    // $dompdf->set_option('isRemoteEnabled', TRUE);
    // $options = new Options();
    // $options->set('chroot', realpath('localhost:8080/hati/img/logo_honda.png'));
    // $dompdf = new \Dompdf\Dompdf($options);
    // $html =  view('mohfaktur/cetakmohfaktur', $data);
    // $dompdf->loadHtml($html);
    // $dompdf->setPaper('Legal', 'Potrait');
    // $dompdf->render();
    // // $dompdf->stream(); //langsung download
    // $dompdf->stream('mohfaktur ' . $nomor . '.pdf', array("Attachment" => false));
    // // var_dump($msg);
    // // echo json_encode($msg);
    // // } else {
    // //   exit('Maaf tidak dapat diproses');
    // // }

    // // require_once base_url("./vendor/autoload.php");
    // $dompdf = new \Dompdf\Dompdf;
    // $img = 'data:image;base64,' . base64_encode(@file_get_contents('logo_honda.png'));
    // $html = $img . '<img src="' . $img . '"';
    // $dompdf->loadHtml($html);
    // $dompdf->setPaper('Legal', 'Potrait');
    // $dompdf->render();
    // // $dompdf->stream(); //langsung download
    // $dompdf->stream('mohfaktur ' . $nomor . '.pdf', array("Attachment" => false));
    // // var_dump($msg);
    // // echo json_encode($msg);
    // // } else {
    // //   exit('Maaf tidak dapat diproses');
    // // }


    // try {
    //   // require_once base_url("./vendor/autoload.php");
    //   // require_once($_SERVER['DOCUMENT_ROOT'] . '\autoload.php');

    //   //$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'utf-8', [190, 236]]);
    //   //  $mpdf = new mPDF('',    // mode - default ''
    //   // '',    // format - A4, for example, default ''
    //   // 0,     // font size - default 0
    //   // '',    // default font family
    //   // 15,    // margin_left
    //   // 15,    // margin right
    //   // 16,     // margin top
    //   // 16,    // margin bottom
    //   // 9,     // margin header
    //   // 9,     // margin footer
    //   // 'L');  // L - landscape, P - portrait

    //   // $mpdf = new \Mpdf\Mpdf([
    //   //   'format' => 'Letter',
    //   //   'margin_left' => 5,
    //   //   'margin_right' => 5,
    //   //   'margin_top' => 5,
    //   //   'margin_bottom' => 5,
    //   //   'margin_header' => 5,
    //   //   'margin_footer' => 5,
    //   // ]);
    //   require_once 'D:\xampp\htdocs\hati\vendor\autoload.php';

    //   $mpdf = new \Mpdf\Mpdf();
    //   $mpdf->SetDisplayMode(50);
    //   $mpdf->showImageErrors = true;
    //   $mpdf->mirrorMargins = 1;
    //   $mpdf->SetTitle('Generate PDF file using PHP and MPDF');
    //   $mpdf->WriteHTML('test');
    //   $mpdf->Output('test', 'I');
    // } catch (\Mpdf\MpdfException $e) {
    //   echo $e->getMessage();
    // }
  }

  public function cari_data_memo()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data Memo',
        'memombr' => $this->memombrModel->where('valid', 'Y')->where('mohfaktur', 'N')->orderBy('nomemo', 'desc')->findAll()
      ];
      $msg = [
        'data' => view('mohfaktur/modalcarimemo', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function repl_memo()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['nomemo'];
      $row = $this->memombrModel->getnomemo($kode);
      // var_dump($row);
      if (isset($row)) {
        $data = [
          'nomemo' => $row['nomemo'],
          'tglmemo' => $row['tanggal'],
        ];
      } else {
        $data = [
          'nomemo' => '',
          'tglmemo' => '',
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
      $row = $this->mohfakturModel->find($id);
      $valid = $row['valid'];
      $nomemo = $row['nomemo'];
      if (!isset($valid)) {
        $valid = 'N';
      }
      $user = "Proses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      $simpandata = [
        'valid' => "Y",
        'user' => $user,
      ];
      // var_dump($simpandata);
      $this->mohfakturModel->update($id, $simpandata);
      // Update status mohfaktur ke memombr
      $row = $this->memombrModel->getnomemo($nomemo);
      $idmemo = $row['id'];
      $simpandata = [
        'mohfaktur' => "Y",
      ];
      $this->memombrModel->update($idmemo, $simpandata);
      // Update ke hisuser
      $row = $this->mohfakturModel->find($id);
      $simpanhisuser = [
        'tanggal' => date('Y-m-d'),
        'dokumen' => $row['nomor'],
        'form' => 'Permohonan Faktur',
        'status' => 'Proses',
        'catatan' => '',
        'user' => $session->get('nama'),
      ];
      $this->hisuserModel->insert($simpanhisuser);
      $msg = [
        'sukses' => 'Data berhasil diupdate'
      ];
      session()->setFlashdata('pesan', 'Data berhasil diupdate');
      echo json_encode($msg);
    };
  }
  public function unproses()
  {
    if ($this->request->isAjax()) {
      $session = session();
      $id = $_POST['id'];
      $row = $this->mohfakturModel->find($id);
      $valid = $row['valid'];
      $nomemo = $row['nomemo'];
      if (!isset($valid)) {
        $valid = 'N';
      }
      $user = "Unproses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      $simpandata = [
        'valid' => "N",
        'user' => $user,
      ];
      $this->mohfakturModel->update($id, $simpandata);
      $row = $this->memombrModel->getnomemo($nomemo);
      $id = $row['id'];
      $simpandata = [
        'mohfaktur' => "N",
      ];
      $this->memombrModel->update($id, $simpandata);
      $msg = [
        'sukses' => true
      ];
      session()->setFlashdata('pesan', 'Data berhasil diupdate');
      echo json_encode($msg);
    };
  }

  public function approv_spv()
  {
    if ($this->request->isAjax()) {
      $session = session();
      $id = $_POST['id'];
      $tgl = date('Y-m-d H:i:s');
      $row = $this->mohfakturModel->find($id);
      $user = "Proses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      $simpandata = [
        'approv_spv' => $session->get('nama'),
        'tglapprov_spv' => $tgl,
      ];
      // var_dump($simpandata);
      $this->mohfakturModel->update($id, $simpandata);
      $msg = [
        'sukses' => 'Data berhasil disimpan'
      ];
      session()->setFlashdata('pesan', 'Data berhasil diupdate');
      echo json_encode($msg);
    };
  }
  public function batalapprov_spv()
  {
    if ($this->request->isAjax()) {
      $session = session();
      $id = $_POST['id'];
      $tgl = date('Y-m-d H:i:s');
      $row = $this->mohfakturModel->find($id);
      $user = "Proses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      $simpandata = [
        'approv_spv' => '',
        'tglapprov_spv' => '',
      ];
      // var_dump($simpandata);
      $this->mohfakturModel->update($id, $simpandata);
      $msg = [
        'sukses' => 'Data berhasil disimpan'
      ];
      session()->setFlashdata('pesan', 'Data berhasil diupdate');
      echo json_encode($msg);
    };
  }

  public function approv_sm()
  {
    if ($this->request->isAjax()) {
      $session = session();
      $id = $_POST['id'];
      $tgl = date('Y-m-d H:i:s');
      $row = $this->mohfakturModel->find($id);
      $user = "Proses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      $simpandata = [
        'approv_sm' => $session->get('nama'),
        'tglapprov_sm' => $tgl,
      ];
      // var_dump($simpandata);
      $this->mohfakturModel->update($id, $simpandata);
      $msg = [
        'sukses' => 'Data berhasil disimpan'
      ];
      session()->setFlashdata('pesan', 'Data berhasil diupdate');
      echo json_encode($msg);
    };
  }
  public function batalapprov_sm()
  {
    if ($this->request->isAjax()) {
      $session = session();
      $id = $_POST['id'];
      $tgl = date('Y-m-d H:i:s');
      $row = $this->mohfakturModel->find($id);
      $user = "Proses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      $simpandata = [
        'approv_sm' => '',
        'tglapprov_sm' => '',
      ];
      // var_dump($simpandata);
      $this->mohfakturModel->update($id, $simpandata);
      $msg = [
        'sukses' => 'Data berhasil disimpan'
      ];
      session()->setFlashdata('pesan', 'Data berhasil diupdate');
      echo json_encode($msg);
    };
  }

  public function approv_dir()
  {
    if ($this->request->isAjax()) {
      $session = session();
      $id = $_POST['id'];
      $tgl = date('Y-m-d H:i:s');
      $row = $this->mohfakturModel->find($id);
      $user = "Proses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      $simpandata = [
        'approv_dir' => $session->get('nama'),
        'tglapprov_dir' => $tgl,
      ];
      // var_dump($simpandata);
      $this->mohfakturModel->update($id, $simpandata);
      $msg = [
        'sukses' => 'Data berhasil disimpan'
      ];
      session()->setFlashdata('pesan', 'Data berhasil diupdate');
      echo json_encode($msg);
    };
  }
  public function batalapprov_dir()
  {
    if ($this->request->isAjax()) {
      $session = session();
      $id = $_POST['id'];
      $tgl = date('Y-m-d H:i:s');
      $row = $this->mohfakturModel->find($id);
      $user = "Proses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      $simpandata = [
        'approv_dir' => '',
        'tglapprov_dir' => '',
      ];
      // var_dump($simpandata);
      $this->mohfakturModel->update($id, $simpandata);
      $msg = [
        'sukses' => 'Data berhasil disimpan'
      ];
      session()->setFlashdata('pesan', 'Data berhasil diupdate');
      echo json_encode($msg);
    };
  }

  public function repl_sales()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['kode'];
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

  public function repl_model()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['kode'];
      $row = $this->tbmodelModel->getkode($kode);
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

  public function repl_sm()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['kode'];
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

  public function repl_nmstnk()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['kode'];
      $row = $this->tbcustomerModel->getkdcustomer($kode);
      if (isset($row)) {
        $data = [
          'kode' => $row['kode'],
          'nama' => $row['nama'],
          'agama' => $row['agama'],
          'tgl_lahir' => $row['tgl_lahir'],
        ];
      } else {
        $data = [
          'kode' => '',
          'nama' => '',
          'agama' => $row['agama'],
          'tgl_lahir' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function rmohfaktur()
  {
    $data = [
      'menu' => 'report',
      'submenu' => 'rmohfaktur',
      'title' => 'Laporam Memo Mobil Baru',
    ];
    echo view('mohfaktur/rmohfaktur', $data);
  }

  public function table_rmohfaktur()
  {
    $tanggal1 = $_POST['tanggal1'];
    $tanggal2 = $_POST['tanggal2'];
    if ($_POST['periode'] == 'off') {
      $data = [
        'title' => 'Laporam Memo Mobil Baru Semua Periode',
        'periode' => $_POST['periode'],
        'mohfaktur' => $this->mohfakturModel->findAll(),
      ];
    } else {
      $data = [
        'title' => 'Laporam Memo Mobil Baru',
        'tanggal1' => $_POST['tanggal1'],
        'tanggal2' => $_POST['tanggal2'],
        'periode' => $_POST['periode'],
        'mohfaktur' => $this->mohfakturModel->getperiode($tanggal1, $tanggal2),
      ];
    }
    // var_dump($data);
    echo view('mohfaktur/tabel_rmohfaktur', $data);
  }
}

ini_set('max_execution_time', 0);
ini_set('memory_limit', '2048M');
