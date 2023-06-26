<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'Home::index');
// $routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);
$routes->post('/dashboard/tampilGrafik', 'Dashboard::tampilGrafik');

$routes->get('/login', 'Login::index');
$routes->get('/logout', 'Login::logout');
$routes->get('/forgot', 'forgot::index');
$routes->get('/', 'Login::index');
$routes->post('/login/auth', 'Login::auth');
$routes->post('/rubah_password/update/(:segment)', 'Rubah_password::update/$1');
$routes->get('/user/rubah_password/(:segment)', 'Rubah_password::index');
$routes->get('/register', 'Register::index');
$routes->post('/register/save', 'Register::save');
$routes->get('/template', 'Register::index');
$routes->get('/rubah_password', 'Rubah_password::index');
$routes->get('/update_profile', 'Update_profile::index');
$routes->post('/update_profile/update/(:segment)', 'Update_profile::update/$1');

$routes->get('/resetpassword', 'resetpassword::index');
$routes->post('/resetpassword', 'resetpassword::resetpassword');
$routes->get('/click_reset_password', 'resetpassword::click_reset_password');

// $routes->get('/tbcabang', 'Tbcabang::index');
// $routes->get('/tbcabang/create', 'Tbcabang::create');
// $routes->post('/tbcabang/save', 'Tbcabang::save');
// $routes->get('/tbcabang/save', 'Tbcabang::save');
// $routes->get('/tbcabang/(:num)', 'Tbcabang::delete/$1');
// $routes->get('/tbcabang/detail/(:any)', 'Tbcabang::detail/$1');
// $routes->get('/tbcabang/edit/(:segment)', 'Tbcabang::edit/$1');
// $routes->post('/tbcabang/update/(:segment)', 'Tbcabang::update/$1');

$routes->get('/hisuser', 'Hisuser::index');
$routes->get('/hisuser/table_hisuser', 'Hisuser::table_hisuser');
$routes->post('/hisuser/ajax-load-data', 'Hisuser::ajaxLoadData');
$routes->post('/hisuser/formdetail', 'Hisuser::formdetail');

$routes->get('/tbcabang', 'Tbcabang::index');
$routes->get('/tbcabang/table_cabang', 'Tbcabang::table_cabang');
$routes->get('/tbcabang/create', 'Tbcabang::create');
$routes->get('/tbcabang/formtambah', 'Tbcabang::formtambah');
$routes->get('/tbcabang/formtambahform', 'Tbcabang::formtambahform');
$routes->post('/tbcabang/save', 'Tbcabang::save');
$routes->post('/tbcabang/simpandata', 'Tbcabang::simpandata');
$routes->get('/tbcabang/detail/(:any)', 'Tbcabang::detail/$1');
$routes->post('/tbcabang/formdetail', 'Tbcabang::formdetail');
$routes->post('/tbcabang/formedit', 'Tbcabang::formedit');
$routes->post('/tbcabang/updatedata', 'Tbcabang::updatedata');
$routes->post('/tbcabang/hapus/(:num)', 'Tbcabang::hapus/$1');
$routes->post('/tbcabang/ajax-load-data', 'Tbcabang::ajaxLoadData');

// $routes->get('/tbdivisi', 'Tbdivisi::index');
// $routes->get('/tbdivisi/create', 'Tbdivisi::create');
// $routes->post('/tbdivisi/save', 'Tbdivisi::save');
// $routes->get('/tbdivisi/save', 'Tbdivisi::save');
// $routes->get('/tbdivisi/(:num)', 'Tbdivisi::delete/$1');
// $routes->get('/tbdivisi/detail/(:any)', 'Tbdivisi::detail/$1');
// $routes->get('/tbdivisi/edit/(:segment)', 'Tbdivisi::edit/$1');
// $routes->post('/tbdivisi/update/(:segment)', 'Tbdivisi::update/$1');

$routes->get('/tbdivisi', 'Tbdivisi::index');
$routes->get('/tbdivisi/table_divisi', 'Tbdivisi::table_divisi');
$routes->get('/tbdivisi/create', 'Tbdivisi::create');
$routes->get('/tbdivisi/formtambah', 'Tbdivisi::formtambah');
$routes->get('/tbdivisi/formtambahform', 'Tbdivisi::formtambahform');
$routes->post('/tbdivisi/save', 'Tbdivisi::save');
$routes->post('/tbdivisi/simpandata', 'Tbdivisi::simpandata');
$routes->get('/tbdivisi/detail/(:any)', 'Tbdivisi::detail/$1');
$routes->post('/tbdivisi/formdetail', 'Tbdivisi::formdetail');
$routes->post('/tbdivisi/formedit', 'Tbdivisi::formedit');
$routes->post('/tbdivisi/updatedata', 'Tbdivisi::updatedata');
$routes->post('/tbdivisi/hapus/(:num)', 'Tbdivisi::hapus/$1');
$routes->post('/tbdivisi/ajax-load-data', 'Tbdivisi::ajaxLoadData');

$routes->get('/rwtkeluarga', 'Rwtkeluarga::index');
$routes->get("rwtkeluarga/table_rwtkeluarga", "Rwtkeluarga::table_rwtkeluarga");
$routes->post("/rwtkeluarga/table_rwtkeluarga", "Rwtkeluarga::table_rwtkeluarga");
$routes->get('/rwtkeluarga/create', 'Rwtkeluarga::create');
$routes->get('/rwtkeluarga/formtambah', 'Rwtkeluarga::formtambah');
$routes->get('/rwtkeluarga/formtambahform', 'Rwtkeluarga::formtambahform');
$routes->post("/rwtkeluarga/ajax-load-data", "Rwtkeluarga::ajaxLoadData");
$routes->get("/rwtkeluarga/ajax-load-data", "Rwtkeluarga::ajaxLoadData");
$routes->get('/rwtkeluarga/formtambahmodal', 'Rwtkeluarga::formtambahmodal');
$routes->post('/rwtkeluarga/simpandata', 'Rwtkeluarga::simpandata');
$routes->post('/rwtkeluarga/formedit', 'Rwtkeluarga::formedit');
$routes->get('/rwtkeluarga/formedit', 'Rwtkeluarga::formedit');
$routes->post('/rwtkeluarga/formeditmodal', 'Rwtkeluarga::formeditmodal');
$routes->post('/rwtkeluarga/updatedata', 'Rwtkeluarga::updatedata');
$routes->post('/rwtkeluarga/formdetail', 'Rwtkeluarga::formdetail');
$routes->post('/rwtkeluarga/hapus/(:num)', 'Rwtkeluarga::hapus/$1');
$routes->post('/rwtkeluarga/deletemultiple', 'Rwtkeluarga::deletemultiple');
$routes->get('/rwtkeluarga/formtambahbanyak', 'Rwtkeluarga::formtambahbanyak');
$routes->post('/rwtkeluarga/simpandatabanyak', 'Rwtkeluarga::simpandatabanyak');
$routes->get('/rwtkeluarga/formedit_detail', 'Rwtkeluarga::formedit_detail');
$routes->get('/rwtkeluarga/table_detail', 'Rwtkeluarga::table_detail');
$routes->post('/rwtkeluarga/table_detail', 'Rwtkeluarga::table_detail');
$routes->get("/rwtkeluarga/ajax-load-data-detail", "Rwtkeluarga::ajaxLoadDataDetail");
$routes->post("/rwtkeluarga/ajax-load-data-detail", "Rwtkeluarga::ajaxLoadDataDetail");
$routes->post('/rwtkeluarga/simpan_data_detail', 'Rwtkeluarga::simpan_data_detail');
$routes->get('/rwtkeluarga/simpan_data_detail', 'Rwtkeluarga::simpan_data_detail');
$routes->get('/rwtkeluarga/formcari', 'Rwtkeluarga::formcari');
$routes->post('/rwtkeluarga/formcari', 'Rwtkeluarga::formcari');
$routes->get('/rwtkeluarga/cari_data_divisi', 'Rwtkeluarga::cari_data_divisi');
$routes->post('/rwtkeluarga/repl_divisi', 'Rwtkeluarga::repl_divisi');

$routes->get('/tbagama', 'Tbagama::index');
$routes->get('/tbagama/table_agama', 'Tbagama::table_agama');
$routes->get('/tbagama/create', 'Tbagama::create');
$routes->get('/tbagama/formtambah', 'Tbagama::formtambah');
$routes->get('/tbagama/formtambahform', 'Tbagama::formtambahform');
$routes->post('/tbagama/save', 'Tbagama::save');
$routes->post('/tbagama/simpandata', 'Tbagama::simpandata');
$routes->get('/tbagama/detail/(:any)', 'Tbagama::detail/$1');
$routes->post('/tbagama/formdetail', 'Tbagama::formdetail');
$routes->post('/tbagama/formedit', 'Tbagama::formedit');
$routes->post('/tbagama/updatedata', 'Tbagama::updatedata');
$routes->post('/tbagama/hapus/(:num)', 'Tbagama::hapus/$1');
$routes->post('/tbagama/ajax-load-data', 'Tbagama::ajaxLoadData');

$routes->get('/tbsa', 'Tbsa::index');
$routes->get('/tbsa/table_sa', 'Tbsa::table_sa');
$routes->get('/tbsa/create', 'Tbsa::create');
$routes->get('/tbsa/formtambah', 'Tbsa::formtambah');
$routes->post('/tbsa/save', 'Tbsa::save');
$routes->post('/tbsa/simpandata', 'Tbsa::simpandata');
$routes->get('/tbsa/detail/(:any)', 'Tbsa::detail/$1');
$routes->post('/tbsa/formdetail', 'Tbsa::formdetail');
$routes->post('/tbsa/formedit', 'Tbsa::formedit');
$routes->post('/tbsa/updatedata', 'Tbsa::updatedata');
$routes->post('/tbsa/hapus/(:num)', 'Tbsa::hapus/$1');
$routes->post('/tbsa/ajax-load-data', 'Tbsa::ajaxLoadData');

$routes->get('/tbklpjasa', 'Tbklpjasa::index');
$routes->get('/tbklpjasa/table_klpjasa', 'Tbklpjasa::table_klpjasa');
$routes->get('/tbklpjasa/create', 'Tbklpjasa::create');
$routes->get('/tbklpjasa/formtambah', 'Tbklpjasa::formtambah');
$routes->post('/tbklpjasa/save', 'Tbklpjasa::save');
$routes->post('/tbklpjasa/simpandata', 'Tbklpjasa::simpandata');
$routes->get('/tbklpjasa/detail/(:any)', 'Tbklpjasa::detail/$1');
$routes->post('/tbklpjasa/formdetail', 'Tbklpjasa::formdetail');
$routes->post('/tbklpjasa/formedit', 'Tbklpjasa::formedit');
$routes->post('/tbklpjasa/updatedata', 'Tbklpjasa::updatedata');
$routes->post('/tbklpjasa/hapus/(:num)', 'Tbklpjasa::hapus/$1');
$routes->post('/tbklpjasa/ajax-load-data', 'Tbklpjasa::ajaxLoadData');
$routes->get('/tbklpjasa/cariparent', 'Tbklpjasa::cariparent');
$routes->post('/tbklpjasa/replparent', 'Tbklpjasa::replparent');

