<?php

namespace App\Models;

use CodeIgniter\Model;

class WoModel extends Model
{
  protected $table      = 'wo';
  // protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = [
    'noestimasi', 'nowo', 'tanggal', 'nopolisi', 'norangka', 'kdpemilik', 'nmpemilik', 'kdsa', 'keluhan', 'kdservice',
    'nmservice', 'aktifitas', 'fasilitas', 'status_tunggu', 'int_reminder', 'via', 'total_part', 'total_bahan', 'total_jasa',
    'total', 'pr_discount', 'discount', 'dpp', 'ppn', 'total_estimasi', 'close', 'batal', 'ket_batal', 'user_batal', 'tgl_batal', 'status_member',
    'klaim', 'internal', 'inventaris', 'campaign', 'booking', 'lain-lain', 'user'
  ];

  public function tampilData($katakunci = null, $start = 0, $length = 0,)
  {
    $builder = $this->table('wo');
    if ($katakunci) {
      $arr = explode(" ", $katakunci);
      for ($i = 0; $i < count($arr); $i++) {
        $builder = $builder->orlike('nowo', $arr[$i]);
        $builder = $builder->orlike('noestimasi', $arr[$i]);
        $builder = $builder->orlike('nopolisi', $arr[$i]);
        $builder = $builder->orlike('user', $arr[$i]);
      }
    }
    if ($start != 0 or $length != 0) {
      $builder = $builder->limit($length, $start);
    }
    return $builder->orderBy('noestimasi', 'desc')->get()->getResult();
    // return $builder->get()->getResult();
  }

  public function getwo($id = false)
  {
    if ($id == false) {
      return $this->findAll();
    }
    return $this->getWhere(['id' => $id]);
    // return $this->where('id', $id)->first();
  }

  public function getkdcustomer($nowo = false)
  {
    if ($nowo == false) {
      return $this->findAll();
    }
    return $this->where('nowo', $nowo)->first();
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

  public function buatnoestimasi()
  {
    $builder = $this->db->table("wo");
    $builder->selectMax('noestimasi');
    return $builder->get()->getResult();
  }
  public function buatnowo()
  {
    $builder = $this->db->table("wo");
    $builder->selectMax('nowo');
    return $builder->get()->getResult();
  }
}
