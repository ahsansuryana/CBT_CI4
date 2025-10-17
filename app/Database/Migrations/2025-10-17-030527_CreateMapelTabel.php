<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMapelTabel extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_mapel' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kode_mapel' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'nama_mapel' => [
                'type' => 'VARCHAR',
                'constraint' => '255',

            ],
        ]);
        $this->forge->addKey('id_mapel', true);
        $this->forge->createTable('m_mapel');
    }

    public function down()
    {
        $this->forge->dropTable('m_mapel');
    }
}