$routes->get('/tbjasa', 'Tbjasa::index');
$routes->get('/tbjasa/index', 'Tbjasa::index');
$routes->get('/tbjasa/table_jasa', 'Tbjasa::table_jasa');
$routes->get('/tbjasa/create', 'Tbjasa::create');
$routes->get('/tbjasa/formtambah', 'Tbjasa::formtambah');
$routes->post('/tbjasa/save', 'Tbjasa::save');
$routes->post('/tbjasa/simpandata', 'Tbjasa::simpandata');
$routes->get('/tbjasa/detail/(:any)', 'Tbjasa::detail/$1');
$routes->post('/tbjasa/formdetail', 'Tbjasa::formdetail');
$routes->post('/tbjasa/formedit', 'Tbjasa::formedit');
$routes->post('/tbjasa/updatedata', 'Tbjasa::updatedata');
$routes->post('/tbjasa/hapus/(:num)', 'Tbjasa::hapus/$1');
$routes->post('/tbjasa/ajax-load-data', 'Tbjasa::ajaxLoadData');
$routes->get('/tbjasa/cariparent', 'Tbjasa::cariparent');
$routes->post('/tbjasa/replparent', 'Tbjasa::replparent');
$routes->post('/tbjasa/importdata', 'Tbjasa::importdata');

$routes->get('/tasklist_bp', 'Tasklist_bp::index');
$routes->get('/tasklist_bp/table_tasklist_bp', 'Tasklist_bp::table_tasklist_bp');
$routes->get('/tasklist_bp/create', 'Tasklist_bp::create');
$routes->get('/tasklist_bp/formtambah', 'Tasklist_bp::formtambah');
$routes->post('/tasklist_bp/save', 'Tasklist_bp::save');
$routes->post('/tasklist_bp/simpandata', 'Tasklist_bp::simpandata');
$routes->get('/tasklist_bp/detail/(:any)', 'Tasklist_bp::detail/$1');
$routes->post('/tasklist_bp/formdetail', 'Tasklist_bp::formdetail');
$routes->post('/tasklist_bp/formdetailtasklist_bp', 'Tasklist_bp::formdetailtasklist_bp');
$routes->post('/tasklist_bp/formedit', 'Tasklist_bp::formedit');
$routes->post('/tasklist_bp/updatedata', 'Tasklist_bp::updatedata');
$routes->post('/tasklist_bp/hapus/(:num)', 'Tasklist_bp::hapus/$1');
$routes->post('/tasklist_bp/ajax-load-data', 'Tasklist_bp::ajaxLoadData');
$routes->get('tasklist_bp/caridatajasa', 'Tasklist_bp::caridatajasa');
$routes->post('tasklist_bp/repljasa', 'Tasklist_bp::repljasa');
$routes->post('tasklist_bp/simpanjasa', 'Tasklist_bp::simpanjasa');
$routes->get('tasklist_bp/caridataasuransi', 'Tasklist_bp::caridataasuransi');
$routes->post('tasklist_bp/replasuransi', 'Tasklist_bp::replasuransi');
$routes->get('tasklist_bp/caridatatasklist_salin', 'Tasklist_bp::caridatatasklist_salin');
$routes->post('tasklist_bp/repltasklist_salin', 'Tasklist_bp::repltasklist_salin');
$routes->post('tasklist_bp/salindetailtasklist_bpd', 'Tasklist_bp::salindetailtasklist_bpd');
$routes->get('tasklist_bp/caridatatbklpjasa', 'Tasklist_bp::caridatatbklpjasa');
$routes->post('tasklist_bp/repltbklpjasa', 'Tasklist_bp::repltbklpjasa');
$routes->post('tasklist_bp/table_tasklist_bpd', 'Tasklist_bp::table_tasklist_bpd');
$routes->post('tasklist_bp/hapusdetailtasklist_bpd/(:num)', 'Tasklist_bp::hapusdetailtasklist_bpd/$1');


$routes->get('/tbpaket', 'Tbpaket::index');
$routes->get('/tbpaket/table_paket', 'Tbpaket::table_paket');
$routes->get('/tbpaket/create', 'Tbpaket::create');
$routes->get('/tbpaket/formtambah', 'Tbpaket::formtambah');
$routes->post('/tbpaket/save', 'Tbpaket::save');
$routes->post('/tbpaket/simpandata', 'Tbpaket::simpandata');
$routes->get('/tbpaket/detail/(:any)', 'Tbpaket::detail/$1');
$routes->post('/tbpaket/formdetail', 'Tbpaket::formdetail');
$routes->post('/tbpaket/formdetailpaket', 'Tbpaket::formdetailpaket');
$routes->post('/tbpaket/formedit', 'Tbpaket::formedit');
$routes->post('/tbpaket/updatedata', 'Tbpaket::updatedata');
$routes->post('/tbpaket/hapus/(:num)', 'Tbpaket::hapus/$1');
$routes->post('/tbpaket/ajax-load-data', 'Tbpaket::ajaxLoadData');
$routes->get('tbpaket/caridatajasa', 'Tbpaket::caridatajasa');
$routes->post('tbpaket/repljasa', 'Tbpaket::repljasa');
$routes->post('tbpaket/simpanjasa', 'Tbpaket::simpanjasa');
$routes->get('tbpaket/caridatapart', 'Tbpaket::caridatapart');
$routes->post('tbpaket/replpart', 'Tbpaket::replpart');
$routes->post('tbpaket/table_paket_part', 'Tbpaket::table_paket_part');
$routes->post('tbpaket/simpanpart', 'Tbpaket::simpanpart');
$routes->post('tbpaket/simpanbahan', 'Tbpaket::simpanbahan');
$routes->get('tbpaket/caridatabahan', 'Tbpaket::caridatabahan');
$routes->post('tbpaket/replbahan', 'Tbpaket::replbahan');
$routes->get('tbpaket/caridataopl', 'Tbpaket::caridataopl');
$routes->post('tbpaket/replopl', 'Tbpaket::replopl');
$routes->post('tbpaket/simpanopl', 'Tbpaket::simpanopl');
$routes->post('tbpaket/table_paket_bahan', 'Tbpaket::table_paket_bahan');
$routes->post('tbpaket/simpantbpaketdbahan', 'Tbpaket::simpantbpaketdbahan');
$routes->post('tbpaket/table_paket_opl', 'Tbpaket::table_paket_opl');
$routes->post('tbpaket/simpantbpaketdopl', 'Tbpaket::simpantbpaketdopl');
$routes->post('tbpaket/table_paket_jasa', 'Tbpaket::table_paket_jasa');
$routes->post('tbpaket/simpantbpaketdjasa', 'Tbpaket::simpantbpaketdjasa');
$routes->post('tbpaket/summary', 'Tbpaket::summary');
$routes->post('tbpaket/hapusdetailtbpaket/(:num)', 'Tbpaket::hapusdetailtbpaket/$1');

$routes->get('/tbbarang', 'Tbbarang::index');
$routes->get('/tbbarang/table_barang', 'Tbbarang::table_barang');
$routes->get('/tbbarang/create', 'Tbbarang::create');
$routes->get('/tbbarang/formtambah', 'Tbbarang::formtambah');
$routes->get('/tbbarang/formtambahform', 'Tbbarang::formtambahform');
$routes->post('/tbbarang/save', 'Tbbarang::save');
$routes->post('/tbbarang/simpandata', 'Tbbarang::simpandata');
$routes->get('/tbbarang/detail/(:any)', 'Tbbarang::detail/$1');
$routes->post('/tbbarang/formdetail', 'Tbbarang::formdetail');
$routes->post('/tbbarang/formedit', 'Tbbarang::formedit');
$routes->post('/tbbarang/updatedata', 'Tbbarang::updatedata');
$routes->post('/tbbarang/hapus/(:num)', 'Tbbarang::hapus/$1');
$routes->post('/tbbarang/ajax-load-data', 'Tbbarang::ajaxLoadData');
$routes->get('/tbbarang/ambildatatbjnbrg', 'Tbbarang::ambildatatbjnbrg');
$routes->get('/tbbarang/ambildatatbsatuan', 'Tbbarang::ambildatatbsatuan');
$routes->get('/tbbarang/ambildatatbmove', 'Tbbarang::ambildatatbmove');
$routes->get('/tbbarang/ambildatatbdisc', 'Tbbarang::ambildatatbdisc');
$routes->post('/tbbarang/repldiscount', 'Tbbarang::repldiscount');
$routes->get('/tbbarang/tambahtbjnbrg', 'Tbbarang::tambahtbjnbrg');
$routes->get('/tbbarang/tambahtbsatuan', 'Tbbarang::tambahtbsatuan');
$routes->get('/tbbarang/tambahtbmove', 'Tbbarang::tambahtbmove');
$routes->get('/tbbarang/tambahtbdisc', 'Tbbarang::tambahtbdisc');
$routes->get('/tbbarang/tambahtbnegara', 'Tbbarang::tambahtbnegara');
$routes->get('/tbbarang/caridatanegara', 'Tbbarang::caridatanegara');
$routes->post('/tbbarang/replnegara', 'Tbbarang::replnegara');

$routes->get('/tbbahan', 'Tbbahan::index');
$routes->get('/tbbahan/table_bahan', 'Tbbahan::table_bahan');
$routes->get('/tbbahan/create', 'Tbbahan::create');
$routes->get('/tbbahan/formtambah', 'Tbbahan::formtambah');
$routes->get('/tbbahan/formtambahform', 'Tbbahan::formtambahform');
$routes->post('/tbbahan/save', 'Tbbahan::save');
$routes->post('/tbbahan/simpandata', 'Tbbahan::simpandata');
$routes->get('/tbbahan/detail/(:any)', 'Tbbahan::detail/$1');
$routes->post('/tbbahan/formdetail', 'Tbbahan::formdetail');
$routes->post('/tbbahan/formedit', 'Tbbahan::formedit');
$routes->post('/tbbahan/updatedata', 'Tbbahan::updatedata');
$routes->post('/tbbahan/hapus/(:num)', 'Tbbahan::hapus/$1');
$routes->post('/tbbahan/ajax-load-data', 'Tbbahan::ajaxLoadData');
$routes->get('/tbbahan/ambildatatbjnbrg', 'Tbbahan::ambildatatbjnbrg');
$routes->get('/tbbahan/ambildatatbsatuan', 'Tbbahan::ambildatatbsatuan');
$routes->get('/tbbahan/ambildatatbmove', 'Tbbahan::ambildatatbmove');
$routes->get('/tbbahan/ambildatatbdisc', 'Tbbahan::ambildatatbdisc');
$routes->post('/tbbahan/repldiscount', 'Tbbahan::repldiscount');
$routes->get('/tbbahan/tambahtbjnbrg', 'Tbbahan::tambahtbjnbrg');
$routes->get('/tbbahan/tambahtbsatuan', 'Tbbahan::tambahtbsatuan');
$routes->get('/tbbahan/tambahtbmove', 'Tbbahan::tambahtbmove');
$routes->get('/tbbahan/tambahtbdisc', 'Tbbahan::tambahtbdisc');
$routes->get('/tbbahan/tambahtbnegara', 'Tbbahan::tambahtbnegara');
$routes->get('/tbbahan/caridatanegara', 'Tbbahan::caridatanegara');
$routes->post('/tbbahan/replnegara', 'Tbbahan::replnegara');

