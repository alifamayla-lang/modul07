@extends('layouts.app')

@section('title', 'Profil Pengguna')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6 sm:py-10">

    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('beranda') }}" class="text-xs font-bold text-orange-600 hover:text-orange-700 flex items-center gap-1.5">
            <i class="fas fa-arrow-left"></i> Kembali ke Beranda
        </a>
        <span class="text-xs font-semibold text-gray-400">Modul 6 Autentikasi Pengguna</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Kartu Ringkasan Pengguna (Kiri) -->
        <div class="md:col-span-1 bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-lg text-center flex flex-col justify-between">
            <div>
                <!-- Avatar Inisial -->
                <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full bg-orange-600 text-white font-extrabold text-3xl sm:text-4xl flex items-center justify-center mx-auto mb-4 shadow-xl shadow-orange-500/30 border-4 border-orange-100">
                    {{ $user->inisial }}
                </div>

                <h2 class="text-xl font-extrabold text-gray-900 tracking-tight">{{ $user->name }}</h2>
                <p class="text-xs font-semibold text-orange-600 mt-0.5 mb-1">{{ $user->status_pengguna }}</p>
                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-orange-100 text-orange-700' }}">
                    Role: {{ $user->role }}
                </span>

                <div class="mt-6 pt-6 border-t border-gray-100 text-left space-y-3 text-xs text-gray-600">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-envelope text-orange-500 w-4"></i>
                        <span class="truncate">{{ $user->email }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-phone text-orange-500 w-4"></i>
                        <span>{{ $user->telepon }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-map-marker-alt text-orange-500 w-4"></i>
                        <span>{{ $user->lokasi }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-calendar-check text-orange-500 w-4"></i>
                        <span>Bergabung: <strong>{{ $user->created_at ? $user->created_at->diffForHumans() : 'Baru saja' }}</strong></span>
                    </div>
                </div>

                <!-- Statistik Laporan Pengguna -->
                <div class="mt-6 bg-orange-50/80 p-3.5 rounded-2xl border border-orange-100">
                    <div class="text-2xl font-extrabold text-orange-600">{{ $totalLaporanUser }}</div>
                    <div class="text-[11px] font-bold text-gray-600 uppercase tracking-wide">Total Kontribusi Laporan</div>
                </div>
            </div>

            <!-- Tombol Keluar / Logout -->
            <div class="mt-8 pt-4 border-t border-gray-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full py-2.5 bg-red-50 hover:bg-red-100 text-red-600 font-bold text-xs rounded-xl border border-red-200 transition flex items-center justify-center gap-2" onclick="return confirm('Apakah Anda yakin ingin logout?')">
                        <i class="fas fa-sign-out-alt"></i> Keluar dari Akun (Logout)
                    </button>
                </form>
            </div>
        </div>

        <!-- Kolom Kanan: Form Edit Profil & Riwayat Laporan -->
        <div class="md:col-span-2 space-y-6">

            <!-- Form Edit Data Profil -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-md">
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-100">
                    <h3 class="text-base font-extrabold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-user-edit text-orange-600"></i> Perbarui Data Akun
                    </h3>
                    <span class="text-[11px] text-gray-400">ID Pengguna: #{{ $user->id }}</span>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                            Nama Lengkap
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="telepon" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                Nomor HP / WhatsApp
                            </label>
                            <input type="text" id="telepon" name="telepon" value="{{ old('telepon', $user->telepon) }}"
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                        </div>

                        <div>
                            <label for="lokasi" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                Wilayah / Domisili
                            </label>
                            <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi', $user->lokasi) }}"
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="px-5 py-2.5 bg-gray-900 hover:bg-gray-800 text-white font-bold text-xs rounded-xl shadow transition">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan Profil
                        </button>
                    </div>
                </form>
            </div>

            <!-- Riwayat Laporan Pengguna Terakhir -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-md">
                <h3 class="text-base font-extrabold text-gray-900 mb-4 pb-3 border-b border-gray-100 flex items-center gap-2">
                    <i class="fas fa-history text-orange-600"></i> Riwayat Laporan Saya
                </h3>

                <div class="space-y-3">
                    @forelse($laporanUser as $lap)
                        <div class="p-3.5 bg-gray-50 rounded-2xl border border-gray-100 flex items-center justify-between">
                            <div class="min-w-0 flex-1 pr-3">
                                <h4 class="text-xs font-bold text-gray-900 truncate">{{ $lap->lokasi }}</h4>
                                <p class="text-[11px] text-gray-500">{{ $lap->waktu_laporan->translatedFormat('d M Y, H:i') }} ({{ $lap->waktu_berlalu }})</p>
                            </div>
                            <a href="{{ route('laporan.show', $lap->id) }}" class="text-xs font-bold text-orange-600 hover:text-orange-700 flex items-center gap-1">
                                Detail &rarr;
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-6 text-gray-400 text-xs">
                            Anda belum pernah mengirim laporan lalu lintas.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
