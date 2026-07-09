<?php

use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

// Pintu untuk ambil semua barang (GET)
Route::get('/products', [ProductController::class, 'index']);

// Pintu untuk simpan barang baru + QR (POST)
Route::post('/products', [ProductController::class, 'store']);
Route::post('/products/scan', [ProductController::class, 'scan']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);