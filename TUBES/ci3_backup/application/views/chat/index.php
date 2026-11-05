<?php
$inisial = strtoupper(substr($user_nama ?? 'A', 0, 1));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; overscroll-behavior-y: none; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .sidebar-item { display: flex; align-items: center; padding: 12px; margin-bottom: 8px; cursor: pointer; transition: all 0.2s; border-radius: 12px; background-color: white; border: 1px solid #f3f4f6; }
        .sidebar-item.active-chat { background-color: #ffedd5; border-left: 4px solid #f97316; border-color: #ffedd5; }
        .profile-img { width: 40px; height: 40px; object-fit: cover; border-radius: 50%; margin-right: 12px; border: 2px solid #f97316; flex-shrink: 0; }
        .bottom-nav-item { display: flex; flex-direction: column; align-items: center; justify-content: center; color: #94a3b8; font-size: 10px; padding: 8px 0; }
        .bottom-nav-item.active { color: #ea580c; font-weight: 600; }
        .bottom-nav-item svg { margin-bottom: 2px; }
        .message-bubble { max-width: 80%; padding: 10px 14px; border-radius: 18px; box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1); word-wrap: break-word; }
        .incoming { background-color: #ffffff; border-top-left-radius: 6px; }
        .outgoing { background-color: #ea580c; color: white; border-top-right-radius: 6px; }
    </style>
</head>
<body class="text-gray-800 h-screen flex flex-col overflow-hidden">
<main class="flex flex-1 relative bg-[#f8fafc] pb-[60px] md:pb-0">
    
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
                    <a href="<?= base_url('Dashboard') ?>" class="text-gray-500 hover:text-orange-600 font-medium text-sm transition-colors pb-1">Beranda</a>
                    <a href="<?= base_url('Laporan') ?>" class="text-gray-500 hover:text-orange-600 font-medium text-sm transition-colors pb-1">Laporan</a>
                    <a href="<?= base_url('Chat') ?>" class="text-orange-600 font-bold text-sm border-b-2 border-orange-600 pb-1">Chat</a>
                </nav>
            </div>
            <div class="flex items-center space-x-5">
                <a href="<?= base_url('Profil') ?>" class="flex items-center space-x-3 bg-gray-50 hover:bg-gray-100 py-1.5 px-3 rounded-full transition border border-gray-200">
                    <img src="https://placehold.co/32x32/ea580c/ffffff?text=<?= $inisial ?>" class="w-7 h-7 rounded-full shadow-sm">
                    <span class="text-sm font-semibold text-gray-700 pr-1"><?= htmlspecialchars($user_nama) ?></span>
                </a>
                <a href="<?= base_url('Auth/logout') ?>" class="text-gray-400 hover:text-red-500 transition" onclick="return confirm('Yakin ingin logout?')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </a>
            </div>
        </header>

        <div class="flex w-full h-full pt-0">
            <!-- Sidebar Contacts -->
            <div class="hidden md:flex flex-col w-1/3 lg:w-1/4 bg-white border-r border-gray-100 h-full z-10">
                <div class="p-4 border-b border-gray-100 bg-white sticky top-0 z-10 shadow-sm">
                    <h2 class="text-xl font-bold text-gray-900 tracking-tight">Chat & Grup</h2>
                    <div class="mt-4 relative">
                        <input type="text" placeholder="Cari teman atau grup..." class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
                <div class="flex-1 overflow-y-auto p-4 space-y-6 no-scrollbar">
                    <div>
                        <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 px-1">Grup Komunitas</h3>
                        <div class="space-y-1">
                            <div class="sidebar-item shadow-sm active-chat">
                                <img class="profile-img" src="https://placehold.co/40x40/f97316/ffffff?text=GU" alt="Grup">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 truncate">Grup Utama</p>
                                    <p class="text-xs text-gray-500 truncate">Semua pengguna aktif</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chat Area -->
            <div class="flex-1 flex flex-col h-full bg-white relative">
                <div class="bg-white border-b border-gray-100 shadow-sm p-3 md:p-4 flex items-center justify-between sticky top-0 z-20">
                    <div class="flex items-center">
                        <img src="https://placehold.co/40x40/f97316/ffffff?text=GU" class="profile-img border-gray-200 w-10 h-10 mr-3" alt="Chat">
                        <div>
                            <h2 class="text-lg font-bold text-gray-900 truncate tracking-tight">Grup Komunitas Utama</h2>
                            <p class="text-xs text-green-500 font-medium">Online - Terbuka untuk semua</p>
                        </div>
                    </div>
                </div>

                <div id="message-area" class="flex-1 overflow-y-auto p-4 space-y-4 no-scrollbar bg-[#f8fafc] flex flex-col">
                    <div class="flex justify-center text-xs font-semibold text-gray-500 my-4 bg-gray-200/50 py-1.5 px-4 rounded-full mx-auto">Riwayat Pesan</div>
                    
                    <?php if (!empty($messages)): ?>
                        <?php foreach ($messages as $msg): ?>
                            <?php $is_me = ($msg->sender == $user_nama); $waktu = date('H:i', strtotime($msg->created_at)); ?>
                            
                            <?php if ($is_me): ?>
                            <div class="flex justify-end">
                                <div class="message-bubble outgoing">
                                    <p class="text-sm"><?= htmlspecialchars($msg->message) ?></p>
                                    <span class="block mt-1 text-[10px] text-white/80 text-right font-medium"><?= $waktu ?></span>
                                </div>
                            </div>
                            <?php else: ?>
                            <div class="flex justify-start">
                                <div class="message-bubble incoming border border-gray-100">
                                    <p class="text-xs text-orange-600 font-bold mb-1"><?= htmlspecialchars($msg->sender) ?></p>
                                    <p class="text-sm"><?= htmlspecialchars($msg->message) ?></p>
                                    <span class="block mt-1 text-[10px] text-gray-400 text-right font-medium"><?= $waktu ?></span>
                                </div>
                            </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="flex flex-col items-center justify-center h-full text-center opacity-50 mt-10">
                            <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            <p class="text-gray-500 text-sm font-medium">Belum ada obrolan.</p>
                            <p class="text-gray-400 text-xs mt-1">Jadilah yang pertama menyapa grup ini!</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Input -->
                <div class="bg-white border-t border-gray-100 p-3 md:p-4 sticky bottom-0 z-10">
                    <?= form_open('Chat/kirim', ['class' => 'flex items-center space-x-2']) ?>
                        <input type="text" name="pesan" required autocomplete="off" placeholder="Ketik pesan..." class="flex-1 p-3.5 rounded-xl bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:bg-white transition text-sm font-medium text-gray-800">
                        <button type="submit" class="bg-gradient-to-r from-orange-600 to-orange-500 text-white p-3.5 rounded-xl hover:from-orange-700 hover:to-orange-600 transition shadow-md hover:shadow-lg active:scale-95 cursor-pointer">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                        </button>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
    
    <nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 flex justify-around md:hidden pb-safe z-50">
        <a href="<?= base_url('Dashboard') ?>" class="bottom-nav-item"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9,22 9,12 15,12 15,22"/></svg><span class="mt-1">Beranda</span></a>
        <a href="<?= base_url('Laporan') ?>" class="bottom-nav-item"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14,2 14,8 20,8"/></svg><span class="mt-1">Laporan</span></a>
        <a href="<?= base_url('Chat') ?>" class="bottom-nav-item active"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg><span class="mt-1">Chat</span></a>
        <a href="<?= base_url('Profil') ?>" class="bottom-nav-item"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg><span class="mt-1">Profil</span></a>
    </nav>
</main>

<script>
var messageArea = document.getElementById("message-area");
messageArea.scrollTop = messageArea.scrollHeight;
</script>
</body>
</html>
