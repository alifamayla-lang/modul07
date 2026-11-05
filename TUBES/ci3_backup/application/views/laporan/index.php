<?php
$keyword = isset($keyword) ? $keyword : '';
?>

<!-- Title + Search -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
    <div>
        <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Data Laporan</h1>
        <p class="text-gray-500 mt-1 text-sm font-medium"><?= count($laporan ?? []) ?> laporan ditemukan<?= $keyword ? ' untuk "<strong class="text-orange-600">'.htmlspecialchars($keyword).'</strong>"' : '' ?></p>
    </div>
    <div class="flex gap-3 items-center w-full md:w-auto">
        <form method="get" action="<?= base_url('Laporan') ?>" class="flex gap-2 flex-1 md:flex-none">
            <div class="flex items-center bg-white border border-gray-200 rounded-xl px-3 py-2 gap-2 flex-1 focus-within:ring-2 focus-within:ring-orange-500 focus-within:border-orange-500">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="q" placeholder="Cari lokasi, pelapor..." value="<?= htmlspecialchars($keyword) ?>" class="w-full bg-transparent focus:outline-none text-sm text-gray-800 font-medium placeholder-gray-400">
            </div>
            <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-sm px-4 py-2 rounded-xl transition active:scale-95">Cari</button>
            <?php if($keyword): ?>
            <a href="<?= base_url('Laporan') ?>" class="bg-red-50 text-red-500 font-bold text-sm px-3 py-2 rounded-xl border border-red-200 hover:bg-red-100 transition">Reset</a>
            <?php endif; ?>
        </form>
        <a href="<?= base_url('Laporan/tambah') ?>" class="bg-gradient-to-r from-orange-600 to-orange-500 text-white font-bold text-sm px-4 py-2.5 rounded-xl shadow hover:shadow-lg transition active:scale-95 flex items-center gap-1.5 whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            Tambah
        </a>
    </div>
</div>

<!-- Laporan Cards -->
<div class="space-y-4">
    <?php if(!empty($laporan)): ?>
        <?php foreach($laporan as $l): ?>
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
        ?>

        <div class="incident-card bg-white p-3 md:p-4 rounded-[20px] shadow-sm border border-gray-200 flex flex-col lg:flex-row gap-4 lg:gap-6 items-start lg:items-center">
            
            <?php if($foto_src): ?>
            <div class="w-full lg:w-[280px] h-[160px] lg:h-[110px] rounded-xl overflow-hidden border border-gray-100 flex-shrink-0 bg-gray-50">
                <img src="<?= $foto_src ?>" alt="Foto" class="w-full h-full object-cover">
            </div>
            <?php endif; ?>
            
            <div class="flex flex-1 w-full gap-4 md:gap-5 items-center lg:items-start py-1">
                <div class="flex-shrink-0 w-16 h-16 md:w-[70px] md:h-[70px] bg-red-50 rounded-[14px] flex flex-col items-center justify-center border border-red-100">
                    <span class="text-xl md:text-2xl font-extrabold text-red-600 leading-none mb-0.5"><?= $tanggal ?></span>
                    <span class="text-[10px] md:text-xs font-bold text-red-500 uppercase tracking-widest"><?= $bulan ?></span>
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="text-lg md:text-xl font-bold text-gray-900 truncate tracking-tight"><?= htmlspecialchars($l->lokasi) ?></h4>
                    <p class="text-sm text-orange-600 font-semibold mt-0.5 mb-1.5">Pelapor: <?= htmlspecialchars($l->nama_pelapor) ?></p>
                    <p class="text-sm md:text-base text-gray-600 line-clamp-2 md:line-clamp-1 leading-relaxed"><?= htmlspecialchars($l->deskripsi) ?></p>
                </div>
            </div>

            <div class="w-full lg:w-auto flex flex-row lg:flex-col justify-between items-center lg:items-end gap-3 lg:gap-4 pl-0 lg:pl-4 lg:border-l border-gray-100 py-1">
                <span class="text-sm font-medium text-gray-500 whitespace-nowrap"><?= $wkt ?></span>
                <div class="flex gap-2 w-full lg:w-auto">
                    <a href="<?= base_url('Laporan/detail/'.$l->id) ?>" class="flex-1 lg:flex-none flex items-center justify-center gap-1.5 px-4 py-2 text-sm font-bold text-orange-600 bg-orange-50 border border-orange-200 rounded-xl hover:bg-orange-100 hover:border-orange-300 transition-all active:scale-95 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        Detail
                    </a>
                    <a href="<?= base_url('Laporan/edit/'.$l->id) ?>" class="flex-1 lg:flex-none flex items-center justify-center gap-1.5 px-3 py-2 text-sm font-bold text-blue-600 bg-blue-50 border border-blue-200 rounded-xl hover:bg-blue-100 transition-all active:scale-95 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit
                    </a>
                    <button onclick="window.location.href='<?= base_url('Laporan/hapus/'.$l->id) ?>'" class="flex-1 lg:flex-none flex items-center justify-center gap-1.5 px-3 py-2 text-sm font-bold text-red-500 bg-red-50 border border-red-200 rounded-xl hover:bg-red-100 transition-all active:scale-95 shadow-sm cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Hapus
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="text-center py-16 px-6 bg-white rounded-[24px] shadow-sm border border-dashed border-gray-300 flex flex-col items-center">
            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-1"><?= $keyword ? 'Tidak Ditemukan' : 'Belum Ada Laporan' ?></h3>
            <p class="text-sm text-gray-500 max-w-sm"><?= $keyword ? 'Tidak ada laporan yang cocok dengan pencarian.' : 'Belum ada laporan yang dibuat.' ?></p>
            <a href="<?= base_url('Laporan/tambah') ?>" class="mt-4 bg-orange-600 text-white font-bold px-6 py-3 rounded-xl hover:bg-orange-700 transition">Buat Laporan Baru</a>
        </div>
    <?php endif; ?>
</div>
