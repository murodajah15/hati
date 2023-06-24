<?php

namespace App\Controllers;

class Mahasiswa extends BaseController
{
  protected $tbl_mahasiswa;
  public $db;
  public function __construct()
  {
    $this->db = \Config\Database::connect();
    // $this->tbl_mahasiswa = new Mahasiswa();
  }

  public function listMahasiswa()
  {
    $data = [
      'title' => 'Pegawai'
    ];
    // $data1 = array();
    // $data1 = [
    //   [
    //     'id' => '1',
    //     'name' => 'test',
    //     'email' => 'email',
    //     'mobile' => 'mobile',
    //     'test' => 'mobile'
    //   ],
    //   [
    //     'id' => '1',
    //     'name' => 'test',
    //     'email' => 'email',
    //     'mobile' => 'mobile',
    //     'test' => 'mobile'
    //   ]
    // ];
    // dd($data1);
    // $data = $this->db->query("SELECT id,name,email,mobile from tbl_mahasiswa limit 10")->getResult();
    // $data1 = array();
    // foreach ($data as $list) {
    //   $row = array();
    //   $row[] = $list->id;
    //   $row[] = $list->name;
    //   $row[] = $list->email;
    //   $row[] = $list->mobile;
    //   $row[] = $list->mobile;
    //   $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person(' . "'" . $list->id . "'" . ')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
    //     <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person(' . "'" . $list->id . "'" . ')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
    //   $data1[] = $row;
    // }
    // dd($data1);
    return view('list-mahasiswa', $data);
  }

  public function ajaxLoadData()
  {
    $params['draw'] = $_REQUEST['draw'];
    $start = $_REQUEST['start'];
    $length = $_REQUEST['length'];
    $search_value = $_REQUEST['search']['value'];

    if (!empty($search_value)) {
      $total_count = $this->db->query("SELECT * from tbl_mahasiswa WHERE id like '%" . $search_value . "%' OR name like '%" . $search_value . "%' OR email like '%" . $search_value . "%' OR mobile like '%" . $search_value . "%'")->getResult();

      $data = $this->db->query("SELECT * from tbl_mahasiswa WHERE id like '%" . $search_value . "%' OR name like '%" . $search_value . "%' OR email like '%" . $search_value . "%' OR mobile like '%" . $search_value . "%' limit $start, $length")->getResult();
    } else {
      $total_count = $this->db->query("SELECT * from tbl_mahasiswa")->getResult();
      $data = $this->db->query("SELECT * from tbl_mahasiswa limit $start, $length")->getResult();
    }
    $data1 = array();
    // $no = $_POST['start'];
    foreach ($data as $list) {
      // $no++;
      $row = array();
      $row[] = $list->id;
      $row[] = $list->name;
      $row[] = $list->email;
      $row[] = $list->mobile;
      // $row[] = $list->mobile;

      //add html for action
      $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_mahasiswa(' . "'" . $list->id . "'" . ')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
        <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_mahasiswa(' . "'" . $list->id . "'" . ')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';

      $data1[] = $row;
    }

    // $data1 = array();
    // $data1 = [
    //   [
    //     'id' => '1',
    //     'name' => 'test',
    //     'email' => 'email',
    //     'mobile' => 'mobile',
    //     'test' => 'mobile'
    //   ],
    //   [
    //     'id' => '1',
    //     'name' => 'test',
    //     'email' => 'email',
    //     'mobile' => 'mobile',
    //     'test' => 'mobile'
    //   ]
    // ];

    $json_data = array(
      "draw" => intval($params['draw']),
      "recordsTotal" => count($total_count),
      "recordsFiltered" => count($total_count),
      "data" => $data1  // total data array
    );
    echo  json_encode($json_data);
  }

  public function ajax_edit($id)
  {
    $data = $this->db->from($this->table);
    $this->db->where('id', $id);
    $query = $this->db->get();
    // $data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
    echo json_encode($query);
  }

  public function ajax_delete($id)
  {
    $this->db->delete_by_id($id);
    echo json_encode(array("status" => TRUE));
  }
}
