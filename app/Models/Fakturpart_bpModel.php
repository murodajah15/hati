<?php

namespace App\Models;

use CodeIgniter\Model;

class Fakturpart_bpModel extends Model
{
  protected $table      = 'faktur_bp_detail';
  // protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = [
    'nofaktur', 'kode', 'nama', 'jenis', 'qty', 'harga', 'pr_discount', 'paket', 'subtotal',
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

  public function getnofaktur($nofaktur = false)
  {
    if ($nofaktur == false) {
      return $this->where('jenis', 'PART')->orderby('nofaktur', 'desc')->findAll();
    }
    $this->where('nofaktur', $nofaktur);
    $this->where('jenis', 'PART');
    return $this->findAll();
    // return $this->where('jenis', 'PART', 'nofaktur', $nofaktur)->findAll();
  }

  public function hapusdetailfaktur($id)
  {
    $this->where('id', $id);
    $this->delete();
  }

  public function getdoublebarang($nofaktur = false, $kode = false)
  {
    if ($nofaktur == false or $kode == false) {
      return $this->findAll();
    }
    $this->where('nofaktur', $nofaktur);
    $this->where('kode', $kode);
    $this->where('jenis', 'PART');
    return $this->findAll();
  }

  public function jumpart($nofaktur = false)
  {
    $this->where('nofaktur', $nofaktur)->select('sum(subtotal) as jumpart');
    $this->where('jenis', 'PART');
    return $this->findAll();
  }
}
