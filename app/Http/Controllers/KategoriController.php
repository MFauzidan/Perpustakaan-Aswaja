<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        // Mengambil semua data kategori beserta subkategorinya
    $kategoris = Kategori::with('subkategoris')->get();

        // Kirim Ke View
    return view('Kategori', compact('kategoris'));

    }

}