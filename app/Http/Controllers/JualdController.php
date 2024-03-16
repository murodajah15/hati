<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\JualdRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Juald;
use App\Models\Jualh;
use App\Models\Saplikasi;

class JualdController extends Controller
{
  public function destroy(Juald $juald, Request $request)
  {
    if ($request->Ajax()) {
      $id = $request->id;
      $juald = Juald::where('id', $id)->first();
      $nojual = $juald->nojual;
      $deleted = DB::table('juald')->where('id', $id)->delete();
      if ($deleted) {
        $subtotal = DB::table('juald')->where('nojual', $nojual)->sum('subtotal');
        $jualh = Jualh::where('nojual', $nojual)->first();
        $biaya_lain = isset($jualh->biaya_lain) ? $jualh->biaya_lain : '0';
        $materai = isset($jualh->materai) ? $jualh->materai : '0';
        $ppn = isset($jualh->ppn) ? $jualh->ppn : '0';
        $total_sementara = $biaya_lain + $subtotal + $materai;
        $total = $total_sementara + ($total_sementara * ($ppn / 100));
        DB::table('jualh')->where('nojual', $nojual)->update(['biaya_lain' => $biaya_lain, 'subtotal' => $subtotal, 'total_sementara' => $total_sementara, 'ppn' => $ppn, 'total' => $total]);
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
      $nojual = $request->nojual;
      $username = session('username');
      $data = [
        'menu' => 'transaksi',
        'submenu' => 'jual',
        'submenu1' => 'ref_umum',
        'title' => 'Tambah Data Penjualan',
      ];
      // var_dump($data);

      // return response()->json([
      //     'data' => $data,
      // ]);
      return response()->json([
        'body' => view('jual.modaleditdetail', [
          'jual' => Jualh::where('nojual', $nojual)->first(),
          'juald' => new Juald(),
          'saplikasi' => Saplikasi::where('aktif', 'Y')->first(),
          'action' => route('jualdstore'),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function store(Request $request, jualdRequest $jualdrequest, juald $juald)
  {
    if ($request->Ajax()) {
      $nojual = $request->nojual;
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
        $recjuald = Juald::where('nojual', $request->nojual)->where('kdbarang', $request->kdbarang)->first();
        if (isset($recjuald->nojual)) {
          $msg = [
            'sukses' => 'Data gagal di tambah', //view('tbbarang.tabel_barang')
          ];
        } else {
          $juald->fill([
            'nojual' => isset($request->nojual) ? $request->nojual : '',
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
          $juald->save($validate);
          $jualh = Jualh::select('*')->where('nojual', $nojual)->first();
          // dd($jualh);
          $biaya_lain = $jualh->biaya_lain;
          $materai = $jualh->materai;
          $ppn = $jualh->ppn;
          $subtotal = DB::table('juald')->where('nojual', $request->nojual)->sum('subtotal');
          $total_sementara = $biaya_lain + $subtotal + $materai;
          $total = $total_sementara + ($total_sementara * ($ppn / 100));
          DB::table('jualh')->where('nojual', $request->nojual)->update([
            'subtotal' => $subtotal, 'biaya_lain' => $biaya_lain, 'materai' => $materai, 'total_sementara' => $total_sementara, 'total_sementara' =>
            $total_sementara, 'total' => $total
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

  public function edit(Juald $juald, Request $request)
  {
    if ($request->Ajax()) {
      // $id = $_GET['id'];
      $id = $request->id;
      $row = Juald::where('id', $id)->first();
      $nojual = $row->nojual;
      $data = [
        'menu' => 'transaksi',
        'submenu' => 'Penjualan',
        'submenu1' => 'ref_umum',
        'title' => 'Edit Data Penjualan',
      ];
      // var_dump($data);

      // return response()->json([
      //     'data' => $data,
      // ]);
      return response()->json([
        'body' => view('jual.modaleditdetail', [
          'jual' => Jualh::where('nojual', $nojual)->first(),
          'juald' => Juald::where('id', $id)->first(),
          'saplikasi' => Saplikasi::where('aktif', 'Y')->first(),
          // 'action' => route('so.update', $jualh->id),
          'action' => 'jualdupdate',
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function update(Request $request, Juald $juald)
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

      $juald = Juald::find($id);
      if ($validate) {
        // $recjuald = Juald::where('nojual', $request->nojuald)->where('kdbarang', $request->kdbarang)->first();
        // if (isset($recjuald->nojual)) {
        //   $msg = [
        //     'sukses' => 'Data gagal di tambah', //view('tbbarang.tabel_barang')
        //   ];
        // } else {
        $juald->fill([
          'nojual' => isset($request->nojuald) ? $request->nojuald : '',
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
        $juald->save($validate);
        $jualh = Jualh::where('nojual', $request->nojuald)->first();
        $biaya_lain = $jualh->biaya_lain;
        $materai = $jualh->materai;
        $ppn = $jualh->ppn;
        $subtotal = DB::table('juald')->where('nojual', $request->nojuald)->sum('subtotal');
        $total_sementara = $biaya_lain + $subtotal + $materai;
        $total = $total_sementara + ($total_sementara * ($ppn / 100));
        DB::table('jualh')->where('nojual', $request->nojuald)->update([
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
}