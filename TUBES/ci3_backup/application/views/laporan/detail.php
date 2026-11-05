<?php
$waktu_lengkap = date('d F Y, H:i', strtotime($laporan->waktu_laporan)) . ' WIB';
$inisial_pelapor = strtoupper(substr($laporan->nama_pelapor, 0, 1));
$foto_src = (!empty($laporan->foto) && file_exists(FCPATH.$laporan->foto))
            ? base_url($laporan->foto)
            : '';
?>

<div class="max-w-[700px] mx-auto fade-in">
    
    <!-- Back + Title -->
    <div class="flex items-center justify-between mb-6">
        <a href="<?= base_url('Laporan') ?>" class="p-2.5 bg-white shadow-sm border border-gray-200 text-gray-700 hover:text-orange-600 hover:bg-orange-50 rounded-full transition-all active:scale-95">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <h1 class="text-xl font-extrabold text-gray-900 tracking-tight">Detail Insiden</h1>
        <div class="w-11"></div>
    </div>

    <div class="bg-white rounded-[24px] shadow-lg shadow-gray-200/50 border border-gray-100 overflow-hidden">
        
        <!-- Foto -->
        <?php if($foto_src): ?>
        <div class="w-full h-[250px] md:h-[350px] bg-gray-100 relative group">
            <img src="<?= $foto_src ?>" alt="Foto Kejadian" class="w-full h-full object-cover">
            <div class="absolute bottom-0 left-0 w-full h-1/3 bg-gradient-to-t from-black/60 to-transparent"></div>
        </div>
        <?php endif; ?>

        <div class="p-6 md:p-8 relative">
            
            <!-- Location Badge -->
            <?php if($foto_src): ?>
            <div class="absolute -top-6 left-6 md:left-8 bg-orange-600 text-white px-4 py-2 rounded-xl shadow-md flex items-center gap-2 font-bold text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                <?= htmlspecialchars($laporan->lokasi) ?>
            </div>
            <div class="h-4"></div>
            <?php else: ?>
            <h2 class="text-2xl font-extrabold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                <?= htmlspecialchars($laporan->lokasi) ?>
            </h2>
            <?php endif; ?>

            <!-- Reporter + Time -->
            <div class="flex items-center justify-between border-b border-gray-100 pb-5 mb-5 mt-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-orange-100 border border-orange-200 flex items-center justify-center text-orange-600 font-extrabold text-lg">
                        <?= $inisial_pelapor ?>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-widest font-bold mb-0.5">Dilaporkan Oleh</p>
                        <p class="font-bold text-gray-900"><?= htmlspecialchars($laporan->nama_pelapor) ?></p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-400 uppercase tracking-widest font-bold mb-0.5">Waktu Kejadian</p>
                    <p class="font-semibold text-gray-700 text-sm"><?= $waktu_lengkap ?></p>
                </div>
            </div>

            <!-- Description -->
            <div>
                <h3 class="text-lg font-extrabold text-gray-900 mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Keterangan Detail
                </h3>
                <p class="text-gray-600 leading-relaxed font-medium bg-gray-50 p-5 rounded-2xl border border-gray-100 whitespace-pre-line"><?= htmlspecialchars($laporan->deskripsi) ?></p>
            </div>

            <!-- Actions -->
            <div class="mt-8 flex gap-3">
                <a href="<?= base_url('Laporan/edit/'.$laporan->id) ?>" class="flex-1 bg-white border-2 border-orange-200 hover:border-orange-500 hover:bg-orange-50 text-orange-600 font-bold py-3.5 rounded-xl transition-all active:scale-95 flex justify-center items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit Laporan
                </a>
                <a href="<?= base_url('Laporan/hapus/'.$laporan->id) ?>" onclick="return confirm('Yakin ingin menghapus laporan ini?')" class="flex-1 bg-white border-2 border-red-200 hover:border-red-500 hover:bg-red-50 text-red-500 font-bold py-3.5 rounded-xl transition-all active:scale-95 flex justify-center items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Hapus
                </a>
            </div>
        </div>
    </div>
</div>
