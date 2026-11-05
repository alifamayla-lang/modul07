<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
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

<body class="p-4 md:p-8 max-w-[800px] mx-auto fade-in text-gray-800">

    <div class="flex items-center mb-6">
        <a href="<?= base_url('Profil') ?>" class="p-2 mr-4 text-gray-700 bg-white shadow-sm border border-gray-100 hover:bg-gray-50 rounded-full transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Pengaturan Akun</h1>
    </div>

    <?php if($this->session->flashdata('success')): ?>
    <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-2xl mb-6 flex items-center gap-3 font-semibold text-sm">
        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <?= $this->session->flashdata('success') ?>
    </div>
    <?php endif; ?>
    <?php if($this->session->flashdata('error')): ?>
    <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-3 rounded-2xl mb-6 flex items-center gap-3 font-semibold text-sm">
        <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <?= $this->session->flashdata('error') ?>
    </div>
    <?php endif; ?>

    <?= form_open('Pengaturan/update', ['class' => 'bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 mb-8']) ?>
        <h2 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-6">Informasi Dasar</h2>
        <div class="space-y-5">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="<?= htmlspecialchars($user_data->nama_lengkap) ?>" required class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500 transition text-gray-800 font-medium">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">Alamat Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user_data->email) ?>" required class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500 transition text-gray-800 font-medium">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">Nomor Telepon</label>
                <input type="text" name="telepon" value="<?= htmlspecialchars($user_data->telepon ?? '') ?>" placeholder="+62 8..." class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500 transition text-gray-800 font-medium">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">Lokasi Anda</label>
                <input type="text" name="lokasi" value="<?= htmlspecialchars($user_data->lokasi ?? '') ?>" placeholder="Contoh: Bandung, Indonesia" class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500 transition text-gray-800 font-medium">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">Status / Peran</label>
                <input type="text" name="status" value="<?= htmlspecialchars($user_data->status ?? 'Pengguna Aktif') ?>" placeholder="Mahasiswa / Pegawai" class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500 transition text-gray-800 font-medium">
            </div>
        </div>
        <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end">
            <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-3 px-8 rounded-xl shadow-md transition-all active:scale-95">Simpan Perubahan</button>
        </div>
    <?= form_close() ?>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden divide-y divide-gray-100 mb-8">
        <p class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest bg-gray-50/50">Keamanan & Preferensi</p>
        <a href="<?= base_url('Pengaturan/ganti_sandi') ?>" class="flex items-center justify-between px-6 py-4 hover:bg-gray-50 transition">
            <div class="flex items-center">
                <div class="p-2 bg-orange-50 rounded-lg mr-4 text-orange-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <div>
                    <span class="text-sm font-bold text-gray-700 block">Ganti Kata Sandi</span>
                    <span class="text-xs font-medium text-gray-400">Perbarui password akun</span>
                </div>
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
