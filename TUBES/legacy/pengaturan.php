<?php
session_start();
include 'koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user'])) {
    header("Location: Hlogin.php");
    exit;
}

// Ambil email user dari session untuk mencari data spesifiknya
// (Catatan: idealnya session menyimpan ID user, tapi karena sebelumnya menggunakan nama/email, kita pakai nama_lengkap)
$nama_user = $_SESSION['user'];

// Ambil data terbaru dari database
$query_user = mysqli_query($conn, "SELECT * FROM users WHERE nama_lengkap = '$nama_user'");
$user_data = mysqli_fetch_assoc($query_user);

// Jika tombol SIMPAN ditekan
if (isset($_POST['update_profil'])) {
    $nama_baru = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $email_baru = mysqli_real_escape_string($conn, $_POST['email']);
    $telepon_baru = mysqli_real_escape_string($conn, $_POST['telepon']);
    $lokasi_baru = mysqli_real_escape_string($conn, $_POST['lokasi']);
    $status_baru = mysqli_real_escape_string($conn, $_POST['status']);

    // Update query
    $update_query = "UPDATE users SET 
                     nama_lengkap = '$nama_baru', 
                     email = '$email_baru', 
                     telepon = '$telepon_baru', 
                     lokasi = '$lokasi_baru', 
                     status = '$status_baru' 
                     WHERE nama_lengkap = '$nama_user'";

    if (mysqli_query($conn, $update_query)) {
        // Update session jika nama berubah
        $_SESSION['user'] = $nama_baru;
        echo "<script>alert('Profil berhasil diperbarui!'); window.location='pengaturan.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui profil!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Akun</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .fade-in { animation: fadeIn 0.3s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .toggle-switch input:checked + .slider { background-color: #f97316; }
        .toggle-switch input:checked + .slider:before { transform: translateX(20px); }
        .slider { background-color: #ccc; cursor: pointer; transition: .4s; }
        .slider:before { background-color: white; transition: .4s; }
    </style>
</head>

<body class="p-4 md:p-8 max-w-[800px] mx-auto fade-in">

    <div class="flex items-center mb-6">
        <a href="Profile.php" class="p-2 mr-4 text-gray-700 bg-white shadow-sm border border-gray-100 hover:bg-gray-50 rounded-full transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Pengaturan Akun</h1>
    </div>

    <form action="" method="POST" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 mb-8">
        
        <h2 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-6">Informasi Dasar</h2>
        
        <div class="space-y-5">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="<?php echo htmlspecialchars($user_data['nama_lengkap']); ?>" required class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500 transition text-gray-800 font-medium">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">Alamat Email</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($user_data['email']); ?>" required class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500 transition text-gray-800 font-medium">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">Nomor Telepon</label>
                <input type="text" name="telepon" value="<?php echo htmlspecialchars($user_data['telepon'] ?? ''); ?>" placeholder="+62 8..." class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500 transition text-gray-800 font-medium">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">Lokasi Anda</label>
                <input type="text" name="lokasi" value="<?php echo htmlspecialchars($user_data['lokasi'] ?? ''); ?>" placeholder="Contoh: Bandung, Indonesia" class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500 transition text-gray-800 font-medium">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">Status / Peran</label>
                <input type="text" name="status" value="<?php echo htmlspecialchars($user_data['status'] ?? 'Pengguna Aktif'); ?>" placeholder="Mahasiswa / Pegawai" class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500 transition text-gray-800 font-medium">
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end">
            <button type="submit" name="update_profil" class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-3 px-8 rounded-xl shadow-md transition-all active:scale-95">
                Simpan Perubahan
            </button>
        </div>
    </form>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden divide-y divide-gray-100 mb-8">
        <p class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest bg-gray-50/50">Keamanan & Preferensi</p>
        
        <a href="ganti_sandi.php" class="w-full flex items-center justify-between px-6 py-4 hover:bg-gray-50 transition cursor-pointer">
            <div class="flex items-center">
                <div class="p-2 bg-gray-100 rounded-lg mr-4 text-gray-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <span class="text-sm font-bold text-gray-700">Ganti Kata Sandi</span>
            </div>
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>

        <div class="flex items-center justify-between px-6 py-4 hover:bg-gray-50 transition">
            <div class="flex items-center">
                <div class="p-2 bg-gray-100 rounded-lg mr-4 text-gray-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </div>
                <div>
                    <span class="text-sm font-bold text-gray-700 block">Notifikasi Push</span>
                    <span class="text-xs font-medium text-gray-400">Terima info macet langsung</span>
                </div>
            </div>
            <label class="relative inline-flex items-center cursor-pointer toggle-switch">
                <input type="checkbox" checked class="sr-only peer">
                <div class="w-11 h-6 slider rounded-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
            </label>
        </div>
    </div>

</body>
</html>