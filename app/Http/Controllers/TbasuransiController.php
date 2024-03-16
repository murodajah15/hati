<?php

namespace App\Http\Controllers;

use App\Http\Requests\TbasuransiRequest;
use Illuminate\Http\Request;
use Session;
// use Yajra\DataTables\Contracts\DataTables;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Tbasuransi;
use App\Models\Userdtl;

// //return type View
// use Illuminate\View\View;

class TbasuransiController extends Controller
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
            'submenu' => 'tbasuransi',
            'submenu1' => 'ref_umum',
            'title' => 'Tabel Asuransi',
            // 'tbasuransi' => Tbasuransi::all(),
            // 'userdtlmenu' => Userdtl::where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
            // 'userdtlmenu' => Userdtl::join('tbmodule', 'userdtl.cmodule', '=', 'tbmodule.cmodule')->where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
            'userdtlmenu' => $userdtl,
            // 'userdtl' => Userdtl::where('cmodule', 'Tabel Asuransi')->where('username', $username)->first(),
        ];
        // dd($data);
        return view('tbasuransi.index')->with($data);
    }
    public function tbasuransiajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $data = Tbasuransi::select('*'); //->orderBy('kode', 'asc');
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
            return view('tbasuransi');
        }
    }

    public function tabel_asuransi(Request $request)
    {
        $data = [
            'menu' => 'file',
            'submenu' => 'tbasuransi',
            'submenu1' => 'ref_umum',
            'title' => 'Tabel Asuransi',
            'tbasuransi' => Tbasuransi::orderBy('kode', 'asc')->get(),
        ];
        // var_dump($data);
        return view('tbasuransi.tabel_asuransi')->with($data);
    }

    public function create(Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'file',
                'submenu' => 'tbasuransi',
                'submenu1' => 'ref_umum',
                'title' => 'Tambah Data Tabel Asuransi',
                // 'tbasuransi' => Tbasuransi::all(),
            ];
            // var_dump($data);
            return response()->json([
                'body' => view('tbasuransi.modaltambah', [
                    'tbasuransi' => new Tbasuransi(), //Tbasuransi::first(),
                    'action' => route('tbasuransi.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,

            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function store(TbasuransiRequest $request, Tbasuransi $tbasuransi)
    {
        if ($request->Ajax()) {
            $validated = $request->validated(
                // [
                //     'kode' => 'required|unique:tbasuransi,kode',
                //     'nama' => 'required',
                // ],
                // [
                //     'kode.unique' => 'Kode tidak boleh sama',
                //     'kode.required' => 'Kode harus di isi',
                //     'nama.required' => 'Nama harus di isi',
                // ]
            );
            if ($validated) {
                // $tbasuransi->fill($request->all());
                // $tbasuransi->aktif = $request->aktif == 'on' ? 'Y' : 'N';
                // $tbasuransi->user = $request->username . date('d-m-Y');
                $aktif = isset($request->aktif) ? 'Y' : 'N';
                $tbasuransi->fill([
                    'kode' => isset($request->kode) ? $request->kode : '',
                    'nama' => isset($request->nama) ? $request->nama : '',
                    'alamat' => isset($request->alamat) ? $request->alamat : '',
                    'kota' => isset($request->kota) ? $request->kota : '',
                    'email' => isset($request->email) ? $request->email : '',
                    'telp' => isset($request->telp) ? $request->telp : '',
                    'fax' => isset($request->fax) ? $request->fax : '',
                    'npwp' => isset($request->npwp) ? $request->npwp : '',
                    'nama_npwp' => isset($request->nama_npwp) ? $request->nama_npwp : '',
                    'alamat_npwp' => isset($request->alamat_npwp) ? $request->alamat_npwp : '',
                    'nppkp' => isset($request->nppkp) ? $request->nppkp : '',
                    'contact_person' => isset($request->contact_person) ? $request->contact_person : '',
                    'no_contact_person' => isset($request->no_contact_person) ? $request->no_contact_person : '',
                    'top' => isset($request->top) ? $request->top : '',
                    'kredit_limit' => isset($request->kredit_limit) ? $request->kredit_limit : '',
                    'disc_part' => isset($request->disc_part) ? $request->disc_part : '',
                    'disc_jasa' => isset($request->disc_jasa) ? $request->disc_jasa : '',
                    'disc_bahan' => isset($request->disc_bahan) ? $request->disc_bahan : '',
                    'pph_jasa' => isset($request->pph_jasa) ? $request->pph_jasa : '',
                    'pph_material' => isset($request->pph_material) ? $request->pph_material : '',
                    'aktif' => $aktif,
                    'user' => 'Tambah-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $tbasuransi->save($validated);
                $msg = [
                    'sukses' => 'Data berhasil di tambah', //view('tbasuransi.tabel_asuransi')
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
                'submenu' => 'tbasuransi',
                'submenu1' => 'ref_umum',
                'title' => 'Detail Tabel Asuransi',
                'tbasuransi' => Tbasuransi::findOrFail($id),
                'userdtl' => Userdtl::where('cmodule', 'Tabel Asuransi')->where('username', $username)->first(),
            ];
            // return view('tbasuransi.modaldetail')->with($data);
            return response()->json([
                'body' => view('tbasuransi.modaltambah', [
                    'tbasuransi' => Tbasuransi::findOrFail($id),
                    'action' => route('tbasuransi.store'),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function edit(Tbasuransi $tbasuransi, Request $request)
    {
        if ($request->Ajax()) {
            $data = [
                'menu' => 'file',
                'submenu' => 'tbasuransi',
                'submenu1' => 'ref_umum',
                'title' => 'Edit Data Tabel Asuransi',
            ];
            return response()->json([
                'body' => view('tbasuransi.modaltambah', [
                    'tbasuransi' => $tbasuransi,
                    'action' => route('tbasuransi.update', $tbasuransi->id),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function update(TbasuransiRequest $request, Tbasuransi $tbasuransi)
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
                    //     'kode' => 'required|unique:tbasuransi,kode',
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
                $aktif = $request->aktif == 'on' ? 'Y' : 'N';
                $tbasuransi->fill([
                    'kode' => isset($request->kode) ? $request->kode : '',
                    'nama' => isset($request->nama) ? $request->nama : '',
                    'alamat' => isset($request->alamat) ? $request->alamat : '',
                    'kota' => isset($request->kota) ? $request->kota : '',
                    'email' => isset($request->email) ? $request->email : '',
                    'telp' => isset($request->telp) ? $request->telp : '',
                    'fax' => isset($request->fax) ? $request->fax : '',
                    'npwp' => isset($request->npwp) ? $request->npwp : '',
                    'nama_npwp' => isset($request->nama_npwp) ? $request->nama_npwp : '',
                    'alamat_npwp' => isset($request->alamat_npwp) ? $request->alamat_npwp : '',
                    'nppkp' => isset($request->nppkp) ? $request->nppkp : '',
                    'contact_person' => isset($request->contact_person) ? $request->contact_person : '',
                    'no_contact_person' => isset($request->no_contact_person) ? $request->no_contact_person : '',
                    'top' => isset($request->top) ? $request->top : '',
                    'kredit_limit' => isset($request->kredit_limit) ? $request->kredit_limit : '',
                    'disc_part' => isset($request->disc_part) ? $request->disc_part : '',
                    'disc_jasa' => isset($request->disc_jasa) ? $request->disc_jasa : '',
                    'disc_bahan' => isset($request->disc_bahan) ? $request->disc_bahan : '',
                    'pph_jasa' => isset($request->pph_jasa) ? $request->pph_jasa : '',
                    'pph_material' => isset($request->pph_material) ? $request->pph_material : '',
                    'aktif' => $aktif,
                    'user' => 'Update-' . $request->username . ', ' . date('d-m-Y h:i:s'),
                ]);
                $tbasuransi->save($validated);
                $msg = [
                    'sukses' => 'Data berhasil di update', //view('tbasuransi.tabel_asuransi')
                ];
            } else {
                $msg = [
                    'sukses' => 'Data gagal di update', //view('tbasuransi.tabel_asuransi')
                ];
            }
            echo json_encode($msg);
            // return redirect()->back()->with('message', 'Berhasil di update');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function destroy(Tbasuransi $tbasuransi, Request $request)
    {
        if ($request->Ajax()) {
            $tbasuransi->delete();
            return response()->json([
                'sukses' => 'Data berhasil di hapus',
            ]);
            // return redirect()->back()->with('message', 'Berhasil di hapus');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
}
