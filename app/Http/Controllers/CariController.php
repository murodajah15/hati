<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Tbbank;
use App\Models\Tbjnskartu;
use App\Models\Tbcustomer;
use App\Models\Tbsales;
use App\Models\Tbbarang;
use App\Models\Tbbahan;
use App\Models\Tbopl;
use App\Models\Tbmultiprc;
use App\Models\Tbsupplier;
use App\Models\Tbklpcust;
use App\Models\Tbasuransi;
use App\Models\Poh;
use App\Models\Jualh;
use App\Models\Belih;
use App\Models\Mohklruangh;
use App\Models\Kasir_tagihand;
use App\Models\Kasir_tunai;
use App\Models\Tasklist_bp;
use App\Models\Tasklisttipe_bp;
use App\Models\Tasklisttipe_bpd;
use App\Models\Tasklisttipe_gr;
use App\Models\Tasklisttipe_grd;
use App\Models\Tbjasa;
use App\Models\Tbsa;
use App\Models\Wo_bp;
use App\Models\Wo_gr;


// //return type View
// use Illuminate\View\View;

class CariController extends Controller
{
  public function carijasa(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        'title' => 'Cari Jasa',
      ];
      return response()->json([
        'body' => view('modalcari.modalcarijasa', [
          'tbjasa' => Tbjasa::all(),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function repljasa(Request $request)
  {
    if ($request->Ajax()) {
      $kode = $request->kode;
      $row = Tbjasa::where('kode', $kode)->first();
      if (isset($row)) {
        $data = [
          'kodejasa' => $row['kode'],
          'namajasa' => $row['nama'],
          'jam' => $row['jam'],
          'frt' => $row['frt'],
        ];
      } else {
        $data = [
          'kodejasa' => '',
          'namajasa' => '',
          'jam' => '0',
          'frt' => '0',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  // public function caribahan(Request $request)
  // {
  //   if ($request->Ajax()) {
  //     $data = [
  //       'title' => 'Cari part',
  //     ];
  //     return response()->json([
  //       'body' => view('modalcari.modalcaripart', [
  //         'tbbarang' => Tbbarang::all(),
  //         'vdata' => $data,
  //       ])->render(),
  //       'data' => $data,
  //     ]);
  //   } else {
  //     exit('Maaf tidak dapat diproses');
  //   }
  // }

  public function replpart(Request $request)
  {
    if ($request->Ajax()) {
      $kode = $request->kode;
      $row = Tbbarang::where('kode', $kode)->first();
      if (isset($row)) {
        $data = [
          'kodepart' => $row['kode'],
          'namapart' => $row['nama'],
          // 'qty' => $row['qty'],
        ];
      } else {
        $data = [
          'kodepart' => '',
          'namapart' => '',
          // 'qty' => '0',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function caribahan(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        'title' => 'Cari bahan',
      ];
      return response()->json([
        'body' => view('modalcari.modalcaribahan', [
          'tbbahan' => Tbbahan::all(),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function replbahan(Request $request)
  {
    if ($request->Ajax()) {
      $kode = $request->kode;
      $row = Tbbahan::where('kode', $kode)->first();
      if (isset($row)) {
        $data = [
          'kodebahan' => $row['kode'],
          'namabahan' => $row['nama'],
          // 'qty' => $row['qty'],
        ];
      } else {
        $data = [
          'kodebahan' => '',
          'namabahan' => '',
          // 'qty' => '0',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function cariopl(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        'title' => 'Cari opl',
      ];
      return response()->json([
        'body' => view('modalcari.modalcariopl', [
          'tbopl' => Tbopl::all(),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function replopl(Request $request)
  {
    if ($request->Ajax()) {
      $kode = $request->kode;
      $row = Tbopl::where('kode', $kode)->first();
      if (isset($row)) {
        $data = [
          'kodeopl' => $row['kode'],
          'namaopl' => $row['nama'],
          // 'qty' => $row['qty'],
        ];
      } else {
        $data = [
          'kodeopl' => '',
          'namaopl' => '',
          // 'qty' => '0',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function caripemakai(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        'title' => 'Cari Data Pemakai',
      ];
      return response()->json([
        'body' => view('modalcari.modalcaripemakai', [
          'tbcustomer' => Tbcustomer::all(),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function replpemakai(Request $request)
  {
    if ($request->Ajax()) {
      $kode = $request->kode;
      $row = Tbcustomer::where('kode', $kode)->first();
      if (isset($row)) {
        $data = [
          'kdpemakai' => $row['kode'],
          'nmpemakai' => $row['nama'],
        ];
      } else {
        $data = [
          'kdpemakai' => '',
          'nmpemakai' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function caripemilik(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        'title' => 'Cari Data Pemilik',
      ];
      return response()->json([
        'body' => view('modalcari.modalcaripemilik', [
          'tbcustomer' => Tbcustomer::all(),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function replpemilik(Request $request)
  {
    if ($request->Ajax()) {
      $kode = $request->kode;
      $row = Tbcustomer::where('kode', $kode)->first();
      if (isset($row)) {
        $data = [
          'kdpemilik' => $row['kode'],
          'nmpemilik' => $row['nama'],
        ];
      } else {
        $data = [
          'kdpemilik' => '',
          'nmpemilik' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function cariasuransi(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        // 'menu' => 'transaksi',
        // 'submenu' => 'tbcustomer',
        // 'submenu1' => 'ref_umum',
        'title' => 'Cari Data Asuransi',
      ];
      // var_dump($data);
      return response()->json([
        'body' => view('modalcari.modalcariasuransi', [
          'tbasuransi' => Tbasuransi::all(),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function replasuransi(Request $request)
  {
    if ($request->Ajax()) {
      $kode = $request->kode; //$_GET['kode_bank'];
      $row = Tbasuransi::where('kode', $kode)->first();
      if (isset($row)) {
        $data = [
          'kdasuransi' => $row['kode'],
          'nmasuransi' => $row['nama'],
          'alamat' => $row['alamat'],
        ];
      } else {
        $data = [
          'kdasuransi' => '',
          'nmasuransi' => '',
          'alamat' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function cariasuransi_es(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        // 'menu' => 'transaksi',
        // 'submenu' => 'tbcustomer',
        // 'submenu1' => 'ref_umum',
        'title' => 'Cari Data Asuransi',
      ];
      // var_dump($data);
      return response()->json([
        'body' => view('modalcari.modalcariasuransi_es', [
          'tbasuransi' => Tbasuransi::all(),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function replasuransi_es(Request $request)
  {
    if ($request->Ajax()) {
      $kode = $request->kode; //$_GET['kode_bank'];
      $row = Tbasuransi::where('kode', $kode)->first();
      if (isset($row)) {
        $data = [
          'kdasuransi' => $row['kode'],
          'nmasuransi' => $row['nama'],
          'alamat' => $row['alamat'],
        ];
      } else {
        $data = [
          'kdasuransi' => '',
          'nmasuransi' => '',
          'alamat' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function caritltipebp(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        // 'menu' => 'transaksi',
        // 'submenu' => 'tbcustomer',
        // 'submenu1' => 'ref_umum',
        'title' => 'Cari Data Task List Tipe',
      ];
      // var_dump($data);
      return response()->json([
        'body' => view('modalcari.modalcaritltipebp', [
          'tasklist_bp' => Tasklisttipe_bp::all(),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function repltltipebp(Request $request)
  {
    if ($request->Ajax()) {
      $kode = $request->kode; //$_GET['kode_bank'];
      $row = Tasklisttipe_bp::where('kode', $kode)->first();
      if (isset($row)) {
        $data = [
          'kdtasklist_salin' => $row['kode'],
          'nmtasklist_salin' => $row['nama'],
          'kdasuransi_salin' => $row['kdasuransi'],
          'nmasuransi_salin' => $row['nmasuransi'],
        ];
      } else {
        $data = [
          'kdtasklist_salin' => '',
          'nmtasklist_salin' => '',
          'kdasuransi_salin' => '',
          'nmasuransi_salin' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function caritlbp(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        // 'menu' => 'transaksi',
        // 'submenu' => 'tbcustomer',
        // 'submenu1' => 'ref_umum',
        'title' => 'Cari Data Task List',
      ];
      // var_dump($data);
      return response()->json([
        'body' => view('modalcari.modalcaritlbp', [
          'tasklist_bp' => Tasklist_bp::all(),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function repltlbp(Request $request)
  {
    if ($request->Ajax()) {
      $kode = $request->kode; //$_GET['kode_bank'];
      $row = Tasklist_bp::where('kode', $kode)->first();
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

  public function cariklpcust(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        // 'menu' => 'transaksi',
        // 'submenu' => 'tbcustomer',
        // 'submenu1' => 'ref_umum',
        'title' => 'Cari Data Kelompok Customer',
      ];
      // var_dump($data);
      return response()->json([
        'body' => view('modalcari.modalcariklpcust', [
          'tbklpcust' => Tbklpcust::all(),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function replklpcust(Request $request)
  {
    if ($request->Ajax()) {
      $kode = $request->kode; //$_GET['kode_bank'];
      $row = Tbklpcust::where('kode', $kode)->first();
      if (isset($row)) {
        $data = [
          'kdklpcust' => $row['kode'],
          'nmklpcust' => $row['nama'],
        ];
      } else {
        $data = [
          'kdklpcust' => '',
          'nmklpcust' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function caritbbank(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        // 'menu' => 'transaksi',
        // 'submenu' => 'tbcustomer',
        // 'submenu1' => 'ref_umum',
        'title' => 'Cari Data bank',
      ];
      // var_dump($data);
      return response()->json([
        'body' => view('modalcari.modalcaribank', [
          'tbbank' => Tbbank::all(),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function repltbbank(Request $request)
  {
    if ($request->Ajax()) {
      $kode = $request->kode; //$_GET['kode_bank'];
      $row = Tbbank::where('kode', $kode)->first();
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

  public function caritbjnskartu(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        // 'menu' => 'transaksi',
        // 'submenu' => 'tbcustomer',
        // 'submenu1' => 'ref_umum',
        'title' => 'Cari Data jnskartu',
      ];
      // var_dump($data);
      return response()->json([
        'body' => view('modalcari.modalcarijnskartu', [
          'tbjnskartu' => Tbjnskartu::all(),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function repltbjnskartu(Request $request)
  {
    if ($request->Ajax()) {
      $kode = $request->kode; //$_GET['kode_jnskartu'];
      $row = Tbjnskartu::where('kode', $kode)->first();
      if (isset($row)) {
        $data = [
          'kdjnskartu' => $row['kode'],
          'nmjnskartu' => $row['nama'],
        ];
      } else {
        $data = [
          'kdjnskartu' => '',
          'nmjnskartu' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function caritbbarang(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        // 'menu' => 'transaksi',
        // 'submenu' => 'tbcustomer',
        // 'submenu1' => 'ref_umum',
        'title' => 'Cari Data Barang',
      ];
      // var_dump($data);
      return response()->json([
        'body' => view('modalcari.modalcaritbbarang', [
          'tbbarang' => Tbbarang::all(),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function repltbbarang(Request $request)
  {
    if ($request->Ajax()) {
      $kode = $request->kode_barang; //$_GET['kode_barang'];
      $row = Tbbarang::where('kode', $kode)->first();
      if (isset($row)) {
        $data = [
          'kdbarang' => $row['kode'],
          'nmbarang' => $row['nama'],
          'kdsatuan' => $row['kdsatuan'],
          'harga_jual' => $row['harga_jual'],
          'harga_beli' => $row['harga_beli'],
        ];
      } else {
        $data = [
          'kdbarang' => '',
          'nmbarang' => '',
          'kdsatuan' => '',
          'harga_jual' => 0,
          'harga_beli' => 0,
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function caritbmultiprc(Request $request)
  {
    if ($request->Ajax()) {
      $kdcustomer = $request->kode_customer;
      // $kdcustomer = $_GET['kode_customer'];
      // dd($kdcustomer);
      $data = [
        // 'menu' => 'transaksi',
        // 'submenu' => 'tbcustomer',
        // 'submenu1' => 'ref_umum',
        'title' => 'Cari Data Multi Price',
      ];
      // var_dump($data);
      return response()->json([
        'body' => view('modalcari.modalcaritbmultiprc', [
          // 'tbmultiprc' => Tbmultiprc::all(),
          'tbmultiprc' => Tbmultiprc::join('tbbarang', 'tbmultiprc.kdbarang', '=', 'tbbarang.kode')->where('tbmultiprc.kdcustomer', $kdcustomer)->get(),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function repltbmultiprc(Request $request)
  {
    if ($request->Ajax()) {
      // $kode = $request->kode_barang; //$_GET['kode_multiprc'];
      // $row = DB::table('select tbmultiprc.kode,tbmultiprc.nama,tbmultiprc.kdsatuan,tbsatuan.nama as nmsatuan')->join('tbbarang', 'tbmultiprc.kdbarang', '=', 'tbbarang.kode')->where('tbmultiprc.kdbarang', $kode)->first();
      $row = Tbmultiprc::join('tbbarang', 'tbmultiprc.kdbarang', '=', 'tbbarang.kode')->where('tbmultiprc.kdcustomer', $request->kode_customer)->where('kdbarang', $request->kode_barang)->first();
      if (isset($row)) {
        $data = [
          'kdbarang' => $row['kdbarang'],
          'nmbarang' => $row['nmbarang'],
          'kdsatuan' => $row['kdsatuan'],
          'harga_jual' => $row['harga'],
        ];
      } else {
        $data = [
          'kdbarang' => '',
          'nmbarang' => '',
          'kdsatuan' => '',
          'harga_jual' => 0,
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function caricustomer(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        // 'menu' => 'transaksi',
        // 'submenu' => 'customer',
        // 'submenu1' => 'ref_umum',
        'title' => 'Cari Data Customer',
      ];
      // var_dump($data);
      return response()->json([
        'body' => view('modalcari.modalcaricustomer', [
          'tbcustomer' => Tbcustomer::all(),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
  public function replcustomer(Request $request)
  {
    if ($request->Ajax()) {
      $kode = $_GET['kode'];
      $row = Tbcustomer::where('kode', $kode)->first();
      if (isset($row)) {
        $data = [
          'kdcustomer' => $row['kode'],
          'nmcustomer' => $row['nama'],
        ];
      } else {
        $data = [
          'kdcustomer' => '',
          'nmcustomer' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function carisales(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        // 'menu' => 'transaksi',
        // 'submenu' => 'sales',
        // 'submenu1' => 'ref_umum',
        'title' => 'Cari Data Sales',
      ];
      // var_dump($data);
      return response()->json([
        'body' => view('modalcari.modalcarisales', [
          'tbsales' => Tbsales::all(),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
  public function replsales(Request $request)
  {
    if ($request->Ajax()) {
      $kode = $_GET['kode'];
      $row = Tbsales::where('kode', $kode)->first();
      if (isset($row)) {
        $data = [
          'kdsales' => $row['kode'],
          'nmsales' => $row['nama'],
        ];
      } else {
        $data = [
          'kdsales' => '',
          'nmsales' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function carisa(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        // 'menu' => 'transaksi',
        // 'submenu' => 'sa',
        // 'submenu1' => 'ref_umum',
        'title' => 'Cari Data Service Advisor',
      ];
      // var_dump($data);
      return response()->json([
        'body' => view('modalcari.modalcarisa', [
          'tbsa' => Tbsa::all(),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
  public function replsa(Request $request)
  {
    if ($request->Ajax()) {
      $kode = $_GET['kode'];
      $row = Tbsa::where('kode', $kode)->first();
      if (isset($row)) {
        $data = [
          'kdsa' => $row['kode'],
          'nmsa' => $row['nama'],
        ];
      } else {
        $data = [
          'kdsa' => '',
          'nmsa' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function carijasa_bp(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        'title' => 'Cari Jasa',
      ];
      $kdasuransi = $request->kdasuransi;
      return response()->json([
        'body' => view('modalcari.modalcarijasa_bp', [
          'tasklisttipe_bpd' => Tasklisttipe_bpd::where('kdasuransi', $kdasuransi)->get(),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
  public function repljasa_bp(Request $request)
  {
    if ($request->Ajax()) {
      $kode = $request->kode;
      $kdasuransi = $request->kdasuransi;
      $row = Tasklisttipe_bpd::where('kode', $kode)->where('kdasuransi', $kdasuransi)->first();
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

  public function caripart_bp(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        'title' => 'Cari part',
      ];
      return response()->json([
        'body' => view('modalcari.modalcaripart_bp', [
          'tbbarang' => Tbbarang::all(),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
  public function replpart_bp(Request $request)
  {
    if ($request->Ajax()) {
      $kode = $_GET['kode'];
      $row = Tbbarang::where('kode', $kode)->first();
      if (isset($row)) {
        $data = [
          'kode' => $row['kode'],
          'nama' => $row['nama'],
          'harga' => $row['harga_jual'],
        ];
      } else {
        $data = [
          'kode' => '',
          'nama' => '',
          'harga' => '0',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function caribahan_bp(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        'title' => 'Cari Bahan',
      ];
      return response()->json([
        'body' => view('modalcari.modalcaribahan_bp', [
          'tbbahan' => Tbbahan::all(),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
  public function replbahan_bp(Request $request)
  {
    if ($request->Ajax()) {
      $kode = $_GET['kode'];
      $row = Tbbahan::where('kode', $kode)->first();
      if (isset($row)) {
        $data = [
          'kode' => $row['kode'],
          'nama' => $row['nama'],
          'harga' => $row['harga_jual'],
        ];
      } else {
        $data = [
          'kode' => '',
          'nama' => '',
          'harga' => '0',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function cariopl_bp(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        'title' => 'Cari OPL',
      ];
      return response()->json([
        'body' => view('modalcari.modalcariopl_bp', [
          'tbopl' => Tbopl::all(),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
  public function replopl_bp(Request $request)
  {
    if ($request->Ajax()) {
      $kode = $_GET['kode'];
      $row = Tbopl::where('kode', $kode)->first();
      if (isset($row)) {
        $data = [
          'kode' => $row['kode'],
          'nama' => $row['nama'],
          'harga' => $row['harga_jual'],
        ];
      } else {
        $data = [
          'kode' => '',
          'nama' => '',
          'harga' => '0',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function carijasa_gr(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        'title' => 'Cari Jasa',
      ];
      $kdtipe = $request->kdtipe;
      return response()->json([
        'body' => view('modalcari.modalcarijasa_gr', [
          'tbjasa' => Tbjasa::orderby('kode')->get(),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
  public function repljasa_gr(Request $request)
  {
    if ($request->Ajax()) {
      $kode = $request->kode;
      $kdtipe = $request->kdtipe;
      $row = Tbjasa::where('kode', $kode)->first();
      if (isset($row)) {
        $data = [
          'kode' => $row['kode'],
          'nama' => $row['nama'],
          'harga' => $row['frt'],
        ];
      } else {
        $data = [
          'kode' => '',
          'nama' => '',
          'harga' => '0',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function caripart_gr(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        'title' => 'Cari Part',
      ];
      return response()->json([
        'body' => view('modalcari.modalcaripart_gr', [
          'tbbarang' => Tbbarang::all(),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
  public function replpart_gr(Request $request)
  {
    if ($request->Ajax()) {
      $kode = $_GET['kode'];
      $row = Tbbarang::where('kode', $kode)->first();
      if (isset($row)) {
        $data = [
          'kode' => $row['kode'],
          'nama' => $row['nama'],
          'harga' => $row['harga_jual'],
        ];
      } else {
        $data = [
          'kode' => '',
          'nama' => '',
          'harga' => '0',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function caribahan_gr(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        'title' => 'Cari Bahan',
      ];
      return response()->json([
        'body' => view('modalcari.modalcaribahan_gr', [
          'tbbahan' => Tbbahan::all(),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
  public function replbahan_gr(Request $request)
  {
    if ($request->Ajax()) {
      $kode = $_GET['kode'];
      $row = Tbbahan::where('kode', $kode)->first();
      if (isset($row)) {
        $data = [
          'kode' => $row['kode'],
          'nama' => $row['nama'],
          'harga' => $row['harga_jual'],
        ];
      } else {
        $data = [
          'kode' => '',
          'nama' => '',
          'harga' => '0',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function cariopl_gr(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        'title' => 'Cari OPL',
      ];
      return response()->json([
        'body' => view('modalcari.modalcariopl_gr', [
          'tbopl' => Tbopl::all(),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
  public function replopl_gr(Request $request)
  {
    if ($request->Ajax()) {
      $kode = $_GET['kode'];
      $row = Tbopl::where('kode', $kode)->first();
      if (isset($row)) {
        $data = [
          'kode' => $row['kode'],
          'nama' => $row['nama'],
          'harga' => $row['harga_jual'],
        ];
      } else {
        $data = [
          'kode' => '',
          'nama' => '',
          'harga' => '0',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function carisupplierdetail(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        // 'menu' => 'transaksi',
        // 'submenu' => 'supplier',
        // 'submenu1' => 'ref_umum',
        'title' => 'Cari Data Supplier',
      ];
      // var_dump($data);
      return response()->json([
        'body' => view('modalcari.modalcarisupplierdetail', [
          'tbsupplier' => Tbsupplier::all(),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function carisupplier(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        // 'menu' => 'transaksi',
        // 'submenu' => 'supplier',
        // 'submenu1' => 'ref_umum',
        'title' => 'Cari Data Supplier',
      ];
      // var_dump($data);
      return response()->json([
        'body' => view('modalcari.modalcarisupplier', [
          'tbsupplier' => Tbsupplier::all(),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
  public function replsupplier(Request $request)
  {
    if ($request->Ajax()) {
      $kode = $_GET['kode'];
      $row = Tbsupplier::where('kode', $kode)->first();
      if (isset($row)) {
        $data = [
          'kdsupplier' => $row['kode'],
          'nmsupplier' => $row['nama'],
        ];
      } else {
        $data = [
          'kdsupplier' => '',
          'nmsupplier' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function caripo(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        'title' => 'Cari Penpoan',
      ];
      // var_dump($data);
      return response()->json([
        'body' => view('modalcari.modalcaripo', [
          'poh' => poh::where('proses', 'Y')->orderBy('nopo', 'desc')->get(),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
  public function replpo(Request $request)
  {
    if ($request->Ajax()) {
      $nopo = $request->nopo; //$_GET['kode_barang'];
      $row = poh::where('nopo', $nopo)->first();
      if (isset($row)) {
        $data = [
          'nopo' => $row['nopo'],
          'tglpo' => $row['tglpo'],
          'nmsupplier' => $row['nmsupplier'],
        ];
      } else {
        $data = [
          'nopo' => '',
          'tglpo' => '',
          'nmsupplier' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function carijual(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        'title' => 'Cari Penjualan',
      ];
      // var_dump($data);
      return response()->json([
        'body' => view('modalcari.modalcarijual', [
          'jualh' => Jualh::where('proses', 'Y')->orderBy('nojual', 'desc')->get(),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
  public function repljual(Request $request)
  {
    if ($request->Ajax()) {
      $nojual = $request->kode; //$_GET['kode_barang'];
      $row = Jualh::where('nojual', $nojual)->first();
      if (isset($row)) {
        $data = [
          'nojual' => $row['nojual'],
          'tgljual' => $row['tgljual'],
          'total' => $row['total'],
          'nmcustomer' => $row['nmcustomer'],
        ];
      } else {
        $data = [
          'nojual' => '',
          'tgljual' => '',
          'total' => '0',
          'nmcustomer' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function carijualpiutang(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        'title' => 'Cari Penjualan',
      ];
      // var_dump($data);
      return response()->json([
        'body' => view('modalcari.modalcarijual', [
          'jualh' => Jualh::where('proses', 'Y')->where('kurangbayar', '>', 0)->orderBy('nojual', 'desc')->get(),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
  public function repljualpiutang(Request $request)
  {
    if ($request->Ajax()) {
      $nojual = $request->kode; //$_GET['kode_barang'];
      $row = Jualh::where('nojual', $nojual)->where('kurangbayar', '>', 0)->first();
      if (isset($row)) {
        $data = [
          'nojual' => $row['nojual'],
          'tgljual' => $row['tgljual'],
          'piutang' => $row['kurangbayar'],
          'uang' => $row['kurangbayar'],
          'bayar' => $row['kurangbayar'],
          'kdcustomer' => $row['kdcustomer'],
          'nmcustomer' => $row['nmcustomer'],
        ];
      } else {
        $data = [
          'nojual' => '',
          'tgljual' => '',
          'piutang' => '0',
          'uang' => '0',
          'bayar' => '0',
          'kdcustomer' => '',
          'nmcustomer' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function carimohklruang(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        'title' => 'Cari Permohonan Keluar Uang',
      ];
      return response()->json([
        'body' => view('modalcari.modalcarimohklruang', [
          'mohklruangh' => Mohklruangh::where('proses', 'Y')->where('kurang', '>', 0)->orderBy('nomohon', 'desc')->get(),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
  public function replmohklruang(Request $request)
  {
    if ($request->Ajax()) {
      $nomohon = $request->kode; //$_GET['kode_barang'];
      $row = Mohklruangh::where('nomohon', $nomohon)->where('kurang', '>', 0)->first();
      if (isset($row)) {
        $data = [
          'nomohon' => $row['nomohon'],
        ];
      } else {
        $data = [
          'nomohon' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function caribeli(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        'title' => 'Cari Penerimaan Pembelian',
      ];
      return response()->json([
        'body' => view('modalcari.modalcaribeli', [
          'belih' => Belih::where('proses', 'Y')->where('kurangbayar', '>', 0)->orderBy('nobeli', 'desc')->get(),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
  public function replbeli(Request $request)
  {
    if ($request->Ajax()) {
      $nobeli = $request->kode; //$_GET['kode_barang'];
      $row = Belih::where('nobeli', $nobeli)->where('kurangbayar', '>', 0)->first();
      if (isset($row)) {
        $data = [
          'nodokumen' => $row['nobeli'],
          'tgldokumen' => $row['tglbeli'],
          'uang' => $row['kurangbayar'],
          'kdsupplier' => $row['kdsupplier'],
          'nmsupplier' => $row['nmsupplier'],
        ];
      } else {
        $data = [
          'nodokumen' => '',
          'tgldokumen' => '',
          'uang' => '0',
          'kdsupplier' => '',
          'nmsupplier' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function tampilpembayaran(Request $request)
  {
    if ($request->Ajax()) {
      $cari = $_GET['cari'];
      $data = [
        'title' => 'Tampil Pembayaran ' . $cari,
      ];
      return response()->json([
        'body' => view('modalcari.modaltampilpembayaran', [
          // 'kasir_tagihand' => Kasir_tagihand::where('nojual', $cari)->orderBy('nokwitansi', 'desc')->get(),
          'kasir_tagihand' => DB::table('kasir_tagihand')->join('kasir_tagihan', 'kasir_tagihand.nokwitansi', '=', 'kasir_tagihan.nokwitansi')
            ->select('kasir_tagihand.*', 'kasir_tagihan.tglkwitansi')->where('kasir_tagihand.nojual', $cari)->get(),
          'kasir_tunai' => Kasir_tunai::where('proses', 'Y')->where('nojual', $cari)->orderBy('nokwitansi', 'desc')->get(),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function cariwo_bp(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        'title' => 'Cari WO Body Repair',
      ];
      return response()->json([
        'body' => view('modalcari.modalcariwo_bp', [
          'wo_bp' => Wo_bp::where('close', '1')->where('nofaktur', '')->orderBy('nowo', 'desc')->get(),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
  public function replwo_bp(Request $request)
  {
    if ($request->Ajax()) {
      $nowo = $request->kode; //$_GET['kode_barang'];
      $row = Wo_bp::where('nowo', $nowo)->where('close', '1')->where('nofaktur', '')->first();
      if (isset($row)) {
        $data = [
          'nowo' => $row['nowo'],
          'tglwo' => $row['tglwo'],
          'nopolisi' => $row['nopolisi'],
          'norangka' => $row['norangka'],
          'kdpemilik' => $row['kdpemilik'],
          'nmpemilik' => $row['nmpemilik'],
          'kdsa' => $row['kdsa'],
          'nmsa' => $row['nmsa'],
          'kdservice' => $row['kdservice'],
          'nmservice' => $row['nmservice'],
          'km' => $row['km'],
          'kdpaket' => $row['kdpaket'],
          'aktifitas' => $row['aktifitas'],
          'fasilitas' => $row['fasilitas'],
          'status_tunggu' => $row['status_tunggu'],
          'int_reminder' => $row['int_reminder'],
          'via' => $row['via'],
          'status_tunggu' => $row['status_tunggu'],
          'keluhan' => $row['keluhan'],
          'saran' => $row['saran'],
          'pr_ppn' => $row['pr_ppn'],
          'no_polis' => $row['no_polis'],
          'nama_polis' => $row['nama_polis'],
          'tgl_akhir_polis' => $row['tgl_akhir_polis'],
          'kdasuransi' => $row['kdasuransi'],
          'nmasuransi' => $row['nmasuransi'],
          'alamat_asuransi' => $row['alamat_asuransi'],
          'klaim' => $row['klaim'],
          'internal' => $row['internal'],
          'inventaris' => $row['inventaris'],
          'campaign' => $row['campaign'],
          'booking' => $row['booking'],
          'lain_lain' => $row['lain_lainn'],
          'surveyor' => $row['campaign'],
          'npwp' => $row['npwp'],
          'contact_person' => $row['contact_person'],
          'own_risk' => $row['own_risk'],
        ];
      } else {
        $data = [
          'nowo' => '',
          'tglwo' => '',
          'nopolisi' => '',
          'norangka' => '',
          'kdpemilik' => '',
          'nmpemilik' => '',
          'kdsa' => '',
          'nmsa' => '',
          'kdservice' => '',
          'nmservice' => '',
          'km' => '',
          'kdpaket' => '',
          'aktifitas' => '',
          'fasilitas' => '',
          'status_tunggu' => '',
          'int_reminder' => '',
          'via' => '',
          'status_tunggu' => '',
          'keluhan' => '',
          'saran' => '',
          'pr_ppn' => '',
          'no_polis' => '',
          'nama_polis' => '',
          'tgl_akhir_polis' => '',
          'kdasuransi' => '',
          'nmasuransi' => '',
          'alamat_asuransi' => '',
          'klaim' => '',
          'internal' => '',
          'inventaris' => '',
          'campaign' => '',
          'booking' => '',
          'lain_lain' => '',
          'surveyor' => '',
          'npwp' => '',
          'contact_person' => '',
          'own_risk' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function cariwo_gr(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        'title' => 'Cari WO Body Repair',
      ];
      return response()->json([
        'body' => view('modalcari.modalcariwo_gr', [
          'wo_gr' => Wo_gr::where('close', '1')->where('nofaktur', '')->orderBy('nowo', 'desc')->get(),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
  public function replwo_gr(Request $request)
  {
    if ($request->Ajax()) {
      $nowo = $request->kode; //$_GET['kode_barang'];
      $row = Wo_gr::where('nowo', $nowo)->where('close', '1')->where('nofaktur', '')->first();
      if (isset($row)) {
        $data = [
          'nowo' => $row['nowo'],
          'tglwo' => $row['tglwo'],
          'nopolisi' => $row['nopolisi'],
          'norangka' => $row['norangka'],
          'kdpemilik' => $row['kdpemilik'],
          'nmpemilik' => $row['nmpemilik'],
          'kdsa' => $row['kdsa'],
          'nmsa' => $row['nmsa'],
          'kdservice' => $row['kdservice'],
          'nmservice' => $row['nmservice'],
          'km' => $row['km'],
          'kdpaket' => $row['kdpaket'],
          'aktifitas' => $row['aktifitas'],
          'fasilitas' => $row['fasilitas'],
          'status_tunggu' => $row['status_tunggu'],
          'int_reminder' => $row['int_reminder'],
          'via' => $row['via'],
          'status_tunggu' => $row['status_tunggu'],
          'keluhan' => $row['keluhan'],
          'saran' => $row['saran'],
          'pr_ppn' => $row['pr_ppn'],
          'no_polis' => $row['no_polis'],
          'nama_polis' => $row['nama_polis'],
          'tgl_akhir_polis' => $row['tgl_akhir_polis'],
          'kdasuransi' => $row['kdasuransi'],
          'nmasuransi' => $row['nmasuransi'],
          'alamat_asuransi' => $row['alamat_asuransi'],
          'klaim' => $row['klaim'],
          'internal' => $row['internal'],
          'inventaris' => $row['inventaris'],
          'campaign' => $row['campaign'],
          'booking' => $row['booking'],
          'lain_lain' => $row['lain_lainn'],
          'surveyor' => $row['campaign'],
          'npwp' => $row['npwp'],
          'contact_person' => $row['contact_person'],
          'own_risk' => $row['own_risk'],
        ];
      } else {
        $data = [
          'nowo' => '',
          'tglwo' => '',
          'nopolisi' => '',
          'norangka' => '',
          'kdpemilik' => '',
          'nmpemilik' => '',
          'kdsa' => '',
          'nmsa' => '',
          'kdservice' => '',
          'nmservice' => '',
          'km' => '',
          'kdpaket' => '',
          'aktifitas' => '',
          'fasilitas' => '',
          'status_tunggu' => '',
          'int_reminder' => '',
          'via' => '',
          'status_tunggu' => '',
          'keluhan' => '',
          'saran' => '',
          'pr_ppn' => '',
          'no_polis' => '',
          'nama_polis' => '',
          'tgl_akhir_polis' => '',
          'kdasuransi' => '',
          'nmasuransi' => '',
          'alamat_asuransi' => '',
          'klaim' => '',
          'internal' => '',
          'inventaris' => '',
          'campaign' => '',
          'booking' => '',
          'lain_lain' => '',
          'surveyor' => '',
          'npwp' => '',
          'contact_person' => '',
          'own_risk' => '',
        ];
      }
      echo json_encode($data);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
}
