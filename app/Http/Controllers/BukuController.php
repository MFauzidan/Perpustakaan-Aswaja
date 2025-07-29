<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;

class BukuController extends Controller
{
    /**
     * Halaman daftar semua buku.
     * Mendukung filter pencarian (judul/penulis) dan filter subkategori.
     */
    public function index(Request $request)
    {
        // Ambil parameter dari URL
        $search = $request->input('search'); // Gunakan 'search' sebagai nama parameter
        $subkategori = $request->input('subkategori'); // Gunakan 'subkategori' sebagai nama parameter

        // Mulai query builder untuk model Buku
        $query = Buku::query();

        // Terapkan filter pencarian jika ada
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%");
            });
        }

        // Terapkan filter subkategori jika ada
        if (!empty($subkategori)) { // Menggunakan !empty() untuk memeriksa nilai null atau string kosong
            $query->where('subkategori_id', $subkategori);
        }

        // Urutkan dan paginasi hasilnya
        $bukus = $query->orderBy('judul', 'asc')->paginate(12); // Default sortir berdasarkan judul

        // Ambil semua kategori dan subkategorinya untuk dropdown filter
        $kategoris = Kategori::with('subkategoris')->get();

        // Sekarang, kita hanya mengembalikan data yang sudah difilter/dipaginasi oleh Controller.
        // Variabel $allBooksForFiltering tidak lagi diperlukan karena filtering dilakukan di server.
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