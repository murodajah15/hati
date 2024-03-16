<?php

namespace App\Http\Controllers;

use App\Http\Requests\TbjasaRequest;
use Illuminate\Http\Request;
use Session;
// use Yajra\DataTables\Contracts\DataTables;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Tbjasa;
use App\Models\Userdtl;

// //return type View
// use Illuminate\View\View;

class TbjasaController extends Controller
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
            'submenu' => 'tbjasa',
            'submenu1' => 'ref_bengkel',
            'title' => 'Tabel Jasa',
            // 'tbjasa' => Tbjasa::all(),
            // 'userdtlmenu' => Userdtl::where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
            // 'userdtlmenu' => Userdtl::join('tbmodule', 'userdtl.cmodule', '=', 'tbmodule.cmodule')->where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
            'userdtlmenu' => $userdtl,
            // 'userdtl' => Userdtl::where('cmodule', 'Tabel Jasa')->where('username', $username)->first(),
        ];
        // dd($data);
        return view('tbjasa.index')->with($data);
    }
    public function tbjasaajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $data = Tbjasa::select('*'); //->orderBy('kode', 'asc');
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
            return view('tbjasa');
        }
    }

    public function tabel_jasa(Request $request)
    {
        $data = [
            'menu' => 'file',
            'submenu' => 'tbjasa',
            'submenu1' => 'ref_bengkel',
            'title' => 'Tabel Jasa',
            'tbjasa' => Tbjasa::orderBy('kode', 'asc')->get(),
        ];
        // var_dump($data);
        return view('tbjasa.tabel_jasa')->with($data);
    }

    public function create(Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'file',
                'submenu' => 'tbjasa',
                'submenu1' => 'ref_bengkel',
                'title' => 'Tambah Data Tabel Jasa',
                // 'tbjasa' => Tbjasa::all(),
            ];
            // var_dump($data);
            return response()->json([
                'body' => view('tbjasa.modaltambah', [
                    'tbjasa' => new Tbjasa(), //Tbjasa::first(),
                    'action' => route('tbjasa.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,

            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function store(TbjasaRequest $request, Tbjasa $tbjasa)
    {
        if ($request->Ajax()) {
            $validated = $request->validated(
                // [
                //     'kode' => 'required|unique:tbjasa,kode',
                //     'nama' => 'required',
                // ],
                // [
                //     'kode.unique' => 'Kode tidak boleh sama',
                //     'kode.required' => 'Kode harus di isi',
                //     'nama.required' => 'Nama harus di isi',
                // ]
            );
            if ($validated) {
                // $tbjasa->fill($request->all());
                // $tbjasa->aktif = $request->aktif == 'on' ? 'Y' : 'N';
                // $tbjasa->user = $request->username . date('d-m-Y');
                $aktif = isset($request->aktif) ? 'Y' : 'N';
                $tbjasa->fill([
                    'kode' => isset($request->kode) ? $request->kode : '',
                    'nama' => isset($request->nama) ? $request->nama : '',
                    'aktif' => $aktif,
                    'user' => 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $tbjasa->save($validated);
                $msg = [
                    'sukses' => 'Data berhasil di tambah', //view('tbjasa.tabel_jasa')
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
                'submenu' => 'tbjasa',
                'submenu1' => 'ref_bengkel',
                'title' => 'Detail Tabel Jasa',
                'tbjasa' => Tbjasa::findOrFail($id),
                'userdtl' => Userdtl::where('cmodule', 'Tabel Jasa')->where('username', $username)->first(),
            ];
            // return view('tbjasa.modaldetail')->with($data);
            return response()->json([
                'body' => view('tbjasa.modaltambah', [
                    'tbjasa' => Tbjasa::findOrFail($id),
                    'action' => route('tbjasa.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function edit(Tbjasa $tbjasa, Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'file',
                'submenu' => 'tbjasa',
                'submenu1' => 'ref_bengkel',
                'title' => 'Edit Data Tabel Jasa',
            ];
            return response()->json([
                'body' => view('tbjasa.modaltambah', [
                    'tbjasa' => $tbjasa,
                    'action' => route('tbjasa.update', $tbjasa->id),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function update(TbjasaRequest $request, Tbjasa $tbjasa)
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
                    //     'kode' => 'required|unique:tbjasa,kode',
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
                $tbjasa->fill([
                    'kode' => isset($request->kode) ? $request->kode : '',
                    'nama' => isset($request->nama) ? $request->nama : '',
                    'aktif' => $aktif,
                    'user' => 'Update-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $tbjasa->save($validated);
                $msg = [
                    'sukses' => 'Data berhasil di update', //view('tbjasa.tabel_jasa')
                ];
            } else {
                $msg = [
                    'sukses' => 'Data gagal di update', //view('tbjasa.tabel_jasa')
                ];
            }
            echo json_encode($msg);
            // return redirect()->back()->with('message', 'Berhasil di update');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function destroy(Tbjasa $tbjasa, Request $request)
    {
        if ($request->Ajax()) {
            $tbjasa->delete();
            return response()->json([
                'sukses' => 'Data berhasil di hapus',
            ]);
            // return redirect()->back()->with('message', 'Berhasil di hapus');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
}