$routes->get('/tbopl', 'Tbopl::index');
$routes->get('/tbopl/table_opl', 'Tbopl::table_opl');
$routes->get('/tbopl/create', 'Tbopl::create');
$routes->get('/tbopl/formtambah', 'Tbopl::formtambah');
$routes->post('/tbopl/save', 'Tbopl::save');
$routes->post('/tbopl/simpandata', 'Tbopl::simpandata');
$routes->get('/tbopl/detail/(:any)', 'Tbopl::detail/$1');
$routes->post('/tbopl/formdetail', 'Tbopl::formdetail');
$routes->post('/tbopl/formedit', 'Tbopl::formedit');
$routes->post('/tbopl/updatedata', 'Tbopl::updatedata');
$routes->post('/tbopl/hapus/(:num)', 'Tbopl::hapus/$1');
$routes->post('/tbopl/ajax-load-data', 'Tbopl::ajaxLoadData');
$routes->get('/tbopl/tambahtbsupplier', 'Tbopl::tambahtbsupplier');
$routes->get('/tbopl/caridatasupplier', 'Tbopl::caridatasupplier');
$routes->post('/tbopl/replsupplier', 'Tbopl::replsupplier');

$routes->get('/tbsupplier', 'Tbsupplier::index');
$routes->get('/tbsupplier/table_supplier', 'Tbsupplier::table_supplier');
$routes->get('/tbsupplier/create', 'Tbsupplier::create');
$routes->get('/tbsupplier/formtambah', 'Tbsupplier::formtambah');
$routes->post('/tbsupplier/save', 'Tbsupplier::save');
$routes->post('/tbsupplier/simpandata', 'Tbsupplier::simpandata');
$routes->get('/tbsupplier/detail/(:any)', 'Tbsupplier::detail/$1');
$routes->post('/tbsupplier/formdetail', 'Tbsupplier::formdetail');
$routes->post('/tbsupplier/formedit', 'Tbsupplier::formedit');
$routes->post('/tbsupplier/updatedata', 'Tbsupplier::updatedata');
$routes->post('/tbsupplier/hapus/(:num)', 'Tbsupplier::hapus/$1');
$routes->post('/tbsupplier/ajax-load-data', 'Tbsupplier::ajaxLoadData');

$routes->get('/tbasuransi', 'Tbasuransi::index');
$routes->get('/tbasuransi/table_asuransi', 'Tbasuransi::table_asuransi');
$routes->get('/tbasuransi/create', 'Tbasuransi::create');
$routes->get('/tbasuransi/formtambah', 'Tbasuransi::formtambah');
$routes->get('/tbasuransi/formtambahform', 'Tbasuransi::formtambahform');
$routes->post('/tbasuransi/save', 'Tbasuransi::save');
$routes->post('/tbasuransi/simpandata', 'Tbasuransi::simpandata');
$routes->get('/tbasuransi/detail/(:any)', 'Tbasuransi::detail/$1');
$routes->post('/tbasuransi/formdetail', 'Tbasuransi::formdetail');
$routes->post('/tbasuransi/formedit', 'Tbasuransi::formedit');
$routes->post('/tbasuransi/updatedata', 'Tbasuransi::updatedata');
$routes->post('/tbasuransi/hapus/(:num)', 'Tbasuransi::hapus/$1');
$routes->post('/tbasuransi/ajax-load-data', 'Tbasuransi::ajaxLoadData');

$routes->post('/tbjnbrg/simpandata', 'Tbjnbrg::simpandata');
$routes->post('/tbsatuan/simpandata', 'Tbsatuan::simpandata');
$routes->post('/tbmove/simpandata', 'Tbmove::simpandata');
$routes->post('/tbdisc/simpandata', 'Tbdisc::simpandata');
$routes->post('/tbnegara/simpandata', 'Tbnegara::simpandata');

$routes->get('/tbnegara', 'Tbnegara::index');
$routes->get('/tbnegara/table_negara', 'Tbnegara::table_negara');
$routes->get('/tbnegara/create', 'Tbnegara::create');
$routes->get('/tbnegara/formtambah', 'Tbnegara::formtambah');
$routes->get('/tbnegara/formtambahform', 'Tbnegara::formtambahform');
$routes->post('/tbnegara/save', 'Tbnegara::save');
$routes->post('/tbnegara/simpandata', 'Tbnegara::simpandata');
$routes->get('/tbnegara/detail/(:any)', 'Tbnegara::detail/$1');
$routes->post('/tbnegara/formdetail', 'Tbnegara::formdetail');
$routes->post('/tbnegara/formedit', 'Tbnegara::formedit');
$routes->post('/tbnegara/updatedata', 'Tbnegara::updatedata');
$routes->post('/tbnegara/hapus/(:num)', 'Tbnegara::hapus/$1');
$routes->post('/tbnegara/ajax-load-data', 'Tbnegara::ajaxLoadData');

$routes->get('/tbjnbrg', 'Tbjnbrg::index');
$routes->get('/tbjnbrg/table_jnbrg', 'Tbjnbrg::table_jnbrg');
$routes->get('/tbjnbrg/create', 'Tbjnbrg::create');
$routes->get('/tbjnbrg/formtambah', 'Tbjnbrg::formtambah');
$routes->get('/tbjnbrg/formtambahform', 'Tbjnbrg::formtambahform');
$routes->post('/tbjnbrg/save', 'Tbjnbrg::save');
$routes->post('/tbjnbrg/simpandata', 'Tbjnbrg::simpandata');
$routes->get('/tbjnbrg/detail/(:any)', 'Tbjnbrg::detail/$1');
$routes->post('/tbjnbrg/formdetail', 'Tbjnbrg::formdetail');
$routes->post('/tbjnbrg/formedit', 'Tbjnbrg::formedit');
$routes->post('/tbjnbrg/updatedata', 'Tbjnbrg::updatedata');
$routes->post('/tbjnbrg/hapus/(:num)', 'Tbjnbrg::hapus/$1');
$routes->post('/tbjnbrg/ajax-load-data', 'Tbjnbrg::ajaxLoadData');

$routes->get('/tbsatuan', 'Tbsatuan::index');
$routes->get('/tbsatuan/table_satuan', 'Tbsatuan::table_satuan');
$routes->get('/tbsatuan/create', 'Tbsatuan::create');
$routes->get('/tbsatuan/formtambah', 'Tbsatuan::formtambah');
$routes->get('/tbsatuan/formtambahform', 'Tbsatuan::formtambahform');
$routes->post('/tbsatuan/save', 'Tbsatuan::save');
$routes->post('/tbsatuan/simpandata', 'Tbsatuan::simpandata');
$routes->get('/tbsatuan/detail/(:any)', 'Tbsatuan::detail/$1');
$routes->post('/tbsatuan/formdetail', 'Tbsatuan::formdetail');
$routes->post('/tbsatuan/formedit', 'Tbsatuan::formedit');
$routes->post('/tbsatuan/updatedata', 'Tbsatuan::updatedata');
$routes->post('/tbsatuan/hapus/(:num)', 'Tbsatuan::hapus/$1');
$routes->post('/tbsatuan/ajax-load-data', 'Tbsatuan::ajaxLoadData');

$routes->get('/tbmove', 'Tbmove::index');
$routes->get('/tbmove/table_move', 'Tbmove::table_move');
$routes->get('/tbmove/create', 'Tbmove::create');
$routes->get('/tbmove/formtambah', 'Tbmove::formtambah');
$routes->get('/tbmove/formtambahform', 'Tbmove::formtambahform');
$routes->post('/tbmove/save', 'Tbmove::save');
$routes->post('/tbmove/simpandata', 'Tbmove::simpandata');
$routes->get('/tbmove/detail/(:any)', 'Tbmove::detail/$1');
$routes->post('/tbmove/formdetail', 'Tbmove::formdetail');
$routes->post('/tbmove/formedit', 'Tbmove::formedit');
$routes->post('/tbmove/updatedata', 'Tbmove::updatedata');
$routes->post('/tbmove/hapus/(:num)', 'Tbmove::hapus/$1');
$routes->post('/tbmove/ajax-load-data', 'Tbmove::ajaxLoadData');

$routes->get('/tbdisc', 'Tbdisc::index');
$routes->get('/tbdisc/table_disc', 'Tbdisc::table_disc');
$routes->get('/tbdisc/create', 'Tbdisc::create');
$routes->get('/tbdisc/formtambah', 'Tbdisc::formtambah');
$routes->get('/tbdisc/formtambahform', 'Tbdisc::formtambahform');
$routes->post('/tbdisc/save', 'Tbdisc::save');
$routes->post('/tbdisc/simpandata', 'Tbdisc::simpandata');
$routes->get('/tbdisc/detail/(:any)', 'Tbdisc::detail/$1');
$routes->post('/tbdisc/formdetail', 'Tbdisc::formdetail');
$routes->post('/tbdisc/formedit', 'Tbdisc::formedit');
$routes->post('/tbdisc/updatedata', 'Tbdisc::updatedata');
$routes->post('/tbdisc/hapus/(:num)', 'Tbdisc::hapus/$1');
$routes->post('/tbdisc/ajax-load-data', 'Tbdisc::ajaxLoadData');

$routes->get('/tbbank', 'Tbbank::index');
$routes->get('/tbbank/table_bank', 'Tbbank::table_bank');
$routes->get('/tbbank/formtambah', 'Tbbank::formtambah');
$routes->post('/tbbank/simpandata', 'Tbbank::simpandata');
$routes->post('/tbbank/formdetail', 'Tbbank::formdetail');
$routes->post('/tbbank/detail', 'Tbbank::detail');
$routes->post('/tbbank/formedit', 'Tbbank::formedit');
$routes->post('/tbbank/updatedata', 'Tbbank::updatedata');
$routes->post('/tbbank/hapus/(:num)', 'Tbbank::hapus/$1');

$routes->get('/tbklpuser', 'Tbklpuser::index');
$routes->get('/tbklpuser/table_klpuser', 'Tbklpuser::table_klpuser');
$routes->get('/tbklpuser/formtambah', 'Tbklpuser::formtambah');
$routes->post('/tbklpuser/simpandata', 'Tbklpuser::simpandata');
$routes->post('/tbklpuser/formdetail', 'Tbklpuser::formdetail');
$routes->post('/tbklpuser/detail', 'Tbklpuser::detail');
$routes->post('/tbklpuser/formedit', 'Tbklpuser::formedit');
$routes->post('/tbklpuser/updatedata', 'Tbklpuser::updatedata');
$routes->post('/tbklpuser/hapus/(:num)', 'Tbklpuser::hapus/$1');

