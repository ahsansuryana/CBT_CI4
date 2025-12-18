<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSiswaujianTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_siswaUjian' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'ujian_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'constraint' => 11,
            ],
            'peserta_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'constraint' => 11,
            ],
            'mulai_ujian' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'selesai_ujian' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'status' => [
                'type'       => "ENUM('belum','sedang','selesai')",
                'default'    => 'belum',
            ],
            'nilai' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'default'    => 0.00,
            ],
            'benar' => [
                'type'       => 'INT',
                'constraint' => 4,
                'default'    => 0,
            ],
            'salah' => [
                'type'       => 'INT',
                'constraint' => 4,
                'default'    => 0,
            ],
            'kosong' => [
                'type'       => 'INT',
                'constraint' => 4,
                'default'    => 0,
            ],
            'kunci_acak' => [
                'type'       => 'TEXT',
                'null' => true,
                'default'    => null,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_siswaUjian', true);
        $this->forge->addForeignKey('ujian_id', 'm_ujian', 'id_ujian', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('peserta_id', 'm_peserta', 'id_peserta', 'CASCADE', 'CASCADE');
        $this->forge->createTable('siswa_ujian');
    }

    public function down()
    {
        $this->forge->dropTable('siswa_ujian');
    }
}
