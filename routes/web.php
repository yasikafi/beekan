<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\SellerController; // <-- PENTING: Import ini ditambahin

// 1. Halaman Depan (Landing)
Route::get('/', function () {
    return view('landing');
})->name('login');

// 2. Halaman Login Form
Route::get('/login', function () {
    return view('login');
});

// --- RUTE PROSES LOGIN & LOGOUT ---
Route::post('/login-process', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

// 3. Halaman Buyer (Menu Kantin)
Route::get('/buyer', [BuyerController::class, 'index'])->middleware('auth');

// 4. Halaman Seller (Dashboard Live)
Route::get('/seller', [SellerController::class, 'index'])->middleware('auth');

// 5. Rute Buat Update Status Order (Terima/Tolak) - INI BARU
Route::post('/seller/order/{id}/update', [SellerController::class, 'updateStatus'])->middleware('auth');

// 6. Halaman Order
Route::get('/order', function () {
    return view('order');
})->middleware('auth');

// 7. Halaman Flash Sale
Route::get('/flash-sale', [BuyerController::class, 'flashSale'])->middleware('auth');

// 8. Halaman Create Flash Sale
Route::get('/seller/create-flash', [SellerController::class, 'createFlash'])->middleware('auth');
Route::post('/seller/create-flash/store', [SellerController::class, 'storeFlash'])->middleware('auth');

// 9. Jalur buat JS ngirim orderan
Route::post('/order/save', [BuyerController::class, 'storeOrder'])->middleware('auth');

// 10. HALAMAN TAMBAH MENU (SELLER)
Route::get('/seller/add-menu', [SellerController::class, 'createMenu'])->middleware('auth');
Route::post('/seller/add-menu/store', [SellerController::class, 'storeMenu'])->middleware('auth');