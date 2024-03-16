<?php

namespace App\Http\Controllers;

use App\Http\Requests\TbsaRequest;
use Illuminate\Http\Request;
use Session;
// use Yajra\DataTables\Contracts\DataTables;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Tbsa;
use App\Models\Userdtl;

// //return type View
// use Illuminate\View\View;

class TbsaController extends Controller
{
    public function index(Request $request) //: View
    {
        $username = session('username');
        $data = [
            'menu' => 'file',
            'submenu' => 'tbsa',
            'submenu1' => 'ref_bengkel',
            'title' => 'Tabel Service Advisor',
            // 'tbsa' => Tbsa::all(),
            'userdtlmenu' => Userdtl::join('tbmodule', 'userdtl.cmodule', '=', 'tbmodule.cmodule')->where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
            'userdtl' => Userdtl::where('cmodule', 'Tabel Service Advisor')->where('username', $username)->first(),
        ];
        // var_dump($data);
        return view('tbsa.index')->with($data);
    }
    public function tbsaajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $data = Tbsa::select('*'); //->orderBy('kode', 'asc');
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
            return view('tbsa');
        }
    }

    public function tabel_sa(Request $request)
    {
        $data = [
            'menu' => 'file',
            'submenu' => 'tbsa',
            'submenu1' => 'ref_bengkel',
            'title' => 'Tabel Service Advisor',
            'tbsa' => Tbsa::orderBy('kode', 'asc')->get(),
        ];
        // var_dump($data);
        return view('tbsa.tabel_sa')->with($data);
    }

    public function create(Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'file',
                'submenu' => 'tbsa',
                'submenu1' => 'ref_bengkel',
                'title' => 'Tambah Data Tabel Service Advisor',
                'tbsa' => Tbsa::all(),
            ];
            // var_dump($data);
            return response()->json([
                'body' => view('tbsa.modaltambah', [
                    'tbsa' => new Tbsa(), //Tbsa::first(),
                    'action' => route('tbsa.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,

            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function store(TbsaRequest $request, Tbsa $tbsa)
    {
        if ($request->Ajax()) {
            $validated = $request->validated(
                // [
                //     'kode' => 'required|unique:tbsa,kode',
                //     'nama' => 'required',
                // ],
                // [
                //     'kode.unique' => 'Kode tidak boleh sama',
                //     'kode.required' => 'Kode harus di isi',
                //     'nama.required' => 'Nama harus di isi',
                // ]
            );
            if ($validated) {
                // $tbsa->fill($request->all());
                // $tbsa->aktif = $request->aktif == 'on' ? 'Y' : 'N';
                // $tbsa->user = $request->username . date('d-m-Y');
                $aktif = isset($request->aktif) ? 'Y' : 'N';
                $tbsa->fill([
                    'nama' => $request->nama,
                    'kode' => $request->kode,
                    'alamat' => $request->alamat,
                    'kelurahan' => $request->kelurahan,
                    'kecamatan' => $request->kecamatan,
                    'kota' => $request->kota,
                    'kodepos' => $request->kodepos,
                    'nohp' => $request->nohp,
                    'aktif' => $aktif,
                    'user' => 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $tbsa->save($validated);
                $msg = [
                    'sukses' => 'Data berhasil di tambah', //view('tbsa.tabel_sa')
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
                'submenu' => 'tbsa',
                'submenu1' => 'ref_bengkel',
                'title' => 'Detail Tabel Service Advisor',
                'tbsa' => Tbsa::findOrFail($id),
                'userdtl' => Userdtl::where('cmodule', 'Tabel Service Advisor')->where('username', $username)->first(),
            ];
            // return view('tbsa.modaldetail')->with($data);
            return response()->json([
                'body' => view('tbsa.modaltambah', [
                    'tbsa' => Tbsa::findOrFail($id),
                    'action' => route('tbsa.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function edit(Tbsa $tbsa, Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'file',
                'submenu' => 'tbsa',
                'submenu1' => 'ref_bengkel',
                'title' => 'Edit Data Tabel Service Advisor',
            ];
            return response()->json([
                'body' => view('tbsa.modaltambah', [
                    'tbsa' => $tbsa,
                    'action' => route('tbsa.update', $tbsa->id),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function update(TbsaRequest $request, Tbsa $tbsa)
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
                    //     'kode' => 'required|unique:tbsa,kode',
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
                $tbsa->fill([
                    'nama' => $request->nama,
                    'kode' => $request->kode,
                    'alamat' => $request->alamat,
                    'kelurahan' => $request->kelurahan,
                    'kecamatan' => $request->kecamatan,
                    'kota' => $request->kota,
                    'kodepos' => $request->kodepos,
                    'nohp' => $request->nohp,
                    'aktif' => $aktif,
                    'user' => 'Update-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $tbsa->save($validated);
                $msg = [
                    'sukses' => 'Data berhasil di update', //view('tbsa.tabel_sa')
                ];
            } else {
                $msg = [
                    'sukses' => 'Data gagal di update', //view('tbsa.tabel_sa')
                ];
            }
            echo json_encode($msg);
            // return redirect()->back()->with('message', 'Berhasil di update');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function destroy(Tbsa $tbsa, Request $request)
    {
        if ($request->Ajax()) {
            $tbsa->delete();
            return response()->json([
                'sukses' => 'Data berhasil di hapus',
            ]);
            // return redirect()->back()->with('message', 'Berhasil di hapus');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
}
