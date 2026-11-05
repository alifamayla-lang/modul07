<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->require_admin();
        $this->load->model('Laporan_model');
    }

    public function index() {
        $data['title']            = 'Dashboard Admin - Smart Traffic Finder';
        $data['user_nama']        = $this->user_nama;
        $data['inisial']          = strtoupper(substr($this->user_nama, 0, 1));
        $data['total_laporan']    = $this->Laporan_model->count_all();
        $data['pending_count']    = $this->Laporan_model->count_by_status('pending');
        $data['verified_count']   = $this->Laporan_model->count_by_status('verified');
        $data['rejected_count']   = $this->Laporan_model->count_by_status('rejected');
        $data['laporan_pending']  = $this->Laporan_model->get_pending();
        $data['laporan_terbaru']  = $this->Laporan_model->get_all(5);
        $data['cctv_list']        = $this->get_cctv_list();

        $this->load->view('admin/dashboard', $data);
    }

    public function verifikasi($id) {
        $status = $this->input->post('status', TRUE);
        $catatan = $this->input->post('catatan_admin', TRUE);

        if (!in_array($status, ['verified', 'rejected'], TRUE)) {
            $this->session->set_flashdata('error', 'Status verifikasi tidak valid.');
            redirect(base_url('Admin'));
        }

        $laporan = $this->Laporan_model->get_by_id($id);
        if (!$laporan) {
            $this->session->set_flashdata('error', 'Laporan tidak ditemukan.');
            redirect(base_url('Admin'));
        }

        $this->Laporan_model->update_verification($id, $status, $this->user_nama, $catatan);

        $message = ($status === 'verified')
            ? 'Laporan berhasil diverifikasi.'
            : 'Laporan ditolak.';
        $this->session->set_flashdata('success', $message);
        redirect(base_url('Admin'));
    }

    private function get_cctv_list() {
        return [
            [
                'name'     => 'Simpang Dago',
                'location' => 'Jl. Ir. H. Juanda',
                'status'   => 'Online',
                'density'  => 'Sedang',
            ],
            [
                'name'     => 'Asia Afrika',
                'location' => 'Jl. Asia Afrika',
                'status'   => 'Online',
                'density'  => 'Padat',
            ],
            [
                'name'     => 'Pasteur',
                'location' => 'Gerbang Tol Pasteur',
                'status'   => 'Online',
                'density'  => 'Lancar',
            ],
            [
                'name'     => 'Cibiru',
                'location' => 'Bundaran Cibiru',
                'status'   => 'Maintenance',
                'density'  => 'Tidak tersedia',
            ],
        ];
    }
}
