<?php

namespace App\Models;

use CodeIgniter\Model;

class WoparttempModel extends Model
{
  protected $table      = 'wo_part_temp';
  // protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = [
    'nowo', 'kodepart', 'namapart', 'qty', 'harga', 'pr_discount', 'subtotal'
  ];

  public function getwo($id = false)
  {
    if ($id == false) {
      return $this->findAll();
    }
    return $this->getWhere(['id' => $id]);
    // return $this->where('id', $id)->first();
  }

  public function getwoparttemp($nowo = false)
  {
    if ($nowo == false) {
      return $this->findAll();
    }
    // return $this->where('nowo', $nowo)->first();
    return $this->where(['nowo' => $nowo])->first();
  }

  public function delete_by_id($id)
  {
    $this->where('id', $id);
    $this->delete();
  }
}
