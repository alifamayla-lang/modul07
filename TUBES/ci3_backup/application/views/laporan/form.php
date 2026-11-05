<?php
$is_edit    = isset($laporan) && $laporan !== NULL;
$form_title = $is_edit ? 'Edit Laporan' : 'Kirim Laporan Baru';
$btn_label  = $is_edit ? 'Simpan Perubahan' : 'Kirim Laporan Sekarang';
?>

<div class="max-w-[800px] mx-auto">

    <div class="hidden md:flex flex-col mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight"><?= $form_title ?></h1>
        <p class="text-gray-500 mt-2">Bantu pengguna lain dengan melaporkan kondisi lalu lintas terkini.</p>
    </div>
    
    <div class="bg-white rounded-[24px] shadow-sm border border-gray-200 p-6 md:p-8">
        
        <?= form_open_multipart($action, ['class' => 'space-y-6', 'id' => 'formLaporan']) ?>
            
            <?php if($is_edit): ?>
            <input type="hidden" name="foto_lama" value="<?= htmlspecialchars($laporan->foto ?? '') ?>">
            <?php endif; ?>

            <!-- Nama Pelapor -->
            <?php if($is_edit): ?>
            <div class="space-y-2">
                <label class="text-sm font-bold text-gray-700 ml-1">Nama Pelapor</label>
                <div class="flex items-center bg-gray-50 border border-gray-200 rounded-2xl px-4 py-3.5 gap-3">
                    <div class="bg-orange-100 p-2 rounded-lg text-orange-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <input type="text" name="nama_pelapor" required placeholder="Nama pelapor" value="<?= htmlspecialchars($laporan->nama_pelapor ?? '') ?>" class="w-full bg-transparent focus:outline-none text-gray-800 placeholder-gray-400 font-medium">
                </div>
            </div>
            <?php endif; ?>

            <!-- Lokasi -->
            <div class="space-y-2">
                <label class="text-sm font-bold text-gray-700 ml-1">Lokasi Kejadian</label>
                <div class="flex items-center bg-gray-50 border border-gray-200 rounded-2xl px-4 py-3.5 gap-3 transition-colors focus-within:ring-2 focus-within:ring-orange-500 focus-within:border-orange-500">
                    <div class="bg-orange-100 p-2 rounded-lg text-orange-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <input type="text" name="lokasi" required placeholder="Contoh: Jl. Merdeka depan minimarket" value="<?= htmlspecialchars($laporan->lokasi ?? '') ?>" class="w-full bg-transparent focus:outline-none text-gray-800 placeholder-gray-400 font-medium">
                </div>
            </div>

            <!-- Foto Upload -->
            <div class="space-y-2">
                <label class="text-sm font-bold text-gray-700 ml-1">
                    Foto Bukti <?= $is_edit ? '<span class="text-xs font-normal text-gray-400">(kosongkan jika tidak ingin mengganti)</span>' : '(Wajib)' ?>
                </label>

                <?php if($is_edit && !empty($laporan->foto) && file_exists(FCPATH.$laporan->foto)): ?>
                <div class="bg-gray-50 rounded-2xl p-3 border border-gray-200 mb-2">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Foto Saat Ini</p>
                    <img src="<?= base_url($laporan->foto) ?>" alt="Foto" class="max-h-40 rounded-xl object-cover">
                </div>
                <?php endif; ?>

                <div id="uploadZone" class="border-2 border-dashed border-orange-300 bg-orange-50 hover:bg-orange-100 rounded-2xl h-56 flex flex-col items-center justify-center text-orange-600 transition relative cursor-pointer overflow-hidden group">
                    
                    <input type="file" name="foto" id="fotoInput" accept="image/*" <?= !$is_edit ? 'required' : '' ?> class="absolute inset-0 opacity-0 w-full h-full z-20 cursor-pointer" onchange="previewImage(event)">
                    
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
            
            <!-- Deskripsi -->
            <div class="space-y-2">
                <label class="text-sm font-bold text-gray-700 ml-1">Detail Kejadian</label>
                <textarea name="deskripsi" rows="4" placeholder="Jelaskan apa yang terjadi (cth: Kecelakaan beruntun, macet total karena lampu merah mati, dll)" required class="w-full p-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 focus:outline-none text-gray-800 placeholder-gray-400 font-medium transition-colors resize-none"><?= htmlspecialchars($laporan->deskripsi ?? '') ?></textarea>
            </div>
            
            <!-- Submit -->
            <div class="pt-2 flex gap-3">
                <?php if($is_edit): ?>
                <a href="<?= base_url('Laporan') ?>" class="flex-1 bg-white border-2 border-gray-200 hover:bg-gray-50 text-gray-700 font-bold text-lg py-4 rounded-2xl transition-all active:scale-95 flex items-center justify-center gap-2">Batal</a>
                <?php endif; ?>
                <button type="submit" id="btnSimpan" class="flex-1 bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-700 hover:to-orange-600 text-white font-bold text-lg py-4 rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200 flex items-center justify-center gap-2">
                    <span><?= $btn_label ?></span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
        <?= form_close() ?>
    </div>
    
    <p class="text-center text-xs text-gray-400 mt-6 font-medium">Laporan palsu dapat menyebabkan pemblokiran akun.</p>
</div>

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

document.getElementById('formLaporan').addEventListener('submit', function(){
    var btn = document.getElementById('btnSimpan');
    btn.innerHTML = '<svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Menyimpan...';
    btn.disabled = true;
});
</script>
