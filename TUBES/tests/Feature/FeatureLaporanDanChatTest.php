<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Database\Seeders\LaporanSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FeatureLaporanDanChatTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(UserSeeder::class);
        $this->seed(LaporanSeeder::class);
    }

    public function test_pengguna_login_dapat_membuat_laporan_insiden(): void
    {
        Storage::fake('public');

        $user = User::where('email', 'admin@smarttraffic.id')->first();

        $response = $this->actingAs($user)->post('/laporan', [
            'lokasi' => 'Jl. Dipatiukur, Depan Kampus Unpad',
            'deskripsi' => 'Terjadi antrean kendaraan cukup panjang akibat kegiatan wisuda.',
            'tingkat_kemacetan' => 65,
            'foto' => UploadedFile::fake()->create('insiden.jpg', 100, 'image/jpeg'),
        ]);

        $response->assertRedirect(route('beranda'));
        $this->assertDatabaseHas('laporan', [
            'lokasi' => 'Jl. Dipatiukur, Depan Kampus Unpad',
            'nama_pelapor' => $user->name,
        ]);
    }

    public function test_pengguna_login_dapat_mengirim_pesan_chat(): void
    {
        $user = User::where('email', 'admin@smarttraffic.id')->first();

        $response = $this->actingAs($user)->post('/chat', [
            'message' => 'Halo semuanya, apakah jalur Pasteur lancar saat ini?',
        ]);

        $response->assertRedirect(route('chat'));
        $this->assertDatabaseHas('messages', [
            'sender' => $user->name,
            'message' => 'Halo semuanya, apakah jalur Pasteur lancar saat ini?',
        ]);
    }
}
