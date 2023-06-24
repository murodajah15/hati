<?php

namespace App\Models;

use CodeIgniter\Model;

class Woopl_bpModel extends Model
{
  protected $table      = 'wo_bp_detail';
  // protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = [
    'nowo', 'kode', 'nama', 'kerusakan', 'jenis', 'qty', 'harga', 'pr_discount', 'paket', 'subtotal',
    'user', 'kdmekanik', 'nmmekanik'
  ];

  public function getid($id = false)
  {
    if ($id == false) {
      return $this->where('jenis', 'OPL')->orderby('id', 'desc')->findAll();
    }
    $this->where('id', $id);
    $this->where('jenis', 'OPL');
    return $this->findAll();
    // return $this->where('jenis', 'PART', 'nowo', $nowo)->findAll();
  }

  public function getnowo($nowo = false)
  {
    if ($nowo == false) {
      return $this->where('jenis', 'OPL')->orderby('nowo', 'desc')->findAll();
    }
    $this->where('nowo', $nowo);
    $this->where('jenis', 'OPL');
    return $this->findAll();
    // return $this->where('jenis', 'PART', 'nowo', $nowo)->findAll();
  }

  public function hapusdetailwo($id)
  {
    $this->where('id', $id);
    $this->delete();
  }

  public function getdoublebarang($nowo = false, $kode = false)
  {
    if ($nowo == false or $kode == false) {
      return $this->findAll();
    }
    $this->where('nowo', $nowo);
    $this->where('kode', $kode);
    $this->where('jenis', 'OPL');
    return $this->findAll();
  }

  public function jumopl($nowo = false)
  {
    $this->where('nowo', $nowo)->select('sum(subtotal) as jumopl');
    $this->where('jenis', 'OPL');
    return $this->findAll();
  }
}
