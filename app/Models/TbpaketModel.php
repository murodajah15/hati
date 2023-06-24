<?php

namespace App\Models;

use CodeIgniter\Model;

class TbpaketModel extends Model
{
  protected $table      = 'tbpaket';
  // protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = [
    'kode', 'nama', 'jenis', 'kdtipe', 'aktif', 'user'
  ];

  public function tampilData($request, $katakunci = null, $start = 0, $length = 0)
  {
    $builder = $this->table('tbpaket');
    if ($katakunci) {
      $arr = explode(" ", $katakunci);
      for ($i = 0; $i < count($arr); $i++) {
        $builder = $builder->orlike('kode', $arr[$i]);
        $builder = $builder->orlike('nama', $arr[$i]);
        $builder = $builder->orlike('jenis', $arr[$i]);
        $builder = $builder->orlike('kdtipe', $arr[$i]);
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
      $builder->orderBy('jenis', $order_dir);
    } else if ($order == 4) {
      $builder->orderBy('kdtipe', $order_dir);
    }
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
  }

  public function getnama($nama = false)
  {
    if ($nama == false) {
      return $this->findAll();
    }
    return $this->where('nama', $nama)->first();
  }

  public function getsupplier($nama = false)
  {
    if ($nama == false) {
      return $this->findAll();
    }
    return $this->where('kdsupplier', $nama)->first();
  }

  public function getparent_id($parent_id = false)
  {
    if ($parent_id == false) {
      return $this->findAll();
    }
    return $this->where('kode', $parent_id)->first();
  }

  public function gettipe($kdtipe = false)
  {
    if ($kdtipe == false) {
      return $this->findAll();
    }
    return $this->where('kdtipe', $kdtipe)->first();
  }

  public function getpaket($kdtipe = false, $kdservice = false)
  {
    if ($kdtipe == false or $kdservice == false) {
      return $this->findAll();
    }
    return $this->where('kdtipe', $kdtipe)->where('jenis', $kdservice)->first();
  }

  public function delete_by_id($id)
  {
    $this->where('id', $id);
    $this->delete();
  }
}
