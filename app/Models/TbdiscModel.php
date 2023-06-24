<?php

namespace App\Models;

use CodeIgniter\Model;

class TbdiscModel extends Model
{
  protected $table      = 'tbdisc';
  protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = ['kode', 'disc_normal', 'disc_urgent', 'disc_hotline', 'user', 'aktif'];

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
