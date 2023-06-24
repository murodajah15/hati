<?php

namespace App\Models;

use CodeIgniter\Model;

class TbsalesModel extends Model
{
  protected $table      = 'tbsales';
  // protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = [
    'kode', 'nama', 'nohp1', 'nohp2', 'email', 'status', 'tglmasuk', 'kdspv', 'user', 'aktif'
  ];

  public function tampilData($request, $katakunci = null, $start = 0, $length = 0)
  {
    $builder = $this->table('tbsales');
    if ($katakunci) {
      $arr = explode(" ", $katakunci);
      for ($i = 0; $i < count($arr); $i++) {
        $builder = $builder->orlike('kode', $arr[$i]);
        $builder = $builder->orlike('nama', $arr[$i]);
        $builder = $builder->orlike('nohp1', $arr[$i]);
        $builder = $builder->orlike('nohp2', $arr[$i]);
        $builder = $builder->orlike('email', $arr[$i]);
        $builder = $builder->orlike('user', $arr[$i]);
      }
    }
    if ($start != 0 or $length != 0) {
      $builder = $builder->limit($length, $start);
    }
    $order = $request->getPost('order[0][column]');
    $order_dir = $request->getPost('order[0][dir]');
    if ($order == 0) {
      $builder = $builder->orderBy('kode', 'asc');
    } else if ($order == 1) {
      $builder->orderBy('kode', $order_dir);
    } else if ($order == 2) {
      $builder->orderBy('nama', $order_dir);
    } else if ($order == 3) {
      $builder->orderBy('nohp1', $order_dir);
    } else if ($order == 4) {
      $builder->orderBy('nohp2', $order_dir);
    } else if ($order == 5) {
      $builder->orderBy('email', $order_dir);
    }
    return $builder->orderBy('kode', 'asc')->get()->getResult();
    // return $builder->get()->getResult();
  }

  public function getsales($id = false)
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

  public function buatkode()
  {
    $builder = $this->db->table("tbsales");
    $builder->selectMax('kode');
    return $builder->get()->getResult();
  }

  public function getspv($kode = false)
  {
    if ($kode == false) {
      return $this->findAll();
    }
    return $this->where('kode', $kode)->where('status', 'SUPERVISOR')->first();
  }

  public function getmgr($kode = false)
  {
    if ($kode == false) {
      return $this->findAll();
    }
    return $this->where('kode', $kode)->where('status', 'MANAGER')->first();
  }
}
