<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Like_model extends CI_Model {

    public function count_likes($laporan_id) {
        return $this->db->where('laporan_id', $laporan_id)->count_all_results('likes');
    }

    public function is_liked($laporan_id, $user_nama) {
        return $this->db->where(['laporan_id' => $laporan_id, 'user_nama' => $user_nama])->count_all_results('likes') > 0;
    }

    public function toggle($laporan_id, $user_nama) {
        if ($this->is_liked($laporan_id, $user_nama)) {
            $this->db->where(['laporan_id' => $laporan_id, 'user_nama' => $user_nama])->delete('likes');
            return false;
        } else {
            $this->db->insert('likes', ['laporan_id' => $laporan_id, 'user_nama' => $user_nama]);
            return true;
        }
    }
}
