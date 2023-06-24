<?php

namespace App\Controllers;

use App\Models\MCrudajax;

class Crudajax extends BaseController
{
  public function index()
  {
    $data = [
      'menu' => 'transaksi',
      'submenu' => 'tbteman',
      'title' => 'CRUD AJAX',
      'content' => 'teman/index_crud',
    ];
    $data['title'] = 'Tabel Customer';
    $data['content'] = 'teman/index_crud';
    return view('teman/index', $data);
  }

  public function table_teman()
  {
    $model = new MCrudajax();
    $data['title'] = 'Tabel Teman';
    $data['tb_teman'] = $model->getTeman();
    echo view('teman/table_teman', $data);
  }

  public function form_teman()
  {
    $data = [
      'validation' => \Config\Services::validation()
    ];
    $session = session();
    $db = db_connect();
    $data['jk'] = $db->query("select * from tb_jeniskelamin order by id asc")->getResult();
    echo view('teman/form_teman', $data);
  }

  public function form_teman_detail()
  {
    $db = db_connect();
    $data['jk'] = $db->query("select * from tb_jeniskelamin order by id asc")->getResult();
    echo view('teman/form_teman_detail', $data);
  }

  public function detail_form_teman()
  {
    $id = $this->request->getVar('Id');
    $model = new MCrudajax();
    $data = $model->getTeman($id)->getRow();
    echo json_encode($data);
  }

  public function tambah_teman()
  {
    // validasi input
    if (!$this->validate([
      'namateman' => [
        'rules' => 'required|is_unique[tb_teman.namateman]',
        'errors' => [
          'required' => '{field} Nama Teman harus diisi.'
        ]
      ],
      'jeniskelamin' => [
        'rules' => 'required|is_unique[tb_teman.jeniskelamin]',
        'errors' => [
          'required' => '{field} Kode divisi harus diisi.'
        ]
      ]
    ])) {
      $model = new MCrudajax();
      $data = array(
        'NamaTeman' => $this->request->getVar('namateman'),
        'Alamat' => $this->request->getVar('alamat'),
        'JenisKelamin' => $this->request->getVar('jeniskelamin'),
      );
      $model->simpanTeman($data);
    };
  }

  public function edit_form_teman()
  {
    $id = $this->request->getVar('Id');
    // $id = 2;
    $model = new MCrudajax();
    $data = $model->getTeman($id)->getRow();
    echo json_encode($data);
  }

  public function edit_teman()
  {
    $session = session();
    $model = new MCrudajax();
    $id = $this->request->getVar('Id');
    // dd($id);
    $data = array(
      'namaTeman' => $this->request->getVar('namateman'),
      'alamat' => $this->request->getVar('alamat'),
      'jeniskelamin' => $this->request->getVar('jeniskelamin'),
    );
    $model->updateTeman($data, $id);
  }

  public function getjeniskelamin()
  {
    $data = "";
    $JenisKelamin = $this->request->getVar('JenisKelamin');
    $db = db_connect();
    $jk = $db->query("select * from tb_jeniskelamin order by id")->getResult();
    $data .= "<option value=''>[Pilih Jenis Kelamin]</option>";
    foreach ($jk as $key) {
      if ($key->uraian == $JenisKelamin) {
        $cek = " selected";
      } else {
        $cek = "";
      }
      $data .= "<option value='$key->uraian' $cek>$key->uraian</option>";
    }
    echo $data;
  }

  public function delete_teman()
  {
    $model = new MCrudajax();
    $id = $this->request->getVar('id');
    $model->deleteTeman($id);
    // echo 'Berhasil';
  }
}
