<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SAWController;

// Halaman Publik
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/portfolio', [HomeController::class, 'portfolio'])->name('portfolio');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/services', [ServiceController::class, 'index'])->name('services');
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');

// Perlu Login
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/my-orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/payment/upload/{order}', [PaymentController::class, 'upload'])->name('payment.upload');
});
// SPK SAW
Route::get('/spk-rekomendasi', [SAWController::class, 'index'])->name('spk.index');
Route::post('/spk-rekomendasi/calculate', [SAWController::class, 'calculate'])
    ->middleware('throttle:20,1')->name('spk.calculate');
Route::get('/spk-rekomendasi/hasil/{result}', [SAWController::class, 'show'])->name('spk.show');
Route::middleware('auth')->group(function () {
    Route::get('/spk-rekomendasi/history', [SAWController::class, 'history'])->name('spk.history');
    Route::post('/spk-rekomendasi/order-package/{package}', [SAWController::class, 'orderPackage'])->name('spk.orderPackage');

    // Profil pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Dashboard setelah login
Route::middleware('auth')->get('/dashboard', function () {
    $orders = \App\Models\Order::where('user_id', auth()->id())->latest()->take(5)->get();
    return view('dashboard', compact('orders'));
})->name('dashboard');

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';