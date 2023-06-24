<?php

namespace App\Controllers;

use App\Models\PenerimaankasirModel;
use App\Models\MemombrModel;
use App\Models\TbagamaModel;
use App\Models\TbsalesModel;
use App\Models\TbmodelModel;
use App\Models\TbcustomerModel;
use App\Models\TbbankModel;
use App\Models\HisuserModel;
use \Dompdf\Dompdf;
use \Dompdf\Options;
use \Mpdf\Mpdf;

class Penerimaankasir extends BaseController
{
  protected $penerimaankasirModel, $memombrModel, $tbagamaModel, $tbsalesModel, $tbmodelModel, $tbcustomerModel, $tbbankModel, $hisuserModel;
  public function __construct()
  {
    $this->penerimaankasirModel = new PenerimaankasirModel();
    $this->memombrModel = new MemombrModel();
    $this->tbagamaModel = new TbagamaModel();
    $this->tbsalesModel = new TbsalesModel();
    $this->tbmodelModel = new TbmodelModel();
    $this->tbcustomerModel = new TbcustomerModel();
    $this->tbbankModel = new TbbankModel();
    $this->hisuserModel = new HisuserModel();
  }

  public function index()
  {
    $data = [
      'menu' => 'transaksi',
      'submenu' => 'penerimaankasir',
      'title' => 'Penerimaan Kasir',
      'penerimaankasir' => $this->penerimaankasirModel->orderBy('nomor', 'desc')->findAll() //$wo
    ];
    echo view('penerimaankasir/index', $data);
  }

  public function ajaxLoadData()
  {
    $request = $this->request;
    // dd($request->getPost('order[0][column]'));
    $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
    $katakunci = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
    $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
    $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
    $data = $this->penerimaankasirModel->tampilData($request, $katakunci, $start, $length);
    $jumlahData = $this->penerimaankasirModel->tampilData($request, $katakunci);
    $output = array(
      "draw" => intval($param['draw']),
      "recordsTotal" => count($jumlahData),
      "recordsFiltered" => count($jumlahData),
      "data" => $data,
    );
    echo json_encode($output);
  }

  public function table_penerimaankasir()
  {
    $model = new penerimaankasirModel();
    $data['title'] = 'Penerimaan Kasir';
    echo view('penerimaankasir/tabel_penerimaankasir', $data);
  }

