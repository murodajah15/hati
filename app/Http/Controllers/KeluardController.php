<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\KeluardRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Keluard;
use App\Models\Keluarh;
use App\Models\Saplikasi;

class KeluardController extends Controller
{
  public function destroy(Keluard $keluard, Request $request)
  {
    if ($request->Ajax()) {
      $id = $request->id;
      $keluard = Keluard::where('id', $id)->first();
      $nokeluar = $keluard->nokeluar;
      $deleted = DB::table('keluard')->where('id', $id)->delete();
      if ($deleted) {
        $subtotal = DB::table('keluard')->where('nokeluar', $nokeluar)->sum('subtotal');
        $keluarh = Keluarh::where('nokeluar', $nokeluar)->first();
        $biaya_lain = isset($keluarh->biaya_lain) ? $keluarh->biaya_lain : '0';
        $total = $biaya_lain + $subtotal;
        DB::table('keluarh')->where('nokeluar', $nokeluar)->update(['biaya_lain' => $biaya_lain, 'subtotal' => $subtotal, 'total' => $total]);
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

  public function create(Request $request)
  {
    if ($request->Ajax()) {
      $nokeluar = $request->nokeluar;
      $username = session('username');
      $data = [
        'menu' => 'transaksi',
        'submenu' => 'keluar',
        'submenu1' => 'ref_umum',
        'title' => 'Tambah Data Penkeluaran',
      ];
      // var_dump($data);

      // return response()->json([
      //     'data' => $data,
      // ]);
      return response()->json([
        'body' => view('keluar.modaleditdetail', [
          'keluar' => Keluarh::where('nokeluar', $nokeluar)->first(),
          'keluard' => new keluard(),
          'saplikasi' => Saplikasi::where('aktif', 'Y')->first(),
          'action' => route('keluardstore'),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function store(Request $request, KeluardRequest $KeluardRequest, Keluard $keluard)
  {
    if ($request->Ajax()) {
      $nokeluar = $request->nokeluar;
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
        $reckeluard = Keluard::where('nokeluar', $request->nokeluar)->where('kdbarang', $request->kdbarang)->first();
        if (isset($reckeluard->nokeluar)) {
          $msg = [
            'sukses' => 'Data gagal di tambah', //view('tbbarang.tabel_barang')
          ];
        } else {
          $keluard->fill([
            'nokeluar' => isset($request->nokeluar) ? $request->nokeluar : '',
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
          $keluard->save($validate);
          $keluarh = Keluarh::select('*')->where('nokeluar', $nokeluar)->first();
          // dd($keluarh);
          $biaya_lain = $keluarh->biaya_lain;
          $subtotal = DB::table('keluard')->where('nokeluar', $request->nokeluar)->sum('subtotal');
          $total = $biaya_lain + $subtotal;
          DB::table('keluarh')->where('nokeluar', $request->nokeluar)->update([
            'subtotal' => $subtotal, 'biaya_lain' => $biaya_lain, 'total' => $total
          ]);
          $msg = [
            'sukses' => 'Data berhasil di tambah', //view('tbbarang.tabel_barang')
          ];
        }
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

  public function edit(Keluard $keluard, Request $request)
  {
    if ($request->Ajax()) {
      // $id = $_GET['id'];
      $id = $request->id;
      $row = Keluard::where('id', $id)->first();
      $nokeluar = $row->nokeluar;
      $data = [
        'menu' => 'transaksi',
        'submenu' => 'Penkeluaran',
        'submenu1' => 'ref_umum',
        'title' => 'Edit Data Penkeluaran',
      ];
      // var_dump($data);

      // return response()->json([
      //     'data' => $data,
      // ]);
      return response()->json([
        'body' => view('keluar.modaleditdetail', [
          'keluar' => Keluarh::where('nokeluar', $nokeluar)->first(),
          'keluard' => Keluard::where('id', $id)->first(),
          'saplikasi' => Saplikasi::where('aktif', 'Y')->first(),
          // 'action' => route('so.update', $keluarh->id),
          'action' => 'keluardupdate',
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function update(Request $request, Keluard $keluard)
  {
    if ($request->Ajax()) {
      $id = $request->id;

      $validate = $request->validate(
        [
          'kdbarang' => 'required',
        ],
        [
          'kdbarang.required' => 'Barang harus di isi',
        ],
      );

      $keluard = Keluard::find($id);
      if ($validate) {
        // $reckeluard = Keluard::where('nokeluar', $request->nokeluard)->where('kdbarang', $request->kdbarang)->first();
        // if (isset($reckeluard->nokeluar)) {
        //   $msg = [
        //     'sukses' => 'Data gagal di tambah', //view('tbbarang.tabel_barang')
        //   ];
        // } else {
        $keluard->fill([
          'nokeluar' => isset($request->nokeluard) ? $request->nokeluard : '',
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
        $keluard->save($validate);
        $keluarh = Keluarh::where('nokeluar', $request->nokeluard)->first();
        $biaya_lain = $keluarh->biaya_lain;
        $subtotal = DB::table('keluard')->where('nokeluar', $request->nokeluard)->sum('subtotal');
        $total = $biaya_lain + $subtotal;
        DB::table('keluarh')->where('nokeluar', $request->nokeluard)->update([
          'subtotal' => $subtotal, 'biaya_lain' => $biaya_lain, 'total' => $total
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
}
