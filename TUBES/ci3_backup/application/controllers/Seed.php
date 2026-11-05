<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Seed — menjalankan seeder dari command line saja (padanan "php artisan db:seed").
 *
 *   php index.php seed                  -> DatabaseSeeder (semua seeder)
 *   php index.php seed run UserSeeder   -> satu seeder tertentu
 *
 * Diblokir bila diakses lewat browser.
 */
class Seed extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!is_cli()) {
            show_404();
        }
    }

    public function index() {
        $this->run('DatabaseSeeder');
    }

    public function run($class = 'DatabaseSeeder') {
        $class = preg_replace('/[^A-Za-z0-9_]/', '', $class);
        $file  = APPPATH.'database/seeders/'.$class.'.php';

        if (!is_file($file)) {
            echo "Seeder '{$class}' tidak ditemukan.\n";
            return;
        }

        require_once $file;
        echo "Seeding database...\n";
        (new $class())->run();
        echo "Seeding selesai.\n";
    }
}
