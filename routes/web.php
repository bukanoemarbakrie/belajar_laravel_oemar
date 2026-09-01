<?php

use App\Http\Controllers\BelajarController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

// ==========================================
// 1. RUTE PUBLIK (GUEST)
// ==========================================
Route::get('/', [LoginController::class, 'login']);
Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('actionLogin', [LoginController::class, 'actionLogin'])->name('action-login');

// ==========================================
// 2. RUTE DENGAN AUTENTIKASI (AUTH)
// ==========================================
Route::middleware('auth')->group(function () {

    // Rute Spesifik / Umum untuk Semua Role Terautentikasi
    Route::get('menu/sidebar', [MenuController::class, 'sidebar']);
    Route::get('order/{id}/print', [OrderController::class, 'printReceipt'])->name('order.print');
    Route::get('setting', [SettingController::class, 'index'])->name('setting');
    Route::put('setting', [SettingController::class, 'update'])->name('setting-update');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // --------------------------------------
    // HAK AKSES ADMIN
    // --------------------------------------
    Route::middleware('admin')->group(function () {
        Route::get('admin/dashboard', [DashboardController::class, 'indexAdmin'])->name('admin.dashboard');
        Route::resource('role', RoleController::class);
        Route::resource('category', CategoryController::class);
        Route::resource('product', ProductController::class);
        Route::resource('menu', MenuController::class);
    });

    // --------------------------------------
    // HAK AKSES KASIR
    // --------------------------------------
    Route::middleware('kasir')->group(function () {
        Route::get('cashier/dashboard', [DashboardController::class, 'indexKasir'])->name('cashier.dashboard');
        // FIX: Menghapus kelebihan huruf 'r' pada OrderController
        Route::resource('order', OrderController::class);
    });

    // --------------------------------------
    // HAK AKSES PIMPINAN
    // --------------------------------------
    // FIX: Format array middleware ['pimpinan']
    Route::middleware('pimpinan')->group(function () {
        Route::get('pimpinan/dashboard', [DashboardController::class, 'index'])->name('pimpinan.dashboard');
    });
});

// ==========================================
// 3. RUTE LATIHAN & PESERTA CRUD
// ==========================================
Route::get('salam', [BelajarController::class, 'greeting']);
Route::get('hitung-tambah', [BelajarController::class, 'tambah'])->name('tambah');
Route::get('hitung-kurang', [BelajarController::class, 'indexKurang'])->name('kurang');
Route::post('action-kurang', [BelajarController::class, 'kurang'])->name("action-kurang");
Route::get('hitung-kali', [BelajarController::class, 'indexKali'])->name('kali');
Route::post('action-kali', [BelajarController::class, 'kali'])->name("action-kali");
Route::get('hitung-bagi', [BelajarController::class, 'indexBagi'])->name('bagi');
Route::post('action-bagi', [BelajarController::class, 'bagi'])->name("action-bagi");
Route::get('counting', [BelajarController::class, 'index'])->name('counting');

// Peserta CRUD
Route::get('peserta', [PesertaController::class, 'index'])->name('peserta');
Route::get('peserta/create', [PesertaController::class, 'create'])->name('peserta-create');
Route::post('peserta/create', [PesertaController::class, 'store'])->name('peserta-store');
Route::get('peserta/edit/{id}', [PesertaController::class, 'edit'])->name('peserta-edit');
Route::put('peserta/edit/{id}', [PesertaController::class, 'update'])->name('peserta-update');
Route::delete('peserta/delete/{id}', [PesertaController::class, 'delete'])->name('peserta-delete');
