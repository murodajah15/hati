<?php

namespace App\Http\Controllers;

use App\Http\Requests\TbleasingRequest;
use Illuminate\Http\Request;
use Session;
// use Yajra\DataTables\Contracts\DataTables;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Tbleasing;
use App\Models\Userdtl;

// //return type View
// use Illuminate\View\View;

class TbleasingController extends Controller
{
  public function index(Request $request) //: View
  {
    $username = session('username');
    $data = [
      'menu' => 'file',
      'submenu' => 'tbleasing',
      'submenu1' => 'ref_umum',
      'title' => 'Tabel Leasing',
      // 'tbleasing' => Tbleasing::all(),
      'userdtlmenu' => Userdtl::join('tbmodule', 'userdtl.cmodule', '=', 'tbmodule.cmodule')->where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
      'userdtl' => Userdtl::where('cmodule', 'Tabel Leasing')->where('username', $username)->first(),
    ];
    // var_dump($data);
    return view('tbleasing.index')->with($data);
  }
  public function tbleasingajax(Request $request) //: View
  {
    if ($request->ajax()) {
      $data = Tbleasing::select('*'); //->orderBy('kode', 'asc');
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
      return view('tbleasing');
    }
  }

  public function tabel_leasing(Request $request)
  {
    $data = [
      'menu' => 'file',
      'submenu' => 'tbleasing',
      'submenu1' => 'ref_umum',
      'title' => 'Tabel Leasing',
      'tbleasing' => Tbleasing::orderBy('kode', 'asc')->get(),
    ];
    // var_dump($data);
    return view('tbleasing.tabel_leasing')->with($data);
  }

