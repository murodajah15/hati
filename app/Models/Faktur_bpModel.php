<?php

namespace App\Models;

use CodeIgniter\Model;

class Faktur_bpModel extends Model
{
  protected $table      = 'faktur_bp';
  // protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = [
    'nofaktur', 'tanggal', 'noestimasi', 'nowo', 'tglwo', 'nopolisi', 'norangka', 'kdpemilik', 'nmpemilik', 'kdsa', 'keluhan', 'kdservice',
    'no_polis', 'nama_polis', 'tgl_akhir_polis', 'kode_asuransi', 'nama_asuransi', 'alamat_asuransi',
    'nmservice', 'aktifitas', 'fasilitas', 'status_tunggu', 'int_reminder', 'via', 'total_part', 'total_bahan', 'total_opl', 'total_jasa',
    'total', 'pr_discount', 'discount', 'dpp', 'ppn', 'total_wo', 'close', 'user_close', 'batal', 'ket_batal', 'user_batal', 'tgl_batal', 'status_member',
    'klaim', 'internal', 'inventaris', 'campaign', 'booking', 'lain-lain', 'user', 'proses', 'user_proses', 'close_part', 'close_jasa', 'close_bahan', 'close_opl',
    'total_faktur'
  ];

  public function tampilData($request, $katakunci = null, $start = 0, $length = 0)
  {
    $builder = $this->table('faktur_bp');
    if ($katakunci) {
      $arr = explode(" ", $katakunci);
      for ($i = 0; $i < count($arr); $i++) {
        $builder = $builder->orlike('nofaktur', $arr[$i]);
        $builder = $builder->orlike('tanggal', $arr[$i]);
        $builder = $builder->orlike('nopolisi', $arr[$i]);
        $builder = $builder->orlike('norangka', $arr[$i]);
        $builder = $builder->orlike('km', $arr[$i]);
        $builder = $builder->orlike('total', $arr[$i]);
        $builder = $builder->orlike('user', $arr[$i]);
      }
      $builder = $builder->orderBy('nofaktur', 'asc');
    }
    if ($start != 0 or $length != 0) {
      // $builder = $builder->orderBy('kode', 'desc');
      $builder = $builder->limit($length, $start);
    }
    $order = $request->getPost('order[0][column]');
    $order_dir = $request->getPost('order[0][dir]');
    if ($order == 0) {
      $builder = $builder->orderBy('nofaktur', 'desc');
    } else if ($order == 1) {
      $builder->orderBy('nofaktur', $order_dir);
    } else if ($order == 2) {
      $builder->orderBy('tanggal', $order_dir);
    } else if ($order == 3) {
      $builder->orderBy('nopolisi', $order_dir);
    } else if ($order == 4) {
      $builder->orderBy('norangka', $order_dir);
    } else if ($order == 5) {
      $builder->orderBy('km', $order_dir);
    } else if ($order == 6) {
      $builder->orderBy('total', $order_dir);
    }
    // return $builder->orderBy('kode', 'asc')->get()->getResult();
    return $builder->get()->getResult();
  }

  public function getid($id = false)
  {
    if ($id == false) {
      return $this->findAll();
    }
    return $this->getWhere(['id' => $id]);
    // return $this->where('id', $id)->first();
  }

  public function getnofaktur($nofaktur = false)
  {
    if ($nofaktur == false) {
      return $this->findAll();
    }
    return $this->where('nofaktur', $nofaktur)->findAll();
  }

  public function getkdcustomer($kdcustomer = false)
  {
    if ($kdcustomer == false) {
      return $this->findAll();
    }
    return $this->where('kdcustomer', $kdcustomer)->first();
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

  public function getnopolisi($nopolisi = false)
  {
    if ($nopolisi == false) {
      return $this->findAll();
    }
    return $this->where('nopolisi', $nopolisi)->orderby('nowo', 'desc')->findAll();
  }

  public function delete_by_id($id)
  {
    $this->where('id', $id);
    $this->delete();
  }

  public function buatnofaktur()
  {
    $builder = $this->db->table("faktur_bp");
    $builder->selectMax('nofaktur');
    return $builder->get()->getResult();
  }
}
