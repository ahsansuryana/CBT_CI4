<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePesertaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_peserta' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_peserta' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'jk_peserta' => [
                'type'       => 'ENUM',
                'constraint' => ['L', 'P'],
            ],
            'telp_peserta' => [
                'type' => 'VARCHAR',
                'constraint' => '20',

            ],
            'email_peserta' => [
                'type' => 'VARCHAR',
                'constraint' => '255',

            ],
            'alamat_peserta' => [
                'type'       => 'TEXT',
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],

        ]);

        $this->forge->addKey('id_peserta', true);
        $this->forge->createTable('m_peserta');
    }

    public function down()
    {
        $this->forge->dropTable('m_peserta');
    }
}
