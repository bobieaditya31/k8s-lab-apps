<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'telepon' => '081234567890',
                'alamat' => 'Jl. Merdeka No. 123, Jakarta',
                'nomor_identitas' => '1234567890123456',
                'nomor_sim' => 'SIM123456',
                'status' => 'aktif',
            ],
            [
                'nama' => 'Siti Nurhaliza',
                'email' => 'siti@example.com',
                'telepon' => '082345678901',
                'alamat' => 'Jl. Sudirman No. 456, Bandung',
                'nomor_identitas' => '2345678901234567',
                'nomor_sim' => 'SIM234567',
                'status' => 'aktif',
            ],
            [
                'nama' => 'Ahmad Wijaya',
                'email' => 'ahmad@example.com',
                'telepon' => '083456789012',
                'alamat' => 'Jl. Gatot Subroto No. 789, Surabaya',
                'nomor_identitas' => '3456789012345678',
                'nomor_sim' => 'SIM345678',
                'status' => 'aktif',
            ],
        ];

        $this->db->table('customers')->insertBatch($data);
    }
}