$routes->get('/tbjenis', 'Tbjenis::index');
$routes->get('/tbjenis/table_jenis', 'Tbjenis::table_jenis');
$routes->get('/tbjenis/formtambah', 'Tbjenis::formtambah');
$routes->post('/tbjenis/simpandata', 'Tbjenis::simpandata');
$routes->post('/tbjenis/formdetail', 'Tbjenis::formdetail');
$routes->post('/tbjenis/detail', 'Tbjenis::detail');
$routes->post('/tbjenis/formedit', 'Tbjenis::formedit');
$routes->post('/tbjenis/updatedata', 'Tbjenis::updatedata');
$routes->post('/tbjenis/hapus/(:num)', 'Tbjenis::hapus/$1');

$routes->get('/tbmerek', 'Tbmerek::index');
$routes->get('/tbmerek/table_merek', 'Tbmerek::table_merek');
$routes->get('/tbmerek/formtambah', 'Tbmerek::formtambah');
$routes->post('/tbmerek/simpandata', 'Tbmerek::simpandata');
$routes->post('/tbmerek/formdetail', 'Tbmerek::formdetail');
$routes->post('/tbmerek/detail', 'Tbmerek::detail');
$routes->post('/tbmerek/formedit', 'Tbmerek::formedit');
$routes->post('/tbmerek/updatedata', 'Tbmerek::updatedata');
$routes->post('/tbmerek/hapus/(:num)', 'Tbmerek::hapus/$1');

$routes->get('/tbmodel', 'Tbmodel::index');
$routes->get('/tbmodel/table_model', 'Tbmodel::table_model');
$routes->get('/tbmodel/formtambah', 'Tbmodel::formtambah');
$routes->post('/tbmodel/simpandata', 'Tbmodel::simpandata');
$routes->post('/tbmodel/formdetail', 'Tbmodel::formdetail');
$routes->post('/tbmodel/detail', 'Tbmodel::detail');
$routes->post('/tbmodel/formedit', 'Tbmodel::formedit');
$routes->post('/tbmodel/updatedata', 'Tbmodel::updatedata');
$routes->post('/tbmodel/hapus/(:num)', 'Tbmodel::hapus/$1');

$routes->get('/tbtipe', 'Tbtipe::index');
$routes->get('/tbtipe/table_tipe', 'Tbtipe::table_tipe');
$routes->get('/tbtipe/formtambah', 'Tbtipe::formtambah');
$routes->post('/tbtipe/simpandata', 'Tbtipe::simpandata');
$routes->post('/tbtipe/formdetail', 'Tbtipe::formdetail');
$routes->post('/tbtipe/detail', 'Tbtipe::detail');
$routes->post('/tbtipe/formedit', 'Tbtipe::formedit');
$routes->post('/tbtipe/updatedata', 'Tbtipe::updatedata');
$routes->post('/tbtipe/hapus/(:num)', 'Tbtipe::hapus/$1');

$routes->get('/tbwarna', 'Tbwarna::index');
$routes->get('/tbwarna/table_warna', 'Tbwarna::table_warna');
$routes->get('/tbwarna/formtambah', 'Tbwarna::formtambah');
$routes->post('/tbwarna/simpandata', 'Tbwarna::simpandata');
$routes->post('/tbwarna/formdetail', 'Tbwarna::formdetail');
$routes->post('/tbwarna/detail', 'Tbwarna::detail');
$routes->post('/tbwarna/formedit', 'Tbwarna::formedit');
$routes->post('/tbwarna/updatedata', 'Tbwarna::updatedata');
$routes->post('/tbwarna/hapus/(:num)', 'Tbwarna::hapus/$1');

$routes->get('/tbmobil', 'Tbmobil::index');
$routes->post('/tbmobil/ajax-load-data', 'Tbmobil::ajaxLoadData');
$routes->get('/tbmobil/table_mobil', 'Tbmobil::table_mobil');
$routes->get('/tbmobil/formtambah', 'Tbmobil::formtambah');
$routes->post('/tbmobil/simpandata', 'Tbmobil::simpandata');
$routes->post('/tbmobil/formdetail', 'Tbmobil::formdetail');
$routes->post('/tbmobil/formdetailmobil', 'Tbcustomer::formdetailmobil');
$routes->post('/tbmobil/detail', 'Tbmobil::detail');
$routes->post('/tbmobil/formedit', 'Tbmobil::formedit');
$routes->post('/tbmobil/updatedata', 'Tbmobil::updatedata');
$routes->post('/tbmobil/hapus/(:num)', 'Tbmobil::hapus/$1');
$routes->get('/tbmobil/filter_merek', 'Tbmobil::filter_merek');
$routes->post('/tbmobil/filter_merek', 'Tbmobil::filter_merek');
$routes->get('/tbmobil/filter_model', 'Tbmobil::filter_model');
$routes->post('/tbmobil/filter_model', 'Tbmobil::filter_model');
$routes->get('/tbmobil/cari_data_pemakai', 'Tbmobil::cari_data_pemakai');
$routes->post('/tbmobil/repl_pemakai', 'Tbmobil::repl_pemakai');
$routes->get('/tbmobil/cari_data_pemilik', 'Tbmobil::cari_data_pemilik');
$routes->post('/tbmobil/repl_pemilik', 'Tbmobil::repl_pemilik');

$routes->get('/tbcustomer', 'Tbcustomer::index');
$routes->get('/tbcustomer/table_customer', 'Tbcustomer::table_customer');
$routes->get('/tbcustomer/formtambah', 'Tbcustomer::formtambah');
$routes->post('/tbcustomer/simpandata', 'Tbcustomer::simpandata');
$routes->post('/tbcustomer/formdetail', 'Tbcustomer::formdetail');
$routes->post('/tbcustomer/detail', 'Tbcustomer::detail');
$routes->post('/tbcustomer/formedit', 'Tbcustomer::formedit');
$routes->post('/tbcustomer/updatedata', 'Tbcustomer::updatedata');
$routes->post('/tbcustomer/hapus/(:num)', 'Tbcustomer::hapus/$1');
$routes->post('/tbcustomer/ajax-load-data', 'Tbcustomer::ajaxLoadData');
$routes->post('/tbcustomer/hapusmobil/(:segment)', 'Tbcustomer::hapusmobil/$1');
$routes->get('/tbcustomer/formdetailmobil', 'Tbcustomer::formdetailmobil');
$routes->post('/tbcustomer/formdetailmobil', 'Tbcustomer::formdetailmobil');
$routes->get('/tbcustomer/cari_nopolisi', 'Tbcustomer::cari_nopolisi');
$routes->post('/tbcustomer/repl_nopolisi', 'Tbcustomer::repl_nopolisi');
$routes->post('/tbcustomer/updatemobil', 'Tbcustomer::updatemobil');
$routes->post('/tbcustomer/table_mobil_customer', 'Tbcustomer::table_mobil_customer');

$routes->get('/tbmekanik', 'Tbmekanik::index');
$routes->get('/tbmekanik/table_mekanik', 'Tbmekanik::table_mekanik');
$routes->get('/tbmekanik/formtambah', 'Tbmekanik::formtambah');
$routes->post('/tbmekanik/simpandata', 'Tbmekanik::simpandata');
$routes->post('/tbmekanik/formdetail', 'Tbmekanik::formdetail');
$routes->post('/tbmekanik/detail', 'Tbmekanik::detail');
$routes->post('/tbmekanik/formedit', 'Tbmekanik::formedit');
$routes->post('/tbmekanik/updatedata', 'Tbmekanik::updatedata');
$routes->post('/tbmekanik/hapus/(:num)', 'Tbmekanik::hapus/$1');
$routes->post('/tbmekanik/ajax-load-data', 'Tbmekanik::ajaxLoadData');
$routes->post('/tbmekanik/table_mobil_mekanik', 'Tbmekanik::table_mobil_mekanik');

