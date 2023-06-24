<?php

namespace App\Controllers;

use App\Models\TbmoduleModel;

class Tbmodule extends BaseController
{
  protected $tbmoduleModel, $model;
  public function __construct()
  {
    $this->tbmoduleModel = new TbmoduleModel();
  }

  public function index()
  {
    $data = [
      'menu' => 'utility',
      'submenu' => 'tbmodule',
      'title' => 'Tabel module',
      'tbmodule' => $this->tbmoduleModel->orderBy('nurut')->findAll() //$tbmodule
    ];
    echo view('tbmodule/index', $data);
  }

  public function detail($id)
  {
    $data = [
      'title' => 'Detail tabel module',
      'tbmodule' => $this->tbmoduleModel->getmodule($id)
    ];
    if (empty($data['tbmodule'])) {
      throw new \CodeIgniter\Exceptions\PageNotFoundException('Id module' . $id . 'tidak ditemukan.');
    }
    return view('tbmodule/detail', $data);
  }

  public function create()
  {
    // session();
    $data = [
      'title' => 'Tambah tabel module',
      'validation' => \Config\Services::validation()
    ];
    return view('tbmodule/formtambah', $data);
  }

  public function ajaxLoadData()
  {
    $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
    $katakunci = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
    $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
    $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';

    $this->model = new TbmoduleModel();
    $data = $this->model->tampilData($katakunci, $start, $length);
    $jumlahData = $this->model->tampilData($katakunci);

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
      $row = $this->tbmoduleModel->find($id);
      $data = [
        'title' => 'Detail data',
        'id' => $row['id'],
        'nurut' => $row['nurut'],
        'cmodule' => $row['cmodule'],
        'cmenu' => $row['cmenu'],
        'clokasi_menu' => $row['clokasi_menu'],
        'cmainmenu' => $row['cmainmenu'],
        'cparent' => $row['cparent'],
        'nlevel' => $row['nlevel'],
      ];
      $msg = [
        'sukses' => view('tbmodule/modaldetail', $data)
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
        'title' => 'Tambah data'
      ];
      $msg = [
        'data' => view('tbmodule/modaltambah', $data),
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
        'data' => view('tbmodule/formtambah', $data),
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function simpandata()
  {
    if ($this->request->isAjax()) {
      $validation = \Config\Services::validation();
      $valid = $this->validate([
        'cmodule' => [
          'label' => 'Module',
          'rules' => 'required|is_unique[tbmodule.cmodule]',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'is_unique' => '{field} tidak boleh ada yang sama'
          ]
        ]
      ]);
      if (!$valid) {
        $msg = [
          'error' => [
            'cmodule' => $validation->getError('cmodule')
          ]
        ];
        echo json_encode($msg);
      } else {
        $session = session();
        $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
        if ($this->request->getVar('cmainmenu') == 'on') {
          $cmainmenu = 'Y';
        } else {
          $cmainmenu = 'N';
        }
        $simpandata = [
          'nurut' => $this->request->getVar('nurut'),
          'cmodule' => $this->request->getVar('cmodule'),
          'cmenu' => $this->request->getVar('cmenu'),
          'clokasi_menu' => $this->request->getVar('clokasi_menu'),
          'cparent' => $this->request->getVar('cparent'),
          'cmainmenu' => $cmainmenu,
          'nlevel' => $this->request->getVar('nlevel'),
        ];
        $this->tbmoduleModel->insert($simpandata);
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
      $row = $this->tbmoduleModel->find($id);
      if ($this->request->getVar('cmainmenu') == 'on') {
        $cmainmenu = 'Y';
      } else {
        $cmainmenu = 'N';
      }
      $data = [
        'title' => 'Edit data',
        'id' => $row['id'],
        'nurut' => $row['nurut'],
        'cmodule' => $row['cmodule'],
        'cmenu' => $row['cmenu'],
        'clokasi_menu' => $row['clokasi_menu'],
        'cparent' => $row['cparent'],
        'cmainmenu' => $row['cmainmenu'],
        'nlevel' => $row['nlevel'],
      ];
      $msg = [
        'sukses' => view('tbmodule/modaledit', $data)
      ];
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function updatedata()
  {
    if ($this->request->isAjax()) {
      $session = session();
      $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
      if ($this->request->getVar('cmainmenu') == 'on') {
        $cmainmenu = 'Y';
      } else {
        $cmainmenu = 'N';
      }
      $simpandata = [
        'nurut' => $this->request->getVar('nurut'),
        'cmodule' => $this->request->getVar('cmodule'),
        'cmenu' => $this->request->getVar('cmenu'),
        'clokasi_menu' => $this->request->getVar('clokasi_menu'),
        'cparent' => $this->request->getVar('cparent'),
        'cmainmenu' => $cmainmenu,
        'nlevel' => $this->request->getVar('nlevel'),
      ];
      $id = $this->request->getVar('id');
      $this->tbmoduleModel->update($id, $simpandata);
      $msg = [
        'sukses' => 'Data berhasil disimpan'
      ];
      session()->setFlashdata('pesan', 'Data berhasil diupdate');
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function hapus($id)
  {
    $this->tbmoduleModel->delete_by_id($id);
    session()->setFlashdata('pesan', 'Data berhasil dihapus');
    echo json_encode(array("status" => TRUE));
  }

  public function urutkan()
  {
    $results = $this->tbmoduleModel->orderBy('nurut')->findAll();
    // var_dump($results);
    $i = 1;
    foreach ($results as $row) {
      $nurut = $i;
      $simpandata = [
        'nurut' => $nurut
      ];
      $id = $row['id'];
      $this->tbmoduleModel->update($id, $simpandata);
      $i++;
    }
    session()->setFlashdata('pesan', 'Data berhasil diurutkan');
    echo json_encode(array("status" => TRUE));
  }

  public function table_module()
  {
    $model = new tbmodulemodel();
    $data['title'] = 'Tabel module';
    $data['tbmodule'] = $model->getmodule();
    // dd($data);
    echo view('tbmodule/tabel_module', $data);
  }
}
