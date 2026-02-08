<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PelangganController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Halaman Depan langsung ke Login
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. Dashboard Redirector (Mengarahkan User sesuai Role)
Route::get('/dashboard', function () {
    // Jika Admin, lempar ke Dashboard Admin
    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    
    // Jika Pelanggan, PANGGIL CONTROLLER (Supaya data Grafik & Statistik terbawa)
    // Jangan pakai 'return view' biasa, nanti variabel $total_kwh error lagi.
    return app(\App\Http\Controllers\PelangganController::class)->index();

})->middleware(['auth', 'verified'])->name('dashboard');

// 3. AREA ADMIN (Wajib Role: admin)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/simpan', [AdminController::class, 'storePenggunaan'])->name('simpan.penggunaan');
    Route::post('/admin/bayar/{id}', [AdminController::class, 'bayarTagihan'])->name('admin.bayar');
});

// 4. AREA PELANGGAN (Bayar Auto)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/pelanggan/bayar-auto/{id}', [PelangganController::class, 'bayarTagihanAuto'])->name('pelanggan.bayar');
});

// 5. AREA PROFILE (Edit Profile, Password, Delete Akun)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';