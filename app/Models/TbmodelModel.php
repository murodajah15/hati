<?php

namespace App\Models;

use CodeIgniter\Model;

class TbmodelModel extends Model
{
  protected $table      = 'tbmodel';
  protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = ['kode', 'nama', 'kdmerek', 'user', 'aktif'];

  public function getid($id = false)
  {
    if ($id == false) {
      $builder = $this->db->table("tbmodel as tbmodel");
      $builder->select('tbmodel.id, tbmodel.kode as kdmodel,tbmodel.nama as nmmodel,tbmodel.user,tbmodel.kdmerek,tbmerek.nama as nmmerek,tbmodel.aktif as aktif');
      $builder->join('tbmerek as tbmerek', 'tbmodel.kdmerek = tbmerek.kode', 'left');
      return $builder->get()->getResult();
      // return $this->orderBy('kode')->findAll();
    }
    return $this->where('id', $id)->first();
  }

  public function getkode($kode = false)
  {
    if ($kode == false) {
      $builder = $this->db->table("tbmodel as tbmodel");
      $builder->select('tbmodel.id, tbmodel.kode as kdmodel,tbmodel.nama as nmmodel,tbmodel.user,tbmodel.kdmerek,tbmerek.nama as nmmerek,tbmodel.aktif as aktif');
      $builder->join('tbmerek as tbmerek', 'tbmerek.kode = tbmodel.kdmerek', 'left');
      return $builder->get()->getResult();
      // return $this->orderBy('kode')->findAll();
    }
    return $this->where('kode', $kode)->first();
  }

  public function getmerek($kode = false)
  {
    if ($kode == false) {
      return $this->where('aktif', 'Y')->orderBy('kdmerek')->findAll();
    }
    // return $this->where('kdmerek', $kode, 'aktif', 'Y')->first();
    $builder = $this->db->table("tbmodel");
    $builder->select('*');
    $builder->where('kdmerek', $kode);
    $builder->where('aktif', 'Y');
    return $builder->get()->getResult();
  }

  public function gettipe($kode = false)
  {
    if ($kode == false) {
      return $this->where('aktif', 'Y')->orderBy('kdtipe')->findAll();
    }
    // return $this->where('kdmerek', $kode, 'aktif', 'Y')->first();
    $builder = $this->db->table("tbmodel");
    $builder->select('*');
    $builder->where('kdtipe', $kode);
    $builder->where('aktif', 'Y');
    return $builder->get()->getResult();
  }

  public function getnama($nama = false)
  {
    if ($nama == false) {
      return $this->where('aktif', 'Y')->orderBy('nama')->findAll();
    }
    return $this->where('nama', $nama)->orderBy('nama')->first();
  }

  public function delete_by_id($id)
  {
    $this->where('id', $id);
    $this->delete();
  }
}
