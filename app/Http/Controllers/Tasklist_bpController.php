<?php

namespace App\Http\Controllers;

use App\Http\Requests\tasklist_bpRequest;
use Illuminate\Http\Request;
use Session;
// use Yajra\DataTables\Contracts\DataTables;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Tasklist_bp;
use App\Models\Userdtl;

// //return type View
// use Illuminate\View\View;

class Tasklist_bpController extends Controller
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
            'submenu' => 'tasklist_bp',
            'submenu1' => 'ref_bp',
            'title' => 'Task List Body Repair',
            // 'tasklist_bp' => Tasklist_bp::all(),
            // 'userdtlmenu' => Userdtl::where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
            // 'userdtlmenu' => Userdtl::join('tbmodule', 'userdtl.cmodule', '=', 'tbmodule.cmodule')->where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
            'userdtlmenu' => $userdtl,
            // 'userdtl' => Userdtl::where('cmodule', 'Task List Body Repair')->where('username', $username)->first(),
        ];
        // dd($data);
        return view('tasklist_bp.index')->with($data);
    }
    public function tasklist_bpajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $data = Tasklist_bp::select('*'); //->orderBy('kode', 'asc');
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
            return view('tasklist_bp');
        }
    }

    // public function tabel_bank(Request $request)
    // {
    //     $data = [
    //         'menu' => 'file',
    //         'submenu' => 'tasklist_bp',
    //         'submenu1' => 'ref_bp',
    //         'title' => 'Task List Body Repair',
    //         'tasklist_bp' => Tasklist_bp::orderBy('kode', 'asc')->get(),
    //     ];
    //     // var_dump($data);
    //     return view('tasklist_bp.tabel_bank')->with($data);
    // }

    public function create(Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'file',
                'submenu' => 'tasklist_bp',
                'submenu1' => 'ref_bp',
                'title' => 'Tambah Data Task List Body Repair',
                // 'tasklist_bp' => Tasklist_bp::all(),
            ];
            // var_dump($data);
            return response()->json([
                'body' => view('tasklist_bp.modaltambah', [
                    'tasklist_bp' => new Tasklist_bp(), //Tasklist_bp::first(),
                    'action' => route('tasklist_bp.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,

            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function store(Tasklist_bpRequest $request, Tasklist_bp $tasklist_bp)
    {
        if ($request->Ajax()) {
            $validated = $request->validated(
                // [
                //     'kode' => 'required|unique:tasklist_bp,kode',
                //     'nama' => 'required',
                // ],
                // [
                //     'kode.unique' => 'Kode tidak boleh sama',
                //     'kode.required' => 'Kode harus di isi',
                //     'nama.required' => 'Nama harus di isi',
                // ]
            );
            if ($validated) {
                // $tasklist_bp->fill($request->all());
                // $tasklist_bp->aktif = $request->aktif == 'on' ? 'Y' : 'N';
                // $tasklist_bp->user = $request->username . date('d-m-Y');
                $aktif = isset($request->aktif) ? 'Y' : 'N';
                $tasklist_bp->fill([
                    'kode' => isset($request->kode) ? $request->kode : '',
                    'nama' => isset($request->nama) ? $request->nama : '',
                    'nama_alias' => isset($request->nama_alias) ? $request->nama_alias : '',
                    'qty' => isset($request->qty) ? $request->qty : '',
                    'aktif' => $aktif,
                    'user' => 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $tasklist_bp->save($validated);
                $msg = [
                    'sukses' => 'Data berhasil di tambah', //view('tasklist_bp.tabel_bank')
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
                'submenu' => 'tasklist_bp',
                'submenu1' => 'ref_bp',
                'title' => 'Detail Task List Body Repair',
                'tasklist_bp' => Tasklist_bp::findOrFail($id),
                'userdtl' => Userdtl::where('cmodule', 'Task List Body Repair')->where('username', $username)->first(),
            ];
            // return view('tasklist_bp.modaldetail')->with($data);
            return response()->json([
                'body' => view('tasklist_bp.modaltambah', [
                    'tasklist_bp' => Tasklist_bp::findOrFail($id),
                    'action' => route('tasklist_bp.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function edit(Tasklist_bp $tasklist_bp, Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'file',
                'submenu' => 'tasklist_bp',
                'submenu1' => 'ref_bp',
                'title' => 'Edit Data Task List Body Repair',
            ];
            return response()->json([
                'body' => view('tasklist_bp.modaltambah', [
                    'tasklist_bp' => $tasklist_bp,
                    'action' => route('tasklist_bp.update', $tasklist_bp->id),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function update(Tasklist_bpRequest $request, Tasklist_bp $tasklist_bp)
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
                    //     'kode' => 'required|unique:tasklist_bp,kode',
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
                $tasklist_bp->fill([
                    'kode' => isset($request->kode) ? $request->kode : '',
                    'nama' => isset($request->nama) ? $request->nama : '',
                    'nama_alias' => isset($request->nama_alias) ? $request->nama_alias : '',
                    'qty' => isset($request->qty) ? $request->qty : '',
                    'aktif' => $aktif,
                    'user' => 'Update-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $tasklist_bp->save($validated);
                $msg = [
                    'sukses' => 'Data berhasil di update', //view('tasklist_bp.tabel_bank')
                ];
            } else {
                $msg = [
                    'sukses' => 'Data gagal di update', //view('tasklist_bp.tabel_bank')
                ];
            }
            echo json_encode($msg);
            // return redirect()->back()->with('message', 'Berhasil di update');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function destroy(Tasklist_bp $tasklist_bp, Request $request)
    {
        if ($request->Ajax()) {
            $tasklist_bp->delete();
            return response()->json([
                'sukses' => 'Data berhasil di hapus',
            ]);
            // return redirect()->back()->with('message', 'Berhasil di hapus');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
}
