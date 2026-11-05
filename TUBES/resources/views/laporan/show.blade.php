@extends('layouts.app')

@section('title', 'Detail Insiden #' . $laporan->id)

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6 sm:py-10">

    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('beranda') }}" class="p-2.5 bg-white shadow-sm border border-gray-200 text-gray-700 hover:text-orange-600 hover:bg-orange-50 rounded-full transition-all active:scale-95">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-lg sm:text-xl font-extrabold text-gray-900 tracking-tight">Detail Insiden Lalu Lintas</h1>
        <div class="w-10"></div>
    </div>

    <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
        
        <!-- Foto Besar -->
        <div class="w-full h-[260px] sm:h-[380px] bg-gray-100 relative">
            <img src="{{ $laporan->foto_url }}" alt="Foto Kejadian" class="w-full h-full object-cover">
            <div class="absolute bottom-0 left-0 w-full h-1/3 bg-gradient-to-t from-black/70 to-transparent"></div>
            <div class="absolute bottom-4 left-6 text-white">
                <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $laporan->tingkat_kemacetan > 50 ? 'bg-red-600' : 'bg-emerald-600' }}">
                    Kemacetan: {{ $laporan->tingkat_kemacetan }}%
                </span>
            </div>
        </div>

        <div class="p-6 sm:p-8">
            
            <!-- Info Pelapor & Waktu -->
            <div class="flex flex-wrap items-center justify-between gap-4 pb-6 border-b border-gray-100 mb-6">
                <div class="flex items-center space-x-3">
                    <div class="w-11 h-11 rounded-full bg-orange-600 text-white font-extrabold flex items-center justify-center text-sm shadow-sm">
                        {{ strtoupper(substr($laporan->nama_pelapor, 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-900">{{ $laporan->nama_pelapor }}</h4>
                        <p class="text-xs text-gray-500">Warga Pelapor Terverifikasi</p>
                    </div>
                </div>

                <div class="text-right">
                    <div class="text-xs font-bold text-gray-800">
                        <i class="fas fa-calendar-day text-orange-600 me-1"></i> {{ $laporan->waktu_laporan->translatedFormat('d F Y') }}
                    </div>
                    <div class="text-[11px] text-gray-500 font-medium">
                        <i class="far fa-clock me-1"></i> Pukul {{ $laporan->waktu_laporan->format('H:i') }} WIB ({{ $laporan->waktu_berlalu }})
                    </div>
                </div>
            </div>

            <!-- Lokasi & Detail Teks -->
            <div class="mb-6">
                <span class="text-[11px] font-bold text-orange-600 uppercase tracking-wider block mb-1">
                    <i class="fas fa-map-marker-alt me-1"></i> Lokasi Kejadian
                </span>
                <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 mb-4">{{ $laporan->lokasi }}</h2>

                <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block mb-1">
                    <i class="fas fa-align-left me-1"></i> Deskripsi Insiden
                </span>
                <div class="text-sm text-gray-700 leading-relaxed bg-gray-50 p-4 sm:p-5 rounded-2xl border border-gray-100">
                    {{ $laporan->deskripsi }}
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex flex-wrap gap-3 pt-4 border-t border-gray-100">
                <button type="button" onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan detail insiden telah disalin ke papan klip!');"
                    class="px-5 py-2.5 bg-orange-600 hover:bg-orange-700 text-white text-xs font-bold rounded-xl shadow-md transition flex items-center gap-2">
                    <i class="fas fa-share-alt"></i> Bagikan Laporan Ini
                </button>
                <a href="{{ route('chat') }}" class="px-5 py-2.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-xs font-semibold rounded-xl transition flex items-center gap-2">
                    <i class="fas fa-comments text-orange-600"></i> Diskusikan di Forum Chat
                </a>
            </div>

        </div>

    </div>

</div>
@endsection
