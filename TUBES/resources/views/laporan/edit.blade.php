@extends('layouts.app')

@section('title', 'Edit Laporan Insiden #' . $laporan->id)

@section('content')
<div class="max-w-2xl mx-auto px-4 py-6 sm:py-10">

    <div class="mb-4">
        <a href="{{ route('laporan.show', $laporan->id) }}" class="text-xs font-bold text-orange-600 hover:text-orange-700 flex items-center gap-1.5">
            <i class="fas fa-arrow-left"></i> Kembali ke Detail Laporan
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-6 sm:p-10">
        
        <div class="mb-8 border-b border-gray-100 pb-5">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center shadow-md shadow-amber-500/20">
                    <i class="fas fa-edit text-lg"></i>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl font-extrabold text-gray-900">Ubah Data Laporan Insiden</h1>
                    <p class="text-xs text-gray-500">Memperbarui informasi kemacetan atau mengganti berkas foto bukti kejadian (ID #{{ $laporan->id }}).</p>
                </div>
            </div>
        </div>

        <form action="{{ route('laporan.update', $laporan->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Pelapor -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5 ml-1">
                    Pelapor Asli
                </label>
                <div class="flex items-center bg-gray-100 border border-gray-200 rounded-xl px-4 py-3 gap-3 text-gray-500 text-sm font-semibold cursor-not-allowed">
                    <i class="fas fa-user-check text-emerald-600"></i>
                    <span>{{ $laporan->nama_pelapor }}</span>
                    <span class="text-xs text-gray-400 ml-auto">Dilaporkan: {{ $laporan->waktu_laporan->translatedFormat('d M Y, H:i') }}</span>
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
                    <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi', $laporan->lokasi) }}" required
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
                    <span id="labelKemacetan" class="text-xs font-extrabold text-orange-600 bg-orange-50 px-2.5 py-0.5 rounded-full border border-orange-200">
                        {{ old('tingkat_kemacetan', $laporan->tingkat_kemacetan) }}%
                    </span>
                </div>
                <input type="range" id="tingkat_kemacetan" name="tingkat_kemacetan" min="0" max="100" value="{{ old('tingkat_kemacetan', $laporan->tingkat_kemacetan) }}"
                    oninput="updateKemacetan(this.value)"
                    class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-orange-600">
                <div class="flex justify-between text-[10px] text-gray-400 mt-1 font-semibold">
                    <span>Lancar (0%)</span>
                    <span>Padat Merayap (50%)</span>
                    <span>Lumpuh Total (100%)</span>
                </div>
            </div>

            <!-- Status Verifikasi -->
            <div>
                <label for="status_verifikasi" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5 ml-1">
                    Status Verifikasi Laporan
                </label>
                <select id="status_verifikasi" name="status_verifikasi"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                    <option value="pending" {{ old('status_verifikasi', $laporan->status_verifikasi) == 'pending' ? 'selected' : '' }}>Menunggu Verifikasi (Pending)</option>
                    <option value="verified" {{ old('status_verifikasi', $laporan->status_verifikasi) == 'verified' ? 'selected' : '' }}>Terverifikasi (Verified)</option>
                    <option value="rejected" {{ old('status_verifikasi', $laporan->status_verifikasi) == 'rejected' ? 'selected' : '' }}>Ditolak / Laporan Palsu (Rejected)</option>
                </select>
            </div>

            <!-- Deskripsi Kejadian -->
            <div>
                <label for="deskripsi" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5 ml-1">
                    Deskripsi Detail Kejadian <span class="text-red-500">*</span>
                </label>
                <textarea id="deskripsi" name="deskripsi" rows="4" required
                    placeholder="Jelaskan kondisi jalan secara lengkap..."
                    class="w-full p-4 bg-gray-50 border @error('deskripsi') border-red-500 @else border-gray-200 @enderror rounded-xl text-sm font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-500 transition">{{ old('deskripsi', $laporan->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="text-red-500 text-xs mt-1.5 ml-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Preview Foto Saat Ini & Upload Baru -->
            <div class="p-5 bg-gray-50 rounded-2xl border border-gray-200 space-y-4">
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700">
                    Berkas Foto Bukti
                </label>

                <!-- Foto Saat Ini -->
                <div class="flex items-center gap-4">
                    <div class="w-24 h-24 rounded-xl overflow-hidden border border-gray-300 bg-white flex-shrink-0 shadow-sm">
                        <img src="{{ $laporan->foto_url }}" alt="Foto Saat Ini" class="w-full h-full object-cover">
                    </div>
                    <div class="text-xs text-gray-600 space-y-1">
                        <p class="font-bold text-gray-800">Foto Saat Ini Tersimpan:</p>
                        <p class="text-[11px] font-mono text-gray-500 truncate max-w-xs bg-white px-2 py-1 rounded border border-gray-200">
                            {{ $laporan->foto ?? 'Tidak ada file fisik khusus' }}
                        </p>
                        @if($laporan->foto)
                            <a href="{{ route('laporan.download', $laporan->id) }}" target="_blank" class="inline-flex items-center gap-1 text-orange-600 hover:text-orange-700 font-bold mt-1">
                                <i class="fas fa-external-link-alt text-[10px]"></i> Buka / Unduh File Fisik
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Input Upload Pengganti -->
                <div class="pt-3 border-t border-gray-200">
                    <label for="foto" class="block text-xs font-bold text-gray-700 mb-1">
                        Ganti Foto Bukti <span class="text-gray-400 font-normal">(Kosongkan jika tidak ingin mengganti)</span>
                    </label>
                    <input type="file" id="foto" name="foto" accept="image/jpeg,image/png,image/jpg,image/webp"
                        onchange="previewNewPhoto(this)"
                        class="w-full text-xs text-gray-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer">
                    <p class="text-[11px] text-gray-400 mt-1">Format: JPG, JPEG, PNG, WEBP &mdash; Ukuran maksimal 2 MB (2048 KB)</p>
                    <div id="newPhotoBox" class="hidden mt-3 p-3 bg-emerald-50 rounded-xl border border-emerald-200 flex items-center gap-3">
                        <img id="newPhotoImg" src="" alt="Pratinjau Baru" class="w-16 h-16 rounded-lg object-cover border border-emerald-300">
                        <div class="text-xs text-emerald-800 font-semibold">
                            <p class="font-bold">Foto baru dipilih (akan menggantikan foto lama):</p>
                            <p id="newPhotoName" class="text-[11px] font-mono text-emerald-700"></p>
                        </div>
                    </div>
                    @error('foto')
                        <p class="text-red-500 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Tombol Aksi Simpan & Batal -->
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <button type="submit"
                    class="flex-1 py-3.5 bg-orange-600 hover:bg-orange-700 text-white font-extrabold rounded-xl shadow-lg shadow-orange-600/30 transition transform active:scale-95 text-sm flex items-center justify-center gap-2">
                    <i class="fas fa-save"></i> Simpan Perubahan (Update)
                </button>
                <a href="{{ route('laporan.show', $laporan->id) }}"
                    class="px-6 py-3.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl text-sm transition text-center">
                    Batal
                </a>
            </div>

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

    function previewNewPhoto(input) {
        let box = document.getElementById('newPhotoBox');
        let img = document.getElementById('newPhotoImg');
        let name = document.getElementById('newPhotoName');
        if (input.files && input.files[0]) {
            let file = input.files[0];
            name.innerText = file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
            let reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                box.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        } else {
            box.classList.add('hidden');
        }
    }
</script>
@endpush
