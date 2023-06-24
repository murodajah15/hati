<?php

namespace App\Controllers;

// use CodeIgniter\Controller;
use App\Models\UserModel;

// class Rubah_password extends Controller
class Rubah_password extends BaseController
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
      'title' => 'Rubah Password',
      'user' => $this->userModel->getUser($nama)
      // 'user' => $this->userModel->findAll()
    ];
    echo view('/user/rubah_password', $data);
  }

  public function update($id)
  {
    $session = session();
    $user = $this->userModel->getUser($this->request->getVar('nama'));
    $id = $user['id'];
    $password_user = $user['password'];
    $password_lama = $this->request->getVar('password_lama');
    $password = $this->request->getVar('password');
    $verify_pass = password_verify($password_lama, $password_user);
    if (!$verify_pass) {
      $session->setFlashdata('msg', 'Password lama tidak sesuai');
      return redirect()->to('/rubah_password')->withInput();
    } else {
      //include helper form
      // helper(['form']);
      //set rules validation form
      $rules = [
        'password'      => 'required|min_length[6]|max_length[200]',
        'confpassword'  => 'matches[password]'
      ];
      $data = [
        'id'     => $this->request->getVar('id'),
        'nama'     => $this->request->getVar('nama'),
        'password' => password_hash($this->request->getVar('confpassword'), PASSWORD_DEFAULT),
        'confpassword' => $this->request->getVar('confpassword')
      ];
      // 'password_baru' => 'required|min_length[6]|max_length[200]',
      if (!$this->validate($rules)) {
        if (str_word_count($this->request->getvar('password')) < 6 or ($this->request->getvar('password') != $this->request->getvar('confpassword'))) {
          $session->setFlashdata('msg', 'Panjang password baru minimum 6 karakter dan harus sama dengan konfirmasi password');
        }
        return redirect()->to('/rubah_password')->withInput();
        // } else {
        //   $data['validation'] = $this->validator;
        //   // dd($data);
        //   // return redirect()->to('/rubah_password');
        //   return redirect()->to('/user/rubah_password');
        //   // echo view('user/rubah_password', $data);
        // }
      } else {
        $model = new UserModel();
        $model->save($data);
        // $model->save($id);
        // $model->save([
        //   'nama'           => $this->request->getVar('nama'),
        //   'email'          => $this->request->getVar('email'),
        //   'password'       => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
        // ]);
        echo "<script>";
        echo "alert('Password berhasil dirubah');";
        echo 'window.location = "/login";';
        echo "</script>";
        // return redirect()->to('/login');
?>
        <!-- <script>
          swal({
              title: "Password Berhasil dirubah!",
              text: "",
              icon: "success",
            })
            .then(function() {
              window.location.href = '/login';
            });
        </script> -->
<?php
      }
    }
  }
}
