<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\pod_bahanRequest;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Pod_bahan;
use App\Models\Poh_bahan;
use App\Models\Saplikasi;

class Pod_bahanController extends Controller
{
  public function pod_bahanajax(Request $request) //: View
  {
    $nopo = $request->nopo;
    if ($request->ajax()) {
      $data = Pod_bahan::where('nopo', $nopo); //->orderBy('kode', 'asc');
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
      $nopo = $request->nopo;
      $username = session('username');
      $data = [
        'menu' => 'transaksi',
        'submenu' => 'po',
        'submenu1' => 'ref_umum',
        'title' => 'Tambah Data Purchase Order',
      ];
      // var_dump($data);

      // return response()->json([
      //     'data' => $data,
      // ]);
      return response()->json([
        'body' => view('po_bahan.modaleditdetail', [
          'poh_bahan' => Poh_bahan::where('nopo', $nopo)->first(),
          'pod_bahan' => new pod_bahan(),
          'saplikasi' => Saplikasi::where('aktif', 'Y')->first(),
          'action' => route('pod_bahan.store'),
          // 'action' => route('podstore'),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function store(Request $request, Pod_bahan $pod_bahan)
  // public function store(Request $request, Soh $poh)
  {
    if ($request->Ajax()) {
      $nopo = $request->nopo;
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
        $recpod = Pod_bahan::where('nopo', $request->nopo)->where('kdbarang', $request->kdbarang)->first();
        if (isset($recpod->nopo)) {
          $msg = [
            'sukses' => 'Data gagal di tambah', //view('tbbarang.tabel_barang')
          ];
        } else {
          $pod_bahan->fill([
            'nopo' => isset($request->nopo) ? $request->nopo : '',
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
          $poh = Poh_bahan::select('*')->where('nopo', $nopo)->first();
          $biaya_lain = $poh->biaya_lain;
          $materai = $poh->materai;
          $ppn = $poh->ppn;
          // $subtotal = DB::table('pod')->where('nopo', $request->nopo)->sum('subtotal');
          $subtotal = Pod_bahan::where('nopo', $request->nopo)->sum('subtotal');
          $total_sementara = $biaya_lain + $subtotal + $materai;
          $total = $total_sementara + ($total_sementara * ($ppn / 100));
          // DB::table('poh')->where('nopo', $request->nopo)->update([
          //   'subtotal' => $subtotal, 'biaya_lain' => $biaya_lain, 'materai' => $materai, 'total_sementara' => $total_sementara, 'total_sementara' =>
          //   $total_sementara, 'total' => $total
          // ]);
          Poh_bahan::where('nopo', $request->nopo)->update([
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

  public function edit(Pod_bahan $pod_bahan, Request $request)
  {
    if ($request->Ajax()) {
      // $id = $_GET['id'];
      $id = $request->id;
      $row = Pod_bahan::where('id', $id)->first();
      $nopo = $row->nopo;
      $data = [
        'menu' => 'transaksi',
        'submenu' => 'Purchase Order',
        'submenu1' => 'ref_umum',
        'title' => 'Edit Data Purchase Order',
      ];
      // var_dump($data);

      // return response()->json([
      //     'data' => $data,
      // ]);
      return response()->json([
        'body' => view('po_bahan.modaleditdetail', [
          'poh_bahan' => Poh_bahan::where('nopo', $nopo)->first(),
          'pod_bahan' => Pod_bahan::where('id', $id)->first(),
          'saplikasi' => Saplikasi::where('aktif', 'Y')->first(),
          'action' => route('pod_bahan.update', $pod_bahan->id),
          // 'action' => 'podupdate',
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function update(Request $request, Pod_bahan $pod_bahan)
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

      $pod = Pod_bahan::find($id);
      if ($validate) {
        // $recpod = Pod_bahan::where('nopo', $request->nopod)->where('kdbarang', $request->kdbarang)->first();
        // if (isset($recpod->nopo)) {
        //   $msg = [
        //     'sukses' => 'Data gagal di tambah', //view('tbbarang.tabel_barang')
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
        $poh = Poh_bahan::where('nopo', $request->nopod)->first();
        $biaya_lain = $poh->biaya_lain;
        $materai = $poh->materai;
        $ppn = $poh->ppn;
        // $subtotal = DB::table('pod')->where('nopo', $request->nopod)->sum('subtotal');
        $subtotal = Pod_bahan::where('nopo', $request->nopod)->sum('subtotal');
        $total_sementara = $biaya_lain + $subtotal + $materai;
        $total = $total_sementara + ($total_sementara * ($ppn / 100));
        // DB::table('poh')->where('nopo', $request->nopod)->update([
        //   'subtotal' => $subtotal, 'biaya_lain' => $biaya_lain, 'materai' => $materai, 'total_sementara' => $total_sementara, 'total_sementara' =>
        //   $total_sementara, 'total' => $total
        // ]);
        Poh_bahan::where('nopo', $request->nopod)->update([
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

  public function destroy(Pod_bahan $pod_bahan, Request $request)
  {
    if ($request->Ajax()) {
      $id = $request->id;
      // $poh->delete('id', $id);
      $rowpod = Pod_bahan::where('id', $id)->first();
      $nopo = $rowpod->nopo;
      $deleted = Pod_bahan::where('id', $id)->delete();
      $poh = Poh_bahan::where('nopo', $nopo)->first();
      $biaya_lain = $poh->biaya_lain;
      $materai = $poh->materai;
      $ppn = $poh->ppn;
      $subtotal = Pod_bahan::where('nopo', $nopo)->sum('subtotal');
      $total_sementara = $biaya_lain + $subtotal + $materai;
      $total = $total_sementara + ($total_sementara * ($ppn / 100));
      Poh_bahan::where('nopo', $nopo)->update([
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
