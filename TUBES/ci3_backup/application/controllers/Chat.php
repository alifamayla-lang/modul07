<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Message_model');
    }

    public function index() {
        $data['title']       = 'Chat — Smart Traffic Finder';
        $data['user_nama']   = $this->user_nama;
        $data['inisial']     = strtoupper(substr($this->user_nama, 0, 1));
        $data['active_page'] = 'chat';
        $data['messages']    = $this->Message_model->get_all();

        $this->load->view('chat/index', $data);
    }

    public function kirim() {
        $pesan = $this->input->post('pesan', TRUE);
        if (!empty(trim($pesan))) {
            $this->Message_model->create($this->user_nama, $pesan);
        }
        redirect(base_url('Chat'));
    }
}
