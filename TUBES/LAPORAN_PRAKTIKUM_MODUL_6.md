# LAPORAN PRAKTIKUM PEMROGRAMAN BERBASIS WEB
## MODUL 6: GENERATE DATA OTOMATIS & AUTHENTICATION PADA LARAVEL

---

### 1. HALAMAN SAMPUL (COVER)
- **Judul Praktikum:** Penerapan Fitur Authentication Manual dan Otomatisasi Data Menggunakan Database Seeder & Faker pada Proyek Tugas Akhir (*Smart Traffic Finder*)
- **Mata Kuliah:** Pemrograman Berbasis Web (PABW)
- **Program Studi:** S1 Informatika / Sistem Informasi / Rekayasa Perangkat Lunak
- **Tahun Akademik:** 2026/2027 (Semester Genap)
- **Identitas Mahasiswa:**
  - **Nama Mahasiswa:** [Nama Saudara]
  - **NIM:** [NIM Saudara]
  - **Kelas:** [Kelas Saudara]
  - **Dosen Pengampu:** [Nama Dosen Pengampu]

---

### 2. TUJUAN PRAKTIKUM
Praktikum ini memiliki beberapa tujuan utama:
1. Memahami arsitektur dan mekanisme otentikasi pengguna pada framework Laravel, mulai dari penanganan request form, proses hashing password satu arah, hingga manajemen sesi.
2. Mampu membangun sistem autentikasi lengkap (Register, Login, Remember Me, dan Logout) secara mandiri (manual) tanpa bergantung pada starter kit otomatis seperti Laravel Breeze.
3. Mampu membatasi dan melindungi hak akses halaman-halaman fungsional aplikasi web Tugas Akhir (*Smart Traffic Finder*) menggunakan *Route Middleware* `auth`.
4. Mengimplementasikan otomasi pengisian data akun uji coba (*dummy accounts*) secara massal ke dalam database MySQL menggunakan fasilitas *Database Seeder* dan pustaka *Faker* dengan lokal Indonesia (`id_ID`).
5. Memastikan aspek keamanan basis data dengan memvalidasi bahwa seluruh kata sandi pengguna tersimpan dalam bentuk enkripsi hash algoritma Bcrypt pada tabel `users`.

---

### 3. ALAT DAN BAHAN
Berikut adalah spesifikasi perangkat keras dan lunak yang digunakan selama pengerjaan praktikum:

#### A. Perangkat Keras (Hardware)
- **Komputer/Laptop:** Windows 10/11 64-bit
- **Processor:** Minimal Multi-core 1.0 GHz (Direkomendasikan Intel Core i5 / AMD Ryzen 5)
- **Memori RAM:** 8.00 GB
- **Penyimpanan:** SSD dengan ruang kosong > 10 GB

#### B. Perangkat Lunak (Software)
- **Server Lokal & Database:** XAMPP v8.2.12 (Apache Web Server & MariaDB/MySQL 10.4)
- **Database Management Tool:** phpMyAdmin 5.2
- **Bahasa Pemrograman:** PHP versi 8.2.12
- **Dependency Manager:** Composer versi 2.10.3
- **Web Framework:** Laravel Framework versi 12.69.3
- **UI Framework & Icon:** Tailwind CSS (CDN) & Font Awesome v6.4.0
- **Code Editor:** Visual Studio Code / Antigravity IDE
- **Web Browser:** Google Chrome / Mozilla Firefox

---

### 4. LANGKAH-LANGKAH PRAKTIKUM

#### Langkah 1: Konfigurasi Basis Data (`.env`)
Memastikan konfigurasi koneksi basis data pada file `.env` telah mengarah ke server MySQL lokal dan menggunakan nama database Tugas Akhir:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smarttraffic_finder
DB_USERNAME=root
DB_PASSWORD=
```

#### Langkah 2: Pembuatan Migration Tabel Pengguna (`users`)
Laravel telah menyediakan migration standar untuk autentikasi. File migration disesuaikan agar memiliki atribut profil tambahan seperti nomor telepon, wilayah/domisili, dan role:
```php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->string('telepon', 30)->default('-')->nullable();
    $table->string('lokasi', 100)->default('Bandung, Jawa Barat')->nullable();
    $table->string('status_pengguna', 100)->default('Pengguna Aktif')->nullable();
    $table->enum('role', ['user', 'admin'])->default('user');
    $table->rememberToken();
    $table->timestamps();
});
```
Perintah migrasi dijalankan melalui terminal:
```bash
php artisan migrate
```

#### Langkah 3: Pembuatan Controller Pendaftaran Akun (`RegisterController.php`)
Membuat controller pada folder `app/Http/Controllers/Auth/RegisterController.php` untuk menangani formulir pendaftaran:
```php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Password di-hash
            'telepon' => $request->telepon ?: '-',
            'lokasi' => $request->lokasi ?: 'Bandung, Jawa Barat',
            'status_pengguna' => 'Pengguna Aktif',
            'role' => 'user',
        ]);

        Auth::login($user); // Otomatis login setelah pendaftaran

        return redirect()->route('beranda')->with('success', 'Akun berhasil didaftarkan!');
    }
}
```
*Penjelasan:* Aturan `'confirmed'` pada password mewajibkan input konfirmasi bernama `password_confirmation`. Method `Hash::make()` mengubah teks sandi menjadi hash Bcrypt.

#### Langkah 4: Pembuatan Controller Masuk & Keluar (`LoginController.php`)
Membuat controller `app/Http/Controllers/Auth/LoginController.php` yang mengatur verifikasi kredensial dan penghapusan sesi:
```php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate(); // Mencegah session fixation
            return redirect()->intended(route('beranda'))->with('success', 'Berhasil masuk!');
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah berhasil logout.');
    }
}
```
*Penjelasan:* `Auth::attempt()` secara otomatis mencari user berdasarkan email lalu mencocokkan password menggunakan `Hash::check()`. `$request->session()->regenerate()` menjamin keamanan ID sesi baru setelah pengguna berhasil terautentikasi.

#### Langkah 5: Pengaturan Routing dan Proteksi Middleware (`routes/web.php`)
Mendaftarkan rute publik dan mengelompokkan rute privat yang wajib login:
```php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;

