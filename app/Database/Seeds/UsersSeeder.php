<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'role_id' => 1, // admin
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ],
            [
                'role_id' => 2, // guru
                'username' => 'ustadz',
                'email' => 'guru@example.com',
                'password' => password_hash('guru123', PASSWORD_DEFAULT),
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ],
            [
                'role_id' => 3, // santri
                'username' => 'ahsan',
                'email' => 'ahsan@example.com',
                'password' => password_hash('santri123', PASSWORD_DEFAULT),
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ],
        ];

        $this->db->table('m_users')->insertBatch($data);
    }
}
