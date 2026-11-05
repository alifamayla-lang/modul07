<!-- Hero Banner -->
<div class="bg-gradient-to-r from-orange-600 to-orange-500 rounded-[24px] shadow-lg p-6 md:p-10 text-white mb-8 relative overflow-hidden">
    <div class="absolute top-0 right-0 opacity-10 transform translate-x-1/4 -translate-y-1/4">
        <svg width="200" height="200" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14.5v-9l6 4.5-6 4.5z"/></svg>
    </div>
    <div class="relative z-10">
        <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight mb-2">Halo, <?= htmlspecialchars($user_nama ?? '') ?>!</h2>
        <p class="text-orange-100 font-medium text-base md:text-lg">Pantau kondisi lalu lintas terkini di sekitar Anda.</p>
        <div class="mt-6 flex items-center gap-4">
            <div class="bg-white/20 backdrop-blur-sm px-5 py-3 rounded-2xl">
                <span class="block text-2xl font-extrabold"><?= $total_laporan ?? 0 ?></span>
                <span class="text-xs text-orange-100 font-semibold uppercase tracking-wider">Total Insiden</span>
            </div>
            <a href="<?= base_url('Laporan/tambah') ?>" class="bg-white text-orange-600 font-bold px-6 py-3 rounded-xl shadow hover:shadow-lg transition active:scale-95 text-sm">+ Lapor Baru</a>
        </div>
    </div>
</div>

<div class="xl:grid xl:grid-cols-[260px_minmax(0,620px)_300px] xl:gap-6 xl:items-start">
    <aside class="hidden xl:block space-y-4">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-1">Ringkasan Kota</p>
            <h3 class="text-lg font-extrabold text-gray-950">Kondisi Lalu Lintas</h3>
            <div class="mt-5 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-semibold text-gray-500">Insiden Aktif</span>
                    <span class="text-lg font-extrabold text-orange-600"><?= $total_laporan ?? 0 ?></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm font-semibold text-gray-500">Feed Terbaru</span>
                    <span class="text-lg font-extrabold text-gray-900"><?= count($laporan_terbaru ?? []) ?></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm font-semibold text-gray-500">Status Kota</span>
                    <span class="text-xs font-bold text-green-700 bg-green-50 border border-green-200 rounded-full px-3 py-1">Dipantau</span>
                </div>
            </div>
            <a href="<?= base_url('Laporan/tambah') ?>" class="mt-5 flex items-center justify-center bg-orange-600 hover:bg-orange-700 text-white font-bold rounded-xl py-3 text-sm transition">Lapor Insiden</a>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-4">Area Rawan</p>
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                    <div>
                        <p class="text-sm font-bold text-gray-900">Asia Afrika</p>
                        <p class="text-xs text-gray-400">Lalu lintas padat</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                    <div>
                        <p class="text-sm font-bold text-gray-900">Pasteur</p>
                        <p class="text-xs text-gray-400">Antrian sedang</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>
                    <div>
                        <p class="text-sm font-bold text-gray-900">Dago</p>
                        <p class="text-xs text-gray-400">Relatif lancar</p>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <section class="min-w-0">
<!-- Insiden Terkini -->
<div class="flex items-center justify-between mb-5">
    <h3 class="text-xl font-extrabold text-gray-900 tracking-tight">Insiden Terkini</h3>
    <a href="<?= base_url('Laporan') ?>" class="text-orange-600 font-bold text-sm hover:underline">Lihat Semua →</a>
</div>

