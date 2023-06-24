<?php

namespace App\Models;

use CodeIgniter\Model;

$db = \Config\Database::connect();

class HisuserModel extends Model
{
  protected $table      = 'hisuser';
  // protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = [
    'tanggal', 'dokumen', 'form', 'status', 'catatan', 'user'
  ];

  public function tampilData($request, $katakunci = null, $start = 0, $length = 0)
  {
    $builder = $this->table('hisuser');
    if ($katakunci) {
      $arr = explode(" ", $katakunci);
      for ($i = 0; $i < count($arr); $i++) {
        $builder = $builder->orlike('tanggal', $arr[$i]);
        $builder = $builder->orlike('dokumen', $arr[$i]);
        $builder = $builder->orlike('form', $arr[$i]);
        $builder = $builder->orlike('status', $arr[$i]);
        $builder = $builder->orlike('user', $arr[$i]);
      }
      // $builder = $builder->orderBy('kode');
    }
    if ($start != 0 or $length != 0) {
      // $builder = $builder->orderBy('nomor', 'desc');
      $builder = $builder->limit($length, $start);
    }
    $order = $request->getPost('order[0][column]');
    $order_dir = $request->getPost('order[0][dir]');
    if ($order == 0) {
      $builder = $builder->orderBy('id', 'desc');
    } else if ($order == 1) {
      $builder->orderBy('tanggal', $order_dir);
    } else if ($order == 2) {
      $builder->orderBy('dokumen', $order_dir);
    } else if ($order == 3) {
      $builder->orderBy('form', $order_dir);
    } else if ($order == 4) {
      $builder->orderBy('status', $order_dir);
    } else if ($order == 5) {
      $builder->orderBy('user', $order_dir);
    }
    return $builder->get()->getResult();
  }

  public function getid($id = false)
  {
    if ($id == false) {
      return $this->orderby('nomor', 'desc')->findAll();
    }
    return $this->where('id', $id)->findAll();
  }

  public function dokumen($dokumen = false)
  {
    if ($dokumen == false) {
      return $this->orderby('dokumen', 'desc')->findAll();
    }
    return $this->where('dokumen', $dokumen)->findAll();
  }

  public function delete_by_id($id)
  {
    $this->where('id', $id);
    $this->delete();
  }

  public function getperiode($tanggal1 = false, $tanggal2 = false)
  {
    if ($tanggal1 == false) {
      return $this->findAll();
    }
    $this->where('date(tanggal) >=', $tanggal1);
    $this->where('date(tanggal) <=', $tanggal2);
    return $this->findAll();
  }
}
