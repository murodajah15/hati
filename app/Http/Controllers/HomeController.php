<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//return type View
use App\Models\Userdtl;
use App\Models\Poh;
use App\Models\Belih;
use App\Models\Tbcustomer;
use App\Models\Jualh;
use App\Models\Kasir_tunai;
use App\Models\Kasir_tagihan;
use App\Models\Tbbarang;
use App\Models\Tbmodule;

class HomeController extends Controller
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
            'userdtl.cmainmenu',
            'userdtl.nlevel',
            'userdtl.nurut',
            'userdtl.pakai',
            'userdtl.tambah',
            'userdtl.edit',
            'userdtl.hapus',
            'userdtl.proses',
            'userdtl.unproses',
            'userdtl.cetak',
        )->join('tbmodule', 'userdtl.cmodule', '=', 'tbmodule.cmodule')->where('userdtl.pakai', '1')->where('userdtl.username', $username)->orderBy('userdtl.nurut')->get();
        // dd($userdtl);
        $data = [
            'menu' => 'dashboard',
            'submenu' => '',
            'submenu1' => '',
            'title' => 'Home',
            // 'userdtlmenu' => Userdtl::join('tbmodule', 'userdtl.cmodule', '=', 'tbmodule.cmodule')->where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
            'userdtlmenu' => $userdtl,
            'jumlah_customer' => Tbcustomer::count(),
            // 'tbbarang' => Tbbarang::select('*')->orderBy('kode')->get(),
        ];
        // dd($data);
        return view('dashboard.index', $data);
    }

    public function contact()
    {
        $data = [
            'menu' => 'home',
            'submenu' => 'dashboard',
            'submenu1' => 'ref_umum',
            'title' => 'Contact',
        ];
        return response()->json([
            'body' => view('home.modalcontact', [
                'vdata' => $data,
            ])->render(),
            'data' => $data,
        ]);
        // return view('home.contact')->with($data);
    }
}
