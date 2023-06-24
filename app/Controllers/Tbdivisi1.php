<?php

namespace App\Controllers;

use App\Models\TbdivisiModel;

class Tbdivisi extends BaseController
{
  protected $tbdivisiModel;
  public function __construct()
  {
    $this->tbdivisiModel = new TbdivisiModel();
  }

  public function listdata()
  {
    // $request = Services::request();
    // $datamodel = new TbdivisiModel($request);
    // if ($request->getMethod(true) == 'POST') {
    //   $lists = $datamodel->get_datatables();
    //   $data = [];
    //   $no = $request->getPost("start");
    //   foreach ($lists as $list) {
    //     $no++;
    //     $row = [];
    //     $row[] = '';
    //     $data[] = $row;
    //   }
    //   $output = [
    //     "draw" => $request->getPost('draw'),
    //     "recordsTotal" => $datamodel->count_all(),
    //     "recordsFiltered" => $datamodel->count_filtered(),
    //     "data" => $data
    //   ];
    //   echo json_encode($output);
    // }
  }

  public function index()
  {
    $data = [
      'menu' => 'file',
      'submenu' => 'tbdivisi',
      'title' => 'Tabel Divisi',
      'tbdivisi' => $this->tbdivisiModel->orderBy('kode')->findAll() //$tbdivisi
    ];
    echo view('tbdivisi/index', $data);
  }

  function get_json()
  {
    $this->load->library('datatables');
    $this->datatables->add_column('no', 'ID-$1', 'kode');
    $this->datatables->select('kode,nama');
  }

  public function detail($id)
  {
    $data = [
      'menu' => 'file',
      'submenu' => 'tbdivisi',
      'title' => 'Detail tabel divisi',
      'tbdivisi' => $this->tbdivisiModel->getdivisi($id)
    ];
    if (empty($data['tbdivisi'])) {
      throw new \CodeIgniter\Exceptions\PageNotFoundException('Id divisi' . $id . 'tidak ditemukan.');
    }
    return view('tbdivisi/detail', $data);
  }

  public function create()
  {
    // session();
    $data = [
      'menu' => 'file',
      'submenu' => 'tbdivisi',
      'title' => 'Tambah tabel divisi',
      'validation' => \Config\Services::validation()
    ];
    return view('tbdivisi/create', $data);
  }

  public function save()
  {
    // validasi input
    if (!$this->validate([
      'kode' => [
        'rules' => 'required|is_unique[tbdivisi.kode]',
        'errors' => [
          'required' => '{field} Kode divisi harus diisi.',
          'is_unique' => '{field} Kode divisi sudah terdaftar'
        ]
      ],
      'nama' => [
        'rules' => 'required|is_unique[tbdivisi.kode]',
        'errors' => [
          'required' => '{field} Kode divisi harus diisi.',
          'is_unique' => '{field} Kode divisi sudah terdaftar'

        ]
      ]
    ])) {
      // $validation = \Config\Services::validation();
      // return redirect()->to('/tbdivisi/create')->withInput()->with('validation', $validation);
      return redirect()->to('/tbdivisi/create')->withInput();
      // $data['validation'] = $validation;
      // return view('tbdivisi/create', $data);
    }
    $session = session();
    $user = "Tambah-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
    $this->tbdivisiModel->save([
      'kode' => $this->request->getVar('kode'),
      'nama' => $this->request->getVar('nama'),
      'user' => $user //$this->request->getVar('sampul')
    ]);
    session()->setFlashdata('pesan', 'Data berhasil disimpan');
    return redirect()->to('/tbdivisi');
  }

  public function delete($id)
  {
    // hapus gambar di img
    $tbdivisi = $this->tbdivisiModel->find($id);
    $this->tbdivisiModel->delete($id);
    session()->setFlashdata('pesan', 'Data berhasil dihapus');
    return redirect()->to('/tbdivisi');
  }

  public function edit($id)
  {
    $data = [
      'menu' => 'file',
      'submenu' => 'tbdivisi',
      'title' => 'Edit tabel divisi',
      'validation' => \Config\Services::validation(),
      'tbdivisi' => $this->tbdivisiModel->getdivisi($id)
    ];
    return view('tbdivisi/edit', $data);
  }

  public function update($id)
  {
    // dd($this->request->getVar('id'));
    // validasi input
    $kodeLama = $this->tbdivisiModel->getdivisi($this->request->getVar('id'));
    dd($kodeLama);
    if ($kodeLama['kode'] == $this->request->getVar('kode')) {
      $rule_kode = "required";
    } else {
      $rule_kode = "required|is_unique[tbdivisi.kode]";
    }
    // dd($kodeLama['kode'] . ' | ' . $this->request->getVar('kode'));
    if (!$this->validate([
      // 'judul' => 'required|is_unique[tbdivisi.judul]'
      'kode' => [
        'rules' => $rule_kode,
        'errors' => [
          'required' => '{field} divisi harus diisi.',
          'is_unique' => '{field} divisi sudah terdaftar'
        ],
      ]
    ])) {
      // $validation = \Config\Services::validation();
      // dd($validation);
      return redirect()->to('/tbdivisi/edit/' . $this->request->getVar('id'))->withInput(); //->with('validation', $validation);
      // $data['validation'] = $validation;
      // return view('tbdivisi/create', $data);
    }
    $session = session();
    $user = "Edit-" . $session->get('nama') . "-" . date('d-m-Y H:i:s');
    $this->tbdivisiModel->save([
      'id' => $id,
      'kode' => $this->request->getVar('kode'),
      'nama' => $this->request->getVar('nama'),
      'user' => $user
    ]);
    session()->setFlashdata('pesan', 'Data berhasil diubah');
    return redirect()->to('/tbdivisi');
  }
}
