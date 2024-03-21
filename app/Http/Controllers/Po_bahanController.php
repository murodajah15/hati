<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use Mpdf\Output\Destination;
use App\Http\Requests\Poh_bahanRequest;
use Illuminate\Http\Request;
use Session;
// use Yajra\DataTables\Contracts\DataTables;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\Poh_bahan;
use App\Models\Pod_bahan;
use App\Models\Tbsupplier;
use App\Models\Tbsales;
use App\Models\Tbbarang;
use App\Models\Tbmultiprc;
use App\Models\Userdtl;
use App\Models\Saplikasi;

// //return type View
// use Illuminate\View\View;

class Po_bahanController extends Controller
{
  public function index(Request $request) //: View
  {
    $username = session('username');
    $data = [
      'menu' => 'transaksi',
      'submenu' => 'po_bahan',
      'submenu1' => 'bahan',
      'title' => 'Purchase Order Bahan',
      // 'tbbarang' => Tbbarang::all(),
      'userdtlmenu' => Userdtl::join('tbmodule', 'userdtl.cmodule', '=', 'tbmodule.cmodule')->where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
      'userdtl' => Userdtl::where('cmodule', 'Purchase Order Bahan')->where('username', $username)->first(),
    ];
    // var_dump($data);
    return view('po_bahan.index')->with($data);
  }
  public function po_bahanajax(Request $request) //: View
  {
    if ($request->ajax()) {
      // $data = Poh_bahan::select('*'); //->orderBy('kode', 'asc');
      $data = Poh_bahan::select('id', DB::raw("DATE_FORMAT(poh_bahan.tglpo, '%Y-%m-%d') as tglpo"), 'nopo', 'nmsupplier', 'total', 'proses', 'batal'); //->orderBy('kode', 'asc');
      return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('kode1', function ($row) {
          $id = $row['id'];
          $btn = $row['kode']; //'<a href="#"' . 'onclick=detail(' . $id . ')>' .  $row['kode'] . '</a>';
          return $btn;
        })
        ->rawColumns(['kode1'])
        ->make(true);
      // return view('po');
    }
  }

