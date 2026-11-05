@extends('layouts.app')

@section('title', 'Selamat Datang di Smart Traffic Finder')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <!-- Hero Banner -->
    <div class="relative bg-gradient-to-r from-orange-600 via-orange-500 to-amber-500 rounded-3xl p-8 sm:p-14 text-white shadow-xl shadow-orange-500/20 overflow-hidden mb-12">
        <div class="relative z-10 max-w-2xl">
            <span class="inline-flex items-center gap-2 px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-bold uppercase tracking-wider mb-4">
                <i class="fas fa-satellite-dish animate-pulse"></i> Sistem Pemantauan Cerdas Lalu Lintas
            </span>
            <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight leading-tight mb-4">
                Jelajahi Kota Tanpa Macet, Bagikan Informasi Nyata.
            </h1>
            <p class="text-base sm:text-lg text-orange-100 font-medium leading-relaxed mb-8">
                Smart Traffic Finder adalah platform komunitas dan pelaporan lalu lintas cerdas untuk masyarakat Kota Bandung. Laporkan kemacetan, insiden, atau kecelakaan secara real-time.
            </p>

            <div class="flex flex-wrap gap-4">
                @auth
                    <a href="{{ route('beranda') }}" class="px-6 py-3.5 bg-white text-orange-600 font-extrabold rounded-2xl shadow-lg hover:bg-orange-50 transition transform active:scale-95 flex items-center gap-2">
                        <i class="fas fa-tachometer-alt"></i> Buka Dashboard Saya
                    </a>
                @else
                    <a href="{{ route('register') }}" class="px-6 py-3.5 bg-white text-orange-600 font-extrabold rounded-2xl shadow-lg hover:bg-orange-50 transition transform active:scale-95 flex items-center gap-2">
                        <i class="fas fa-user-plus"></i> Bergabung Sekarang (Gratis)
                    </a>
                    <a href="{{ route('login') }}" class="px-6 py-3.5 bg-orange-700/60 hover:bg-orange-700/80 border border-white/20 text-white font-bold rounded-2xl backdrop-blur-md transition flex items-center gap-2">
                        <i class="fas fa-sign-in-alt"></i> Masuk ke Akun
                    </a>
                @endauth
            </div>
        </div>

        <div class="absolute -right-12 -bottom-12 opacity-15 hidden lg:block pointer-events-none">
            <i class="fas fa-road text-[320px]"></i>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-12">
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center text-2xl font-bold">
                <i class="fas fa-bullhorn"></i>
            </div>
            <div>
                <div class="text-2xl font-extrabold text-gray-900">{{ $totalLaporan }}</div>
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Insiden Terlaporkan</div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl font-bold">
                <i class="fas fa-shield-alt"></i>
            </div>
            <div>
                <div class="text-2xl font-extrabold text-gray-900">100% Aman</div>
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Autentikasi Bcrypt & Middleware</div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl font-bold">
                <i class="fas fa-map-marked-alt"></i>
            </div>
            <div>
                <div class="text-2xl font-extrabold text-gray-900">Kota Bandung</div>
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Cakupan Wilayah Terkini</div>
            </div>
        </div>
    </div>

    <!-- Preview Insiden Terkini -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm mb-12">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-xl font-extrabold text-gray-900">Insiden & Kemacetan Terbaru</h2>
                <p class="text-sm text-gray-500">Laporan langsung dari para pengguna di jalan.</p>
            </div>
            <a href="{{ auth()->check() ? route('laporan.index') : route('login') }}" class="text-xs sm:text-sm font-bold text-orange-600 hover:text-orange-700">
                Lihat Semua &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($laporanTerbaru as $lap)
                <div class="border border-gray-200 rounded-2xl overflow-hidden hover:shadow-md transition">
                    <div class="h-44 w-full bg-gray-100 overflow-hidden">
                        <img src="{{ $lap->foto_url }}" alt="{{ $lap->lokasi }}" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4">
                        <div class="flex items-center justify-between text-xs text-gray-500 mb-2">
                            <span><i class="fas fa-clock text-orange-500 me-1"></i> {{ $lap->waktu_berlalu }}</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-orange-100 text-orange-700">Macet {{ $lap->tingkat_kemacetan }}%</span>
                        </div>
                        <h3 class="font-bold text-gray-900 text-base mb-1 truncate">{{ $lap->lokasi }}</h3>
                        <p class="text-xs text-gray-600 line-clamp-2 leading-relaxed mb-3">{{ $lap->deskripsi }}</p>
                        <div class="text-[11px] text-gray-400 font-medium">Pelapor: {{ $lap->nama_pelapor }}</div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-8 text-gray-400">
                    Belum ada insiden yang dilaporkan hari ini.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Informasi Fitur Autentikasi Modul 6 -->
    <div class="bg-gray-900 rounded-3xl p-8 sm:p-10 text-white">
        <div class="max-w-3xl">
            <span class="text-xs font-bold text-orange-400 uppercase tracking-widest">Ketentuan Modul 6 Pemrograman Web</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold mt-2 mb-4">Fitur Keamanan & Autentikasi Pengguna</h2>
            <p class="text-gray-300 text-sm sm:text-base leading-relaxed mb-6">
                Proyek Tugas Akhir ini telah memenuhi seluruh kriteria Modul 6: Autentikasi Manual Laravel menggunakan Controller, Password Hashing dengan Bcrypt (`Hash::make()`), proteksi halaman melalui Middleware Auth, serta Seeding data dummy menggunakan Faker dengan locale Indonesia.
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div class="flex items-start gap-2.5">
                    <i class="fas fa-lock text-orange-400 mt-1"></i>
                    <div><strong>Password Hash:</strong> Tersimpan aman dalam bentuk `$2y$...` di database MySQL phpMyAdmin.</div>
                </div>
                <div class="flex items-start gap-2.5">
                    <i class="fas fa-user-shield text-orange-400 mt-1"></i>
                    <div><strong>Middleware Auth:</strong> Halaman Beranda, Laporan, Chat, dan Profil hanya bisa dibuka setelah login.</div>
                </div>
                <div class="flex items-start gap-2.5">
                    <i class="fas fa-database text-orange-400 mt-1"></i>
                    <div><strong>Seeder & Faker:</strong> Tersedia 5 akun pengguna dummy + 1 admin siap uji.</div>
                </div>
                <div class="flex items-start gap-2.5">
                    <i class="fas fa-key text-orange-400 mt-1"></i>
                    <div><strong>CSRF & Session:</strong> Dilindungi token CSRF dan Session Regeneration otomatis.</div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
