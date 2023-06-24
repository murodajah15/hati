<?php

namespace App\Models;

use CodeIgniter\Model;

class Tb_temanModel extends Model
{
  protected $table = 'tb_teman';

  public function tampilData($katakunci = null, $start = 0, $length = 0)
  {
    $builder = $this->table('tb_teman');
    if ($katakunci) {
      $arr = explode(" ", $katakunci);
      for ($i = 0; $i < count($arr); $i++) {
        $builder = $builder->orlike('namateman', $arr[$i]);
        $builder = $builder->orlike('alamat', $arr[$i]);
        $builder = $builder->orlike('jeniskelamin', $arr[$i]);
      }
    }
    if ($start != 0 or $length != 0) {
      $builder = $builder->limit($length, $start);
    }
    return $builder->orderBy('namateman', 'asc')->get()->getResult();
  }
}
