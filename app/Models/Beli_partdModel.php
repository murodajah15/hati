<?php

namespace App\Models;

use CodeIgniter\Model;

class Beli_partdModel extends Model
{
  protected $table      = 'beli_partd';
  // protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = [
    'nobeli', 'kodepart', 'namapart', 'kdjnbrg', 'nmjnbrg', 'kdmove', 'nmmove', 'satuan', 'qty', 'hrgbeli', 'discount', 'rp_discount', 'subtotal', 'proses',
    'hpp',
  ];

  public function tampilData($request, $katakunci = null, $start = 0, $length = 0)
  {
    $builder = $this->table('beli_partd');
    if ($katakunci) {
      $arr = explode(" ", $katakunci);
      for ($i = 0; $i < count($arr); $i++) {
        $builder = $builder->orlike('kodepart', $arr[$i]);
        $builder = $builder->orlike('namapart', $arr[$i]);
        $builder = $builder->orlike('qty', $arr[$i]);
        $builder = $builder->orlike('hrgbeli', $arr[$i]);
        $builder = $builder->orlike('subtotal', $arr[$i]);
      }
      $builder = $builder->orderBy('nobeli', 'asc');
    }
    if ($start != 0 or $length != 0) {
      // $builder = $builder->orderBy('kode', 'desc');
      $builder = $builder->limit($length, $start);
    }
    $order = $request->getPost('order[0][column]');
    $order_dir = $request->getPost('order[0][dir]');
    if ($order == 0) {
      $builder = $builder->orderBy('kodepart', 'desc');
    } else if ($order == 1) {
      $builder->orderBy('namapart', $order_dir);
    } else if ($order == 2) {
      $builder->orderBy('qty', $order_dir);
    } else if ($order == 3) {
      $builder->orderBy('hrgbeli', $order_dir);
    } else if ($order == 4) {
      $builder->orderBy('subtotal', $order_dir);
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

  public function getnobeli($nobeli = false)
  {
    if ($nobeli == false) {
      return $this->findAll();
    }
    return $this->where('nobeli', $nobeli)->findAll();
  }

  public function getkdsupplier($kdcustomer = false)
  {
    if ($kdcustomer == false) {
      return $this->findAll();
    }
    return $this->where('kdcustomer', $kdcustomer)->first();
    // return $this->where(['slug' => $slug])->first();
  }

  public function delete_by_id($id)
  {
    $this->where('id', $id);
    $this->delete();
  }

  public function jumpart($nobeli = false)
  {
    $this->where('nobeli', $nobeli)->select('sum(subtotal) as jumpart');
    return $this->findAll();
  }

  public function getdoublebarang($nobeli = false, $kode = false)
  {
    if ($nobeli == false or $kode == false) {
      return $this->findAll();
    }
    $this->where('nobeli', $nobeli);
    $this->where('kodepart', $kode);
    return $this->findAll();
  }
}
