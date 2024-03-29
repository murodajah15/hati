<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Sod_bahanRequest;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Sod_bahan;
use App\Models\Soh_bahan;
use App\Models\Saplikasi;

class Sod_bahanController extends Controller
{
  public function sod_bahanajax(Request $request) //: View
  {
    $noso = $request->noso;
    if ($request->ajax()) {
      // $data = Sod_bahan::where('noso', $noso); //->orderBy('kode', 'asc');
      $data = Sod_bahan::leftjoin('tbsatuan', 'tbsatuan.kode', '=', 'sod_bahan.kdsatuan')
        ->select('sod_bahan.*', 'tbsatuan.nama as nmsatuan')
        ->where('noso', $noso); //->orderBy('kode', 'asc');      
      return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('kode1', function ($row) {
          $id = $row['id'];
          $btn = $row['kode']; //'<a href="#"' . 'onclick=detail(' . $id . ')>' .  $row['kode'] . '</a>';
          return $btn;
        })
        ->rawColumns(['kode1'])
        ->make(true);
      // return view('tbl-detail-so');
    }
  }

  public function create(Request $request)
  {
    if ($request->Ajax()) {
      $noso = $request->noso;
      $username = session('username');
      $data = [
        'menu' => 'transaksi',
        'submenu' => 'so',
        'submenu1' => 'bahan',
        'title' => 'Tambah Data Sales Order',
      ];
      // var_dump($data);

      // return response()->json([
      //     'data' => $data,
      // ]);
      return response()->json([
        'body' => view('so_bahan.modaleditdetail', [
          'soh_bahan' => Soh_bahan::where('noso', $noso)->first(),
          'sod_bahan' => new Sod_bahan(),
          'saplikasi' => Saplikasi::where('aktif', 'Y')->first(),
          // 'action' => route('so.update', $soh->id),
          'action' => route('sod_bahan.store'),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function store(Request $request, Sod_bahanRequest $Sod_bahanrequest, Sod_bahan $Sod_bahan)
  // public function store(Request $request, Soh $soh)
  {
    if ($request->Ajax()) {
      $noso = $request->noso;
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
        $recSod_bahan = Sod_bahan::where('noso', $request->noso)->where('kdbarang', $request->kdbarang)->first();
        if (isset($recSod_bahan->noso)) {
          $msg = [
            'sukses' => 'Data gagal di tambah', //view('tbbarang.tabel_barang')
          ];
        } else {
          $multiprc = isset($request->multiprc) ? 'Y' : 'N';
          $Sod_bahan->fill([
            'noso' => isset($request->noso) ? $request->noso : '',
            'kdbarang' => isset($request->kdbarang) ? $request->kdbarang : '',
            'nmbarang' => isset($request->nmbarang) ? $request->nmbarang : '',
            'kdsatuan' => isset($request->kdsatuan) ? $request->kdsatuan : '',
            'qty' => isset($request->qty) ? $request->qty : '',
            'harga' => isset($request->harga) ? $request->harga : '',
            'discount' => isset($request->discount) ? $request->discount : '',
            'subtotal' => isset($request->subtotal) ? $request->subtotal : '',
            'total' => isset($request->total) ? $request->total : '',
            'multiprc' => $multiprc,
            'user' => 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s'),
          ]);
          $Sod_bahan->save($validate);
          $soh = Soh_bahan::select('*')->where('noso', $noso)->first();
          // dd($soh);
          $biaya_lain = $soh->biaya_lain;
          $materai = $soh->materai;
          $ppn = $soh->ppn;
          $subtotal = Sod_bahan::where('noso', $request->noso)->sum('subtotal');
          $total_sementara = $biaya_lain + $subtotal + $materai;
          $total = $total_sementara + ($total_sementara * ($ppn / 100));
          Soh_bahan::where('noso', $request->noso)->update([
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

  public function edit(Sod_bahan $Sod_bahan, Request $request)
  {
    if ($request->Ajax()) {
      // $id = $_GET['id'];
      $id = $request->id;
      $row = Sod_bahan::where('id', $id)->first();
      $noso = $row->noso;
      $data = [
        'menu' => 'transaksi',
        'submenu' => 'Sales Order',
        'submenu1' => 'bahan',
        'title' => 'Edit Data Sales Order',
      ];
      // var_dump($data);

      // return response()->json([
      //     'data' => $data,
      // ]);
      return response()->json([
        'body' => view('so_bahan.modaleditdetail', [
          'soh_bahan' => Soh_bahan::where('noso', $noso)->first(),
          'sod_bahan' => Sod_bahan::where('id', $id)->first(),
          'saplikasi' => Saplikasi::where('aktif', 'Y')->first(),
          'action' => route('sod_bahan.update', $id),
          // 'action' => 'Sod_bahanupdate',
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function update(Request $request, Sod_bahan $Sod_bahan)
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

      $Sod_bahan = Sod_bahan::find($id);
      if ($validate) {
        // $recSod_bahan = Sod_bahan::where('noso', $request->noso)->where('kdbarang', $request->kdbarang)->first();
        // if (isset($recSod_bahan->noso)) {
        //   $msg = [
        //     'sukses' => 'Data gagal di tambah', //view('tbbarang.tabel_barang')
        //   ];
        // } else {
        $multiprc = isset($request->multiprc) ? 'Y' : 'N';
        $Sod_bahan->fill([
          'noso' => isset($request->noso) ? $request->noso : '',
          'kdbarang' => isset($request->kdbarang) ? $request->kdbarang : '',
          'nmbarang' => isset($request->nmbarang) ? $request->nmbarang : '',
          'kdsatuan' => isset($request->kdsatuan) ? $request->kdsatuan : '',
          'qty' => isset($request->qty) ? $request->qty : '',
          'harga' => isset($request->harga) ? $request->harga : '',
          'discount' => isset($request->discount) ? $request->discount : '',
          'subtotal' => isset($request->subtotal) ? $request->subtotal : '',
          'total' => isset($request->total) ? $request->total : '',
          'multiprc' => $multiprc,
          'user' => 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s'),
        ]);
        $Sod_bahan->save($validate);
        $soh = Soh_bahan::where('noso', $request->noso)->first();
        $biaya_lain = $soh->biaya_lain;
        $materai = $soh->materai;
        $ppn = $soh->ppn;
        $subtotal = Sod_bahan::where('noso', $request->noso)->sum('subtotal');
        $total_sementara = $biaya_lain + $subtotal + $materai;
        $total = $total_sementara + ($total_sementara * ($ppn / 100));
        Soh_bahan::where('noso', $request->noso)->update([
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

  public function destroy(Sod_bahan $Sod_bahan, Request $request)
  {
    if ($request->Ajax()) {
      $id = $request->id;
      // $soh->delete('id', $id);
      $recso = Sod_bahan::where('id', $id)->first();
      $noso = $recso->noso;
      $deleted = Sod_bahan::where('id', $id)->delete();
      $soh = Soh_bahan::where('noso', $noso)->first();
      $biaya_lain = $soh->biaya_lain;
      $materai = $soh->materai;
      $ppn = $soh->ppn;
      $subtotal = Sod_bahan::where('noso', $noso)->sum('subtotal');
      $total_sementara = $biaya_lain + $subtotal + $materai;
      $total = $total_sementara + ($total_sementara * ($ppn / 100));
      Soh_bahan::where('noso', $noso)->update([
        'subtotal' => $subtotal, 'biaya_lain' => $biaya_lain, 'materai' => $materai, 'total_sementara' => $total_sementara, 'total_sementara' =>
        $total_sementara, 'total' => $total
      ]);
      if ($deleted) {
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
}
