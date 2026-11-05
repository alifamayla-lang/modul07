<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaporanSeeder extends Seeder
{
    public function run(): void
    {
        $laporans = [
            [
                'nama_pelapor' => 'Budi Santoso',
                'lokasi' => 'Jl. Buah Batu, Simpang Pasar Kordon',
                'deskripsi' => 'Terjadi kemacetan cukup padat mengular hingga 1 km akibat peningkatan volume kendaraan jam pulang kerja dan perbaikan jalan di sisi kiri.',
                'foto' => 'https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?auto=format&fit=crop&w=800&q=80',
                'status_verifikasi' => 'verified',
                'tingkat_kemacetan' => 75,
                'waktu_laporan' => now()->subMinutes(25),
                'created_at' => now()->subMinutes(25),
                'updated_at' => now()->subMinutes(25),
            ],
            [
                'nama_pelapor' => 'Siti Rahmawati',
                'lokasi' => 'Jl. Ir. H. Juanda (Dago Bawah)',
                'deskripsi' => 'Kondisi lalu lintas terpantau ramai lancar, cuaca berawan. Kendaraan roda dua dan roda empat melaju dengan kecepatan rata-rata 35 km/jam.',
                'foto' => 'https://images.unsplash.com/photo-1506521781263-d8422e82f27a?auto=format&fit=crop&w=800&q=80',
                'status_verifikasi' => 'verified',
                'tingkat_kemacetan' => 30,
                'waktu_laporan' => now()->subHours(2),
                'created_at' => now()->subHours(2),
                'updated_at' => now()->subHours(2),
            ],
            [
                'nama_pelapor' => 'Ahmad Haris',
                'lokasi' => 'Jl. Soekarno Hatta (Dekat MIM)',
                'deskripsi' => 'Ada kecelakaan ringan antara dua minibus di jalur cepat. Petugas Dishub dan Polantas sudah tiba di lokasi untuk evakuasi lajur.',
                'foto' => 'https://images.unsplash.com/photo-1542362567-b07e54358753?auto=format&fit=crop&w=800&q=80',
                'status_verifikasi' => 'verified',
                'tingkat_kemacetan' => 60,
                'waktu_laporan' => now()->subHours(5),
                'created_at' => now()->subHours(5),
                'updated_at' => now()->subHours(5),
            ],
            [
                'nama_pelapor' => 'Fajar Ramadhan',
                'lokasi' => 'Jl. Asia Afrika (Simpang Alun-alun)',
                'deskripsi' => 'Lampu lalu lintas di persimpangan berfungsi normal, namun penumpukan kendaraan terjadi karena penyeberang jalan cukup ramai.',
                'foto' => 'https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?auto=format&fit=crop&w=800&q=80',
                'status_verifikasi' => 'verified',
                'tingkat_kemacetan' => 45,
                'waktu_laporan' => now()->subDay(),
                'created_at' => now()->subDay(),
                'updated_at' => now()->subDay(),
            ],
        ];

        foreach ($laporans as $item) {
            DB::table('laporan')->updateOrInsert(
                ['lokasi' => $item['lokasi']],
                $item
            );
        }

        // Dummy messages
        $messages = [
            ['sender' => 'Administrator', 'message' => 'Selamat datang di ruang informasi lalu lintas Bandung. Mohon jaga kesopanan.', 'created_at' => now()->subHours(4), 'updated_at' => now()->subHours(4)],
            ['sender' => 'Budi Santoso', 'message' => 'Daerah Dago lancar ya sore ini kawan-kawan?', 'created_at' => now()->subMinutes(40), 'updated_at' => now()->subMinutes(40)],
            ['sender' => 'Siti Rahmawati', 'message' => 'Lancar om Budi, baru aja lewat simpang BIP.', 'created_at' => now()->subMinutes(15), 'updated_at' => now()->subMinutes(15)],
        ];

        foreach ($messages as $msg) {
            DB::table('messages')->updateOrInsert(
                ['message' => $msg['message']],
                $msg
            );
        }
    }
}
