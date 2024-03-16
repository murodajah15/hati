<?php

namespace App\Http\Controllers;

use App\Http\Requests\TbmodelRequest;
use Illuminate\Http\Request;
use Session;
// use Yajra\DataTables\Contracts\DataTables;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Tbmodel;
use App\Models\Userdtl;
use App\Models\Tbmerek;

// //return type View
// use Illuminate\View\View;

class TbmodelController extends Controller
{
  public function index(Request $request) //: View
  {
    $username = session('username');
    $userdtl = Userdtl::where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get();
    $data = [
      'menu' => 'file',
      'submenu' => 'tbmodel',
      'submenu1' => 'ref_kendaraan',
      'title' => 'Tabel Model Kendaraan',
      // 'tbmodel' => Tbmodel::all(),
      // 'userdtlmenu' => Userdtl::join('tbmodule', 'userdtl.cmodule', '=', 'tbmodule.cmodule')->where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
      'userdtlmenu' => $userdtl,
      'userdtl' => Userdtl::where('cmodule', 'Tabel Model Kendaraan')->where('username', $username)->first(),
    ];
    // var_dump($data);
    return view('tbmodel.index')->with($data);
  }
  public function tbmodelajax(Request $request) //: View
  {
    if ($request->ajax()) {
      // $data = Tbmodel::select('*'); //->orderBy('kode', 'asc');
      $data = Tbmodel::select('tbmodel.*', 'tbmerek.nama as nmmerek')->leftjoin('tbmerek', 'tbmerek.kode', '=', 'tbmodel.kdmerek'); //->orderBy('kode', 'asc');
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
      return view('tbmodel');
    }
  }

  public function tabel_model(Request $request)
  {
    $data = [
      'menu' => 'file',
      'submenu' => 'tbmodel',
      'submenu1' => 'ref_kendaraan',
      'title' => 'Tabel Model Kendaraan',
      'tbmodel' => Tbmodel::orderBy('kode', 'asc')->get(),
    ];
    // var_dump($data);
    return view('tbmodel.tabel_model')->with($data);
  }

  public function create(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        'menu' => 'file',
        'submenu' => 'tbmodel',
        'submenu1' => 'ref_kendaraan',
        'title' => 'Tambah Data Tabel Model Kendaraan',
        // 'tbmodel' => Tbmodel::all(),
      ];
      // var_dump($data);
      return response()->json([
        'body' => view('tbmodel.modaltambah', [
          'tbmodel' => new Tbmodel(), //Tbmodel::first(),
          'action' => route('tbmodel.store'),
          'vdata' => $data,
        ])->render(),
        'data' => $data,

      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function store(TbmodelRequest $request, Tbmodel $tbmodel)
  {
    if ($request->Ajax()) {
      $validated = $request->validated(
        // [
        //     'kode' => 'required|unique:tbmodel,kode',
        //     'nama' => 'required',
        // ],
        // [
        //     'kode.unique' => 'Kode tidak boleh sama',
        //     'kode.required' => 'Kode harus di isi',
        //     'nama.required' => 'Nama harus di isi',
        // ]
      );
      if ($validated) {
        // $tbmodel->fill($request->all());
        // $tbmodel->aktif = $request->aktif == 'on' ? 'Y' : 'N';
        // $tbmodel->user = $request->username . date('d-m-Y');
        $aktif = isset($request->aktif) ? 'Y' : 'N';
        $tbmodel->fill([
          'nama' => $request->nama,
          'kode' => $request->kode,
          'kdmerek' => isset($request->kdmerek) ? $request->kdmerek : '',
          'aktif' => $aktif,
          'user' => 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s'),
        ]);
        $tbmodel->save($validated);
        $msg = [
          'sukses' => 'Data berhasil di tambah', //view('tbmodel.tabel_model')
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
        'submenu' => 'tbmodel',
        'submenu1' => 'ref_kendaraan',
        'title' => 'Detail Tabel Model Kendaraan',
        'tbmodel' => Tbmodel::findOrFail($id),
        'userdtl' => Userdtl::where('cmodule', 'Tabel Model Kendaraan')->where('username', $username)->first(),
      ];
      // return view('tbmodel.modaldetail')->with($data);
      return response()->json([
        'body' => view('tbmodel.modaltambah', [
          'tbmodel' => Tbmodel::findOrFail($id),
          'action' => route('tbmodel.store'),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function edit(Tbmodel $tbmodel, Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        'menu' => 'file',
        'submenu' => 'tbmodel',
        'submenu1' => 'ref_kendaraan',
        'title' => 'Edit Data Tabel Model Kendaraan',
      ];
      return response()->json([
        'body' => view('tbmodel.modaltambah', [
          'tbmodel' => $tbmodel,
          'action' => route('tbmodel.update', $tbmodel->id),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function update(TbmodelRequest $request, Tbmodel $tbmodel)
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
          //     'kode' => 'required|unique:tbmodel,kode',
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
        $tbmodel->fill([
          'nama' => $request->nama,
          'kode' => $request->kode,
          'kdmerek' => isset($request->kdmerek) ? $request->kdmerek : '',
          'aktif' => $aktif,
          'user' => 'Update-' . $request->username . ', ' . date('d-m-Y h:i:s'),
        ]);
        $tbmodel->save($validated);
        $msg = [
          'sukses' => 'Data berhasil di update', //view('tbmodel.tabel_model')
        ];
      } else {
        $msg = [
          'sukses' => 'Data gagal di update', //view('tbmodel.tabel_model')
        ];
      }
      echo json_encode($msg);
      // return redirect()->back()->with('message', 'Berhasil di update');
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function ambildatatbmerek(Request $request, Tbmerek $tbmerek)
  {
    if ($request->Ajax()) {
      $kdmerek = $request->kdmerek;
      $datatbmerek = $tbmerek->orderBy('kode')->get();
      $isidata = "<option value='' selected>[Pilih Merek]</option>";
      foreach ($datatbmerek as $row) {
        if ($row['kode'] == $kdmerek) {
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

  public function destroy(Tbmodel $tbmodel, Request $request)
  {
    if ($request->Ajax()) {
      $tbmodel->delete();
      return response()->json([
        'sukses' => 'Data berhasil di hapus',
      ]);
      // return redirect()->back()->with('message', 'Berhasil di hapus');
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
}
