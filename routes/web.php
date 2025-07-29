<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\KategoriController; // Pastikan controller ini ada jika Anda menggunakannya

// Halaman Beranda - Menangani filter pencarian, kategori, dan subkategori melalui parameter GET
Route::get('/', [HomepageController::class, 'index'])->name('home');

// Halaman Semua Buku - Menampilkan semua buku, bisa juga menangani pencarian/sortir sendiri jika diimplementasikan di BukuController@index
Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');

// Halaman Detail Buku Individual
Route::get('/bukus/{buku}', [BukuController::class, 'show'])->name('buku.show'); // Mengasumsikan {buku} adalah route model binding

// Opsional: Halaman Kategori - Hanya jika Anda memiliki halaman khusus untuk kategori
// Jika halaman ini tidak digunakan atau kategori hanya berfungsi sebagai dropdown di halaman beranda, Anda bisa menghapusnya.
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');

