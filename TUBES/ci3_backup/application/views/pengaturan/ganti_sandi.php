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
<body class="p-4 md:p-8 max-w-[600px] mx-auto fade-in min-h-screen flex flex-col justify-center text-gray-800">

<div class="flex items-center mb-6">
    <a href="<?= base_url('Pengaturan') ?>" class="p-2 mr-4 text-gray-700 bg-white shadow-sm border border-gray-100 hover:bg-gray-50 rounded-full transition">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Ganti Kata Sandi</h1>
</div>

<?php if($this->session->flashdata('error')): ?>
<div class="bg-red-50 border border-red-200 text-red-700 px-5 py-3 rounded-2xl mb-6 font-semibold text-sm">
    <?= $this->session->flashdata('error') ?>
</div>
<?php endif; ?>

<?= form_open('Pengaturan/update_password', ['class' => 'bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 mb-8 space-y-5']) ?>
    <p class="text-sm text-gray-500">Pastikan kata sandi baru unik dan tidak mudah ditebak.</p>

    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">Kata Sandi Lama</label>
        <input type="password" name="pass_lama" required class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500 transition text-gray-800 font-medium">
    </div>

    <div class="h-px bg-gray-100"></div>

    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">Kata Sandi Baru</label>
        <input type="password" name="pass_baru" required minlength="8" placeholder="Minimal 8 karakter" class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500 transition text-gray-800 font-medium">
    </div>

    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">Konfirmasi Kata Sandi Baru</label>
        <input type="password" name="konfirmasi_pass" required minlength="8" placeholder="Ulangi kata sandi baru" class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500 transition text-gray-800 font-medium">
    </div>

    <div class="pt-4 border-t border-gray-100">
        <button type="submit" class="w-full bg-orange-600 hover:bg-orange-700 text-white font-bold py-3.5 px-8 rounded-xl shadow-md transition-all active:scale-95">
            Simpan Kata Sandi
        </button>
    </div>
<?= form_close() ?>

</body>
</html>
