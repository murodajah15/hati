<?php

namespace App\Models;

use CodeIgniter\Model;

class Po_partdModel extends Model
{
  protected $table      = 'po_partd';
  // protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = [
    'nopo', 'kodepart', 'namapart', 'kdjnbrg', 'nmjnbrg', 'kdmove', 'nmmove', 'satuan', 'qty', 'hrgbeli', 'discount', 'rp_discount', 'subtotal', 'proses',
    'hpp',
  ];

  public function tampilData($request, $katakunci = null, $start = 0, $length = 0)
  {
    $builder = $this->table('po_partd');
    if ($katakunci) {
      $arr = explode(" ", $katakunci);
      for ($i = 0; $i < count($arr); $i++) {
        $builder = $builder->orlike('kodepart', $arr[$i]);
        $builder = $builder->orlike('namapart', $arr[$i]);
        $builder = $builder->orlike('qty', $arr[$i]);
        $builder = $builder->orlike('hrgbeli', $arr[$i]);
        $builder = $builder->orlike('subtotal', $arr[$i]);
      }
      $builder = $builder->orderBy('nopo', 'asc');
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

  public function getnopo($nopo = false)
  {
    if ($nopo == false) {
      return $this->findAll();
    }
    return $this->where('nopo', $nopo)->findAll();
  }

  public function delete_po($nopo)
  {
    $this->where('nopo', $nopo);
    $this->delete();
  }

  public function delete_by_id($id)
  {
    $this->where('id', $id);
    $this->delete();
  }

  public function jumpart($nopo = false)
  {
    $this->where('nopo', $nopo)->select('sum(subtotal) as jumpart');
    return $this->findAll();
  }

  public function getdoublebarang($nopo = false, $kode = false)
  {
    if ($nopo == false or $kode == false) {
      return $this->findAll();
    }
    $this->where('nopo', $nopo);
    $this->where('kodepart', $kode);
    return $this->findAll();
  }
}
