<?php

namespace App\Http\Controllers;

use App\Http\Requests\Wo_grdRequest;
use Illuminate\Http\Request;
use Session;
// use Yajra\DataTables\Contracts\DataTables;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Wo_gr;
use App\Models\Wo_grd;
use App\Models\Tasklisttipe_grd;
use App\Models\Userdtl;
use App\Models\Saplikasi;

// //return type View
// use Illuminate\View\View;

class Wo_grdController extends Controller
{
    public function tbljasa_wo_grajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $nowo = $request->nowo;
            $data = Wo_grd::where('nowo', $nowo)->where('jenis', 'JASA'); //->orderBy('kode', 'asc');
            // $data = Wo_gr::select('wo_gr.*', 'tbasuransi.nama as nmasuransi')->join('tbasuransi', 'tbasuransi.kode', '=', 'wo_gr.kdasuransi'); //->orderBy('kode', 'asc');
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
            return view('tbl_wo_jasa');
        }
    }

    public function tblpart_wo_grajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $nowo = $request->nowo;
            $data = Wo_grd::where('nowo', $nowo)->where('jenis', 'PART'); //->orderBy('kode', 'asc');
            // $data = Wo_gr::select('wo_gr.*', 'tbasuransi.nama as nmasuransi')->join('tbasuransi', 'tbasuransi.kode', '=', 'wo_gr.kdasuransi'); //->orderBy('kode', 'asc');
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
            return view('tbl_wo_part');
        }
    }

    public function tblbahan_wo_grajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $nowo = $request->nowo;
            $data = Wo_grd::where('nowo', $nowo)->where('jenis', 'BAHAN'); //->orderBy('kode', 'asc');
            // $data = Wo_gr::select('wo_gr.*', 'tbasuransi.nama as nmasuransi')->join('tbasuransi', 'tbasuransi.kode', '=', 'wo_gr.kdasuransi'); //->orderBy('kode', 'asc');
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
            return view('tbl_wo_bahan');
        }
    }

    public function tblopl_wo_grajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $nowo = $request->nowo;
            $data = Wo_grd::where('nowo', $nowo)->where('jenis', 'OPL'); //->orderBy('kode', 'asc');
            // $data = Wo_gr::select('wo_gr.*', 'tbasuransi.nama as nmasuransi')->join('tbasuransi', 'tbasuransi.kode', '=', 'wo_gr.kdasuransi'); //->orderBy('kode', 'asc');
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
            return view('tbl_wo_opl');
        }
    }

    public function create(Request $request)
    {
        if ($request->Ajax()) {
            if ($request->jenis == 'JASA' or $request->jenis == 'jasa') {
                $title = 'Tambah data jasa wo body repair';
                $view = 'wo_gr.modaltambahjasa';
            }
            if ($request->jenis == 'PART' or $request->jenis == 'part') {
                $title = 'Tambah data part wo body repair';
                $view = 'wo_gr.modaltambahpart';
            }
            if ($request->jenis == 'BAHAN' or $request->jenis == 'bahan') {
                $title = 'Tambah data bahan wo body repair';
                $view = 'wo_gr.modaltambahbahan';
            }
            if ($request->jenis == 'OPL' or $request->jenis == 'opl') {
                $title = 'Tambah data opl wo body repair';
                $view = 'wo_gr.modaltambahopl';
            }
            $data = [
                'menu' => 'transaksi',
                'submenu' => 'wo_gr',
                'submenu1' => 'body_repair',
                'title' => $title,
            ];
            return response()->json([
                'body' => view($view, [
                    'saplikasi' => Saplikasi::where('aktif', 'Y')->first(),
                    'wo_gr' => Wo_gr::where('nowo', $request->nowo)->first(),
                    'wo_grd' => new wo_grd(), //Wo_gr::first(),
                    // 'tasklisttipe_grd' => Tasklisttipe_grd::where('kdasuransi', $kdasuransi)->orderBy('nama')->get(),
                    'action' => route('wo_grd.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,

            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function store(Wo_grdRequest $request, wo_grd $wo_grd)
    {
        if ($request->Ajax()) {
            $validated = $request->validated();
            if ($validated) {
                $wo_grd->fill([
                    'nowo' => isset($request->nowo) ? $request->nowo : '',
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
                $wo_grd->save($validated);
                $wo_grd->save($validated);
                $jumjasa = Wo_grd::where('nowo', $request->nowo)->where('jenis', 'JASA')->sum('subtotal');
                $jumpart = Wo_grd::where('nowo', $request->nowo)->where('jenis', 'PART')->sum('subtotal');
                $jumbahan = Wo_grd::where('nowo', $request->nowo)->where('jenis', 'BAHAN')->sum('subtotal');
                $jumopl = Wo_grd::where('nowo', $request->nowo)->where('jenis', 'OPL')->sum('subtotal');
                $wo_gr = Wo_gr::where('nowo', $request->nowo)->first();
                $total = $jumjasa + $jumpart + $jumbahan + $jumopl;
                $pr_ppn = $wo_gr->pr_ppn;
                $ppn = $total * ($pr_ppn / 100);
                $total_wo = $total + $ppn;
                Wo_gr::where('nowo', $request->nowo)->update([
                    'total_jasa' => $jumjasa, 'total_part' => $jumpart,
                    'total_bahan' => $jumbahan, 'total_opl' => $jumopl,
                    'total' => $total, 'dpp' => $total, 'ppn' => $ppn, 'total_wo' => $total_wo
                ]);
                $msg = [
                    'sukses' => 'Data berhasil di tambah', //view('wo_gr.tabel_paket')
                ];
            }
            echo json_encode($msg);
            // return redirect()->back()->with('message', 'Berhasil di simpan');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function edit(wo_grd $wo_grd, Request $request)
    {
        if ($request->Ajax()) {
            if ($request->jenis == 'JASA' or $request->jenis == 'jasa') {
                $title = 'Edit data jasa wo body repair';
                $view = 'wo_gr.modaltambahjasa';
            }
            if ($request->jenis == 'PART' or $request->jenis == 'part') {
                $title = 'Edit data part wo body repair';
                $view = 'wo_gr.modaltambahpart';
            }
            if ($request->jenis == 'BAHAN' or $request->jenis == 'bahan') {
                $title = 'Edit data bahan wo body repair';
                $view = 'wo_gr.modaltambahbahan';
            }
            if ($request->jenis == 'OPL' or $request->jenis == 'opl') {
                $title = 'Edit data opl wo body repair';
                $view = 'wo_gr.modaltambahopl';
            }
            $data = [
                'menu' => 'transaksi',
                'submenu' => 'wo_gr',
                'submenu1' => 'body_repair',
                'title' => $title,
            ];
            return response()->json([
                'body' => view($view, [
                    'saplikasi' => Saplikasi::where('aktif', 'Y')->first(),
                    'wo_gr' => Wo_gr::where('nowo', $wo_grd->nowo)->first(),
                    'wo_grd' => $wo_grd,
                    'action' => route('wo_grd.update', $wo_grd->id),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function update(wo_grdRequest $request, wo_grd $wo_grd)
    {
        if ($request->Ajax()) {
            $validated = $request->validated();
            if ($validated) {
                $wo_grd->fill([
                    'nowo' => isset($request->nowo) ? $request->nowo : '',
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
                $wo_grd->save($validated);
                $jumjasa = Wo_grd::where('nowo', $request->nowo)->where('jenis', 'JASA')->sum('subtotal');
                $jumpart = Wo_grd::where('nowo', $request->nowo)->where('jenis', 'PART')->sum('subtotal');
                $jumbahan = Wo_grd::where('nowo', $request->nowo)->where('jenis', 'BAHAN')->sum('subtotal');
                $jumopl = Wo_grd::where('nowo', $request->nowo)->where('jenis', 'OPL')->sum('subtotal');
                $wo_gr = Wo_gr::where('nowo', $request->nowo)->first();
                $total = $jumjasa + $jumpart + $jumbahan + $jumopl;
                $pr_ppn = $wo_gr->pr_ppn;
                $ppn = $total * ($pr_ppn / 100);
                $total_wo = $total + $ppn;
                Wo_gr::where('nowo', $request->nowo)->update([
                    'total_jasa' => $jumjasa, 'total_part' => $jumpart,
                    'total_bahan' => $jumbahan, 'total_opl' => $jumopl,
                    'total' => $total, 'dpp' => $total, 'ppn' => $ppn, 'total_wo' => $total_wo
                ]);
                $msg = [
                    'sukses' => 'Data berhasil di update', //view('wo_gr.tabel_paket')
                ];
            } else {
                $msg = [
                    'sukses' => 'Data gagal di update', //view('wo_gr.tabel_paket')
                ];
            }
            echo json_encode($msg);
            // return redirect()->back()->with('message', 'Berhasil di update');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function wo_grdajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $kdtasklist = $_GET['kdtasklist'];
            $kdasuransi = $_GET['kdasuransi'];
            $data = Wo_grd::select('*')->where('kdasuransi', $kdasuransi)->where('kdtasklist', $kdtasklist);
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

    public function simpanwo_grd(Request $request, wo_grd $wo_grd)
    {
        // if ($request->Ajax()) {
        // $validated = $request->validated();
        // if ($validated) {
        $kdtasklist = isset($request->kdtasklist) ? $request->kdtasklist : '';
        $kdasuransi = isset($request->kdasuransi) ? $request->kdasuransi : '';
        $cekdouble = Wo_grd::where('kdtasklist', $kdtasklist)->where('kdasuransi', $kdasuransi)->where('kode', $request->kode)->first();
        if (isset($cekdouble->kode)) {
            $msg = [
                'sukses' => false, //view('wo_grd.tabel_paket_detail')
            ];
        } else {
            $kode = isset($request->kode) ? $request->kode : '';
            $nama = isset($request->nama) ? $request->nama : '';
            $harga = isset($request->harga) ? $request->harga : '';
            $kdtasklist = isset($request->kdtasklist) ? $request->kdtasklist : '';
            $kdasuransi = isset($request->kdasuransi) ? $request->kdasuransi : '';
            $user = 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s');
            // $wo_grd->save($validated);
            Wo_grd::insert([
                'kode' => $kode, 'nama' => $nama, 'kdtasklist' => $kdtasklist, 'kdasuransi' => $kdasuransi,
                'harga' => $harga, 'user' => $user
            ]);
            $msg = [
                'sukses' => true, //'Data berhasil di tambah', //view('wo_grd.tabel_paket_detail')
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
                'submenu' => 'wo_gr',
                'submenu1' => 'ref_bengkel',
                'title' => 'Detail WO',
                // 'wo_gr' => Wo_grd::findOrFail($id),
                'userdtl' => Userdtl::where('cmodule', 'WO Body Repair')->where('username', $username)->first(),
            ];
            $wo_grd = Wo_grd::where('id', $id)->first();
            // dd($wo_grd);
            return response()->json([
                'body' => view('wo_gr.modaldetailwo', [
                    'wo_gr' => Wo_gr::where('id', $id)->first(),
                    // 'wo_grd' => Wo_grd::findOrFail($id),
                    'action' => route('wo_grd.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function editwo_grd(Request $request)
    {
        if ($request->Ajax()) {
            // dd($request->id);
            $wo_grd = Wo_grd::where('id', $request->id)->first();
            $data = [
                'menu' => 'file',
                'submenu' => 'wo_gr',
                'submenu1' => 'ref_bengkel',
                'title' => 'Edit Data Task List Tipe',
            ];
            return response()->json([
                'body' => view('wo_gr.modaleditdetail', [
                    'wo_grd' => $wo_grd,
                    // 'action' => route('wo_grd.update', $wo_grd->id),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
    public function updatewo_grd(Request $request, wo_grd $wo_grd)
    {
        if ($request->Ajax()) {
            $kode = isset($request->kode) ? $request->kode : '';
            $nama = isset($request->nama) ? $request->nama : '';
            $harga = isset($request->harga) ? $request->harga : '';
            // $kdtasklist = isset($request->kdtasklist) ? $request->kdtasklist : '';
            // $kdasuransi = isset($request->kdasuransi) ? $request->kdasuransi : '';
            $user = 'Update-' . $request->username . ', ' . date('d-m-Y h:i:s');
            Wo_grd::where('id', $request->id)->update([
                'kode' => $kode, 'nama' => $nama, 'harga' => $harga, 'user' => $user
            ]);
            // Wo_grd::where('id', $request->id)->update([
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

    public function salinwo_grd(Request $request, wo_grd $wo_grd)
    {
        if ($request->Ajax()) {
            $kdtasklist_salin = isset($request->kdtasklist_salin) ? $request->kdtasklist_salin : '';
            $kdasuransi_salin = isset($request->kdasuransi_salin) ? $request->kdasuransi_salin : '';
            $kdasuransi = isset($request->kdasuransi) ? $request->kdasuransi : '';
            $kdtasklist = isset($request->kdtasklist) ? $request->kdtasklist : '';
            // dd($kdtasklist_salin . '   ' . $kdasuransi_salin . '   ' . $kdasuransi);
            $tltipesalin_grd = Wo_grd::where('kdtasklist', $kdtasklist_salin)->where('kdasuransi', $kdasuransi_salin)->get();
            foreach ($tltipesalin_grd as $row) {
                $cekdouble = Wo_grd::where('kdtasklist', $kdtasklist)->where('kdasuransi', $kdasuransi)->where('kode', $row->kode)->first();
                if (isset($cekdouble)) {
                    $user = 'Update-' . $request->username . ', ' . date('d-m-Y h:i:s');
                    Wo_grd::where('kdasuransi', $kdasuransi)->where('kode', $row->kode)->update([
                        'harga' => $row->harga, 'user' => $user
                    ]);
                } else {
                    $user = 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s');
                    Wo_grd::insert([
                        'kode' => $row->kode, 'nama' => $row->nama, 'kdtasklist' => $kdtasklist, 'kdasuransi' => $kdasuransi,
                        'harga' => $row->harga, 'user' => $user
                    ]);
                }
            }
            $msg = [
                'sukses' => true, //'Data berhasil di tambah', //view('wo_grd.tabel_paket_detail')
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function destroy(wo_grd $wo_grd, Request $request)
    {
        if ($request->Ajax()) {
            $row_wo_grd = Wo_grd::where('id', $request->id)->first();
            $nowo = $row_wo_grd->nowo;
            $wo_grd->delete();
            $jumjasa = Wo_grd::where('nowo', $nowo)->where('jenis', 'JASA')->sum('subtotal');
            $jumpart = Wo_grd::where('nowo', $nowo)->where('jenis', 'PART')->sum('subtotal');
            $jumbahan = Wo_grd::where('nowo', $nowo)->where('jenis', 'BAHAN')->sum('subtotal');
            $jumopl = Wo_grd::where('nowo', $nowo)->where('jenis', 'OPL')->sum('subtotal');
            $wo_gr = Wo_gr::where('nowo', $nowo)->first();
            $total = $jumjasa + $jumpart + $jumbahan + $jumopl;
            $pr_ppn = $wo_gr->pr_ppn;
            $ppn = $total * ($pr_ppn / 100);
            $total_wo = $total + $ppn;
            Wo_gr::where('nowo', $nowo)->update([
                'total_jasa' => $jumjasa, 'total_part' => $jumpart,
                'total_bahan' => $jumbahan, 'total_opl' => $jumopl,
                'total' => $total, 'dpp' => $total, 'ppn' => $ppn, 'total_wo' => $total_wo
            ]);
            return response()->json([
                'sukses' => 'Data berhasil di hapus',
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function summary_wo_gr(Request $request) //: View
    {
        if ($request->ajax()) {
            $nowo = $request->nowo;
            $wo_gr = Wo_gr::where('nowo', $nowo)->first(); //->orderBy('kode', 'asc');
            $data = [
                'wo_gr' => $wo_gr,
            ];
            echo view('wo_gr.summary', $data);
        }
    }
}
