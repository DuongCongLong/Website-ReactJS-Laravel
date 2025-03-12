<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\CategoryController;
use App\Http\Controllers\backend\BrandController;
use App\Http\Controllers\backend\BannerController;
use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\backend\MenuController;
use App\Http\Controllers\backend\OrderController;
use App\Http\Controllers\backend\PostController;
use App\Http\Controllers\backend\TopicController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\backend\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController as ControllersPaymentController;
use App\Http\Controllers\CartController as ControllersCartController;
use App\Http\Controllers\MenuController as ControllersMenuController;
use App\Http\Controllers\OrderController as ControllersOrderController;
use App\Http\Controllers\PostController as ControllersPostController;
use App\Http\Controllers\ProductReviewController;

// Route::post('/register', [AuthController::class, 'register']);
// Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [UserController::class, 'getUserInfo']);
});

// Route API cho sản phẩm
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'product'])->name('api.product');
    Route::get('/new', [ProductController::class, 'getNewProducts'])->name('api.product.new');
    Route::get('/flash', [ProductController::class, 'FlashSale'])->name('api.product.flash');
    Route::get('/suggested', [ProductController::class, 'getSuggestedProducts'])->name('api.product.suggested');
    Route::get('/category/{categoryId}', [ProductController::class, 'getByCategory']);
    Route::get('/{id}', [ProductController::class, 'getProductDetail']);
    //Route::get('/{id}/reviews/count', [ProductReviewController::class, 'getReviewCount']);
    Route::get('/{id}/related-by-brand', [ProductController::class, 'getProductsByBrand']);
    Route::get('/search', [ProductController::class, 'search']);
});
Route::get('/categories/{id}/products/count', [CategoryController::class, 'getProductCount']);
// Route API cho người dùng
    Route::post('/register', [AuthController::class, 'register'])->name('api.register');
    // Route::post('/login', [AuthController::class, 'login'])->name('api.login');
    Route::match(['GET', 'POST'], '/login', [AuthController::class, 'login'])->name('api.login');

    Route::middleware('auth:sanctum')->get('/me', [UserController::class, 'me'])->name('api.me');


// Route API khác
Route::get('/categories', [CategoryController::class, 'categories'])->name('api.categories');
Route::get('/brands', [BrandController::class, 'brand']);
Route::get('/banners', [BannerController::class, 'banners'])->name('api.banners');// Route giỏ hàng
// Route::middleware('auth:sanctum')->get('/cart', [CartController::class, 'index']);
// Route::middleware('auth:sanctum')->post('/cart', [CartController::class, 'store']);
// Route::middleware('auth:sanctum')->put('/cart/{id}', [CartController::class, 'update']);
// Route::middleware('auth:sanctum')->delete('/cart/{id}', [CartController::class, 'destroy']);
// // Route::post('/cart', [CartController::class, 'addToCart'])->name('api.cart.add');
// Route::middleware('auth:sanctum')->post('/cart', [CartController::class, 'addToCart']);
Route::middleware('auth:sanctum')->group(function () {
    // Các route bảo vệ bởi middleware auth:sanctum
    Route::post('/cart/add', [ControllersCartController::class, 'addToCart']);
    Route::post('/cart/quantity', [ControllersCartController::class, 'updateCart']);
    // Đảm bảo route này sử dụng phương thức DELETE
    Route::delete('/cart/delete', [ControllersCartController::class, 'removeCartItem']);

    Route::get('/cart/{userId}', [ControllersCartController::class, 'getCartByUserId']);
    Route::post('/cart/sync', [ControllersCartController::class, 'syncCart']);
    Route::post('/order/vnpay_payment',[ControllersPaymentController::class,'vnpay_payment']);
    Route::get('/order/vnpay_return', [ControllersPaymentController::class, 'vnpayReturn']);
    Route::post('/order/checkout', [ControllersOrderController::class, 'checkout']);

});

Route::post('/contacts', [ContactController::class, 'store']);
Route::post('/productreview', [ProductReviewController::class, 'store']);
Route::get('/productreview/{id}', [ProductReviewController::class, 'show']);
Route::get('/banners', [BannerController::class, 'index']);
Route::get('/posts', [ControllersPostController::class, 'index']);
Route::get('/post/{id}', [ControllersPostController::class, 'show']); 
Route::get('/menus', [ControllersMenuController::class, 'index']);