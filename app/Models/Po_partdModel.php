<?php

namespace App\Models;

use CodeIgniter\Model;

class Po_partdModel extends Model
{
  protected $table      = 'po_part';
  // protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = [
    'nopo', 'tanggal', 'kdsupplier', 'nmsupplier', 'jnsorder', 'reference', 'biaya1', 'nbiaya1', 'biaya2', 'nbiaya2', 'biaya3', 'toal_biaya', 'catatan',
    'subtotal', 'totalsmt', 'ppn', 'rp_ppn', 'materai', 'total',  'user', 'proses', 'part_shop',
  ];

  public function tampilData($request, $katakunci = null, $start = 0, $length = 0)
  {
    $builder = $this->table('po_partd');
    if ($katakunci) {
      $arr = explode(" ", $katakunci);
      for ($i = 0; $i < count($arr); $i++) {
        $builder = $builder->orlike('nopo', $arr[$i]);
        $builder = $builder->orlike('tanggal', $arr[$i]);
        $builder = $builder->orlike('kdsupplier', $arr[$i]);
        $builder = $builder->orlike('nmsupplier', $arr[$i]);
        $builder = $builder->orlike('total', $arr[$i]);
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
      $builder = $builder->orderBy('nopo', 'desc');
    } else if ($order == 1) {
      $builder->orderBy('nopo', $order_dir);
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

  public function getnopo($nopo = false)
  {
    if ($nopo == false) {
      return $this->findAll();
    }
    return $this->where('nopo', $nopo)->findAll();
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

  public function buatnopo()
  {
    $builder = $this->db->table("po_partd");
    $builder->selectMax('nopo');
    return $builder->get()->getResult();
  }
}
