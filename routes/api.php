<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SubCategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::Group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
});

Route::group([
    'middleware' => 'api'
], function () {
    Route::resources([
        'category' => CategoryController::class,
        'subcategory' => SubCategoryController::class,
        'slider' => SliderController::class
    ]);
});

// Route::resource('kategori', CategoryController::class);
