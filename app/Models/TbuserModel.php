<?php

namespace App\Models;

use CodeIgniter\Model;

class TbuserModel extends Model
{
  protected $table      = 'user';
  protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = ['email', 'password', 'nama', 'nama_lengkap', 'nohp', 'level', 'kelompok', 'user', 'photo'];

  public function getuser($id = false)
  {
    if ($id == false) {
      return $this->findAll();
    }
    return $this->where('id', $id)->first();
  }
  public function getkduser($kode = false)
  {
    if ($kode == false) {
      return $this->findAll();
    }
    return $this->where('kode', $kode)->first();
  }
  public function getnmuser($nama = false)
  {
    if ($nama == false) {
      return $this->findAll();
    }
    return $this->where('nama', $nama)->first();
  }

  public function delete_by_id($id)
  {
    $this->where('id', $id);
    $query = $this->delete();
    return $query;
  }
}
