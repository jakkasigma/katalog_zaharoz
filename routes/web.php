<?php

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController as AdminAuthController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CompanyProfileController as AdminCompanyProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PaymentVerificationController as AdminPaymentVerificationController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CompanyProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\User\AddressController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Route;

// ─── Company Profile (public) ─────────────────────────────────────────────
Route::controller(CompanyProfileController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/tentang-kami', 'about')->name('about');
    Route::get('/visi-misi', 'vision')->name('vision');
    Route::get('/kontak', 'contact')->name('contact');
});

// ─── Store (public catalogue) ──────────────────────────────────────────────
Route::get('/store', [ProductController::class, 'storefront'])->name('store.index');
Route::get('/store/{product:slug}', [ProductController::class, 'show'])->name('store.product');

// Redirect lama agar link lama tidak 404
Route::get('/products', fn () => redirect()->route('store.index', [], 301))->name('products.index');
Route::get('/products/{product:slug}', fn (string $product) => redirect()->to("/store/{$product}", 301))->name('products.show');

Route::middleware('guest')->group(function (): void {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/password', [ProfileController::class, 'password'])->name('profile.password');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    Route::resource('addresses', AddressController::class)->except(['show']);

    // Transaction routes - restricted for non-admin users only
    Route::middleware('not-admin')->group(function (): void {
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
        Route::patch('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');

        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
        Route::get('/checkout/payment', [CheckoutController::class, 'payment'])->name('checkout.payment');
        Route::post('/checkout/payment', [CheckoutController::class, 'confirm'])->name('checkout.confirm');

        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

        Route::get('/orders/{order}/payment', [PaymentController::class, 'create'])->name('payments.create');
        Route::post('/orders/{order}/payment', [PaymentController::class, 'store'])->name('payments.store');
    });
});

Route::prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/login', [AdminAuthController::class, 'create'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'store'])->name('login.store');

    Route::middleware('admin')->group(function (): void {
        Route::post('/logout', [AdminAuthController::class, 'destroy'])->name('logout');

        Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
        Route::get('/company-profile', [AdminCompanyProfileController::class, 'edit'])->name('company-profile.edit');
        Route::patch('/company-profile', [AdminCompanyProfileController::class, 'update'])->name('company-profile.update');
        Route::patch('/company-profile/payment-info', [AdminCompanyProfileController::class, 'updatePaymentInfo'])->name('company-profile.update-payment-info');

        Route::resource('categories', AdminCategoryController::class)->except(['show']);
        Route::resource('products', AdminProductController::class);

        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
        Route::patch('/users/{user}/toggle-active', [AdminUserController::class, 'toggleActive'])->name('users.toggle-active');

        Route::get('/payments', [AdminPaymentVerificationController::class, 'index'])->name('payments.index');
        Route::get('/payments/{payment}', [AdminPaymentVerificationController::class, 'show'])->name('payments.show');
        Route::post('/payments/{payment}/approve', [AdminPaymentVerificationController::class, 'approve'])->name('payments.approve');
        Route::post('/payments/{payment}/reject', [AdminPaymentVerificationController::class, 'reject'])->name('payments.reject');

        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');

        Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    });
});
