<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNotificationTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_notification' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],

            'user_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
            ],

            'endpoint' => [
                'type' => 'TEXT',
                'null' => false,
            ],

            'p256dh' => [
                'type' => 'TEXT',
                'null' => false,
            ],

            'auth' => [
                'type' => 'TEXT',
                'null' => false,
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

        $this->forge->addKey('id_notification', true);
        $this->forge->addForeignKey('user_id', 'm_users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('m_notification', true);
    }

    public function down()
    {
        $this->forge->dropTable('m_notification', true);
    }
}
