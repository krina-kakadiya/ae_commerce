<?php

use Illuminate\Support\Facades\Route;

// admin all controllers
use App\Http\Controllers\Admin\{
    AuthController,
    CategoryController,
    ProductController,
    UserController,
    OrderController,
};
use App\Http\Controllers\User\{
    AuthController as UserAuthController,
    CartController,
    CheckoutController,
    HomeController,
    OrderController as UserOrderController,
};

// Route::get('/', function () {
//     return view('bin.welcome');
// });

Route::group(['prefix' => '/admin', 'as' => 'admin.',], function () {

    Route::controller(AuthController::class)->group(function () {
        Route::group(['middleware' => 'AdminLogout'], function () {
            Route::get('/login', 'showLogin')->name('login');
            Route::post('/login', 'doLogin')->name('doLogin');
        });

        Route::group(['middleware' => 'AdminLogin'], function () {
            Route::get('/dashboard', 'adminDashboard')->name('dashboard');
            Route::get('/logout', 'logout')->name('logout');
        });
    });

    Route::group(['middleware' => 'AdminLogin'], function () {

        // admin:category
        Route::controller(CategoryController::class)->group(function () {
            Route::post('/check/category', 'checkCategory')->name('check.category');
            Route::get('/category/index', 'index')->name('category.index');
            Route::get('/category/create', 'create')->name('category.create');
            Route::post('/category/create', 'store')->name('category.store');
            Route::get('/category/edit/{id}', 'edit')->name('category.edit');
            Route::post('/category/update/{id}', 'update')->name('category.update');
            Route::get('/category/delete/{id}', 'delete')->name('category.delete');
            Route::post('/category/update-status/{id}', 'updateStatus')->name('category.updateStatus');

            // trashed category
            Route::get('/category/trashed', 'trashedCategory')->name('category.trashed');
            Route::get('/category/restore/{id}', 'restoreCategory')->name('category.restore');
            Route::get('/category/force-delete/{id}', 'forceDeleteCategory')->name('category.force.delete');
        });

        // admin:product
        Route::controller(ProductController::class)->group(function () {
            Route::get('/product/index', 'index')->name('product.index');
            Route::get('/product/create', 'create')->name('product.create');
            Route::post('/product/create', 'store')->name('product.store');
            Route::get('/product/view/{id}', 'view')->name('product.view');
            Route::get('/product/edit/{id}', 'edit')->name('product.edit');
            Route::post('/product/update/{id}', 'update')->name('product.update');
            Route::get('/product/delete/{id}', 'delete')->name('product.delete');
            Route::post('/product/update-status/{id}', 'updateStatus')->name('product.updateStatus');

            // trashed product
            Route::get('/product/trashed', 'trashed')->name('product.trashed');
            Route::get('/product/restore/{id}', 'restore')->name('product.restore');
            Route::get('/product/force-delete/{id}', 'forceDelete')->name('product.force.delete');
        });

        // admin:user
        Route::controller(UserController::class)->group(function () {
            Route::get('/user/index', 'index')->name('user.index');
            Route::get('/user/view/{id}', 'view')->name('user.view');
            Route::get('/user/delete/{id}', 'delete')->name('user.delete');
            Route::post('/user/update-status/{id}', 'updateStatus')->name('user.updateStatus');
        });

        // admin:order
        Route::controller(OrderController::class)->group(function () {
            Route::get('/order/index', 'index')->name('order.index');
            Route::get('/order/view/{id}', 'view')->name('order.view');
            Route::post('/order/update-status/{id}', 'updateStatus')->name('order.updateStatus');
            Route::post('/order-detail/update-status/{id}', 'updateStatusOrderDetails')->name('order.detail.updateStatus');
        });
    });
});



Route::group(['as' => 'user.'], function () {

    // user:authentication
    Route::controller(UserAuthController::class)->group(function () {
        Route::post('/login', 'userLogin')->name('login');
        Route::get('/logout', 'logout')->name('logout');
        Route::get('/register', 'registerView')->name('register.view');
        Route::post('/register', 'register')->name('register');
        Route::post('/check/mail', 'checkMail')->name('check.mail');
        Route::get('/profile', 'profileView')->middleware('UserLogin')->name('profile.view');
        Route::post('/update-profile', 'updateProfile')->middleware('UserLogin')->name('profile.update');
        Route::post('/change-password', 'changePassword')->middleware('UserLogin')->name('change.password');
    });

    //user:home
    Route::controller(HomeController::class)->group(function () {
        Route::get('/', 'index')->name('home');
        Route::get('/category-view/{id}', 'categoryView')->name('category.view');
        Route::get('/product-view/{id}', 'productView')->name('product.view');
    });

    //user:add to cart
    Route::controller(CartController::class)->group(function () {
        Route::get('/cart', 'index')->name('cart');
        Route::get('/add-to-cart/{id}', 'addToCart')->name('add.to.cart');
        Route::post('/update-cart', 'update')->name('update.cart');
        Route::get('remove-from-cart', 'remove')->name('remove.from.cart');
    });


    Route::group(['middleware' => 'UserLogin'], function () {

        //user:checkout 
        Route::controller(CheckoutController::class)->group(function () {
            Route::get('/checkout', 'index')->name('checkout');
            Route::post('/checkout', 'checkout')->name('checkout');
        });

        //user:checkout 
        Route::controller(UserOrderController::class)->group(function () {
            Route::get('/order', 'index')->name('order');
            Route::get('/orderView/{id}', 'orderView')->name('order.view');
            Route::get('/download-pdf/{id}', 'downloadPDF')->name('order.download.pdf');
            Route::post('/update-status/{id}', 'updateStatus')->name('order.update.status');
        });
    });
});
