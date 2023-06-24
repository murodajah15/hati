<?php

namespace App\Models;

use CodeIgniter\Model;

class EstimasijasaModel extends Model
{
  protected $table      = 'estimasi_detail';
  // protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = [
    'noestimasi', 'kode', 'nama', 'jenis', 'qty', 'harga', 'pr_discount', 'paket', 'subtotal',
    'user', 'kdmekanik', 'nmmekanik'
  ];

  public function getkode($kode = false)
  {
    if ($kode == false) {
      return $this->findAll();
    }
    $this->where('kode', $kode);
    return $this->findAll();
  }

  public function getnoestimasi($noestimasi = false)
  {
    if ($noestimasi == false) {
      return $this->where('jenis', 'JASA')->orderby('noestimasi', 'desc')->findAll();
    }
    $this->where('noestimasi', $noestimasi);
    $this->where('jenis', 'JASA');
    return $this->findAll();
    // return $this->where('jenis', 'JASA', 'noestimasi', $noestimasi)->findAll();
  }

  public function hapusdetailestimasi($id)
  {
    $this->where('id', $id);
    $this->delete();
  }

  public function hapuspaket($noestimasi)
  {
    $this->where('noestimasi', $noestimasi)->where('paket', 'Y');
    $this->delete();
  }

  public function getdoublebarang($noestimasi = false, $kode = false)
  {
    if ($noestimasi == false or $kode == false) {
      return $this->findAll();
    }
    $this->where('noestimasi', $noestimasi);
    $this->where('kode', $kode);
    $this->where('jenis', 'JASA');
    return $this->findAll();
  }

  public function jumjasa($noestimasi = false)
  {
    $this->where('noestimasi', $noestimasi)->select('sum(subtotal) as jumjasa');
    $this->where('jenis', 'JASA');
    return $this->findAll();
  }
}
