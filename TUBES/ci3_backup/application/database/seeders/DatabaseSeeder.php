<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__.'/Seeder.php';

/**
 * DatabaseSeeder — titik masuk semua seeder.
 * Daftarkan seeder baru di method run() ini.
 *
 * Cara menjalankan (dari folder project):
 *   php index.php seed            -> menjalankan DatabaseSeeder (semua seeder)
 *   php index.php seed run UserSeeder  -> menjalankan satu seeder saja
 */
class DatabaseSeeder extends Seeder {

    public function run() {
        $this->call('UserSeeder');
    }
}
