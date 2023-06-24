<?php

namespace App\Models;

use CodeIgniter\Model;

class Fakturjasa_bpModel extends Model
{
  protected $table      = 'faktur_bp_detail';
  // protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = [
    'nofaktur', 'kode', 'nama', 'kerusakan', 'jenis', 'qty', 'harga', 'pr_discount', 'paket', 'subtotal',
    'user', 'kdmekanik', 'nmmekanik'
  ];

  public function getid($id = false)
  {
    if ($id == false) {
      return $this->orderby('nofaktur', 'desc')->findAll();
    }
    $this->where('id', $id);
    $this->where('jenis', 'JASA');
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
      return $this->where('jenis', 'JASA')->orderby('nofaktur', 'desc')->findAll();
    }
    $this->where('nofaktur', $nofaktur);
    $this->where('jenis', 'JASA');
    return $this->findAll();
    // return $this->where('jenis', 'JASA', 'nofaktur', $nofaktur)->findAll();
  }

  public function hapusdetailwo($id)
  {
    $this->where('id', $id);
    $this->delete();
  }

  public function hapuspaket($nofaktur)
  {
    $this->where('nofaktur', $nofaktur)->where('paket', 'Y');
    $this->delete();
  }

  public function getdoublebarang($nofaktur = false, $kode = false)
  {
    if ($nofaktur == false or $kode == false) {
      return $this->findAll();
    }
    $this->where('nofaktur', $nofaktur);
    $this->where('kode', $kode);
    $this->where('jenis', 'JASA');
    return $this->findAll();
  }

  public function jumjasa($nofaktur = false)
  {
    $this->where('nofaktur', $nofaktur)->select('sum(subtotal) as jumjasa');
    $this->where('jenis', 'JASA');
    return $this->findAll();
  }
}
