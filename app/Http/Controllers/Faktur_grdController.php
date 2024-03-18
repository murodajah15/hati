<?php

namespace App\Http\Controllers;

use App\Http\Requests\faktur_grdRequest;
use Illuminate\Http\Request;
use Session;
// use Yajra\DataTables\Contracts\DataTables;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Faktur_gr;
use App\Models\Faktur_grd;
use App\Models\Tasklisttipe_grd;
use App\Models\Userdtl;
use App\Models\Saplikasi;

// //return type View
// use Illuminate\View\View;

class Faktur_grdController extends Controller
{
    public function index(Request $request) //: View
    {
        $username = session('username');
        $row_faktur_gr = Faktur_gr::where('id', $request->id)->first();
        $row_faktur_grd = Faktur_grd::where('nofaktur', $row_faktur_gr->nofaktur)->first();
        $data = [
            'menu' => 'transaksi',
            'submenu' => 'faktur_gr',
            'submenu1' => 'general_repair',
            'title' => 'Detail Faktur General Repair',
        ];
        return response()->json([
            'body' => view('faktur_gr.modaldetailfaktur', [
                'saplikasi' => Saplikasi::where('aktif', 'Y')->first(),
                'faktur_gr' => $row_faktur_gr,
                'faktur_grd' => $row_faktur_grd,
                'action' => '',
                'vdata' => $data,
            ])->render(),
            'data' => $data,
        ]);
    }

