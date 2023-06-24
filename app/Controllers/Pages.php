<?php

namespace App\Controllers;

class Pages extends BaseController
{
  public function index()
  {
    $data = [
      'title' => 'Home',
      'test' => ['satu', 'dua', 'tiga']
    ];
    // echo view('layout/header', $data);
    // echo view('pages/home');
    // echo view('layout/footer');
    echo view('pages/home', $data);

    // echo 'Home';
  }
  public function about()
  {
    $data = [
      'title' => 'About'
    ];
    // echo view('layout/header', $data);
    // echo view('pages/about');
    // echo view('layout/footer');
    echo view('pages/about', $data);
    // echo 'About';
    // echo "Nama saya $this->nama";
  }
  public function contact()
  {
    $data = [
      'title' => 'Contact',
      'alamat' => [
        [
          'tipe' => 'Rumah',
          'alamat' => 'Taman Fasco Blok.B2',
          'kota' => 'Tangerang Selatan'
        ],
        [
          'tipe' => 'Kantor',
          'alamat' => 'Jl. RE. Martadinata No.42',
          'kota' => 'Tangerang Selatan'
        ]
      ]
    ];
    echo view('pages/contact', $data);
  }
}
