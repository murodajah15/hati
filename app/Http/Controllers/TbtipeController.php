<?php

namespace App\Http\Controllers;

use App\Http\Requests\TbtipeRequest;
use Illuminate\Http\Request;
use Session;
// use Yajra\DataTables\Contracts\DataTables;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Tbtipe;
use App\Models\Tbmodel;
use App\Models\Userdtl;

// //return type View
// use Illuminate\View\View;

class TbtipeController extends Controller
{
  public function index(Request $request) //: View
  {
    $username = session('username');
    $userdtl = Userdtl::where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get();
    $data = [
      'menu' => 'file',
      'submenu' => 'tbtipe',
      'submenu1' => 'ref_kendaraan',
      'title' => 'Tabel Tipe Kendaraan',
      // 'tbtipe' => Tbtipe::all(),
      // 'userdtlmenu' => Userdtl::join('tbmodule', 'userdtl.cmodule', '=', 'tbmodule.cmodule')->where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
      'userdtlmenu' => $userdtl,
      'userdtl' => Userdtl::where('cmodule', 'Tabel Tipe Kendaraan')->where('username', $username)->first(),
    ];
    // var_dump($data);
    return view('tbtipe.index')->with($data);
  }
  public function tbtipeajax(Request $request) //: View
  {
    if ($request->ajax()) {
      // $data = Tbtipe::select('*'); //->orderBy('kode', 'asc');
      $data = Tbtipe::select('tbtipe.*', 'tbmodel.nama as nmmodel')->leftjoin('tbmodel', 'tbmodel.kode', '=', 'tbtipe.kdmodel'); //->orderBy('kode', 'asc');
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
      return view('tbtipe');
    }
  }

  public function tabel_model(Request $request)
  {
    $data = [
      'menu' => 'file',
      'submenu' => 'tbtipe',
      'submenu1' => 'ref_kendaraan',
      'title' => 'Tabel Tipe Kendaraan',
      'tbtipe' => Tbtipe::orderBy('kode', 'asc')->get(),
    ];
    // var_dump($data);
    return view('tbtipe.tabel_model')->with($data);
  }

