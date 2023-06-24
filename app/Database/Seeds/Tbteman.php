<?php

namespace App\Database\Seeds;

use CodeIgniter\I18n\Time;

use CodeIgniter\Database\Seeder;

class Tbteman extends Seeder
{
    public function run()
    {
        $data = [
            [
                'namateman' => 'Murod',
                'alamat'    => 'Fasco',
                'jeniskelamin'    => 'LAKI',
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ],
            [
                'namateman' => 'darth',
                'alamat'    => 'darth@theempire.com',
                'jeniskelamin'    => 'LAKI',
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ],
        ];

        // Simple Queries
        // $this->db->query('INSERT INTO tb_teman (namateman,alamat,jeniskelamin,created_at,updated_at) VALUES(:namateman:, :alamat:, :jeniskelamin:, :created_at:, :updated_at:)', $data);

        // Using Query Builder
        // $this->db->table('tb_teman')->insert($data);
        $this->db->table('tb_teman')->insertBatch($data);
    }
}