$routes->get('/estimasi_bp', 'Estimasi_bp::index');
$routes->post('/estimasi_bp', 'Estimasi_bp::index');
$routes->post('/estimasi_bp/ajax-load-data-tbmobil', 'Estimasi_bp::ajaxLoadDataTbMobil');
$routes->get('/estimasi_bp/table_mobil', 'Estimasi_bp::table_mobil');
$routes->post('estimasi_bp/detail_mobil', 'Estimasi_bp::detail_mobil');
$routes->post('estimasi_bp/table_estimasi_bp', 'Estimasi_bp::table_estimasi_bp');
$routes->post('estimasi_bp/table_wo_bp', 'Estimasi_bp::table_wo_bp');
$routes->post('estimasi_bp/modalestimasi_bp', 'Estimasi_bp::modalestimasi_bp');
$routes->post('/estimasi_bp/hapusestimasi_bp/(:num)', 'Estimasi_bp::hapusestimasi_bp/$1');
$routes->post('/estimasi_bp/cancel_estimasi_bp/(:num)', 'Estimasi_bp::cancel_estimasi_bp/$1');
$routes->post('estimasi_bp/detailestimasi_bp', 'Estimasi_bp::detailestimasi_bp');
$routes->post('estimasi_bp/tambahestimasi_bp', 'Estimasi_bp::tambahestimasi_bp');
$routes->post('estimasi_bp/simpanestimasi_bp', 'Estimasi_bp::simpanestimasi_bp');
$routes->post('estimasi_bp/editestimasi_bp', 'Estimasi_bp::editestimasi_bp');
$routes->post('estimasi_bp/updateestimasi_bp', 'Estimasi_bp::updateestimasi_bp');
$routes->post('estimasi_bp/inputestimasi_bpd', 'Estimasi_bp::inputestimasi_bpd');
$routes->get('estimasi_bp/caridatasa', 'Estimasi_bp::caridatasa');
$routes->post('estimasi_bp/replsa', 'Estimasi_bp::replsa');
$routes->get('estimasi_bp/caridatamekanik', 'Estimasi_bp::caridatamekanik');
$routes->post('estimasi_bp/replmekanik', 'Estimasi_bp::replmekanik');
$routes->get('estimasi_bp/caridataasuransi', 'Estimasi_bp::caridataasuransi');
$routes->post('estimasi_bp/replasuransi', 'Estimasi_bp::replasuransi');
$routes->get('estimasi_bp/caridatapart', 'Estimasi_bp::caridatapart');
$routes->post('estimasi_bp/replpart', 'Estimasi_bp::replpart');
$routes->post('estimasi_bp/table_estimasi_bp_part', 'Estimasi_bp::table_estimasi_bp_part');
$routes->post('estimasi_bp/simpanestimasi_bpd', 'Estimasi_bp::simpanestimasi_bpd');
$routes->post('estimasi_bp/simpanpart', 'Estimasi_bp::simpanpart');
$routes->post('estimasi_bp/simpanbahan', 'Estimasi_bp::simpanbahan');
$routes->get('estimasi_bp/caridatabahan', 'Estimasi_bp::caridatabahan');
$routes->post('estimasi_bp/replbahan', 'Estimasi_bp::replbahan');
$routes->get('estimasi_bp/caridataopl', 'Estimasi_bp::caridataopl');
$routes->post('estimasi_bp/replopl', 'Estimasi_bp::replopl');
$routes->post('estimasi_bp/simpanopl', 'Estimasi_bp::simpanopl');
$routes->get('estimasi_bp/caridatajasa', 'Estimasi_bp::caridatajasa');
$routes->post('estimasi_bp/caridatatasklist', 'Estimasi_bp::caridatatasklist');
$routes->post('estimasi_bp/repljasa', 'Estimasi_bp::repljasa');
$routes->post('estimasi_bp/simpanjasa', 'Estimasi_bp::simpanjasa');
$routes->post('estimasi_bp/table_estimasi_bp_bahan', 'Estimasi_bp::table_estimasi_bp_bahan');
$routes->post('estimasi_bp/simpanestimasi_bpdbahan', 'Estimasi_bp::simpanestimasi_bpdbahan');
$routes->post('estimasi_bp/table_estimasi_bp_opl', 'Estimasi_bp::table_estimasi_bp_opl');
$routes->post('estimasi_bp/simpanestimasi_bpdopl', 'Estimasi_bp::simpanestimasi_bpdopl');
$routes->post('estimasi_bp/table_estimasi_bp_jasa', 'Estimasi_bp::table_estimasi_bp_jasa');
$routes->post('estimasi_bp/simpanestimasi_bpdjasa', 'Estimasi_bp::simpanestimasi_bpdjasa');
$routes->post('estimasi_bp/summary', 'Estimasi_bp::summary');
$routes->post('estimasi_bp/hapusdetailestimasi_bp/(:num)', 'Estimasi_bp::hapusdetailestimasi_bp/$1');
$routes->post('estimasi_bp/editdetailestimasi_bp/(:num)', 'Estimasi_bp::editdetailestimasi_bp/$1');
$routes->post('/estimasi_bp/prosesestimasi_bp', 'Estimasi_bp::prosesestimasi_bp');
$routes->post('/estimasi_bp/unprosesestimasi_bp', 'Estimasi_bp::unprosesestimasi_bp');
$routes->post('estimasi_bp/simpan_batal_estimasi', 'Estimasi_bp::simpan_batal_estimasi');
$routes->get('estimasi_bp/cetakestimasi_bp/(:num)', 'Estimasi_bp::cetakestimasi_bp/$1');
$routes->post('estimasi_bp/simpankewo', 'Estimasi_bp::simpankewo');
$routes->post('/estimasi_bp/hapus_wo_bp/(:num)', 'Estimasi_bp::hapus_wo_bp/$1');
$routes->post('/estimasi_bp/cancel_wo_bp/(:num)', 'Estimasi_bp::cancel_wo_bp/$1');
$routes->post('estimasi_bp/edit_wo_bp', 'Estimasi_bp::edit_wo_bp');
$routes->post('estimasi_bp/update_wo_bp', 'Estimasi_bp::update_wo_bp');
$routes->post('estimasi_bp/detail_wo_bp', 'Estimasi_bp::detail_wo_bp');
$routes->post('estimasi_bp/summary_wo', 'Estimasi_bp::summary_wo');
$routes->post('estimasi_bp/table_wo_bp_jasa', 'Estimasi_bp::table_wo_bp_jasa');
$routes->post('estimasi_bp/table_wo_bp_part', 'Estimasi_bp::table_wo_bp_part');
$routes->post('estimasi_bp/table_wo_bp_opl', 'Estimasi_bp::table_wo_bp_opl');
$routes->post('estimasi_bp/table_wo_bp_bahan', 'Estimasi_bp::table_wo_bp_bahan');
$routes->post('estimasi_bp/batal_wo', 'Estimasi_bp::batal_wo');
$routes->post('estimasi_bp/simpan_batal_wo', 'Estimasi_bp::simpan_batal_wo');
$routes->post('estimasi_bp/input_wo_bpd', 'Estimasi_bp::input_wo_bpd');
$routes->post('estimasi_bp/simpan_jasa_wo', 'Estimasi_bp::simpan_jasa_wo');
$routes->post('estimasi_bp/simpan_part_wo', 'Estimasi_bp::simpan_part_wo');
$routes->post('estimasi_bp/simpan_bahan_wo', 'Estimasi_bp::simpan_bahan_wo');
$routes->post('estimasi_bp/simpan_opl_wo', 'Estimasi_bp::simpan_opl_wo');
$routes->post('estimasi_bp/hapusdetailwo_bp/(:num)', 'Estimasi_bp::hapusdetailwo_bp/$1');
$routes->post('estimasi_bp/proses_wo_bp', 'Estimasi_bp::proses_wo_bp');
$routes->post('estimasi_bp/unproses_wo_bp', 'Estimasi_bp::unproses_wo_bp');
$routes->post('estimasi_bp/editdetailwo_bp/(:num)', 'Estimasi_bp::editdetailwo_bp/$1');
$routes->post('estimasi_bp/simpanpart_wo', 'Estimasi_bp::simpanpart_wo');
$routes->post('estimasi_bp/simpanbahan_wo', 'Estimasi_bp::simpanbahan_wo');
$routes->post('estimasi_bp/simpanjasa_wo', 'Estimasi_bp::simpanjasa_wo');
$routes->post('estimasi_bp/simpanopl_wo', 'Estimasi_bp::simpanopl_wo');
$routes->post('estimasi_bp/hitung_summary_wo', 'Estimasi_bp::hitung_summary_wo');
$routes->post('estimasi_bp/tampildetailjasawo/(:num)', 'Estimasi_bp::tampildetailjasawo/$1');
$routes->post('estimasi_bp/tampildetailpartwo/(:num)', 'Estimasi_bp::tampildetailpartwo/$1');
$routes->post('estimasi_bp/tampildetailbahanwo/(:num)', 'Estimasi_bp::tampildetailbahanwo/$1');
$routes->post('estimasi_bp/tampildetailoplwo/(:num)', 'Estimasi_bp::tampildetailoplwo/$1');
$routes->get('estimasi_bp/cetakwo_bp/(:num)', 'Estimasi_bp::cetakwo_bp/$1');

$routes->get('/part_bp', 'Part_bp::index');
$routes->post('/part_bp/ajax-load-data', 'Part_bp::ajaxLoadData');
$routes->get('/part_bp/table_wo_bp', 'Part_bp::table_wo_bp');
$routes->post('/part_bp/table_part_bp', 'Part_bp::table_part_bp');
$routes->post('/part_bp/input_part_bp', 'Part_bp::input_part_bp');
$routes->post('/part_bp/close_part_bp', 'Part_bp::close_part_bp');
$routes->post('/part_bp/unclose_part_bp', 'Part_bp::unclose_part_bp');

$routes->get('/bahan_bp', 'Bahan_bp::index');
$routes->post('/bahan_bp/ajax-load-data', 'Bahan_bp::ajaxLoadData');
$routes->get('/bahan_bp/table_wo_bp', 'Bahan_bp::table_wo_bp');
$routes->post('/bahan_bp/table_bahan_bp', 'Bahan_bp::table_bahan_bp');
$routes->post('/bahan_bp/input_bahan_bp', 'Bahan_bp::input_bahan_bp');
$routes->post('/bahan_bp/close_bahan_bp', 'Bahan_bp::close_bahan_bp');
$routes->post('/bahan_bp/unclose_bahan_bp', 'Bahan_bp::unclose_bahan_bp');

$routes->get('/opl_bp', 'Opl_bp::index');
$routes->post('/opl_bp/ajax-load-data', 'Opl_bp::ajaxLoadData');
$routes->get('/opl_bp/table_wo_bp', 'Opl_bp::table_wo_bp');
$routes->post('/opl_bp/table_opl_bp', 'Opl_bp::table_opl_bp');
$routes->post('/opl_bp/input_opl_bp', 'Opl_bp::input_opl_bp');
$routes->post('/opl_bp/close_opl_bp', 'Opl_bp::close_opl_bp');
$routes->post('/opl_bp/unclose_opl_bp', 'Opl_bp::unclose_opl_bp');

$routes->get('/close_wo_bp', 'Close_wo_bp::index');
$routes->post('/close_wo_bp/ajax-load-data', 'Close_wo_bp::ajaxLoadData');
$routes->get('/close_wo_bp/table_wo_bp', 'Close_wo_bp::table_wo_bp');
$routes->post('close_wo_bp/input_wo_bpd', 'Close_wo_bp::input_wo_bpd');
$routes->post('/close_wo_bp/table_wo_bp_jasa', 'Close_wo_bp::table_wo_bp_jasa');
// $routes->post('close_wo_bp/caridatatasklist', 'Close_wo_bp::caridatatasklist');
$routes->post('/close_wo_bp/table_wo_bp_part', 'Close_wo_bp::table_wo_bp_part');
$routes->post('/close_wo_bp/table_wo_bp_bahan', 'Close_wo_bp::table_wo_bp_bahan');
$routes->post('/close_wo_bp/table_wo_bp_opl', 'Close_wo_bp::table_wo_bp_opl');
$routes->post('/close_wo_bp/summary_wo_bp', 'Close_wo_bp::summary_wo_bp');
$routes->post('/close_wo_bp/close_wo_bp', 'Close_wo_bp::close_wo_bp');
$routes->post('/close_wo_bp/unclose_wo_bp', 'Close_wo_bp::unclose_wo_bp');

$routes->get('/close_faktur_bp', 'Close_faktur_bp::index');
// $routes->post('/close_faktur_bp', 'Close_faktur_bp::index');
$routes->post('/close_faktur_bp/ajax-load-data', 'Close_faktur_bp::ajaxLoadData');
$routes->get('/close_faktur_bp/table_faktur_bp', 'Close_faktur_bp::table_faktur_bp');
$routes->post('/close_faktur_bp/formdetail', 'Close_faktur_bp::formdetail');
// $routes->post('/close_faktur_bp/detail_faktur_bp', 'Close_faktur_bp::detail_faktur_bp');
$routes->get('/close_faktur_bp/formtambah', 'Close_faktur_bp::formtambah');
$routes->get('/close_faktur_bp/caridatawo', 'Close_faktur_bp::caridatawo');
$routes->post('/close_faktur_bp/replwo', 'Close_faktur_bp::replwo');
$routes->post('/close_faktur_bp/simpanclose_faktur_bp', 'Close_faktur_bp::simpanclose_faktur_bp');
$routes->post('close_faktur_bp/input_faktur_bpd', 'Close_faktur_bp::input_faktur_bpd');
$routes->post('/close_faktur_bp/table_faktur_bp_jasa', 'Close_faktur_bp::table_faktur_bp_jasa');
// $routes->post('close_faktur_bp/caridatatasklist', 'Close_faktur_bp::caridatatasklist');
$routes->post('/close_faktur_bp/table_faktur_bp_part', 'Close_faktur_bp::table_faktur_bp_part');
$routes->post('/close_faktur_bp/table_faktur_bp_bahan', 'Close_faktur_bp::table_faktur_bp_bahan');
$routes->post('/close_faktur_bp/table_faktur_bp_opl', 'Close_faktur_bp::table_faktur_bp_opl');
$routes->post('/close_faktur_bp/summary_faktur_bp', 'Close_faktur_bp::summary_faktur_bp');
$routes->post('/close_faktur_bp/close_faktur_bp', 'Close_faktur_bp::close_faktur_bp');
$routes->post('/close_faktur_bp/unclose_faktur_bp', 'Close_faktur_bp::unclose_faktur_bp');
$routes->get('close_faktur_bp/cetakfaktur_bp/(:num)', 'Close_faktur_bp::cetakfaktur_bp/$1');

