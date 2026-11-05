<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Legacy extends CI_Controller {

    public function login() {
        redirect(base_url('Auth/login'));
    }

    public function register() {
        redirect(base_url('Auth/register'));
    }

    public function dashboard() {
        redirect(base_url('Dashboard'));
    }

    public function laporan_form() {
        redirect(base_url('Laporan/tambah'));
    }

    public function detail_laporan() {
        $id = (int) $this->input->get('id');
        redirect(base_url($id > 0 ? 'Laporan/detail/'.$id : 'Laporan'));
    }

    public function chat() {
        redirect(base_url('Chat'));
    }

    public function profil() {
        redirect(base_url('Profil'));
    }

    public function pengaturan() {
        redirect(base_url('Pengaturan'));
    }

    public function ganti_sandi() {
        redirect(base_url('Pengaturan/ganti_sandi'));
    }

    public function lupa_password() {
        redirect(base_url('Auth/lupa_password'));
    }

    public function logout() {
        redirect(base_url('Auth/logout'));
    }
}
