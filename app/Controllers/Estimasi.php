<?php

namespace App\Controllers;

use App\Models\EstimasiModel;
use App\Models\EstimasipartModel;
use App\Models\EstimasibahanModel;
use App\Models\EstimasioplModel;
use App\Models\EstimasijasaModel;
use App\Models\WoModel;
use App\Models\TbcustomerModel;
use App\Models\TbmobilModel;
use App\Models\TbmerekModel;
use App\Models\TbmodelModel;
use App\Models\TbtipeModel;
use App\Models\TbwarnaModel;
use App\Models\TbjenisModel;
use App\Models\TbagamaModel;
use App\Models\TbbarangModel;
use App\Models\TbbahanModel;
use App\Models\TboplModel;
use App\Models\TbjasaModel;
use App\Models\TbsaModel;
use App\Models\TbpaketModel;
use App\Models\PaketpartModel;
use App\Models\PaketjasaModel;
use App\Models\PaketbahanModel;
use App\Models\PaketoplModel;
use App\Models\TbasuransiModel;
use \Dompdf\Dompdf;

class Estimasi extends BaseController
{
  protected $tbcustomerModel, $estimasiModel, $woModel, $tbmobilModel, $tbmerekModel, $tbmodelModel, $tbtipeModel, $tbwarnaModel, $tbjenisModel, $tbagamaModel,
    $tbbarangModel, $estimasipartModel, $estimasibahanModel, $tbbahanModel, $tboplModel, $tbjasaModel, $tbsaModel, $estimasioplModel, $estimasijasaModel, $tbpaketModel,
    $paketpartModel, $paketjasaModel, $paketbahanModel, $paketoplModel, $tbasuransiModel;
  public function __construct()
  {
    $this->estimasiModel = new EstimasiModel();
    $this->estimasipartModel = new EstimasipartModel();
    $this->estimasibahanModel = new EstimasibahanModel();
    $this->estimasioplModel = new EstimasioplModel();
    $this->estimasijasaModel = new EstimasijasaModel();
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
    $this->tbbarangModel = new TbbarangModel();
    $this->tbbahanModel = new TbbahanModel();
    $this->tboplModel = new TboplModel();
    $this->tbjasaModel = new TbjasaModel();
    $this->tbsaModel = new TbsaModel();
    $this->tbpaketModel = new TbpaketModel();
    $this->paketpartModel = new PaketpartModel();
    $this->paketjasaModel = new PaketjasaModel();
    $this->paketbahanModel = new PaketbahanModel();
    $this->paketoplModel = new PaketoplModel();
    $this->tbasuransiModel = new TbasuransiModel();
  }

  public function index()
  {
    $data = [
      'menu' => 'transaksi',
      'submenu' => 'estimasi',
      'submenu1' => 'general_repair',
      'title' => 'Estimasi Work Order',
      'estimasi' => $this->estimasiModel->orderBy('noestimasi')->findAll() //$wo
    ];
    echo view('estimasi/index', $data);
  }

  public function ajaxLoadData()
  {
    $request = $this->request;
    $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
    $katakunci = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
    $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
    $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
    $data = $this->estimasiModel->tampilData($request, $katakunci, $start, $length);
    $jumlahData = $this->estimasiModel->tampilData($request, $katakunci);
    $output = array(
      "draw" => intval($param['draw']),
      "recordsTotal" => count($jumlahData),
      "recordsFiltered" => count($jumlahData),
      "data" => $data,
    );
    // var_dump($data);
    echo json_encode($output);
  }

  public function table_mobil()
  {
    $model = new tbmobilmodel();
    $data['title'] = 'Estimas Work Order';
    $data['tbmobil'] = $model->getnopolisi();
    // dd($data);
    echo view('estimasi/tabel_mobil', $data);
  }

