<?php

namespace App\Http\Controllers;

use App\Http\Requests\TbjenisRequest;
use Illuminate\Http\Request;
use Session;
// use Yajra\DataTables\Contracts\DataTables;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Tbjenis;
use App\Models\Userdtl;

// //return type View
// use Illuminate\View\View;

class TbjenisController extends Controller
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
            // 'tbjenis' => Tbjenis::all(),
            // 'userdtlmenu' => Userdtl::where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
            // 'userdtlmenu' => Userdtl::join('tbmodule', 'userdtl.cmodule', '=', 'tbmodule.cmodule')->where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
            'userdtlmenu' => $userdtl,
            // 'userdtl' => Userdtl::where('cmodule', 'Tabel Jenis Kendaraan')->where('username', $username)->first(),
        ];
        // dd($data);
        return view('tbjenis.index')->with($data);
    }
    public function tbjenisajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $data = Tbjenis::select('*'); //->orderBy('kode', 'asc');
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
            return view('tbjenis');
        }
    }

    public function tabel_jenis(Request $request)
    {
        $data = [
            'menu' => 'file',
            'submenu' => 'tbjenis',
            'submenu1' => 'ref_kendaraan',
            'title' => 'Tabel Jenis Kendaraan',
            'tbjenis' => Tbjenis::orderBy('kode', 'asc')->get(),
        ];
        // var_dump($data);
        return view('tbjenis.tabel_jenis')->with($data);
    }

    public function create(Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'file',
                'submenu' => 'tbjenis',
                'submenu1' => 'ref_kendaraan',
                'title' => 'Tambah Data Tabel jenis',
                // 'tbjenis' => Tbjenis::all(),
            ];
            // var_dump($data);
            return response()->json([
                'body' => view('tbjenis.modaltambah', [
                    'tbjenis' => new Tbjenis(), //Tbjenis::first(),
                    'action' => route('tbjenis.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,

            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function store(TbjenisRequest $request, Tbjenis $tbjenis)
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
                $tbjenis->fill([
                    'nama' => $request->nama,
                    'kode' => $request->kode,
                    'aktif' => $aktif,
                    'user' => 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $tbjenis->save($validated);
                $msg = [
                    'sukses' => 'Data berhasil di tambah', //view('tbjenis.tabel_jenis')
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
                'tbjenis' => Tbjenis::findOrFail($id),
                'userdtl' => Userdtl::where('cmodule', 'Tabel Jenis Kendaraan')->where('username', $username)->first(),
            ];
            // return view('tbjenis.modaldetail')->with($data);
            return response()->json([
                'body' => view('tbjenis.modaltambah', [
                    'tbjenis' => Tbjenis::findOrFail($id),
                    'action' => route('tbjenis.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function edit(Tbjenis $tbjenis, Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'file',
                'submenu' => 'tbjenis',
                'submenu1' => 'ref_kendaraan',
                'title' => 'Edit Data Tabel jenis',
            ];
            return response()->json([
                'body' => view('tbjenis.modaltambah', [
                    'tbjenis' => $tbjenis,
                    'action' => route('tbjenis.update', $tbjenis->id),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function update(TbjenisRequest $request, Tbjenis $tbjenis)
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
                $tbjenis->fill([
                    'nama' => $request->nama,
                    'kode' => $request->kode,
                    'aktif' => $aktif,
                    'user' => 'Update-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $tbjenis->save($validated);
                $msg = [
                    'sukses' => 'Data berhasil di update', //view('tbjenis.tabel_jenis')
                ];
            } else {
                $msg = [
                    'sukses' => 'Data gagal di update', //view('tbjenis.tabel_jenis')
                ];
            }
            echo json_encode($msg);
            // return redirect()->back()->with('message', 'Berhasil di update');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function destroy(Tbjenis $tbjenis, Request $request)
    {
        if ($request->Ajax()) {
            $tbjenis->delete();
            return response()->json([
                'sukses' => 'Data berhasil di hapus',
            ]);
            // return redirect()->back()->with('message', 'Berhasil di hapus');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
}
