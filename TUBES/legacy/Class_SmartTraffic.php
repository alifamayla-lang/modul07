<?php
// File: Class_SmartTraffic.php

class UserAuth {
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function cekLogin() {
        if (!isset($_SESSION['user'])) {
            header("Location: Hlogin.php");
            exit;
        }
    }

    public function getNamaUser() {
        return $_SESSION['user'];
    }

    public function getInisial() {
        return strtoupper(substr($this->getNamaUser(), 0, 1));
    }
}

class Laporan {
    private $koneksi;

    public function __construct($db) {
        $this->koneksi = $db;
    }

    // Mengambil data laporan dari database
    public function getLaporanTerbaru($limit = 10) {
        $query = "SELECT * FROM laporan ORDER BY waktu_laporan DESC LIMIT $limit";
        return mysqli_query($this->koneksi, $query);
    }

    // Memformat selisih waktu (Baru saja, menit lalu, dst)
    public function formatWaktuBerlalu($waktu_laporan) {
        $waktu_db = strtotime($waktu_laporan);
        $selisih = time() - $waktu_db;
        
        if ($selisih < 60) {
            return "Baru saja";
        } elseif ($selisih < 3600) {
            return floor($selisih / 60) . " menit yang lalu";
        } elseif ($selisih < 86400) {
            return floor($selisih / 3600) . " jam yang lalu";
        } else {
            return floor($selisih / 86400) . " hari yang lalu";
        }
    }

    // Mengambil format Tanggal (contoh: 12)
    public function formatTanggal($waktu_laporan) {
        return date('d', strtotime($waktu_laporan));
    }

    // Mengambil format Bulan (contoh: MAR)
    public function formatBulan($waktu_laporan) {
        return strtoupper(date('M', strtotime($waktu_laporan)));
    }

    // Method baru untuk menyimpan laporan (Create & Upload)
    public function tambahLaporan($data_post, $data_file, $nama_pelapor) {
        // Sanitasi input agar aman dari SQL Injection
        $lokasi = mysqli_real_escape_string($this->koneksi, $data_post['lokasi']);
        $deskripsi = mysqli_real_escape_string($this->koneksi, $data_post['deskripsi']);

        // Proses Foto
        $nama_foto = $data_file['foto_kejadian']['name'];
        $tmp_foto = $data_file['foto_kejadian']['tmp_name'];
        
        // Ganti nama foto agar unik
        $foto_baru = time() . "_" . $nama_foto;
        $path = "uploads/" . $foto_baru;

        // Cek dan buat folder otomatis jika belum ada
        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }

        // Pindahkan foto ke folder uploads
        if (move_uploaded_file($tmp_foto, $path)) {
            // Masukkan ke database
            $query = "INSERT INTO laporan (nama_pelapor, lokasi, deskripsi, foto) VALUES ('$nama_pelapor', '$lokasi', '$deskripsi', '$path')";
            
            if (mysqli_query($this->koneksi, $query)) {
                return ['status' => 'sukses', 'pesan' => 'Laporan berhasil dikirim!'];
            } else {
                return ['status' => 'gagal', 'pesan' => 'Gagal menyimpan ke database!'];
            }
        } else {
            return ['status' => 'gagal', 'pesan' => 'Gagal mengunggah foto!'];
        }
    }
}
?>