<?php

namespace App\Controllers;

use App\Models\tbmoduleModel;
use App\Models\userdtlModel;
use App\Models\tbuserModel;
use App\Models\tbklpuserModel;
use Ifsnop\Mysqldump\Mysqldump;

class Tbuser extends BaseController
{
  protected $helpers = ['form'];
  protected $tbuserModel, $tbmoduleModel, $userdtlModel, $tbklpuserModel;
  public function __construct()
  {
    $this->tbuserModel = new tbuserModel();
    $this->tbmoduleModel = new tbmoduleModel();
    $this->userdtlModel = new userdtlModel();
    $this->tbklpuserModel = new tbklpuserModel();
  }

  public function index()
  {
    $data = [
      'menu' => 'utility',
      'submenu' => 'tbuser',
      'title' => 'Tabel user',
      'tbuser' => $this->tbuserModel->orderBy('nama')->findAll() //$tbuser
    ];
    echo view('tbuser/index', $data);
  }

  public function detail($id)
  {
    $data = [
      'title' => 'Detail tabel user',
      'tbuser' => $this->tbuserModel->getuser($id)
    ];
    if (empty($data['tbuser'])) {
      throw new \CodeIgniter\Exceptions\PageNotFoundException('Id user' . $id . 'tidak ditemukan.');
    }
    return view('tbuser/detail', $data);
  }

  public function create()
  {
    // session();
    $data = [
      'title' => 'Tambah tabel user',
      'validation' => \Config\Services::validation()
    ];
    return view('tbuser/formtambah', $data);
  }

  public function ajaxLoadData()
  {
    $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
    $katakunci = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
    $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
    $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';

    $this->tbuserModel = new tbuserModel();
    $data = $this->tbuserModel->tampilData($katakunci, $start, $length);
    $jumlahData = $this->tbuserModel->tampilData($katakunci);

    $output = array(
      "draw" => intval($param['draw']),
      "recordsTotal" => count($jumlahData),
      "recordsFiltered" => count($jumlahData),
      "data" => $data,
    );

    echo json_encode($output);
  }

