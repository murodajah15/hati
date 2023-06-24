<?php

namespace App\Controllers;

use App\Models\Tb_temanModel;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Data Tabel Server Side Teman',
        ];
        return view('v_tb_teman', $data);
        // return view('v_tb_teman');
    }

    function temanAjax()
    {
        $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
        $katakunci = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
        $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
        $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';

        $this->model = new Tb_temanModel();
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
}
