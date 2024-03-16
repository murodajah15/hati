<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use App\Http\Requests\Estimasi_bpRequest;
use App\Http\Requests\Wo_bpRequest;
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

// //return type View
// use Illuminate\View\View;

class Estimasi_bpController extends Controller
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
            'submenu' => 'estimasi_bp',
            'submenu1' => 'body_repair',
            'title' => 'Estimasi WO Body Repair',
            'userdtlmenu' => $userdtl,
            'userdtl' => Userdtl::where('cmodule', 'Estimasi WO Body Repair')->where('username', $username)->first(),
        ];
        return view('estimasi_bp.index')->with($data);
    }

    public function tbmobil_bpajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $data = Tbmobil::select('*'); //->orderBy('kode', 'asc');
            // $data = Estimasi_bp::select('estimasi_bp.*', 'tbasuransi.nama as nmasuransi')->join('tbasuransi', 'tbasuransi.kode', '=', 'estimasi_bp.kdasuransi'); //->orderBy('kode', 'asc');
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
            return view('estimasi_bp');
        }
    }

    public function estimasi_bpajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $nopolisi = $_GET['nopolisi'];
            $data = Estimasi_bp::where('nopolisi', $nopolisi); //->orderBy('kode', 'asc');
            // $data = Estimasi_bp::select('estimasi_bp.*', 'tbasuransi.nama as nmasuransi')->join('tbasuransi', 'tbasuransi.kode', '=', 'estimasi_bp.kdasuransi'); //->orderBy('kode', 'asc');
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
            return view('estimasi_bp');
        }
    }

    public function wo_bpajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $nopolisi = $_GET['nopolisi'];
            $data = Wo_bp::where('nopolisi', $nopolisi); //->orderBy('kode', 'asc');
            // $data = wo_bp::select('wo_bp.*', 'tbasuransi.nama as nmasuransi')->join('tbasuransi', 'tbasuransi.kode', '=', 'wo_bp.kdasuransi'); //->orderBy('kode', 'asc');
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
            return view('wo_bp');
        }
    }

    // public function tabel_paket(Request $request)
    // {
    //     $data = [
    //         'menu' => 'transaksi',
    //         'submenu' => 'estimasi_bp',
    //         'submenu1' => 'body_repair',
    //         'title' => 'Estimasi WO Body Repair',
    //         'estimasi_bp' => Estimasi_bp::orderBy('kode', 'asc')->get(),
    //     ];
    //     // var_dump($data);
    //     return view('estimasi_bp.tabel_paket')->with($data);
    // }

    public function create(Request $request)
    {
        if ($request->Ajax()) {
            $tbmobil = Tbmobil::where('id', $request->id)->first();
            $nopolisi = $tbmobil->nopolisi;
            $data = [
                'menu' => 'transaksi',
                'submenu' => 'estimasi_bp',
                'submenu1' => 'body_repair',
                'title' => 'Tambah Data Task List Body Repair',
                // 'estimasi_bp' => Estimasi_bp::all(),
            ];
            // var_dump($data);
            return response()->json([
                'body' => view('estimasi_bp.modaltambahestimasi', [
                    'estimasi_bp' => new estimasi_bp(), //Estimasi_bp::first(),
                    'tbasuransi' => Tbasuransi::orderBy('nama')->get(),
                    'tbmobil' => $tbmobil, //Tbmobil::findOrFail($id),
                    'action' => route('estimasi_bp.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,

            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    // public function estimasi_bp_create(Request $request)
    // {
    //     if ($request->Ajax()) {
    //         $id = $request->id;
    //         $tbmobil = Tbmobil::where('id', $id)->first();
    //         $nopolisi = $tbmobil->nopolisi;
    //         $username = session('username');
    //         $estimasi_bp = Estimasi_bp::where('nopolisi', $nopolisi)->first();
    //         // dd($estimasi_bp);
    //         $data = [
    //             'menu' => 'transaksi',
    //             'submenu' => 'estimasi_bp',
    //             'submenu1' => 'body_repair',
    //             'title' => 'Tambah Estimasi WO Body Repair',
    //             'userdtl' => Userdtl::where('cmodule', 'Estimasi WO Body Repair')->where('username', $username)->first(),
    //         ];
    //         // return view('estimasi_bp.modaldetail')->with($data);
    //         return response()->json([
    //             'body' => view('estimasi_bp.modaltambahestimasi', [
    //                 'tbmobil' => $tbmobil, //Tbmobil::findOrFail($id),
    //                 'estimasi_bp' => $estimasi_bp, //Estimasi_bp::where('nopolisi', $nopolisi)->get(),
    //                 // 'action' => route('estimasi_bp.store'),
    //                 'action' => 'estimasi_bp_tambah',
    //                 'vdata' => $data,
    //             ])->render(),
    //             'data' => $data,
    //         ]);
    //     } else {
    //         exit('Maaf tidak dapat diproses');
    //     }
    // }

    // public function estimasi_bp_tambah(Estimasi_bpRequest $request, estimasi_bp $estimasi_bp)
    // {
    //     if ($request->Ajax()) {
    //         $noestimasi = 'BE' . date('Y') . date('m') . sprintf("%05s", intval(substr('00000', -5)) + 1);
    //         $rec = Estimasi_bp::where('noestimasi', $noestimasi)->first();
    //         if (isset($rec)) {
    //             $noakhir = Estimasi_bp::orderBy('noestimasi', 'desc')->max('noestimasi');
    //             $noestimasi = 'BE' . date('Y') . date('m') . sprintf("%05s", intval(substr($noakhir, -5)) + 1);
    //         }
    //         $id = $request->idestimasi;
    //         $klaim = $request->klaim == 'on' ? '1' : '0';
    //         $internal = $request->internal == 'on' ? '1' : '0';
    //         $inventaris = $request->inventaris == 'on' ? '1' : '0';
    //         $campaign = $request->campaign == 'on' ? '1' : '0';
    //         $booking = $request->booking == 'on' ? '1' : '0';
    //         $lain_lain = $request->lain_lain == 'on' ? '1' : '0';
    //         $tanggal = isset($request->tanggal) ? $request->tanggal : "";
    //         $tanggal = isset($request->tanggal) ? $request->tanggal : "";
    //         $nopolisi = isset($request->nopolisi) ? $request->nopolisi : "";
    //         $norangka = isset($request->norangka) ? $request->norangka : "";
    //         $kdpemilik = isset($request->kdpemilik) ? $request->kdpemilik : "";
    //         $nmpemilik = isset($request->nmpemilik) ? $request->nmpemilik : "";
    //         $kdsa = isset($request->kdsa) ? $request->kdsa : "";
    //         $kdservice = isset($request->kdservice) ? $request->kdservice : "";
    //         $nmservice = isset($request->nmservice) ? $request->nmservice : "";
    //         $km = isset($request->km) ? $request->km : "";
    //         $kdpaket = isset($request->kdpaket) ? $request->kdpaket : "";
    //         $aktifitas = isset($request->aktifitas) ? $request->aktifitas : "";
    //         $fasilitas = isset($request->fasilitas) ? $request->fasilitas : "";
    //         $status_tunggu = isset($request->status_tunggu) ? $request->status_tunggu : "";
    //         $int_reminder = isset($request->int_reminder) ? $request->int_reminder : "";
    //         $via = isset($request->via) ? $request->via : "";
    //         $kdsa = isset($request->kdsa) ? $request->kdsa : "";
    //         $nmsa = isset($request->nmsa) ? $request->nmsa : "";
    //         $keluhan = isset($request->keluhan) ? $request->keluhan : "";
    //         $pr_ppn = isset($request->pr_ppn) ? $request->pr_ppn : "";
    //         $no_polis = isset($request->no_polis) ? $request->no_polis : "";
    //         $nama_polis = isset($request->nama_polis) ? $request->nama_polis : "";
    //         $tgl_akhir_polis = isset($request->tgl_akhir_polis) ? $request->tgl_akhir_polis : "";
    //         $kdasuransi = isset($request->kdasuransi) ? $request->kdasuransi : "";
    //         $nmasuransi = isset($request->nmasuransi) ? $request->nmasuransi : "";
    //         $alamat_asuransi = isset($request->alamat_asuransi) ? $request->alamat_asuransi : "";
    //         $klaim = $klaim;
    //         $internal = $internal;
    //         $inventaris = $inventaris;
    //         $campaign = $campaign;
    //         $booking = $booking;
    //         $lain_lain = $lain_lain;
    //         $surveyor = isset($request->surveyor) ? $request->surveyor : "";
    //         $npwp = isset($request->npwp) ? $request->npwp : "";
    //         $contact_person = isset($request->contact_person) ? $request->contact_person : "";
    //         $no_contact_person = isset($request->no_contact_person) ? $request->no_contact_person : "";
    //         $own_risk = isset($request->own_risk) ? $request->own_risk : "";
    //         $user = 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s');
    //         $update = Estimasi_bp::insert([
    //             'noestimasi' => $noestimasi, 'tanggal' => $tanggal, 'nopolisi' => $nopolisi, 'norangka' => $norangka,
    //             'kdpemilik' => $kdpemilik, 'nmpemilik' => $nmpemilik, 'kdsa' => $kdsa, 'kdservice' => $kdservice,
    //             'nmservice' => $nmservice, 'km' => $km, 'kdpaket' => $kdpaket, 'aktifitas' => $aktifitas,
    //             'fasilitas' => $fasilitas, 'status_tunggu' => $status_tunggu, 'int_reminder' => $int_reminder,
    //             'via' => $via, 'nmsa' => $nmsa, 'keluhan' => $keluhan, 'pr_ppn' => $pr_ppn,
    //             'no_polis' => $no_polis, 'nama_polis' => $nama_polis, 'tgl_akhir_polis' => $tgl_akhir_polis,
    //             'kdasuransi' => $kdasuransi, 'nmasuransi' => $nmasuransi, 'alamat_asuransi' => $alamat_asuransi,
    //             'klaim' => $klaim, 'internal' => $internal, 'inventaris' => $inventaris, 'campaign' => $campaign,
    //             'booking' => $booking, 'lain_lain' => $lain_lain, 'surveyor' => $surveyor, 'npwp' => $npwp,
    //             'contact_person' => $contact_person, 'no_contact_person' => $no_contact_person, 'own_risk' => $own_risk, 'user' => $user
    //         ]);
    //         if ($update) {
    //             $msg = [
    //                 'sukses' => 'Data berhasil di update', //view('tbmobil.tabel_mobil')
    //             ];
    //         } else {
    //             $msg = [
    //                 'sukses' => 'Data gagal update', //view('tbmobil.tabel_mobil')
    //             ];
    //         }
    //         echo json_encode($msg);
    //         // return redirect()->back()->with('message', 'Berhasil di simpan');
    //     } else {
    //         exit('Maaf tidak dapat diproses');
    //     }
    // }

    public function store(Estimasi_bpRequest $request, estimasi_bp $estimasi_bp)
    {
        if ($request->Ajax()) {
            $validated = $request->validated();
            if ($validated) {
                $noestimasi = 'BE' . date('Y') . date('m') . sprintf("%05s", intval(substr('00000', -5)) + 1);
                $rec = Estimasi_bp::where('noestimasi', $noestimasi)->first();
                if (isset($rec)) {
                    $noakhir = Estimasi_bp::orderBy('noestimasi', 'desc')->max('noestimasi');
                    $noestimasi = 'BE' . date('Y') . date('m') . sprintf("%05s", intval(substr($noakhir, -5)) + 1);
                }
                // dd($noestimasi);
                $aktif = $request->aktif == 'on' ? 'Y' : 'N';
                $klaim = $request->klaim == 'on' ? '1' : '0';
                $internal = $request->internal == 'on' ? '1' : '0';
                $inventaris = $request->inventaris == 'on' ? '1' : '0';
                $campaign = $request->campaign == 'on' ? '1' : '0';
                $booking = $request->booking == 'on' ? '1' : '0';
                $lain_lain = $request->lain_lain == 'on' ? '1' : '0';
                $estimasi_bp->fill([
                    'noestimasi' => $noestimasi,
                    'tanggal' => isset($request->tanggal) ? $request->tanggal : '',
                    'est_selesai' => isset($request->est_selesai) ? $request->est_selesai : '',
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
                    'pr_ppn' => isset($request->pr_ppn) ? $request->pr_ppn : '',
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
                $estimasi_bp->save($validated);
                $msg = [
                    'sukses' => 'Data berhasil di simpan', //view('estimasi_bp.tabel_paket')
                ];
            } else {
                $msg = [
                    'sukses' => 'Gagal di simpan', //view('estimasi_bp.tabel_paket')
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
            $rec = Estimasi_bp::where('id', $request->id)->first();
            $nopolisi = $rec->nopolisi;
            $username = session('username');
            $data = [
                'menu' => 'transaksi',
                'submenu' => 'estimasi_bp',
                'submenu1' => 'body_repair',
                'title' => 'Detail Estimasi Body Repair',
                'estimasi_bp' => Estimasi_bp::findOrFail($id),
                'userdtl' => Userdtl::where('cmodule', 'Estimasi WO Body Repair')->where('username', $username)->first(),
            ];
            // return view('estimasi_bp.modaldetail')->with($data);
            return response()->json([
                'body' => view('estimasi_bp.modaltambahestimasi', [
                    'estimasi_bp' => Estimasi_bp::findOrFail($id),
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

    public function edit(estimasi_bp $estimasi_bp, Request $request)
    {
        if ($request->Ajax()) {
            $rec = Estimasi_bp::where('id', $request->id)->first();
            $nopolisi = $rec->nopolisi;
            // dd($nopolisi);
            $data = [
                'menu' => 'transaksi',
                'submenu' => 'estimasi_bp',
                'submenu1' => 'body_repair',
                'title' => 'Edit Data Task List Body Repair',
            ];
            return response()->json([
                'body' => view('estimasi_bp.modaltambahestimasi', [
                    'estimasi_bp' => $estimasi_bp,
                    'tbmobil' => Tbmobil::where('nopolisi', $nopolisi)->first(),
                    'tbasuransi' => Tbasuransi::orderBy('nama')->get(),
                    'action' => route('estimasi_bp.update', $estimasi_bp->id),
                    // 'action' => 'estimasi_bp_update',
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    // public function estimasi_bp_edit(estimasi_bp $estimasi_bp, Request $request)
    // {
    //     if ($request->Ajax()) {
    //         $rec = Estimasi_bp::where('id', $request->id)->first();
    //         $nopolisi = $rec->nopolisi;
    //         // dd($nopolisi);
    //         $data = [
    //             'menu' => 'transaksi',
    //             'submenu' => 'estimasi_bp',
    //             'submenu1' => 'body_repair',
    //             'title' => 'Edit Data Task List Body Repair',
    //         ];
    //         return response()->json([
    //             'body' => view('estimasi_bp.modaltambahestimasi', [
    //                 'estimasi_bp' => $estimasi_bp,
    //                 'tbmobil' => Tbmobil::where('nopolisi', $nopolisi)->first(),
    //                 'tbasuransi' => Tbasuransi::orderBy('nama')->get(),
    //                 // 'action' => route('estimasi_bp.update', $estimasi_bp->id),
    //                 'action' => 'estimasi_bp_update',
    //                 'vdata' => $data,
    //             ])->render(),
    //             'data' => $data,
    //         ]);
    //     } else {
    //         exit('Maaf tidak dapat diproses');
    //     }
    // }

    public function update(Estimasi_bpRequest $request, estimasi_bp $estimasi_bp)
    {
        if ($request->Ajax()) {
            $validated = $request->validated();
            if ($validated) {
                $aktif = $request->aktif == 'on' ? 'Y' : 'N';
                $klaim = $request->klaim == 'on' ? '1' : '0';
                $internal = $request->internal == 'on' ? '1' : '0';
                $inventaris = $request->inventaris == 'on' ? '1' : '0';
                $campaign = $request->campaign == 'on' ? '1' : '0';
                $booking = $request->booking == 'on' ? '1' : '0';
                $lain_lain = $request->lain_lain == 'on' ? '1' : '0';
                $row_estimasi_bp = Estimasi_bp::where('noestimasi', $request->noestimasilama)->first();
                $dpp = $row_estimasi_bp->dpp;
                $ppn = $dpp * ($request->pr_ppn / 100);
                $total_estimasi = $dpp + $ppn;
                $estimasi_bp->fill([
                    'noestimasi' => isset($request->noestimasilama) ? $request->noestimasilama : '',
                    'tanggal' => isset($request->tanggal) ? $request->tanggal : '',
                    'est_selesai' => isset($request->est_selesai) ? $request->est_selesai : '',
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
                    'pr_ppn' => isset($request->pr_ppn) ? $request->pr_ppn : '',
                    'total_estimasi' => $total_estimasi,
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
                $estimasi_bp->save($validated);
                $msg = [
                    'sukses' => 'Data berhasil di update', //view('estimasi_bp.tabel_paket')
                ];
            } else {
                $msg = [
                    'sukses' => 'Data gagal di update', //view('estimasi_bp.tabel_paket')
                ];
            }
            echo json_encode($msg);
            // return redirect()->back()->with('message', 'Berhasil di update');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    // public function estimasi_bp_update(Request $request, estimasi_bp $estimasi_bp)
    // {
    //     if ($request->Ajax()) {
    //         $validated = $request->validate(
    //             [
    //                 'nopolisi' => 'required',
    //                 'noestimasi' => 'required',
    //             ],
    //             [
    //                 'nopolisi.required' => 'No.Polisi harus di isi',
    //                 'noestimasi.required' => 'No.Estimasi harus di isi',
    //             ],
    //         );
    //         if ($validated) {
    //             $id = $request->idestimasi;
    //             $klaim = $request->klaim == 'on' ? '1' : '0';
    //             $internal = $request->internal == 'on' ? '1' : '0';
    //             $inventaris = $request->inventaris == 'on' ? '1' : '0';
    //             $campaign = $request->campaign == 'on' ? '1' : '0';
    //             $booking = $request->booking == 'on' ? '1' : '0';
    //             $lain_lain = $request->lain_lain == 'on' ? '1' : '0';
    //             $tanggal = isset($request->tanggal) ? $request->tanggal : "";
    //             $noestimasi = isset($request->noestimasilama) ? $request->noestimasilama : "";
    //             $tanggal = isset($request->tanggal) ? $request->tanggal : "";
    //             $nopolisi = isset($request->nopolisi) ? $request->nopolisi : "";
    //             $norangka = isset($request->norangka) ? $request->norangka : "";
    //             $kdpemilik = isset($request->kdpemilik) ? $request->kdpemilik : "";
    //             $nmpemilik = isset($request->nmpemilik) ? $request->nmpemilik : "";
    //             $kdsa = isset($request->kdsa) ? $request->kdsa : "";
    //             $kdservice = isset($request->kdservice) ? $request->kdservice : "";
    //             $nmservice = isset($request->nmservice) ? $request->nmservice : "";
    //             $km = isset($request->km) ? $request->km : "";
    //             $kdpaket = isset($request->kdpaket) ? $request->kdpaket : "";
    //             $aktifitas = isset($request->aktifitas) ? $request->aktifitas : "";
    //             $fasilitas = isset($request->fasilitas) ? $request->fasilitas : "";
    //             $status_tunggu = isset($request->status_tunggu) ? $request->status_tunggu : "";
    //             $int_reminder = isset($request->int_reminder) ? $request->int_reminder : "";
    //             $via = isset($request->via) ? $request->via : "";
    //             $kdsa = isset($request->kdsa) ? $request->kdsa : "";
    //             $nmsa = isset($request->nmsa) ? $request->nmsa : "";
    //             $keluhan = isset($request->keluhan) ? $request->keluhan : "";
    //             $pr_ppn = isset($request->pr_ppn) ? $request->pr_ppn : "";
    //             $no_polis = isset($request->no_polis) ? $request->no_polis : "";
    //             $nama_polis = isset($request->nama_polis) ? $request->nama_polis : "";
    //             $tgl_akhir_polis = isset($request->tgl_akhir_polis) ? $request->tgl_akhir_polis : "";
    //             $kdasuransi = isset($request->kdasuransi) ? $request->kdasuransi : "";
    //             $nmasuransi = isset($request->nmasuransi) ? $request->nmasuransi : "";
    //             $alamat_asuransi = isset($request->alamat_asuransi) ? $request->alamat_asuransi : "";
    //             $klaim = $klaim;
    //             $internal = $internal;
    //             $inventaris = $inventaris;
    //             $campaign = $campaign;
    //             $booking = $booking;
    //             $lain_lain = $lain_lain;
    //             $surveyor = isset($request->surveyor) ? $request->surveyor : "";
    //             $npwp = isset($request->npwp) ? $request->npwp : "";
    //             $contact_person = isset($request->contact_person) ? $request->contact_person : "";
    //             $no_contact_person = isset($request->no_contact_person) ? $request->no_contact_person : "";
    //             $own_risk = isset($request->own_risk) ? $request->own_risk : "";
    //             $user = 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s');
    //             $update = $estimasi_bp::where('id', $id)->update([
    //                 'noestimasi' => $noestimasi, 'tanggal' => $tanggal, 'nopolisi' => $nopolisi, 'norangka' => $norangka,
    //                 'kdpemilik' => $kdpemilik, 'nmpemilik' => $nmpemilik, 'kdsa' => $kdsa, 'kdservice' => $kdservice,
    //                 'nmservice' => $nmservice, 'km' => $km, 'kdpaket' => $kdpaket, 'aktifitas' => $aktifitas,
    //                 'fasilitas' => $fasilitas, 'status_tunggu' => $status_tunggu, 'int_reminder' => $int_reminder,
    //                 'via' => $via, 'nmsa' => $nmsa, 'keluhan' => $keluhan, 'pr_ppn' => $pr_ppn,
    //                 'no_polis' => $no_polis, 'nama_polis' => $nama_polis, 'tgl_akhir_polis' => $tgl_akhir_polis,
    //                 'kdasuransi' => $kdasuransi, 'nmasuransi' => $nmasuransi, 'alamat_asuransi' => $alamat_asuransi,
    //                 'klaim' => $klaim, 'internal' => $internal, 'inventaris' => $inventaris, 'campaign' => $campaign,
    //                 'booking' => $booking, 'lain_lain' => $lain_lain, 'surveyor' => $surveyor, 'npwp' => $npwp,
    //                 'contact_person' => $contact_person, 'no_contact_person' => $no_contact_person, 'own_risk' => $own_risk, 'user' => $user
    //             ]);
    //             if ($update) {
    //                 $msg = [
    //                     'sukses' => 'Data berhasil di update', //view('tbmobil.tabel_mobil')
    //                 ];
    //             } else {
    //                 $msg = [
    //                     'sukses' => 'Data gagal update', //view('tbmobil.tabel_mobil')
    //                 ];
    //             }
    //         } else {
    //             $msg = [
    //                 'sukses' => 'Data gagal di update', //view('tbmobil.tabel_mobil')
    //             ];
    //         }
    //         echo json_encode($msg);
    //         // return redirect()->back()->with('message', 'Berhasil di update');
    //     } else {
    //         exit('Maaf tidak dapat diproses');
    //     }
    // }

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
                    'estimasi_bp' => Estimasi_bp::where('nopolisi', $nopolisi)->get(),
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
    //         Estimasi_bp::where('id', $request->id)->delete();
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
            Estimasi_bp::where('id', $request->id)->update(['batal' => 1]);
            return response()->json([
                'sukses' => true,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
    public function estimasi_bpambil(Request $request)
    {
        if ($request->Ajax()) {
            Estimasi_bp::where('id', $request->id)->update(['batal' => 0]);
            return response()->json([
                'sukses' => true,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function estimasi_bpproses(Request $request)
    {
        if ($request->Ajax()) {
            Estimasi_bp::where('id', $request->id)->update(['close' => 1]);
            $data = Estimasi_bp::where('id', $request->id)->first();
            //Create History
            $tanggal = date('Y-m-d');
            $datetime = date('Y-m-d H:i:s');
            $dokumen = $data->noestimasi;
            $form = 'Estimasi BP';
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
    public function estimasi_bpunproses_simpan(Request $request)
    {
        if ($request->Ajax()) {
            Estimasi_bp::where('id', $request->id)->update([
                'close' => 0, 'user' => 'Unproses-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                'ket_proses' => $request->catatan . ' (' . date('d-m-Y h:i:s') . '}'
            ]);
            //Create History
            $tanggal = date('Y-m-d');
            $datetime = date('Y-m-d H:i:s');
            $dokumen = $request->dokumen;
            $form = 'Estimasi BP';
            $status = 'Unproses';
            $catatan = isset($request->catatan) ? $request->catatan : '';
            $username = session('username');
            Hisuser::insert(['tanggal' => $tanggal, 'dokumen' => $dokumen, 'form' => $form, 'status' => $status, 'user' => $username, 'catatan' => $catatan, 'datetime' => $datetime]);
            $msg = [
                'sukses' => 'Data berhasil di tambah', //view('tbbarang.tabel_barang')
            ];
            return response()->json([
                'sukses' => true,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
    public function estimasi_bpunproses(Request $request)
    {
        if ($request->Ajax()) {
            $username = session('username');
            $id = $request->id;
            $estimasi_bp = Estimasi_bp::where('id', $id)->first();
            $data = [
                'menu' => 'transaksi',
                'submenu' => 'estimasi_bp',
                'submenu1' => 'body_repair',
                'title' => 'Unproses Estimasi WO Body Repair',
                'userdtl' => Userdtl::where('cmodule', 'Estimasi WO Body Repair')->where('username', $username)->first(),
            ];
            // return view('estimasi_bp.modaldetail')->with($data);
            return response()->json([
                'body' => view('estimasi_bp.modalbatalproses', [
                    'estimasi_bp' => $estimasi_bp,
                    'action' => 'estimasi_bpunproses_simpan',
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function detailestimasi_bp(estimasi_bp $estimasi_bp, Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'transaksi',
                'submenu' => 'estimasi_bp',
                'submenu1' => 'body_repair',
                'title' => 'Detail Estimasi Body Repair',
            ];
            $id = $request->id;
            $estimasi_bp = Estimasi_bp::where('id', $id)->first();
            $estimasi_bpd = Estimasi_bpd::where('noestimasi', $estimasi_bp->noestimasi)->get();
            return response()->json([
                'body' => view('estimasi_bp.modaldetailestimasi', [
                    'submenu' => 'estimasi_bp',
                    'estimasi_bp' => $estimasi_bp,
                    'estimasi_bpd' => $estimasi_bpd,
                    'action' => '', //route('estimasi_bpd.store', $estimasi_bp->id),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function cetak_estimasi_bp(Request $request)
    {
        $row_estimasi_bp = Estimasi_bp::where('id', $request->id)->first();
        $noestimasi = $row_estimasi_bp->noestimasi;
        $kdpemilik = $row_estimasi_bp->kdpemilik;
        $nopolisi = $row_estimasi_bp->nopolisi;
        $row_tbmobil = Tbmobil::join('tbtipe', 'tbmobil.kdtipe', '=', 'tbtipe.kode')->where('tbmobil.nopolisi', $nopolisi)
            ->select('tbmobil.*', 'tbtipe.nama as nmtipe')
            ->first();
        $row_tbcustomer = Tbcustomer::where('kode', $kdpemilik)->first();
        $data = [
            'saplikasi' => Saplikasi::where('aktif', 'Y')->first(),
            'estimasi_bp' => $row_estimasi_bp,
            'tbmobil' => $row_tbmobil,
            'tbcustomer' => $row_tbcustomer,
            'estimasi_bpd_jasa' => Estimasi_bp::join('estimasi_bpd', 'estimasi_bpd.noestimasi', '=', 'estimasi_bp.noestimasi')
                ->join('tbcustomer', 'tbcustomer.kode', '=', 'estimasi_bp.kdpemilik')
                ->select('estimasi_bp.*', 'estimasi_bpd.*')
                ->where('estimasi_bpd.noestimasi', $noestimasi)->where('estimasi_bpd.jenis', 'JASA')->orwhere('estimasi_bpd.jenis', 'OPL')->get(),
            'estimasi_bpd_part' => Estimasi_bp::join('estimasi_bpd', 'estimasi_bpd.noestimasi', '=', 'estimasi_bp.noestimasi')
                ->join('tbcustomer', 'tbcustomer.kode', '=', 'estimasi_bp.kdpemilik')
                ->join('tbmobil', 'tbmobil.nopolisi', '=', 'estimasi_bp.nopolisi')
                ->join('tbbarang', 'tbbarang.kode', '=', 'estimasi_bpd.kode')
                ->join('tbsatuan', 'tbsatuan.kode', '=', 'tbbarang.kdsatuan')
                ->select('estimasi_bp.*', 'estimasi_bpd.*', 'tbsatuan.kode as kdsatuan', 'tbsatuan.nama as nmsatuan')
                ->where('estimasi_bpd.noestimasi', $noestimasi)->where('estimasi_bpd.jenis', 'PART')->get(),
            'estimasi_bpd_bahan' => Estimasi_bp::join('estimasi_bpd', 'estimasi_bpd.noestimasi', '=', 'estimasi_bp.noestimasi')
                ->join('tbcustomer', 'tbcustomer.kode', '=', 'estimasi_bp.kdpemilik')
                ->join('tbmobil', 'tbmobil.nopolisi', '=', 'estimasi_bp.nopolisi')
                ->join('tbbahan', 'tbbahan.kode', '=', 'estimasi_bpd.kode')
                ->join('tbsatuan', 'tbsatuan.kode', '=', 'tbbahan.kdsatuan')
                ->select('estimasi_bp.*', 'estimasi_bpd.*', 'tbsatuan.kode as kdsatuan', 'tbsatuan.nama as nmsatuan')
                ->where('estimasi_bpd.noestimasi', $noestimasi)->where('estimasi_bpd.jenis', 'BAHAN')->get(),
        ];
        // return view('jual.cetak', $data);

        $rowd = estimasi_bpd::where('noestimasi', $noestimasi)->get();
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
        $estimasi_bp = Estimasi_bp::where('id', $request->id)->first();
        $tanggal = date('Y-m-d');
        $datetime = date('Y-m-d H:i:s');
        $dokumen = $estimasi_bp->noestimasi;
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
        $mpdf->WriteHTML(view('estimasi_bp.cetak', $data));
        $namafile = $noestimasi . ' - ' . date('dmY H:i:s') . '.pdf';
        //return the PDF for download
        // return $mpdf->Output($request->get('name') . $namafile, Destination::DOWNLOAD);
        $mpdf->Output($namafile, 'I');
    }

    public function buatwo_bp(Request $request, wo_bp $wo_bp)
    {
        if ($request->Ajax()) {
            $idestimasi = $request->idestimasi;
            $row_estimasi_bp = Estimasi_bp::where('id', $idestimasi)->first();
            // $validated = $request->validated();
            // if ($validated) {
            $nowo = 'BW' . date('Y') . date('m') . sprintf("%05s", intval(substr('00000', -5)) + 1);
            $rec = Wo_bp::where('nowo', $nowo)->first();
            if (isset($rec)) {
                $noakhir = Wo_bp::orderBy('nowo', 'desc')->max('nowo');
                $nowo = 'BW' . date('Y') . date('m') . sprintf("%05s", intval(substr($noakhir, -5)) + 1);
            }
            $klaim = $row_estimasi_bp->klaim;
            $internal = $row_estimasi_bp->internal;
            $inventaris = $row_estimasi_bp->inventaris;
            $campaign = $row_estimasi_bp->campaign;
            $booking = $row_estimasi_bp->booking;
            $lain_lain = $row_estimasi_bp->lain_lain;
            $wo_bp->fill([
                'nowo' => $nowo,
                'noestimasi' => $row_estimasi_bp->noestimasi,
                'tglestimasi' => isset($row_estimasi_bp->tanggal) ? $row_estimasi_bp->tanggal : '',
                'tglwo' => date('Y-m-d H:i:s'),
                'nopolisi' => isset($row_estimasi_bp->nopolisi) ? $row_estimasi_bp->nopolisi : '',
                'norangka' => isset($row_estimasi_bp->norangka) ? $row_estimasi_bp->norangka : '',
                'kdpemilik' => isset($row_estimasi_bp->kdpemilik) ? $row_estimasi_bp->kdpemilik : '',
                'nmpemilik' => isset($row_estimasi_bp->nmpemilik) ? $row_estimasi_bp->nmpemilik : '',
                'kdsa' => isset($row_estimasi_bp->kdsa) ? $row_estimasi_bp->kdsa : '',
                'kdservice' => isset($row_estimasi_bp->kdservice) ? $row_estimasi_bp->kdservice : '',
                'nmservice' => isset($row_estimasi_bp->nmservice) ? $row_estimasi_bp->nmservice : '',
                'km' => isset($row_estimasi_bp->km) ? $row_estimasi_bp->km : '',
                'kdpaket' => isset($row_estimasi_bp->kdpaket) ? $row_estimasi_bp->kdpaket : '',
                'aktifitas' => isset($row_estimasi_bp->aktifitas) ? $row_estimasi_bp->aktifitas : '',
                'fasilitas' => isset($row_estimasi_bp->fasilitas) ? $row_estimasi_bp->fasilitas : '',
                'status_tunggu' => isset($row_estimasi_bp->status_tunggu) ? $row_estimasi_bp->status_tunggu : '',
                'int_reminder' => isset($row_estimasi_bp->int_reminder) ? $row_estimasi_bp->int_reminder : '',
                'via' => isset($row_estimasi_bp->via) ? $row_estimasi_bp->via : '',
                'kdsa' => isset($row_estimasi_bp->kdsa) ? $row_estimasi_bp->kdsa : '',
                'nmsa' => isset($row_estimasi_bp->nmsa) ? $row_estimasi_bp->nmsa : '',
                'keluhan' => isset($row_estimasi_bp->keluhan) ? $row_estimasi_bp->keluhan : '',
                'no_polis' => isset($row_estimasi_bp->no_polis) ? $row_estimasi_bp->no_polis : '',
                'nama_polis' => isset($row_estimasi_bp->nama_polis) ? $row_estimasi_bp->nama_polis : '',
                'tgl_akhir_polis' => isset($row_estimasi_bp->tgl_akhir_polis) ? $row_estimasi_bp->tgl_akhir_polis : '',
                'kdasuransi' => isset($row_estimasi_bp->kdasuransi) ? $row_estimasi_bp->kdasuransi : '',
                'nmasuransi' => isset($row_estimasi_bp->nmasuransi) ? $row_estimasi_bp->nmasuransi : '',
                'alamat_asuransi' => isset($row_estimasi_bp->alamat_asuransi) ? $row_estimasi_bp->alamat_asuransi : '',
                'klaim' => $klaim,
                'internal' => $internal,
                'inventaris' => $inventaris,
                'campaign' => $campaign,
                'booking' => $booking,
                'lain_lain' => $lain_lain,
                'surveyor' => isset($row_estimasi_bp->surveyor) ? $row_estimasi_bp->surveyor : '',
                'npwp' => isset($row_estimasi_bp->npwp) ? $row_estimasi_bp->npwp : '',
                'contact_person' => isset($row_estimasi_bp->contact_person) ? $row_estimasi_bp->contact_person : '',
                'no_contact_person' => isset($row_estimasi_bp->no_contact_person) ? $row_estimasi_bp->no_contact_person : '',
                'own_risk' => isset($row_estimasi_bp->own_risk) ? $row_estimasi_bp->own_risk : '',
                'total_jasa' => $row_estimasi_bp->total_jasa,
                'total_part' => $row_estimasi_bp->total_part,
                'total_bahan' => $row_estimasi_bp->total_bahan,
                'total_opl' => $row_estimasi_bp->total_opl,
                'total' => $row_estimasi_bp->total,
                'dpp' => $row_estimasi_bp->dpp,
                'pr_ppn' => $row_estimasi_bp->pr_ppn,
                'ppn' => $row_estimasi_bp->ppn,
                'total_wo' => $row_estimasi_bp->total_estimasi,
                'user' => 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s'),
            ]);
            // $wo_bp->save($validated);
            $wo_bp->save();
            Estimasi_bp::where('noestimasi', $row_estimasi_bp->noestimasi)->update(['nowo' => $nowo]);
            $row_estimasi_bpd = Estimasi_bpd::where('noestimasi', $row_estimasi_bp->noestimasi)->get();
            Wo_bpd::where('noestimasi', $row_estimasi_bp->noestimasi)->delete();
            foreach ($row_estimasi_bpd as $row) {
                Wo_bpd::insert([
                    'nowo' => $nowo, 'kode' => $row->kode, 'nama' => $row->nama, 'kerusakan' => $row->kerusakan, 'jenis' => $row->jenis, 'qty' => $row->qty,
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
}
