<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class Forgot extends Controller
{
  public function index()
  {
    //include helper form
    helper(['form']);
    $data = [];
    echo view('forgot', $data);
  }

  public function send()
  {
    //include helper form
    helper(['form']);
    //set rules validation form
    $rules = [
      'email'         => 'required|min_length[6]|max_length[50]|valid_email|is_unique[user.user_email]'
    ];

    if ($this->validate($rules)) {
      $model = new UserModel();
      $data = [
        'user_email'    => $this->request->getVar('email')
      ];
      // $model->save($data);
      return redirect()->to('/login');
    } else {
      $data['validation'] = $this->validator;
      echo view('forgot', $data);
    }
  }
}
