<?php

namespace App\Http\Controllers;

use App\Http\Requests\TbmoveRequest;
use Illuminate\Http\Request;
use Session;
// use Yajra\DataTables\Contracts\DataTables;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Tbmove;
use App\Models\Userdtl;

// //return type View
// use Illuminate\View\View;

class TbmoveController extends Controller
{
  public function index(Request $request) //: View
  {
    $username = session('username');
    $userdtl = Userdtl::where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get();
    $data = [
      'menu' => 'file',
      'submenu' => 'tbmove',
      'submenu1' => 'ref_part',
      'title' => 'Tabel Perputaran Barang',
      // 'tbmove' => Tbmove::all(),
      // 'userdtlmenu' => Userdtl::join('tbmodule', 'userdtl.cmodule', '=', 'tbmodule.cmodule')->where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
      'userdtlmenu' => $userdtl,
      'userdtl' => Userdtl::where('cmodule', 'Tabel Perputaran Barang')->where('username', $username)->first(),
    ];
    // var_dump($data);
    return view('tbmove.index')->with($data);
  }
  public function tbmoveajax(Request $request) //: View
  {
    if ($request->ajax()) {
      $data = Tbmove::select('*'); //->orderBy('kode', 'asc');
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
      return view('tbmove');
    }
  }

  public function tabel_move(Request $request)
  {
    $data = [
      'menu' => 'file',
      'submenu' => 'tbmove',
      'submenu1' => 'ref_umum',
      'title' => 'Tabel Perputaran Barang',
      'tbmove' => Tbmove::orderBy('kode', 'asc')->get(),
    ];
    // var_dump($data);
    return view('tbmove.tabel_move')->with($data);
  }

  public function create(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        'menu' => 'file',
        'submenu' => 'tbmove',
        'submenu1' => 'ref_umum',
        'title' => 'Tambah Data Tabel Perputaran Barang',
        // 'tbmove' => Tbmove::all(),
      ];
      // var_dump($data);
      return response()->json([
        'body' => view('tbmove.modaltambah', [
          'tbmove' => new Tbmove(), //Tbmove::first(),
          'action' => route('tbmove.store'),
          'vdata' => $data,
        ])->render(),
        'data' => $data,

      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function store(TbmoveRequest $request, Tbmove $tbmove)
  {
    if ($request->Ajax()) {
      $validated = $request->validated(
        // [
        //     'kode' => 'required|unique:tbmove,kode',
        //     'nama' => 'required',
        // ],
        // [
        //     'kode.unique' => 'Kode tidak boleh sama',
        //     'kode.required' => 'Kode harus di isi',
        //     'nama.required' => 'Nama harus di isi',
        // ]
      );
      if ($validated) {
        // $tbmove->fill($request->all());
        // $tbmove->aktif = $request->aktif == 'on' ? 'Y' : 'N';
        // $tbmove->user = $request->username . date('d-m-Y');
        $aktif = isset($request->aktif) ? 'Y' : 'N';
        $tbmove->fill([
          'nama' => $request->nama,
          'kode' => $request->kode,
          'aktif' => $aktif,
          'user' => 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s'),
        ]);
        $tbmove->save($validated);
        $msg = [
          'sukses' => 'Data berhasil di tambah', //view('tbmove.tabel_move')
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
        'submenu' => 'tbmove',
        'submenu1' => 'ref_umum',
        'title' => 'Detail Tabel Perputaran Barang',
        'tbmove' => Tbmove::findOrFail($id),
        'userdtl' => Userdtl::where('cmodule', 'Tabel Perputaran Barang')->where('username', $username)->first(),
      ];
      // return view('tbmove.modaldetail')->with($data);
      return response()->json([
        'body' => view('tbmove.modaltambah', [
          'tbmove' => Tbmove::findOrFail($id),
          'action' => route('tbmove.store'),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function edit(Tbmove $tbmove, Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        'menu' => 'file',
        'submenu' => 'tbmove',
        'submenu1' => 'ref_umum',
        'title' => 'Edit Data Tabel Perputaran Barang',
      ];
      return response()->json([
        'body' => view('tbmove.modaltambah', [
          'tbmove' => $tbmove,
          'action' => route('tbmove.update', $tbmove->id),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function update(TbmoveRequest $request, Tbmove $tbmove)
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
          //     'kode' => 'required|unique:tbmove,kode',
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
        $tbmove->fill([
          'nama' => $request->nama,
          'kode' => $request->kode,
          'aktif' => $aktif,
          'user' => 'Update-' . $request->username . ', ' . date('d-m-Y h:i:s'),
        ]);
        $tbmove->save($validated);
        $msg = [
          'sukses' => 'Data berhasil di update', //view('tbmove.tabel_move')
        ];
      } else {
        $msg = [
          'sukses' => 'Data gagal di update', //view('tbmove.tabel_move')
        ];
      }
      echo json_encode($msg);
      // return redirect()->back()->with('message', 'Berhasil di update');
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function destroy(Tbmove $tbmove, Request $request)
  {
    if ($request->Ajax()) {
      $tbmove->delete();
      return response()->json([
        'sukses' => 'Data berhasil di hapus',
      ]);
      // return redirect()->back()->with('message', 'Berhasil di hapus');
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
}
