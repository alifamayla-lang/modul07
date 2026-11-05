<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_model extends CI_Model {

    private $table = 'laporan';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Ambil semua laporan (dengan pagination)
     */
    public function get_all($limit = NULL, $offset = 0, $status = NULL) {
        if ($status !== NULL) {
            $this->db->where('status_verifikasi', $status);
        }
        $this->db->order_by('waktu_laporan', 'DESC');
        if ($limit !== NULL) {
            return $this->db->get($this->table, $limit, $offset)->result();
        }
        return $this->db->get($this->table)->result();
    }

    /**
     * Hitung total laporan
     */
    public function count_all() {
        return $this->db->count_all($this->table);
    }

    public function count_by_status($status) {
        return $this->db->where('status_verifikasi', $status)->count_all_results($this->table);
    }

    public function get_pending($limit = NULL, $offset = 0) {
        return $this->get_all($limit, $offset, 'pending');
    }

    public function get_verified($limit = NULL, $offset = 0) {
        return $this->get_all($limit, $offset, 'verified');
    }

    /**
     * Ambil satu laporan berdasarkan ID
     */
    public function get_by_id($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    /**
     * Simpan laporan baru (Create) + upload file
     */
    public function create($data) {
        $data['waktu_laporan'] = date('Y-m-d H:i:s');
        if (!isset($data['status_verifikasi'])) {
            $data['status_verifikasi'] = 'pending';
        }
        return $this->db->insert($this->table, $data);
    }

    /**
     * Update laporan (Update) + opsional upload file baru
     */
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Hapus laporan (Delete)
     */
    public function delete($id) {
        // Ambil dulu nama foto untuk dihapus dari server
        $laporan = $this->get_by_id($id);
        if ($laporan && !empty($laporan->foto)) {
            $foto_path = FCPATH . $laporan->foto;
            if (file_exists($foto_path)) {
                unlink($foto_path);
            }
        }
        return $this->db->delete($this->table, ['id' => $id]);
    }

    /**
     * Cari laporan berdasarkan keyword
     */
    public function search($keyword, $status = NULL) {
        if ($status !== NULL) {
            $this->db->where('status_verifikasi', $status);
        }

        $this->db->group_start();
        $this->db->like('lokasi', $keyword);
        $this->db->or_like('nama_pelapor', $keyword);
        $this->db->or_like('deskripsi', $keyword);
        $this->db->group_end();
        $this->db->order_by('waktu_laporan', 'DESC');
        return $this->db->get($this->table)->result();
    }

    public function update_verification($id, $status, $admin_nama, $catatan = '') {
        return $this->db->where('id', $id)->update($this->table, [
            'status_verifikasi' => $status,
            'verified_by'       => $admin_nama,
            'verified_at'       => date('Y-m-d H:i:s'),
            'catatan_admin'     => $catatan,
        ]);
    }
}
