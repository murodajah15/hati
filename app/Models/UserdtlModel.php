<?php

namespace App\Models;

use CodeIgniter\Model;

class UserdtlModel extends Model
{
  protected $table      = 'userdtl';
  // protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = ['iduser', 'idmodule', 'username', 'cmodule', 'cmenu', 'clain', 'cmainmenu', 'nlevel', 'nurut', 'pakai', 'tambah', 'edit', 'hapus', 'proses', 'unproses', 'cetak', 'cparent'];

  public function getId($id = false)
  {
    if ($id == false) {
      return $this->findAll();
    }
    return $this->where('id', $id)->first();
    // return $this->where(['slug' => $slug])->first();
  }

  public function getUsername($username = false)
  {
    if ($username == false) {
      return $this->findAll();
    }
    return $this->where('username', $username)->orderBy('nurut')->findAll();
  }

  public function delete_by_id($id)
  {
    $this->where('iduser', $id);
    $query = $this->delete();
    return $query;
  }

  public function delete_by_username($username)
  {
    // dd($username);
    $this->where('username', $username);
    $query = $this->delete();
    return $query;
  }

  public function updateuserdtl($data, $cmodule, $username)
  {
    // dd($username);
    session()->setFlashdata('pesan', 'Data berhasil diubah');
    $update_query = $this->db->table($this->table)->update($data, array('cmodule' => $cmodule, 'username' => $username));
    return $update_query;
  }

  public function getuserakses($cmenu, $username)
  {
    // dd($module);
    $array = ['cmenu' => $cmenu, 'username' => $username];
    // $builder->where($array);
    // $this->where('cmenu', $cmenu);
    return $this->where($array)->get()->getResult();
  }
}
