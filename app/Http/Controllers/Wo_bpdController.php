<?php

namespace App\Http\Controllers;

use App\Http\Requests\Wo_bpdRequest;
use Illuminate\Http\Request;
use Session;
// use Yajra\DataTables\Contracts\DataTables;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Wo_bp;
use App\Models\Wo_bpd;
use App\Models\Tasklisttipe_bpd;
use App\Models\Userdtl;
use App\Models\Saplikasi;

// //return type View
// use Illuminate\View\View;

class Wo_bpdController extends Controller
{
    public function tbljasa_wo_bpajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $nowo = $request->nowo;
            $data = Wo_bpd::where('nowo', $nowo)->where('jenis', 'JASA'); //->orderBy('kode', 'asc');
            // $data = Wo_bp::select('wo_bp.*', 'tbasuransi.nama as nmasuransi')->join('tbasuransi', 'tbasuransi.kode', '=', 'wo_bp.kdasuransi'); //->orderBy('kode', 'asc');
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

    public function tblpart_wo_bpajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $nowo = $request->nowo;
            $data = Wo_bpd::where('nowo', $nowo)->where('jenis', 'PART'); //->orderBy('kode', 'asc');
            // $data = Wo_bp::select('wo_bp.*', 'tbasuransi.nama as nmasuransi')->join('tbasuransi', 'tbasuransi.kode', '=', 'wo_bp.kdasuransi'); //->orderBy('kode', 'asc');
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

    public function tblbahan_wo_bpajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $nowo = $request->nowo;
            $data = Wo_bpd::where('nowo', $nowo)->where('jenis', 'BAHAN'); //->orderBy('kode', 'asc');
            // $data = Wo_bp::select('wo_bp.*', 'tbasuransi.nama as nmasuransi')->join('tbasuransi', 'tbasuransi.kode', '=', 'wo_bp.kdasuransi'); //->orderBy('kode', 'asc');
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

