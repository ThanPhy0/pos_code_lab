<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'user'], function () {
    Route::group(['prefix' => 'user'], function () {

        Route::get('home/{id?}', [UserController::class, 'userHome'])->name('userHome');

        //Profile
        // Change Password
        Route::get('changePassword', [ProfileController::class, 'changePasswordPage'])->name('user#changPassword#page');
        Route::post('changePassword', [ProfileController::class, 'changPassword'])->name('user#changePassword');

        // Profile Status/Check
        Route::get('profile', [ProfileController::class, 'profile'])->name('user#accountProfile');
        // Edit Profile
        Route::get('edit', [ProfileController::class, 'editProfile'])->name('user#edit');
        Route::post('update', [ProfileController::class, 'updateProfile'])->name('user#update');

        //Contact
        Route::get('contact/{user_id?}', [ContactController::class, 'contact'])->name('contact');
        Route::post('to/contact', [ContactController::class, 'toContact'])->name('toContact');

        Route::get('product/details/{id}', [ProductController::class, 'details'])->name('product#details');

        Route::post('addToCart', [ProductController::class, 'addToCart'])->name('product#addToCart');

        Route::get('cart', [ProductController::class, 'cartPage'])->name('product#cartPage');

        // Delete cart row using api call
        Route::get('cart/delete', [ProductController::class, 'cartDelete'])->name('product#cartDelete');
        Route::get('product/list', [ProductController::class, 'productList'])->name('product#cartList');

        // Order cart
        Route::get('cart/temp', [ProductController::class, 'cartTemp'])->name('product#cartTemp');
        Route::get('payment', [ProductController::class, 'payment'])->name('product#payment');
        Route::post('order', [ProductController::class, 'order'])->name('product#order');

        Route::get('order/list', [ProductController::class, 'orderList'])->name('product#orderList');

        // Customer Comment
        Route::post('comment', [ProductController::class, 'comment'])->name('product#comment');
        Route::get('comment/delete{id}', [ProductController::class, 'deleteComment'])->name('product#deleteComment');
        // Rating
        Route::post('rating', [ProductController::class, 'rating'])->name('product#rating');
    });
});

Route::group(['prefix' => 'profile'], function () {});
