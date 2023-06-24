<?php

namespace App\Controllers;

use App\Models\UserDatatable;
use Config\Services;

class User extends BaseController
{
  // protected $users;
  // public function __construct()
  // {
  //   $this->users = new User();
  // }

  // public function index()
  // {
  //   $data = [
  //     'title' => 'Tabel Cabang',
  //     'tbcabang' => $this->users->orderBy('id')->findAll() //$tbcabang
  //   ];
  //   return view('index', $data);
  // }
  public function index()
  {
    $data = [
      'title' => 'User List'
    ];
    return view('index', $data);
  }

  public function ajaxList()
  {
    $request = Services::request();
    $datatable = new UserDatatable($request);

    if ($request->getPost(true) === 'POST') {
      $lists = $datatable->getDatatables();
      $data = [];
      $no = $request->getPost('start');
      foreach ($lists as $list) {
        $no++;
        $row = [];
        $row[] = $no;
        $row[] = $list->name;
        $row[] = $list->email;
        $data[] = $row;
      }

      $output = [
        'draw' => $request->getPost('draw'),
        'recordsTotal' => $datatable->countAll(),
        'recordsFiltered' => $datatable->countFiltered(),
        'data' => $data
      ];
      echo json_encode($output);
    }
  }
}
