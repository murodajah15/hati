<?php

namespace App\Models;

use CodeIgniter\Model;

class Wopart_bpModel extends Model
{
  protected $table      = 'wo_bp_detail';
  // protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = [
    'nowo', 'kode', 'nama', 'jenis', 'qty', 'harga', 'pr_discount', 'paket', 'subtotal',
    'user', 'kdmekanik', 'nmmekanik'
  ];

  public function getid($id = false)
  {
    if ($id == false) {
      return $this->findAll();
    }
    $this->where('id', $id);
    return $this->findAll();
  }

  public function getkode($kode = false)
  {
    if ($kode == false) {
      return $this->findAll();
    }
    $this->where('kode', $kode);
    return $this->findAll();
  }

  public function getnowo($nowo = false)
  {
    if ($nowo == false) {
      return $this->where('jenis', 'PART')->orderby('nowo', 'desc')->findAll();
    }
    $this->where('nowo', $nowo);
    $this->where('jenis', 'PART');
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
    $this->where('jenis', 'PART');
    return $this->findAll();
  }

  public function jumpart($nowo = false)
  {
    $this->where('nowo', $nowo)->select('sum(subtotal) as jumpart');
    $this->where('jenis', 'PART');
    return $this->findAll();
  }

  public function jumpart_close($nowo = false)
  {
    $this->where('nowo', $nowo)->select('sum(subtotal) as jumpart');
    $this->where('jenis', 'PART');
    $this->where('close_part', 1);
    return $this->findAll();
  }
}