    public function faktur_grdajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $data = Faktur_grd::select('*'); //->orderBy('kode', 'asc');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('kode1', function ($row) {
                    $btn = $row['kode']; //'<a href="#"' . 'onclick=detail(' . $id . ')>' .  $row['kode'] . '</a>';
                    return $btn;
                })
                ->rawColumns(['kode1'])
                ->make(true);
            // return view('part_gr');
        }
    }

    public function tbljasa_faktur_grajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $nofaktur = $request->nofaktur;
            $data = Faktur_grd::where('nofaktur', $nofaktur)->where('jenis', 'JASA'); //->orderBy('kode', 'asc');
            // $data = Faktur_gr::select('faktur_gr.*', 'tbasuransi.nama as nmasuransi')->join('tbasuransi', 'tbasuransi.kode', '=', 'faktur_gr.kdasuransi'); //->orderBy('kode', 'asc');
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
            return view('tbl_faktur_jasa');
        }
    }

    public function tblpart_faktur_grajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $nofaktur = $request->nofaktur;
            $data = Faktur_grd::where('nofaktur', $nofaktur)->where('jenis', 'PART'); //->orderBy('kode', 'asc');
            // $data = Faktur_gr::select('faktur_gr.*', 'tbasuransi.nama as nmasuransi')->join('tbasuransi', 'tbasuransi.kode', '=', 'faktur_gr.kdasuransi'); //->orderBy('kode', 'asc');
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
            return view('tbl_faktur_part');
        }
    }

    public function tblbahan_faktur_grajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $nofaktur = $request->nofaktur;
            $data = Faktur_grd::where('nofaktur', $nofaktur)->where('jenis', 'BAHAN'); //->orderBy('kode', 'asc');
            // $data = Faktur_gr::select('faktur_gr.*', 'tbasuransi.nama as nmasuransi')->join('tbasuransi', 'tbasuransi.kode', '=', 'faktur_gr.kdasuransi'); //->orderBy('kode', 'asc');
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
            return view('tbl_faktur_bahan');
        }
    }

    public function tblopl_faktur_grajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $nofaktur = $request->nofaktur;
            $data = Faktur_grd::where('nofaktur', $nofaktur)->where('jenis', 'OPL'); //->orderBy('kode', 'asc');
            // $data = Faktur_gr::select('faktur_gr.*', 'tbasuransi.nama as nmasuransi')->join('tbasuransi', 'tbasuransi.kode', '=', 'faktur_gr.kdasuransi'); //->orderBy('kode', 'asc');
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
            return view('tbl_faktur_opl');
        }
    }

    public function create(Request $request)
    {
        if ($request->Ajax()) {
            if ($request->jenis == 'JASA' or $request->jenis == 'jasa') {
                $title = 'Tambah data jasa faktur general repair';
                $view = 'faktur_gr.modaltambahjasa';
            }
            if ($request->jenis == 'PART' or $request->jenis == 'part') {
                $title = 'Tambah data part faktur general repair';
                $view = 'faktur_gr.modaltambahpart';
            }
            if ($request->jenis == 'BAHAN' or $request->jenis == 'bahan') {
                $title = 'Tambah data bahan faktur general repair';
                $view = 'faktur_gr.modaltambahbahan';
            }
            if ($request->jenis == 'OPL' or $request->jenis == 'opl') {
                $title = 'Tambah data opl faktur general repair';
                $view = 'faktur_gr.modaltambahopl';
            }
            $data = [
                'menu' => 'transaksi',
                'submenu' => 'faktur_gr',
                'submenu1' => 'general_repair',
                'title' => $title,
            ];
            return response()->json([
                'body' => view($view, [
                    'saplikasi' => Saplikasi::where('aktif', 'Y')->first(),
                    'faktur_gr' => Faktur_gr::where('nofaktur', $request->nofaktur)->first(),
                    'faktur_grd' => new faktur_grd(), //Faktur_gr::first(),
                    // 'tasklisttipe_grd' => Tasklisttipe_grd::where('kdasuransi', $kdasuransi)->orderBy('nama')->get(),
                    'action' => route('faktur_grd.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,

            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function store(faktur_grdRequest $request, faktur_grd $faktur_grd)
    {
        if ($request->Ajax()) {
            $validated = $request->validated();
            if ($validated) {
                $faktur_grd->fill([
                    'nofaktur' => isset($request->nofaktur) ? $request->nofaktur : '',
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
                $faktur_grd->save($validated);
                $jumjasa = Faktur_grd::where('nofaktur', $request->nofaktur)->where('jenis', 'JASA')->sum('subtotal');
                $jumpart = Faktur_grd::where('nofaktur', $request->nofaktur)->where('jenis', 'PART')->sum('subtotal');
                $jumbahan = Faktur_grd::where('nofaktur', $request->nofaktur)->where('jenis', 'BAHAN')->sum('subtotal');
                $jumopl = Faktur_grd::where('nofaktur', $request->nofaktur)->where('jenis', 'OPL')->sum('subtotal');
                $faktur_gr = Faktur_gr::where('nofaktur', $request->nofaktur)->first();
                $total = $jumjasa + $jumpart + $jumbahan + $jumopl;
                $pr_ppn = $faktur_gr->pr_ppn;
                $ppn = $total * ($pr_ppn / 100);
                $total_faktur = $total + $ppn;
                Faktur_gr::where('nofaktur', $request->nofaktur)->update([
                    'total_jasa' => $jumjasa, 'total_part' => $jumpart,
                    'total_bahan' => $jumbahan, 'total_opl' => $jumopl,
                    'total' => $total, 'dpp' => $total, 'ppn' => $ppn, 'total_faktur' => $total_faktur
                ]);
                $msg = [
                    'sukses' => 'Data berhasil di tambah', //view('faktur_gr.tabel_paket')
                ];
            }
            echo json_encode($msg);
            // return redirect()->back()->with('message', 'Berhasil di simpan');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function edit(faktur_grd $faktur_grd, Request $request)
    {
        if ($request->Ajax()) {
            if ($request->jenis == 'JASA' or $request->jenis == 'jasa') {
                $title = 'Edit data jasa faktur general repair';
                $view = 'faktur_gr.modaltambahjasa';
            }
            if ($request->jenis == 'PART' or $request->jenis == 'part') {
                $title = 'Edit data part faktur general repair';
                $view = 'faktur_gr.modaltambahpart';
            }
            if ($request->jenis == 'BAHAN' or $request->jenis == 'bahan') {
                $title = 'Edit data bahan faktur general repair';
                $view = 'faktur_gr.modaltambahbahan';
            }
            if ($request->jenis == 'OPL' or $request->jenis == 'opl') {
                $title = 'Edit data opl faktur general repair';
                $view = 'faktur_gr.modaltambahopl';
            }
            $data = [
                'menu' => 'transaksi',
                'submenu' => 'faktur_gr',
                'submenu1' => 'general_repair',
                'title' => $title,
            ];
            return response()->json([
                'body' => view($view, [
                    'saplikasi' => Saplikasi::where('aktif', 'Y')->first(),
                    'faktur_gr' => Faktur_gr::where('nofaktur', $faktur_grd->nofaktur)->first(),
                    'faktur_grd' => $faktur_grd,
                    'action' => route('faktur_grd.update', $faktur_grd->id),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function update(faktur_grdRequest $request, faktur_grd $faktur_grd)
    {
        if ($request->Ajax()) {
            $validated = $request->validated();
            if ($validated) {
                $faktur_grd->fill([
                    'nofaktur' => isset($request->nofaktur) ? $request->nofaktur : '',
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
                $faktur_grd->save($validated);
                $jumjasa = Faktur_grd::where('nofaktur', $request->nofaktur)->where('jenis', 'JASA')->sum('subtotal');
                $jumpart = Faktur_grd::where('nofaktur', $request->nofaktur)->where('jenis', 'PART')->sum('subtotal');
                $jumbahan = Faktur_grd::where('nofaktur', $request->nofaktur)->where('jenis', 'BAHAN')->sum('subtotal');
                $jumopl = Faktur_grd::where('nofaktur', $request->nofaktur)->where('jenis', 'OPL')->sum('subtotal');
                $faktur_gr = Faktur_gr::where('nofaktur', $request->nofaktur)->first();
                $total = $jumjasa + $jumpart + $jumbahan + $jumopl;
                $pr_ppn = $faktur_gr->pr_ppn;
                $ppn = $total * ($pr_ppn / 100);
                $total_faktur = $total + $ppn;
                Faktur_gr::where('nofaktur', $request->nofaktur)->update([
                    'total_jasa' => $jumjasa, 'total_part' => $jumpart,
                    'total_bahan' => $jumbahan, 'total_opl' => $jumopl,
                    'total' => $total, 'dpp' => $total, 'ppn' => $ppn, 'total_faktur' => $total_faktur
                ]);
                $msg = [
                    'sukses' => 'Data berhasil di update', //view('faktur_gr.tabel_paket')
                ];
            } else {
                $msg = [
                    'sukses' => 'Data gagal di update', //view('faktur_gr.tabel_paket')
                ];
            }
            echo json_encode($msg);
            // return redirect()->back()->with('message', 'Berhasil di update');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    // public function faktur_grdajax(Request $request) //: View
    // {
    //     if ($request->ajax()) {
    //         $kdtasklist = $_GET['kdtasklist'];
    //         $kdasuransi = $_GET['kdasuransi'];
    //         $data = Faktur_grd::select('*')->where('kdasuransi', $kdasuransi)->where('kdtasklist', $kdtasklist);
    //         return Datatables::of($data)
    //             ->addIndexColumn()
    //             ->addColumn('kode1', function ($row) {
    //                 $id = $row['id'];
    //                 $btn = $row['kode']; //'<a href="#"' . 'onclick=detail(' . $id . ')>' .  $row['kode'] . '</a>';
    //                 return $btn;
    //             })
    //             ->rawColumns(['kode1'])
    //             ->make(true);
    //     }
    // }

    public function simpanfaktur_grd(Request $request, faktur_grd $faktur_grd)
    {
        // if ($request->Ajax()) {
        // $validated = $request->validated();
        // if ($validated) {
        $kdtasklist = isset($request->kdtasklist) ? $request->kdtasklist : '';
        $kdasuransi = isset($request->kdasuransi) ? $request->kdasuransi : '';
        $cekdouble = Faktur_grd::where('kdtasklist', $kdtasklist)->where('kdasuransi', $kdasuransi)->where('kode', $request->kode)->first();
        if (isset($cekdouble->kode)) {
            $msg = [
                'sukses' => false, //view('faktur_grd.tabel_paket_detail')
            ];
        } else {
            $kode = isset($request->kode) ? $request->kode : '';
            $nama = isset($request->nama) ? $request->nama : '';
            $harga = isset($request->harga) ? $request->harga : '';
            $kdtasklist = isset($request->kdtasklist) ? $request->kdtasklist : '';
            $kdasuransi = isset($request->kdasuransi) ? $request->kdasuransi : '';
            $user = 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s');
            // $faktur_grd->save($validated);
            Faktur_grd::insert([
                'kode' => $kode, 'nama' => $nama, 'kdtasklist' => $kdtasklist, 'kdasuransi' => $kdasuransi,
                'harga' => $harga, 'user' => $user
            ]);
            $msg = [
                'sukses' => true, //'Data berhasil di tambah', //view('faktur_grd.tabel_paket_detail')
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
                'submenu' => 'faktur_gr',
                'submenu1' => 'ref_bengkel',
                'title' => 'Detail Faktur General Repair',
                // 'faktur_gr' => Faktur_grd::findOrFail($id),
                'userdtl' => Userdtl::where('cmodule', 'Faktur General Repair')->where('username', $username)->first(),
            ];
            $faktur_grd = Faktur_grd::where('id', $id)->first();
            // dd($faktur_grd);
            return response()->json([
                'body' => view('faktur_gr.modaldetailfaktur', [
                    'faktur_gr' => Faktur_gr::where('id', $id)->first(),
                    // 'faktur_grd' => Faktur_grd::findOrFail($id),
                    'action' => route('faktur_grd.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function editfaktur_grd(Request $request)
    {
        if ($request->Ajax()) {
            // dd($request->id);
            $faktur_grd = Faktur_grd::where('id', $request->id)->first();
            $data = [
                'menu' => 'file',
                'submenu' => 'faktur_gr',
                'submenu1' => 'ref_bengkel',
                'title' => 'Edit Data Task List Tipe',
            ];
            return response()->json([
                'body' => view('faktur_gr.modaleditdetail', [
                    'faktur_grd' => $faktur_grd,
                    // 'action' => route('faktur_grd.update', $faktur_grd->id),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
    public function updatefaktur_grd(Request $request, faktur_grd $faktur_grd)
    {
        if ($request->Ajax()) {
            $kode = isset($request->kode) ? $request->kode : '';
            $nama = isset($request->nama) ? $request->nama : '';
            $harga = isset($request->harga) ? $request->harga : '';
            // $kdtasklist = isset($request->kdtasklist) ? $request->kdtasklist : '';
            // $kdasuransi = isset($request->kdasuransi) ? $request->kdasuransi : '';
            $user = 'Update-' . $request->username . ', ' . date('d-m-Y h:i:s');
            Faktur_grd::where('id', $request->id)->update([
                'kode' => $kode, 'nama' => $nama, 'harga' => $harga, 'user' => $user
            ]);
            // Faktur_grd::where('id', $request->id)->update([
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

    public function salinfaktur_grd(Request $request, faktur_grd $faktur_grd)
    {
        if ($request->Ajax()) {
            $kdtasklist_salin = isset($request->kdtasklist_salin) ? $request->kdtasklist_salin : '';
            $kdasuransi_salin = isset($request->kdasuransi_salin) ? $request->kdasuransi_salin : '';
            $kdasuransi = isset($request->kdasuransi) ? $request->kdasuransi : '';
            $kdtasklist = isset($request->kdtasklist) ? $request->kdtasklist : '';
            // dd($kdtasklist_salin . '   ' . $kdasuransi_salin . '   ' . $kdasuransi);
            $tltipesalin_grd = Faktur_grd::where('kdtasklist', $kdtasklist_salin)->where('kdasuransi', $kdasuransi_salin)->get();
            foreach ($tltipesalin_grd as $row) {
                $cekdouble = Faktur_grd::where('kdtasklist', $kdtasklist)->where('kdasuransi', $kdasuransi)->where('kode', $row->kode)->first();
                if (isset($cekdouble)) {
                    $user = 'Update-' . $request->username . ', ' . date('d-m-Y h:i:s');
                    Faktur_grd::where('kdasuransi', $kdasuransi)->where('kode', $row->kode)->update([
                        'harga' => $row->harga, 'user' => $user
                    ]);
                } else {
                    $user = 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s');
                    Faktur_grd::insert([
                        'kode' => $row->kode, 'nama' => $row->nama, 'kdtasklist' => $kdtasklist, 'kdasuransi' => $kdasuransi,
                        'harga' => $row->harga, 'user' => $user
                    ]);
                }
            }
            $msg = [
                'sukses' => true, //'Data berhasil di tambah', //view('faktur_grd.tabel_paket_detail')
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function destroy(faktur_grd $faktur_grd, Request $request)
    {
        if ($request->Ajax()) {
            $row_faktur_grd = Faktur_grd::where('id', $request->id)->first();
            $nofaktur = $row_faktur_grd->nofaktur;
            $faktur_grd->delete();
            $jumjasa = Faktur_grd::where('nofaktur', $nofaktur)->where('jenis', 'JASA')->sum('subtotal');
            $jumpart = Faktur_grd::where('nofaktur', $nofaktur)->where('jenis', 'PART')->sum('subtotal');
            $jumbahan = Faktur_grd::where('nofaktur', $nofaktur)->where('jenis', 'BAHAN')->sum('subtotal');
            $jumopl = Faktur_grd::where('nofaktur', $nofaktur)->where('jenis', 'OPL')->sum('subtotal');
            $faktur_gr = Faktur_gr::where('nofaktur', $nofaktur)->first();
            $total = $jumjasa + $jumpart + $jumbahan + $jumopl;
            $pr_ppn = $faktur_gr->pr_ppn;
            $ppn = $total * ($pr_ppn / 100);
            $total_faktur = $total + $ppn;
            Faktur_gr::where('nofaktur', $nofaktur)->update([
                'total_jasa' => $jumjasa, 'total_part' => $jumpart,
                'total_bahan' => $jumbahan, 'total_opl' => $jumopl,
                'total' => $total, 'dpp' => $total, 'ppn' => $ppn, 'total_faktur' => $total_faktur
            ]);
            return response()->json([
                'sukses' => 'Data berhasil di hapus',
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function summary_faktur_gr(Request $request) //: View
    {
        if ($request->ajax()) {
            $nofaktur = $request->nofaktur;
            $faktur_gr = Faktur_gr::where('nofaktur', $nofaktur)->first(); //->orderBy('kode', 'asc');
            $data = [
                'faktur_gr' => $faktur_gr,
            ];
            echo view('faktur_gr.summary', $data);
        }
    }
}
