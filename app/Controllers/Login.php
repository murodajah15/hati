<?php

namespace App\Controllers;

// use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\SaplikasiModel;

class Login extends BaseController
{
  protected $userModel, $saplikasiModel;
  public function __construct()
  {
    $this->userModel = new UserModel();
    $this->saplikasiModel = new SaplikasiModel();
  }

  public function index()
  {
    helper(['form']);
    echo view('login');
  }

  public function auth()
  {
    $session = session();
    $model = new UserModel();
    $email = $this->request->getVar('email');
    $password = $this->request->getVar('password');
    // $data = $model->where('email', $email)->where('aktif', 'Y')->first();
    $data = $model->where('email', $email)->first();
    if ($data) {
      $pass = $data['password'];
      $verify_pass = password_verify($password, $pass);
      if ($verify_pass) {
        $saplikasimodel = new SaplikasiModel();
        $saplikasi = $saplikasimodel->where('aktif', 'Y')->first();
        $ses_data = [
          'id'       => $data['id'],
          'nama'     => $data['nama'],
          'nama_lengkap'     => $data['nama_lengkap'],
          'email'    => $data['email'],
          'level'    => $data['level'],
          'kelompok'    => $data['kelompok'],
          'photo'    => $data['photo'],
          'logged_in'     => TRUE,
          'nama_perusahaan' => $saplikasi['nm_perusahaan'],
          'alamat_perusahaan' => $saplikasi['alamat'],
          'ppn' => $saplikasi['ppn'],
        ];
        if ($data['aktif'] == 'Y') {
          $session->set($ses_data);
          return redirect()->to('/dashboard');
        } else {
          $session->setFlashdata('msg', 'User belum aktif!');
          return redirect()->to('/login');
        }
      } else {
        $session->setFlashdata('msg', 'Password salah!');
        return redirect()->to('/login');
      }
    } else {
      $session->setFlashdata('msg', 'Email tidak ditemukan!');
      return redirect()->to('/login')->withInput();
    }
  }

  public function logout()
  {
    $session = session();
    $session->destroy();
    return redirect()->to('/login');
  }
}
