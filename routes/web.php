<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\homepageController;
use App\Http\Controllers\KategoriController;

// Homepage
Route::get('/', [homepageController::class, 'index'])->name('home');

// AJAX Search Route
Route::get('/api/buku/search', [BukuController::class, 'ajaxSearch'])->name('ajax.search');

// Detail buku
Route::get('/bukus/{id}', [BukuController::class, 'show'])->name('bukus.show');

// Kategori
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
