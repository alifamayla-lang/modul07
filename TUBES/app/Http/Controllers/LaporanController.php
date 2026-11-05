<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    /**
     * READ: Tampilkan daftar seluruh laporan dengan filter pencarian dan pagination.
     */
    public function index(Request $request)
    {
        $query = Laporan::orderByDesc('waktu_laporan');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sq) use ($q) {
                $sq->where('lokasi', 'like', "%{$q}%")
                   ->orWhere('deskripsi', 'like', "%{$q}%")
                   ->orWhere('nama_pelapor', 'like', "%{$q}%");
            });
        }

        $laporans = $query->paginate(9)->withQueryString();

        return view('laporan.index', compact('laporans'));
    }

    /**
     * CREATE: Tampilkan form pembuatan laporan baru.
     */
    public function create()
    {
        return view('laporan.create');
    }

    /**
     * CREATE: Simpan laporan baru dan berkas foto ke storage/app/public/laporan.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'lokasi' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string', 'min:10'],
            'tingkat_kemacetan' => ['nullable', 'integer', 'min:0', 'max:100'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ], [
            'lokasi.required' => 'Lokasi kejadian wajib diisi.',
            'deskripsi.required' => 'Deskripsi laporan wajib diisi.',
            'deskripsi.min' => 'Deskripsi minimal 10 karakter agar informasi jelas.',
            'foto.image' => 'Berkas yang diunggah harus berupa gambar valid.',
            'foto.mimes' => 'Format file yang diperbolehkan hanya JPG, JPEG, PNG, dan WEBP.',
            'foto.max' => 'Ukuran file foto maksimal adalah 2 MB (2048 KB).',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('laporan', 'public');
        }

        Laporan::create([
            'nama_pelapor' => Auth::user()->name,
            'lokasi' => $validated['lokasi'],
            'deskripsi' => $validated['deskripsi'],
            'tingkat_kemacetan' => $validated['tingkat_kemacetan'] ?? 30,
            'foto' => $fotoPath,
            'status_verifikasi' => 'verified',
            'waktu_laporan' => now(),
        ]);

        return redirect()->route('laporan.index')->with('success', 'Laporan insiden berhasil dikirimkan dan dipublikasikan!');
    }

    /**
     * READ: Tampilkan rincian detail laporan.
     */
    public function show(Laporan $laporan)
    {
        return view('laporan.show', compact('laporan'));
    }

    /**
     * UPDATE: Tampilkan form edit laporan.
     */
    public function edit(Laporan $laporan)
    {
        return view('laporan.edit', compact('laporan'));
    }

    /**
     * UPDATE: Simpan perubahan data laporan dan kelola penggantian file di storage.
     */
    public function update(Request $request, Laporan $laporan)
    {
        $validated = $request->validate([
            'lokasi' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string', 'min:10'],
            'tingkat_kemacetan' => ['nullable', 'integer', 'min:0', 'max:100'],
            'status_verifikasi' => ['nullable', 'in:pending,verified,rejected'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ], [
            'lokasi.required' => 'Lokasi kejadian wajib diisi.',
            'deskripsi.required' => 'Deskripsi laporan wajib diisi.',
            'deskripsi.min' => 'Deskripsi minimal 10 karakter agar informasi jelas.',
            'foto.image' => 'Berkas yang diunggah harus berupa gambar valid.',
            'foto.mimes' => 'Format file yang diperbolehkan hanya JPG, JPEG, PNG, dan WEBP.',
            'foto.max' => 'Ukuran file foto maksimal adalah 2 MB (2048 KB).',
        ]);

        $data = [
            'lokasi' => $validated['lokasi'],
            'deskripsi' => $validated['deskripsi'],
            'tingkat_kemacetan' => $validated['tingkat_kemacetan'] ?? $laporan->tingkat_kemacetan,
            'status_verifikasi' => $validated['status_verifikasi'] ?? $laporan->status_verifikasi,
        ];

        // Jika pengguna memilih file foto baru
        if ($request->hasFile('foto')) {
            // Hapus file fisik lama dari storage public jika ada
            if ($laporan->foto && !str_starts_with($laporan->foto, 'http://') && !str_starts_with($laporan->foto, 'https://')) {
                Storage::disk('public')->delete($laporan->foto);
            }

            // Simpan file baru ke folder storage/app/public/laporan
            $data['foto'] = $request->file('foto')->store('laporan', 'public');
        }

        $laporan->update($data);

        return redirect()->route('laporan.show', $laporan)->with('success', 'Laporan insiden berhasil diperbarui!');
    }

    /**
     * DELETE: Hapus data laporan dari database dan file fisik dari storage.
     */
    public function destroy(Laporan $laporan)
    {
        // Hapus file fisik dari storage public jika ada
        if ($laporan->foto && !str_starts_with($laporan->foto, 'http://') && !str_starts_with($laporan->foto, 'https://')) {
            Storage::disk('public')->delete($laporan->foto);
        }

        $laporan->delete();

        return redirect()->route('laporan.index')->with('success', 'Laporan insiden beserta file bukti berhasil dihapus!');
    }

    /**
     * DOWNLOAD: Unduh file berkas foto bukti laporan.
     */
    public function download(Laporan $laporan)
    {
        if (empty($laporan->foto)) {
            return back()->with('error', 'Laporan ini tidak memiliki lampiran berkas foto.');
        }

        if (str_starts_with($laporan->foto, 'http://') || str_starts_with($laporan->foto, 'https://')) {
            return redirect()->away($laporan->foto);
        }

        if (!Storage::disk('public')->exists($laporan->foto)) {
            return back()->with('error', 'File fisik tidak ditemukan pada server penyimpanan.');
        }

        return Storage::disk('public')->download($laporan->foto);
    }
}
