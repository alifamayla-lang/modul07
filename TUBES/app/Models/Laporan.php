<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';

    protected $fillable = [
        'nama_pelapor',
        'lokasi',
        'deskripsi',
        'foto',
        'status_verifikasi',
        'tingkat_kemacetan',
        'waktu_laporan',
    ];

    protected $casts = [
        'waktu_laporan' => 'datetime',
    ];

    public function getTanggalAttribute(): string
    {
        return Carbon::parse($this->waktu_laporan ?? $this->created_at)->format('d');
    }

    public function getBulanAttribute(): string
    {
        return strtoupper(Carbon::parse($this->waktu_laporan ?? $this->created_at)->translatedFormat('M'));
    }

    public function getWaktuBerlaluAttribute(): string
    {
        return Carbon::parse($this->waktu_laporan ?? $this->created_at)->diffForHumans();
    }

    public function getFotoUrlAttribute(): string
    {
        if (!empty($this->foto)) {
            if (str_starts_with($this->foto, 'http://') || str_starts_with($this->foto, 'https://')) {
                return $this->foto;
            }
            if (str_starts_with($this->foto, 'uploads/')) {
                return asset($this->foto);
            }
            return asset('storage/' . $this->foto);
        }
        return 'https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?auto=format&fit=crop&w=800&q=80';
    }
}
