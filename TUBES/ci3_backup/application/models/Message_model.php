<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message_model extends CI_Model {

    private $table = 'messages';

    public function get_all() {
        $this->db->order_by('created_at', 'ASC');
        return $this->db->get($this->table)->result();
    }

    public function create($sender, $message) {
        return $this->db->insert($this->table, [
            'sender'  => $sender,
            'message' => $message,
        ]);
    }
}
