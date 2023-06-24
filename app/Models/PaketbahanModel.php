<?php

namespace App\Models;

use CodeIgniter\Model;

class PaketbahanModel extends Model
{
  protected $table      = 'tbpaket_detail';
  // protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = [
    'kdpaket', 'kode', 'nama', 'jenis', 'kdtipe', 'qty', 'user'
  ];

  public function getkode($kode = false)
  {
    if ($kode == false) {
      return $this->findAll();
    }
    $this->where('kode', $kode);
    return $this->findAll();
  }

  public function getkdpaket($kdpaket = false)
  {
    if ($kdpaket == false) {
      return $this->where('jenis', 'BAHAN')->orderby('kdpaket', 'desc')->findAll();
    }
    $this->where('kdpaket', $kdpaket);
    $this->where('jenis', 'BAHAN');
    return $this->findAll();
    // return $this->where('jenis', 'BAHAN', 'kdpaket', $kdpaket)->findAll();
  }

  public function hapusdetailpaket($id)
  {
    $this->where('id', $id);
    $this->delete();
  }

  public function getdoublebarang($kdpaket = false, $kode = false)
  {
    if ($kdpaket == false or $kode == false) {
      return $this->findAll();
    }
    $this->where('kdpaket', $kdpaket);
    $this->where('kode', $kode);
    $this->where('jenis', 'BAHAN');
    return $this->findAll();
  }
}
