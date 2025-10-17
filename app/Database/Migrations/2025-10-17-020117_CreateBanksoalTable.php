<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBanksoalTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'bank_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_bank' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'mapel_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
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

        $this->forge->addKey('bank_id', true);
        $this->forge->createTable('m_banksoal');
    }

    public function down()
    {
        $this->forge->dropTable('m_banksoal');
    }
}
