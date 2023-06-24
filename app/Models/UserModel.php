<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
  protected $table = 'user';
  protected $allowedFields = ['nama', 'email', 'password', 'created_at', 'nama_lengkap', 'nohp'];

  public function getUser($nama = false)
  {
    if ($nama == false) {
      return $this->findAll();
    }
    return $this->where('nama', $nama)->first();
  }
}