  public function create(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        'menu' => 'file',
        'submenu' => 'tbtipe',
        'submenu1' => 'ref_kendaraan',
        'title' => 'Tambah Data Tabel Tipe Kendaraan',
        // 'tbtipe' => Tbtipe::all(),
      ];
      // var_dump($data);
      return response()->json([
        'body' => view('tbtipe.modaltambah', [
          'tbtipe' => new Tbtipe(), //Tbtipe::first(),
          'action' => route('tbtipe.store'),
          'vdata' => $data,
        ])->render(),
        'data' => $data,

      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function store(TbtipeRequest $request, Tbtipe $tbtipe)
  {
    if ($request->Ajax()) {
      $validated = $request->validated(
        // [
        //     'kode' => 'required|unique:tbtipe,kode',
        //     'nama' => 'required',
        // ],
        // [
        //     'kode.unique' => 'Kode tidak boleh sama',
        //     'kode.required' => 'Kode harus di isi',
        //     'nama.required' => 'Nama harus di isi',
        // ]
      );
      if ($validated) {
        // $tbtipe->fill($request->all());
        // $tbtipe->aktif = $request->aktif == 'on' ? 'Y' : 'N';
        // $tbtipe->user = $request->username . date('d-m-Y');
        $aktif = isset($request->aktif) ? 'Y' : 'N';
        $tbtipe->fill([
          'nama' => $request->nama,
          'kode' => $request->kode,
          'kdmodel' => isset($request->kdmodel) ? $request->kdmodel : '',
          'aktif' => $aktif,
          'user' => 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s'),
        ]);
        $tbtipe->save($validated);
        $msg = [
          'sukses' => 'Data berhasil di tambah', //view('tbtipe.tabel_model')
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
        'submenu' => 'tbtipe',
        'submenu1' => 'ref_kendaraan',
        'title' => 'Detail Tabel Tipe Kendaraan',
        'tbtipe' => Tbtipe::findOrFail($id),
        'userdtl' => Userdtl::where('cmodule', 'Tabel Tipe Kendaraan')->where('username', $username)->first(),
      ];
      // return view('tbtipe.modaldetail')->with($data);
      return response()->json([
        'body' => view('tbtipe.modaltambah', [
          'tbtipe' => Tbtipe::findOrFail($id),
          'action' => route('tbtipe.store'),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function edit(Tbtipe $tbtipe, Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        'menu' => 'file',
        'submenu' => 'tbtipe',
        'submenu1' => 'ref_kendaraan',
        'title' => 'Edit Data Tabel Tipe Kendaraan',
      ];
      return response()->json([
        'body' => view('tbtipe.modaltambah', [
          'tbtipe' => $tbtipe,
          'action' => route('tbtipe.update', $tbtipe->id),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function update(TbtipeRequest $request, Tbtipe $tbtipe)
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
          //     'kode' => 'required|unique:tbtipe,kode',
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
        $tbtipe->fill([
          'nama' => $request->nama,
          'kode' => $request->kode,
          'kdmodel' => isset($request->kdmodel) ? $request->kdmodel : '',
          'aktif' => $aktif,
          'user' => 'Update-' . $request->username . ', ' . date('d-m-Y h:i:s'),
        ]);
        $tbtipe->save($validated);
        $msg = [
          'sukses' => 'Data berhasil di update', //view('tbtipe.tabel_model')
        ];
      } else {
        $msg = [
          'sukses' => 'Data gagal di update', //view('tbtipe.tabel_model')
        ];
      }
      echo json_encode($msg);
      // return redirect()->back()->with('message', 'Berhasil di update');
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function ambildatatbmodel(Request $request, Tbmodel $tbmodel)
  {
    if ($request->Ajax()) {
      $kdmerek = isset($request->kdmerek) ? $request->kdmerek : '';
      $kdmodel = $request->kdmodel;
      if ($kdmerek == '') {
        $datatbmodel = $tbmodel->orderBy('kode')->get();
      } else {
        $datatbmodel = $tbmodel->where('kdmerek', $kdmerek)->orderBy('kode')->get();
      }
      $isidata = "<option value='' selected>[Pilih Model]</option>";
      foreach ($datatbmodel as $row) {
        if ($row['kode'] == $kdmodel) {
          $isidata .= '<option value="' . $row['kode'] . '" selected>' . $row['nama'] .  ' </option>';
        } else {
          $isidata .= '<option value="' . $row['kode'] . '">' . $row['nama'] . '</option>';
        }
      }
      $msg = [
        'data' => $isidata
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function ambildatatbtipe(Request $request, Tbtipe $tbtipe)
  {
    if ($request->Ajax()) {
      $kdmodel = isset($request->kdmodel) ? $request->kdmodel : '';
      $kdtipe = $request->kdtipe;
      if ($kdmodel == '') {
        $datatbtipe = $tbtipe->orderBy('kode')->get();
      } else {
        $datatbtipe = $tbtipe->where('kdmodel', $kdmodel)->orderBy('kode')->get();
      }
      $isidata = "<option value='' selected>[Pilih Tipe]</option>";
      foreach ($datatbtipe as $row) {
        if ($row['kode'] == $kdtipe) {
          $isidata .= '<option value="' . $row['kode'] . '" selected>' . $row['nama'] .  ' </option>';
        } else {
          $isidata .= '<option value="' . $row['kode'] . '">' . $row['nama'] . '</option>';
        }
      }
      $msg = [
        'data' => $isidata
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function destroy(Tbtipe $tbtipe, Request $request)
  {
    if ($request->Ajax()) {
      $tbtipe->delete();
      return response()->json([
        'sukses' => 'Data berhasil di hapus',
      ]);
      // return redirect()->back()->with('message', 'Berhasil di hapus');
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
}
