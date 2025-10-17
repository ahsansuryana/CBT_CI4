<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTutorTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'kode_tutor' => [
                'type'       => 'CHAR',
                'constraint' => 50,
            ],
            'nama_tutor' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'telp_tutor' => [
                'type' => 'VARCHAR',
                'constraint' => '20',

            ],
            'alamat_tutor' => [
                'type' => 'TEXT',
            ],
        ]);
        $this->forge->addKey('kode_tutor', true);
        $this->forge->createTable('m_tutor');
    }

    public function down()
    {
        $this->forge->dropTable('m_tutor');
    }
}
