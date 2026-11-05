<?php
session_start();
include 'koneksi.php'; // Tambahkan ini

if (!isset($_SESSION['user'])) {
    header("Location: Hlogin.php");
    exit;
}

$nama_user = $_SESSION['user'];
$inisial = strtoupper(substr($nama_user, 0, 1));

// AMBIL DATA TAMBAHAN DARI DATABASE
$query = mysqli_query($conn, "SELECT lokasi, status FROM users WHERE nama_lengkap = '$nama_user'");
$user_data = mysqli_fetch_assoc($query);

$lokasi_user = (!empty($user_data['lokasi']) && $user_data['lokasi'] != '-') ? $user_data['lokasi'] : "Bandung, ID";
$status_user = (!empty($user_data['status']) && $user_data['status'] != '-') ? $user_data['status'] : "Pengguna Aktif";

// Hitung total laporan
$query_laporan = mysqli_query($conn, "SELECT COUNT(*) as total FROM laporan WHERE nama_pelapor = '$nama_user'");
$data_laporan = mysqli_fetch_assoc($query_laporan);
$total_laporan = $data_laporan['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f7f9fb; }
        .fade-in { animation: fadeIn 0.3s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateX(10px); } to { opacity: 1; transform: translateX(0); } }
        .toggle-switch input:checked + .slider { background-color: #f97316; }
        .toggle-switch input:checked + .slider:before { transform: translateX(20px); }
        .slider { background-color: #ccc; cursor: pointer; transition: .4s; }
        .slider:before { background-color: white; transition: .4s; }
    </style>
</head>

<body class="p-4">

    <div class="mb-4">
        <a href="beranda.php" class="text-orange-600 font-bold flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Kembali
        </a>
    </div>

    <div id="view-profil" class="fade-in">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 text-center mb-6">
            <img src="https://placehold.co/128x128/f97316/ffffff?text=<?php echo $inisial; ?>" class="w-28 h-28 rounded-full border-4 border-orange-100 mx-auto object-cover shadow-md mb-4">
            
            <h2 class="text-2xl font-bold text-gray-800"><?php echo htmlspecialchars($nama_user); ?></h2>
            
            <p class="text-orange-600 font-medium text-sm mb-4"><?php echo htmlspecialchars($status_user); ?></p>
            
            <div class="flex justify-center space-x-6 text-gray-600 text-sm">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-1 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.727A8 8 0 016.343 6.273L12 12m-7.071 7.071L12 12"></path></svg>
                    <span><?php echo htmlspecialchars($lokasi_user); ?></span> </div>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-1 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span>Bergabung Baru Saja</span>
                </div>
            </div>
            <div class="mt-6 bg-gray-50 p-3 rounded-xl border border-gray-200">
                <span class="block text-3xl font-extrabold text-orange-600"><?php echo $total_laporan; ?></span>
                <span class="text-xs text-gray-500 uppercase font-semibold tracking-wider">Total Laporan</span>
            </div>
        </div>
        
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4 mb-6">
            <h3 class="text-lg font-bold text-gray-800 mb-3">Aktivitas Terkini</h3>
            <div class="space-y-3 text-center text-gray-500 text-sm py-4">
                Belum ada aktivitas.
            </div>
        </div>
        
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden divide-y divide-gray-100">
            
            <a href="pengaturan.php" class="w-full flex items-center justify-between p-4 hover:bg-gray-50">
                <div class="flex items-center"><svg class="w-6 h-6 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37h.001z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg><span class="font-medium text-gray-700">Pengaturan Akun</span></div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
            
            <button onclick="window.location.href='logout.php'" class="w-full flex items-center justify-between p-4 hover:bg-gray-50 text-red-500 cursor-pointer">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    <span class="font-bold">Keluar Aplikasi</span>
                </div>
            </button>
        </div>
    </div>
    
</body>
</html>