<?php
// File: laporan.php
include 'koneksi.php';
include 'Class_SmartTraffic.php';

// 1. Inisialisasi User
$user = new UserAuth();
$user->cekLogin();
$nama_user = $user->getNamaUser();
$inisial = $user->getInisial();

// 2. Inisialisasi Sistem Laporan
$laporanSistem = new Laporan($conn);

// 3. Logika ketika tombol "Kirim Laporan" ditekan
if (isset($_POST['submit_laporan'])) {
    // Memanggil method OOP untuk proses simpan dan upload
    $hasil = $laporanSistem->tambahLaporan($_POST, $_FILES, $nama_user);
    
    if ($hasil['status'] == 'sukses') {
        echo "<script>alert('{$hasil['pesan']}'); window.location='beranda.php';</script>";
    } else {
        echo "<script>alert('{$hasil['pesan']}');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - Smart Traffic Finder</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; overscroll-behavior-y: none; }
        .bottom-nav-item { display: flex; flex-direction: column; align-items: center; justify-content: center; color: #94a3b8; font-size: 10px; padding: 8px 0; }
        .bottom-nav-item.active { color: #ea580c; font-weight: 600; }
        .bottom-nav-item svg { margin-bottom: 2px; }
        
        /* Hilangkan Scrollbar tapi bisa di-scroll */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* Efek fokus pada input */
        .input-ring:focus-within { ring: 2px; ring-color: #f97316; border-color: #f97316; }
    </style>
</head>
<body class="text-gray-800 h-screen flex flex-col overflow-hidden">
<main class="flex flex-1 overflow-hidden relative bg-[#f8fafc] pb-[60px] md:pb-0">
    
    <div id="page-dashboard" class="flex-1 flex flex-col h-full relative">
        <header class="bg-white shadow-sm px-8 py-4 hidden md:flex justify-between items-center z-20 relative border-b border-gray-100">
            <div class="flex items-center space-x-10">
                <div class="flex items-center space-x-2">
                    <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="font-extrabold text-xl tracking-tight text-gray-900">Smart Traffic Finder</span>
                </div>
                <nav class="flex space-x-6">
                    <a href="beranda.php" class="text-gray-500 hover:text-orange-600 font-medium text-sm transition-colors pb-1">Beranda</a>
                    <a href="laporan.php" class="text-orange-600 font-bold text-sm border-b-2 border-orange-600 pb-1">Laporan</a>
                    <a href="chat.php" class="text-gray-500 hover:text-orange-600 font-medium text-sm transition-colors pb-1">Chat</a>
                </nav>
            </div>
            
            <div class="flex items-center space-x-5">
                <a href="Profile.php" class="flex items-center space-x-3 bg-gray-50 hover:bg-gray-100 py-1.5 px-3 rounded-full transition border border-gray-200">
                    <img src="https://placehold.co/32x32/ea580c/ffffff?text=<?php echo $inisial; ?>" class="w-7 h-7 rounded-full shadow-sm">
                    <span class="text-sm font-semibold text-gray-700 pr-1"><?php echo htmlspecialchars($nama_user); ?></span>
                </a>
                <a href="logout.php" class="text-gray-400 hover:text-red-500 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </a>
            </div>
        </header>

        <div id="view-laporan" class="flex-1 overflow-y-auto p-4 md:p-8 max-w-[800px] mx-auto w-full no-scrollbar">
            
            <div class="flex justify-between items-center mb-6 md:hidden">
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Lapor Insiden</h1>
                <a href="logout.php" class="p-2 bg-white rounded-full shadow-sm border border-gray-100 text-red-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </a>
            </div>

            <div class="hidden md:flex flex-col mb-8">
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Kirim Laporan Baru</h1>
                <p class="text-gray-500 mt-2">Bantu pengguna lain dengan melaporkan kondisi lalu lintas terkini.</p>
            </div>
            
            <div class="bg-white rounded-[24px] shadow-sm border border-gray-200 p-6 md:p-8">
                
                <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">
                    
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-700 ml-1">Lokasi Kejadian</label>
                        <div class="flex items-center bg-gray-50 border border-gray-200 rounded-2xl px-4 py-3.5 gap-3 transition-colors input-ring">
                            <div class="bg-orange-100 p-2 rounded-lg text-orange-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <input type="text" name="lokasi" required placeholder="Contoh: Jl. Merdeka depan minimarket" class="w-full bg-transparent focus:outline-none text-gray-800 placeholder-gray-400 font-medium">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-700 ml-1">Foto Bukti (Wajib)</label>
                        <div class="border-2 border-dashed border-orange-300 bg-orange-50 hover:bg-orange-100 rounded-2xl h-56 flex flex-col items-center justify-center text-orange-600 transition relative cursor-pointer overflow-hidden group">
                            
                            <input type="file" name="foto_kejadian" accept="image/*" required class="absolute inset-0 opacity-0 w-full h-full z-20 cursor-pointer" onchange="previewImage(event)">
                            
                            <div id="upload-placeholder" class="flex flex-col items-center justify-center z-10 transition-transform group-hover:scale-105">
                                <div class="bg-white p-4 rounded-full shadow-sm mb-3">
                                    <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <span class="text-base font-bold text-gray-800">Sentuh untuk Unggah Foto</span>
                                <span class="text-xs font-medium text-orange-600 mt-1">Gunakan foto langsung dari lokasi</span>
                            </div>

                            <img id="img-preview" class="hidden absolute inset-0 w-full h-full object-cover rounded-2xl z-10">
                            
                            <div id="img-overlay" class="hidden absolute inset-0 bg-black/40 z-10 flex flex-col items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                                <span class="text-white font-bold bg-black/50 px-4 py-2 rounded-full">Ganti Foto</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-700 ml-1">Detail Kejadian</label>
                        <textarea name="deskripsi" rows="4" placeholder="Jelaskan apa yang terjadi (cth: Kecelakaan beruntun, macet total karena lampu merah mati, dll)" required class="w-full p-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 focus:outline-none text-gray-800 placeholder-gray-400 font-medium transition-colors resize-none"></textarea>
                    </div>
                    
                    <div class="pt-2">
                        <button type="submit" name="submit_laporan" class="w-full bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-700 hover:to-orange-600 text-white font-bold text-lg py-4 rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200 flex items-center justify-center gap-2">
                            <span>Kirim Laporan Sekarang</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </form>
            </div>
            
            <p class="text-center text-xs text-gray-400 mt-6 font-medium">Laporan palsu dapat menyebabkan pemblokiran akun.</p>
        </div>
    </div>
    
    <nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 flex justify-around md:hidden pb-safe z-50">
        <a href="beranda.php" class="bottom-nav-item"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9,22 9,12 15,12 15,22"/></svg><span class="mt-1">Beranda</span></a>
        <a href="laporan.php" class="bottom-nav-item active"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14,2 14,8 20,8"/></svg><span class="mt-1">Laporan</span></a>
        <a href="chat.php" class="bottom-nav-item"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg><span class="mt-1">Chat</span></a>
        <a href="Profile.php" class="bottom-nav-item"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg><span class="mt-1">Profil</span></a>
    </nav>
</main>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('img-preview');
            var placeholder = document.getElementById('upload-placeholder');
            var overlay = document.getElementById('img-overlay');
            
            output.src = reader.result;
            output.classList.remove('hidden');
            placeholder.classList.add('hidden');
            overlay.classList.remove('hidden');
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
</body>
</html>