// Rute Publik
Route::get('/', [HomeController::class, 'welcome'])->name('welcome');

// Rute Tamu (Guest Only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});

// Rute Terproteksi (Wajib Login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/beranda', [HomeController::class, 'beranda'])->name('beranda');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/create', [LaporanController::class, 'create'])->name('laporan.create');
    Route::post('/laporan', [LaporanController::class, 'store'])->name('laporan.store');
    Route::get('/laporan/{id}', [LaporanController::class, 'show'])->name('laporan.show');
    Route::get('/chat', [ChatController::class, 'index'])->name('chat');
    Route::post('/chat', [ChatController::class, 'store'])->name('chat.store');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
```

#### Langkah 6: Pembuatan Seeder Akun Dummy dengan Faker (`UserSeeder.php`)
Membuat file `database/seeders/UserSeeder.php` dengan memanfaatkan pustaka Faker lokal Indonesia:
```php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // 1 Akun Administrator Manual
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@smarttraffic.id'],
            [
                'name' => 'Administrator Smart Traffic',
                'password' => Hash::make('admin123'),
                'telepon' => '081234567890',
                'lokasi' => 'Command Center Dishub Bandung',
                'status_pengguna' => 'Super Admin',
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // 5 Akun Dummy Pengguna Menggunakan Faker
        for ($i = 1; $i <= 5; $i++) {
            DB::table('users')->updateOrInsert(
                ['email' => "user{$i}@smarttraffic.id"],
                [
                    'name' => $faker->name,
                    'password' => Hash::make('password123'),
                    'telepon' => $faker->phoneNumber,
                    'lokasi' => $faker->randomElement(['Buah Batu, Bandung', 'Dago, Bandung', 'Cibiru, Bandung']),
                    'status_pengguna' => 'Pengguna Aktif',
                    'role' => 'user',
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
```
Seeder kemudian didaftarkan pada `DatabaseSeeder.php` dan dijalankan dengan perintah:
```bash
php artisan db:seed
```

---

### 5. HASIL DAN DOKUMENTASI PROGRAM

| No | Komponen Pengujian | Deskripsi Hasil & Bukti Fungsionalitas | Status |
| :-: | :--- | :--- | :---: |
| 1 | **Halaman Registrasi (`/register`)** | Formulir memvalidasi input nama, email unik, dan konfirmasi kata sandi. Jika ada input yang kosong atau password tidak cocok, pesan galat spesifik tampil di bawah kolom input (`@error`). Jika berhasil, akun langsung terdaftar dan pengguna masuk ke Beranda. | **Berhasil** |
| 2 | **Halaman Login (`/login`)** | Menyediakan kolom email, password, dan checkbox Remember Me. Kredensial akun uji coba admin dan dummy dipasang sebagai panduan penguji. | **Berhasil** |
| 3 | **Penanganan Kesalahan Login** | Saat memasukkan kata sandi yang keliru atau email yang tidak terdaftar, sistem tidak meloloskan sesi dan mengembalikan pesan: *"Email atau kata sandi yang Anda masukkan salah."* | **Berhasil** |
| 4 | **Pengujian Proteksi Middleware `auth`** | Ketika pengguna belum login mengakses URL langsung seperti `http://127.0.0.1:8000/beranda` atau `/profile`, sistem otomatis menolak akses dan mengarahkan (*redirect*) ke rute `/login`. | **Berhasil** |
| 5 | **Halaman Beranda & Profil Setelah Login** | Menampilkan identitas pengguna yang aktif (`Auth::user()->name`, avatar inisial, email, wilayah, role, dan tanggal pendaftaran akun dalam format waktu mudah terbaca `created_at->diffForHumans()`). | **Berhasil** |
| 6 | **Proses Logout Aman (`POST /logout`)** | Tombol keluar dieksekusi melalui form bertipe POST dengan token CSRF. Sesi pengguna dihancurkan di server dan diarahkan kembali ke landing page publik. | **Berhasil** |
| 7 | **Tabel `users` pada phpMyAdmin** | Data 6 akun hasil seeder tersimpan di MySQL database `smarttraffic_finder`. Seluruh nilai kolom `password` berupa string hash acak panjang 60 karakter berawalan `$2y$12$...`, tidak ada teks polos. | **Berhasil** |

---

### 6. ANALISIS DAN PEMBAHASAN

#### A. Perbedaan Aplikasi Sebelum dan Sesudah Menggunakan Authentication
- **Sebelum (Modul 4):** Aplikasi bersifat terbuka tanpa kontrol identitas. Setiap pengunjung dapat langsung melihat, mengubah, atau mengirim data laporan. Kata sandi pada modul awal bahkan masih tersimpan dalam format teks asli (*plain text*), yang sangat rentan terhadap pencurian identitas apabila basis data diekstrak secara ilegal.
- **Sesudah (Modul 6):** Akses dibatasi secara tegas antara tamu (*guest*) dan pengguna terverifikasi (*authenticated user*). Pengguna memiliki identitas tunggal, setiap aksi pelaporan tercatat atas nama akun yang bersangkutan, dan kata sandi dienkripsi secara irreversibel.

#### B. Perbandingan Laravel Breeze vs Autentikasi Manual
- **Laravel Breeze:** Keunggulannya adalah kecepatan instalasi karena seluruh view, route, dan controller digenerate otomatis. Namun kekurangannya, Breeze menimpa file `routes/web.php`, mengganti layout bawaan proyek, serta sangat bergantung pada Node.js/Vite (`npm run dev`) yang kerap memunculkan error *"Vite manifest not found"* di lingkungan pengujian lokal tanpa kompilasi frontend aktif.
- **Autentikasi Manual (Dipilih):** Membutuhkan penulisan kode controller dan rute secara manual, namun memberikan fleksibilitas 100% terhadap desain antarmuka *Smart Traffic Finder*, menghilangkan dependensi runtime Node.js/Vite, serta memperdalam pemahaman mahasiswa mengenai siklus hidup permintaan (*request life-cycle*) autentikasi Laravel.

#### C. Peran Session, Password Hashing, dan Middleware Auth
- **Session:** Protokol HTTP bersifat *stateless* (tidak mengingat interaksi sebelumnya). Session hadir sebagai mekanisme sisi server untuk menyimpan pengenal pengguna yang telah lolos verifikasi, sehingga pengguna tetap dikenali saat berpindah halaman tanpa harus login berulang kali.
- **Password Hashing:** Menggunakan fungsi hash kriptografi Bcrypt yang bersifat satu arah (*one-way*). Meskipun nilai hash diketahui oleh pihak luar atau administrator basis data, nilai teks asli kata sandi tidak dapat didekripsi balik (*irreversible*).
- **Middleware Auth:** Bertindak sebagai lapisan penyaring di tingkat perutean HTTP (*HTTP Middleware*). Setiap kali suatu permintaan menuju rute tertutup diproses, middleware mengevaluasi `Auth::check()`. Jika tidak valid, alur dibelokkan ke rute login yang ditentukan.

#### D. Kendala yang Ditemui dan Solusinya
1. **Galat `419 Page Expired`:**
   - *Penyebab:* Form HTML dikirim tanpa menyertakan token keamanan Cross-Site Request Forgery (CSRF).
   - *Solusi:* Menambahkan directive Blade `@csrf` di dalam setiap elemen `<form method="POST">`.
2. **Galat `Route [login] not defined`:**
   - *Penyebab:* Middleware auth bawaan Laravel secara baku mencari rute bernama `login` saat me-redirect tamu.
   - *Solusi:* Memastikan rute formulir login diberi penamaan yang tepat: `Route::get('/login', [...])->name('login');`.
3. **Pencegahan Session Fixation:**
   - *Solusi:* Memanggil method `$request->session()->regenerate()` tepat setelah `Auth::attempt()` berhasil.

---

### 7. KESIMPULAN
Berdasarkan praktikum Modul 6, implementasi autentikasi manual pada proyek Tugas Akhir *Smart Traffic Finder* telah berhasil diselesaikan dengan baik sesuai ketentuan praktikum. Sistem berhasil menyediakan fitur registrasi, login, remember me, dan logout yang dilengkapi validasi ketat serta pesan galat yang ramah pengguna. Pembatasan hak akses halaman melalui middleware `auth` terbukti andal dalam melindungi data laporan dan profil pengguna. Selain itu, otomatisasi data menggunakan *Database Seeder* dan pustaka *Faker* berhasil membentuk data pengguna dummy secara realistis dengan seluruh kata sandi tersimpan aman dalam format hash Bcrypt pada tabel `users`.

---

### 8. DAFTAR KREDENSIAL AKUN UJI COBA
1. **Akun Administrator:**
   - Email: `admin@smarttraffic.id`
   - Kata Sandi: `admin123`
   - Role: `admin`
2. **Akun Pengguna Dummy (Faker `id_ID`):**
   - Email: `user1@smarttraffic.id` s/d `user5@smarttraffic.id`
   - Kata Sandi: `password123`
   - Role: `user`
