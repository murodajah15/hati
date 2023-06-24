<?php

namespace App\Models;

use CodeIgniter\Model;

class TbjnbrgModel extends Model
{
  protected $table      = 'tbjnbrg';
  protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = ['kode', 'nama', 'user', 'aktif'];

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
}
