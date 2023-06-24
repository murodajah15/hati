<?php

namespace App\Controllers;

// use CodeIgniter\Controller;
use App\Models\UserModel;

class Resetpassword extends BaseController
{
  protected $userModel, $email;
  public function __construct()
  {
    $this->userModel = new UserModel();
    $this->email = \Config\Services::email();
  }

  public function index()
  {
    // session();
    $data = [
      'menu' => 'file',
      'submenu' => 'tbcabang',
      'title' => 'Tambah Tabel Cabang',
      'validation' => \Config\Services::validation()
    ];
    helper(['form']);
    echo view('resetpassword', $data);
  }

  public function resetpassword()
  {
    if ($this->request->isAjax()) {
      $validation = \Config\Services::validation();
      $session = session();
      // validasi input
      if (!$this->validate([
        'email' => [
          'label' => 'Email',
          'rules' => 'required|min_length[6]|max_length[50]|valid_email',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'min_length' => '{field} Minimum 6 karakter',
            'max_length' => '{field} Maksimum 50 karakter',
            'valid_email' => '{field} Harus email'

          ]
        ],
        'password' => [
          'rules' => 'required|min_length[6]|max_length[200]',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
          ]
        ],
        'confpassword' => [
          'rules' => 'required|matches[password]',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'matches' => 'Konfirmasi password tidak sesuai',
          ]
        ],
      ])) {
        $msg = [
          'error' => [
            'email' => $validation->getError('email'),
            'password' => $validation->getError('password'),
            'confpassword' => $validation->getError('confpassword'),
          ]
        ];
        echo json_encode($msg);
        // return redirect()->to('/resetpassword')->withInput();
      } else {
        $model = new UserModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $data = $model->where('email', $email)->first();
        if ($data) {
          $from = 'murodajah15@gmail.com';
          $to = 'murodajah15@gmail.com'; //$this->request->getVar('to');
          $attachment = ''; //base_url('/upload/invoice.pdf');
          $title = "Reset Password HATI";
          $msg = [
            'sukses' => 'Silahkan cek email untuk konfirmasi Reset Password!'
          ];
          echo json_encode($msg);
          $message = "User Login : " . $email . "<br>Password : " . $password . "<br><a href='http://localhost:8080/click_reset_password?email=" . $email . "&password=" . $password . "'>Click here to reset password </a>";
          $this->sendEmail($from, $to, $attachment, $title, $message);
          // if ($this->sendEmail($from, $to, $attachment, $title, $message)) {;
          //   // $session->setFlashdata('msg', 'Silahkan cek email untuk konfirmasi Reset Password!');
          //   // return redirect()->to('/resetpassword')->withInput();
          //   $msg = [
          //     'sukses' => 'Silahkan cek email untuk konfirmasi Reset Password!'
          //   ];
          //   echo json_encode($msg);
          // } else {
          //   // $session->setFlashdata('msg', 'Gagal Reset Password!');
          //   // return redirect()->to('/resetpassword')->withInput();
          // }
        } else {
          // $session->setFlashdata('msg', 'Email tidak ditemukan');
          // return redirect()->to('/resetpassword')->withInput();
          $msg = [
            'sukses' => 'Email tidak ditemukan!'
          ];
          echo json_encode($msg);
        }
      }
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function sendEmail($from, $to, $attachment, $title, $message)
  {
    $this->email->setFrom($from, $from);
    $this->email->setTo($to);

    $this->email->attach($attachment);

    $this->email->setSubject($title);
    $this->email->setMessage($message);

    if (!$this->email->send()) {
      // echo "Gagal reset password";
      return false;
    } else {
      // echo "Reset password sukses";
      return true;
    }
  }

  public function click_reset_password()
  {
    //http://localhost:8080/click_reset_password?email=murod@honda-autoland.com&password=111111
    //$2y$10$pVSNZG/fQDaRochqPNL0H.dKIRZRrQsCP3BD7DZb9T3q7yvsmQwrO
    $password = $_GET['password'];
    $email = $_GET['email'];
    $password = password_hash($password, PASSWORD_DEFAULT);
    $simpandata = [
      'nama' => 'test',
      'email' => $email,
      'password' => $password,
    ];
    // dd($simpandata);
    $data = $this->userModel->where('email', $email)->first();
    $id = $data['id'];
    if ($this->userModel->update($id, $simpandata)) {
      echo ("<script>
          window.alert('Reset password berhasil!');
          window.location.href='login';
       </script>");
      // echo "Reset password sukses " . $password . '  ' . $email;
    } else {
      echo ("<script>
          window.alert('Reset password gagal!');
          window.location.href='login';
       </script>");
      // echo "Reset password gagal " . $password . '  ' . $email;
    }
  }
}
