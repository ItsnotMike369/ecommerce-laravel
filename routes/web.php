<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\PaymentMethodController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/shop', [ProductController::class, 'index'])->name('shop');
Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');

Route::get('/customer-service', function () {
    return view('customer-service');
})->name('customer-service');

Route::get('/about', function () {
    return view('about');
})->name('about');

// Wishlist routes
Route::post('/wishlist/add/{productId}', [WishlistController::class, 'add'])->name('wishlist.add');
Route::post('/wishlist/remove/{productId}', [WishlistController::class, 'remove'])->name('wishlist.remove');

// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{productId}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{productId}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout/customer', [CheckoutController::class, 'saveCustomer'])->name('checkout.customer');
Route::post('/checkout/shipping', [CheckoutController::class, 'saveShipping'])->name('checkout.shipping');
Route::post('/checkout/back', [CheckoutController::class, 'backToStep'])->name('checkout.back');
Route::post('/checkout/place', [CheckoutController::class, 'placeOrder'])->name('checkout.place');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

// Social OAuth routes (accessible regardless of auth state)
Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
Route::get('/auth/facebook', [SocialAuthController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('/auth/facebook/callback', [SocialAuthController::class, 'handleFacebookCallback'])->name('auth.facebook.callback');

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware('throttle:6,1')->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('/dashboard', function () {
        if (Auth::user()->is_admin) {
            return view('dashboard');
        }
        return redirect()->route('account');
    })->name('dashboard');

    Route::get('/account', [ProfileController::class, 'account'])->name('account');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/account/address', [ProfileController::class, 'saveAddress'])->name('account.address.save');

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    // Payment methods
    Route::post('/account/payment-methods', [PaymentMethodController::class, 'store'])->name('payment.store');
    Route::delete('/account/payment-methods/{paymentMethod}', [PaymentMethodController::class, 'destroy'])->name('payment.destroy');
    Route::post('/account/payment-methods/{paymentMethod}/default', [PaymentMethodController::class, 'setDefault'])->name('payment.default');
});

// Admin routes
Route::prefix('admin')->group(function () {
    Route::get('login', [AdminController::class, 'showLogin'])->name('admin.login');
    Route::post('login', [AdminController::class, 'login'])->name('admin.login.post');

    Route::middleware('admin')->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('products', [AdminController::class, 'products'])->name('admin.products');
        Route::post('products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
        Route::put('products/{id}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
        Route::delete('products/{id}', [AdminController::class, 'deleteProduct'])->name('admin.products.delete');
        Route::get('orders', [AdminController::class, 'orders'])->name('admin.orders');
        Route::get('orders/{id}', [AdminController::class, 'orderDetail'])->name('admin.orders.detail');
        Route::get('customers', [AdminController::class, 'customers'])->name('admin.customers');
        Route::get('settings', [AdminController::class, 'settings'])->name('admin.settings');
        Route::post('settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
        Route::post('logout', [AdminController::class, 'logout'])->name('admin.logout');
    });
});
