<?php

namespace App\Models;

use CodeIgniter\Model;

$db = \Config\Database::connect();

class MohfakturModel extends Model
{
  protected $table      = 'mohfaktur';
  // protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = [
    'tanggal', 'nomor', 'nospk', 'tglspk', 'nomemo', 'tglmemo', 'nospk', 'tglspk', 'kdsales', 'nmsales', 'kdspv', 'nmspv', 'sama_spk',
    'kdpemesan', 'nmpemesan', 'alamat_pemesan', 'kel_pemesan', 'kec_pemesan', 'kota_pemesan', 'provinsi_pemesan', 'kodepos_pemesan', 'hp_pemesan', 'email_pemesan',
    'sama_pemesan', 'kdstnk', 'nmstnk', 'alamat_stnk', 'kel_stnk', 'kec_stnk', 'kota_stnk', 'provinsi_stnk', 'kodepos_stnk', 'hp_stnk', 'email_stnk',
    'kdmodel', 'nmmodel', 'kdtipe', 'nmtipe', 'norangka', 'nomesin', 'kdwarna', 'nmwarna', 'accessories', 'harga', 'dp', 'tgl_dp', 'eta', 'etd', 'paket', 'jekel', 'tgllahir',
    'status_menikah', 'jumlah_keluarga', 'agama', 'pekerjaan', 'metode_pembelian', 'mobil_tambahan', 'mobil_pengganti', 'metode_pembayaran',
    'leasing', 'tenor', 'bulan', 'asuransi', 'kdsm', 'nmsm', 'tambah_honda', 'tambah_nonhonda', 'ganti_honda', 'ganti_nonhonda',
    'tipe_faktur', 'tipe_pelanggan', 'status_pelanggan', 'nik_pemesan', 'nik_stnk', 'nkk', 'admin', 'valid', 'close', 'batal', 'user',
  ];

  public function tampilData($request, $katakunci = null, $start = 0, $length = 0)
  {
    $builder = $this->table('mohfaktur');
    if ($katakunci) {
      $arr = explode(" ", $katakunci);
      for ($i = 0; $i < count($arr); $i++) {
        $builder = $builder->orlike('tanggal', $arr[$i]);
        $builder = $builder->orlike('nomor', $arr[$i]);
        $builder = $builder->orlike('no_spk', $arr[$i]);
        $builder = $builder->orlike('tgl_spk', $arr[$i]);
        $builder = $builder->orlike('nama_pesan', $arr[$i]);
        $builder = $builder->orlike('user', $arr[$i]);
      }
      // $builder = $builder->orderBy('kode');
    }
    if ($start != 0 or $length != 0) {
      $builder = $builder->orderBy('nomor', 'desc');
      $builder = $builder->limit($length, $start);
    }
    $order = $request->getPost('order[0][column]');
    $order_dir = $request->getPost('order[0][dir]');
    if ($order == 0) {
      $builder = $builder->orderBy('tanggal');
    } else if ($order == 1) {
      $builder->orderBy('tanggal', $order_dir);
    } else if ($order == 2) {
      $builder->orderBy('nomor', $order_dir);
    } else if ($order == 3) {
      $builder->orderBy('no_spk', $order_dir);
    } else if ($order == 4) {
      $builder->orderBy('tgl_spk', $order_dir);
    } else if ($order == 5) {
      $builder->orderBy('nama_pemesan', $order_dir);
    }
    // return $builder->orderBy('kode', 'asc')->get()->getResult();
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
    $builder = $this->db->table("mohfaktur");
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

  public function jumlah_record()
  {
    return $this->db->table('mohfaktur')->countAllResults();
  }
}
