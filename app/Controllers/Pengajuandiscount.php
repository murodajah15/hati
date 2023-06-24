<?php

namespace App\Controllers;

use App\Models\MemombrModel;
use App\Models\PengajuandiscountModel;
use App\Models\HisuserModel;
use \Dompdf\Dompdf;

class Pengajuandiscount extends BaseController
{
  protected $pengajuandiscountModel, $memombrModel, $hisuserModel;
  public function __construct()
  {
    $this->pengajuandiscountModel = new PengajuandiscountModel();
    $this->memombrModel = new MemombrModel();
    $this->hisuserModel = new HisuserModel();
  }

  public function index()
  {
    $data = [
      'menu' => 'transaksi',
      'submenu' => 'pengajuandiscount',
      'title' => 'Pengajuan Discount Mobil Baru',
      'pengajuandiscount' => $this->pengajuandiscountModel->orderBy('nomemo', 'desc')->findAll() //$wo
    ];
    echo view('pengajuandiscount/index', $data);
  }

  public function ajaxLoadData()
  {
    $request = $this->request;
    // dd($request->getPost('order[0][column]'));
    $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
    $katakunci = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
    $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
    $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
    $data = $this->pengajuandiscountModel->tampilData($request, $katakunci, $start, $length);
    $jumlahData = $this->pengajuandiscountModel->tampilData($request, $katakunci);
    $output = array(
      "draw" => intval($param['draw']),
      "recordsTotal" => count($jumlahData),
      "recordsFiltered" => count($jumlahData),
      "data" => $data,
    );
    echo json_encode($output);
  }

  public function table_pengajuandiscount()
  {
    $model = new pengajuandiscountModel();
    $data['title'] = 'Pengajuan Discount Mobil Baru';
    echo view('pengajuandiscount/tabel_pengajuandiscount', $data);
  }

