<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800">

<div class="flex items-center justify-center min-h-screen p-4 md:p-8">
    <div class="bg-white rounded-[24px] shadow-2xl shadow-gray-200/50 w-full max-w-4xl flex flex-col-reverse md:flex-row overflow-hidden border border-gray-100">

        <!-- Panel Kiri (Orange) -->
        <div class="hidden md:flex w-1/2 bg-gradient-to-br from-orange-500 to-orange-600 p-12 flex-col text-center justify-center text-white relative overflow-hidden">
            <div class="absolute top-0 left-0 opacity-10 transform -translate-x-1/3 -translate-y-1/3">
                <svg width="300" height="300" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14.5v-9l6 4.5-6 4.5z"/></svg>
            </div>
            <div class="relative z-10 flex flex-col items-center">
                <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                </div>
                <h2 class="text-4xl font-extrabold mb-4 tracking-tight leading-tight">Sudah Punya<br>Akun?</h2>
                <p class="text-orange-100 font-medium text-lg leading-relaxed mb-10 max-w-sm">Masuk untuk melihat laporan lalu lintas terbaru dan kelola rute perjalanan Anda.</p>
                <a href="<?= base_url('Auth/login') ?>" class="bg-white text-orange-600 font-extrabold px-8 py-4 rounded-xl shadow-lg hover:bg-gray-50 hover:shadow-xl transition-all active:scale-95 flex items-center gap-2">Masuk Sekarang</a>
            </div>
        </div>

        <!-- Form Register -->
        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
            <div class="text-center mb-10">
                <div class="flex items-center justify-center space-x-3 mb-2">
                    <svg class="w-9 h-9 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="font-extrabold text-2xl md:text-3xl tracking-tight text-gray-900">Smart Traffic Finder</span>
                </div>
                <p class="text-sm text-gray-500 font-medium mt-3">Mulai perjalanan Anda. Buat akun baru sekarang!</p>
            </div>

            <?php if($this->session->flashdata('error')): ?>
            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-5 flex items-center gap-2 font-semibold text-sm">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <?= $this->session->flashdata('error') ?>
            </div>
            <?php endif; ?>
            <?php if($this->session->flashdata('success')): ?>
            <div class="bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-xl mb-5 flex items-center gap-2 font-semibold text-sm">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <?= $this->session->flashdata('success') ?>
            </div>
            <?php endif; ?>

            <?= form_open('Auth/proses_register', ['class' => 'space-y-4', 'novalidate' => 'novalidate']) ?>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">Nama Lengkap</label>
                    <div class="flex items-center bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 gap-3 focus-within:ring-2 focus-within:ring-orange-500 focus-within:border-orange-500 transition-all">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <input type="text" name="nama_lengkap" placeholder="Masukkan nama lengkap Anda" value="<?= set_value('nama_lengkap') ?>" class="w-full bg-transparent focus:outline-none text-gray-800 font-medium placeholder-gray-400">
                    </div>
                    <?= form_error('nama_lengkap', '<p class="text-red-600 text-xs font-semibold mt-1.5 ml-1">', '</p>') ?>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">Alamat Email</label>
                    <div class="flex items-center bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 gap-3 focus-within:ring-2 focus-within:ring-orange-500 focus-within:border-orange-500 transition-all">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <input type="email" name="email" placeholder="Contoh: budi@email.com" value="<?= set_value('email') ?>" class="w-full bg-transparent focus:outline-none text-gray-800 font-medium placeholder-gray-400">
                    </div>
                    <?= form_error('email', '<p class="text-red-600 text-xs font-semibold mt-1.5 ml-1">', '</p>') ?>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">Kata Sandi</label>
                    <div class="flex items-center bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 gap-3 focus-within:ring-2 focus-within:ring-orange-500 focus-within:border-orange-500 transition-all">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        <input type="password" name="password" placeholder="Minimal 8 karakter" class="w-full bg-transparent focus:outline-none text-gray-800 font-medium placeholder-gray-400">
                    </div>
                    <?= form_error('password', '<p class="text-red-600 text-xs font-semibold mt-1.5 ml-1">', '</p>') ?>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">Konfirmasi Kata Sandi</label>
                    <div class="flex items-center bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 gap-3 focus-within:ring-2 focus-within:ring-orange-500 focus-within:border-orange-500 transition-all">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        <input type="password" name="password_confirm" placeholder="Ulangi kata sandi Anda" class="w-full bg-transparent focus:outline-none text-gray-800 font-medium placeholder-gray-400">
                    </div>
                    <?= form_error('password_confirm', '<p class="text-red-600 text-xs font-semibold mt-1.5 ml-1">', '</p>') ?>
                </div>
                <div class="pt-4">
                    <button type="submit" class="w-full bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-700 hover:to-orange-600 text-white font-bold py-3.5 rounded-xl shadow-lg hover:shadow-xl transition-all active:scale-95 flex justify-center items-center gap-2">
                        Daftar Akun
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            <?= form_close() ?>

            <p class="text-center text-sm font-medium text-gray-600 mt-8 md:hidden">
                Sudah punya akun? <a href="<?= base_url('Auth/login') ?>" class="text-orange-600 font-bold hover:underline">Masuk Sekarang</a>
            </p>
        </div>
    </div>
</div>
</body>
</html>
