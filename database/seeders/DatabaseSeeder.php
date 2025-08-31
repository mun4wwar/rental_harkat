<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'password' => Hash::make('password'),
                'role' => 1,
            ],
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 2,
            ],
            [
                'name' => 'Supir User',
                'email' => 'supir@example.com',
                'password' => Hash::make('password'),
                'role' => 3,
            ],
            [
                'name' => 'Customer User',
                'email' => 'customer@example.com',
                'password' => Hash::make('password'),
                'role' => 4,
            ],
        ];

        foreach ($users as $u) {
            User::updateOrCreate(
                ['email' => $u['email']],
                $u
            );
        }

        // Seeder lainnya
        $this->call([
            TipeMobilSeeder::class,
            MobilSeeder::class,
            SupirSeeder::class,
            CitiesSeeder::class,
            BookingExpiredSeeder::class,
        ]);
    }
}
