<?php

namespace App\Http\Controllers;

use App\Http\Requests\TbbankRequest;
use Illuminate\Http\Request;
use Session;
// use Yajra\DataTables\Contracts\DataTables;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Tbbank;
use App\Models\Userdtl;

// //return type View
// use Illuminate\View\View;

class TbbankController extends Controller
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
            'submenu' => 'tbbank',
            'submenu1' => 'ref_umum',
            'title' => 'Tabel Bank',
            // 'tbbank' => Tbbank::all(),
            // 'userdtlmenu' => Userdtl::where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
            // 'userdtlmenu' => Userdtl::join('tbmodule', 'userdtl.cmodule', '=', 'tbmodule.cmodule')->where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
            'userdtlmenu' => $userdtl,
            'userdtl' => Userdtl::where('cmodule', 'Tabel Bank')->where('username', $username)->first(),
        ];
        // dd($data);
        return view('tbbank.index')->with($data);
    }
    public function tbbankajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $data = Tbbank::select('*'); //->orderBy('kode', 'asc');
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
            return view('tbbank');
        }
    }

    public function tabel_bank(Request $request)
    {
        $data = [
            'menu' => 'file',
            'submenu' => 'tbbank',
            'submenu1' => 'ref_umum',
            'title' => 'Tabel Bank',
            'tbbank' => Tbbank::orderBy('kode', 'asc')->get(),
        ];
        // var_dump($data);
        return view('tbbank.tabel_bank')->with($data);
    }

    public function create(Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'file',
                'submenu' => 'tbbank',
                'submenu1' => 'ref_umum',
                'title' => 'Tambah Data Tabel Bank',
                // 'tbbank' => Tbbank::all(),
            ];
            // var_dump($data);
            return response()->json([
                'body' => view('tbbank.modaltambah', [
                    'tbbank' => new Tbbank(), //Tbbank::first(),
                    'action' => route('tbbank.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,

            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function store(TbbankRequest $request, Tbbank $tbbank)
    {
        if ($request->Ajax()) {
            $validated = $request->validated(
                // [
                //     'kode' => 'required|unique:tbbank,kode',
                //     'nama' => 'required',
                // ],
                // [
                //     'kode.unique' => 'Kode tidak boleh sama',
                //     'kode.required' => 'Kode harus di isi',
                //     'nama.required' => 'Nama harus di isi',
                // ]
            );
            if ($validated) {
                // $tbbank->fill($request->all());
                // $tbbank->aktif = $request->aktif == 'on' ? 'Y' : 'N';
                // $tbbank->user = $request->username . date('d-m-Y');
                $aktif = isset($request->aktif) ? 'Y' : 'N';
                $tbbank->fill([
                    'kode' => isset($request->kode) ? $request->kode : '',
                    'nama' => isset($request->nama) ? $request->nama : '',
                    'aktif' => $aktif,
                    'user' => 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $tbbank->save($validated);
                $msg = [
                    'sukses' => 'Data berhasil di tambah', //view('tbbank.tabel_bank')
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
                'submenu' => 'tbbank',
                'submenu1' => 'ref_umum',
                'title' => 'Detail Tabel Bank',
                'tbbank' => Tbbank::findOrFail($id),
                'userdtl' => Userdtl::where('cmodule', 'Tabel Bank')->where('username', $username)->first(),
            ];
            // return view('tbbank.modaldetail')->with($data);
            return response()->json([
                'body' => view('tbbank.modaltambah', [
                    'tbbank' => Tbbank::findOrFail($id),
                    'action' => route('tbbank.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function edit(Tbbank $tbbank, Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'file',
                'submenu' => 'tbbank',
                'submenu1' => 'ref_umum',
                'title' => 'Edit Data Tabel Bank',
            ];
            return response()->json([
                'body' => view('tbbank.modaltambah', [
                    'tbbank' => $tbbank,
                    'action' => route('tbbank.update', $tbbank->id),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function update(TbbankRequest $request, Tbbank $tbbank)
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
                    //     'kode' => 'required|unique:tbbank,kode',
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
                $tbbank->fill([
                    'kode' => isset($request->kode) ? $request->kode : '',
                    'nama' => isset($request->nama) ? $request->nama : '',
                    'aktif' => $aktif,
                    'user' => 'Update-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $tbbank->save($validated);
                $msg = [
                    'sukses' => 'Data berhasil di update', //view('tbbank.tabel_bank')
                ];
            } else {
                $msg = [
                    'sukses' => 'Data gagal di update', //view('tbbank.tabel_bank')
                ];
            }
            echo json_encode($msg);
            // return redirect()->back()->with('message', 'Berhasil di update');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function destroy(Tbbank $tbbank, Request $request)
    {
        if ($request->Ajax()) {
            $tbbank->delete();
            return response()->json([
                'sukses' => 'Data berhasil di hapus',
            ]);
            // return redirect()->back()->with('message', 'Berhasil di hapus');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
}
