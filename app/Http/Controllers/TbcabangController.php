<?php

namespace App\Http\Controllers;

use App\Http\Requests\TbcabangRequest;
use Illuminate\Http\Request;
use Session;
// use Yajra\DataTables\Contracts\DataTables;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Tbcabang;
use App\Models\Userdtl;

// //return type View
// use Illuminate\View\View;

class TbcabangController extends Controller
{
    public function index(Request $request) //: View
    {
        $username = session('username');
        $userdtl = Userdtl::where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get();
        $userdtlX = Userdtl::select(
            'tbmodule.cmodule',
            'tbmodule.cmenu',
            'tbmodule.clain',
            'tbmodule.cparent',
            'tbmodule.cmainmenu',
            'tbmodule.nlevel',
            'tbmodule.nurut',
            'userdtl.pakai',
            'userdtl.tambah',
            'userdtl.edit',
            'userdtl.hapus',
            'userdtl.proses',
            'userdtl.unproses',
            'userdtl.cetak',
        )->join('tbmodule', 'tbmodule.cmodule', '=', 'userdtl.cmodule')->where('userdtl.pakai', '1')->where('userdtl.username', $username)->orderBy('userdtl.nurut')->get();
        $data = [
            'menu' => 'file',
            'submenu' => 'tbcabang',
            'submenu1' => 'ref_umum',
            'title' => 'Tabel Cabang',
            // 'tbcabang' => Tbcabang::all(),
            // 'userdtlmenu' => Userdtl::where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
            // 'userdtlmenu' => Userdtl::join('tbmodule', 'userdtl.cmodule', '=', 'tbmodule.cmodule')->where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
            'userdtlmenu' => $userdtl,
            // 'userdtl' => Userdtl::where('cmodule', 'Tabel Cabang')->where('username', $username)->first(),
        ];
        // dd($data);
        return view('tbcabang.index')->with($data);
    }
    public function tbcabangajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $data = Tbcabang::select('*'); //->orderBy('kode', 'asc');
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
            return view('tbcabang');
        }
    }

    public function tabel_cabang(Request $request)
    {
        $data = [
            'menu' => 'file',
            'submenu' => 'tbcabang',
            'submenu1' => 'ref_umum',
            'title' => 'Tabel Cabang',
            'tbcabang' => Tbcabang::orderBy('kode', 'asc')->get(),
        ];
        // var_dump($data);
        return view('tbcabang.tabel_cabang')->with($data);
    }

    public function create(Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'file',
                'submenu' => 'tbcabang',
                'submenu1' => 'ref_umum',
                'title' => 'Tambah Data Tabel Cabang',
                // 'tbcabang' => Tbcabang::all(),
            ];
            // var_dump($data);
            return response()->json([
                'body' => view('tbcabang.modaltambah', [
                    'tbcabang' => new Tbcabang(), //Tbcabang::first(),
                    'action' => route('tbcabang.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,

            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function store(TbcabangRequest $request, Tbcabang $tbcabang)
    {
        if ($request->Ajax()) {
            $validated = $request->validated(
                // [
                //     'kode' => 'required|unique:tbcabang,kode',
                //     'nama' => 'required',
                // ],
                // [
                //     'kode.unique' => 'Kode tidak boleh sama',
                //     'kode.required' => 'Kode harus di isi',
                //     'nama.required' => 'Nama harus di isi',
                // ]
            );
            if ($validated) {
                // $tbcabang->fill($request->all());
                // $tbcabang->aktif = $request->aktif == 'on' ? 'Y' : 'N';
                // $tbcabang->user = $request->username . date('d-m-Y');
                $aktif = isset($request->aktif) ? 'Y' : 'N';
                $tbcabang->fill([
                    'nama' => $request->nama,
                    'kode' => $request->kode,
                    'aktif' => $aktif,
                    'user' => 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $tbcabang->save($validated);
                $msg = [
                    'sukses' => 'Data berhasil di tambah', //view('tbcabang.tabel_cabang')
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
                'submenu' => 'tbcabang',
                'submenu1' => 'ref_umum',
                'title' => 'Detail Tabel Cabang',
                'tbcabang' => Tbcabang::findOrFail($id),
                'userdtl' => Userdtl::where('cmodule', 'Tabel Cabang')->where('username', $username)->first(),
            ];
            // return view('tbcabang.modaldetail')->with($data);
            return response()->json([
                'body' => view('tbcabang.modaltambah', [
                    'tbcabang' => Tbcabang::findOrFail($id),
                    'action' => route('tbcabang.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function edit(Tbcabang $tbcabang, Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'file',
                'submenu' => 'tbcabang',
                'submenu1' => 'ref_umum',
                'title' => 'Edit Data Tabel Cabang',
            ];
            return response()->json([
                'body' => view('tbcabang.modaltambah', [
                    'tbcabang' => $tbcabang,
                    'action' => route('tbcabang.update', $tbcabang->id),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function update(TbcabangRequest $request, Tbcabang $tbcabang)
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
                    //     'kode' => 'required|unique:tbcabang,kode',
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
                $tbcabang->fill([
                    'nama' => $request->nama,
                    'kode' => $request->kode,
                    'aktif' => $aktif,
                    'user' => 'Update-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $tbcabang->save($validated);
                $msg = [
                    'sukses' => 'Data berhasil di update', //view('tbcabang.tabel_cabang')
                ];
            } else {
                $msg = [
                    'sukses' => 'Data gagal di update', //view('tbcabang.tabel_cabang')
                ];
            }
            echo json_encode($msg);
            // return redirect()->back()->with('message', 'Berhasil di update');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function destroy(Tbcabang $tbcabang, Request $request)
    {
        if ($request->Ajax()) {
            $tbcabang->delete();
            return response()->json([
                'sukses' => 'Data berhasil di hapus',
            ]);
            // return redirect()->back()->with('message', 'Berhasil di hapus');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
}
