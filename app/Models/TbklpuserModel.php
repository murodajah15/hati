<?php

namespace App\Models;

use CodeIgniter\Model;

class TbklpuserModel extends Model
{
  protected $table      = 'tbklpuser';
  protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = ['kelompok', 'user'];

  public function getid($id = false)
  {
    if ($id == false) {
      return $this->orderBy('kelompok')->findAll();
    }
    return $this->where('id', $id)->first();
  }

  public function getkelompok($kelompok = false)
  {
    if ($kelompok == false) {
      return $this->orderBy('kelompok')->findAll();
    }
    return $this->where('kelompok', $kelompok)->first();
  }

  public function delete_by_id($id)
  {
    $this->where('id', $id);
    $this->delete();
  }
}