    public function tblopl_wo_bpajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $nowo = $request->nowo;
            $data = Wo_bpd::where('nowo', $nowo)->where('jenis', 'OPL'); //->orderBy('kode', 'asc');
            // $data = Wo_bp::select('wo_bp.*', 'tbasuransi.nama as nmasuransi')->join('tbasuransi', 'tbasuransi.kode', '=', 'wo_bp.kdasuransi'); //->orderBy('kode', 'asc');
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
                $view = 'wo_bp.modaltambahjasa';
            }
            if ($request->jenis == 'PART' or $request->jenis == 'part') {
                $title = 'Tambah data part wo body repair';
                $view = 'wo_bp.modaltambahpart';
            }
            if ($request->jenis == 'BAHAN' or $request->jenis == 'bahan') {
                $title = 'Tambah data bahan wo body repair';
                $view = 'wo_bp.modaltambahbahan';
            }
            if ($request->jenis == 'OPL' or $request->jenis == 'opl') {
                $title = 'Tambah data opl wo body repair';
                $view = 'wo_bp.modaltambahopl';
            }
            $data = [
                'menu' => 'transaksi',
                'submenu' => 'wo_bp',
                'submenu1' => 'body_repair',
                'title' => $title,
            ];
            return response()->json([
                'body' => view($view, [
                    'saplikasi' => Saplikasi::where('aktif', 'Y')->first(),
                    'wo_bp' => Wo_bp::where('nowo', $request->nowo)->first(),
                    'wo_bpd' => new wo_bpd(), //Wo_bp::first(),
                    // 'tasklisttipe_bpd' => Tasklisttipe_bpd::where('kdasuransi', $kdasuransi)->orderBy('nama')->get(),
                    'action' => route('wo_bpd.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,

            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function store(wo_bpdRequest $request, wo_bpd $wo_bpd)
    {
        if ($request->Ajax()) {
            $validated = $request->validated();
            if ($validated) {
                $wo_bpd->fill([
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
                $wo_bpd->save($validated);
                $wo_bpd->save($validated);
                $jumjasa = Wo_bpd::where('nowo', $request->nowo)->where('jenis', 'JASA')->sum('subtotal');
                $jumpart = Wo_bpd::where('nowo', $request->nowo)->where('jenis', 'PART')->sum('subtotal');
                $jumbahan = Wo_bpd::where('nowo', $request->nowo)->where('jenis', 'BAHAN')->sum('subtotal');
                $jumopl = Wo_bpd::where('nowo', $request->nowo)->where('jenis', 'OPL')->sum('subtotal');
                $wo_bp = Wo_bp::where('nowo', $request->nowo)->first();
                $total = $jumjasa + $jumpart + $jumbahan + $jumopl;
                $pr_ppn = $wo_bp->pr_ppn;
                $ppn = $total * ($pr_ppn / 100);
                $total_wo = $total + $ppn;
                Wo_bp::where('nowo', $request->nowo)->update([
                    'total_jasa' => $jumjasa, 'total_part' => $jumpart,
                    'total_bahan' => $jumbahan, 'total_opl' => $jumopl,
                    'total' => $total, 'dpp' => $total, 'ppn' => $ppn, 'total_wo' => $total_wo
                ]);
                $msg = [
                    'sukses' => 'Data berhasil di tambah', //view('wo_bp.tabel_paket')
                ];
            }
            echo json_encode($msg);
            // return redirect()->back()->with('message', 'Berhasil di simpan');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function edit(wo_bpd $wo_bpd, Request $request)
    {
        if ($request->Ajax()) {
            if ($request->jenis == 'JASA' or $request->jenis == 'jasa') {
                $title = 'Edit data jasa wo body repair';
                $view = 'wo_bp.modaltambahjasa';
            }
            if ($request->jenis == 'PART' or $request->jenis == 'part') {
                $title = 'Edit data part wo body repair';
                $view = 'wo_bp.modaltambahpart';
            }
            if ($request->jenis == 'BAHAN' or $request->jenis == 'bahan') {
                $title = 'Edit data bahan wo body repair';
                $view = 'wo_bp.modaltambahbahan';
            }
            if ($request->jenis == 'OPL' or $request->jenis == 'opl') {
                $title = 'Edit data opl wo body repair';
                $view = 'wo_bp.modaltambahopl';
            }
            $data = [
                'menu' => 'transaksi',
                'submenu' => 'wo_bp',
                'submenu1' => 'body_repair',
                'title' => $title,
            ];
            return response()->json([
                'body' => view($view, [
                    'saplikasi' => Saplikasi::where('aktif', 'Y')->first(),
                    'wo_bp' => Wo_bp::where('nowo', $wo_bpd->nowo)->first(),
                    'wo_bpd' => $wo_bpd,
                    'action' => route('wo_bpd.update', $wo_bpd->id),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function update(wo_bpdRequest $request, wo_bpd $wo_bpd)
    {
        if ($request->Ajax()) {
            $validated = $request->validated();
            if ($validated) {
                $wo_bpd->fill([
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
                $wo_bpd->save($validated);
                $jumjasa = Wo_bpd::where('nowo', $request->nowo)->where('jenis', 'JASA')->sum('subtotal');
                $jumpart = Wo_bpd::where('nowo', $request->nowo)->where('jenis', 'PART')->sum('subtotal');
                $jumbahan = Wo_bpd::where('nowo', $request->nowo)->where('jenis', 'BAHAN')->sum('subtotal');
                $jumopl = Wo_bpd::where('nowo', $request->nowo)->where('jenis', 'OPL')->sum('subtotal');
                $wo_bp = Wo_bp::where('nowo', $request->nowo)->first();
                $total = $jumjasa + $jumpart + $jumbahan + $jumopl;
                $pr_ppn = $wo_bp->pr_ppn;
                $ppn = $total * ($pr_ppn / 100);
                $total_wo = $total + $ppn;
                Wo_bp::where('nowo', $request->nowo)->update([
                    'total_jasa' => $jumjasa, 'total_part' => $jumpart,
                    'total_bahan' => $jumbahan, 'total_opl' => $jumopl,
                    'total' => $total, 'dpp' => $total, 'ppn' => $ppn, 'total_wo' => $total_wo
                ]);
                $msg = [
                    'sukses' => 'Data berhasil di update', //view('wo_bp.tabel_paket')
                ];
            } else {
                $msg = [
                    'sukses' => 'Data gagal di update', //view('wo_bp.tabel_paket')
                ];
            }
            echo json_encode($msg);
            // return redirect()->back()->with('message', 'Berhasil di update');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function wo_bpdajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $kdtasklist = $_GET['kdtasklist'];
            $kdasuransi = $_GET['kdasuransi'];
            $data = Wo_bpd::select('*')->where('kdasuransi', $kdasuransi)->where('kdtasklist', $kdtasklist);
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

    public function simpanwo_bpd(Request $request, wo_bpd $wo_bpd)
    {
        // if ($request->Ajax()) {
        // $validated = $request->validated();
        // if ($validated) {
        $kdtasklist = isset($request->kdtasklist) ? $request->kdtasklist : '';
        $kdasuransi = isset($request->kdasuransi) ? $request->kdasuransi : '';
        $cekdouble = Wo_bpd::where('kdtasklist', $kdtasklist)->where('kdasuransi', $kdasuransi)->where('kode', $request->kode)->first();
        if (isset($cekdouble->kode)) {
            $msg = [
                'sukses' => false, //view('wo_bpd.tabel_paket_detail')
            ];
        } else {
            $kode = isset($request->kode) ? $request->kode : '';
            $nama = isset($request->nama) ? $request->nama : '';
            $harga = isset($request->harga) ? $request->harga : '';
            $kdtasklist = isset($request->kdtasklist) ? $request->kdtasklist : '';
            $kdasuransi = isset($request->kdasuransi) ? $request->kdasuransi : '';
            $user = 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s');
            // $wo_bpd->save($validated);
            Wo_bpd::insert([
                'kode' => $kode, 'nama' => $nama, 'kdtasklist' => $kdtasklist, 'kdasuransi' => $kdasuransi,
                'harga' => $harga, 'user' => $user
            ]);
            $msg = [
                'sukses' => true, //'Data berhasil di tambah', //view('wo_bpd.tabel_paket_detail')
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
                'submenu' => 'wo_bp',
                'submenu1' => 'ref_bengkel',
                'title' => 'Detail WO',
                // 'wo_bp' => Wo_bpd::findOrFail($id),
                'userdtl' => Userdtl::where('cmodule', 'WO Body Repair')->where('username', $username)->first(),
            ];
            $wo_bpd = Wo_bpd::where('id', $id)->first();
            // dd($wo_bpd);
            return response()->json([
                'body' => view('wo_bp.modaldetailwo', [
                    'wo_bp' => Wo_bp::where('id', $id)->first(),
                    // 'wo_bpd' => Wo_bpd::findOrFail($id),
                    'action' => route('wo_bpd.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function editwo_bpd(Request $request)
    {
        if ($request->Ajax()) {
            // dd($request->id);
            $wo_bpd = Wo_bpd::where('id', $request->id)->first();
            $data = [
                'menu' => 'file',
                'submenu' => 'wo_bp',
                'submenu1' => 'ref_bengkel',
                'title' => 'Edit Data Task List Tipe',
            ];
            return response()->json([
                'body' => view('wo_bp.modaleditdetail', [
                    'wo_bpd' => $wo_bpd,
                    // 'action' => route('wo_bpd.update', $wo_bpd->id),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
    public function updatewo_bpd(Request $request, wo_bpd $wo_bpd)
    {
        if ($request->Ajax()) {
            $kode = isset($request->kode) ? $request->kode : '';
            $nama = isset($request->nama) ? $request->nama : '';
            $harga = isset($request->harga) ? $request->harga : '';
            // $kdtasklist = isset($request->kdtasklist) ? $request->kdtasklist : '';
            // $kdasuransi = isset($request->kdasuransi) ? $request->kdasuransi : '';
            $user = 'Update-' . $request->username . ', ' . date('d-m-Y h:i:s');
            Wo_bpd::where('id', $request->id)->update([
                'kode' => $kode, 'nama' => $nama, 'harga' => $harga, 'user' => $user
            ]);
            // Wo_bpd::where('id', $request->id)->update([
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

    public function salinwo_bpd(Request $request, wo_bpd $wo_bpd)
    {
        if ($request->Ajax()) {
            $kdtasklist_salin = isset($request->kdtasklist_salin) ? $request->kdtasklist_salin : '';
            $kdasuransi_salin = isset($request->kdasuransi_salin) ? $request->kdasuransi_salin : '';
            $kdasuransi = isset($request->kdasuransi) ? $request->kdasuransi : '';
            $kdtasklist = isset($request->kdtasklist) ? $request->kdtasklist : '';
            // dd($kdtasklist_salin . '   ' . $kdasuransi_salin . '   ' . $kdasuransi);
            $tltipesalin_bpd = Wo_bpd::where('kdtasklist', $kdtasklist_salin)->where('kdasuransi', $kdasuransi_salin)->get();
            foreach ($tltipesalin_bpd as $row) {
                $cekdouble = Wo_bpd::where('kdtasklist', $kdtasklist)->where('kdasuransi', $kdasuransi)->where('kode', $row->kode)->first();
                if (isset($cekdouble)) {
                    $user = 'Update-' . $request->username . ', ' . date('d-m-Y h:i:s');
                    Wo_bpd::where('kdasuransi', $kdasuransi)->where('kode', $row->kode)->update([
                        'harga' => $row->harga, 'user' => $user
                    ]);
                } else {
                    $user = 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s');
                    Wo_bpd::insert([
                        'kode' => $row->kode, 'nama' => $row->nama, 'kdtasklist' => $kdtasklist, 'kdasuransi' => $kdasuransi,
                        'harga' => $row->harga, 'user' => $user
                    ]);
                }
            }
            $msg = [
                'sukses' => true, //'Data berhasil di tambah', //view('wo_bpd.tabel_paket_detail')
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function destroy(wo_bpd $wo_bpd, Request $request)
    {
        if ($request->Ajax()) {
            $row_wo_bpd = Wo_bpd::where('id', $request->id)->first();
            $nowo = $row_wo_bpd->nowo;
            $wo_bpd->delete();
            $jumjasa = Wo_bpd::where('nowo', $nowo)->where('jenis', 'JASA')->sum('subtotal');
            $jumpart = Wo_bpd::where('nowo', $nowo)->where('jenis', 'PART')->sum('subtotal');
            $jumbahan = Wo_bpd::where('nowo', $nowo)->where('jenis', 'BAHAN')->sum('subtotal');
            $jumopl = Wo_bpd::where('nowo', $nowo)->where('jenis', 'OPL')->sum('subtotal');
            $wo_bp = Wo_bp::where('nowo', $nowo)->first();
            $total = $jumjasa + $jumpart + $jumbahan + $jumopl;
            $pr_ppn = $wo_bp->pr_ppn;
            $ppn = $total * ($pr_ppn / 100);
            $total_wo = $total + $ppn;
            Wo_bp::where('nowo', $nowo)->update([
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

    public function summary_wo_bp(Request $request) //: View
    {
        if ($request->ajax()) {
            $nowo = $request->nowo;
            $wo_bp = Wo_bp::where('nowo', $nowo)->first(); //->orderBy('kode', 'asc');
            $data = [
                'wo_bp' => $wo_bp,
            ];
            echo view('wo_bp.summary', $data);
        }
    }
}
