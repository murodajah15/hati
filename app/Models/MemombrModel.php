<?php

namespace App\Models;

use CodeIgniter\Model;

$db = \Config\Database::connect();

class MemombrModel extends Model
{
  protected $table      = 'memombr';
  // protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = [
    'tanggal', 'nomemo', 'nospk', 'norangka', 'nomesin', 'kdmerek', 'kdmodel', 'kdtipe', 'nmtipe', 'kdjenis', 'kdwarna', 'nmwarna', 'tahun', 'pembayaran', 'kdleasing', 'nmkreditur',
    'lama_kredit', 'asuransi', 'kdasuransi', 'nmasuransi', 'pembeli', 'penjualan', 'disc_team_harga', 'booking_fee', 'kaca_film', 'faktur_pajak', 'kdsales',
    'status_sales', 'kdspv', 'kdmgr', 'sales_mgr', 'kdcustomer', 'nmcustomer', 'alamat', 'kelurahan', 'kecamatan', 'kota', 'provinsi', 'kodepos',
    'kdcustomer_stnk', 'nmcustomer_stnk', 'alamat_stnk', 'kelurahan_stnk', 'kecamatan_stnk', 'kota_stnk', 'provinsi_stnk', 'kodepos_stnk',
    'harga_jual_mobil', 'harga_jual_accessories', 'biaya_wilayah', 'upping_price', 'disc_accessories', 'total', 'disc_dealer', 'mediator_an',
    'nama_stnk', 'tipe_unit_warna', 'beli_asuransi', 'beli_accessories', 'mediator_bank', 'mediator_cabang', 'mediator_account', 'mediator_nilai',
    'ket_uang_lain', 'uang_lain', 'event_hpm', 'event_lain', 'tgl_validasi', 'nama_validasi', 'tgl_acc_discount', 'nama_acc_discount', 'valid', 'batal', 'user', 'pembelian_accessories', 'bonus_accessories',
    'nik_customer', 'nik_stnk', 'nik_kk', 'nohp_customer', 'nohp_customer_stnk', 'email_stnk', 'npwp_stnk', 'mohfaktur'
  ];

  public function tampilData($request, $katakunci = null, $start = 0, $length = 0)
  {
    $builder = $this->table('memombr');
    if ($katakunci) {
      $arr = explode(" ", $katakunci);
      for ($i = 0; $i < count($arr); $i++) {
        $builder = $builder->orlike('tanggal', $arr[$i]);
        $builder = $builder->orlike('nomemo', $arr[$i]);
        $builder = $builder->orlike('nospk', $arr[$i]);
        $builder = $builder->orlike('nmtipe', $arr[$i]);
        $builder = $builder->orlike('status_approv_spv', $arr[$i]);
        $builder = $builder->orlike('status_approv_sm', $arr[$i]);
        $builder = $builder->orlike('status_approv_dir', $arr[$i]);
        $builder = $builder->orlike('user', $arr[$i]);
      }
      // $builder = $builder->orderBy('kode');
    }
    if ($start != 0 or $length != 0) {
      $builder = $builder->limit($length, $start);
    }
    $order = $request->getPost('order[0][column]');
    $order_dir = $request->getPost('order[0][dir]');
    if ($order == 0) {
      $builder = $builder->orderBy('nomemo', 'desc');
    } else if ($order == 1) {
      $builder->orderBy('nomemo', $order_dir);
    } else if ($order == 2) {
      $builder->orderBy('tanggal', $order_dir);
    } else if ($order == 3) {
      $builder->orderBy('nospk', $order_dir);
    } else if ($order == 4) {
      $builder->orderBy('nmtipe', $order_dir);
    } else if ($order == 5) {
      $builder->orderBy('status_approv_spv', $order_dir);
    } else if ($order == 6) {
      $builder->orderBy('status_approv_sm', $order_dir);
    } else if ($order == 7) {
      $builder->orderBy('status_approv_dir', $order_dir);
    }
    // return $builder->orderBy('kode', 'asc')->get()->getResult();
    return $builder->get()->getResult();
  }

  public function getid($id = false)
  {
    if ($id == false) {
      return $this->orderby('nomemombr', 'desc')->findAll();
    }
    return $this->where('id', $id)->first();
  }

  public function getnomemo($nomemo = false)
  {
    if ($nomemo == false) {
      return $this->orderby('nomemo', 'desc')->findAll();
    }
    return $this->where('nomemo', $nomemo)->first();
  }

  public function getkdcustomer($nowo = false)
  {
    if ($nowo == false) {
      return $this->findAll();
    }
    return $this->where('nomemombr', $nowo)->first();
    // return $this->where(['slug' => $slug])->first();
  }

  public function getnmcustomer($nama = false)
  {
    if ($nama == false) {
      return $this->findAll();
    }
    return $this->where('nama', $nama)->first();
    // return $this->where(['slug' => $slug])->first();
  }

  public function getsales($kode = false)
  {
    if ($kode == false) {
      return $this->findAll();
    }
    return $this->where('kdsales', $kode)->orderby('kdsales', 'desc')->findAll();
  }

  public function getkodeservice($kode = false)
  {
    if ($kode == false) {
      return $this->findAll();
    }
    $this->where('kdservice', $kode);
    return $this->findAll();
  }

  public function getasuransi($kode = false)
  {
    if ($kode == false) {
      return $this->findAll();
    }
    $this->where('kdasuransi', $kode);
    return $this->findAll();
  }

  public function getleasing($kode = false)
  {
    if ($kode == false) {
      return $this->findAll();
    }
    $this->where('kdkreditur', $kode);
    return $this->findAll();
  }

  public function delete_by_id($id)
  {
    $this->where('id', $id);
    $this->delete();
  }

  public function buatnomemo()
  {
    $builder = $this->db->table("memombr");
    $builder->selectMax('nomemo');
    return $builder->get()->getResult();
  }

  public function getperiode($tanggal1 = false, $tanggal2 = false)
  {
    if ($tanggal1 == false) {
      return $this->findAll();
    }
    $this->where('date(tanggal) >=', $tanggal1);
    $this->where('date(tanggal) <=', $tanggal2);
    return $this->findAll();
  }

  public function jumlah_record()
  {
    return $this->db->table('memombr')->countAllResults();
  }
}
