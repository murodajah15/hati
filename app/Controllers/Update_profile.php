<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class Update_profile extends Controller
{
  protected $userModel;
  public function __construct()
  {
    $this->userModel = new UserModel();
  }

  public function index()
  {
    $session = session();
    $nama = $session->get('nama');
    //include helper form
    helper(['form']);
    // $data = [];
    $data = [
      'title' => 'Update Profile',
      'user' => $this->userModel->getUser($nama)
    ];
    echo view('/user/update_profile', $data);
  }

  public function update($id)
  {
    //include helper form
    helper(['form']);
    //set rules validation form
    // $rules = [
    //   'nama_lengkap'  => 'required|min_length[3]|max_length[20]',
    //   'nohp'          => 'required|min_length[3]|max_length[20]'
    // ];

    $data = [
      'id' => $this->request->getVar('id'),
      'nama_lengkap'     => $this->request->getVar('nama_lengkap'),
      'nohp'    => $this->request->getVar('nohp')
    ];

    // if (!$this->validate($rules)) {
    //   $validation = \Config\Services::validation();
    //   return redirect()->to('/update_profile')->withInput()->with('validation', $validation);
    // } else {
    $model = new UserModel();
    $model->save($data);
    // echo "<script>";
    // echo "alert('Register Berhasil');";
    // echo 'window.location = "/dashboard.php";';
    // echo "</script>";
    return redirect()->to('/dashboard');
  }
}
