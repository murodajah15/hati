<?php

namespace App\Models;

use CodeIgniter\Model;

class TbtipeModel extends Model
{
  protected $table      = 'tbtipe';
  protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = ['kode', 'nama', 'user', 'kdmodel', 'aktif'];

  public function getid($id = false)
  {
    if ($id == false) {
      $builder = $this->db->table("tbtipe as tbtipe");
      $builder->select('tbtipe.id, tbtipe.kode as kdtipe,tbtipe.nama as nmtipe,tbtipe.user,tbmodel.kode as kdmodel,tbmodel.nama as nmmodel,tbtipe.aktif as aktif');
      $builder->join('tbmodel as tbmodel', 'tbtipe.kdmodel = tbmodel.kode', 'left');
      return $builder->get()->getResult();
      // return $this->orderBy('kode')->findAll();
    }
    return $this->where('id', $id)->first();
  }

  public function getkode($kode = false)
  {
    if ($kode == false) {
      $builder = $this->db->table("tbtipe as tbtipe");
      $builder->select('tbtipe.id, tbtipe.kode as kdtipe,tbtipe.nama as nmtipe,tbtipe.user,tbmodel.kode as kdmodel,tbmodel.nama as nmmodel,tbtipe.aktif as aktif');
      $builder->join('tbmodel as tbmodel', 'tbtipe.kdmodel = tbmodel.kode', 'left');
      return $builder->get()->getResult();
      // return $this->orderBy('kode')->findAll();
    }
    return $this->where('kode', $kode)->first();
  }

  public function getnama($nama = false)
  {
    if ($nama == false) {
      return $this->orderBy('nama')->findAll();
    }
    return $this->where('nama', $nama)->orderBy('nama')->first();
  }

  public function delete_by_id($id)
  {
    $this->where('id', $id);
    $this->delete();
  }

  public function getmodel($kode = false)
  {
    if ($kode == "") {
      return $this->where('aktif', 'Y')->orderBy('kdmodel')->findAll();
    }
    $builder = $this->db->table("tbtipe");
    $builder->select('*');
    $builder->where('kdmodel', $kode);
    $builder->where('aktif', 'Y')->orderBy('kdmodel');
    return $builder->get()->getResult();
  }
}
