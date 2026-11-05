<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Database\Seeders\LaporanSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(UserSeeder::class);
        $this->seed(LaporanSeeder::class);
    }

    public function test_halaman_welcome_dapat_diakses_publik(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Smart Traffic');
    }

    public function test_halaman_login_dan_register_dapat_diakses_guest(): void
    {
        $loginRes = $this->get('/login');
        $loginRes->assertStatus(200);
        $loginRes->assertSee('Masuk');

        $registerRes = $this->get('/register');
        $registerRes->assertStatus(200);
        $registerRes->assertSee('Daftar Akun Pengguna');
    }

    public function test_halaman_terproteksi_redirect_ke_login_jika_belum_autentikasi(): void
    {
        $this->get('/beranda')->assertRedirect('/login');
        $this->get('/dashboard')->assertRedirect('/login');
        $this->get('/laporan')->assertRedirect('/login');
        $this->get('/laporan/create')->assertRedirect('/login');
        $this->get('/chat')->assertRedirect('/login');
        $this->get('/profile')->assertRedirect('/login');
    }

    public function test_registrasi_pengguna_baru_berhasil_dan_password_tersimpan_dalam_bentuk_hash(): void
    {
        $email = 'penguji_baru_' . uniqid() . '@smarttraffic.id';

        $response = $this->post('/register', [
            'name' => 'Penguji Laravel',
            'email' => $email,
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'telepon' => '089988776655',
            'lokasi' => 'Bandung Wetan',
        ]);

        $response->assertRedirect(route('beranda'));
        $this->assertAuthenticated();

        // Cek database
        $user = User::where('email', $email)->first();
        $this->assertNotNull($user);
        $this->assertNotEquals('password123', $user->password);
        $this->assertTrue(Hash::check('password123', $user->password));
        $this->assertStringStartsWith('$2y$', $user->password);
    }

    public function test_registrasi_gagal_jika_konfirmasi_password_tidak_sama(): void
    {
        $response = $this->post('/register', [
            'name' => 'User Salah',
            'email' => 'salah@smarttraffic.id',
            'password' => 'password123',
            'password_confirmation' => 'bedapassword',
        ]);

        $response->assertSessionHasErrors(['password']);
        $this->assertGuest();
    }

    public function test_login_berhasil_menggunakan_akun_admin_hasil_seeder(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@smarttraffic.id',
            'password' => 'admin123',
        ]);

        $response->assertRedirect(route('beranda'));
        $this->assertAuthenticated();
    }

    public function test_login_berhasil_menggunakan_akun_dummy_hasil_seeder(): void
    {
        $response = $this->post('/login', [
            'email' => 'user1@smarttraffic.id',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('beranda'));
        $this->assertAuthenticated();
    }

    public function test_login_gagal_jika_password_salah(): void
    {
        $response = $this->from('/login')->post('/login', [
            'email' => 'admin@smarttraffic.id',
            'password' => 'passwordsalah123',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    public function test_pengguna_yang_telah_login_dapat_mengakses_halaman_beranda_dan_profil(): void
    {
        $user = User::where('email', 'admin@smarttraffic.id')->first();

        $response = $this->actingAs($user)->get('/beranda');
        $response->assertStatus(200);
        $response->assertSee('Beranda Pemantauan');

        $profileRes = $this->actingAs($user)->get('/profile');
        $profileRes->assertStatus(200);
        $profileRes->assertSee($user->name);
    }

    public function test_logout_berhasil_menghapus_sesi_dan_mengarahkan_ke_halaman_utama(): void
    {
        $user = User::where('email', 'admin@smarttraffic.id')->first();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }
}
