<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mobil;

class MobilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Mobil::insert([
            [
                'nama_mobil' => 'New Avanza',
                'plat_nomor' => 'AB 1234 CD',
                'merk' => 'Toyota',
                'tahun' => 2022,
                'harga_sewa' => 350000,
                'harga_all_in' => 650000,
                'status' => 1
            ],
            [
                'nama_mobil' => 'New Agya',
                'plat_nomor' => 'AB 5678 EF',
                'merk' => 'Toyota',
                'tahun' => 2022,
                'harga_sewa' => 325000,
                'harga_all_in' => 625000,
                'status' => 1
            ],
            [
                'nama_mobil' => 'New BR-V',
                'plat_nomor' => 'AB 9101 GH',
                'merk' => 'Honda',
                'tahun' => 2021,
                'harga_sewa' => 400000,
                'harga_all_in' => 700000,
                'status' => 1
            ],
            [
                'nama_mobil' => 'New Fortuner',
                'plat_nomor' => 'B 2367 UYT',
                'merk' => 'Toyota',
                'tahun' => 2022,
                'harga_sewa' => 750000,
                'harga_all_in' => 1100000,
                'status' => 1
            ],
            [
                'nama_mobil' => 'New Brio',
                'plat_nomor' => 'F 9886 UK',
                'merk' => 'Honda',
                'tahun' => 2023,
                'harga_sewa' => 300000,
                'harga_all_in' => 500000,
                'status' => 1
            ],
        ]);
    }
}
