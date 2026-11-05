<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    private $table = 'users';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Cek login berdasarkan email dan password
     * Tabel users menggunakan kolom 'nama_lengkap'
     */
    public function cek_login($email, $password) {
        $this->db->where('email', $email);
        $query = $this->db->get($this->table);
        $user  = $query->row();

        if ($user && password_verify($password, $user->password)) {
            // Tambahkan property 'nama' agar kompatibel dengan session
            $user->nama = $user->nama_lengkap;
            $user->role = isset($user->role) ? $user->role : 'user';
            return $user;
        }
        return FALSE;
    }

    /**
     * Ambil data user berdasarkan ID
     */
    public function get_by_id($id) {
        $user = $this->db->get_where($this->table, ['id' => $id])->row();
        if ($user) {
            $user->nama = $user->nama_lengkap;
        }
        return $user;
    }

    public function get_by_email($email) {
        $user = $this->db->get_where($this->table, ['email' => $email])->row();
        if ($user) {
            $user->nama = $user->nama_lengkap;
        }
        return $user;
    }

    public function update_profile($id, array $data) {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function update_password($id, $password) {
        return $this->db->where('id', $id)->update($this->table, [
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ]);
    }

    public function update_password_by_email($email, $password) {
        return $this->db->where('email', $email)->update($this->table, [
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ]);
    }
}
