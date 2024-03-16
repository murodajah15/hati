<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Saplikasi;
use App\Models\Userdtl;
use App\Models\Closing_harian;
use App\Models\Close_hpp;
use App\Models\Opnameh;
use App\Models\User;

class ProsesController extends Controller
{
    public function closing_harian(Request $request) //: View
    {
        $username = session('username');
        $data = [
            'menu' => 'proses',
            'submenu' => 'closing_harian',
            'submenu1' => '',
            'title' => 'Closing Harian',
            'username' => $username,
            'closing_harian' => Closing_harian::orderBy('tglclosing', 'desc')->get(),
            'userdtlmenu' => Userdtl::where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(), //Userdtl::join('tbmodule', 'userdtl.cmodule', '=', 'tbmodule.cmodule')->where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
            'userdtl' => Userdtl::where('cmodule', 'Closing Harian')->where('username', $username)->first(),
        ];
        // var_dump($data);
        return view('proses.closing_harian')->with($data);
    }
    public function closing_harian_proses(Request $request) //: View
    {
        $username = session('username');
        $data = [
            'menu' => 'proses',
            'submenu' => 'closing_harian',
            'submenu1' => '',
            'title' => 'Closing Harian',
            'username' => $username,
            'saplikasi' => Saplikasi::where('aktif', 'Y')->first(),
            'userdtlmenu' => Userdtl::where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(), //Userdtl::join('tbmodule', 'userdtl.cmodule', '=', 'tbmodule.cmodule')->where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
            'userdtl' => Userdtl::where('cmodule', 'Closing Harian')->where('username', $username)->first(),
            'semuaperiode' => isset($request->semuaperiode) ? 'Y' : 'N',
            'tgl_berikutnya' => $request->tgl_berikutnya,
        ];
        // var_dump($data);
        return view('proses.closing_harian_proses')->with($data);
    }

    public function closing_hpp(Request $request) //: View
    {
        $username = session('username');
        $data = [
            'menu' => 'proses',
            'submenu' => 'closing_hpp',
            'submenu1' => '',
            'title' => 'Closing Bulanan dan HPP',
            'username' => $username,
            'user' => User::orderBy('last_login', 'desc')->get(),
            'saplikasi' => Saplikasi::where('aktif', 'Y')->first(),
            'close_hpp' => Close_hpp::orderBy('tgl_closing', 'desc')->get(),
            'opnameh' => Opnameh::orderBy('tglopname', 'desc')->get(),
            'userdtlmenu' => Userdtl::where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(), //Userdtl::join('tbmodule', 'userdtl.cmodule', '=', 'tbmodule.cmodule')->where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
            'userdtl' => Userdtl::where('cmodule', 'Closing Bulanan dan HPP')->where('username', $username)->first(),
        ];
        // var_dump($data);
        return view('proses.closing_hpp')->with($data);
    }
    public function closing_hpp_proses(Request $request) //: View
    {
        $username = session('username');
        $data = [
            'menu' => 'proses',
            'submenu' => 'closing_hpp',
            'submenu1' => '',
            'title' => 'Closing Bulanan dan HPP',
            'username' => $username,
            'saplikasi' => Saplikasi::where('aktif', 'Y')->first(),
            'close_hpp' => Close_hpp::orderBy('tgl_closing', 'desc')->get(),
            'userdtlmenu' => Userdtl::where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(), //Userdtl::join('tbmodule', 'userdtl.cmodule', '=', 'tbmodule.cmodule')->where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
            'userdtl' => Userdtl::where('cmodule', 'Closing Bulanan dan HPP')->where('username', $username)->first(),
            'semuaperiode' => isset($request->semuaperiode) ? 'Y' : 'N',
            'tgl_berikutnya' => $request->tgl_berikutnya,
        ];
        // var_dump($data);
        return view('proses.closing_hpp_proses')->with($data);
    }
    public function closing_hpp_unproses(Request $request) //: View
    {
        $username = session('username');
        $data = [
            'menu' => 'proses',
            'submenu' => 'closing_hpp',
            'submenu1' => '',
            'title' => 'Closing Bulanan dan HPP',
            'username' => $username,
            'saplikasi' => Saplikasi::where('aktif', 'Y')->first(),
            'close_hpp' => Close_hpp::orderBy('tgl_closing', 'desc')->get(),
            'userdtlmenu' => Userdtl::where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(), //Userdtl::join('tbmodule', 'userdtl.cmodule', '=', 'tbmodule.cmodule')->where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
            'userdtl' => Userdtl::where('cmodule', 'Closing Bulanan dan HPP')->where('username', $username)->first(),
            'semuaperiode' => isset($request->semuaperiode) ? 'Y' : 'N',
            'tgl_berikutnya' => $request->tgl_berikutnya,
        ];
        // var_dump($data);
        return view('proses.closing_hpp_unproses')->with($data);
    }

