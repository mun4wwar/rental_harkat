<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Loop buat generate beberapa pelanggan
        for ($i = 1; $i <= 10; $i++) {
            Pelanggan::create([
                'nama' => "Pelanggan $i",
                'email' => "pelanggan$i@example.com",
                'no_telp' => '08123456789' . $i,
                'alamat' => "Jl. Contoh Alamat No. $i",
            ]);
        }
    }
}
