@extends('layouts.app')

@section('title', 'Pendaftaran Akun Baru')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8 sm:py-12">
    <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 p-8 sm:p-12">

        <div class="text-center mb-8">
            <div class="w-12 h-12 rounded-2xl bg-orange-600 text-white flex items-center justify-center mx-auto mb-3 shadow-md shadow-orange-500/30">
                <i class="fas fa-user-plus text-xl"></i>
            </div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Daftar Akun Pengguna</h2>
            <p class="text-sm text-gray-500 font-medium mt-1">Bergabung bersama ribuan pengendara untuk memantau lalu lintas Kota Bandung.</p>
        </div>

        <form action="{{ route('register') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Nama Lengkap -->
            <div>
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5 ml-1">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <div class="relative flex items-center">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <i class="fas fa-user text-sm"></i>
                    </div>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                        placeholder="Contoh: Budi Santoso"
                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border @error('name') border-red-500 focus:ring-red-500 @else border-gray-200 focus:ring-orange-500 @enderror rounded-xl text-sm font-medium focus:bg-white focus:outline-none focus:ring-2 transition">
                </div>
                @error('name')
                    <p class="text-red-500 text-xs mt-1.5 ml-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5 ml-1">
                    Alamat Email <span class="text-red-500">*</span>
                </label>
                <div class="relative flex items-center">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <i class="fas fa-envelope text-sm"></i>
                    </div>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        placeholder="budi@example.com"
                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border @error('email') border-red-500 focus:ring-red-500 @else border-gray-200 focus:ring-orange-500 @enderror rounded-xl text-sm font-medium focus:bg-white focus:outline-none focus:ring-2 transition">
                </div>
                @error('email')
                    <p class="text-red-500 text-xs mt-1.5 ml-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Grid: Telepon & Lokasi -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="telepon" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5 ml-1">
                        Nomor HP / WhatsApp
                    </label>
                    <div class="relative flex items-center">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <i class="fas fa-phone text-sm"></i>
                        </div>
                        <input type="text" id="telepon" name="telepon" value="{{ old('telepon') }}"
                            placeholder="08123456789"
                            class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                    </div>
                </div>

                <div>
                    <label for="lokasi" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5 ml-1">
                        Domisili / Wilayah
                    </label>
                    <div class="relative flex items-center">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <i class="fas fa-map-marker-alt text-sm"></i>
                        </div>
                        <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi', 'Bandung, Jawa Barat') }}"
                            placeholder="Contoh: Buah Batu, Bandung"
                            class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                    </div>
                </div>
            </div>

            <!-- Password & Konfirmasi Password -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5 ml-1">
                        Kata Sandi <span class="text-red-500">*</span>
                    </label>
                    <div class="relative flex items-center">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <i class="fas fa-lock text-sm"></i>
                        </div>
                        <input type="password" id="password" name="password" required autocomplete="new-password"
                            placeholder="Minimal 8 karakter"
                            class="w-full pl-10 pr-4 py-3 bg-gray-50 border @error('password') border-red-500 focus:ring-red-500 @else border-gray-200 focus:ring-orange-500 @enderror rounded-xl text-sm font-medium focus:bg-white focus:outline-none focus:ring-2 transition">
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1.5 ml-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5 ml-1">
                        Konfirmasi Sandi <span class="text-red-500">*</span>
                    </label>
                    <div class="relative flex items-center">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <i class="fas fa-lock text-sm"></i>
                        </div>
                        <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password"
                            placeholder="Ulangi kata sandi"
                            class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                    </div>
                </div>
            </div>

            <p class="text-[11px] text-gray-500 leading-relaxed">
                Dengan mendaftar, kata sandi Anda akan dienkripsi dengan algoritma <strong>Bcrypt Hash</strong> sesuai standar keamanan Laravel Modul 6.
            </p>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full py-3.5 bg-orange-600 hover:bg-orange-700 text-white font-extrabold rounded-xl shadow-lg shadow-orange-600/30 transition transform active:scale-95 text-sm flex items-center justify-center gap-2">
                <i class="fas fa-user-plus"></i> Selesaikan Pendaftaran
            </button>
        </form>

        <div class="mt-8 text-center text-xs text-gray-600">
            Sudah memiliki akun?
            <a href="{{ route('login') }}" class="font-bold text-orange-600 hover:text-orange-700 underline ml-1">
                Masuk di sini
            </a>
        </div>

    </div>
</div>
@endsection
