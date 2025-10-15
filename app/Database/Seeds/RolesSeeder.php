<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'admin',
            ],
            [
                'name' => 'guru',
            ],
            [
                'name' => 'santri',
            ],
        ];

        // Insert banyak data sekaligus
        $this->db->table('m_roles')->insertBatch($data);
    }
}
