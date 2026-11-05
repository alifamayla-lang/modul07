<?php
$host = "localhost";
$user = "root"; 
$pass = "";     
$db   = "smart_traffic"; // Pastikan kamu sudah membuat database dengan nama ini di phpMyAdmin

$conn = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>