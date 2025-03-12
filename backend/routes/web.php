<?php

use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\backend\PaymentController;
use App\Http\Controllers\PaymentController as ControllerPaymentController;
use App\Http\Controllers\backend\CategoryController;
use App\Http\Controllers\backend\PostController;
use App\Http\Controllers\backend\BrandController;
use App\Http\Controllers\backend\BannerController;
use App\Http\Controllers\backend\OrderController;
use App\Http\Controllers\backend\ShippingController;
use App\Http\Controllers\backend\ContactController;
use App\Http\Controllers\backend\MenuController;
use App\Http\Controllers\backend\OrderDetailController;
use App\Http\Controllers\backend\PolicyController;
use App\Http\Controllers\backend\ProductReviewController;
use App\Http\Controllers\backend\PromotionController;
use App\Http\Controllers\backend\TopicController;
use App\Http\Controllers\backend\TransactionController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\backend\UserNewController;
use App\Http\Controllers\AuthController;
use App\Models\Brand;
use App\Models\OrderDetail;
use App\Models\Payment;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/sanctum/csrf-cookie', function () {
    return response()->json(['message' => 'CSRF cookie set']);
});

Route::post('/payment/create-intent', [PaymentController::class, 'createIntent']);

Route::post('/payment/vnpay', [PaymentController::class, 'vnpayPayment']);
Route::get('/payment/vnpay/return', [PaymentController::class, 'returnFromVNPay']);


Route::prefix('/api')->group(function() {
    // Product Routes
    Route::get('/products', [ProductController::class, 'product'])->name('api.product');
    Route::get('/product', [ProductController::class, 'products']);
    Route::get('/products/{id}', [ProductController::class, 'productdetail'])->name('api.product.detail');
    Route::get('/products/new', [ProductController::class, 'getNewProducts'])->name('api.product.new');
    Route::get('/products/flash', [ProductController::class, 'FlashSale'])->name('api.product.flash');
    Route::get('/products/suggested', [ProductController::class, 'getSuggestedProducts'])->name('api.product.suggested');
    Route::get('/products/category/{categoryId}', [ProductController::class, 'getByCategory']);
    Route::get('/products/{id}/related-by-brand', [ProductController::class, 'getProductsByBrand']);
    Route::post('/checkout', [TransactionController::class, 'checkout']);

    // Brand and Category Routes
    Route::get('/brands', [BrandController::class, 'brands'])->name('api.brands');
    Route::get('/categories', [CategoryController::class, 'categories'])->name('api.categories');
    
    // Banner Routes
    Route::get('/banners', [BannerController::class, 'banners'])->name('api.banners');
    
    // User Routes
    Route::prefix('user')->group(function() {
        Route::post('/register', [UserController::class, 'register'])->name('api.register');
        Route::post('/login', [UserController::class, 'login'])->name('api.login');
        Route::get('/me', [UserController::class, 'me'])->middleware('auth:api')->name('api.me');
    });
});
Route::post('/register', [AuthController::class, 'register'])->name('api.register');
Route::post('/login', [AuthController::class, 'login'])->name('api.login');
Route::middleware('auth:sanctum')->get('/me', [UserController::class, 'me'])->name('api.me');

Route::get('/admin/products/export', [ProductController::class, 'export'])->name('admin.products.export');



Route::get('/', function () {return view('welcome');});
Route::get('/admin', function () {return view('admin');});
Route::get('admin/transaction/create', [TransactionController::class, 'create'])->name('admin.transaction.create');
Route::post('admin/transaction', [TransactionController::class, 'store'])->name('admin.transaction.store');
Route::get('admin/transactions/{transaction_id}/edit', [TransactionController::class, 'edit'])->name('admin.transaction.edit');
Route::put('admin/transaction/{transaction_id}', [TransactionController::class, 'update'])->name('admin.transaction.update');
Route::get('admin/user/edit/{user_id}', [UserController::class, 'edit'])->name('admin.user.edit');
// Route chỉnh sửa sản phẩm
Route::get('admin/product/edit/{product_id}', [ProductController::class, 'edit'])->name('admin.product.edit');

