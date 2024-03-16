<?php

namespace App\Http\Controllers;

use App\Http\Requests\TboplRequest;
use Illuminate\Http\Request;
use Session;
// use Yajra\DataTables\Contracts\DataTables;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Tbopl;
use App\Models\Tbsupplier;
use App\Models\Userdtl;

// //return type View
// use Illuminate\View\View;

class TboplController extends Controller
{
    public function index(Request $request) //: View
    {
        $username = session('username');
        $userdtl = Userdtl::where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get();
        $data = [
            'menu' => 'file',
            'submenu' => 'tbopl',
            'submenu1' => 'ref_bengkel',
            'title' => 'Tabel Order Pekerjaan Luar',
            // 'tbopl' => Tbopl::all(),
            // 'userdtlmenu' => Userdtl::join('tbmodule', 'userdtl.cmodule', '=', 'tbmodule.cmodule')->where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
            'userdtlmenu' => $userdtl,
            // 'userdtl' => Userdtl::where('cmodule', 'Tabel Order Pekerjaan Luar')->where('username', $username)->first(),
        ];
        // var_dump($data);
        return view('tbopl.index')->with($data);
    }
    public function tboplajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $data = Tbopl::select('*'); //->orderBy('kode', 'asc');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('kode1', function ($row) {
                    $id = $row['id'];
                    $btn = $row['kode']; //'<a href="#"' . 'onclick=detail(' . $id . ')>' .  $row['kode'] . '</a>';
                    return $btn;
                })
                ->rawColumns(['kode1'])
                ->make(true);
            return view('tbopl');
        }
    }

    public function tabel_opl(Request $request)
    {
        $data = [
            'menu' => 'file',
            'submenu' => 'tbopl',
            'submenu1' => 'ref_umum',
            'title' => 'Tabel Order Pekerjaan Luar',
            'tbopl' => Tbopl::orderBy('kode', 'asc')->get(),
        ];
        // var_dump($data);
        return view('tbopl.tabel_opl')->with($data);
    }

    public function create(Request $request)
    {
        if ($request->Ajax()) {
            $username = session('username');
            $data = [
                'menu' => 'file',
                'submenu' => 'tbopl',
                'submenu1' => 'ref_umum',
                'title' => 'Tambah Data Tabel Order Pekerjaan Luar',
            ];
            return response()->json([
                'body' => view('tbopl.modaltambahmaster', [
                    'tambahtbsupplier' => Userdtl::where('cmodule', 'Tabel Supplier')->where('username', $username)->first(),
                    'tbopl' => new Tbopl(),
                    'action' => route('tbopl.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,

            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function store(TboplRequest $request, Tbopl $tbopl)
    {
        if ($request->Ajax()) {
            $validated = $request->validated();
            if ($validated) {
                $tbopl->fill([
                    'kode' => isset($request->kode) ? $request->kode : '',
                    'nama' => isset($request->nama) ? $request->nama : '',
                    'kdsupplier' => isset($request->kdsupplier) ? $request->kdsupplier : '',
                    'harga_beli' => isset($request->harga_beli) ? $request->harga_beli : '',
                    'harga_jual' => isset($request->harga_jual) ? $request->harga_jual : '',
                    'user' => 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $tbopl->save($validated);
                $msg = [
                    'sukses' => 'Data berhasil di tambah', //view('tbopl.tabel_opl')
                ];
            }
            echo json_encode($msg);
            // return redirect()->back()->with('message', 'Berhasil di simpan');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    // public function show(string $id)
    public function show(Tbopl $tbopl, Request $request)
    {
        $id = $_GET['id'];
        $username = session('username');
        if ($request->Ajax()) {
            $data = [
                'menu' => 'file',
                'submenu' => 'tbopl',
                'submenu1' => 'ref_umum',
                'title' => 'Detail Tabel Order Pekerjaan Luar',
                // 'tbopl' => Tbopl::findOrFail($id),
                // 'userdtl' => Userdtl::where('cmodule', 'Tabel Order Pekerjaan Luar')->where('username', $username)->first(),
            ];
            // return view('tbopl.modaldetail')->with($data);
            return response()->json([
                'body' => view('tbopl.modaltambahmaster', [
                    'tambahtbsupplier' => Userdtl::where('cmodule', 'Tabel Supplier')->where('username', $username)->first(),
                    'tbopl' => Tbopl::findOrFail($id),
                    'action' => route('tbopl.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function edit(Tbopl $tbopl, Request $request)
    {
        if ($request->Ajax()) {
            $username = session('username');
            $data = [
                'menu' => 'file',
                'submenu' => 'tbopl',
                'submenu1' => 'ref_umum',
                'title' => 'Edit Data Tabel Order Pekerjaan Luar',
            ];
            // var_dump($data);

            // return response()->json([
            //     'data' => $data,
            // ]);
            return response()->json([
                'body' => view('tbopl.modaltambahmaster', [
                    'tambahtbsupplier' => Userdtl::where('cmodule', 'Tabel Supplier')->where('username', $username)->first(),
                    'tbopl' => $tbopl,
                    'action' => route('tbopl.update', $tbopl->id),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function update(TboplRequest $request, Tbopl $tbopl)
    {
        if ($request->Ajax()) {
            if ($request->kode === $request->kodelama) {
                $validated = $request->validated();
            } else {
                $validated = $request->validated();
            }
            if ($validated) {
                $tbopl->fill([
                    'kode' => isset($request->kode) ? $request->kode : '',
                    'nama' => isset($request->nama) ? $request->nama : '',
                    'kdsupplier' => isset($request->kdsupplier) ? $request->kdsupplier : '',
                    'harga_beli' => isset($request->harga_beli) ? $request->harga_beli : '',
                    'harga_jual' => isset($request->harga_jual) ? $request->harga_jual : '',
                    'user' => 'Update-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $tbopl->save($validated);
                $msg = [
                    'sukses' => 'Data berhasil di update', //view('tbopl.tabel_opl')
                ];
            } else {
                $msg = [
                    'sukses' => 'Data gagal di update', //view('tbopl.tabel_opl')
                ];
            }
            echo json_encode($msg);
            // return redirect()->back()->with('message', 'Berhasil di update');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function destroy(Tbopl $tbopl, Request $request)
    {
        if ($request->Ajax()) {
            $tbopl->delete();
            return response()->json([
                'sukses' => true,
            ]);
            // return redirect()->back()->with('message', 'Berhasil di hapus');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function ambildatatbsupplier(Request $request, Tbsupplier $tbsupplier)
    {
        if ($request->Ajax()) {
            $kdsupplier = $request->kdsupplier;
            $datatbsupplier = $tbsupplier->orderBy('nama')->get();
            $isidata = "<option value='' selected>[Pilih supplier]</option>";
            foreach ($datatbsupplier as $row) {
                if ($row['kode'] == $kdsupplier) {
                    $isidata .= '<option value="' . $row['kode'] . '" selected>' . $row['nama'] .  ' </option>';
                } else {
                    $isidata .= '<option value="' . $row['kode'] . '">' . $row['nama'] . '</option>';
                }
            }
            $msg = [
                'data' => $isidata
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function tambahtbsupplier(Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'file',
                'submenu' => 'tbopl',
                'title' => 'Tambah Data Tabel supplier',
                // 'tbsupplier' => $this->tbsupplierModel->getid()
            ];
            // dd($data);
            $msg = [
                'data' => view('tbopl/tambahtbsupplier', $data),
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function carisupplier(Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                // 'menu' => 'file',
                // 'submenu' => 'tbcustomer',
                // 'submenu1' => 'ref_umum',
                'title' => 'Cari Negara',
            ];
            // var_dump($data);
            return response()->json([
                'body' => view('tbopl.modalcari', [
                    'tbnegara' => Tbsupplier::all(),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
    public function replsupplier(Request $request)
    {
        if ($request->Ajax()) {
            $kode = $_GET['kode'];
            $row = Tbsupplier::where('kode', $kode)->first();
            if (isset($row)) {
                $data = [
                    'kdsupplier' => $row['kode'],
                    'nmsupplier' => $row['nama'],
                ];
            } else {
                $data = [
                    'kdsupplier' => '',
                    'nmsupplier' => '',
                ];
            }
            echo json_encode($data);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
}
