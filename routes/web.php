<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\productDetailController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('/login',    [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login',   [LoginController::class, 'postLogin'])->name('post.login');
Route::get('/register', [LoginController::class, 'showLoginForm'])->name('register');
Route::post('/register',[LoginController::class, 'postRegister'])->name('post.register');
Route::get('/logout',   [LoginController::class, 'Logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['main.auth', 'admin.auth'])->group(function () {
    Route::get('/', fn() => redirect('/admin/dashboard'));
    Route::get('/test',               [\App\Http\Controllers\test::class, 'index']);
    Route::get('/dashboard',          [\App\Http\Controllers\admin\AdminController::class, 'Dashboard'])->name('dashboard');
    Route::get('/customers',          [\App\Http\Controllers\admin\AdminController::class, 'Customers'])->name('customers');
    Route::get('/customers/{customer}',[\App\Http\Controllers\admin\AdminController::class, 'CustomerContext'])->name('customers.show');
    Route::get('/orders',             [\App\Http\Controllers\admin\AdminController::class, 'Orders'])->name('orders');
    Route::get('/orders/{order_id}',  [\App\Http\Controllers\admin\AdminController::class, 'OrderContext'])->name('orders.show');
    Route::get('/product_management', [App\Http\Controllers\admin\productController::class, 'index'])->name('product_management');
    Route::get('/create',             [App\Http\Controllers\admin\productController::class, 'create'])->name('create');
    Route::post('/store',             [App\Http\Controllers\admin\productController::class, 'store'])->name('store');
    Route::get('/{product}/edit',     [App\Http\Controllers\admin\productController::class, 'edit'])->name('edit');
    Route::post('/product/{product}', [App\Http\Controllers\admin\productController::class, 'update'])->name('update');
    Route::delete('/{product}/delete',[App\Http\Controllers\admin\productController::class, 'delete'])->name('delete');
});

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\homeController;

Route::get('/', [homeController::class, 'home'])->name('home');

// Shop
Route::get('/shop',         [App\Http\Controllers\ShopController::class, 'index'])->name('shop.index');
Route::post('/shop/filter', [App\Http\Controllers\ShopController::class, 'filter'])->name('shop.filter');
Route::post('/shop',        [App\Http\Controllers\ShopController::class, 'search'])->name('shop.search');
Route::post('/shop/add',    [App\Http\Controllers\ShopController::class, 'add'])->name('shop.add');

// Product detail
Route::get('/product/{product_id}', [productDetailController::class, 'productDetail'])->name('product.detail');

// API địa chỉ (public)
Route::get('/api/wards', [ProfileController::class, 'getWards'])->name('api.wards');

/*
|--------------------------------------------------------------------------
| Customer Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['main.auth', 'user.auth'])->group(function () {

    // Profile — Tài khoản
    Route::get('/profile',                  [ProfileController::class, 'account'])->name('account');
    Route::post('/profile/update/{id}',     [ProfileController::class, 'updateAccount'])->name('account.update');

    // Profile — Thông tin cá nhân
    Route::get('/profile/personal',              [ProfileController::class, 'personalProfile'])->name('account.profile');
    Route::post('/profile/personal/update/{id}', [ProfileController::class, 'updatePersonalProfile'])->name('account.profile.update');

    // Đổi mật khẩu
    Route::post('/profile/update_pass/{id}', [ProfileController::class, 'updatePass'])->name('account.updatePass');

    // Đơn hàng
    Route::get('/profile/order', [ProfileController::class, 'listorder'])->name('customer.orders');

    // Thêm giỏ hàng từ trang product detail
    Route::post('/product/{product_id}/addtocart', [productDetailController::class, 'addproduct'])->name('product.addtocart');

    // Cart
    Route::get('/cart',                    [App\Http\Controllers\cart\CartController::class, 'showCart'])->name('cart.index');
    Route::post('/cart/update/{itemId}',   [App\Http\Controllers\cart\CartController::class, 'updateCartItem'])->name('cart.update');
    Route::delete('/cart/remove/{itemId}', [App\Http\Controllers\cart\CartController::class, 'removeFromCart'])->name('cart.remove');

    // Payment
    Route::get('/payment/index',   [PaymentController::class, 'index']);
    Route::post('/payment/submit', [PaymentController::class, 'submit']);
});

/*
|--------------------------------------------------------------------------
| Chatbot Routes
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\ChatController;

Route::get('/chat/{threadId?}',  [ChatController::class, 'start']);
Route::post('/chat/{threadId?}', [ChatController::class, 'ask']);