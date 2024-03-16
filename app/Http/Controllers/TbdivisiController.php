<?php

namespace App\Http\Controllers;

use App\Http\Requests\TbdivisiRequest;
use Illuminate\Http\Request;
use Session;
// use Yajra\DataTables\Contracts\DataTables;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Tbdivisi;
use App\Models\Userdtl;

// //return type View
// use Illuminate\View\View;

class TbdivisiController extends Controller
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
            'submenu' => 'tbdivisi',
            'submenu1' => 'ref_umum',
            'title' => 'Tabel Divisi',
            // 'tbdivisi' => Tbdivisi::all(),
            // 'userdtlmenu' => Userdtl::where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
            // 'userdtlmenu' => Userdtl::join('tbmodule', 'userdtl.cmodule', '=', 'tbmodule.cmodule')->where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
            'userdtlmenu' => $userdtl,
            // 'userdtl' => Userdtl::where('cmodule', 'Tabel Divisi')->where('username', $username)->first(),
        ];
        // dd($data);
        return view('tbdivisi.index')->with($data);
    }
    public function tbdivisiajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $data = Tbdivisi::select('*'); //->orderBy('kode', 'asc');
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
            return view('tbdivisi');
        }
    }

    public function tabel_divisi(Request $request)
    {
        $data = [
            'menu' => 'file',
            'submenu' => 'tbdivisi',
            'submenu1' => 'ref_umum',
            'title' => 'Tabel Divisi',
            'tbdivisi' => Tbdivisi::orderBy('kode', 'asc')->get(),
        ];
        // var_dump($data);
        return view('tbdivisi.tabel_divisi')->with($data);
    }

    public function create(Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'file',
                'submenu' => 'tbdivisi',
                'submenu1' => 'ref_umum',
                'title' => 'Tambah Data Tabel Divisi',
                // 'tbdivisi' => Tbdivisi::all(),
            ];
            // var_dump($data);
            return response()->json([
                'body' => view('tbdivisi.modaltambah', [
                    'tbdivisi' => new Tbdivisi(), //Tbdivisi::first(),
                    'action' => route('tbdivisi.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,

            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function store(TbdivisiRequest $request, Tbdivisi $tbdivisi)
    {
        if ($request->Ajax()) {
            $validated = $request->validated(
                // [
                //     'kode' => 'required|unique:tbdivisi,kode',
                //     'nama' => 'required',
                // ],
                // [
                //     'kode.unique' => 'Kode tidak boleh sama',
                //     'kode.required' => 'Kode harus di isi',
                //     'nama.required' => 'Nama harus di isi',
                // ]
            );
            if ($validated) {
                // $tbdivisi->fill($request->all());
                // $tbdivisi->aktif = $request->aktif == 'on' ? 'Y' : 'N';
                // $tbdivisi->user = $request->username . date('d-m-Y');
                $aktif = isset($request->aktif) ? 'Y' : 'N';
                $tbdivisi->fill([
                    'nama' => $request->nama,
                    'kode' => $request->kode,
                    'aktif' => $aktif,
                    'user' => 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $tbdivisi->save($validated);
                $msg = [
                    'sukses' => 'Data berhasil di tambah', //view('tbdivisi.tabel_divisi')
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
                'submenu' => 'tbdivisi',
                'submenu1' => 'ref_umum',
                'title' => 'Detail Tabel Divisi',
                'tbdivisi' => Tbdivisi::findOrFail($id),
                'userdtl' => Userdtl::where('cmodule', 'Tabel Divisi')->where('username', $username)->first(),
            ];
            // return view('tbdivisi.modaldetail')->with($data);
            return response()->json([
                'body' => view('tbdivisi.modaltambah', [
                    'tbdivisi' => Tbdivisi::findOrFail($id),
                    'action' => route('tbdivisi.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function edit(Tbdivisi $tbdivisi, Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'file',
                'submenu' => 'tbdivisi',
                'submenu1' => 'ref_umum',
                'title' => 'Edit Data Tabel Divisi',
            ];
            return response()->json([
                'body' => view('tbdivisi.modaltambah', [
                    'tbdivisi' => $tbdivisi,
                    'action' => route('tbdivisi.update', $tbdivisi->id),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function update(TbdivisiRequest $request, Tbdivisi $tbdivisi)
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
                    //     'kode' => 'required|unique:tbdivisi,kode',
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
                $tbdivisi->fill([
                    'nama' => $request->nama,
                    'kode' => $request->kode,
                    'aktif' => $aktif,
                    'user' => 'Update-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $tbdivisi->save($validated);
                $msg = [
                    'sukses' => 'Data berhasil di update', //view('tbdivisi.tabel_divisi')
                ];
            } else {
                $msg = [
                    'sukses' => 'Data gagal di update', //view('tbdivisi.tabel_divisi')
                ];
            }
            echo json_encode($msg);
            // return redirect()->back()->with('message', 'Berhasil di update');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function destroy(Tbdivisi $tbdivisi, Request $request)
    {
        if ($request->Ajax()) {
            $tbdivisi->delete();
            return response()->json([
                'sukses' => 'Data berhasil di hapus',
            ]);
            // return redirect()->back()->with('message', 'Berhasil di hapus');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
}
