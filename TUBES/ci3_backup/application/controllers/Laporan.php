<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Laporan_model');
        $this->load->library('form_validation');
    }

    /**
     * READ — Daftar semua laporan
     */
    public function index() {
        $keyword = $this->input->get('q', TRUE);

        if ($keyword) {
            $data['laporan'] = $this->Laporan_model->search($keyword, 'verified');
        } else {
            $data['laporan'] = $this->Laporan_model->get_verified();
        }

        $data['title']       = 'Data Laporan — Smart Traffic Finder';
        $data['user_nama']   = $this->user_nama;
        $data['inisial']     = strtoupper(substr($this->user_nama, 0, 1));
        $data['active_page'] = 'laporan';
        $data['keyword']     = $keyword;

        $this->load->view('templates/header', $data);
        $this->load->view('laporan/index', $data);
        $this->load->view('templates/footer', $data);
    }

    /**
     * CREATE — Form tambah laporan baru
     */
    public function tambah() {
        $data['title']       = 'Lapor Insiden — Smart Traffic Finder';
        $data['user_nama']   = $this->user_nama;
        $data['inisial']     = strtoupper(substr($this->user_nama, 0, 1));
        $data['active_page'] = 'laporan';
        $data['laporan']     = NULL;
        $data['action']      = base_url('Laporan/simpan');

        $this->load->view('templates/header', $data);
        $this->load->view('laporan/form', $data);
        $this->load->view('templates/footer', $data);
    }

    /**
     * UPDATE — Form edit laporan
     */
    public function edit($id) {
        $laporan = $this->Laporan_model->get_by_id($id);
        if (!$laporan) {
            $this->session->set_flashdata('error', 'Laporan tidak ditemukan!');
            redirect(base_url('Laporan'));
        }

        $data['title']       = 'Edit Laporan — Smart Traffic Finder';
        $data['user_nama']   = $this->user_nama;
        $data['inisial']     = strtoupper(substr($this->user_nama, 0, 1));
        $data['active_page'] = 'laporan';
        $data['laporan']     = $laporan;
        $data['action']      = base_url('Laporan/simpan/' . $id);

        $this->load->view('templates/header', $data);
        $this->load->view('laporan/form', $data);
        $this->load->view('templates/footer', $data);
    }

    /**
     * SIMPAN — 1 tombol untuk Create & Update + Upload file
     */
    public function simpan($id = NULL) {
        // Validasi form
        $this->form_validation->set_rules('lokasi',    'Lokasi',    'required|trim');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required|trim');

        if ($id) {
            $this->form_validation->set_rules('nama_pelapor', 'Nama Pelapor', 'required|trim');
        }

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors(' ', ' | '));
            if ($id) {
                redirect(base_url('Laporan/edit/' . $id));
            } else {
                redirect(base_url('Laporan/tambah'));
            }
        }

        $lokasi    = $this->input->post('lokasi', TRUE);
        $deskripsi = $this->input->post('deskripsi', TRUE);

        // --- Proses Upload File ---
        $foto_path = '';

        if (!empty($_FILES['foto']['name'])) {
            // Buat folder uploads jika belum ada
            $upload_dir = FCPATH . 'uploads/laporan/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, TRUE);
            }

            $config_upload = array(
                'upload_path'   => $upload_dir,
                'allowed_types' => 'jpg|jpeg|png|gif',
                'max_size'      => 5120,
                'encrypt_name'  => TRUE,
            );

            $this->load->library('upload', $config_upload);

            if ($this->upload->do_upload('foto')) {
                $upload_data = $this->upload->data();
                $foto_path   = 'uploads/laporan/' . $upload_data['file_name'];

                // Hapus foto lama jika update
                if ($id) {
                    $old = $this->Laporan_model->get_by_id($id);
                    if ($old && !empty($old->foto) && file_exists(FCPATH . $old->foto)) {
                        unlink(FCPATH . $old->foto);
                    }
                }
            } else {
                $this->session->set_flashdata('error', 'Upload foto gagal: ' . $this->upload->display_errors('', ''));
                if ($id) {
                    redirect(base_url('Laporan/edit/' . $id));
                } else {
                    redirect(base_url('Laporan/tambah'));
                }
            }
        }

        // --- Susun data untuk DB ---
        $db_data = array(
            'lokasi'    => $lokasi,
            'deskripsi' => $deskripsi,
        );

        if (!empty($foto_path)) {
            $db_data['foto'] = $foto_path;
        }

        // --- Create atau Update ---
        if ($id) {
            $db_data['nama_pelapor'] = $this->input->post('nama_pelapor', TRUE);
            $this->Laporan_model->update($id, $db_data);
            $this->session->set_flashdata('success', 'Laporan berhasil diperbarui!');
        } else {
            $db_data['nama_pelapor'] = $this->user_nama;
            if (empty($db_data['foto'])) {
                $db_data['foto'] = '';
            }
            $this->Laporan_model->create($db_data);
            $this->session->set_flashdata('success', 'Laporan berhasil ditambahkan!');
        }

        redirect(base_url('Laporan'));
    }

    /**
     * DELETE — Hapus laporan
     */
    public function hapus($id) {
        $laporan = $this->Laporan_model->get_by_id($id);
        if (!$laporan) {
            $this->session->set_flashdata('error', 'Laporan tidak ditemukan!');
            redirect(base_url('Laporan'));
        }
        $this->Laporan_model->delete($id);
        $this->session->set_flashdata('success', 'Laporan berhasil dihapus!');
        redirect(base_url('Laporan'));
    }

    /**
     * Detail laporan
     */
    public function detail($id) {
        $laporan = $this->Laporan_model->get_by_id($id);
        if (!$laporan) {
            $this->session->set_flashdata('error', 'Laporan tidak ditemukan!');
            redirect(base_url('Laporan'));
        }

        $data['title']       = 'Detail Laporan — Smart Traffic Finder';
        $data['user_nama']   = $this->user_nama;
        $data['inisial']     = strtoupper(substr($this->user_nama, 0, 1));
        $data['active_page'] = 'laporan';
        $data['laporan']     = $laporan;

        $this->load->view('templates/header', $data);
        $this->load->view('laporan/detail', $data);
        $this->load->view('templates/footer', $data);
    }
}
