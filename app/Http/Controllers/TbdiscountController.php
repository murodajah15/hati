<?php

namespace App\Http\Controllers;

use App\Http\Requests\TbdiscountRequest;
use Illuminate\Http\Request;
use Session;
// use Yajra\DataTables\Contracts\DataTables;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Tbdiscount;
use App\Models\Userdtl;

// //return type View
// use Illuminate\View\View;

class TbdiscountController extends Controller
{
    public function index(Request $request) //: View
    {
        $username = session('username');
        $userdtl = Userdtl::where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get();
        $data = [
            'menu' => 'file',
            'submenu' => 'tbdiscount',
            'submenu1' => 'ref_part',
            'title' => 'Tabel Discount',
            // 'tbdiscount' => Tbdiscount::all(),
            // 'userdtlmenu' => Userdtl::join('tbmodule', 'userdtl.cmodule', '=', 'tbmodule.cmodule')->where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
            'userdtlmenu' => $userdtl,
            // 'userdtl' => Userdtl::where('cmodule', 'Tabel Discount')->where('username', $username)->first(),
        ];
        // var_dump($data);
        return view('tbdiscount.index')->with($data);
    }
    public function tbdiscountajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $data = Tbdiscount::select('*'); //->orderBy('kode', 'asc');
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
            return view('tbdiscount');
        }
    }

    public function tabel_discount(Request $request)
    {
        $data = [
            'menu' => 'file',
            'submenu' => 'tbdiscount',
            'submenu1' => 'ref_part',
            'title' => 'Tabel Discount',
            'tbdiscount' => Tbdiscount::orderBy('kode', 'asc')->get(),
        ];
        // var_dump($data);
        return view('tbdiscount.tabel_discount')->with($data);
    }

    public function create(Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'file',
                'submenu' => 'tbdiscount',
                'submenu1' => 'ref_part',
                'title' => 'Tambah Data Tabel Discount',
                // 'tbdiscount' => Tbdiscount::all(),
            ];
            // var_dump($data);
            return response()->json([
                'body' => view('tbdiscount.modaltambah', [
                    'tbdiscount' => new Tbdiscount(), //Tbdiscount::first(),
                    'action' => route('tbdiscount.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,

            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function store(TbdiscountRequest $request, Tbdiscount $tbdiscount)
    {
        if ($request->Ajax()) {
            $validated = $request->validated(
                // [
                //     'kode' => 'required|unique:tbdiscount,kode',
                //     'nama' => 'required',
                // ],
                // [
                //     'kode.unique' => 'Kode tidak boleh sama',
                //     'kode.required' => 'Kode harus di isi',
                //     'nama.required' => 'Nama harus di isi',
                // ]
            );
            if ($validated) {
                // $tbdiscount->fill($request->all());
                // $tbdiscount->aktif = $request->aktif == 'on' ? 'Y' : 'N';
                // $tbdiscount->user = $request->username . date('d-m-Y');
                $aktif = isset($request->aktif) ? 'Y' : 'N';
                $tbdiscount->fill([
                    'kode' => $request->kode,
                    'disc_normal' => $request->disc_normal,
                    'disc_urgent' => $request->disc_urgent,
                    'disc_hotline' => $request->disc_hotline,
                    'aktif' => $aktif,
                    'user' => 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $tbdiscount->save($validated);
                $msg = [
                    'sukses' => 'Data berhasil di tambah', //view('tbdiscount.tabel_discount')
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
                'submenu' => 'tbdiscount',
                'submenu1' => 'ref_part',
                'title' => 'Detail Tabel Discount',
                'tbdiscount' => Tbdiscount::findOrFail($id),
                'userdtl' => Userdtl::where('cmodule', 'Tabel Discount')->where('username', $username)->first(),
            ];
            // return view('tbdiscount.modaldetail')->with($data);
            return response()->json([
                'body' => view('tbdiscount.modaltambah', [
                    'tbdiscount' => Tbdiscount::findOrFail($id),
                    'action' => route('tbdiscount.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function edit(Tbdiscount $tbdiscount, Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'file',
                'submenu' => 'tbdiscount',
                'submenu1' => 'ref_part',
                'title' => 'Edit Data Tabel Discount',
            ];
            return response()->json([
                'body' => view('tbdiscount.modaltambah', [
                    'tbdiscount' => $tbdiscount,
                    'action' => route('tbdiscount.update', $tbdiscount->id),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function update(TbdiscountRequest $request, Tbdiscount $tbdiscount)
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
                    //     'kode' => 'required|unique:tbdiscount,kode',
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
                $tbdiscount->fill([
                    'kode' => $request->kode,
                    'disc_normal' => $request->disc_normal,
                    'disc_urgent' => $request->disc_urgent,
                    'disc_hotline' => $request->disc_hotline,
                    'aktif' => $aktif,
                    'user' => 'Update-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $tbdiscount->save($validated);
                $msg = [
                    'sukses' => 'Data berhasil di update', //view('tbdiscount.tabel_discount')
                ];
            } else {
                $msg = [
                    'sukses' => 'Data gagal di update', //view('tbdiscount.tabel_discount')
                ];
            }
            echo json_encode($msg);
            // return redirect()->back()->with('message', 'Berhasil di update');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function destroy(Tbdiscount $tbdiscount, Request $request)
    {
        if ($request->Ajax()) {
            $tbdiscount->delete();
            return response()->json([
                'sukses' => 'Data berhasil di hapus',
            ]);
            // return redirect()->back()->with('message', 'Berhasil di hapus');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
}
