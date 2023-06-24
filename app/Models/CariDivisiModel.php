<?php

namespace App\Models;

use CodeIgniter\Model;

class CariDivisiModel extends Model
{

  protected $table = 'tbdivisi';

  public function pencarian($kunci)
  {
    return $this->table('tbdivisi')->like('nama', $kunci);
  }
}
