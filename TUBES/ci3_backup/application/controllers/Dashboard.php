<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Laporan_model', 'Like_model', 'Comment_model']);
    }

    public function index() {
        $laporan_list = $this->Laporan_model->get_verified(10);

        // Tambahkan data like & comment ke setiap laporan
        foreach ($laporan_list as &$lap) {
            $lap->like_count   = $this->Like_model->count_likes($lap->id);
            $lap->is_liked     = $this->Like_model->is_liked($lap->id, $this->user_nama);
            $lap->comment_count = $this->Comment_model->count_comments($lap->id);
            $lap->comments     = $this->Comment_model->get_by_laporan($lap->id);
        }

        $data['title']          = 'Dashboard — Smart Traffic Finder';
        $data['user_nama']      = $this->user_nama;
        $data['inisial']        = strtoupper(substr($this->user_nama, 0, 1));
        $data['total_laporan']  = $this->Laporan_model->count_by_status('verified');
        $data['laporan_terbaru'] = $laporan_list;
        $data['active_page']    = 'dashboard';

        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/footer', $data);
    }

    public function like($laporan_id) {
        $this->Like_model->toggle($laporan_id, $this->user_nama);
        redirect(base_url('Dashboard'));
    }

    public function komentar($laporan_id) {
        $komentar = $this->input->post('komentar', TRUE);
        if (!empty(trim($komentar))) {
            $this->Comment_model->create($laporan_id, $this->user_nama, $komentar);
        }
        redirect(base_url('Dashboard'));
    }
}
