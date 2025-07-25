<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Buku extends Model
{
    use HasFactory;

    protected $fillable = [
    'judul',
    'penulis',
    'penerbit',          // ✅ baru
    'tahun_terbit',      // ✅ baru
    'jumlah_halaman',    // ✅ baru
    'gambar',
    'sinopsis',
    'kategori_id',
    'subkategori_id',
    'jumlah_asli',
    'jumlah_sekarang',
    'kode_penempatan',
];


    public function kategori()
    {
        return $this->belongsTo(Kategori::class); // tidak perlu sebutkan foreign key jika pakai kategori_id
    }

    public function peminjam()
    {
        return $this->hasMany(Peminjam::class);
    }

    protected static function booted()
    {
        // Hapus gambar lama saat update
        static::updating(function ($buku) {
            if ($buku->isDirty('gambar') && $buku->getOriginal('gambar')) {
                Storage::disk('public')->delete($buku->getOriginal('gambar'));
            }
        });

        // Hapus gambar saat record dihapus
        static::deleting(function ($buku) {
            if ($buku->gambar) {
                Storage::disk('public')->delete($buku->gambar);
            }
        });
    }

    // Untuk digunakan di view
    public function getCoverUrlAttribute()
    {
        return $this->gambar ? asset('storage/' . $this->gambar) : null;
    }

    public function subkategori()
    {
        return $this->belongsTo(Subkategori::class);
    }
}
