<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tbpaket_detailRequest;
use Illuminate\Http\Request;
use Session;
// use Yajra\DataTables\Contracts\DataTables;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Tbpaket;
use App\Models\Tbpaket_detail;
use App\Models\Userdtl;

// //return type View
// use Illuminate\View\View;

class Tbpaket_detailController extends Controller
{
    public function index1(Request $request) //: View
    {
        $username = session('username');
        $userdtl = Userdtl::where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get();
        $data = [
            'menu' => 'file',
            'submenu' => 'tbpaket',
            'submenu1' => 'ref_bengkel',
            'title' => 'Tabel Paket',
            'userdtlmenu' => $userdtl,
        ];
        return view('tbpaket.index')->with($data);
    }
    public function index(Request $request) //: View
    {
        if ($request->Ajax()) {
            $id = $request->id;
            $username = session('username');
            $data = [
                'menu' => 'file',
                'submenu' => 'tbpaket',
                'submenu1' => 'ref_bengkel',
                'title' => 'Detail Tabel Paket',
                'tbpaket' => Tbpaket::findOrFail($id),
                'userdtl' => Userdtl::where('cmodule', 'Tabel Paket')->where('username', $username)->first(),
            ];
            // return view('tbpaket.modaldetail')->with($data);
            return response()->json([
                'body' => view('tbpaket.modaldetail', [
                    'tbpaket' => Tbpaket::findOrFail($id),
                    'userdtl' => Userdtl::where('cmodule', 'Tabel Paket')->where('username', $username)->first(),
                    'action' => route('tbpaket.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function paketjasaajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $kdpaket = $_GET['kdpaket'];
            $data = Tbpaket_detail::select('*')->where('jenis', 'JASA')->where('kdpaket', $kdpaket);
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

    public function paketpartajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $kdpaket = $_GET['kdpaket'];
            $data = Tbpaket_detail::select('*')->where('jenis', 'PART')->where('kdpaket', $kdpaket);
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

    public function paketbahanajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $kdpaket = $_GET['kdpaket'];
            $data = Tbpaket_detail::select('*')->where('jenis', 'BAHAN')->where('kdpaket', $kdpaket);
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

    public function paketoplajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $kdpaket = $_GET['kdpaket'];
            $data = Tbpaket_detail::select('*')->where('jenis', 'OPL')->where('kdpaket', $kdpaket);
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

    // public function create(Request $request)
    // {
    //     if ($request->Ajax()) {
    //         $data = [
    //             'menu' => 'file',
    //             'submenu' => 'tbpaket',
    //             'submenu1' => 'ref_bengkel',
    //             'title' => 'Tambah Data Tabel Paket',
    //             // 'tbpaket' => Tbpaket::all(),
    //         ];
    //         // var_dump($data);
    //         return response()->json([
    //             'body' => view('tbpaket.modaltambah', [
    //                 'tbpaket_detail' => new Tbpaket_detail(), //Tbpaket::first(),
    //                 'action' => route('tbpaket.store'),
    //                 'vdata' => $data,
    //             ])->render(),
    //             'data' => $data,

    //         ]);
    //     } else {
    //         exit('Maaf tidak dapat diproses');
    //     }
    // }

    public function simpanpaketjasa(Request $request, Tbpaket_detail $tbpaket_detail)
    {
        // if ($request->Ajax()) {
        // $validated = $request->validated();
        // if ($validated) {
        $kode = isset($request->kodejasa) ? $request->kodejasa : '';
        $kdpaket = isset($request->kdpaket) ? $request->kdpaket : '';
        $jenis = isset($request->jenis) ? $request->jenis : '';
        // dd($kode . $kdpaket . $jenis);
        $cekdouble = Tbpaket_detail::where('kdpaket', $kdpaket)->where('jenis', $jenis)->where('kode', $kode)->first();
        if (isset($cekdouble->kode)) {
            $msg = [
                'sukses' => false, //view('tbpaket_detail.tabel_paket_detail')
            ];
        } else {
            $aktif = isset($request->aktif) ? 'Y' : 'N';
            $kode = isset($request->kodejasa) ? $request->kodejasa : '';
            $nama = isset($request->namajasa) ? $request->namajasa : '';
            $kdpaket = isset($request->kdpaket) ? $request->kdpaket : '';
            $jenis = isset($request->jenis) ? $request->jenis : '';
            $qty = isset($request->qty) ? $request->qty : '';
            $jam = isset($request->jamjasa) ? $request->jamjasa : '';
            $frt = isset($request->frtjasa) ? $request->frtjasa : '';
            $user = 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s');
            // $tbpaket_detail->save($validated);
            Tbpaket_detail::insert([
                'kode' => $kode, 'nama' => $nama, 'kdpaket' => $kdpaket, 'jenis' => $jenis,
                'qty' => $qty, 'jam' => $jam, 'frt' => $frt, 'user' => $user
            ]);
            $msg = [
                'sukses' => true, //'Data berhasil di tambah', //view('tbpaket_detail.tabel_paket_detail')
            ];
        }
        // }
        echo json_encode($msg);
        // return redirect()->back()->with('message', 'Berhasil di simpan');
        // } else {
        //     exit('Maaf tidak dapat diproses');
        // }
    }

    public function simpanpaketpart(Request $request, Tbpaket_detail $tbpaket_detail)
    {
        // if ($request->Ajax()) {
        // $validated = $request->validated();
        // if ($validated) {
        $kode = isset($request->kodepart) ? $request->kodepart : '';
        $kdpaket = isset($request->kdpaket) ? $request->kdpaket : '';
        $jenis = isset($request->jenis) ? $request->jenis : '';
        // dd($kode . $kdpaket . $jenis);
        $cekdouble = Tbpaket_detail::where('kdpaket', $kdpaket)->where('jenis', $jenis)->where('kode', $kode)->first();
        if (isset($cekdouble->kode)) {
            $msg = [
                'sukses' => false, //view('tbpaket_detail.tabel_paket_detail')
            ];
        } else {
            $aktif = isset($request->aktif) ? 'Y' : 'N';
            $kode = isset($request->kodepart) ? $request->kodepart : '';
            $nama = isset($request->namapart) ? $request->namapart : '';
            $kdpaket = isset($request->kdpaket) ? $request->kdpaket : '';
            $jenis = isset($request->jenis) ? $request->jenis : '';
            $qty = isset($request->qtypart) ? $request->qtypart : '';
            $jam = isset($request->jam) ? $request->jam : '';
            $frt = isset($request->frt) ? $request->frt : '';
            $user = 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s');
            // $tbpaket_detail->save($validated);
            Tbpaket_detail::insert([
                'kode' => $kode, 'nama' => $nama, 'kdpaket' => $kdpaket, 'jenis' => $jenis,
                'qty' => $qty, 'jam' => $jam, 'frt' => $frt, 'user' => $user
            ]);
            $msg = [
                'sukses' => 'Data berhasil di tambah', //view('tbpaket_detail.tabel_paket_detail')
            ];
        }
        // }
        echo json_encode($msg);
        // return redirect()->back()->with('message', 'Berhasil di simpan');
        // } else {
        //     exit('Maaf tidak dapat diproses');
        // }
    }

    public function simpanpaketbahan(Request $request, Tbpaket_detail $tbpaket_detail)
    {
        // if ($request->Ajax()) {
        // $validated = $request->validated();
        // if ($validated) {
        $kode = isset($request->kodebahan) ? $request->kodebahan : '';
        $kdpaket = isset($request->kdpaket) ? $request->kdpaket : '';
        $jenis = isset($request->jenis) ? $request->jenis : '';
        // dd($kode . $kdpaket . $jenis);
        $cekdouble = Tbpaket_detail::where('kdpaket', $kdpaket)->where('jenis', $jenis)->where('kode', $kode)->first();
        if (isset($cekdouble->kode)) {
            $msg = [
                'sukses' => false, //view('tbpaket_detail.tabel_paket_detail')
            ];
        } else {
            $aktif = isset($request->aktif) ? 'Y' : 'N';
            $kode = isset($request->kodebahan) ? $request->kodebahan : '';
            $nama = isset($request->namabahan) ? $request->namabahan : '';
            $kdpaket = isset($request->kdpaket) ? $request->kdpaket : '';
            $jenis = isset($request->jenis) ? $request->jenis : '';
            $qty = isset($request->qtybahan) ? $request->qtybahan : '';
            $jam = isset($request->jam) ? $request->jam : '';
            $frt = isset($request->frt) ? $request->frt : '';
            $user = 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s');
            // $tbpaket_detail->save($validated);
            Tbpaket_detail::insert([
                'kode' => $kode, 'nama' => $nama, 'kdpaket' => $kdpaket, 'jenis' => $jenis,
                'qty' => $qty, 'jam' => $jam, 'frt' => $frt, 'user' => $user
            ]);
            $msg = [
                'sukses' => 'Data berhasil di tambah', //view('tbpaket_detail.tabel_paket_detail')
            ];
        }
        // }
        echo json_encode($msg);
        // return redirect()->back()->with('message', 'Berhasil di simpan');
        // } else {
        //     exit('Maaf tidak dapat diproses');
        // }
    }

    public function simpanpaketopl(Request $request, Tbpaket_detail $tbpaket_detail)
    {
        // if ($request->Ajax()) {
        // $validated = $request->validated();
        // if ($validated) {
        $kode = isset($request->kodeopl) ? $request->kodeopl : '';
        $kdpaket = isset($request->kdpaket) ? $request->kdpaket : '';
        $jenis = isset($request->jenis) ? $request->jenis : '';
        // dd($kode . $kdpaket . $jenis);
        $cekdouble = Tbpaket_detail::where('kdpaket', $kdpaket)->where('jenis', $jenis)->where('kode', $kode)->first();
        if (isset($cekdouble->kode)) {
            $msg = [
                'sukses' => false, //view('tbpaket_detail.tabel_paket_detail')
            ];
        } else {
            $aktif = isset($request->aktif) ? 'Y' : 'N';
            $kode = isset($request->kodeopl) ? $request->kodeopl : '';
            $nama = isset($request->namaopl) ? $request->namaopl : '';
            $kdpaket = isset($request->kdpaket) ? $request->kdpaket : '';
            $jenis = isset($request->jenis) ? $request->jenis : '';
            $qty = isset($request->qtyopl) ? $request->qtyopl : '';
            $jam = isset($request->jam) ? $request->jam : '';
            $frt = isset($request->frt) ? $request->frt : '';
            $user = 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s');
            // $tbpaket_detail->save($validated);
            Tbpaket_detail::insert([
                'kode' => $kode, 'nama' => $nama, 'kdpaket' => $kdpaket, 'jenis' => $jenis,
                'qty' => $qty, 'jam' => $jam, 'frt' => $frt, 'user' => $user
            ]);
            $msg = [
                'sukses' => 'Data berhasil di tambah', //view('tbpaket_detail.tabel_paket_detail')
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
                'submenu' => 'tbpaket',
                'submenu1' => 'ref_bengkel',
                'title' => 'Detail Tabel Paket',
                'tbpaket' => Tbpaket_detail::findOrFail($id),
                'userdtl' => Userdtl::where('cmodule', 'Tabel Paket')->where('username', $username)->first(),
            ];
            // return view('tbpaket.modaldetail')->with($data);
            return response()->json([
                'body' => view('tbpaket.modaltambah', [
                    'tbpaket_detail' => Tbpaket_detail::findOrFail($id),
                    'action' => route('tbpaket.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function editpaketjasa(Request $request)
    {
        if ($request->Ajax()) {
            // dd($request->id);
            $tbpaket_detail = Tbpaket_detail::where('id', $request->id)->first();
            $data = [
                'menu' => 'file',
                'submenu' => 'tbpaket',
                'submenu1' => 'ref_bengkel',
                'title' => 'Edit Data Paket Jasa',
            ];
            return response()->json([
                'body' => view('tbpaket.modaleditjasa', [
                    'tbpaket_detail' => $tbpaket_detail,
                    // 'action' => route('tbpaket_detail.update', $tbpaket_detail->id),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
    public function updatepaketjasa(Request $request, Tbpaket_detail $tbpaket_detail)
    {
        if ($request->Ajax()) {
            $kode = isset($request->kodejasa) ? $request->kodejasa : '';
            $nama = isset($request->namajasa) ? $request->namajasa : '';
            $kdpaket = isset($request->kdpaket) ? $request->kdpaket : '';
            $jenis = isset($request->jenis) ? $request->jenis : '';
            $qty = isset($request->qty) ? $request->qty : '';
            $jam = isset($request->jamjasa) ? $request->jamjasa : '';
            $frt = isset($request->frtjasa) ? $request->frtjasa : '';
            $user = 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s');
            Tbpaket_detail::where('id', $request->id)->update([
                'kode' => $kode, 'nama' => $nama, 'kdpaket' => $kdpaket, 'jenis' => $jenis,
                'qty' => $qty, 'jam' => $jam, 'frt' => $frt, 'user' => $user
            ]);
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

    public function editpaketpart(Request $request)
    {
        if ($request->Ajax()) {
            // dd($request->id);
            $tbpaket_detail = Tbpaket_detail::where('id', $request->id)->first();
            $data = [
                'menu' => 'file',
                'submenu' => 'tbpaket',
                'submenu1' => 'ref_bengkel',
                'title' => 'Edit Data Paket Part',
            ];
            return response()->json([
                'body' => view('tbpaket.modaleditpart', [
                    'tbpaket_detail' => $tbpaket_detail,
                    // 'action' => route('tbpaket_detail.update', $tbpaket_detail->id),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
    public function updatepaketpart(Request $request, Tbpaket_detail $tbpaket_detail)
    {
        if ($request->Ajax()) {
            $kode = isset($request->kodepart) ? $request->kodepart : '';
            $nama = isset($request->namapart) ? $request->namapart : '';
            $kdpaket = isset($request->kdpaket) ? $request->kdpaket : '';
            $jenis = isset($request->jenis) ? $request->jenis : '';
            $qty = isset($request->qtypart) ? $request->qtypart : '';
            $jam = isset($request->jampart) ? $request->jampart : '';
            $frt = isset($request->frtpart) ? $request->frtpart : '';
            $user = 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s');
            Tbpaket_detail::where('id', $request->id)->update([
                'kode' => $kode, 'nama' => $nama, 'kdpaket' => $kdpaket, 'jenis' => $jenis,
                'qty' => $qty, 'jam' => $jam, 'frt' => $frt, 'user' => $user
            ]);
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

    public function editpaketbahan(Request $request)
    {
        if ($request->Ajax()) {
            // dd($request->id);
            $tbpaket_detail = Tbpaket_detail::where('id', $request->id)->first();
            $data = [
                'menu' => 'file',
                'submenu' => 'tbpaket',
                'submenu1' => 'ref_bengkel',
                'title' => 'Edit Data Paket Bahan',
            ];
            return response()->json([
                'body' => view('tbpaket.modaleditbahan', [
                    'tbpaket_detail' => $tbpaket_detail,
                    // 'action' => route('tbpaket_detail.update', $tbpaket_detail->id),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
    public function updatepaketbahan(Request $request, Tbpaket_detail $tbpaket_detail)
    {
        if ($request->Ajax()) {
            $kode = isset($request->kodebahan) ? $request->kodebahan : '';
            $nama = isset($request->namabahan) ? $request->namabahan : '';
            $kdpaket = isset($request->kdpaket) ? $request->kdpaket : '';
            $jenis = isset($request->jenis) ? $request->jenis : '';
            $qty = isset($request->qtybahan) ? $request->qtybahan : '';
            $jam = isset($request->jambahan) ? $request->jambahan : '';
            $frt = isset($request->frtbahan) ? $request->frtbahan : '';
            $user = 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s');
            Tbpaket_detail::where('id', $request->id)->update([
                'kode' => $kode, 'nama' => $nama, 'kdpaket' => $kdpaket, 'jenis' => $jenis,
                'qty' => $qty, 'jam' => $jam, 'frt' => $frt, 'user' => $user
            ]);
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

    public function editpaketopl(Request $request)
    {
        if ($request->Ajax()) {
            // dd($request->id);
            $tbpaket_detail = Tbpaket_detail::where('id', $request->id)->first();
            $data = [
                'menu' => 'file',
                'submenu' => 'tbpaket',
                'submenu1' => 'ref_bengkel',
                'title' => 'Edit Data Paket OPL',
            ];
            return response()->json([
                'body' => view('tbpaket.modaleditopl', [
                    'tbpaket_detail' => $tbpaket_detail,
                    // 'action' => route('tbpaket_detail.update', $tbpaket_detail->id),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
    public function updatepaketopl(Request $request, Tbpaket_detail $tbpaket_detail)
    {
        if ($request->Ajax()) {
            $kode = isset($request->kodeopl) ? $request->kodeopl : '';
            $nama = isset($request->namaopl) ? $request->namaopl : '';
            $kdpaket = isset($request->kdpaket) ? $request->kdpaket : '';
            $jenis = isset($request->jenis) ? $request->jenis : '';
            $qty = isset($request->qtyopl) ? $request->qtyopl : '';
            $jam = isset($request->jamopl) ? $request->jamopl : '';
            $frt = isset($request->frtopl) ? $request->frtbahan : '';
            $user = 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s');
            Tbpaket_detail::where('id', $request->id)->update([
                'kode' => $kode, 'nama' => $nama, 'kdpaket' => $kdpaket, 'jenis' => $jenis,
                'qty' => $qty, 'jam' => $jam, 'frt' => $frt, 'user' => $user
            ]);
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

    public function update(Tbpaket_detailRequest $request, Tbpaket_detail $tbpaket_detail)
    {
        if ($request->Ajax()) {
            $validated = $request->validated();
            if ($validated) {
                $aktif = $request->aktif == 'on' ? 'Y' : 'N';
                $tbpaket_detail->fill([
                    'kode' => isset($request->kode) ? $request->kode : '',
                    'nama' => isset($request->nama) ? $request->nama : '',
                    'jenis' => isset($request->jenis) ? $request->jenis : '',
                    'kdtipe' => isset($request->kdtipe) ? $request->kdtipe : '',
                    'aktif' => $aktif,
                    'user' => 'Update-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $tbpaket_detail->save($validated);
                $msg = [
                    'sukses' => 'Data berhasil di update', //view('tbpaket_detail.tabel_paket_detail')
                ];
            } else {
                $msg = [
                    'sukses' => 'Data gagal di update', //view('tbpaket_detail.tabel_paket_detail')
                ];
            }
            echo json_encode($msg);
            // return redirect()->back()->with('message', 'Berhasil di update');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function destroy(Tbpaket_detail $tbpaket_detail, Request $request)
    {
        if ($request->Ajax()) {
            $tbpaket_detail->delete();
            return response()->json([
                'sukses' => 'Data berhasil di hapus',
            ]);
            // return redirect()->back()->with('message', 'Berhasil di hapus');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    // public function tbpaket_detail(Tbpaket $tbpaket, Request $request)
    // {
    //     if ($request->Ajax()) {
    //         $data = [
    //             'menu' => 'file',
    //             'submenu' => 'tbpaket',
    //             'submenu1' => 'ref_bengkel',
    //             'title' => 'Edit Data Tabel Paket',
    //         ];
    //         return response()->json([
    //             'body' => view('tbpaket.modaltambah', [
    //                 'tbpaket' => $tbpaket,
    //                 'tbtipe' => Tbtipe::orderBy('nama')->get(),
    //                 'action' => route('tbpaket.update', $tbpaket->id),
    //                 'vdata' => $data,
    //             ])->render(),
    //             'data' => $data,
    //         ]);
    //     } else {
    //         exit('Maaf tidak dapat diproses');
    //     }
    // }
}
