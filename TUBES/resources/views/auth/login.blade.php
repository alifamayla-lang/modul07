@extends('layouts.app')

@section('title', 'Masuk ke Akun')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8 sm:py-12">
    <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 flex flex-col md:flex-row overflow-hidden">

        <!-- Form Login Kolom Kiri -->
        <div class="w-full md:w-1/2 p-8 sm:p-12 flex flex-col justify-center">
            
            <div class="mb-8">
                <div class="flex items-center space-x-3 mb-2">
                    <div class="w-10 h-10 rounded-xl bg-orange-600 flex items-center justify-center text-white shadow-md shadow-orange-500/20">
                        <i class="fas fa-traffic-light text-lg"></i>
                    </div>
                    <span class="font-extrabold text-2xl tracking-tight text-gray-900">Masuk Akun</span>
                </div>
                <p class="text-sm text-gray-500 font-medium">Selamat datang kembali! Silakan masukkan email dan kata sandi Anda.</p>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5 ml-1">
                        Alamat Email
                    </label>
                    <div class="relative flex items-center">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <i class="fas fa-envelope text-sm"></i>
                        </div>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                            placeholder="nama@email.com"
                            class="w-full pl-10 pr-4 py-3 bg-gray-50 border @error('email') border-red-500 focus:ring-red-500 @else border-gray-200 focus:ring-orange-500 @enderror rounded-xl text-sm font-medium focus:bg-white focus:outline-none focus:ring-2 transition">
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1.5 ml-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <div class="flex justify-between items-center mb-1.5 ml-1">
                        <label for="password" class="block text-xs font-bold uppercase tracking-wider text-gray-700">
                            Kata Sandi
                        </label>
                    </div>
                    <div class="relative flex items-center">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <i class="fas fa-lock text-sm"></i>
                        </div>
                        <input type="password" id="password" name="password" required
                            placeholder="••••••••"
                            class="w-full pl-10 pr-4 py-3 bg-gray-50 border @error('password') border-red-500 focus:ring-red-500 @else border-gray-200 focus:ring-orange-500 @enderror rounded-xl text-sm font-medium focus:bg-white focus:outline-none focus:ring-2 transition">
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1.5 ml-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me Checkbox -->
                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
                            class="w-4 h-4 text-orange-600 rounded border-gray-300 focus:ring-orange-500">
                        <span class="text-gray-600 font-medium">Ingat Saya di Perangkat Ini</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full py-3.5 bg-orange-600 hover:bg-orange-700 text-white font-extrabold rounded-xl shadow-lg shadow-orange-600/30 transition transform active:scale-95 text-sm flex items-center justify-center gap-2">
                    <i class="fas fa-sign-in-alt"></i> Masuk Sekarang
                </button>
            </form>

            <div class="mt-8 text-center text-xs text-gray-600">
                Belum memiliki akun?
                <a href="{{ route('register') }}" class="font-bold text-orange-600 hover:text-orange-700 underline ml-1">
                    Daftar akun baru
                </a>
            </div>

        </div>

        <!-- Kolom Kanan: Panduan Akun Dummy untuk Dosen / Asisten -->
        <div class="w-full md:w-1/2 bg-gradient-to-br from-orange-50 via-amber-50 to-orange-100 p-8 sm:p-12 flex flex-col justify-between border-t md:border-t-0 md:border-l border-orange-100">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-orange-600 text-white rounded-full text-[11px] font-bold uppercase tracking-wider mb-4">
                    <i class="fas fa-flask"></i> Akun Pengujian Modul 6
                </span>
                <h3 class="text-xl font-extrabold text-gray-900 mb-2">Akun Demo (Hasil Seeder)</h3>
                <p class="text-xs text-gray-600 leading-relaxed mb-6">
                    Data di bawah ini di-generate secara otomatis menggunakan <strong>UserSeeder</strong> dan Faker. Password tersimpan dalam bentuk hash Bcrypt (`$2y$...`) pada database MySQL.
                </p>

                <!-- Info Box Admin -->
                <div class="bg-white p-4 rounded-2xl border border-orange-200/80 shadow-sm mb-4">
                    <div class="text-xs font-bold text-orange-600 uppercase tracking-wider mb-1 flex items-center justify-between">
                        <span><i class="fas fa-user-shield me-1"></i> Akun Admin</span>
                        <span class="text-[10px] bg-orange-100 text-orange-700 px-2 py-0.5 rounded-full font-bold">Role: admin</span>
                    </div>
                    <div class="text-xs text-gray-700 space-y-1">
                        <div><strong>Email:</strong> <code class="bg-gray-100 px-1 py-0.5 rounded text-orange-600 font-mono">admin@smarttraffic.id</code></div>
                        <div><strong>Password:</strong> <code class="bg-gray-100 px-1 py-0.5 rounded font-mono">admin123</code></div>
                    </div>
                </div>

                <!-- Info Box Dummy User -->
                <div class="bg-white p-4 rounded-2xl border border-orange-200/80 shadow-sm">
                    <div class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-1 flex items-center justify-between">
                        <span><i class="fas fa-users me-1"></i> Akun Pengguna Dummy (5 Akun)</span>
                        <span class="text-[10px] bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full font-bold">Role: user</span>
                    </div>
                    <div class="text-xs text-gray-700 space-y-1">
                        <div><strong>Email:</strong> <code class="bg-gray-100 px-1 py-0.5 rounded text-orange-600 font-mono">user1@smarttraffic.id</code> (s/d <code class="bg-gray-100 px-1 py-0.5 rounded font-mono">user5@smarttraffic.id</code>)</div>
                        <div><strong>Password:</strong> <code class="bg-gray-100 px-1 py-0.5 rounded font-mono">password123</code></div>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-orange-200/60 text-[11px] text-gray-500">
                <i class="fas fa-info-circle text-orange-600 me-1"></i> Anda juga dapat mendaftar dengan akun baru melalui tombol <strong>Daftar Akun Baru</strong>.
            </div>
        </div>

    </div>
</div>
@endsection
