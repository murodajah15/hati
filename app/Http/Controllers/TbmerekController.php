<?php

namespace App\Http\Controllers;

use App\Http\Requests\TbmerekRequest;
use Illuminate\Http\Request;
use Session;
// use Yajra\DataTables\Contracts\DataTables;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Tbmerek;
use App\Models\Userdtl;

// //return type View
// use Illuminate\View\View;

class TbmerekController extends Controller
{
  public function index(Request $request) //: View
  {
    $username = session('username');
    $userdtl = Userdtl::where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get();
    $data = [
      'menu' => 'file',
      'submenu' => 'tbmerek',
      'submenu1' => 'ref_kendaraan',
      'title' => 'Tabel Merek Kendaraan',
      // 'tbmerek' => Tbmerek::all(),
      // 'userdtlmenu' => Userdtl::join('tbmodule', 'userdtl.cmodule', '=', 'tbmodule.cmodule')->where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
      'userdtlmenu' => $userdtl,
      'userdtl' => Userdtl::where('cmodule', 'Tabel Merek Kendaraan')->where('username', $username)->first(),
    ];
    // var_dump($data);
    return view('tbmerek.index')->with($data);
  }
  public function tbmerekajax(Request $request) //: View
  {
    if ($request->ajax()) {
      $data = Tbmerek::select('*'); //->orderBy('kode', 'asc');
      return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('kode1', function ($row) {
          $id = $row['id'];
          $btn = $row['kode']; //'<a href="#"' . 'onclick=detail(' . $id . ')>' .  $row['kode'] . '</a>';
          return $btn;
        })
        ->rawColumns(['kode1'])
        // ->addIndexColumn()
        // ->addColumn('action', function ($row) {
        //     $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
        //     return $btn;
        // })
        // ->rawColumns(['action'])
        ->make(true);
      return view('tbmerek');
    }
  }

  public function tabel_merek(Request $request)
  {
    $data = [
      'menu' => 'file',
      'submenu' => 'tbmerek',
      'submenu1' => 'ref_kendaraan',
      'title' => 'Tabel Merek Kendaraan',
      'tbmerek' => Tbmerek::orderBy('kode', 'asc')->get(),
    ];
    // var_dump($data);
    return view('tbmerek.tabel_merek')->with($data);
  }

  public function create(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        'menu' => 'file',
        'submenu' => 'tbmerek',
        'submenu1' => 'ref_kendaraan',
        'title' => 'Tambah Data Tabel Merek Kendaraan',
        // 'tbmerek' => Tbmerek::all(),
      ];
      // var_dump($data);
      return response()->json([
        'body' => view('tbmerek.modaltambah', [
          'tbmerek' => new Tbmerek(), //Tbmerek::first(),
          'action' => route('tbmerek.store'),
          'vdata' => $data,
        ])->render(),
        'data' => $data,

      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function store(TbmerekRequest $request, Tbmerek $tbmerek)
  {
    if ($request->Ajax()) {
      $validated = $request->validated(
        // [
        //     'kode' => 'required|unique:tbmerek,kode',
        //     'nama' => 'required',
        // ],
        // [
        //     'kode.unique' => 'Kode tidak boleh sama',
        //     'kode.required' => 'Kode harus di isi',
        //     'nama.required' => 'Nama harus di isi',
        // ]
      );
      if ($validated) {
        // $tbmerek->fill($request->all());
        // $tbmerek->aktif = $request->aktif == 'on' ? 'Y' : 'N';
        // $tbmerek->user = $request->username . date('d-m-Y');
        $aktif = isset($request->aktif) ? 'Y' : 'N';
        $tbmerek->fill([
          'nama' => $request->nama,
          'kode' => $request->kode,
          'aktif' => $aktif,
          'user' => 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s'),
        ]);
        $tbmerek->save($validated);
        $msg = [
          'sukses' => 'Data berhasil di tambah', //view('tbmerek.tabel_merek')
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
    if ($request->Ajax()) {
      $id = $_GET['id'];
      $username = session('username');
      $data = [
        'menu' => 'file',
        'submenu' => 'tbmerek',
        'submenu1' => 'ref_kendaraan',
        'title' => 'Detail Tabel Merek Kendaraan',
        'tbmerek' => Tbmerek::findOrFail($id),
        'userdtl' => Userdtl::where('cmodule', 'Tabel Merek Kendaraan')->where('username', $username)->first(),
      ];
      // return view('tbmerek.modaldetail')->with($data);
      return response()->json([
        'body' => view('tbmerek.modaltambah', [
          'tbmerek' => Tbmerek::findOrFail($id),
          'action' => route('tbmerek.store'),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function edit(Tbmerek $tbmerek, Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        'menu' => 'file',
        'submenu' => 'tbmerek',
        'submenu1' => 'ref_kendaraan',
        'title' => 'Edit Data Tabel Merek Kendaraan',
      ];
      return response()->json([
        'body' => view('tbmerek.modaltambah', [
          'tbmerek' => $tbmerek,
          'action' => route('tbmerek.update', $tbmerek->id),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function update(TbmerekRequest $request, Tbmerek $tbmerek)
  {
    if ($request->Ajax()) {
      if ($request->kode === $request->kodelama) {
        $validated = $request->validated(
          // [
          //     'kode' => 'required',
          //     'nama' => 'required',
          // ],
          // [
          //     'kode.required' => 'Kode harus di isi',
          //     'nama.required' => 'Nama harus di isi',
          // ]
        );
      } else {
        // var_dump($request->kode . '!=' . $request->kodelama);
        $validated = $request->validated(
          // [
          //     'kode' => 'required|unique:tbmerek,kode',
          //     'nama' => 'required',
          // ],
          // [
          //     'kode.unique' => 'Kode tidak boleh sama',
          //     'kode.required' => 'Kode harus di isi',
          //     'nama.required' => 'Nama harus di isi',
          // ]
        );
      }
      if ($validated) {
        $aktif = $request->aktif == 'on' ? 'Y' : 'N';
        $tbmerek->fill([
          'nama' => $request->nama,
          'kode' => $request->kode,
          'aktif' => $aktif,
          'user' => 'Update-' . $request->username . ', ' . date('d-m-Y h:i:s'),
        ]);
        $tbmerek->save($validated);
        $msg = [
          'sukses' => 'Data berhasil di update', //view('tbmerek.tabel_merek')
        ];
      } else {
        $msg = [
          'sukses' => 'Data gagal di update', //view('tbmerek.tabel_merek')
        ];
      }
      echo json_encode($msg);
      // return redirect()->back()->with('message', 'Berhasil di update');
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function destroy(Tbmerek $tbmerek, Request $request)
  {
    if ($request->Ajax()) {
      $tbmerek->delete();
      return response()->json([
        'sukses' => 'Data berhasil di hapus',
      ]);
      // return redirect()->back()->with('message', 'Berhasil di hapus');
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
}
