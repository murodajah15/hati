<?php

namespace App\Models;

use CodeIgniter\Model;

class EstimasioplModel extends Model
{
  protected $table      = 'estimasi_detail';
  // protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = [
    'noestimasi', 'kode', 'nama', 'jenis', 'qty', 'harga', 'pr_discount', 'paket', 'subtotal', 'user', 'kdmekanik', 'nmmekanik',
  ];

  public function getnoestimasi($noestimasi = false)
  {
    if ($noestimasi == false) {
      return $this->where('jenis', 'OPL')->orderby('noestimasi', 'desc')->findAll();
    }
    $this->where('noestimasi', $noestimasi);
    $this->where('jenis', 'OPL');
    return $this->findAll();
    // return $this->where('jenis', 'PART', 'noestimasi', $noestimasi)->findAll();
  }

  public function hapusdetailestimasi($id)
  {
    $this->where('id', $id);
    $this->delete();
  }

  public function getdoublebarang($noestimasi = false, $kode = false)
  {
    if ($noestimasi == false or $kode == false) {
      return $this->findAll();
    }
    $this->where('noestimasi', $noestimasi);
    $this->where('kode', $kode);
    $this->where('jenis', 'OPL');
    return $this->findAll();
  }

  public function jumopl($noestimasi = false)
  {
    $this->where('noestimasi', $noestimasi)->select('sum(subtotal) as jumopl');
    $this->where('jenis', 'OPL');
    return $this->findAll();
  }
}
