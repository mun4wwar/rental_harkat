<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supir;

class SupirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Supir::insert([
            [
                'nama' => 'Budi Santoso',
                'no_hp' => '081234567890',
                'alamat' => 'Jl. Kaliurang Km 7, Yogyakarta',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Slamet Riyadi',
                'no_hp' => '085612345678',
                'alamat' => 'Jl. Wates, Bantul',
                'status' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
