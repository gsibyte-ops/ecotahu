<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;

Route::get('/', [ProdukController::class, 'index']);
Route::post('/tambah-produk', [ProdukController::class, 'store'])->name('produk.store');

// Ini tambahan buat Edit & Delete
Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');