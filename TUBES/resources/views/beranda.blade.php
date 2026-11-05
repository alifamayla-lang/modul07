@extends('layouts.app')

@section('title', 'Beranda Utama')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

    <!-- Welcome Greeting Header Mobile & Desktop -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Beranda Pemantauan</h1>
            <p class="text-xs sm:text-sm text-gray-500 font-medium">
                Selamat bertugas / memantau lalu lintas, <span class="text-orange-600 font-bold">{{ $user->name }}</span>!
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('laporan.create') }}" class="px-4 py-2.5 bg-orange-600 hover:bg-orange-700 text-white text-xs sm:text-sm font-bold rounded-xl shadow-md shadow-orange-500/20 transition flex items-center gap-2">
                <i class="fas fa-plus-circle"></i> Buat Laporan Baru
            </a>
            <a href="{{ route('profile') }}" class="px-4 py-2.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-xs sm:text-sm font-semibold rounded-xl shadow-sm transition flex items-center gap-1.5">
                <i class="fas fa-user-circle text-orange-600"></i> Profil Saya
            </a>
        </div>
    </div>

    <!-- Status Kota Saat Ini Banner -->
    <div class="bg-gradient-to-r from-orange-600 via-orange-500 to-amber-500 rounded-3xl p-6 sm:p-8 text-white shadow-xl shadow-orange-500/20 mb-8 relative overflow-hidden">
        <div class="relative z-10 max-w-xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-[11px] font-bold uppercase tracking-wider mb-3">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span> Live CCTV & Community Feed
            </div>
            <h2 class="text-2xl sm:text-3xl font-extrabold mb-2 tracking-tight">
                Status Kota Bandung: Ramai Lancar 🚗💨
            </h2>
            <p class="text-xs sm:text-sm text-orange-100 font-medium leading-relaxed">
                Kecepatan rata-rata kendaraan 38–45 km/jam. Titik perlambatan terpantau di kawasan simpang Jl. Buah Batu dan Dago Bawah. Tetap waspada dan patuhi marka jalan!
            </p>
        </div>
        <div class="absolute -right-8 -bottom-8 opacity-15 hidden sm:block pointer-events-none">
            <i class="fas fa-car-side text-[200px]"></i>
        </div>
    </div>

    <!-- Section Heading -->
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg sm:text-xl font-extrabold text-gray-900 uppercase tracking-wider flex items-center gap-3">
            <span>Insiden & Kondisi Terkini</span>
            <span class="text-xs font-bold bg-orange-100 text-orange-700 px-2.5 py-0.5 rounded-full lowercase">{{ $totalLaporan }} laporan</span>
        </h3>
        <div class="hidden sm:block flex-1 ml-6 h-px bg-gray-200"></div>
    </div>

    <!-- Feed Daftar Insiden -->
    <div class="space-y-4">
        @forelse($laporans as $lap)
            <div class="bg-white p-4 sm:p-5 rounded-2xl shadow-sm border border-gray-200 hover:border-orange-200 hover:shadow-md transition flex flex-col lg:flex-row gap-4 lg:gap-6 items-start lg:items-center">
                
                <!-- Foto Insiden -->
                <div class="w-full lg:w-[240px] h-[160px] lg:h-[120px] rounded-xl overflow-hidden border border-gray-100 flex-shrink-0 bg-gray-50">
                    <img src="{{ $lap->foto_url }}" alt="{{ $lap->lokasi }}" class="w-full h-full object-cover">
                </div>

                <!-- Bagian Konten Tengah -->
                <div class="flex flex-1 w-full gap-4 items-start">
                    <!-- Badge Tanggal -->
                    <div class="flex-shrink-0 w-14 h-14 sm:w-16 sm:h-16 bg-red-50 rounded-xl flex flex-col items-center justify-center border border-red-100">
                        <span class="text-xl sm:text-2xl font-extrabold text-red-600 leading-none mb-0.5">{{ $lap->tanggal }}</span>
                        <span class="text-[10px] sm:text-xs font-bold text-red-500 uppercase tracking-widest">{{ $lap->bulan }}</span>
                    </div>

                    <!-- Teks Informasi -->
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2 mb-1">
                            <h4 class="text-base sm:text-lg font-bold text-gray-900 truncate tracking-tight">{{ $lap->lokasi }}</h4>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $lap->tingkat_kemacetan > 50 ? 'bg-red-100 text-red-700' : 'bg-emerald-100 text-emerald-700' }}">
                                Macet {{ $lap->tingkat_kemacetan }}%
                            </span>
                        </div>
                        <p class="text-xs text-orange-600 font-semibold mb-1">
                            <i class="fas fa-user-circle me-1"></i> Pelapor: {{ $lap->nama_pelapor }}
                        </p>
                        <p class="text-xs sm:text-sm text-gray-600 line-clamp-2 leading-relaxed">
                            {{ $lap->deskripsi }}
                        </p>
                    </div>
                </div>

                <!-- Kolom Aksi Kanan -->
                <div class="w-full lg:w-auto flex flex-row lg:flex-col justify-between items-center lg:items-end gap-3 lg:pl-6 lg:border-l border-gray-100 pt-2 lg:pt-0">
                    <span class="text-xs font-medium text-gray-400 whitespace-nowrap">
                        <i class="far fa-clock me-1"></i> {{ $lap->waktu_berlalu }}
                    </span>

                    <div class="flex gap-2 w-full lg:w-auto">
                        <a href="{{ route('laporan.show', $lap->id) }}" class="flex-1 lg:flex-none flex items-center justify-center gap-1.5 px-4 py-2 text-xs font-bold text-orange-600 bg-orange-50 border border-orange-200 rounded-xl hover:bg-orange-100 transition shadow-sm">
                            <i class="fas fa-info-circle"></i> Detail
                        </a>
                        <button type="button" onclick="navigator.clipboard.writeText('{{ url('/laporan/'.$lap->id) }}'); alert('Link laporan telah disalin ke clipboard!');" class="flex-1 lg:flex-none flex items-center justify-center gap-1.5 px-3 py-2 text-xs font-bold text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition shadow-sm">
                            <i class="fas fa-share-alt"></i> Bagikan
                        </button>
                    </div>
                </div>

            </div>
        @empty
            <div class="text-center py-16 px-6 bg-white rounded-3xl border border-dashed border-gray-300">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400 text-2xl">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3 class="text-base font-bold text-gray-800 mb-1">Belum Ada Laporan Insiden</h3>
                <p class="text-xs text-gray-500 max-w-sm mx-auto mb-4">Kondisi jalanan aman terkendali. Jadilah yang pertama melaporkan kejadian lalu lintas.</p>
                <a href="{{ route('laporan.create') }}" class="px-4 py-2 bg-orange-600 text-white rounded-xl text-xs font-bold">
                    + Buat Laporan Pertama
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $laporans->links() }}
    </div>

</div>
@endsection
