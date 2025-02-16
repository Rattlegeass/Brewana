<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PengirimanController;

Route::middleware(['json'])->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);
        Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
        Route::post('/forgot-password', [AuthController::class, 'sendResetLink']);
        Route::post('/reset-password', [AuthController::class, 'resetPassword']);
        Route::delete('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
    });

    Route::middleware(['auth', 'verified', 'json'])->group(function () {
        Route::prefix('dashboard')->group(function () {
            Route::get('income', [DashboardController::class, 'totalPemasukan']);
            Route::get('sent', [DashboardController::class, 'totalPengiriman']);
            Route::get('transaction', [DashboardController::class, 'totalTransaksi']);
        });

        Route::prefix('setting')->group(function () {
            Route::get('', [SettingController::class, 'index'])->withoutMiddleware(['auth', 'verified', 'json']);
            Route::post('', [SettingController::class, 'update']);
        });

        Route::prefix('pembayaran')->group(function () {
            Route::post('', [PembayaranController::class, 'index']);
            Route::post('{uuid}/update-status', [PembayaranController::class, 'updateStatus']);
        });

        Route::prefix('pengiriman')->group(function () {
            Route::post('', [PengirimanController::class, 'index']);
            Route::post('{uuid}/update-status', [PengirimanController::class, 'updateStatus']);
        });

        Route::prefix('master')->group(function () {
            Route::get('users', [UserController::class, 'get']);
            Route::post('users', [UserController::class, 'index']);
            Route::post('users/store', [UserController::class, 'store']);
            Route::apiResource('users', UserController::class)
                ->except(['index', 'store'])->scoped(['user' => 'uuid']);

            Route::get('roles', [RoleController::class, 'get']);
            Route::post('roles', [RoleController::class, 'index']);
            Route::post('roles/store', [RoleController::class, 'store']);
            Route::apiResource('roles', RoleController::class)
                ->except(['index', 'store']);

            Route::prefix('barang')->group(function () {
                Route::get('', [BarangController::class, 'get']);
                Route::post('', [BarangController::class, 'index']);
                Route::post('store', [BarangController::class, 'store']);
                Route::get('{uuid}/show', [BarangController::class, 'show']);
                Route::post('{uuid}/update', [BarangController::class, 'update']);
                Route::delete('{uuid}', [BarangController::class, 'destroy']);
            });

            Route::prefix('kategori')->group(function () {
                Route::get('', [KategoriController::class, 'get']);
                Route::post('', [KategoriController::class, 'index']);
                Route::post('store', [KategoriController::class, 'store']);
                Route::get('{uuid}/show', [KategoriController::class, 'show']);
                Route::post('{uuid}/update', [KategoriController::class, 'update']);
                Route::delete('{uuid}', [KategoriController::class, 'destroy']);
            });
            Route::prefix('promo')->group(function () {
                Route::get('', [PromoController::class, 'get']);
                Route::post('', [PromoController::class, 'index']);
                Route::post('store', [PromoController::class, 'store']);
                Route::get('{uuid}/show', [PromoController::class, 'show']);
                Route::post('{uuid}/update', [PromoController::class, 'update']);
                Route::delete('{uuid}', [PromoController::class, 'destroy']);
            });
        });

        Route::prefix('landing')->group(function () {
            Route::prefix('home')->group(function () {
                Route::post('/umpan-balik', [HomeController::class, 'umpanBalik']);
            });
            Route::prefix('toko')->group(function () {
                Route::post('/get', [TokoController::class, 'items'])->withoutMiddleware(['auth', 'verified', 'json']);
                Route::get('/promo/get', [TokoController::class, 'promoItems'])->withoutMiddleware(['auth', 'verified', 'json']);
                Route::prefix('detail')->group(function () {
                    Route::get('/{uuid}/get', [TokoController::class, 'detailItem'])->withoutMiddleware(['auth', 'verified', 'json']);
                    Route::post('/beli', [TokoController::class, 'beli']);
                    Route::post('/check-status', [TokoController::class, 'checkStatus']);
                    Route::post('/keranjang', [TokoController::class, 'keranjang']);
                    Route::get('/{uuid}/invoice', [TokoController::class, 'invoice']);
                    Route::prefix('komentar')->group(function () {
                        Route::post('/{id}/get', [TokoController::class, 'komentarItem'])->withoutMiddleware(['auth', 'verified', 'json']);
                        Route::post('/tambah-komentar', [TokoController::class, 'tambahKomentar']);
                    });
                });
            });
            Route::prefix('keranjang')->group(function () {
                Route::post('/get', [KeranjangController::class, 'items']);
                Route::post('/{uuid}/atur-kuantitas', [KeranjangController::class, 'aturKuantitas']);
                Route::delete('/{uuid}/hapus-item', [KeranjangController::class, 'hapusItem']);
                Route::post('/checkout', [KeranjangController::class, 'checkout']);
                Route::post('/check-status', [KeranjangController::class, 'checkStatus']);
            });
            Route::prefix('profil')->group(function () {
                Route::get('/{uuid}/get', [ProfilController::class, 'show']);
                Route::post('/{uuid}/update', [ProfilController::class, 'update']);
                Route::post('/{uuid}/update-password', [ProfilController::class, 'updatePassword']);
                Route::post('/riwayat', [ProfilController::class, 'riwayat']);
            });
        });
    });
});
