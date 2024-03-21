<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use Mpdf\Output\Destination;
use App\Http\Requests\Soh_bahanRequest;
use App\Http\Requests\Sod_bahanRequest;
use Illuminate\Http\Request;
use Session;
// use Yajra\DataTables\Contracts\DataTables;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\Soh_bahan;
use App\Models\Sod_bahan;
// use App\Models\Tbsales;
use App\Models\Tbbarang;
use App\Models\Tbmultiprc;
use App\Models\Userdtl;
use App\Models\Saplikasi;

// //return type View
// use Illuminate\View\View;

class So_bahanController extends Controller
{
  public function index(Request $request) //: View
  {
    $username = session('username');
    $data = [
      'menu' => 'transaksi',
      'submenu' => 'so_bahan',
      'submenu1' => 'bahan',
      'title' => 'Sales Order Bahan',
      // 'tbbarang' => Tbbarang::all(),
      'userdtlmenu' => Userdtl::join('tbmodule', 'userdtl.cmodule', '=', 'tbmodule.cmodule')->where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
      'userdtl' => Userdtl::where('cmodule', 'Sales Order Bahan')->where('username', $username)->first(),
    ];
    $userdtl = Userdtl::where('cmodule', 'Sales Order Bahan')->where('username', $username)->first();
    if ($userdtl->pakai == '1') {
      return view('so_bahan.index')->with($data);
    } else {
      return redirect('home');
    }
  }
  public function so_bahanajax(Request $request) //: View
  {
    if ($request->ajax()) {
      $data = Soh_bahan::select('*'); //->orderBy('kode', 'asc');
      return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('kode1', function ($row) {
          $id = $row['id'];
          $btn = $row['kode']; //'<a href="#"' . 'onclick=detail(' . $id . ')>' .  $row['kode'] . '</a>';
          return $btn;
        })
        ->rawColumns(['kode1'])
        ->make(true);
      // return view('so');
    }
  }

