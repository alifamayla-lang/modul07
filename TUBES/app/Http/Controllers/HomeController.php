<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Halaman landing page publik.
     */
    public function welcome()
    {
        $totalLaporan = Laporan::count();
        $laporanTerbaru = Laporan::orderByDesc('waktu_laporan')->take(3)->get();
        return view('welcome', compact('totalLaporan', 'laporanTerbaru'));
    }

    /**
     * Halaman Dashboard / Beranda utama aplikasi (Wajib Login).
     */
    public function beranda()
    {
        $user = Auth::user();
        $laporans = Laporan::orderByDesc('waktu_laporan')->paginate(10);
        $totalLaporan = Laporan::count();
        $laporanVerified = Laporan::where('status_verifikasi', 'verified')->count();

        return view('beranda', compact('user', 'laporans', 'totalLaporan', 'laporanVerified'));
    }
}
