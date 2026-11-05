<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Smart Traffic Finder') - Pantau & Laporkan Lalu Lintas</title>
    
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .bottom-nav-item { display: flex; flex-direction: column; align-items: center; justify-content: center; color: #94a3b8; font-size: 11px; padding: 8px 0; }
        .bottom-nav-item.active { color: #ea580c; font-weight: 700; }
    </style>
    @stack('styles')
</head>
<body class="text-gray-800 min-h-screen flex flex-col bg-[#f8fafc]">

    <!-- Top Navbar -->
    <header class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                
                <!-- Logo & Brand -->
                <div class="flex items-center space-x-8">
                    <a href="{{ auth()->check() ? route('beranda') : route('welcome') }}" class="flex items-center space-x-2.5">
                        <div class="w-10 h-10 rounded-xl bg-orange-600 flex items-center justify-center text-white shadow-md shadow-orange-500/30">
                            <i class="fas fa-traffic-light text-lg"></i>
                        </div>
                        <span class="font-extrabold text-xl tracking-tight text-gray-900">Smart Traffic <span class="text-orange-600">Finder</span></span>
                    </a>

                    <!-- Navigasi Desktop -->
                    <nav class="hidden md:flex space-x-6 text-sm font-semibold">
                        @auth
                            <a href="{{ route('beranda') }}" class="{{ request()->routeIs('beranda') ? 'text-orange-600 border-b-2 border-orange-600 pb-1' : 'text-gray-600 hover:text-orange-600 pb-1' }}">
                                <i class="fas fa-home me-1"></i> Beranda
                            </a>
                            <a href="{{ route('laporan.index') }}" class="{{ request()->routeIs('laporan.*') ? 'text-orange-600 border-b-2 border-orange-600 pb-1' : 'text-gray-600 hover:text-orange-600 pb-1' }}">
                                <i class="fas fa-bullhorn me-1"></i> Laporan
                            </a>
                            <a href="{{ route('chat') }}" class="{{ request()->routeIs('chat') ? 'text-orange-600 border-b-2 border-orange-600 pb-1' : 'text-gray-600 hover:text-orange-600 pb-1' }}">
                                <i class="fas fa-comments me-1"></i> Forum Chat
                            </a>
                        @else
                            <a href="{{ route('welcome') }}" class="{{ request()->routeIs('welcome') ? 'text-orange-600 border-b-2 border-orange-600 pb-1' : 'text-gray-600 hover:text-orange-600 pb-1' }}">
                                <i class="fas fa-info-circle me-1"></i> Beranda Publik
                            </a>
                        @endauth
                    </nav>
                </div>

                <!-- Bagian Kanan Navbar -->
                <div class="flex items-center space-x-4">
                    @auth
                        <!-- Tombol Buat Laporan Cepat -->
                        <a href="{{ route('laporan.create') }}" class="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-orange-600 hover:bg-orange-700 text-white text-xs font-bold rounded-lg shadow-sm transition">
                            <i class="fas fa-plus"></i> Laporkan Insiden
                        </a>

                        <!-- Profil Pill -->
                        <a href="{{ route('profile') }}" class="flex items-center space-x-2.5 bg-gray-50 hover:bg-gray-100 py-1.5 px-3 rounded-full border border-gray-200 transition">
                            <div class="w-7 h-7 rounded-full bg-orange-600 text-white font-bold text-xs flex items-center justify-center shadow-sm">
                                {{ Auth::user()->inisial }}
                            </div>
                            <span class="text-xs sm:text-sm font-semibold text-gray-700 truncate max-w-[120px]">{{ Auth::user()->name }}</span>
                        </a>

                        <!-- Form Logout (Method POST) -->
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" title="Keluar / Logout" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" onclick="return confirm('Apakah Anda yakin ingin keluar?')">
                                <i class="fas fa-sign-out-alt text-base"></i>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 hover:text-orange-600 px-3 py-1.5">
                            <i class="fas fa-sign-in-alt me-1"></i> Masuk
                        </a>
                        <a href="{{ route('register') }}" class="text-sm font-bold bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-xl shadow-sm shadow-orange-500/20 transition">
                            <i class="fas fa-user-plus me-1"></i> Daftar Akun
                        </a>
                    @endauth
                </div>

            </div>
        </div>
    </header>

    <!-- Global Notification Alerts -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full mt-4">
        @if(session('success'))
            <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm rounded-xl p-4 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2">
                    <i class="fas fa-check-circle text-emerald-600 text-base"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-red-50 border border-red-200 text-red-800 text-sm rounded-xl p-4 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2">
                    <i class="fas fa-exclamation-circle text-red-600 text-base"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-800">&times;</button>
            </div>
        @endif

        @if(session('info'))
            <div class="mb-4 bg-blue-50 border border-blue-200 text-blue-800 text-sm rounded-xl p-4 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2">
                    <i class="fas fa-info-circle text-blue-600 text-base"></i>
                    <span>{{ session('info') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-blue-500 hover:text-blue-800">&times;</button>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 bg-amber-50 border border-amber-200 text-amber-800 text-sm rounded-xl p-4 shadow-sm">
                <div class="flex items-center gap-2 font-bold mb-1">
                    <i class="fas fa-triangle-exclamation text-amber-600"></i>
                    <span>Periksa kembali input Anda:</span>
                </div>
                <ul class="list-disc list-inside space-y-0.5 text-xs text-amber-700">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="flex-1 pb-20 md:pb-8">
        @yield('content')
    </main>

    <!-- Mobile Bottom Navigation (Hanya Tampil di Layar Kecil untuk Pengguna Auth) -->
    @auth
    <nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 flex justify-around md:hidden z-40 py-1 shadow-lg">
        <a href="{{ route('beranda') }}" class="bottom-nav-item {{ request()->routeIs('beranda') ? 'active' : '' }}">
            <i class="fas fa-home text-base mb-0.5"></i>
            <span>Beranda</span>
        </a>
        <a href="{{ route('laporan.index') }}" class="bottom-nav-item {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
            <i class="fas fa-bullhorn text-base mb-0.5"></i>
            <span>Laporan</span>
        </a>
        <a href="{{ route('laporan.create') }}" class="bottom-nav-item text-orange-600 font-bold">
            <div class="w-8 h-8 rounded-full bg-orange-600 text-white flex items-center justify-center -mt-3 shadow-md">
                <i class="fas fa-plus text-xs"></i>
            </div>
            <span>Lapor</span>
        </a>
        <a href="{{ route('chat') }}" class="bottom-nav-item {{ request()->routeIs('chat') ? 'active' : '' }}">
            <i class="fas fa-comments text-base mb-0.5"></i>
            <span>Chat</span>
        </a>
        <a href="{{ route('profile') }}" class="bottom-nav-item {{ request()->routeIs('profile') ? 'active' : '' }}">
            <i class="fas fa-user text-base mb-0.5"></i>
            <span>Profil</span>
        </a>
    </nav>
    @endauth

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 py-6 text-center text-xs text-gray-500 hidden md:block">
        <div class="max-w-7xl mx-auto px-4">
            <p>&copy; 2026 <strong>Smart Traffic Finder</strong> &mdash; Proyek Tugas Akhir Pemrograman Berbasis Web (Modul 6 Autentikasi Laravel).</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
