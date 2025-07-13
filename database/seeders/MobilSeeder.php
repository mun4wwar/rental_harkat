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
                'nama_mobil' => 'Toyota Avanza',
                'plat_nomor' => 'AB1234CD',
                'merk' => 'Toyota',
                'tahun' => 2020,
                'harga_sewa' => 350000,
                'status' => 1
            ],
            [
                'nama_mobil' => 'Daihatsu Xenia',
                'plat_nomor' => 'AB5678EF',
                'merk' => 'Daihatsu',
                'tahun' => 2019,
                'harga_sewa' => 320000,
                'status' => 1
            ],
            [
                'nama_mobil' => 'Honda Brio',
                'plat_nomor' => 'AB9101GH',
                'merk' => 'Honda',
                'tahun' => 2021,
                'harga_sewa' => 400000,
                'status' => 0
            ],
        ]);
    }
}
