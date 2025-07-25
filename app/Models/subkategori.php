<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subkategori extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori_id',
        'nama'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}

