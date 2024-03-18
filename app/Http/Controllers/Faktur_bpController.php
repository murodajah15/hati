<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use App\Http\Requests\Faktur_bpRequest;
use Illuminate\Http\Request;
use Session;
// use Yajra\DataTables\Contracts\DataTables;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Tbmobil;
use App\Models\Estimasi_bp;
use App\Models\Estimasi_bpd;
use App\Models\Tbasuransi;
use App\Models\Tbmerek;
use App\Models\Tbmodel;
use App\Models\Tbtipe;
use App\Models\Tbwarna;
use App\Models\Tbjenis;
use App\Models\Tbcustomer;
use App\Models\Wo_bp;
use App\Models\Wo_bpd;
use App\Models\Hisuser;
use App\Models\Userdtl;
use App\Models\Saplikasi;
use App\Models\Faktur_bp;
use App\Models\Faktur_bpd;

// //return type View
// use Illuminate\View\View;

class Faktur_bpController extends Controller
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
            'menu' => 'transaksi',
            'submenu' => 'faktur_bp',
            'submenu1' => 'body_repair',
            'title' => 'Faktur Body Repair',
            'userdtlmenu' => $userdtl,
            'userdtl' => Userdtl::where('cmodule', 'Faktur Body Repair')->where('username', $username)->first(),
        ];
        return view('faktur_bp.index')->with($data);
    }

    public function faktur_bpajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $data = Faktur_bp::select('*'); //->orderBy('kode', 'asc');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('kode1', function ($row) {
                    $btn = $row['kode']; //'<a href="#"' . 'onclick=detail(' . $id . ')>' .  $row['kode'] . '</a>';
                    return $btn;
                })
                ->rawColumns(['kode1'])
                ->make(true);
            // return view('part_bp');
        }
    }

    // public function vwo_bp(Request $request)
    // {
    //     if ($request->Ajax()) {
    //         $username = session('username');
    //         $tbmobil = Tbmobil::where('id', $request->id)->first();
    //         $nopolisi = $tbmobil->nopolisi;
    //         $data = [
    //             'menu' => 'transaksi',
    //             'submenu' => 'wo_bp',
    //             'submenu1' => 'body_repair',
    //             'title' => 'List WO Body Repair',
    //             'userdtl' => Userdtl::where('cmodule', 'WO Body Repair')->where('username', $username)->first(),
    //             // 'estimasi_bp' => Wo_bp::all(),
    //         ];
    //         // var_dump($data);
    //         return response()->json([
    //             'body' => view('wo_bp.modaltblwo', [
    //                 'wo_bp' => Wo_bp::where('nopolisi', $nopolisi)->get(), //Wo_bp::first(),
    //                 'tbasuransi' => Tbasuransi::orderBy('nama')->get(),
    //                 'tbmobil' => $tbmobil, //Tbmobil::findOrFail($id),
    //                 'userdtl' => Userdtl::where('cmodule', 'WO Body Repair')->where('username', $username)->first(),
    //                 // 'action' => route('estimasi_bp.store'),
    //                 'vdata' => $data,
    //             ])->render(),
    //             'data' => $data,

    //         ]);
    //     } else {
    //         exit('Maaf tidak dapat diproses');
    //     }
    // }

    // public function vwo_bpajax(Request $request) //: View
    // {
    //     if ($request->ajax()) {
    //         $data = Wo_bp::select('*'); //->orderBy('kode', 'asc');
    //         return Datatables::of($data)
    //             ->addIndexColumn()
    //             ->addColumn('kode1', function ($row) {
    //                 $btn = $row['kode']; //'<a href="#"' . 'onclick=detail(' . $id . ')>' .  $row['kode'] . '</a>';
    //                 return $btn;
    //             })
    //             ->rawColumns(['kode1'])
    //             ->make(true);
    //         // return view('part_bp');
    //     }
    // }

    // public function tbmobil_bpajax(Request $request) //: View
    // {
    //     if ($request->ajax()) {
    //         $data = Tbmobil::select('*'); //->orderBy('kode', 'asc');
    //         // $data = Wo_bp::select('wo_bp.*', 'tbasuransi.nama as nmasuransi')->join('tbasuransi', 'tbasuransi.kode', '=', 'wo_bp.kdasuransi'); //->orderBy('kode', 'asc');
    //         return Datatables::of($data)
    //             ->addIndexColumn()
    //             ->addColumn('kode1', function ($row) {
    //                 $id = $row['id'];
    //                 $btn = $row['kode']; //'<a href="#"' . 'onclick=detail(' . $id . ')>' .  $row['kode'] . '</a>';
    //                 return $btn;
    //             })
    //             ->rawColumns(['kode1'])
    //             // ->addIndexColumn()
    //             // ->addColumn('action', function ($row) {
    //             //     $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
    //             //     return $btn;
    //             // })
    //             // ->rawColumns(['action'])
    //             ->make(true);
    //         // return view('wo_bp');
    //     }
    // }

    // public function wo_bpajax(Request $request) //: View
    // {
    //     if ($request->ajax()) {
    //         $nopolisi = $_GET['nopolisi'];
    //         $data = Wo_bp::where('nopolisi', $nopolisi); //->orderBy('kode', 'asc');
    //         return Datatables::of($data)
    //             ->addIndexColumn()
    //             ->addColumn('kode1', function ($row) {
    //                 $btn = $row['kode']; //'<a href="#"' . 'onclick=detail(' . $id . ')>' .  $row['kode'] . '</a>';
    //                 return $btn;
    //             })
    //             ->rawColumns(['kode1'])
    //             ->make(true);
    //         // return view('wo_bp');
    //     }
    // }

    public function create(Request $request)
    {
        if ($request->Ajax()) {
            $wo_bp = Wo_bp::join('tbmobil', 'tbmobil.nopolisi', '=', 'wo_bp.nopolisi')
                ->select('wo_bp.*', 'tbmobil.*')->where('wo_bp.close', 1)->get();
            $faktur_bp = Faktur_bp::where('id', $request->id)->first();
            $data = [
                'menu' => 'transaksi',
                'submenu' => 'faktur_bp',
                'submenu1' => 'body_repair',
                'title' => 'Tambah Data Task List Body Repair',
                // 'faktur_bp' => Wo_bp::all(),
            ];
            // var_dump($data);
            return response()->json([
                'body' => view('faktur_bp.modaltambahmaster', [
                    'wo_bp' => $wo_bp, //Wo_bp::first(),
                    'faktur_bp' => new faktur_bp(), //Wo_bp::first(),
                    'tbasuransi' => Tbasuransi::orderBy('nama')->get(),
                    'action' => route('faktur_bp.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,

            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function store(Faktur_bpRequest $request, faktur_bp $faktur_bp)
    {
        if ($request->Ajax()) {
            $validated = $request->validated();
            if ($validated) {
                $nofaktur = 'FB' . date('Y') . date('m') . sprintf("%05s", intval(substr('00000', -5)) + 1);
                $rec = Faktur_bp::where('nofaktur', $nofaktur)->first();
                if (isset($rec)) {
                    $noakhir = Faktur_bp::orderBy('nofaktur', 'desc')->max('nofaktur');
                    $nofaktur = 'FB' . date('Y') . date('m') . sprintf("%05s", intval(substr($noakhir, -5)) + 1);
                }
                // dd($nofaktur);
                $klaim = isset($request->klaim) ? '1' : '0';
                $internal = isset($request->internal) ? '1' : '0';
                $inventaris = isset($request->inventaris) ? '1' : '0';
                $campaign = isset($request->campaign)  ? '1' : '0';
                $booking = isset($request->booking)  ? '1' : '0';
                $lain_lain = isset($request->lain_lain)  ? '1' : '0';
                $row_wo_bp = Wo_bp::where('nowo', $request->nowo)->first();
                $dpp = $row_wo_bp->dpp;
                $ppn = $dpp * ($request->pr_ppn / 100);
                $total_wo = $dpp + $ppn;
                $total_faktur = $total_wo;
                $faktur_bp->fill([
                    'nofaktur' => $nofaktur,
                    'tanggal' => isset($request->tanggal) ? $request->tanggal : '',
                    'noestimasi' => isset($request->noestimasi) ? $request->noestimasi : '',
                    'nowo' => isset($request->nowo) ? $request->nowo : '',
                    'tglwo' => isset($request->tglwo) ? $request->tglwo : '',
                    'nopolisi' => isset($request->nopolisi) ? $request->nopolisi : '',
                    'norangka' => isset($request->norangka) ? $request->norangka : '',
                    'kdpemilik' => isset($request->kdpemilik) ? $request->kdpemilik : '',
                    'nmpemilik' => isset($request->nmpemilik) ? $request->nmpemilik : '',
                    'kdsa' => isset($request->kdsa) ? $request->kdsa : '',
                    'kdservice' => isset($request->kdservice) ? $request->kdservice : '',
                    'nmservice' => isset($request->nmservice) ? $request->nmservice : '',
                    'km' => isset($request->km) ? $request->km : '',
                    'kdpaket' => isset($request->kdpaket) ? $request->kdpaket : '',
                    'aktifitas' => isset($request->aktifitas) ? $request->aktifitas : '',
                    'fasilitas' => isset($request->fasilitas) ? $request->fasilitas : '',
                    'status_tunggu' => isset($request->status_tunggu) ? $request->status_tunggu : '',
                    'int_reminder' => isset($request->int_reminder) ? $request->int_reminder : '',
                    'via' => isset($request->via) ? $request->via : '',
                    'kdsa' => isset($request->kdsa) ? $request->kdsa : '',
                    'nmsa' => isset($request->nmsa) ? $request->nmsa : '',
                    'keluhan' => isset($request->keluhan) ? $request->keluhan : '',
                    'saran' => isset($request->saran) ? $request->saran : '',
                    'total_jasa' => $row_wo_bp->total_jasa,
                    'total_part' => $row_wo_bp->total_part,
                    'total_bahan' => $row_wo_bp->total_bahan,
                    'total_opl' => $row_wo_bp->total_opl,
                    'total' => $row_wo_bp->total,
                    'pr_ppn' => isset($request->pr_ppn) ? $request->pr_ppn : '',
                    'dpp' => $dpp,
                    'ppn' => $ppn,
                    'total_wo' => $total_wo,
                    'total_faktur' => $total_faktur,
                    'no_polis' => isset($request->no_polis) ? $request->no_polis : '',
                    'nama_polis' => isset($request->nama_polis) ? $request->nama_polis : '',
                    'tgl_akhir_polis' => isset($request->tgl_akhir_polis) ? $request->tgl_akhir_polis : '',
                    'kdasuransi' => isset($request->kdasuransi) ? $request->kdasuransi : '',
                    'nmasuransi' => isset($request->nmasuransi) ? $request->nmasuransi : '',
                    'alamat_asuransi' => isset($request->alamat_asuransi) ? $request->alamat_asuransi : '',
                    'klaim' => $klaim,
                    'internal' => $internal,
                    'inventaris' => $inventaris,
                    'campaign' => $campaign,
                    'booking' => $booking,
                    'lain_lain' => $lain_lain,
                    'surveyor' => isset($request->surveyor) ? $request->surveyor : '',
                    'npwp' => isset($request->npwp) ? $request->npwp : '',
                    'contact_person' => isset($request->contact_person) ? $request->contact_person : '',
                    'no_contact_person' => isset($request->no_contact_person) ? $request->no_contact_person : '',
                    'own_risk' => isset($request->own_risk) ? $request->own_risk : '',
                    'user' => 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $faktur_bp->save($validated);
                Wo_bp::where('nowo', $request->nowo)->update(['nofaktur' => $nofaktur]);
                Faktur_bpd::where('nofaktur', $nofaktur)->delete();
                $row_wo_bpd = Wo_bpd::where('nowo', $request->nowo)->get();
                foreach ($row_wo_bpd as $row) {
                    Faktur_bpd::insert([
                        'nofaktur' => $nofaktur, 'kode' => $row->kode, 'nama' => $row->nama, 'kerusakan' => $row->kerusakan, 'jenis' => $row->jenis, 'qty' => $row->qty,
                        'harga' => $row->harga, 'pr_discount' => $row->pr_discount, 'subtotal' => $row->subtotal
                    ]);
                }
                $msg = [
                    'sukses' => 'Data berhasil di simpan', //view('faktur_bp.tabel_paket')
                ];
            } else {
                $msg = [
                    'sukses' => 'Gagal di simpan', //view('faktur_bp.tabel_paket')
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
            $rec = Faktur_bp::where('id', $request->id)->first();
            $nopolisi = $rec->nopolisi;
            $username = session('username');
            // dd($request->jenis);
            $data = [
                'menu' => 'transaksi',
                'submenu' => 'wo_bp',
                'submenu1' => 'body_repair',
                'title' => 'Detail Faktur Body Repair',
                'faktur_bp' => Faktur_bp::findOrFail($id),
                'userdtl' => Userdtl::where('cmodule', 'Faktur Body Repair')->where('username', $username)->first(),
            ];
            // return view('faktur_bp.modaldetail')->with($data);
            return response()->json([
                'body' => view('faktur_bp.modaltambahmaster', [
                    'faktur_bp' => Faktur_bp::findOrFail($id),
                    'tbmobil' => Tbmobil::where('nopolisi', $nopolisi)->first(),
                    'tbmerek' => Tbmerek::orderBy('nama')->get(),
                    'tbmodel' => Tbmodel::orderBy('nama')->get(),
                    'tbtipe' => Tbtipe::orderBy('nama')->get(),
                    'tbwarna' => Tbwarna::orderBy('nama')->get(),
                    'tbjenis' => Tbjenis::orderBy('nama')->get(),
                    'tbasuransi' => Tbasuransi::orderBy('nama')->get(),
                    'action' => '',
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function edit(faktur_bp $faktur_bp, Request $request)
    {
        if ($request->Ajax()) {
            $rec = Faktur_bp::where('id', $request->id)->first();
            $nopolisi = $rec->nopolisi;
            // dd($nopolisi);
            $data = [
                'menu' => 'transaksi',
                'submenu' => 'faktur_bp',
                'submenu1' => 'body_repair',
                'title' => 'Edit Data Faktur Body Repair',
            ];
            return response()->json([
                'body' => view('faktur_bp.modaltambahmaster', [
                    'faktur_bp' => $faktur_bp,
                    'tbmobil' => Tbmobil::where('nopolisi', $nopolisi)->first(),
                    'tbasuransi' => Tbasuransi::orderBy('nama')->get(),
                    'action' => route('faktur_bp.update', $faktur_bp->id),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function update(Faktur_bpRequest $request, faktur_bp $faktur_bp)
    {
        if ($request->Ajax()) {
            $validated = $request->validated();
            if ($validated) {
                $klaim = isset($request->klaim) ? '1' : '0';
                $internal = isset($request->internal) ? '1' : '0';
                $inventaris = isset($request->inventaris) ? '1' : '0';
                $campaign = isset($request->campaign)  ? '1' : '0';
                $booking = isset($request->booking)  ? '1' : '0';
                $lain_lain = isset($request->lain_lain)  ? '1' : '0';
                $row_faktur_bp = Faktur_bp::where('id', $request->id)->first();
                $dpp = $row_faktur_bp->dpp;
                $ppn = $dpp * ($request->pr_ppn / 100);
                $total_wo = $dpp + $ppn;
                $total_faktur = $total_wo;
                $faktur_bp->fill([
                    'noestimasi' => isset($request->noestimasi) ? $request->noestimasi : '',
                    'nowo' => isset($request->nowo) ? $request->nowo : '',
                    'tglwo' => isset($request->tglwo) ? $request->tglwo : '',
                    'tanggal' => isset($request->tanggal) ? $request->tanggal : '',
                    'nopolisi' => isset($request->nopolisi) ? $request->nopolisi : '',
                    'norangka' => isset($request->norangka) ? $request->norangka : '',
                    'kdpemilik' => isset($request->kdpemilik) ? $request->kdpemilik : '',
                    'nmpemilik' => isset($request->nmpemilik) ? $request->nmpemilik : '',
                    'kdsa' => isset($request->kdsa) ? $request->kdsa : '',
                    'kdservice' => isset($request->kdservice) ? $request->kdservice : '',
                    'nmservice' => isset($request->nmservice) ? $request->nmservice : '',
                    'km' => isset($request->km) ? $request->km : '',
                    'kdpaket' => isset($request->kdpaket) ? $request->kdpaket : '',
                    'aktifitas' => isset($request->aktifitas) ? $request->aktifitas : '',
                    'fasilitas' => isset($request->fasilitas) ? $request->fasilitas : '',
                    'status_tunggu' => isset($request->status_tunggu) ? $request->status_tunggu : '',
                    'int_reminder' => isset($request->int_reminder) ? $request->int_reminder : '',
                    'via' => isset($request->via) ? $request->via : '',
                    'kdsa' => isset($request->kdsa) ? $request->kdsa : '',
                    'nmsa' => isset($request->nmsa) ? $request->nmsa : '',
                    'keluhan' => isset($request->keluhan) ? $request->keluhan : '',
                    'saran' => isset($request->saran) ? $request->saran : '',
                    'pr_ppn' => isset($request->pr_ppn) ? $request->pr_ppn : '',
                    'dpp' => $dpp,
                    'ppn' => $ppn,
                    'total_wo' => $total_wo,
                    'total_faktur' => $total_faktur,
                    'no_polis' => isset($request->no_polis) ? $request->no_polis : '',
                    'nama_polis' => isset($request->nama_polis) ? $request->nama_polis : '',
                    'tgl_akhir_polis' => isset($request->tgl_akhir_polis) ? $request->tgl_akhir_polis : '',
                    'kdasuransi' => isset($request->kdasuransi) ? $request->kdasuransi : '',
                    'nmasuransi' => isset($request->nmasuransi) ? $request->nmasuransi : '',
                    'alamat_asuransi' => isset($request->alamat_asuransi) ? $request->alamat_asuransi : '',
                    'klaim' => $klaim,
                    'internal' => $internal,
                    'inventaris' => $inventaris,
                    'campaign' => $campaign,
                    'booking' => $booking,
                    'lain_lain' => $lain_lain,
                    'surveyor' => isset($request->surveyor) ? $request->surveyor : '',
                    'npwp' => isset($request->npwp) ? $request->npwp : '',
                    'contact_person' => isset($request->contact_person) ? $request->contact_person : '',
                    'no_contact_person' => isset($request->no_contact_person) ? $request->no_contact_person : '',
                    'own_risk' => isset($request->own_risk) ? $request->own_risk : '',
                    'user' => 'Update-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $faktur_bp->save($validated);
                $msg = [
                    'sukses' => 'Data berhasil di update',
                ];
            } else {
                $msg = [
                    'sukses' => 'Data gagal di update',
                ];
            }
            echo json_encode($msg);
            // return redirect()->back()->with('message', 'Berhasil di update');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    // public function show(string $id)
    public function vestimasi_bp(Request $request)
    {
        if ($request->Ajax()) {
            $id = $_GET['id'];
            $tbmobil = Tbmobil::where('id', $id)->first();
            $nopolisi = $tbmobil->nopolisi;
            $username = session('username');
            $data = [
                'menu' => 'transaksi',
                'submenu' => 'estimasi_bp',
                'submenu1' => 'body_repair',
                'title' => 'Estimasi WO Body Repair',
                'userdtl' => Userdtl::where('cmodule', 'Estimasi WO Body Repair')->where('username', $username)->first(),
            ];
            // return view('estimasi_bp.modaldetail')->with($data);
            return response()->json([
                'body' => view('estimasi_bp.modaltambah', [
                    'tbmobil' => $tbmobil, //Tbmobil::findOrFail($id),
                    'tbmerek' => Tbmerek::orderBy('nama')->get(),
                    'tbmodel' => Tbmodel::orderBy('nama')->get(),
                    'tbtipe' => Tbtipe::orderBy('nama')->get(),
                    'tbwarna' => Tbwarna::orderBy('nama')->get(),
                    'tbjenis' => Tbjenis::orderBy('nama')->get(),
                    'estimasi_bp' => Wo_bp::where('nopolisi', $nopolisi)->get(),
                    'action' => '',
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function tbmobil_update(Request $request, Tbmobil $tbmobil)
    {
        if ($request->Ajax()) {
            $validated = $request->validate(
                [
                    'nopolisi' => 'required',
                ],
                [
                    'nopolisi.required' => 'No.Polisi harus di isi',
                ],
            );
            if ($validated) {
                // dd($request->id);
                $tbmobil = Tbmobil::findOrFail($request->id)->first();
                $tbmobil->fill([
                    'nopolisi' => isset($request->nopolisi) ? $request->nopolisi : '',
                    'norangka' => isset($request->norangka) ? $request->norangka : '',
                    'nomesin' => isset($request->nomesin) ? $request->nomesin : '',
                    'tahun' => isset($request->tahun) ? $request->tahun : '',
                    'kdmerek' => isset($request->kdmerek) ? $request->kdmerek : '',
                    'kdmodel' => isset($request->kdmodel) ? $request->kdmodel : '',
                    'kdtipe' => isset($request->kdtipe) ? $request->kdtipe : '',
                    'kdwarna' => isset($request->kdwarna) ? $request->kdwarna : '',
                    'kdjenis' => isset($request->kdjenis) ? $request->kdjenis : '',
                    'kdmerek' => isset($request->kdmerek) ? $request->kdmerek : '',
                    'nostnk' => isset($request->nostnk) ? $request->nostnk : '',
                    'tglstnk' => isset($request->tglstnk) ? $request->tglstnk : '',
                    'tahun' => isset($request->tahun) ? $request->tahun : '',
                    'bahanbakar' => isset($request->bahanbakar) ? $request->bahanbakar : '',
                    'dealerjual' => isset($request->dealerjual) ? $request->dealerjual : '',
                    'kdpemilik' => isset($request->kdpemilik) ? $request->kdpemilik : '',
                    'nmpemilik' => isset($request->nmpemilik) ? $request->nmpemilik : '',
                    'npwp' => isset($request->npwp) ? $request->npwp : '',
                    'contact_person' => isset($request->contact_person) ? $request->contact_person : '',
                    'no_contact_person' => isset($request->no_contact_person) ? $request->no_contact_person : '',
                    'kdpemilik' => isset($request->kdpemilik) ? $request->kdpemilik : '',
                    'nmpemilik' => isset($request->nmpemilik) ? $request->nmpemilik : '',
                    'kdpemakai' => isset($request->kdpemakai) ? $request->kdpemakai : '',
                    'nmpemakai' => isset($request->nmpemakai) ? $request->nmpemakai : '',
                    'kdasuransi' => isset($request->kdasuransi) ? $request->kdasuransi : '',
                    'nmasuransi' => isset($request->nmasuransi) ? $request->nmasuransi : '',
                    'no_polis' => isset($request->no_polis) ? $request->no_polis : '',
                    'nama_polis' => isset($request->nama_polis) ? $request->nama_polis : '',
                    'tgl_akhir_polis' => isset($request->tgl_akhir_polis) ? $request->tgl_akhir_polis : '',
                    'user' => 'Update-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $tbmobil->save($validated);
                $msg = [
                    'sukses' => 'Data berhasil di update', //view('tbmobil.tabel_mobil')
                ];
            } else {
                $msg = [
                    'sukses' => 'Data gagal di update', //view('tbmobil.tabel_mobil')
                ];
            }
            echo json_encode($msg);
            // return redirect()->back()->with('message', 'Berhasil di update');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    // public function destroy(estimasi_bp $estimasi_bp, Request $request)
    // {
    //     if ($request->Ajax()) {
    //         Wo_bp::where('id', $request->id)->delete();
    //         return response()->json([
    //             'sukses' => true,
    //         ]);
    //     } else {
    //         exit('Maaf tidak dapat diproses');
    //     }
    // }

    public function destroy(Request $request)
    {
        if ($request->Ajax()) {
            Wo_bp::where('id', $request->id)->update(['batal' => 1]);
            return response()->json([
                'sukses' => true,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function faktur_bpproses(Request $request)
    {
        if ($request->Ajax()) {
            $data = Faktur_bp::where('id', $request->id)->first();
            $userclose = session('username') . ', ' . date('d-m-Y h:i:s');
            Faktur_bp::where('id', $request->id)->update(['close' => 1, 'sudahbayar' => $data->total_wo, 'user_close' => $userclose]);
            Wo_bp::where('nowo', $data->nowo)->update(['nofaktur' => $data->nofaktur]);
            //Create History
            $tanggal = date('Y-m-d');
            $datetime = date('Y-m-d H:i:s');
            $dokumen = $data->nofaktur;
            $form = 'Faktur Body Repair';
            $status = 'Proses';
            $catatan = isset($request->catatan) ? $request->catatan : '';
            $username = session('username');
            Hisuser::insert(['tanggal' => $tanggal, 'dokumen' => $dokumen, 'form' => $form, 'status' => $status, 'user' => $username, 'catatan' => $catatan, 'datetime' => $datetime]);
            return response()->json([
                'sukses' => true,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function faktur_bpunproses(Request $request)
    {
        if ($request->Ajax()) {
            $username = session('username');
            $id = $request->id;
            $faktur_bp = Faktur_bp::where('id', $id)->first();
            $data = [
                'menu' => 'transaksi',
                'submenu' => 'faktur_bp',
                'submenu1' => 'body_repair',
                'title' => 'Unproses Fktur Body Repair',
                'userdtl' => Userdtl::where('cmodule', 'Faktur Body Repair')->where('username', $username)->first(),
            ];
            // return view('faktur_bp.modaldetail')->with($data);
            return response()->json([
                'body' => view('faktur_bp.modalbatalproses', [
                    'faktur_bp' => $faktur_bp,
                    'action' => 'faktur_bpunproses_simpan',
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
    public function faktur_bpunproses_simpan(Request $request)
    {
        if ($request->Ajax()) {
            Faktur_bp::where('id', $request->id)->update([
                'close' => 0, 'user' => 'Unproses-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                'ket_proses' => $request->catatan . ' (' . date('d-m-Y h:i:s') . '}'
            ]);
            $data = Faktur_bp::where('id', $request->id)->first();
            Wo_bp::where('nowo', $data->nowo)->update(['nofaktur' => '']);
            //Create History
            $tanggal = date('Y-m-d');
            $datetime = date('Y-m-d H:i:s');
            $dokumen = $request->dokumen;
            $form = 'Faktur Body Repair';
            $status = 'Unproses';
            $catatan = isset($request->catatan) ? $request->catatan : '';
            $username = session('username');
            Hisuser::insert(['tanggal' => $tanggal, 'dokumen' => $dokumen, 'form' => $form, 'status' => $status, 'user' => $username, 'catatan' => $catatan, 'datetime' => $datetime]);
            return response()->json([
                'sukses' => true,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }


    public function faktur_bpcancel(Request $request)
    {
        if ($request->Ajax()) {
            $ket_batal = "";
            $userbatal = session('username') . ', ' . date('d-m-Y h:i:s');
            Faktur_bp::where('id', $request->id)->update(['batal' => 1, 'ket_batal' => $ket_batal, 'user_batal' => $userbatal, 'tgl_batal' => date('Y-m-d')]);
            $data = Faktur_bp::where('id', $request->id)->first();
            Wo_bp::where('nowo', $data->nowo)->update(['nofaktur' => '']);
            //Create History
            $tanggal = date('Y-m-d');
            $datetime = date('Y-m-d H:i:s');
            $dokumen = $data->nofaktur;
            $form = 'Faktur Body Repair';
            $status = 'Cancel';
            $catatan = isset($request->catatan) ? $request->catatan : '';
            $username = session('username');
            Hisuser::insert(['tanggal' => $tanggal, 'dokumen' => $dokumen, 'form' => $form, 'status' => $status, 'user' => $username, 'catatan' => $catatan, 'datetime' => $datetime]);
            return response()->json([
                'sukses' => true,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function faktur_bpambil(Request $request)
    {
        if ($request->Ajax()) {
            Faktur_bp::where('id', $request->id)->update(['batal' => 0]);
            $data = Faktur_bp::where('id', $request->id)->first();
            //Create History
            $tanggal = date('Y-m-d');
            $datetime = date('Y-m-d H:i:s');
            $dokumen = $data->nofaktur;
            $form = 'Faktur Body Repair';
            $status = 'Ambil';
            $catatan = isset($request->catatan) ? $request->catatan : '';
            $username = session('username');
            Hisuser::insert(['tanggal' => $tanggal, 'dokumen' => $dokumen, 'form' => $form, 'status' => $status, 'user' => $username, 'catatan' => $catatan, 'datetime' => $datetime]);
            return response()->json([
                'sukses' => true,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function detailwo_bp(wo_bp $wo_bp, Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'transaksi',
                'submenu' => 'wo_bp',
                'submenu1' => 'body_repair',
                'title' => 'Detail WO Body Repair',
            ];
            $id = $request->id;
            $wo_bp = Wo_bp::where('id', $id)->first();
            $wo_bpd = Wo_bpd::where('nowo', $wo_bp->nowo)->get();
            return response()->json([
                'body' => view('wo_bp.modaldetailwo', [
                    'submenu' => 'wo_bp',
                    'tbmobil' => Tbmobil::where('nopolisi', $wo_bp->nopolisi)->first(),
                    'wo_bp' => $wo_bp,
                    'wo_bpd' => $wo_bpd,
                    'action' => '', //route('estimasi_bpd.store', $estimasi_bp->id),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function cetak_faktur_bp(Request $request)
    {
        $row_faktur_bp = Faktur_bp::join('tbsa', 'faktur_bp.kdsa', '=', 'tbsa.kode')
            ->where('faktur_bp.id', $request->id)
            ->select('faktur_bp.*', 'tbsa.nama as nmsa')->first();
        $nofaktur = $row_faktur_bp->nofaktur;
        $kdpemilik = $row_faktur_bp->kdpemilik;
        $nopolisi = $row_faktur_bp->nopolisi;
        $row_tbmobil = Tbmobil::join('tbtipe', 'tbmobil.kdtipe', '=', 'tbtipe.kode')->join('tbwarna', 'tbmobil.kdwarna', '=', 'tbwarna.kode')
            ->where('tbmobil.nopolisi', $nopolisi)
            ->select('tbmobil.*', 'tbtipe.nama as nmtipe', 'tbwarna.nama as nmwarna')
            ->first();
        $row_tbcustomer = Tbcustomer::where('kode', $kdpemilik)->first();
        $data = [
            'saplikasi' => Saplikasi::where('aktif', 'Y')->first(),
            'faktur_bp' => $row_faktur_bp,
            'tbmobil' => $row_tbmobil,
            'tbcustomer' => $row_tbcustomer,
            'faktur_bpd_jasa' => Faktur_bp::join('faktur_bpd', 'faktur_bpd.nofaktur', '=', 'faktur_bp.nofaktur')
                ->join('tbcustomer', 'tbcustomer.kode', '=', 'faktur_bp.kdpemilik')
                ->select('faktur_bp.*', 'faktur_bpd.*')
                ->where('faktur_bpd.nofaktur', $nofaktur)->where('faktur_bpd.jenis', 'JASA')->orwhere('faktur_bpd.jenis', 'OPL')->get(),
            'faktur_bpd_part' => Faktur_bp::join('faktur_bpd', 'faktur_bpd.nofaktur', '=', 'faktur_bp.nofaktur')
                ->join('tbcustomer', 'tbcustomer.kode', '=', 'faktur_bp.kdpemilik')
                ->join('tbmobil', 'tbmobil.nopolisi', '=', 'faktur_bp.nopolisi')
                ->join('tbbarang', 'tbbarang.kode', '=', 'faktur_bpd.kode')
                ->join('tbsatuan', 'tbsatuan.kode', '=', 'tbbarang.kdsatuan')
                ->select('faktur_bp.*', 'faktur_bpd.*', 'tbsatuan.kode as kdsatuan', 'tbsatuan.nama as nmsatuan')
                ->where('faktur_bpd.nofaktur', $nofaktur)->where('faktur_bpd.jenis', 'PART')->get(),
            'faktur_bpd_bahan' => Faktur_bp::join('faktur_bpd', 'faktur_bpd.nofaktur', '=', 'faktur_bp.nofaktur')
                ->join('tbcustomer', 'tbcustomer.kode', '=', 'faktur_bp.kdpemilik')
                ->join('tbmobil', 'tbmobil.nopolisi', '=', 'faktur_bp.nopolisi')
                ->join('tbbahan', 'tbbahan.kode', '=', 'faktur_bpd.kode')
                ->join('tbsatuan', 'tbsatuan.kode', '=', 'tbbahan.kdsatuan')
                ->select('faktur_bp.*', 'faktur_bpd.*', 'tbsatuan.kode as kdsatuan', 'tbsatuan.nama as nmsatuan')
                ->where('faktur_bpd.nofaktur', $nofaktur)->where('faktur_bpd.jenis', 'BAHAN')->get(),
        ];
        // return view('jual.cetak', $data);

        $rowd = faktur_bpd::where('nofaktur', $nofaktur)->get();
        $rowd = $rowd->count();

        // if ($rowd > 10) {
        //create PDF
        $mpdf = new Mpdf([
            'format' => 'Letter',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 8,
            'margin_bottom' => 5,
            'margin_header' => 5,
            'margin_footer' => 5,
        ]);
        // } else {
        //     //create PDF
        //     $mpdf = new Mpdf([
        //         'format' => [150, 210], //gagal jadi ke landscape
        //         // 'format' => 'Letter-P',
        //         'orientation' => 'L',
        //         'margin_left' => 10,
        //         'margin_right' => 10,
        //         'margin_top' => 8,
        //         'margin_bottom' => 5,
        //         'margin_header' => 5,
        //         'margin_footer' => 5,
        //     ]);
        // }

        //Create History
        $faktur_bp = Faktur_bp::where('id', $request->id)->first();
        $tanggal = date('Y-m-d');
        $datetime = date('Y-m-d H:i:s');
        $dokumen = $faktur_bp->nofaktur;
        $form = 'Penjualan';
        $status = 'Cetak';
        $catatan = isset($request->catatan) ? $request->catatan : '';
        $username = session('username');
        Hisuser::insert(['tanggal' => $tanggal, 'dokumen' => $dokumen, 'form' => $form, 'status' => $status, 'user' => $username, 'catatan' => $catatan, 'datetime' => $datetime]);

        $header = trim($request->get('header', ''));
        $footer = trim($request->get('footer', ''));

        if (strlen($header)) {
            $mpdf->SetHTMLHeader($header);
        }

        if (strlen($footer)) {
            $mpdf->SetHTMLFooter($footer);
        }

        if ($request->get('show_toc')) {
            $mpdf->h2toc = array(
                'H1' => 0,
                'H2' => 1,
                'H3' => 2,
                'H4' => 3,
                'H5' => 4,
                'H6' => 5
            );
            $mpdf->TOCpagebreak();
        }

        //write content
        // $mpdf->WriteHTML($request->get('content'));
        $mpdf->WriteHTML(view('faktur_bp.cetak', $data));
        $namafile = $nofaktur . ' - ' . date('dmY H:i:s') . '.pdf';
        //return the PDF for download
        // return $mpdf->Output($request->get('name') . $namafile, Destination::DOWNLOAD);
        $mpdf->Output($namafile, 'I');
    }

    public function buatfaktur_bp(Request $request, faktur_bp $faktur_bp)
    {
        if ($request->Ajax()) {
            $idwo = $request->idwo;
            $row_wo_bp = Wo_bp::where('id', $idwo)->first();
            // $validated = $request->validated();
            // if ($validated) {
            $nofaktur = 'BF' . date('Y') . date('m') . sprintf("%05s", intval(substr('00000', -5)) + 1);
            $rec = Faktur_bp::where('nofaktur', $nofaktur)->first();
            if (isset($rec)) {
                $noakhir = Faktur_bp::orderBy('nofaktur', 'desc')->max('nofaktur');
                $nofaktur = 'BF' . date('Y') . date('m') . sprintf("%05s", intval(substr($noakhir, -5)) + 1);
            }
            $klaim = $row_wo_bp->klaim;
            $internal = $row_wo_bp->internal;
            $inventaris = $row_wo_bp->inventaris;
            $campaign = $row_wo_bp->campaign;
            $booking = $row_wo_bp->booking;
            $lain_lain = $row_wo_bp->lain_lain;
            $faktur_bp->fill([
                'nofaktur' => $nofaktur,
                'nowo' => $row_wo_bp->nowo,
                'tanggal' => isset($row_wo_bp->tanggal) ? $row_wo_bp->tanggal : '',
                'tglwo' => date('Y-m-d H:i:s'),
                'nopolisi' => isset($row_wo_bp->nopolisi) ? $row_wo_bp->nopolisi : '',
                'norangka' => isset($row_wo_bp->norangka) ? $row_wo_bp->norangka : '',
                'kdpemilik' => isset($row_wo_bp->kdpemilik) ? $row_wo_bp->kdpemilik : '',
                'nmpemilik' => isset($row_wo_bp->nmpemilik) ? $row_wo_bp->nmpemilik : '',
                'kdsa' => isset($row_wo_bp->kdsa) ? $row_wo_bp->kdsa : '',
                'kdservice' => isset($row_wo_bp->kdservice) ? $row_wo_bp->kdservice : '',
                'nmservice' => isset($row_wo_bp->nmservice) ? $row_wo_bp->nmservice : '',
                'km' => isset($row_wo_bp->km) ? $row_wo_bp->km : '',
                'kdpaket' => isset($row_wo_bp->kdpaket) ? $row_wo_bp->kdpaket : '',
                'aktifitas' => isset($row_wo_bp->aktifitas) ? $row_wo_bp->aktifitas : '',
                'fasilitas' => isset($row_wo_bp->fasilitas) ? $row_wo_bp->fasilitas : '',
                'status_tunggu' => isset($row_wo_bp->status_tunggu) ? $row_wo_bp->status_tunggu : '',
                'int_reminder' => isset($row_wo_bp->int_reminder) ? $row_wo_bp->int_reminder : '',
                'via' => isset($row_wo_bp->via) ? $row_wo_bp->via : '',
                'kdsa' => isset($row_wo_bp->kdsa) ? $row_wo_bp->kdsa : '',
                'nmsa' => isset($row_wo_bp->nmsa) ? $row_wo_bp->nmsa : '',
                'keluhan' => isset($row_wo_bp->keluhan) ? $row_wo_bp->keluhan : '',
                'no_polis' => isset($row_wo_bp->no_polis) ? $row_wo_bp->no_polis : '',
                'nama_polis' => isset($row_wo_bp->nama_polis) ? $row_wo_bp->nama_polis : '',
                'tgl_akhir_polis' => isset($row_wo_bp->tgl_akhir_polis) ? $row_wo_bp->tgl_akhir_polis : '',
                'kdasuransi' => isset($row_wo_bp->kdasuransi) ? $row_wo_bp->kdasuransi : '',
                'nmasuransi' => isset($row_wo_bp->nmasuransi) ? $row_wo_bp->nmasuransi : '',
                'alamat_asuransi' => isset($row_wo_bp->alamat_asuransi) ? $row_wo_bp->alamat_asuransi : '',
                'klaim' => $klaim,
                'internal' => $internal,
                'inventaris' => $inventaris,
                'campaign' => $campaign,
                'booking' => $booking,
                'lain_lain' => $lain_lain,
                'surveyor' => isset($row_wo_bp->surveyor) ? $row_wo_bp->surveyor : '',
                'npwp' => isset($row_wo_bp->npwp) ? $row_wo_bp->npwp : '',
                'contact_person' => isset($row_wo_bp->contact_person) ? $row_wo_bp->contact_person : '',
                'no_contact_person' => isset($row_wo_bp->no_contact_person) ? $row_wo_bp->no_contact_person : '',
                'own_risk' => isset($row_wo_bp->own_risk) ? $row_wo_bp->own_risk : '',
                'total_jasa' => $row_wo_bp->total_jasa,
                'total_part' => $row_wo_bp->total_part,
                'total_bahan' => $row_wo_bp->total_bahan,
                'total_opl' => $row_wo_bp->total_opl,
                'total' => $row_wo_bp->total,
                'dpp' => $row_wo_bp->dpp,
                'pr_ppn' => $row_wo_bp->pr_ppn,
                'ppn' => $row_wo_bp->ppn,
                'total_wo' => $row_wo_bp->total_wo,
                'user' => 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s'),
            ]);
            // $wo_bp->save($validated);
            $faktur_bp->save();
            Wo_bp::where('nofaktur', $row_wo_bp->nofaktur)->update(['nofaktur' => $nofaktur]);
            $row_wo_bpd = Wo_bpd::where('nowo', $row_wo_bp->nowo)->get();
            Faktur_bpd::where('nowo', $row_wo_bp->nowo)->delete();
            foreach ($row_wo_bpd as $row) {
                Faktur_bpd::insert([
                    'nofaktur' => $row->nofaktur, 'kode' => $row->kode, 'nama' => $row->nama, 'kerusakan' => $row->kerusakan, 'jenis' => $row->jenis, 'qty' => $row->qty,
                    'harga' => $row->harga, 'pr_discount' => $row->pr_discount, 'subtotal' => $row->subtotal
                ]);
            }
            $msg = [
                'sukses' => 'Data berhasil di simpan', //view('estimasi_bp.tabel_paket')
            ];
            // } else {
            //     $msg = [
            //         'sukses' => 'Gagal di simpan', //view('estimasi_bp.tabel_paket')
            //     ];
            // }
            echo json_encode($msg);
            // return redirect()->back()->with('message', 'Berhasil di simpan');
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