    public function proses_stock(Request $request) //: View
    {
        $username = session('username');
        $data = [
            'menu' => 'proses',
            'submenu' => 'proses_stock',
            'submenu1' => '',
            'title' => 'Proses Ulang Stock',
            'username' => $username,
            'user' => User::orderBy('last_login', 'desc')->get(),
            'saplikasi' => Saplikasi::where('aktif', 'Y')->first(),
            'close_hpp' => Close_hpp::orderBy('tgl_closing', 'desc')->get(),
            'opnameh' => Opnameh::orderBy('tglopname', 'desc')->get(),
            'userdtlmenu' => Userdtl::where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(), //Userdtl::join('tbmodule', 'userdtl.cmodule', '=', 'tbmodule.cmodule')->where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
            'userdtl' => Userdtl::where('cmodule', 'Proses Ulang Stock')->where('username', $username)->first(),
        ];
        // var_dump($data);
        return view('proses.proses_stock')->with($data);
    }
    public function proses_stock_proses(Request $request) //: View
    {
        $username = session('username');
        $data = [
            'menu' => 'proses',
            'submenu' => 'proses_stock',
            'submenu1' => '',
            'title' => 'Proses Ulang Stock',
            'username' => $username,
            'saplikasi' => Saplikasi::where('aktif', 'Y')->first(),
            'close_hpp' => Close_hpp::orderBy('tgl_closing', 'desc')->get(),
            'userdtlmenu' => Userdtl::where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(), //Userdtl::join('tbmodule', 'userdtl.cmodule', '=', 'tbmodule.cmodule')->where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
            'userdtl' => Userdtl::where('cmodule', 'Proses Ulang Stock')->where('username', $username)->first(),
            'semuaperiode' => isset($request->semuaperiode) ? 'Y' : 'N',
            'tgl_berikutnya' => $request->tgl_berikutnya,
        ];
        // var_dump($data);
        return view('proses.proses_stock_proses')->with($data);
    }

    public function backup(Request $request) //: View
    {
        $username = session('username');
        $data = [
            'menu' => 'utility',
            'submenu' => 'backup',
            'submenu1' => '',
            'title' => 'Backup Database',
            'username' => $username,
            'user' => User::orderBy('last_login', 'desc')->get(),
            'saplikasi' => Saplikasi::where('aktif', 'Y')->first(),
            'close_hpp' => Close_hpp::orderBy('tgl_closing', 'desc')->get(),
            'opnameh' => Opnameh::orderBy('tglopname', 'desc')->get(),
            'userdtlmenu' => Userdtl::where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(), //Userdtl::join('tbmodule', 'userdtl.cmodule', '=', 'tbmodule.cmodule')->where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
            'userdtl' => Userdtl::where('cmodule', 'Backup Database')->where('username', $username)->first(),
        ];
        // var_dump($data);
        return view('proses.backup')->with($data);
    }
    public function backup_proses(Request $request) //: View
    {
        $username = session('username');
        $data = [
            'menu' => 'proses',
            'submenu' => 'backup',
            'submenu1' => '',
            'title' => 'Backup Database',
            'username' => $username,
            'saplikasi' => Saplikasi::where('aktif', 'Y')->first(),
            'close_hpp' => Close_hpp::orderBy('tgl_closing', 'desc')->get(),
            'userdtlmenu' => Userdtl::where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(), //Userdtl::join('tbmodule', 'userdtl.cmodule', '=', 'tbmodule.cmodule')->where('userdtl.pakai', '1')->where('username', $username)->orderBy('userdtl.nurut')->get(),
            'userdtl' => Userdtl::where('cmodule', 'Backup Database')->where('username', $username)->first(),
            'semuaperiode' => isset($request->semuaperiode) ? 'Y' : 'N',
            'tgl_berikutnya' => $request->tgl_berikutnya,
        ];
        // var_dump($data);
        return view('proses.backup_proses')->with($data);
    }
}
