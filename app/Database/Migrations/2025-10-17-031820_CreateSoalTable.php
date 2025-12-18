<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSoalTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_soal' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'ujian_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'       => true,
                'null'       => true,
            ],
            'bank_soal_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'       => true,
                'null'       => false,
            ],
            'nomor' => [
                'type'       => 'INT',
                'constraint' => 3,
                'null'       => true,
                'unsigned'       => true,
            ],
            'bobot' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'default'    => 1.00,
            ],
            'acak_opsi' => [
                'type'       => "ENUM('Y','N')",
                'default'    => 'Y',
            ],
            'jenis_soal' => [
                'type'       => "ENUM('pg','esai')",
                'default'    => 'pg',
            ],
            'pertanyaan' => [
                'type' => 'TEXT',
            ],
            'opsi_a' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'opsi_b' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'opsi_c' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'opsi_d' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'opsi_e' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'jawaban_benar' => [
                'type'       => 'VARCHAR',
                'constraint' => '5',
                'null'       => true,
            ],
            'pembahasan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'tingkat_kesulitan' => [
                'type'       => "ENUM('mudah','sedang','sulit')",
                'default'    => 'sedang',
            ],
            'status' => [
                'type'       => "ENUM('aktif','nonaktif')",
                'default'    => 'aktif',
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);

        $this->forge->addKey('id_soal', true);
        $this->forge->addForeignKey('ujian_id', 'm_ujian', 'id_ujian', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('bank_soal_id', 'm_banksoal', 'bank_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('m_soal');
    }

    public function down()
    {
        $this->forge->dropTable('m_soal');
    }
}
