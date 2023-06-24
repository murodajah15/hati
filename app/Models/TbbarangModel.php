<?php

namespace App\Models;

use CodeIgniter\Model;

class TbbarangModel extends Model
{
  protected $table      = 'tbbarang';
  // protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = [
    'kode', 'nama', 'lokasi', 'merek', 'harga_jual', 'harga_beli', 'harga_beli_lama', 'hpp', 'hpp_lama', 'stock', 'stock_min', 'stock_mak',
    'kdjnbrg', 'kdsatuan', 'kdnegara', 'kdmove', 'kddiscount', 'aktif', 'user'
  ];

  public function tampilData($request, $katakunci = null, $start = 0, $length = 0)
  {
    $builder = $this->table('tbbarang');
    if ($katakunci) {
      $arr = explode(" ", $katakunci);
      for ($i = 0; $i < count($arr); $i++) {
        $builder = $builder->orlike('kode', $arr[$i]);
        $builder = $builder->orlike('nama', $arr[$i]);
        $builder = $builder->orlike('lokasi', $arr[$i]);
        $builder = $builder->orlike('stock', $arr[$i]);
        $builder = $builder->orlike('harga_jual', $arr[$i]);
        $builder = $builder->orlike('user', $arr[$i]);
      }
      $builder = $builder->orderBy('kode');
    }
    if ($start != 0 or $length != 0) {
      // $builder = $builder->orderBy('kode', 'desc');
      $builder = $builder->limit($length, $start);
    }
    $order = $request->getPost('order[0][column]');
    $order_dir = $request->getPost('order[0][dir]');
    if ($order == 0) {
      $builder = $builder->orderBy('kode', 'asc');
    } else if ($order == 1) {
      $builder->orderBy('kode', $order_dir);
    } else if ($order == 2) {
      $builder->orderBy('nama', $order_dir);
    } else if ($order == 3) {
      $builder->orderBy('lokasi', $order_dir);
    } else if ($order == 4) {
      $builder->orderBy('stock', $order_dir);
    } else if ($order == 5) {
      $builder->orderBy('harga_jual', $order_dir);
    } else if ($order == 6) {
      $builder->orderBy('aktif', $order_dir);
    }
    // return $builder->orderBy('kode', 'asc')->get()->getResult();
    return $builder->get()->getResult();
  }


  public function getbarang($id = false)
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

  public function getnama($kode = false)
  {
    if ($kode == false) {
      return $this->findAll();
    }
    return $this->where('nama', $kode)->first();
    // return $this->where(['slug' => $slug])->first();
  }

  public function getkdbarang($kode = false)
  {
    if ($kode == false) {
      return $this->findAll();
    }
    return $this->where('kode', $kode)->first();
    // return $this->where(['slug' => $slug])->first();
  }

  public function getnmbarang($nama = false)
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

  public function getkodedisc($kodedisc = false)
  {
    if ($kodedisc == false) {
      return $this->findAll();
    }
    return $this->where('kddiscount', $kodedisc)->first();
    // return $this->where(['slug' => $slug])->first();
  }

  public function getkodesatuan($kodesatuan = false)
  {
    if ($kodesatuan == false) {
      return $this->findAll();
    }
    return $this->where('kdsatuan', $kodesatuan)->first();
    // return $this->where(['slug' => $slug])->first();
  }

  public function getkodemove($kodemove = false)
  {
    if ($kodemove == false) {
      return $this->findAll();
    }
    return $this->where('kdmove', $kodemove)->first();
    // return $this->where(['slug' => $slug])->first();
  }

  public function getkodenegara($kodenegara = false)
  {
    if ($kodenegara == false) {
      return $this->findAll();
    }
    return $this->where('kdnegara', $kodenegara)->first();
    // return $this->where(['slug' => $slug])->first();
  }

  public function getkodejnbrg($kodejnbrg = false)
  {
    if ($kodejnbrg == false) {
      return $this->findAll();
    }
    return $this->where('kdjnbrg', $kodejnbrg)->first();
    // return $this->where(['slug' => $slug])->first();
  }
}
