<?php

namespace App\Http\Controllers;

use App\Http\Requests\TbmekanikRequest;
use Illuminate\Http\Request;
use Session;
// use Yajra\DataTables\Contracts\DataTables;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Tbmekanik;
use App\Models\Userdtl;

// //return type View
// use Illuminate\View\View;

class tbmekanikController extends Controller
{
    public function index(Request $request) //: View
    {
        $username = session('username');
        $data = [
            'menu' => 'file',
            'submenu' => 'tbmekanik',
            'submenu1' => 'ref_bengkel',
            'title' => 'Tabel Mekanik',
            // 'tbmekanik' => Tbmekanik::all(),
            'userdtlmenu' => Userdtl::join('tbmodule', 'userdtl.cmodule', '=', 'tbmodule.cmodule')->where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
            'userdtl' => Userdtl::where('cmodule', 'Tabel Mekanik')->where('username', $username)->first(),
        ];
        // var_dump($data);
        return view('tbmekanik.index')->with($data);
    }
    public function tbmekanikajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $data = Tbmekanik::select('*'); //->orderBy('kode', 'asc');
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
            return view('tbmekanik');
        }
    }

    public function tabel_sa(Request $request)
    {
        $data = [
            'menu' => 'file',
            'submenu' => 'tbmekanik',
            'submenu1' => 'ref_bengkel',
            'title' => 'Tabel Mekanik',
            'tbmekanik' => Tbmekanik::orderBy('kode', 'asc')->get(),
        ];
        // var_dump($data);
        return view('tbmekanik.tabel_sa')->with($data);
    }

    public function create(Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'file',
                'submenu' => 'tbmekanik',
                'submenu1' => 'ref_bengkel',
                'title' => 'Tambah Data Tabel Mekanik',
                'tbmekanik' => Tbmekanik::all(),
            ];
            // var_dump($data);
            return response()->json([
                'body' => view('tbmekanik.modaltambah', [
                    'tbmekanik' => new tbmekanik(), //Tbmekanik::first(),
                    'action' => route('tbmekanik.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,

            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function store(tbmekanikRequest $request, tbmekanik $tbmekanik)
    {
        if ($request->Ajax()) {
            $validated = $request->validated(
                // [
                //     'kode' => 'required|unique:tbmekanik,kode',
                //     'nama' => 'required',
                // ],
                // [
                //     'kode.unique' => 'Kode tidak boleh sama',
                //     'kode.required' => 'Kode harus di isi',
                //     'nama.required' => 'Nama harus di isi',
                // ]
            );
            if ($validated) {
                // $tbmekanik->fill($request->all());
                // $tbmekanik->aktif = $request->aktif == 'on' ? 'Y' : 'N';
                // $tbmekanik->user = $request->username . date('d-m-Y');
                $aktif = isset($request->aktif) ? 'Y' : 'N';
                $tbmekanik->fill([
                    'nama' => $request->nama,
                    'kode' => $request->kode,
                    'alamat' => $request->alamat,
                    'kelurahan' => $request->kelurahan,
                    'kecamatan' => $request->kecamatan,
                    'kota' => $request->kota,
                    'provinsi' => $request->provinsi,
                    'kodepos' => $request->kodepos,
                    'telp1' => $request->telp1,
                    'kategori' => $request->kategori,
                    'tgl_register' => $request->tgl_register,
                    'aktif' => $aktif,
                    'user' => 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $tbmekanik->save($validated);
                $msg = [
                    'sukses' => 'Data berhasil di tambah', //view('tbmekanik.tabel_sa')
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
                'submenu' => 'tbmekanik',
                'submenu1' => 'ref_bengkel',
                'title' => 'Detail Tabel Mekanik',
                'tbmekanik' => Tbmekanik::findOrFail($id),
                'userdtl' => Userdtl::where('cmodule', 'Tabel Mekanik')->where('username', $username)->first(),
            ];
            // return view('tbmekanik.modaldetail')->with($data);
            return response()->json([
                'body' => view('tbmekanik.modaltambah', [
                    'tbmekanik' => Tbmekanik::findOrFail($id),
                    'action' => route('tbmekanik.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function edit(tbmekanik $tbmekanik, Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'file',
                'submenu' => 'tbmekanik',
                'submenu1' => 'ref_bengkel',
                'title' => 'Edit Data Tabel Mekanik',
            ];
            return response()->json([
                'body' => view('tbmekanik.modaltambah', [
                    'tbmekanik' => $tbmekanik,
                    'action' => route('tbmekanik.update', $tbmekanik->id),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function update(tbmekanikRequest $request, tbmekanik $tbmekanik)
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
                    //     'kode' => 'required|unique:tbmekanik,kode',
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
                $tbmekanik->fill([
                    'nama' => $request->nama,
                    'kode' => $request->kode,
                    'alamat' => $request->alamat,
                    'kelurahan' => $request->kelurahan,
                    'kecamatan' => $request->kecamatan,
                    'kota' => $request->kota,
                    'provinsi' => $request->provinsi,
                    'kodepos' => $request->kodepos,
                    'telp1' => $request->telp1,
                    'kategori' => $request->kategori,
                    'tgl_register' => $request->tgl_register,
                    'aktif' => $aktif,
                    'user' => 'Update-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $tbmekanik->save($validated);
                $msg = [
                    'sukses' => 'Data berhasil di update', //view('tbmekanik.tabel_sa')
                ];
            } else {
                $msg = [
                    'sukses' => 'Data gagal di update', //view('tbmekanik.tabel_sa')
                ];
            }
            echo json_encode($msg);
            // return redirect()->back()->with('message', 'Berhasil di update');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function destroy(tbmekanik $tbmekanik, Request $request)
    {
        if ($request->Ajax()) {
            $tbmekanik->delete();
            return response()->json([
                'sukses' => 'Data berhasil di hapus',
            ]);
            // return redirect()->back()->with('message', 'Berhasil di hapus');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
}