  public function formdetail()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->pengajuandiscountModel->find($id);
      $nomemo = $row['nomemo'];
      $data = [
        'title' => 'Detail Data Pengajuan Discount Mobil Baru',
        'pengajuandiscount' => $this->pengajuandiscountModel->find($id),
        'memombr' => $this->memombrModel->getnomemo($nomemo),
      ];
      $msg = [
        'sukses' => view('pengajuandiscount/modaldetail', $data)
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
        'title' => 'Tambah Data Pengajuan Discount',
      ];
      $msg = [
        'data' => view('pengajuandiscount/modaltambah', $data),
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
        $nomor = 'D' . date('Y') . date('m') . sprintf("%05s", intval(substr('00000', -5)) + 1);
        $pengajuandiscount = $this->pengajuandiscountModel->buatnomor();
        if (isset($pengajuandiscount)) {
          foreach ($pengajuandiscount as $row) {
            if ($row->nomor != NULL) {
              $nomor = 'D' . date('Y') . date('m') . sprintf("%05s", intval(substr($row->nomor, -5)) + 1);
            }
          }
        }
        $simpandata = [
          'nomor' => $nomor,
          'tanggal' => $this->request->getVar('tanggal'),
          'nomemo' => $this->request->getVar('nomemo'),
          'nama_pemesan' => $this->request->getVar('nmcustomer'),
          'nama_stnk' => $this->request->getVar('nmcustomer_stnk'),
          'pembayaran' => $this->request->getVar('pembayaran'),
          'tipe' => $this->request->getVar('tipe'),
          'warna' => $this->request->getVar('warna'),
          'pembelian_accessories' => $this->request->getVar('pembelian_accessories'),
          'booking_fee' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('booking_fee')),
          'discount_team_harga' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('discount_team_harga')),
          'discount_cashback' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('discount_cashback')),
          'paket' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('paket')),
          'mediator' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('mediator')),
          'lain_lain' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('lain_lain')),
          'bonus_accessories' => $this->request->getVar('bonus_accessories'),
          'user_login' => $session->get('email'),
          'user' => $user,
        ];
        // var_dump($simpandata);
        $this->pengajuandiscountModel->insert($simpandata);
        $simpanhisuser = [
          'tanggal' => date('Y-m-d'),
          'dokumen' => $nomor,
          'form' => 'Pengajuan Discount',
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
      $row = $this->pengajuandiscountModel->find($id);
      $nomemo = $row['nomemo'];
      $data = [
        'title' => 'Edit Data Pengajuan Discount Mobil Baru',
        'pengajuandiscount' => $this->pengajuandiscountModel->find($id),
        'memombr' => $this->memombrModel->getnomemo($nomemo),
      ];
      $msg = [
        'sukses' => view('pengajuandiscount/modaledit', $data)
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function formapprov_spv()
  {
    if ($this->request->isAjax()) {
      $session = session();
      $id = $this->request->getVar('id');
      $row = $this->pengajuandiscountModel->find($id);
      $nomemo = $row['nomemo'];
      $data = [
        'title' => 'Approval Pengajuan Discount Mobil Baru',
        'pengajuandiscount' => $this->pengajuandiscountModel->find($id),
        'memombr' => $this->memombrModel->getnomemo($nomemo),
      ];
      $msg = [
        'sukses' => view('pengajuandiscount/approv_spv', $data)
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
  public function simpanapprov_spv()
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
        ]
      ]);
      if (!$valid) {
        $msg = [
          'error' => [
            'nomor' => $validation->getError('nomor'),
          ]
        ];
        echo json_encode($msg);
      } else {
        date_default_timezone_set('Asia/Jakarta');
        $tgl = date('Y-m-d H:i:s');
        $session = session();
        $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        if ($this->request->getVar('status_approv_spv') != '') {
          $simpandata = [
            'status_approv_spv' => $this->request->getVar('status_approv_spv'),
            'approv_spv' => $session->get('nama'),
            'tglapprov_spv' => $tgl,
            'ket_approv_spv' => $this->request->getVar('ket_approv_spv'),
            'user' => $user,
          ];
        } else {
          $simpandata = [
            'status_approv_spv' => '',
            'approv_spv' => '',
            'tglapprov_spv' => '',
            'ket_approv_spv' => '',
          ];
        }
        // var_dump($simpandata);
        $id = $this->request->getVar('id');
        $this->pengajuandiscountModel->update($id, $simpandata);
        $row = $this->pengajuandiscountModel->find($id);
        $simpanhisuser = [
          'tanggal' => date('Y-m-d'),
          'dokumen' => $row['nomor'],
          'form' => 'Pengajuan Discount',
          'status' => 'Approv Discount SPV ' . $row['status_approv_spv'],
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

  public function formapprov_sm()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->pengajuandiscountModel->find($id);
      $nomemo = $row['nomemo'];
      $data = [
        'title' => 'Approval Pengajuan Discount Mobil Baru',
        'pengajuandiscount' => $this->pengajuandiscountModel->find($id),
        'memombr' => $this->memombrModel->getnomemo($nomemo),
      ];
      $msg = [
        'sukses' => view('pengajuandiscount/approv_sm', $data)
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
  public function simpanapprov_sm()
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
        ]
      ]);
      if (!$valid) {
        $msg = [
          'error' => [
            'nomor' => $validation->getError('nomor'),
          ]
        ];
        echo json_encode($msg);
      } else {
        date_default_timezone_set('Asia/Jakarta');
        $tgl = date('Y-m-d H:i:s');
        $session = session();
        $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        if ($this->request->getVar('status_approv_sm') != '') {
          $simpandata = [
            'status_approv_sm' => $this->request->getVar('status_approv_sm'),
            'approv_sm' => $session->get('nama'),
            'tglapprov_sm' => $tgl,
            'ket_approv_sm' => $this->request->getVar('ket_approv_sm'),
            'user' => $user,
          ];
        } else {
          $simpandata = [
            'status_approv_sm' => '',
            'approv_sm' => '',
            'tglapprov_sm' => '',
            'ket_approv_sm' => '',
          ];
        }
        // var_dump($simpandata);
        $id = $this->request->getVar('id');
        $this->pengajuandiscountModel->update($id, $simpandata);
        //update ke memo
        if ($this->request->getVar('status_approv_sm') == 'SETUJUI') {
          $simpandata = [
            'nama_validasi' => $session->get('nama'),
            'tgl_validasi' => $tgl,
          ];
        } else {
          $simpandata = [
            'nama_validasi' => '',
            'tgl_validasi' => '',
          ];
        }
        // var_dump($simpandata);
        $row = $this->pengajuandiscountModel->find($id);
        $simpanhisuser = [
          'tanggal' => date('Y-m-d'),
          'dokumen' => $row['nomor'],
          'form' => 'Pengajuan Discount',
          'status' => 'Approv Discount SM ' . $row['status_approv_sm'],
          'catatan' => '',
          'user' => $session->get('nama'),
        ];
        $this->hisuserModel->insert($simpanhisuser);
        $nomemo = $this->request->getVar('nomemo');
        $row = $this->memombrModel->getnomemo($nomemo);
        $id = $row['id'];
        $this->memombrModel->update($id, $simpandata);
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

  public function formapprov_dir()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->pengajuandiscountModel->find($id);
      $nomemo = $row['nomemo'];
      $data = [
        'title' => 'Approval Pengajuan Discount Mobil Baru',
        'pengajuandiscount' => $this->pengajuandiscountModel->find($id),
        'memombr' => $this->memombrModel->getnomemo($nomemo),
      ];
      $msg = [
        'sukses' => view('pengajuandiscount/approv_dir', $data)
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
  public function simpanapprov_dir()
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
        ]
      ]);
      if (!$valid) {
        $msg = [
          'error' => [
            'nomor' => $validation->getError('nomor'),
          ]
        ];
        echo json_encode($msg);
      } else {
        date_default_timezone_set('Asia/Jakarta');
        $tgl = date('Y-m-d H:i:s');
        $session = session();
        $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        if ($this->request->getVar('status_approv_dir') != '') {
          if ($this->request->getVar('status_approv_dir') == 'SETUJUI') {
            $close = 'Y';
          } else {
            $close = 'N';
          }
          $simpandata = [
            'status_approv_dir' => $this->request->getVar('status_approv_dir'),
            'approv_dir' => $session->get('nama'),
            'tglapprov_dir' => $tgl,
            'ket_approv_dir' => $this->request->getVar('ket_approv_dir'),
            'close' => $close,
            'user' => $user,
          ];
        } else {
          $simpandata = [
            'status_approv_dir' => '',
            'approv_dir' => '',
            'tglapprov_dir' => '',
            'ket_approv_dir' => '',
          ];
        }
        // var_dump($simpandata);
        $id = $this->request->getVar('id');
        $idpengajuandiscount = $id;
        $this->pengajuandiscountModel->update($id, $simpandata);
        //update ke memo
        if ($this->request->getVar('status_approv_dir') == 'SETUJUI') {
          $simpandata = [
            'nama_acc_discount' => $session->get('nama'),
            'tgl_acc_discount' => $tgl,
            'pembelian_accessories' => $this->request->getVar('pembelian_accessories'),
            'bonus_accessories' => $this->request->getVar('bonus_accessories'),
            'booking_fee' => $this->request->getVar('booking_fee'),
            'disccount_team_harga' => $this->request->getVar('disccount_team_harga'),
            'disc_dealer' => $this->request->getVar('discount_cashback'),
            'mediator_nilai' => $this->request->getVar('mediator'),
            'paket' => $this->request->getVar('paket'),
            'uang_lain' => $this->request->getVar('lain_lain'),
          ];
        } else {
          $simpandata = [
            'nama_acc_discount' => '',
            'tgl_acc_discount' => '',
            'pembelian_accessories' => '',
            'bonus_accessories' => '',
            'booking_fee' => 0,
            'disccount_team_harga' => 0,
            'disc_dealer' => 0,
            'mediator_nilai' => 0,
            'paket' => 0,
            'uang_lain' => 0,
          ];
        }
        // var_dump($simpandata);
        $nomemo = $this->request->getVar('nomemo');
        $row = $this->memombrModel->getnomemo($nomemo);
        $id = $row['id'];
        $this->memombrModel->update($id, $simpandata);
        $row = $this->pengajuandiscountModel->find($idpengajuandiscount);
        $simpanhisuser = [
          'tanggal' => date('Y-m-d'),
          'dokumen' => $row['nomor'],
          'form' => 'Pengajuan Discount',
          'status' => 'Approv Discount Dir ' . $row['status_approv_dir'],
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
        ]
      ]);
      if (!$valid) {
        $msg = [
          'error' => [
            'nomor' => $validation->getError('nomor'),
          ]
        ];
        echo json_encode($msg);
      } else {
        date_default_timezone_set('Asia/Jakarta');
        $session = session();
        $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        $simpandata = [
          'tanggal' => $this->request->getVar('tanggal'),
          'nomemo' => $this->request->getVar('nomemo'),
          'nama_pemesan' => $this->request->getVar('nmcustomer'),
          'nama_stnk' => $this->request->getVar('nmcustomer_stnk'),
          'pembayaran' => $this->request->getVar('pembayaran'),
          'tipe' => $this->request->getVar('tipe'),
          'warna' => $this->request->getVar('warna'),
          'pembelian_accessories' => $this->request->getVar('pembelian_accessories'),
          'booking_fee' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('booking_fee')),
          'discount_team_harga' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('discount_team_harga')),
          'discount_cashback' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('discount_cashback')),
          'paket' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('paket')),
          'mediator' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('mediator')),
          'lain_lain' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('lain_lain')),
          'bonus_accessories' => $this->request->getVar('bonus_accessories'),
          'user_login' => $session->get('email'),
          'user' => $user,
        ];
        // var_dump($simpandata);
        $id = $this->request->getVar('id');
        $this->pengajuandiscountModel->update($id, $simpandata);
        $simpanhisuser = [
          'tanggal' => date('Y-m-d'),
          'dokumen' => $this->request->getVar('nomor'),
          'form' => 'Pengajuan Discount',
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
    $row = $this->pengajuandiscountModel->find($id);
    $simpanhisuser = [
      'tanggal' => date('Y-m-d'),
      'dokumen' => $row['nomor'],
      'form' => 'Pengajuan Discount',
      'status' => 'Hapus',
      'catatan' => '',
      'user' => $session->get('nama'),
    ];
    $this->hisuserModel->insert($simpanhisuser);
    $this->pengajuandiscountModel->delete_by_id($id);
    session()->setFlashdata('pesan', 'Data berhasil dihapus');
    echo json_encode(array("status" => TRUE));
  }

  public function cetakpengajuandiscount($id)
  {
    $session = session();
    $row = $this->pengajuandiscountModel->find($id);
    $simpanhisuser = [
      'tanggal' => date('Y-m-d'),
      'dokumen' => $row['nomor'],
      'form' => 'Pengajuan Discount',
      'status' => 'Cetak',
      'catatan' => '',
      'user' => $session->get('nama'),
    ];
    $this->hisuserModel->insert($simpanhisuser);
    $dompdf = new Dompdf();
    $row = $this->pengajuandiscountModel->find($id);
    $nomor = $row['nomor'];
    $data = [
      'title' => 'Edit Data Pengajuan Discount',
      'pengajuandiscount' => $this->pengajuandiscountModel->find($id),
    ];
    // $msg = [
    //   'sukses' => view('pengajuandiscount/cetakpengajuandiscount', $data)
    // ];
    $html =  view('pengajuandiscount/cetakpengajuandiscount', $data);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'Potrait');
    $dompdf->render();
    // $dompdf->stream(); //langsung download
    $dompdf->stream('pengajuandiscount ' . $nomor . '.pdf', array("Attachment" => false));
    // var_dump($msg);
    // echo json_encode($msg);
    // } else {
    //   exit('Maaf tidak dapat diproses');
    // }
  }

  public function cari_data_memo()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data Memo',
        'memombr' => $this->memombrModel->where('valid', 'Y')->orderBy('nomemo', 'desc')->findAll()
      ];
      $msg = [
        'data' => view('pengajuandiscount/modalcarimemo', $data),
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
      $row = $this->pengajuandiscountModel->find($id);
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
      $this->pengajuandiscountModel->update($id, $simpandata);
      $session = session();
      $row = $this->pengajuandiscountModel->find($id);
      $simpanhisuser = [
        'tanggal' => date('Y-m-d'),
        'dokumen' => $row['nomor'],
        'form' => 'Pengajuan Discount',
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
      $session = session();
      $id = $_POST['id'];
      $row = $this->pengajuandiscountModel->find($id);
      $approv_dir = $row['approv_dir'];
      if ($approv_dir != "") {
        $msg = [
          'sukses' => false
        ];
        session()->setFlashdata('pesan', 'Data gagal divalidasi!');
        echo json_encode($msg);
      } else {
        $user = "Unproses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        $simpandata = [
          'valid' => "N",
          'user' => $user,
        ];
        $this->pengajuandiscountModel->update($id, $simpandata);
        $session = session();
        $row = $this->pengajuandiscountModel->find($id);
        $simpanhisuser = [
          'tanggal' => date('Y-m-d'),
          'dokumen' => $row['nomor'],
          'form' => 'Pengajuan Discount',
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
    };
  }

  public function approv_spv()
  {
    if ($this->request->isAjax()) {
      $session = session();
      $id = $_POST['id'];
      $tgl = date('Y-m-d H:i:s');
      $row = $this->pengajuandiscountModel->find($id);
      $user = "Proses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      $simpandata = [
        'approv_spv' => $session->get('nama'),
        'tglapprov_spv' => $tgl,
      ];
      // var_dump($simpandata);
      $this->pengajuandiscountModel->update($id, $simpandata);
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
      $row = $this->pengajuandiscountModel->find($id);
      $user = "Proses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      $simpandata = [
        'approv_spv' => '',
        'tglapprov_spv' => '',
      ];
      // var_dump($simpandata);
      $this->pengajuandiscountModel->update($id, $simpandata);
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
      $row = $this->pengajuandiscountModel->find($id);
      $user = "Proses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      $simpandata = [
        'approv_sm' => $session->get('nama'),
        'tglapprov_sm' => $tgl,
      ];
      // var_dump($simpandata);
      $this->pengajuandiscountModel->update($id, $simpandata);
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
      $row = $this->pengajuandiscountModel->find($id);
      $user = "Proses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      $simpandata = [
        'approv_sm' => '',
        'tglapprov_sm' => '',
      ];
      // var_dump($simpandata);
      $this->pengajuandiscountModel->update($id, $simpandata);
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
      $row = $this->pengajuandiscountModel->find($id);
      $user = "Proses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      $simpandata = [
        'approv_dir' => $session->get('nama'),
        'tglapprov_dir' => $tgl,
      ];
      // var_dump($simpandata);
      $this->pengajuandiscountModel->update($id, $simpandata);
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
      $row = $this->pengajuandiscountModel->find($id);
      $user = "Proses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      $simpandata = [
        'approv_dir' => '',
        'tglapprov_dir' => '',
      ];
      // var_dump($simpandata);
      $this->pengajuandiscountModel->update($id, $simpandata);
      $msg = [
        'sukses' => 'Data berhasil disimpan'
      ];
      session()->setFlashdata('pesan', 'Data berhasil diupdate');
      echo json_encode($msg);
    };
  }

  public function rpengajuandiscount()
  {
    $data = [
      'menu' => 'report',
      'submenu' => 'rpengajuandiscount',
      'title' => 'Laporam Pengajuan Discount Mobil Baru',
    ];
    echo view('pengajuandiscount/rpengajuandiscount', $data);
  }

  public function table_rpengajuandiscount()
  {
    $tanggal1 = $_POST['tanggal1'];
    $tanggal2 = $_POST['tanggal2'];
    if ($_POST['periode'] == 'off') {
      $data = [
        'title' => 'Laporam Memo Mobil Baru Semua Periode',
        'periode' => $_POST['periode'],
        'pengajuandiscount' => $this->pengajuandiscountModel->findAll(),
      ];
    } else {
      $data = [
        'title' => 'Laporam Memo Mobil Baru',
        'tanggal1' => $_POST['tanggal1'],
        'tanggal2' => $_POST['tanggal2'],
        'periode' => $_POST['periode'],
        'pengajuandiscount' => $this->pengajuandiscountModel->getperiode($tanggal1, $tanggal2),
      ];
    }
    // var_dump($data);
    echo view('pengajuandiscount/tabel_rpengajuandiscount', $data);
  }
}
