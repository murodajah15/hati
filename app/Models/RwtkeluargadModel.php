<?php

namespace App\Models;

use CodeIgniter\Model;

class RwtkeluargadModel extends Model
{
  protected $table      = 'rwtkeluargad';
  // protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = ['kode', 'nama', 'jekel', 'user'];

  public function tampilData($katakunci = null, $start = 0, $length = 0)
  {
    $builder = $this->table('rwtkeluarga');
    if ($katakunci) {
      $arr = explode(" ", $katakunci);
      for ($i = 0; $i < count($arr); $i++) {
        $builder = $builder->orlike('kode', $arr[$i]);
        $builder = $builder->orlike('nama', $arr[$i]);
        $builder = $builder->orlike('user', $arr[$i]);
      }
    }
    if ($start != 0 or $length != 0) {
      $builder = $builder->limit($length, $start);
    }
    // return $builder->orderBy('kode', 'asc')->get()->getResult();
    return $builder->get()->getResult();
  }

  public function tampilDataDetail($katakunci = null, $start = 0, $length = 0)
  {
    $builder = $this->table('rwtkeluargad');
    if ($katakunci) {
      $arr = explode(" ", $katakunci);
      for ($i = 0; $i < count($arr); $i++) {
        $builder = $builder->orlike('kode', $arr[$i]);
        $builder = $builder->orlike('nama', $arr[$i]);
        $builder = $builder->orlike('user', $arr[$i]);
      }
    }
    if ($start != 0 or $length != 0) {
      $builder = $builder->limit($length, $start);
    }
    // return $builder->orderBy('kode', 'asc')->get()->getResult();
    return $builder->get()->getResult();
  }

  public function getrwtkeluarga($id = false)
  {
    if ($id == false) {
      return $this->findAll();
    }
    return $this->getWhere(['id' => $id]);
    // return $this->where('id', $id)->first();
  }

  public function getkdrwtkeluarga($kode = false)
  {
    if ($kode == false) {
      return $this->findAll();
    }
    return $this->where('kode', $kode)->first();
    // return $this->where(['slug' => $slug])->first();
  }

  public function getnmrwtkeluarga($nama = false)
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

  public function delete_by_kode($kode)
  {
    $this->where('kode', $kode);
    $this->delete();
  }

  public function hapusbanyak($kode, $jmldata)
  {
    // for ($i = 0; $i < $jmldata; $i++) {
    //   // $this->db->delete('rwtkeluarga', ['kode'=>$kode[$i]]);

    // }
    $this->whereIn('kode', $kode);
    $this->delete();
    return true;
  }
}
