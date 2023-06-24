<?php

namespace App\Models;

use CodeIgniter\Model;

$db = \Config\Database::connect();

class PenerimaankasirModel extends Model
{
  protected $table      = 'penerimaankasir';
  // protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = [
    'tanggal', 'nomor', 'nomemo', 'tglmemo', 'nospk', 'tglspk', 'kdcustomer', 'nmcustomer', 'piutang', 'penerimaan', 'kdacc', 'nmacc', 'bank_charge_pr',
    'bank_charge', 'total_penerimaan', 'keterangan', 'cara_bayar', 'kdbank', 'nmbank', 'pemegang_kartu', 'kdjnkartu', 'nmjnkartu', 'norek', 'nocek',
    'tglcek', 'tgljttempocek', 'valid', 'batal', 'user',
  ];

  public function tampilData($request, $katakunci = null, $start = 0, $length = 0)
  {
    $builder = $this->table('penerimaankasir');
    if ($katakunci) {
      $arr = explode(" ", $katakunci);
      for ($i = 0; $i < count($arr); $i++) {
        $builder = $builder->orlike('nomor', $arr[$i]);
        $builder = $builder->orlike('tanggal', $arr[$i]);
        $builder = $builder->orlike('nospk', $arr[$i]);
        $builder = $builder->orlike('nmcustomer', $arr[$i]);
        $builder = $builder->orlike('total_penerimaan', $arr[$i]);
        $builder = $builder->orlike('user', $arr[$i]);
      }
      // $builder = $builder->orderBy('kode');
    }
    if ($start != 0 or $length != 0) {
      // $builder = $builder->orderBy('nomor', 'desc');
      $builder = $builder->limit($length, $start);
    }
    $order = $request->getPost('order[0][column]');
    $order_dir = $request->getPost('order[0][dir]');
    if ($order == 0) {
      $builder = $builder->orderBy('nomor', 'desc');
    } else if ($order == 1) {
      $builder->orderBy('nomor', $order_dir);
    } else if ($order == 2) {
      $builder->orderBy('tanggal', $order_dir);
    } else if ($order == 3) {
      $builder->orderBy('nospk', $order_dir);
    } else if ($order == 4) {
      $builder->orderBy('nmcustomer', $order_dir);
    } else if ($order == 5) {
      $builder->orderBy('total_penerimaan', $order_dir);
    }
    return $builder->get()->getResult();
  }

  public function getid($id = false)
  {
    if ($id == false) {
      return $this->orderby('nomor', 'desc')->findAll();
    }
    return $this->where('id', $id)->findAll();
  }

  public function getnomor($nomor = false)
  {
    if ($nomor == false) {
      return $this->orderby('nomor', 'desc')->findAll();
    }
    return $this->where('nomor', $nomor)->findAll();
  }

  public function getnomemo($nomemo = false)
  {
    if ($nomemo == false) {
      return $this->orderby('nomemo', 'desc')->findAll();
    }
    return $this->where('nomemo', $nomemo)->findAll();
  }

  public function delete_by_id($id)
  {
    $this->where('id', $id);
    $this->delete();
  }

  public function buatnomor()
  {
    $builder = $this->db->table("penerimaankasir");
    $builder->selectMax('nomor');
    return $builder->get()->getResult();
  }

  public function getperiode($tanggal1 = false, $tanggal2 = false)
  {
    if ($tanggal1 == false) {
      return $this->findAll();
    }
    $this->where('date(tanggal) >=', $tanggal1);
    $this->where('date(tanggal) <=', $tanggal2);
    return $this->findAll();
  }
}
