<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FindMeNumber;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Rate limit test
Route::get('/findMeNumber', [FindMeNumber::class, 'index'])->name('findMeNumber.index');
Route::get('/findMeNumber/confirm', [FindMeNumber::class, 'confirm'])->name('findMeNumber.confirm');

// 1M records query test
Route::post('/category', [CategoryController::class, 'list'])->name('category.list');
Route::get('/product', [ProductController::class, 'list'])->name('product.list');