$routes->get('/estimasi', 'Estimasi::index');
$routes->post('/estimasi', 'Estimasi::index');
$routes->post('/estimasi/ajax-load-data-tbmobil', 'Estimasi::ajaxLoadDataTbMobil');
$routes->get('/estimasi/table_mobil', 'Estimasi::table_mobil');
$routes->post('estimasi/detail_mobil', 'Estimasi::detail_mobil');
$routes->post('estimasi/table_estimasi', 'Estimasi::table_estimasi');
$routes->post('estimasi/modalestimasi', 'Estimasi::modalestimasi');
$routes->post('/estimasi/hapusestimasi/(:num)', 'Estimasi::hapusestimasi/$1');
$routes->post('estimasi/detailestimasi', 'Estimasi::detailestimasi');
$routes->post('estimasi/tambahestimasi', 'Estimasi::tambahestimasi');
$routes->post('estimasi/simpanestimasi', 'Estimasi::simpanestimasi');
$routes->post('estimasi/editestimasi', 'Estimasi::editestimasi');
$routes->post('estimasi/updateestimasi', 'Estimasi::updateestimasi');
$routes->post('estimasi/inputestimasid', 'Estimasi::inputestimasid');
$routes->get('estimasi/caridatasa', 'Estimasi::caridatasa');
$routes->post('estimasi/replsa', 'Estimasi::replsa');
$routes->get('estimasi/caridataasuransi', 'Estimasi::caridataasuransi');
$routes->post('estimasi/replasuransi', 'Estimasi::replasuransi');
$routes->get('estimasi/caridatapart', 'Estimasi::caridatapart');
$routes->post('estimasi/replpart', 'Estimasi::replpart');
$routes->post('estimasi/table_estimasi_part', 'Estimasi::table_estimasi_part');
$routes->post('estimasi/simpanestimasid', 'Estimasi::simpanestimasid');
$routes->post('estimasi/simpanbahan', 'Estimasi::simpanbahan');
$routes->get('estimasi/caridatabahan', 'Estimasi::caridatabahan');
$routes->post('estimasi/replbahan', 'Estimasi::replbahan');
$routes->get('estimasi/caridataopl', 'Estimasi::caridataopl');
$routes->post('estimasi/replopl', 'Estimasi::replopl');
$routes->post('estimasi/simpanopl', 'Estimasi::simpanopl');
$routes->get('estimasi/caridatajasa', 'Estimasi::caridatajasa');
$routes->post('estimasi/repljasa', 'Estimasi::repljasa');
$routes->post('estimasi/simpanjasa', 'Estimasi::simpanjasa');
$routes->post('estimasi/table_estimasi_bahan', 'Estimasi::table_estimasi_bahan');
$routes->post('estimasi/simpanestimasidbahan', 'Estimasi::simpanestimasidbahan');
$routes->post('estimasi/table_estimasi_opl', 'Estimasi::table_estimasi_opl');
$routes->post('estimasi/simpanestimasidopl', 'Estimasi::simpanestimasidopl');
$routes->post('estimasi/table_estimasi_jasa', 'Estimasi::table_estimasi_jasa');
$routes->post('estimasi/simpanestimasidjasa', 'Estimasi::simpanestimasidjasa');
$routes->post('estimasi/summary', 'Estimasi::summary');
$routes->post('estimasi/hapusdetailestimasi/(:num)', 'Estimasi::hapusdetailestimasi/$1');
$routes->post('/estimasi/prosesestimasi', 'Estimasi::prosesestimasi');
$routes->post('/estimasi/unprosesestimasi', 'Estimasi::unprosesestimasi');
$routes->get('estimasi/cetakestimasi/(:num)', 'Estimasi::cetakestimasi/$1');

$routes->post('/estimasi/hapusestimasi/(:num)', 'Estimasi::hapusestimasi/$1');

$routes->get('/wo', 'Wo::index');
$routes->post('/wo/table_wo', 'Wo::table_wo');
$routes->get('/wo/formtambah', 'Wo::formtambah');
$routes->post('/wo/simpandata', 'Wo::simpandata');
$routes->post('/wo/formdetail', 'Wo::formdetail');
$routes->post('/wo/detail', 'Wo::detail');
$routes->post('/wo/formedit', 'Wo::formedit');
$routes->post('/wo/updatedata', 'Wo::updatedata');
$routes->post('/wo/hapus/(:num)', 'Wo::hapus/$1');
$routes->post('/wo/hapusestimasi/(:num)', 'Wo::hapusestimasi/$1');
$routes->post('/wo/hapuswo/(:num)', 'Wo::hapuswo/$1');
$routes->post('/wo/ajax-load-data', 'Wo::ajaxLoadData');
$routes->post('/wo/hapusmobil/(:segment)', 'Wo::hapusmobil/$1');
$routes->get('/wo/formdetailmobil', 'Wo::formdetailmobil');
$routes->post('/wo/formdetailmobil', 'Wo::formdetailmobil');
$routes->get('/wo/cari_nopolisi', 'Wo::cari_nopolisi');
$routes->post('/wo/repl_nopolisi', 'Wo::repl_nopolisi');
$routes->post('/wo/updatemobil', 'Wo::updatemobil');
$routes->post('/wo/table_mobil_customer', 'Wo::table_mobil_customer');
$routes->get('/wo/cari_data_nopolisi', 'Wo::cari_data_nopolisi');
$routes->post('/wo/repl_nopolisi', 'Wo::repl_nopolisi');
$routes->get('/wo/table_mobil', 'Wo::table_mobil');
$routes->post('/wo/table_estimasi', 'Wo::table_estimasi');
$routes->get('/wo/formmobil', 'Wo::formmobil');
$routes->get('/wo/modalwo', 'Wo::modalwo');
$routes->post('/wo/modalestimasi', 'Wo::modalestimasi');
$routes->post('/wo/updatedatamobil', 'Wo::updatedatamobil');
$routes->post('/tbmobil/simpanwo', 'Wo::simpanwo');
$routes->post('/wo/simpanwo', 'Wo::simpanwo');
$routes->post('wo/tambahestimasi', 'Wo::tambahestimasi');
$routes->post('wo/detailestimasi', 'Wo::detailestimasi');
$routes->post('wo/tambahwo', 'Wo::tambahwo');
$routes->post('/wo/simpanestimasi', 'Wo::simpanestimasi');
$routes->get('/wo/table_wo_part', 'Wo::table_wo_part');
$routes->get('/wo/tambah_wo_part', 'Wo::tambah_wo_part');
$routes->post('/wo/hapus_wo_part', 'Wo::hapus_wo_part');
// $routes->post('/wo/hapus_wo_part/(:num)', 'Wo::hapus_wo_part/$1');
$routes->post('/wo/hitung_wo_part', 'Wo::hitung_wo_part');

$routes->get('/tbsales', 'Tbsales::index');
$routes->get('/tbsales/table_sales', 'Tbsales::table_sales');
$routes->get('/tbsales/create', 'Tbsales::create');
$routes->get('/tbsales/formtambah', 'Tbsales::formtambah');
$routes->post('/tbsales/save', 'Tbsales::save');
$routes->post('/tbsales/simpandata', 'Tbsales::simpandata');
$routes->get('/tbsales/detail/(:any)', 'Tbsales::detail/$1');
$routes->post('/tbsales/formdetail', 'Tbsales::formdetail');
$routes->post('/tbsales/formedit', 'Tbsales::formedit');
$routes->post('/tbsales/updatedata', 'Tbsales::updatedata');
$routes->post('/tbsales/hapus/(:num)', 'Tbsales::hapus/$1');
$routes->post('/tbsales/ajax-load-data', 'Tbsales::ajaxLoadData');

$routes->get('/tbleasing', 'Tbleasing::index');
$routes->get('/tbleasing/table_leasing', 'Tbleasing::table_leasing');
$routes->get('/tbleasing/create', 'Tbleasing::create');
$routes->get('/tbleasing/formtambah', 'Tbleasing::formtambah');
$routes->post('/tbleasing/save', 'Tbleasing::save');
$routes->post('/tbleasing/simpandata', 'Tbleasing::simpandata');
$routes->get('/tbleasing/detail/(:any)', 'Tbleasing::detail/$1');
$routes->post('/tbleasing/formdetail', 'Tbleasing::formdetail');
$routes->post('/tbleasing/formedit', 'Tbleasing::formedit');
$routes->post('/tbleasing/updatedata', 'Tbleasing::updatedata');
$routes->post('/tbleasing/hapus/(:num)', 'Tbleasing::hapus/$1');
$routes->post('/tbleasing/ajax-load-data', 'Tbleasing::ajaxLoadData');

$routes->get('/memombr', 'Memombr::index');
$routes->get('/memombr/table_memombr', 'Memombr::table_memombr');
$routes->post('/memombr/ajax-load-data', 'Memombr::ajaxLoadData');
$routes->get('/memombr/formtambah', 'Memombr::formtambah');
$routes->post('/memombr/simpandata', 'Memombr::simpandata');
$routes->post('/memombr/formdetail', 'Memombr::formdetail');
$routes->post('/memombr/detail', 'Memombr::detail');
$routes->post('/memombr/formedit', 'Memombr::formedit');
$routes->post('/memombr/updatedata', 'Memombr::updatedata');
$routes->post('/memombr/hapus/(:num)', 'Memombr::hapus/$1');
$routes->get('/memombr/cari_data_kreditur', 'Memombr::cari_data_kreditur');
$routes->post('/memombr/repl_kreditur', 'Memombr::repl_kreditur');
$routes->get('/memombr/cari_data_asuransi', 'Memombr::cari_data_asuransi');
$routes->post('/memombr/repl_asuransi', 'Memombr::repl_asuransi');
$routes->get('/memombr/cari_data_sales', 'Memombr::cari_data_sales');
$routes->post('/memombr/repl_sales', 'Memombr::repl_sales');
$routes->get('/memombr/cari_data_spv', 'Memombr::cari_data_spv');
$routes->post('/memombr/repl_spv', 'Memombr::repl_spv');
$routes->get('/memombr/cari_data_mgr', 'Memombr::cari_data_mgr');
$routes->post('/memombr/repl_mgr', 'Memombr::repl_mgr');
$routes->get('/memombr/cari_data_customer', 'Memombr::cari_data_customer');
$routes->post('/memombr/repl_customer', 'Memombr::repl_customer');
$routes->get('/memombr/cari_data_customer_stnk', 'Memombr::cari_data_customer_stnk');
$routes->post('/memombr/repl_customer_stnk', 'Memombr::repl_customer_stnk');
$routes->post('/memombr/proses/(:num)', 'Memombr::proses/$1');
$routes->post('/memombr/unproses/(:num)', 'Memombr::unproses/$1');
$routes->post('/memombr/tambahjual', 'Memombr::tambahjual');
$routes->post('/memombr/simpanjual', 'Memombr::simpanjual');
$routes->post('/memombr/table_memombrd', 'Memombr::table_memombrd');
$routes->post('/memombr/hapusmemombrd/(:num)', 'Memombr::hapusmemombrd/$1');
$routes->post('/memombr/prosesmemombr', 'Memombr::prosesmemombr');
$routes->post('/memombr/unprosesmemombr', 'Memombr::unprosesmemombr');
$routes->get('memombr/cetakmemombr/(:num)', 'Memombr::cetakmemombr/$1');

