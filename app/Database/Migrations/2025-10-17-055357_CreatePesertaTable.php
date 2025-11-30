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
            'user_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
            'nama_peserta' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'jk_peserta' => [
                'type'       => 'ENUM',
                'constraint' => ['L', 'P'],
                'null' => true,
                'default' => null
            ],
            'telp_peserta' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
                'default' => null
            ],
            'alamat_peserta' => [
                'type'       => 'TEXT',
                'null' => true,
                'default' => null
            ],
        ]);

        $this->forge->addKey('id_peserta', true);
        $this->forge->addForeignKey('user_id', 'm_users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('m_peserta');
    }

    public function down()
    {
        $this->forge->dropTable('m_peserta');
    }
}
