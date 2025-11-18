<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUjianTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_ujian' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kode_ujian' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'mapel_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'       => true,
                'null'       => true,
            ],
            'nama_ujian' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'banksoal_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'       => true,
                'null'       => true,
            ],
            'tanggal_mulai' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'tanggal_selesai' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'durasi' => [
                'type'       => 'INT',
                'constraint' => 4,
                'default'    => 60, // default 60 menit
            ],
            'jumlah_soal' => [
                'type'       => 'INT',
                'constraint' => 4,
                'default'    => 10,
            ],
            'acak_soal' => [
                'type'       => "ENUM('Y','N')",
                'default'    => 'Y',
            ],
            'acak_opsi' => [
                'type'       => "ENUM('Y','N')",
                'default'    => 'Y',
            ],
            'tampil_nilai' => [
                'type'       => "ENUM('Y','N')",
                'default'    => 'Y',
            ],
            'status' => [
                'type'       => "ENUM('draft','aktif','selesai')",
                'default'    => 'draft',
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

        $this->forge->addKey('id_ujian', true);
        $this->forge->addForeignKey('mapel_id', 'm_mapel', 'id_mapel', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('banksoal_id', 'm_banksoal', 'bank_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('m_ujian');
    }

    public function down()
    {
        $this->forge->dropTable('m_ujian');
    }
}
