<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DiskonController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PromoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Authentication Route
Route::middleware(['json'])->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);
        Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
        Route::delete('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
    });

    Route::middleware(['auth', 'verified', 'json'])->group(function () {
        Route::prefix('setting')->group(function () {
            Route::get('', [SettingController::class, 'index'])->withoutMiddleware(['auth', 'verified', 'json']);
            Route::post('', [SettingController::class, 'update']);
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
            Route::prefix('diskon')->group(function () {
                Route::get('', [DiskonController::class, 'get']);
                Route::post('', [DiskonController::class, 'index']);
                Route::post('store', [DiskonController::class, 'store']);
                Route::get('{uuid}/show', [DiskonController::class, 'show']);
                Route::post('{uuid}/update', [DiskonController::class, 'update']);
                Route::delete('{uuid}', [DiskonController::class, 'destroy']);
            });
        });
    });
});
