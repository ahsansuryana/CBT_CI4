<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PesertaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_id' => '2',
                'nama_peserta' => 'Muhamad Ahsan Suryanaputra',
                'jk_peserta' => 'L',
                'telp_peserta' => '081234567890',
                'alamat_peserta' => 'Bandung Panyileukan'
            ],
        ];

        // Insert banyak data sekaligus
        $this->db->table('m_peserta')->insertBatch($data);
    }
}
