<?php
// File: beranda.php
include 'koneksi.php';
include 'Class_SmartTraffic.php'; // Memanggil file class OOP

// 1. Inisialisasi Object User
$user = new UserAuth();
$user->cekLogin();
$nama_user = $user->getNamaUser();
$inisial = $user->getInisial();

// 2. Inisialisasi Object Laporan
$laporanSistem = new Laporan($conn);
$data_laporan = $laporanSistem->getLaporanTerbaru(10);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - Smart Traffic Finder</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; overscroll-behavior-y: none; }
        .bottom-nav-item { display: flex; flex-direction: column; align-items: center; justify-content: center; color: #94a3b8; font-size: 10px; padding: 8px 0; }
        .bottom-nav-item.active { color: #ea580c; font-weight: 600; }
        .bottom-nav-item svg { margin-bottom: 2px; }
        
        /* Animasi Card yang Elegan */
        .incident-card { transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1); }
        .incident-card:hover { transform: translateY(-3px); box-shadow: 0 12px 20px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.04); border-color: #fbd5b5; }
        
        /* Hilangkan Scrollbar tapi bisa di-scroll */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
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
                    <a href="beranda.php" class="text-orange-600 font-bold text-sm border-b-2 border-orange-600 pb-1">Beranda</a>
                    <a href="laporan.php" class="text-gray-500 hover:text-orange-600 font-medium text-sm transition-colors pb-1">Laporan</a>
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

        <div class="flex-1 flex flex-col h-full overflow-hidden relative w-full">
            <div id="view-beranda" class="flex-1 overflow-y-auto p-4 pb-20 md:p-8 max-w-[1400px] mx-auto w-full no-scrollbar">
                
                <div class="flex justify-between items-center mb-6 md:hidden">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Beranda</h1>
                        <p class="text-sm text-gray-500 font-medium">Halo, <?php echo htmlspecialchars($nama_user); ?>!</p>
                    </div>
                    <a href="logout.php" class="p-2 bg-white rounded-full shadow-sm border border-gray-100 text-red-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </a>
                </div>

                <div class="bg-gradient-to-r from-orange-600 to-orange-500 rounded-2xl p-6 md:p-8 text-white shadow-lg mb-8 relative overflow-hidden">
                    <div class="relative z-10">
                        <p class="text-orange-100 text-sm font-semibold tracking-wider uppercase mb-2">Status Kota Saat Ini</p>
                        <h2 class="text-3xl md:text-4xl font-extrabold mb-2 tracking-tight">Lancar Jaya <span class="text-2xl animate-pulse">🟢</span></h2>
                        <p class="text-sm md:text-base opacity-90 font-medium">Kecepatan rata-rata 45 km/jam. Tetap hati-hati dan patuhi rambu!</p>
                    </div>
                    <div class="absolute -right-10 -bottom-10 opacity-10">
                        <svg width="200" height="200" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14.5v-9l6 4.5-6 4.5z"/></svg>
                    </div>
                </div>

                <h3 class="text-xl font-extrabold text-gray-900 mb-6 uppercase tracking-wider flex items-center">
                    Insiden Terkini
                    <div class="ml-4 flex-1 h-px bg-gray-200 hidden md:block"></div>
                </h3>
                
                <div class="space-y-4">
                    
                    <?php
                    if (mysqli_num_rows($data_laporan) > 0) {
                        while ($row = mysqli_fetch_assoc($data_laporan)) {
                            // Menggunakan method OOP untuk memformat data
                            $tanggal = $laporanSistem->formatTanggal($row['waktu_laporan']);
                            $bulan = $laporanSistem->formatBulan($row['waktu_laporan']);
                            $waktu_tampil = $laporanSistem->formatWaktuBerlalu($row['waktu_laporan']);
                            ?>
                            
                            <div class="incident-card bg-white p-3 md:p-4 rounded-[20px] shadow-sm border border-gray-200 flex flex-col lg:flex-row gap-4 lg:gap-6 items-start lg:items-center">
                                
                                <div class="w-full lg:w-[280px] h-[160px] lg:h-[110px] rounded-xl overflow-hidden border border-gray-100 flex-shrink-0 bg-gray-50">
                                    <img src="<?php echo htmlspecialchars($row['foto']); ?>" alt="Foto" class="w-full h-full object-cover">
                                </div>
                                
                                <div class="flex flex-1 w-full gap-4 md:gap-5 items-center lg:items-start py-1">
                                    <div class="flex-shrink-0 w-16 h-16 md:w-[70px] md:h-[70px] bg-red-50 rounded-[14px] flex flex-col items-center justify-center border border-red-100">
                                        <span class="text-xl md:text-2xl font-extrabold text-red-600 leading-none mb-0.5"><?php echo $tanggal; ?></span>
                                        <span class="text-[10px] md:text-xs font-bold text-red-500 uppercase tracking-widest"><?php echo $bulan; ?></span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-lg md:text-xl font-bold text-gray-900 truncate tracking-tight"><?php echo htmlspecialchars($row['lokasi']); ?></h4>
                                        <p class="text-sm text-orange-600 font-semibold mt-0.5 mb-1.5">Pelapor: <?php echo htmlspecialchars($row['nama_pelapor']); ?></p>
                                        <p class="text-sm md:text-base text-gray-600 line-clamp-2 md:line-clamp-1 leading-relaxed"><?php echo htmlspecialchars($row['deskripsi']); ?></p>
                                    </div>
                                </div>

                                <div class="w-full lg:w-auto flex flex-row lg:flex-col justify-between items-center lg:items-end gap-3 lg:gap-4 pl-0 lg:pl-4 lg:border-l border-gray-100 py-1">
                                    <span class="text-sm font-medium text-gray-500 whitespace-nowrap"><?php echo $waktu_tampil; ?></span>
                                    
                                    <div class="flex gap-2 w-full lg:w-auto">
                                        <a href="detail_laporan.php?id=<?php echo $row['id']; ?>" class="flex-1 lg:flex-none flex items-center justify-center gap-1.5 px-4 py-2 text-sm font-bold text-orange-600 bg-orange-50 border border-orange-200 rounded-xl hover:bg-orange-100 hover:border-orange-300 transition-all active:scale-95 shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            Detail
                                        </a>
                                        <button onclick="alert('Link laporan berhasil disalin!')" class="flex-1 lg:flex-none flex items-center justify-center gap-1.5 px-4 py-2 text-sm font-bold text-gray-600 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 hover:text-gray-900 transition-all active:scale-95 shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                                            Bagikan
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <?php
                        }
                    } else {
                        // Tampilan Kosong
                        echo '
                        <div class="text-center py-16 px-6 bg-white rounded-[24px] shadow-sm border border-dashed border-gray-300 flex flex-col items-center">
                            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 mb-1">Belum Ada Insiden</h3>
                            <p class="text-sm text-gray-500 max-w-sm">Saat ini kota Anda aman dan terkendali. Laporan yang dibuat akan muncul di sini.</p>
                        </div>';
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
    
    <nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 flex justify-around md:hidden pb-safe z-50">
        <a href="beranda.php" class="bottom-nav-item active"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9,22 9,12 15,12 15,22"/></svg><span class="mt-1">Beranda</span></a>
        <a href="laporan.php" class="bottom-nav-item"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14,2 14,8 20,8"/></svg><span class="mt-1">Laporan</span></a>
        <a href="chat.php" class="bottom-nav-item"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg><span class="mt-1">Chat</span></a>
        <a href="Profile.php" class="bottom-nav-item"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg><span class="mt-1">Profil</span></a>
    </nav>
</main>
</body>
</html>