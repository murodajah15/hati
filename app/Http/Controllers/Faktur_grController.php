<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use App\Http\Requests\Faktur_grRequest;
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

class Faktur_grController extends Controller
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
            'submenu' => 'faktur_gr',
            'submenu1' => 'general_repair',
            'title' => 'Faktur General Repair',
            'userdtlmenu' => $userdtl,
            'userdtl' => Userdtl::where('cmodule', 'Faktur General Repair')->where('username', $username)->first(),
        ];
        return view('faktur_gr.index')->with($data);
    }

    public function faktur_grajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $data = Faktur_gr::select('*'); //->orderBy('kode', 'asc');
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

    public function create(Request $request)
    {
        if ($request->Ajax()) {
            $faktur_gr = Faktur_gr::join('tbmobil', 'tbmobil.nopolisi', '=', 'faktur_gr.nopolisi')
                ->select('faktur_gr.*', 'tbmobil.*')->where('faktur_gr.close', 1)->get();
            $faktur_gr = Faktur_gr::where('id', $request->id)->first();
            $data = [
                'menu' => 'transaksi',
                'submenu' => 'faktur_gr',
                'submenu1' => 'general_repair',
                'title' => 'Tambah Data Task List General Repair',
                // 'faktur_gr' => Faktur_gr::all(),
            ];
            // var_dump($data);
            return response()->json([
                'body' => view('faktur_gr.modaltambahmaster', [
                    'faktur_gr' => $faktur_gr, //Faktur_gr::first(),
                    'faktur_gr' => new faktur_gr(), //Faktur_gr::first(),
                    'tbasuransi' => Tbasuransi::orderBy('nama')->get(),
                    'action' => route('faktur_gr.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,

            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function store(Faktur_grRequest $request, faktur_gr $faktur_gr)
    {
        if ($request->Ajax()) {
            $validated = $request->validated();
            if ($validated) {
                $nofaktur = 'FG' . date('Y') . date('m') . sprintf("%05s", intval(substr('00000', -5)) + 1);
                $rec = Faktur_gr::where('nofaktur', $nofaktur)->first();
                if (isset($rec)) {
                    $noakhir = Faktur_gr::orderBy('nofaktur', 'desc')->max('nofaktur');
                    $nofaktur = 'FG' . date('Y') . date('m') . sprintf("%05s", intval(substr($noakhir, -5)) + 1);
                }
                // dd($nofaktur);
                $klaim = isset($request->klaim) ? '1' : '0';
                $internal = isset($request->internal) ? '1' : '0';
                $inventaris = isset($request->inventaris) ? '1' : '0';
                $campaign = isset($request->campaign)  ? '1' : '0';
                $booking = isset($request->booking)  ? '1' : '0';
                $lain_lain = isset($request->lain_lain)  ? '1' : '0';
                $row_wo_gr = Faktur_gr::where('nowo', $request->nowo)->first();
                $dpp = $row_wo_gr->dpp;
                $ppn = $dpp * ($request->pr_ppn / 100);
                $total_wo = $dpp + $ppn;
                $total_faktur = $total_wo;
                $faktur_gr->fill([
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
                    'total_jasa' => $row_wo_gr->total_jasa,
                    'total_part' => $row_wo_gr->total_part,
                    'total_bahan' => $row_wo_gr->total_bahan,
                    'total_opl' => $row_wo_gr->total_opl,
                    'total' => $row_wo_gr->total,
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
                $faktur_gr->save($validated);
                Faktur_gr::where('nowo', $request->nowo)->update(['nofaktur' => $nofaktur]);
                Faktur_grd::where('nofaktur', $nofaktur)->delete();
                $row_wo_grd = Wo_grd::where('nowo', $request->nowo)->get();
                foreach ($row_wo_grd as $row) {
                    Faktur_grd::insert([
                        'nofaktur' => $nofaktur, 'kode' => $row->kode, 'nama' => $row->nama, 'kerusakan' => $row->kerusakan, 'jenis' => $row->jenis, 'qty' => $row->qty,
                        'harga' => $row->harga, 'pr_discount' => $row->pr_discount, 'subtotal' => $row->subtotal
                    ]);
                }
                $msg = [
                    'sukses' => 'Data berhasil di simpan', //view('faktur_gr.tabel_paket')
                ];
            } else {
                $msg = [
                    'sukses' => 'Gagal di simpan', //view('faktur_gr.tabel_paket')
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
            $rec = Faktur_gr::where('id', $request->id)->first();
            $nopolisi = $rec->nopolisi;
            $username = session('username');
            // dd($request->jenis);
            $data = [
                'menu' => 'transaksi',
                'submenu' => 'faktur_gr',
                'submenu1' => 'general_repair',
                'title' => 'Detail Faktur General Repair',
                'faktur_gr' => Faktur_gr::findOrFail($id),
                'userdtl' => Userdtl::where('cmodule', 'Faktur General Repair')->where('username', $username)->first(),
            ];
            // return view('faktur_gr.modaldetail')->with($data);
            return response()->json([
                'body' => view('faktur_gr.modaltambahmaster', [
                    'faktur_gr' => Faktur_gr::findOrFail($id),
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

    public function edit(faktur_gr $faktur_gr, Request $request)
    {
        if ($request->Ajax()) {
            $rec = Faktur_gr::where('id', $request->id)->first();
            $nopolisi = $rec->nopolisi;
            // dd($nopolisi);
            $data = [
                'menu' => 'transaksi',
                'submenu' => 'faktur_gr',
                'submenu1' => 'general_repair',
                'title' => 'Edit Data Faktur General Repair',
            ];
            return response()->json([
                'body' => view('faktur_gr.modaltambahmaster', [
                    'faktur_gr' => $faktur_gr,
                    'tbmobil' => Tbmobil::where('nopolisi', $nopolisi)->first(),
                    'tbasuransi' => Tbasuransi::orderBy('nama')->get(),
                    'action' => route('faktur_gr.update', $faktur_gr->id),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function update(Faktur_grRequest $request, faktur_gr $faktur_gr)
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
                $row_faktur_gr = Faktur_gr::where('id', $request->id)->first();
                $dpp = $row_faktur_gr->dpp;
                $ppn = $dpp * ($request->pr_ppn / 100);
                $total_wo = $dpp + $ppn;
                $total_faktur = $total_wo;
                $faktur_gr->fill([
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
                $faktur_gr->save($validated);
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

    // // public function show(string $id)
    // public function vestimasi_gr(Request $request)
    // {
    //     if ($request->Ajax()) {
    //         $id = $_GET['id'];
    //         $tbmobil = Tbmobil::where('id', $id)->first();
    //         $nopolisi = $tbmobil->nopolisi;
    //         $username = session('username');
    //         $data = [
    //             'menu' => 'transaksi',
    //             'submenu' => 'estimasi_gr',
    //             'submenu1' => 'general_repair',
    //             'title' => 'Estimasi WO General Repair',
    //             'userdtl' => Userdtl::where('cmodule', 'Estimasi WO General Repair')->where('username', $username)->first(),
    //         ];
    //         // return view('estimasi_gr.modaldetail')->with($data);
    //         return response()->json([
    //             'body' => view('estimasi_gr.modaltambah', [
    //                 'tbmobil' => $tbmobil, //Tbmobil::findOrFail($id),
    //                 'tbmerek' => Tbmerek::orderBy('nama')->get(),
    //                 'tbmodel' => Tbmodel::orderBy('nama')->get(),
    //                 'tbtipe' => Tbtipe::orderBy('nama')->get(),
    //                 'tbwarna' => Tbwarna::orderBy('nama')->get(),
    //                 'tbjenis' => Tbjenis::orderBy('nama')->get(),
    //                 'estimasi_gr' => Faktur_gr::where('nopolisi', $nopolisi)->get(),
    //                 'action' => '',
    //                 'vdata' => $data,
    //             ])->render(),
    //             'data' => $data,
    //         ]);
    //     } else {
    //         exit('Maaf tidak dapat diproses');
    //     }
    // }

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
    //         Faktur_gr::where('id', $request->id)->delete();
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
            Faktur_gr::where('id', $request->id)->update(['batal' => 1]);
            return response()->json([
                'sukses' => true,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function faktur_grproses(Request $request)
    {
        if ($request->Ajax()) {
            $data = Faktur_gr::where('id', $request->id)->first();
            $userclose = session('username') . ', ' . date('d-m-Y h:i:s');
            Faktur_gr::where('id', $request->id)->update(['close' => 1, 'sudahbayar' => $data->total_wo, 'user_close' => $userclose]);
            Faktur_gr::where('nowo', $data->nowo)->update(['nofaktur' => $data->nofaktur]);
            //Create History
            $tanggal = date('Y-m-d');
            $datetime = date('Y-m-d H:i:s');
            $dokumen = $data->nofaktur;
            $form = 'Faktur General Repair';
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

    public function faktur_grunproses(Request $request)
    {
        if ($request->Ajax()) {
            $username = session('username');
            $id = $request->id;
            $faktur_gr = Faktur_gr::where('id', $id)->first();
            $data = [
                'menu' => 'transaksi',
                'submenu' => 'faktur_gr',
                'submenu1' => 'general_repair',
                'title' => 'Unproses Fktur General Repair',
                'userdtl' => Userdtl::where('cmodule', 'Faktur General Repair')->where('username', $username)->first(),
            ];
            // return view('faktur_gr.modaldetail')->with($data);
            return response()->json([
                'body' => view('faktur_gr.modalbatalproses', [
                    'faktur_gr' => $faktur_gr,
                    'action' => 'faktur_grunproses_simpan',
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
    public function faktur_grunproses_simpan(Request $request)
    {
        if ($request->Ajax()) {
            Faktur_gr::where('id', $request->id)->update([
                'close' => 0, 'user' => 'Unproses-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                'ket_proses' => $request->catatan . ' (' . date('d-m-Y h:i:s') . '}'
            ]);
            // $data = Faktur_gr::where('id', $request->id)->first();
            // Faktur_gr::where('nowo', $data->nowo)->update(['nofaktur' => '']);
            //Create History
            $tanggal = date('Y-m-d');
            $datetime = date('Y-m-d H:i:s');
            $dokumen = $request->dokumen;
            $form = 'Faktur General Repair';
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


    public function faktur_grcancel(Request $request)
    {
        if ($request->Ajax()) {
            $ket_batal = "";
            $userbatal = session('username') . ', ' . date('d-m-Y h:i:s');
            Faktur_gr::where('id', $request->id)->update(['batal' => 1, 'ket_batal' => $ket_batal, 'user_batal' => $userbatal, 'tgl_batal' => date('Y-m-d')]);
            $data = Faktur_gr::where('id', $request->id)->first();
            Faktur_gr::where('nowo', $data->nowo)->update(['nofaktur' => '']);
            //Create History
            $tanggal = date('Y-m-d');
            $datetime = date('Y-m-d H:i:s');
            $dokumen = $data->nofaktur;
            $form = 'Faktur General Repair';
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

    public function faktur_grambil(Request $request)
    {
        if ($request->Ajax()) {
            $datafaktur = Faktur_gr::where('id', $request->id)->first();
            $nofaktur = $datafaktur->nofaktur;
            $nowo = $datafaktur->nowo;
            $datawo = Faktur_gr::where('nowo', $nowo)->first();
            if ($datawo->nofaktur != $nofaktur) {
                return response()->json([
                    'sukses' => false,
                ]);
            } else {
                Faktur_gr::where('nowo', $nowo)->update(['nofaktur' => $nofaktur]);
                Faktur_gr::where('id', $request->id)->update(['batal' => 0]);
                $datafaktur = Faktur_gr::where('id', $request->id)->first();
                //Create History
                $tanggal = date('Y-m-d');
                $datetime = date('Y-m-d H:i:s');
                $dokumen = $datafaktur->nofaktur;
                $form = 'Faktur General Repair';
                $status = 'Ambil';
                $catatan = isset($request->catatan) ? $request->catatan : '';
                $username = session('username');
                Hisuser::insert(['tanggal' => $tanggal, 'dokumen' => $dokumen, 'form' => $form, 'status' => $status, 'user' => $username, 'catatan' => $catatan, 'datetime' => $datetime]);
                return response()->json([
                    'sukses' => true,
                ]);
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function detailwo_gr(wo_gr $faktur_gr, Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'transaksi',
                'submenu' => 'faktur_gr',
                'submenu1' => 'general_repair',
                'title' => 'Detail WO General Repair',
            ];
            $id = $request->id;
            $faktur_gr = Faktur_gr::where('id', $id)->first();
            $faktur_grd = Wo_grd::where('nowo', $faktur_gr->nowo)->get();
            return response()->json([
                'body' => view('faktur_gr.modaldetailwo', [
                    'submenu' => 'faktur_gr',
                    'tbmobil' => Tbmobil::where('nopolisi', $faktur_gr->nopolisi)->first(),
                    'faktur_gr' => $faktur_gr,
                    'faktur_grd' => $faktur_grd,
                    'action' => '', //route('estimasi_grd.store', $estimasi_gr->id),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function cetak_faktur_gr(Request $request)
    {
        $row_faktur_gr = Faktur_gr::join('tbsa', 'faktur_gr.kdsa', '=', 'tbsa.kode')
            ->where('faktur_gr.id', $request->id)
            ->select('faktur_gr.*', 'tbsa.nama as nmsa')->first();
        $nofaktur = $row_faktur_gr->nofaktur;
        $kdpemilik = $row_faktur_gr->kdpemilik;
        $nopolisi = $row_faktur_gr->nopolisi;
        $row_tbmobil = Tbmobil::join('tbtipe', 'tbmobil.kdtipe', '=', 'tbtipe.kode')->join('tbwarna', 'tbmobil.kdwarna', '=', 'tbwarna.kode')
            ->where('tbmobil.nopolisi', $nopolisi)
            ->select('tbmobil.*', 'tbtipe.nama as nmtipe', 'tbwarna.nama as nmwarna')
            ->first();
        $row_tbcustomer = Tbcustomer::where('kode', $kdpemilik)->first();
        $data = [
            'saplikasi' => Saplikasi::where('aktif', 'Y')->first(),
            'faktur_gr' => $row_faktur_gr,
            'tbmobil' => $row_tbmobil,
            'tbcustomer' => $row_tbcustomer,
            'faktur_grd_jasa' => Faktur_gr::join('faktur_grd', 'faktur_grd.nofaktur', '=', 'faktur_gr.nofaktur')
                ->join('tbcustomer', 'tbcustomer.kode', '=', 'faktur_gr.kdpemilik')
                ->select('faktur_gr.*', 'faktur_grd.*')
                ->where('faktur_grd.nofaktur', $nofaktur)->where('faktur_grd.jenis', 'JASA')->orwhere('faktur_grd.jenis', 'OPL')->get(),
            'faktur_grd_part' => Faktur_gr::join('faktur_grd', 'faktur_grd.nofaktur', '=', 'faktur_gr.nofaktur')
                ->join('tbcustomer', 'tbcustomer.kode', '=', 'faktur_gr.kdpemilik')
                ->join('tbmobil', 'tbmobil.nopolisi', '=', 'faktur_gr.nopolisi')
                ->join('tbbarang', 'tbbarang.kode', '=', 'faktur_grd.kode')
                ->join('tbsatuan', 'tbsatuan.kode', '=', 'tbbarang.kdsatuan')
                ->select('faktur_gr.*', 'faktur_grd.*', 'tbsatuan.kode as kdsatuan', 'tbsatuan.nama as nmsatuan')
                ->where('faktur_grd.nofaktur', $nofaktur)->where('faktur_grd.jenis', 'PART')->get(),
            'faktur_grd_bahan' => Faktur_gr::join('faktur_grd', 'faktur_grd.nofaktur', '=', 'faktur_gr.nofaktur')
                ->join('tbcustomer', 'tbcustomer.kode', '=', 'faktur_gr.kdpemilik')
                ->join('tbmobil', 'tbmobil.nopolisi', '=', 'faktur_gr.nopolisi')
                ->join('tbbahan', 'tbbahan.kode', '=', 'faktur_grd.kode')
                ->join('tbsatuan', 'tbsatuan.kode', '=', 'tbbahan.kdsatuan')
                ->select('faktur_gr.*', 'faktur_grd.*', 'tbsatuan.kode as kdsatuan', 'tbsatuan.nama as nmsatuan')
                ->where('faktur_grd.nofaktur', $nofaktur)->where('faktur_grd.jenis', 'BAHAN')->get(),
        ];
        // return view('jual.cetak', $data);

        $rowd = faktur_grd::where('nofaktur', $nofaktur)->get();
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
        $faktur_gr = Faktur_gr::where('id', $request->id)->first();
        $tanggal = date('Y-m-d');
        $datetime = date('Y-m-d H:i:s');
        $dokumen = $faktur_gr->nofaktur;
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
        $mpdf->WriteHTML(view('faktur_gr.cetak', $data));
        $namafile = $nofaktur . ' - ' . date('dmY H:i:s') . '.pdf';
        //return the PDF for download
        // return $mpdf->Output($request->get('name') . $namafile, Destination::DOWNLOAD);
        $mpdf->Output($namafile, 'I');
    }

    public function buatfaktur_gr(Request $request, faktur_gr $faktur_gr)
    {
        if ($request->Ajax()) {
            $idwo = $request->idwo;
            $row_wo_gr = Faktur_gr::where('id', $idwo)->first();
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
            // $faktur_gr->save($validated);
            $faktur_gr->save();
            Faktur_gr::where('nofaktur', $row_wo_gr->nofaktur)->update(['nofaktur' => $nofaktur]);
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
            $faktur_gr = Faktur_gr::where('nowo', $nowo)->first(); //->orderBy('kode', 'asc');
            $data = [
                'faktur_gr' => $faktur_gr,
            ];
            echo view('faktur_gr.summary', $data);
        }
    }
}
