<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Mdatatables;

class Datatables extends BaseController
{
  public function index()
  {
    helper('url');
    return view('index_datatables');
  }

  public function table_data()
  {
    $model = new MDatatables();
    $listing = $model->get_datatables();
    $data = array();
    $no = $_POST['start'];
    foreach ($listing as $key) {
      $no++;
      $row = array();
      $row = $key->NamaTeman;
      $row = $key->Alamat;
      $row = $key->JenisKelamin;
      $data = $row;
    }
    $output = array(
      "draw" => $_POST['draw'],
      "data" => $data
    );
    echo json_encode($output);
  }
}
