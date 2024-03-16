<?php

namespace App\Http\Controllers;

use App\Http\Requests\TbjnstrmksrRequest;
use Illuminate\Http\Request;
use Session;
// use Yajra\DataTables\Contracts\DataTables;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Tbjnstrmksr;
use App\Models\Userdtl;

// //return type View
// use Illuminate\View\View;

class TbjnstrmksrController extends Controller
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
            'submenu' => 'tbjnstrmksr',
            'submenu1' => 'ref_umum',
            'title' => 'Tabel Jenis Penerimaan Kasir',
            'userdtlmenu' => $userdtl,
        ];
        return view('tbjnstrmksr.index')->with($data);
    }
    public function tbjnstrmksrajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $data = Tbjnstrmksr::select('*'); //->orderBy('kode', 'asc');
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
            return view('tbjnstrmksr');
        }
    }

    public function tabel_jnstrmksr(Request $request)
    {
        $data = [
            'menu' => 'file',
            'submenu' => 'tbjnstrmksr',
            'submenu1' => 'ref_umum',
            'title' => 'Tabel Jenis Penerimaan Kasir',
            'tbjnstrmksr' => Tbjnstrmksr::orderBy('kode', 'asc')->get(),
        ];
        // var_dump($data);
        return view('tbjnstrmksr.tabel_jnstrmksr')->with($data);
    }

    public function create(Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'file',
                'submenu' => 'tbjnstrmksr',
                'submenu1' => 'ref_umum',
                'title' => 'Tambah Data Tabel jnstrmksr',
                // 'tbjnstrmksr' => Tbjnstrmksr::all(),
            ];
            // var_dump($data);
            return response()->json([
                'body' => view('tbjnstrmksr.modaltambah', [
                    'tbjnstrmksr' => new Tbjnstrmksr(), //Tbjnstrmksr::first(),
                    'action' => route('tbjnstrmksr.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,

            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function store(TbjnstrmksrRequest $request, Tbjnstrmksr $tbjnstrmksr)
    {
        if ($request->Ajax()) {
            $validated = $request->validated(
                // [
                //     'kode' => 'required|unique:tbjnstrmksr,kode',
                //     'nama' => 'required',
                // ],
                // [
                //     'kode.unique' => 'Kode tidak boleh sama',
                //     'kode.required' => 'Kode harus di isi',
                //     'nama.required' => 'Nama harus di isi',
                // ]
            );
            if ($validated) {
                // $tbjnstrmksr->fill($request->all());
                // $tbjnstrmksr->aktif = $request->aktif == 'on' ? 'Y' : 'N';
                // $tbjnstrmksr->user = $request->username . date('d-m-Y');
                $aktif = isset($request->aktif) ? 'Y' : 'N';
                $tbjnstrmksr->fill([
                    'kode' => isset($request->kode) ? $request->kode : '',
                    'nama' => isset($request->nama) ? $request->nama : '',
                    'kodeacc' => isset($request->kodeacc) ? $request->kodeacc : '',
                    'aktif' => $aktif,
                    'user' => 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $tbjnstrmksr->save($validated);
                $msg = [
                    'sukses' => 'Data berhasil di tambah', //view('tbjnstrmksr.tabel_jnstrmksr')
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
                'submenu' => 'tbjnstrmksr',
                'submenu1' => 'ref_umum',
                'title' => 'Detail Tabel jnstrmksr',
                'tbjnstrmksr' => Tbjnstrmksr::findOrFail($id),
                'userdtl' => Userdtl::where('cmodule', 'Tabel Jenis Penerimaan Kasir')->where('username', $username)->first(),
            ];
            // return view('tbjnstrmksr.modaldetail')->with($data);
            return response()->json([
                'body' => view('tbjnstrmksr.modaltambah', [
                    'tbjnstrmksr' => Tbjnstrmksr::findOrFail($id),
                    'action' => route('tbjnstrmksr.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function edit(Tbjnstrmksr $tbjnstrmksr, Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'file',
                'submenu' => 'tbjnstrmksr',
                'submenu1' => 'ref_umum',
                'title' => 'Edit Data Tabel jnstrmksr',
            ];
            return response()->json([
                'body' => view('tbjnstrmksr.modaltambah', [
                    'tbjnstrmksr' => $tbjnstrmksr,
                    'action' => route('tbjnstrmksr.update', $tbjnstrmksr->id),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function update(TbjnstrmksrRequest $request, Tbjnstrmksr $tbjnstrmksr)
    {
        if ($request->Ajax()) {
            $validated = $request->validated();
            if ($validated) {
                $aktif = $request->aktif == 'on' ? 'Y' : 'N';
                $tbjnstrmksr->fill([
                    'kode' => isset($request->kode) ? $request->kode : '',
                    'nama' => isset($request->nama) ? $request->nama : '',
                    'kodeacc' => isset($request->kodeacc) ? $request->kodeacc : '',
                    'aktif' => $aktif,
                    'user' => 'Update-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $tbjnstrmksr->save($validated);
                $msg = [
                    'sukses' => 'Data berhasil di update', //view('tbjnstrmksr.tabel_jnstrmksr')
                ];
            } else {
                $msg = [
                    'sukses' => 'Data gagal di update', //view('tbjnstrmksr.tabel_jnstrmksr')
                ];
            }
            echo json_encode($msg);
            // return redirect()->back()->with('message', 'Berhasil di update');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function destroy(Tbjnstrmksr $tbjnstrmksr, Request $request)
    {
        if ($request->Ajax()) {
            $tbjnstrmksr->delete();
            return response()->json([
                'sukses' => 'Data berhasil di hapus',
            ]);
            // return redirect()->back()->with('message', 'Berhasil di hapus');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
}
