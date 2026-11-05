<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * MY_Controller — Base Controller
 * Semua controller yang butuh login harus extends class ini.
 */
class MY_Controller extends CI_Controller {

    protected $user_id;
    protected $user_nama;
    protected $user_email;
    protected $user_role;

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');

        // Cek apakah user sudah login
        if (!$this->session->userdata('user_id')) {
            redirect(base_url('Auth/login'));
        }

        $this->user_id    = $this->session->userdata('user_id');
        $this->user_nama  = $this->session->userdata('user_nama');
        $this->user_email = $this->session->userdata('user_email');
        $this->user_role  = $this->session->userdata('user_role') ?: 'user';
    }

    protected function require_admin() {
        if ($this->user_role !== 'admin') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman admin.');
            redirect(base_url('Dashboard'));
        }
    }
}
