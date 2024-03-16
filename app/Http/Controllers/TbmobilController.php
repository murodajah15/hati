<?php

namespace App\Http\Controllers;

use App\Http\Requests\TbmobilRequest;
use App\Http\Requests\TbcustomerRequest;
use Illuminate\Http\Request;
use Session;
// use Yajra\DataTables\Contracts\DataTables;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Tbmobil;
use App\Models\Tbmerek;
use App\Models\Tbmodel;
use App\Models\Tbtipe;
use App\Models\Tbwarna;
use App\Models\Tbjenis;
use App\Models\Userdtl;
use App\Models\Tbcustomer;
use App\Models\Tbagama;
use App\Models\Estimasi_bp;

// //return type View
// use Illuminate\View\View;

class TbmobilController extends Controller
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
            'menu' => 'file',
            'submenu' => 'tbmobil',
            'submenu1' => 'ref_kendaraan',
            'title' => 'Tabel Mobil',
            // 'tbmobil' => Tbmobil::all(),
            // 'userdtlmenu' => Userdtl::where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
            // 'userdtlmenu' => Userdtl::join('tbmodule', 'userdtl.cmodule', '=', 'tbmodule.cmodule')->where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
            'userdtlmenu' => $userdtl,
            // 'userdtl' => Userdtl::where('cmodule', 'Tabel Mobil')->where('username', $username)->first(),
        ];
        // dd($data);
        return view('tbmobil.index')->with($data);
    }
    public function tbmobilajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $data = Tbmobil::select('*'); //->orderBy('kode', 'asc');
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
            return view('tbmobil');
        }
    }

    public function tabel_mobil(Request $request)
    {
        $data = [
            'menu' => 'file',
            'submenu' => 'tbmobil',
            'submenu1' => 'ref_kendaraan',
            'title' => 'Tabel Mobil',
            'tbmobil' => Tbmobil::orderBy('kode', 'asc')->get(),
        ];
        // var_dump($data);
        return view('tbmobil.tabel_mobil')->with($data);
    }

    public function create(Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'file',
                'submenu' => 'tbmobil',
                'submenu1' => 'ref_kendaraan',
                'title' => 'Tambah Data Tabel Mobil',
            ];
            // var_dump($data);
            return response()->json([
                'body' => view('tbmobil.modaltambahmaster', [
                    'tbmobil' => new Tbmobil(), //Tbmobil::first(),
                    'tbmerek' => Tbmerek::orderBy('nama')->get(),
                    'tbmodel' => Tbmodel::orderBy('nama')->get(),
                    'tbtipe' => Tbtipe::orderBy('nama')->get(),
                    'tbwarna' => Tbwarna::orderBy('nama')->get(),
                    'tbjenis' => Tbjenis::orderBy('nama')->get(),
                    'action' => route('tbmobil.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,

            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function store(TbmobilRequest $request, Tbmobil $tbmobil)
    {
        if ($request->Ajax()) {
            $validated = $request->validated(
                // [
                //     'kode' => 'required|unique:tbmobil,kode',
                //     'nama' => 'required',
                // ],
                // [
                //     'kode.unique' => 'Kode tidak boleh sama',
                //     'kode.required' => 'Kode harus di isi',
                //     'nama.required' => 'Nama harus di isi',
                // ]
            );
            if ($validated) {
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
                    'user' => 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $tbmobil->save($validated);
                $msg = [
                    'sukses' => 'Data berhasil di tambah', //view('tbmobil.tabel_mobil')
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
            $username = session('username');
            $data = [
                'menu' => 'file',
                'submenu' => 'tbmobil',
                'submenu1' => 'ref_kendaraan',
                'title' => 'Detail Tabel Mobil',
                'tbmobil' => Tbmobil::findOrFail($id),
                'userdtl' => Userdtl::where('cmodule', 'Tabel Mobil')->where('username', $username)->first(),
            ];
            // return view('tbmobil.modaldetail')->with($data);
            return response()->json([
                'body' => view('tbmobil.modaltambahmaster', [
                    'tbmobil' => Tbmobil::findOrFail($id),
                    'tbmerek' => Tbmerek::orderBy('nama')->get(),
                    'tbmodel' => Tbmodel::orderBy('nama')->get(),
                    'tbtipe' => Tbtipe::orderBy('nama')->get(),
                    'tbwarna' => Tbwarna::orderBy('nama')->get(),
                    'tbjenis' => Tbjenis::orderBy('nama')->get(),
                    'action' => route('tbmobil.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function edit(Tbmobil $tbmobil, Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'file',
                'submenu' => 'tbmobil',
                'submenu1' => 'ref_kendaraan',
                'title' => 'Edit Data Tabel Mobil',
            ];
            return response()->json([
                'body' => view('tbmobil.modaltambahmaster', [
                    'tbmobil' => $tbmobil,
                    'tbmerek' => Tbmerek::orderBy('nama')->get(),
                    'tbmodel' => Tbmodel::orderBy('nama')->get(),
                    'tbtipe' => Tbtipe::orderBy('nama')->get(),
                    'tbwarna' => Tbwarna::orderBy('nama')->get(),
                    'tbjenis' => Tbjenis::orderBy('nama')->get(),
                    'action' => route('tbmobil.update', $tbmobil->id),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function update(TbmobilRequest $request, Tbmobil $tbmobil)
    {
        if ($request->Ajax()) {
            if ($request->kode === $request->kodelama) {
                $validated = $request->validated(
                    // [
                    //     'kode' => 'required',
                    //     'nama' => 'required',
                    // ],
                    // [
                    //     'kode.required' => 'Kode harus di isi',
                    //     'nama.required' => 'Nama harus di isi',
                    // ]
                );
            } else {
                // var_dump($request->kode . '!=' . $request->kodelama);
                $validated = $request->validated(
                    // [
                    //     'kode' => 'required|unique:tbmobil,kode',
                    //     'nama' => 'required',
                    // ],
                    // [
                    //     'kode.unique' => 'Kode tidak boleh sama',
                    //     'kode.required' => 'Kode harus di isi',
                    //     'nama.required' => 'Nama harus di isi',
                    // ]
                );
            }
            if ($validated) {
                // dd($request->norangka);
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

    public function destroy(Tbmobil $tbmobil, Request $request)
    {
        if ($request->Ajax()) {
            $tbmobil = Tbmobil::where('id', $request->id)->first();
            $rec = Estimasi_bp::where('nopolisi', $tbmobil->nopolisi)->first();
            if (isset($rec)) {
                return response()->json([
                    'sukses' => false,
                ]);
            } else {
                $tbmobil->delete();
                return response()->json([
                    'sukses' => 'Data berhasil di hapus',
                ]);
            }
            // return redirect()->back()->with('message', 'Berhasil di hapus');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function tambahcustomer(Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'file',
                'submenu' => 'tbcustomer',
                'submenu1' => 'ref_umum',
                'title' => 'Tambah Data Tabel Customer',
            ];
            // var_dump($data);
            return response()->json([
                // 'body' => view('tbmobil.modaltambahcustomer', [
                'body' => view('tbcustomer.modaltambah', [
                    'tbcustomer' => new Tbcustomer(), //Tbcustomer::first(),
                    'tbagama' => Tbagama::all(),
                    'action' => route('tbcustomer.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,

            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    // public function simpancustomer(TbcustomerRequest $request, Tbcustomer $tbcustomer)
    // {
    //     if ($request->Ajax()) {
    //         $validated = $request->validated(
    //             // [
    //             //     'kode' => 'required|unique:tbcustomer,kode',
    //             //     'nama' => 'required',
    //             // ],
    //             // [
    //             //     'kode.unique' => 'Kode tidak boleh sama',
    //             //     'kode.required' => 'Kode harus di isi',
    //             //     'nama.required' => 'Nama harus di isi',
    //             // ]
    //         );
    //         if ($validated) {
    //             // $aktif = isset($request->aktif) ? 'Y' : 'N';
    //             $tbcustomer->fill([
    //                 'nama' => isset($request->nama) ? $request->nama : '',
    //                 'kode' => isset($request->kode) ? $request->kode : '',
    //                 'kelompok' => isset($request->kelompok) ? $request->kelompok : '',
    //                 'alamat' => isset($request->alamat) ? $request->alamat : '',
    //                 'kota' => isset($request->kota) ? $request->kota : '',
    //                 'kodepos' => isset($request->kodepos) ? $request->kodepos : '',
    //                 'telp1' => isset($request->telp1) ? $request->telp1 : '',
    //                 'telp2' => isset($request->telp2) ? $request->telp2 : '',
    //                 'agama' => isset($request->agama) ? $request->agama : '',
    //                 'tgl_lahir' => isset($request->tgl_lahir) ? $request->tgl_lahir : '',
    //                 'alamat_ktr' => isset($request->alamat_ktr) ? $request->alamat_ktr : '',
    //                 'kota_ktr' => isset($request->kota_ktr) ? $request->kota_ktr : '',
    //                 'kodepos_ktr' => isset($request->kodepos_ktr) ? $request->kodepos_ktr : '',
    //                 'telp1_ktr' => isset($request->telp1_ktr) ? $request->telp1_ktr : '',
    //                 'telp2_ktr' => isset($request->telp2_ktr) ? $request->telp2_ktr : '',
    //                 'npwp' => isset($request->npwp) ? $request->npwp : '',
    //                 'alamat_npwp' => isset($request->alamat_npwp) ? $request->alamat_npwp : '',
    //                 'nama_npwp' => isset($request->nama_npwp) ? $request->nama_npwp : '',
    //                 'alamat_ktp' => isset($request->alamat_ktp) ? $request->alamat_ktp : '',
    //                 'kota_ktp' => isset($request->kota_ktp) ? $request->kota_ktp : '',
    //                 'kodepos_ktp' => isset($request->kodepos_ktp) ? $request->kodepos_ktp : '',
    //                 'contact_person_rmh' => isset($request->contact_person_rmh) ? $request->contact_person_rmh : '',
    //                 'mak_piutang' => isset($request->mak_piutang) ? $request->mak_piutang : '',
    //                 'kdklpcust' => isset($request->kdklpcust) ? $request->kdklpcust : '',
    //                 'nmklpcust' => isset($request->nmklpcust) ? $request->nmklpcust : '',
    //                 'tgl_register' => isset($request->tgl_register) ? $request->tgl_register : '',
    //                 'tempo' => isset($request->tempo) ? $request->tempo : '',
    //                 'user' => 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s'),
    //             ]);
    //             $tbcustomer->save($validated);
    //             $msg = [
    //                 'sukses' => 'Data berhasil di tambah', //view('tbcustomer.tabel_customer')
    //             ];
    //         }
    //         echo json_encode($msg);
    //         // return redirect()->back()->with('message', 'Berhasil di simpan');
    //     } else {
    //         exit('Maaf tidak dapat diproses');
    //     }
    // }
}
