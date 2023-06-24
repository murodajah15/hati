<?php

namespace App\Controllers;

use App\Models\TbcabangModel;

class Tbcabang extends BaseController
{
  protected $tbcabangModel;
  public function __construct()
  {
    $this->tbcabangModel = new TbcabangModel();
  }


  public function index()
  {
    $data = [
      'menu' => 'file',
      'submenu' => 'tbcabang',
      'title' => 'Tabel Cabang',
      'tbcabang' => $this->tbcabangModel->orderBy('kode')->findAll() //$tbcabang
    ];
    echo view('tbcabang/index', $data);
  }

  public function detail($id)
  {
    $data = [
      'menu' => 'file',
      'submenu' => 'tbcabang',
      'title' => 'Detail Tabel Cabang',
      'tbcabang' => $this->tbcabangModel->getCabang($id)
    ];
    if (empty($data['tbcabang'])) {
      throw new \CodeIgniter\Exceptions\PageNotFoundException('Id Cabang' . $id . 'tidak ditemukan.');
    }
    return view('tbcabang/detail', $data);
  }

  public function create()
  {
    // session();
    $data = [
      'menu' => 'file',
      'submenu' => 'tbcabang',
      'title' => 'Tambah Tabel Cabang',
      'validation' => \Config\Services::validation()
    ];
    return view('tbcabang/create', $data);
  }

  public function save()
  {
    // validasi input
    if (!$this->validate([
      'kode' => [
        'rules' => 'required|is_unique[tbcabang.kode]',
        'errors' => [
          'required' => '{field} Kode Cabang harus diisi.',
          'is_unique' => '{field} Kode Cabang sudah terdaftar'
        ]
      ],
      'nama' => [
        'rules' => 'required|is_unique[tbcabang.kode]',
        'errors' => [
          'required' => '{field} Kode Cabang harus diisi.',
          'is_unique' => '{field} Kode Cabang sudah terdaftar'

        ]
      ]
    ])) {
      // $validation = \Config\Services::validation();
      // return redirect()->to('/tbcabang/create')->withInput()->with('validation', $validation);
      return redirect()->to('/tbcabang/create')->withInput();
      // $data['validation'] = $validation;
      // return view('tbcabang/create', $data);
    }
    $session = session();
    $user = "Tambah-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
    $this->tbcabangModel->save([
      'kode' => $this->request->getVar('kode'),
      'nama' => $this->request->getVar('nama'),
      'user' => $user //$this->request->getVar('sampul')
    ]);
    session()->setFlashdata('pesan', 'Data berhasil disimpan');
    return redirect()->to('/tbcabang');
  }

  public function delete($id)
  {
    // hapus gambar di img
    $tbcabang = $this->tbcabangModel->find($id);
    $this->tbcabangModel->delete($id);
    session()->setFlashdata('pesan', 'Data berhasil dihapus');
    return redirect()->to('/tbcabang');
  }

  public function edit($id)
  {
    $data = [
      'menu' => 'file',
      'submenu' => 'tbcabang',
      'title' => 'Edit Tabel Cabang',
      'validation' => \Config\Services::validation(),
      'tbcabang' => $this->tbcabangModel->getcabang($id)
    ];
    return view('tbcabang/edit', $data);
  }

  public function update($id)
  {
    // dd($this->request->getVar('id'));
    // validasi input
    $kodeLama = $this->tbcabangModel->getCabang($this->request->getVar('id'));
    // dd($kodeLama);
    if ($kodeLama['kode'] == $this->request->getVar('kode')) {
      $rule_kode = "required";
    } else {
      $rule_kode = "required|is_unique[tbcabang.kode]";
    }
    // dd($kodeLama['kode'] . ' | ' . $this->request->getVar('kode'));
    if (!$this->validate([
      // 'judul' => 'required|is_unique[tbcabang.judul]'
      'kode' => [
        'rules' => $rule_kode,
        'errors' => [
          'required' => '{field} cabang harus diisi.',
          'is_unique' => '{field} cabang sudah terdaftar'
        ],
      ]
    ])) {
      // $validation = \Config\Services::validation();
      // dd($validation);
      return redirect()->to('/tbcabang/edit/' . $this->request->getVar('id'))->withInput(); //->with('validation', $validation);
      // $data['validation'] = $validation;
      // return view('tbcabang/create', $data);
    }
    $session = session();
    $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
    $this->tbcabangModel->save([
      'id' => $id,
      'kode' => $this->request->getVar('kode'),
      'nama' => $this->request->getVar('nama'),
      'user'  => $user
    ]);
    session()->setFlashdata('pesan', 'Data berhasil diubah');
    return redirect()->to('/tbcabang');
  }
}
