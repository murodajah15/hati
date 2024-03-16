<?php

namespace App\Http\Controllers;

use App\Http\Requests\TbwarnaRequest;
use Illuminate\Http\Request;
use Session;
// use Yajra\DataTables\Contracts\DataTables;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Tbwarna;
use App\Models\Userdtl;

// //return type View
// use Illuminate\View\View;

class TbwarnaController extends Controller
{
  public function index(Request $request) //: View
  {
    $username = session('username');
    $userdtl = Userdtl::where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get();
    $data = [
      'menu' => 'file',
      'submenu' => 'tbwarna',
      'submenu1' => 'ref_kendaraan',
      'title' => 'Tabel Warna Kendaraan',
      // 'tbwarna' => Tbwarna::all(),
      // 'userdtlmenu' => Userdtl::join('tbmodule', 'userdtl.cmodule', '=', 'tbmodule.cmodule')->where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
      'userdtlmenu' => $userdtl,
      'userdtl' => Userdtl::where('cmodule', 'Tabel Warna Kendaraan')->where('username', $username)->first(),
    ];
    // var_dump($data);
    return view('tbwarna.index')->with($data);
  }
  public function tbwarnaajax(Request $request) //: View
  {
    if ($request->ajax()) {
      $data = Tbwarna::select('*'); //->orderBy('kode', 'asc');
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
      return view('tbwarna');
    }
  }

  public function tabel_warna(Request $request)
  {
    $data = [
      'menu' => 'file',
      'submenu' => 'tbwarna',
      'submenu1' => 'ref_kendaraan',
      'title' => 'Tabel Warna Kendaraan',
      'tbwarna' => Tbwarna::orderBy('kode', 'asc')->get(),
    ];
    // var_dump($data);
    return view('tbwarna.tabel_warna')->with($data);
  }

  public function create(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        'menu' => 'file',
        'submenu' => 'tbwarna',
        'submenu1' => 'ref_kendaraan',
        'title' => 'Tambah Data Tabel Warna Kendaraan',
        // 'tbwarna' => Tbwarna::all(),
      ];
      // var_dump($data);
      return response()->json([
        'body' => view('tbwarna.modaltambah', [
          'tbwarna' => new Tbwarna(), //Tbwarna::first(),
          'action' => route('tbwarna.store'),
          'vdata' => $data,
        ])->render(),
        'data' => $data,

      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function store(TbwarnaRequest $request, Tbwarna $tbwarna)
  {
    if ($request->Ajax()) {
      $validated = $request->validated(
        // [
        //     'kode' => 'required|unique:tbwarna,kode',
        //     'nama' => 'required',
        // ],
        // [
        //     'kode.unique' => 'Kode tidak boleh sama',
        //     'kode.required' => 'Kode harus di isi',
        //     'nama.required' => 'Nama harus di isi',
        // ]
      );
      if ($validated) {
        // $tbwarna->fill($request->all());
        // $tbwarna->aktif = $request->aktif == 'on' ? 'Y' : 'N';
        // $tbwarna->user = $request->username . date('d-m-Y');
        $aktif = isset($request->aktif) ? 'Y' : 'N';
        $tbwarna->fill([
          'nama' => $request->nama,
          'kode' => $request->kode,
          'aktif' => $aktif,
          'user' => 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s'),
        ]);
        $tbwarna->save($validated);
        $msg = [
          'sukses' => 'Data berhasil di tambah', //view('tbwarna.tabel_warna')
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
        'submenu' => 'tbwarna',
        'submenu1' => 'ref_kendaraan',
        'title' => 'Detail Tabel Warna Kendaraan',
        'tbwarna' => Tbwarna::findOrFail($id),
        'userdtl' => Userdtl::where('cmodule', 'Tabel Warna Kendaraan')->where('username', $username)->first(),
      ];
      // return view('tbwarna.modaldetail')->with($data);
      return response()->json([
        'body' => view('tbwarna.modaltambah', [
          'tbwarna' => Tbwarna::findOrFail($id),
          'action' => route('tbwarna.store'),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function edit(Tbwarna $tbwarna, Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        'menu' => 'file',
        'submenu' => 'tbwarna',
        'submenu1' => 'ref_kendaraan',
        'title' => 'Edit Data Tabel Warna Kendaraan',
      ];
      return response()->json([
        'body' => view('tbwarna.modaltambah', [
          'tbwarna' => $tbwarna,
          'action' => route('tbwarna.update', $tbwarna->id),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function update(TbwarnaRequest $request, Tbwarna $tbwarna)
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
          //     'kode' => 'required|unique:tbwarna,kode',
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
        $tbwarna->fill([
          'nama' => $request->nama,
          'kode' => $request->kode,
          'aktif' => $aktif,
          'user' => 'Update-' . $request->username . ', ' . date('d-m-Y h:i:s'),
        ]);
        $tbwarna->save($validated);
        $msg = [
          'sukses' => 'Data berhasil di update', //view('tbwarna.tabel_warna')
        ];
      } else {
        $msg = [
          'sukses' => 'Data gagal di update', //view('tbwarna.tabel_warna')
        ];
      }
      echo json_encode($msg);
      // return redirect()->back()->with('message', 'Berhasil di update');
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function destroy(Tbwarna $tbwarna, Request $request)
  {
    if ($request->Ajax()) {
      $tbwarna->delete();
      return response()->json([
        'sukses' => 'Data berhasil di hapus',
      ]);
      // return redirect()->back()->with('message', 'Berhasil di hapus');
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
}