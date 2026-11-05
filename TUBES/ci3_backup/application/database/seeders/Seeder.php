<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Seeder — kelas dasar untuk semua seeder.
 * CodeIgniter 3 tidak punya fitur seeder bawaan seperti Laravel,
 * jadi struktur ini meniru pola Laravel: DatabaseSeeder memanggil seeder lain lewat call().
 */
abstract class Seeder {

    /** @var CI_Controller */
    protected $CI;
    /** @var CI_DB_query_builder */
    protected $db;

    public function __construct() {
        $this->CI =& get_instance();
        $this->db = $this->CI->db;
    }

    abstract public function run();

    /** Jalankan seeder lain (mirip $this->call() di Laravel). */
    protected function call($class) {
        require_once __DIR__.'/'.$class.'.php';
        echo "Seeding: {$class}\n";
        (new $class())->run();
    }
}
