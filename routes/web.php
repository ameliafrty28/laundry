<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\kasir\PelangganController as KasirPelanggan;
use App\Http\Controllers\kasir\LayananController as KasirLayanan;
use App\Http\Controllers\kasir\TransaksiController as KasirTransaksi;

use App\Http\Controllers\admin\LayananController as AdminLayanan;
use App\Http\Controllers\admin\PelangganController as AdminPelanggan;
use App\Http\Controllers\admin\TransaksiController as AdminTransaksi;
use App\Http\Controllers\admin\DashboardController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RekapController;


/*
|--------------------------------------------------------------------------
| LANDING
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'loginProses');
    Route::get('/logout', 'logout')->middleware('auth');
});


/*
|--------------------------------------------------------------------------
| KASIR
|--------------------------------------------------------------------------
*/

Route::prefix('kasir')
    ->name('kasir.')
    ->middleware(['auth'])
    ->group(function () {

        // dashboard (opsional, bisa kamu hapus)
        Route::view('/dashboard', 'kasir.dashboard')->name('dashboard');

        // pelanggan
        Route::resource('pelanggan', KasirPelanggan::class);

        // layanan
        Route::resource('layanan', KasirLayanan::class);

        // transaksi utama
        Route::controller(KasirTransaksi::class)->group(function () {

            Route::get('/transaksi', 'index')->name('transaksi.index');
            Route::get('/transaksi/create', 'create')->name('transaksi.create');

            Route::post('/transaksi/proses', 'proses')->name('transaksi.proses');
            Route::post('/transaksi/store', 'store')->name('transaksi.store');

            Route::get('/transaksi/{id}/edit', 'edit')->name('transaksi.edit');
            Route::put('/transaksi/{id}', 'update')->name('transaksi.update');
            Route::delete('/transaksi/{id}', 'destroy')->name('transaksi.destroy');

            Route::get('/transaksi/{id}', 'show')->name('transaksi.show');
            
            Route::get('/transaksi/{id}/bayar', 'bayar')->name('transaksi.bayar');
            Route::post('/transaksi/{id}/bayar', 'prosesBayar')->name('transaksi.prosesBayar');
        });
});


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth'])
    ->group(function () {

        Route::view('/dashboard', 'admin.dashboard.index')->name('dashboard');

        Route::resource('layanan', AdminLayanan::class);
        Route::resource('pelanggan', AdminPelanggan::class);

        // 🔥 TRANSAKSI ADMIN (FULL RESOURCE)
// transaksi utama
        Route::controller(AdminTransaksi::class)->group(function () {

            Route::get('/transaksi', 'index')->name('transaksi.index');
            Route::get('/transaksi/create', 'create')->name('transaksi.create');

            Route::post('/transaksi/proses', 'proses')->name('transaksi.proses');
            Route::post('/transaksi/store', 'store')->name('transaksi.store');

            Route::get('/transaksi/{id}/edit', 'edit')->name('transaksi.edit');
            Route::put('/transaksi/{id}', 'update')->name('transaksi.update');
            Route::delete('/transaksi/{id}', 'destroy')->name('transaksi.destroy');

            Route::get('/transaksi/{id}', 'show')->name('transaksi.show');
            
            Route::get('/transaksi/{id}/bayar', 'bayar')->name('transaksi.bayar');
            Route::post('/transaksi/{id}/bayar', 'prosesBayar')->name('transaksi.prosesBayar');
        
           // 🔥 TAMBAHAN UNTUK SOFT DELETE
        Route::post('/transaksi/{id}/restore', [AdminTransaksi::class, 'restore'])
            ->name('transaksi.restore');

        Route::delete('/transaksi/{id}/force', [AdminTransaksi::class, 'forceDelete'])
            ->name('transaksi.forceDelete');
        });

        Route::view('/rekap', 'admin.rekap.index')->name('rekap');
});

Route::get('/generate-rekap', [RekapController::class, 'generateRekapHarian']);