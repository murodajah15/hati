<?php

namespace App\Http\Controllers;

use App\Http\Requests\TbpaketRequest;
use Illuminate\Http\Request;
use Session;
// use Yajra\DataTables\Contracts\DataTables;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Tbpaket;
use App\Models\Tbpaket_detail;
use App\Models\Tbtipe;
use App\Models\Userdtl;

// //return type View
// use Illuminate\View\View;

class TbpaketController extends Controller
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
            'submenu' => 'tbpaket',
            'submenu1' => 'ref_bengkel',
            'title' => 'Tabel Paket',
            'userdtlmenu' => $userdtl,
        ];
        return view('tbpaket.index')->with($data);
    }
    public function tbpaketajax(Request $request) //: View
    {
        if ($request->ajax()) {
            // $data = Tbpaket::select('*'); //->orderBy('kode', 'asc');
            $data = Tbpaket::select('tbpaket.*', 'tbtipe.nama as nmtipe')->join('tbtipe', 'tbtipe.kode', '=', 'tbpaket.kdtipe'); //->orderBy('kode', 'asc');
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
            return view('tbpaket');
        }
    }

    public function tabel_paket(Request $request)
    {
        $data = [
            'menu' => 'file',
            'submenu' => 'tbpaket',
            'submenu1' => 'ref_bengkel',
            'title' => 'Tabel Paket',
            'tbpaket' => Tbpaket::orderBy('kode', 'asc')->get(),
        ];
        // var_dump($data);
        return view('tbpaket.tabel_paket')->with($data);
    }

    public function create(Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'file',
                'submenu' => 'tbpaket',
                'submenu1' => 'ref_bengkel',
                'title' => 'Tambah Data Tabel Paket',
                // 'tbpaket' => Tbpaket::all(),
            ];
            // var_dump($data);
            return response()->json([
                'body' => view('tbpaket.modaltambah', [
                    'tbpaket' => new Tbpaket(), //Tbpaket::first(),
                    'tbtipe' => Tbtipe::orderBy('nama')->get(),
                    'action' => route('tbpaket.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,

            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function store(TbpaketRequest $request, Tbpaket $tbpaket)
    {
        if ($request->Ajax()) {
            $validated = $request->validated();
            if ($validated) {
                $aktif = isset($request->aktif) ? 'Y' : 'N';
                $tbpaket->fill([
                    'kode' => isset($request->kode) ? $request->kode : '',
                    'nama' => isset($request->nama) ? $request->nama : '',
                    'jenis' => isset($request->jenis) ? $request->jenis : '',
                    'kdtipe' => isset($request->kdtipe) ? $request->kdtipe : '',
                    'aktif' => $aktif,
                    'user' => 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $tbpaket->save($validated);
                $msg = [
                    'sukses' => 'Data berhasil di tambah', //view('tbpaket.tabel_paket')
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
                'submenu' => 'tbpaket',
                'submenu1' => 'ref_bengkel',
                'title' => 'Detail Tabel paket',
                'tbpaket' => Tbpaket::findOrFail($id),
                'userdtl' => Userdtl::where('cmodule', 'Tabel Paket')->where('username', $username)->first(),
            ];
            // return view('tbpaket.modaldetail')->with($data);
            return response()->json([
                'body' => view('tbpaket.modaltambah', [
                    'tbpaket' => Tbpaket::findOrFail($id),
                    'tbtipe' => Tbtipe::orderBy('nama')->get(),
                    'action' => route('tbpaket.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function edit(Tbpaket $tbpaket, Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'file',
                'submenu' => 'tbpaket',
                'submenu1' => 'ref_bengkel',
                'title' => 'Edit Data Tabel Paket',
            ];
            return response()->json([
                'body' => view('tbpaket.modaltambah', [
                    'tbpaket' => $tbpaket,
                    'tbtipe' => Tbtipe::orderBy('nama')->get(),
                    'action' => route('tbpaket.update', $tbpaket->id),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function update(TbpaketRequest $request, Tbpaket $tbpaket)
    {
        if ($request->Ajax()) {
            $validated = $request->validated();
            if ($validated) {
                $aktif = $request->aktif == 'on' ? 'Y' : 'N';
                $tbpaket->fill([
                    'kode' => isset($request->kode) ? $request->kode : '',
                    'nama' => isset($request->nama) ? $request->nama : '',
                    'jenis' => isset($request->jenis) ? $request->jenis : '',
                    'kdtipe' => isset($request->kdtipe) ? $request->kdtipe : '',
                    'aktif' => $aktif,
                    'user' => 'Update-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $tbpaket->save($validated);
                $msg = [
                    'sukses' => 'Data berhasil di update', //view('tbpaket.tabel_paket')
                ];
            } else {
                $msg = [
                    'sukses' => 'Data gagal di update', //view('tbpaket.tabel_paket')
                ];
            }
            echo json_encode($msg);
            // return redirect()->back()->with('message', 'Berhasil di update');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function destroy(Tbpaket $tbpaket, Request $request)
    {
        if ($request->Ajax()) {
            $tbpaketid = Tbpaket::where('id', $tbpaket->id)->first();
            $kdpaket = $tbpaketid->kode;
            Tbpaket_detail::where('kdpaket', $kdpaket)->delete();
            $tbpaket->delete();
            return response()->json([
                'sukses' => 'Data berhasil di hapus',
            ]);
            // return redirect()->back()->with('message', 'Berhasil di hapus');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function tbpaket_detail(Tbpaket $tbpaket, Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'file',
                'submenu' => 'tbpaket',
                'submenu1' => 'ref_bengkel',
                'title' => 'Edit Data Tabel Paket',
            ];
            return response()->json([
                'body' => view('tbpaket.modaltambah', [
                    'tbpaket' => $tbpaket,
                    'tbtipe' => Tbtipe::orderBy('nama')->get(),
                    'action' => route('tbpaket.update', $tbpaket->id),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
}
