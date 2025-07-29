<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class homepageController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query', '');
        $subkategoriDipilih = $request->input('subkategori', null);
        $sortOrderAllBooks = $request->input('sort_all_books', 'desc'); // Default 'desc' untuk semua buku
        $sortOrderNewBooks = $request->input('sort_new_books', 'desc'); // Default 'desc' untuk buku terbaru

        $kategoris = Kategori::with('subkategoris')->get();

        // --- Logika untuk "LIHAT SEMUA BUKU" (sebelumnya `allBooksForFiltering`) ---
        $allBooksQuery = Buku::query();

        // 1. Filter berdasarkan pencarian (judul atau penulis)
        if (!empty($query)) {
            $allBooksQuery->where(function($q) use ($query) {
                $q->where('judul', 'like', '%' . $query . '%')
                  ->orWhere('penulis', 'like', '%' . $query . '%');
            });
        }

        // 2. Filter berdasarkan subkategori
        if ($subkategoriDipilih) {
            $allBooksQuery->where('subkategori_id', $subkategoriDipilih);
        }

        // 3. Sorting untuk "LIHAT SEMUA BUKU"
        // Anda bisa menambahkan tombol sortir untuk bagian ini di frontend jika perlu
        $allBooksQuery->orderBy('created_at', $sortOrderAllBooks); // Sortir berdasarkan created_at

        $allBooks = $allBooksQuery->select('id', 'judul', 'penulis', 'gambar', 'kategori_id', 'subkategori_id', 'created_at')
                                ->get();


        // --- Logika untuk "BUKU TERBARU" (sebelumnya `bukuTerbaruUntukJS`) ---
        // Ini akan selalu menampilkan buku terbaru, dengan opsi sortir terbaru/terlama
        $bukuTerbaru = Buku::orderBy('created_at', $sortOrderNewBooks)->take(50)->get(); // Ambil 50 buku

        return view('homepage', compact(
            'kategoris',
            'query',
            'subkategoriDipilih',
            'allBooks', // Mengganti nama variabel agar lebih jelas
            'bukuTerbaru', // Mengganti nama variabel agar lebih jelas
            'sortOrderAllBooks',
            'sortOrderNewBooks'
        ));
    }
}