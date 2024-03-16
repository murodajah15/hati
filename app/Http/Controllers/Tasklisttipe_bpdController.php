<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tasklisttipe_bpdRequest;
use Illuminate\Http\Request;
use Session;
// use Yajra\DataTables\Contracts\DataTables;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Tasklisttipe_bp;
use App\Models\Tasklisttipe_bpd;
use App\Models\Userdtl;

// //return type View
// use Illuminate\View\View;

class Tasklisttipe_bpdController extends Controller
{
    public function index1(Request $request) //: View
    {
        $username = session('username');
        $userdtl = Userdtl::where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get();
        $data = [
            'menu' => 'file',
            'submenu' => 'tasklisttipe_bp',
            'submenu1' => 'ref_bp',
            'title' => 'Task List Tipe Body Repair',
            'userdtlmenu' => $userdtl,
        ];
        return view('tasklisttipe_bp.index')->with($data);
    }
    public function index(Request $request) //: View
    {
        if ($request->Ajax()) {
            $id = $request->id;
            $username = session('username');
            $data = [
                'menu' => 'file',
                'submenu' => 'tasklisttipe_bp',
                'submenu1' => 'ref_bengkel',
                'title' => 'Detail Task List Tipe Body Repair',
                'tasklisttipe_bp' => Tasklisttipe_bp::findOrFail($id),
                'userdtl' => Userdtl::where('cmodule', 'Task List Tipe Body Repair')->where('username', $username)->first(),
            ];
            // return view('tasklisttipe_bp.modaldetail')->with($data);
            return response()->json([
                'body' => view('tasklisttipe_bp.modaldetail', [
                    'tasklisttipe_bp' => Tasklisttipe_bp::findOrFail($id),
                    'userdtl' => Userdtl::where('cmodule', 'Task List Tipe Body Repair')->where('username', $username)->first(),
                    'action' => route('tasklisttipe_bp.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function tasklisttipe_bpdajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $kdtasklist = $_GET['kdtasklist'];
            $kdasuransi = $_GET['kdasuransi'];
            $data = Tasklisttipe_bpd::select('*')->where('kdasuransi', $kdasuransi)->where('kdtasklist', $kdtasklist);
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('kode1', function ($row) {
                    $id = $row['id'];
                    $btn = $row['kode']; //'<a href="#"' . 'onclick=detail(' . $id . ')>' .  $row['kode'] . '</a>';
                    return $btn;
                })
                ->rawColumns(['kode1'])
                ->make(true);
        }
    }

    public function simpantasklisttipe_bpd(Request $request, Tasklisttipe_bpd $tasklisttipe_bpd)
    {
        // if ($request->Ajax()) {
        // $validated = $request->validated();
        // if ($validated) {
        $kdtasklist = isset($request->kdtasklist) ? $request->kdtasklist : '';
        $kdasuransi = isset($request->kdasuransi) ? $request->kdasuransi : '';
        $cekdouble = Tasklisttipe_bpd::where('kdtasklist', $kdtasklist)->where('kdasuransi', $kdasuransi)->where('kode', $request->kode)->first();
        if (isset($cekdouble->kode)) {
            $msg = [
                'sukses' => false, //view('tasklisttipe_bpd.tabel_paket_detail')
            ];
        } else {
            $kode = isset($request->kode) ? $request->kode : '';
            $nama = isset($request->nama) ? $request->nama : '';
            $harga = isset($request->harga) ? $request->harga : '';
            $kdtasklist = isset($request->kdtasklist) ? $request->kdtasklist : '';
            $kdasuransi = isset($request->kdasuransi) ? $request->kdasuransi : '';
            $user = 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s');
            // $tasklisttipe_bpd->save($validated);
            Tasklisttipe_bpd::insert([
                'kode' => $kode, 'nama' => $nama, 'kdtasklist' => $kdtasklist, 'kdasuransi' => $kdasuransi,
                'harga' => $harga, 'user' => $user
            ]);
            $msg = [
                'sukses' => true, //'Data berhasil di tambah', //view('tasklisttipe_bpd.tabel_paket_detail')
            ];
        }
        // }
        echo json_encode($msg);
        // return redirect()->back()->with('message', 'Berhasil di simpan');
        // } else {
        //     exit('Maaf tidak dapat diproses');
        // }
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
                'submenu1' => 'ref_bengkel',
                'title' => 'Detail Tabel Paket',
                'tasklisttipe_bp' => Tasklisttipe_bpd::findOrFail($id),
                'userdtl' => Userdtl::where('cmodule', 'Tabel Paket')->where('username', $username)->first(),
            ];
            // return view('tasklisttipe_bp.modaldetail')->with($data);
            return response()->json([
                'body' => view('tasklisttipe_bp.modaltambah', [
                    'tasklisttipe_bpd' => Tasklisttipe_bpd::findOrFail($id),
                    'action' => route('tasklisttipe_bp.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function edittasklisttipe_bpd(Request $request)
    {
        if ($request->Ajax()) {
            // dd($request->id);
            $tasklisttipe_bpd = Tasklisttipe_bpd::where('id', $request->id)->first();
            $data = [
                'menu' => 'file',
                'submenu' => 'tasklisttipe_bp',
                'submenu1' => 'ref_bengkel',
                'title' => 'Edit Data Task List Tipe',
            ];
            return response()->json([
                'body' => view('tasklisttipe_bp.modaleditdetail', [
                    'tasklisttipe_bpd' => $tasklisttipe_bpd,
                    // 'action' => route('tasklisttipe_bpd.update', $tasklisttipe_bpd->id),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
    public function updatetasklisttipe_bpd(Request $request, Tasklisttipe_bpd $tasklisttipe_bpd)
    {
        if ($request->Ajax()) {
            $kode = isset($request->kode) ? $request->kode : '';
            $nama = isset($request->nama) ? $request->nama : '';
            $harga = isset($request->harga) ? $request->harga : '';
            // $kdtasklist = isset($request->kdtasklist) ? $request->kdtasklist : '';
            // $kdasuransi = isset($request->kdasuransi) ? $request->kdasuransi : '';
            $user = 'Update-' . $request->username . ', ' . date('d-m-Y h:i:s');
            Tasklisttipe_bpd::where('id', $request->id)->update([
                'kode' => $kode, 'nama' => $nama, 'harga' => $harga, 'user' => $user
            ]);
            // Tasklisttipe_bpd::where('id', $request->id)->update([
            //     'kode' => $kode, 'nama' => $nama, 'kdtasklist' => $kdtasklist, 'kdasuransi' => $kdasuransi,
            //     'harga' => $harga, 'user' => $user
            // ]);
            $msg = [
                'sukses' => true,
            ];
            echo json_encode($msg);
        } else {
            $msg = [
                'sukses' => false,
            ];
            echo json_encode($msg);
            exit('Maaf tidak dapat diproses');
        }
    }

    public function salintasklisttipe_bpd(Request $request, Tasklisttipe_bpd $tasklisttipe_bpd)
    {
        if ($request->Ajax()) {
            $kdtasklist_salin = isset($request->kdtasklist_salin) ? $request->kdtasklist_salin : '';
            $kdasuransi_salin = isset($request->kdasuransi_salin) ? $request->kdasuransi_salin : '';
            $kdasuransi = isset($request->kdasuransi) ? $request->kdasuransi : '';
            $kdtasklist = isset($request->kdtasklist) ? $request->kdtasklist : '';
            // dd($kdtasklist_salin . '   ' . $kdasuransi_salin . '   ' . $kdasuransi);
            $tltipesalin_bpd = Tasklisttipe_bpd::where('kdtasklist', $kdtasklist_salin)->where('kdasuransi', $kdasuransi_salin)->get();
            foreach ($tltipesalin_bpd as $row) {
                $cekdouble = Tasklisttipe_bpd::where('kdtasklist', $kdtasklist)->where('kdasuransi', $kdasuransi)->where('kode', $row->kode)->first();
                if (isset($cekdouble)) {
                    $user = 'Update-' . $request->username . ', ' . date('d-m-Y h:i:s');
                    Tasklisttipe_bpd::where('kdasuransi', $kdasuransi)->where('kode', $row->kode)->update([
                        'harga' => $row->harga, 'user' => $user
                    ]);
                } else {
                    $user = 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s');
                    Tasklisttipe_bpd::insert([
                        'kode' => $row->kode, 'nama' => $row->nama, 'kdtasklist' => $kdtasklist, 'kdasuransi' => $kdasuransi,
                        'harga' => $row->harga, 'user' => $user
                    ]);
                }
            }
            $msg = [
                'sukses' => true, //'Data berhasil di tambah', //view('tasklisttipe_bpd.tabel_paket_detail')
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function destroy(Tasklisttipe_bpd $tasklisttipe_bpd, Request $request)
    {
        if ($request->Ajax()) {
            $tasklisttipe_bpd->delete();
            return response()->json([
                'sukses' => 'Data berhasil di hapus',
            ]);
            // return redirect()->back()->with('message', 'Berhasil di hapus');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
}
