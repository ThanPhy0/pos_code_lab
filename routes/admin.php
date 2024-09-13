<?php

use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'superadmin'], function () {
    Route::get('admin', [AdminController::class, 'Admin'])->name('Admin');

    // Category CRUD
    Route::group(['prefix' => 'category'], function () {
        Route::get('list', [CategoryController::class, 'list'])->name('category#list');
        Route::post('create', [CategoryController::class, 'create'])->name('category#create');

        Route::get('update/{id}', [CategoryController::class, 'updatePage'])->name('category#updatePage');
        Route::post('update/{id}', [CategoryController::class, 'update'])->name('category#update');

        Route::get('delete/{id}', [CategoryController::class, 'delete'])->name('category#delete');
    });


    // Profile
    Route::group(['prefix' => 'profile'], function () {
        // Change Password
        Route::get('changePassword', [ProfileController::class, 'changePasswordPage'])->name('profile#changPassword#page');
        Route::post('changePassword', [ProfileController::class, 'changPassword'])->name('profile#changePassword');

        // Profile Status/Check
        Route::get('profile', [ProfileController::class, 'profile'])->name('profile#accountProfile');
        // Edit Profile
        Route::get('edit', [ProfileController::class, 'editProfile'])->name('profile#edit');
        Route::post('update', [ProfileController::class, 'updateProfile'])->name('profile#update');

        Route::group(['middleware' => 'superadmin'], function () {
            // Create New Admin Account
            Route::get('add/newAdmin', [ProfileController::class, 'createNewAdminAccount'])->name('profile#createNewAdminAccount');
            Route::post('add/newAdmin', [ProfileController::class, 'createAdminAccount'])->name('profile#createAdminAccount');

            // Admin List
            Route::get('admin/list', [ProfileController::class, 'adminList'])->name('profile#adminList');
            // User List
            Route::get('user/list', [ProfileController::class, 'userList'])->name('profile#userList');
            // Can delete only superadmin
            Route::get('admin/delete/{id}', [ProfileController::class, 'delete'])->name('profile#delete');
        });
    });

    Route::group(['prefix' => 'product'], function () {
        // Create New Product View
        Route::get('create', [ProductController::class, 'create'])->name('product#create');
        // Create New Product
        Route::post('create', [ProductController::class, 'createProduct'])->name('product#createProduct');
        // Product List
        Route::get('list/{amt?}', [ProductController::class, 'productList'])->name('product#list');
        // View Product Detail
        Route::get('view/{id}', [ProductController::class, 'view'])->name('view');
        // Update Page
        Route::get('update/page/{id}', [ProductController::class, 'updatePage'])->name('update#list');
        Route::post('update/{id}', [ProductController::class, 'update'])->name('update');
        // Delete
        Route::get('delete/{id}', [ProductController::class, 'delete'])->name('delete');
    });

    Route::group(['prefx' => 'payment'], function () {
        // Payment method create page
        Route::get('payment/method', [PaymentController::class, 'paymentView'])->name('payment#methodView');
        // Payment CRUD
        Route::post('payment/create', [PaymentController::class, 'create'])->name('payment#create');
        Route::post('payment/update/{id}', [PaymentController::class, 'update'])->name('payment#update');
        Route::get('payment/delete/{id}', [PaymentController::class, 'delete'])->name('payment#delete');
    });

    Route::group(['prefix' => 'order'], function () {
        Route::get('list', [OrderController::class, 'list'])->name('order#list');
        Route::get('details/{orderCode}', [OrderController::class, 'details'])->name('order#details');

        // Change status using api (ajax, jquery) method
        Route::get('changeStatus', [OrderController::class, 'changeStatus'])->name('order#changeStatus');
        Route::get('confirmOrder', [OrderController::class, 'confirmOrder'])->name('order#confirmOrder');
        Route::get('cancelOrder', [OrderController::class, 'cancelOrder'])->name('order#cancelOrder');
        Route::get('rejectOrder', [OrderController::class, 'rejectOrder'])->name('order#rejectOrder');

        // Sale information
        Route::get('sale/info', [OrderController::class, 'saleInfo'])->name('order#saleInfo');
    });
});
