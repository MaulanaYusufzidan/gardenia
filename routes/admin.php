<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\SpkController;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Pesanan
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

    // Manajemen Pengguna
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::patch('/users/{user}/toggle', [UserController::class, 'toggleActive'])->name('users.toggle');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Manajemen Layanan
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
    Route::patch('/services/{service}/toggle', [ServiceController::class, 'toggleActive'])->name('services.toggle');

    // SPK: paket desain & kriteria
    Route::get('/spk/packages', [SpkController::class, 'packages'])->name('spk.packages');
    Route::get('/spk/packages/create', [SpkController::class, 'createPackage'])->name('spk.packages.create');
    Route::post('/spk/packages', [SpkController::class, 'storePackage'])->name('spk.packages.store');
    Route::get('/spk/packages/{package}/edit', [SpkController::class, 'editPackage'])->name('spk.packages.edit');
    Route::put('/spk/packages/{package}', [SpkController::class, 'updatePackage'])->name('spk.packages.update');
    Route::patch('/spk/packages/{package}/toggle', [SpkController::class, 'togglePackage'])->name('spk.packages.toggle');
    Route::delete('/spk/packages/{package}', [SpkController::class, 'destroyPackage'])->name('spk.packages.destroy');
    Route::get('/spk/criteria', [SpkController::class, 'criteria'])->name('spk.criteria');
    Route::put('/spk/criteria', [SpkController::class, 'updateCriteria'])->name('spk.criteria.update');

    // Verifikasi Pembayaran
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
    Route::patch('/payments/{payment}/verify', [PaymentController::class, 'verify'])->name('payments.verify');
    Route::patch('/payments/{payment}/reject', [PaymentController::class, 'reject'])->name('payments.reject');

});