  public function create(Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        'menu' => 'file',
        'submenu' => 'tbleasing',
        'submenu1' => 'ref_umum',
        'title' => 'Tambah Data Tabel leasing',
      ];
      // var_dump($data);
      return response()->json([
        'body' => view('tbleasing.modaltambah', [
          'tbleasing' => new Tbleasing(), //Tbleasing::first(),
          'action' => route('tbleasing.store'),
          'vdata' => $data,
        ])->render(),
        'data' => $data,

      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function store(TbleasingRequest $request, Tbleasing $tbleasing)
  {
    if ($request->Ajax()) {
      $validated = $request->validated(
        // [
        //     'kode' => 'required|unique:tbleasing,kode',
        //     'nama' => 'required',
        // ],
        // [
        //     'kode.unique' => 'Kode tidak boleh sama',
        //     'kode.required' => 'Kode harus di isi',
        //     'nama.required' => 'Nama harus di isi',
        // ]
      );
      if ($validated) {
        $aktif = isset($request->aktif) ? 'Y' : 'N';
        $tbleasing->fill([
          'kode' => isset($request->kode) ? $request->kode : '',
          'nama' => isset($request->nama) ? $request->nama : '',
          'alamat' => isset($request->alamat) ? $request->alamat : '',
          'kota' => isset($request->kota) ? $request->kota : '',
          'email' => isset($request->email) ? $request->email : '',
          'telp' => isset($request->telp) ? $request->telp : '',
          'fax' => isset($request->fax) ? $request->fax : '',
          'npwp' => isset($request->npwp) ? $request->npwp : '',
          'nama_npwp' => isset($request->nama_npwp) ? $request->nama_npwp : '',
          'alamat_npwp' => isset($request->alamat_npwp) ? $request->alamat_npwp : '',
          'nppkp' => isset($request->nppkp) ? $request->nppkp : '',
          'contact_person' => isset($request->contact_person) ? $request->contact_person : '',
          'no_contact_person' => isset($request->no_contact_person) ? $request->no_contact_person : '',
          'top' => isset($request->top) ? $request->top : '',
          'kredit_limit' => isset($request->kredit_limit) ? $request->kredit_limit : '',
          'disc_part' => isset($request->disc_part) ? $request->disc_part : '',
          'disc_jasa' => isset($request->disc_jasa) ? $request->disc_jasa : '',
          'disc_bahan' => isset($request->disc_bahan) ? $request->disc_bahan : '',
          'pph_jasa' => isset($request->pph_jasa) ? $request->pph_jasa : '',
          'pph_material' => isset($request->pph_material) ? $request->pph_material : '',
          'aktif' => $aktif,
          'user' => 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s'),
        ]);
        $tbleasing->save($validated);
        $msg = [
          'sukses' => 'Data berhasil di tambah', //view('tbleasing.tabel_leasing')
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
        'submenu' => 'tbleasing',
        'submenu1' => 'ref_umum',
        'title' => 'Detail Tabel leasing',
        'tbleasing' => Tbleasing::findOrFail($id),
        'userdtl' => Userdtl::where('cmodule', 'Tabel Leasing')->where('username', $username)->first(),
      ];
      // return view('tbleasing.modaldetail')->with($data);
      return response()->json([
        'body' => view('tbleasing.modaltambah', [
          'tbleasing' => Tbleasing::findOrFail($id),
          'action' => route('tbleasing.store'),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function edit(Tbleasing $tbleasing, Request $request)
  {
    if ($request->Ajax()) {
      $data = [
        'menu' => 'file',
        'submenu' => 'tbleasing',
        'submenu1' => 'ref_umum',
        'title' => 'Edit Data Tabel leasing',
      ];
      return response()->json([
        'body' => view('tbleasing.modaltambah', [
          'tbleasing' => $tbleasing,
          'action' => route('tbleasing.update', $tbleasing->id),
          'vdata' => $data,
        ])->render(),
        'data' => $data,
      ]);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function update(TbleasingRequest $request, Tbleasing $tbleasing)
  {
    if ($request->Ajax()) {
      $validated = $request->validated();
      if ($validated) {
        $aktif = $request->aktif == 'on' ? 'Y' : 'N';
        $tbleasing->fill([
          'kode' => isset($request->kode) ? $request->kode : '',
          'nama' => isset($request->nama) ? $request->nama : '',
          'alamat' => isset($request->alamat) ? $request->alamat : '',
          'kota' => isset($request->kota) ? $request->kota : '',
          'email' => isset($request->email) ? $request->email : '',
          'telp' => isset($request->telp) ? $request->telp : '',
          'fax' => isset($request->fax) ? $request->fax : '',
          'npwp' => isset($request->npwp) ? $request->npwp : '',
          'nama_npwp' => isset($request->nama_npwp) ? $request->nama_npwp : '',
          'alamat_npwp' => isset($request->alamat_npwp) ? $request->alamat_npwp : '',
          'nppkp' => isset($request->nppkp) ? $request->nppkp : '',
          'contact_person' => isset($request->contact_person) ? $request->contact_person : '',
          'no_contact_person' => isset($request->no_contact_person) ? $request->no_contact_person : '',
          'top' => isset($request->top) ? $request->top : '',
          'kredit_limit' => isset($request->kredit_limit) ? $request->kredit_limit : '',
          'disc_part' => isset($request->disc_part) ? $request->disc_part : '',
          'disc_jasa' => isset($request->disc_jasa) ? $request->disc_jasa : '',
          'disc_bahan' => isset($request->disc_bahan) ? $request->disc_bahan : '',
          'pph_jasa' => isset($request->pph_jasa) ? $request->pph_jasa : '',
          'pph_material' => isset($request->pph_material) ? $request->pph_material : '',
          'aktif' => $aktif,
          'user' => 'Update-' . $request->username . ', ' . date('d-m-Y h:i:s'),
        ]);
        $tbleasing->save($validated);
        $msg = [
          'sukses' => 'Data berhasil di update', //view('tbleasing.tabel_leasing')
        ];
      } else {
        $msg = [
          'sukses' => 'Data gagal di update', //view('tbleasing.tabel_leasing')
        ];
      }
      echo json_encode($msg);
      // return redirect()->back()->with('message', 'Berhasil di update');
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function destroy(Tbleasing $tbleasing, Request $request)
  {
    if ($request->Ajax()) {
      $tbleasing->delete();
      return response()->json([
        'sukses' => 'Data berhasil di hapus',
      ]);
      // return redirect()->back()->with('message', 'Berhasil di hapus');
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
}
