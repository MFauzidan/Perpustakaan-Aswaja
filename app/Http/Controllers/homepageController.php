<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index(Request $request)
    {
        $kategoriDipilih = $request->input('kategori'); // id_kategori (optional)
        $sort = $request->input('sort', 'terbaru'); // default: terbaru

        // Ambil semua kategori
        $kategoris = Kategori::all();

        // =============================
        // Bagian Buku Terbaru (TIDAK TERFILTER kategori)
        // =============================
        $bukuTerbaru = Buku::with('kategori')
            ->orderBy('created_at', $sort === 'terlama' ? 'asc' : 'desc')
            ->limit(10)
            ->get();

        // =============================
        // Bagian Semua Buku (FILTER berdasarkan kategori)
        // =============================
        $semuaBuku = Buku::with('kategori')
            ->when($kategoriDipilih, function ($query) use ($kategoriDipilih) {
                $query->where('kategori_id', $kategoriDipilih);
            })
            ->orderBy('judul', 'asc')
            ->get();

        return view('homepage', compact(
            'kategoris',
            'kategoriDipilih',
            'sort',
            'bukuTerbaru',
            'semuaBuku'
        ));
    }
}
