<?php

namespace App\Models;

use CodeIgniter\Model;

class TbdivisiModel extends Model
{
  protected $table      = 'tbdivisi';
  // protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = ['kode', 'nama', 'user'];

  // protected $useAutoIncrement = true;

  // protected $returnType     = 'array';
  // protected $useSoftDeletes = true;

  // protected $allowedFields = ['name', 'email'];

  // protected $useTimestamps = true;
  // protected $createdField  = 'created_at';
  // protected $updatedField  = 'updated_at';
  // protected $deletedField  = 'deleted_at';

  // protected $validationRules    = [];
  // protected $validationMessages = [];
  // protected $skipValidation     = false;

  public function getdivisi($id = false)
  {
    if ($id == false) {
      return $this->findAll();
    }
    return $this->where('id', $id)->first();
    // return $this->where(['slug' => $slug])->first();
  }
  public function getkddivisi($kode = false)
  {
    if ($kode == false) {
      return $this->findAll();
    }
    return $this->where('kode', $kode)->first();
    // return $this->where(['slug' => $slug])->first();
  }
  public function getnmdivisi($nama = false)
  {
    if ($nama == false) {
      return $this->findAll();
    }
    return $this->where('nama', $nama)->first();
    // return $this->where(['slug' => $slug])->first();
  }
}
