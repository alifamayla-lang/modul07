<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['User_model', 'Laporan_model']);
    }

    public function index() {
        $user = $this->User_model->get_by_id($this->user_id);

        $lokasi_user = (!empty($user->lokasi) && $user->lokasi != '-') ? $user->lokasi : 'Bandung, ID';
        $status_user = (!empty($user->status) && $user->status != '-') ? $user->status : 'Pengguna Aktif';

        // Hitung total laporan user
        $this->db->where('nama_pelapor', $this->user_nama);
        $total_laporan = $this->db->count_all_results('laporan');

        // Ambil aktivitas terkini (5 laporan terakhir user ini)
        $this->db->where('nama_pelapor', $this->user_nama);
        $this->db->order_by('waktu_laporan', 'DESC');
        $this->db->limit(5);
        $aktivitas = $this->db->get('laporan')->result();

        $data['title']          = 'Profil — Smart Traffic Finder';
        $data['user_nama']      = $this->user_nama;
        $data['inisial']        = strtoupper(substr($this->user_nama, 0, 1));
        $data['active_page']    = 'profil';
        $data['lokasi_user']    = $lokasi_user;
        $data['status_user']    = $status_user;
        $data['total_laporan']  = $total_laporan;
        $data['aktivitas']      = $aktivitas;
        $data['user_data']      = $user;

        $this->load->view('profil/index', $data);
    }
}
