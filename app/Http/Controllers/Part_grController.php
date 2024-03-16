<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Wo_gr;
use App\Models\Wo_grd;
use App\Models\Faktur_grd;
use App\Models\Userdtl;
use App\Models\Hisuser;

// //return type View
// use Illuminate\View\View;

class Part_grController extends Controller
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
            'submenu' => 'part_gr',
            'submenu1' => 'general_repair',
            'title' => 'Pembebanan Spare Part GR',
            'userdtlmenu' => $userdtl,
            'userdtl' => Userdtl::where('cmodule', 'Part Body Repair')->where('username', $username)->first(),
        ];
        return view('part_gr.index')->with($data);
    }

    public function vwopart_grajax(Request $request) //: View
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

    public function part_grdetail(Request $request)
    {
        if ($request->Ajax()) {
            $username = session('username');
            $row_wo_gr = Wo_gr::where('id', $request->id)->first();
            $nowo = $row_wo_gr->nowo;
            $data = [
                'menu' => 'file',
                'submenu' => 'part_gr',
                'submenu1' => 'general_repair',
                'title' => 'Detail Part GR',
                'userdtl' => Userdtl::where('cmodule', 'Pembebanan Spare Part GR')->where('username', $username)->first(),
            ];
            return response()->json([
                'body' => view('part_gr.modaldetailwo', [
                    'wo_gr' => Wo_gr::where('nowo', $nowo)->first(),
                    'wo_grd' => Wo_grd::where('nowo', $nowo)->get(),
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function partwo_grajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $data = Wo_grd::where('nowo', $request->nowo)->where('jenis', 'PART')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('kode1', function ($row) {
                    $btn = $row['kode']; //'<a href="#"' . 'onclick=detail(' . $id . ')>' .  $row['kode'] . '</a>';
                    return $btn;
                })
                ->rawColumns(['kode1'])
                ->make(true);
        }
    }

    public function partfaktur_grajax(Request $request) //: View
    {
        if ($request->ajax()) {
            $data = Faktur_grd::where('nofaktur', $request->nofaktur)->where('jenis', 'PART')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('kode1', function ($row) {
                    $btn = $row['kode']; //'<a href="#"' . 'onclick=detail(' . $id . ')>' .  $row['kode'] . '</a>';
                    return $btn;
                })
                ->rawColumns(['kode1'])
                ->make(true);
        }
    }

    public function proses_partwo_gr(Request $request)
    {
        if ($request->Ajax()) {
            $id = $request->id;
            $row_wo_gr = Wo_gr::where('id', $id)->first();
            if ($row_wo_gr->close == 1) {
                $msg = [
                    'sukses' => false,
                ];
            } else {
                $update = Wo_gr::where('id', $id)->update(['close_part' => 1]);
                if ($update) {
                    //Create History
                    $tanggal = date('Y-m-d');
                    $datetime = date('Y-m-d H:i:s');
                    $dokumen = $row_wo_gr->nowo;
                    $form = 'Part BP';
                    $status = 'Unproses';
                    $catatan = isset($request->catatan) ? $request->catatan : '';
                    $username = session('username');
                    Hisuser::insert(['tanggal' => $tanggal, 'dokumen' => $dokumen, 'form' => $form, 'status' => $status, 'user' => $username, 'catatan' => $catatan, 'datetime' => $datetime]);

                    $msg = [
                        'sukses' => 'Spare Part berhasil di close',
                    ];
                } else {
                    $msg = [
                        'sukses' => false,
                    ];
                }
            }
            echo json_encode($msg);
            // return redirect()->back()->with('message', 'Berhasil di simpan');
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function unproses_partwo_gr(Request $request)
    {
        if ($request->Ajax()) {
            $username = session('username');
            $id = $request->id;
            $wo_gr = Wo_gr::where('id', $id)->first();
            $data = [
                'menu' => 'transaksi',
                'submenu' => 'wo_gr',
                'submenu1' => 'general_repair',
                'title' => 'Unproses Part WO Body Repair',
                'userdtl' => Userdtl::where('cmodule', 'WO Body Repair')->where('username', $username)->first(),
            ];
            // return view('wo_gr.modaldetail')->with($data);
            return response()->json([
                'body' => view('wo_gr.modalbatalproses', [
                    'wo_gr' => $wo_gr,
                    'action' => 'unproses_partwo_gr_simpan',
                    'vdata' => $data,
                ])->render(),
                'data' => $data,
            ]);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function unproses_partwo_gr_simpan(Request $request)
    {
        if ($request->Ajax()) {
            Wo_gr::where('id', $request->id)->update([
                'close_part' => 0, 'user_close_part' => 'Unproses-' . $request->username . ', ' . date('d-m-Y h:i:s'),
            ]);
            //Create History
            $tanggal = date('Y-m-d');
            $datetime = date('Y-m-d H:i:s');
            $dokumen = $request->dokumen;
            $form = 'Part BP';
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
}