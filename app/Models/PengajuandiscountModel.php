<?php

namespace App\Models;

use CodeIgniter\Model;

$db = \Config\Database::connect();

class PengajuandiscountModel extends Model
{
  protected $table      = 'pengajuandiscount';
  // protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = [
    'tanggal', 'nomor', 'nomemo', 'nama_pemesan', 'nama_stnk', 'pembayaran', 'tipe', 'warna', 'pembelian_accessories', 'booking_fee',
    'discount_team_harga', 'discount_cashback', 'paket', 'mediator', 'lain_lain', 'bonus_accessories', 'approv_spv', 'tglapprov_spv',
    'status_approv_spv', 'ket_approv_spv', 'approv_sm', 'tglapprov_sm', 'status_approv_sm', 'ket_approv_sm', 'approv_dir', 'tglapprov_dir',
    'status_approv_dir', 'ket_approv_dir', 'user_login', 'status_approv_spv', 'status_approv_sm', 'valid', 'close', 'batal', 'user',
  ];

  public function tampilData($request, $katakunci = null, $start = 0, $length = 0)
  {
    $builder = $this->table('pengajuandiscount');
    if ($katakunci) {
      $arr = explode(" ", $katakunci);
      for ($i = 0; $i < count($arr); $i++) {
        $builder = $builder->orlike('tanggal', $arr[$i]);
        $builder = $builder->orlike('nomor', $arr[$i]);
        $builder = $builder->orlike('nomemo', $arr[$i]);
        $builder = $builder->orlike('nama_pesan', $arr[$i]);
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
      $builder = $builder->orderBy('nomor', 'desc');
    } else if ($order == 1) {
      $builder->orderBy('tanggal', $order_dir);
    } else if ($order == 2) {
      $builder->orderBy('nomor', $order_dir);
    } else if ($order == 3) {
      $builder->orderBy('nomemo', $order_dir);
    } else if ($order == 4) {
      $builder->orderBy('nama_pemesan', $order_dir);
    }
    // return $builder->orderBy('kode', 'asc')->get()->getResult();
    return $builder->get()->getResult();
  }

  public function getid($id = false)
  {
    if ($id == false) {
      return $this->orderby('nomor', 'desc')->findAll();
    }
    return $this->where('id', $id)->findAll();
  }

  public function getnomor($nomor = false)
  {
    if ($nomor == false) {
      return $this->orderby('nomor', 'desc')->findAll();
    }
    return $this->where('nomor', $nomor)->findAll();
  }

  public function getnomemo($nomemo = false)
  {
    if ($nomemo == false) {
      return $this->orderby('nomemo', 'desc')->findAll();
    }
    return $this->where('nomemo', $nomemo)->findAll();
  }

  public function delete_by_id($id)
  {
    $this->where('id', $id);
    $this->delete();
  }

  public function buatnomor()
  {
    $builder = $this->db->table("pengajuandiscount");
    $builder->selectMax('nomor');
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
    return $this->db->table('pengajuandiscount')->countAllResults();
  }

  public function jumlah_record_approved()
  {
    $builder = $this->db->table('pengajuandiscount');
    return $builder->where('status_approv_dir', 'SETUJUI')->countAllResults();
  }
}
