<?php

namespace App\Http\Controllers;

use App\Http\Requests\TbklpjasaRequest;
use Illuminate\Http\Request;
use Session;
// use Yajra\DataTables\Contracts\DataTables;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Tbklpjasa;
use App\Models\Userdtl;

// //return type View
// use Illuminate\View\View;

class TbklpjasaController extends Controller
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
            'submenu' => 'tbklpjasa',
            'submenu1' => 'ref_bengkel',
            'title' => 'Tabel Kelompok Jasa',
            // 'tbklpjasa' => Tbklpjasa::all(),
            // 'userdtlmenu' => Userdtl::where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
            // 'userdtlmenu' => Userdtl::join('tbmodule', 'userdtl.cmodule', '=', 'tbmodule.cmodule')->where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
            'userdtlmenu' => $userdtl,
            // 'userdtl' => Userdtl::where('cmodule', 'Tabel Kelompok Jasa')->where('username', $username)->first(),
        ];
        // dd($data);
        return view('tbklpjasa.index')->with($data);
    }
    public function tbklpjasaajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $data = Tbklpjasa::select('*'); //->orderBy('kode', 'asc');
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
            return view('tbklpjasa');
        }
    }

    public function tabel_klpjasa(Request $request)
    {
        $data = [
            'menu' => 'file',
            'submenu' => 'tbklpjasa',
            'submenu1' => 'ref_bengkel',
            'title' => 'Tabel Kelompok Jasa',
            'tbklpjasa' => Tbklpjasa::orderBy('kode', 'asc')->get(),
        ];
        // var_dump($data);
        return view('tbklpjasa.tabel_klpjasa')->with($data);
    }

    public function create(Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'file',
                'submenu' => 'tbklpjasa',
                'submenu1' => 'ref_bengkel',
                'title' => 'Tambah Data Tabel Kelompok Jasa',
                // 'tbklpjasa' => Tbklpjasa::all(),
            ];
            // var_dump($data);
            return response()->json([
                'body' => view('tbklpjasa.modaltambah', [
                    'tbklpjasa' => new Tbklpjasa(), //Tbklpjasa::first(),
                    'action' => route('tbklpjasa.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,

            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function store(TbklpjasaRequest $request, Tbklpjasa $tbklpjasa)
    {
        if ($request->Ajax()) {
            $validated = $request->validated(
                // [
                //     'kode' => 'required|unique:tbklpjasa,kode',
                //     'nama' => 'required',
                // ],
                // [
                //     'kode.unique' => 'Kode tidak boleh sama',
                //     'kode.required' => 'Kode harus di isi',
                //     'nama.required' => 'Nama harus di isi',
                // ]
            );
            if ($validated) {
                // $tbklpjasa->fill($request->all());
                // $tbklpjasa->aktif = $request->aktif == 'on' ? 'Y' : 'N';
                // $tbklpjasa->user = $request->username . date('d-m-Y');
                $aktif = isset($request->aktif) ? 'Y' : 'N';
                $tbklpjasa->fill([
                    'nama' => $request->nama,
                    'kode' => $request->kode,
                    'aktif' => $aktif,
                    'user' => 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $tbklpjasa->save($validated);
                $msg = [
                    'sukses' => 'Data berhasil di tambah', //view('tbklpjasa.tabel_klpjasa')
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
                'submenu' => 'tbklpjasa',
                'submenu1' => 'ref_bengkel',
                'title' => 'Detail Tabel Kelompok Jasa',
                'tbklpjasa' => Tbklpjasa::findOrFail($id),
                'userdtl' => Userdtl::where('cmodule', 'Tabel Kelompok Jasa')->where('username', $username)->first(),
            ];
            // return view('tbklpjasa.modaldetail')->with($data);
            return response()->json([
                'body' => view('tbklpjasa.modaltambah', [
                    'tbklpjasa' => Tbklpjasa::findOrFail($id),
                    'action' => route('tbklpjasa.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function edit(Tbklpjasa $tbklpjasa, Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'file',
                'submenu' => 'tbklpjasa',
                'submenu1' => 'ref_bengkel',
                'title' => 'Edit Data Tabel Kelompok Jasa',
            ];
            return response()->json([
                'body' => view('tbklpjasa.modaltambah', [
                    'tbklpjasa' => $tbklpjasa,
                    'action' => route('tbklpjasa.update', $tbklpjasa->id),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function update(TbklpjasaRequest $request, Tbklpjasa $tbklpjasa)
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
                    //     'kode' => 'required|unique:tbklpjasa,kode',
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
                $tbklpjasa->fill([
                    'nama' => $request->nama,
                    'kode' => $request->kode,
                    'aktif' => $aktif,
                    'user' => 'Update-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $tbklpjasa->save($validated);
                $msg = [
                    'sukses' => 'Data berhasil di update', //view('tbklpjasa.tabel_klpjasa')
                ];
            } else {
                $msg = [
                    'sukses' => 'Data gagal di update', //view('tbklpjasa.tabel_klpjasa')
                ];
            }
            echo json_encode($msg);
            // return redirect()->back()->with('message', 'Berhasil di update');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function destroy(Tbklpjasa $tbklpjasa, Request $request)
    {
        if ($request->Ajax()) {
            $tbklpjasa->delete();
            return response()->json([
                'sukses' => 'Data berhasil di hapus',
            ]);
            // return redirect()->back()->with('message', 'Berhasil di hapus');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
}
