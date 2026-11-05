<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('form_validation');

        // Pesan galat validasi dalam Bahasa Indonesia
        $this->form_validation->set_message('required',     '{field} wajib diisi.');
        $this->form_validation->set_message('valid_email',  '{field} harus berupa alamat email yang valid.');
        $this->form_validation->set_message('min_length',    '{field} minimal {param} karakter.');
        $this->form_validation->set_message('max_length',    '{field} maksimal {param} karakter.');
        $this->form_validation->set_message('matches',       'Konfirmasi Kata Sandi tidak sama dengan {param}.');
        $this->form_validation->set_message('is_unique',     '{field} sudah terdaftar. Gunakan email lain atau silakan login.');
    }

    /**
     * Pengguna yang sudah login tidak perlu melihat halaman login/register lagi.
     */
    private function redirect_if_logged_in() {
        if ($this->session->userdata('user_id')) {
            $target = ($this->session->userdata('user_role') === 'admin') ? 'Admin' : 'Dashboard';
            redirect(base_url($target));
        }
    }

    public function index() {
        $this->login();
    }

    public function login() {
        $this->redirect_if_logged_in();
        $data['title'] = 'Login — Smart Traffic Finder';
        $this->load->view('auth/login', $data);
    }

    public function register() {
        $this->redirect_if_logged_in();
        $data['title'] = 'Daftar — Smart Traffic Finder';
        $this->load->view('auth/register', $data);
    }

    public function lupa_password() {
        $this->redirect_if_logged_in();

        $data['title']          = 'Lupa Password - Smart Traffic Finder';
        $data['step']           = 1;
        $data['email_verified'] = '';

        $this->load->view('auth/forgot_password', $data);
    }

    public function proses_login() {
        $this->redirect_if_logged_in();

        $this->form_validation->set_rules('email',    'Email',     'required|trim|strtolower|valid_email|max_length[100]');
        $this->form_validation->set_rules('password', 'Kata Sandi', 'required');

        // Validasi gagal -> tampilkan kembali form beserta pesan galat per kolom
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Login — Smart Traffic Finder';
            $this->load->view('auth/login', $data);
            return;
        }

        $email    = $this->input->post('email', TRUE);
        $password = $this->input->post('password');
        $user     = $this->User_model->cek_login($email, $password);

        if ($user) {
            // Ganti ID session setelah login agar terhindar dari session fixation
            $this->session->sess_regenerate(TRUE);
            $this->session->set_userdata([
                'user_id'    => $user->id,
                'user_nama'  => $user->nama,
                'user_email' => $user->email,
                'user_role'  => $user->role,
            ]);
            redirect(base_url($user->role === 'admin' ? 'Admin' : 'Dashboard'));
        }

        // Email/password tidak cocok (pesan sengaja tidak menyebut mana yang salah)
        $data['title']       = 'Login — Smart Traffic Finder';
        $data['login_error'] = 'Email atau kata sandi salah. Periksa kembali lalu coba lagi.';
        $this->load->view('auth/login', $data);
    }

    public function proses_register() {
        $this->redirect_if_logged_in();

        $this->form_validation->set_rules('nama_lengkap',     'Nama Lengkap',        'required|trim|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('email',            'Email',               'required|trim|strtolower|valid_email|max_length[100]|is_unique[users.email]');
        $this->form_validation->set_rules('password',         'Kata Sandi',          'required|min_length[8]|max_length[72]');
        $this->form_validation->set_rules('password_confirm', 'Konfirmasi Kata Sandi', 'required|matches[password]');

        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Daftar — Smart Traffic Finder';
            $this->load->view('auth/register', $data);
            return;
        }

        $data = [
            'nama_lengkap' => $this->input->post('nama_lengkap', TRUE),
            'email'        => $this->input->post('email', TRUE),
            // Password disimpan dalam bentuk hash (bcrypt), bukan teks asli
            'password'     => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'role'         => 'user',
        ];

        $this->db->insert('users', $data);

        $this->session->set_flashdata('success', 'Pendaftaran berhasil! Silakan login.');
        redirect(base_url('Auth/login'));
    }

    public function proses_cek_email() {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', 'Masukkan alamat email yang valid.');
            redirect(base_url('Auth/lupa_password'));
        }

        $email = $this->input->post('email', TRUE);
        $user  = $this->User_model->get_by_email($email);

        if (!$user) {
            $this->session->set_flashdata('error', 'Alamat email tidak ditemukan.');
            redirect(base_url('Auth/lupa_password'));
        }

        $data['title']          = 'Reset Password - Smart Traffic Finder';
        $data['step']           = 2;
        $data['email_verified'] = $email;

        $this->load->view('auth/forgot_password', $data);
    }

    public function proses_reset_password() {
        $this->form_validation->set_rules('email_target', 'Email', 'required|valid_email|trim');
        $this->form_validation->set_rules('pass_baru', 'Kata Sandi Baru', 'required|min_length[8]');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors(' ', ' | '));
            redirect(base_url('Auth/lupa_password'));
        }

        $email = $this->input->post('email_target', TRUE);
        $user  = $this->User_model->get_by_email($email);

        if (!$user) {
            $this->session->set_flashdata('error', 'Alamat email tidak ditemukan.');
            redirect(base_url('Auth/lupa_password'));
        }

        $this->User_model->update_password_by_email($email, $this->input->post('pass_baru'));
        $this->session->set_flashdata('success', 'Password berhasil direset. Silakan login dengan password baru.');
        redirect(base_url('Auth/login'));
    }

    public function logout() {
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('user_nama');
        $this->session->unset_userdata('user_email');
        $this->session->unset_userdata('user_role');
        $this->session->sess_destroy();

        $cookie_name = $this->config->item('sess_cookie_name') ?: 'ci_session';
        setcookie($cookie_name, '', time() - 3600, '/');

        redirect(base_url('Auth/login'));
    }
}