  public function create(Request $request)
  {
    if ($request->Ajax()) {
      $username = session('username');
      $data = [
        'menu' => 'transaksi',
        'submenu' => 'so_bahan',
        'submenu1' => 'bahan',
        'title' => 'Tambah Data Sales Order Bahan',
      ];
      return response()->json([
        'body' => view('so_bahan.modaltambahmaster', [
          'tambahtbnegara' => Userdtl::where('cmodule', 'Tabel Negara')->where('username', $username)->first(),
          'tambahtbjnbrg' => Userdtl::where('cmodule', 'Tabel Jenis Barang')->where('username', $username)->first(),
          'tambahtbsatuan' => Userdtl::where('cmodule', 'Tabel Satuan')->where('username', $username)->first(),
          'tambahtbmove' => Userdtl::where('cmodule', 'Tabel Perputaran Barang')->where('username', $username)->first(),
          'tambahtbdisc' => Userdtl::where('cmodule', 'Tabel Discount')->where('username', $username)->first(),
          'saplikasi' => Saplikasi::where('aktif', 'Y')->first(),
          // 'tbsales' => Tbsales::orderBy('nama')->get(),
          'soh_bahan' => new Soh_bahan(),
          'action' => route('so_bahan.store'),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function store(Soh_bahanRequest $request, Soh_bahan $soh_bahan)
  {
    if ($request->Ajax()) {
      $sort_num = 0;
      $new_code = $request->noso;
      $ketemu = 0;
      $record = 0;
      $rec = Soh_bahan::where('noso', $new_code)->first();
      if ($rec == null) {
        $aplikasi = Saplikasi::where('aktif', 'Y')->first();
        $sort_num = $aplikasi->noso;
        $tahun = $aplikasi->tahun;
        $bulan = $aplikasi->bulan;
        Saplikasi::where('aktif', 'Y')->update(['noso' => $sort_num + 1]);
      } else {
        while ($ketemu == $record) { //0=0
          $aplikasi = Saplikasi::where('aktif', 'Y')->first();
          $sort_num = $aplikasi->noso;
          $tahun = $aplikasi->tahun;
          $bulan = $aplikasi->bulan;
          Saplikasi::where('aktif', 'Y')->update(['noso' => $sort_num + 1]);
          $new_code = 'SOB' . $tahun . sprintf('%02s', $bulan) . sprintf("%05s", $sort_num + 1);
          $rec = Soh_bahan::where('noso', $new_code)->first();
          if ($rec == null) {
            $record = 0;
            Saplikasi::where('aktif', 'Y')->update(['noso' => $sort_num + 1]);
            break;
          } else {
            Saplikasi::where('aktif', 'Y')->update(['noso' => $sort_num + 1]);
          }
        }
      }
      $validated = $request->validated();
      if ($validated) {
        $subtotal = 0;
        $biaya_lain = isset($request->biaya_lain) ? $request->biaya_lain : '0';
        $materai = isset($request->materai) ? $request->materai : '0';
        $ppn = isset($request->ppn) ? $request->ppn : '0';
        $total_sementara = $biaya_lain + $subtotal + $materai;
        $total = $total_sementara + ($total_sementara * ($ppn / 100));
        $soh_bahan->fill([
          'noso' => isset($request->noso) ? $new_code : '',
          'tglso' => isset($request->tglso) ? $request->tglso : '',
          'noreferensi' => isset($request->noreferensi) ? $request->noreferensi : '',
          'nopo_customer' => isset($request->nopo_customer) ? $request->nopo_customer : '',
          'tglpo_customer' => isset($request->tglpo_customer) ? $request->tglpo_customer : '',
          'kdcustomer' => isset($request->kdcustomer) ? $request->kdcustomer : '',
          'nmcustomer' => isset($request->nmcustomer) ? $request->nmcustomer : '',
          'kdsales' => isset($request->kdsales) ? $request->kdsales : '',
          'nmsales' => isset($request->nmsales) ? $request->nmsales : '',
          'tglkirim' => isset($request->tglkirim) ? $request->tglkirim : '',
          'jenis_order' => isset($request->jenis_order) ? $request->jenis_order : '',
          'carabayar' => isset($request->carabayar) ? $request->carabayar : '',
          'tempo' => isset($request->tempo) ? $request->tempo : '',
          'tgl_jt_tempo' => isset($request->tgl_jt_tempo) ? $request->tgl_jt_tempo : '',
          'ket_biaya_lain' => isset($request->ket_biaya_lain) ? $request->ket_biaya_lain : '',
          'biaya_lain' => $biaya_lain,
          'subtotal' => $subtotal,
          'total_sementara' => $total_sementara,
          'ppn' => $ppn,
          'materai' => $materai,
          'total' => $total,
          'keterangan' => isset($request->keterangan) ? $request->keterangan : '',
          'user' => 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s'),
        ]);
        $soh_bahan->save($validated);
        //Create History
        $tanggal = date('Y-m-d');
        $datetime = date('Y-m-d H:i:s');
        $dokumen = $new_code;
        $form = 'Sales Order Bahan';
        $status = 'Tambah';
        $catatan = isset($request->catatan) ? $request->catatan : '';
        $username = session('username');
        DB::table('hisuser')->insert(['tanggal' => $tanggal, 'dokumen' => $dokumen, 'form' => $form, 'status' => $status, 'user' => $username, 'catatan' => $catatan, 'datetime' => $datetime]);
        $msg = [
          'sukses' => 'Data berhasil di tambah',
        ];
      } else {
        $msg = [
          'sukses' => 'Data gagal di tambah',
        ];
      }
      echo json_encode($msg);
      // return redirect()->back()->with('message', 'Berhasil di simpan');
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  // public function show(string $id)
  public function show(Request $request)
  {
    $id = $_GET['id'];
    $username = session('username');
    if ($request->Ajax()) {
      $data = [
        'menu' => 'transaksi',
        'submenu' => 'so',
        'submenu1' => 'bahan',
        'title' => 'Detail Sales Order Bahan',
        // 'userdtl' => Userdtl::where('cmodule', 'Sales Order Bahan')->where('username', $username)->first(),
      ];
      return response()->json([
        'body' => view('so_bahan.modaltambahmaster', [
          'saplikasi' => Saplikasi::where('aktif', 'Y')->first(),
          // 'tbsales' => Tbsales::get(),
          'soh_bahan' => Soh_bahan::where('id', $id)->first(),
          'action' => route('tbbarang.store'),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function edit(Soh_bahan $soh_bahan, Request $request)
  {
    if ($request->Ajax()) {
      $id = $_GET['id'];
      $data = [
        'menu' => 'transaksi',
        'submenu' => 'so',
        'submenu1' => 'bahan',
        'title' => 'Edit Data Sales Order Bahan',
      ];
      // var_dump($data);

      // return response()->json([
      //     'data' => $data,
      // ]);
      return response()->json([
        'body' => view('so_bahan.modaltambahmaster', [
          'saplikasi' => Saplikasi::where('aktif', 'Y')->first(),
          // 'tbsales' => Tbsales::get(),
          'soh_bahan' => Soh_bahan::where('id', $id)->first(),
          'action' => route('so_bahan.update', $id),
          // 'action' => 'soupdate',
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function update(Request $request, Soh_bahan $soh_bahan)
  {
    if ($request->Ajax()) {
      $id = $request->id;
      if ($request->noso === $request->nosolama) {
        $validate = $request->validate(
          [
            'noso' => 'required',
            'tglso' => 'required',
          ],
          [
            'noso_bahan.required' => 'No. SO harus di isi',
            'tglso_bahan.required' => 'Tanggal SO harus di isi',
          ],
        );
      } else {
        $validate = $request->validate(
          [
            'noso' => 'required|unique:soh|max:255',
            'tglso' => 'required',
          ],
          [
            'noso_bahan.required' => 'No. SO harus di isi',
            'tglso_bahan.required' => 'Tanggal SO harus di isi',
          ],
        );
      }
      $soh_bahan = Soh_bahan::find($id);
      if ($validate) {
        $noso = $request->noso;
        $subtotal = Sod_bahan::where('noso', $noso)->sum('subtotal');
        // $subtotal = DB::table('sod')->where('noso', $noso)->sum('subtotal');
        $biaya_lain = isset($request->biaya_lain) ? $request->biaya_lain : '0';
        $materai = isset($request->materai) ? $request->materai : '0';
        $ppn = isset($request->ppn) ? $request->ppn : '0';
        $total_sementara = $biaya_lain + $subtotal + $materai;
        $total = $total_sementara + ($total_sementara * ($ppn / 100));
        $soh_bahan->fill([
          'noso' => isset($request->noso) ? $request->noso : '',
          'tglso' => isset($request->tglso) ? $request->tglso : '',
          'noreferensi' => isset($request->noreferensi) ? $request->noreferensi : '',
          'nopo_customer' => isset($request->nopo_customer) ? $request->nopo_customer : '',
          'tglpo_customer' => isset($request->tglpo_customer) ? $request->tglpo_customer : '',
          'kdcustomer' => isset($request->kdcustomer) ? $request->kdcustomer : '',
          'nmcustomer' => isset($request->nmcustomer) ? $request->nmcustomer : '',
          'kdsales' => isset($request->kdsales) ? $request->kdsales : '',
          'nmsales' => isset($request->nmsales) ? $request->nmsales : '',
          'tglkirim' => isset($request->tglkirim) ? $request->tglkirim : '',
          'jenis_order' => isset($request->jenis_order) ? $request->jenis_order : '',
          'carabayar' => isset($request->carabayar) ? $request->carabayar : '',
          'tempo' => isset($request->tempo) ? $request->tempo : '',
          'tgl_jt_tempo' => isset($request->tgl_jt_tempo) ? $request->tgl_jt_tempo : '',
          'ket_biaya_lain' => isset($request->ket_biaya_lain) ? $request->ket_biaya_lain : '',
          'biaya_lain' => $biaya_lain,
          'subtotal' => $subtotal,
          'total_sementara' => $total_sementara,
          'ppn' => $ppn,
          'materai' => $materai,
          'total' => $total,
          'keterangan' => isset($request->keterangan) ? $request->keterangan : '',
          'user' => 'Update-' . $request->username . ', ' . date('d-m-Y h:i:s'),
        ]);
        $soh_bahan->save($validate);
        //Create History
        $tanggal = date('Y-m-d');
        $datetime = date('Y-m-d H:i:s');
        $dokumen = $noso;
        $form = 'Sales Order Bahan';
        $status = 'Update';
        $catatan = isset($request->catatan) ? $request->catatan : '';
        $username = session('username');
        DB::table('hisuser')->insert(['tanggal' => $tanggal, 'dokumen' => $dokumen, 'form' => $form, 'status' => $status, 'user' => $username, 'catatan' => $catatan, 'datetime' => $datetime]);
        $msg = [
          'sukses' => 'Data berhasil di update',
        ];
      } else {
        $msg = [
          'sukses' => 'Data gagal di update',
        ];
      }
      echo json_encode($msg);
      // return redirect()->back()->with('message', 'Berhasil di update');
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function so_bahanproses(Request $request, Soh_bahan $soproses)
  {
    if ($request->Ajax()) {
      $id = $request->id;
      $soh_bahan = Soh_bahan::where('id', $id)->first();
      $noso = $soh_bahan->noso;
      // $soproses->load('so_bahanDetail');
      // $subtotal = $soproses->so_bahanDetail->sum('subtotal');
      $subtotal = Sod_bahan::where('noso', $noso)->sum('subtotal');
      $total_sementara = $soh_bahan->biaya_lain + $subtotal;
      // $soproses->proses = 'Y';
      // $soproses->subtotal = $subtotal;
      // $soproses->total_sementara = $total_sementara;
      // $soproses->total = $total_sementara + ($total_sementara * ($soproses->ppn / 100));
      // $soproses->user = 'Proses-' . session('username') . ', ' . date('d-m-Y h:i:s');
      // $soproses->save();
      $soh_bahan = Soh_bahan::find($id);
      $soh_bahan->fill([
        'proses' => 'Y',
        'subtotal' => $subtotal,
        'total_sementara' => $total_sementara,
        'total' => $total_sementara + ($total_sementara * ($soh_bahan->ppn / 100)),
        'user' => 'Proses-' . session('username') . ', ' . date('d-m-Y h:i:s'),
      ]);
      $soh_bahan->save();
      $sod_bahan = Sod_bahan::where('noso', $noso)->get();
      foreach ($sod_bahan as $row) {
        $idd = $row->id;
        $qty = $row->qty;
        Sod_bahan::where('id', $idd)->update(['proses' => 'Y', 'kurang' => $qty]);
        // DB::table('sod_bahan')->where('id', $idd)->update(['proses' => 'Y', 'kurang' => $qty]);
      }
      //Create History
      $tanggal = date('Y-m-d');
      $datetime = date('Y-m-d H:i:s');
      $dokumen = $noso;
      $form = 'Sales Order Bahan';
      $status = 'Proses';
      $catatan = isset($request->catatan) ? $request->catatan : '';
      $username = session('username');
      DB::table('hisuser')->insert(['tanggal' => $tanggal, 'dokumen' => $dokumen, 'form' => $form, 'status' => $status, 'user' => $username, 'catatan' => $catatan, 'datetime' => $datetime]);
      return response()->json([
        'sukses' => 'Data berhasil di Cancel',
      ]);
      // return redirect()->back()->with('message', 'Berhasil di update');
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function so_bahanbatalproses(Soh_bahan $soh_bahan, Request $request)
  {
    if ($request->Ajax()) {
      $id = $_GET['id'];
      $soh_bahan = Soh_bahan::where('id', $id)->first();
      $sod_bahan = Sod_bahan::where('noso', $soh_bahan->noso)->where('terima', '>', '0')->first();
      if (isset($sod_bahan->noso)) {
        $msg = [
          'sukses' => 'Data gagal di cancel',
        ];
        echo json_encode($msg);
      } else {
        $data = [
          'menu' => 'transaksi',
          'submenu' => 'so',
          'submenu1' => 'bahan',
          'title' => 'Batal Proses Sales Order Bahan',
        ];
        // var_dump($data);

        // return response()->json([
        //     'data' => $data,
        // ]);
        return response()->json([
          'body' => view('so_bahan.modalbatalproses', [
            'soh_bahan' => Soh_bahan::where('id', $id)->first(),
            // 'action' => route('so_bahan.update', $soh->id),
            'action' => 'so_bahanbatalprosesok',
            'vdata' => $data,
          ])->render(),
          'data' => $data,
        ]);
      }
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function so_bahanbatalprosesok(Request $request, Soh_bahan $soh_bahan)
  {
    if ($request->Ajax()) {
      $id = $request->id;
      $user = 'Proses-' . session('username') . ', ' . date('d-m-Y h:i:s');
      Soh_bahan::where('id', $id)->update(['proses' => 'N', 'user' => $user]);
      // DB::table('soh')->where('id', $id)->update(['proses' => 'N', 'user' => $user]);
      //Create History
      $soh_bahan = Soh_bahan::where('id', $id)->first();
      $noso = $soh_bahan->noso;
      $tanggal = date('Y-m-d');
      $datetime = date('Y-m-d H:i:s');
      $dokumen = $noso;
      $form = 'Sales Order Bahan';
      $status = 'Batal Proses';
      $catatan = isset($request->catatan) ? $request->catatan : '';
      $username = session('username');
      DB::table('hisuser')->insert(['tanggal' => $tanggal, 'dokumen' => $dokumen, 'form' => $form, 'status' => $status, 'user' => $username, 'catatan' => $catatan, 'datetime' => $datetime]);
      $msg = [
        'sukses' => 'Data berhasil di Cancel',
      ];
      echo json_encode($msg);
      // return redirect()->back()->with('message', 'Berhasil di update');
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function so_bahancancel(Request $request, Soh_bahan $soh_bahan)
  {
    if ($request->Ajax()) {
      $id = $_POST['id'];
      $user = 'Cancel-' . session('username') . ', ' . date('d-m-Y h:i:s');
      Soh_bahan::where('id', $id)->update(['batal' => 'Y', 'user' => $user]);
      // DB::table('soh_bahan')->where('id', $id)->update(['batal' => 'Y', 'user' => $user]);
      //Create History
      $soh_bahan = Soh_bahan::where('id', $id)->first();
      $noso = $soh_bahan->noso;
      $tanggal = date('Y-m-d');
      $datetime = date('Y-m-d H:i:s');
      $dokumen = $noso;
      $form = 'Sales Order Bahan';
      $status = 'Cancel';
      $catatan = isset($request->catatan) ? $request->catatan : '';
      $username = session('username');
      DB::table('hisuser')->insert(['tanggal' => $tanggal, 'dokumen' => $dokumen, 'form' => $form, 'status' => $status, 'user' => $username, 'catatan' => $catatan, 'datetime' => $datetime]);
      $msg = [
        'sukses' => 'Data berhasil di Cancel',
      ];
      echo json_encode($msg);
      // return redirect()->back()->with('message', 'Berhasil di update');
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function so_bahanambil(Request $request, Soh_bahan $soh_bahan)
  {
    if ($request->Ajax()) {
      $id = $_POST['id'];
      $user = 'Ambil-' . session('username') . ', ' . date('d-m-Y h:i:s');
      Soh_bahan::where('id', $id)->update(['batal' => 'N', 'user' => $user]);
      // DB::table('soh_bahan')->where('id', $id)->update(['batal' => 'N', 'user' => $user]);
      //Create History
      $row = Soh_bahan::where('id', $request->id)->first();
      $noso = $row->noso;
      $tanggal = date('Y-m-d');
      $datetime = date('Y-m-d H:i:s');
      $dokumen = $noso;
      $form = 'Sales Order Bahan';
      $status = 'Ambil';
      $catatan = isset($request->catatan) ? $request->catatan : '';
      $username = session('username');
      DB::table('hisuser')->insert(['tanggal' => $tanggal, 'dokumen' => $dokumen, 'form' => $form, 'status' => $status, 'user' => $username, 'catatan' => $catatan, 'datetime' => $datetime]);
      $msg = [
        'sukses' => 'Data berhasil di Cancel',
      ];
      echo json_encode($msg);
      // return redirect()->back()->with('message', 'Berhasil di update');
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function destroy(Soh_bahan $soh_bahan, Request $request)
  {
    if ($request->Ajax()) {
      $id = $request->id;
      $soh_bahan = Soh_bahan::where('id', $request->id)->first();
      $deleted = Soh_bahan::where('id', $id)->delete();
      // $deleted = DB::table('soh_bahan')->where('id', $id)->delete();
      if ($deleted) {
        Sod_bahan::where('noso', $soh_bahan->noso)->delete();
        // DB::table('sod_bahan')->where('noso', $soh_bahan->noso)->delete();
        //Create History
        $noso = $soh_bahan->noso;
        $tanggal = date('Y-m-d');
        $datetime = date('Y-m-d H:i:s');
        $dokumen = $noso;
        $form = 'Sales Order Bahan';
        $status = 'Hapus';
        $catatan = isset($request->catatan) ? $request->catatan : '';
        $username = session('username');
        DB::table('hisuser')->insert(['tanggal' => $tanggal, 'dokumen' => $dokumen, 'form' => $form, 'status' => $status, 'user' => $username, 'catatan' => $catatan, 'datetime' => $datetime]);
        return response()->json([
          'sukses' => 'Data berhasil di hapus',
        ]);
      } else {
        return response()->json([
          'sukses' => 'Data gagal di hapus',
        ]);
      }
      // return redirect()->back()->with('message', 'Berhasil di hapus');
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function socaritbbarang(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        // 'menu' => 'transaksi',
        // 'submenu' => 'tbcustomer',
        // 'submenu1' => 'bahan',
        'title' => 'Cari Tabel barang',
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

  public function sorepltbbarang(Request $request)
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

  public function socaritbmultiprc(Request $request)
  {
    if ($request->Ajax()) {
      $kdcustomer = $request->kode_customer;
      // $kdcustomer = $_GET['kode_customer'];
      // dd($kdcustomer);
      $data = [
        // 'menu' => 'transaksi',
        // 'submenu' => 'tbcustomer',
        // 'submenu1' => 'bahan',
        'title' => 'Cari Tabel Multi Price',
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

  public function sorepltbmultiprc(Request $request)
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

  public function so_bahaninputsod(Soh_bahan $soh_bahan, Request $request)
  {
    if ($request->Ajax()) {
      $id = $_GET['id'];
      $username = session('username');
      $soh_bahan = Soh_bahan::where('id', $id)->first();
      $noso = $soh_bahan->noso;
      $data = [
        'menu' => 'transaksi',
        'submenu' => 'so',
        'submenu1' => 'bahan',
        'title' => 'Detail Data Sales Order Bahan',
      ];
      // var_dump($data);

      // return response()->json([
      //     'data' => $data,
      // ]);
      return response()->json([
        'body' => view('so_bahan.modaldetail', [
          'userdtlmenu' => Userdtl::join('tbmodule', 'userdtl.cmodule', '=', 'tbmodule.cmodule')->where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
          'userdtl' => Userdtl::where('cmodule', 'Sales Order Bahan')->where('username', $username)->first(),
          'saplikasi' => Saplikasi::where('aktif', 'Y')->first(),
          // 'tbsales' => Tbsales::get(),
          'soh_bahan' => Soh_bahan::where('id', $id)->first(),
          'sod_bahan' => Sod_bahan::where('noso', $noso)->get(),
          // 'action' => route('so_bahan.update', $soh_bahan->id),
          'action' => 'sotambahdetail',
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function sotambahdetail(Request $request, Sod_bahanRequest $sodrequest, Sod_bahan $sod_bahan)
  {
    if ($request->Ajax()) {
      $id = $request->id;
      $validate = $request->validate(
        [
          'kdbarang' => 'required',
        ],
        [
          'kdbarang.required' => 'Kode barang harus di isi',
        ],
      );
      if ($validate) {
        // $recsod = Sod_bahan::where('noso', $request->nosod)->where('kdbarang', $request->kdbarang)->first();
        // if (isset($recsod->noso)) {
        //   $msg = [
        //     'sukses' => 'Data gagal di tambah',
        //   ];
        // } else {
        $sod_bahan->fill([
          'noso' => isset($request->nosod) ? $request->nosod : '',
          'kdbarang' => isset($request->kdbarang) ? $request->kdbarang : '',
          'nmbarang' => isset($request->nmbarang) ? $request->nmbarang : '',
          'kdsatuan' => isset($request->kdsatuan) ? $request->kdsatuan : '',
          'qty' => isset($request->qty) ? $request->qty : '',
          'harga' => isset($request->harga) ? $request->harga : '',
          'discount' => isset($request->discount) ? $request->discount : '',
          'subtotal' => isset($request->subtotal) ? $request->subtotal : '',
          'total' => isset($request->total) ? $request->total : '',
          'user' => 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s'),
        ]);
        $sod_bahan->save($validate);
        $soh_bahan = Soh_bahan::where('noso', $request->nosod)->first();
        $biaya_lain = $soh_bahan->biaya_lain;
        $materai = $soh_bahan->materai;
        $ppn = $soh_bahan->ppn;
        $subtotal = DB::table('sod_bahan')->where('noso', $request->nosod)->sum('subtotal');
        $total_sementara = $biaya_lain + $subtotal + $materai;
        $total = $total_sementara + ($total_sementara * ($ppn / 100));
        Soh_bahan::where('noso', $request->nosod)->update([
          'subtotal' => $subtotal, 'biaya_lain' => $biaya_lain, 'materai' => $materai, 'total_sementara' => $total_sementara, 'total_sementara' =>
          $total_sementara, 'total' => $total
        ]);
        // DB::table('soh_bahan')->where('noso', $request->nosod)->update([
        //   'subtotal' => $subtotal, 'biaya_lain' => $biaya_lain, 'materai' => $materai, 'total_sementara' => $total_sementara, 'total_sementara' =>
        //   $total_sementara, 'total' => $total
        // ]);
        $msg = [
          'sukses' => 'Data berhasil di tambah',
        ];
        // }
      } else {
        $msg = [
          'sukses' => 'Data gagal di tambah',
        ];
      }
      echo json_encode($msg);
      // return redirect()->back()->with('message', 'Berhasil di update');
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function so_bahantotaldetail(Soh_bahan $soh_bahan, Request $request)
  {
    if ($request->Ajax()) {
      $noso = $request->noso;
      $soh_bahan = Soh_bahan::where('noso', $noso)->first();
      $data = [
        'menu' => 'transaksi',
        'submenu' => 'Sales Order Bahan',
        'submenu1' => 'bahan',
        'title' => 'Detail Data Sales Order Bahan',
      ];
      // var_dump($data);

      // return response()->json([
      //     'data' => $data,
      // ]);
      return response()->json([
        'body' => view('so_bahan.totaldetail', [
          'subtotalsod' => Sod_bahan::where('noso', $noso)->sum('subtotal'),
          'qtysod' => Sod_bahan::where('noso', $noso)->sum('qty'),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function so_bahancetak(Request $request)
  {
    //Create History
    $rowsoh = Soh_bahan::leftjoin('tbcustomer', 'soh_bahan.kdcustomer', '=', 'tbcustomer.kode')->where('soh_bahan.id', $request->id)->first();
    $noso = $rowsoh->noso;
    $rowsod = Soh_bahan::join('sod_bahan', 'sod_bahan.noso', '=', 'soh_bahan.noso')
      ->join('tbsatuan', 'tbsatuan.kode', '=', 'sod_bahan.kdsatuan')
      ->select('soh_bahan.*', 'sod_bahan.*', 'tbsatuan.nama as nmsatuan')
      ->where('soh_bahan.noso', $noso)->get();
    $data = [
      'soh_bahan' => $rowsoh,
      'sod_bahan' => $rowsod,
    ];
    // return view('so_bahan.cetak', $data);

    $rowd = Sod_bahan::where('noso', $noso)->get();
    $rowd = $rowd->count();

    if ($rowd > 10) {
      //create PDF
      $mpdf = new Mpdf([
        'format' => 'Letter',
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_top' => 8,
        'margin_bottom' => 5,
        'margin_header' => 5,
        'margin_footer' => 5,
      ]);
    } else {
      //create PDF
      $mpdf = new Mpdf([
        'format' => [150, 210], //gagal jadi ke landscape
        // 'format' => 'Letter-P',
        'orientation' => 'L',
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_top' => 8,
        'margin_bottom' => 5,
        'margin_header' => 5,
        'margin_footer' => 5,
      ]);
    }

    //Create History
    $soh = Soh_bahan::where('id', $request->id)->first();
    $tanggal = date('Y-m-d');
    $datetime = date('Y-m-d H:i:s');
    $dokumen = $soh->noso;
    $form = 'Sales Order Bahan';
    $status = 'Cetak';
    $catatan = isset($request->catatan) ? $request->catatan : '';
    $username = session('username');
    DB::table('hisuser')->insert(['tanggal' => $tanggal, 'dokumen' => $dokumen, 'form' => $form, 'status' => $status, 'user' => $username, 'catatan' => $catatan, 'datetime' => $datetime]);

    $header = trim($request->get('header', ''));
    $footer = trim($request->get('footer', ''));

    if (strlen($header)) {
      $mpdf->SetHTMLHeader($header);
    }

    if (strlen($footer)) {
      $mpdf->SetHTMLFooter($footer);
    }

    if ($request->get('show_toc')) {
      $mpdf->h2toc = array(
        'H1' => 0,
        'H2' => 1,
        'H3' => 2,
        'H4' => 3,
        'H5' => 4,
        'H6' => 5
      );
      $mpdf->TOCpagebreak();
    }

    //write content
    // $mpdf->WriteHTML($request->get('content'));
    $mpdf->WriteHTML(view('so_bahan.cetak', $data));
    $namafile = $noso . ' - ' . date('dmY H:i:s') . '.pdf';
    //return the PDF for download
    // return $mpdf->Output($request->get('name') . $namafile, Destination::DOWNLOAD);
    $mpdf->Output($namafile, 'I');
  }

  public function socetakpl(Request $request)
  {
    //Create History
    $rowsoh = Soh_bahan::join('tbcustomer', 'soh.kdcustomer', '=', 'tbcustomer.kode')->where('soh.id', $request->id)->first();
    $noso = $rowsoh->noso;
    $rowsod = Soh_bahan::join('sod', 'sod.noso', '=', 'soh.noso')
      ->join('tbsatuan', 'tbsatuan.kode', '=', 'sod.kdsatuan')
      ->select('soh.*', 'sod.*', 'tbsatuan.nama as nmsatuan')
      ->where('soh.noso', $noso)->get();
    $data = [
      'soh' => $rowsoh,
      'sod' => $rowsod,
    ];
    // return view('so_bahan.cetak', $data);

    $rowd = Sod_bahan::where('noso', $noso)->get();
    $rowd = $rowd->count();

    if ($rowd > 10) {
      //create PDF
      $mpdf = new Mpdf([
        'format' => 'Letter',
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_top' => 8,
        'margin_bottom' => 5,
        'margin_header' => 5,
        'margin_footer' => 5,
      ]);
    } else {
      //create PDF
      $mpdf = new Mpdf([
        // 'format' => [150, 210], //gagal jadi ke landscape
        'format' => [60, 60], //gagal jadi ke landscape
        // 'format' => 'Letter-P',
        'orientation' => 'P',
        'margin_left' => 4,
        'margin_right' => 4,
        'margin_top' => 2,
        'margin_bottom' => 2,
        'margin_header' => 2,
        'margin_footer' => 2,
      ]);
    }

    //Create History
    $soh = Soh_bahan::where('id', $request->id)->first();
    $tanggal = date('Y-m-d');
    $datetime = date('Y-m-d H:i:s');
    $dokumen = $soh->noso;
    $form = 'Sales Order Bahan';
    $status = 'Cetak';
    $catatan = isset($request->catatan) ? $request->catatan : '';
    $username = session('username');
    DB::table('hisuser')->insert(['tanggal' => $tanggal, 'dokumen' => $dokumen, 'form' => $form, 'status' => $status, 'user' => $username, 'catatan' => $catatan, 'datetime' => $datetime]);

    $header = trim($request->get('header', ''));
    $footer = trim($request->get('footer', ''));

    if (strlen($header)) {
      $mpdf->SetHTMLHeader($header);
    }

    if (strlen($footer)) {
      $mpdf->SetHTMLFooter($footer);
    }

    if ($request->get('show_toc')) {
      $mpdf->h2toc = array(
        'H1' => 0,
        'H2' => 1,
        'H3' => 2,
        'H4' => 3,
        'H5' => 4,
        'H6' => 5
      );
      $mpdf->TOCpagebreak();
    }

    //write content
    // $mpdf->WriteHTML($request->get('content'));
    $mpdf->WriteHTML(view('so_bahan.cetakpl', $data));
    $namafile = $noso . ' - ' . date('dmY H:i:s') . '.pdf';
    //return the PDF for download
    // return $mpdf->Output($request->get('name') . $namafile, Destination::DOWNLOAD);
    $mpdf->Output($namafile, 'I');
    exit;
  }
}
