<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
    ];

    public function bukus()
    {
        return $this->hasMany(Buku::class); // sudah benar
    }

        public function subkategoris()
    {
        return $this->hasMany(subkategori::class);
    }
}
