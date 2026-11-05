<?php
include 'koneksi.php';

// PENTING: Mengecek apakah tombol 'Daftar Akun' (name="signup") diklik
if (isset($_POST['signup'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi password

    // Cek apakah email sudah terdaftar
    $cek_email = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
    
    if(mysqli_num_rows($cek_email) > 0) {
        echo "<script>alert('Pendaftaran gagal! Alamat Email sudah terdaftar.');</script>";
    } else {
        $query = "INSERT INTO users (nama_lengkap, email, password) VALUES ('$nama', '$email', '$password')";
        if (mysqli_query($conn, $query)) {
            // Akan diarahkan ke Hlogin.php jika sukses
            echo "<script>alert('Pendaftaran Berhasil! Silakan login untuk melanjutkan.'); window.location='Hlogin.php';</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan sistem, pendaftaran gagal!');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Smart Traffic Finder</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

<div id="page-signup" class="flex items-center justify-center min-h-screen p-4 md:p-8">
    <div class="bg-white rounded-[24px] shadow-2xl shadow-gray-200/50 w-full max-w-4xl flex flex-col-reverse md:flex-row overflow-hidden border border-gray-100">

        <div class="hidden md:flex w-1/2 bg-gradient-to-br from-orange-500 to-orange-600 p-12 flex-col text-center justify-center text-white relative overflow-hidden">
            <div class="absolute top-0 left-0 opacity-10 transform -translate-x-1/3 -translate-y-1/3">
                <svg width="300" height="300" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14.5v-9l6 4.5-6 4.5z"/></svg>
            </div>
            
            <div class="relative z-10 flex flex-col items-center">
                <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                </div>
                <h2 class="text-4xl font-extrabold mb-4 tracking-tight leading-tight">Sudah Punya<br>Akun?</h2>
                <p class="text-orange-100 font-medium text-lg leading-relaxed mb-10 max-w-sm">Masuk untuk melihat laporan lalu lintas terbaru dan kelola rute perjalanan Anda.</p>
                
                <a href="Hlogin.php" class="bg-white text-orange-600 font-extrabold px-8 py-4 rounded-xl shadow-lg hover:bg-gray-50 hover:shadow-xl transition-all active:scale-95 flex items-center gap-2">
                    Masuk Sekarang
                </a>
            </div>
        </div>

        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
            
            <div class="text-center mb-10">
                <div class="flex items-center justify-center space-x-3 mb-2">
                    <svg class="w-9 h-9 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="font-extrabold text-2xl md:text-3xl tracking-tight text-gray-900">Smart Traffic Finder</span>
                </div>
                <p class="text-sm text-gray-500 font-medium mt-3">Mulai perjalanan Anda. Buat akun baru sekarang!</p>
            </div>

            <form action="" method="POST" class="space-y-4">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">Nama Lengkap</label>
                    <div class="flex items-center bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 gap-3 focus-within:ring-2 focus-within:ring-orange-500 focus-within:border-orange-500 transition-all">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <input type="text" name="nama_lengkap" placeholder="Masukkan nama lengkap Anda" required class="w-full bg-transparent focus:outline-none text-gray-800 font-medium placeholder-gray-400">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">Alamat Email</label>
                    <div class="flex items-center bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 gap-3 focus-within:ring-2 focus-within:ring-orange-500 focus-within:border-orange-500 transition-all">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <input type="email" name="email" placeholder="Contoh: budi@email.com" required class="w-full bg-transparent focus:outline-none text-gray-800 font-medium placeholder-gray-400">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">Kata Sandi</label>
                    <div class="flex items-center bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 gap-3 focus-within:ring-2 focus-within:ring-orange-500 focus-within:border-orange-500 transition-all">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        <input type="password" name="password" placeholder="Minimal 6 karakter" required minlength="6" class="w-full bg-transparent focus:outline-none text-gray-800 font-medium placeholder-gray-400">
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" name="signup" class="w-full bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-700 hover:to-orange-600 text-white font-bold py-3.5 rounded-xl shadow-lg hover:shadow-xl transition-all active:scale-95 flex justify-center items-center gap-2">
                        Daftar Akun
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            </form>

            <div class="mt-8 text-center relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-3 bg-white text-gray-400 font-medium">Atau daftar dengan</span>
                </div>
            </div>

            <div class="mt-6 flex justify-center space-x-4">
                <button type="button" class="w-12 h-12 border border-gray-200 rounded-full flex items-center justify-center bg-white hover:bg-gray-50 hover:border-gray-300 transition-colors shadow-sm">
                    <svg class="w-5 h-5" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                </button>
                <button type="button" class="w-12 h-12 border border-gray-200 rounded-full flex items-center justify-center bg-white hover:bg-gray-50 hover:border-gray-300 transition-colors shadow-sm text-gray-700">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                </button>
            </div>
            
            <p class="text-center text-sm font-medium text-gray-600 mt-8 md:hidden">
                Sudah punya akun? <a href="Hlogin.php" class="text-orange-600 font-bold hover:underline">Masuk Sekarang</a>
            </p>
        </div>
        
    </div>
</div>

</body>
</html>