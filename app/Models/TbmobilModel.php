<?php

namespace App\Models;

use CodeIgniter\Model;

class TbmobilModel extends Model
{
  protected $table      = 'tbmobil';
  protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $allowedFields = [
    'nopolisi', 'norangka', 'nomesin', 'kdmerek', 'kdmodel', 'kdtipe', 'kdwarna', 'kdjenis', 'nostnk', 'tglstnk', 'bahanbakar',
    'dealerjual', 'tglserahdealer', 'kdpemilik', 'nmpemilik', 'kdpemakai', 'nmpemakai', 'kode_asuransi', 'nama_asuransi', 'alamat_asuransi', 'user',
    'npwp', 'contact_person', 'no_contact_person'
  ];

  public function tampilData($request, $katakunci = null, $start = 0, $length = 0)
  {
    // $builder = $this->table('tbmobil');
    $builder = $this->db->table("tbmobil as tbmobil");
    $builder->select('tbmobil.id, tbmobil.nopolisi as nopolisi,tbmobil.norangka,tbmobil.nmpemilik as nmpemilik,tbmobil.user,tbmobil.kdmerek,tbmobil.kdmodel,
    tbmobil.kdtipe,tbmobil.kdwarna,tbmerek.nama as nmmerek,tbmodel.nama as nmmodel,tbtipe.nama as nmtipe');
    $builder->join('tbmerek as tbmerek', 'tbmobil.kdmerek = tbmerek.kode', 'left');
    $builder->join('tbmodel as tbmodel', 'tbmobil.kdmodel = tbmodel.kode', 'left');
    $builder->join('tbtipe as tbtipe', 'tbmobil.kdtipe = tbtipe.kode', 'left');
    if ($katakunci) {
      $arr = explode(" ", $katakunci);
      for ($i = 0; $i < count($arr); $i++) {
        $builder = $builder->orlike('nopolisi', $arr[$i]);
        $builder = $builder->orlike('norangka', $arr[$i]);
        $builder = $builder->orlike('nomesin', $arr[$i]);
        $builder = $builder->orlike('nmpemilik', $arr[$i]);
        $builder = $builder->orlike('nmtipe', $arr[$i]);
      }
    }
    if ($start != 0 or $length != 0) {
      // $builder = $builder->limit($length, $start);
    }
    $order = $request->getPost('order[0][column]');
    $order_dir = $request->getPost('order[0][dir]');
    if ($order == 0) {
      $builder = $builder->orderBy('nopolisi', 'asc');
    } else if ($order == 1) {
      $builder->orderBy('nopolisi', $order_dir);
    } else if ($order == 2) {
      $builder->orderBy('norangka', $order_dir);
    } else if ($order == 3) {
      $builder->orderBy('nmpemilik', $order_dir);
    } else if ($order == 4) {
      $builder->orderBy('nmtipe', $order_dir);
    }
    return $builder->orderBy('nopolisi', 'asc')->get()->getResult();
    // return $builder->get()->getResult();
  }

  public function getid($id = false)
  {
    if ($id == false) {
      $builder = $this->db->table("tbmobil as tbmobil");
      $builder->select('tbmobil.id, tbmobil.nopolisi as kdmobil,tbmobil.nama as nmmobil,tbmobil.user,tbmobil.kdmerek,tbmerek.nama as nmmerek,tbmobil.aktif as aktif');
      $builder->join('tbmerek as tbmerek', 'tbmobil.kdmerek = tbmerek.nopolisi', 'left');
      return $builder->get()->getResult();
      // return $this->orderBy('nopolisi')->findAll();
    }
    return $this->where('id', $id)->first();
  }

  public function getnopolisi($nopolisi = false)
  {
    if ($nopolisi == false) {
      // $builder = $this->db->table("tbmobil");
      // $builder->select('*')->orderBy('nopolisi');
      $builder = $this->db->table("tbmobil as tbmobil");
      $builder->select('tbmobil.*, tbmerek.nama as nmmerek, tbtipe.nama as nmtipe');
      $builder->join('tbmerek as tbmerek', 'tbmerek.kode = tbmobil.kdmerek', 'left');
      $builder->join('tbtipe as tbtipe', 'tbtipe.kode = tbmobil.kdtipe', 'left');
      return $builder->get()->getResult();
      // return $this->orderBy('nopolisi')->findAll();
    }
    return $this->where('nopolisi', $nopolisi)->first();
  }

  public function getnama($nama = false)
  {
    if ($nama == false) {
      return $this->where('aktif', 'Y')->orderBy('nama')->findAll();
    }
    return $this->where('nama', $nama, 'aktif', 'Y')->orderBy('nama')->first();
  }

  public function getpemilik($kdpemilik = false)
  {
    if ($kdpemilik == false) {
      return $this->where('aktif', 'Y')->orderBy('nopolisi')->findAll();
    }
    return $this->where('kdpemilik', $kdpemilik, 'aktif', 'Y')->orderBy('nopolisi')->first();
  }

  public function delete_by_id($id)
  {
    $this->where('id', $id);
    $this->delete();
  }

  public function hapusmobil($nopolisi)
  {
    $builder = $this->db->table("tbmobil");
    $builder->set('kdpemilik', '');
    $builder->set('nmpemilik', '');
    $builder->where('nopolisi', $nopolisi);
    $builder->update();
  }

  public function gettipe($kode = false)
  {
    if ($kode == false) {
      return $this->findAll();
    }
    return $this->where('kdtipe', $kode)->first();
  }

  public function getwarna($kode = false)
  {
    if ($kode == false) {
      return $this->findAll();
    }
    return $this->where('kdwarna', $kode)->first();
  }

  public function getrangka($norangka = false)
  {
    if ($norangka == false) {
      return $this->findAll();
    }
    return $this->where('norangka', $norangka)->first();
  }
}
