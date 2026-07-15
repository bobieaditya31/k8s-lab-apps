<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class VehicleSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'plat_nomor' => 'B 1234 ABC',
                'merek' => 'Toyota',
                'model' => 'Avanza',
                'tipe' => 'mobil',
                'tahun' => 2022,
                'warna' => 'Putih',
                'harga_perhari' => 350000,
                'status' => 'tersedia',
            ],
            [
                'plat_nomor' => 'B 5678 DEF',
                'merek' => 'Honda',
                'model' => 'PCX',
                'tipe' => 'motor',
                'tahun' => 2023,
                'warna' => 'Merah',
                'harga_perhari' => 80000,
                'status' => 'tersedia',
            ],
            [
                'plat_nomor' => 'B 9012 GHI',
                'merek' => 'Daihatsu',
                'model' => 'Xenia',
                'tipe' => 'mobil',
                'tahun' => 2021,
                'warna' => 'Silver',
                'harga_perhari' => 300000,
                'status' => 'tersedia',
            ],
            [
                'plat_nomor' => 'B 3456 JKL',
                'merek' => 'Suzuki',
                'model' => 'Ertiga',
                'tipe' => 'mobil',
                'tahun' => 2022,
                'warna' => 'Hitam',
                'harga_perhari' => 400000,
                'status' => 'tersedia',
            ],
            [
                'plat_nomor' => 'B 7890 MNO',
                'merek' => 'Yamaha',
                'model' => 'Nmax',
                'tipe' => 'motor',
                'tahun' => 2023,
                'warna' => 'Biru',
                'harga_perhari' => 100000,
                'status' => 'tersedia',
            ],
        ];

        $this->db->table('vehicles')->insertBatch($data);
    }
}
