<?php

namespace App\Models;

use CodeIgniter\Model;

class TbsaModel extends Model
{
  protected $table      = 'tbsa';
  // protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = ['kdsa', 'nama', 'alamat', 'kelurahan', 'kecamatan', 'kota', 'kodepos', 'nohp', 'aktif', 'user'];

  public function tampilData($request, $katakunci = null, $start = 0, $length = 0)
  {
    $builder = $this->table('tbsa');
    if ($katakunci) {
      $arr = explode(" ", $katakunci);
      for ($i = 0; $i < count($arr); $i++) {
        $builder = $builder->orlike('kdsa', $arr[$i]);
        $builder = $builder->orlike('nama', $arr[$i]);
        $builder = $builder->orlike('alamat', $arr[$i]);
        $builder = $builder->orlike('nohp', $arr[$i]);
      }
      // $builder = $builder->orderBy('kdsa');
    }
    if ($start != 0 or $length != 0) {
      // $builder = $builder->orderBy('kdsa');
      $builder = $builder->limit($length, $start);
    }
    $order = $request->getPost('order[0][column]');
    $order_dir = $request->getPost('order[0][dir]');
    if ($order == 0) {
      $builder = $builder->orderBy('kdsa');
    } else if ($order == 1) {
      $builder->orderBy('kdsa', $order_dir);
    } else if ($order == 2) {
      $builder->orderBy('nama', $order_dir);
    } else if ($order == 3) {
      $builder->orderBy('alamat', $order_dir);
    } else if ($order == 4) {
      $builder->orderBy('nohp', $order_dir);
    }
    // return $builder->orderBy('kdsa', 'asc')->get()->getResult();
    return $builder->get()->getResult();
  }

  public function getsa($id = false)
  {
    if ($id == false) {
      return $this->findAll();
    }
    return $this->getWhere(['id' => $id]);
    // return $this->where('id', $id)->first();
  }

  public function getkode($kdsa = false)
  {
    if ($kdsa == false) {
      return $this->findAll();
      // return $this->where('kdsa', "")->first();
    }
    return $this->where('kdsa', $kdsa)->first();
    // return $this->where(['slug' => $slug])->first();
  }

  public function getkdsa($kdsa = false)
  {
    if ($kdsa == false) {
      return $this->findAll();
    }
    return $this->where('kdsa', $kdsa)->first();
    // return $this->where(['slug' => $slug])->first();
  }

  public function getnmsa($nama = false)
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
