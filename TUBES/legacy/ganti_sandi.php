<?php
session_start();
include 'koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user'])) {
    header("Location: Hlogin.php");
    exit;
}

$nama_user = $_SESSION['user'];

// Logika ketika tombol "Simpan Kata Sandi" ditekan
if (isset($_POST['ganti_sandi'])) {
    $pass_lama = $_POST['pass_lama'];
    $pass_baru = $_POST['pass_baru'];
    $konfirmasi_pass = $_POST['konfirmasi_pass'];

    // Ambil password lama (yang di-hash) dari database
    $query = mysqli_query($conn, "SELECT password FROM users WHERE nama_lengkap = '$nama_user'");
    
    if ($query && mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
        
        // Verifikasi apakah password lama yang diinput cocok dengan di database
        if (password_verify($pass_lama, $data['password'])) {
            
            // Cek apakah password baru dan konfirmasi cocok
            if ($pass_baru === $konfirmasi_pass) {
                
                // Enkripsi password baru
                $pass_baru_hash = password_hash($pass_baru, PASSWORD_DEFAULT);
                
                // Update ke database
                $update_query = "UPDATE users SET password = '$pass_baru_hash' WHERE nama_lengkap = '$nama_user'";
                if (mysqli_query($conn, $update_query)) {
                    echo "<script>alert('Kata sandi berhasil diubah!'); window.location='pengaturan.php';</script>";
                } else {
                    echo "<script>alert('Gagal memperbarui kata sandi di database.');</script>";
                }
            } else {
                echo "<script>alert('Kata sandi baru dan konfirmasi tidak cocok!');</script>";
            }
        } else {
            echo "<script>alert('Kata sandi lama salah!');</script>";
        }
    } else {
        echo "<script>alert('Data pengguna tidak ditemukan!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Kata Sandi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .fade-in { animation: fadeIn 0.3s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>

<body class="p-4 md:p-8 max-w-[600px] mx-auto fade-in h-screen flex flex-col justify-center">

    <div class="flex items-center mb-6">
        <a href="pengaturan.php" class="p-2 mr-4 text-gray-700 bg-white shadow-sm border border-gray-100 hover:bg-gray-50 rounded-full transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Ganti Kata Sandi</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 mb-8">
        
        <p class="text-sm text-gray-500 mb-6">Pastikan kata sandi baru Anda unik dan tidak mudah ditebak oleh orang lain.</p>
        
        <form action="" method="POST" class="space-y-5">
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">Kata Sandi Lama</label>
                <div class="relative">
                    <input type="password" name="pass_lama" required class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500 transition text-gray-800 font-medium">
                </div>
            </div>

            <div class="h-px bg-gray-100 my-4"></div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">Kata Sandi Baru</label>
                <input type="password" name="pass_baru" required minlength="6" class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500 transition text-gray-800 font-medium" placeholder="Minimal 6 karakter">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">Konfirmasi Kata Sandi Baru</label>
                <input type="password" name="konfirmasi_pass" required minlength="6" class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500 transition text-gray-800 font-medium" placeholder="Ulangi kata sandi baru">
            </div>

            <div class="mt-8 pt-6 border-t border-gray-100">
                <button type="submit" name="ganti_sandi" class="w-full bg-orange-600 hover:bg-orange-700 text-white font-bold py-3.5 px-8 rounded-xl shadow-md transition-all active:scale-95 text-center">
                    Simpan Kata Sandi
                </button>
            </div>
        </form>
    </div>

</body>
</html>