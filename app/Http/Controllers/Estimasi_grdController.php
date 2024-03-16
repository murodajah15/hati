<?php

namespace App\Http\Controllers;

use App\Http\Requests\Estimasi_grdRequest;
use Illuminate\Http\Request;
use Session;
// use Yajra\DataTables\Contracts\DataTables;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Estimasi_gr;
use App\Models\Estimasi_grd;
use App\Models\Tasklisttipe_grd;
use App\Models\Userdtl;
use App\Models\Saplikasi;

// //return type View
// use Illuminate\View\View;

class Estimasi_grdController extends Controller
{

    public function tbljasa_estimasi_grajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $noestimasi = $request->noestimasi;
            $data = Estimasi_grd::where('noestimasi', $noestimasi)->where('jenis', 'JASA'); //->orderBy('kode', 'asc');
            // $data = Estimasi_gr::select('estimasi_gr.*', 'tbasuransi.nama as nmasuransi')->join('tbasuransi', 'tbasuransi.kode', '=', 'estimasi_gr.kdasuransi'); //->orderBy('kode', 'asc');
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
            return view('tbl_estimasi_jasa');
        }
    }

    public function tblpart_estimasi_grajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $noestimasi = $request->noestimasi;
            $data = Estimasi_grd::where('noestimasi', $noestimasi)->where('jenis', 'PART'); //->orderBy('kode', 'asc');
            // $data = Estimasi_gr::select('estimasi_gr.*', 'tbasuransi.nama as nmasuransi')->join('tbasuransi', 'tbasuransi.kode', '=', 'estimasi_gr.kdasuransi'); //->orderBy('kode', 'asc');
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
            return view('tbl_estimasi_part');
        }
    }

    public function tblbahan_estimasi_grajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $noestimasi = $request->noestimasi;
            $data = Estimasi_grd::where('noestimasi', $noestimasi)->where('jenis', 'BAHAN'); //->orderBy('kode', 'asc');
            // $data = Estimasi_gr::select('estimasi_gr.*', 'tbasuransi.nama as nmasuransi')->join('tbasuransi', 'tbasuransi.kode', '=', 'estimasi_gr.kdasuransi'); //->orderBy('kode', 'asc');
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
            return view('tbl_estimasi_bahan');
        }
    }

    public function tblopl_estimasi_grajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $noestimasi = $request->noestimasi;
            $data = Estimasi_grd::where('noestimasi', $noestimasi)->where('jenis', 'OPL'); //->orderBy('kode', 'asc');
            // $data = Estimasi_gr::select('estimasi_gr.*', 'tbasuransi.nama as nmasuransi')->join('tbasuransi', 'tbasuransi.kode', '=', 'estimasi_gr.kdasuransi'); //->orderBy('kode', 'asc');
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
            return view('tbl_estimasi_opl');
        }
    }

    public function create(Request $request)
    {
        if ($request->Ajax()) {
            if ($request->jenis == 'JASA') {
                $title = 'Tambah data jasa estimasi generai repair';
                $view = 'estimasi_gr.modaltambahjasa';
            }
            if ($request->jenis == 'PART') {
                $title = 'Tambah data part estimasi generai repair';
                $view = 'estimasi_gr.modaltambahpart';
            }
            if ($request->jenis == 'BAHAN') {
                $title = 'Tambah data bahan estimasi generai repair';
                $view = 'estimasi_gr.modaltambahbahan';
            }
            if ($request->jenis == 'OPL') {
                $title = 'Tambah data opl estimasi generai repair';
                $view = 'estimasi_gr.modaltambahopl';
            }
            $data = [
                'menu' => 'transaksi',
                'submenu' => 'estimasi_gr',
                'submenu1' => 'body_repair',
                'title' => $title,
            ];
            return response()->json([
                'body' => view($view, [
                    'saplikasi' => Saplikasi::where('aktif', 'Y')->first(),
                    'estimasi_gr' => Estimasi_gr::where('noestimasi', $request->noestimasi)->first(),
                    'estimasi_grd' => new estimasi_grd(), //Estimasi_gr::first(),
                    // 'tasklisttipe_grd' => Tasklisttipe_grd::where('kdasuransi', $kdasuransi)->orderBy('nama')->get(),
                    'action' => route('estimasi_grd.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,

            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function store(estimasi_grdRequest $request, estimasi_grd $estimasi_grd)
    {
        if ($request->Ajax()) {
            $validated = $request->validated();
            if ($validated) {
                $estimasi_grd->fill([
                    'noestimasi' => isset($request->noestimasi) ? $request->noestimasi : '',
                    'jenis' => isset($request->jenis) ? $request->jenis : '',
                    'kode' => isset($request->kode) ? $request->kode : '',
                    'nama' => isset($request->nama) ? $request->nama : '',
                    'harga' => isset($request->harga) ? $request->harga : '',
                    'qty' => isset($request->qty) ? $request->qty : '',
                    'pr_discount' => isset($request->pr_discount) ? $request->pr_discount : '',
                    'subtotal' => isset($request->subtotal) ? $request->subtotal : '',
                    'kerusakan' => isset($request->kerusakan) ? $request->kerusakan : '',
                    'user' => 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $estimasi_grd->save($validated);
                $estimasi_grd->save($validated);
                $jumjasa = Estimasi_grd::where('noestimasi', $request->noestimasi)->where('jenis', 'JASA')->sum('subtotal');
                $jumpart = Estimasi_grd::where('noestimasi', $request->noestimasi)->where('jenis', 'PART')->sum('subtotal');
                $jumbahan = Estimasi_grd::where('noestimasi', $request->noestimasi)->where('jenis', 'BAHAN')->sum('subtotal');
                $jumopl = Estimasi_grd::where('noestimasi', $request->noestimasi)->where('jenis', 'OPL')->sum('subtotal');
                $estimasi_gr = Estimasi_gr::where('noestimasi', $request->noestimasi)->first();
                $total = $jumjasa + $jumpart + $jumbahan + $jumopl;
                $pr_ppn = $estimasi_gr->pr_ppn;
                $ppn = $total * ($pr_ppn / 100);
                $total_estimasi = $total + $ppn;
                Estimasi_gr::where('noestimasi', $request->noestimasi)->update([
                    'total_jasa' => $jumjasa, 'total_part' => $jumpart,
                    'total_bahan' => $jumbahan, 'total_opl' => $jumopl,
                    'total' => $total, 'dpp' => $total, 'ppn' => $ppn, 'total_estimasi' => $total_estimasi
                ]);
                $msg = [
                    'sukses' => 'Data berhasil di tambah', //view('estimasi_gr.tabel_paket')
                ];
            }
            echo json_encode($msg);
            // return redirect()->back()->with('message', 'Berhasil di simpan');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function edit(estimasi_grd $estimasi_grd, Request $request)
    {
        if ($request->Ajax()) {
            if ($request->jenis == 'JASA') {
                $title = 'Edit data jasa estimasi generai repair';
                $view = 'estimasi_gr.modaltambahjasa';
            }
            if ($request->jenis == 'PART') {
                $title = 'Edit data part estimasi generai repair';
                $view = 'estimasi_gr.modaltambahpart';
            }
            if ($request->jenis == 'BAHAN') {
                $title = 'Edit data bahan estimasi generai repair';
                $view = 'estimasi_gr.modaltambahbahan';
            }
            if ($request->jenis == 'OPL') {
                $title = 'Edit data opl estimasi generai repair';
                $view = 'estimasi_gr.modaltambahopl';
            }
            $data = [
                'menu' => 'transaksi',
                'submenu' => 'estimasi_gr',
                'submenu1' => 'body_repair',
                'title' => $title,
            ];
            return response()->json([
                'body' => view($view, [
                    'saplikasi' => Saplikasi::where('aktif', 'Y')->first(),
                    'estimasi_gr' => Estimasi_gr::where('noestimasi', $estimasi_grd->noestimasi)->first(),
                    'estimasi_grd' => $estimasi_grd,
                    'action' => route('estimasi_grd.update', $estimasi_grd->id),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function update(estimasi_grdRequest $request, estimasi_grd $estimasi_grd)
    {
        if ($request->Ajax()) {
            $validated = $request->validated();
            if ($validated) {
                $estimasi_grd->fill([
                    'noestimasi' => isset($request->noestimasi) ? $request->noestimasi : '',
                    'jenis' => isset($request->jenis) ? $request->jenis : '',
                    'kode' => isset($request->kode) ? $request->kode : '',
                    'nama' => isset($request->nama) ? $request->nama : '',
                    'harga' => isset($request->harga) ? $request->harga : '',
                    'qty' => isset($request->qty) ? $request->qty : '',
                    'pr_discount' => isset($request->pr_discount) ? $request->pr_discount : '',
                    'subtotal' => isset($request->subtotal) ? $request->subtotal : '',
                    'kerusakan' => isset($request->kerusakan) ? $request->kerusakan : '',
                    'user' => 'Update-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $estimasi_grd->save($validated);
                $jumjasa = Estimasi_grd::where('noestimasi', $request->noestimasi)->where('jenis', 'JASA')->sum('subtotal');
                $jumpart = Estimasi_grd::where('noestimasi', $request->noestimasi)->where('jenis', 'PART')->sum('subtotal');
                $jumbahan = Estimasi_grd::where('noestimasi', $request->noestimasi)->where('jenis', 'BAHAN')->sum('subtotal');
                $jumopl = Estimasi_grd::where('noestimasi', $request->noestimasi)->where('jenis', 'OPL')->sum('subtotal');
                $estimasi_gr = Estimasi_gr::where('noestimasi', $request->noestimasi)->first();
                $total = $jumjasa + $jumpart + $jumbahan + $jumopl;
                $pr_ppn = $estimasi_gr->pr_ppn;
                $ppn = $total * ($pr_ppn / 100);
                $total_estimasi = $total + $ppn;
                Estimasi_gr::where('noestimasi', $request->noestimasi)->update([
                    'total_jasa' => $jumjasa, 'total_part' => $jumpart,
                    'total_bahan' => $jumbahan, 'total_opl' => $jumopl,
                    'total' => $total, 'dpp' => $total, 'ppn' => $ppn, 'total_estimasi' => $total_estimasi
                ]);
                $msg = [
                    'sukses' => 'Data berhasil di update', //view('estimasi_gr.tabel_paket')
                ];
            } else {
                $msg = [
                    'sukses' => 'Data gagal di update', //view('estimasi_gr.tabel_paket')
                ];
            }
            echo json_encode($msg);
            // return redirect()->back()->with('message', 'Berhasil di update');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function estimasi_grdajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $kdtasklist = $_GET['kdtasklist'];
            $kdasuransi = $_GET['kdasuransi'];
            $data = Estimasi_grd::select('*')->where('kdasuransi', $kdasuransi)->where('kdtasklist', $kdtasklist);
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

    public function simpanestimasi_grd(Request $request, Estimasi_grd $Estimasi_grd)
    {
        // if ($request->Ajax()) {
        // $validated = $request->validated();
        // if ($validated) {
        $kdtasklist = isset($request->kdtasklist) ? $request->kdtasklist : '';
        $kdasuransi = isset($request->kdasuransi) ? $request->kdasuransi : '';
        $cekdouble = Estimasi_grd::where('kdtasklist', $kdtasklist)->where('kdasuransi', $kdasuransi)->where('kode', $request->kode)->first();
        if (isset($cekdouble->kode)) {
            $msg = [
                'sukses' => false, //view('Estimasi_grd.tabel_paket_detail')
            ];
        } else {
            $kode = isset($request->kode) ? $request->kode : '';
            $nama = isset($request->nama) ? $request->nama : '';
            $harga = isset($request->harga) ? $request->harga : '';
            $kdtasklist = isset($request->kdtasklist) ? $request->kdtasklist : '';
            $kdasuransi = isset($request->kdasuransi) ? $request->kdasuransi : '';
            $user = 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s');
            // $Estimasi_grd->save($validated);
            Estimasi_grd::insert([
                'kode' => $kode, 'nama' => $nama, 'kdtasklist' => $kdtasklist, 'kdasuransi' => $kdasuransi,
                'harga' => $harga, 'user' => $user
            ]);
            $msg = [
                'sukses' => true, //'Data berhasil di tambah', //view('Estimasi_grd.tabel_paket_detail')
            ];
        }
        // }
        echo json_encode($msg);
        // return redirect()->back()->with('message', 'Berhasil di simpan');
        // } else {
        //     exit('Maaf tidak dapat diproses');
        // }
    }

    public function show(Request $request)
    {
        if ($request->Ajax()) {
            $id = $request->id;
            $username = session('username');
            $data = [
                'menu' => 'file',
                'submenu' => 'Estimasi_gr',
                'submenu1' => 'ref_bengkel',
                'title' => 'Detail Jasa Estimasi',
                // 'estimasi_gr' => Estimasi_grd::findOrFail($id),
                'userdtl' => Userdtl::where('cmodule', 'Estimasi WO General Repair')->where('username', $username)->first(),
            ];
            $estimasi_grd = Estimasi_grd::where('id', $id)->first();
            // dd($estimasi_grd);
            return response()->json([
                'body' => view('estimasi_gr.modaltambahjasa', [
                    'estimasi_gr' => Estimasi_gr::where('noestimasi', $estimasi_grd->noestimasi)->first(),
                    'estimasi_grd' => Estimasi_grd::findOrFail($id),
                    'action' => route('estimasi_grd.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function editestimasi_grd(Request $request)
    {
        if ($request->Ajax()) {
            // dd($request->id);
            $Estimasi_grd = Estimasi_grd::where('id', $request->id)->first();
            $data = [
                'menu' => 'file',
                'submenu' => 'Estimasi_gr',
                'submenu1' => 'ref_bengkel',
                'title' => 'Edit Data Task List Tipe',
            ];
            return response()->json([
                'body' => view('estimasi_gr.modaleditdetail', [
                    'estimasi_grd' => $Estimasi_grd,
                    // 'action' => route('Estimasi_grd.update', $Estimasi_grd->id),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
    public function updateestimasi_grd(Request $request, Estimasi_grd $Estimasi_grd)
    {
        if ($request->Ajax()) {
            $kode = isset($request->kode) ? $request->kode : '';
            $nama = isset($request->nama) ? $request->nama : '';
            $harga = isset($request->harga) ? $request->harga : '';
            // $kdtasklist = isset($request->kdtasklist) ? $request->kdtasklist : '';
            // $kdasuransi = isset($request->kdasuransi) ? $request->kdasuransi : '';
            $user = 'Update-' . $request->username . ', ' . date('d-m-Y h:i:s');
            Estimasi_grd::where('id', $request->id)->update([
                'kode' => $kode, 'nama' => $nama, 'harga' => $harga, 'user' => $user
            ]);
            // Estimasi_grd::where('id', $request->id)->update([
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

    public function salinestimasi_grd(Request $request, Estimasi_grd $Estimasi_grd)
    {
        if ($request->Ajax()) {
            $kdtasklist_salin = isset($request->kdtasklist_salin) ? $request->kdtasklist_salin : '';
            $kdasuransi_salin = isset($request->kdasuransi_salin) ? $request->kdasuransi_salin : '';
            $kdasuransi = isset($request->kdasuransi) ? $request->kdasuransi : '';
            $kdtasklist = isset($request->kdtasklist) ? $request->kdtasklist : '';
            // dd($kdtasklist_salin . '   ' . $kdasuransi_salin . '   ' . $kdasuransi);
            $tltipesalin_grd = Estimasi_grd::where('kdtasklist', $kdtasklist_salin)->where('kdasuransi', $kdasuransi_salin)->get();
            foreach ($tltipesalin_grd as $row) {
                $cekdouble = Estimasi_grd::where('kdtasklist', $kdtasklist)->where('kdasuransi', $kdasuransi)->where('kode', $row->kode)->first();
                if (isset($cekdouble)) {
                    $user = 'Update-' . $request->username . ', ' . date('d-m-Y h:i:s');
                    Estimasi_grd::where('kdasuransi', $kdasuransi)->where('kode', $row->kode)->update([
                        'harga' => $row->harga, 'user' => $user
                    ]);
                } else {
                    $user = 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s');
                    Estimasi_grd::insert([
                        'kode' => $row->kode, 'nama' => $row->nama, 'kdtasklist' => $kdtasklist, 'kdasuransi' => $kdasuransi,
                        'harga' => $row->harga, 'user' => $user
                    ]);
                }
            }
            $msg = [
                'sukses' => true, //'Data berhasil di tambah', //view('Estimasi_grd.tabel_paket_detail')
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function destroy(estimasi_grd $estimasi_grd, Request $request)
    {
        if ($request->Ajax()) {
            $row_estimasi_grd = Estimasi_grd::where('id', $request->id)->first();
            $noestimasi = $row_estimasi_grd->noestimasi;
            $estimasi_grd->delete();
            $jumjasa = Estimasi_grd::where('noestimasi', $noestimasi)->where('jenis', 'JASA')->sum('subtotal');
            $jumpart = Estimasi_grd::where('noestimasi', $noestimasi)->where('jenis', 'PART')->sum('subtotal');
            $jumbahan = Estimasi_grd::where('noestimasi', $noestimasi)->where('jenis', 'BAHAN')->sum('subtotal');
            $jumopl = Estimasi_grd::where('noestimasi', $noestimasi)->where('jenis', 'OPL')->sum('subtotal');
            $estimasi_gr = Estimasi_gr::where('noestimasi', $noestimasi)->first();
            $total = $jumjasa + $jumpart + $jumbahan + $jumopl;
            $pr_ppn = $estimasi_gr->pr_ppn;
            $ppn = $total * ($pr_ppn / 100);
            $total_estimasi = $total + $ppn;
            Estimasi_gr::where('noestimasi', $noestimasi)->update([
                'total_jasa' => $jumjasa, 'total_part' => $jumpart,
                'total_bahan' => $jumbahan, 'total_opl' => $jumopl,
                'total' => $total, 'dpp' => $total, 'ppn' => $ppn, 'total_estimasi' => $total_estimasi
            ]);
            return response()->json([
                'sukses' => 'Data berhasil di hapus',
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function summary_estimasi_gr(Request $request) //: View
    {
        if ($request->ajax()) {
            $noestimasi = $request->noestimasi;
            $estimasi_gr = Estimasi_gr::where('noestimasi', $noestimasi)->first(); //->orderBy('kode', 'asc');
            $data = [
                'estimasi_gr' => $estimasi_gr,
            ];
            echo view('estimasi_gr.summary', $data);
        }
    }
}
