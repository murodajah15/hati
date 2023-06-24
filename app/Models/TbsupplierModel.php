<?php

namespace App\Models;

use CodeIgniter\Model;

class TbsupplierModel extends Model
{
  protected $table      = 'tbsupplier';
  // protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = [
    'kode', 'kelompok', 'nama', 'alamat', 'kota', 'kelurahan', 'kecamatan', 'kodepos', 'telp',
    'npwp', 'alamat_npwp', 'nama_npwp', 'mak_hutang', 'tgl_register', 'user', 'contact_person', 'no_contact_person', 'aktif'
  ];

  public function tampilData($request, $katakunci = null, $start = 0, $length = 0)
  {
    $builder = $this->table('tbsupplier');
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
      $builder->orderBy('kelompok', $order_dir);
    } else if ($order == 3) {
      $builder->orderBy('nama', $order_dir);
    } else if ($order == 4) {
      $builder->orderBy('alamat', $order_dir);
    }
    return $builder->orderBy('kode', 'asc')->get()->getResult();
    // return $builder->get()->getResult();
  }

  public function getsupplier($id = false)
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
    $builder = $this->db->table("tbsupplier");
    $builder->selectMax('kode');
    return $builder->get()->getResult();
  }
}
