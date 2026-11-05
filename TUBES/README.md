# SMART TRAFFIC FINDER (TUGAS AKHIR PEMROGRAMAN BERBASIS WEB)
## Implementasi Modul 6: Generate Data Otomatis & Authentication (Laravel)

Proyek ini adalah implementasi lengkap Tugas Akhir Pemrograman Web Semester 2 (**Smart Traffic Finder**) yang telah dimigrasikan dan dikembangkan menggunakan framework **Laravel 12**, dilengkapi dengan sistem **Authentication Manual** (subbab 6.4.10) sesuai ketentuan praktikum **Modul 6**.

---

## 1. Ringkasan Fitur & Ketentuan Modul 6

| Ketentuan Modul 6 | Implementasi pada Proyek | Status |
| :--- | :--- | :---: |
| **Metode Authentication** | Manual Authentication (tanpa starter kit Breeze) melalui `Auth\RegisterController` dan `Auth\LoginController`. | ✅ Selesai |
| **Fitur Autentikasi** | Register, Login, Remember Me, Logout (method POST dengan CSRF protection), validasi input lengkap, dan pesan galat/error yang jelas. | ✅ Selesai |
| **Proteksi Halaman (Middleware `auth`)** | Halaman `/beranda` (Dashboard), `/laporan`, `/laporan/create`, `/laporan/{id}`, `/chat`, dan `/profile` dilindungi middleware `auth`. Tamu (guest) otomatis di-redirect ke `/login`. | ✅ Selesai |
| **Seeder & Faker** | `UserSeeder.php` menggunakan Faker `id_ID` untuk membuat 5 akun pengguna dummy + 1 akun administrator. Didaftarkan di `DatabaseSeeder.php`. | ✅ Selesai |
| **Password Hashing** | Seluruh kata sandi di-hash menggunakan algoritma **Bcrypt** (`Hash::make()`) dengan prefix `$2y$12$...` dan diverifikasi dengan `Auth::attempt()`. | ✅ Selesai |

---

## 2. Kredensial Pengujian Akun (Tabel `users`)

| No | Tipe Akun | Nama Pengguna | Alamat Email | Kata Sandi (Plain) | Status Password di DB |
| :-: | :--- | :--- | :--- | :--- | :--- |
| 1 | **Admin** | Administrator Smart Traffic | `admin@smarttraffic.id` | `admin123` | Bcrypt Hash (`$2y$12$...`) |
| 2 | **User 1** | Victoria Melani | `user1@smarttraffic.id` | `password123` | Bcrypt Hash (`$2y$12$...`) |
| 3 | **User 2** | Ratih Mandasari S.E. | `user2@smarttraffic.id` | `password123` | Bcrypt Hash (`$2y$12$...`) |
| 4 | **User 3** | Siska Wastuti M.TI. | `user3@smarttraffic.id` | `password123` | Bcrypt Hash (`$2y$12$...`) |
| 5 | **User 4** | Ira Andriani | `user4@smarttraffic.id` | `password123` | Bcrypt Hash (`$2y$12$...`) |
| 6 | **User 5** | Aisyah Ellis Susanti S.Gz | `user5@smarttraffic.id` | `password123` | Bcrypt Hash (`$2y$12$...`) |

> [!TIP]
> Anda juga dapat membuat akun baru sendiri kapan saja melalui halaman **Register** (`/register`).

---

## 3. Cara Menjalankan Aplikasi

### Persyaratan:
1. Pastikan Apache & MySQL pada **XAMPP** dalam keadaan **Running**.
2. Database bernama `smarttraffic_finder` telah dibuat di MySQL.

### Langkah Menjalankan:
Buka Terminal / Command Prompt pada direktori project ini (`c:\Users\User\Desktop\PABW\TUBES`), lalu jalankan:

```bash
# 1. Jalankan migrasi dan seeder database
php artisan migrate --seed

# 2. Jalankan server Laravel lokal
php artisan serve
```

Akses aplikasi di browser melalui: **`http://127.0.0.1:8000`**

