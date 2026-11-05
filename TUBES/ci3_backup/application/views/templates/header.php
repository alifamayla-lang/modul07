<?php
$inisial = strtoupper(substr($user_nama ?? 'A', 0, 1));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlspecialchars($title) : 'Smart Traffic Finder' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; overscroll-behavior-y: none; }
        .bottom-nav-item { display: flex; flex-direction: column; align-items: center; justify-content: center; color: #94a3b8; font-size: 10px; padding: 8px 0; }
        .bottom-nav-item.active { color: #ea580c; font-weight: 600; }
        .bottom-nav-item svg { margin-bottom: 2px; }
        .incident-card { transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1); }
        .incident-card:hover { transform: translateY(-3px); box-shadow: 0 12px 20px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.04); border-color: #fbd5b5; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .fade-in { animation: fadeIn 0.3s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="text-gray-800 h-screen flex flex-col overflow-hidden">
<main class="flex flex-1 overflow-hidden relative bg-[#f8fafc] pb-[60px] md:pb-0">
    
    <div class="flex-1 flex flex-col h-full relative">
        <header class="bg-white shadow-sm px-8 py-4 hidden md:flex justify-between items-center z-20 relative border-b border-gray-100">
            <div class="flex items-center space-x-10">
                <div class="flex items-center space-x-2">
                    <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="font-extrabold text-xl tracking-tight text-gray-900">Smart Traffic Finder</span>
                </div>
                <nav class="flex space-x-6">
                    <a href="<?= base_url('Dashboard') ?>" class="<?= ($active_page==='dashboard') ? 'text-orange-600 font-bold border-b-2 border-orange-600' : 'text-gray-500 hover:text-orange-600 font-medium' ?> text-sm transition-colors pb-1">Beranda</a>
                    <a href="<?= base_url('Laporan') ?>" class="<?= ($active_page==='laporan') ? 'text-orange-600 font-bold border-b-2 border-orange-600' : 'text-gray-500 hover:text-orange-600 font-medium' ?> text-sm transition-colors pb-1">Laporan</a>
                    <a href="<?= base_url('Chat') ?>" class="<?= ($active_page==='chat') ? 'text-orange-600 font-bold border-b-2 border-orange-600' : 'text-gray-500 hover:text-orange-600 font-medium' ?> text-sm transition-colors pb-1">Chat</a>
                </nav>
            </div>
            
            <div class="flex items-center space-x-5">
                <a href="<?= base_url('Profil') ?>" class="flex items-center space-x-3 bg-gray-50 hover:bg-gray-100 py-1.5 px-3 rounded-full transition border border-gray-200">
                    <img src="https://placehold.co/32x32/ea580c/ffffff?text=<?= $inisial ?>" class="w-7 h-7 rounded-full shadow-sm">
                    <span class="text-sm font-semibold text-gray-700 pr-1"><?= htmlspecialchars($user_nama ?? '') ?></span>
                </a>
                <button onclick="window.location.href='<?= base_url('Auth/logout') ?>'" class="text-gray-400 hover:text-red-500 transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </button>
            </div>
        </header>

        <div class="flex-1 flex flex-col h-full overflow-hidden relative w-full">
            <div class="flex-1 overflow-y-auto p-4 pb-20 md:p-8 max-w-[1400px] mx-auto w-full no-scrollbar">

                <!-- Mobile Header -->
                <div class="flex justify-between items-center mb-6 md:hidden">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 tracking-tight"><?= htmlspecialchars(explode('—', $title ?? 'Dashboard')[0]) ?></h1>
                        <p class="text-sm text-gray-500 font-medium">Halo, <?= htmlspecialchars($user_nama ?? '') ?>!</p>
                    </div>
                    <button onclick="window.location.href='<?= base_url('Auth/logout') ?>'" class="p-2 bg-white rounded-full shadow-sm border border-gray-100 text-red-500 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </button>
                </div>

                <?php if($this->session->flashdata('success')): ?>
                <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-2xl mb-6 flex items-center gap-3 font-semibold text-sm fade-in">
                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <?= $this->session->flashdata('success') ?>
                </div>
                <?php endif; ?>
                <?php if($this->session->flashdata('error')): ?>
                <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-3 rounded-2xl mb-6 flex items-center gap-3 font-semibold text-sm fade-in">
                    <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <?= $this->session->flashdata('error') ?>
                </div>
                <?php endif; ?>
