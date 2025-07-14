<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;

class BukuController extends Controller
{
    public function ajaxSearch(Request $request)
    {
        $query = $request->input('query');

        $results = Buku::where('judul', 'like', '%' . $query . '%')
            ->orWhere('penulis', 'like', '%' . $query . '%')
            ->get();

        return response()->json($results);
    }

    public function index()
    {
        $bukus = Buku::all();
        return view('bukus.index', compact('bukus'));
    }

    public function show($id)
    {
        $buku = Buku::with('kategori')->findOrFail($id);
        return view('detailbuku', compact('buku'));
    }
}


