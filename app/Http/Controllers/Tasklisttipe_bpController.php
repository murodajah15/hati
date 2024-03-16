<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tasklisttipe_bpRequest;
use Illuminate\Http\Request;
use Session;
// use Yajra\DataTables\Contracts\DataTables;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Tasklisttipe_bp;
use App\Models\Tasklisttipe_bpd;
use App\Models\Tbasuransi;
use App\Models\Tbjasa;
use App\Models\Userdtl;

// //return type View
// use Illuminate\View\View;

class Tasklisttipe_bpController extends Controller
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
            'submenu' => 'tasklisttipe_bp',
            'submenu1' => 'ref_bp',
            'title' => 'Task List Tipe Body Repair',
            'userdtlmenu' => $userdtl,
        ];
        return view('tasklisttipe_bp.index')->with($data);
    }
    public function tasklisttipe_bpajax(Request $request) //: View
    {
        if ($request->ajax()) {
            // $data = Tasklisttipe_bp::select('*'); //->orderBy('kode', 'asc');
            $data = Tasklisttipe_bp::select('tasklisttipe_bp.*', 'tbasuransi.nama as nmasuransi')->join('tbasuransi', 'tbasuransi.kode', '=', 'tasklisttipe_bp.kdasuransi'); //->orderBy('kode', 'asc');
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
            return view('tasklisttipe_bp');
        }
    }

    // public function tabel_paket(Request $request)
    // {
    //     $data = [
    //         'menu' => 'file',
    //         'submenu' => 'tasklisttipe_bp',
    //         'submenu1' => 'ref_bp',
    //         'title' => 'Task List Tipe Body Repair',
    //         'tasklisttipe_bp' => Tasklisttipe_bp::orderBy('kode', 'asc')->get(),
    //     ];
    //     // var_dump($data);
    //     return view('tasklisttipe_bp.tabel_paket')->with($data);
    // }

    public function create(Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'file',
                'submenu' => 'tasklisttipe_bp',
                'submenu1' => 'ref_bp',
                'title' => 'Tambah Data Task List Body Repair',
                // 'tasklisttipe_bp' => Tasklisttipe_bp::all(),
            ];
            // var_dump($data);
            return response()->json([
                'body' => view('tasklisttipe_bp.modaltambahmaster', [
                    'tasklisttipe_bp' => new Tasklisttipe_bp(), //Tasklisttipe_bp::first(),
                    'tbasuransi' => Tbasuransi::orderBy('nama')->get(),
                    'action' => route('tasklisttipe_bp.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,

            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function store(Tasklisttipe_bpRequest $request, Tasklisttipe_bp $tasklisttipe_bp)
    {
        if ($request->Ajax()) {
            $validated = $request->validated();
            if ($validated) {
                $aktif = isset($request->aktif) ? 'Y' : 'N';
                $tasklisttipe_bp->fill([
                    'kode' => isset($request->kode) ? $request->kode : '',
                    'nama' => isset($request->nama) ? $request->nama : '',
                    'jenis' => isset($request->jenis) ? $request->jenis : '',
                    'kdtipe' => isset($request->kdtipe) ? $request->kdtipe : '',
                    'aktif' => $aktif,
                    'user' => 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $tasklisttipe_bp->save($validated);
                $msg = [
                    'sukses' => 'Data berhasil di tambah', //view('tasklisttipe_bp.tabel_paket')
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
                'submenu' => 'tasklisttipe_bp',
                'submenu1' => 'ref_bp',
                'title' => 'Detail Task List Body Repair',
                'tasklisttipe_bp' => Tasklisttipe_bp::findOrFail($id),
                'userdtl' => Userdtl::where('cmodule', 'Task List Tipe Body Repair')->where('username', $username)->first(),
            ];
            // return view('tasklisttipe_bp.modaldetail')->with($data);
            return response()->json([
                'body' => view('tasklisttipe_bp.modaltambahmaster', [
                    'tasklisttipe_bp' => Tasklisttipe_bp::findOrFail($id),
                    'tbasuransi' => Tbasuransi::orderBy('nama')->get(),
                    'action' => route('tasklisttipe_bp.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function edit(tasklisttipe_bp $tasklisttipe_bp, Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'file',
                'submenu' => 'tasklisttipe_bp',
                'submenu1' => 'ref_bp',
                'title' => 'Edit Data Task List Body Repair',
            ];
            return response()->json([
                'body' => view('tasklisttipe_bp.modaltambahmaster', [
                    'tasklisttipe_bp' => $tasklisttipe_bp,
                    'tbasuransi' => Tbasuransi::orderBy('nama')->get(),
                    'action' => route('tasklisttipe_bp.update', $tasklisttipe_bp->id),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function update(tasklisttipe_bpRequest $request, tasklisttipe_bp $tasklisttipe_bp)
    {
        if ($request->Ajax()) {
            $validated = $request->validated();
            if ($validated) {
                $aktif = $request->aktif == 'on' ? 'Y' : 'N';
                $tasklisttipe_bp->fill([
                    'kode' => isset($request->kode) ? $request->kode : '',
                    'nama' => isset($request->nama) ? $request->nama : '',
                    'jenis' => isset($request->jenis) ? $request->jenis : '',
                    'kdtipe' => isset($request->kdtipe) ? $request->kdtipe : '',
                    'aktif' => $aktif,
                    'user' => 'Update-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $tasklisttipe_bp->save($validated);
                $msg = [
                    'sukses' => 'Data berhasil di update', //view('tasklisttipe_bp.tabel_paket')
                ];
            } else {
                $msg = [
                    'sukses' => 'Data gagal di update', //view('tasklisttipe_bp.tabel_paket')
                ];
            }
            echo json_encode($msg);
            // return redirect()->back()->with('message', 'Berhasil di update');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function destroy(tasklisttipe_bp $tasklisttipe_bp, Request $request)
    {
        if ($request->Ajax()) {
            $tasklisttipe_bpid = Tasklisttipe_bp::where('id', $tasklisttipe_bp->id)->first();
            $kdpaket = $tasklisttipe_bpid->kode;
            Tasklisttipe_bpd::where('kdpaket', $kdpaket)->delete();
            $tasklisttipe_bp->delete();
            return response()->json([
                'sukses' => 'Data berhasil di hapus',
            ]);
            // return redirect()->back()->with('message', 'Berhasil di hapus');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    // public function tasklisttipe_bp_d(tasklisttipe_bp $tasklisttipe_bp, Request $request)
    // {
    //     if ($request->Ajax()) {
    //         $data = [
    //             'menu' => 'file',
    //             'submenu' => 'tasklisttipe_bp',
    //             'submenu1' => 'ref_bp',
    //             'title' => 'Edit Data Tabel Paket',
    //         ];
    //         return response()->json([
    //             'body' => view('tasklisttipe_bp.modaltambah', [
    //                 'tasklisttipe_bp' => $tasklisttipe_bp,
    //                 'tbasuransi' => Tbasuransi::orderBy('nama')->get(),
    //                 'action' => route('tasklisttipe_bp.update', $tasklisttipe_bp->id),
    //                 'vdata' => $data,
    //             ])->render(),
    //             'data' => $data,
    //         ]);
    //     } else {
    //         exit('Maaf tidak dapat diproses');
    //     }
    // }
}
