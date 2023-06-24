<?php

namespace App\Models;

use CodeIgniter\Model;

class TbcustomerModel extends Model
{
  protected $table      = 'tbcustomer';
  // protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = [
    'kode', 'kelompok', 'nama', 'alamat', 'kota', 'kelurahan', 'kecamatan', 'kodepos', 'telp1', 'telp2',
    'agama', 'tgl_lahir', 'alamat_ktr', 'kelurahan_ktr', 'kecamatan_ktr', 'kota_ktr', 'kodepos_ktr', 'telp1_ktr', 'telp2_ktr',
    'npwp', 'alamat_npwp', 'nama_npwp', 'nik', 'alamat_ktp', 'kelurahan_ktp', 'kecamatan_ktp', 'kota_ktp', 'kodepos_ktp', 'contact_person_rmh', 'mak_piutang', 'tgl_register', 'user',
    'contact_person', 'no_contact_person', 'provinsi', 'provinsi_ktp', 'provinsi_ktr', 'email'
  ];

  public function tampilData($request, $katakunci = null, $start = 0, $length = 0)
  {
    $builder = $this->table('tbcustomer');
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

  public function getcustomer($id = false)
  {
    if ($id == false) {
      return $this->findAll();
    }
    return $this->getWhere(['id' => $id]);
    // return $this->where('id', $id)->first();
  }

  public function getkdcustomer($kode = false)
  {
    if ($kode == false) {
      return $this->findAll();
    }
    return $this->where('kode', $kode)->first();
    // return $this->where(['slug' => $slug])->first();
  }

  public function getnmcustomer($nama = false)
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
    $builder = $this->db->table("tbcustomer");
    $builder->selectMax('kode');
    return $builder->get()->getResult();
  }

  public function getkodeagama($kodeagama = false)
  {
    if ($kodeagama == false) {
      return $this->findAll();
    }
    return $this->where('kdagama', $kodeagama)->first();
    // return $this->where(['slug' => $slug])->first();
  }

  public function getnamaagama($namaagama = false)
  {
    if ($namaagama == false) {
      return $this->findAll();
    }
    return $this->where('agama', $namaagama)->first();
    // return $this->where(['slug' => $slug])->first();
  }
}