<div class="space-y-5">
    <?php if(!empty($laporan_terbaru)): ?>
        <?php foreach($laporan_terbaru as $l): ?>
        <?php
            $waktu_db = strtotime($l->waktu_laporan);
            $selisih  = time() - $waktu_db;
            if ($selisih < 60)          $wkt = "Baru saja";
            elseif ($selisih < 3600)    $wkt = floor($selisih/60)." menit lalu";
            elseif ($selisih < 86400)   $wkt = floor($selisih/3600)." jam lalu";
            else                        $wkt = floor($selisih/86400)." hari lalu";
            $tanggal = date('d', $waktu_db);
            $bulan   = strtoupper(date('M', $waktu_db));
            $foto_src = (!empty($l->foto) && file_exists(FCPATH.$l->foto)) ? base_url($l->foto) : '';
            $inisial_pelapor = strtoupper(substr($l->nama_pelapor, 0, 1));
            $liked_class = $l->is_liked ? 'text-red-500 bg-red-50 border-red-200' : 'text-gray-400 bg-gray-50 border-gray-200 hover:text-red-500 hover:bg-red-50';
            $heart_fill  = $l->is_liked ? 'fill="currentColor"' : 'fill="none"';
        ?>
        <div class="bg-white max-w-[620px] mx-auto rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Header -->
            <div class="flex items-center gap-3 px-4 py-3">
                <div class="w-11 h-11 rounded-full bg-orange-100 border-2 border-orange-500 flex items-center justify-center text-orange-600 font-extrabold text-sm flex-shrink-0">
                    <?= $inisial_pelapor ?>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-gray-900 truncate"><?= htmlspecialchars($l->nama_pelapor) ?></p>
                    <p class="text-xs text-gray-400"><?= $wkt ?> &bull; <?= htmlspecialchars($l->lokasi) ?></p>
                </div>
                <button type="button" class="w-9 h-9 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-800" aria-label="Menu laporan">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><circle cx="5" cy="12" r="2"/><circle cx="12" cy="12" r="2"/><circle cx="19" cy="12" r="2"/></svg>
                </button>
            </div>

            <!-- Photo -->
            <?php if($foto_src): ?>
            <div class="bg-black border-y border-gray-100 flex items-center justify-center">
                <img src="<?= $foto_src ?>" alt="Foto" class="w-full max-h-[520px] object-contain">
            </div>
            <?php endif; ?>

            <!-- Like & Comment Actions -->
            <div class="px-4 py-3">
                <div class="flex items-center gap-4">
                    <a href="<?= base_url('Dashboard/like/'.$l->id) ?>" class="text-gray-900 hover:text-red-500 transition-all active:scale-95 <?= $l->is_liked ? 'text-red-500' : '' ?>" aria-label="Sukai laporan">
                        <svg class="w-7 h-7" <?= $heart_fill ?> stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </a>
                    <button onclick="toggleComment(<?= $l->id ?>)" class="text-gray-900 hover:text-blue-500 transition-all active:scale-95" aria-label="Komentar">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    </button>
                </div>

                <p class="text-sm font-extrabold text-gray-950 mt-3"><?= $l->like_count ?> suka</p>
                <p class="text-sm text-gray-900 leading-relaxed mt-2">
                    <span class="font-extrabold"><?= htmlspecialchars($l->nama_pelapor) ?></span>
                    <span class="font-semibold text-orange-600">[<?= strtoupper(htmlspecialchars($l->status_verifikasi ?? 'verified')) ?>]</span>
                </p>
                <p class="text-sm text-gray-900 leading-relaxed mt-2">Keterangan: <?= htmlspecialchars($l->deskripsi) ?></p>
                <p class="text-sm text-gray-900 leading-relaxed mt-2">Lokasi Penemuan: <?= htmlspecialchars($l->lokasi) ?></p>
                <?php if($l->comment_count > 0): ?>
                <button onclick="toggleComment(<?= $l->id ?>)" class="text-sm text-gray-500 mt-3 hover:text-gray-800">Lihat <?= $l->comment_count ?> komentar</button>
                <?php endif; ?>
            </div>

            <!-- Comments Section (collapsible) -->
            <div id="comments-<?= $l->id ?>" class="hidden border-t border-gray-100 bg-gray-50/50">
                <?php if(!empty($l->comments)): ?>
                <div class="px-4 py-3 space-y-2 max-h-[200px] overflow-y-auto">
                    <?php foreach($l->comments as $c): ?>
                    <div class="flex gap-2">
                        <div class="w-7 h-7 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 font-bold text-xs flex-shrink-0 mt-0.5">
                            <?= strtoupper(substr($c->user_nama, 0, 1)) ?>
                        </div>
                        <div class="bg-white rounded-xl px-3 py-2 border border-gray-100 flex-1 min-w-0">
                            <p class="text-xs font-bold text-gray-800"><?= htmlspecialchars($c->user_nama) ?> <span class="font-normal text-gray-400 ml-1"><?= date('H:i', strtotime($c->created_at)) ?></span></p>
                            <p class="text-sm text-gray-600"><?= htmlspecialchars($c->komentar) ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                <!-- Comment Input -->
                <?= form_open('Dashboard/komentar/'.$l->id, ['class' => 'flex items-center gap-2 p-3 border-t border-gray-100']) ?>
                    <input type="text" name="komentar" required autocomplete="off" placeholder="Tulis komentar..." class="flex-1 px-3 py-2 rounded-xl bg-white border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 font-medium">
                    <button type="submit" class="bg-orange-600 text-white p-2 rounded-xl hover:bg-orange-700 transition active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                    </button>
                <?= form_close() ?>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="text-center py-16 px-6 bg-white rounded-[24px] shadow-sm border border-dashed border-gray-300">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <h3 class="text-lg font-bold text-gray-800 mb-1">Belum Ada Insiden</h3>
            <p class="text-sm text-gray-500 mb-4">Jadilah yang pertama melaporkan kondisi lalu lintas.</p>
            <a href="<?= base_url('Laporan/tambah') ?>" class="bg-orange-600 text-white font-bold px-6 py-3 rounded-xl hover:bg-orange-700 transition">Buat Laporan</a>
        </div>
    <?php endif; ?>
        </div>
    </section>

    <aside class="hidden xl:block space-y-4">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-extrabold text-gray-950">CCTV Live</h3>
                <span class="text-xs font-bold text-green-700 bg-green-50 border border-green-200 rounded-full px-2.5 py-1">3 Online</span>
            </div>
            <div class="space-y-3">
                <div class="rounded-xl border border-gray-200 overflow-hidden">
                    <div class="h-24 bg-slate-900 text-white flex items-center justify-center relative">
                        <span class="absolute top-2 left-2 w-2 h-2 rounded-full bg-green-500"></span>
                        <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    </div>
                    <div class="p-3">
                        <p class="text-sm font-bold text-gray-900">Simpang Dago</p>
                        <p class="text-xs text-gray-400">Kepadatan sedang</p>
                    </div>
                </div>
                <div class="rounded-xl border border-gray-200 overflow-hidden">
                    <div class="h-24 bg-slate-900 text-white flex items-center justify-center relative">
                        <span class="absolute top-2 left-2 w-2 h-2 rounded-full bg-green-500"></span>
                        <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    </div>
                    <div class="p-3">
                        <p class="text-sm font-bold text-gray-900">Asia Afrika</p>
                        <p class="text-xs text-gray-400">Kepadatan tinggi</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <h3 class="text-lg font-extrabold text-gray-950 mb-4">Laporan Terbaru</h3>
            <div class="space-y-4">
                <?php if(!empty($laporan_terbaru)): ?>
                    <?php foreach(array_slice($laporan_terbaru, 0, 4) as $mini): ?>
                    <a href="<?= base_url('Laporan/detail/'.$mini->id) ?>" class="block group">
                        <p class="text-sm font-bold text-gray-900 group-hover:text-orange-600 truncate"><?= htmlspecialchars($mini->lokasi) ?></p>
                        <p class="text-xs text-gray-500 mt-1 line-clamp-2"><?= htmlspecialchars($mini->deskripsi) ?></p>
                    </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-sm text-gray-500">Belum ada laporan terbaru.</p>
                <?php endif; ?>
            </div>
        </div>
    </aside>
</div>

<script>
function toggleComment(id) {
    var el = document.getElementById('comments-' + id);
    if (el.classList.contains('hidden')) {
        el.classList.remove('hidden');
        var input = el.querySelector('input[name="komentar"]');
        if (input) input.focus();
    } else {
        el.classList.add('hidden');
    }
}
</script>
