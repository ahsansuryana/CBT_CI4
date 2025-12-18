<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSiswaJawabanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_siswaJawaban' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'siswaUjian_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'constraint' => 11,
            ],
            'nomor' => [
                'type'       => 'INT',
                'constraint' => 3,
                'unsigned'       => true,
            ],
            'jawaban' => [
                'type'       => 'VARCHAR',
                'constraint' => 5,
                'null'       => true,
            ],
            'benar' => [
                'type'       => "ENUM('Y','N')",
                'default'    => 'N',
            ],
            'nilai' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'default'    => 0.00,
            ],
            'ragu' => [
                'type'       => 'BOOLEAN',
                'default' => false,
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

        $this->forge->addKey('id_siswaJawaban', true);
        $this->forge->addForeignKey('pesertaUjian_id', 'siswa_ujian', 'id_siswaUjian', 'CASCADE', 'CASCADE');
        $this->forge->createTable('siswa_jawaban');
    }

    public function down()
    {
        $this->forge->dropTable('siswa_jawaban');
    }
}
