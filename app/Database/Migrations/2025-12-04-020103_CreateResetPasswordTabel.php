<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateResetPasswordTabel extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_reset_password' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],

            'token' => [
                'type' => 'CHAR',
                'constraint' => 64,
            ],
            'expires_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_reset_password', true);
        $this->forge->addForeignKey('user_id', 'm_users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('t_reset_password');
    }

    public function down()
    {
        $this->forge->dropTable('t_reset_password');
    }
}