  public function formdetail()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->penerimaankasirModel->find($id);
      $data = [
        'title' => 'Detail Data Penerimaan Kasir',
        'penerimaankasir' => $this->penerimaankasirModel->find($id),
      ];
      $msg = [
        'sukses' => view('penerimaankasir/modaldetail', $data)
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
        'title' => 'Tambah Data Penerimaan Kasir',
        'tbagama' => $this->tbagamaModel->orderBy('kode', 'asc')->findAll(),
      ];
      $msg = [
        'data' => view('penerimaankasir/modaltambah', $data),
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
        $nomor = 'KT' . date('Y') . date('m') . sprintf("%05s", intval(substr('00000', -5)) + 1);
        $penerimaankasir = $this->penerimaankasirModel->buatnomor();
        if (isset($penerimaankasir)) {
          foreach ($penerimaankasir as $row) {
            if ($row->nomor != NULL) {
              $nomor = 'KT' . date('Y') . date('m') . sprintf("%05s", intval(substr($row->nomor, -5)) + 1);
            }
          }
        }
        if ($this->request->getVar('sama_spk') == 'on') {
          $sama_spk = 'Y';
        } else {
          $sama_spk = 'N';
        }
        $simpandata = [
          'nomor' => $nomor,
          'tanggal' => $this->request->getVar('tanggal'),
          'nomemo' => $this->request->getVar('nomemo'),
          'tglmemo' => $this->request->getVar('tglmemo'),
          'nospk' => $this->request->getVar('nospk'),
          'tglspk' => $this->request->getVar('tglspk'),
          'kdcustomer' => $this->request->getVar('kdcustomer'),
          'nmcustomer' => $this->request->getVar('nmcustomer'),
          'piutang' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('piutang')),
          'penerimaan' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('penerimaan')),
          'bank_charge_pr' => $this->request->getVar('bank_charge_pr'),
          'bank_charge' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('bank_charge')),
          'total_penerimaan' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('total_penerimaan')),
          // 'kdacc' => $this->request->getVar('kdacc'),
          // 'nmacc' => $this->request->getVar('nmacc'),
          'keterangan' => $this->request->getVar('keterangan'),
          'cara_bayar' => $this->request->getVar('cara_bayar'),
          'kdbank' => $this->request->getVar('kdbank'),
          'nmbank' => $this->request->getVar('nmbank'),
          'pemegang_kartu' => $this->request->getVar('pemegang_kartu'),
          'nmjnkartu' => $this->request->getVar('nmjnkartu'),
          'norek' => $this->request->getVar('norek'),
          'nocek' => $this->request->getVar('nocek'),
          'tglcek' => $this->request->getVar('tglcek'),
          'tgljttempocek' => $this->request->getVar('tgljttempocek'),
          'user' => $user,
        ];
        // var_dump($simpandata);
        $this->penerimaankasirModel->insert($simpandata);
        $simpanhisuser = [
          'tanggal' => date('Y-m-d'),
          'dokumen' => $nomor,
          'form' => 'Penerimaan Kasir',
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
      $row = $this->penerimaankasirModel->find($id);
      // $nomemo = $row['nomemo'];
      $data = [
        'title' => 'Edit Data Penerimaan Kasir',
        'penerimaankasir' => $this->penerimaankasirModel->find($id),
        // 'tbagama' => $this->tbagamaModel->orderBy('kode', 'asc')->findAll(),
      ];
      $msg = [
        'sukses' => view('penerimaankasir/modaledit', $data)
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
        $simpandata = [
          'tanggal' => $this->request->getVar('tanggal'),
          'nomemo' => $this->request->getVar('nomemo'),
          'tglmemo' => $this->request->getVar('tglmemo'),
          'nospk' => $this->request->getVar('nospk'),
          'tglspk' => $this->request->getVar('tglspk'),
          'kdcustomer' => $this->request->getVar('kdcustomer'),
          'nmcustomer' => $this->request->getVar('nmcustomer'),
          'piutang' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('piutang')),
          'penerimaan' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('penerimaan')),
          'bank_charge_pr' => $this->request->getVar('bank_charge_pr'),
          'bank_charge' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('bank_charge')),
          'total_penerimaan' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('total_penerimaan')),
          // 'kdacc' => $this->request->getVar('kdacc'),
          // 'nmacc' => $this->request->getVar('nmacc'),
          'keterangan' => $this->request->getVar('keterangan'),
          'cara_bayar' => $this->request->getVar('cara_bayar'),
          'kdbank' => $this->request->getVar('kdbank'),
          'nmbank' => $this->request->getVar('nmbank'),
          'pemegang_kartu' => $this->request->getVar('pemegang_kartu'),
          'nmjnkartu' => $this->request->getVar('nmjnkartu'),
          'norek' => $this->request->getVar('norek'),
          'nocek' => $this->request->getVar('nocek'),
          'tglcek' => $this->request->getVar('tglcek'),
          'tgljttempocek' => $this->request->getVar('tgljttempocek'),
          'user' => $user,
        ];
        // var_dump($simpandata);
        $id = $this->request->getVar('id');
        $this->penerimaankasirModel->update($id, $simpandata);
        $simpanhisuser = [
          'tanggal' => date('Y-m-d'),
          'dokumen' => $this->request->getVar('nomor'),
          'form' => 'Penerimaan Kasir',
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

  public function formapprov_spv()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->penerimaankasirModel->find($id);
      $nomemo = $row['nomemo'];
      $data = [
        'title' => 'Approval Penerimaan Kasir',
        'penerimaankasir' => $this->penerimaankasirModel->find($id),
        // 'memombr' => $this->memombrModel->getnomemo($nomemo),
      ];
      $msg = [
        'sukses' => view('penerimaankasir/approv_spv', $data)
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
        $this->penerimaankasirModel->update($id, $simpandata);
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
      $row = $this->penerimaankasirModel->find($id);
      $nomemo = $row['nomemo'];
      $data = [
        'title' => 'Approval Penerimaan Kasir',
        'penerimaankasir' => $this->penerimaankasirModel->find($id),
        // 'memombr' => $this->memombrModel->getnomemo($nomemo),
      ];
      $msg = [
        'sukses' => view('penerimaankasir/approv_sm', $data)
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
        $this->penerimaankasirModel->update($id, $simpandata);
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
        // // var_dump($simpandata);
        // $nomemo = $this->request->getVar('nomemo');
        // // $row = $this->memombrModel->getnomemo($nomemo);
        // $id = $row['id'];
        // $this->memombrModel->update($id, $simpandata);
        // $msg = [
        //   'sukses' => 'Data berhasil disimpan'
        // ];
        // session()->setFlashdata('pesan', 'Data berhasil diupdate');
        // echo json_encode($msg);
      }
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function formapprov_dir()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->penerimaankasirModel->find($id);
      $nomemo = $row['nomemo'];
      $data = [
        'title' => 'Approval Penerimaan Kasir',
        'penerimaankasir' => $this->penerimaankasirModel->find($id),
        // 'memombr' => $this->memombrModel->getnomemo($nomemo),
      ];
      $msg = [
        'sukses' => view('penerimaankasir/approv_dir', $data)
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
        $this->penerimaankasirModel->update($id, $simpandata);
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
        // // var_dump($simpandata);
        // $nomemo = $this->request->getVar('nomemo');
        // $row = $this->memombrModel->getnomemo($nomemo);
        // $id = $row['id'];
        // $this->memombrModel->update($id, $simpandata);
        // $msg = [
        //   'sukses' => 'Data berhasil disimpan'
        // ];
        // session()->setFlashdata('pesan', 'Data berhasil diupdate');
        // echo json_encode($msg);
      }
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function hapus($id)
  {
    $session = session();
    $row = $this->penerimaankasirModel->find($id);
    $simpanhisuser = [
      'tanggal' => date('Y-m-d'),
      'dokumen' => $row['nomor'],
      'form' => 'Penerimaan Kasir',
      'status' => 'Hapus',
      'catatan' => '',
      'user' => $session->get('nama'),
    ];
    $this->hisuserModel->insert($simpanhisuser);
    $this->penerimaankasirModel->delete_by_id($id);
    session()->setFlashdata('pesan', 'Data berhasil dihapus');
    echo json_encode(array("status" => TRUE));
  }

  public function cetakpenerimaankasir($id)
  {
    $session = session();
    $row = $this->penerimaankasirModel->find($id);
    $simpanhisuser = [
      'tanggal' => date('Y-m-d'),
      'dokumen' => $row['nomor'],
      'form' => 'Penerimaan Kasir',
      'status' => 'Cetak',
      'catatan' => '',
      'user' => $session->get('nama'),
    ];
    $this->hisuserModel->insert($simpanhisuser);
    $data = [
      'title' => 'Edit Data Penerimaan Kasir',
      // 'penerimaankasir' => $this->penerimaankasirModel->find($id),
      'penerimaankasir' => $this->penerimaankasirModel->find($id),
    ];
    return view('penerimaankasir/cetakpenerimaankasir', $data);

    // $dompdf = new Dompdf();
    // define("DOMPDF_UNICODE_ENABLED", TRUE);
    // // $dompdf->loadHtml($aData('html'));
    // $dompdf->set_option('isRemoteEnabled', TRUE);
    // $options = new Options();
    // $options->set('chroot', realpath('localhost:8080/hati/img/logo_honda.png'));
    // $dompdf = new \Dompdf\Dompdf($options);
    // $html =  view('penerimaankasir/cetakpenerimaankasir', $data);
    // $dompdf->loadHtml($html);
    // $dompdf->setPaper('Legal', 'Potrait');
    // $dompdf->render();
    // // $dompdf->stream(); //langsung download
    // $dompdf->stream('penerimaankasir ' . $nomor . '.pdf', array("Attachment" => false));
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
    // $dompdf->stream('penerimaankasir ' . $nomor . '.pdf', array("Attachment" => false));
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
        'memombr' => $this->memombrModel->where('valid', 'Y')->orderBy('nomemo', 'desc')->findAll()
      ];
      $msg = [
        'data' => view('penerimaankasir/modalcarimemo', $data),
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

  public function cari_data_tbbank()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data Bank',
        'tbbank' => $this->tbbankModel->where('aktif', 'Y')->orderBy('nama', 'desc')->findAll()
      ];
      $msg = [
        'data' => view('penerimaankasir/modalcaritbbank', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function repl_tbbank()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['kdbank'];
      $row = $this->tbbankModel->getkode($kode);
      // var_dump($row);
      if (isset($row)) {
        $data = [
          'kdbank' => $row['kode'],
          'nmbank' => $row['nama'],
        ];
      } else {
        $data = [
          'kdbank' => '',
          'nmbank' => '',
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
      $row = $this->penerimaankasirModel->find($id);
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
      $this->penerimaankasirModel->update($id, $simpandata);
      // $row = $this->memombrModel->getnomemo($nomemo);
      // $id = $row['id'];
      // $simpandata = [
      //   'penerimaankasir' => "Y",
      // ];
      // $this->memombrModel->update($id, $simpandata);
      $simpanhisuser = [
        'tanggal' => date('Y-m-d'),
        'dokumen' => $row['nomor'],
        'form' => 'Penerimaan Kasir',
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
      $row = $this->penerimaankasirModel->find($id);
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
      $this->penerimaankasirModel->update($id, $simpandata);
      // $row = $this->memombrModel->getnomemo($nomemo);
      // $id = $row['id'];
      // $simpandata = [
      //   'penerimaankasir' => "N",
      // ];
      // $this->memombrModel->update($id, $simpandata);
      $simpanhisuser = [
        'tanggal' => date('Y-m-d'),
        'dokumen' => $row['nomor'],
        'form' => 'Penerimaan Kasir',
        'status' => 'Batal Proses',
        'catatan' => '',
        'user' => $session->get('nama'),
      ];
      $this->hisuserModel->insert($simpanhisuser);
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
      $row = $this->penerimaankasirModel->find($id);
      $user = "Proses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      $simpandata = [
        'approv_spv' => $session->get('nama'),
        'tglapprov_spv' => $tgl,
      ];
      // var_dump($simpandata);
      $this->penerimaankasirModel->update($id, $simpandata);
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
      $row = $this->penerimaankasirModel->find($id);
      $user = "Proses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      $simpandata = [
        'approv_spv' => '',
        'tglapprov_spv' => '',
      ];
      // var_dump($simpandata);
      $this->penerimaankasirModel->update($id, $simpandata);
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
      $row = $this->penerimaankasirModel->find($id);
      $user = "Proses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      $simpandata = [
        'approv_sm' => $session->get('nama'),
        'tglapprov_sm' => $tgl,
      ];
      // var_dump($simpandata);
      $this->penerimaankasirModel->update($id, $simpandata);
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
      $row = $this->penerimaankasirModel->find($id);
      $user = "Proses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      $simpandata = [
        'approv_sm' => '',
        'tglapprov_sm' => '',
      ];
      // var_dump($simpandata);
      $this->penerimaankasirModel->update($id, $simpandata);
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
      $row = $this->penerimaankasirModel->find($id);
      $user = "Proses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      $simpandata = [
        'approv_dir' => $session->get('nama'),
        'tglapprov_dir' => $tgl,
      ];
      // var_dump($simpandata);
      $this->penerimaankasirModel->update($id, $simpandata);
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
      $row = $this->penerimaankasirModel->find($id);
      $user = "Proses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      $simpandata = [
        'approv_dir' => '',
        'tglapprov_dir' => '',
      ];
      // var_dump($simpandata);
      $this->penerimaankasirModel->update($id, $simpandata);
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

  public function rpenerimaankasir()
  {
    $data = [
      'menu' => 'report',
      'submenu' => 'rpenerimaankasir',
      'title' => 'Laporam Memo Mobil Baru',
    ];
    echo view('penerimaankasir/rpenerimaankasir', $data);
  }

  public function table_rpenerimaankasir()
  {
    if ($_POST['periode'] == 'off') {
      $data = [
        'periode' => $_POST['periode'],
        'title' => 'Laporam Memo Mobil Baru Semua Periode',
        'penerimaankasir' => $this->penerimaankasirModel->findAll(),
      ];
    } else {
      $tanggal1 = $_POST['tanggal1'];
      $tanggal2 = $_POST['tanggal2'];
      $data = [
        'periode' => $_POST['periode'],
        'title' => 'Laporam Memo Mobil Baru',
        'tanggal1' => $_POST['tanggal1'],
        'tanggal2' => $_POST['tanggal2'],
        'periode' => $_POST['periode'],
        'penerimaankasir' => $this->penerimaankasirModel->getperiode($tanggal1, $tanggal2),
      ];
    }
    // var_dump($data);
    echo view('penerimaankasir/tabel_rpenerimaankasir', $data);
  }
}

ini_set('max_execution_time', 0);
ini_set('memory_limit', '2048M');
