<?php

namespace App\Controllers;

// use CodeIgniter\Controller;
use App\Models\UserModel;

// class Register extends Controller
class Register extends BaseController
{
  public function index()
  {
    //include helper form
    session();
    helper(['form']);
    $data = [
      'title' => 'Register User',
      'validation' => \Config\Services::validation()
    ];
    echo view('register', $data);
  }

  public function save()
  {
    //include helper form
    helper(['form']);
    //set rules validation form
    $rules = [
      'nama'          => 'required|min_length[3]|max_length[20]',
      'email'         => 'required|min_length[6]|max_length[50]|valid_email|is_unique[user.email]',
      'password'      => 'required|min_length[6]|max_length[200]',
      'confpassword'  => 'matches[password]'
    ];

    $data = [
      'nama'     => $this->request->getVar('nama'),
      'email'    => $this->request->getVar('email'),
      'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
    ];

    if (!$this->validate($rules)) {
      // $data['validation'] = $this->validator;
      // return redirect()->to('/register')->withInput();
      // echo view('/register', $data);
      $validation = \Config\Services::validation();
      return redirect()->to('/register')->withInput()->with('validation', $validation);
    } else {
      $model = new UserModel();
      $model->save($data);
      // $model->save([
      //   'nama'           => $this->request->getVar('nama'),
      //   'email'          => $this->request->getVar('email'),
      //   'password'       => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
      // ]);

      echo "<script>";
      echo "alert('Register Berhasil');";
      echo 'window.location = "/login.php";';
      echo "</script>";
      // return redirect()->to('/login');
    }
  }
}
