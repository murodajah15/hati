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
use App\Models\Faktur_gr;
use App\Models\Faktur_grd;

// //return type View
// use Illuminate\View\View;

class Wo_grController extends Controller
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
            'submenu' => 'wo_gr',
            'submenu1' => 'general_repair',
            'title' => 'WO General Repair',
            'userdtlmenu' => $userdtl,
            'userdtl' => Userdtl::where('cmodule', 'WO General Repair')->where('username', $username)->first(),
        ];
        return view('wo_gr.index')->with($data);
    }

    public function vwo_gr(Request $request)
    {
        if ($request->Ajax()) {
            $username = session('username');
            $tbmobil = Tbmobil::where('id', $request->id)->first();
            $nopolisi = $tbmobil->nopolisi;
            $data = [
                'menu' => 'transaksi',
                'submenu' => 'wo_gr',
                'submenu1' => 'general_repair',
                'title' => 'List WO General Repair',
                'userdtl' => Userdtl::where('cmodule', 'WO General Repair')->where('username', $username)->first(),
                // 'estimasi_gr' => Wo_gr::all(),
            ];
            // var_dump($data);
            return response()->json([
                'body' => view('wo_gr.modaltblwo', [
                    'wo_gr' => Wo_gr::where('nopolisi', $nopolisi)->get(), //Wo_gr::first(),
                    'tbasuransi' => Tbasuransi::orderBy('nama')->get(),
                    'tbmobil' => $tbmobil, //Tbmobil::findOrFail($id),
                    'userdtl' => Userdtl::where('cmodule', 'WO General Repair')->where('username', $username)->first(),
                    // 'action' => route('estimasi_gr.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,

            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function vwo_grajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $data = Wo_gr::select('*'); //->orderBy('kode', 'asc');
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

    public function tbmobil_grajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $data = Tbmobil::select('*'); //->orderBy('kode', 'asc');
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
            // return view('wo_gr');
        }
    }

    public function wo_grajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $nopolisi = $_GET['nopolisi'];
            $data = Wo_gr::where('nopolisi', $nopolisi); //->orderBy('kode', 'asc');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('kode1', function ($row) {
                    $btn = $row['kode']; //'<a href="#"' . 'onclick=detail(' . $id . ')>' .  $row['kode'] . '</a>';
                    return $btn;
                })
                ->rawColumns(['kode1'])
                ->make(true);
            // return view('wo_gr');
        }
    }

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
                // 'estimasi_gr' => Wo_gr::all(),
            ];
            // var_dump($data);
            return response()->json([
                'body' => view('estimasi_gr.modaltambahestimasi', [
                    'estimasi_gr' => new estimasi_gr(), //Wo_gr::first(),
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

    public function store(Wo_grRequest $request, wo_gr $wo_gr)
    {
        if ($request->Ajax()) {
            $validated = $request->validated();
            if ($validated) {
                $nowo = 'GE' . date('Y') . date('m') . sprintf("%05s", intval(substr('00000', -5)) + 1);
                $rec = Wo_gr::where('nowo', $nowo)->first();
                if (isset($rec)) {
                    $noakhir = Wo_gr::orderBy('nowo', 'desc')->max('nowo');
                    $nowo = 'GE' . date('Y') . date('m') . sprintf("%05s", intval(substr($noakhir, -5)) + 1);
                }
                // dd($nowo);
                $aktif = $request->aktif == 'on' ? 'Y' : 'N';
                $klaim = $request->klaim == 'on' ? '1' : '0';
                $internal = $request->internal == 'on' ? '1' : '0';
                $inventaris = $request->inventaris == 'on' ? '1' : '0';
                $campaign = $request->campaign == 'on' ? '1' : '0';
                $booking = $request->booking == 'on' ? '1' : '0';
                $lain_lain = $request->lain_lain == 'on' ? '1' : '0';
                $wo_gr->fill([
                    'nowo' => $nowo,
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
                    'saran' => isset($request->saran) ? $request->saran : '',
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
                $wo_gr->save($validated);
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
            $rec = Wo_gr::where('id', $request->id)->first();
            $nopolisi = $rec->nopolisi;
            $username = session('username');
            // dd($request->jenis);
            $data = [
                'menu' => 'transaksi',
                'submenu' => 'wo_gr',
                'submenu1' => 'general_repair',
                'title' => 'Detail WO General Repair',
                'wo_gr' => Wo_gr::findOrFail($id),
                'userdtl' => Userdtl::where('cmodule', 'Estimasi WO General Repair')->where('username', $username)->first(),
            ];
            // return view('wo_gr.modaldetail')->with($data);
            return response()->json([
                'body' => view('wo_gr.modaltambahwo', [
                    'wo_gr' => Wo_gr::findOrFail($id),
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

    public function edit(wo_gr $wo_gr, Request $request)
    {
        if ($request->Ajax()) {
            $rec = Wo_gr::where('id', $request->id)->first();
            $nopolisi = $rec->nopolisi;
            // dd($nopolisi);
            $data = [
                'menu' => 'transaksi',
                'submenu' => 'wo_gr',
                'submenu1' => 'general_repair',
                'title' => 'Edit Data WO General Repair',
            ];
            return response()->json([
                'body' => view('wo_gr.modaltambahwo', [
                    'wo_gr' => $wo_gr,
                    'tbmobil' => Tbmobil::where('nopolisi', $nopolisi)->first(),
                    'tbasuransi' => Tbasuransi::orderBy('nama')->get(),
                    'action' => route('wo_gr.update', $wo_gr->id),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function update(Wo_grRequest $request, wo_gr $wo_gr)
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

                $wo_gr->fill([
                    'nowo' => isset($request->nowolama) ? $request->nowolama : '',
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
                    'saran' => isset($request->saran) ? $request->saran : '',
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
                    'user' => 'Update-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $wo_gr->save($validated);
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
    //             $update = $Wo_gr::where('id', $id)->update([
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
                    'estimasi_gr' => Wo_gr::where('nopolisi', $nopolisi)->get(),
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
    //         Wo_gr::where('id', $request->id)->delete();
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
            Wo_gr::where('id', $request->id)->update(['batal' => 1]);
            return response()->json([
                'sukses' => true,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function wo_grproses(Request $request)
    {
        if ($request->Ajax()) {
            Wo_gr::where('id', $request->id)->update(['close' => 1]);
            $data = Wo_gr::where('id', $request->id)->first();
            //Create History
            $tanggal = date('Y-m-d');
            $datetime = date('Y-m-d H:i:s');
            $dokumen = $data->nowo;
            $form = 'WO General Repair';
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

    public function wo_grunproses(Request $request)
    {
        if ($request->Ajax()) {
            $username = session('username');
            $id = $request->id;
            $wo_gr = Wo_gr::where('id', $id)->first();
            if ($wo_gr->nofaktur == '') {
                $data = [
                    'menu' => 'transaksi',
                    'submenu' => 'wo_gr',
                    'submenu1' => 'general_repair',
                    'title' => 'Unproses wo WO General Repair',
                    'userdtl' => Userdtl::where('cmodule', 'wo WO General Repair')->where('username', $username)->first(),
                ];
                // return view('wo_gr.modaldetail')->with($data);
                return response()->json([
                    'body' => view('wo_gr.modalbatalproses', [
                        'wo_gr' => $wo_gr,
                        'action' => 'wo_grunproses_simpan',
                        'vdata' => $data,
                    ])->render(),
                    'data' => $data,
                ]);
            } else {
                $msg = [
                    'sukses' => false,
                ];
                echo json_encode($msg);
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
    public function wo_grunproses_simpan(Request $request)
    {
        if ($request->Ajax()) {
            Wo_gr::where('id', $request->id)->update([
                'close' => 0, 'user' => 'Unproses-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                'ket_proses' => $request->catatan . ' (' . date('d-m-Y h:i:s') . '}'
            ]);
            //Create History
            $tanggal = date('Y-m-d');
            $datetime = date('Y-m-d H:i:s');
            $dokumen = $request->dokumen;
            $form = 'WO General Repair';
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

    public function wo_grcancel(Request $request)
    {
        if ($request->Ajax()) {
            Wo_gr::where('id', $request->id)->update(['batal' => 1]);
            $data = Wo_gr::where('id', $request->id)->first();
            //Create History
            $tanggal = date('Y-m-d');
            $datetime = date('Y-m-d H:i:s');
            $dokumen = $data->nowo;
            $form = 'WO General Repair';
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

    public function wo_grambil(Request $request)
    {
        if ($request->Ajax()) {
            Wo_gr::where('id', $request->id)->update(['batal' => 0]);
            $data = Wo_gr::where('id', $request->id)->first();
            //Create History
            $tanggal = date('Y-m-d');
            $datetime = date('Y-m-d H:i:s');
            $dokumen = $data->nowo;
            $form = 'WO General Repair';
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

    public function detailwo_gr(wo_gr $wo_gr, Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'transaksi',
                'submenu' => 'wo_gr',
                'submenu1' => 'general_repair',
                'title' => 'Detail WO General Repair',
            ];
            $id = $request->id;
            $wo_gr = Wo_gr::where('id', $id)->first();
            $wo_grd = Wo_grd::where('nowo', $wo_gr->nowo)->get();
            return response()->json([
                'body' => view('wo_gr.modaldetailwo', [
                    'submenu' => 'wo_gr',
                    'tbmobil' => Tbmobil::where('nopolisi', $wo_gr->nopolisi)->first(),
                    'wo_gr' => $wo_gr,
                    'wo_grd' => $wo_grd,
                    'action' => '', //route('estimasi_grd.store', $estimasi_gr->id),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function cetak_wo_gr(Request $request)
    {
        $row_wo_gr = Wo_gr::where('id', $request->id)->first();
        $nowo = $row_wo_gr->nowo;
        $kdpemilik = $row_wo_gr->kdpemilik;
        $nopolisi = $row_wo_gr->nopolisi;
        $row_tbmobil = Tbmobil::join('tbtipe', 'tbmobil.kdtipe', '=', 'tbtipe.kode')->where('tbmobil.nopolisi', $nopolisi)
            ->select('tbmobil.*', 'tbtipe.nama as nmtipe')
            ->first();
        $row_tbcustomer = Tbcustomer::where('kode', $kdpemilik)->first();
        $data = [
            'saplikasi' => Saplikasi::where('aktif', 'Y')->first(),
            'wo_gr' => $row_wo_gr,
            'tbmobil' => $row_tbmobil,
            'tbcustomer' => $row_tbcustomer,
            'wo_grd_jasa' => Wo_gr::join('wo_grd', 'wo_grd.nowo', '=', 'wo_gr.nowo')
                ->join('tbcustomer', 'tbcustomer.kode', '=', 'wo_gr.kdpemilik')
                ->select('wo_gr.*', 'wo_grd.*')
                ->where('wo_grd.nowo', $nowo)->where('wo_grd.jenis', 'JASA')->orwhere('wo_grd.jenis', 'OPL')->get(),
            'wo_grd_part' => Wo_gr::join('wo_grd', 'wo_grd.nowo', '=', 'wo_gr.nowo')
                ->join('tbcustomer', 'tbcustomer.kode', '=', 'wo_gr.kdpemilik')
                ->join('tbmobil', 'tbmobil.nopolisi', '=', 'wo_gr.nopolisi')
                ->join('tbbarang', 'tbbarang.kode', '=', 'wo_grd.kode')
                ->join('tbsatuan', 'tbsatuan.kode', '=', 'tbbarang.kdsatuan')
                ->select('wo_gr.*', 'wo_grd.*', 'tbsatuan.kode as kdsatuan', 'tbsatuan.nama as nmsatuan')
                ->where('wo_grd.nowo', $nowo)->where('wo_grd.jenis', 'PART')->get(),
            'wo_grd_bahan' => Wo_gr::join('wo_grd', 'wo_grd.nowo', '=', 'wo_gr.nowo')
                ->join('tbcustomer', 'tbcustomer.kode', '=', 'wo_gr.kdpemilik')
                ->join('tbmobil', 'tbmobil.nopolisi', '=', 'wo_gr.nopolisi')
                ->join('tbbahan', 'tbbahan.kode', '=', 'wo_grd.kode')
                ->join('tbsatuan', 'tbsatuan.kode', '=', 'tbbahan.kdsatuan')
                ->select('wo_gr.*', 'wo_grd.*', 'tbsatuan.kode as kdsatuan', 'tbsatuan.nama as nmsatuan')
                ->where('wo_grd.nowo', $nowo)->where('wo_grd.jenis', 'BAHAN')->get(),
        ];
        // return view('jual.cetak', $data);

        $rowd = estimasi_grd::where('nowo', $nowo)->get();
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
        $wo_gr = Wo_gr::where('id', $request->id)->first();
        $tanggal = date('Y-m-d');
        $datetime = date('Y-m-d H:i:s');
        $dokumen = $wo_gr->nowo;
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
        $mpdf->WriteHTML(view('wo_gr.cetak', $data));
        $namafile = $nowo . ' - ' . date('dmY H:i:s') . '.pdf';
        //return the PDF for download
        // return $mpdf->Output($request->get('name') . $namafile, Destination::DOWNLOAD);
        $mpdf->Output($namafile, 'I');
    }

    public function buatfaktur_gr(Request $request, faktur_gr $faktur_gr)
    {
        if ($request->Ajax()) {
            $idwo = $request->idwo;
            $row_wo_gr = Wo_gr::where('id', $idwo)->first();
            // $validated = $request->validated();
            // if ($validated) {
            $nofaktur = 'BF' . date('Y') . date('m') . sprintf("%05s", intval(substr('00000', -5)) + 1);
            $rec = Faktur_gr::where('nofaktur', $nofaktur)->first();
            if (isset($rec)) {
                $noakhir = Faktur_gr::orderBy('nofaktur', 'desc')->max('nofaktur');
                $nofaktur = 'BF' . date('Y') . date('m') . sprintf("%05s", intval(substr($noakhir, -5)) + 1);
            }
            $klaim = $row_wo_gr->klaim;
            $internal = $row_wo_gr->internal;
            $inventaris = $row_wo_gr->inventaris;
            $campaign = $row_wo_gr->campaign;
            $booking = $row_wo_gr->booking;
            $lain_lain = $row_wo_gr->lain_lain;
            $faktur_gr->fill([
                'nofaktur' => $nofaktur,
                'nowo' => $row_wo_gr->nowo,
                'tanggal' => isset($row_wo_gr->tanggal) ? $row_wo_gr->tanggal : '',
                'tglwo' => date('Y-m-d H:i:s'),
                'nopolisi' => isset($row_wo_gr->nopolisi) ? $row_wo_gr->nopolisi : '',
                'norangka' => isset($row_wo_gr->norangka) ? $row_wo_gr->norangka : '',
                'kdpemilik' => isset($row_wo_gr->kdpemilik) ? $row_wo_gr->kdpemilik : '',
                'nmpemilik' => isset($row_wo_gr->nmpemilik) ? $row_wo_gr->nmpemilik : '',
                'kdsa' => isset($row_wo_gr->kdsa) ? $row_wo_gr->kdsa : '',
                'kdservice' => isset($row_wo_gr->kdservice) ? $row_wo_gr->kdservice : '',
                'nmservice' => isset($row_wo_gr->nmservice) ? $row_wo_gr->nmservice : '',
                'km' => isset($row_wo_gr->km) ? $row_wo_gr->km : '',
                'kdpaket' => isset($row_wo_gr->kdpaket) ? $row_wo_gr->kdpaket : '',
                'aktifitas' => isset($row_wo_gr->aktifitas) ? $row_wo_gr->aktifitas : '',
                'fasilitas' => isset($row_wo_gr->fasilitas) ? $row_wo_gr->fasilitas : '',
                'status_tunggu' => isset($row_wo_gr->status_tunggu) ? $row_wo_gr->status_tunggu : '',
                'int_reminder' => isset($row_wo_gr->int_reminder) ? $row_wo_gr->int_reminder : '',
                'via' => isset($row_wo_gr->via) ? $row_wo_gr->via : '',
                'kdsa' => isset($row_wo_gr->kdsa) ? $row_wo_gr->kdsa : '',
                'nmsa' => isset($row_wo_gr->nmsa) ? $row_wo_gr->nmsa : '',
                'keluhan' => isset($row_wo_gr->keluhan) ? $row_wo_gr->keluhan : '',
                'no_polis' => isset($row_wo_gr->no_polis) ? $row_wo_gr->no_polis : '',
                'nama_polis' => isset($row_wo_gr->nama_polis) ? $row_wo_gr->nama_polis : '',
                'tgl_akhir_polis' => isset($row_wo_gr->tgl_akhir_polis) ? $row_wo_gr->tgl_akhir_polis : '',
                'kdasuransi' => isset($row_wo_gr->kdasuransi) ? $row_wo_gr->kdasuransi : '',
                'nmasuransi' => isset($row_wo_gr->nmasuransi) ? $row_wo_gr->nmasuransi : '',
                'alamat_asuransi' => isset($row_wo_gr->alamat_asuransi) ? $row_wo_gr->alamat_asuransi : '',
                'klaim' => $klaim,
                'internal' => $internal,
                'inventaris' => $inventaris,
                'campaign' => $campaign,
                'booking' => $booking,
                'lain_lain' => $lain_lain,
                'surveyor' => isset($row_wo_gr->surveyor) ? $row_wo_gr->surveyor : '',
                'npwp' => isset($row_wo_gr->npwp) ? $row_wo_gr->npwp : '',
                'contact_person' => isset($row_wo_gr->contact_person) ? $row_wo_gr->contact_person : '',
                'no_contact_person' => isset($row_wo_gr->no_contact_person) ? $row_wo_gr->no_contact_person : '',
                'own_risk' => isset($row_wo_gr->own_risk) ? $row_wo_gr->own_risk : '',
                'total_jasa' => $row_wo_gr->total_jasa,
                'total_part' => $row_wo_gr->total_part,
                'total_bahan' => $row_wo_gr->total_bahan,
                'total_opl' => $row_wo_gr->total_opl,
                'total' => $row_wo_gr->total,
                'dpp' => $row_wo_gr->dpp,
                'pr_ppn' => $row_wo_gr->pr_ppn,
                'ppn' => $row_wo_gr->ppn,
                'total_wo' => $row_wo_gr->total_wo,
                'user' => 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s'),
            ]);
            // $wo_gr->save($validated);
            $faktur_gr->save();
            Wo_gr::where('nofaktur', $row_wo_gr->nofaktur)->update(['nofaktur' => $nofaktur]);
            $row_wo_grd = Wo_grd::where('nowo', $row_wo_gr->nowo)->get();
            Faktur_grd::where('nowo', $row_wo_gr->nowo)->delete();
            foreach ($row_wo_grd as $row) {
                Faktur_grd::insert([
                    'nofaktur' => $row->nofaktur, 'kode' => $row->kode, 'nama' => $row->nama, 'kerusakan' => $row->kerusakan, 'jenis' => $row->jenis, 'qty' => $row->qty,
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
