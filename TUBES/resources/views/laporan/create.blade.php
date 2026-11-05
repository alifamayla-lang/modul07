@extends('layouts.app')

@section('title', 'Kirim Laporan Insiden')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-6 sm:py-10">

    <div class="mb-4">
        <a href="{{ route('beranda') }}" class="text-xs font-bold text-orange-600 hover:text-orange-700 flex items-center gap-1.5">
            <i class="fas fa-arrow-left"></i> Kembali ke Beranda
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-6 sm:p-10">
        
        <div class="mb-8 border-b border-gray-100 pb-5">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-xl bg-orange-600 text-white flex items-center justify-center shadow-md shadow-orange-500/20">
                    <i class="fas fa-bullhorn text-lg"></i>
                </div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-gray-900">Laporkan Insiden / Kemacetan</h1>
            </div>
            <p class="text-xs text-gray-500">
                Informasi Anda sangat berharga bagi pengendara lain dan petugas penanganan Dishub.
            </p>
        </div>

        <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Pelapor (Otomatis dari Akun Auth) -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5 ml-1">
                    Nama Pelapor (Sesuai Akun Login)
                </label>
                <div class="flex items-center bg-gray-100 border border-gray-200 rounded-xl px-4 py-3 gap-3 text-gray-500 text-sm font-semibold cursor-not-allowed">
                    <i class="fas fa-user-check text-emerald-600"></i>
                    <span>{{ Auth::user()->name }} ({{ Auth::user()->email }})</span>
                </div>
            </div>

            <!-- Lokasi Kejadian -->
            <div>
                <label for="lokasi" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5 ml-1">
                    Lokasi / Titik Kejadian <span class="text-red-500">*</span>
                </label>
                <div class="relative flex items-center">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <i class="fas fa-map-pin text-sm"></i>
                    </div>
                    <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi') }}" required
                        placeholder="Contoh: Jl. Soekarno Hatta No. 120, dekat Simpang Kordon"
                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border @error('lokasi') border-red-500 @else border-gray-200 @enderror rounded-xl text-sm font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                </div>
                @error('lokasi')
                    <p class="text-red-500 text-xs mt-1.5 ml-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tingkat Kemacetan Slider -->
            <div>
                <div class="flex justify-between items-center mb-1.5 ml-1">
                    <label for="tingkat_kemacetan" class="block text-xs font-bold uppercase tracking-wider text-gray-700">
                        Perkiraan Tingkat Kemacetan (%)
                    </label>
                    <span id="labelKemacetan" class="text-xs font-extrabold text-orange-600 bg-orange-50 px-2.5 py-0.5 rounded-full border border-orange-200">50% Sedang</span>
                </div>
                <input type="range" id="tingkat_kemacetan" name="tingkat_kemacetan" min="0" max="100" value="{{ old('tingkat_kemacetan', 50) }}"
                    oninput="updateKemacetan(this.value)"
                    class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-orange-600">
                <div class="flex justify-between text-[10px] text-gray-400 mt-1 font-semibold">
                    <span>Lancar (0%)</span>
                    <span>Padat Merayap (50%)</span>
                    <span>Lumpuh Total (100%)</span>
                </div>
            </div>

            <!-- Deskripsi Kejadian -->
            <div>
                <label for="deskripsi" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5 ml-1">
                    Deskripsi Detail Kejadian <span class="text-red-500">*</span>
                </label>
                <textarea id="deskripsi" name="deskripsi" rows="4" required
                    placeholder="Jelaskan kondisi jalan, penyebab kemacetan (kecelakaan, pohon tumbang, genangan air, perbaikan jalan, dsb)..."
                    class="w-full p-4 bg-gray-50 border @error('deskripsi') border-red-500 @else border-gray-200 @enderror rounded-xl text-sm font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-500 transition">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="text-red-500 text-xs mt-1.5 ml-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Upload Foto Bukti -->
            <div>
                <label for="foto" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5 ml-1">
                    Foto Bukti Kejadian (Opsional)
                </label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-200 border-dashed rounded-2xl hover:border-orange-400 transition bg-gray-50">
                    <div class="space-y-1 text-center">
                        <i class="fas fa-camera text-2xl text-gray-400 mb-1"></i>
                        <div class="flex text-xs text-gray-600 justify-center">
                            <label for="foto" class="relative cursor-pointer bg-transparent rounded-md font-bold text-orange-600 hover:text-orange-500">
                                <span>Pilih file foto</span>
                                <input id="foto" name="foto" type="file" accept="image/*" class="sr-only" onchange="previewFileName(this)">
                            </label>
                            <p class="pl-1">atau tarik ke sini</p>
                        </div>
                        <p class="text-[10px] text-gray-400">PNG, JPG, WEBP hingga 4MB</p>
                        <p id="fileNamePreview" class="text-xs font-bold text-emerald-600 mt-2 hidden"></p>
                    </div>
                </div>
                @error('foto')
                    <p class="text-red-500 text-xs mt-1.5 ml-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full py-4 bg-orange-600 hover:bg-orange-700 text-white font-extrabold rounded-xl shadow-lg shadow-orange-600/30 transition transform active:scale-95 text-sm flex items-center justify-center gap-2">
                <i class="fas fa-paper-plane"></i> Publikasikan Laporan
            </button>
        </form>

    </div>
</div>
@endsection

@push('scripts')
<script>
    function updateKemacetan(val) {
        let label = document.getElementById('labelKemacetan');
        let status = 'Lancar';
        if (val > 70) status = 'Macet Parah';
        else if (val > 40) status = 'Padat';
        label.innerText = val + '% (' + status + ')';
    }

    function previewFileName(input) {
        let preview = document.getElementById('fileNamePreview');
        if (input.files && input.files[0]) {
            preview.innerText = 'Foto terpilih: ' + input.files[0].name;
            preview.classList.remove('hidden');
        }
    }
</script>
@endpush
