<?php

// namespace App\Models;

// use CodeIgniter\Model;

// class TbdivisiModel extends Model
// {
//   protected $table      = 'tbdivisi';
//   // protected $primaryKey = 'id';
//   protected $useTimestamps = true;
//   protected $allowedFields = ['kode', 'nama', 'user'];

//   // protected $useAutoIncrement = true;

//   // protected $returnType     = 'array';
//   // protected $useSoftDeletes = true;

//   // protected $allowedFields = ['name', 'email'];

//   // protected $useTimestamps = true;
//   // protected $createdField  = 'created_at';
//   // protected $updatedField  = 'updated_at';
//   // protected $deletedField  = 'deleted_at';

//   // protected $validationRules    = [];
//   // protected $validationMessages = [];
//   // protected $skipValidation     = false;

//   public function getdivisi($id = false)
//   {
//     if ($id == false) {
//       return $this->findAll();
//     }
//     return $this->where('id', $id)->first();
//     // return $this->where(['slug' => $slug])->first();
//   }
//   public function getkddivisi($kode = false)
//   {
//     if ($kode == false) {
//       return $this->findAll();
//     }
//     return $this->where('kode', $kode)->first();
//     // return $this->where(['slug' => $slug])->first();
//   }
//   public function getnmdivisi($nama = false)
//   {
//     if ($nama == false) {
//       return $this->findAll();
//     }
//     return $this->where('nama', $nama)->first();
//     // return $this->where(['slug' => $slug])->first();
//   }
// }

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class Modelfile extends Model
{
  protected $table = "";
  protected $column_order = array();
  protected $column_search = array();
  protected $order = array('' => '');
  protected $request;
  protected $db;
  protected $dt;

  function __construct(RequestInterface $request)
  {
    parent::__construct();
    $this->db = db_connect();
    $this->request = $request;

    $this->dt = $this->db->table($this->table);
  }
  private function _get_datatables_query()
  {
    $i = 0;
    foreach ($this->column_search as $item) {
      if ($this->request->getPost('search')['value']) {
        if ($i === 0) {
          $this->dt->groupStart();
          $this->dt->like($item, $this->request->getPost('search')['value']);
        } else {
          $this->dt->orLike($item, $this->request->getPost('search')['value']);
        }
        if (count($this->column_search) - 1 == $i)
          $this->dt->groupEnd();
      }
      $i++;
    }

    if ($this->request->getPost('order')) {
      $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
    } else if (isset($this->order)) {
      $order = $this->order;
      $this->dt->orderBy(key($order), $order[key($order)]);
    }
  }
  function get_datatables()
  {
    $this->_get_datatables_query();
    if ($this->request->getPost('length') != -1)
      $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
    $query = $this->dt->get();
    return $query->getResult();
  }
  function count_filtered()
  {
    $this->_get_datatables_query();
    return $this->dt->countAllResults();
  }
  public function count_all()
  {
    $tbl_storage = $this->db->table($this->table);
    return $tbl_storage->countAllResults();
  }
}