// $routes->post('rmemombr', 'Memombr::rmemombr');
$routes->get('rmemombr', 'Memombr::rmemombr');
$routes->post('/memombr/table_rmemombr', 'Memombr::table_rmemombr');
// $routes->post('/memombr/cetakrmemombr', 'Memombr::cetakrmemombr');
// $routes->get('/memombr/cetakrmemombr', 'Memombr::cetakrmemombr');

// $routes->post('rpengajuandiscount', 'Pengajuandiscount::rpengajuandiscount');
$routes->get('rpengajuandiscount', 'Pengajuandiscount::rpengajuandiscount');
$routes->post('/pengajuandiscount/table_rpengajuandiscount', 'Pengajuandiscount::table_rpengajuandiscount');
// $routes->post('/pengajuandiscount/cetakrpengajuandiscount', 'Pengajuandiscount::cetakrpengajuandiscount');
// $routes->get('/pengajuandiscount/cetakrpengajuandiscount', 'Pengajuandiscount::cetakrpengajuandiscount');

// $routes->post('rmohfaktur', 'Mohfaktur::rmohfaktur');
$routes->get('rmohfaktur', 'Mohfaktur::rmohfaktur');
$routes->post('/mohfaktur/table_rmohfaktur', 'Mohfaktur::table_rmohfaktur');
// $routes->post('/mohfaktur/cetakrmohfaktur', 'Mohfaktur::cetakrmohfaktur');
// $routes->get('/mohfaktur/cetakrmohfaktur', 'Mohfaktur::cetakrmohfaktur');

$routes->get('rpenerimaankasir', 'penerimaankasir::rpenerimaankasir');
$routes->post('/penerimaankasir/table_rpenerimaankasir', 'penerimaankasir::table_rpenerimaankasir');

$routes->get('/pengajuandiscount', 'Pengajuandiscount::index');
$routes->get('/pengajuandiscount/table_pengajuandiscount', 'Pengajuandiscount::table_pengajuandiscount');
$routes->post('/pengajuandiscount/ajax-load-data', 'Pengajuandiscount::ajaxLoadData');
$routes->get('/pengajuandiscount/formtambah', 'Pengajuandiscount::formtambah');
$routes->post('/pengajuandiscount/simpandata', 'Pengajuandiscount::simpandata');
$routes->post('/pengajuandiscount/formdetail', 'Pengajuandiscount::formdetail');
$routes->post('/pengajuandiscount/detail', 'Pengajuandiscount::detail');
$routes->post('/pengajuandiscount/formedit', 'Pengajuandiscount::formedit');
$routes->post('/pengajuandiscount/updatedata', 'Pengajuandiscount::updatedata');
$routes->post('/pengajuandiscount/hapus/(:num)', 'Pengajuandiscount::hapus/$1');
$routes->get('/pengajuandiscount/cari_data_memo', 'Pengajuandiscount::cari_data_memo');
$routes->post('/pengajuandiscount/repl_memo', 'Pengajuandiscount::repl_memo');
$routes->post('/pengajuandiscount/proses/(:num)', 'Pengajuandiscount::proses/$1');
$routes->post('/pengajuandiscount/unproses/(:num)', 'Pengajuandiscount::unproses/$1');
$routes->get('pengajuandiscount/cetakpengajuandiscount/(:num)', 'Pengajuandiscount::cetakpengajuandiscount/$1');
$routes->post('pengajuandiscount/approv_spv/(:num)', 'Pengajuandiscount::approv_spv/$1');
$routes->post('pengajuandiscount/batalapprov_spv/(:num)', 'Pengajuandiscount::batalapprov_spv/$1');
$routes->post('pengajuandiscount/approv_sm/(:num)', 'Pengajuandiscount::approv_sm/$1');
$routes->post('pengajuandiscount/batalapprov_sm/(:num)', 'Pengajuandiscount::batalapprov_sm/$1');
$routes->post('/pengajuandiscount/formapprov_spv', 'Pengajuandiscount::formapprov_spv');
$routes->post('/pengajuandiscount/simpanapprov_spv', 'Pengajuandiscount::simpanapprov_spv');
$routes->post('/pengajuandiscount/formapprov_sm', 'Pengajuandiscount::formapprov_sm');
$routes->post('/pengajuandiscount/simpanapprov_sm', 'Pengajuandiscount::simpanapprov_sm');
$routes->post('/pengajuandiscount/formapprov_dir', 'Pengajuandiscount::formapprov_dir');
$routes->post('/pengajuandiscount/simpanapprov_dir', 'Pengajuandiscount::simpanapprov_dir');

$routes->get('/mohfaktur', 'Mohfaktur::index');
$routes->get('/mohfaktur/table_mohfaktur', 'Mohfaktur::table_mohfaktur');
$routes->post('/mohfaktur/ajax-load-data', 'Mohfaktur::ajaxLoadData');
$routes->get('/mohfaktur/formtambah', 'Mohfaktur::formtambah');
$routes->post('/mohfaktur/simpandata', 'Mohfaktur::simpandata');
$routes->post('/mohfaktur/formdetail', 'Mohfaktur::formdetail');
$routes->post('/mohfaktur/detail', 'Mohfaktur::detail');
$routes->post('/mohfaktur/formedit', 'Mohfaktur::formedit');
$routes->post('/mohfaktur/updatedata', 'Mohfaktur::updatedata');
$routes->post('/mohfaktur/hapus/(:num)', 'Mohfaktur::hapus/$1');
$routes->get('/mohfaktur/cari_data_memo', 'Mohfaktur::cari_data_memo');
$routes->post('/mohfaktur/repl_memo', 'Mohfaktur::repl_memo');
$routes->post('/mohfaktur/proses/(:num)', 'Mohfaktur::proses/$1');
$routes->post('/mohfaktur/unproses/(:num)', 'Mohfaktur::unproses/$1');
$routes->post('mohfaktur/approv_spv/(:num)', 'Mohfaktur::approv_spv/$1');
$routes->post('mohfaktur/batalapprov_spv/(:num)', 'Mohfaktur::batalapprov_spv/$1');
$routes->post('mohfaktur/approv_sm/(:num)', 'Mohfaktur::approv_sm/$1');
$routes->post('mohfaktur/batalapprov_sm/(:num)', 'Mohfaktur::batalapprov_sm/$1');
$routes->post('/mohfaktur/formapprov_spv', 'Mohfaktur::formapprov_spv');
$routes->post('/mohfaktur/simpanapprov_spv', 'Mohfaktur::simpanapprov_spv');
$routes->post('/mohfaktur/formapprov_sm', 'Mohfaktur::formapprov_sm');
$routes->post('/mohfaktur/simpanapprov_sm', 'Mohfaktur::simpanapprov_sm');
$routes->post('/mohfaktur/formapprov_dir', 'Mohfaktur::formapprov_dir');
$routes->post('/mohfaktur/simpanapprov_dir', 'Mohfaktur::simpanapprov_dir');
$routes->post('/mohfaktur/repl_sales', 'Mohfaktur::repl_sales');
$routes->post('/mohfaktur/repl_model', 'Mohfaktur::repl_model');
$routes->post('/mohfaktur/repl_sm', 'Mohfaktur::repl_sm');
$routes->post('/mohfaktur/repl_nmstnk', 'Mohfaktur::repl_nmstnk');
$routes->post('/mohfaktur/proses', 'Mohfaktur::proses');
$routes->post('/mohfaktur/unproses', 'Mohfaktur::unproses');
$routes->get('mohfaktur/cetakmohfaktur/(:num)', 'Mohfaktur::cetakmohfaktur/$1');

$routes->get('/penerimaankasir', 'Penerimaankasir::index');
$routes->get('/penerimaankasir/table_penerimaankasir', 'Penerimaankasir::table_penerimaankasir');
$routes->post('/penerimaankasir/ajax-load-data', 'Penerimaankasir::ajaxLoadData');
$routes->get('/penerimaankasir/formtambah', 'Penerimaankasir::formtambah');
$routes->post('/penerimaankasir/simpandata', 'Penerimaankasir::simpandata');
$routes->post('/penerimaankasir/formdetail', 'Penerimaankasir::formdetail');
$routes->post('/penerimaankasir/detail', 'Penerimaankasir::detail');
$routes->post('/penerimaankasir/formedit', 'Penerimaankasir::formedit');
$routes->post('/penerimaankasir/updatedata', 'Penerimaankasir::updatedata');
$routes->post('/penerimaankasir/hapus/(:num)', 'Penerimaankasir::hapus/$1');
$routes->get('/penerimaankasir/cari_data_memo', 'Penerimaankasir::cari_data_memo');
$routes->post('/penerimaankasir/repl_memo', 'Penerimaankasir::repl_memo');
$routes->get('/penerimaankasir/cari_data_tbbank', 'Penerimaankasir::cari_data_tbbank');
$routes->post('/penerimaankasir/repl_tbbank', 'Penerimaankasir::repl_tbbank');
$routes->get('/penerimaankasir/cari_data_tbjnkartu', 'Penerimaankasir::cari_data_tbjnkartu');
$routes->post('/penerimaankasir/repl_tbjnkartu', 'Penerimaankasir::repl_tbjnkartu');
$routes->post('/penerimaankasir/proses/(:num)', 'Penerimaankasir::proses/$1');
$routes->post('/penerimaankasir/unproses/(:num)', 'Penerimaankasir::unproses/$1');
$routes->get('penerimaankasir/cetakpenerimaankasir/(:num)', 'Penerimaankasir::cetakpenerimaankasir/$1');

$routes->get('/pengeluarankasir', 'Pengeluarankasir::index');
$routes->get('/pengeluarankasir/table_pengeluarankasir', 'Pengeluarankasir::table_pengeluarankasir');
$routes->post('/pengeluarankasir/ajax-load-data', 'Pengeluarankasir::ajaxLoadData');
$routes->get('/pengeluarankasir/formtambah', 'Pengeluarankasir::formtambah');
$routes->post('/pengeluarankasir/simpandata', 'Pengeluarankasir::simpandata');
$routes->post('/pengeluarankasir/formdetail', 'Pengeluarankasir::formdetail');
$routes->post('/pengeluarankasir/detail', 'Pengeluarankasir::detail');
$routes->post('/pengeluarankasir/formedit', 'Pengeluarankasir::formedit');
$routes->post('/pengeluarankasir/updatedata', 'Pengeluarankasir::updatedata');
$routes->post('/pengeluarankasir/hapus/(:num)', 'Pengeluarankasir::hapus/$1');
$routes->get('/pengeluarankasir/cari_data_memo', 'Pengeluarankasir::cari_data_memo');
$routes->post('/pengeluarankasir/repl_memo', 'Pengeluarankasir::repl_memo');
$routes->get('/pengeluarankasir/cari_data_tbbank', 'Pengeluarankasir::cari_data_tbbank');
$routes->post('/pengeluarankasir/repl_tbbank', 'Pengeluarankasir::repl_tbbank');
$routes->get('/pengeluarankasir/cari_data_tbjnkartu', 'Pengeluarankasir::cari_data_tbjnkartu');
$routes->post('/pengeluarankasir/repl_tbjnkartu', 'Pengeluarankasir::repl_tbjnkartu');
$routes->post('/pengeluarankasir/proses/(:num)', 'Pengeluarankasir::proses/$1');
$routes->post('/pengeluarankasir/unproses/(:num)', 'Pengeluarankasir::unproses/$1');
$routes->get('pengeluarankasir/cetakpengeluarankasir/(:num)', 'Pengeluarankasir::cetakpengeluarankasir/$1');