*(Alternatif: Jika diakses melalui XAMPP htdocs, file `index.php` dan `.htaccess` di root direktori telah dikonfigurasi untuk secara otomatis mengarahkan ke folder `public/` Laravel).*

---

## 4. Alasan Pemilihan Autentikasi Manual (Jawaban Tugas Praktikum No. 2)

Dalam pengerjaan Modul 6 ini, dipilihlah pembuatan **Authentication secara Manual** (mengikuti subbab 6.4.10) dengan alasan sebagai berikut:

1. **Fleksibilitas UI/UX dan Keselarasan Desain:**
   Aplikasi Tugas Akhir *Smart Traffic Finder* telah memiliki identitas visual khas berupa tata letak modern bernuansa oranye, responsif (desktop & mobile bottom navigation), dan kartu insiden. Penggunaan Laravel Breeze secara otomatis menimpa view default dengan Tailwind Breeze standar dan file `routes/web.php`. Dengan metode manual, tampilan UI form Login, Register, Beranda, dan Profil dapat dirancang selaras 100% tanpa risiko ter-overwrite.
2. **Pemahaman Arsitektur & Alur Kerja di Balik Layar:**
   Metode manual memberikan pemahaman mendalam tentang setiap tahap autentikasi Laravel:
   - Validasi Request (`$request->validate([...])`).
   - Pembuatan hash password (`Hash::make($request->password)`).
   - Pencocokan kredensial pengguna (`Auth::attempt($credentials, $remember)`).
   - Pencegahan serangan *session fixation* (`$request->session()->regenerate()`).
   - Proteksi route melalui grup `Route::middleware('auth')->group(...)`.
   - Pembersihan sesi secara aman saat logout (`Auth::logout()`, `invalidate()`, dan `regenerateToken()`).
3. **Bebas Ketergantungan Build Tool (Vite / npm):**
   Laravel Breeze memerlukan instalasi package Node.js (`npm install`) dan proses compile asset yang harus terus berjalan (`npm run dev`). Apabila asisten praktikum atau dosen penguji menguji project tanpa menjalankan `npm run dev`, halaman Breeze akan mengalami galat *Vite manifest not found*. Dengan autentikasi manual berbasis CDN Tailwind & FontAwesome, project dapat diuji langsung hanya dengan `php artisan serve`.

---

## 5. Struktur Pembagian Hak Akses & Middleware Auth

### A. Halaman Publik (Tamu / Guest)
- **`GET /`** (`welcome`): Landing page publik menampilkan informasi aplikasi, statistik insiden, dan tombol Masuk/Daftar.
- **`GET /login`** & **`POST /login`**: Formulir login dan proses autentikasi (dilindungi middleware `guest`).
- **`GET /register`** & **`POST /register`**: Formulir pendaftaran akun baru (dilindungi middleware `guest`).

### B. Halaman Terproteksi (Wajib Login / Middleware `auth`)
Jika pengguna belum login mencoba membuka salah satu URL di bawah ini, Laravel akan secara otomatis menolak akses dan mengarahkannya kembali ke halaman `/login`:
- **`GET /beranda`** (alias `/dashboard`): Beranda utama status kelancaran kota dan feed insiden terkini.
- **`GET /laporan`**: Daftar seluruh laporan insiden lalu lintas dengan fitur pencarian.
- **`GET /laporan/create`** & **`POST /laporan`**: Formulir pelaporan insiden lengkap dengan upload foto bukti.
- **`GET /laporan/{id}`**: Halaman rincian detail insiden.
- **`GET /chat`** & **`POST /chat`**: Forum komunikasi interaktif antar pengendara di Kota Bandung.
- **`GET /profile`** & **`POST /profile`**: Informasi akun pengguna yang sedang login (`Auth::user()`) dan form edit profil.
- **`POST /logout`**: Pembersihan sesi dan token login secara aman.

---

## 6. Pengujian Otomatis (Automated Testing)

Project ini telah dilengkapi dengan 14 unit & feature test yang dapat dijalankan melalui perintah:
```bash
php artisan test
```
Hasil pengujian: **14 passed (54 assertions)**, meliputi pengujian status publik, proteksi middleware, hash password seeder, kegagalan validasi, dan alur login/logout.
