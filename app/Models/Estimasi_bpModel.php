<?php

namespace App\Models;

use CodeIgniter\Model;

class Estimasi_bpModel extends Model
{
  protected $table      = 'estimasi_bp';
  // protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = [
    'noestimasi', 'nowo', 'tanggal', 'nopolisi', 'norangka', 'kdpemilik', 'nmpemilik', 'no_polis', 'nama_polis',
    'tgl_akhir_polis', 'kode_asuransi', 'nama_asuransi', 'alamat_asuransi', 'kdsa', 'keluhan', 'kdservice', 'km', 'kdpaket',
    'nmservice', 'aktifitas', 'fasilitas', 'status_tunggu', 'int_reminder', 'via', 'close',
    'batal', 'ket_batal', 'user_batal', 'tgl_batal', 'status_member',
    'klaim', 'internal', 'inventaris', 'campaign', 'booking', 'lain_lain', 'surveyor',
    'npwp', 'contact_person', 'no_contact_person', 'user', 'total_jasa', 'total_part', 'total_bahan', 'total_opl', 'total', 'dpp', 'pr_ppn', 'ppn', 'total_estimasi'
  ];

  public function tampilData($katakunci = null, $start = 0, $length = 0,)
  {
    $builder = $this->table('estimasi_bp');
    if ($katakunci) {
      $arr = explode(" ", $katakunci);
      for ($i = 0; $i < count($arr); $i++) {
        $builder = $builder->orlike('nowo', $arr[$i]);
        $builder = $builder->orlike('noestimasi', $arr[$i]);
        $builder = $builder->orlike('nopolisi', $arr[$i]);
        $builder = $builder->orlike('user', $arr[$i]);
      }
    }
    if ($start != 0 or $length != 0) {
      $builder = $builder->limit($length, $start);
    }
    return $builder->orderBy('noestimasi', 'desc')->get()->getResult();
    // return $builder->get()->getResult();
  }

  public function tampilDatawopart($katakunci = null, $start = 0, $length = 0,)
  {
    $builder = $this->table('wo');
    if ($katakunci) {
      $arr = explode(" ", $katakunci);
      for ($i = 0; $i < count($arr); $i++) {
        $builder = $builder->orlike('nowo', $arr[$i]);
        $builder = $builder->orlike('noestimasi', $arr[$i]);
        $builder = $builder->orlike('nopolisi', $arr[$i]);
        $builder = $builder->orlike('user', $arr[$i]);
      }
    }
    if ($start != 0 or $length != 0) {
      $builder = $builder->limit($length, $start);
    }
    return $builder->orderBy('noestimasi', 'desc')->get()->getResult();
    // $db = \Config\Database::connect();
    // $query   = $db->query("create temporary table temp_wo_part select * from wo_part limit 0");
    // $builder = $db->table('temp_wo_part');
    // $query    = $builder->get();
    // $results = $query->getResultArray();
    // foreach ($results as $row) {
    //   echo '<tr><td>' . $row['nowo'] . '<td>' . $row['user'] . '</td>';
    // }
    // if ($katakunci) {
    //   $arr = explode(" ", $katakunci);
    //   for ($i = 0; $i < count($arr); $i++) {
    //     $builder = $builder->orlike('nowo', $arr[$i]);
    //     $builder = $builder->orlike('user', $arr[$i]);
    //   }
    // }
    // if ($start != 0 or $length != 0) {
    //   $builder = $builder->limit($length, $start);
    // }
    // return $builder->orderBy('nowo', 'desc')->get()->getResult();
  }

  public function getid($id = false)
  {
    if ($id == false) {
      return $this->orderby('noestimasi', 'desc')->findAll();
    }
    return $this->where('id', $id)->findAll();
  }

  public function getnoestimasi($noestimasi = false)
  {
    if ($noestimasi == false) {
      return $this->orderby('noestimasi', 'desc')->findAll();
    }
    return $this->where('noestimasi', $noestimasi)->findAll();
  }

  public function getwo($nopolisi = false)
  {
    if ($nopolisi == false) {
      return $this->orderby('noestimasi', 'desc')->findAll();
    }
    return $this->where('nopolisi', $nopolisi)->findAll();
  }

  public function getkdcustomer($nowo = false)
  {
    if ($nowo == false) {
      return $this->findAll();
    }
    return $this->where('noestimasi', $nowo)->first();
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

  public function getnopolisi($nopolisi = false)
  {
    if ($nopolisi == false) {
      return $this->findAll();
    }
    return $this->where('nopolisi', $nopolisi)->orderby('noestimasi', 'desc')->findAll();
  }

  public function getsa($kode = false)
  {
    if ($kode == false) {
      return $this->findAll();
    }
    return $this->where('kdsa', $kode)->orderby('noestimasi', 'desc')->findAll();
  }

  public function getkodeservice($kode = false)
  {
    if ($kode == false) {
      return $this->findAll();
    }
    $this->where('kdservice', $kode);
    return $this->findAll();
  }

  public function getasuransi($kode = false)
  {
    if ($kode == false) {
      return $this->findAll();
    }
    $this->where('kode_asuransi', $kode);
    return $this->findAll();
  }

  public function delete_by_id($id)
  {
    $this->where('id', $id);
    $this->delete();
  }

  public function buatnoestimasi()
  {
    $builder = $this->db->table("estimasi_bp");
    $builder->selectMax('noestimasi');
    return $builder->get()->getResult();
  }
}