//Proses
$routes->get('/approvmemospv', 'Approvmemospv::index');
$routes->get('/approvmemospv/table_approvmemospv', 'Approvmemospv::table_approvmemospv');
$routes->post('/approvmemospv/ajax-load-data', 'Approvmemospv::ajaxLoadData');
$routes->post('/approvmemospv/formdetail', 'Approvmemospv::formdetail');

$routes->get('/approvmemosm', 'Approvmemosm::index');
$routes->get('/approvmemosm/table_approvmemosm', 'Approvmemosm::table_approvmemosm');
$routes->post('/approvmemosm/ajax-load-data', 'Approvmemosm::ajaxLoadData');
$routes->post('/approvmemosm/formdetail', 'Approvmemosm::formdetail');

$routes->get('/approvmemodir', 'Approvmemodir::index');
$routes->get('/approvmemodir/table_approvmemodir', 'Approvmemodir::table_approvmemodir');
$routes->post('/approvmemodir/ajax-load-data', 'Approvmemodir::ajaxLoadData');
$routes->post('/approvmemodir/formdetail', 'Approvmemodir::formdetail');

// $routes->get('/approvmemospv', 'Approvmemospv::index');
// $routes->get('/approvmemospv/table_approvmemospv', 'Approvmemospv::table_approvmemospv');
// $routes->post('/approvmemospv/ajax-load-data', 'Approvmemospv::ajaxLoadData');
// $routes->post('/approvmemospv/formdetail', 'Approvmemospv::formdetail');
// $routes->post('/approvmemospv/proses/(:num)', 'Approvmemospv::proses/$1');
// $routes->post('/approvmemospv/unproses/(:num)', 'Approvmemospv::unproses/$1');
// $routes->post('/approvmemospv/tambahjual', 'Approvmemospv::tambahjual');
// $routes->post('/approvmemospv/simpanjual', 'Approvmemospv::simpanjual');
// $routes->post('/approvmemospv/hapusmemospvd/(:num)', 'Approvmemospv::hapusmemospvd/$1');
// $routes->post('/approvmemospv/prosesmemospv', 'Approvmemospv::prosesmemospv');
// $routes->post('/approvmemospv/unprosesmemospv', 'Approvmemospv::unprosesmemospv');
// $routes->get('approvmemospv/cetakmemospv/(:num)', 'Approvmemospv::cetakmemospv/$1');

// $routes->post('memombr/modalmemombr', 'Memombr::modalmemombr');
// $routes->post('/memombr/hapusmemombr/(:num)', 'Memombr::hapusmemombr/$1');
// $routes->post('memombr/detailmemombr', 'Memombr::detailmemombr');
// $routes->post('memombr/tambahmemombr', 'Memombr::tambahmemombr');
// $routes->post('memombr/simpanmemombr', 'Memombr::simpanmemombr');
// $routes->post('memombr/editmemombr', 'Memombr::editmemombr');
// $routes->post('memombr/updatememombr', 'Memombr::updatememombr');
// $routes->post('memombr/inputmemombrd', 'Memombr::inputmemombrd');
// $routes->get('memombr/caridatasa', 'Memombr::caridatasa');
// $routes->post('memombr/replsa', 'Memombr::replsa');
// $routes->get('memombr/caridataasuransi', 'Memombr::caridataasuransi');
// $routes->post('memombr/replasuransi', 'Memombr::replasuransi');
// $routes->get('memombr/caridatapart', 'Memombr::caridatapart');
// $routes->post('memombr/replpart', 'Memombr::replpart');
// $routes->post('memombr/table_memombr_part', 'Memombr::table_memombr_part');
// $routes->post('memombr/simpanmemombrd', 'Memombr::simpanmemombrd');
// $routes->post('memombr/simpanbahan', 'Memombr::simpanbahan');
// $routes->get('memombr/caridatabahan', 'Memombr::caridatabahan');
// $routes->post('memombr/replbahan', 'Memombr::replbahan');
// $routes->get('memombr/caridataopl', 'Memombr::caridataopl');
// $routes->post('memombr/replopl', 'Memombr::replopl');
// $routes->post('memombr/simpanopl', 'Memombr::simpanopl');
// $routes->get('memombr/caridatajasa', 'Memombr::caridatajasa');
// $routes->post('memombr/repljasa', 'Memombr::repljasa');
// $routes->post('memombr/simpanjasa', 'Memombr::simpanjasa');
// $routes->post('memombr/table_memombr_bahan', 'Memombr::table_memombr_bahan');
// $routes->post('memombr/simpanmemombrdbahan', 'Memombr::simpanmemombrdbahan');
// $routes->post('memombr/table_memombr_opl', 'Memombr::table_memombr_opl');
// $routes->post('memombr/simpanmemombrdopl', 'Memombr::simpanmemombrdopl');
// $routes->post('memombr/table_memombr_jasa', 'Memombr::table_memombr_jasa');
// $routes->post('memombr/simpanmemombrdjasa', 'Memombr::simpanmemombrdjasa');
// $routes->post('memombr/summary', 'Memombr::summary');
// $routes->post('memombr/hapusdetailmemombr/(:num)', 'Memombr::hapusdetailmemombr/$1');
// $routes->post('/memombr/prosesmemombr', 'Memombr::prosesmemombr');
// $routes->post('/memombr/unprosesmemombr', 'Memombr::unprosesmemombr');
// $routes->get('memombr/cetakmemombr/(:num)', 'Memombr::cetakmemombr/$1');

$routes->get('/saplikasi', 'Saplikasi::index');
$routes->get('/saplikasi/table_saplikasi', 'Saplikasi::table_saplikasi');
$routes->get('/saplikasi/formtambah', 'Saplikasi::formtambah');
$routes->post('/saplikasi/simpandata', 'Saplikasi::simpandata');
$routes->post('/saplikasi/formdetail', 'Saplikasi::formdetail');
$routes->post('/saplikasi/detail', 'Saplikasi::detail');
$routes->post('/saplikasi/formedit', 'Saplikasi::formedit');
$routes->post('/saplikasi/updatedata', 'Saplikasi::updatedata');
$routes->post('/saplikasi/hapus/(:num)', 'Saplikasi::hapus/$1');
$routes->post('/saplikasi/deletemultiple', 'Saplikasi::deletemultiple');

$routes->get('/tbmodule', 'Tbmodule::index');
$routes->get('/tbmodule/table_module', 'Tbmodule::table_module');
$routes->get('/tbmodule/formtambah', 'Tbmodule::formtambah');
$routes->post('/tbmodule/simpandata', 'Tbmodule::simpandata');
$routes->post('/tbmodule/formdetail', 'Tbmodule::formdetail');
$routes->post('/tbmodule/formedit', 'Tbmodule::formedit');
$routes->post('/tbmodule/updatedata', 'Tbmodule::updatedata');
$routes->post('/tbmodule/hapus/(:num)', 'Tbmodule::hapus/$1');
$routes->post('/tbmodule/urutkan', 'Tbmodule::urutkan');

$routes->get('/tbuser', 'Tbuser::index');
$routes->get('/tbuser/tabel_user', 'Tbuser::tabel_user');
$routes->get('/tbuser/formtambah', 'Tbuser::formtambah');
$routes->post('/tbuser/simpandata', 'Tbuser::simpandata');
$routes->post('/tbuser/formdetail', 'Tbuser::formdetail');
$routes->post('/tbuser/formedit', 'Tbuser::formedit');
$routes->post('/tbuser/updatedata', 'Tbuser::updatedata');
$routes->post('/tbuser/hapus/(:num)', 'Tbuser::hapus/$1');
$routes->get('/tbuser/formakses', 'Tbuser::formakses');
$routes->post('/tbuser/simpanakses', 'Tbuser::simpanakses');
$routes->get('backup_database', 'Tbuser::backup');
$routes->get('proses_backup', 'Tbuser::proses_backup');

$routes->get('/customer', 'Customers::index');
$routes->post('ajaxDatatables', 'Customer::ajaxDatatables');
$routes->get('/person', 'Person::index');
$routes->get('/user', 'User::index');
$routes->get('/user/ajaxList', 'User::ajaxList');
$routes->post('/user/ajaxList', 'User::ajaxList');

$routes->get("list-mahasiswa", "Mahasiswa::listMahasiswa");
$routes->post("ajax-load-data", "Mahasiswa::ajaxLoadData");
$routes->get("mahasiswa/ajax_edit/(:num)", "Mahasiswa::ajax_edit/$1");
$routes->post("mahasiswa/ajax_delete/(:num)", "Mahasiswa::ajax_delete/$1");

$routes->get("teman", "Crudajax::index");
$routes->get("teman/table_teman", "Crudajax::table_teman");
$routes->get("teman/form_teman", "Crudajax::form_teman");
$routes->get("teman/form_teman_detail", "Crudajax::form_teman_detail");
$routes->get("teman/detail_form_teman", "Crudajax::detail_form_teman");
$routes->get("teman/tambah_teman", "Crudajax::tambah_teman");
$routes->get("teman/edit_teman", "Crudajax::edit_teman");
$routes->get("teman/edit_form_teman", "Crudajax::edit_form_teman");
$routes->post("teman/edit_form_teman", "Crudajax::edit_form_teman");
$routes->post("teman/getjeniskelamin", "Crudajax::getjeniskelamin");
$routes->post("teman/delete_teman", "Crudajax::delete_teman");

$routes->get('home', 'Home::index');
// $routes->get('/temanAjax', 'Home::temanAjax');
// $routes->post('/temanAjax', 'Home::temanAjax');
$routes->get('teman/temanAjax', 'Teman::temanAjax');
$routes->post('teman/temanAjax', 'Teman::temanAjax');

// $routes->get('/', 'Pages::index');
// $routes->get('/', 'Home::index');
// $routes->get('/', 'Pages::index');
// $routes->get('/pages/home', 'Pages::home');
// $routes->get('/pages/about', 'Pages::about');
// $routes->get('/pages/contact', 'Pages::contact');
// $routes->get('/komik', 'Komik::index');
$routes->get('/', 'Dashboard::index');
$routes->get('/datatables', 'Datatables::index');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
