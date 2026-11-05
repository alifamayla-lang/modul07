@extends('layouts.app')

@section('title', 'Daftar Laporan Lalu Lintas')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Semua Laporan Insiden</h1>
            <p class="text-xs sm:text-sm text-gray-500 font-medium">Data arsip dan pantauan insiden kemacetan serta kecelakaan di jalanan.</p>
        </div>
        <a href="{{ route('laporan.create') }}" class="px-4 py-2.5 bg-orange-600 hover:bg-orange-700 text-white text-xs sm:text-sm font-bold rounded-xl shadow-md shadow-orange-500/20 transition flex items-center gap-2 self-start sm:self-auto">
            <i class="fas fa-plus"></i> Buat Laporan Baru
        </a>
    </div>

    <!-- Search Form -->
    <div class="bg-white p-4 rounded-2xl border border-gray-200 shadow-sm mb-6">
        <form action="{{ route('laporan.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                    <i class="fas fa-search text-sm"></i>
                </div>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama jalan, wilayah, deskripsi kejadian, atau pelapor..."
                    class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
            </div>
            <button type="submit" class="px-5 py-2.5 bg-gray-900 hover:bg-gray-800 text-white font-bold text-xs sm:text-sm rounded-xl transition flex items-center justify-center gap-2">
                <i class="fas fa-filter"></i> Filter Data
            </button>
            @if(request('q'))
                <a href="{{ route('laporan.index') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold text-xs sm:text-sm rounded-xl transition flex items-center justify-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Grid Kartu Laporan -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($laporans as $lap)
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition overflow-hidden flex flex-col justify-between">
                <div>
                    <div class="h-44 bg-gray-100 relative overflow-hidden">
                        <img src="{{ $lap->foto_url }}" alt="{{ $lap->lokasi }}" class="w-full h-full object-cover">
                        <div class="absolute top-3 right-3">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold shadow-sm {{ $lap->tingkat_kemacetan > 50 ? 'bg-red-500 text-white' : 'bg-emerald-500 text-white' }}">
                                Kemacetan {{ $lap->tingkat_kemacetan }}%
                            </span>
                        </div>
                    </div>
                    <div class="p-5">
                        <div class="flex items-center justify-between text-xs text-gray-400 mb-2">
                            <span><i class="fas fa-calendar-alt text-orange-500 me-1"></i> {{ $lap->waktu_laporan->translatedFormat('d M Y, H:i') }}</span>
                            <span>{{ $lap->waktu_berlalu }}</span>
                        </div>
                        <h3 class="font-extrabold text-gray-900 text-base mb-1 truncate">{{ $lap->lokasi }}</h3>
                        <p class="text-xs text-orange-600 font-semibold mb-2">Oleh: {{ $lap->nama_pelapor }}</p>
                        <p class="text-xs text-gray-600 line-clamp-3 leading-relaxed">{{ $lap->deskripsi }}</p>
                    </div>
                </div>
                <div class="p-4 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
                    <span class="text-[11px] text-gray-500 font-medium">ID #{{ $lap->id }}</span>
                    <a href="{{ route('laporan.show', $lap->id) }}" class="text-xs font-bold text-orange-600 hover:text-orange-700 flex items-center gap-1">
                        Lihat Rincian <i class="fas fa-chevron-right text-[10px]"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12 bg-white rounded-2xl border border-dashed border-gray-300">
                <i class="fas fa-folder-open text-3xl text-gray-300 mb-2"></i>
                <p class="text-sm font-semibold text-gray-600">Tidak ada laporan yang sesuai dengan kriteria.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $laporans->links() }}
    </div>

</div>
@endsection
