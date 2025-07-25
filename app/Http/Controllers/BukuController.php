<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;

class BukuController extends Controller
{
    /**
     * Halaman daftar semua buku.
     * Mendukung filter pencarian dan filter subkategori.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $subkategori = $request->input('subkategori');

        $query = Buku::query();

        // Filter pencarian judul atau penulis
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan subkategori
        if ($subkategori) {
            $query->where('subkategori_id', $subkategori);
        }

        // Paginate 12 buku per halaman
        $bukus = $query->orderBy('judul')->paginate(12);

        // Ambil kategori + subkategorinya untuk dropdown
        $kategoris = Kategori::with('subkategoris')->get();

        return view('buku', compact('bukus', 'search', 'subkategori', 'kategoris'));
    }

    /**
     * Detail buku.
     */
    public function show($id)
    {
        $buku = Buku::with('kategori')->findOrFail($id);

        return view('detailbuku', compact('buku'));
    }
}
