<?php

namespace App\Models;

use CodeIgniter\Model;

class MCrudajax extends Model
{
  protected $table = 'tb_teman';

  public function getTeman($id = false)
  {
    if ($id === false) {
      return $this->findAll();
    } else {
      return $this->getWhere(['id' => $id]);
    }
  }

  public function updateTeman($data, $id)
  {
    // dd($data);
    session()->setFlashdata('pesan', 'Data berhasil diubah');
    $update_query = $this->db->table($this->table)->update($data, array('id' => $id));
    return $update_query;
  }

  public function simpanTeman($data)
  {
    session()->setFlashdata('pesan', 'Data berhasil ditambah');
    $simpan_query = $this->db->table($this->table)->insert($data);
    return $simpan_query;
  }

  public function deleteTeman($id)
  {
    session()->setFlashdata('pesan', 'Data berhasil dihapus');
    $delete_query = $this->db->table($this->table)->delete(array('id' => $id));
    return $delete_query;
  }
}
