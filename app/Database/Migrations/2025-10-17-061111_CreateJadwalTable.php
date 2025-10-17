<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJadwalTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_jadwal' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'ujian_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],

            'tanggal' => [
                'type' => 'DATE',
            ],
            'jam_mulai' => [
                'type' => 'TIME',
            ],
            'jam_selesai' => [
                'type' => 'TIME',
            ],
            'status' => [
                'type'       => "ENUM('belum mulai','berlangsung','selesai')",
                'default'    => 'belum mulai',
            ],
            'token_akses' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => true,
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

        $this->forge->addKey('id_jadwal', true);
        $this->forge->addForeignKey('ujian_id', 'm_ujian', 'id_ujian', 'CASCADE', 'CASCADE');
        $this->forge->createTable('m_jadwal');
    }

    public function down()
    {
        $this->forge->dropTable('m_jadwal');
    }
}