  public function detail_mobil()
  {
    $model = new tbmobilmodel();
    $data['title'] = 'Detail Kendaraan';
    $data['tbmobil'] = $model->getnopolisi();

    // dd($data);
    echo view('tbmobil/modaldetail', $data);
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

  public function modalestimasi()
  {
    $id = $this->request->getVar('id');
    $row = $this->tbmobilModel->find($id);
    $nopolisi = $row['nopolisi'];
    $kdpemilik = $row['kdpemilik'];
    $data = [
      'title' => 'Estimasi & WO',
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
      'sukses' => view('estimasi/modalestimasi', $data)
    ];
    echo json_encode($msg);
  }

  public function tambahestimasi()
  {
    $nopolisi = $_POST['nopolisi'];
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Tambah Data Estimasi / WO',
        'tbmobil' => $this->tbmobilModel->getnopolisi($nopolisi),
        'tbpaket' => $this->tbpaketModel->where('aktif', 'Y')->orderBy('kode', 'asc')->findAll()
      ];
      // var_dump($data);
      $msg = [
        'data' => view('estimasi/tambahestimasi', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  // public function simpandata()
  // {
  //   if ($this->request->isAjax()) {
  //     $validation = \Config\Services::validation();
  //     $valid = $this->validate([
  //       'noestimasi' => [
  //         'label' => 'noestimasi',
  //         'rules' => 'required|is_unique[wo.noestimasi]',
  //         'errors' => [
  //           'required' => '{field} tidak boleh kosong',
  //           'is_unique' => '{field} tidak boleh ada yang sama'
  //         ]
  //       ],
  //       'nopolisi' => [
  //         'label' => 'nopolisi',
  //         'rules' => 'required',
  //         'errors' => [
  //           'required' => '{field} tidak boleh kosong'
  //         ]
  //       ],
  //     ]);
  //     if (!$valid) {
  //       $msg = [
  //         'error' => [
  //           'noestimasi' => $validation->getError('noestimasi'),
  //           'nopolisi' => $validation->getError('nopolisi'),
  //         ]
  //       ];
  //       echo json_encode($msg);
  //     } else {
  //       date_default_timezone_set('Asia/Jakarta');
  //       $noestimasi = 'ES' . date('Y') . date('m') . sprintf("%05s", intval(substr('00000', -5)) + 1);
  //       $estimasi = $this->woModel->buatnoestimasi();
  //       foreach ($estimasi as $row) {
  //         if ($row->noestimasi > 0) {
  //           $noestimasi = 'ES' . date('Y') . date('m') . sprintf("%05s", intval(substr($row->noestimasi, -5)) + 1);
  //         }
  //       }
  //       $session = session();
  //       $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
  //       $simpandata = [
  //         'noestimasi' => $noestimasi, //$this->request->getVar('noestimasi'),
  //         'tanggal' => $this->request->getVar('tanggal'),
  //         'nopolisi' => $this->request->getVar('nopolisi'),
  //         'norangka' => $this->request->getVar('norangka'),
  //         'kdpemilik' => $this->request->getVar('kdpemilik'),
  //         'nmpemilik' => $this->request->getVar('nmpemilik'),
  //         'kdsa' => $this->request->getVar('kdsa'),
  //         'keluhan' => $this->request->getVar('keluhan'),
  //         'kdservice' => $this->request->getVar('kdservice'),
  //         'nmservice' => $this->request->getVar('nmservice'),
  //         'km' => $this->request->getVar('km'),
  //         'aktifitas' => $this->request->getVar('aktifitas'),
  //         'fasilitas' => $this->request->getVar('fasilitas'),
  //         'status_tunggu' => $this->request->getVar('status_tunggu'),
  //         'int_reminder' => $this->request->getVar('int_reminder'),
  //         'via' => $this->request->getVar('via'),
  //         'pr_ppn' => $this->request->getVar('pr_ppn'),
  //         'klaim' => ($this->request->getVar('klaim') === null ? 0 : 1),
  //         'internal' => ($this->request->getVar('internal') === null ? 0 : 1),
  //         'inventaris' => ($this->request->getVar('inventaris') === null ? 0 : 1),
  //         'campaign' => ($this->request->getVar('campaign') === null ? 0 : 1),
  //         'booking' => ($this->request->getVar('booking') === null ? 0 : 1),
  //         'lain_lain' => ($this->request->getVar('lain_lain') === null ? 0 : 1),
  //         'surveyor' => $this->request->getVar('surveyor'),
  //         'user' => $user,
  //       ];
  //       $this->woModel->insert($simpandata);
  //       $msg = [
  //         'sukses' => 'Data berhasil ditambah'
  //       ];
  //       session()->setFlashdata('pesan', 'Data berhasil ditambah');
  //       echo json_encode($msg);
  //     }
  //   } else {
  //     exit('Maaf tidak dapat diproses');
  //   }
  // }

  public function detailestimasi()
  {
    $id = $this->request->getVar('id');
    $row = $this->estimasiModel->find($id);
    $nopolisi = $row['nopolisi'];
    $kdpemilik = $row['kdpemilik'];
    $kdsa = $row['kdsa'];
    $kdpaket = $row['kdpaket'];
    $data = [
      'title' => 'Detail Estimasi',
      'estimasi' => $this->estimasiModel->find($id),
      'tbmobil' => $this->tbmobilModel->getnopolisi($nopolisi),
      'tbmerek' => $this->tbmerekModel->getNama(),
      'tbmodel' => $this->tbmodelModel->getMerek(),
      'tbtipe' => $this->tbtipeModel->getModel(),
      'tbwarna' => $this->tbwarnaModel->getNama(),
      'tbjenis' => $this->tbjenisModel->getNama(),
      'tbsa' => $this->tbsaModel->getkode($kdsa),
      'tbcustomer' => $this->tbcustomerModel->getkdcustomer($kdpemilik),
      'tbpaket' => ($kdpaket ? $this->tbpaketModel->getkode($kdpaket) : ''),
    ];
    // var_dump($data);
    $msg = [
      'sukses' => view('estimasi/detailestimasi', $data)
    ];
    echo json_encode($msg);
  }

  public function inputestimasid()
  {
    $id = $this->request->getVar('id');
    $row = $this->estimasiModel->find($id);
    $nopolisi = $row['nopolisi'];
    $kdpemilik = $row['kdpemilik'];
    $data = [
      'title' => 'Update Detail Estimasi',
      'estimasi' => $this->estimasiModel->find($id),
      'tbmobil' => $this->tbmobilModel->getnopolisi($nopolisi),
      'tbmerek' => $this->tbmerekModel->getNama(),
      'tbmodel' => $this->tbmodelModel->getMerek(),
      'tbtipe' => $this->tbtipeModel->getModel(),
      'tbwarna' => $this->tbwarnaModel->getNama(),
      'tbjenis' => $this->tbjenisModel->getNama(),
      'tbcustomer' => $this->tbcustomerModel->getkdcustomer($kdpemilik),
      'tbpaket' => $this->tbpaketModel->where('aktif', 'Y')->orderBy('kode', 'asc')->findAll()
    ];

    // var_dump($data);
    $msg = [
      'sukses' => view('estimasi/inputestimasid', $data)
    ];
    echo json_encode($msg);
  }

  public function editestimasi()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->estimasiModel->find($id);
      $nopolisi = $row['nopolisi'];
      $kdpemilik = $row['kdpemilik'];
      $kdsa = $row['kdsa'];
      if (!isset($kdsa)) {
        $kdsa = "";
      }
      $data = [
        'title' => 'Edit Data Estimasi',
        // 'id' => $row['id'],
        // 'nopolisi' => $row['nopolisi'],
        // 'nama' => $row['nama'],
        // 'aktif' => $row['aktif'],
        'estimasi' => $this->estimasiModel->find($id),
        'tbmobil' => $this->tbmobilModel->getnopolisi($nopolisi),
        'tbmerek' => $this->tbmerekModel->getNama(),
        'tbmodel' => $this->tbmodelModel->getMerek(),
        'tbtipe' => $this->tbtipeModel->getModel(),
        'tbwarna' => $this->tbwarnaModel->getNama(),
        'tbjenis' => $this->tbjenisModel->getNama(),
        'tbcustomer' => $this->tbcustomerModel->getkdcustomer($kdpemilik),
        'tbsa' => ($kdsa ? $this->tbsaModel->getkode($kdsa) : ''),
        'tbpaket' => $this->tbpaketModel->where('aktif', 'Y')->orderBy('kode', 'asc')->findAll()
      ];
      // var_dump($data);
      $msg = [
        'sukses' => view('estimasi/editestimasi', $data)
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function updateestimasi()
  {
    if ($this->request->isAjax()) {
      $validation = \Config\Services::validation();
      $nowolama = $this->request->getVar('nowolama');
      $noestimasi = $this->request->getVar('noestimasi');
      $nowo = $this->request->getVar('nowo');
      if ($nowo != $nowolama) {
        $valid = $this->validate([
          'noestimasi' => [
            'label' => 'noestimasi',
            'rules' => 'required|is_unique[estimasi.noestimasi]',
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
        // if ($this->request->getVar('internal') === null) {
        //   $internal = 0;
        // } else {
        //   $internal = 1;
        // }
        $simpandata = [
          'noestimasi' => $this->request->getVar('noestimasi'),
          'tanggal' => $this->request->getVar('tanggal'),
          'nopolisi' => $this->request->getVar('nopolisi'),
          'norangka' => $this->request->getVar('norangka'),
          'kdpemilik' => $this->request->getVar('kdpemilik'),
          'nmpemilik' => $this->request->getVar('nmpemilik'),
          'kdsa' => $this->request->getVar('kdsa'),
          'keluhan' => $this->request->getVar('keluhan'),
          'kdservice' => $this->request->getVar('kdservice'),
          // 'nmservice' => $this->request->getVar('nmservice'),
          'km' => $this->request->getVar('km'),
          'kdpaket' => $this->request->getVar('kdpaket'),
          'aktifitas' => $this->request->getVar('aktifitas'),
          'fasilitas' => $this->request->getVar('fasilitas'),
          'status_tunggu' => $this->request->getVar('status_tunggu'),
          'int_reminder' => $this->request->getVar('int_reminder'),
          'via' => $this->request->getVar('via'),
          'pr_ppn' => $this->request->getVar('pr_ppn'),
          'no_polis' => $this->request->getVar('no_polis'),
          'nama_polis' => $this->request->getVar('nama_polis'),
          'tgl_akhir_polis' => $this->request->getVar('tgl_akhir_polis'),
          'kode_asuransi' => $this->request->getVar('kode_asuransi'),
          'nama_asuransi' => $this->request->getVar('nama_asuransi'),
          'alamat_asuransi' => $this->request->getVar('alamat_asuransi'),
          'klaim' => ($this->request->getVar('klaim') === null ? 0 : 1),
          'internal' => ($this->request->getVar('internal') === null ? 0 : 1),
          'inventaris' => ($this->request->getVar('inventaris') === null ? 0 : 1),
          'campaign' => ($this->request->getVar('campaign') === null ? 0 : 1),
          'booking' => ($this->request->getVar('booking') === null ? 0 : 1),
          'lain_lain' => ($this->request->getVar('lain_lain') === null ? 0 : 1),
          'surveyor' => $this->request->getVar('surveyor'),
          'npwp' => $this->request->getVar('npwp'),
          'contact_person' => $this->request->getVar('contact_person'),
          'no_contact_person' => $this->request->getVar('no_contact_person'),
          'user' => $user,
        ];
        // var_dump($simpandata);
        $id = $this->request->getVar('id');
        $this->estimasiModel->update($id, $simpandata);
        // Cek Paket
        $row = $this->estimasiModel->getnoestimasi($noestimasi);
        foreach ($row as $k) {
          $noestimasi = $k['noestimasi'];
          $norangka = $k['norangka'];
          $kdservice = $k['kdservice'];
          $idestimasi = $k['id'];
          $pr_ppn = $k['pr_ppn'];
        }
        $this->estimasijasaModel->hapuspaket($noestimasi);
        $rowmobil = $this->tbmobilModel->getrangka($norangka);
        $kdtipe = $rowmobil['kdtipe'];
        $rowpaket = $this->tbpaketModel->getpaket($kdtipe, $kdservice);
        if ($rowpaket) {
          // foreach ($rowpaket as $paket) {
          $kdpaket = $rowpaket['kode'];
          // var_dump($kdpaket);
          // }
          $rowpaketdetail = $this->paketjasaModel->getkdpaket($kdpaket);
          foreach ($rowpaketdetail as $row) {
            $datapaket = [
              'noestimasi' => $noestimasi,
              'kode' => $row['kode'],
              'nama' => $row['nama'],
              'jenis' => 'JASA',
              'qty' => $row['jam'],
              'harga' => $row['frt'],
              'subtotal' => $row['frt'] * $row['jam'],
              'users' => $user,
              'paket' => 'Y',
            ];
            $this->estimasijasaModel->insert($datapaket);
          }
          $rowpaketdetail = $this->paketpartModel->getkdpaket($kdpaket);
          foreach ($rowpaketdetail as $row) {
            $rowpart = $this->tbbarangModel->getkode($row['kode']);
            $harga_jual = $rowpart['harga_jual'];
            $datapaket = [
              'noestimasi' => $noestimasi,
              'kode' => $row['kode'],
              'nama' => $row['nama'],
              'jenis' => 'PART',
              'qty' => $row['qty'],
              'harga' => $harga_jual,
              'subtotal' => $harga_jual,
              'users' => $user,
              'paket' => 'Y',
            ];
            $this->estimasipartModel->insert($datapaket);
          }
          $rowpaketdetail = $this->paketbahanModel->getkdpaket($kdpaket);
          foreach ($rowpaketdetail as $row) {
            $rowbahan = $this->tbbahanModel->getkode($row['kode']);
            $harga_jual = $rowbahan['harga_jual'];
            $datapaket = [
              'noestimasi' => $noestimasi,
              'kode' => $row['kode'],
              'nama' => $row['nama'],
              'jenis' => 'BAHAN',
              'qty' => $row['qty'],
              'harga' => $harga_jual,
              'subtotal' => $harga_jual,
              'users' => $user,
              'paket' => 'Y',
            ];
            $this->estimasibahanModel->insert($datapaket);
          }
          $rowpaketdetail = $this->paketoplModel->getkdpaket($kdpaket);
          foreach ($rowpaketdetail as $row) {
            $rowopl = $this->tboplModel->getkode($row['kode']);
            $harga_jual = $rowopl['harga_jual'];
            $datapaket = [
              'noestimasi' => $noestimasi,
              'kode' => $row['kode'],
              'nama' => $row['nama'],
              'jenis' => 'OPL',
              'qty' => $row['qty'],
              'harga' => $harga_jual,
              'subtotal' => $harga_jual,
              'users' => $user,
              'paket' => 'Y',
            ];
            $this->estimasioplModel->insert($datapaket);
          }
          // $db = \Config\Database::connect();
          // $builder = $db->table('select sum(subtotal) from estimasi_detail as jumjasa');
          // $builder->where('noestimasi', $noestimasi);
          // $query    = $builder->get();
          $jumpart = 0;
          $jumbahan = 0;
          $jumjasa = 0;
          $jumopl = 0;
          $jumjasa = $this->estimasijasaModel->jumjasa($noestimasi);
          $jumpart = $this->estimasipartModel->jumpart($noestimasi);
          $jumbahan = $this->estimasibahanModel->jumbahan($noestimasi);
          $jumopl = $this->estimasioplModel->jumopl($noestimasi);
          foreach ($jumjasa as $j) {
            $jumjasa = $j['jumjasa'];
          }
          foreach ($jumpart as $j) {
            $jumpart = $j['jumpart'];
          }
          foreach ($jumbahan as $j) {
            $jumbahan = $j['jumbahan'];
          }
          foreach ($jumopl as $j) {
            $jumopl = $j['jumopl'];
          }
          $total = $jumpart + $jumjasa + $jumbahan + $jumopl;
          $ppn = $total * ($pr_ppn / 100);
          $total_estimasi = $total + $ppn;
          $dataupdate = [
            'id' => $idestimasi,
            'total_jasa' => $jumjasa,
            'total_part' => $jumpart,
            'total_bahan' => $jumbahan,
            'total_opl' => $jumopl,
            'total' => $total,
            'dpp' => $total,
            'ppn' => $ppn,
            'total_estimasi' => $total_estimasi,
            'paket' => 'Y',
          ];
          // var_dump($dataupdate);
          $id = $idestimasi;
          $this->estimasiModel->update($id, $dataupdate);
        }
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

  public function hapusestimasi($id)
  {
    $rowestimasi = $this->estimasiModel->find($id);
    $noestimasi = $rowestimasi['noestimasi'];
    $rowjasa = $this->estimasijasaModel->getnoestimasi($noestimasi);
    $rowpart = $this->estimasipartModel->getnoestimasi($noestimasi);
    $rowbahan = $this->estimasibahanModel->getnoestimasi($noestimasi);
    $rowopl = $this->estimasioplModel->getnoestimasi($noestimasi);
    if ($rowjasa or $rowpart or $rowbahan or $rowopl) {
      session()->setFlashdata('pesan', 'Data gagal dihapus, sudah terdapat detail transaksi');
      echo json_encode(array("status" => FALSE));
    } else {
      $this->estimasiModel->delete_by_id($id);
      session()->setFlashdata('pesan', 'Data berhasil dihapus');
      echo json_encode(array("status" => TRUE));
    }
  }

  public function cetakestimasi($id)
  {
    $dompdf = new Dompdf();
    // if ($this->request->isAjax()) {
    // $rowestimasi = $this->estimasiModel->find($id);
    // $id = $this->request->getVar('id');
    $row = $this->estimasiModel->find($id);
    $noestimasi = $row['noestimasi'];
    $nopolisi = $row['nopolisi'];
    $kdpemilik = $row['kdpemilik'];
    $kdsa = $row['kdsa'];
    if (!isset($kdsa)) {
      $kdsa = "";
    }
    $rowmobil = $this->tbmobilModel->getnopolisi($nopolisi);
    $kdmerek = $rowmobil['kdmerek'];
    $kdmodel = $rowmobil['kdmodel'];
    $kdtipe = $rowmobil['kdtipe'];
    $kdwarna = $rowmobil['kdwarna'];
    $kdjenis = $rowmobil['kdjenis'];


    $data = [
      'title' => 'Edit Data Estimasi',
      'estimasi' => $this->estimasiModel->find($id),
      'tbmobil' => $this->tbmobilModel->getnopolisi($nopolisi),
      'tbmerek' => $this->tbmerekModel->getkode($kdmerek),
      'tbmodel' => $this->tbmodelModel->getkode($kdmodel),
      'tbtipe' => $this->tbtipeModel->getkode($kdtipe),
      'tbwarna' => $this->tbwarnaModel->getkode($kdwarna),
      'tbjenis' => $this->tbjenisModel->getkode($kdjenis),
      'tbcustomer' => $this->tbcustomerModel->getkdcustomer($kdpemilik),
      'tbsa' => ($kdsa ? $this->tbsaModel->getkode($kdsa) : ''),
      'jasa' => $this->estimasijasaModel->getnoestimasi($noestimasi),
      'part' => $this->estimasipartModel->getnoestimasi($noestimasi),
      'bahan' => $this->estimasibahanModel->getnoestimasi($noestimasi),
      'opl' => $this->estimasioplModel->getnoestimasi($noestimasi),
    ];
    // var_dump($data);
    // $msg = [
    //   'sukses' => view('estimasi/cetakestimasi', $data)
    // ];
    $html =  view('estimasi/cetakestimasi', $data);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'Potrait');
    $dompdf->render();
    // $dompdf->stream(); //langsung download
    $dompdf->stream('Estimasi ' . $noestimasi . '.pdf', array("Attachment" => false));
    // var_dump($msg);
    // echo json_encode($msg);
    // } else {
    //   exit('Maaf tidak dapat diproses');
    // }
  }

  public function hapusdetailestimasi($id)
  {
    $this->estimasipartModel->hapusdetailestimasi($id);
    session()->setFlashdata('pesan', 'Data berhasil dihapus');
    echo json_encode(array("status" => TRUE));
  }

  public function table_estimasi()
  {
    $nopolisi = $_POST['nopolisi'];
    $model = new estimasimodel();
    $data['title'] = 'Estimasi';
    $data['estimasi'] = $model->getnopolisi($nopolisi);
    echo view('estimasi/tabel_estimasi', $data);
  }

  // public function formdetailmobil()
  // {
  //   if ($this->request->isAjax()) {
  //     $this->tbagamaModel->findAll();
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
          'kdsa' => $this->request->getVar('kdsa'),
          'keluhan' => $this->request->getVar('keluhan'),
          'kdservice' => $this->request->getVar('kdservice'),
          // 'nmservice' => $this->request->getVar('nmservice'),
          'km' => $this->request->getVar('km'),
          'kdpaket' => $this->request->getVar('kdpaket'),
          'aktifitas' => $this->request->getVar('aktifitas'),
          'fasilitas' => $this->request->getVar('fasilitas'),
          'status_tunggu' => $this->request->getVar('status_tunggu'),
          'int_reminder' => $this->request->getVar('int_reminder'),
          'via' => $this->request->getVar('via'),
          'pr_ppn' => $this->request->getVar('pr_ppn'),
          'no_polis' => $this->request->getVar('no_polis'),
          'nama_polis' => $this->request->getVar('nama_polis'),
          'tgl_akhir_polis' => $this->request->getVar('tgl_akhir_polis'),
          'kode_asuransi' => $this->request->getVar('kode_asuransi'),
          'nama_asuransi' => $this->request->getVar('nama_asuransi'),
          'alamat_asuransi' => $this->request->getVar('alamat_asuransi'),
          'klaim' => ($this->request->getVar('klaim') === null ? 0 : 1),
          'internal' => ($this->request->getVar('internal') === null ? 0 : 1),
          'inventaris' => ($this->request->getVar('inventaris') === null ? 0 : 1),
          'campaign' => ($this->request->getVar('campaign') === null ? 0 : 1),
          'booking' => ($this->request->getVar('booking') === null ? 0 : 1),
          'lain_lain' => ($this->request->getVar('lain_lain') === null ? 0 : 1),
          'surveyor' => $this->request->getVar('surveyor'),
          'npwp' => $this->request->getVar('npwp'),
          'contact_person' => $this->request->getVar('contact_person'),
          'no_contact_person' => $this->request->getVar('no_contact_person'),
          'user' => $user,
        ];
        $this->estimasiModel->insert($simpandata);
        // Cek Paket
        $row = $this->estimasiModel->getnoestimasi($noestimasi);
        foreach ($row as $k) {
          $noestimasi = $k['noestimasi'];
          $norangka = $k['norangka'];
          $idestimasi = $k['id'];
          $pr_ppn = $k['pr_ppn'];
        }
        $rowmobil = $this->tbmobilModel->getrangka($norangka);
        $kdtipe = $rowmobil['kdtipe'];
        $rowpaket = $this->tbpaketModel->gettipe($kdtipe);
        if ($rowpaket) {
          // foreach ($rowpaket as $paket) {
          $kdpaket = $rowpaket['kode'];
          // }
          $rowpaketdetail = $this->paketjasaModel->getkdpaket($kdpaket);
          foreach ($rowpaketdetail as $row) {
            $datapaket = [
              'noestimasi' => $noestimasi,
              'kode' => $row['kode'],
              'nama' => $row['nama'],
              'jenis' => 'JASA',
              'qty' => $row['jam'],
              'harga' => $row['frt'],
              'subtotal' => $row['frt'] * $row['jam'],
              'users' => $user,
            ];
            $this->estimasijasaModel->insert($datapaket);
          }
          // $db = \Config\Database::connect();
          // $builder = $db->table('select sum(subtotal) from estimasi_detail as jumjasa');
          // $builder->where('noestimasi', $noestimasi);
          // $query    = $builder->get();

          $jumpart = 0;
          $jumbahan = 0;
          $jumjasa = 0;
          $jumopl = 0;
          $jumjasa = $this->estimasijasaModel->jumjasa($noestimasi);
          $jumpart = $this->estimasipartModel->jumpart($noestimasi);
          $jumbahan = $this->estimasibahanModel->jumbahan($noestimasi);
          $jumopl = $this->estimasioplModel->jumopl($noestimasi);
          foreach ($jumjasa as $j) {
            $jumjasa = $j['jumjasa'];
          }
          foreach ($jumpart as $j) {
            $jumpart = $j['jumpart'];
          }
          foreach ($jumbahan as $j) {
            $jumbahan = $j['jumbahan'];
          }
          foreach ($jumopl as $j) {
            $jumopl = $j['jumopl'];
          }
          $total = $jumpart + $jumjasa + $jumbahan + $jumopl;
          $ppn = $total * ($pr_ppn / 100);
          $total_estimasi = $total + $ppn;
          $dataupdate = [
            'id' => $idestimasi,
            'total_jasa' => $jumjasa,
            'total_part' => $jumpart,
            'total_bahan' => $jumbahan,
            'total_opl' => $jumopl,
            'total' => $total,
            'dpp' => $total,
            'ppn' => $ppn,
            'total_estimasi' => $total_estimasi
          ];
          // var_dump($dataupdate);
          $id = $idestimasi;
          $this->estimasiModel->update($id, $dataupdate);
        }
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

  public function caridatapart()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data Part',
        'tbbarang' => $this->tbbarangModel->where('aktif', 'Y')->orderBy('kode', 'asc')->findAll() //$rwtkeluarga
      ];
      $msg = [
        'data' => view('estimasi/modalcaripart', $data),
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
        'data' => view('estimasi/modalcaribahan', $data),
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
        'data' => view('estimasi/modalcariopl', $data),
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
        'data' => view('estimasi/modalcarijasa', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function simpanestimasid()
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
        $session = session();
        $noestimasi = $this->request->getVar('noestimasi');
        $kode = $this->request->getVar('kodepart');
        $data = $this->estimasipartModel->getdoublebarang($noestimasi, $kode);
        if ($data) {
          foreach ($data as $row) {
            $id = $row['id'];
          }
          $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
          $simpandata = [
            'noestimasi' => $this->request->getVar('noestimasi'),
            'kode' => $this->request->getVar('kodepart'),
            'nama' => $this->request->getVar('namapart'),
            'jenis' => 'PART',
            'qty' => $this->request->getVar('qtypart'),
            'harga' => str_replace(",", "", $this->request->getVar('hargapart')),
            'pr_discount' => $this->request->getVar('pr_discountpart'),
            'subtotal' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('subtotalpart')),
            // 'harga' => $this->request->getVar('hargapart'),
            // 'pr_discount' => $this->request->getVar('pr_discountpart'),
            // 'subtotal' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('subtotalpart')),
            'user' => $user,
          ];
          if ($this->request->getVar('qtypart') > 0) {
            $this->estimasipartModel->update($id, $simpandata);
            $msg = [
              'sukses' => 'Data berhasil diupdate'
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
        } else {
          $user = "Tambah-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
          $simpandata = [
            'noestimasi' => $this->request->getVar('noestimasi'),
            'kode' => $this->request->getVar('kodepart'),
            'nama' => $this->request->getVar('namapart'),
            'jenis' => 'PART',
            'qty' => $this->request->getVar('qtypart'),
            'harga' => str_replace(",", "", $this->request->getVar('hargapart')),
            'pr_discount' => $this->request->getVar('pr_discountpart'),
            'subtotal' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('subtotalpart')),
            // 'harga' => $this->request->getVar('hargapart'),
            // 'pr_discount' => $this->request->getVar('pr_discountpart'),
            // 'subtotal' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('subtotalpart')),
            'user' => $user,
          ];
          // var_dump($simpandata);
          if ($this->request->getVar('qtypart') > 0) {
            $this->estimasipartModel->insert($simpandata);
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

  public function table_estimasi_part()
  {
    $noestimasi = $_POST['noestimasi'];
    $data = [
      'noestimasi' => $noestimasi,
      'title' => 'Estimasi WO',
      'estimasi_part' => $this->estimasipartModel->getnoestimasi($noestimasi)
    ];
    // dd($data);
    echo view('estimasi/tbl_estimasi_part', $data);
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

  public function table_estimasi_bahan()
  {
    $noestimasi = $_POST['noestimasi'];
    $data = [
      'noestimasi' => $noestimasi,
      'title' => 'Estimasi WO',
      'estimasi_bahan' => $this->estimasibahanModel->getnoestimasi($noestimasi)
    ];
    // var_dump($data);
    echo view('estimasi/tbl_estimasi_bahan', $data);
  }

  public function replbahan()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['kodebahan'];
      $row = $this->tbbahanModel->getkode($kode);
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
        $session = session();
        $noestimasi = $this->request->getVar('noestimasi');
        $kode = $this->request->getVar('kodebahan');
        $data = $this->estimasibahanModel->getdoublebarang($noestimasi, $kode);
        if ($data) {
          foreach ($data as $row) {
            $id = $row['id'];
          }
          $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
          $simpandata = [
            'noestimasi' => $this->request->getVar('noestimasi'),
            'kode' => $this->request->getVar('kodebahan'),
            'nama' => $this->request->getVar('namabahan'),
            'jenis' => 'BAHAN',
            'qty' => $this->request->getVar('qtybahan'),
            'harga' => str_replace(",", "", $this->request->getVar('hargabahan')),
            'pr_discount' => $this->request->getVar('pr_discountbahan'),
            'subtotal' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('subtotalbahan')),
            'user' => $user,
          ];
          if ($this->request->getVar('qtybahan') > 0) {
            $this->estimasibahanModel->update($id, $simpandata);
            $msg = [
              'sukses' => 'Data berhasil diupdate'
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
        } else {
          $user = "Tambah-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
          $simpandata = [
            'noestimasi' => $this->request->getVar('noestimasi'),
            'kode' => $this->request->getVar('kodebahan'),
            'nama' => $this->request->getVar('namabahan'),
            'jenis' => 'BAHAN',
            'qty' => $this->request->getVar('qtybahan'),
            'harga' => str_replace(",", "", $this->request->getVar('hargabahan')),
            'pr_discount' => $this->request->getVar('pr_discountbahan'),
            'subtotal' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('subtotalbahan')),
            'user' => $user,
          ];
          if ($this->request->getVar('qtybahan') > 0) {
            $this->estimasibahanModel->insert($simpandata);
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

  public function table_estimasi_opl()
  {
    $noestimasi = $_POST['noestimasi'];
    $data = [
      'noestimasi' => $noestimasi,
      'title' => 'Estimasi WO',
      'estimasi_opl' => $this->estimasioplModel->getnoestimasi($noestimasi),
    ];
    // var_dump($data);
    echo view('estimasi/tbl_estimasi_opl', $data);
  }

  public function table_estimasi_jasa()
  {
    $noestimasi = $_POST['noestimasi'];
    $data = [
      'noestimasi' => $noestimasi,
      'title' => 'Estimasi WO',
      'estimasi_jasa' => $this->estimasijasaModel->getnoestimasi($noestimasi),
    ];
    // var_dump($data);
    echo view('estimasi/tbl_estimasi_jasa', $data);
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
          'harga' => $row['harga'],
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
        $session = session();
        $noestimasi = $this->request->getVar('noestimasi');
        $kode = $this->request->getVar('kodeopl');
        $data = $this->estimasioplModel->getdoublebarang($noestimasi, $kode);
        if ($data) {
          foreach ($data as $row) {
            $id = $row['id'];
          }
          $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
          $simpandata = [
            'noestimasi' => $this->request->getVar('noestimasi'),
            'kode' => $this->request->getVar('kodeopl'),
            'nama' => $this->request->getVar('namaopl'),
            'jenis' => 'OPL',
            'qty' => $this->request->getVar('qtyopl'),
            'harga' => str_replace(",", "", $this->request->getVar('hargaopl')),
            'pr_discount' => $this->request->getVar('pr_discountopl'),
            'subtotal' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('subtotalopl')),
            'user' => $user,
          ];
          if ($this->request->getVar('qtyopl') > 0) {
            $this->estimasipartModel->update($id, $simpandata);
            $msg = [
              'sukses' => 'Data berhasil diupdate'
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
        } else {
          $user = "Tambah-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
          $simpandata = [
            'noestimasi' => $this->request->getVar('noestimasi'),
            'kode' => $this->request->getVar('kodeopl'),
            'nama' => $this->request->getVar('namaopl'),
            'jenis' => 'OPL',
            'qty' => $this->request->getVar('qtyopl'),
            'harga' => str_replace(",", "", $this->request->getVar('hargaopl')),
            'pr_discount' => $this->request->getVar('pr_discountopl'),
            'subtotal' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('subtotalopl')),
            'user' => $user,
          ];
          if ($this->request->getVar('qtyopl') > 0) {
            $this->estimasipartModel->insert($simpandata);
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
        'qtyjasa' => [
          'label' => 'qtyjasa',
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
            'kodejasa' => $validation->getError('kodejasa'),
            'qtyjasa' => $validation->getError('qtyjasa'),
          ]
        ];
        echo json_encode($msg);
      } else {
        $session = session();
        $noestimasi = $this->request->getVar('noestimasi');
        $kode = $this->request->getVar('kodejasa');
        $data = $this->estimasijasaModel->getdoublebarang($noestimasi, $kode);
        if ($data) {
          foreach ($data as $row) {
            $id = $row['id'];
          }
          $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
          $simpandata = [
            'noestimasi' => $this->request->getVar('noestimasi'),
            'kode' => $this->request->getVar('kodejasa'),
            'nama' => $this->request->getVar('namajasa'),
            'jenis' => 'jasa',
            'qty' => $this->request->getVar('qtyjasa'),
            'harga' => str_replace(",", "", $this->request->getVar('hargajasa')),
            'pr_discount' => $this->request->getVar('pr_discountjasa'),
            'subtotal' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('subtotaljasa')),
            'user' => $user,
          ];
          if ($this->request->getVar('qtyjasa') > 0) {
            $this->estimasijasaModel->update($id, $simpandata);
            $msg = [
              'sukses' => 'Data berhasil diupdate'
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
        } else {
          $user = "Tambah-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
          $simpandata = [
            'noestimasi' => $this->request->getVar('noestimasi'),
            'kode' => $this->request->getVar('kodejasa'),
            'nama' => $this->request->getVar('namajasa'),
            'jenis' => 'jasa',
            'qty' => $this->request->getVar('qtyjasa'),
            'harga' => str_replace(",", "", $this->request->getVar('hargajasa')),
            'pr_discount' => $this->request->getVar('pr_discountjasa'),
            'subtotal' => preg_replace("/[^a-zA-Z0-9]/", "", $this->request->getVar('subtotaljasa')),
            'user' => $user,
          ];
          if ($this->request->getVar('qtyjasa') > 0) {
            $this->estimasijasaModel->insert($simpandata);
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

  public function summary()
  {
    $noestimasi = $_POST['noestimasi'];
    $row = $this->estimasiModel->getnoestimasi($noestimasi);
    foreach ($row as $k) {
      $noestimasi = $k['noestimasi'];
      $idestimasi = $k['id'];
      $pr_ppn = $k['pr_ppn'];
    }
    $jumpart = 0;
    $jumbahan = 0;
    $jumjasa = 0;
    $jumopl = 0;
    $jumjasa = $this->estimasijasaModel->jumjasa($noestimasi);
    $jumpart = $this->estimasipartModel->jumpart($noestimasi);
    $jumbahan = $this->estimasibahanModel->jumbahan($noestimasi);
    $jumopl = $this->estimasioplModel->jumopl($noestimasi);
    foreach ($jumjasa as $j) {
      $jumjasa = $j['jumjasa'];
    }
    foreach ($jumpart as $j) {
      $jumpart = $j['jumpart'];
    }
    foreach ($jumbahan as $j) {
      $jumbahan = $j['jumbahan'];
    }
    foreach ($jumopl as $j) {
      $jumopl = $j['jumopl'];
    }
    $total = $jumpart + $jumjasa + $jumbahan + $jumopl;
    $ppn = $total * ($pr_ppn / 100);
    $total_estimasi = $total + $ppn;
    $dataupdate = [
      'id' => $idestimasi,
      'total_jasa' => $jumjasa,
      'total_part' => $jumpart,
      'total_bahan' => $jumbahan,
      'total_opl' => $jumopl,
      'total' => $total,
      'dpp' => $total,
      'pr_ppn' => $pr_ppn,
      'ppn' => $ppn,
      'total_estimasi' => $total_estimasi
    ];
    $id = $idestimasi;
    $this->estimasiModel->update($id, $dataupdate);
    $data = [
      'title' => 'Estimasi WO',
      'estimasi' => $this->estimasiModel->getnoestimasi($noestimasi),
      'summary_part' => $this->estimasipartModel->getnoestimasi($noestimasi),
      'summary_jasa' => $this->estimasijasaModel->getnoestimasi($noestimasi),
      'summary_bahan' => $this->estimasibahanModel->getnoestimasi($noestimasi),
      'summary_opl' => $this->estimasioplModel->getnoestimasi($noestimasi),
    ];
    // var_dump($data);
    echo view('estimasi/summary', $data);
  }

  public function caridatasa()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data sa',
        'tbsa' => $this->tbsaModel->where('aktif', 'Y')->orderBy('kdsa', 'asc')->findAll() //$rwtkeluarga
      ];
      $msg = [
        'data' => view('estimasi/modalcarisa', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
  public function replsa()
  {
    if ($this->request->isAjax()) {
      $kode = $_POST['kdsa'];
      $row = $this->tbsaModel->getkode($kode);
      if (isset($row)) {
        $data = [
          'title' => 'Detail data',
          'kdsa' => $row['kdsa'],
          'nama' => $row['nama'],
        ];
      } else {
        $data = [
          'title' => 'Detail data',
          'kdsa' => '',
          'nama' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function caridataasuransi()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Cari Data Asuransi',
        'tbasuransi' => $this->tbasuransiModel->where('aktif', 'Y')->orderBy('kode', 'asc')->findAll() //$rwtkeluarga
      ];
      $msg = [
        'data' => view('estimasi/modalcariasuransi', $data),
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

  public function prosesestimasi()
  {
    if ($this->request->isAjax()) {
      $session = session();
      $id = $_POST['id'];
      $row = $this->estimasiModel->find($id);
      $close = $row['close'];
      if (!isset($close)) {
        $close = '';
      }
      if ($close == 'Y') {
      }
      $user = "Proses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      $simpandata = [
        'close' => "Y",
        'user' => $user,
      ];
      // var_dump($simpandata);
      $this->estimasiModel->update($id, $simpandata);
      $msg = [
        'sukses' => 'Data berhasil disimpan'
      ];
      session()->setFlashdata('pesan', 'Data berhasil diupdate');
      echo json_encode($msg);
    };
  }
  public function unprosesestimasi()
  {
    if ($this->request->isAjax()) {
      $session = session();
      $id = $_POST['id'];

      $user = "Unproses-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      $simpandata = [
        'close' => "N",
        'user' => $user,
      ];
      $this->estimasiModel->update($id, $simpandata);
      $msg = [
        'sukses' => 'Data berhasil disimpan'
      ];
      session()->setFlashdata('pesan', 'Data berhasil diupdate');
      echo json_encode($msg);
    };
  }
}
