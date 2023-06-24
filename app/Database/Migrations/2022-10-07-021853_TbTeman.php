<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TbTeman extends Migration
{
    public function up()
    {
        // Membuat kolom/field untuk tabel tb_teman
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'namateman'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'default'        => '',
            ],
            'alamat'      => [
                'type'           => 'TEXT',
                'default'        => '',
            ],
            'jeniskelamin' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'default'        => '',
            ],
            'created_at' => [
                'type'           => 'DATETIME',
                'null'           => TRUE,
            ],
            'updated_at' => [
                'type'           => 'DATETIME',
                'null'           => TRUE,
            ],
        ]);

        // Membuat primary key
        $this->forge->addKey('id', TRUE);

        // Membuat tabel news
        $this->forge->createTable('tb_teman', TRUE);
    }

    public function down()
    {
        // menghapus tabel tb_teman
        $this->forge->dropTable('tb_teman');
    }
}