  public function create(Request $request)
  {
    if ($request->Ajax()) {
      $username = session('username');
      $data = [
        'menu' => 'transaksi',
        'submenu' => 'po',
        'submenu1' => 'ref_umum',
        'title' => 'Tambah Data Purchase Order Bahan',
      ];
      return response()->json([
        'body' => view('po_bahan.modaltambahmaster', [
          'saplikasi' => Saplikasi::where('aktif', 'Y')->first(),
          'tbsales' => Tbsales::orderBy('nama')->get(),
          'poh_bahan' => new Poh_bahan(),
          'action' => route('po_bahan.store'),
          'vdata' => $data,
        ])->render(),
        'data' => $data,

      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function store(Poh_bahanRequest $request, Poh_bahan $poh_bahan)
  // public function store(Request $request, Poh_bahan $poh_bahan)
  {
    if ($request->Ajax()) {
      $sort_num = 0;
      $new_code = $request->nopo;
      $ketemu = 0;
      $record = 0;
      $rec = Poh_bahan::where('nopo', $new_code)->first();
      if ($rec == null) {
        $aplikasi = Saplikasi::where('aktif', 'Y')->first();
        $sort_num = $aplikasi->nopo;
        $tahun = $aplikasi->tahun;
        $bulan = $aplikasi->bulan;
        DB::table('saplikasi')->where('aktif', 'Y')->update(['nopo' => $sort_num + 1]);
      } else {
        while ($ketemu == $record) { //0=0
          $aplikasi = Saplikasi::where('aktif', 'Y')->first();
          $sort_num = $aplikasi->nopo;
          $tahun = $aplikasi->tahun;
          $bulan = $aplikasi->bulan;
          DB::table('saplikasi')->where('aktif', 'Y')->update(['nopo' => $sort_num + 1]);
          $new_code = 'POB' . $tahun . sprintf('%02s', $bulan) . sprintf("%05s", $sort_num + 1);
          $rec = Poh_bahan::where('nopo', $new_code)->first();
          if ($rec == null) {
            $record = 0;
            DB::table('saplikasi')->where('aktif', 'Y')->update(['nopo' => $sort_num + 1]);
            break;
          } else {
            DB::table('saplikasi')->where('aktif', 'Y')->update(['nopo' => $sort_num + 1]);
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
        $poh_bahan->fill([
          'nopo' => isset($request->nopo) ? $new_code : '',
          'tglpo' => isset($request->tglpo) ? $request->tglpo : '',
          'noreferensi' => isset($request->noreferensi) ? $request->noreferensi : '',
          'kdsupplier' => isset($request->kdsupplier) ? $request->kdsupplier : '',
          'nmsupplier' => isset($request->nmsupplier) ? $request->nmsupplier : '',
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
        $poh_bahan->save($validated);
        //Create History
        $tanggal = date('Y-m-d');
        $datetime = date('Y-m-d H:i:s');
        $dokumen = $new_code;
        $form = 'Purchase Order Bahan';
        $status = 'Tambah';
        $catatan = isset($request->catatan) ? $request->catatan : '';
        $username = session('username');
        DB::table('hisuser')->insert(['tanggal' => $tanggal, 'dokumen' => $dokumen, 'form' => $form, 'status' => $status, 'user' => $username, 'catatan' => $catatan, 'datetime' => $datetime]);
        $msg = [
          'sukses' => 'Data berhasil di tambah', //view('tbbarang.tabel_barang')
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
        'submenu' => 'po',
        'submenu1' => 'ref_umum',
        'title' => 'Detail Purchase Order Bahan',
        // 'userdtl' => Userdtl::where('cmodule', 'Purchase Order Bahan')->where('username', $username)->first(),
      ];
      return response()->json([
        'body' => view('po_bahan.modaltambahmaster', [
          'saplikasi' => Saplikasi::where('aktif', 'Y')->first(),
          'tbsales' => Tbsales::get(),
          'poh_bahan' => Poh_bahan::where('id', $id)->first(),
          'action' => route('tbbarang.store'),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function edit(Poh_bahan $poh_bahan, Request $request)
  {
    if ($request->Ajax()) {
      $id = $_GET['id'];
      $username = session('username');
      $data = [
        'menu' => 'transaksi',
        'submenu' => 'po',
        'submenu1' => 'ref_umum',
        'title' => 'Edit Data Purchase Order Bahan',
      ];
      // var_dump($data);

      // return response()->json([
      //     'data' => $data,
      // ]);
      return response()->json([
        'body' => view('po_bahan.modaltambahmaster', [
          'saplikasi' => Saplikasi::where('aktif', 'Y')->first(),
          'tbsales' => Tbsales::get(),
          'poh_bahan' => Poh_bahan::where('id', $id)->first(),
          'action' => route('po_bahan.update', $id),
          // 'action' => route('po_bahan.update', $poh_bahan->id),
          // 'action' => 'poupdate',
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function update(Request $request, Poh_bahan $poh_bahan)
  {
    if ($request->Ajax()) {
      $id = $request->id;
      if ($request->nopo === $request->nopolama) {
        $validate = $request->validate(
          [
            'nopo' => 'required',
            'tglpo' => 'required',
            'kdsupplier' => 'required',
          ],
          [
            'nopo.required' => 'No. SO harus di isi',
            'tglpo.required' => 'Tanggal SO harus di isi',
            'kdsupplier.required' => 'Supplier harus di isi',
          ],
        );
      } else {
        $validate = $request->validate(
          [
            'nopo' => 'required|unique:Poh|max:255',
            'tglpo' => 'required',
            'kdsupplier' => 'required',
          ],
          [
            'nopo.required' => 'No. SO harus di isi',
            'tglpo.required' => 'Tanggal SO harus di isi',
            'kdsupplier.required' => 'Supplier harus di isi',
          ],
        );
      }
      $poh_bahan = Poh_bahan::find($id);
      if ($validate) {
        $nopo = $request->nopo;
        // $subtotal = DB::table('pod_bahan')->where('nopo', $nopo)->sum('subtotal');
        $subtotal = Pod_bahan::where('nopo', $nopo)->sum('subtotal');
        $biaya_lain = isset($request->biaya_lain) ? $request->biaya_lain : '0';
        $materai = isset($request->materai) ? $request->materai : '0';
        $ppn = isset($request->ppn) ? $request->ppn : '0';
        $total_sementara = $biaya_lain + $subtotal + $materai;
        $total = $total_sementara + ($total_sementara * ($ppn / 100));
        $poh_bahan->fill([
          'nopo' => isset($request->nopo) ? $request->nopo : '',
          'tglpo' => isset($request->tglpo) ? $request->tglpo : '',
          'noreferensi' => isset($request->noreferensi) ? $request->noreferensi : '',
          'kdsupplier' => isset($request->kdsupplier) ? $request->kdsupplier : '',
          'nmsupplier' => isset($request->nmsupplier) ? $request->nmsupplier : '',
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
        $poh_bahan->save($validate);
        //Create History
        $tanggal = date('Y-m-d');
        $datetime = date('Y-m-d H:i:s');
        $dokumen = $nopo;
        $form = 'Purchase Order Bahan';
        $status = 'Update';
        $catatan = isset($request->catatan) ? $request->catatan : '';
        $username = session('username');
        DB::table('hisuser')->insert(['tanggal' => $tanggal, 'dokumen' => $dokumen, 'form' => $form, 'status' => $status, 'user' => $username, 'catatan' => $catatan, 'datetime' => $datetime]);
        $msg = [
          'sukses' => 'Data berhasil di update', //view('tbbarang.tabel_barang')
        ];
      } else {
        $msg = [
          'sukses' => 'Data gagal di update', //view('tbbarang.tabel_barang')
        ];
      }
      echo json_encode($msg);
      // return redirect()->back()->with('message', 'Berhasil di update');
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function po_bahanproses(Request $request, Poh_bahan $poproses)
  {
    if ($request->Ajax()) {
      $id = $request->id;
      $poh_bahan = Poh_bahan::where('id', $id)->first();
      $nopo = $poh_bahan->nopo;
      // $poproses->load('poDetail');
      // $subtotal = $poproses->soDetail->sum('subtotal');
      $subtotal = Pod_bahan::where('nopo', $nopo)->sum('subtotal');
      $total_sementara = $poproses->biaya_lain + $subtotal;
      // $poproses->proses = 'Y';
      // $poproses->subtotal = $subtotal;
      // $poproses->total_sementara = $total_sementara;
      // $poproses->total = $total_sementara + ($total_sementara * ($poproses->ppn / 100));
      // $poproses->user = 'Proses-' . session('username') . ', ' . date('d-m-Y h:i:s');
      // $poproses->save();
      $poh_bahan = Poh_bahan::find($id);
      $poh_bahan->fill([
        'proses' => 'Y',
        'subtotal' => $subtotal,
        'total_sementara' => $total_sementara,
        'total' => $total_sementara + ($total_sementara * ($poh_bahan->ppn / 100)),
        'user' => 'Proses-' . session('username') . ', ' . date('d-m-Y h:i:s'),
      ]);
      $poh_bahan->save();
      $pod_bahan = Pod_bahan::where('nopo', $nopo)->get();
      foreach ($pod_bahan as $row) {
        $idd = $row->id;
        $qty = $row->qty;
        // DB::table('pod_bahan')->where('id', $idd)->update(['proses' => 'Y', 'kurang' => $qty]);
        Pod_bahan::where('id', $idd)->update(['proses' => 'Y', 'kurang' => $qty]);
      }
      //Create History
      $tanggal = date('Y-m-d');
      $datetime = date('Y-m-d H:i:s');
      $dokumen = $nopo;
      $form = 'Purchase Order Bahan';
      $status = 'Proses';
      $catatan = isset($request->catatan) ? $request->catatan : '';
      $username = session('username');
      DB::table('hisuser')->insert(['tanggal' => $tanggal, 'dokumen' => $dokumen, 'form' => $form, 'status' => $status, 'user' => $username, 'catatan' => $catatan, 'datetime' => $datetime]);
      return response()->json([
        'sukses' => 'Data berhasil di Cancel', //view('tbbarang.tabel_barang')
      ]);
      // return redirect()->back()->with('message', 'Berhasil di update');
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function po_bahanbatalproses(Poh_bahan $poh_bahan, Request $request)
  {
    if ($request->Ajax()) {
      $id = $_GET['id'];
      $poh_bahan = Poh_bahan::where('id', $id)->first();
      $pod_bahan = Pod_bahan::where('nopo', $poh_bahan->nopo)->where('terima', '>', '0')->first();
      if (isset($pod_bahan->nopo)) {
        $msg = [
          'sukses' => 'Data gagal di cancel', //view('tbbarang.tabel_barang')
        ];
        echo json_encode($msg);
      } else {
        $data = [
          'menu' => 'transaksi',
          'submenu' => 'po',
          'submenu1' => 'ref_umum',
          'title' => 'Batal Proses Purchase Order Bahan',
        ];
        // var_dump($data);

        // return response()->json([
        //     'data' => $data,
        // ]);
        return response()->json([
          'body' => view('po_bahan.modalbatalproses', [
            'poh_bahan' => Poh_bahan::where('id', $id)->first(),
            // 'action' => route('po.update', $poh_bahan->id),
            'action' => 'po_bahanbatalprosesok',
            'vdata' => $data,
          ])->render(),
          'data' => $data,
        ]);
      }
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function po_bahanbatalprosesok(Request $request, Poh_bahan $poh_bahan)
  {
    if ($request->Ajax()) {
      $id = $request->id;
      $user = 'Proses-' . session('username') . ', ' . date('d-m-Y h:i:s');
      // DB::table('poh_bahan')->where('id', $id)->update(['proses' => 'N', 'user' => $user]);
      Poh_bahan::where('id', $id)->update(['proses' => 'N', 'user' => $user]);
      //Create History
      $poh_bahan = Poh_bahan::where('id', $id)->first();
      $nopo = $poh_bahan->nopo;
      $tanggal = date('Y-m-d');
      $datetime = date('Y-m-d H:i:s');
      $dokumen = $nopo;
      $form = 'Purchase Order Bahan';
      $status = 'Batal Proses';
      $catatan = isset($request->catatan) ? $request->catatan : '';
      $username = session('username');
      DB::table('hisuser')->insert(['tanggal' => $tanggal, 'dokumen' => $dokumen, 'form' => $form, 'status' => $status, 'user' => $username, 'catatan' => $catatan, 'datetime' => $datetime]);
      $msg = [
        'sukses' => 'Data berhasil di Cancel', //view('tbbarang.tabel_barang')
      ];
      echo json_encode($msg);
      // return redirect()->back()->with('message', 'Berhasil di update');
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function po_bahancancel(Request $request, Poh_bahan $poh_bahan)
  {
    if ($request->Ajax()) {
      $id = $_POST['id'];
      $user = 'Cancel-' . session('username') . ', ' . date('d-m-Y h:i:s');
      // DB::table('poh_bahan')->where('id', $id)->update(['batal' => 'Y', 'user' => $user]);
      Poh_bahan::where('id', $id)->update(['batal' => 'Y', 'user' => $user]);
      //Create History
      $poh_bahan = Poh_bahan::where('id', $id)->first();
      $nopo = $poh_bahan->nopo;
      $tanggal = date('Y-m-d');
      $datetime = date('Y-m-d H:i:s');
      $dokumen = $nopo;
      $form = 'Purchase Order Bahan';
      $status = 'Cancel';
      $catatan = isset($request->catatan) ? $request->catatan : '';
      $username = session('username');
      DB::table('hisuser')->insert(['tanggal' => $tanggal, 'dokumen' => $dokumen, 'form' => $form, 'status' => $status, 'user' => $username, 'catatan' => $catatan, 'datetime' => $datetime]);
      $msg = [
        'sukses' => 'Data berhasil di Cancel', //view('tbbarang.tabel_barang')
      ];
      echo json_encode($msg);
      // return redirect()->back()->with('message', 'Berhasil di update');
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function po_bahanambil(Request $request, Poh_bahan $poh_bahan)
  {
    if ($request->Ajax()) {
      $id = $_POST['id'];
      $user = 'Ambil-' . session('username') . ', ' . date('d-m-Y h:i:s');
      // DB::table('poh_bahan')->where('id', $id)->update(['batal' => 'N', 'user' => $user]);
      Poh_bahan::where('id', $id)->update(['batal' => 'N', 'user' => $user]);
      //Create History
      $row = Poh_bahan::where('id', $request->id)->first();
      $nopo = $row->nopo;
      $tanggal = date('Y-m-d');
      $datetime = date('Y-m-d H:i:s');
      $dokumen = $nopo;
      $form = 'Purchase Order Bahan';
      $status = 'Ambil';
      $catatan = isset($request->catatan) ? $request->catatan : '';
      $username = session('username');
      DB::table('hisuser')->insert(['tanggal' => $tanggal, 'dokumen' => $dokumen, 'form' => $form, 'status' => $status, 'user' => $username, 'catatan' => $catatan, 'datetime' => $datetime]);
      $msg = [
        'sukses' => 'Data berhasil di Cancel', //view('tbbarang.tabel_barang')
      ];
      echo json_encode($msg);
      // return redirect()->back()->with('message', 'Berhasil di update');
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function destroy(Poh_bahan $poh_bahan, Request $request)
  {
    if ($request->Ajax()) {
      $id = $request->id;
      $row = Poh_bahan::where('id', $request->id)->first();
      // $deleted = DB::table('poh_bahan')->where('id', $id)->delete();
      $deleted = Poh_bahan::where('id', $id)->delete();
      if ($deleted) {
        // DB::table('pod_bahan')->where('nopo', $row->nopo)->delete();
        Poh_bahan::where('nopo', $row->nopo)->delete();
        //Create History
        $nopo = $row->nopo;
        $tanggal = date('Y-m-d');
        $datetime = date('Y-m-d H:i:s');
        $dokumen = $nopo;
        $form = 'Purchase Order Bahan';
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

  public function pocaritbbarang(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        // 'menu' => 'transaksi',
        // 'submenu' => 'tbsupplier',
        // 'submenu1' => 'ref_umum',
        'title' => 'Cari tabel barang',
      ];
      // var_dump($data);
      return response()->json([
        'body' => view('so.modalcaritbbarang', [
          'tbbarang' => Tbbarang::all(),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function porepltbbarang(Request $request)
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

  public function pocaritbmultiprc(Request $request)
  {
    if ($request->Ajax()) {
      $kdsupplier = $request->kode_supplier;
      // $kdsupplier = $_GET['kode_supplier'];
      // dd($kdsupplier);
      $data = [
        // 'menu' => 'transaksi',
        // 'submenu' => 'tbsupplier',
        // 'submenu1' => 'ref_umum',
        'title' => 'Cari Tabel Multi Price',
      ];
      // var_dump($data);
      return response()->json([
        'body' => view('so.modalcaritbmultiprc', [
          // 'tbmultiprc' => Tbmultiprc::all(),
          'tbmultiprc' => Tbmultiprc::join('tbbarang', 'tbmultiprc.kdbarang', '=', 'tbbarang.kode')->where('tbmultiprc.kdsupplier', $kdsupplier)->get(),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function porepltbmultiprc(Request $request)
  {
    if ($request->Ajax()) {
      // $kode = $request->kode_barang; //$_GET['kode_multiprc'];
      // $row = DB::table('select tbmultiprc.kode,tbmultiprc.nama,tbmultiprc.kdsatuan,tbsatuan.nama as nmsatuan')->join('tbbarang', 'tbmultiprc.kdbarang', '=', 'tbbarang.kode')->where('tbmultiprc.kdbarang', $kode)->first();
      $row = Tbmultiprc::join('tbbarang', 'tbmultiprc.kdbarang', '=', 'tbbarang.kode')->where('tbmultiprc.kdsupplier', $request->kode_supplier)->where('kdbarang', $request->kode_barang)->first();
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

  public function po_bahaninputpod(Poh_bahan $poh_bahan, Request $request)
  {
    if ($request->Ajax()) {
      $id = $_GET['id'];
      $username = session('username');
      $poh_bahan = Poh_bahan::where('id', $id)->first();
      $nopo = $poh_bahan->nopo;
      $data = [
        'menu' => 'transaksi',
        'submenu' => 'po',
        'submenu1' => 'ref_umum',
        'title' => 'Detail Data Purchase Order Bahan',
      ];
      // var_dump($data);

      // return response()->json([
      //     'data' => $data,
      // ]);
      return response()->json([
        'body' => view('po_bahan.modaldetail', [
          'userdtlmenu' => Userdtl::join('tbmodule', 'userdtl.cmodule', '=', 'tbmodule.cmodule')->where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
          'userdtl' => Userdtl::where('cmodule', 'Purchase Order Bahan')->where('username', $username)->first(),
          'saplikasi' => Saplikasi::where('aktif', 'Y')->first(),
          'tbsales' => Tbsales::get(),
          'poh_bahan' => Poh_bahan::where('id', $id)->first(),
          'pod_bahan' => Pod_bahan::where('nopo', $nopo)->get(),
          // 'action' => route('po.update', $poh_bahan->id),
          'action' => 'potambahdetail',
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function potambahdetail(Request $request, Pod_bahan $pod_bahan)
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
        // $recsod = Pod_bahan::where('nopo', $request->nopod)->where('kdbarang', $request->kdbarang)->first();
        // if (isset($recsod->nopo)) {
        //   $msg = [
        //     'sukses' => 'Data gagal di tambah',
        //   ];
        // } else {
        $pod_bahan->fill([
          'nopo' => isset($request->nopod) ? $request->nopod : '',
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
        $pod_bahan->save($validate);
        $poh_bahan = Poh_bahan::where('nopo', $request->nopod)->first();
        $biaya_lain = $poh_bahan->biaya_lain;
        $materai = $poh_bahan->materai;
        $ppn = $poh_bahan->ppn;
        $subtotal = DB::table('pod_bahan')->where('nopo', $request->nopod)->sum('subtotal');
        $total_sementara = $biaya_lain + $subtotal + $materai;
        $total = $total_sementara + ($total_sementara * ($ppn / 100));
        DB::table('poh_bahan')->where('nopo', $request->nopod)->update([
          'subtotal' => $subtotal, 'biaya_lain' => $biaya_lain, 'materai' => $materai, 'total_sementara' => $total_sementara, 'total_sementara' =>
          $total_sementara, 'total' => $total
        ]);
        $msg = [
          'sukses' => 'Data berhasil di tambah', //view('tbbarang.tabel_barang')
        ];
        // }
      } else {
        $msg = [
          'sukses' => 'Data gagal di tambah', //view('tbbarang.tabel_barang')
        ];
      }
      echo json_encode($msg);
      // return redirect()->back()->with('message', 'Berhasil di update');
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function po_bahantotaldetail(Poh_bahan $poh_bahan, Request $request)
  {
    if ($request->Ajax()) {
      $nopo = $request->nopo;
      $poh_bahan = Poh_bahan::where('nopo', $nopo)->first();
      $data = [
        'menu' => 'transaksi',
        'submenu' => 'Purchase Order Bahan',
        'submenu1' => 'ref_umum',
        'title' => 'Detail Data Purchase Order Bahan',
      ];
      // var_dump($data);

      // return response()->json([
      //     'data' => $data,
      // ]);
      return response()->json([
        'body' => view('po_bahan.totaldetail', [
          'subtotalpod' => Pod_bahan::where('nopo', $nopo)->sum('subtotal'),
          'qtypod' => Pod_bahan::where('nopo', $nopo)->sum('qty'),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function po_bahancetak(Request $request)
  {
    //Create History
    $rowpoh_bahan = Poh_bahan::join('tbsupplier', 'poh_bahan.kdsupplier', '=', 'tbsupplier.kode')->where('poh_bahan.id', $request->id)->first();
    $nopo = $rowpoh_bahan->nopo;
    $rowpod_bahan = Poh_bahan::join('pod_bahan', 'pod_bahan.nopo', '=', 'poh_bahan.nopo')->where('poh_bahan.nopo', $nopo)->get();
    $data = [
      'poh_bahan' => $rowpoh_bahan,
      'pod_bahan' => $rowpod_bahan,
    ];
    // return view('po.cetak', $data);

    $rowd = Pod_bahan::where('nopo', $nopo)->get();
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
    $poh_bahan = Poh_bahan::where('id', $request->id)->first();
    $tanggal = date('Y-m-d');
    $datetime = date('Y-m-d H:i:s');
    $dokumen = $poh_bahan->nopo;
    $form = 'Purchase Order Bahan';
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
    $mpdf->WriteHTML(view('po_bahan.cetak', $data));
    $namafile = $nopo . ' - ' . date('dmY H:i:s') . '.pdf';
    //return the PDF for download
    // return $mpdf->Output($request->get('name') . $namafile, Destination::DOWNLOAD);
    $mpdf->Output($namafile, 'I');
  }
}
