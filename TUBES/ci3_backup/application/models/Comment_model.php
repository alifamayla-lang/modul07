<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comment_model extends CI_Model {

    public function get_by_laporan($laporan_id) {
        $this->db->where('laporan_id', $laporan_id);
        $this->db->order_by('created_at', 'ASC');
        return $this->db->get('comments')->result();
    }

    public function count_comments($laporan_id) {
        return $this->db->where('laporan_id', $laporan_id)->count_all_results('comments');
    }

    public function create($laporan_id, $user_nama, $komentar) {
        return $this->db->insert('comments', [
            'laporan_id' => $laporan_id,
            'user_nama'  => $user_nama,
            'komentar'   => $komentar,
        ]);
    }
}
