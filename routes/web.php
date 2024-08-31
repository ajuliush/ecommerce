<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishListController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('shop/', [ShopController::class, 'index'])->name('shop');
Route::get('product/{slug}', [ShopController::class, 'show'])->name('details');

Route::get('cart/', [CartController::class, 'index'])->name('cart.index');
Route::post('cart/add', [CartController::class, 'add_to_cart'])->name('cart.add');
Route::put('/cart/increase/{rowId}', [CartController::class, 'increase_cart_quantity'])->name('cart.increase');
Route::put('/cart/decrease/{rowId}', [CartController::class, 'decrease_cart_quantity'])->name('cart.decrease');
Route::delete('/cart/remove/{rowId}', [CartController::class, 'remove_item'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'empty_cart'])->name('cart.empty');

Route::get('checkout/', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('place-an-order/', [CartController::class, 'place_an_order'])->name('cart.place.order');
Route::get('order-confirmation/', [CartController::class, 'order_confirmation'])->name('cart.order.confirmation');

Route::post('cart/apply-coupon', [CartController::class, 'apply_coupon_code'])->name('cart.coupon.apply');
Route::delete('cart/remove-coupon', [CartController::class, 'remove_coupon_code'])->name('cart.coupon.remove');

Route::get('wishlist', [WishListController::class, 'index'])->name('wishlist.index');
Route::post('wishlist/store', [WishListController::class, 'store'])->name('wishlist.store');
Route::post('wishlist/remove-item/{rowId}', [WishListController::class, 'remove_item'])->name('wishlist.remove_item');
Route::post('wishlist/destroy', [WishListController::class, 'destroy'])->name('wishlist.destroy');
Route::post('wishlist/move-to-cart/{rowId}', [WishListController::class, 'move_to_cart'])->name('wishlist.move.to.cart');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Permission Routes
    Route::get('/permissions/', [PermissionController::class, 'index'])->name('permission.index');
    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permission.create');
    Route::post('/permissions/store', [PermissionController::class, 'store'])->name('permission.store');
    Route::get('/permissions/{id}/edit', [PermissionController::class, 'edit'])->name('permission.edit');
    Route::post('/permissions/{id}/update', [PermissionController::class, 'update'])->name('permission.update');
    Route::delete('/permissions/', [PermissionController::class, 'destroy'])->name('permission.destroy');

    //Role routes
    Route::get('/roles/', [RoleController::class, 'index'])->name('role.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('role.create');
    Route::post('/roles/store', [RoleController::class, 'store'])->name('role.store');
    Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('role.edit');
    Route::post('/roles/{id}/update', [RoleController::class, 'update'])->name('role.update');
    Route::delete('/roles/', [RoleController::class, 'destroy'])->name('role.destroy');

    //User routes
    Route::get('/users/', [UserController::class, 'index'])->name('user.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/users/store', [UserController::class, 'store'])->name('user.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/users/{id}/update', [UserController::class, 'update'])->name('user.update');
    Route::delete('/users/', [UserController::class, 'destroy'])->name('user.destroy');

    //Article  routes
    Route::get('/articles/', [ArticleController::class, 'index'])->name('article.index');
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('article.create');
    Route::post('/articles/store', [ArticleController::class, 'store'])->name('article.store');
    Route::get('/articles/{id}/edit', [ArticleController::class, 'edit'])->name('article.edit');
    Route::post('/articles/{id}/update', [ArticleController::class, 'update'])->name('article.update');
    Route::delete('/articles/', [ArticleController::class, 'destroy'])->name('article.destroy');

    //Brand  routes
    Route::get('/brands/', [BrandController::class, 'index'])->name('brand.index');
    Route::get('/brands/create', [BrandController::class, 'create'])->name('brand.create');
    Route::post('/brands/store', [BrandController::class, 'store'])->name('brand.store');
    Route::get('/brands/{id}/edit', [BrandController::class, 'edit'])->name('brand.edit');
    Route::post('/brands/{id}/update', [BrandController::class, 'update'])->name('brand.update');
    Route::delete('/brands/{id}', [BrandController::class, 'destroy'])->name('brand.destroy');

    //Category  routes
    Route::get('/categories/', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('/categories/{id}/update', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

    //Product  routes
    Route::get('/products/', [ProductController::class, 'index'])->name('product.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/products/store', [ProductController::class, 'store'])->name('product.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::post('/products/{id}/update', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('product.destroy');

    //Coupon  routes
    Route::get('/coupons/', [CouponController::class, 'index'])->name('coupon.index');
    Route::get('/coupons/create', [CouponController::class, 'create'])->name('coupon.create');
    Route::post('/coupons/store', [CouponController::class, 'store'])->name('coupon.store');
    Route::get('/coupons/{id}/edit', [CouponController::class, 'edit'])->name('coupon.edit');
    Route::post('/coupons/{id}/update', [CouponController::class, 'update'])->name('coupon.update');
    Route::delete('/coupons/{id}', [CouponController::class, 'destroy'])->name('coupon.destroy');

    //Order  routes
    Route::get('/orders/', [OrderController::class, 'index'])->name('order.index');
    Route::get('/orders/{id}/show', [OrderController::class, 'show'])->name('order.show');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('order.create');
    Route::post('/orders/store', [OrderController::class, 'store'])->name('order.store');
    Route::get('/orders/{id}/edit', [OrderController::class, 'edit'])->name('order.edit');
    Route::post('/orders/{id}/update', [OrderController::class, 'update'])->name('order.update');
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('order.destroy');
});

require __DIR__ . '/auth.php';