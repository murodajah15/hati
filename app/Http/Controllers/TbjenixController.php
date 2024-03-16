<?php

namespace App\Http\Controllers;

use App\Http\Requests\TbjenixRequest;
use Illuminate\Http\Request;
use Session;
// use Yajra\DataTables\Contracts\DataTables;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Tbjenix;
use App\Models\Userdtl;

// //return type View
// use Illuminate\View\View;

class TbjenixController extends Controller
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
            'submenu' => 'tbjenis',
            'submenu1' => 'ref_kendaraan',
            'title' => 'Tabel Jenis Kendaraan',
            // 'tbjenis' => Tbjenix::all(),
            // 'userdtlmenu' => Userdtl::where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
            // 'userdtlmenu' => Userdtl::join('tbmodule', 'userdtl.cmodule', '=', 'tbmodule.cmodule')->where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
            'userdtlmenu' => $userdtl,
            // 'userdtl' => Userdtl::where('cmodule', 'Tabel Jenis Kendaraan')->where('username', $username)->first(),
        ];
        // dd($data);
        return view('tbjenix.index')->with($data);
    }
    public function tbjenixajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $data = Tbjenix::select('*'); //->orderBy('kode', 'asc');
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
            return view('tbjenix');
        }
    }

    public function tabel_jenis(Request $request)
    {
        $data = [
            'menu' => 'file',
            'submenu' => 'tbjenis',
            'submenu1' => 'ref_kendaraan',
            'title' => 'Tabel Jenis Kendaraan',
            'tbjenis' => Tbjenix::orderBy('kode', 'asc')->get(),
        ];
        // var_dump($data);
        return view('tbjenix.tabel_jenis')->with($data);
    }

    public function create(Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'file',
                'submenu' => 'tbjenix',
                'submenu1' => 'ref_kendaraan',
                'title' => 'Tambah Data Tabel jenis',
                // 'tbjenis' => Tbjenix::all(),
            ];
            // var_dump($data);
            return response()->json([
                'body' => view('tbjenix.modaltambah', [
                    'tbjenis' => new Tbjenix(), //Tbjenix::first(),
                    'action' => route('tbjenix.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,

            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function store(TbjenixRequest $request, Tbjenix $tbjenix)
    {
        if ($request->Ajax()) {
            $validated = $request->validated(
                // [
                //     'kode' => 'required|unique:tbjenis,kode',
                //     'nama' => 'required',
                // ],
                // [
                //     'kode.unique' => 'Kode tidak boleh sama',
                //     'kode.required' => 'Kode harus di isi',
                //     'nama.required' => 'Nama harus di isi',
                // ]
            );
            if ($validated) {
                // $tbjenis->fill($request->all());
                // $tbjenis->aktif = $request->aktif == 'on' ? 'Y' : 'N';
                // $tbjenis->user = $request->username . date('d-m-Y');
                $aktif = isset($request->aktif) ? 'Y' : 'N';
                $tbjenix->fill([
                    'nama' => $request->nama,
                    'kode' => $request->kode,
                    'aktif' => $aktif,
                    'user' => 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $tbjenix->save($validated);
                $msg = [
                    'sukses' => 'Data berhasil di tambah', //view('tbjenix.tabel_jenis')
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
                'submenu' => 'tbjenis',
                'submenu1' => 'ref_kendaraan',
                'title' => 'Detail Tabel jenis',
                'tbjenis' => Tbjenix::findOrFail($id),
                'userdtl' => Userdtl::where('cmodule', 'Tabel Jenis Kendaraan')->where('username', $username)->first(),
            ];
            // return view('tbjenix.modaldetail')->with($data);
            return response()->json([
                'body' => view('tbjenix.modaltambah', [
                    'tbjenis' => Tbjenix::findOrFail($id),
                    'action' => route('tbjenix.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function edit(Tbjenix $tbjenix, Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'file',
                'submenu' => 'tbjenis',
                'submenu1' => 'ref_kendaraan',
                'title' => 'Edit Data Tabel Jenis',
            ];
            return response()->json([
                'body' => view('tbjenix.modaltambah', [
                    'tbjenis' => $tbjenix,
                    'action' => route('tbjenix.update', $tbjenix->id),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function update(TbjenixRequest $request, Tbjenix $tbjenix)
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
                    //     'kode' => 'required|unique:tbjenis,kode',
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
                $tbjenix->fill([
                    'nama' => $request->nama,
                    'kode' => $request->kode,
                    'aktif' => $aktif,
                    'user' => 'Update-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $tbjenix->save($validated);
                $msg = [
                    'sukses' => 'Data berhasil di update', //view('tbjenix.tabel_jenis')
                ];
            } else {
                $msg = [
                    'sukses' => 'Data gagal di update', //view('tbjenix.tabel_jenis')
                ];
            }
            echo json_encode($msg);
            // return redirect()->back()->with('message', 'Berhasil di update');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function destroy(Tbjenix $tbjenix, Request $request)
    {
        if ($request->Ajax()) {
            $tbjenix->delete();
            return response()->json([
                'sukses' => 'Data berhasil di hapus',
            ]);
            // return redirect()->back()->with('message', 'Berhasil di hapus');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
}
