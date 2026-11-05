<?php
session_start();
include 'koneksi.php';

$step = 1; // Default menampilkan form cek email
$pesan_error = "";
$email_verified = "";

// LANGKAH 1: Cek apakah email ada di database
if (isset($_POST['cek_email'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    $query = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    
    if (mysqli_num_rows($query) > 0) {
        // Email ketemu, lanjut ke langkah 2
        $step = 2;
        $email_verified = $email;
    } else {
        $pesan_error = "Alamat email tidak ditemukan di sistem kami!";
    }
}

// LANGKAH 2: Simpan password baru
if (isset($_POST['reset_password'])) {
    $email_target = mysqli_real_escape_string($conn, $_POST['email_target']);
    $pass_baru = $_POST['pass_baru'];
    
    // Enkripsi password baru
    $pass_hash = password_hash($pass_baru, PASSWORD_DEFAULT);
    
    // Update ke database
    $update_query = "UPDATE users SET password = '$pass_hash' WHERE email = '$email_target'";
    
    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Password berhasil direset! Silakan login dengan password baru.'); window.location='Hlogin.php';</script>";
        exit;
    } else {
        $pesan_error = "Gagal mereset password!";
        $step = 2; // Tetap di form reset
        $email_verified = $email_target;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Smart Traffic Cam</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .fade-in { animation: fadeIn 0.4s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-[24px] shadow-xl border border-gray-100 w-full max-w-md p-8 fade-in">
        
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4 text-orange-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
            </div>
            <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Lupa Password?</h1>
            <p class="text-sm text-gray-500 mt-2">Jangan khawatir, kami akan membantu Anda memulihkan akses ke akun Anda.</p>
        </div>

        <?php if (!empty($pesan_error)): ?>
            <div class="bg-red-50 border border-red-200 text-red-600 text-sm p-3 rounded-xl mb-6 text-center font-medium">
                <?php echo $pesan_error; ?>
            </div>
        <?php endif; ?>

        <?php if ($step == 1): ?>
        <form action="" method="POST" class="space-y-5 fade-in">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">Alamat Email Terdaftar</label>
                <input type="email" name="email" required placeholder="Contoh: budi@email.com" class="w-full px-4 py-3.5 rounded-xl bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500 transition text-gray-800 font-medium">
            </div>
            
            <button type="submit" name="cek_email" class="w-full bg-orange-600 hover:bg-orange-700 text-white font-bold py-3.5 px-8 rounded-xl shadow-md transition-all active:scale-95 text-center">
                Verifikasi Email
            </button>
        </form>
        <?php endif; ?>

        <?php if ($step == 2): ?>
        <form action="" method="POST" class="space-y-5 fade-in">
            <input type="hidden" name="email_target" value="<?php echo htmlspecialchars($email_verified); ?>">
            
            <div class="bg-green-50 border border-green-200 text-green-700 text-sm p-3 rounded-xl mb-4 text-center font-medium">
                Email ditemukan! Silakan buat kata sandi baru.
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">Kata Sandi Baru</label>
                <input type="password" name="pass_baru" required minlength="6" placeholder="Minimal 6 karakter" class="w-full px-4 py-3.5 rounded-xl bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500 transition text-gray-800 font-medium">
            </div>
            
            <button type="submit" name="reset_password" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3.5 px-8 rounded-xl shadow-md transition-all active:scale-95 text-center">
                Simpan Password Baru
            </button>
        </form>
        <?php endif; ?>

        <div class="mt-8 text-center border-t border-gray-100 pt-6">
            <a href="Hlogin.php" class="text-sm font-bold text-gray-500 hover:text-orange-600 transition flex items-center justify-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke halaman Login
            </a>
        </div>

    </div>
</body>
</html>