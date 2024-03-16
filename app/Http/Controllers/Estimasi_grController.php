<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use App\Http\Requests\Estimasi_grRequest;
use App\Http\Requests\Wo_grRequest;
use Illuminate\Http\Request;
use Session;
// use Yajra\DataTables\Contracts\DataTables;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Tbmobil;
use App\Models\Estimasi_gr;
use App\Models\Estimasi_grd;
use App\Models\Tbasuransi;
use App\Models\Tbmerek;
use App\Models\Tbmodel;
use App\Models\Tbtipe;
use App\Models\Tbwarna;
use App\Models\Tbjenis;
use App\Models\Tbcustomer;
use App\Models\Wo_gr;
use App\Models\Wo_grd;
use App\Models\Hisuser;
use App\Models\Userdtl;
use App\Models\Saplikasi;

// //return type View
// use Illuminate\View\View;

class Estimasi_grController extends Controller
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
            'submenu' => 'estimasi_gr',
            'submenu1' => 'general_repair',
            'title' => 'Estimasi WO General Repair',
            'userdtlmenu' => $userdtl,
            'userdtl' => Userdtl::where('cmodule', 'Estimasi WO General Repair')->where('username', $username)->first(),
        ];
        return view('estimasi_gr.index')->with($data);
    }

    public function tbmobil_grajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $data = Tbmobil::select('*'); //->orderBy('kode', 'asc');
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
            return view('estimasi_gr');
        }
    }

    public function estimasi_grajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $nopolisi = $_GET['nopolisi'];
            $data = Estimasi_gr::where('nopolisi', $nopolisi); //->orderBy('kode', 'asc');
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
            return view('estimasi_gr');
        }
    }

    public function wo_grajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $nopolisi = $_GET['nopolisi'];
            $data = Wo_gr::where('nopolisi', $nopolisi); //->orderBy('kode', 'asc');
            // $data = wo_gr::select('wo_gr.*', 'tbasuransi.nama as nmasuransi')->join('tbasuransi', 'tbasuransi.kode', '=', 'wo_gr.kdasuransi'); //->orderBy('kode', 'asc');
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
            return view('wo_gr');
        }
    }

    // public function tabel_paket(Request $request)
    // {
    //     $data = [
    //         'menu' => 'transaksi',
    //         'submenu' => 'estimasi_gr',
    //         'submenu1' => 'general_repair',
    //         'title' => 'Estimasi WO General Repair',
    //         'estimasi_gr' => Estimasi_gr::orderBy('kode', 'asc')->get(),
    //     ];
    //     // var_dump($data);
    //     return view('estimasi_gr.tabel_paket')->with($data);
    // }

    public function create(Request $request)
    {
        if ($request->Ajax()) {
            $tbmobil = Tbmobil::where('id', $request->id)->first();
            $nopolisi = $tbmobil->nopolisi;
            $data = [
                'menu' => 'transaksi',
                'submenu' => 'estimasi_gr',
                'submenu1' => 'general_repair',
                'title' => 'Tambah Data Task List General Repair',
                // 'estimasi_gr' => Estimasi_gr::all(),
            ];
            // var_dump($data);
            return response()->json([
                'body' => view('estimasi_gr.modaltambahestimasi', [
                    'estimasi_gr' => new estimasi_gr(), //Estimasi_gr::first(),
                    'tbasuransi' => Tbasuransi::orderBy('nama')->get(),
                    'tbmobil' => $tbmobil, //Tbmobil::findOrFail($id),
                    'action' => route('estimasi_gr.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,

            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    // public function estimasi_gr_create(Request $request)
    // {
    //     if ($request->Ajax()) {
    //         $id = $request->id;
    //         $tbmobil = Tbmobil::where('id', $id)->first();
    //         $nopolisi = $tbmobil->nopolisi;
    //         $username = session('username');
    //         $estimasi_gr = Estimasi_gr::where('nopolisi', $nopolisi)->first();
    //         // dd($estimasi_gr);
    //         $data = [
    //             'menu' => 'transaksi',
    //             'submenu' => 'estimasi_gr',
    //             'submenu1' => 'general_repair',
    //             'title' => 'Tambah Estimasi WO General Repair',
    //             'userdtl' => Userdtl::where('cmodule', 'Estimasi WO General Repair')->where('username', $username)->first(),
    //         ];
    //         // return view('estimasi_gr.modaldetail')->with($data);
    //         return response()->json([
    //             'body' => view('estimasi_gr.modaltambahestimasi', [
    //                 'tbmobil' => $tbmobil, //Tbmobil::findOrFail($id),
    //                 'estimasi_gr' => $estimasi_gr, //Estimasi_gr::where('nopolisi', $nopolisi)->get(),
    //                 // 'action' => route('estimasi_gr.store'),
    //                 'action' => 'estimasi_gr_tambah',
    //                 'vdata' => $data,
    //             ])->render(),
    //             'data' => $data,
    //         ]);
    //     } else {
    //         exit('Maaf tidak dapat diproses');
    //     }
    // }

    // public function estimasi_gr_tambah(Estimasi_grRequest $request, estimasi_gr $estimasi_gr)
    // {
    //     if ($request->Ajax()) {
    //         $noestimasi = 'GE' . date('Y') . date('m') . sprintf("%05s", intval(substr('00000', -5)) + 1);
    //         $rec = Estimasi_gr::where('noestimasi', $noestimasi)->first();
    //         if (isset($rec)) {
    //             $noakhir = Estimasi_gr::orderBy('noestimasi', 'desc')->max('noestimasi');
    //             $noestimasi = 'GE' . date('Y') . date('m') . sprintf("%05s", intval(substr($noakhir, -5)) + 1);
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
    //         $update = Estimasi_gr::insert([
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

    public function store(Estimasi_grRequest $request, estimasi_gr $estimasi_gr)
    {
        if ($request->Ajax()) {
            $validated = $request->validated();
            if ($validated) {
                $noestimasi = 'GE' . date('Y') . date('m') . sprintf("%05s", intval(substr('00000', -5)) + 1);
                $rec = Estimasi_gr::where('noestimasi', $noestimasi)->first();
                if (isset($rec)) {
                    $noakhir = Estimasi_gr::orderBy('noestimasi', 'desc')->max('noestimasi');
                    $noestimasi = 'GE' . date('Y') . date('m') . sprintf("%05s", intval(substr($noakhir, -5)) + 1);
                }
                // dd($noestimasi);
                $aktif = $request->aktif == 'on' ? 'Y' : 'N';
                $klaim = $request->klaim == 'on' ? '1' : '0';
                $internal = $request->internal == 'on' ? '1' : '0';
                $inventaris = $request->inventaris == 'on' ? '1' : '0';
                $campaign = $request->campaign == 'on' ? '1' : '0';
                $booking = $request->booking == 'on' ? '1' : '0';
                $lain_lain = $request->lain_lain == 'on' ? '1' : '0';
                $estimasi_gr->fill([
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
                $estimasi_gr->save($validated);
                $msg = [
                    'sukses' => 'Data berhasil di simpan', //view('estimasi_gr.tabel_paket')
                ];
            } else {
                $msg = [
                    'sukses' => 'Gagal di simpan', //view('estimasi_gr.tabel_paket')
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
            $rec = Estimasi_gr::where('id', $request->id)->first();
            $nopolisi = $rec->nopolisi;
            $username = session('username');
            $data = [
                'menu' => 'transaksi',
                'submenu' => 'estimasi_gr',
                'submenu1' => 'general_repair',
                'title' => 'Detail Estimasi WO General Repair',
                'estimasi_gr' => Estimasi_gr::findOrFail($id),
                'userdtl' => Userdtl::where('cmodule', 'Estimasi WO General Repair')->where('username', $username)->first(),
            ];
            // return view('estimasi_gr.modaldetail')->with($data);
            return response()->json([
                'body' => view('estimasi_gr.modaltambahestimasi', [
                    'estimasi_gr' => Estimasi_gr::findOrFail($id),
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

    public function edit(estimasi_gr $estimasi_gr, Request $request)
    {
        if ($request->Ajax()) {
            $rec = Estimasi_gr::where('id', $request->id)->first();
            $nopolisi = $rec->nopolisi;
            // dd($nopolisi);
            $data = [
                'menu' => 'transaksi',
                'submenu' => 'estimasi_gr',
                'submenu1' => 'general_repair',
                'title' => 'Edit Data Task List General Repair',
            ];
            return response()->json([
                'body' => view('estimasi_gr.modaltambahestimasi', [
                    'estimasi_gr' => $estimasi_gr,
                    'tbmobil' => Tbmobil::where('nopolisi', $nopolisi)->first(),
                    'tbasuransi' => Tbasuransi::orderBy('nama')->get(),
                    'action' => route('estimasi_gr.update', $estimasi_gr->id),
                    // 'action' => 'estimasi_gr_update',
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    // public function estimasi_gr_edit(estimasi_gr $estimasi_gr, Request $request)
    // {
    //     if ($request->Ajax()) {
    //         $rec = Estimasi_gr::where('id', $request->id)->first();
    //         $nopolisi = $rec->nopolisi;
    //         // dd($nopolisi);
    //         $data = [
    //             'menu' => 'transaksi',
    //             'submenu' => 'estimasi_gr',
    //             'submenu1' => 'general_repair',
    //             'title' => 'Edit Data Task List General Repair',
    //         ];
    //         return response()->json([
    //             'body' => view('estimasi_gr.modaltambahestimasi', [
    //                 'estimasi_gr' => $estimasi_gr,
    //                 'tbmobil' => Tbmobil::where('nopolisi', $nopolisi)->first(),
    //                 'tbasuransi' => Tbasuransi::orderBy('nama')->get(),
    //                 // 'action' => route('estimasi_gr.update', $estimasi_gr->id),
    //                 'action' => 'estimasi_gr_update',
    //                 'vdata' => $data,
    //             ])->render(),
    //             'data' => $data,
    //         ]);
    //     } else {
    //         exit('Maaf tidak dapat diproses');
    //     }
    // }

    public function update(Estimasi_grRequest $request, estimasi_gr $estimasi_gr)
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
                $row_estimasi_gr = Estimasi_gr::where('noestimasi', $request->noestimasilama)->first();
                $dpp = $row_estimasi_gr->dpp;
                $ppn = $dpp * ($request->pr_ppn / 100);
                $total_estimasi = $dpp + $ppn;
                $estimasi_gr->fill([
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
                $estimasi_gr->save($validated);
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

    // public function estimasi_gr_update(Request $request, estimasi_gr $estimasi_gr)
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
    //             $update = $estimasi_gr::where('id', $id)->update([
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
    public function vestimasi_gr(Request $request)
    {
        if ($request->Ajax()) {
            $id = $_GET['id'];
            $tbmobil = Tbmobil::where('id', $id)->first();
            $nopolisi = $tbmobil->nopolisi;
            $username = session('username');
            $data = [
                'menu' => 'transaksi',
                'submenu' => 'estimasi_gr',
                'submenu1' => 'general_repair',
                'title' => 'Estimasi WO General Repair',
                'userdtl' => Userdtl::where('cmodule', 'Estimasi WO General Repair')->where('username', $username)->first(),
            ];
            // return view('estimasi_gr.modaldetail')->with($data);
            return response()->json([
                'body' => view('estimasi_gr.modaltambah', [
                    'tbmobil' => $tbmobil, //Tbmobil::findOrFail($id),
                    'tbmerek' => Tbmerek::orderBy('nama')->get(),
                    'tbmodel' => Tbmodel::orderBy('nama')->get(),
                    'tbtipe' => Tbtipe::orderBy('nama')->get(),
                    'tbwarna' => Tbwarna::orderBy('nama')->get(),
                    'tbjenis' => Tbjenis::orderBy('nama')->get(),
                    'estimasi_gr' => Estimasi_gr::where('nopolisi', $nopolisi)->get(),
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

    // public function destroy(estimasi_gr $estimasi_gr, Request $request)
    // {
    //     if ($request->Ajax()) {
    //         Estimasi_gr::where('id', $request->id)->delete();
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
            Estimasi_gr::where('id', $request->id)->update(['batal' => 1]);
            return response()->json([
                'sukses' => true,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
    public function estimasi_grambil(Request $request)
    {
        if ($request->Ajax()) {
            Estimasi_gr::where('id', $request->id)->update(['batal' => 0]);
            return response()->json([
                'sukses' => true,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function estimasi_grproses(Request $request)
    {
        if ($request->Ajax()) {
            Estimasi_gr::where('id', $request->id)->update(['close' => 1]);
            $data = Estimasi_gr::where('id', $request->id)->first();
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
    public function estimasi_grunproses_simpan(Request $request)
    {
        if ($request->Ajax()) {
            Estimasi_gr::where('id', $request->id)->update([
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
    public function estimasi_grunproses(Request $request)
    {
        if ($request->Ajax()) {
            $username = session('username');
            $id = $request->id;
            $estimasi_gr = Estimasi_gr::where('id', $id)->first();
            $data = [
                'menu' => 'transaksi',
                'submenu' => 'estimasi_gr',
                'submenu1' => 'general_repair',
                'title' => 'Unproses Estimasi WO General Repair',
                'userdtl' => Userdtl::where('cmodule', 'Estimasi WO General Repair')->where('username', $username)->first(),
            ];
            // return view('estimasi_gr.modaldetail')->with($data);
            return response()->json([
                'body' => view('estimasi_gr.modalbatalproses', [
                    'estimasi_gr' => $estimasi_gr,
                    'action' => 'estimasi_grunproses_simpan',
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function detailestimasi_gr(estimasi_gr $estimasi_gr, Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'transaksi',
                'submenu' => 'estimasi_gr',
                'submenu1' => 'general_repair',
                'title' => 'Detail Estimasi WO General Repair',
            ];
            $id = $request->id;
            $estimasi_gr = Estimasi_gr::where('id', $id)->first();
            $estimasi_grd = Estimasi_grd::where('noestimasi', $estimasi_gr->noestimasi)->get();
            return response()->json([
                'body' => view('estimasi_gr.modaldetailestimasi', [
                    'submenu' => 'estimasi_gr',
                    'estimasi_gr' => $estimasi_gr,
                    'estimasi_grd' => $estimasi_grd,
                    'action' => '', //route('estimasi_grd.store', $estimasi_gr->id),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function cetak_estimasi_gr(Request $request)
    {
        $row_estimasi_gr = Estimasi_gr::where('id', $request->id)->first();
        $noestimasi = $row_estimasi_gr->noestimasi;
        $kdpemilik = $row_estimasi_gr->kdpemilik;
        $nopolisi = $row_estimasi_gr->nopolisi;
        $row_tbmobil = Tbmobil::join('tbtipe', 'tbmobil.kdtipe', '=', 'tbtipe.kode')->where('tbmobil.nopolisi', $nopolisi)
            ->select('tbmobil.*', 'tbtipe.nama as nmtipe')
            ->first();
        $row_tbcustomer = Tbcustomer::where('kode', $kdpemilik)->first();
        $data = [
            'saplikasi' => Saplikasi::where('aktif', 'Y')->first(),
            'estimasi_gr' => $row_estimasi_gr,
            'tbmobil' => $row_tbmobil,
            'tbcustomer' => $row_tbcustomer,
            'estimasi_grd_jasa' => Estimasi_gr::join('estimasi_grd', 'estimasi_grd.noestimasi', '=', 'estimasi_gr.noestimasi')
                ->join('tbcustomer', 'tbcustomer.kode', '=', 'estimasi_gr.kdpemilik')
                ->select('estimasi_gr.*', 'estimasi_grd.*')
                ->where('estimasi_grd.noestimasi', $noestimasi)->where('estimasi_grd.jenis', 'JASA')->orwhere('estimasi_grd.jenis', 'OPL')->get(),
            'estimasi_grd_part' => Estimasi_gr::join('estimasi_grd', 'estimasi_grd.noestimasi', '=', 'estimasi_gr.noestimasi')
                ->join('tbcustomer', 'tbcustomer.kode', '=', 'estimasi_gr.kdpemilik')
                ->join('tbmobil', 'tbmobil.nopolisi', '=', 'estimasi_gr.nopolisi')
                ->join('tbbarang', 'tbbarang.kode', '=', 'estimasi_grd.kode')
                ->join('tbsatuan', 'tbsatuan.kode', '=', 'tbbarang.kdsatuan')
                ->select('estimasi_gr.*', 'estimasi_grd.*', 'tbsatuan.kode as kdsatuan', 'tbsatuan.nama as nmsatuan')
                ->where('estimasi_grd.noestimasi', $noestimasi)->where('estimasi_grd.jenis', 'PART')->get(),
            'estimasi_grd_bahan' => Estimasi_gr::join('estimasi_grd', 'estimasi_grd.noestimasi', '=', 'estimasi_gr.noestimasi')
                ->join('tbcustomer', 'tbcustomer.kode', '=', 'estimasi_gr.kdpemilik')
                ->join('tbmobil', 'tbmobil.nopolisi', '=', 'estimasi_gr.nopolisi')
                ->join('tbbahan', 'tbbahan.kode', '=', 'estimasi_grd.kode')
                ->join('tbsatuan', 'tbsatuan.kode', '=', 'tbbahan.kdsatuan')
                ->select('estimasi_gr.*', 'estimasi_grd.*', 'tbsatuan.kode as kdsatuan', 'tbsatuan.nama as nmsatuan')
                ->where('estimasi_grd.noestimasi', $noestimasi)->where('estimasi_grd.jenis', 'BAHAN')->get(),
        ];
        // return view('jual.cetak', $data);

        $rowd = estimasi_grd::where('noestimasi', $noestimasi)->get();
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
        $estimasi_gr = Estimasi_gr::where('id', $request->id)->first();
        $tanggal = date('Y-m-d');
        $datetime = date('Y-m-d H:i:s');
        $dokumen = $estimasi_gr->noestimasi;
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
        $mpdf->WriteHTML(view('estimasi_gr.cetak', $data));
        $namafile = $noestimasi . ' - ' . date('dmY H:i:s') . '.pdf';
        //return the PDF for download
        // return $mpdf->Output($request->get('name') . $namafile, Destination::DOWNLOAD);
        $mpdf->Output($namafile, 'I');
    }

    public function buatwo_gr(Request $request, wo_gr $wo_gr)
    {
        if ($request->Ajax()) {
            $idestimasi = $request->idestimasi;
            $row_estimasi_gr = Estimasi_gr::where('id', $idestimasi)->first();
            // $validated = $request->validated();
            // if ($validated) {
            $nowo = 'GW' . date('Y') . date('m') . sprintf("%05s", intval(substr('00000', -5)) + 1);
            $rec = Wo_gr::where('nowo', $nowo)->first();
            if (isset($rec)) {
                $noakhir = Wo_gr::orderBy('nowo', 'desc')->max('nowo');
                $nowo = 'GW' . date('Y') . date('m') . sprintf("%05s", intval(substr($noakhir, -5)) + 1);
            }
            $klaim = $row_estimasi_gr->klaim;
            $internal = $row_estimasi_gr->internal;
            $inventaris = $row_estimasi_gr->inventaris;
            $campaign = $row_estimasi_gr->campaign;
            $booking = $row_estimasi_gr->booking;
            $lain_lain = $row_estimasi_gr->lain_lain;
            $wo_gr->fill([
                'nowo' => $nowo,
                'noestimasi' => $row_estimasi_gr->noestimasi,
                'tglestimasi' => isset($row_estimasi_gr->tanggal) ? $row_estimasi_gr->tanggal : '',
                'tglwo' => date('Y-m-d H:i:s'),
                'nopolisi' => isset($row_estimasi_gr->nopolisi) ? $row_estimasi_gr->nopolisi : '',
                'norangka' => isset($row_estimasi_gr->norangka) ? $row_estimasi_gr->norangka : '',
                'kdpemilik' => isset($row_estimasi_gr->kdpemilik) ? $row_estimasi_gr->kdpemilik : '',
                'nmpemilik' => isset($row_estimasi_gr->nmpemilik) ? $row_estimasi_gr->nmpemilik : '',
                'kdsa' => isset($row_estimasi_gr->kdsa) ? $row_estimasi_gr->kdsa : '',
                'kdservice' => isset($row_estimasi_gr->kdservice) ? $row_estimasi_gr->kdservice : '',
                'nmservice' => isset($row_estimasi_gr->nmservice) ? $row_estimasi_gr->nmservice : '',
                'km' => isset($row_estimasi_gr->km) ? $row_estimasi_gr->km : '',
                'kdpaket' => isset($row_estimasi_gr->kdpaket) ? $row_estimasi_gr->kdpaket : '',
                'aktifitas' => isset($row_estimasi_gr->aktifitas) ? $row_estimasi_gr->aktifitas : '',
                'fasilitas' => isset($row_estimasi_gr->fasilitas) ? $row_estimasi_gr->fasilitas : '',
                'status_tunggu' => isset($row_estimasi_gr->status_tunggu) ? $row_estimasi_gr->status_tunggu : '',
                'int_reminder' => isset($row_estimasi_gr->int_reminder) ? $row_estimasi_gr->int_reminder : '',
                'via' => isset($row_estimasi_gr->via) ? $row_estimasi_gr->via : '',
                'kdsa' => isset($row_estimasi_gr->kdsa) ? $row_estimasi_gr->kdsa : '',
                'nmsa' => isset($row_estimasi_gr->nmsa) ? $row_estimasi_gr->nmsa : '',
                'keluhan' => isset($row_estimasi_gr->keluhan) ? $row_estimasi_gr->keluhan : '',
                'no_polis' => isset($row_estimasi_gr->no_polis) ? $row_estimasi_gr->no_polis : '',
                'nama_polis' => isset($row_estimasi_gr->nama_polis) ? $row_estimasi_gr->nama_polis : '',
                'tgl_akhir_polis' => isset($row_estimasi_gr->tgl_akhir_polis) ? $row_estimasi_gr->tgl_akhir_polis : '',
                'kdasuransi' => isset($row_estimasi_gr->kdasuransi) ? $row_estimasi_gr->kdasuransi : '',
                'nmasuransi' => isset($row_estimasi_gr->nmasuransi) ? $row_estimasi_gr->nmasuransi : '',
                'alamat_asuransi' => isset($row_estimasi_gr->alamat_asuransi) ? $row_estimasi_gr->alamat_asuransi : '',
                'klaim' => $klaim,
                'internal' => $internal,
                'inventaris' => $inventaris,
                'campaign' => $campaign,
                'booking' => $booking,
                'lain_lain' => $lain_lain,
                'surveyor' => isset($row_estimasi_gr->surveyor) ? $row_estimasi_gr->surveyor : '',
                'npwp' => isset($row_estimasi_gr->npwp) ? $row_estimasi_gr->npwp : '',
                'contact_person' => isset($row_estimasi_gr->contact_person) ? $row_estimasi_gr->contact_person : '',
                'no_contact_person' => isset($row_estimasi_gr->no_contact_person) ? $row_estimasi_gr->no_contact_person : '',
                'own_risk' => isset($row_estimasi_gr->own_risk) ? $row_estimasi_gr->own_risk : '',
                'total_jasa' => $row_estimasi_gr->total_jasa,
                'total_part' => $row_estimasi_gr->total_part,
                'total_bahan' => $row_estimasi_gr->total_bahan,
                'total_opl' => $row_estimasi_gr->total_opl,
                'total' => $row_estimasi_gr->total,
                'dpp' => $row_estimasi_gr->dpp,
                'pr_ppn' => $row_estimasi_gr->pr_ppn,
                'ppn' => $row_estimasi_gr->ppn,
                'total_wo' => $row_estimasi_gr->total_estimasi,
                'user' => 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s'),
            ]);
            // $wo_gr->save($validated);
            $wo_gr->save();
            Estimasi_gr::where('noestimasi', $row_estimasi_gr->noestimasi)->update(['nowo' => $nowo]);
            $row_estimasi_grd = Estimasi_grd::where('noestimasi', $row_estimasi_gr->noestimasi)->get();
            Wo_grd::where('noestimasi', $row_estimasi_gr->noestimasi)->delete();
            foreach ($row_estimasi_grd as $row) {
                Wo_grd::insert([
                    'nowo' => $nowo, 'kode' => $row->kode, 'nama' => $row->nama, 'kerusakan' => $row->kerusakan, 'jenis' => $row->jenis, 'qty' => $row->qty,
                    'harga' => $row->harga, 'pr_discount' => $row->pr_discount, 'subtotal' => $row->subtotal
                ]);
            }
            $msg = [
                'sukses' => 'Data berhasil di simpan', //view('estimasi_gr.tabel_paket')
            ];
            // } else {
            //     $msg = [
            //         'sukses' => 'Gagal di simpan', //view('estimasi_gr.tabel_paket')
            //     ];
            // }
            echo json_encode($msg);
            // return redirect()->back()->with('message', 'Berhasil di simpan');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
}
