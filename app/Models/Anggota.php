<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Anggota extends Model
{
        use HasFactory;

    protected $table = 'Anggotas';

    protected $fillable = [
        'nama',
        'gender',
        'kelas',
        'program_studi',
        'no_hp',
    ];
}
