<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Pastikan ini ada

class homepageController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query', '');
        $subkategoriDipilih = $request->input('subkategori', null);

        $kategoris = Kategori::with('subkategoris')->get();

        // Ambil semua buku yang akan difilter di sisi klien
        $allBooksForFiltering = Buku::select('id', 'judul', 'penulis', 'gambar', 'kategori_id', 'subkategori_id', 'created_at')
                                    ->get();

        // Ambil buku terbaru untuk diurutkan JS di section "Buku Terbaru"
        // $bukuTerbaruUntukJS = Buku::orderBy('created_at', 'desc')->take(50)->get();

        $sort = $request->input('sort', 'terbaru');
        $bukuTerbaruUntukJS = Buku::orderBy('created_at', $sort === 'terlama' ? 'asc' : 'desc')->take(50)->get();


        return view('homepage', compact(
            'kategoris',
            'query',
            'subkategoriDipilih',
            'bukuTerbaruUntukJS',
            'allBooksForFiltering'
        ));
    }
}