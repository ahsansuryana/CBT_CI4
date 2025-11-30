<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MapelSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_mapel' => 'Bahasa Arab',
            ],
            [
                'nama_mapel' => 'Bahasa Inggis',
            ],
            [
                'nama_mapel' => 'Bahasa Indonesia',
            ],
        ];

        // Insert banyak data sekaligus
        $this->db->table('m_mapel')->insertBatch($data);
    }
}