// Route xóa sản phẩm
Route::delete('admin/product/delete/{product_id}', [ProductController::class, 'destroy'])->name('admin.product.delete');


Route::prefix('admin')->group(function(){
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard.index');
   //Transaction
    Route::prefix('transaction')->group(function(){
        Route::get('/', [TransactionController::class,'index'])->name('admin.transaction.index');
        Route::get('trash', [TransactionController::class,'trash'])->name('admin.transaction.trash');
        Route::get('edit/{transaction_id}', [TransactionController::class,'edit'])->name('admin.transaction.edit');
        Route::get('show/{transaction_id}', [TransactionController::class,'show'])->name('admin.transaction.show');
        Route::get('create', [TransactionController::class,'create'])->name('admin.transaction.create');
        Route::post('store', [TransactionController::class,'store'])->name('admin.transaction.store');
        Route::put('update/{transaction_id}', [TransactionController::class,'update'])->name('admin.transaction.update');
        Route::get('delete/{transaction_id}', [TransactionController::class,'delete'])->name('admin.transaction.delete');
        Route::get('restore/{transaction_id}', [TransactionController::class,'restore'])->name('admin.transaction.restore');
        Route::get('status/{transaction_id}', [TransactionController::class,'status'])->name('admin.transaction.status');
        Route::delete('destroy/{transaction_id}', [TransactionController::class,'destroy'])->name('admin.transaction.destroy');
    });
    //Category
    Route::prefix('category')->group(function(){
        Route::get('/', [CategoryController::class,'index'])->name('admin.category.index');
        Route::get('trash', [CategoryController::class,'trash'])->name('admin.category.trash');
        Route::get('show/{id}', [CategoryController::class,'show'])->name('admin.category.show');
        Route::get('create', [CategoryController::class,'create'])->name('admin.category.create');
        Route::post('store', [CategoryController::class,'store'])->name('admin.category.store');
        Route::get('edit/{id}', [CategoryController::class,'edit'])->name('admin.category.edit');
        Route::put('update/{id}', [CategoryController::class,'update'])->name('admin.category.update');
        Route::get('delete/{id}', [CategoryController::class,'delete'])->name('admin.category.delete');
        Route::get('restore/{id}', [CategoryController::class,'restore'])->name('admin.category.restore');
        Route::get('status/{id}', [CategoryController::class,'status'])->name('admin.category.status');
        Route::delete('destroy/{id}', [CategoryController::class,'destroy'])->name('admin.category.destroy');
    });
    //Product
    Route::prefix('product')->group(function(){
        Route::get('/', [ProductController::class,'index'])->name('admin.product.index');
        Route::get('trash', [ProductController::class,'trash'])->name('admin.product.trash');
        Route::get('show/{product_id}', [ProductController::class,'show'])->name('admin.product.show');
        Route::get('create', [ProductController::class,'create'])->name('admin.product.create');
        Route::post('store', [ProductController::class,'store'])->name('admin.product.store');
        Route::get('edit/{product_id}', [ProductController::class,'edit'])->name('admin.product.edit');
        Route::put('update/{product_id}', [ProductController::class,'update'])->name('admin.product.update');
        Route::get('delete/{product_id}', [ProductController::class,'delete'])->name('admin.product.delete');
        Route::post('delete_multiple', [ProductController::class, 'delete_multiple'])->name('admin.product.delete_multiple');
        Route::get('restore/{product_id}', [ProductController::class,'restore'])->name('admin.product.restore');
        Route::get('status/{product_id}', [ProductController::class,'status'])->name('admin.product.status');
        Route::delete('destroy/{product_id}', [ProductController::class,'destroy'])->name('admin.product.destroy');
        Route::get('clone/{product_id}', [ProductController::class, 'clone'])->name('admin.product.clone');

    });
    //Banner
    Route::prefix('banner')->group(function(){
        Route::get('/', [BannerController::class,'index'])->name('admin.banner.index');
        Route::get('trash', [BannerController::class,'trash'])->name('admin.banner.trash');
        Route::get('show/{banner_id}', [BannerController::class,'show'])->name('admin.banner.show');
        Route::get('create', [BannerController::class,'create'])->name('admin.banner.create');
        Route::post('store', [BannerController::class,'store'])->name('admin.banner.store');
        Route::get('edit/{banner_id}', [BannerController::class, 'edit'])->name('admin.banner.edit');
        Route::put('update/{banner_id}', [BannerController::class,'update'])->name('admin.banner.update');
        Route::get('delete/{banner_id}', [BannerController::class,'delete'])->name('admin.banner.delete');
        Route::get('restore/{banner_id}', [BannerController::class,'restore'])->name('admin.banner.restore');
        Route::get('status/{banner_id}', [BannerController::class,'status'])->name('admin.banner.status');
        Route::delete('destroy/{banner_id}', [BannerController::class,'destroy'])->name('admin.banner.destroy');
    });
    Route::prefix('contact')->group(function(){
        Route::get('/', [ContactController::class,'index'])->name('admin.contact.index');
    });
    //Payment
    Route::prefix('payment')->group(function(){
        Route::get('/', [PaymentController::class,'index'])->name('admin.payment.index');
        Route::get('trash', [PaymentController::class,'trash'])->name('admin.payment.trash');
        Route::get('show/{id}', [PaymentController::class,'show'])->name('admin.payment.show');
        Route::get('create', [PaymentController::class,'create'])->name('admin.payment.create');
        Route::post('store', [PaymentController::class,'store'])->name('admin.payment.store');
        Route::get('edit/{id}', [PaymentController::class,'edit'])->name('admin.payment.edit');
        Route::put('update/{id}', [PaymentController::class,'update'])->name('admin.payment.update');
        Route::get('delete/{id}', [PaymentController::class,'delete'])->name('admin.payment.delete');
        Route::get('restore/{id}', [PaymentController::class,'restore'])->name('admin.payment.restore');
        Route::get('status/{id}', [PaymentController::class,'status'])->name('admin.payment.status');
        Route::delete('destroy/{id}', [PaymentController::class,'destroy'])->name('admin.payment.destroy');
    });
     //Post
     Route::prefix('post')->group(function(){
        Route::get('/', [PostController::class,'index'])->name('admin.post.index');
        Route::get('trash', [PostController::class,'trash'])->name('admin.post.trash');
        Route::get('show/{post_id}', [PostController::class,'show'])->name('admin.post.show');
        Route::get('create', [PostController::class,'create'])->name('admin.post.create');
        Route::post('store', [PostController::class,'store'])->name('admin.post.store');
        Route::get('edit/{post_id}', [PostController::class,'edit'])->name('admin.post.edit');
        Route::put('update/{post_id}', [PostController::class,'update'])->name('admin.post.update');
        Route::get('delete/{post_id}', [PostController::class,'delete'])->name('admin.post.delete');
        Route::get('restore/{post_id}', [PostController::class,'restore'])->name('admin.post.restore');
        Route::get('status/{post_id}', [PostController::class,'status'])->name('admin.post.status');
        Route::delete('destroy/{post_id}', [PostController::class,'destroy'])->name('admin.post.destroy');
    });
    //Brand
    Route::prefix('brand')->group(function(){
        Route::get('/', [BrandController::class,'index'])->name('admin.brand.index');
        Route::get('trash', [BrandController::class,'trash'])->name('admin.brand.trash');
        Route::get('show/{id}', [BrandController::class,'show'])->name('admin.brand.show');
        Route::get('create', [BrandController::class,'create'])->name('admin.brand.create');
        Route::post('store', [BrandController::class,'store'])->name('admin.brand.store');
        Route::get('edit/{id}', [BrandController::class,'edit'])->name('admin.brand.edit');
        Route::put('update/{id}', [BrandController::class,'update'])->name('admin.brand.update');
        Route::get('delete/{id}', [BrandController::class,'delete'])->name('admin.brand.delete');
        Route::post('admin/brand/delete_multiple', [BrandController::class, 'deleteMultiple'])->name('admin.brand.delete_multiple');
        Route::get('restore/{id}', [BrandController::class,'restore'])->name('admin.brand.restore');
        Route::get('status/{id}', [BrandController::class,'status'])->name('admin.brand.status');
        Route::delete('destroy/{id}', [BrandController::class,'destroy'])->name('admin.brand.destroy');
    });
    //Banner
    Route::prefix('banner')->group(function(){
        Route::get('/', [BannerController::class,'index'])->name('admin.banner.index');
        Route::get('trash', [BannerController::class,'trash'])->name('admin.banner.trash');
        Route::get('show/{banner_id}', [BannerController::class,'show'])->name('admin.banner.show');
        Route::get('create', [BannerController::class,'create'])->name('admin.banner.create');
        Route::post('store', [BannerController::class,'store'])->name('admin.banner.store');
        Route::get('edit/{banner_id}', [BannerController::class,'edit'])->name('admin.banner.edit');
        Route::put('update/{banner_id}', [BannerController::class,'update'])->name('admin.banner.update');
        Route::get('delete/{banner_id}', [BannerController::class,'delete'])->name('admin.banner.delete');
        Route::get('restore/{banner_id}', [BannerController::class,'restore'])->name('admin.banner.restore');
        Route::get('status/{banner_id}', [BannerController::class,'status'])->name('admin.banner.status');
        Route::delete('destroy/{banner_id}', [BannerController::class,'destroy'])->name('admin.banner.destroy');
    });
    //Order
    Route::prefix('order')->group(function(){
        Route::get('/', [OrderController::class,'index'])->name('admin.order.index');
        Route::get('trash', [OrderController::class,'trash'])->name('admin.order.trash');
        Route::get('show/{order_id}', [OrderController::class,'show'])->name('admin.order.show');
        Route::get('create', [OrderController::class,'create'])->name('admin.order.create');
        Route::post('store', [OrderController::class,'store'])->name('admin.order.store');
        Route::get('edit/{order_id}', [OrderController::class,'edit'])->name('admin.order.edit');
        Route::put('update/{order_id}', [OrderController::class,'update'])->name('admin.order.update');
        Route::get('delete/{order_id}', [OrderController::class,'delete'])->name('admin.order.delete');
        Route::get('restore/{order_id}', [OrderController::class,'restore'])->name('admin.order.restore');
        Route::get('status/{order_id}', [OrderController::class,'status'])->name('admin.order.status');
        Route::delete('destroy/{order_id}', [OrderController::class,'destroy'])->name('admin.order.destroy');
    });
    //Orderdetail
    Route::prefix('orderdetail')->group(function(){
        Route::get('/', [OrderDetailController::class,'index'])->name('admin.orderdetail.index');
        Route::get('trash', [OrderDetailController::class,'trash'])->name('admin.orderdetail.trash');
        Route::get('show/{id}', [OrderDetailController::class,'show'])->name('admin.orderdetail.show');
        Route::get('create', [OrderDetailController::class,'create'])->name('admin.orderdetail.create');
        Route::post('store', [OrderDetailController::class,'store'])->name('admin.orderdetail.store');
        Route::get('edit/{id}', [OrderDetailController::class,'edit'])->name('admin.orderdetail.edit');
        Route::put('update/{id}', [OrderDetailController::class,'update'])->name('admin.orderdetail.update');
        Route::get('delete/{id}', [OrderDetailController::class,'delete'])->name('admin.orderdetail.delete');
        Route::get('restore/{id}', [OrderDetailController::class,'restore'])->name('admin.orderdetail.restore');
        Route::get('status/{id}', [OrderDetailController::class,'status'])->name('admin.orderdetail.status');
        Route::delete('destroy/{id}', [OrderDetailController::class,'destroy'])->name('admin.orderdetail.destroy');
    });
     //Shipping
     Route::prefix('shipping')->group(function(){
        Route::get('/', [ShippingController::class,'index'])->name('admin.shipping.index');
        Route::get('trash', [ShippingController::class,'trash'])->name('admin.shipping.trash');
        Route::get('show/{shipping_id}', [ShippingController::class,'show'])->name('admin.shipping.show');
        Route::get('create', [ShippingController::class,'create'])->name('admin.shipping.create');
        Route::post('store', [ShippingController::class,'store'])->name('admin.shipping.store');
        Route::get('edit/{shipping_id}', [ShippingController::class,'edit'])->name('admin.shipping.edit');
        Route::put('update/{shipping_id}', [ShippingController::class,'update'])->name('admin.shipping.update');
        Route::get('delete/{shipping_id}', [ShippingController::class,'delete'])->name('admin.shipping.delete');
        Route::get('restore/{shipping_id}', [ShippingController::class,'restore'])->name('admin.shipping.restore');
        Route::get('status/{shipping_id}', [ShippingController::class,'status'])->name('admin.shipping.status');
        Route::delete('destroy/{shipping_id}', [ShippingController::class,'destroy'])->name('admin.shipping.destroy');
    });
    //Topic
    Route::prefix('topic')->group(function(){
        Route::get('/', [TopicController::class,'index'])->name('admin.topic.index');
        Route::get('trash', [TopicController::class,'trash'])->name('admin.topic.trash');
        Route::get('show/{topic_id}', [TopicController::class,'show'])->name('admin.topic.show');
        Route::get('create', [TopicController::class,'create'])->name('admin.topic.create');
        Route::post('store', [TopicController::class,'store'])->name('admin.topic.store');
        Route::get('edit/{topic_id}', [TopicController::class,'edit'])->name('admin.topic.edit');
        Route::put('update/{topic_id}', [TopicController::class,'update'])->name('admin.topic.update');
        Route::get('delete/{topic_id}', [TopicController::class,'delete'])->name('admin.topic.delete');
        Route::get('restore/{topic_id}', [TopicController::class,'restore'])->name('admin.topic.restore');
        Route::get('status/{topic_id}', [TopicController::class,'status'])->name('admin.topic.status');
        Route::delete('destroy/{topic_id}', [TopicController::class,'destroy'])->name('admin.topic.destroy');
    });
    //Menu
    Route::prefix('menu')->group(function(){
        Route::get('/', [MenuController::class,'index'])->name('admin.menu.index');
        Route::get('trash', [MenuController::class,'trash'])->name('admin.menu.trash');
        Route::get('show/{id}', [MenuController::class,'show'])->name('admin.menu.show');
        Route::get('create', [MenuController::class,'create'])->name('admin.menu.create');
        Route::post('store', [MenuController::class,'store'])->name('admin.menu.store');
        Route::get('edit/{id}', [MenuController::class,'edit'])->name('admin.menu.edit');
        Route::put('update/{id}', [MenuController::class,'update'])->name('admin.menu.update');
        Route::get('delete/{id}', [MenuController::class,'delete'])->name('admin.menu.delete');
        Route::get('restore/{id}', [MenuController::class,'restore'])->name('admin.menu.restore');
        Route::get('status/{id}', [MenuController::class,'status'])->name('admin.menu.status');
        Route::delete('destroy/{id}', [MenuController::class,'destroy'])->name('admin.menu.destroy');
    });
    //9. User
    Route::prefix('user')->group(function(){
        Route::get('/', [UserController::class,'index'])->name('admin.user.index');
        Route::get('trash', [UserController::class,'trash'])->name('admin.user.trash');
        Route::get('show/{user_id}', [UserController::class,'show'])->name('admin.user.show');
        Route::get('create', [UserController::class,'create'])->name('admin.user.create');
        Route::post('store', [UserController::class,'store'])->name('admin.user.store');
        Route::get('edit/{user_id}', [UserController::class,'edit'])->name('admin.user.edit');
        Route::put('update/{user_id}', [UserController::class,'update'])->name('admin.user.update');
        Route::get('delete/{user_id}', [UserController::class,'delete'])->name('admin.user.delete');
        Route::get('restore/{user_id}', [UserController::class,'restore'])->name('admin.user.restore');
        Route::get('status/{user_id}', [UserController::class,'status'])->name('admin.user.status');
        Route::delete('destroy/{user_id}', [UserController::class,'destroy'])->name('admin.user.destroy');
    });
});