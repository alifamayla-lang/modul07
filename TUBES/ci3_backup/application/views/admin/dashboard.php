<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f6f7f9; }
        .camera-noise {
            background:
                linear-gradient(135deg, rgba(15,23,42,.92), rgba(15,23,42,.72)),
                repeating-linear-gradient(0deg, rgba(255,255,255,.06) 0, rgba(255,255,255,.06) 1px, transparent 1px, transparent 9px);
        }
    </style>
</head>
<body class="text-gray-800 min-h-screen">

<header class="bg-white border-b border-gray-200 sticky top-0 z-30">
    <div class="max-w-[1500px] mx-auto px-4 md:px-8 py-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-orange-600 text-white flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <h1 class="text-xl md:text-2xl font-extrabold text-gray-950 tracking-tight">Dashboard Admin</h1>
                <p class="text-xs md:text-sm text-gray-500 font-medium">CCTV monitoring dan verifikasi laporan pengguna</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="<?= base_url('Dashboard') ?>" class="hidden md:inline-flex px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-sm transition">Lihat User View</a>
            <a href="<?= base_url('Auth/logout') ?>" class="px-4 py-2 rounded-xl bg-red-50 hover:bg-red-100 text-red-600 font-bold text-sm transition">Logout</a>
        </div>
    </div>
</header>

<main class="max-w-[1500px] mx-auto px-4 md:px-8 py-6 md:py-8">
    <?php if($this->session->flashdata('success')): ?>
    <div class="mb-5 bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-xl font-semibold text-sm"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>
    <?php if($this->session->flashdata('error')): ?>
    <div class="mb-5 bg-red-50 border border-red-200 text-red-700 px-5 py-3 rounded-xl font-semibold text-sm"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>

    <section class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-5 mb-8">
        <div class="bg-white border border-gray-200 rounded-xl p-5">
            <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Total Laporan</p>
            <p class="text-3xl font-extrabold text-gray-950 mt-2"><?= $total_laporan ?></p>
        </div>
        <div class="bg-white border border-amber-200 rounded-xl p-5">
            <p class="text-xs font-bold uppercase tracking-widest text-amber-500">Menunggu</p>
            <p class="text-3xl font-extrabold text-amber-600 mt-2"><?= $pending_count ?></p>
        </div>
        <div class="bg-white border border-green-200 rounded-xl p-5">
            <p class="text-xs font-bold uppercase tracking-widest text-green-500">Terverifikasi</p>
            <p class="text-3xl font-extrabold text-green-600 mt-2"><?= $verified_count ?></p>
        </div>
        <div class="bg-white border border-red-200 rounded-xl p-5">
            <p class="text-xs font-bold uppercase tracking-widest text-red-500">Ditolak</p>
            <p class="text-3xl font-extrabold text-red-600 mt-2"><?= $rejected_count ?></p>
        </div>
    </section>

    <section class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-extrabold text-gray-950">Pantauan CCTV</h2>
            <span class="text-xs font-bold uppercase tracking-widest text-gray-400"><?= count($cctv_list) ?> kamera</span>
        </div>
        <div class="grid md:grid-cols-2 xl:grid-cols-4 gap-4">
            <?php foreach($cctv_list as $cctv): ?>
            <?php
                $is_online = $cctv['status'] === 'Online';
                $badge = $is_online ? 'bg-green-500' : 'bg-amber-500';
            ?>
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                <div class="camera-noise aspect-video relative flex items-center justify-center text-white">
                    <div class="absolute top-3 left-3 flex items-center gap-2 text-xs font-bold uppercase tracking-widest">
                        <span class="w-2 h-2 rounded-full <?= $badge ?>"></span>
                        <?= htmlspecialchars($cctv['status']) ?>
                    </div>
                    <div class="text-center">
                        <svg class="w-10 h-10 mx-auto mb-2 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        <p class="text-sm font-extrabold"><?= $is_online ? 'LIVE FEED' : 'MAINTENANCE' ?></p>
                    </div>
                    <div class="absolute bottom-3 right-3 text-[11px] font-bold bg-black/30 px-2 py-1 rounded">REC</div>
                </div>
                <div class="p-4">
                    <h3 class="font-extrabold text-gray-950"><?= htmlspecialchars($cctv['name']) ?></h3>
                    <p class="text-sm text-gray-500 mt-1"><?= htmlspecialchars($cctv['location']) ?></p>
                    <p class="text-xs font-bold uppercase tracking-widest text-orange-600 mt-3">Kepadatan: <?= htmlspecialchars($cctv['density']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-extrabold text-gray-950">Verifikasi Laporan Pengguna</h2>
            <span class="text-xs font-bold uppercase tracking-widest text-amber-500"><?= $pending_count ?> pending</span>
        </div>

        <?php if(!empty($laporan_pending)): ?>
        <div class="grid xl:grid-cols-2 gap-4">
            <?php foreach($laporan_pending as $laporan): ?>
            <?php $foto_src = (!empty($laporan->foto) && file_exists(FCPATH.$laporan->foto)) ? base_url($laporan->foto) : ''; ?>
            <article class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                <div class="grid md:grid-cols-[220px_1fr]">
                    <div class="bg-gray-100 min-h-[180px]">
                        <?php if($foto_src): ?>
                            <img src="<?= $foto_src ?>" alt="Foto laporan" class="w-full h-full object-cover">
                        <?php else: ?>
                            <div class="h-full min-h-[180px] flex items-center justify-center text-gray-400 font-bold text-sm">Tanpa Foto</div>
                        <?php endif; ?>
                    </div>
                    <div class="p-5">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h3 class="text-lg font-extrabold text-gray-950"><?= htmlspecialchars($laporan->lokasi) ?></h3>
                                <p class="text-sm text-orange-600 font-bold mt-1"><?= htmlspecialchars($laporan->nama_pelapor) ?></p>
                            </div>
                            <span class="text-xs font-bold uppercase tracking-widest bg-amber-50 text-amber-600 border border-amber-200 rounded-full px-3 py-1">Pending</span>
                        </div>
                        <p class="text-sm text-gray-600 leading-relaxed mt-3"><?= htmlspecialchars($laporan->deskripsi) ?></p>
                        <p class="text-xs text-gray-400 font-semibold mt-3"><?= date('d M Y, H:i', strtotime($laporan->waktu_laporan)) ?> WIB</p>

                        <?= form_open('Admin/verifikasi/'.$laporan->id, ['class' => 'mt-4 space-y-3']) ?>
                            <textarea name="catatan_admin" rows="2" placeholder="Catatan admin (opsional)" class="w-full p-3 rounded-xl bg-gray-50 border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"></textarea>
                            <div class="flex gap-2">
                                <button type="submit" name="status" value="verified" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 rounded-xl transition">Setujui</button>
                                <button type="submit" name="status" value="rejected" class="flex-1 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 font-bold py-2.5 rounded-xl transition">Tolak</button>
                            </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="bg-white border border-dashed border-gray-300 rounded-xl p-10 text-center">
            <h3 class="text-lg font-extrabold text-gray-900">Tidak ada laporan pending</h3>
            <p class="text-sm text-gray-500 mt-1">Semua laporan pengguna sudah diverifikasi.</p>
        </div>
        <?php endif; ?>
    </section>
</main>

</body>
</html>
