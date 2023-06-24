<?php

namespace App\Controllers;

use \CodeIgniter\Controller;
use \Hermawan\DataTables\DataTable;


class Customers extends Controller
{
  public function index()
  {
    helper('url');
    return view('customers_view');
  }

  public function ajaxDataTables()
  {
    $db = db_connect();
    $builder = $db->table('customers')->select('firstName, lastName, phone, address, city, country');

    return DataTable::of($builder)
      ->addNumbering() //it will return data output with numbering on first column
      ->toJson();
  }
}
