<?php

namespace App\Models;

use CodeIgniter\Model;

class TbmoduleModel extends Model
{
  protected $table      = 'tbmodule';
  protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = ['nurut', 'cmodule', 'cmenu', 'clokasi_menu', 'nlevel', 'cmainmenu', 'nurut', 'clain', 'cparent'];

  public function getmodule($id = false)
  {
    if ($id == false) {
      return $this->orderBy('nurut')->findAll();
    }
    return $this->where('id', $id)->orderBy('nurut')->first();
  }

  public function getkdmodule($kode = false)
  {
    if ($kode == false) {
      return $this->findAll();
    }
    return $this->where('kode', $kode)->first();
  }

  public function getnmmodule($nama = false)
  {
    if ($nama == false) {
      return $this->findAll();
    }
    return $this->where('nama', $nama)->first();
  }

  public function delete_by_id($id)
  {
    $this->where('id', $id);
    $this->delete();
  }
}
