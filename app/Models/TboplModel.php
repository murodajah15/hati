<?php

namespace App\Models;

use CodeIgniter\Model;

class TboplModel extends Model
{
  protected $table      = 'tbopl';
  // protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = [
    'kode', 'nama', 'kdsupplier', 'harga_beli', 'harga_jual', 'aktif', 'user'
  ];

  public function tampilData($request, $katakunci = null, $start = 0, $length = 0)
  {
    $builder = $this->table('tbopl');
    if ($katakunci) {
      $arr = explode(" ", $katakunci);
      for ($i = 0; $i < count($arr); $i++) {
        $builder = $builder->orlike('kode', $arr[$i]);
        $builder = $builder->orlike('nama', $arr[$i]);
        $builder = $builder->orlike('kdsupplier', $arr[$i]);
        $builder = $builder->orlike('user', $arr[$i]);
      }
      // $builder = $builder->orderBy('kode');
    }
    if ($start != 0 or $length != 0) {
      // $builder = $builder->orderBy('kode');
      $builder = $builder->limit($length, $start);
    }
    $order = $request->getPost('order[0][column]');
    $order_dir = $request->getPost('order[0][dir]');
    if ($order == 0) {
      $builder = $builder->orderBy('kode');
    } else if ($order == 1) {
      $builder->orderBy('kode', $order_dir);
    } else if ($order == 2) {
      $builder->orderBy('nama', $order_dir);
    } else if ($order == 3) {
      $builder->orderBy('harga_beli', $order_dir);
    } else if ($order == 4) {
      $builder->orderBy('harga_jual', $order_dir);
    } else if ($order == 5) {
      $builder->orderBy('kdsupplier', $order_dir);
    } else if ($order == 6) {
      $builder->orderBy('aktif', $order_dir);
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

  public function getsupplier($nama = false)
  {
    if ($nama == false) {
      return $this->findAll();
    }
    return $this->where('kdsupplier', $nama)->first();
    // return $this->where(['slug' => $slug])->first();
  }

  public function delete_by_id($id)
  {
    $this->where('id', $id);
    $this->delete();
  }
}
