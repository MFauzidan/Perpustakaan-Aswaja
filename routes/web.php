<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\KategoriController;

// Homepage — dengan filter GET (search, kategori, subkategori)
Route::get('/', [HomepageController::class, 'index'])->name('home');

// Semua Buku — dengan filter GET (search)
Route::get('/buku', [BukuController::class, 'index'])->name('bukus.index');

// Detail buku
Route::get('/bukus/{id}', [BukuController::class, 'show'])->name('bukus.show');

// Kategori — jika ada halaman kategori terpisah
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');

// 🔴 Hapus AJAX search: sudah tidak dipakai
// Route::get('/api/buku/search', [BukuController::class, 'ajaxSearch'])->name('ajax.search');

// 🔴 Hapus subkategori AJAX: pakai GET param di /
Route::get('/buku/subkategori/{id}', [BukuController::class, 'bysubkategori'])->name('buku.bysubkategori'); 
// 🟢 Jika subkategori via param GET, route ini TIDAK DIPAKAI, jadi bisa DIHAPUS

// ✅ Saran: hapus jika `bysubkategori` tidak ada di controller.
