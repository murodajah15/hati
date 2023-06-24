<?php

namespace App\Models;

use CodeIgniter\Model;

$db = \Config\Database::connect();

class MemombrdModel extends Model
{
  protected $table      = 'memombrd';
  // protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = [
    'nomemo', 'nama_produk', 'modal', 'jual', 'user',
  ];

  public function tampilData($request, $katakunci = null, $start = 0, $length = 0)
  {
    $builder = $this->table('memombr');
    if ($katakunci) {
      $arr = explode(" ", $katakunci);
      for ($i = 0; $i < count($arr); $i++) {
        $builder = $builder->orlike('nama_produk', $arr[$i]);
        $builder = $builder->orlike('modal', $arr[$i]);
        $builder = $builder->orlike('jual', $arr[$i]);
        $builder = $builder->orlike('user', $arr[$i]);
      }
      // $builder = $builder->orderBy('kode');
    }
    if ($start != 0 or $length != 0) {
      $builder = $builder->orderBy('nomemo', 'desc');
      $builder = $builder->limit($length, $start);
    }
    $order = $request->getPost('order[0][column]');
    $order_dir = $request->getPost('order[0][dir]');
    if ($order == 0) {
      $builder = $builder->orderBy('tanggal');
    } else if ($order == 1) {
      $builder->orderBy('tanggal', $order_dir);
    } else if ($order == 2) {
      $builder->orderBy('nomemo', $order_dir);
    } else if ($order == 3) {
      $builder->orderBy('nospk', $order_dir);
    } else if ($order == 4) {
      $builder->orderBy('nmtipe', $order_dir);
    }
    // return $builder->orderBy('kode', 'asc')->get()->getResult();
    return $builder->get()->getResult();
  }

  public function getid($id = false)
  {
    if ($id == false) {
      return $this->orderby('nomemombr', 'desc')->findAll();
    }
    return $this->where('id', $id)->first();
  }

  public function getdata($nomemo = false)
  {
    if ($nomemo == false) {
      return $this->orderby('nomemo', 'desc')->findAll();
    }
    return $this->where('nomemo', $nomemo)->findAll();
  }

  public function delete_by_id($id)
  {
    $this->where('id', $id);
    $this->delete();
  }
}
