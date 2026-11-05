<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function index() {
        $user = $this->User_model->get_by_id($this->user_id);

        $data['title']       = 'Pengaturan Akun — Smart Traffic Finder';
        $data['user_nama']   = $this->user_nama;
        $data['active_page'] = 'profil';
        $data['user_data']   = $user;

        $this->load->view('pengaturan/index', $data);
    }

    public function update() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors(' ', ' | '));
            redirect(base_url('Pengaturan'));
        }

        $update_data = [
            'nama_lengkap' => $this->input->post('nama_lengkap', TRUE),
            'email'        => $this->input->post('email', TRUE),
            'telepon'      => $this->input->post('telepon', TRUE),
            'lokasi'       => $this->input->post('lokasi', TRUE),
            'status'       => $this->input->post('status', TRUE),
        ];

        $this->User_model->update_profile($this->user_id, $update_data);

        // Update session jika nama berubah
        $this->session->set_userdata('user_nama', $update_data['nama_lengkap']);

        $this->session->set_flashdata('success', 'Profil berhasil diperbarui!');
        redirect(base_url('Pengaturan'));
    }

    public function ganti_sandi() {
        $data['title']       = 'Ganti Kata Sandi - Smart Traffic Finder';
        $data['user_nama']   = $this->user_nama;
        $data['active_page'] = 'profil';

        $this->load->view('pengaturan/ganti_sandi', $data);
    }

    public function update_password() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('pass_lama', 'Kata Sandi Lama', 'required');
        $this->form_validation->set_rules('pass_baru', 'Kata Sandi Baru', 'required|min_length[8]');
        $this->form_validation->set_rules('konfirmasi_pass', 'Konfirmasi Kata Sandi', 'required|matches[pass_baru]');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors(' ', ' | '));
            redirect(base_url('Pengaturan/ganti_sandi'));
        }

        $user = $this->User_model->get_by_id($this->user_id);
        if (!$user || !password_verify($this->input->post('pass_lama'), $user->password)) {
            $this->session->set_flashdata('error', 'Kata sandi lama salah.');
            redirect(base_url('Pengaturan/ganti_sandi'));
        }

        $this->User_model->update_password($this->user_id, $this->input->post('pass_baru'));
        $this->session->set_flashdata('success', 'Kata sandi berhasil diubah.');
        redirect(base_url('Pengaturan'));
    }
}
