<?php

namespace App\Models;

use CodeIgniter\Model;

class TbasuransiModel extends Model
{
  protected $table      = 'tbasuransi';
  // protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = [
    'kode', 'nama', 'alamat', 'kota', 'telp', 'fax', 'email', 'contact_person', 'no_contact_person',
    'npwp', 'nama_npwp', 'nppkp', 'top', 'kredit_limit', 'disc_part', 'disc_jasa', 'disc_bahan', 'pph_jasa', 'pph_material',
    'user', 'aktif'
  ];

  public function tampilData($request, $katakunci = null, $start = 0, $length = 0)
  {
    $builder = $this->table('tbasuransi');
    if ($katakunci) {
      $arr = explode(" ", $katakunci);
      for ($i = 0; $i < count($arr); $i++) {
        $builder = $builder->orlike('kode', $arr[$i]);
        $builder = $builder->orlike('nama', $arr[$i]);
        $builder = $builder->orlike('alamat', $arr[$i]);
        $builder = $builder->orlike('user', $arr[$i]);
      }
    }
    if ($start != 0 or $length != 0) {
      $builder = $builder->limit($length, $start);
    }
    $order = $request->getPost('order[0][column]');
    $order_dir = $request->getPost('order[0][dir]');
    if ($order == 0) {
      $builder = $builder->orderBy('kode', 'desc');
    } else if ($order == 1) {
      $builder->orderBy('kode', $order_dir);
    } else if ($order == 2) {
      $builder->orderBy('nama', $order_dir);
    } else if ($order == 3) {
      $builder->orderBy('alamat', $order_dir);
    }
    return $builder->orderBy('kode', 'asc')->get()->getResult();
    // return $builder->get()->getResult();
  }

  public function getasuransi($id = false)
  {
    if ($id == false) {
      return $this->findAll();
    }
    return $this->getWhere(['id' => $id]);
    // return $this->where('id', $id)->first();
  }

  public function getkode($kode = false)
  {
    if ($kode == false) {
      return $this->findAll();
    }
    return $this->where('kode', $kode)->first();
    // return $this->where(['slug' => $slug])->first();
  }

  public function getnama($nama = false)
  {
    if ($nama == false) {
      return $this->findAll();
    }
    return $this->where('nama', $nama)->first();
    // return $this->where(['slug' => $slug])->first();
  }

  public function delete_by_id($id)
  {
    $this->where('id', $id);
    $this->delete();
  }

  public function buatkode()
  {
    $builder = $this->db->table("tbasuransi");
    $builder->selectMax('kode');
    return $builder->get()->getResult();
  }
}
