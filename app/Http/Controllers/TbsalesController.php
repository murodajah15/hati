<?php

namespace App\Http\Controllers;

use App\Http\Requests\TbsalesRequest;
use Illuminate\Http\Request;
use Session;
// use Yajra\DataTables\Contracts\DataTables;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Tbsales;
use App\Models\Tbstatus_sales;
use App\Models\Userdtl;
use Illuminate\Support\Facades\DB;

// //return type View
// use Illuminate\View\View;

class TbsalesController extends Controller
{
  public function index() //: View
  {
    $username = session('username');
    $data = [
      'menu' => 'file',
      'submenu' => 'tbsales',
      'submenu1' => 'ref_umum',
      'title' => 'Tabel Sales',
      // 'tbsales' => Tbsales::all(),
      'userdtlmenu' => Userdtl::join('tbmodule', 'userdtl.cmodule', '=', 'tbmodule.cmodule')->where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
      'userdtl' => Userdtl::where('cmodule', 'Tabel sales')->where('username', $username)->first(),
    ];
    // var_dump($data);
    return view('tbsales.index')->with($data);
  }
  public function tbsalesajax(Request $request) //: View
  {
    if ($request->ajax()) {
      $data = Tbsales::select('*'); //->orderBy('kode', 'asc');
      return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('kode1', function ($row) {
          $id = $row['id'];
          $btn = $row['kode']; //'<a href="#"' . 'onclick=detail(' . $id . ')>' .  $row['kode'] . '</a>';
          return $btn;
        })
        ->rawColumns(['kode1'])
        ->make(true);
      return view('tbsales');
    }
  }

  public function tabel_sales(Request $request)
  {
    $data = [
      'menu' => 'file',
      'submenu' => 'tbsales',
      'submenu1' => 'ref_umum',
      'title' => 'Tabel Sales',
      'tbsales' => Tbsales::orderBy('kode', 'asc')->get(),
    ];
    // var_dump($data);
    return view('tbsales.tabel_sales')->with($data);
  }

  public function create(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        'menu' => 'file',
        'submenu' => 'tbsales',
        'submenu1' => 'ref_umum',
        'title' => 'Tambah Data Tabel sales',
      ];
      return response()->json([
        'body' => view('tbsales.modaltambah', [
          'tbsales' => new Tbsales(),
          'tbsales_pilih' => Tbsales::orderBy('nama')->get(),
          'tbstatus_sales' => Tbstatus_sales::orderBy('status')->get(),
          'action' => route('tbsales.store'),
          'vdata' => $data,
        ])->render(),
        'data' => $data,

      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function store(TbsalesRequest $request, Tbsales $tbsales)
  {
    if ($request->Ajax()) {
      $validated = $request->validated();
      if ($validated) {
        $aktif = $request->aktif == 'on' ? 'Y' : 'N';
        $tbsales->fill([
          'kode' => isset($request->kode) ? $request->kode : '',
          'nama' => isset($request->nama) ? $request->nama : '',
          'nohp1' => isset($request->nohp1) ? $request->nohp1 : '',
          'nohp2' => isset($request->nohp2) ? $request->nohp2 : '',
          'email' => isset($request->email) ? $request->email : '',
          'status' => isset($request->status) ? $request->status : '',
          'tglmasuk' => isset($request->tglmasuk) ? $request->tglmasuk : '',
          'kdspv' => isset($request->kdspv) ? $request->kdspv : '',
          'aktif' => $aktif,
          'user' => 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s'),
        ]);
        $tbsales->save($validated);
        $msg = [
          'sukses' => 'Data berhasil di tambah', //view('tbsales.tabel_sales')
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
        'menu' => 'file',
        'submenu' => 'tbsales',
        'submenu1' => 'ref_umum',
        'title' => 'Detail Tabel sales',
        'tbsales' => Tbsales::findOrFail($id),
        'userdtl' => Userdtl::where('cmodule', 'Tabel sales')->where('username', $username)->first(),
      ];
      // return view('tbsales.modaldetail')->with($data);
      return response()->json([
        'body' => view('tbsales.modaltambah', [
          'tbsales' => Tbsales::findOrFail($id),
          'tbsales_pilih' => Tbsales::orderBy('nama')->get(),
          'tbstatus_sales' => Tbstatus_sales::orderBy('status')->get(),
          'action' => route('tbsales.store'),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function edit(Tbsales $tbsales, Request $request, $id)
  {
    if ($request->Ajax()) {
      $tbsales = Tbsales::findOrFail($id);
      $data = [
        'menu' => 'file',
        'submenu' => 'tbsales',
        'submenu1' => 'ref_umum',
        'title' => 'Edit Data Tabel sales',
      ];
      return response()->json([
        'body' => view('tbsales.modaltambah', [
          'tbsales' => $tbsales,
          'tbsales_pilih' => Tbsales::orderBy('nama')->get(),
          'tbstatus_sales' => Tbstatus_sales::orderBy('status')->get(),
          'action' => route('tbsales.update', $tbsales->id),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function update(Request $request, Tbsales $tbsales)
  {
    if ($request->Ajax()) {
      if ($request->kode === $request->kodelama) {
        $validated = $request->validate(
          [
            'kode' => 'required',
            'nama' => 'required',
          ],
          [
            'kode.required' => 'Kode harus di isi',
            'nama.required' => 'Nama harus di isi',
          ]
        );
      } else {
        // var_dump($request->kode . '!=' . $request->kodelama);
        $validated = $request->validate(
          [
            'kode' => 'required|unique:tbsales,kode',
            'nama' => 'required',
          ],
          [
            'kode.unique' => 'Kode tidak boleh sama',
            'kode.required' => 'Kode harus di isi',
            'nama.required' => 'Nama harus di isi',
          ]
        );
      }
      if ($validated) {
        $aktif = $request->aktif == 'on' ? 'Y' : 'N';
        $kode = isset($request->kode) ? $request->kode : '';
        $nama = isset($request->nama) ? $request->nama : '';
        $nohp1 = isset($request->nohp1) ? $request->nohp1 : '';
        $nohp2 = isset($request->nohp2) ? $request->nohp2 : '';
        $email = isset($request->email) ? $request->email : '';
        $status = isset($request->status) ? $request->status : '';
        $tglmasuk = isset($request->tglmasuk) ? $request->tglmasuk : '';
        $kdspv = isset($request->kdspv) ? $request->kdspv : '';
        $aktif = $aktif;
        $user = 'Update-' . $request->username . ', ' . date('d-m-Y h:i:s');
        Tbsales::where('id', $request->id)->update([
          'kode' => $kode, 'nama' => $nama, 'nohp1' => $nohp1, 'nohp2' => $nohp2,
          'email' => $email, 'status' => $status, 'tglmasuk' => $tglmasuk, 'kdspv' => $kdspv, 'aktif' => $aktif, 'user' => $user
        ]);
        $msg = [
          'sukses' => 'Data berhasil di update', //view('tbsa.tabel_sa')
        ];
      } else {
        $msg = [
          'sukses' => 'Data gagal di update', //view('tbsales.tabel_sales')
        ];
      }
      echo json_encode($msg);
      // return redirect()->back()->with('message', 'Berhasil di update');
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function destroy(Tbsales $tbsales, Request $request, $id)
  {
    if ($request->Ajax()) {
      // DB::table('tbsales')->where('id', $id)->delete();
      Tbsales::where('id', $id)->delete();
      // $tbsales->delete();
      return response()->json([
        'sukses' => 'Data berhasil di hapus',
      ]);
      // return redirect()->back()->with('message', 'Berhasil di hapus');
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
}
