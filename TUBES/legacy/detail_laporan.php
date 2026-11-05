<?php
session_start();
include 'koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user'])) {
    header("Location: Hlogin.php");
    exit;
}

$nama_user = $_SESSION['user'];

// Cek apakah ada ID laporan yang dikirim melalui URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: beranda.php");
    exit;
}

$id_laporan = mysqli_real_escape_string($conn, $_GET['id']);

// Ambil data laporan spesifik berdasarkan ID
$query = mysqli_query($conn, "SELECT * FROM laporan WHERE id = '$id_laporan'");

// Jika laporan tidak ditemukan
if (mysqli_num_rows($query) == 0) {
    echo "<script>alert('Laporan tidak ditemukan!'); window.location='beranda.php';</script>";
    exit;
}

$laporan = mysqli_fetch_assoc($query);

// Format waktu yang lebih lengkap (Contoh: 31 Maret 2026, 14:30 WIB)
$waktu_lengkap = date('d F Y, H:i', strtotime($laporan['waktu_laporan'])) . ' WIB';

// Inisial Pelapor untuk Foto Profil dummy
$inisial_pelapor = strtoupper(substr($laporan['nama_pelapor'], 0, 1));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan - Smart Traffic Finder</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .fade-in { animation: fadeIn 0.3s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="text-gray-800 min-h-screen flex flex-col items-center p-4 md:p-8">

    <div class="w-full max-w-[700px] fade-in pb-10">
        
        <div class="flex items-center justify-between mb-6">
            <a href="beranda.php" class="p-2.5 bg-white shadow-sm border border-gray-200 text-gray-700 hover:text-orange-600 hover:bg-orange-50 rounded-full transition-all active:scale-95">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h1 class="text-xl font-extrabold text-gray-900 tracking-tight">Detail Insiden</h1>
            <div class="w-11"></div> 
        </div>

        <div class="bg-white rounded-[24px] shadow-lg shadow-gray-200/50 border border-gray-100 overflow-hidden">
            
            <div class="w-full h-[250px] md:h-[350px] bg-gray-100 relative group">
                <img src="<?php echo htmlspecialchars($laporan['foto']); ?>" alt="Foto Kejadian" class="w-full h-full object-cover">
                <div class="absolute bottom-0 left-0 w-full h-1/3 bg-gradient-to-t from-black/60 to-transparent"></div>
            </div>

            <div class="p-6 md:p-8 relative">
                
                <div class="absolute -top-6 left-6 md:left-8 bg-orange-600 text-white px-4 py-2 rounded-xl shadow-md flex items-center gap-2 font-bold text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                    <?php echo htmlspecialchars($laporan['lokasi']); ?>
                </div>

                <div class="h-4"></div>

                <div class="flex items-center justify-between border-b border-gray-100 pb-5 mb-5 mt-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-orange-100 border border-orange-200 flex items-center justify-center text-orange-600 font-extrabold text-lg">
                            <?php echo $inisial_pelapor; ?>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-widest font-bold mb-0.5">Dilaporkan Oleh</p>
                            <p class="font-bold text-gray-900"><?php echo htmlspecialchars($laporan['nama_pelapor']); ?></p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-400 uppercase tracking-widest font-bold mb-0.5">Waktu Kejadian</p>
                        <p class="font-semibold text-gray-700 text-sm"><?php echo $waktu_lengkap; ?></p>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-extrabold text-gray-900 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Keterangan Detail
                    </h3>
                    <p class="text-gray-600 leading-relaxed font-medium bg-gray-50 p-5 rounded-2xl border border-gray-100 whitespace-pre-line">
                        <?php echo htmlspecialchars($laporan['deskripsi']); ?>
                    </p>
                </div>

                <div class="mt-8 flex gap-3">
                    <button onclick="alert('Link berhasil disalin!')" class="flex-1 bg-white border-2 border-gray-200 hover:border-orange-500 hover:bg-orange-50 text-gray-700 hover:text-orange-600 font-bold py-3.5 rounded-xl transition-all active:scale-95 flex justify-center items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                        Bagikan Info Ini
                    </button>
                </div>

            </div>
        </div>
    </div>

</body>
</html>