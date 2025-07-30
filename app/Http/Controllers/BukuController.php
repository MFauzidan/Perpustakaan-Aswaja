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
        $query = $request->input('query', ''); // ← pakai 'search' sesuai form
        $subkategori = $request->input('subkategori');

        $kategoris = Kategori::with('subkategoris')->get();

        // Gunakan nama variabel lain untuk query builder
        // $bukuQuery = Buku::query();
                $allBooksQuery = Buku::query();


        // Filter pencarian
        if (!empty($query)) {
            $allBooksQuery->where(function($q) use ($query) {
                $q->where('judul', 'like', '%' . $query . '%')
                  ->orWhere('penulis', 'like', '%' . $query . '%');
            });
        }

        // Filter subkategori
        if (!empty($subkategori)) {
            $allBooksQuery->where('subkategori_id', $subkategori);
        }

        // Sorting dan pagination
        // $bukus = $allBooksQuery->orderBy('judul', 'asc')->paginate(12);
        
        $allBooks = $allBooksQuery->select('id', 'judul', 'penulis', 'gambar', 'kategori_id', 'subkategori_id', 'created_at')
                                ->paginate(12)
                                ->withQueryString();

        // Ajax JSON response
        if ($request->ajax()) {
            return response()->json([
                'allBooks' => $allBooks->items(),
                'pagination' => (string) $allBooks->links(),
                'query' => $query,
                'subkategori' => $subkategori
            ]);
        }

        // Return ke view
        return view('buku', compact(
            'allBooks',
            'query',
            'subkategori',
            'kategoris'
        ));
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