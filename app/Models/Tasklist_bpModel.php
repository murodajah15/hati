<?php

namespace App\Models;

use CodeIgniter\Model;

class Tasklist_bpModel extends Model
{
  protected $table      = 'tasklist_bp';
  protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = ['nomor', 'kode', 'nama', 'kdasuransi', 'nmasuransi', 'aktif', 'user'];

  public function tampilData($request, $katakunci = null, $start = 0, $length = 0)
  {
    $builder = $this->table('tasklist_bp');
    if ($katakunci) {
      $arr = explode(" ", $katakunci);
      for ($i = 0; $i < count($arr); $i++) {
        $builder = $builder->orlike('kode', $arr[$i]);
        $builder = $builder->orlike('nama', $arr[$i]);
        $builder = $builder->orlike('kdasuransi', $arr[$i]);
        $builder = $builder->orlike('nmasuransi', $arr[$i]);
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
      $builder->orderBy('kdasuransi', $order_dir);
    } else if ($order == 4) {
      $builder->orderBy('nmasuransi', $order_dir);
    }
    return $builder->get()->getResult();
  }

  public function getid($id = false)
  {
    if ($id == false) {
      return $this->orderBy('kode')->findAll();
    }
    return $this->where('id', $id)->first();
  }

  public function getkode($kode = false)
  {
    if ($kode == false) {
      return $this->orderBy('kode')->findAll();
    }
    return $this->where('kode', $kode)->first();
  }

  public function getnama($nama = false)
  {
    if ($nama == false) {
      return $this->where('aktif', 'Y')->orderBy('nama')->findAll();
    }
    return $this->where('nama', $nama, 'aktif', 'Y')->orderBy('nama')->first();
  }

  public function delete_by_id($id)
  {
    $this->where('id', $id);
    $this->delete();
  }

  public function buatnomor()
  {
    $builder = $this->db->table("tasklist_bp");
    $builder->selectMax('kode');
    return $builder->get()->getResult();
  }
}
