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
                'tipe_id' => 1,
                'plat_nomor' => 'AB 1234 CD',
                'merk' => 'Toyota',
                'tahun' => 2022,
                'harga_sewa' => 350000,
                'harga_all_in' => 650000,
                'status' => 1
            ],
            [
                'nama_mobil' => 'New Agya',
                'tipe_id' => 1,
                'plat_nomor' => 'AB 5678 EF',
                'merk' => 'Toyota',
                'tahun' => 2022,
                'harga_sewa' => 325000,
                'harga_all_in' => 625000,
                'status' => 1
            ],
            [
                'nama_mobil' => 'Raize',
                'tipe_id' => 2,
                'plat_nomor' => 'AB 8789 EF',
                'merk' => 'Toyota',
                'tahun' => 2022,
                'harga_sewa' => 350000,
                'harga_all_in' => 650000,
                'status' => 1
            ],
            [
                'nama_mobil' => 'New BR-V',
                'tipe_id' => 2,
                'plat_nomor' => 'AB 9101 GH',
                'merk' => 'Honda',
                'tahun' => 2021,
                'harga_sewa' => 400000,
                'harga_all_in' => 700000,
                'status' => 1
            ],
            [
                'nama_mobil' => 'New Innova Reborn',
                'tipe_id' => 1,
                'plat_nomor' => 'B 8879 OKL',
                'merk' => 'Toyota',
                'tahun' => 2022,
                'harga_sewa' => 450000,
                'harga_all_in' => 850000,
                'status' => 1
            ],
            [
                'nama_mobil' => 'New Fortuner GR',
                'tipe_id' => 3,
                'plat_nomor' => 'B 2367 UYT',
                'merk' => 'Toyota',
                'tahun' => 2022,
                'harga_sewa' => 1100000,
                'harga_all_in' => 1100000,
                'status' => 1
            ],
            [
                'nama_mobil' => 'New Brio',
                'tipe_id' => 1,
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