  public function formdetail()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->tbuserModel->find($id);
      $data = [
        'title' => 'Detail data',
        'id' => $row['id'],
        'nama' => $row['nama'],
        'email' => $row['email'],
        'nama_lengkap' => $row['nama_lengkap'],
        'nohp' => $row['nohp'],
        'level' => $row['level'],
        'kelompok' => $row['kelompok'],
        'photo' => $row['photo'],
        'aktif' => $row['aktif'],
      ];
      $msg = [
        'sukses' => view('tbuser/modaldetail', $data)
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function formtambah()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Tambah data',
        'tbklpuser' => $this->tbklpuserModel->findAll(),
      ];
      $msg = [
        'data' => view('tbuser/modaltambah', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function formtambahform()
  {
    if ($this->request->isAjax()) {
      $data = [
        'title' => 'Tambah data'
      ];
      $msg = [
        'data' => view('tbuser/formtambah', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function simpandata()
  {
    if ($this->request->isAjax()) {
      $rules = [
        'email' => [
          'label' => 'Email',
          'rules' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[user.email]',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'is_unique' => '{field} tidak boleh ada yang sama',
            'min_length' => '{field} Minimum 6 karakter',
            'max_length' => '{field} Maksimum 50 karakter',
            'valid_email' => '{field} Harus email'

          ],
        ],
        'photo' => [
          'rules' => 'uploaded[photo]|max_size[photo,1024]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]',
          'errors' => [
            'uploaded' => 'Pilih gambar terlebih dahulu',
            'max_size' => 'Harap isi dahulu pada :max karakter dan pada :max karakter.',
            'is_image' => 'Yang anda pilih bukan gambar',
            'mime_in' => 'Yang anda pilih bukan gambar',
          ]
        ],
        'nama'          => 'required|min_length[3]|max_length[20]',
        'password'      => 'required|min_length[6]|max_length[200]',
        'confpassword'  => 'matches[password]',
      ];
      // $rules = [
      //   'nama'          => 'required|min_length[3]|max_length[20]',
      //   'email'         => 'required|min_length[6]|max_length[50]|valid_email|is_unique[user.email]',
      //   'password'      => 'required|min_length[6]|max_length[200]',
      //   'confpassword'  => 'matches[password]'
      // ];
      $filePhoto = $this->request->getFile('photo');
      // dd($filePhoto);
      if ($filePhoto->getError() == 4) {
        $namaPhoto = 'default.png';
      } else {
        $namaPhoto = $filePhoto->getRandomName();
      }
      // dd($namaPhoto);
      $session = session();
      $user = "Tambah-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      if ($this->request->getVar('aktif') == 'on') {
        $aktif = 'Y';
      } else {
        $aktif = 'N';
      }
      $data = [
        'nama'     => $this->request->getVar('nama'),
        'email'    => $this->request->getVar('email'),
        'nama_lengkap' => $this->request->getVar('nama_lengkap'),
        'nohp' => $this->request->getVar('nohp'),
        'level' => $this->request->getVar('level'),
        'kelompok' => $this->request->getVar('kelompok'),
        'user' => $user,
        'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
        'photo' => $namaPhoto,
        'aktif' => $aktif,
      ];
      if (!$this->validate($rules)) {
        $validation = \Config\Services::validation();
        // return redirect()->to('/register')->withInput()->with('validation', $validation);
        $msg = [
          'error' => [
            'nama' => $validation->getError('nama'),
            'email' => $validation->getError('email'),
            'password' => $validation->getError('password'),
            'confpassword' => $validation->getError('confpassword'),
            'photo' => $validation->getError('photo'),
          ]
        ];
        echo json_encode($msg);
      } else {
        $this->tbuserModel->insert($data);
        if (isset($filePhoto)) {
          $filePhoto->move('img', $namaPhoto);
        }
        $username = $this->request->getVar('salinuser');
        if ($username != "") {
          $data = $this->userdtlModel->getusername($username);
          // var_dump($data);
          //insert batch
          $userdtl_data = array();
          foreach ($data as $row) {
            $userdtl_data[] = [
              'iduser' => $row['iduser'],
              'idmodule' => $row['idmodule'],
              'username' => $this->request->getVar('email'),
              'cmodule' => $row['cmodule'],
              'cmenu' => $row['cmenu'],
              'clain' => $row['clain'],
              'cmainmenu' => $row['cmainmenu'],
              'cparent' => $row['cparent'],
              'nlevel' => $row['nlevel'],
              'nurut' => $row['nurut'],
              'pakai' => $row['pakai'],
              'tambah' => $row['tambah'],
              'edit' => $row['edit'],
              'hapus' => $row['hapus'],
              'proses' => $row['proses'],
              'unproses' => $row['unproses'],
              'cetak' => $row['cetak'],
            ];
          }
          $this->userdtlModel->insertBatch($userdtl_data);
        }
        $msg = [
          'sukses' => 'Data berhasil ditambah'
        ];
        session()->setFlashdata('pesan', 'Data berhasil ditambah');
        echo json_encode($msg);
      }
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function formedit()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('id');
      $row = $this->tbuserModel->find($id);
      $session = session();
      $user = "Update-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      $data = [
        'title' => 'Edit data',
        'id' => $row['id'],
        'nama' => $row['nama'],
        'email' => $row['email'],
        'nama_lengkap' => $row['nama_lengkap'],
        'nohp' => $row['nohp'],
        'level' => $row['level'],
        'kelompok' => $row['kelompok'],
        'user' => $user,
        'password' => $row['password'],
        'photo' => $row['photo'],
        'aktif' => $row['aktif'],
        'tbklpuser' => $this->tbklpuserModel->findAll(),
      ];
      // var_dump($data);
      $msg = [
        'sukses' => view('tbuser/modaledit', $data)
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function updatedata()
  {
    if ($this->request->isAjax()) {
      if ($this->request->getVar('password') == "") {
        $valpassword = "min_length[0]";
      } else {
        $valpassword = 'required|min_length[6]|max_length[200]';
      }
      $rules = [
        'email' => [
          'label' => 'Email',
          'rules' => 'required|min_length[6]|max_length[50]|valid_email',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'min_length' => '{field} Minimum 6 karakter',
            'max_length' => '{field} Maksimum 50 karakter',
            'valid_email' => '{field} Harus email'

          ],
        ],
        'photo' => [
          'rules' => 'max_size[photo,1024]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]',
          'errors' => [
            // 'uploaded' => 'Pilih gambar terlebih dahulu', uploaded[photo]|
            'max_size' => 'Harap isi dahulu pada :max karakter dan pada :max karakter.',
            'is_image' => 'Yang anda pilih bukan gambar',
            'mime_in' => 'Yang anda pilih bukan gambar',
          ]
        ],
        'nama'          => 'required|min_length[3]|max_length[20]',
        'password'      => $valpassword,
        'confpassword'  => 'matches[password]'
      ];
      if (!$this->validate($rules)) {
        $validation = \Config\Services::validation();
        // return redirect()->to('/register')->withInput()->with('validation', $validation);
        $msg = [
          'error' => [
            'nama' => $validation->getError('nama'),
            'email' => $validation->getError('email'),
            'password' => $validation->getError('password'),
            'confpassword' => $validation->getError('confpassword'),
            'photo' => $validation->getError('photo'),
          ]
        ];
        echo json_encode($msg);
      } else {
        $session = session();
        $user = "Update-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        if (!empty($this->request->getVar('password'))) {
          $password = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);
        } else {
          $password = $this->request->getVar('password_lama');
        }

        // Cek gambar apakah tetap gambar lama
        $filePhoto = $this->request->getFile('photo');
        if ($filePhoto->getError() == 4) {
          // if (!isset($filePhoto)) {
          $namaPhoto = $this->request->getVar('photoLama');
        } else {
          $namaPhoto = $filePhoto->getRandomName();
          if (is_file('img/' . $this->request->getVar('photoLama'))) {
            if ($this->request->getVar('photoLama') != 'default.png') {
              unlink('img/' . $this->request->getVar('photoLama'));
            }
          }
          // unlink('img/' . $this->request->getVar('photoLama'));
          $filePhoto->move('img', $namaPhoto);
        }
        if ($this->request->getVar('aktif') == 'on') {
          $aktif = 'Y';
        } else {
          $aktif = 'N';
        }
        $simpandata = [
          'nama' => $this->request->getVar('nama'),
          'email' => $this->request->getVar('email'),
          'nama_lengkap' => $this->request->getVar('nama_lengkap'),
          'nohp' => $this->request->getVar('nohp'),
          'level' => $this->request->getVar('level'),
          'kelompok' => $this->request->getVar('kelompok'),
          'user' => $user,
          'password' => $password,
          'photo' => $namaPhoto,
          'aktif' => $aktif,
        ];
        // dd($simpandata);
        $id = $this->request->getVar('id');
        $this->tbuserModel->update($id, $simpandata);
        $username = $this->request->getVar('salinuser');
        if ($username != "") {
          $data = $this->userdtlModel->getusername($username);
          // var_dump($data);
          //insert batch
          $userdtl_data = array();
          foreach ($data as $row) {
            $userdtl_data[] = [
              'iduser' => $row['iduser'],
              'idmodule' => $row['idmodule'],
              'username' => $this->request->getVar('email'),
              'cmodule' => $row['cmodule'],
              'cmenu' => $row['cmenu'],
              'clain' => $row['clain'],
              'cmainmenu' => $row['cmainmenu'],
              'cparent' => $row['cparent'],
              'nlevel' => $row['nlevel'],
              'nurut' => $row['nurut'],
              'pakai' => $row['pakai'],
              'tambah' => $row['tambah'],
              'edit' => $row['edit'],
              'hapus' => $row['hapus'],
              'proses' => $row['proses'],
              'unproses' => $row['unproses'],
              'cetak' => $row['cetak'],
            ];
          }
          $this->userdtlModel->insertBatch($userdtl_data);
        }
        $msg = [
          'sukses' => 'Data berhasil disimpan'
        ];
        session()->setFlashdata('pesan', 'Data berhasil diupdate');
        echo json_encode($msg);
      }
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function hapus($id)
  {
    // hapus gambar di img
    $user = $this->tbuserModel->find($id);
    // dd($user['photo']);
    if ($user['photo'] != 'default.png') {
      // if (file_exists('img/' . $user['photo'])) {
      if (is_file('img/' . $user['photo'])) {
        unlink('img/' . $user['photo']);
      }
    }
    $row = $this->tbuserModel->getuser($id);
    $username = $row['email'];
    $result = $this->userdtlModel->delete_by_username($username);
    if ($result) {
      $result1 = $this->tbuserModel->delete_by_id($id);
      if ($result1) {
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        echo json_encode(array("status" => TRUE));
      } else {
        session()->setFlashdata('pesan', 'Data gagal dihapus');
        echo json_encode(array("status" => FALSE));
      }
    } else {
      session()->setFlashdata('pesan', 'Data gagal dihapus');
      echo json_encode(array("status" => FALSE));
    }
  }

  public function tabel_user()
  {
    $model = new tbusermodel();
    $data['title'] = 'Tabel user';
    $data['tbuser'] = $model->getuser();
    // dd($data);
    echo view('tbuser/tabel_user', $data);
  }

  public function formakses()
  {
    if ($this->request->isAjax()) {
      $tbmoduleModel = new tbmodulemodel();
      $id = $this->request->getVar('id');
      $row = $this->tbuserModel->find($id);
      $session = session();
      $user = "Update-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      $data = [
        'title' => 'Akses User',
        'id' => $row['id'],
        'nama' => $row['nama'],
        'email' => $row['email'],
        'nama_lengkap' => $row['nama_lengkap'],
        'nohp' => $row['nohp'],
        'level' => $row['level'],
        'user' => $user,
        'password' => $row['password'],
        'photo' => $row['photo'],
        'tbmodule' => $tbmoduleModel->getmodule(),
        // 'userdtl' => $userdtlModel->getusername(),
      ];
      // $msg = [
      //   'sukses' => view('tbuser/formakses', $data)
      // ];
      // dd($data);
      echo view('tbuser/formakses', $data);
      // echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function simpanakses()
  {
    //hapus record sesuai iduser
    $id = $this->request->getVar('id');
    $this->userdtlModel->delete_by_id($id);
    //insert ke userdtl sesuai module yang dipilih
    $cmodule = $this->request->getVar('cmodule');
    $cmenu = $this->request->getVar('cmenu');
    $cmainmenu = $this->request->getVar('cmainmenu');
    $cparent = $this->request->getVar('cparent');
    $nlevel = $this->request->getVar('nlevel');
    $nurut = $this->request->getVar('nurut');
    $username = $this->request->getVar('username');
    $pakai = $this->request->getVar('pakai');
    $tambah = $this->request->getVar('tambah');
    $edit = $this->request->getVar('edit');
    $hapus = $this->request->getVar('hapus');
    $proses = $this->request->getVar('proses');
    $unproses = $this->request->getVar('unproses');
    $cetak = $this->request->getVar('cetak');
    $jmldata = count($cmodule);
    isset($pakai) ? $jmlpakai = count($pakai) : $jmlpakai = 0;
    isset($tambah) ? $jmltambah = count($tambah) : $jmltambah = 0;
    isset($edit) ? $jmledit = count($edit) : $jmledit = 0;
    isset($hapus) ? $jmlhapus = count($hapus) : $jmlhapus = 0;
    isset($proses) ? $jmlproses = count($proses) : $jmlproses = 0;
    isset($unproses) ? $jmlunproses = count($unproses) : $jmlunproses = 0;
    isset($cetak) ? $jmlcetak = count($cetak) : $jmlcetak = 0;
    // var_dump(count($pakai));
    // dd($jmldata);
    //insert biasa
    // for ($i = 0; $i < $jmldata; $i++) {
    //   $this->userdtlModel->insert([
    //     'iduser' => $id,
    //     'idmodule' => $nurut[$i],
    //     'nurut' => $nurut[$i],
    //     'cmodule' => $cmodule[$i],
    //     'username' => $username,
    //   ]);
    // }
    //insert batch
    $userdtl_data = array();
    for ($i = 0; $i < $jmldata; $i++) {
      $userdtl_data[] = [
        'iduser' => $id,
        'idmodule' => $nurut[$i],
        'nurut' => $nurut[$i],
        'cmodule' => $cmodule[$i],
        'cmenu' => $cmenu[$i],
        'cmainmenu' => $cmainmenu[$i],
        'cparent' => $cparent[$i],
        'nlevel' => $nlevel[$i],
        'username' => $username
      ];
    }
    $result = $this->userdtlModel->insertBatch($userdtl_data);
    for ($i = 0; $i < $jmlpakai; $i++) {
      $cmodule = $pakai[$i];
      $data = [
        'pakai' => 1,
      ];
      $this->userdtlModel->updateuserdtl($data, $cmodule, $username);
    }
    for ($i = 0; $i < $jmltambah; $i++) {
      $cmodule = $tambah[$i];
      $data = [
        'tambah' => 1,
      ];
      $this->userdtlModel->updateuserdtl($data, $cmodule, $username);
    }
    for ($i = 0; $i < $jmledit; $i++) {
      $cmodule = $edit[$i];
      $data = [
        'edit' => 1,
      ];
      $this->userdtlModel->updateuserdtl($data, $cmodule, $username);
    }
    for ($i = 0; $i < $jmlhapus; $i++) {
      $cmodule = $hapus[$i];
      $data = [
        'hapus' => 1,
      ];
      $this->userdtlModel->updateuserdtl($data, $cmodule, $username);
    }
    for ($i = 0; $i < $jmlproses; $i++) {
      $cmodule = $proses[$i];
      $data = [
        'proses' => 1,
      ];
      $this->userdtlModel->updateuserdtl($data, $cmodule, $username);
    }
    for ($i = 0; $i < $jmlunproses; $i++) {
      $cmodule = $unproses[$i];
      $data = [
        'unproses' => 1,
      ];
      $this->userdtlModel->updateuserdtl($data, $cmodule, $username);
    }
    for ($i = 0; $i < $jmlcetak; $i++) {
      $cmodule = $cetak[$i];
      $data = [
        'cetak' => 1,
      ];
      $this->userdtlModel->updateuserdtl($data, $cmodule, $username);
    }
    if ($result) {
      session()->setFlashdata('pesan', 'Data berhasil disimpan');
      echo json_encode(array("status" => TRUE));
    } else {
      session()->setFlashdata('pesan', 'Data gagal disimpan');
      echo json_encode(array("status" => FALSE));
    }
  }

  public function backup()
  {
    $data = [
      'menu' => 'utility',
      'submenu' => 'backup_database',
      'title' => 'Backup',
      'tbuser' => $this->tbuserModel->orderBy('nama')->findAll() //$tbuser
    ];
    echo view('tbuser/backup', $data);
  }
  public function proses_backup2()
  {
    $db = \Config\Database::connect();
    $dbname = $db->database;
    // $path = WRITEPATH . 'backup/';              // change path here
    $path = 'D:/TEMP/';              // change path here
    $filename = $dbname . '_' . date('dMY_Hi') . '.sql';   // change file name here
    $prefs = ['filename' => $filename];     // I only set the file name, for complete prefs see README

    $util = (new \CodeIgniter\Database\Database())->loadUtils($db);
    $backup = $util->backup($prefs, $db);
    echo $path . $filename;
    if (write_file($path . $filename . '.gz', $backup) == FALSE) {
      echo 'Unable to write the file';
    } else {
      echo 'File written!';
    }
    // write_file($path . $filename . '.gz', $backup);
    // return $this->response->download($path . $filename . '.gz', null);
  }

  public function proses_backup1()
  {
    $tglsekarang = date('dmy');
    try {
      echo $tglsekarang;
      $dump = new Mysqldump('mysql:host=localhost:8090;dbname=chikung;port=3306', 'root', '');
      $dump->start('backup/dbbackup-' . $tglsekarang . '.sql');
      return redirect()->to('/tbuser/backup');
    } catch (\Exception $e) {
      echo 'mysqldump-php error: ' . $e->getMessage();
    }
  }

  public function proses_backup()
  {
    try {
      $db = \Config\Database::connect();
      $dbname = $db->database;
      $path = WRITEPATH . 'backup/';              // change path here
      // $path = WRITEPATH . 'uploads/';        // change path here
      $filename = $dbname . '_' . date('dMY_Hi') . '.sql';   // change file name here
      $prefs = ['filename' => $filename];              // I only set the file name, for complete prefs see below 

      $util = (new \CodeIgniter\Database\Database())->loadUtils($db);
      $backup = $util->backup($prefs, $db);

      write_file($path . $filename . '.gz', $backup);
      return $this->response->download($path . $filename . '.gz', null);
    } catch (\Exception $e) {
      echo 'mysqldump-php error: ' . $e->getMessage();
    }
  }
}
