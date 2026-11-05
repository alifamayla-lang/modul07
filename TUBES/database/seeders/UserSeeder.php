<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // 1. Akun Administrator Tetap untuk Pengujian Login
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@smarttraffic.id'],
            [
                'name' => 'Administrator Smart Traffic',
                'password' => Hash::make('admin123'),
                'telepon' => '081234567890',
                'lokasi' => 'Command Center Dishub Bandung',
                'status_pengguna' => 'Super Admin',
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // 2. Akun Dummy Pengguna Menggunakan Faker (Minimal 5 Akun)
        for ($i = 1; $i <= 5; $i++) {
            $email = "user{$i}@smarttraffic.id";
            DB::table('users')->updateOrInsert(
                ['email' => $email],
                [
                    'name' => $faker->name,
                    'password' => Hash::make('password123'),
                    'telepon' => $faker->phoneNumber,
                    'lokasi' => $faker->randomElement(['Buah Batu, Bandung', 'Dago, Bandung', 'Cibiru, Bandung', 'Lengkong, Bandung', 'Antapani, Bandung']),
                    'status_pengguna' => 'Pengguna Aktif',
                    'role' => 'user',
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
