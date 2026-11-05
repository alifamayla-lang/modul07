<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__.'/Seeder.php';

/**
 * UserSeeder — membuat akun dummy di tabel users menggunakan Faker.
 *  - 1 akun admin tetap (admin@smarttraffic.id) bila belum ada
 *  - 5 akun user dummy dengan nama/email acak dari Faker (locale id_ID)
 * Semua password disimpan dalam bentuk hash bcrypt (password_hash), bukan teks asli.
 */
class UserSeeder extends Seeder {

    const JUMLAH_DUMMY    = 5;
    const PASSWORD_DUMMY  = 'password123';

    public function run() {
        if (!class_exists('Faker\Factory')) {
            show_error('Library Faker belum terpasang. Jalankan: composer install   (atau: composer require --dev fakerphp/faker)');
        }

        $faker = Faker\Factory::create('id_ID');
        $dibuat = [];

        // Akun admin tetap (dilewati bila sudah ada)
        if (!$this->db->where('email', 'admin@smarttraffic.id')->count_all_results('users')) {
            $this->db->insert('users', [
                'nama_lengkap' => 'Administrator',
                'email'        => 'admin@smarttraffic.id',
                'password'     => password_hash('admin123', PASSWORD_DEFAULT),
                'role'         => 'admin',
            ]);
            $dibuat[] = ['Administrator', 'admin@smarttraffic.id', 'admin123', 'admin'];
        }

        // Lewati bila akun dummy (email @example.*) sudah ada, agar seeder aman dijalankan berulang
        $sudah_ada = $this->db->like('email', '@example.', 'both')->where('role', 'user')->count_all_results('users');
        $jumlah = min($sudah_ada, self::JUMLAH_DUMMY);
        if ($jumlah >= self::JUMLAH_DUMMY) {
            echo "  (akun dummy sudah ada, dilewati)\n";
        }

        // 5 akun dummy dari Faker
        while ($jumlah < self::JUMLAH_DUMMY) {
            $email = $faker->unique()->safeEmail();
            if ($this->db->where('email', $email)->count_all_results('users')) {
                continue; // email sudah ada di database, buat yang lain
            }
            $nama = $faker->name();
            $this->db->insert('users', [
                'nama_lengkap' => $nama,
                'email'        => $email,
                'password'     => password_hash(self::PASSWORD_DUMMY, PASSWORD_DEFAULT),
                'telepon'      => substr($faker->phoneNumber(), 0, 20),
                'lokasi'       => $faker->city(),
                'role'         => 'user',
            ]);
            $dibuat[] = [$nama, $email, self::PASSWORD_DUMMY, 'user'];
            $jumlah++;
        }

        // Tampilkan akun yang dibuat agar mudah dipakai untuk uji login
        foreach ($dibuat as $row) {
            printf("  - %-28s %-34s pass: %-12s (%s)\n", $row[0], $row[1], $row[2], $row[3]);
        }
    }
}
