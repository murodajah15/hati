<?php

namespace App\Models;

use CodeIgniter\Model;

class Part_bpModel extends Model
{
  protected $table      = 'wo_bp_detail';
  // protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = [
    'kode', 'nama', 'kerusakan', 'jenis', 'qty', 'harga', 'pr_discount', 'subtotal', 'kdmekanik', 'nmmekanik', 'close', 'user',
  ];

  public function tampilData($katakunci = null, $start = 0, $length = 0,)
  {
    $builder = $this->table('wo_bp');
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

  public function getid($id = false)
  {
    if ($id == false) {
      return $this->findAll();
    }
    return $this->getWhere(['id' => $id]);
    // return $this->where('id', $id)->first();
  }

  public function getkode($kode = false)
  {
    if ($kode == false) {
      return $this->findAll();
    }
    return $this->where('kode', $kode)->first();
    // return $this->where(['slug' => $slug])->first();
  }

  public function getnama($nama = false)
  {
    if ($nama == false) {
      return $this->findAll();
    }
    return $this->where('nama', $nama)->first();
    // return $this->where(['slug' => $slug])->first();
  }

  public function delete_by_id($id)
  {
    $this->where('id', $id);
    $this->delete();
  }
}
