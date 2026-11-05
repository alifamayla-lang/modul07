<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil pengguna yang sedang login.
     */
    public function show()
    {
        $user = Auth::user();
        $totalLaporanUser = Laporan::where('nama_pelapor', $user->name)->count();
        $laporanUser = Laporan::where('nama_pelapor', $user->name)->orderByDesc('waktu_laporan')->take(5)->get();

        return view('profile', compact('user', 'totalLaporanUser', 'laporanUser'));
    }

    /**
     * Update profil pengguna.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'telepon' => ['nullable', 'string', 'max:30'],
            'lokasi' => ['nullable', 'string', 'max:100'],
        ]);

        $user->update($validated);

        return back()->with('success', 'Profil Anda berhasil diperbarui.');
    }
}
