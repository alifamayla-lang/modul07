<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .fade-in { animation: fadeIn 0.3s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 text-gray-800">

<div class="bg-white rounded-[24px] shadow-xl border border-gray-100 w-full max-w-md p-8 fade-in">
    <div class="text-center mb-8">
        <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4 text-orange-600">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
        </div>
        <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight"><?= ($step == 1) ? 'Lupa Password?' : 'Buat Password Baru' ?></h1>
        <p class="text-sm text-gray-500 mt-2">
            <?= ($step == 1) ? 'Masukkan email terdaftar untuk memulai reset password.' : 'Email ditemukan. Silakan buat kata sandi baru.' ?>
        </p>
    </div>

    <?php if($this->session->flashdata('error')): ?>
    <div class="bg-red-50 border border-red-200 text-red-600 text-sm p-3 rounded-xl mb-6 text-center font-semibold">
        <?= $this->session->flashdata('error') ?>
    </div>
    <?php endif; ?>

    <?php if($step == 1): ?>
        <?= form_open('Auth/proses_cek_email', ['class' => 'space-y-5']) ?>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">Alamat Email Terdaftar</label>
                <input type="email" name="email" required placeholder="Contoh: budi@email.com" class="w-full px-4 py-3.5 rounded-xl bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500 transition text-gray-800 font-medium">
            </div>
            <button type="submit" class="w-full bg-orange-600 hover:bg-orange-700 text-white font-bold py-3.5 px-8 rounded-xl shadow-md transition-all active:scale-95">
                Verifikasi Email
            </button>
        <?= form_close() ?>
    <?php else: ?>
        <?= form_open('Auth/proses_reset_password', ['class' => 'space-y-5']) ?>
            <input type="hidden" name="email_target" value="<?= htmlspecialchars($email_verified) ?>">

            <div class="bg-green-50 border border-green-200 text-green-700 text-sm p-3 rounded-xl text-center font-semibold">
                <?= htmlspecialchars($email_verified) ?>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">Kata Sandi Baru</label>
                <input type="password" name="pass_baru" required minlength="8" placeholder="Minimal 8 karakter" class="w-full px-4 py-3.5 rounded-xl bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500 transition text-gray-800 font-medium">
            </div>

            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3.5 px-8 rounded-xl shadow-md transition-all active:scale-95">
                Simpan Password Baru
            </button>
        <?= form_close() ?>
    <?php endif; ?>

    <div class="mt-8 text-center border-t border-gray-100 pt-6">
        <a href="<?= base_url('Auth/login') ?>" class="text-sm font-bold text-gray-500 hover:text-orange-600 transition flex items-center justify-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke halaman Login
        </a>
    </div>
</div>

</body>
</html>
