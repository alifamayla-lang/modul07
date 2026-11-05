<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    /**
     * Tampilkan formulir registrasi.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Tangani permintaan pendaftaran pengguna baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'telepon' => ['nullable', 'string', 'max:30'],
            'lokasi' => ['nullable', 'string', 'max:100'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telepon' => $request->telepon ?: '-',
            'lokasi' => $request->lokasi ?: 'Bandung, Jawa Barat',
            'status_pengguna' => 'Pengguna Aktif',
            'role' => 'user',
        ]);

        event(new Registered($user));

        // Langsung autentikasi pengguna baru
        Auth::login($user);

        return redirect()->route('beranda')->with('success', 'Akun berhasil didaftarkan! Selamat datang di Smart Traffic Finder.');
    }
}
