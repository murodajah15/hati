<?php

namespace App\Models;

use CodeIgniter\Model;

class Tasklist_bpdModel extends Model
{
  protected $table      = 'tasklist_bpd';
  // protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = [
    'kdtasklist', 'kode', 'nama', 'kdasuransi', 'harga', 'user'
  ];

  public function getkode($kode = false)
  {
    if ($kode == false) {
      return $this->findAll();
    }
    $this->where('kode', $kode);
    return $this->findAll();
  }

  public function getkdtl($kdtl = false)
  {
    if ($kdtl == false) {
      return $this->orderby('kdtasklist')->findAll();
    }
    $this->where('kdtasklist', $kdtl);
    return $this->findAll();
  }

  public function getdata($kdtl = false, $kode = false)
  {
    if ($kdtl == false) {
      return $this->orderby('kdtasklist')->findAll();
    }
    $this->where('kdtasklist', $kdtl);
    $this->where('kode', $kode);
    return $this->findAll();
  }

  public function delete_by_id($id)
  {
    $this->where('id', $id);
    $this->delete();
  }

  public function getdoublebarang($kdtl = false, $kode = false)
  {
    if ($kdtl == false or $kode == false) {
      // return $this->findAll();
    }
    $this->where('kdtasklist', $kdtl);
    $this->where('kode', $kode);
    return $this->findAll();
  }
}
