<?php

namespace App\Models;

use CodeIgniter\Model;

class SaplikasiModel extends Model
{
  protected $table      = 'saplikasi';
  protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = ['kd_perusahaan', 'nm_perusahaan', 'alamat', 'telp', 'npwp', 'pejabat_1', 'pejabat_2', 'logo', 'user', 'aktif'];

  public function getid($id = false)
  {
    if ($id == false) {
      return $this->orderBy('kd_perusahaan')->findAll();
    }
    return $this->where('id', $id)->orderBy('kd_perusahaan')->first();
  }

  public function getkode($kode = false)
  {
    if ($kode == false) {
      return $this->findAll();
    }
    return $this->where('kode', $kode)->first();
  }

  public function getnama($nama = false)
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

  public function hapusbanyak($id, $jmldata)
  {
    // for ($i = 0; $i < $jmldata; $i++) {
    //   $this->where('id', ['id' => $id[$i]]);
    //   $this->delete();
    // }
    $this->whereIn('logo', $id);
    $this->delete();
    return true;
  }
}
