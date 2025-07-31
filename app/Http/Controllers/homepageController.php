<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomepageController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query', '');
        $subkategori = $request->input('subkategori');
        $sortOrderAllBooks = $request->input('sort_all_books', 'desc');
        $sortOrderNewBooks = $request->input('sort_new_books', 'desc');

        $kategoris = Kategori::with('subkategoris')->get();

        // --- Logika untuk "LIHAT SEMUA BUKU" ---
        $allBooksQuery = Buku::query();

        if (!empty($query)) {
            $allBooksQuery->where(function($q) use ($query) {
                $q->where('judul', 'like', '%' . $query . '%')
                  ->orWhere('penulis', 'like', '%' . $query . '%');
            });
        }

        if ($subkategori) {
            $allBooksQuery->where('subkategori_id', $subkategori);
        }

        $allBooksQuery->orderBy('created_at', $sortOrderAllBooks);

        $allBooks = $allBooksQuery->select('id', 'judul', 'penulis', 'gambar', 'kategori_id', 'subkategori_id', 'created_at')
                                ->get();


        // --- Logika untuk "BUKU TERBARU" ---
        $bukuTerbaru = Buku::orderBy('created_at', $sortOrderNewBooks)->take(50)->get();

        // **PENTING: Ubah logika ini untuk permintaan AJAX**
        if ($request->ajax()) {
            return response()->json([
                'allBooks' => $allBooks, // Mengembalikan koleksi Buku
                'bukuTerbaru' => $bukuTerbaru, // Mengembalikan koleksi Buku
                'sortOrderNewBooksText' => ($sortOrderNewBooks ?? 'desc') == 'desc' ? 'Terbaru' : 'Terlama'
            ]);
        }

        return view('homepage', compact(
            'kategoris',
            'query',
            'subkategori',
            'allBooks',
            'bukuTerbaru',
            'sortOrderAllBooks',
            'sortOrderNewBooks'
        ));
    }

        //  Detail buku.

    public function show($id)
    {
        $buku = Buku::with('kategori')->findOrFail($id);
        return view('detailbuku', compact('buku'));
    }
}
